@extends('layouts.app')
@section('content')
    <div class="banner">
    <img src="/public/images/banner/new-password-banner.png" alt=""/>
    <div class="slider-imge-overlay"></div>
    <div class="caption text-center">
        <div class="container">
            <div class="caption-in">
                <div class="caption-ins">
                    <!-- <h1 class="text-up">Hello<span>Test</span></h1>
                    <div class="links"> 
                        <a href="#" class="btns slider-btn"><span>Button</span></a> 
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>

<section class="login-section">
<div class="windows-firm-Box">
    <div class="top-tile">
        Re-Send Verify E-Mail
    </div>
    <div class="windows-form">
        <form method="POST" action="/request/verifyemail">
         @csrf

          <input id="email" type="email" class="windows-form-input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email }}" required readonly>  
            <button type="submit" class="btn btn-style btn-top" >Re-Send</button>
        </form>
    </div>
</div>
</section>

@endsection