@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>My Members</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">List <span style="float: right;"> <a href="{{ URL::previous() }}"><button type="button" class="btn btn-danger btn-sm">
<span class="fa fa-chevron-left"></span> Back</button></a></span></h3>
                        </div>

                        <div class="box-body">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm" onClick="refreshPage()">
                                    <i class="fa fa-refresh"></i> Refresh
                                </button>
                            </div>
                            <span class="user-active">Active Member - {{$activeMembers}}</span>
                            <span class="user-deactive"> Deactive Member - {{$deactiveMembers}}</span>
                        </div>

                        <div class="box-body">
                            <table class="table table-hover on-mob-scroll-table-full">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th><input type="checkbox" id="master"> Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Code</th>
                                    <th>Refer</th>
                                    <th>Member</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($myMembers as $myMember)
                                    <tr class="clickable-row" data-href='/member/with-member/{{$myMember->id}}' style="cursor: pointer;">
                                        <td>{{ $myMember->id }}</td>
                                        <td>{{ $myMember->name }}</td>
                                        <td>{{ $myMember->email }}</td>
                                        <td>{{ $myMember->phone_no }}</td>
                                        <td>{{ $myMember->member_code }}</td>
                                        <td>{{ $myMember->refer_code }}</td>
                                        <td>{{ $myMember->down_member }}</td>
                                        <td>@if($myMember->status == 1)
                                            <span class="user-active">Verified</span>
                                            @else
                                            <span class="user-deactive">Unverified</span>
                                            @endif
                                            </td>
                                    </tr>
                                    </a>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
 <script type="text/javascript" src="/public/jquery/jquery-3.2.1.min.js"></script>
<script>

  jQuery(document).ready(function($) {
      $(".clickable-row").click(function(e) {
        
          window.location = $(this).data("href");
        
      });
  });
</script>
@endsection