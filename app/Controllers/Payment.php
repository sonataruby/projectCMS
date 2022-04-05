<?php

namespace App\Controllers;

class Payment extends BaseController
{

    public function index()
    {
        $time = $this->request->getPost("timeline");
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
            "price" => $price
        ];
        return view('pages/payment',["invoice" => ["price" => $price, "total" => $total, "discord" => $discord,"discordLine" => $discordLine, "pay" => $pay, "item" => [$item]]]);
    }
}
