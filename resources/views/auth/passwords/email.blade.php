@extends('layouts.app')
@section('content')
	<div class="banner">
	<img src="/public/images/banner/password-rest-banner.jpg" alt=""/>
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
    <section class="rest-pass-section">
<div class="windows-firm-Box">
    <div class="top-tile">
        {{ __('Reset Password') }}
    </div>
    <div class="windows-form">
        
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="windows-form-input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-style btn-top">
                                    {{ __('Password Reset') }}
                                </button>
                            </div>
                        </div>
                    </form>

    </div>
</div>
</section>
</div>
@endsection
