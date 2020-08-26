@extends('layouts.app')
@section('content')
@if(isset($banner))
<div class="banner">
    <img src="{{asset('/public/images/banner/'.$banner->image)}}" alt="{{$banner->heading}}"/>
    <div class="slider-imge-overlay"></div>
    <div class="caption text-center">
        <div class="container">
            @if($banner->heading)
            <div class="caption-in">
                <div class="caption-ins">
                    <h1 class="text-up">{{$banner->heading}}<span>{{$banner->sub_heading}}</span></h1>
                    @if($banner->button_text)
                    <div class="links"> 
                        <a href="{{$banner->button_link}}" class="btns slider-btn"><span>{{$banner->button_text}}</span></a> 
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@else
<div class="m-t-150"></div>
@endif
<section class="login-section">
<div class="windows-firm-Box">
    <div class="top-tile">
        Log In
    </div>
    <div class="windows-form">
        <a href="{{ url('auth/google') }}" style="font-weight: 400;margin-bottom: 30px;box-shadow: unset !important;" class="btn btn-style btn-lg btn-block">
          <strong>Login With Google</strong>
        </a> 
        <form method="POST" action="{{ route('login') }}">
         @csrf
         <label class="dis-none" for="user-email">Email</label>
          <input type="email" placeholder="Email" class="windows-form-input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" id="user-email" required autofocus>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            <label class="dis-none" for="password-field">Password</label>
            <input id="password-field" type="password" placeholder="Password" class="windows-form-input form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                        <span toggle="#password-field" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
            <p style="margin-left:25px"><input class="windows-form-input form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="width:40px; height:20px;"><label for="remember" style="padding-left: 20px;">Remember Me</label>
                <span class="pull-right">
                    @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="forget-password-text">{{ __('Forgotten Password?') }}</a>@endif
    </span>
            </p>
            <button type="submit" class="btn btn-style btn-top" >Submit</button>
            <br>
            <div style="float: left;">Don't have account ? <a href="/register" class="sign-up-link">Register here</a></div>
        </form>
    </div>
</div>
</section>
<script src="/public/jquery/jquery-3.2.1.min.js"></script>
<script>
$(".toggle-password").click(function() {
$(this).toggleClass("fa-eye-slash fa-eye");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
input.attr("type", "text");
} else {
input.attr("type", "password");
}
});
</script>
@endsection
