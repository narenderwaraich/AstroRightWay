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

<div class="container">

<section class="about-sec1 section-top">
      <div class="row">
        <div class="col-md-6 text-center">
          <img src="/public/images/section/about-us-img.jpg" alt="Pandit" class="icon-img2">
        </div>
        <div class="col-md-6 pad-in-section">
          <div class="heading-title heading-text heading-color">Know About AstroRightWay</div>
          <br>
          <p><strong>|| हरि ॐ नमो वासुदेवाय ||</strong>
            <br><br>
            <b>We Offer Services</b>
            <br>
            We offer services to help our users to gain insight into their past, present and future and remedies to prevent and cure problems.
          </p>
        </div>
      </div>  
    </section>


    <section class="about-sec2 section-top section-bottom">
      <div class="row">
        <div class="col-md-6 col-md-pull-6 pad-in-section">
          <div class="heading-title heading-text heading-color">Services of AstroRightWay</div>
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
        <div class="col-md-6 col-md-push-6 text-center">
         <img src="/public/images/section/section2.jpg" alt="services" class="icon-img2 on-mob-top-30">
        </div>
      </div>  
    </section>
</div>
@endsection
