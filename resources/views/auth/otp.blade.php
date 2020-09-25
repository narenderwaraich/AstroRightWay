@extends('layouts.app')
@section('content')
<div class="banner">
    <img src="/public/images/banner/15829702470.jpg" alt="Contact Us">
    <div class="slider-imge-overlay"></div>
    <div class="caption text-center">
        <div class="container">
            <div class="caption-in">
                <div class="caption-ins">
                    <h1 class="text-up">Verify Account<span></span></h1>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="login-section">
<div class="windows-firm-Box">
    <div class="top-tile">
        Enter Verification Code
    </div>
    <div class="windows-form">
        <form method="POST" action="/verify-Otp">
         @csrf
            <p>Check your email id in Verification code.</p>
            <input name="email" type="hidden" value="{{$user->email}}">
            <input id="partitioned" name="otp" type="text" maxlength="6" />
            <div><a href="/resend-Otp/{{$user->id}}" class="sign-up-link">Resend Otp</a></div>
            <button type="submit" class="btn btn-style btn-top">Verify</button>
            <br>
        </form>
    </div>
</div>
</section>

<style>
#partitioned {
    margin: auto;
    display: block;
    text-align: center;
    padding-left: 14px;
    letter-spacing: 41px;
    border: 0;
    background-image: linear-gradient(to left, #ce2350 70%, rgba(255, 255, 255, 0) 0%);
    background-position: bottom;
    background-size: 50px 1px;
    background-repeat: repeat-x;
    background-position-x: 35px;
    width: 285px;
    margin-top: 30px;
}
input:focus {
    outline: none;
    border: 0;
     }
input::placeholder {
  color: #ce2350;
}
.sign-up-link{
    color: #ce2350;
    text-align: center;
    display: block;
    margin: auto;
    margin-top: 15px;
}
</style>

@endsection