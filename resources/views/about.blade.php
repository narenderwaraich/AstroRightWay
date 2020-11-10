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
@if(isset($aboutSection))
@if($aboutSection->section == "about-main")
<section class="about-sec1 section-top">
      <div class="row">
        @if($aboutSection->bg_img)
        <div class="col-md-6 text-center">
          <img src="/public/images/bg/{{$aboutSection->bg_img}}" alt="Pandit" class="icon-img2">
        </div>
        @endif
        @if($aboutSection->section_heading)
        <div class="col-md-6 pad-in-section">
          <div class="heading-title heading-text heading-color">{{$aboutSection->section_heading}}</div>
          <br>
          <p>@if($aboutSection->section_sub_heading)<strong>{{$aboutSection->section_sub_heading}}</strong>
          @endif
          @if($aboutSection->section_content)
            <br><br>
            {{$aboutSection->section_content}}
            @endif
          </p>
        </div>
        @endif
      </div>  
    </section>
    @endif
    @endif
    @if(isset($aboutServiceSection))
    @if($aboutServiceSection->section == "about-services")
    <section class="about-sec2 section-top section-bottom">
      <div class="row">
        @if($aboutServiceSection->section_heading)
        <div class="col-md-6 col-md-pull-6 pad-in-section">
          <div class="heading-title heading-text heading-color">{{$aboutServiceSection->section_heading}}</div>
          @if($aboutServiceSection->section_sub_heading)
          <br>
          <b>{{$aboutServiceSection->section_sub_heading}}</b>
          @endif
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
        @endif
        @if($aboutServiceSection->bg_img)
        <div class="col-md-6 col-md-push-6 text-center">
         <img src="/public/images/bg/{{$aboutServiceSection->bg_img}}" alt="services" class="icon-img2 on-mob-top-30">
        </div>
        @endif
      </div>  
    </section>
    @endif
    @endif
</div>
@endsection
