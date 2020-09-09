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
        
    </div>  <!-- end bootstrap -->
</div>  <!-- Content End -->

<script type="text/javascript" src="/public/jquery/jquery-3.2.1.min.js"></script>        
<script>
jQuery(document).ready(function($) {
      $(".clickable-row").click(function(e) {
        
          window.location = $(this).data("href");
        
      });
  });
</script>
@endsection