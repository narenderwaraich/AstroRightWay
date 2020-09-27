<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\UserAddress;
use App\UserInvoice;
use App\CartStorage;
use App\Order;
use App\OrderItem;
use App\Setting;
use Carbon\Carbon;
use Auth;
use Toastr;
use App\Contact;
use App\Product;
use App\User;
use App\RefundPayment;
use App\BanerSlide;
use App\UserPlan;
use App\ChatPlan;
use Mail;
use App\Mail\PaymentNotification;

class PaymentController extends Controller
{
    
    // Paytem Via Cash function

    public function cashPayment($amount){
        $userId = Auth::id();
        $userAddress = UserAddress::where('user_id',$userId)->first();
            if(!$userAddress){
                Toastr::error('Please First Update Address', 'Error', ["positionClass" => "toast-top-right"]);
                    return back();
            }else{
                //$orderTax = DB::table("cart_storages")->where('user_id',$userId)->sum('tax');
                $orderDiscount = DB::table("cart_storages")->where('user_id',$userId)->sum('discount');
                $orderSubTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('subtotal');
                $orderTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('total');
                $orderAmount = DB::table("cart_storages")->where('user_id',$userId)->sum('net_amount');

                $lastOrderNumber = Order::orderBy('id', 'DESC')->pluck('order_number')->first(); 
                         //dd($lastOrderNumber);
                        if($lastOrderNumber){
                          $getNumber = explode('OR', $lastOrderNumber)[1]; 
                        $newOrderNum = 'OR'.str_pad($getNumber + 1, 5, "0", STR_PAD_LEFT);  //dd($newOrderNum);
                        
                        }else{
                          $newOrderNum = "OR00001";
                        }
                    $setting = Setting::where('id',1)->first();
                    //$taxRate = $setting->tax_rate;
                    $shipCharge = $setting->ship_charge;

                    $orderData['user_id'] = $userId;
                    $orderData['order_number'] = $newOrderNum;
                    $orderData['method'] = "Cash";
                    //$orderData['tax'] = $orderTax;
                    //$orderData['tax_rate'] = $taxRate;
                    $orderData['ship_charge'] = $shipCharge;
                    $orderData['discount'] = $orderDiscount;
                    $orderData['subtotal'] =  $orderSubTotal;
                    $orderData['total'] =  $orderTotal;
                    $orderData['net_amount'] =  $orderAmount;
                    $orderData['created_at'] =  Carbon::now();

                    $orderId = DB::table('orders')->insertGetId($orderData);

                    $cartStorg = CartStorage::where('user_id',$userId)->get(); //dd($cartStorg);

                    foreach ($cartStorg as $cartData) {       
                       $orderItem['product_id'] = $cartData->product_id;
                       $orderItem['order_id'] = $orderId;
                       $orderItem['user_id'] = $userId;
                       $orderItem['product_name'] = $cartData->product_name;
                       $orderItem['price'] = $cartData->price;
                       $orderItem['description'] = $cartData->description;
                       $orderItem['image'] = $cartData->image;
                       $orderItem['qty'] = $cartData->qty;

                       OrderItem::create($orderItem); 
                    }
                
        CartStorage::where('user_id',$userId)->delete();
        Toastr::success('Congratulations! your order Place success', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/');
        }
    }

    // Paytem Via Payments Recived all function

    public function paytmPay($amount)
    {
        $userId = Auth::id();
        $userAddress = UserAddress::where('user_id',$userId)->first();
            if(!$userAddress){
                Toastr::error('Please First Update Address', 'Error', ["positionClass" => "toast-top-right"]);
                    return back();
            }else{
                $lastOrderNumber = Order::orderBy('id', 'DESC')->pluck('order_number')->first(); 
                // dd($lastOrderNumber);
                if($lastOrderNumber){
                  $getNumber = explode('OR', $lastOrderNumber)[1]; 
                $newOrderNum = 'OR'.str_pad($getNumber + 1, 5, "0", STR_PAD_LEFT);  //dd($newOrderNum);
                }else{
                  $newOrderNum = "OR00001";
                }
                $order_id = uniqid();
                $order = new Order();
                $order->order_id = $order_id;
                $order->status = 'Fields';
                $order->user_id = Auth::id();
                $order->order_number = $newOrderNum;
                // $order->price = ( $request->price ) ? $request->price : '';
                $order->transaction_id = '';
                $order->save();

                $data_for_request = $this->handlePaytmRequest($order_id, $amount);


                $paytm_txn_url = env('PAYTM_TXN_URL');
                $paramList = $data_for_request['paramList'];
                $checkSum = $data_for_request['checkSum'];

                return view('paytm-merchant-form',compact( 'paytm_txn_url', 'paramList', 'checkSum' ));
            }
    }
    
    
    public function paytemRefundBack($id){
        $paymentData = Payment::find($id);
        $refundId = uniqid();
          /**
        * import checksum generation utility
        * You can get this utility from https://developer.paytm.com/docs/checksum/
        */
        $this->getAllEncdecFunc();

        /* initialize an array */
        $paytmParams = array();

        /* body parameters */
        $paytmParams["body"] = array(

            /* Find your MID in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys */
            "mid" => env('PAYTM_MERCHANT_ID'),

            /* This has fixed value for refund transaction */
            "txnType" => "REFUND",

            /* Enter your order id for which refund needs to be initiated */
            "orderId" => $paymentData->order_id,

            /* Enter transaction id received from Paytm for respective successful order */
            "txnId" => $paymentData->transaction_id,

            /* Enter numeric or alphanumeric unique refund id */
            "refId" => $refundId,

            /* Enter amount that needs to be refunded, this must be numeric */
            "refundAmount" => $paymentData->amount,
        );

        /**
        * Generate checksum by parameters we have in body
        * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
        */
        $checksum = getChecksumFromString(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), env('PAYTM_MERCHANT_KEY'));

        /* head parameters */
        $paytmParams["head"] = array(

            /* This is used when you have two different merchant keys. In case you have only one please put - C11 */
            "clientId"  => "C11",

            /* put generated checksum value here */
            "signature" => $checksum
        );

        /* prepare JSON string for request */
        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

        /* for Staging */
        $url = env('PAYTM_REFUND_URL');

        /* for Production */
        // $url = "https://securegw.paytm.in/refund/apply";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
        $response = curl_exec($ch);
        $output = json_decode($response);
        $getReturn = $output->body->resultInfo;
            $data['user_id'] =  $paymentData->user_id;
            $data['order_id'] =  $paymentData->order_id;
            $data['order_number'] = $paymentData->order_number;
            $data['transaction_id'] =  $paymentData->transaction_id;
            $data['amount'] =  $paymentData->amount;
            $data['status'] =  $getReturn->resultStatus;
            $data['transaction_date'] =  Carbon::now();
            $data['message'] =  $getReturn->resultMsg;
            $data['refund_id'] =  $refundId;
            RefundPayment::create($data);
            if ($getReturn->resultStatus == "TXN_FAILURE") {
                Toastr::error('Sorry not refundable', 'Error', ["positionClass" => "toast-top-right"]);
                return back();
            }else{
                Toastr::success('Payment refund success', 'Success', ["positionClass" => "toast-bottom-right"]);
                return back();
            }
            
  
    }

