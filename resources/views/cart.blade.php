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

@if(!empty($storage))
  <!-- Cart -->
  <section class="cart bgwhite m-t-70">
    <div class="container">
      <!-- Cart item -->
      <div class="container-table-cart pos-relative">
        <div class="wrap-table-shopping-cart bgwhite">
          <table class="table-shopping-cart">
            <tr class="table-head">
              <th class="column-1">Image</th>
              <th class="column-2">Product</th>
              <th class="column-3">Price</th>
              <th class="column-4 p-l-25 p-l-0-mob">Quantity</th>
              <th class="column-5">Total</th>
              <th class="column-6">Action</th>
            </tr>
            <?php $i = 0 ?>
            @foreach($storage as $cart)
            
            <tr class="table-row UpdateId" id="tr_{{$cart->id}}" data-id="{{$cart->id}}">
              <form action="/cart/update/{{$cart->id}}" method="post" id="updateForm">
                {{ csrf_field() }}
              <td class="column-1">
                <div class="cart-img-product b-rad-4 o-f-hidden view-item" DataId="{{$cart->product_id}}">
                  <img src="{{asset('/public/images/products/'.$cart->image)}}" alt="{{$cart->product_name}}">
                </div>
              </td>
              <td class="column-2">{{$cart->product_name}}</td>
              <td class="column-3">₹{{$cart->price}}</td>
              <input type="hidden" name="" value="{{$cart->price}}" id="rate{{ $i}}">
              <td class="column-4">
                <div class="flex-w of-hidden">
                  <!-- <button class="btn-num-product-down color1 flex-c-m size7 bg8 eff2">
                    <i class="fs-12 fa fa-minus" aria-hidden="true"></i>
                  </button> -->

                  <input class="qty-input t-center" type="number" name="quantity" id="qty{{ $i}}" value="{{$cart->qty}}" onkeyup="calc(this,  {{$i}})" style="border: 2px solid #ce2350 !important;">

                  <!-- <button class="btn-num-product-up color1 flex-c-m size7 bg8 eff2">
                    <i class="fs-12 fa fa-plus" aria-hidden="true"></i>
                  </button> -->
                </div>
              </td>
              <td class="column-5" >₹<span><input type="text" name="" id="total{{ $i}}" value="{{$cart->subtotal}}" style="border:none;width: 100px;" class="tot"></span>
              </td>
              <td class="column-6">
                <button type="submit" class="btn btn-primary">Update</button>
                      <a class="btn btn-danger" href="/cart/deleteItem/{{$cart->id}}">Remove</a>
              </td>
              <input type="hidden" name="" id="discount_per" value="{{$cart->discount_percentage}}">
              <input type="hidden" name="" id="discount_coupan" value="{{$cart->coupan_code}}">
              </form>
            </tr>
            <?php $i++ ?>
            @endforeach
          </table>
        </div>
      </div>
<!-- Start cart totals or address section -->

<br><br><br>
<div class="card-warp">
        <div class="row">
          <div class="col-md-4">
            <div class="shipping-info">
              <h4>Shipping Address</h4>
              <div class="shipping-chooes">
                <div class="sc-item">
                  <label>Country<span>@if(empty($userAddress->country))  @else {{$userAddress->country}} @endif</span></label>
                </div>
                <div class="sc-item">
                  <label>State<span>@if(empty($userAddress->state))  @else {{$userAddress->state}} @endif</span></label>
                </div>
                <div class="sc-item">
                  <label>City<span>@if(empty($userAddress->city))  @else {{$userAddress->city}} @endif</span></label>
                </div>
                <div class="sc-item">
                  <label>ZipCode<span>@if(empty($userAddress->zipcode))  @else {{$userAddress->zipcode}} @endif</span></label>
                </div>
                <div class="sc-item">
                  <label>Address<span>@if(empty($userAddress->address))  @else {{$userAddress->address}} @endif</span></label>
                </div>
              </div>
              <h4 style="margin-bottom: 0px;">Cupon code</h4>
              <p>Enter your cupone code</p>
            <form method="post" action="/coupan-apply" class="coupan-form">
              {{ csrf_field() }}
              <div class="cupon-input">
                <input type="text" class="form-control{{ $errors->has('coupon_code') ? ' is-invalid' : '' }} coupan-input" name="coupon_code" value="{{ old('coupon_code') }}" placeholder="Coupon Code" id="coupan_input">
                  @if ($errors->has('coupon_code'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('coupon_code') }}</strong>
                  </span>
                  @endif
                <button type="submit" class="site-btn">Apply</button>
              </div>
            </form>
            </div>
          </div>
          <div class="col-md-2"></div>
          <div class="col-md-6">
            <div class="cart-total-details">
              <h4>Cart total</h4>
              <ul class="cart-total-card">
                <li>Subtotal<span>₹<input type="text" name="subtotal"  value="" id="subtotal" readonly style="border:none; width: 100px;"></span></li>
                <li>Shipping<span>₹<input type="text" name=""  value="" id="shipCharge" readonly style="border:none; width: 100px;"></span></li>
                <li class="discount-field" style="display: none;">Discount <!-- <b style="font-size: 10px;color: #ce2350;">()</b> --> <span class="discount-price">-₹<input type="text" name="discount"  value="0" id="net_discount" readonly style="border:none; width: 100px;color: #CA0B00;"></span>
                </li>
                <li class="total">Total<span>₹<input type="text" name="net_amount"  value="" id="net_amount" readonly style="border:none; color: #ce2350;font-weight: 600; width: 100px;background: transparent;"></span></li>
                <li class="cart-payment-method">
                  <div class="form-check-inline">
        <label class="form-check-label radio-btn-labl">
          <input type="radio" class="form-check-input radio-btn-input" name="method" id="cashMethod">Cash
        </label>
      </div>
      <div class="form-check-inline">
        <label class="form-check-label radio-btn-labl">
          <input type="radio" class="form-check-input radio-btn-input" name="method" id="paytmMethod">Paytm
        </label>
      </div>
                </li>
              </ul>
              <button class="site-btn btn-full" type="button" id="checkOut">Proceed to checkout</button>
            </div>
          </div>
        </div>
    </div>


