@extends('layouts.app')
@section('content')

@if(isset($banner->image))
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

<div class="container privacy-section m-t-70">

	<div class="heading-title">AstroRightWay</div>
	<br>
	<p>We are Sale astrology & vastu products like ruby and rudraksh etc. our astrology store.
	</p>
	<br>

	<div class="heading-title">Privacy Policy</div>
	<br>
	<strong>When do we collect information?</strong>
	<p>We collect data from you when you register on our site, place an order, subscribe to website, fill out a form</p>
	<br>
	<strong>We Collect information on user Register time.</strong>
	<ul class="store-info-list">
		<li>Name</li>
		<li>Email</li>
	</ul>
	<br>
	<p>Additionally, birth and gender information submitted to us through profile updated.</p>
	<br>
	<strong>We Collect information on order time.</strong>
	<ul class="store-info-list">
		<li>Phone Number</li>
		<li>Country</li>
		<li>State</li>
		<li>City</li>
		<li>ZipCode</li>
		<li>Address</li>
	</ul>

	<br>
	<strong>Note:</strong> 
	<p>Email addresses are kept private and never used for mailing lists.
	All information use order shiping on user address purpose.</p>
	<br><br>
	<strong>Contacting Us</strong>
	<br>
	<p>If there are any doubts in privacy policy, you may contact on <a href="mailto:info@astrorightway.com">info@astrorightway.com</a></p>

</div>
@endsection