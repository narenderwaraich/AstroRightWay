<?php

namespace App\Http\Controllers;

use App\Astrologer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Toastr;
use Auth;
use App\User;
use DB;
use Mail;
use App\Mail\AstrologerVerification;
use App\Mail\PaymentNotification;
use App\Payment;
use Carbon\Carbon;
use Redirect;
use Response;
use App\Setting;
use App\BanerSlide;
use App\Chat;
use App\Order;
use App\Contact;
use App\AstrologerPayment;

class AstrologerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(){
        if(Auth::check()){
            if(Auth::user()->role == "astrologer"){
                $userId = Auth::id();
                $astrologerId = Astrologer::where('auth_id',$userId)->first()->id; //dd($astrologerId);
                $chats = Chat::where('message_status','=',"Sent")->where('message_assign','=',$astrologerId)->get(); //dd($chats);
                foreach ($chats as $chat) {
                  $chat->user_name = User::where('id',$chat->user_id)->first()->name;
                } 
                $astrologer = Astrologer::where('email',Auth::user()->email)->first(); //dd($astrologer);
                  if($astrologer->verified == 2){
                    $totalMessage = Chat::where('message_assign','=',$astrologerId)->count();
                    return view('Astrologer.index',compact('chats','astrologer','totalMessage'));
                }else{
                    $banner = BanerSlide::where('page_name','=','pay')->first(); //dd($banner);
                    if (isset($banner)) {
                        $title = $banner->title;
                        $description = $banner->description;
                    }
                  $setting = Setting::where('id',1)->first();  
                  $payment = $setting->astrologer;
                  return view('Astrologer.pay',compact('title','description','banner','payment'));
                }
            }else{
              return redirect()->to('/');
            }
        }else{
          return redirect()->to('/login');
        }
        
    }

    public function index()
    {
      if(Auth::check()){
          if(Auth::user()->role == "admin"){
            $astrologer = Astrologer::orderBy('created_at','desc')->paginate(10);
            return view('Admin.astrologer',compact('astrologer'));
          }
      }else{
      return redirect()->to('/login');
    }
    }

    public function astrologerView($id){
      $astrologer = Astrologer::find($id); //dd($astrologer);
      return view('Admin.Astrologers.View',compact('astrologer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            $banner = BanerSlide::where('page_name','=','join-astrologer')->first(); //dd($banner);
                if (isset($banner)) {
                    $title = $banner->title;
                    $description = $banner->description;
                }
            $country_data =DB::table('countries')->select('id','name')->get();
            $state_data = DB::table("states")->select('id','name')->get();
            $city_data = DB::table("cities")->select('id','name')->get();
        return view('join-astrologer',compact('title','description','banner','country_data','state_data','city_data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
    {
        $validate = $this->validate(request(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phone_no' => ['required', 'string', 'min:10', 'max:10'],
            ]);
              if(!$validate){
                toster::error('some error','Error',["positionClass" => "toast-bottom-right"]);
                Redirect::back();
              }

              $data = request(['name','email','phone_no','gender','date','address','country','state','city','zipcode']);
                if($request->avatar){
                  $imageName = time().'.'.request()->avatar->getClientOriginalExtension();

                  request()->avatar->move(public_path('images/user'), $imageName);
                  $data["avatar"] = $imageName;
                  $user["avatar"] = $imageName;
                  }
              $email = $request->email;
              $findUser = User::where('email',$email)->first();
              if($findUser){
                $data["auth_id"] = $findUser->id;
                $data["password"] = Hash::make($request->password);
                $data["email_token"] = base64_encode($email);
                $storeData = Astrologer::create($data);
                Mail::to($email)->send(new AstrologerVerification($storeData));
                Toastr::success('Thank you for join with us plz check your mail', 'Success', ["positionClass" => "toast-bottom-right"]);
                return redirect()->to('/');
              }else{
                $user["name"] = $request->name;
                $user["email"] = $email;
                $user["password"] = Hash::make($request->password);
                $user["phone_no"] = $request->phone_no;
                $user["gender"] = $request->gender;
                $user["date"] = $request->date;
                $user["role"] = 'astrologer';
                $userData = User::create($user);

                /// add astrologer data
                $data["auth_id"] = $userData->id;
                $data["password"] = Hash::make($request->password);
                $data["email_token"] = base64_encode($email);
                $storeData = Astrologer::create($data);
                Mail::to($email)->send(new AstrologerVerification($storeData));
                Toastr::success('Thank you for join with us plz check your mail', 'Success', ["positionClass" => "toast-bottom-right"]);
                return redirect()->to('/');
              }
    }
    
    public function verify($token)
            {
                $astrologer = Astrologer::where('email_token',$token)->first();
                $user = User::where('email',$astrologer->email)->first();
                $astrologer->verified = 1;
                $astrologer->auth_id = $user->id;
                if($astrologer->save()){
                  $user->verified = 1;
                  $user->save();
                Toastr::success('Email is successfully verified login Now', 'Success', ["positionClass" => "toast-top-right"]);
                return redirect()->to('/login');
                }
            }

    /**
     * Display the specified resource.
     *
     * @param  \App\Astrologer  $astrologer
     * @return \Illuminate\Http\Response
     */
    public function show(Astrologer $astrologer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Astrologer  $astrologer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      if(Auth::check()){
          if(Auth::user()->role == "astrologer"){
              $astrologer = Astrologer::where('auth_id',$id)->first(); //dd($astrologer);
              $country_data =DB::table('countries')->select('id','name')->get();
              $state_data = DB::table("states")->select('id','name')->get();
              $city_data = DB::table("cities")->select('id','name')->get();
          return view('Astrologer.edit-astrologer',compact('country_data','state_data','city_data','astrologer'));
        }
      }else{
        return redirect()->to('/login');
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Astrologer  $astrologer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //return $request;
        $validate = $this->validate(request(),[
            'name' => ['required', 'string', 'max:255'],
            'phone_no' => ['required', 'string', 'min:10', 'max:10'],
            ]);
              if(!$validate){
                toster::error('some error','Error',["positionClass" => "toast-bottom-right"]);
                Redirect::back();
              }

              $data = request(['name','email','phone_no','gender','date','address','country','state','city','zipcode']);

              if($request->avatar){
                  $imageName = time().'.'.request()->avatar->getClientOriginalExtension();

                  request()->avatar->move(public_path('images/user'), $imageName);
                  $data["avatar"] = $imageName;
                  $user["avatar"] = $imageName;
                  }

              $storeData = Astrologer::where('id',$id)->update($data);

              $userId = User::find(Auth::id());
              $user["name"] = $request->name;
              $user["phone_no"] = $request->phone_no;
              $user["gender"] = $request->gender;
              $user["date"] = $request->date;
              $userId->update($user);
              Toastr::success('data updated', 'Success', ["positionClass" => "toast-bottom-right"]);
                return redirect()->to('/astrologer/dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Astrologer  $astrologer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      if(Auth::check()){
        if(Auth::user()->role == "admin"){
        if($id == 1){
            Toastr::error('Astrologer Can not be deleted', 'Error', ["positionClass" => "toast-top-right"]);
                        return back();
        }else{
        $astrologer = Astrologer::find($id);
        $astrologer->delete();
      Toastr::success('Astrologer Deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/astrologer/dashboard');
        }
      }
      }else{
        return redirect()->to('/login');
      }
    }

    public function verifyAstrologer($id){
      if(Auth::check()){
          if(Auth::user()->role == "admin"){
              $atrologer = Astrologer::find($id);
              $data['verified'] = 2;
              $atrologer->update($data);
              Toastr::success('Astrologer Verified', 'Success', ["positionClass" => "toast-bottom-right"]);
                  return back();
            }
          }else{
        return redirect()->to('/login');
      }
    }

    public function inActiveAstrologer($id){
      if(Auth::check()){
          if(Auth::user()->role == "admin"){
              $atrologer = Astrologer::find($id);
              $data['verified'] = 1;
              $atrologer->update($data);
              Toastr::success('Astrologer Inactive', 'Success', ["positionClass" => "toast-bottom-right"]);
                  return back();
            }
          }else{
        return redirect()->to('/login');
      }
    }

    public function editAstrologer($id)
    {
      if(Auth::check()){
          if(Auth::user()->role == "admin"){
                $astrologer = Astrologer::where('auth_id',$id)->first(); //dd($astrologer);
                $country_data =DB::table('countries')->select('id','name')->get();
                $state_data = DB::table("states")->select('id','name')->get();
                $city_data = DB::table("cities")->select('id','name')->get();
            return view('Admin.Astrologers.Edit',compact('country_data','state_data','city_data','astrologer'));
          }
        }else{
        return redirect()->to('/login');
      }
    }


    public function genrateChatRefer(){
      if(Auth::check()){
          if(Auth::user()->role == "astrologer"){
                $userId = Auth::id();
                $astrologer = Astrologer::where('auth_id',$userId)->first(); //dd($astrologer);
                //$code = $astrologer->phone_no.$astrologer->name.$astrologer->email; //dd($code);
                $referCode = $this->refer_code_make();
                $data['chat_refer'] = $referCode;
                $astrologer->update($data);
              Toastr::success('Refer code genrated', 'Success', ["positionClass" => "toast-bottom-right"]);
                  return back();
          }
        }else{
        return redirect()->to('/login');
      }
    }

    function refer_code_make(){ 
                                    
        // String of all alphanumeric character
         
        $code = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
      
        // Shufle the $code and returns substring 
        // of specified length 
        return substr(str_shuffle($code),  
                           0, 10); 
    } 


    public function collectPayment()
    {
      if(Auth::check()){
          if(Auth::user()->role == "astrologer"){
            $astroId = Auth::id();
            $payments = AstrologerPayment::where('astrologer_id',$astroId)->orderBy('created_at','desc')->paginate(10); //dd($payments);
            foreach ($payments as $payment) {
                $user = User::find($payment->user_id);
                $payment->userName = $user->name;
            }  
          return view('Astrologer.payments',compact('payments'));
        }
      }else{
        return redirect()->to('/login');
      }
    }

    public function changeAstrologerPassword(){
      if(Auth::check()){
        if(Auth::user()->role == "astrologer"){
            return view('Astrologer.ChangePassword');
          }
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
                $amount = $request->payment;
                $order_id = uniqid();
                $order = new Payment();
                $order->order_id = $order_id;
                $order->transaction_status = 'Pending';
                $order->amount = $amount;
                $order->transaction_id = '';
                $order->user_id = Auth::id();
                $order->save();
                $data_for_request = $this->handlePaytmRequest($order_id, $amount);
                $paytm_txn_url = env('PAYTM_TXN_URL');
                $paramList = $data_for_request['paramList'];
                $checkSum = $data_for_request['checkSum'];

                return view('paytm-merchant-form',compact( 'paytm_txn_url', 'paramList', 'checkSum' ));
    }

    public function addAstrologer(){
      if(Auth::check()){
        if(Auth::user()->role == "admin"){
            $country_data =DB::table('countries')->select('id','name')->get();
            $state_data = DB::table("states")->select('id','name')->get();
            $city_data = DB::table("cities")->select('id','name')->get();
          return view('Admin.Astrologers.Add',compact('country_data','state_data','city_data'));
        }
    }else{
    return redirect()->to('/login');
  }
    }

    public function astrologerList(){
      if(Auth::check()){
        if(Auth::user()->role == "admin"){
          $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
          $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
          $astrologer = Astrologer::orderBy('created_at','desc')->paginate(10);
          return view('Admin.Astrologers.Show',compact('getOrders','contacts'),['astrologer' =>$astrologer]);
        }
      }else{
          return redirect()->to('/login');
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
        $paramList["CALLBACK_URL"] = url( env('ASTROLOGER_PAYMENT_STATUS') );  //env('CALLBACK_URL');
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
                    $order = Payment::where( 'order_id', $order_id )->first();
                    $order->transaction_status = 'Success';
                    $order->transaction_id = $transaction_id;
                    $order->payment_method = $payment_method;
                    $order->bank_transaction_id = $bank_transaction_id;
                    $order->bank_name = $bank_name;
                    $order->transaction_date =  Carbon::now();
                    $order->created_at =  Carbon::now();
                    $order->save();

                    $astrologer = Astrologer::where('email',Auth::user()->email)->first();
                    $astrologer->verified = 2;
                    $astrologer->save();

                    $user = User::where('id',$order->user_id)->first();
                    $setting = Setting::find(1);
                    $adminMail = $setting->admin_mail;
                    Mail::to($adminMail)->send(new PaymentNotification($user,$order));

                    Toastr::success('Payment Success', 'Success', ["positionClass" => "toast-top-right"]);
                    return redirect()->to('/');
        } else if( 'TXN_FAILURE' === $request['STATUS'] ){
                    ///Fields
                    $order = Payment::where( 'order_id', $order_id )->first();
                    $order->transaction_status = 'Fields';
                    $order->transaction_id = $transaction_id;
                    $order->payment_method = $payment_method;
                    $order->bank_transaction_id = $bank_transaction_id;
                    $order->bank_name = $bank_name;
                    $order->transaction_date =  Carbon::now();
                    $order->created_at =  Carbon::now();
                    $order->save();
                    return view( 'payment-failed' );
        }
    }

}
