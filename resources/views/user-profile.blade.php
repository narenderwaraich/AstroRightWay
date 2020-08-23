@extends('layouts.app')
@section('content')
@if(isset($banner->image))
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

<!-- Content -->
<div class="container m-t-70 m-b-70">
    <div class="user-pro-section">
         <div class="row">
            <div class="col-sm-12">
              <h1>{{ Auth::user()->name }}
              </h1>
            </div>
          </div>

          <div class="row m-t-30">
            <div class="col-sm-3"><!--left col-->
                <div class="text-center">
                    @if(empty(Auth::user()->avatar))
                    <img src="" class="dp-show newdp" id="profile-img-tag" alt="avatar" style="display: none;">
                    <div id="userImage"></div>
                    @else
                    <img src="{{asset('/public/images/user/'.Auth::user()->avatar)}}" alt="{{ Auth::user()->name }}" class="dp-show" id="profile-img-tag">
                    @endif
                    <button type="button" class="btn img-upload btn-style" onclick="document.getElementById('getFile').click()">Upload</button>
                </div>
            </hr><br>
            <ul class="list-group">
              <li class="list-group-item text-muted">Orders <i class="fa fa-dashboard fa-1x"></i></li>
              <li class="list-group-item text-right"><span class="pull-left"><strong>Order</strong></span>0</li>
            </ul> 
            </div><!--/col-md-3-->

            <div class="col-sm-9 on-mob-top-35">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#profile">Profile</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#address">Address</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#password-tab">Password</a>
                  </li>
                </ul>
            <!-- Tab panes -->
                <div class="tab-content">
                    <div id="profile" class="container tab-pane active"><br>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                  <div class="col-md-12">
                                    <h4>Your Profile</h4>
                                    <hr>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-12">
                                    <form method="POST" action="/user-profile-update/{{ auth()->user()->id }}"  enctype="multipart/form-data" class="profile-form">
                                      @csrf
                                      <div class="form-group row">
                                        <label for="username" class="col-md-3 col-form-label">Name</label> 
                                        <div class="col-md-9">
                                          <input id="username" name="name" placeholder="Name" class="form-control input-style here {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ Auth::user()->name }}" required="required" type="text">
                                          @if ($errors->has('name'))
                                          <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                          </span>
                                          @endif
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="email" class="col-md-3 col-form-label">Email</label> 
                                        <div class="col-md-9">
                                          <input id="email" name="email" placeholder="Email" class="form-control input-style here {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ Auth::user()->email }}" required="required" type="text">
                                          @if ($errors->has('email'))
                                          <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                          </span>
                                          @endif
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="mobile" class="col-md-3 col-form-label">Mobile</label>
                                        <div class="col-md-9">
                                          <input type="number" class="form-control input-style here {{ $errors->has('phone_no') ? ' is-invalid' : '' }}" name="phone_no" value="{{ Auth::user()->phone_no }}" id="mobile" placeholder="enter mobile number" title="enter your mobile number if any.">
                                          @if ($errors->has('phone_no'))
                                          <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone_no') }}</strong>
                                          </span>
                                          @endif
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="select" class="col-md-3 col-form-label">Gender</label> 
                                        <div class="col-md-9">
                                          <select name="gender" id="select" required class=" input-style form-control ">
                                            <option value="{{ Auth::user()->gender }}">-- Select Gender--</option>    
                                            <option value="male" @if (Auth::user()->gender == "male") {{ 'selected' }} @endif>Male</option>
                                            <option value="female" @if (Auth::user()->gender == "female") {{ 'selected' }} @endif>Female</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="db" class="col-md-3 col-form-label">Date of Birth</label>
                                        <div class="col-md-9">
                                          <input type="date" class="form-control input-style here" name="date" value="{{ Auth::user()->date }}" id="db" placeholder="Date of birth">
                                        </div>
                                      </div>

                                      <input type="file" name="avatar" value="{{Auth::user()->avatar}}" style="visibility: hidden;" id="getFile">
                                      <div class="form-group row" style="margin-top: -20px;margin-bottom: 20px;">
                                        <div class="col-12">
                                          <button name="submit" type="submit" class="btn btn-style">Update</button>
                                        </div>
                                      </div>
                                    </form>
                                   </div>
                               </div>

                            </div>
                        </div>
                    </div>

                    <div id="address" class="container tab-pane fade"><br>
                        @if(isset($userAddress))
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                  <div class="col-md-12">
                                    <h4>Update Address</h4>
                                    <hr>
                                  </div>
                                </div>
                            <form action="/update-user-address/{{ $userAddress->id }}" method="post"  class="profile-form">
                                @csrf
                                <div class="form-group row">
                                  <label for="country" class="col-md-3 col-form-label">Country</label> 
                                  <div class="col-md-9">
                                    <select name="country"  class="input-style form-control " id="country">
                                        <option value="">-- Select Country--</option>    
                                        @foreach($country_data as $country)
                                            <option value="{{$country->name}}" {{$country->name == $userAddress->country  ? 'selected' : ''}}>{{$country->name}}</option>
                                        @endforeach
                                    </select>  
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="state" class="col-md-3 col-form-label">State</label> 
                                  <div class="col-md-9">
                                <select name="state"  class="input-style form-control " id="state">
                                    <option value="">-- Select State--</option>    
                                    @foreach($state_data as $state)
                                          <option value="{{$state->name}}" {{$state->name == $userAddress->state  ? 'selected' : ''}}>{{$state->name}}</option>
                                    @endforeach
                                </select>

                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="city" class="col-md-3 col-form-label">City</label> 
                                  <div class="col-md-9">
                                <select name="city"  class="input-style form-control " id="city">
                                    <option value="">-- Select City--</option>    
                                      @foreach($city_data as $city)
                                          <option value="{{$city->name}}" {{$city->name == $userAddress->city  ? 'selected' : ''}}>{{$city->name}}</option>
                                      @endforeach
                                </select>  

                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="zipcode" class="col-md-3 col-form-label">Pin Code</label> 
                                  <div class="col-md-9">

                                    <input type="text" class="input-style form-control{{ $errors->has('zipcode') ? ' is-invalid' : '' }}" id="zipcode" name="zipcode" value="{{ $userAddress->zipcode }}" placeholder="Pin Code"  >

                                            @if ($errors->has('zipcode'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('zipcode') }}</strong>
                                                </span>
                                            @endif
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="address" class="col-md-3 col-form-label">Address</label> 
                                  <div class="col-md-9">
                                <textarea class="form-control input-style" name="address" id="address"  rows="2" placeholder="Address">{{$userAddress->address}}</textarea>

                                  </div>
                                </div>
                                  <div class="form-group row" style="margin-bottom: 13px;">
                                    <div class="col-12">
                                      <button name="submit" type="submit" class="btn btn-style">Update</button>
                                    </div>
                                  </div>
                            </form>
                            </div>
                        </div>
                        @else
                        <!-- address add -->
                          <div class="card">
                            <div class="card-body">
                                <div class="row">
                                  <div class="col-md-12">
                                    <h4>Add Address</h4>
                                    <hr>
                                  </div>
                                </div>
                            <form action="/add-user-address/{{ auth()->user()->id }}" method="post"  class="profile-form">
                                @csrf
                                <div class="form-group row">
                                  <label for="country" class="col-md-3 col-form-label">Country</label> 
                                  <div class="col-md-9">
                                    <select name="country"  class="input-style form-control " id="country">
                                            <option value="">-- Select Country--</option>    
                                            @foreach($country_data as $country)
                                                <option value="{{$country->name}}">{{$country->name}}</option>
                                            @endforeach
                                            </select> 
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="state" class="col-md-3 col-form-label">State</label> 
                                  <div class="col-md-9">
                                <select name="state"  class="input-style form-control " id="state">
                                                <option value="">-- Select State--</option>    
                                                @foreach($state_data as $state)
                                                      <option value="{{$state->name}}">{{$state->name}}</option>
                                                @endforeach
                                            </select>

                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="city" class="col-md-3 col-form-label">City</label> 
                                  <div class="col-md-9">
                                <select name="city"  class="input-style form-control " id="city">
                                                <option value="">-- Select City--</option>    
                                                @foreach($city_data as $city)
                                                      <option value="{{$city->name}}">{{$city->name}}</option>
                                                @endforeach
                                            </select> 

                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="zipcode" class="col-md-3 col-form-label">Pin Code</label> 
                                  <div class="col-md-9">

                                    <input type="text" class="input-style form-control{{ $errors->has('zipcode') ? ' is-invalid' : '' }}" id="zipcode" name="zipcode" placeholder="Pin Code"  >

                                            @if ($errors->has('zipcode'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('zipcode') }}</strong>
                                                </span>
                                            @endif
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="address" class="col-md-3 col-form-label">Address</label> 
                                  <div class="col-md-9">
                                <textarea class="form-control input-style" name="address" id="address"  rows="2" placeholder="Address"></textarea>

                                  </div>
                                </div>
                                  <div class="form-group row" style="margin-bottom: 13px;">
                                    <div class="col-12">
                                      <button name="submit" type="submit" class="btn btn-style">Submit</button>
                                    </div>
                                  </div>
                            </form>
                            </div>
                        </div>
                        <!-- end -->
                        @endif
                    </div>

                    <div id="password-tab" class="container tab-pane fade"><br>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                  <div class="col-md-12">
                                    <h4>Change Password</h4>
                                    <hr>
                                  </div>
                                </div>

                            <form action="/change-password" method="post">
                                {{ csrf_field() }}
                                <div class="form-group row">
                                      <label for="old_password" class="col-md-3 col-form-label">Old Password</label> 
                                      <div class="col-md-9">
                                    <input type="password" name="old_password" id="old_password" class="form-control pass-filed input-style {{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="Enter Old Password" required>
                                                @if ($errors->has('old_password'))
                                                      <span class="invalid-feedback" role="alert" style="text-align: center;padding-bottom: 10px">
                                                          <strong>{{ $errors->first('old_password') }}</strong>
                                                      </span>
                                                @endif

                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label for="password" class="col-md-3 col-form-label">New Password</label> 
                                      <div class="col-md-9">
                                    <input type="password" name="password" id="password" class="form-control pass-filed input-style {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Enter New Password" required>
                                                @if ($errors->has('password'))
                                                      <span class="invalid-feedback" role="alert" style="text-align: center;padding-bottom: 10px">
                                                          <strong>{{ $errors->first('password') }}</strong>
                                                      </span>
                                                @endif

                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label for="password_confirmation" class="col-md-3 col-form-label">Confirm Password</label> 
                                      <div class="col-md-9">
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control pass-filed input-style {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" placeholder="Confirm Password" required>
                                                @if ($errors->has('password_confirmation'))
                                                  <span class="invalid-feedback" role="alert" style="text-align: center;padding-bottom: 10px">
                                                      <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                  </span>
                                                @endif

                                      </div>
                                    </div>

                                    <input type="checkbox" onclick="myFunction()" class="chk-box"> &nbsp; <b>Show Password</b>
                                                <br>
                                    <div class="form-group row" style="margin-bottom: 15px;">
                                        <div class="col-12">
                                          <button name="submit" type="submit" class="btn btn-style">Submit</button>
                                        </div>
                                    </div>

                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- End Tab panes -->
            </div><!--/col-md-9-->
          </div> <!-- row end -->
        
    </div>  <!-- end bootstrap -->
</div>  <!-- Content End -->

<span id="user_full_name" style="display: none;">{{Auth::user()->name}}</span>
<script type="text/javascript" src="/public/jquery/jquery-3.2.1.min.js"></script>        
<script>
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

    $(document).ready(function(){
         var userName = $('#user_full_name').text();
         var intials = userName.charAt(0);
         var profileImage = $('#userImage').text(intials);
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

        /// Change Password
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