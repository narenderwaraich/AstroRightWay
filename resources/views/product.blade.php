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


	<!-- Content page -->
	<section class="bgwhite m-t-70">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-md-4 col-lg-3 p-b-50">
					<div class="siderbar p-r-20 p-r-0-sm">
							<label class="m-text14 p-b-7 heading-title" for="category">Categories</label>
						<select name="" class="form-control select-category" id="category">
							<option value="/product">All</option>
							@foreach($category as $categoryData)
							<option value="/product/category/{{$categoryData->name}}" {{ url()->current() === env('APP_URL').'/product/category/'.$categoryData->name ? "selected":"" }}>{{$categoryData->name}}</option>
							@endforeach
						</select>

						

<!-- 						<h4 class="m-text14 p-b-32">
							Filters
						</h4>

						<div class="filter-price p-t-22 p-b-50 bo3">
							<div class="m-text15 p-b-17">
								Price
							</div>

							<div class="wra-filter-bar">
								<div id="filter-bar"></div>
							</div>

							<div class="flex-sb-m flex-w p-t-16">
								<div class="w-size11">
									<button class="flex-c-m size4 bg7 bo-rad-15 hov1 s-text14 trans-0-4">
										Filter
									</button>
								</div>

								<div class="s-text3 p-t-10 p-b-10">
									Range: $<span id="value-lower">610</span> - $<span id="value-upper">980</span>
								</div>
							</div>
						</div> -->
					</div>
				</div>

				<div class="col-sm-6 col-md-8 col-lg-9 p-b-50">
								<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<form action="/products/search" method="POST" id="SearchData" role="search">
                    	{{ csrf_field() }}
						<div class="search-product pos-relative of-hidden">
							<label class="dis-none" for="search">Search</label>
							<input class="s-text7 size6 p-l-23 p-r-50" type="text" name="search-product" id="search" value="{{request('search-product')}}" placeholder="Search Products..." required>

							<button type="submit" class="flex-c-m size5 ab-r-m color2 color0-hov trans-0-4">
								<i class="fs-25 fa fa-search" aria-hidden="true"></i>
								<span class="dis-none">Search</span>
							</button>
						</div>
					</form>
				</div>
			</div>
					<!--  -->
					<div class="flex-sb-m flex-w">
						<!--<div class="flex-w">-->
						<!--	<div class="rs2-select2 bo4 of-hidden w-size12 m-t-5 m-b-5 m-r-10">-->
						<!--		<select class="selection-2" name="sorting">-->
						<!--			<option>New</option>-->
						<!--			<option>Popularity</option>-->
						<!--			<option>Price: low to high</option>-->
						<!--			<option>Price: high to low</option>-->
						<!--		</select>-->
						<!--	</div>-->

						<!--	<div class="rs2-select2 bo4 of-hidden w-size12 m-t-5 m-b-5 m-r-10">-->
						<!--		<select class="selection-2" name="sorting">-->
						<!--			<option>Price</option>-->
						<!--			<option>₹0.00 - ₹50.00</option>-->
						<!--			<option>₹50.00 - ₹100.00</option>-->
						<!--			<option>₹100.00 - ₹150.00</option>-->
						<!--			<option>₹150.00 - ₹200.00</option>-->
						<!--			<option>₹200.00+</option>-->

						<!--		</select>-->
						<!--	</div>-->
						<!--</div>-->
						@if(isset($message))
						<span class="s-text8 p-t-5 p-b-5">
                         	<p>{{ $message }}</p>
						</span>
						@endif
					</div>

					<!-- Product -->

		<section class="programs-section container">
			<div class="row  m-t-50">
        @foreach($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-4 p-b-50">
                <div class="product-block">
                    <div class="block2-img wrap-pic-w of-hidden pos-relative {{ ($product->product_types_id ==2) ? 'block2-labelnew' : '' }} {{ ($product->product_types_id ==1) ? 'block2-labelsale' : '' }}">
                        <img src="{{asset('/public/images/products/'.$product->image)}}" alt="{{$product->name}}">
                        <div class="block2-overlay trans-0-4">
                            <div class="block2-btn-addcart w-size1 trans-0-4">
                                <button class="flex-c-m trans-0-4 btn secondary_btn mt40 add-on-cart" addId="{{ $product->id }}">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="product-content p-t-20">
                        <a href="/product-details/{{$product->id}}" class="dis-block p-b-5">
                            <div class="heading-title">{{$product->name}}</div>
                        </a>
                        <span class="product-price-txt">
                            ₹{{$product->price}}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

		  <!-- <div class="row m-t-50">
		  	@foreach($products as $product)
		    <div class="col-md-6 mb-cols">
		      <div class="product-view-window-div {{ ($product->product_types_id ==2) ? 'block2-labelnew' : '' }} {{ ($product->product_types_id ==1) ? 'block2-labelsale' : '' }}" style="background-image: url(/public/images/products/{{$product->image}});">
		          <div class="slide-imge-overlay"></div>
		        <div class="product-content">
			        <a href="/product-details/{{$product->id}}"><h2 class="m-top heading-color2">{{$product->name}}</h2></a>
			        <br>
			        <p class="offer-text">₹{{$product->price}}</p>
			        <button type="button" class="btn secondary_btn mt40 add-on-cart" addId="{{ $product->id }}">Add to Cart</button>
		        </div>
		      </div>
		    </div>
		    @endforeach
		  </div> -->
		  {!! $products->links() !!}
		</section>
			<!-- 		<div class="row">
					 @if(isset($products))
						@foreach($products as $product)
						<div class="col-sm-12 col-md-6 col-lg-4 p-b-50">
							<div class="block2">
								<div class="block2-img wrap-pic-w of-hidden pos-relative block2-labelnew">
									<img src="{{asset('/public/images/products/'.$product->image)}}" alt="IMG-PRODUCT">

									<div class="block2-overlay trans-0-4">
										<a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4">
											<i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>
											<i class="icon-wishlist icon_heart dis-none" aria-hidden="true"></i>
										</a>

										<div class="block2-btn-addcart w-size1 trans-0-4" addId="{{ $product->id }}">
											<button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4">
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
					{!! $products->links() !!}
					@endif -->
					<!-- Pagination -->
					<!-- <div class="pagination flex-m flex-w p-t-26">
						<a href="#" class="item-pagination flex-c-m trans-0-4 active-pagination">1</a>
						<a href="#" class="item-pagination flex-c-m trans-0-4">2</a>
					</div> -->
				</div>
			</div>
		</div>
	</section>




	
 <script type="text/javascript" src="/public/jquery/jquery-3.2.1.min.js"></script>

	<script> 
		$('.add-on-cart').on('click', function(){
                var product_id = $(this).attr("addId");
                $.ajax({

	            //type: "POST",

	            dataType: 'json',
	            url: "cart",
                method : 'post',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: 'id='+product_id,
                success: function (data) {
                    if (data['success']) {
                       toastr.success("Product Add on Cart","Successfuly");
          				window.location.href = '/cart';
                    } else if (data['error']) {
                       toastr.error(data['error']);
                       //swal(nameProduct, "is already added to cart !", "error");
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                    
                },
                error: function (data) {
                    toastr.error("Please Login First","Sorry");
                }
	            });
            });

		$('.select-category').change(function(){
			var selectedCategory = $(this).children("option:selected").val();
			window.location.href = selectedCategory;
		});
        	
</script>


@endsection