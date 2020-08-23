<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered; 
use Illuminate\Http\Request;
use App\Jobs\SendVerificationEmail; 
use Toastr;
use Mail;
use App\Mail\EmailVerification;
use App\Mail\UserNotification;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'phone_no' => ['string', 'min:10', 'max:10'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_no' => $data['phone_no'],
            'gender' => $data['gender'],
            // 'date' => $data['date'],
            'password' => Hash::make($data['password']),
            'email_token' => base64_encode($data['email']),
            'otp' => rand(100000, 999999)
        ]);

        // $user->sendEmailVerificationNotification();

        // Toastr::success('Thank you for Signing up! We have sent you confirmation email, Please Check and activate your account.', 'Success', ["positionClass" => "toast-top-right"]);
        // return $user;
    }

    /**
            * Handle a registration request for the application.
            *
            * @param \Illuminate\Http\Request $request
            * @return \Illuminate\Http\Response
            */
            public function register(Request $request)
            {
                $this->validator($request->all())->validate();
                // event(new Registered($user = $this->create($request->all())));
                // $otp = rand(100000, 999999);
                //dispatch(new SendVerificationEmail($user));
                $user = $this->create($request->all());
                /// send amin new user notification
                $userEmail = $request->email;
                Mail::to($userEmail)->send(new EmailVerification($user));
                $adminMail = "singh4narender@gmail.com";
                Mail::to($adminMail)->send(new UserNotification($user));
                Toastr::success('Thank you for Registration. Please check in your mail enter verify code', 'Success', ["positionClass" => "toast-top-right"]);
                //return redirect()->to('/');
                return view('auth.otp',compact('user'));

            }
            /**
            * Handle a registration request for the application.
            *
            * @param $token
            * @return \Illuminate\Http\Response
            */
            public function verify($token)
            {
                $user = User::where('email_token',$token)->first();
                $user->verified = 1;
                if($user->save()){
                Toastr::success('Email is successfully verified login Now', 'Success', ["positionClass" => "toast-top-right"]);
                return redirect()->to('/login');
                }
            }
            
            public function verifyOtp(Request $request)
            {
                $email = $request->email;
                $otp = $request->otp; //dd($otp);
                $user = User::where('email',$email)->first();
                if($user->otp == $otp){
                    $user->verified = 1;
                    $user->otp = "";
                    $user->save();
                  Toastr::success('Account verified successfully login Now', 'Success', ["positionClass" => "toast-top-right"]);
                return redirect()->to('/login');
                }else{
                    Toastr::error('otp code not match', 'Error', ["positionClass" => "toast-top-right"]);
                    return view('auth.otp',compact('user'));
                }
            }
            
            public function resendOtp($id){
                $otp = rand(100000, 999999);
                $user = User::where('id',$id)->first();
                if($user){
                    $code['otp'] = $otp;
                    $user->update($code); 
                    $userEmail = $user->email;
                    Mail::to($userEmail)->send(new EmailVerification($user));
                   Toastr::success('OTP Resend check email', 'Success', ["positionClass" => "toast-top-right"]);
                    return view('auth.otp',compact('user'));
                }else{
                    Error::success('OTP not Resend', 'Error', ["positionClass" => "toast-top-right"]);
                    return back();
                }
            }
}
