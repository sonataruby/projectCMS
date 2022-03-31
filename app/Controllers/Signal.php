<?php
namespace App\Controllers;
use App\Models\TraderModel;
class Signal extends BaseController
{
	private $query;
	public function __construct(){
		$this->query = new TraderModel;
	}
    public function index()
    {
        // check if already logged in.
		if (!logged_in())
		{
			return redirect()->route('login');
		}
		$search = $this->request->getGet('fillter');

        $data = $this->query->getSignal($search);
        $dataWeek = $this->query->getSignalWeek($search);
        $finish = $this->query->getSignalFinish();
        $report = $this->query->getReport();
		return view('pages/signal',["data" => $data, "week" => $dataWeek,"report" => $report, "finish" => $finish, "header" => ["title" => "Smart Signal"]]);
	}

	public function attemptProfile(){

	}
	public function test(){
		//$this->scanTelegramID(1804);
	}
	public function api($type=""){
		$data  = json_decode($this->request->getGet('query'));
		
		if($type == "create"){
			$arv = [
				
				"symbol" => $data->symbol, 
				"type" => $data->type, 
				"open" => $data->open,
				"open_2" => $data->dca1, 
				"open_3" => $data->dca2, 
				"sl" => $data->sl, 
				"tp" => $data->tp,
				"tp_2" => $data->tp2, 
				"tp_3" => $data->tp3,  
				"message_id" => $data->telegram,
				"message_id_group" => $data->relymsg,
				"timefream" => $data->tf, 
				"chart" => ""
			];

			$this->query->createOrder($arv);
			$client = \Config\Services::curlrequest();

			$client->request('post', 'http://localhost:7000/signal', ["json" => $arv]);
			echo json_encode(["status" => "ok"]);
		}


		if($type == "finish"){
			$arv = [
				"target" => $data->target,
				"pip" => $data->pip,
				"close" => $data->close_at,
				"close_type" => strtolower($data->type),
				"usd" => $data->usd,
				"message_id" => $data->telegram,
				"finish" => $data->finish
			];
			$arvObj = $this->query->finishOrder((Object)$arv);
			$client = \Config\Services::curlrequest();
			@$client->request('post', 'http://localhost:7000/finish', ["json" => $arvObj]);
			$msg = "";
			
			$readObj = (Object)$arvObj;
			$reply_telegram_postid = $readObj->message_id_group;

			if(strtolower($data->type) == "tp"){
				if($data->target < 3){
					$msg = "Hit TP : ".$data->target;
				}else if($data->target == 3){
					$msg = "Hit TP : ".$data->target."\nComplete Round";
				}else if($data->target == 4){
					$msg = "Hit TP : DCA1";
				}else if($data->target == 5){
					$msg = "Hit TP : DCA2";
				}
			}else if(strtolower($data->type) == "sl"){
				$msg = "Hit SL finish round ";
			}else if(strtolower($data->type) == "close"){
				$msg = "Close finish round ";
			}
			
			$this->telegram($reply_telegram_postid,$msg);

			echo json_encode(["status" => "ok"]);
		}

		if($type == "updatemsgid"){
			$arv = [
				"message_id" => $data->telegram,
				"message_id_group" => $data->reply_id
			];
			
			if($data->reply_id > 0) $this->query->updateMsgIDOrder((Object)$arv);
		}

		if($type == "status"){
			$extract = explode(";", $this->request->getGet('query'));

			$arv = [];
			foreach ($extract as $key => $value) {
				list($key_id,$usd, $pips) = explode("|", $value);
				
				if($arv[$key_id] > 0){
					$arv[$key_id]["usd"] = $arv[$key_id]["usd"] + $usd;
					$arv[$key_id]["pips"] = $arv[$key_id]["pips"] + $pips;
				}else{
					$arv[$key_id]["usd"] = $usd;
					$arv[$key_id]["pips"] = $pips;
				}
			}
			if($arv) $this->query->updateMsgIDOrderStatus($arv);
			
		}
	}

	public function scanTelegramID($telegramid=0){
		$msgid = 0;
		$token = "5209738152:AAG5MzyE3cJg75GoXcjZByW4W7fH4JknZCI";
		$client = \Config\Services::curlrequest();
		$data = $client->request('GET', 'https://api.telegram.org/bot'.$token.'/getUpdates?limit=150')->getBody();
		$json = json_decode($data);
		foreach ($json->result as $key => $value) {
			print_r($value->message->forward_from_message_id."<br>");
			if(is_object($value->message)  && $value->message->message_id && $value->message->forward_from_message_id){
				//print_r($value->message->forward_from_message_id."<br>");
				if($telegramid == $value->message->forward_from_message_id && is_object($value->message->from)){
					print_r($value);
					if($value->message->from->is_bot == false && $value->message->from->first_name == "Telegram"){
						$msgid = $value->message->message_id;
					}
				}
			}
		}
		print_r($msgid);
	}
	

	public function telegram($reply_id, $msg){
		
		$group = "@smartiqx";
	    $token = "5209738152:AAG5MzyE3cJg75GoXcjZByW4W7fH4JknZCI";
	    // following ones are optional, so could be set as null
	    $disable_web_page_preview = false;
	    $reply_to_message_id = $reply_id;
	   
	    $data = array(
	            'chat_id' => $group,
	            'text' => $msg,
	            'disable_web_page_preview' => false,
	            'reply_to_message_id' => $reply_to_message_id
	        );

	    $url = "https://api.telegram.org/bot".$token."/sendMessage";

	    //  open connection
	    $ch = curl_init();
	    //  set the url
	    curl_setopt($ch, CURLOPT_URL, $url);
	    //  number of POST vars
	    curl_setopt($ch, CURLOPT_POST, count($data));
	    //  POST data
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    //  To display result of curl
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    //  execute post
	    $result = curl_exec($ch);
	    //print_r($result);
	    //  close connection
	    curl_close($ch);
	}
}