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

    <!-- Daily Rashi Section -->
@foreach($rashi as $todayRashi)
    <section class="daily-rashi-section section-top container">
        <h1 class="section-heading-txt heading-color text-center">आज का राशिफल</h1>
            <div class="today-date">{{ date('l, d/m/Y', strtotime($todayRashi->today_date)) }}</div>
            <p class="rashi-sub-heading">कैसा रहेगा आज का दिन आपके लिए? क्या कहते हैं आज के सितारे?</p>
        <div class="row m-t-30">
            <div class="col-sm-12 col-md-12 col-lg-12">

               <!-- rashi section -->
               <div class="row">
                   <div class="col-auto">
                    <a href="/today-rashifal/mesh">
                       <div class="rashi-box">
                           <div class="rashi-name">मेष</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/vrishabh">
                       <div class="rashi-box">
                           <div class="rashi-name">वृषभ</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/mithun">
                       <div class="rashi-box">
                           <div class="rashi-name">मिथुन</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/kark">
                       <div class="rashi-box">
                           <div class="rashi-name">कर्क</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/simha">
                       <div class="rashi-box">
                           <div class="rashi-name">सिंह</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/kanya">
                       <div class="rashi-box">
                           <div class="rashi-name">कन्या</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/tula">
                       <div class="rashi-box">
                           <div class="rashi-name">तुला</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/vrishchik">
                       <div class="rashi-box">
                           <div class="rashi-name">वृश्चिक</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/dhanu">
                       <div class="rashi-box">
                           <div class="rashi-name">धनु</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/makar">
                       <div class="rashi-box">
                           <div class="rashi-name">मकर</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/kumbh">
                       <div class="rashi-box">
                           <div class="rashi-name">कुंभ</div>
                       </div>
                     </a>
                   </div>
                   <div class="col-auto">
                    <a href="/today-rashifal/meen">
                       <div class="rashi-box">
                           <div class="rashi-name">मीन</div>
                       </div>
                     </a>
                   </div>
               </div> 
               <!-- end rashi section -->
            </div>
           <!--  <div class="col-sm-12 col-md-4 col-lg-3"></div> -->
        </div>
    </section>
@endforeach

    <section class="section-top container">
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
          <div class="card rashi-card">
            <div class="card-header rashi-card-header">
              @if($rashiName == "mesh")
                मेष राशिफल
              @endif

              @if($rashiName =="vrishabh")
              वृषभ राशिफल
              @endif

              @if($rashiName =="mithun")
              मिथुन राशिफल
              @endif

              @if($rashiName =="kark")
              कर्क राशिफल
              @endif

              @if($rashiName =="simha")
              सिंह राशिफल
              @endif

              @if($rashiName =="kanya")
              कन्या राशिफल
              @endif

              @if($rashiName =="tula")
              तुला राशिफल
              @endif

              @if($rashiName =="vrishchik")
              वृश्चिक राशिफल
              @endif

              @if($rashiName =="dhanu")
              धनु राशिफल
              @endif

              @if($rashiName =="makar")
              मकर राशिफल
              @endif

              @if($rashiName =="kumbh")
              कुंभ राशिफल
              @endif

              @if($rashiName =="meen")
              मीन राशिफल
              @endif
            </div>
            <div class="card-body rashi-card-body" style="background-image: url(/public/images/rashi/{{$rashiName}}.png);">
              <p class="card-text">{{$rashiDetail[0]}}</p>
            </div>
            <div class="rashi-card-imge-overlay"></div>
          </div>
        </div>
        <!-- <div class="col-sm-12 col-md-4 col-lg-3"></div> -->
      </div>

    </section>

 @endsection