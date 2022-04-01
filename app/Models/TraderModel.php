<?php namespace App\Models;

use CodeIgniter\Model;


class TraderModel extends Model
{
	protected $table = 'trader_signal';
    protected $primaryKey = 'id';
	public function getSignal($s=""){
		$query = $this->db->table('trader_signal');
		if($s != ""){
			$query->like("symbol",$s);
		}
		$query->whereIn("timefream",["M1","M5"]);
		
		$query->orderBy("id","DESC");
		$query = $query->get(10);
		return $query->getResult();

	}

	public function getSignalAll($s=""){
		$query = $this->db->table('trader_signal');
		if($s != ""){
			$query->like("symbol",$s);
		}
		
		$query->orderBy("id","DESC");
		$query = $query->get(100);
		return $query->getResult();

	}


	public function getSignalWeek($s=""){
		$query = $this->db->table('trader_signal');
		if($s != ""){
			$query->like("symbol",$s);
		}
		
		$query->whereIn("timefream",["M15","M30","H1","H4","D1"]);
		$query->orderBy("id","DESC");
		$query = $query->get(10);
		return $query->getResult();

	}


	public function getSignalFinish(){
		$query = $this->db->table('trader_signal_finish')->orderBy("id","DESC")->get(10);
		return $query->getResult();

	}
	public function getSignalFinishByKey($message_id=0){
		if($message_id == 0) return [];

		$query = $this->db->table('trader_signal_finish')->where("message_id",$message_id)->orderBy("id","DESC")->get();
		return $query->getResult();

	}

	public function createOrder($obj){
		//print_r($obj);
		$date = explode(" ",$obj["opentime"]);
		list($year,$month,$day) = explode(".", $date[0]);
		$obj["opentime"] = $month."-".$day."-".$year." ".$date[1];
		//unset($arv["time"]);
		$this->db->table('trader_signal')->insert($obj);
	}

	public function test(){
		$info = $this->db->table('trader_signal')->where(["message_id" => 1699])->get(1)->getResult()[0];
		print_r($info);
	}

	public function finishOrder($obj){
		$info = $this->db->table('trader_signal')->where(["message_id" => $obj->message_id])->get(1)->getResult()[0];
		
		if(!$info) return false;

		
		$action = $obj->close_type;
		if($action == "sl" || ($obj->target == 3 && $obj->ordertype != "prime") || $obj->finish == "yes"){
			$this->db->table('trader_signal')->delete(["message_id" => $obj->message_id]);//Remove Complete Order
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
				"close_time" => date("Y-m-d h:i:s"),
				"profit_pip" => $obj->pip,
				"profit_usd" => $obj->usd,
				"close_type" => ($obj->close_type == "sl" || $obj->close_type == "tp" ?  $obj->close_type : "close"),
				"message_id" => $info->message_id,
				"is_access" => $obj->target < 2 ? "Free" : "Vip",
				"daily" => $formatday,
				"weekly" => (int)date('W')
			];
		$report_arv = $arv;
		if($obj->target == 4 || $obj->target == 5) $report_arv["close_type"] = "DCA";
		if($obj->ordertype == "prime") $report_arv["close_type"] = "PRIME";
		if($info) $this->db->table('trader_signal_finish')->insert($report_arv);
		
		$arv["message_id_group"] = $info->message_id_group;
		return $this->updateReport($arv);
		//return $arv;
	}

	public function updateReport($arv){
		$info = $this->db->table('trader_report')->where(["id" => 1])->get(1)->getResult()[0];

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

		$this->db->table('trader_report')->where(["id" => 1])->update($arvUpdate);
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
		$reinfo = $this->db->table('trader_report')->where(["id" => 1])->get(1)->getResult();
		$reportdayly = $this->db->table('trader_signal_finish')->where(['daily' => date('Y-m-d') ])->get()->getResult();
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
		$reinfo[0]->daily = (Object)$daily;
		return $reinfo[0];
	}
	public  function updateMsgIDOrder($obj)
	{
		$this->db->table('trader_signal')->where(["message_id" => $obj->message_id])->update(["message_id_group" => $obj->message_id_group]);
	}

	public function updateMsgIDOrderStatus($arv){
		
		$arvk = [];
		
		foreach ($arv as $key => $value) {
			$arvk[] = $key;
			$this->db->table('trader_signal')->where(["message_id" => $key])->update(["status_pips" => $value["pips"],"status_usd" => $value["usd"]]);
		}
		
		$query = $this->db->table('trader_signal')->orderBy("id","DESC")->get(100)->getResult();
		foreach ($query as $key => $value) {
			if(!in_array($value->message_id,$arvk)){
				//echo $value->message_id.".<br>";
				$this->db->table('trader_signal')->delete(["message_id" => $value->message_id]);
			}
		}

	}
}

