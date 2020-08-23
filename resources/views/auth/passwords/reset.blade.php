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

<div class="container">
    
<section class="rest-password-section">
<div class="windows-firm-Box">
    <div class="top-tile">
       {{ __('Reset Password') }}
    </div>
    <div class="windows-form">
         <form method="POST" action="{{ route('password.update') }}">
            @csrf
            
             <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="windows-form-input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="windows-form-input form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="windows-form-input form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-12 ">
                                <button type="submit" class="btn btn-style btn-top">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
 
            </div>
        </div>
    </section>
 </div>  
@endsection
