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
    <div class="table-title">My Orders</div>
               
          <table id="bootstrap-data-table" class="table table-responsive table-striped table-bordered">
            <thead>
              <tr>
                <th>Order Id</th>
                <th>Method</th>
                 <th>Subtotal</th>
                 <th>Shiping</th>
                 <th>Discount</th>
                 <th>Total</th>
                 <th>Amount</th>
                 <th>Status</th>
                 <th width="290px">Action</th>
              </tr>
            </thead>
            <tbody>
             @foreach ($Orders as $order)
        <tr class="clickable-row" data-href='/order-details/{{$order->id}}' style="cursor: pointer;">
        <td>{{ $order->order_number}}</td>
        <td>{{ $order->method}} </td>  
        <td>{{ $order->subtotal}}</td>
        <td>{{ $order->ship_charge}}</td>
        <td>{{ $order->discount}}</td>
        <td>{{ $order->total }}</td>
        <td>{{ $order->net_amount }}</td>
        <td>{{ $order->status }}</td>
        <td class="btn-td">
            @if($order->status == 'Pending' || $order->status == 'Process')
            <a class="btn btn-danger" href="/cancel-order/{{$order->id}}">
                 Cancel</a>
            @endif
            @if($order->status == 'Accept')
            <a class="btn btn-success disabled" href="#">
                 In Process</a>
            @endif
            @if($order->status == 'Dispatch')
            <a class="btn btn-info" href="/orders/track/{{$order->id}}">
                 Track</a>
            @endif
            @if($order->status == 'Complete')
            <a class="btn btn-warning" href="/feed-back/{{$order->id}}">
            Feedback</a>
            @endif
            @if($order->status == 'Cancel')
            <a class="btn btn-danger disabled" href="#">
                 Cancel</a>
            @endif
           <!-- @if($order->status == 'Close')
            <a class="btn btn-dark" href="/product-details/{{$order->id}}">
                 Reorder</a>
            @endif -->
        </td> 
      </tr>
    </tbody>
                    
    @endforeach
    </table>
     {!! $Orders->links() !!}                   
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