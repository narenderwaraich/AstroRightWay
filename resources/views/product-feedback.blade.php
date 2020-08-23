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
<section class="container">
	<div class="row m-t-70">
		<div class="col-md-12">
			<div class="windows-firm-Box" style="margin-top: 0px;">
				<div class="top-tile">
					Feed-Back
				</div>
				<div class="windows-form">
					<form action="/store-review/{{ $order }}" method="post" enctype="multipart/form-data">
						{{ csrf_field() }}
							<h4>Give Rating</h4>
								<div class="stars">
								    <input class="star star-5" id="star-5" type="radio" name="rating" value="5" />
								    <label class="star star-5" for="star-5"></label>
								    <input class="star star-4" id="star-4" type="radio" name="rating" value="4" />
								    <label class="star star-4" for="star-4"></label>
								    <input class="star star-3" id="star-3" type="radio" name="rating" value="3" />
								    <label class="star star-3" for="star-3"></label>
								    <input class="star star-2" id="star-2" type="radio" name="rating" value="2" />
								    <label class="star star-2" for="star-2"></label>
								    <input class="star star-1" id="star-1" type="radio" name="rating" value="1" />
								    <label class="star star-1" for="star-1"></label>
								</div>
					             <div class="form-group">
					             	<textarea name="comment"  value="{{ old('comment') }}"  rows="5" placeholder="Comment" class="form-control windows-form-input" required></textarea>
					             </div>
								<button type="submit" class="btn btn-style itm-center btn-width btn-top">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection