<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Auth;
use Toastr;
use Redirect;
use Hash;
use App\Role;
use Validator;
use App\UserRole;
use App\Product;
use App\Order;
use App\Setting;
use App\Contact;
use Carbon\Carbon;
use App\BanerSlide;
use App\Page;
use App\Chat;
use App\Payment;
use App\DirectPayment;
use App\MemberPayment;
use App\UserAddress;
use App\MemberJoin;
use App\UserPlan;
use App\AstrologerPayment;
use App\Astrologer;
use Mail;
use App\Mail\EmailVerification;

class AdminController extends Controller
{
    // public function __construct(){
    //     $this->middleware('auth');
    // }
    
    public function homePage(){
        if(Auth::check()){
            $findRole = User::find(Auth::id());
            $role = $findRole->role;
            if($role == "admin" || $role == "administrator"){
                $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
                $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
                $chats = Chat::where('message_status','=',"Sent")->get(); //dd($chats);
                foreach ($chats as $chat) {
                  $chat->user_name = User::where('id',$chat->user_id)->first()->name;
                }
                $totalUser =User::All()->count();
                $activeUser =User::where('verified', '=', 1)->count();
                $deActiveUser =User::where('verified', '=', 0)->count();
                $newUser =User::whereMonth('created_at', '>=', Carbon::now()->subMonth(12))->count();
                $userData =DB::table('users')
                     ->select(DB::raw('COUNT(*) as user_num'),DB::raw('DATE_FORMAT(created_at, "%Y-%m-01") as month'))
                     ->groupBy('month')
                     ->orderBy('month','asc')
                     ->get();
                     //dd($userData);
                $member = MemberJoin::where('id', '!=', 1)->where('status', '=', 1)->count();
                $deActiveMember = MemberJoin::where('id', '!=', 1)->where('status', '=', 0)->count();
                $totalMember = MemberJoin::where('id', '!=', 1)->count();
                $totalProfit = Payment::where('transaction_status','=','Success')->sum('amount');
                $directPayment = DirectPayment::where('transaction_status','=','Success')->sum('amount');
                $memberPayment = MemberPayment::where('transaction_status','=','Success')->sum('amount');
                $totalCollectPayment = $totalProfit + $memberPayment;

                $activeAstrologer = Astrologer::where('verified', '=', 2)->count();
                $deActiveAstrologer = Astrologer::where('verified', '=', 1)->count();
                $totalAstrologer = Astrologer::all()->count();

                // //// all members
                // $members = MemberJoin::where('status', '=', 1)->get();
                // foreach ($members as $memberData) {
                //   $memberData->down_member_join = MemberJoin::where('refer_code','=', $memberData->member_code)->get();
                // }
                $totalMessage = Chat::All()->count();
                return view('Admin.index',compact('getOrders','contacts','chats','totalUser','activeUser','newUser','userData','deActiveUser','totalProfit','directPayment','memberPayment','member','deActiveMember','totalMember', 'totalCollectPayment','totalMessage','activeAstrologer','deActiveAstrologer','totalAstrologer'));
            }else{
                // message
                return redirect('/login');
            }
        }else{
           return redirect('/login'); 
        }
        
    }

    public function dashboard(){
            $piChart = [0,0,0];
            $allUser = User::all()->count();
            $veryfiyUser = User::where('verified','=',1)->count();
            $notVeryfiyUser = User::where('verified','=',0)->count();
            
            $piChart[0] += $allUser;
            $piChart[1] += $veryfiyUser;
            $piChart[2] += $notVeryfiyUser;
            $finalPiData = [];
           
            foreach($piChart as $key => $PiData){
              $finalPiData[$key]['type'] = ($key == 0 ? "All" : ($key  == 1 ? "Voucher Verified" : "Not Verified"));
              $finalPiData[$key]['count'] = $PiData;
            }

            $data=[
                'piChartData'=> $finalPiData
            ];
        return response()->json($data);
    }

