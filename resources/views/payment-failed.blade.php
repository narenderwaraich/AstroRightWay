@extends('layouts.app')
@section('content') 
	<div class="banner">
	<img src="/public/images/banner/banner_bg.jpg" alt=""/>
	<div class="slider-imge-overlay"></div>
	<div class="caption text-center">
		<div class="container">
			<div class="caption-in">
				<div class="caption-ins">
					<h1>Payment<span>Transaction</span></h1>
					<div class="links"> 
						<a href="#" class="btns slider-btn"><span>Button</span></a> 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container m-t-70">
  <div class="table-title">Payment</div>
  <div class="payment-order-box">
    <p class="description">Sorry payment transaction failed</p>
  </div>
</div>
@endsection