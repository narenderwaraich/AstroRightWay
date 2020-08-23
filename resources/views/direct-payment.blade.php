@extends('layouts.app')
@section('content') 

<div class="banner">
	<img src="{{asset('/public/images/banner/direct-payment.jpg')}}" alt="Payment Banner"/>
	<div class="slider-imge-overlay"></div>
	<div class="caption text-center">
		<div class="container">
			<div class="caption-in">
				<div class="caption-ins">
					<h1 class="text-up">Pay Payment<span>Direct Pay with AstroRightWay</span></h1>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container" style="margin-top: 50px;">
	
    <section class="login-section">
        <div class="windows-firm-Box">
            <div class="top-tile">
                Pay Payment
            </div>
        <div class="windows-form">
            
            <form method="POST" action="/pay/payment">
                @csrf
              <input  name="name" placeholder="Name" class="form-control windows-form-input {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{old('name') }}" required="required" type="text">
                  @if ($errors->has('name'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
                  @endif
              <input id="email" name="email" placeholder="Email" class="form-control windows-form-input{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{old('email') }}" required="required" type="text">
                  @if ($errors->has('email'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                  </span>
                  @endif
             <input type="number" class="form-control windows-form-input {{ $errors->has('phone_no') ? ' is-invalid' : '' }}" name="phone_no" value="{{old('phone_no') }}" id="mobile" placeholder="Mobile Number">
                  @if ($errors->has('phone_no'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('phone_no') }}</strong>
                  </span>
                  @endif
            <input class="form-control windows-form-input {{ $errors->has('payment') ? ' is-invalid' : '' }}" type="number" name="payment" value="{{old('payment')}}" placeholder="Enter Payment">
				@if ($errors->has('payment'))
	                <span class="invalid-feedback" role="alert">
	                   <strong>{{ $errors->first('payment') }}</strong>
	                </span>
                 @endif
            
            <button type="submit" class="btn btn-style btn-top" >Pay Now</button>
        </form>
        
            </div>
        </div>
    </section>
    </div>
@endsection