    public function __construct(){
     $this->middleware('auth');
   }
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
      if(Auth::check()){
        if(Auth::user()->role == "admin"){
            $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
            $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
            $chats = Chat::where('message_status','=',"Sent")->get(); //dd($chats);
            $user = User::where('verified',1)->orderBy('created_at','desc')->paginate(10);
            return view('Admin.User.Show',compact('getOrders','contacts','chats'),['user' =>$user]);
          }
        }else{
              return redirect()->to('/login');
        }
    }

    public function userWithStatus($status){
          if(Auth::check()){
        if(Auth::user()->role == "admin"){
            $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
            $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
            $chats = Chat::where('message_status','=',"Sent")->get(); //dd($chats);
            $user = User::where('verified',$status)->orderBy('created_at','desc')->paginate(10);
            return view('Admin.User.Show',compact('getOrders','contacts','chats'),['user' =>$user]);
          }
          }else{
              return redirect()->to('/login');
          }
      }

      public function SearchData(Request $request){
            $q = Input::get ( 'q' );
            /// Start user search by Name or email
            $user = User::where('name', 'like', '%'.$q.'%')
                 ->orWhere('email', 'like', '%'.$q.'%')
                 ->orWhere('phone_no', 'like', '%'.$q.'%')
                 ->orderBy('created_at', 'desc')
                 ->paginate(10)->setPath ( '' );
                  $pagination = $user->appends ( array (
                  'q' => Input::get ( 'q' )
                  ) );
                if (count ($user) > 0){ //by user name data view
                      $total_row = $user->total(); //dd($total_row);
                    return view ('Admin.User.Show',compact('total_row','user'))->withQuery ( $q )->withMessage ($total_row.' '. 'User found match your search');
                 }else{ 
                    return view ('Admin.User.Show')->withMessage ( 'User not found match Your search !' );
                 }
        }       

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        return view('Admin.User.Add',compact('getOrders','contacts'));
      }
        }else{
            return redirect()->to('/login');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|string|max:50',
            'email'=>'required|string|email:unique|max:255',
            'password'=> 'required|string|min:6',
        ]);

        $user = User::create($request->all()); 
        Toastr::success('User Add', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/user');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      if(Auth::check()){
    if(Auth::user()->role == "admin"){
        if($id == 1){
            Toastr::error('Admin Can not be edit', 'Error', ["positionClass" => "toast-top-right"]);
                        return back();
        }else{
        $user = User::find($id);
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        return view('Admin.User.Edit',compact('getOrders','contacts'),['user' =>$user]);
        }
      }
  }else{
      return redirect()->to('/login');
  }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = $this->validate(request(),[
                  'name'=>'required|string|max:50',
                  'email' => 'required',
                  'password' => 'string|min:6',
                ]);
        if(!$validate){
          Redirect::back()->withInput();
        }
        $user = User::find($id);
        $data = request(['name','email','phone_no','gender','role']);
        $password = $request->password;
        if($password){
          $data['password'] = Hash::make($password);
        }
        $user->update($data);
        Toastr::success('User Updated', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/user');
    }

    public function changePassGet(){
      if(Auth::check()){
        if(Auth::user()->role == "administrator" || Auth::user()->role == "admin"){
            //$id = Auth::id();
            $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
            $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
            return view('Admin.ChangePassword',compact('getOrders','contacts'));
          }
      }else{
          return redirect()->to('/login');
      }
    }

    public function changePass(Request $request){
        $validate = $this->validate(request(),[
                        'current_password' => 'required',
                        'new_password' => 'required|confirmed|string|min:6',
                    ]);
                 if(!$validate){ 
                  Redirect::back()->withInput();
                }
              $data = $request->all();
              $user = User::find(auth()->user()->id);
              if(!Hash::check($data['current_password'], $user->password)){
                Toastr::error('The specified password does not match the database password', 'Error', ["positionClass" => "toast-top-right"]);
                        return back();
              }else{
                  $password = $request->new_password;
                  $user->update(['password' => Hash::make($password)]);
                 Toastr::success('Password Updated', 'Success', ["positionClass" => "toast-bottom-right"]);
                                     return redirect()->to('/admin');
              }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $User
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
        $user = User::find($id);
        $user->delete();
      Toastr::success('User Deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/admin');
        }
      }
}else{
    return redirect()->to('/login');
}
    }

     public function verifyUser($id){
      if(Auth::check()){
        if(Auth::user()->role == "admin"){
            $user = User::find($id);
            $user->verified = !$user->verified;
            $data['email_token'] = "";
            $user->update($data);
            Toastr::success('User Verified', 'Success', ["positionClass" => "toast-bottom-right"]);
                return back();
          }
        }else{
            return redirect()->to('/login');
        }
        }

    public function verifyMailReminder($id){
      if(Auth::check()){
        if(Auth::user()->role == "admin"){
           $user = User::find($id);
           Mail::to($user->email)->send(new EmailVerification($user));
           Toastr::success('Verify mail reminder sent', 'Success', ["positionClass" => "toast-bottom-right"]);
              return back();
          }
        }else{
            return redirect()->to('/login');
        }
    }
    
    public function enableDisableUser($id){
      if(Auth::check()){
          if(Auth::user()->role == "admin"){
            $user = User::find($id);
            $user->suspend = !$user->suspend;
            $user->save();
            Toastr::success('User Suspend', 'Success', ["positionClass" => "toast-bottom-right"]);
                return back();
          }
      }else{
          return redirect()->to('/login');
      }
        }

    // Web Setting 
    public function settingPage()
    {
      if(Auth::check()){
        if(Auth::user()->role == "admin"){
        $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
        $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
        $id =1;
        $data = Setting::find($id);
        return view('Admin.settings',compact('getOrders','contacts'),['data' =>$data]);
        }
}else{
    return redirect()->to('/login');
}
    }
    public function settingUpdate(Request $request)
    {
        $id =1;
        $setting = Setting::find($id);
        $setting->update($request->all());
        Toastr::success('Updated', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/admin');
    }


    //// Page Setup All function

    public function pageIndex()
    {
      if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $pageSetup = BanerSlide::orderBy('created_at','desc')->paginate(8);
        return view('Admin.PageSetup.Show',['pageSetup' =>$pageSetup]);
      }
    }else{
        return redirect()->to('/login');
    }
    }
    
    public function pageCreate()
    {
      if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $pages = Page::All();
        return view('Admin.PageSetup.Add',['pages' => $pages]);
      }
    }else{
        return redirect()->to('/login');
    }
    }

    public function pageStore(Request $request)
    {
        $validate = $this->validate($request, [
            'page_name' => 'required',
        ]);
        if(!$validate){
            Redirect::back()->withInput();
        }
        $data = request(['title','description','heading','sub_heading','button_text','button_link','page_name']);
        if($request->file('uploadFile')){
            foreach ($request->file('uploadFile') as $key => $value) {

                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                $value->move(public_path('images/banner'), $imageName);
                $data['image'] =$imageName;
            }
        }
        if($request->page_name == "home"){
            $pageSetup = BanerSlide::create($data);
        Toastr::success('Banner Add', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/page-setup/show');
        }else{
          $pageNameCheck = BanerSlide::where('page_name', '=', $request->page_name)->first();
          if($pageNameCheck){
            Toastr::error('Page Banner Already Make', 'Sorry', ["positionClass" => "toast-bottom-right"]);
           return redirect()->back(); 
         }else{
           $pageSetup = BanerSlide::create($data);
            Toastr::success('Banner Add', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/page-setup/show'); 
         }   
        }
        
    }
    public function pageEdit($id)
    {
      if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $pageSetup = BanerSlide::find($id);
        $pages = Page::All();
        return view('Admin.PageSetup.Edit',['pageSetup' =>$pageSetup, 'pages' => $pages]);
      }
}else{
    return redirect()->to('/login');
}
    }
    public function pageUpdate(Request $request, $id)
    {
        $validate = $this->validate($request, [
            'page_name' => 'required',

        ]);
        if(!$validate){
            Redirect::back()->withInput();
        }
        $pageSetup = BanerSlide::find($id);
        $data = request(['title','description','heading','sub_heading','button_text','button_link','page_name']);
        if($request->file('uploadFile')){
            foreach ($request->file('uploadFile') as $key => $value) {

                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                $value->move(public_path('images/banner'), $imageName);
                $data['image'] = $imageName;
            }
            $pageSetup->update($data);
            Toastr::success('Banner updated', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/page-setup/show');
        }else{
            $pageSetup->update($request->all());
            Toastr::success('Banner updated', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/page-setup/show');
        }
 
    }
    public function pageDestroy($id)
    {
      if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $pageSetup = BanerSlide::find($id);
        $pageSetup->delete();
        Toastr::success('Banner Deleted', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->to('/page-setup/show');
        }
}else{
    return redirect()->to('/login');
}
    }

    public function openMySql(){
      if(Auth::check()){
    if(Auth::user()->role == "admin"){
        $tables = DB::select('SHOW TABLES'); //dd($tables);
        return view('Admin.mysql',compact('tables'));
        }
}else{
    return redirect()->to('/login');
}
    }
    
    public function openQueryMySql(Request $request)
    {
      $queryData = $request->all(); 
      $query = $queryData['query']; //dd($query);
      $result = DB::select($query);
      echo "<pre>";
          print_r($result);
      echo "</pre>";
    }

    public function userView($id){
      $user = User::find($id);
      $userAddress = UserAddress::where('user_id',$id)->first();
      return view('Admin.User.View',compact('user','userAddress'));
    }

    public function envData(){
        if(Auth::user()->role == 'admin'){
            return view('Admin.env-file');
        }else{
                return view('login');
            }
     }

     public function changeEnvData(Request $request){
        if(Auth::user()->role == 'admin'){
            $key = $request->key; //"MAIL_FROM_ADDRESS";
            $value = $request->value; //"info@maplelabs.com";
            $this->setEnv($key, $value);
            Toastr::success('Value Changed', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/change-env-file-data');
        }else{
                return view('login');
            }
     }

        private function setEnv($key, $value)
        { 
            //echo env('MAIL_FROM_ADDRESS');
            file_put_contents(app()->environmentFilePath(), str_replace(
                    env($key),
                    $value,
            file_get_contents(app()->environmentFilePath())
            ));
        }

        public function clearCache(){

            \Artisan::call('cache:clear');
            Toastr::success('Cache clear successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/change-env-file-data');
        }

        public function clearConfig(){

            \Artisan::call('config:clear');
            Toastr::success('Config clear successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
            return redirect()->to('/change-env-file-data');
        }


        //// astrologer_payments table data
        public function astrologerPayments(){
          if(Auth::check()){
            if(Auth::user()->role == "admin"){
                $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
                $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
                $chats = Chat::where('message_status','=',"Sent")->get(); //dd($chats);
                $tableData = AstrologerPayment::orderBy('created_at','desc')->paginate(10);
                foreach ($tableData as $table) {
                  $user = User::where('id',$table->user_id)->first(); //dd($user);
                  $table->user = $user ? $user->name : "";
                }
                return view('Admin.Table.astrologer-payments',compact('getOrders','contacts','chats'),['tableData' =>$tableData]);
              }
            }else{
                  return redirect()->to('/login');
            }
        }

        //// member_payments table data
        public function memberPayments(){
          if(Auth::check()){
            if(Auth::user()->role == "admin"){
                $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
                $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
                $chats = Chat::where('message_status','=',"Sent")->get(); //dd($chats);
                $tableData = MemberPayment::orderBy('created_at','desc')->paginate(10);
                foreach ($tableData as $table) {
                  $user = User::where('id',$table->user_id)->first(); //dd($user);
                  $table->user = $user ? $user->name : "";
                }
                return view('Admin.Table.member-payments',compact('getOrders','contacts','chats'),['tableData' =>$tableData]);
              }
            }else{
                  return redirect()->to('/login');
            }
        }

        //// paymentTable table data
        public function paymentTable(){
          if(Auth::check()){
            if(Auth::user()->role == "admin"){
                $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
                $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
                $chats = Chat::where('message_status','=',"Sent")->get(); //dd($chats);
                $tableData = Payment::orderBy('created_at','desc')->paginate(10);
                foreach ($tableData as $table) {
                  $user = User::where('id',$table->user_id)->first(); //dd($user);
                  $table->user = $user ? $user->name : "";
                }
                return view('Admin.Table.payments',compact('getOrders','contacts','chats'),['tableData' =>$tableData]);
              }
            }else{
                  return redirect()->to('/login');
            }
        }

        //// userAddresses table data
        public function userAddresses(){
          if(Auth::check()){
            if(Auth::user()->role == "admin"){
                $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
                $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
                $chats = Chat::where('message_status','=',"Sent")->get(); //dd($chats);
                $tableData = UserAddress::orderBy('created_at','desc')->paginate(10);
                foreach ($tableData as $table) {
                  $user = User::where('id',$table->user_id)->first(); //dd($user);
                  $table->user = $user ? $user->name : "";
                }
                return view('Admin.Table.user_addresses',compact('getOrders','contacts','chats'),['tableData' =>$tableData]);
              }
            }else{
                  return redirect()->to('/login');
            }
        }

        //// userPlans table data
        public function userPlans(){
          if(Auth::check()){
            if(Auth::user()->role == "admin"){
                $getOrders = Order::where('status','=',"Pending")->get(); //dd($getOrders);
                $contacts = Contact::where('status','=',"Pending")->get(); //dd($contacts);
                $chats = Chat::where('message_status','=',"Sent")->get(); //dd($chats);
                $tableData = UserPlan::orderBy('created_at','desc')->paginate(10);
                foreach ($tableData as $table) {
                  $user = User::where('id',$table->user_id)->first(); //dd($user);
                  $table->user = $user ? $user->name : "";
                }
                return view('Admin.Table.user_plans',compact('getOrders','contacts','chats'),['tableData' =>$tableData]);
              }
            }else{
                  return redirect()->to('/login');
            }
        }

        // public function userPlanEdit($id){
        //   $plan = UserPlan::find($id);
        //   return view('Admin.Table.user_plan_edit',compact('plan'));
        // } 

        public function userPlanActive($id){
          $plan = UserPlan::find($id);
          $data['is_activated'] = 1;
          $plan->update($data);
          Toastr::success('User plan active successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
            return back();
        } 

        public function userPlanInActive($id){
          $plan = UserPlan::find($id);
          $data['is_activated'] = 0;
          $plan->update($data);
          Toastr::success('User plan Inactive successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
            return back();
        }

        public function userPaymentMarkSuccess($id){
          $payment = Payment::where('id',$id)->first();
          $data['transaction_status'] = 'Success';
          $payment->update($data);
          Toastr::success('Payment mark successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
            return back();
        }

        public function userPaymentManual($id){
          $payment = Payment::where('id',$id)->first();
          $data['transaction_status'] = 'Success';
          $data['payment_method'] = 'Cash';
          $payment->update($data);
          Toastr::success('Payment manual received successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
            return back();
        }

        public function memberPaymentMarkSuccess($id){
          $payment = MemberPayment::where('id',$id)->first();
          $data['transaction_status'] = 'Success';
          $payment->update($data);
          Toastr::success('Payment mark successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
            return back();
        }

        public function memberPaymentManual($id){
          $payment = MemberPayment::where('id',$id)->first();
          $data['transaction_status'] = 'Success';
          $data['payment_method'] = 'Cash';
          $payment->update($data);
          Toastr::success('Payment manual received successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
            return back();
        }                                   

}