@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Users</h1>
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
                            <a href="/user/create" class="btn btn-success btn-sm">
                                  <i class="fa fa-plus"></i> Add new
                              </a>
                              <button type="button" class="btn btn-default btn-sm" onClick="refreshPage()">
                                  <i class="fa fa-refresh"></i> Refresh
                              </button>
                              <a href="/user/1">
                                  <button type="button" class="btn btn-success btn-sm">Active</button>
                              </a>
                              <a href="/user/0">
                                  <button type="button" class="btn btn-danger btn-sm">Deactive</button>
                              </a>
                              <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal" id="sendButton">
                                  <i class="fa fa fa-envelope"></i> Send Mail
                              </a>
                              <a href="/user" id="clearBtn" style="display: none;">
                                  <button type="button" class="btn btn-secondary btn-sm">Clear</button>
                              </a>
                          </div>
                        </div>

                        <div class="box-body">
                          <form action="/user/search" method="GET" id="SearchData" role="search"> 
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
                                    <th>Gender</th>
                                    <th>Google</th>
                                    <th>Profile</th>
                                    <th>Status</th>
                                    <th>Role</th>
                                    <th>Online</th>
                                    <th>Login Type</th>
                                    <th>Login Date</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user as $userData)
                                    <tr class="clickable-row" data-href='/user/{{$userData->id}}/view' style="cursor: pointer;">
                                        <td>{{ $userData->id }}</td>
                                        <td><input type="checkbox" class="sub_chk" data-id="{{$userData->id}}" email-id="{{ $userData->email }}">
                                          {{ $userData->name }}</td>
                                        <td>{{ $userData->email }}</td>
                                        <td>{{ $userData->gender }}</td>
                                        <td>{{ $userData->google_id }}</td>
                                        <td>
                                          @if($userData->avatar)
                                          <img src="{{asset('/public/images/user/'.$userData->avatar)}}" style="width: 100px;height: 100px;border-radius: 100%;border:2px solid #dc3545;">
                                          @endif
                                        </td>
                                        <td>@if($userData->verified == 1)
                                            <span class="user-active">Verified</span>
                                            @else
                                            <span class="user-deactive">Unverified</span>
                                            @endif
                                            </td>
                                        <td>{{ $userData->role }}</td>
                                        <td>@if($userData->online_status == 1)
                                            <span class="user-active">Active</span>
                                            @else
                                            <span class="user-deactive">Inactive</span>
                                            @endif</td>
                                        <td>{{ $userData->login_type }}</td>
                                        <td>{{ $userData->lastLoginDate }}</td>
                                        <td><a href="/user/edit/{{ $userData->id }}" class="btn btn-secondary">Edit</a>
                                        @if($userData->verified == 0)
                                        <a href="/user/verified/{{ $userData->id }}" class="btn btn-success  on-mob-table-btn">Verify</a>
                                         <a href="/user/verified-mail/{{ $userData->id }}" class="btn btn-dark  on-mob-table-btn">Verification Mail</a>
                                        @endif
                                        @if($userData->suspend)
                                            <a href="/user/suspend-user/{{$userData->id}}" class="btn btn-success on-mob-table-btn">Enable</a>
                                        @else
                                            <a href="/user/suspend-user/{{$userData->id}}" class="btn btn-warning on-mob-table-btn">Disable</a>
                                        @endif
                                        <a onclick="return removeAlert();" href="/user/delete/{{ $userData->id }}" class="btn btn-danger on-mob-table-btn">Delete</a>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $user->links() !!}

                            
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
                                            <form action="/send-notificaton-mail"  id="MailData" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="ids" id="store_id">
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
                                            
                                            <center><button type="button" id="send-mail-btn" class="btn modal-btn">
                                              <span id="send-btn">Send</span>
                                              <span id="mail-button-sending" style="display:none;">Sending…</span>
                                              </button></center>
                                          </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
<div id="progress" class="dialogContent" style="text-align: left; display: none;">
  <img src="/public/images/gif/ajax-loader.gif" style="margin: auto;display: block;" />
  <h5 style="margin-top: 10px;">Please wait...</h5>
  <asp:literal id="literalPleaseWait" runat="server" text="Please wait..." />
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
                    $('#send-mail-btn').on('click', function() {
                         var allVals = [];  
                              $(".sub_chk:checked").each(function() {  
                                  allVals.push($(this).attr('data-id'));
                              });  
                              if(allVals.length <=0)  
                              {  
                                  alert("Please select row.");  
                              }else{
                                $('#send-btn').hide();
                                $('#mail-button-sending').show();
                                var join_selected_values = allVals.join(",");  //console.log(join_selected_values);
                                document.getElementById('store_id').value = join_selected_values;
                                $("#MailData").submit();
                              }
                    });
                        //     $("form#MailData").submit(function(e) {
                        //       var allVals = [];  
                        //       $(".sub_chk:checked").each(function() {  
                        //           allVals.push($(this).attr('data-id'));
                        //       });  
                        //       if(allVals.length <=0)  
                        //       {  
                        //           alert("Please select row.");  
                        //       }else{

                        //         var join_selected_values = allVals.join(",");  //console.log(join_selected_values);
                        //         document.getElementById('store_id').value = join_selected_values;
                        //       e.preventDefault();    
                        //       var formData = new FormData(this);
                        //       $.ajax({
                        //           url: '/send-notificaton-mail',
                        //           type: 'POST',
                        //           data: formData,
                        //           beforeSend: function() {
                        //               $('#send-btn').hide();
                        //               $('#mail-button-sending').show();
                        //               $("#send-mail-btn").attr("disabled", "disabled");
                        //               //ShowProgressAnimation();
                        //           },
                        //           success: function (data) {
                        //              if (data['success']) {
                        //               $('#loading').hide();
                        //               toastr.success("Mail Sent successfully","Mail");
                        //               $('#myModal').hide();
                        //               $(".modal .close").click();
                        //                   location.reload();
                        //                   //$('.msgMail').append(data .msg);
                        //                   // $('#hidediv').show();
                        //     } else if (data['error']) {
                        //         toastr.error("Sorry","Mail");
                        //         $('#myModal').hide();
                        //         $(".modal .close").click();
                        //     } else {
                        //         alert('Whoops Something went wrong!!');
                        //     }
                        // },
                        // error: function (data) {
                        //     alert(data.responseText);
                        // },
                        //           cache: false,
                        //           contentType: false,
                        //           processData: false
                        //       });
                        //     } //end else
                        //   });


                    function ShowProgressAnimation() {
                      var pleaseWaitDialog = $("#progress").dialog(
                      {
                      resizable: false,
                      height: 'auto',
                      width: 500,
                      modal: true,
                      title: 'INVOICES',
                      closeText: '',
                      bgiframe: true,
                      closeOnEscape: false,
                      open: function(type, data) {
                      $(this).parent().appendTo($("form:first"));
                      $('body').css('overflow', 'auto'); //IE scrollbar fix for long checklist templates
                      }
                      });
                    }

</script>


@endsection