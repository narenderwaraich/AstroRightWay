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

<div class="container m-t-70">
	<div class="term-section">
          <div class="heading-title heading-text heading-color">Our Services</div>
          <br>
          <b>We Offer Services</b>
          <br>
          <ul class="service-list">
            <li>Get your love back</li>
            <li>Love marriage specialist</li>
            <li>Love Problem</li>
            <li>Court Case Problem</li>
            <li>Relationship Problem</li>
            <li>Love Issue</li>
            <li>Manglik Dosh</li>
            <li>Family Problem</li>
            <li>Children Problem</li>
            <li>Kundli Matching Services</li>
            <li>Husband Wife Disputes</li>
          </ul>
     </div>
<br><br>
     <div class="term-section">
          <div class="heading-title heading-text heading-color">Our Term & Condtions</div>
          <br>
          <ul class="service-list">
            <li>No Replacement</li>
            <li>If your order Dispatch never cancel you order. no any refund</li>
            <li>If your Payment dedcuted or no place order then you contact us. full support you or refund youar payment</li>
            <li>If you place any fake order then Suspend youar account by Admin</li>
            <li>Kindly contact us at <a href="mailto:info@astrorightway.com">info@astrorightway.com</a> , in case you have any queries</li>
          </ul>
     </div>

</div>
@endsection
