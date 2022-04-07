<?php
namespace App\Controllers;
use App\Models\TraderModel;
use App\Models\PostsModel;
use App\Libraries\UUID;
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
		return view('pages/signal',["data" => $data, "week" => $dataWeek,"report" => $report, "finish" => $finish, "header" => $this->getHeader(["title" => "Smart Signal"])]);
	}

	

	public function updateaccount(){
		if (!logged_in())
		{
			return redirect()->route('login');
		}
		$time = $this->request->getPost("timeline");
        if($time == "") $time = 1;
        $price = 30;
        $total = $time * $price;
        $discordLine = 5;
        if($time == 3){
            $discordLine = 20;
        }else if($time == 6){
            $discordLine = 30;
        }else if($time == 12){
            $discordLine = 40;
        }else if($time == 24){
            $discordLine = 50;
        }
        $discord = $total - $total*(100-$discordLine)/100;
        $pay = $total - $discord;
        $item = [
            "name" => $time . " month",
            "price" => $price,
            "discord" => $discord,
            "payment" => $pay,
            "qty" => 1
        ];

		$arv = [
			"name" => "Update VIP",
			"cost" => $total,
			"discord" => $discord,
			"discordline" => $discordLine,
			"payment" => $pay,
			"return_action" => "\App\Models\Account\setPremisstion('vip')"
		];
		$invoice_id = $this->invoice->createInvoice($arv, [$item]);

		return _go("/payment/invoice/".$invoice_id);
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
				"chart" => "",
				"opentime" => $data->time,
				"ordertype" => $data->ordertype
			];

			$this->query->createOrder($arv);
			$client = \Config\Services::curlrequest();

			$client->request('post', 'http://localhost:7000/signal', ["json" => $arv]);
			echo json_encode(["status" => "ok"]);
		}


		if($type == "finish"){
			$data->finish = $data->ordertype == "prime" ? "no" : $data->finish;
			
			$arv = [
				"target" => $data->target,
				"pip" => $data->pip,
				"close" => $data->close_at,
				"close_type" => strtolower($data->type),
				"usd" => $data->usd,
				"message_id" => $data->telegram,
				"finish" => $data->finish,
				"time" => $data->time,
				"ordertype" => $data->ordertype
			];
			$arvObj = $this->query->finishOrder((Object)$arv);
			if($arvObj){
				$client = \Config\Services::curlrequest();
				@$client->request('post', 'http://localhost:7000/finish', ["json" => (Array)$arvObj]);
				$msg = "";
				
				$readObj = (Object)$arvObj;

				$reply_telegram_postid = $readObj->message_id;

				if(strtolower($data->type) == "tp" && ($data->target == 3 || $data->finish == "yes")){
					$msg = $readObj->symbol . " [".strtoupper($readObj->type)."] Complete round\n";
					$msg .= $this->getMsgTelegramFinish($readObj->message_id);//Get masg Complete
				}else if(strtolower($data->type) == "sl"){
					$msg = $readObj->symbol . " [".strtoupper($readObj->type)."] Complete round\n";
					$msg .= $this->getMsgTelegramFinish($readObj->message_id);//Get masg Complete
				}else if(strtolower($data->type) == "close" && $data->finish == "yes"){
					$msg = $readObj->symbol . " [".strtoupper($readObj->type)."] Complete round\n";
					$msg .= $this->getMsgTelegramFinish($readObj->message_id);
				}else{
					if(strtolower($data->type) == "tp"){
						$msg = $readObj->symbol . " [".strtoupper($readObj->type)."] hit TP ".$data->target."\n";
						$msg .= "Open : ".$readObj->open . "  Close :  ".$data->close_at."\n";
						$msg .= "Profit : ".$readObj->profit_usd . "$  Pips :  ".$data->profit_pip." pip(s)\n";
					}
					if(strtolower($data->type) == "sl"){
						$msg = $readObj->symbol . " [".strtoupper($readObj->type)."] hit SL\n";
						$msg .= "Open : ".$readObj->open . "  Close :  ".$data->close_at."\n";
						$msg .= "Profit : ".$readObj->profit_usd . "$  Pips :  ".$data->profit_pip." pip(s)\n";
					}
				}
				
				$this->telegram($reply_telegram_postid,$msg);
			}
			echo json_encode(["status" => "ok"]);
		}

		

		if($type == "status"){
			$extract = explode(";", $this->request->getGet('query'));

			$arv = [];
			foreach ($extract as $key => $value) {
				list($key_id,$usd, $pips, $symbol) = explode("|", $value);
				
				if($arv[$key_id] > 0){
					$arv[$key_id]["usd"] = $arv[$key_id]["usd"] + $usd;
					$arv[$key_id]["pips"] = $arv[$key_id]["pips"] + $pips;
				}else{
					$arv[$key_id]["usd"] = $usd;
					$arv[$key_id]["pips"] = $pips;
				}
			}

			if($arv) $this->query->updateMsgIDOrderStatus($arv,$symbol);
			

			$query = $this->query->getSignal();
			$arvPush = [];
			foreach ($query as $key => $value) {
				$arvPush[] = [
					"id" => $value->message_id,
					"pips" => $value->status_pips,
					"usd" => $value->status_usd,
				];
			}

			$client = \Config\Services::curlrequest();
			@$client->request('post', 'http://localhost:7000/price', ["json" => (Array)$arvPush]);

		}
		
	}

	public function getMsgTelegramFinish($msg_id){
		$query = $this->query->getSignalFinishByKey($msg_id);
		if(!$query) return false;
		$msg = "";
		$profit_pip = 0;
		$profit_usd = 0;
		$order = 0;
		$msg .= "Type | Open     | Close   | Profit\n";
		foreach ($query as $key => $value) {
			$msg .= strtoupper($value->type)." | ".$value->open." | ".$value->close_at." | ".$value->profit_pip."\n";
			$order +=1;
			$profit_pip = $profit_pip + $value->profit_pip;
			$profit_usd = $profit_usd + $value->profit_usd;
		}
		$msg .= "==================================\n";
		$msg .= "Order Open : ".$order."\n";
		$msg .= "Profit Pips : ".$profit_pip." pip(s)\n";
		$msg .= "Profit USD : ".$profit_usd." USD\n";
		$msg .= "==================================\n";
		$msg .=  "AI System trader #BTC, #ETH, #Crypto, #Forex, #Sock\n";
		$msg .=  "Check real signal free : https://expressiq.co/signal";
		return $msg;
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
		
		$group = "@goldslacp";
	    $token = "5209738152:AAG5MzyE3cJg75GoXcjZByW4W7fH4JknZCI";
	    // following ones are optional, so could be set as null
	    $disable_web_page_preview = false;
	    $reply_to_message_id = $reply_id;
	   
	    $data = array(
	            'chat_id' => $group,
	            'text' => $msg,
	            'disable_web_page_preview' => false
	            //'reply_to_message_id' => $reply_to_message_id
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


	/*
	Shopping
	*/

	public function buysmartos(){
		$time = $this->request->getPost("timeline");
		$meta_id = $this->request->getPost("meta_id");

        if($time == "") $time = 1;
        $price = 120;
        $total = $time * $price;
        $discordLine = 5;
        if($time == 3){
            $discordLine = 20;
        }else if($time == 6){
            $discordLine = 30;
        }else if($time == 12){
            $discordLine = 40;
        }else if($time == 24){
            $discordLine = 50;
        }
        $discord = $total - $total*(100-$discordLine)/100;
        $pay = $total - $discord;
        $item = [
            "name" => $time . " month",
            "price" => $price,
            "discord" => $discord,
            "payment" => $pay,
            "qty" => 1
        ];

		$arv = [
			"name" => "Buy Smart OS | ".$meta_id,
			"cost" => $total,
			"discord" => $discord,
			"discordline" => $discordLine,
			"payment" => $pay,
			"return_action" => "downloadcontent",
			"contents" => json_encode(["filename" => $meta_id.".key","content" => $this->serial($meta_id, $time * 30)])
		];
		$invoice_id = $this->invoice->createInvoice($arv, [$item]);

		return _go("/payment/invoice/".$invoice_id);
	}

	public function shopos(){
		//$post = new PostsModel;
		//$data = $this->posts->getPostsByType("indicator");

		return view("pages/shop_smartos",["header" => ["title" => "Smart OS Shop"]]);
	}

	public function buysmartindicator(){
		
		$meta_id = $this->request->getPost("meta_id");

       
        $price = 50;
        $total = $price;
        $discordLine = 5;
        
        $discord = $total - $total*(100-$discordLine)/100;
        $pay = $total - $discord;
        $item = [
            "name" => "Smart Indicator ".$meta_id,
            "price" => $price,
            "discord" => $discord,
            "payment" => $pay,
            "qty" => 1
        ];

		$arv = [
			"name" => "Buy Smart Indicator | ".$meta_id,
			"cost" => $total,
			"discord" => $discord,
			"discordline" => $discordLine,
			"payment" => $pay,
			"return_action" => "downloadcontent",
			"contents" => json_encode(["filename" => $meta_id.".key","content" => $this->serialindicator($meta_id)])
		];
		$invoice_id = $this->invoice->createInvoice($arv, [$item]);

		return _go("/payment/invoice/".$invoice_id);
	}

	public function shopindicator(){
		//$post = new PostsModel;
		//$data = $this->posts->getPostsByType("indicator");

		return view("pages/shop_indicator",["header" => ["title" => "Smart OS Indicator"]]);
	}

	public function serial($id=0,$finish=30){
		$data = [
			"start" => date('Y.m.d h:i',now()),
			"end" => date('Y.m.d h:i',now()+(84000*$finish)),
			"meta_id" => $id,
			"serial" => UUID::v5('1546058f-5a25-4334-85ae-e68f2a44bbaf', $id)
		];
		$json = json_encode($data);
		return base64_encode($json);
	}

	public function serialindicator($id=0){
		
		return base64_encode("SmartIQIndicator").base64_encode($id."|".UUID::v5('1546058f-5a25-4334-85ae-e68f2a44bbaf', $id));
	}

	public function shop(){
		//$post = new PostsModel;
		$data = $this->posts->getPostsByType("indicator");

		return view("pages/shop",["item" => $data, "header" => ["title" => "Smart OS Shop"]]);
	}

	public function shopinfo($id){
		
		$data = $this->posts->getPostByID($id);
		return view("pages/shop-detail",["data" => $data,"header" => ["title" => "Smart OS Shop"]]);
	}









}

