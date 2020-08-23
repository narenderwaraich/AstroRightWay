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
          @foreach($gallery as $item)
          <div class="p-r-50 p-r-0-lg">
            <!-- item blog -->
            <div class="item-blog p-b-20">
              <a href="#" class="item-blog-img pos-relative dis-block hov-img-zoom">
                <img src="{{asset('/public/images/gellery/'.$item->image)}}" alt="{{ $item->title }}">

                <span class="item-blog-date dis-block flex-c-m pos1 size17 bg4 s-text1">
                  {{ date('d/m/Y', strtotime($item->created_at)) }}<!-- 28 Dec, 2018 -->
                </span>
              </a>

              <div class="item-blog-txt p-t-33">
                <div class="p-b-11 heading-title">
                  <a href="#" class="m-text24">
                    {{ $item->title }}
                  </a>
                </div>

                <p class="p-b-12">
                  {{ $item->description }}
                </p>
              </div>
            </div>
          </div>
          @endforeach
              {!! $gallery->links() !!}
        </div>

        <div class="col-md-4 col-lg-3 p-b-75">
          <div class="rightbar">
  
          </div>
        </div>
      </div>
    </div>
  </section>
   <script type="text/javascript" src="/public/jquery/jquery-3.2.1.min.js"></script>
@endsection
