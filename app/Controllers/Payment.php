<?php

namespace App\Controllers;

class Payment extends BaseController
{

    public function index(){

    }


    public function invoice($invoice_id)
    {
        $data = $this->invoice->getInvoice($invoice_id);
        
        return view('pages/payment',["invoice" => ["price" => $price, "total" => $total, "discord" => $discord,"discordLine" => $discordLine, "pay" => $pay, "item" => [$item]]]);
    }
}
