<?php namespace App\Models;

use CodeIgniter\Model;
use App\Models\TraderFinishModel;
use App\Models\TraderReportModel;

class TraderModel extends Model
{
	protected $table = 'trader_signal';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['symbol', 'groupSymbol','status_pips','status_usd','timefream','type','open','open_2','open_3','opentime','sl','tp','tp_2','tp_3','tp_hit','chart','message_id','message_id_group'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;

	public function getSignal($s=""){
		
		if($s != ""){
			$this->like("symbol",$s);
		}
		$this->whereIn("timefream",["M1","M5"]);
		
		$this->orderBy("id","DESC");
		
		return $this->findAll(10);

	}

	public function getSignalAll($s=""){
		$query = $this->db->table('trader_signal');
		if($s != ""){
			$this->like("symbol",$s);
		}
		
		$this->orderBy("id","DESC");
		
		return $this->findAll(100);

	}


	public function getSignalWeek($s=""){
		
		if($s != ""){
			$this->like("symbol",$s);
		}
		
		$this->whereIn("timefream",["M15","M30","H1","H4","D1"]);
		$this->orderBy("id","DESC");
		
		return $this->findAll(10);

	}


	public function getSignalFinish(){
		$finish = new TraderFinishModel;

		$query = $finish->orderBy("id","DESC")->findAll(10);
		return $query;

	}
	public function getSignalFinishByKey($message_id=0){
		if($message_id == 0) return [];
		$finish = new TraderFinishModel;
		$query = $finish->where("message_id",$message_id)->orderBy("id","DESC")->findAll();
		return $query;

	}

	public function createOrder($obj){

		//print_r($obj);
		//$date = explode(" ",$obj["opentime"]);
		//list($year,$month,$day) = explode(".", $date[0]);
		$obj["opentime"] = date('Y-m-d h:i:s',now());
		//unset($arv["time"]);
		$this->insert($obj);
	}

	public function test(){
		$info = $this->db->table('trader_signal')->where(["message_id" => 1699])->get(1)->getResult()[0];
		print_r($info);
	}

	public function finishOrder($obj){

		$finish = new TraderFinishModel;
		$info = $this->where(["message_id" => $obj->message_id])->first();
		
		if(!$info) return false;

		
		$action = $obj->close_type;
		if($action == "sl" || ($obj->target == 3 && $obj->ordertype != "prime") || $obj->finish == "yes"){
			$this->delete(["message_id" => $obj->message_id]);//Remove Complete Order
		}
		$date = explode(" ",$obj->time);
		list($year,$month,$day) = explode(".", $date[0]);
		$formatday = $month."-".$day."-".$year." ".$date[1];
		$arv = [
				"signals_id" => $info->id,
				"type" => $info->type,
				"symbol" => $info->symbol,
				"open" => $info->open,
				"opentime" => $info->opentime,
				"sl" => $info->sl,
				"close_at" => $obj->close,
				"close_time" => date("Y-m-d h:i:s",now()),
				"profit_pip" => $obj->pip,
				"profit_usd" => $obj->usd,
				"close_type" => ($obj->close_type == "sl" || $obj->close_type == "tp" ?  $obj->close_type : "close"),
				"message_id" => $info->message_id,
				"is_access" => $obj->target < 2 ? "Free" : "Vip",
				"daily" => date("Y-m-d",now()),
				"weekly" => (int)date('W')
			];
		$report_arv = $arv;
		if($obj->target == 4 || $obj->target == 5) $report_arv["close_type"] = "DCA";
		if($obj->ordertype == "prime") $report_arv["close_type"] = "PRIME";
		if($info) $finish->insert($report_arv);
		
		$arv["message_id_group"] = $info->message_id_group;
		return $this->updateReport($arv);
		//return $arv;
	}

	public function updateReport($arv){
		$report = new TraderReportModel;
		$info = $report->find(1);
		
		$arvUpdate = [];
		$arvUpdate["usd_total"] = $info->usd_total + $arv["profit_usd"];
		if($arv["close_type"] == "sl" && $arv["profit_pip"] < 0){
			$arvUpdate["sl_total"] = $info->sl_total + 1;
			$arvUpdate["sl_total_pips"] = $info->sl_total_pips + $arv["profit_pip"];

		}
		if($arv["profit_pip"] > 0){
			$arvUpdate["tp_total"] = $info->tp_total + 1;
			$arvUpdate["tp_total_pips"] = $info->tp_total_pips + $arv["profit_pip"];
			if($arv["is_access"] == "Vip"){
				$arvUpdate["tp_total_vip_pips"] = $info->tp_total_vip_pips + $arv["profit_pip"];
			}
		}
		
		$report->update(1,$arvUpdate);

		$reinfo = $this->getReport();
		$arv["sl_total"] = $reinfo->sl_total;
		$arv["sl_total_pips"] = $reinfo->sl_total_pips;
		$arv["tp_total"] = $reinfo->tp_total;
		$arv["tp_total_pips"] = $reinfo->tp_total_pips;
		$arv["tp_total_vip_pips"] = $reinfo->tp_total_vip_pips;
		$arv["usd_total"] = $reinfo->usd_total;
		return $arv;

	}

	public function getReport(){
		$report = new TraderReportModel;
		$finish = new TraderFinishModel;
		$reinfo = $report->find(1);
		$reportdayly = $finish->where(['daily' => date('Y-m-d', now()) ])->findAll();
		$num_sig = 0;
		$win = 0;
		$loss = 0;
		$usd = 0;
		foreach ($reportdayly as $key => $value) {
			$num_sig++;
			$usd = $usd + $value->profit_usd;
			if($value->profit_pip > 0) $win = $win + $value->profit_pip;
			if($value->profit_pip < 0) $loss = $loss + $value->profit_pip;

		}
		$daily = [
			"win" => $win,
			"loss" => $loss,
			"numsig" => $num_sig,
			"usd" => $usd
		];
		$reinfo->daily = (Object)$daily;
		return $reinfo;
	}


	public  function updateMsgIDOrder($obj)
	{
		$this->where(["message_id" => $obj->message_id])->update(["message_id_group" => $obj->message_id_group]);
	}

	public function updateMsgIDOrderStatus($arv){
		
		$arvk = [];
		$self = new TraderModel;
		$self2 = new TraderModel;
		foreach ($arv as $key => $value) {
			$arvk[] = $key;
			$self->where(["message_id" => $key]);
			$dataRow = $self->first();
			$arvUpdate = ["status_pips" => $value["pips"],"status_usd" => $value["usd"]];
			print_r($arvUpdate);
			$self2->where("id",$dataRow->id)->update($arvUpdate);
			
		}
		
		$self3 = new TraderModel;
		$self4 = new TraderModel;
		$query = $self3->orderBy("id","DESC")->findAll(100);
		foreach ($query as $key => $value) {
			if(!in_array($value->message_id,$arvk)){
				//echo $value->message_id.".<br>";
				$self4->delete(["message_id" => $value->message_id]);
			}
		}

	}
}