    public function handlePaytmRequest( $order_id, $amount ) {
        // Load all functions of encdec_paytm.php and config-paytm.php
        $this->getAllEncdecFunc();
        $this->getConfigPaytmSettings();

        $checkSum = "";
        $paramList = array();


       

        // Create an array having all required parameters for creating checksum.
        $paramList["MID"] = env('PAYTM_MERCHANT_ID');
        $paramList["ORDER_ID"] = $order_id;
        $paramList["CUST_ID"] = $order_id;
        $paramList["INDUSTRY_TYPE_ID"] = env('PAYTM_INDUSTRY_TYPE');
        $paramList["CHANNEL_ID"] = env('PAYTM_CHANNEL');
        $paramList["TXN_AMOUNT"] = $amount;
        $paramList["WEBSITE"] = env('PAYTM_MERCHANT_WEBSITE');
        $paramList["CALLBACK_URL"] = url( env('CALLBACK_URL') );  //env('CALLBACK_URL');
        $paytm_merchant_key = env('PAYTM_MERCHANT_KEY');

        //Here checksum string will return by getChecksumFromArray() function.
        $checkSum = getChecksumFromArray( $paramList, $paytm_merchant_key );

        //dd($checkSum);

        return array(
            'checkSum' => $checkSum,
            'paramList' => $paramList
        );
    }

