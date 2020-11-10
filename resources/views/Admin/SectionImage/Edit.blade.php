@extends('layouts.master')
@section('content')

  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
            <h1>Section Image</h1>
        </section>
      <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <form action="/section-image/update/{{ $pageSetup->id }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                      <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit<span style="float: right;"><a href="{{ URL::previous() }}"><button type="button" class="btn btn-danger btn-sm">
<span class="fa fa-chevron-left"></span> Back</button></a></span></h3>
                            </div>

                           <!--  <bootstrap-alert /> -->

                                                       <div class="box-body">
                              <div class="form-group">
                                    <label for="page">Page</label>
                                      <select class="form-control{{ $errors->has('page_name') ? ' is-invalid' : '' }}"  name="page_name" >
                                        <option value="">--Select Page--</option>
                                        @foreach($pages as $page)
                                        <option value="{{$page->slug}}" {{ $pageSetup->page_name == $page->slug ? "selected":"" }}>{{$page->text}}</option>
                                        @endforeach
                                      </select>
                                       @if ($errors->has('page_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('page_name') }}</strong>
                                        </span>
                                        @endif
                                 </div>
                                  <div class="form-group">
                                    <label for="page-section">Page Section</label>
                                    <input type="text" class="form-control{{ $errors->has('section') ? ' is-invalid' : '' }}" name="section" id="page-section" placeholder="Enter Page Section" value="{{ $pageSetup->section }}">
                                @if ($errors->has('section'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('section') }}</strong>
                                </span>
                                @endif
                                </div>

                                <div class="form-group">
                                    <label for="section_heading">Section Heading</label>
                                    <input type="text" class="form-control{{ $errors->has('section_heading') ? ' is-invalid' : '' }}" name="section_heading" id="section_heading" placeholder="Enter Section Heading" value="{{ $pageSetup->section_heading }}">
                                @if ($errors->has('section_heading'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('section_heading') }}</strong>
                                </span>
                                @endif
                                </div>

                                <div class="form-group">
                                    <label for="section_sub_heading">Section Sub Heading</label>
                                    <input type="text" class="form-control{{ $errors->has('section_sub_heading') ? ' is-invalid' : '' }}" name="section_sub_heading" id="section_sub_heading" placeholder="Enter  Section Sub Heading" value="{{ $pageSetup->section_sub_heading }}">
                                @if ($errors->has('section_sub_heading'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('section_sub_heading') }}</strong>
                                </span>
                                @endif
                                </div>
                                <div class="form-group">
                                    <label for="section_content">Section Content</label>
                                <textarea name="section_content" id="section_content"  rows="5" placeholder="Section Content" class="form-control">{{$pageSetup->section_content}}</textarea>
                               </div>
                                
                                  <label for="title">Drop only 1 Blog Image</label>
                                  <div class="large-12 medium-12 small-12 filezone  gallery">
                                      <input type="file" class="multi-img" id="files" name="uploadFile[]"  multiple/>
                                      <p>
                                          Drop your files here <br>or click to search (Maxsize 5mb)
                                      </p>
                                  </div>

                                  @if($pageSetup->image)
                                  <div class="img-show-box pip">
                                    <img class="imageThumb" src="/public/images/banner/{{ $pageSetup->image }}"> 
                                    <div class="remove">Remove</div>
                                  </div>
                                  @endif

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
<script src="/public/jquery/jquery-3.2.1.min.js"></script>
<script>
    $(document).ready(function(){
        $('.remove').on('click', function() {
            $(this).parents(".pip").remove();
              });

         /// multi image 
  if (window.File && window.FileList && window.FileReader) {
    $("#files").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
        if(filesLength > 1){
          alert('plz drop only 1 image');
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
          // $(".remove").click(function(){
          //   $(this).parent(".pip").remove();
          // });
          
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
        width:  auto;
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
