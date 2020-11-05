<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\UserAddress;
use Auth;
use Toastr;
use Carbon\Carbon;
use Redirect;
use Response;
use App\User;
use PaytmWallet;
use App\EventRegistration;
use App\CartStorage;
use Mail;
use App\Mail\OrderAccept;
use App\Mail\OrderCancel;
use App\Mail\OrderDispatch;
use App\Mail\OrderReject;
use App\Mail\Payments;
use App\Review;
use App\Contact;
use App\OrderItem;
use App\Payment;
use App\BanerSlide;
use App\OrderPayment;
use App\Setting;
use App\Mail\OrderPaymentNotifaction;
use App\Mail\OrderPlace;
use App\ProfitSharePayment;

class OrderController extends Controller
{
    public function paytmPay($amount)
    {
        $userId = Auth::id();
        $checkUserData = User::where('id',$userId)->first();
        $checkUserMobile = $checkUserData->phone_no;
        if($checkUserMobile == ""){
                Toastr::error('Please Update your mobile number in profile', 'Error', ["positionClass" => "toast-top-right"]);
                    return back();
            }
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
                $order->method = 'Paytm';
                $order->user_id = Auth::id();
                $order->order_number = $newOrderNum;
                // $order->price = ( $request->price ) ? $request->price : '';
                $order->transaction_id = '';
                $order->save();


                $orderPaymentRecord = new OrderPayment();
                $orderPaymentRecord->amount = $amount;
                $orderPaymentRecord->order_id = $order_id;
                $orderPaymentRecord->transaction_status = 'Pending';
                $orderPaymentRecord->payment_method = 'Paytm';
                $orderPaymentRecord->user_id = Auth::id();
                $orderPaymentRecord->order_number = $newOrderNum;
                $orderPaymentRecord->transaction_id = '';
                $orderPaymentRecord->save();

                $data_for_request = $this->handlePaytmRequest($order_id, $amount);


                $paytm_txn_url = env('PAYTM_TXN_URL');
                $paramList = $data_for_request['paramList'];
                $checkSum = $data_for_request['checkSum'];

                return view('paytm-merchant-form',compact( 'paytm_txn_url', 'paramList', 'checkSum' ));
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
        $paramList["CALLBACK_URL"] = url( env('ORDER_PAYMENT_STATUS_URL') );  //env('CALLBACK_URL');
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

        if ( 'TXN_SUCCESS' === $request['STATUS'] ) {
                $orderPaymentRecord = OrderPayment::where('order_id', $order_id )->first();

                $orderPaymentRecord->payment_method = $payment_method;
                $orderPaymentRecord->transaction_id = $transaction_id;
                $orderPaymentRecord->transaction_status = $transaction_status;
                $orderPaymentRecord->bank_transaction_id = $bank_transaction_id;
                $orderPaymentRecord->transaction_date = $transaction_date;
                $orderPaymentRecord->bank_name = $bank_name;
                $orderPaymentRecord->amount =  $amount;
                $orderPaymentRecord->created_at =  Carbon::now();
                $orderPaymentRecord->save();

                $profitAmount = 0;

                $order = Order::where('order_id', $order_id )->first();
                $userId = $order->user_id;
                //$orderTax = DB::table("cart_storages")->where('user_id',$userId)->sum('tax');
                $orderDiscount = DB::table("cart_storages")->where('user_id',$userId)->sum('discount');
                $orderSubTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('subtotal');
                $orderTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('total');
                $orderAmount = DB::table("cart_storages")->where('user_id',$userId)->sum('net_amount');

                    $setting = Setting::where('id',1)->first();
                    //$taxRate = $setting->tax_rate;
                    $shipCharge = $setting->ship_charge;


                    $transaction_id = $request['TXNID'];
                    $order->status = 'Pending';
                    $order->transaction_id = $transaction_id;
                    $order->method = $payment_method;
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
                       $saleProductAmount = Product::where('id',$cartData->product_id)->first()->original_price * $cartData->qty;
                       $profitAmount += $saleProductAmount; 
                       OrderItem::create($orderItem);
                    }

                    $orderExp = $profitAmount + $shipCharge;

                    $shareProfitAmount = $amount - $orderExp;

                    $profitShare['order_id'] = $order_id;
                    $profitShare['order_profit'] = $shareProfitAmount;
                    ProfitSharePayment::create($profitShare); 

            CartStorage::where('user_id',$userId)->delete();
            $user = User::where('id',$userId)->first();
            $setting = Setting::find(1);
            $adminMail = $setting->admin_mail;
            Mail::to($adminMail)->send(new OrderPaymentNotifaction($user,$order));
            $userData = User::find($userId);
            Mail::to($user->email)->send(new OrderPlace($userData));
            return view( 'order-complete', compact( 'order', 'status' ) );
        } else if( 'TXN_FAILURE' === $request['STATUS'] ){
            //return $request;
                $orderPaymentRecord = OrderPayment::where('order_id', $order_id )->first();

                $orderPaymentRecord->payment_method = $payment_method;
                $orderPaymentRecord->transaction_id = $transaction_id;
                $orderPaymentRecord->transaction_status = $transaction_status;
                $orderPaymentRecord->bank_transaction_id = $bank_transaction_id;
                $orderPaymentRecord->transaction_date = $transaction_date;
                $orderPaymentRecord->bank_name = $bank_name;
                $orderPaymentRecord->amount =  $amount;
                $orderPaymentRecord->created_at =  Carbon::now();
                $orderPaymentRecord->save();
            return view( 'payment-failed' );
        }
    }





    public function takeOrder($id){
        $data['user_id'] = Auth::id();
        $data['product_id'] = $id;

        Order::create($data);
        Toastr::success('Order place successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/');
    }

    public function showOrder(){
        $orders = Order::orderBy('created_at','desc')->paginate(10); //dd($orders);
        foreach ($orders as $order) {
            $userAddress = UserAddress::where('user_id',$order->user_id)->first();
            $order->userAddress = $userAddress->address;
            $order->userCountry = $userAddress->country;
            $order->userState = $userAddress->state;
            $order->userCity = $userAddress->city;
            $order->userPINCode = $userAddress->zipcode;
        }
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        return view('Admin.Orders.Show',compact('getOrders','contacts'),['orders' =>$orders]);
    }

    public function showOrderItems($id){
        $orderItem = OrderItem::where('order_id',$id)->get(); //dd($orderItem);
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        return view('Admin.Orders.Order-Item',compact('getOrders','contacts'),['orderItem' =>$orderItem]);
    }

    public function showUserOrder(){
        $banner = BanerSlide::where('page_name','=','user-order')->first(); //dd($banner);
        if (isset($banner)) {
            $title = $banner->title;
            $description = $banner->description;
        }
        $userId = Auth::id();
        if(Auth::check()){
            $Orders = Order::where('user_id',$userId)->latest()->paginate(10); //dd($Orders);
            $cartCollection = CartStorage::where('user_id',$userId)->get();
            $subTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('subtotal');
            return view('user-order',compact('title','description'),compact('Orders'),['banner' =>$banner, 'cartCollection' =>$cartCollection, 'subTotal' => $subTotal]);
        }else{
            return redirect()->to('/login');
        }
    }

    public function userOrderDitails($id){
        $banner = BanerSlide::where('page_name','=','order-detail')->first(); //dd($banner);
        if (isset($banner)) {
            $title = $banner->title;
            $description = $banner->description;
        }
        $userId = Auth::id();
        if(Auth::check()){
            $orderItem = OrderItem::where('order_id',$id)->get(); //dd($orderItem);
            $cartCollection = CartStorage::where('user_id',$userId)->get();
            $subTotal = DB::table("cart_storages")->where('user_id',$userId)->sum('subtotal');
            return view('order-detail',compact('title','description'),compact('orderItem'),['cartCollection' =>$cartCollection, 'subTotal' => $subTotal]);
        }else{
            return redirect()->to('/login');
        }
    }

    public function orderAccept($id){
        $status['status'] = "Accept";
        Order::where('id',$id)->update($status);
        $getUser = Order::find($id);
        $userId = $getUser->user_id;
        $userData = User::find($userId);
        $mailId = $userData->email;
         Mail::to($mailId)->send(new OrderAccept($userData));
        Toastr::success('Order Accept', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/orders/show');
    }
    public function orderDispatch(Request $request){
        $allData = request(['dispatch_id','track_code','track_url']); 
        $data  = request(['track_code','track_url']); 
        $orderId = $allData['dispatch_id']; 
        $data['status'] = "Dispatch";
        Order::where('id',$orderId)->update($data);
        $getUser = Order::find($orderId);
        $userId = $getUser->user_id;
        $userData = User::find($userId);
        $mailId = $userData->email;
         Mail::to($mailId)->send(new OrderDispatch($userData));
         //return response()->json(['error' => $invs]);
         return response()->json(['success' => "Order Dispatch"]);
    }

    public function orderCancel($id){
        $order = Order::where('id',$id)->first();
        $status = $order->status;
        if($status == 'Pending' || $status == 'Accept'){
            $data['status'] = "Cancel";
            $order->update($data);
            $getUser = Order::find($id);
            $userId = $getUser->user_id;
            $userData = User::find($userId);
            $mailId = $userData->email;
         Mail::to($mailId)->send(new OrderCancel($userData));
            Toastr::success('Order Cancel', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/user-order');
        }else{
          Toastr::error('Order can not be Cancel', 'Sorry', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/user-order');  
        }
    }

    public function orderReject(Request $request){
        $allData = request(['reject_id','message']); 
        $message  = request(['message']); 
        $orderId = $allData['reject_id']; 
        $data['status'] = "Reject";
        Order::where('id',$orderId)->update($data);
        $getUser = Order::find($orderId);
        $userId = $getUser->user_id;
        $userData = User::find($userId);
        $mailId = $userData->email;
         Mail::to($mailId)->send(new OrderReject($userData,$message));
         return response()->json(['success' => "Order Rejected"]);
    }

    public function orderComplete($id){
        $getOrder = Order::find($id);
        $method = $getOrder->method;
        $userId = $getOrder->user_id;
        $userData = User::find($userId);
        $mailId = $userData->email;
         Mail::to($mailId)->send(new Payments($userData));
         $status['status'] = "Complete";
         Order::where('id',$id)->update($status);
         if($method == "Cash"){
                $data['user_id'] =  $getOrder->user_id;
                $data['order_id'] =  $getOrder->id;
                $data['amount'] =  $getOrder->net_amount;
                $data['payment_method'] =  "Cash";
                $data['transaction_date'] =  Carbon::now();
                $data['transaction_status'] =  "Success";
                $data['order_number'] =  $getOrder->order_number;
                Payment::create($data);
         }
        Toastr::success('Order Complete', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/orders/show');
    }
    
    public function orderTrack($id){
        $banner = BanerSlide::where('page_name','=','track-shiping')->first(); //dd($banner);
        if (isset($banner)) {
            $title = $banner->title;
            $description = $banner->description;
        }
        $order = Order::find($id); //dd($order);
        if($order->status =="Dispatch"){
           return view('track-shiping',compact('title','description'),['banner' =>$banner, 'order' =>$order]);
        }else{
           Toastr::error('Order not Dispatch', 'Error', ["positionClass" => "toast-bottom-right"]);
           return redirect()->to('/user-order');
        }
    }


    public function paytmShowPayments(){
        $payments = OrderPayment::where('transaction_status','=','Success')->orderBy('created_at','desc')->paginate(10); //dd($payments);
        foreach ($payments as $payment) {
            $user = User::find($payment->user_id);
            $payment->userName = $user->name;
        }
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        return view('Admin.Payments.order-payment',compact('getOrders','contacts'),['payments' =>$payments]);
    }

    public function paytmWithStatus($status){
        $payments = OrderPayment::where('transaction_status',$status)->orderBy('created_at','desc')->paginate(10); //dd($payments);
        foreach ($payments as $payment) {
            $user = User::find($payment->user_id);
            $payment->userName = $user->name;
        }
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        return view('Admin.Payments.order-payment',compact('getOrders','contacts'),['payments' =>$payments]);
    }
}
