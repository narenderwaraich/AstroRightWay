@extends('layouts.master')
@section('content')

  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
            <h1>Profile</h1>
        </section>
      <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <form action="/astrologer/update/{{ $astrologer->id }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                      <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit <span style="float: right;">
                                  <a href="{{ URL::previous() }}">
                                    <button type="button" class="btn btn-danger btn-sm">
                                      <span class="fa fa-chevron-left"></span> Back
                                    </button>
                                  </a>
                                </span>
                                </h3>
                            </div>


                            <div class="box-body">
                                <div class="form-group">
                                    <label for="title">Name</label>
                                    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" placeholder="Enter Name" value="{{ $astrologer->name }}" required>
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                                </div>


                     <div class="col-md-12">
                        <label class="user-input-label">Profile Image</label>
                        <div class="form-group">
                          <button type="button" class="btn secondary_btn" id="selectFile">Change</button>
                        </div>
                        <img src="/public/images/user/{{ $astrologer->avatar }}" id="profile-img-tag" class="show-product-img">
                          <input type="file" name="avatar" id="getFile" accept="/image/*" style="visibility: hidden;">
                        </div>
                              

                                <div class="form-group">
                                    <label for="title">Phone</label>
                                    <input type="text" class="form-control {{ $errors->has('phone_no') ? ' is-invalid' : '' }}" name="phone_no" placeholder="Enter Phone Number" value="{{ $astrologer->phone_no }}" required>
                                @if ($errors->has('phone_no'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone_no') }}</strong>
                                </span>
                                @endif
                                </div>

                                <div class="form-group">
                                    <label for="title">Gender</label>
                                      <select class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender" required>
                                        <option value="">-- Select Gender--</option>
                                        <option value="male" {{ $astrologer->gender == "male" ? "selected":"" }}>Male</option>
                                        <option value="female" {{ $astrologer->gender == "female" ? "selected":"" }}>Female</option>
                                      </select>
                                 </div>

                                <div class="form-group">
                                    <label for="title">Date of Birth</label>
                                    <input type="date" class="form-control {{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" placeholder="Enter Date of Birth" value="{{ $astrologer->date }}" required>
                                @if ($errors->has('date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('date') }}</strong>
                                </span>
                                @endif
                                </div>

                                 <div class="form-group">
                                    <label for="title">Country</label>
                                      <select name="country"  class="form-control " id="country">
                                          <option value="">-- Select Country--</option>    
                                          @foreach($country_data as $country)
                                          <option value="{{$country->name}}" {{ $astrologer->country == $country->name ? "selected":"" }}>{{$country->name}}</option>
                                          @endforeach
                                      </select>  
                                 </div>

                                 <div class="form-group">
                                    <label for="title">State</label>
                                     <select name="state"  class="form-control " id="state">
                            <option value="">-- Select State--</option>    
                            @foreach($state_data as $state)
                            <option value="{{$state->name}}" {{ $astrologer->state == $state->name ? "selected":"" }}>{{$state->name}}</option>
                            @endforeach
                        </select> 
                                 </div>

                                 <div class="form-group">
                                    <label for="title">City</label>
                                      <select name="city"  class="input-style form-control " id="city">
                            <option value="">-- Select City--</option>    
                            @foreach($city_data as $city)
                            <option value="{{$city->name}}" {{ $astrologer->city == $city->name ? "selected":"" }}>{{$city->name}}</option>
                            @endforeach
                        </select>  
                                 </div>

                                 <div class="form-group">
                                    <label for="title">ZipCode</label>
                                    <input type="text" class="form-control" name="zipcode" placeholder="Enter ZipCode" value="{{ $astrologer->zipcode }}" required>
                                </div>

                                  <div class="form-group">
                                    <span style="float: right;font-size: 14px;">(max length 150) <span id="charNum"></span></span>
                                    <label for="title">Address</label>
                                    <textarea name="address" id="proDesc"  rows="5" placeholder="Address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" maxlength="150" minlength="5" required onkeyup="countChar(this)">{{$astrologer->address}}</textarea>
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
 });
</script>
@endsection