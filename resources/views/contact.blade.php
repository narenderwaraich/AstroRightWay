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
<div class="container" style="margin-top: 100px;">
	<div class="heading-title contact-heading" style="text-align: center;">Get In Touch</div>
	<p class="contact-sub-heading">We would be happy to help you. You can contact us ..</p>
</div>

    <section class="login-section">
        <div class="windows-firm-Box" style="margin-top: 50px;">
            <div class="top-tile">
                Contact Us
            </div>
        <div class="windows-form">
            
            <form method="POST" action="/contactUs">
                @csrf
            <div class="form-group">
            	<label class="dis-none" for="full-name">Name</label>
            	<input class="form-control windows-form-input {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" value="{{old('name')}}" placeholder="Name" id="full-name">
				@if ($errors->has('name'))
	                <span class="invalid-feedback" role="alert">
	                   <strong>{{ $errors->first('name') }}</strong>
	                </span>
                 @endif
            </div>
            <div class="form-group">
            	<label class="dis-none" for="mob-no">Mobile</label>
            	<input class="form-control windows-form-input {{ $errors->has('phone_number') ? ' is-invalid' : '' }}" type="number" name="phone_number" value="{{old('phone_number')}}" placeholder="Mobile" id="mob-no">
				@if ($errors->has('phone_number'))
	                <span class="invalid-feedback" role="alert">
	                   <strong>{{ $errors->first('phone_number') }}</strong>
	                </span>
                 @endif
            </div>
             <div class="form-group">
             	<label class="dis-none" for="email-address">Email</label>
            	<input class="form-control windows-form-input {{ $errors->has('email') ? ' is-invalid' : '' }}" type="text" name="email" value="{{old('email')}}" placeholder="Email" id="email-address">
							@if ($errors->has('email'))
	                          <span class="invalid-feedback" role="alert">
	                              <strong>{{ $errors->first('email') }}</strong>
	                          </span>
	                    	@endif
             </div>
            
	         <div class="form-group">
	         	<label class="dis-none" for="query">Message</label>
	       		<textarea class="form-control windows-form-input {{ $errors->has('message') ? ' is-invalid' : '' }}" name="message" placeholder="Message" id="query"></textarea>
	            @if ($errors->has('message'))
	               <span class="invalid-feedback" role="alert">
	                   <strong>{{ $errors->first('message') }}</strong>
	               </span>
	           @endif
	         </div>
            <button type="submit" class="btn btn-style btn-top" >Send</button>
        </form>
        
            </div>
        </div>
    </section>
@endsection