    /**
     * Get all the functions from encdec_paytm.php
     */
    function getAllEncdecFunc() {
        function encrypt_e($input, $ky) {
            $key   = html_entity_decode($ky);
            $iv = "@@@@&&&&####$$$$";
            $data = openssl_encrypt ( $input , "AES-128-CBC" , $key, 0, $iv );
            return $data;
        }

        function decrypt_e($crypt, $ky) {
            $key   = html_entity_decode($ky);
            $iv = "@@@@&&&&####$$$$";
            $data = openssl_decrypt ( $crypt , "AES-128-CBC" , $key, 0, $iv );
            return $data;
        }

        function pkcs5_pad_e($text, $blocksize) {
            $pad = $blocksize - (strlen($text) % $blocksize);
            return $text . str_repeat(chr($pad), $pad);
        }

        function pkcs5_unpad_e($text) {
            $pad = ord($text{strlen($text) - 1});
            if ($pad > strlen($text))
                return false;
            return substr($text, 0, -1 * $pad);
        }

        function generateSalt_e($length) {
            $random = "";
            srand((double) microtime() * 1000000);

            $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
            $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
            $data .= "0FGH45OP89";

            for ($i = 0; $i < $length; $i++) {
                $random .= substr($data, (rand() % (strlen($data))), 1);
            }

            return $random;
        }

        function checkString_e($value) {
            if ($value == 'null')
                $value = '';
            return $value;
        }

        function getChecksumFromArray($arrayList, $key, $sort=1) {
            if ($sort != 0) {
                ksort($arrayList);
            }
            $str = getArray2Str($arrayList);
            $salt = generateSalt_e(4);
            $finalString = $str . "|" . $salt;
            $hash = hash("sha256", $finalString);
            $hashString = $hash . $salt;
            $checksum = encrypt_e($hashString, $key);
            return $checksum;
        }
        function getChecksumFromString($str, $key) {

            $salt = generateSalt_e(4);
            $finalString = $str . "|" . $salt;
            $hash = hash("sha256", $finalString);
            $hashString = $hash . $salt;
            $checksum = encrypt_e($hashString, $key);
            return $checksum;
        }

        function verifychecksum_e($arrayList, $key, $checksumvalue) {
            $arrayList = removeCheckSumParam($arrayList);
            ksort($arrayList);
            $str = getArray2StrForVerify($arrayList);
            $paytm_hash = decrypt_e($checksumvalue, $key);
            $salt = substr($paytm_hash, -4);

            $finalString = $str . "|" . $salt;

            $website_hash = hash("sha256", $finalString);
            $website_hash .= $salt;

            $validFlag = "FALSE";
            if ($website_hash == $paytm_hash) {
                $validFlag = "TRUE";
            } else {
                $validFlag = "FALSE";
            }
            return $validFlag;
        }

        function verifychecksum_eFromStr($str, $key, $checksumvalue) {
            $paytm_hash = decrypt_e($checksumvalue, $key);
            $salt = substr($paytm_hash, -4);

            $finalString = $str . "|" . $salt;

            $website_hash = hash("sha256", $finalString);
            $website_hash .= $salt;

            $validFlag = "FALSE";
            if ($website_hash == $paytm_hash) {
                $validFlag = "TRUE";
            } else {
                $validFlag = "FALSE";
            }
            return $validFlag;
        }

        function getArray2Str($arrayList) {
            $findme   = 'REFUND';
            $findmepipe = '|';
            $paramStr = "";
            $flag = 1;
            foreach ($arrayList as $key => $value) {
                $pos = strpos($value, $findme);
                $pospipe = strpos($value, $findmepipe);
                if ($pos !== false || $pospipe !== false)
                {
                    continue;
                }

                if ($flag) {
                    $paramStr .= checkString_e($value);
                    $flag = 0;
                } else {
                    $paramStr .= "|" . checkString_e($value);
                }
            }
            return $paramStr;
        }

        function getArray2StrForVerify($arrayList) {
            $paramStr = "";
            $flag = 1;
            foreach ($arrayList as $key => $value) {
                if ($flag) {
                    $paramStr .= checkString_e($value);
                    $flag = 0;
                } else {
                    $paramStr .= "|" . checkString_e($value);
                }
            }
            return $paramStr;
        }

        function redirect2PG($paramList, $key) {
            $hashString = getchecksumFromArray($paramList, $key);
            $checksum = encrypt_e($hashString, $key);
        }

        function removeCheckSumParam($arrayList) {
            if (isset($arrayList["CHECKSUMHASH"])) {
                unset($arrayList["CHECKSUMHASH"]);
            }
            return $arrayList;
        }

        function getTxnStatus($requestParamList) {
            return callAPI(PAYTM_STATUS_QUERY_URL, $requestParamList);
        }

        function getTxnStatusNew($requestParamList) {
            return callNewAPI(PAYTM_STATUS_QUERY_NEW_URL, $requestParamList);
        }

        function initiateTxnRefund($requestParamList) {
            $CHECKSUM = getRefundChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY,0);
            $requestParamList["CHECKSUM"] = $CHECKSUM;
            return callAPI(PAYTM_REFUND_URL, $requestParamList);
        }

