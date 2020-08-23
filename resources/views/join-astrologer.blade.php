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
            Register Astrologer
        </div>
        <div class="windows-form">
            <form method="POST" action="/join-astrologer" enctype="multipart/form-data">
                @csrf
                <div class="text-center">
                    <img src="{{asset('/public/images/user/user.jpg')}}" class="dp-show newdp" id="profile-img-tag" alt="avatar">
                    <button type="button" class="btn img-upload btn-style" onclick="document.getElementById('getFile').click()" style="box-shadow: unset !important;">Upload</button>
                    <input type="file" name="avatar" value="" style="visibility: hidden;" id="getFile">
                </div>
                <div class="row">
                    <div class="col-6 form-group">
                        <label for="name">Name</label>
                        <input id="name" type="text" class="windows-form-input form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus>

                        @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-6 form-group">
                        <label for="">Phone</label>
                        <input type="number" class="form-control input-style here {{ $errors->has('phone_no') ? ' is-invalid' : '' }}" name="phone_no" value="{{ old('phone_no') }}" id="mobile" placeholder="enter mobile number" title="enter your mobile number if any.">
                        @if ($errors->has('phone_no'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('phone_no') }}</strong>
                        </span>
                        @endif
                    </div>

                </div>

                <div class="row">
                    <div class="col-6 form-group">
                        <label for="e-mail">Email</label>
                        <input id="email" type="email" class="windows-form-input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required>

                        @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-6 form-group">
                        <label for="">Password</label>
                        <input id="password-field" type="password" class="windows-form-input form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
                        <span toggle="#password-field" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                        @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>

                </div>

                <div class="row">
                    <div class="col-6 form-group">
                        <label for="">Gender</label>
                        <select name="gender" id="select" required class=" input-style form-control ">
                            <option value="">-- Select Gender--</option>    
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="col-6 form-group">
                        <label for="">Date of Birth</label>
                        <input type="date" class="form-control input-style here" name="date" value="" id="db" placeholder="Date of birth">
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 form-group">
                        <label for="">Country</label>
                        <select name="country"  class="input-style form-control " id="country">
                            <option value="">-- Select Country--</option>    
                            @foreach($country_data as $country)
                            <option value="{{$country->name}}">{{$country->name}}</option>
                            @endforeach
                        </select>  
                    </div>
                    <div class="col-6 form-group">
                        <label for="">State</label>
                        <select name="state"  class="input-style form-control " id="state">
                            <option value="">-- Select State--</option>    
                            @foreach($state_data as $state)
                            <option value="{{$state->name}}">{{$state->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 form-group">
                        <label for="">City</label>
                        <select name="city"  class="input-style form-control " id="city">
                            <option value="">-- Select City--</option>    
                            @foreach($city_data as $city)
                            <option value="{{$city->name}}">{{$city->name}}</option>
                            @endforeach
                        </select>  
                    </div>
                    <div class="col-6 form-group">
                        <label for="">ZipCode</label>
                        <input type="text" class="input-style form-control{{ $errors->has('zipcode') ? ' is-invalid' : '' }}" id="zipcode" name="zipcode" value="" placeholder="Pin Code"  >

                        @if ($errors->has('zipcode'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('zipcode') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control input-style" name="address" id="address"  rows="6" placeholder="Address"></textarea>
                    </div>
                </div>
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

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#profile-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#getFile").change(function(){
        readURL(this);
        $('#userImage').hide();
        $('.newdp').show();
    });

    

// get World
$('#country').change(function(){
    var countryName = $(this).val();    
    if(countryName){
        $.ajax({
            type:"GET",
            url:"{{url('get-state-list')}}?country_id="+countryName,
            success:function(res){               
                if(res){
                    $("#state").empty();
                    $("#state").append('<option>Select</option>');
                    $.each(res,function(key,value){
                        $("#state").append('<option value="'+value+'">'+value+'</option>');
                    });

                }else{
                    $("#state").empty();
                }
            }
        });
    }else{
        $("#state").empty();
        $("#city").empty();
    }      
});
$('#state').on('change',function(){
var stateName = $(this).val();  //console.log(stateName);  
if(stateName){
    $.ajax({
        type:"GET",
        url:"{{url('get-city-list')}}?city_id="+stateName,
        success:function(res){               
            if(res){
                $("#city").empty();
                $.each(res,function(key,value){
                    $("#city").append('<option value="'+value+'">'+value+'</option>');
                });

            }else{
                $("#city").empty();
            }
        }
    });
}else{
    $("#city").empty();
}

});
</script>
<style type="text/css">
    .windows-firm-Box,
    .input-style{
        width: 100%;
    }
</style>
@endsection
