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

  <!-- content page -->
  <section class="bgwhite m-t-70">
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-lg-9 p-b-75">
            <div class="row">
              @foreach ($videos as $videoData)
                <div class="col-sm-10 col-md-6 p-b-30 m-l-r-auto">

                        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{ $videoData->url}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>  

                        <div class="block3-txt p-t-14">
                            <div class="p-b-7 heading-title">
                                    {{ $videoData->title}}
                            </div>

                            <span class="s-text6">By</span> <span class="s-text7">{{ $videoData->auth}}</span>
                            <span class="s-text6">on</span> <span class="s-text7">{{$videoData->created_at->format('j M, Y')}}</span>
                        </div>
                    
                </div>
             @endforeach
            </div>
            {!! $videos->links() !!}
        </div>

        <div class="col-md-4 col-lg-3 p-b-75">
          <div class="rightbar">
  
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
