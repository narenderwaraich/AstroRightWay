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

	<!-- Product Detail -->
	<div class="container bgwhite m-t-70">
		<div class="flex-w flex-sb">
			<div class="w-size13 p-t-30 respon5">
				<div class="wrap-slick3 flex-sb flex-w">
					<div class="wrap-slick3-dots"></div>

					<div class="slick3">
						<div class="item-slick3" data-thumb="{{asset('/public/images/products/'.$productData->image)}}">
							<div class="wrap-pic-w">
								<img src="{{asset('/public/images/products/'.$productData->image)}}" alt="{{$productData->name}}">
							</div>
						</div>
						@if(!empty($productData->image1))
						<div class="item-slick3" data-thumb="{{asset('/public/images/products/'.$productData->image1)}}">
							<div class="wrap-pic-w">
								<img src="{{asset('/public/images/products/'.$productData->image1)}}" alt="{{$productData->name}} - 1">
							</div>
						</div>
						@endif

						@if(!empty($productData->image2))
						<div class="item-slick3" data-thumb="{{asset('/public/images/products/'.$productData->image2)}}">
							<div class="wrap-pic-w">
								<img src="{{asset('/public/images/products/'.$productData->image2)}}" alt="{{$productData->name}} - 2">
							</div>
						</div>
						@endif

						@if(!empty($productData->image3))
						<div class="item-slick3" data-thumb="{{asset('/public/images/products/'.$productData->image3)}}">
							<div class="wrap-pic-w">
								<img src="{{asset('/public/images/products/'.$productData->image3)}}" alt="{{$productData->name}} - 3">
							</div>
						</div>
						@endif

						@if(!empty($productData->image4))
						<div class="item-slick3" data-thumb="{{asset('/public/images/products/'.$productData->image4)}}">
							<div class="wrap-pic-w">
								<img src="{{asset('/public/images/products/'.$productData->image4)}}" alt="{{$productData->name}} - 4">
							</div>
						</div>
						@endif
					</div>
				</div>
			</div>

			<div class="w-size14 p-t-30 respon5">
				<div class="heading-title product-detail-name m-text16">
					{{$productData->name}}
				</div>
                <p class="avaibility p-b-13">
                    @if($productData->status ==0)
                         <i class="fa fa-circle"></i> 
                     In Stock
                     @else
                     <i class="fa fa-circle" style="color:#ff0000;"></i> 
                     Out Of Stock
                     @endif
                </p>
				<span class="m-text17">
					₹{{$productData->price}}
				</span>
				<p>
			        <div class="placeholder" style="color: gray; font-size: 22px;">
			            <i class="fa fa-star"></i>
			            <i class="fa fa-star"></i>
			            <i class="fa fa-star"></i>
			            <i class="fa fa-star"></i>
			            <i class="fa fa-star"></i>
			            <span class="small" style="color: gray;">({{ $rating }})</span>
			        </div>

			        <div class="overlay" style="position: relative;top: -32px;font-size: 22px; color: orange;">
			            
			            @while($rating>0)
			                @if($rating >0.5)
			                    <i class="fa fa-star"></i>
			                @else
			                    <i class="fa fa-star-half"></i>
			                @endif
			                @php $rating--; @endphp
			            @endwhile

			        </div> 
			    </p>
			    <p><a href="whatsapp://send?text=Product Details Check Click Here {{env('APP_URL')}}//product-details/{{$productData->id}}" data-action="share/whatsapp/share" class="btn btn-success" aria-label="Whatsapp"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></p>

				<!--  -->
				<div class="p-t-33 p-b-60">

					<div class="p-t-10">
						<div class="w-size16 flex-m flex-w">
						  <form method="post" action="/add_cart/{{$productData->id}}">
							@csrf
							<div class="input-group mb-3 product-detail-form">
								<label class="dis-none" for="qty">QTY</label>
      							<input type="text" class="size8 qty-input m-text18 t-center num-product" type="number" name="qty" value="1" id="qty">
      						  <div class="btn-addcart-product-detail size9 trans-0-4 input-group-append">
        							<button type="submit" class="btn qty-add-btn">Add</button>
      						  </div>
    						</div>
						</form>
						</div>
					</div>
				</div>

				

				<!--  -->
				<div class="wrap-dropdown-content bo6 p-t-15 p-b-14 active-dropdown-content">
					<div class="small-title-text js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4">
						Description
						<i class="down-mark fs-12 color1 fa fa-minus dis-none" aria-hidden="true"></i>
						<i class="up-mark fs-12 color1 fa fa-plus" aria-hidden="true"></i>
					</div>

					<div class="dropdown-content dis-none p-t-15 p-b-23">
						<p class="s-text8">
							{{$productData->description}}
						</p>
					</div>
				</div>

				<div class="wrap-dropdown-content bo7 p-t-15 p-b-14">
					<div class="small-title-text js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4">
						Reviews ({{$count}})
						<i class="down-mark fs-12 color1 fa fa-minus dis-none" aria-hidden="true"></i>
						<i class="up-mark fs-12 color1 fa fa-plus" aria-hidden="true"></i>
					</div>

					<div class="dropdown-content dis-none p-t-15 p-b-23">
						<!--Comments-->
						@foreach ($comments as $comment)
							<div class="card card-comments mb-3 wow fadeIn">
							    <div class="card-header font-weight-bold">Comments</div>
							    <div class="card-body">

							        <div class="media d-block d-md-flex mt-4">
							        	@if(Auth::check())
				                        @if(Auth::user()->avatar)
				                            <img class="d-flex mb-3 mx-auto " src="/public/images/user/{{$comment->userImage}}" alt="{{Auth::user()->name}}" style="width: 70px; height: 70px; border-radius: 100%;"> 
				                         @else
				                           <i class="fa fa-user-circle" aria-hidden="true"></i>
				                         @endif
				                        @else
				                        @endif
							            
							            
							            <div class="media-body text-center text-md-left ml-md-3 ml-0">
							                <div class="small-title-text mt-0 font-weight-bold">{{$comment->userName}}
							                    <a href="" class="pull-right" aria-label="Reply">
							                        <i class="fa fa-reply"></i>
							                    </a>
							                </div>
							                {{$comment->comment}}

							                <!-- Quick Reply -->
							                <div class="form-group mt-4" style="display: none;">
							                    <label for="quickReplyFormComment">Your comment</label>
							                    <textarea class="form-control" id="quickReplyFormComment" rows="5"></textarea>
							                    <div class="" style="margin-top: 10px;">
							                        <button class="btn btn-info btn-sm" type="submit">Post</button>
							                    </div>
							                </div>   
							            </div>
							        </div>
							    </div>
							</div>
							<!--/.Comments-->
							<br>
						@endforeach	
						{!! $comments->render() !!}
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Relate Product -->
	<section class="relateproduct bgwhite m-t-70">
		<div class="container">
			<div class="sec-title p-b-60">
				<div class="heading-title m-text5 t-center">
					Related Products
				</div>
			</div>

			<!-- Slide2 -->
			<div class="wrap-slick2">
				<div class="slick2">
					@foreach($products as $product)
					<div class="item-slick2 p-l-15 p-r-15">
						<!-- Block2 -->
						<div class="block2">
							<div class="block2-img wrap-pic-w of-hidden pos-relative block2-labelnew">
								<img src="{{asset('/public/images/products/'.$product->image)}}" alt="{{$product->name}}">

								<div class="block2-overlay trans-0-4">
									<a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4" aria-label="add">
										<i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>
										<i class="icon-wishlist icon_heart dis-none" aria-hidden="true"></i>
									</a>

									<div class="block2-btn-addcart w-size1  trans-0-4">
										<!-- Button -->
										<button class="flex-c-m add-on-cart btn btn-style s-text1 trans-0-4" addId="{{ $product->id }}">
											Add to Cart
										</button>
									</div>
								</div>
							</div>

							<div class="block2-txt p-t-20">
								<a href="/product-details/{{$product->id}}" class="block2-name dis-block s-text3 p-b-5">
									{{$product->name}}
								</a>

								<span class="block2-price m-text6 p-r-5">
									₹{{$product->price}}
								</span>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>

		</div>
	</section>

<script type="text/javascript" src="/public/jquery/jquery-3.2.1.min.js"></script>
 <script> 
        $('.add-on-cart').on('click', function(){
                var product_id = $(this).attr("addId");
                     //console.log(product_id);
                $.ajax({

                //type: "POST",

                dataType: 'json',
                url: "/cart",
                method : 'post',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: 'id='+product_id,
                success: function (data) {
                    if (data['success']) {
                       toastr.success("Product Add on Cart","Successfuly");
                        window.location.href = '/cart';
                    } else if (data['error']) {
                       toastr.error(data['error']);
                       //window.location.href = '/login';
                       //swal(nameProduct, "is already added to cart !", "error");
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                    
                },
                error: function (data) {
                    toastr.error(data.responseText,"error");
                }
                });
            });
            
</script>

@endsection