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

<div class="container" style="margin-top: 50px;">
	
    <section class="login-section">
        <div class="windows-firm-Box">
            <div class="top-tile">
                Pay Payment
            </div>
        <div class="windows-form">
            
            <form method="POST" action="/pay/fee">
                @csrf
            <input class="form-control windows-form-input {{ $errors->has('payment') ? ' is-invalid' : '' }}" type="number" name="payment" value="{{$payment}}" placeholder="Enter Payment" readonly>
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