        function callAPI($apiURL, $requestParamList) {
            $jsonResponse = "";
            $responseParamList = array();
            $JsonData =json_encode($requestParamList);
            $postData = 'JsonData='.urlencode($JsonData);
            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($postData))
            );
            $jsonResponse = curl_exec($ch);
            $responseParamList = json_decode($jsonResponse,true);
            return $responseParamList;
        }

        function callNewAPI($apiURL, $requestParamList) {
            $jsonResponse = "";
            $responseParamList = array();
            $JsonData =json_encode($requestParamList);
            $postData = 'JsonData='.urlencode($JsonData);
            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($postData))
            );
            $jsonResponse = curl_exec($ch);
            $responseParamList = json_decode($jsonResponse,true);
            return $responseParamList;
        }
        function getRefundChecksumFromArray($arrayList, $key, $sort=1) {
            if ($sort != 0) {
                ksort($arrayList);
            }
            $str = getRefundArray2Str($arrayList);
            $salt = generateSalt_e(4);
            $finalString = $str . "|" . $salt;
            $hash = hash("sha256", $finalString);
            $hashString = $hash . $salt;
            $checksum = encrypt_e($hashString, $key);
            return $checksum;
        }
        function getRefundArray2Str($arrayList) {
            $findmepipe = '|';
            $paramStr = "";
            $flag = 1;
            foreach ($arrayList as $key => $value) {
                $pospipe = strpos($value, $findmepipe);
                if ($pospipe !== false)
                {
                    continue;
                }

                if ($flag) {
                    $paramStr .= checkString_e($value);
                    $flag = 0;
                } else {
                    $paramStr .= "|" . checkString_e($value);
                }
            }
            return $paramStr;
        }
        function callRefundAPI($refundApiURL, $requestParamList) {
            $jsonResponse = "";
            $responseParamList = array();
            $JsonData =json_encode($requestParamList);
            $postData = 'JsonData='.urlencode($JsonData);
            $ch = curl_init($apiURL);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $refundApiURL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $jsonResponse = curl_exec($ch);
            $responseParamList = json_decode($jsonResponse,true);
            return $responseParamList;
        }
    }

    /**
     * Config Paytm Settings from config_paytm.php file of paytm kit
     */
    function getConfigPaytmSettings() {
        define('PAYTM_ENVIRONMENT', env('PAYTM_ENVIRONMENT')); // PROD
        define('PAYTM_MERCHANT_KEY', env('PAYTM_MERCHANT_KEY')); //Change this constant's value with Merchant key downloaded from portal
        define('PAYTM_MERCHANT_MID', env('PAYTM_MERCHANT_ID')); //Change this constant's value with MID (Merchant ID) received from Paytm
        define('PAYTM_MERCHANT_WEBSITE', env('PAYTM_MERCHANT_WEBSITE')); //Change this constant's value with Website name received from Paytm

        $PAYTM_STATUS_QUERY_NEW_URL= env('PAYTM_STATUS_QUERY_URL');
        $PAYTM_TXN_URL= env('PAYTM_TXN_URL');
        if (PAYTM_ENVIRONMENT == 'PROD') {
            $PAYTM_STATUS_QUERY_NEW_URL= env('PAYTM_STATUS_QUERY_URL');
            $PAYTM_TXN_URL= env('PAYTM_TXN_URL');
        }
        define('PAYTM_REFUND_URL', env('PAYTM_REFUND_URL'));
        define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
        define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
        define('PAYTM_TXN_URL', $PAYTM_TXN_URL);
    }

    public function paytmCallback( Request $request ) {
                //return $request;
                $order_id = $request['ORDERID'];
                $transaction_id = $request['TXNID'];
                $amount = $request['TXNAMOUNT'];
                $payment_method = $request['PAYMENTMODE'];
                $transaction_date = $request['TXNDATE'];
                $transaction_status = $request['STATUS'];
                $bank_transaction_id = $request['BANKTXNID'];
                $bank_name = $request['BANKNAME'];
                $userId = Auth::id();

        if ( 'TXN_SUCCESS' === $request['STATUS'] ) {
                //$orderTax = DB::table("cart_storages")->where('user_id',$userId)->sum('tax');
                $orderDiscount = DB::table("cart_storages")->where('user_id',$userId)->sum('discount');
                $orderSubTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('subtotal');
                $orderTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('total');
                $orderAmount = DB::table("cart_storages")->where('user_id',$userId)->sum('net_amount');

                    $setting = Setting::where('id',1)->first();
                    //$taxRate = $setting->tax_rate;
                    $shipCharge = $setting->ship_charge;


                    $transaction_id = $request['TXNID'];
                    $order = Order::where( 'order_id', $order_id )->first();
                    $order->status = 'Pending';
                    $order->transaction_id = $transaction_id;
                    $order->user_id = $userId;
                    $order->method = "Paytm";
                    //$order->tax = $orderTax;
                    //$order->tax_rate = $taxRate;
                    $order->ship_charge = $shipCharge;
                    $order->discount = $orderDiscount;
                    $order->subtotal =  $orderSubTotal;
                    $order->total =  $orderTotal;
                    $order->net_amount =  $amount;
                    $order->created_at =  Carbon::now();
                    $order->save();

                    $cartStorg = CartStorage::where('user_id',$userId)->get(); //dd($cartStorg);

                    foreach ($cartStorg as $cartData) {       
                       $orderItem['product_id'] = $cartData->product_id;
                       $orderItem['order_id'] = $order->id;
                       $orderItem['user_id'] = $userId;
                       $orderItem['product_name'] = $cartData->product_name;
                       $orderItem['price'] = $cartData->price;
                       $orderItem['description'] = $cartData->description;
                       $orderItem['image'] = $cartData->image;
                       $orderItem['qty'] = $cartData->qty;

                       OrderItem::create($orderItem); 
                    }

                    $data['user_id'] =  $userId;
                    $data['order_id'] =  $order_id;
                    $data['transaction_id'] =  $transaction_id;
                    $data['amount'] =  $orderAmount;
                    $data['payment_method'] =  $payment_method;
                    $data['transaction_date'] =  $transaction_date;
                    $data['transaction_status'] = 'Success';
                    $data['bank_transaction_id'] =  $bank_transaction_id;
                    $data['bank_name'] =  $bank_name;

            Payment::create($data);
            CartStorage::where('user_id',$userId)->delete();
            $user = User::where('id',$userId)->first();
            $setting = Setting::find(1);
            $adminMail = $setting->admin_mail;
            Mail::to($adminMail)->send(new PaymentNotification($order,$user));
            return view( 'order-complete', compact( 'order', 'status' ) );
        } else if( 'TXN_FAILURE' === $request['STATUS'] ){
            //return $request;
            return view( 'payment-failed' );
        }
    }

    // public function createInvoice($orderAmount,$orderDiscount,$orderSubTotal,$orderTotal){
    //     $userId = Auth::id();
    //     $lastInvoice = UserInvoice::latest()->orderBy('id', 'DESC')->pluck('invoice_number')->first(); 
    //                     //dd($lastInvoice);
    //                     if($lastInvoice){
    //                       $getNumber = explode('INV', $lastInvoice)[1]; 
    //                     $newInvoice = 'INV'.str_pad($getNumber + 1, 5, "0", STR_PAD_LEFT);  //dd($newInvoice);
                        
    //                     }else{
    //                       $newInvoice = "INV00001";
    //                     } 
    //             $setting = Setting::where('id',1)->first();
    //             //$taxRate = $setting->tax_rate;
    //             $shipCharge = $setting->ship_charge;       
    //             $data['user_id'] = $userId;
    //             $data['discount'] = $orderDiscount;
    //             $data['subtotal'] = $orderSubTotal;
    //             $data['total'] = $orderTotal;
    //             $data['net_amount'] = $orderAmount;
    //             $data['ship_charge'] = $shipCharge;
    //             //$data['tax_rate'] = $taxRate;
    //             $data['invoice_number'] = $newInvoice;

    //         UserInvoice::create($data);
    // }


    public function paytmShowPayments(){
        $payments = Payment::where('transaction_status','=','Success')->orderBy('created_at','desc')->paginate(10); //dd($payments);
        foreach ($payments as $payment) {
            $user = User::find($payment->user_id);
            $payment->userName = $user->name;
        }
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        return view('Admin.Payments.paytm',compact('getOrders','contacts'),['payments' =>$payments]);
    }

    public function paytmWithStatus($status){
        $payments = Payment::where('transaction_status',$status)->orderBy('created_at','desc')->paginate(10); //dd($payments);
        foreach ($payments as $payment) {
            $user = User::find($payment->user_id);
            $payment->userName = $user->name;
        }
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        return view('Admin.Payments.paytm',compact('getOrders','contacts'),['payments' =>$payments]);
    }

    public function cashShowPayments(){
        $payments = Payment::orderBy('created_at','desc')->paginate(10); //dd($payments);
        foreach ($payments as $payment) {
            $user = User::find($payment->user_id);
            $payment->userName = $user->name;
        }
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        return view('Admin.Payments.cash',compact('getOrders','contacts'),['payments' =>$payments]);
    }

    public function refundShowPayments(){
        $refundPayments = RefundPayment::orderBy('created_at','desc')->paginate(10); //dd($payments);
        foreach ($refundPayments as $payment) {
            $user = User::find($payment->user_id);
            $payment->userName = $user->name;
        }
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        return view('Admin.Payments.refund',compact('getOrders','contacts'),['refundPayments' =>$refundPayments]);
    }

}