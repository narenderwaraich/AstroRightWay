@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Members</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">List</h3>
                        </div>

                        <div class="box-body">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm" onClick="refreshPage()">
                                    <i class="fa fa-refresh"></i> Refresh
                                </button>
                                <a href="/member/1/list">
                                    <button type="button" class="btn btn-success btn-sm">Active</button>
                                </a>
                                <a href="/member/0/list">
                                    <button type="button" class="btn btn-danger btn-sm">Deactive</button>
                                </a>
                                <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal" id="sendButton">
                                   <i class="fa fa fa-envelope"></i> Send Mail
                                </a>
                                <a href="/member/list" id="clearBtn" style="display: none;">
                                  <button type="button" class="btn btn-secondary btn-sm">Clear</button>
                              </a>
                            </div>
                        </div>

                        <div class="box-body">
                            <form action="/member/search" method="GET" id="SearchData" role="search"> 
                              <div class="input-group">
                                <input type="text" name="q" value="{{request('q')}}" id="search" class="form-control" placeholder="Search User by name, email, phone">
                                <div class="input-group-append">
                                  <button class="btn btn-secondary" type="submit" style="width: 80px;">
                                    <i class="fa fa-search"></i>
                                  </button>
                                </div>
                              </div>
                          </form>
                          <div class="col-md-12 col-sm-12 result-status">
                            @if(isset($message))
                                 <p>{{ $message }}</p>
                            @endif
                          </div>


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
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($member as $memberData)
                                    <tr class="clickable-row" data-href='/member/with-member/{{$memberData->id}}' style="cursor: pointer;">
                                        <td>{{ $memberData->id }}</td>
                                        <td>{{ $memberData->name }}</td>
                                        <td>{{ $memberData->email }}</td>
                                        <td>{{ $memberData->phone_no }}</td>
                                        <td>{{ $memberData->member_code }}</td>
                                        <td>{{ $memberData->refer_code }}</td>
                                        <td>{{ $memberData->down_member }}</td>
                                        <td>@if($memberData->status == 1)
                                            <span class="user-active">Verified</span>
                                            @else
                                            <span class="user-deactive">Unverified</span>
                                            @endif
                                            </td>
                                        <td>
                                        @if($memberData->status == 0)
                                        <a href="/member/verified/{{ $memberData->id }}" class="btn btn-success  on-mob-table-btn">Verify</a>
                                        @endif
                                        @if($memberData->suspend)
                                            <a href="/member/suspend-member/{{$memberData->id}}" class="btn btn-success on-mob-table-btn">Enable</a>
                                        @else
                                            <a href="/member/suspend-member/{{$memberData->id}}" class="btn btn-warning on-mob-table-btn">Disable</a>
                                        @endif
                                        <a href="/member/edit/{{ $memberData->id }}" class="btn btn-secondary">Edit</a>
                                        <a onclick="return removeAlert();" href="/member/delete/{{ $memberData->id }}" class="btn btn-danger on-mob-table-btn">Delete</a>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $member->links() !!}

                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>


<!--Send Mail Modal -->
                                    <div class="modal fade" id="myModal" role="dialog">
                                      <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <div class="modal-title-text">
                                              Send Invoice
                                            </div>
                                            <button type="button" class="close" data-dismiss="modal" style="float: right;">&times;</button>
                                          </div>
                                          <div class="modal-body">
                                            <!-- <img src="/images/loader.gif" id="loading" style="height: 65px;"> -->
                                            <form  id="MailData" method="post">
                                                {{ csrf_field() }}
                                            <div class="form-group">
                                                <label for="title">Subject</label>
                                                <input type="text" name="subject" placeholder="Subject" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="title">Message</label>
                                                <textarea name="message" rows="5" placeholder="Message" class="form-control" required></textarea>
                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            
                                            <center><button type="submit" id="send-mail-btn" class="btn modal-btn">
                                              <span id="send-btn">Send</span>
                                              <span id="mail-button-sending" style="display:none;">Sending…</span>
                                              </button></center>
                                          </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>

 <script type="text/javascript" src="/public/jquery/jquery-3.2.1.min.js"></script>
<script>

  jQuery(document).ready(function($) {
      $(".clickable-row").click(function(e) {
        
          window.location = $(this).data("href");
        
      });
  });
  /// hide search button
      if($('#search').val()!=""){
        $('#clearBtn').show();
      }
    $(document).ready(function () {

          // select all 
        $('#master').on('click', function(e) {
         if($(this).is(':checked',true))  
         {
            $(".sub_chk").prop('checked', true);
         } else {  
            $(".sub_chk").prop('checked',false); 
         }  
        });
    });


                    /// mail send model
                            $("form#MailData").submit(function(e) {
                              e.preventDefault();    
                              var formData = new FormData(this);
                              $.ajax({
                                  url: '/send-notificaton-mail',
                                  type: 'POST',
                                  data: formData,
                                  beforeSend: function() {
                                      $('#send-btn').hide();
                                      $('#mail-button-sending').show();
                                      $("#send-mail-btn").attr("disabled", "disabled");
                                  },
                                  success: function (data) {
                                     if (data['success']) {
                                      $('#loading').hide();
                                      toastr.success("Mail Sent successfully","Mail");
                                      $('#myModal').hide();
                                      $(".modal .close").click();
                                          location.reload();
                                          //$('.msgMail').append(data .msg);
                                          // $('#hidediv').show();
                            } else if (data['error']) {
                                toastr.error("Sorry","Mail");
                                $('#myModal').hide();
                                $(".modal .close").click();
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        },
                                  cache: false,
                                  contentType: false,
                                  processData: false
                              });
                          });

</script>


@endsection