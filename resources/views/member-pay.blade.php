@extends('layouts.app')
@section('content') 

<div class="banner">
	<img src="{{asset('/public/images/banner/direct-payment.jpg')}}" alt="Payment Banner"/>
	<div class="slider-imge-overlay"></div>
	<div class="caption text-center">
		<div class="container">
			<div class="caption-in">
				<div class="caption-ins">
					<h1 class="text-up">Pay Payment<span>Join Our Plan</span></h1>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container" style="margin-top: 50px;">
	<h3 class="contact-heading">Payment</h3>
	<p class="contact-sub-heading">Your Member Fee Pending Please Pay Now</p>
	<div class="plan-box top-plan">
		<div class="plan-name"><span>Name</span> <span>Help Plan</span></div>
		<div class="plan-day"><span>Day</span>  <span>30 day</span> </div>
		<div class="plan-message"><span>Message</span> <span>500</span> </div>
		<div class="plan-amount"><span>Amount</span> <span>101 <i class="fa fa-inr" aria-hidden="true"></i></span> </div>
	</div>
    <section class="login-section">
        <div class="windows-firm-Box" style="margin-top: 30px;">
            <div class="top-tile">
                Pay Payment
            </div>
        <div class="windows-form">
            
            <form method="POST" action="/join-member/payment">
                @csrf
            <input class="form-control windows-form-input {{ $errors->has('payment') ? ' is-invalid' : '' }}" type="number" name="payment" value="101" placeholder="Enter Payment" readonly>
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
<style type="text/css">
	.top-plan {
    margin: auto;
    text-align: left;
    width: 420px;
    height: 180px;
    padding: 40px;
    background: #000;
    color: #fff;
    border: 2px solid #ce2350 !important;
    margin-top: 30px;
}
.plan-box span {
    width: 50%;
    float: left;
}
</style>
@endsection