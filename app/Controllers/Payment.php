<?php

namespace App\Controllers;
use App\Models\BillingModel;
class Payment extends BaseController
{

    //private $paypalClientID = "Aafu2Nq8NSYSWq9KeU5_Ht4Ge6YjboAWLrVlZCptGHw0s2JoclY5U9js8RyICCfCSF2lh27gqefmGteW";
    //private $paypalClientSecret = "EJs8bpM09hRXZTczxFA5mvMwVXYE3P_g-S4WcVf_PumSDIfv_A7ik7QWCFBkZHjDqjPcXc2mHC5ZzNBj";
    
    private $paypalClientID = "AZgXuZZ0zqKppoB1GgPNQ4ymTqssQMCKvgEjT1dJTeDaNtGr-qSdPiCajuS_Hu8w4TKT94LorYmrEYMG";
    private $paypalClientSecret = "EJBAS33Vv62aeQUx7Nvl6uzjHzxqUh5N8UkR1wax8odJc4FiPFaudy4kCX9LkQDs7Co0jtrOhhbUVtZw";
    
    public function index(){

    }


    public function invoice($invoice_id)
    {
        $method = $this->request->getPost("methodpayment");
        $data = (Array)$this->invoice->getInvoice($invoice_id);
        if($method == "paypal"){
            
            $datapayment =  $this->paypal($data);
            $this->invoice->updatepayment($invoice_id, ["payment_method" => "paypal","payment_id" => $datapayment["payment_id"]]);
            return _go($datapayment["url"]);
            exit();
        }
        return view('pages/payment',["invoice" => $data]);
    }


    public function cancel($invoice_id){
        $data = (Array)$this->invoice->getInvoice($invoice_id);
        return view('pages/payment-cancel',["invoice" => $data]);
    }

    public function complete($invoice_id){
        $data = $this->invoice->getInvoice($invoice_id);
        if($data->payment_method == "paypal"){
            $getdata = $this->check_paypal($data->payment_id);
            if($getdata["status"] == "complete"){

                $this->invoice->updateComplete($invoice_id);
                $billing = new BillingModel;
                $billing->create($data);

                $class = $data->return_action;
                if($class != ""){
                    $ob = new $class;
                    return $ob->payment();
                }
                return _go("/signal");
            }
        }
        //print_r($data);
    }

    public function paypal($arv=[]){
        require_once APPPATH . "ThirdParty/paypal/vendor/autoload.php";
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $this->paypalClientID,     // ClientID
                $this->paypalClientSecret      // ClientSecret
            )
        );
        // Step 2.1 : Between Step 2 and Step 3
        $apiContext->setConfig(
          array(
            'mode' => 'live',
            'log.LogEnabled' => false,
            'log.FileName' => 'PayPal.log',
            'log.LogLevel' => 'FINE'
          )
        );

        // After Step 2
        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

       
        $item1 = new \PayPal\Api\Item();
        foreach ($arv["item"] as $key => $value) {
            $item1->setName($value->name);
            $item1->setCurrency('USD');
            $item1->setQuantity($value->qty);
            $item1->setPrice($value->payment);
        }
        


        $itemList = new \PayPal\Api\ItemList();
        $itemList->setItems(array($item1));


        $amount = new \PayPal\Api\Amount();
        $amount->setCurrency("USD");
        $amount->setTotal($arv["payment"]);



        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount);
        $transaction->setItemList($itemList);
        $transaction->setDescription($arv["name"]);

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl(base_url("payment/complete/".$arv["inc_id"]))
            ->setCancelUrl(base_url("signal"));

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);



        
        // After Step 3
        try {
            $payment->create($apiContext);
            
            return ["payment_id" => $payment->id, "url" => $payment->getApprovalLink()];
        }
        catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // This will print the detailed information on the exception.
            //REALLY HELPFUL FOR DEBUGGING
            //echo $ex->getData();
            //echo $ex->getData();
            return ["payment_id" => 0, "url" => "/payment/error"];
        }


    }



    public function check_paypal($paymentId){
        require_once APPPATH . "ThirdParty/paypal/vendor/autoload.php";
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $this->paypalClientID,     // ClientID
                $this->paypalClientSecret      // ClientSecret
            )
        );
        // Step 2.1 : Between Step 2 and Step 3
        $apiContext->setConfig(
          array(
            'mode' => 'live',
            'log.LogEnabled' => false,
            'log.FileName' => 'PayPal.log',
            'log.LogLevel' => 'FINE'
          )
        );
        //use PayPal\Api\Amount;
        //use PayPal\Api\Details;
        //use PayPal\Api\ExecutePayment;
        //use PayPal\Api\Payment;
        //use PayPal\Api\PaymentExecution;
        //use PayPal\Api\Transaction;

        // Get payment object by passing paymentId
        
        $payment = \PayPal\Api\Payment::get($paymentId, $apiContext);
        
        $payerId = $_GET['PayerID'];

        // Execute payment with payer id
        $execution = new \PayPal\Api\PaymentExecution();
        $execution->setPayerId($payerId);

        //echo "<pre>";
        try {
          // Execute payment
          $result = $payment->execute($execution, $apiContext);
          $subtotal = $payment->transactions[0]->related_resources[0]->sale->amount->details->subtotal;
            if ($result) {
                return ["status" => "complete","subtotal" => $subtotal];
           }
          //var_dump($result);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
          echo $ex->getCode();
          echo $ex->getData();
          die($ex);
        } catch (Exception $ex) {
          die($ex);
        }
    }
}
