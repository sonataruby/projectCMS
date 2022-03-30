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
		return view('pages/signal',["data" => $data, "week" => $dataWeek, "finish" => $finish, "header" => ["title" => "Smart Signal"]]);
	}

	public function attemptProfile(){

	}
	public function test(){
		print_r($this->telegram("46323","Hit Tp 1"));
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
				"message_id" => $data->telegram
			];
			$arvObj = $this->query->finishOrder((Object)$arv);
			$client->request('post', 'http://localhost:7000/finish', ["json" => $arvObj]);
			$msg = "";
			
			$reply_telegram_postid = $arvObj->message_id_group;

			if(strtolower($data->type) == "tp"){
				if($data->target < 3){
					$msg = "Hit TP : ".$data->target;
				}else if($data->target == 3){
					$msg = "Hit TP : ".$data->target."\nComplete Round";
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
			$this->query->updateMsgIDOrder((Object)$arv);
		}
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