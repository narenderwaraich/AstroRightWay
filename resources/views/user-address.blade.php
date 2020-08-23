@extends('layouts.app')
@section('content')
  <div class="banner">
  <img src="/public/images/banner/banner-bg.jpg" alt=""/>
  <div class="slider-imge-overlay"></div>
  <div class="caption text-center">
    <div class="container">
      <div class="caption-in">
        <div class="caption-ins">
          <h1>Hello<span>Test</span></h1>
          <div class="links"> 
            <a href="#" class="btns slider-btn"><span>Button</span></a> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="windows-firm-Box">
  <div class="top-tile">
    Add Address
  </div>
  <div class="windows-form">
     <form action="/add-user-address/{{ auth()->user()->id }}" method="post"  class="profile-form">
        @csrf
  <div class="row">
    <div class="col-12">
            <input id="phone" type="number" class="input-style form-control{{ $errors->has('phone_no') ? ' is-invalid' : '' }}" name="phone_no" value="{{ old('phone_no') }}" placeholder="Phone" required autofocus>

            @if ($errors->has('phone_no'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('phone_no') }}</strong>
                </span>
            @endif
            <select name="country"  class="input-style form-control " id="country">
                <option value="">-- Select Country--</option>    
                @foreach($country_data as $country)
                    <option value="{{$country->name}}">{{$country->name}}</option>
                @endforeach
            </select> 

            <select name="state"  class="input-style form-control " id="state">
                <option value="">-- Select State--</option>    
                @foreach($state_data as $state)
                      <option value="{{$state->name}}">{{$state->name}}</option>
                @endforeach
            </select>

            <select name="city"  class="input-style form-control " id="city">
                <option value="">-- Select City--</option>    
                @foreach($city_data as $city)
                      <option value="{{$city->name}}">{{$city->name}}</option>
                @endforeach
            </select>  

                <!-- <input type="text" class="input-style form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" placeholder="City"  autofocus> -->
            

            <input type="text" class="input-style form-control{{ $errors->has('zipcode') ? ' is-invalid' : '' }}" name="zipcode" placeholder="Pin Code"  autofocus>

            @if ($errors->has('zipcode'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('zipcode') }}</strong>
                </span>
            @endif

            <textarea class="form-control input-style" name="address"  rows="2" placeholder="Address"></textarea>
        </div>
            <button type="submit" class="btn sub-btn" >Submit</button>
    </div>
</div>
</form>
</div>

      <span id="userName" style="display: none;">{{Auth::user()->name}}</span>
            


    <script type="text/javascript" src="/public/js/jquery-3.2.1.min.js"></script>

<script type="text/javascript">
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
@endsection