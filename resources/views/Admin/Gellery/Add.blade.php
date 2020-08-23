@extends('layouts.master')
@section('content')

  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
            <h1>Gallery</h1>
        </section>
      <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <form action="/gallery/create" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                      <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Create <span style="float: right;"><a href="{{ URL::previous() }}"><button type="button" class="btn btn-danger btn-sm">
<span class="fa fa-chevron-left"></span> Back</button></a></span></h3>
                            </div>

                           <!--  <bootstrap-alert /> -->

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" placeholder="Enter Title" value="{{ old('title') }}" required>
                                @if ($errors->has('title'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                                @endif
                                </div>
                                <div class="form-group">
                                    <label for="title">Author</label>
                                    <input type="text" class="form-control{{ $errors->has('auth') ? ' is-invalid' : '' }}" name="auth" placeholder="Enter Author Name" value="{{ old('auth') }}">
                                @if ($errors->has('auth'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('auth') }}</strong>
                                </span>
                                @endif
                                </div>
                                <div class="form-group">
                                    <label for="title">URL</label>
                                    <input type="text" class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" name="url" placeholder="Enter URL" value="{{ old('url') }}">
                                @if ($errors->has('url'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('url') }}</strong>
                                </span>
                                @endif
                                </div>
                                  <div class="form-group">
                                    <label for="title">Description</label>
                                    <textarea name="description" id="proDesc" rows="5" placeholder="Description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" required></textarea>
                                    @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                                  </div>

                                  <label for="title">Drop only 1 Blog Image</label>
                                  <div class="large-12 medium-12 small-12 filezone  gallery">
                                      <input type="file" class="multi-img" id="files" name="uploadFile[]"  multiple/>
                                      <p>
                                          Drop your files here <br>or click to search (Maxsize 5mb)
                                      </p>
                                  </div>
                            </div>

                            <div class="box-footer">
                              <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            </div>
                        </div>
                    </form>
                  </div>
              </div>
        </section>
</section>

<script src="/public/jquery/jquery-3.2.1.min.js"></script>
<script>
    /// multi image 
$(document).ready(function(){
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
        width: auto;
      height:300px;
      padding: 10px;
    }
    .remove {
      color: red;
      text-align: center;
      cursor: pointer;
      display: block;
      width: auto;
      height: auto;
    }
    .remove:hover {
      color: green;
    }
</style>
@endsection