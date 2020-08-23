@extends('layouts.app')

@section('content')
<div class="banner">
    <img src="/public/images/banner/bandwidth-close-up-connection-1148820.jpg" alt=""/>
    <div class="slider-imge-overlay"></div>
    <div class="caption text-center">
        <div class="container">
            <div class="caption-in">
                <div class="caption-ins">
                    <h1>Hello<span>Test</span></h1>
                    <div class="links"> 
                        <a href="#" class="btns slider-btn"><span>Button</span></a> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
