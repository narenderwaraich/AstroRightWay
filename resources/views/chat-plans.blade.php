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

<section class="chat-plan-background-image-style">
  <div class="container-fluid chat-plan-background-opacity-bg">
	    <div class="container">
    		<div class="row chat-plan-list">
    			@foreach ($plans as $plan)
    			<div class="col-md-4" style="margin-top: 30px;">
    				<div class="plan-box @if($plan->id==6) top-plan animation-css @endif">
    					<div class="plan-name"><span>Name</span> <span>{{ $plan->name }}</span></div>
    					<div class="plan-day"><span>Day</span>  <span>{{ $plan->access_day }} day</span> </div>
    					<div class="plan-message"><span>Message</span> <span>{{ $plan->message }}</span> </div>
    					<div class="plan-amount"><span>Amount</span> <span>{{ $plan->amount }} <i class="fa fa-inr" aria-hidden="true"></i></span> </div>
    					<a href="/buy-plan/{{ $plan->id }}"><button type="button" class="btn btn-style btn-top">Buy</button></a>
    				</div>
    			</div>
    			@endforeach
    		</div>
	    </div>
  </div>
</section>
<style type="text/css">
	.footer {
    margin-top: 0px;
	}
	.top-plan{
		background: #000;
		border: 5px solid #ce2350 !important;
	}
	@keyframes blink { 
   50% { border-color: #00C851;
   background-color:  transparent;} 
}
.animation-css{ 
    animation: blink .5s step-end infinite alternate;
}
</style>
@endsection