<?php

namespace App\Http\Controllers;

use App\MemberJoin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Validator;
use Redirect;
use Toastr;
use Carbon\Carbon;
use Auth;
use App\User;
use App\BanerSlide;
use App\MemberPayment;
use App\UserPlan;
use App\Order;
use App\Contact;
use Mail;
use App\Mail\MemberNotification;
use App\Mail\EmailVerification;
use App\Mail\PaymentNotification;
use App\Setting;
use App\Chat; 

class MemberJoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
    if(Auth::check()){   
            $id = Auth::id();
            $member = MemberJoin::where('user_id',$id)->first();
        if($member){
            if($member->status ==1){
                $banner = BanerSlide::where('page_name','=','member-panel')->first(); //dd($banner);
                    if (isset($banner)) {
                        $title = $banner->title;
                        $description = $banner->description;
                    }
                $myMembers = MemberJoin::where('refer_code',$member->member_code)->get();
                $activeMembers = MemberJoin::where('refer_code',$member->member_code)->where('status','=',1)->get();
                //if user have down complete 20 member update level
                if(count($activeMembers)==20 && $member->level == ""){
                    $data['level'] = "Pearl";
                    $member->update($data);
                }
                return view('member-panel',compact('title','description','banner','member','myMembers'));

               }else{
                    return redirect()->to('/join-member/pay/payment');
            }
        }else{
            return redirect()->to('/join-member');
        
        }

     }else{
            return redirect()->to('/login');
        }
        
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banner = BanerSlide::where('page_name','=','join-member')->first(); //dd($banner);
            if (isset($banner)) {
                $title = $banner->title;
                $description = $banner->description;
            }
        if (Auth::check()) {  
            return view('join-member',compact('title','description','banner'));
        }else{
            return view('make-member',compact('title','description','banner'));
            }
    }

    public function joinWithCode($code)
    {
        $banner = BanerSlide::where('page_name','=','join-member')->first(); //dd($banner);
            if (isset($banner)) {
                $title = $banner->title;
                $description = $banner->description;
            }
        $referCode = $code;
        
        if (Auth::check()) {
            return view('join-member',compact('title','description','banner','referCode'));
        }else{
            return view('make-member',compact('title','description','banner','referCode'));
            }
    }


    public function memberPlan()
    {
            $banner = BanerSlide::where('page_name','=','member-plan')->first(); //dd($banner);
            if (isset($banner)) {
                $title = $banner->title;
                $description = $banner->description;
            }
            return view('member-plan',compact('title','description','banner'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $this->validate($request, [
            'name' => 'required', 'string', 'max:255',
            'email' => 'required', 'string', 'email', 'max:255', 'unique:member_joins',
            'phone_no' => 'required', 'string', 'min:10', 'max:10',
            ]);
            if(!$validate){
                    Redirect::back()->withInput();
            }
            if (Auth::check()) {
                $data = request(['name','email','phone_no']);
                $userId = Auth::id();
                $current = Carbon::now();
                $nowDate = $current->toDateTimeString();
                $expireDate = $current->addDays(30);

                $lastMemberNumber = MemberJoin::orderBy('id', 'DESC')->pluck('member_code')->first(); 
                 //dd($lastMemberNumber);
                if($lastMemberNumber){
                  $getNumber = explode('ARW', $lastMemberNumber)[1]; 
                $newMemberNum = 'ARW'.str_pad($getNumber + 1, 5, "0", STR_PAD_LEFT);  //dd($newMemberNum);
                
                }else{
                  $newMemberNum = "ARW00001";
                }

                $refer = $request->refer_code;
                $checkRefer = MemberJoin::where('member_code',$refer)->first();

                $data['join_date'] = Carbon::now();
                $data['exp_date'] = $expireDate;
                $data['member_code'] = $newMemberNum;
                $data['user_id'] = $userId;
                if($checkRefer){
                    $data['refer_code'] = $refer;
                }
                $member = MemberJoin::create($data);

                if($checkRefer){
                    $addMember['down_member'] = $checkRefer->down_member +1;
                    $checkRefer->update($addMember);
                }

                $userPlan['amount'] = 101;
                $userPlan['access_date'] = Carbon::now();
                $userPlan['get_message'] = 500;
                $userPlan['expire_date'] = $expireDate;
                $userPlan['plan_id'] = 6;
                $userPlan['user_id'] = $userId;
                $userPlan['is_activated'] = 0;
                
                $checkUserPlan = UserPlan::where('user_id',$userId)->first();
                if($checkUserPlan){
                    $checkUserPlan->update($userPlan);
                }else{
                    UserPlan::create($userPlan);
                }
                $adminMail = "singh4narender@gmail.com";
                Mail::to($adminMail)->send(new MemberNotification($member));
                Toastr::success('Meember Join', 'Success', ["positionClass" => "toast-bottom-right"]);
                    return redirect()->to('/member-panel');
                
            }else{
                return redirect()->to('/login');
            }
    }


    public function userWithMember(Request $request)
    {
        $validate = $this->validate($request, [
            'name' => 'required', 'string', 'max:255',
            'email' => 'required', 'string', 'email', 'max:255', 'unique:member_joins',
            'phone_no' => 'required', 'string', 'min:10', 'max:10',
            'gender' => 'required',
            ]);
            if(!$validate){
                    Redirect::back()->withInput();
            }
            $findUser = User::where('email','=',$request->email)->first();
            if ($findUser) {
                $data = request(['name','email','phone_no']);
                $userId = $findUser->id;
                $current = Carbon::now();
                $nowDate = $current->toDateTimeString();
                $expireDate = $current->addDays(30);

                $lastMemberNumber = MemberJoin::orderBy('id', 'DESC')->pluck('member_code')->first(); 
                 //dd($lastMemberNumber);
                if($lastMemberNumber){
                  $getNumber = explode('ARW', $lastMemberNumber)[1]; 
                $newMemberNum = 'ARW'.str_pad($getNumber + 1, 5, "0", STR_PAD_LEFT);  //dd($newMemberNum);
                
                }else{
                  $newMemberNum = "ARW00001";
                }

                $refer = $request->refer_code;
                $checkRefer = MemberJoin::where('member_code',$refer)->first();

                $data['join_date'] = Carbon::now();
                $data['exp_date'] = $expireDate;
                $data['member_code'] = $newMemberNum;
                $data['user_id'] = $userId;
                if($checkRefer){
                    $data['refer_code'] = $refer;
                }
                $member = MemberJoin::create($data);

                if($checkRefer){
                    $addMember['down_member'] = $checkRefer->down_member +1;
                    $checkRefer->update($addMember);
                }

                $userPlan['amount'] = 101;
                $userPlan['access_date'] = Carbon::now();
                $userPlan['get_message'] = 500;
                $userPlan['expire_date'] = $expireDate;
                $userPlan['plan_id'] = 6;
                $userPlan['user_id'] = $userId;
                $userPlan['is_activated'] = 0;
                
                $checkUserPlan = UserPlan::where('user_id',$userId)->first();
                if($checkUserPlan){
                    $checkUserPlan->update($userPlan);
                }else{
                    UserPlan::create($userPlan);
                }
                $adminMail = "singh4narender@gmail.com";
                Mail::to($adminMail)->send(new MemberNotification($member));
                Toastr::success('Meember Join', 'Success', ["positionClass" => "toast-bottom-right"]);
                    return redirect()->to('/member-panel');
                
            }else{ //// if not find user record 

                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone_no' => $request->phone_no,
                    'gender' => $request->gender,
                    'password' => Hash::make($request->password),
                    'email_token' => base64_encode($request->email),
                    'otp' => rand(100000, 999999)
                ]);

                //// add member record in database
                $data = request(['name','email','phone_no']);
                $userId = $user->id;
                $current = Carbon::now();
                $nowDate = $current->toDateTimeString();
                $expireDate = $current->addDays(30);

                $lastMemberNumber = MemberJoin::orderBy('id', 'DESC')->pluck('member_code')->first(); 
                 //dd($lastMemberNumber);
                if($lastMemberNumber){
                  $getNumber = explode('ARW', $lastMemberNumber)[1]; 
                $newMemberNum = 'ARW'.str_pad($getNumber + 1, 5, "0", STR_PAD_LEFT);  //dd($newMemberNum);
                
                }else{
                  $newMemberNum = "ARW00001";
                }

                $refer = $request->refer_code;
                $checkRefer = MemberJoin::where('member_code',$refer)->first();

                $data['join_date'] = Carbon::now();
                $data['exp_date'] = $expireDate;
                $data['member_code'] = $newMemberNum;
                $data['user_id'] = $userId;
                if($checkRefer){
                    $data['refer_code'] = $refer;
                }
                $member = MemberJoin::create($data);

                if($checkRefer){
                    $addMember['down_member'] = $checkRefer->down_member +1;
                    $checkRefer->update($addMember);
                }

                $userPlan['amount'] = 101;
                $userPlan['access_date'] = Carbon::now();
                $userPlan['get_message'] = 500;
                $userPlan['expire_date'] = $expireDate;
                $userPlan['plan_id'] = 6;
                $userPlan['user_id'] = $userId;
                $userPlan['is_activated'] = 0;
                
                $checkUserPlan = UserPlan::where('user_id',$userId)->first();
                if($checkUserPlan){
                    $checkUserPlan->update($userPlan);
                }else{
                    UserPlan::create($userPlan);
                }

                // send mail to user for varify
                Mail::to($request->email)->send(new EmailVerification($user));
                $adminMail = "singh4narender@gmail.com";
                Mail::to($adminMail)->send(new MemberNotification($member));
                Toastr::success('Meember Join', 'Success', ["positionClass" => "toast-bottom-right"]);
                    // return redirect()->to('/member-panel');
                return view('auth.otp',compact('user'));
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MemberJoin  $memberJoin
     * @return \Illuminate\Http\Response
     */
    public function show(MemberJoin $memberJoin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MemberJoin  $memberJoin
     * @return \Illuminate\Http\Response
     */
    public function edit(MemberJoin $memberJoin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MemberJoin  $memberJoin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $member = MemberJoin::where('id',$id)->first();
        $validate = $this->validate($request, [
            'name' => 'required', 'string', 'max:255',
            'email' => 'required', 'string', 'email', 'max:255', 'unique:member_joins',
            'phone_no' => 'required', 'string', 'min:10', 'max:10',
            ]);
            if(!$validate){
                    Redirect::back()->withInput();
            }
            if (Auth::check()) {
                $data = request(['name','email','phone_no']);
                $member->update($data);
                Toastr::success('Meember Updated', 'Success', ["positionClass" => "toast-bottom-right"]);
                    return redirect()->to('/member-panel');
                
            }else{
                return redirect()->to('/login');
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MemberJoin  $memberJoin
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::check()){
            if(Auth::user()->role == "admin"){
                if($id == 1){
                    Toastr::error('Admin Can not be deleted', 'Error', ["positionClass" => "toast-top-right"]);
                                return back();
                }else{
                $member = MemberJoin::find($id);
                $member->delete();
              Toastr::success('Member Deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
                    return redirect()->to('/admin');
                }
              }
        }else{
            return redirect()->to('/login');
        }
    }

    public function getPay(){
        if(Auth::check()){
            return view('member-pay');
        }else{
            return redirect()->to('/login');
        }
    }

    public function paytmPay(Request $request)
    {
                $validate = $this->validate($request, [
                    'payment' => 'required|min:1',
                ]);
                if(!$validate){
                    Redirect::back()->withInput();
                }
                $id = Auth::id();
                $member = MemberJoin::where('user_id',$id)->first();

                $amount = Setting::where('id',1)->first()->member; //dd($amount);
                $order_id = uniqid();
                $order = new MemberPayment();
                $order->order_id = $order_id;
                $order->transaction_date = Carbon::now();
                $order->transaction_status = 'Pending';
                $order->amount = $amount;
                $order->user_id = $id;
                $order->member_id = $member->id; 
                $order->transaction_id = '';
                $order->payment_method = "Paytm";
                $order->save();
                $data_for_request = $this->handlePaytmRequest($order_id, $amount);
                $paytm_txn_url = env('PAYTM_TXN_URL');
                $paramList = $data_for_request['paramList'];
                $checkSum = $data_for_request['checkSum'];

                return view('paytm-merchant-form',compact( 'paytm_txn_url', 'paramList', 'checkSum' ));
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
        $paramList["CALLBACK_URL"] = url( env('MEMBER_PAYMENT_CALL_BACK') );  //env('CALLBACK_URL');
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
                    $order = MemberPayment::where( 'order_id', $order_id )->first();
                    $order->transaction_status = 'Success';
                    $order->transaction_id = $transaction_id;
                    $order->payment_method = $payment_method;
                    $order->bank_transaction_id = $bank_transaction_id;
                    $order->bank_name = $bank_name;
                    $order->transaction_date =  Carbon::now();
                    $order->created_at =  Carbon::now();
                    $order->save();

                    $member = MemberJoin::where('id',$order->member_id)->first();
                    $data['status'] = 1;
                    $member->update($data);

                    $checkUserPlan = UserPlan::where('user_id',$order->user_id)->first();
                    $current = Carbon::now();
                    $nowDate = $current->toDateTimeString();
                    $expireDate = $current->addDays(30);
                    $userPlan['amount'] = 101;
                    $userPlan['access_date'] = Carbon::now();
                    $userPlan['get_message'] = 500;
                    $userPlan['expire_date'] = $expireDate;
                    $userPlan['plan_id'] = 6;
                    $userPlan['is_activated'] = 1;
                    $checkUserPlan->update($userPlan);

                    /// update pending message to sent
                    $chat = Chat::where('user_id',$order->user_id)->where('message_status' ,'=', "Pending")->first();
                    $chatData['message_status'] = "Sent";
                    $chat->update($chatData);

                    $user = User::where('id',$order->user_id)->first();
                    $adminMail = "singh4narender@gmail.com";
                    Mail::to($adminMail)->send(new PaymentNotification($user,$order));

                    Toastr::success('Payment Success', 'Success', ["positionClass" => "toast-top-right"]);
                    return redirect()->to('/member-panel');
        } else if( 'TXN_FAILURE' === $request['STATUS'] ){
                $order = MemberPayment::where( 'order_id', $order_id )->first();
                $order->transaction_status = 'Field';
                $order->transaction_id = $transaction_id;
                $order->payment_method = $payment_method;
                $order->bank_transaction_id = $bank_transaction_id;
                $order->bank_name = $bank_name;
                $order->created_at =  Carbon::now();
                $order->save();
                return view( 'payment-failed' );
        }
    }


    public function paytmShow(){
        $memberPayments = MemberPayment::where('transaction_status','=','Success')->orderBy('created_at','desc')->paginate(10); //dd($memberPayments);
        foreach ($memberPayments as $memberPayment) {
            $user = User::find($memberPayment->user_id);
            $memberPayment->userName = $user->name;
        }
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        return view('Admin.MemberPayment.paytm',compact('getOrders','contacts'),['memberPayments' =>$memberPayments]);
    }

    public function withStatus($status){
        $memberPayments = MemberPayment::where('transaction_status',$status)->orderBy('created_at','desc')->paginate(10); //dd($memberPayments);
        foreach ($memberPayments as $memberPayment) {
            $user = User::find($memberPayment->user_id);
            $memberPayment->userName = $user->name;
        }
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        return view('Admin.MemberPayment.paytm',compact('getOrders','contacts'),['memberPayments' =>$memberPayments]);
    }

    public function memberShow(){
    if(Auth::check()){
        if(Auth::user()->role == "admin"){
            $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
            $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
            $chats = Chat::where('message_status','=',"Sent")->get(); //dd($chats);
            $member = MemberJoin::where('status',1)->orderBy('created_at','desc')->paginate(10);
            return view('Admin.User.Member',compact('getOrders','contacts','chats'),['member' =>$member]);
          }
      }else{
          return redirect()->to('/login');
      }
    }

    public function memberWithMember($id){
        if(Auth::check()){
        if(Auth::user()->role == "admin"){
            $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
            $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
            $chats = Chat::where('message_status','=',"Sent")->get(); //dd($chats);
            $member = MemberJoin::find($id);
            $myMembers = MemberJoin::where('refer_code',$member->member_code)->get();
            $activeMembers = MemberJoin::where('refer_code',$member->member_code)->where('status', '=', 1)->count();
            $deactiveMembers = MemberJoin::where('refer_code',$member->member_code)->where('status', '=', 0)->count();
            return view('Admin.User.Member-Show',compact('getOrders','contacts','chats'),['member' =>$member, 'myMembers' =>$myMembers, 'activeMembers' => $activeMembers, 'deactiveMembers' => $deactiveMembers]);
          }
      }else{
          return redirect()->to('/login');
      }
    }

    public function userMemberWithMember($id){
        if(Auth::check()){
            $banner = BanerSlide::where('page_name','=','member-panel')->first(); //dd($banner);
                    if (isset($banner)) {
                        $title = $banner->title;
                        $description = $banner->description;
                    }
            $member = MemberJoin::find($id);
            $myMembers = MemberJoin::where('refer_code',$member->member_code)->get();
            return view('member-with-member',compact('title','description','banner','member','myMembers'));
      }else{
          return redirect()->to('/login');
      }
    }

    public function SearchData(Request $request){
            $q = Input::get ( 'q' );
            /// Start user search by Name or email
            $member = MemberJoin::where('name', 'like', '%'.$q.'%')
                 ->orWhere('email', 'like', '%'.$q.'%')
                 ->orWhere('phone_no', 'like', '%'.$q.'%')
                 ->orderBy('created_at', 'desc')
                 ->paginate(10)->setPath ( '' );
                  $pagination = $member->appends ( array (
                  'q' => Input::get ( 'q' )
                  ) );
            if (count ($member) > 0){ //by user name data view
                  $total_row = $member->total(); //dd($total_row);
                return view ('Admin.User.Member',compact('total_row','member'))->withQuery ( $q )->withMessage ($total_row.' '. 'Member found match your search');
             }else{ 
                return view ('Admin.User.Member')->withMessage ( 'Member not found match Your search !' );
             }
        }       

    public function memberWithStatus($status){
      if(Auth::check()){
            if(Auth::user()->role == "admin"){
                $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
                $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
                $chats = Chat::where('message_status','=',"Sent")->get(); //dd($chats);
                $member = MemberJoin::where('status',$status)->orderBy('created_at','desc')->paginate(10);
                return view('Admin.User.Member',compact('getOrders','contacts','chats'),['member' =>$member]);
              }
      }else{
          return redirect()->to('/login');
      }
    }


    public function verifyMember($id){
      if(Auth::check()){
        if(Auth::user()->role == "admin"){
            $member = MemberJoin::find($id);
            $member->status = !$member->status;
            $member->save();
            Toastr::success('Member Verified', 'Success', ["positionClass" => "toast-bottom-right"]);
                return back();
          }
        }else{
            return redirect()->to('/login');
        }
        }
    
    public function enableDisableMember($id){
      if(Auth::check()){
          if(Auth::user()->role == "admin"){
            $member = MemberJoin::find($id);
            $member->status = !$member->status;
            $member->save();
            Toastr::success('Member Suspend', 'Success', ["positionClass" => "toast-bottom-right"]);
                return back();
          }
      }else{
          return redirect()->to('/login');
      }
        }



}