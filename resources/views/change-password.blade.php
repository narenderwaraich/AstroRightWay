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
<div class="windows-firm-Box">
  <div class="top-tile">
    Change Password
  </div>
  <div class="windows-form">
    <form action="/change-password" method="post">
      {{ csrf_field() }}
      <input type="password" name="old_password" id="old_password" class="form-control pass-filed windows-form-input {{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="Enter Old Password" required>
            @if ($errors->has('old_password'))
                  <span class="invalid-feedback" role="alert" style="text-align: center;padding-bottom: 10px">
                      <strong>{{ $errors->first('old_password') }}</strong>
                  </span>
            @endif
            <input type="password" name="password" id="password" class="form-control pass-filed windows-form-input {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Enter New Password" required>
            @if ($errors->has('password'))
                  <span class="invalid-feedback" role="alert" style="text-align: center;padding-bottom: 10px">
                      <strong>{{ $errors->first('password') }}</strong>
                  </span>
            @endif
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control pass-filed windows-form-input {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" placeholder="Confirm Password" required>
            @if ($errors->has('password_confirmation'))
              <span class="invalid-feedback" role="alert" style="text-align: center;padding-bottom: 10px">
                  <strong>{{ $errors->first('password_confirmation') }}</strong>
              </span>
            @endif
            <input type="checkbox" onclick="myFunction()" class="chk-box"> &nbsp; <b>Show Password</b>
            <br>
          <button type="submit" class="btn btn-style itm-center btn-width btn-top">Submit</button>
    </form>
  </div>
</div>
 <script type="text/javascript" src="/public/jquery/jquery-3.2.1.min.js"></script>
<script>
function myFunction() {
    var x = document.getElementById("password");
    var y = document.getElementById("password_confirmation");
    var z = document.getElementById("old_password");    
    if (x.type === "password",y.type === "password",z.type === "password") {
        x.type = "text";
        y.type = "text";
        z.type = "text";
    } else {
        x.type = "password";
        y.type = "password";
        z.type = "password";
    }
}
</script>
@endsection
