@extends('layouts.master')
@section('content')

  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
            <h1>Product</h1>
        </section>
      <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <form action="/product/update/{{ $product->id }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                      <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit <span style="float: right;"><a href="{{ URL::previous() }}"><button type="button" class="btn btn-danger btn-sm">
<span class="fa fa-chevron-left"></span> Back</button></a></span></h3>
                            </div>


                            <div class="box-body">
                                <div class="form-group">
                                    <label for="title">Name</label>
                                    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" placeholder="Enter Name" value="{{ $product->name }}" required>
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                                </div>


                     <div class="col-md-12">
                        <label class="user-input-label">Product Main Image(720x960)</label>
                        <div class="form-group">
                          <button type="button" class="btn secondary_btn" id="selectFile">Change</button>
                        </div>
                        <img src="/public/images/products/{{ $product->image }}" id="showUpLog" class="show-product-img profile-img-tag">
                          <input type="file" name="image" id="getFile" accept="/image/*" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }} input-border" style="display: none;">
                        </div>
                              @if ($errors->has('image'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                                @endif

                                <div class="form-group">
                                    <label for="title">Original Price</label>
                                    <input type="number" min="10" max="10000" class="form-control{{ $errors->has('original_price') ? ' is-invalid' : '' }}" name="original_price" placeholder="Enter Original Price" value="{{ $product->original_price }}" required>
                                @if ($errors->has('original_price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('original_price') }}</strong>
                                </span>
                                @endif
                                </div>
                                <div class="form-group">
                                    <label for="title">Sale Price</label>
                                    <input type="number" min="10" max="10000" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" placeholder="Enter Sale Price" value="{{ $product->price }}" required>
                                @if ($errors->has('price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                                @endif
                                </div>
                                <div class="form-group">
                                    <label for="title">Quantity</label>
                                    <input type="number" min="1" max="100" class="form-control{{ $errors->has('qty') ? ' is-invalid' : '' }}" name="qty" placeholder="Enter Quantity" value="{{ $product->qty }}" required>
                                @if ($errors->has('qty'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('qty') }}</strong>
                                </span>
                                @endif
                                </div>
                                <div class="form-group">
                                    <label for="title">Category</label>
                                      <select class="form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" name="category_id" required>
                                        <option value="">Select Category</option>
                              @foreach ($categories as $category)
                          <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? "selected":"" }}>{{ $category->name}}</option>
                              @endforeach
                                      </select>
                                 </div>
                                 <div class="form-group">
                                    <label for="title">Product Type</label>
                                      <select class="form-control{{ $errors->has('product_types_id') ? ' is-invalid' : '' }}" name="product_types_id" required>
                                        <option value="">Select Product Type</option>
                              @foreach ($productTypes as $productType)
                          <option value="{{ $productType->id }}" {{ $product->product_types_id == $productType->id ? "selected":"" }}>{{ $productType->name}}</option>
                              @endforeach
                                      </select>
                                 </div>
                                 
                                  <div class="form-group">
                                    <span style="float: right;font-size: 14px;">(max length 450) <span id="charNum"></span></span>
                                    <label for="title">Description</label>
                                    <textarea name="description" id="proDesc"  rows="5" placeholder="Description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" maxlength="200" minlength="5" required onkeyup="countChar(this)">{{$product->description}}</textarea>
                                  </div>

                                  <div class="row">
                                    <div class="col-md-3">
                                      @if(!empty($product->image1))
                                      <img class="imageThumb show-img-1" src="/public/images/products/{{ $product->image1 }}">
                                      @else
                                       <img class="imageThumb show-img-1" src="/public/images/products/default.jpg">
                                      @endif
                                      <input type="file" name="image1" id="img_1" accept="/image/*" style="display: none;" value="{{ $product->image1 }}">
                                      <div class="img-action">
                                       <a href="#" class="btn btn-info btn-sm" id="change_image1">Change</a>
                                       <a href="#" class="btn btn-danger btn-sm" id="remove_image1">Remove</a>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      @if(!empty($product->image2))
                                      <img class="imageThumb show-img-2" src="/public/images/products/{{ $product->image2 }}">
                                      @else
                                       <img class="imageThumb show-img-2" src="/public/images/products/default.jpg">
                                      @endif
                                      <input type="file" name="image2" id="img_2" accept="/image/*" style="display: none;" value="{{ $product->image2 }}">
                                      <div class="img-action">
                                       <a href="#" class="btn btn-info btn-sm" id="change_image2">Change</a>
                                       <a href="#" class="btn btn-danger btn-sm" id="remove_image2">Remove</a>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      @if(!empty($product->image3))
                                      <img class="imageThumb show-img-3" src="/public/images/products/{{ $product->image3 }}">
                                      @else
                                       <img class="imageThumb show-img-3" src="/public/images/products/default.jpg">
                                      @endif
                                      <input type="file" name="image3" id="img_3" accept="/image/*" style="display: none;" value="{{ $product->image3 }}">
                                      <div class="img-action">
                                       <a href="#" class="btn btn-info btn-sm" id="change_image3">Change</a>
                                       <a href="#" class="btn btn-danger btn-sm" id="remove_image3">Remove</a>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      @if(!empty($product->image4))
                                      <img class="imageThumb show-img-4" src="/public/images/products/{{ $product->image4 }}">
                                      @else
                                       <img class="imageThumb show-img-4" src="/public/images/products/default.jpg">
                                      @endif
                                      <input type="file" name="image4" id="img_4" accept="/image/*" style="display: none;" value="{{ $product->image4 }}">
                                      <div class="img-action">
                                       <a href="#" class="btn btn-info btn-sm" id="change_image4">Change</a>
                                       <a href="#" class="btn btn-danger btn-sm" id="remove_image4">Remove</a>
                                      </div>
                                    </div>
                                  </div>
         
                            </div>

                            <div class="box-footer">
                              <button type="submit" class="btn btn-primary btn-sm">Update</button>
                            </div>
                        </div>
                    </form>
                  </div>
              </div>
        </section>
</section>
@endsection

<script src="/public/jquery/jquery-3.2.1.min.js"></script>
<script>
    $(document).ready(function(){
        //// change image
        $('#change_image1').on('click', function() {
          $("#img_1").click();
          var file_1 = $("#img_1"); 
          function readURL1(file_1) {
                if (file_1.files && file_1.files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function (e) {
                        $('.show-img-1').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file_1.files[0]);
                }
            }
            $("#img_1").change(function(){
              $(".show-img-1").show();
                readURL1(this);
            });
        });
        $('#change_image2').on('click', function() {
           $("#img_2").click();
           var file_2 = $("#img_2");
          function readURL2(file_2) {
                if (file_2.files && file_2.files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function (e) {
                        $('.show-img-2').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file_2.files[0]);
                }
            }
            $("#img_2").change(function(){
              $(".show-img-2").show();
                readURL2(this);
            });
        });
        $('#change_image3').on('click', function() {
           $("#img_3").click();
          function readURL3(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function (e) {
                        $('.show-img-3').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#img_3").change(function(){
              $(".show-img-3").show();
                readURL3(this);
            });
        });
        $('#change_image4').on('click', function() {
           $("#img_4").click();
          function readURL4(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function (e) {
                        $('.show-img-4').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#img_4").change(function(){
              $(".show-img-4").show();
                readURL4(this);
            });
        });

        /// remove image

        $('#remove_image1').click( function() {
          $(this).parent(".img-action").parent(".col-md-3").remove();
          $('#img_1').val('');
          });
        $('#remove_image2').on('click', function() {
          $(this).parent(".img-action").parent(".col-md-3").remove();
          $('#img_2').val('');
        });
        $('#remove_image3').on('click', function() {
          $(this).parent(".img-action").parent(".col-md-3").remove();
          $('#img_3').val('');
        });
        $('#remove_image4').on('click', function() {
          $(this).parent(".img-action").parent(".col-md-3").remove();
          $('#img_4').val('');
        });

    });
</script>
<script>
    $(document).ready(function(){
    $('#selectFile').on('click', function() {
      $("#getFile").click();
    });
  
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('.profile-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#getFile").change(function(){
      $("#showUpLog").show();
        readURL(this);
    });
});

    function countChar(val) {
        var len = val.value.length;
        if (len >= 450) {
          val.value = val.value.substring(0, 450);
        } else {
          $('#charNum').text(450 - len);
        }
      };
</script>
<style scoped>
   .img-action {
    display: block;
    margin: auto;
    text-align: center;
  }
    .imageThumb{
        margin-bottom: 20px;
        margin-top: 20px;
        width: 300px;
      height:300px;
      padding: 10px;
    }
</style>