<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Auth;
use Hash;
use App\User;
use App\CartStorage;
use Redirect;
use Toastr;
use App\BanerSlide;
use Mail;
use App\Mail\EmailVerification;


class SessionController extends Controller
{
    public function loginView(){
        if(Auth::check()){
            return redirect()->to('/');
        }else{
        $banner = BanerSlide::where('page_name','=','login')->first(); //dd($banner);
        if (isset($banner)) {
            $title = $banner->title;
            $description = $banner->description;
        }
        return view('auth.login',compact('title','description'),['banner' =>$banner]);
        }
    }
    public function loginId(Request $request)
    {
        $remember = (Input::has('remember')) ? true : false;
        $data = [
        'email' => $request['email'],
        'password' => $request['password'],
        ];
            $email = $request['email'];
            $userFind = User::where('email', '=', $email)->count() > 0; 
            if (!$userFind) {
                Toastr::error('Sorry this email not exists!', 'Error', ["positionClass" => "toast-top-right"]);
                return back()->withInput();
            }
            $userSelect = User::where('email', '=', $email)->first();
            if(!$userSelect->verified == 'true'){
            Toastr::error('Your account is not verified! Please check in your mail click on verify button', 'Error', ["positionClass" => "toast-top-right"]);
             //return back()->withInput();
            return view('auth.resend-verified-mail',compact('email'));
        }   
            if (!Auth::attempt($data,$remember)) {
            Toastr::error('The email or password is incorrect, please try again', 'Error', ["positionClass" => "toast-top-right"]);
            return back()->withInput();
            
        }
         $userSuspend = User::where('email', '=', $email)->first();
            if($userSuspend->suspend == 1){ // check account Suspend or not 
              Toastr::warning('Your Account is suspend please contact Admin AstroRightWay at info@astrorightway.com', 'Account Suspend', ["positionClass" => "toast-top-right"]);
            return back()->withInput();
            }
            
     if(Auth::user()->role == 'admin' || Auth::user()->role == 'administrator')
        {
            return redirect()->to('/admin');
        }elseif (Auth::user()->role == 'astrologer') {
            return redirect()->to('/astrologer/dashboard');
        }else

        {
            $checkCart = CartStorage::where('user_id',Auth::id())->first();
            if($checkCart){
                CartStorage::where('user_id',Auth::id())->delete();
            }
            return back();
        }
 
    }
    public function destroy(){
        auth()->logout();
        return redirect()->to('/login');

    }

    public function resendVerifyMail(Request $request){
        $mail = $request->email;
        $user = User::where('email',$mail)->first();
        Mail::to($mail)->send(new EmailVerification($user));
        Toastr::success('Verified email send agian!', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->to('/login');
    }

}