<input type="hidden" name="ship_charge" id="delviryCharge" value="{{$setting->ship_charge}}">


<!-- end cart totals or address section -->

    </div>
  </section>
  @else
  <div style="text-align: center; margin-top: 50px;">Cart is empty!</div>
  @endif
  <script> 
    // Submit Form
    $('#checkOut').on('click', function(){
      //$('#checkOutForm').submit();
      var payment = document.getElementById("net_amount").value;
      if($("#paytmMethod").prop('checked')){
        window.location.href = '/paytm/'+payment+'/pay';
        // $('.coupan-form').show();
      }else{
        window.location.href = '/cash/'+payment+'/pay';
      }
      
    });

      $('.view-item').on('click', function(){
              var product_id = $(this).attr("DataId");
              window.location.href = '/product-details/'+product_id;
            });
          

       $('#paytmMethod').on('click', function(){
          // $('.coupan-form').show();
          // $('#coupan_input').attr('readonly');
       });

       $('#cashMethod').on('click', function(){
          // $('.coupan-form').hide();
       });

</script>

<script> 
      $('.update-item').on('click', function(e){
              var product_id = $('.UpdateId').attr('data-id');
              var qty = document.getElementById("qty").value;
              $.ajax({
                        dataType: 'json',
                  url: "update-cart",
                    method : 'post',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {id:product_id, quantity:qty},
                  success: function (data) {
                  alert('success');
                  location.reload();
                  },
                  error: function (data) {
                  console.log('Error:', data);
                  }
                    });

            });
          

</script>

<script type="text/javascript">
          //// Calculation form
                    var rate = 0;
                    var qty = 0;
                    var itemTotal = 0;
                    function calc(obj, i) {
                        var e = obj.id.toString();
                        e = e.slice(0, -1);

                        if (e == 'rate') {
                            rate = Number(obj.value);
                            qty = Number(document.getElementById('qty'+i).value);
                        } else {
                            rate = Number(document.getElementById('rate'+i).value);
                            qty = Number(obj.value);
                        }
                        itemTotal = rate * qty;
                        var netTotal = itemTotal.toFixed(2);
                        document.getElementById('total'+i).value = netTotal;
                         
                        myFunction();   
                    }

                      //// Discount nd tax
                          var total = 0;
                          var net = 0;
                          var dilvCharg = 0;
                        var nowAmount = 0;
                        
                   
                    function myFunction() {
                        var itemTotals = $(".tot");
                        console.log(itemTotals);
                                var subTotal = 0;
                                for(var i= 0; i < itemTotals.length; i++){
                                  subTotal += Number(itemTotals[i].value);
                                }
                                var nowTotal = subTotal.toFixed(2);
                                $("#subtotal").val(nowTotal); 
                              
                              var dilvCharg = document.getElementById("delviryCharge").value;
                              var total = document.getElementById("subtotal").value;

                                 net = parseFloat(total) + parseFloat(dilvCharg); 
                                 nowAmount = net.toFixed(2);
                                document.getElementById('shipCharge').value = dilvCharg; //total discount
                                document.getElementById('net_amount').value = nowAmount; /// subtotal - discount + tax = Total
                              

                          }


                          $(document).ready(function myFunction() {
                        var itemTotals = $(".tot");
                                var subTotal = 0;
                                for(var i= 0; i < itemTotals.length; i++){
                                  subTotal += Number(itemTotals[i].value);
                                }
                                var nowTotal = subTotal.toFixed(2);
                                $("#subtotal").val(nowTotal); 

                                var discount = 0;

                              var dilvCharg = document.getElementById("delviryCharge").value;
                              var total = document.getElementById("subtotal").value;
                              var discount = document.getElementById("discount_per").value;
       
                                 net = parseFloat(total) + parseFloat(dilvCharg); 
                                 nowAmount = net.toFixed(2);
                                document.getElementById('shipCharge').value = dilvCharg; //total discount
                                getDiscount = nowAmount * discount / 100;
                                document.getElementById('net_discount').value = getDiscount;
                                netTotalAmount = nowAmount - getDiscount;
                                nowAmount = netTotalAmount.toFixed(2);
                                document.getElementById('net_amount').value = nowAmount; /// subtotal - discount + tax = Total
                                var discountCode = document.getElementById("discount_coupan").value;
                                if(discountCode != ""){
                                  $('.discount-field').show();
                                }else{
                                  $('.discount-field').hide();
                                }
                          });

</script>
@endsection
