@extends('layouts.master')
@section('content')

  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
            <h1>Product</h1>
        </section>
      <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <form action="/product/create" method="post" onSubmit = 'return validate();' enctype="multipart/form-data">
                    {{ csrf_field() }}
                      <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Create <span style="float: right;"><a href="{{ URL::previous() }}"><button type="button" class="btn btn-danger btn-sm">
<span class="fa fa-chevron-left"></span> Back</button></a></span></h3>
                            </div>


                            <div class="box-body">
                                <div class="form-group">
                                    <label for="title">Name</label>
                                    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" placeholder="Enter Name" value="{{ old('name') }}" required>
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                                </div>

                        <div class="col-md-12">
                        <label class="user-input-label">Product Main Image(720x960)</label>
                        <div class="form-group">
                          <button type="button" class="btn secondary_btn" id="selectFile">Upload</button>
                        </div>
                        <img src="/images" id="showUpLog" class="show-product-img profile-img-tag" style="display: none;">
                          <input type="file" name="image" id="getFile" accept="/image/*" class="form-control input-border" style="display: none;">
                        </div>

                                <div class="form-group">
                                    <label for="title">Original Price</label>
                                    <input type="number" class="form-control{{ $errors->has('original_price') ? ' is-invalid' : '' }}" name="original_price" placeholder="Enter Original Price" value="{{ old('original_price') }}" min="10" max="10000" required>
                                @if ($errors->has('original_price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('original_price') }}</strong>
                                </span>
                                @endif
                                </div>
                                <div class="form-group">
                                    <label for="title">Sale Price</label>
                                    <input type="number" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" placeholder="Enter Sale Price" value="{{ old('price') }}" min="10" max="10000" required>
                                @if ($errors->has('price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                                @endif
                                </div>
                                <div class="form-group">
                                    <label for="title">Quantity</label>
                                    <input type="number" class="form-control{{ $errors->has('qty') ? ' is-invalid' : '' }}" name="qty" placeholder="Enter Quantity" value="{{ old('qty') }}" min="1" max="100" required>
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
                          <option value="{{ $category->id }}" {{ (old("category_id") == $category->id ? "selected":"") }}>{{ $category->name}}</option>
                              @endforeach
                                      </select>
                                 </div>
                                 <div class="form-group">
                                    <label for="title">Product Type</label>
                                      <select class="form-control{{ $errors->has('product_types_id') ? ' is-invalid' : '' }}" name="product_types_id" required>
                                        <option value="">Select Product Type</option>
                              @foreach ($productTypes as $productType)
                          <option value="{{ $productType->id }}" {{ (old("product_types_id") == $productType->id ? "selected":"") }}>{{ $productType->name}}</option>
                              @endforeach
                                      </select>
                                 </div>
                                 
                                  <div class="form-group"><span style="float: right;font-size: 14px;">(max length 450) <span id="charNum"></span></span>
                                    <label for="title">Description</label>
                                    <textarea name="description" id="proDesc"  rows="5" placeholder="Description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" maxlength="200" minlength="5" required onkeyup="countChar(this)"></textarea>
                                  </div>
                                  
                                  <label for="title">Drop Other Product Image</label>
                                  <div class="large-12 medium-12 small-12 filezone  gallery">
                                      <input type="file" class="multi-img" id="files" name="uploadFile[]"  multiple/>
                                      <p>
                                          Drop your files here <br>or click to search (720x960 Maxsize 2mb)
                                      </p>
                                  </div>
                            </div>

                            <div class="box-footer">
                              <button type="submit" class="btn btn-primary btn-sm" id="submitProduct">Save</button>
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
      $("#companyImage").hide();
        readURL(this);
    });
    
    /// multi image 
  if (window.File && window.FileList && window.FileReader) {
    $("#files").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
        if(filesLength > 4){
          alert('plz drop only 4 image');
        }else{
                for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          $("<div class=\"img-show-box pip\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" + 
            "<div class=\"remove\">Remove</div>" +
            "</div>").insertAfter(".gallery");
          $(".remove").click(function(){
            $(this).parent(".pip").remove();
          });
          
        });
        fileReader.readAsDataURL(f);
      }
        }
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});


      function countChar(val) {
        var len = val.value.length;
        if (len >= 450) {
          val.value = val.value.substring(0, 450);
        } else {
          $('#charNum').text(450 - len);
        }
      };


      function validate(){
        $imgCheck = $('#getFile').val();
        if(!$imgCheck){
          alert('Please upload first images');
          return false;
        }else{
          return true;
        }
      }
    </script>
<style scoped>
    .multi-img{
        opacity: 0;
        width: 100%;
        height: 200px;
        position: absolute;
        cursor: pointer;
    }
    .filezone {
        outline: 2px dashed grey;
        outline-offset: -10px;
        background: #ccc;
        color: dimgray;
        padding: 10px 10px;
        min-height: 200px;
        position: relative;
        cursor: pointer;
    }
    .filezone:hover {
        background: #c0c0c0;
    }

    .filezone p {
        font-size: 1.2em;
        text-align: center;
        padding: 50px 50px 50px 50px;
    }
    .img-show-box{
         display: inline-block;
    width: auto;
    }
    .imageThumb{
        margin-bottom: 20px;
        margin-top: 20px;
        width: 300px;
      height:300px;
      padding: 10px;
    }
    .remove {
      color: red;
      text-align: center;
      cursor: pointer;
      display: block;
      width: 300px;
      height: auto;
    }
    .remove:hover {
      color: green;
    }
</style>