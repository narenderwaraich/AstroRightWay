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

<div class="container singn-up">
    <div class="windows-firm-Box">
        <div class="top-tile">
            Join With Us
        </div>
        <div class="windows-form">
            <form method="POST" action="/make-member">
                @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input id="name" type="text" class="windows-form-input form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Name">

                        @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="e-mail">Email</label>
                        <input id="email" type="email" class="windows-form-input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email">

                        @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input id="password-field" type="password" class="windows-form-input form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
                        <span toggle="#password-field" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Phone</label>
                        <input type="number" class="form-control windows-form-input {{ $errors->has('phone_no') ? ' is-invalid' : '' }}" name="phone_no" value="{{ old('phone_no') }}" id="mobile" placeholder="Mobile Number">
                        @if ($errors->has('phone_no'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('phone_no') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="select">Gender</label>
                            <select name="gender" id="select" required class="windows-form-input form-control ">
                                <option value="">-- Select Gender--</option>    
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                    </div>


                    @if(isset($referCode))
                    <div class="form-group">
                        <label for="">Refer Code</label>
                        <input type="text" class="windows-form-input form-control" name="refer_code" placeholder="Refer Code" value="{{$referCode}}" readonly>
                    </div>
                    @else
                    <div class="form-group">
                        <label for="">Refer Code</label>
                        <input type="text" class="windows-form-input form-control" name="refer_code" placeholder="Refer Code">
                    </div>
                    @endif
                <button type="submit" class="btn btn-style btn-top" >Submit</button>
            </form>
        </div>
    </div>
</div>
<script src="/public/jquery/jquery-3.2.1.min.js"></script>
<script>
$(".toggle-password").click(function() {
$(this).toggleClass("fa-eye-slash fa-eye");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
input.attr("type", "text");
} else {
input.attr("type", "password");
}
});
</script>
@endsection
