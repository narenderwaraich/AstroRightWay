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

<!-- Content -->
<div class="container m-t-70 m-b-70">
    <div class="user-pro-section">
         <div class="row">
            <div class="col-sm-12">
              <h1>{{ $member->name }}
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
                </div>
            </hr><br>
            <ul class="list-group">
              <li class="list-group-item text-muted">Achivement <i class="fa fa-dashboard fa-1x"></i></li>
              <li class="list-group-item text-right"><span class="pull-left"><strong>Level</strong></span>
                <span class="pull-right" style="color: #ce2350;font-weight: 600;">{{ $member->level }}</span></li>
              <li class="list-group-item text-right"><span class="pull-left"><strong>MEMBER CODE</strong></span><span class="pull-right" style="color: #ce2350;font-weight: 600;">{{ $member->member_code }}</span></li>
              <li class="list-group-item text-right"><span class="pull-left"><strong>WORK MEMBER</strong></span><span class="pull-right" style="color: #ce2350;font-weight: 600;">{{ $member->down_member }}</span></li>
              <li class="list-group-item text-right"><span class="pull-left"><strong>Share</strong></span><span class="pull-right" style="color: #ce2350;font-weight: 600;"><button type="button" class="btn" onclick="copyLink()">Copy Link</button>
                <input type="text" name="" value="{{env('APP_URL')}}/join-member/{{$member->member_code}}" id="linkCopy" style="visibility: hidden;">
                </span></li>
              <li class="list-group-item text-right"><span class="pull-left"><strong>WhatApps</strong></span><span class="pull-right">
                <p><a href="whatsapp://send?text=Share my Refer CODE {{env('APP_URL')}}/join-member/{{$member->member_code}}" data-action="share/whatsapp/share" class="btn btn-success"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></p></span>
              </li>

            </ul> 
            </div><!--/col-md-3-->

            <div class="col-sm-9 on-mob-top-35">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#profile">Panel</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#member">Members</a>
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
                                    <form method="POST" action="/member-update/{{ $member->id }}" class="profile-form">
                                      @csrf
                                      <div class="form-group row">
                                        <label for="username" class="col-md-3 col-form-label">Name</label> 
                                        <div class="col-md-9">
                                          <input id="username" name="name" placeholder="Name" class="form-control input-style here {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $member->name }}" required="required" type="text">
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
                                          <input id="email" name="email" placeholder="Email" class="form-control input-style here {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ $member->email }}" required="required" type="text">
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
                                          <input type="number" class="form-control input-style here {{ $errors->has('phone_no') ? ' is-invalid' : '' }}" name="phone_no" value="{{ $member->phone_no }}" id="mobile" placeholder="Mobile Number">
                                          @if ($errors->has('phone_no'))
                                          <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone_no') }}</strong>
                                          </span>
                                          @endif
                                        </div>
                                      </div>
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

                  <div id="member" class="container tab-pane"><br>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                  <div class="col-md-12">
                                    <h4>Your Members</h4>
                                    <hr>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-12">
                                    <table id="members">
                                      <tr>
                                        <th>No.</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Level</th>
                                        <th>Members</th>
                                      </tr>
                                      @foreach($myMembers as $key => $myMember)
                                      <tr class="clickable-row" data-href='/user/member/with-member/{{$myMember->id}}' style="cursor: pointer;">
                                        <td>{{$key +1}}</td>
                                        <td>{{$myMember->member_code}}</td>
                                        <td>{{$myMember->name}}</td>
                                        <td>{{$myMember->phone_no}}</td>
                                        <td>@if($myMember->status ==1)<span style="color: #28a745;">Active</span>@else <span style="color: #dc3545;">Deactive</span> @endif</td>
                                        <td>{{$myMember->level}}</td>
                                        <td>{{$myMember->down_member}}</td>
                                      </tr>
                                      @endforeach
                                    </table>
                                   </div>
                               </div>

                            </div>
                        </div>
                    </div>
                </div>
            <!-- End Tab panes -->
            </div><!--/col-md-9-->
          </div> <!-- row end -->
        
    </div>  <!-- end bootstrap -->
</div>  <!-- Content End -->

<span id="user_full_name" style="display: none;">{{$member->name}}</span>
<script type="text/javascript" src="/public/jquery/jquery-3.2.1.min.js"></script>        
<script>
    $(document).ready(function(){
         var userName = $('#user_full_name').text();
         var intials = userName.charAt(0);
         var profileImage = $('#userImage').text(intials);
         });

    function copyLink() {
  var copyText = document.getElementById("linkCopy");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
  alert("Copied the text: " + copyText.value);
}
jQuery(document).ready(function($) {
      $(".clickable-row").click(function(e) {
        
          window.location = $(this).data("href");
        
      });
  });
</script>
@endsection