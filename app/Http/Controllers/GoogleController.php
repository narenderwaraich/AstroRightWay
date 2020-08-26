<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use Auth;
use Exception;
use App\User;
use Toastr;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
      
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
    
            $user = Socialite::driver('google')->user(); //dd($user);
            /// find user create by google
            $finduser = User::where('google_id', $user->id)->first();
            /// user login with google
            $exitUser = User::where('email', $user->email)->first();

            if($exitUser){
                $data[''] = $user->id;
                $exitUser->update($data);
                Auth::login($exitUser);
    
                return redirect('/');
            }
     
            if($finduser){
     
                Auth::login($finduser);
    
                return redirect('/');
     
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => encrypt('password'),
                    'verified' => 1
                ]);
    
                Auth::login($newUser);
     
                return redirect('/');
            }
    
        } catch (Exception $e) {
            //dd($e->getMessage());
            Toastr::error($e->getMessage(), 'Error', ["positionClass" => "toast-top-right"]);
             return redirect()->to('/');
        }
    }
}
