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
<div class="container m-t-70">
    <div class="table-title">All Order Items</div>
               
          <table id="bootstrap-data-table" class="table table-responsive table-striped table-bordered">
            <thead>
              <tr>
                <th class="on-mob-hide">Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price</th>
              </tr>
            </thead>
            <tbody>  
             @foreach ($orderItem as $item)
        <tr class="clickable-row" data-href='/product-details/{{$item->product_id}}' style="cursor: pointer;">
        <td class="on-mob-hide"><img src="/public/images/products/{{$item->image}}" style="width: 100px; height: 100px; border-radius: 50%;"></td>
        <td>{{ $item->product_name}}</td>
        <td>{{ $item->description }}</td>
        <td>{{ $item->qty }}</td>
        <td>{{ $item->price}} </td>
      </tr>
    </tbody>
                    
    @endforeach
    </table>               
</div>
<script>
    jQuery(document).ready(function($) {
        $(".clickable-row").click(function(e) {
          if(e.target.tagName != 'A'){
            window.location = $(this).data("href");
          }
        });
    });
</script>
@endsection