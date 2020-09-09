@extends('layouts.astro')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Chat List</h1>
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
                                <a href="/astrologer/Sent/chat">
                                    <button type="button" class="btn btn-success btn-sm">Sent</button>
                                </a>
                                <a href="/astrologer/Reply/chat">
                                    <button type="button" class="btn btn-danger btn-sm">Reply</button>
                                </a>
                                <a href="/astrologer/Pending/chat">
                                    <button type="button" class="btn btn-warning btn-sm">Pending</button>
                                </a>
                            </div>
                        </div>

                        <div class="box-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                     <th>Name</th>
                                     <th>Email</th>
                                    <!--  <th>Phone</th> -->
                                     <th class="on-mob-user-chat">User</th>
                                     <th class="on-mob-admin-chat">Astro</th>
                                     <th width="290px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($getChats as $chat)
                                    <tr>
                                        <td>{{ $chat->name }}</td>
                                        <td>{{ $chat->email }}</td>
                                        <!-- <td></td> -->
                                        <td>
                                            <p>{{ \Illuminate\Support\Str::limit($chat->user_message, 100, '...') }}</p>
                                          </td>
                                          <td>
                                            <p>{{ \Illuminate\Support\Str::limit($chat->reply_message, 100, '...') }}</p>
                                          </td>
                                        <td>
                                        @if($chat->message_status == "Sent")
                                        <a href="/astrologer/chat/reply/{{ $chat->id }}"><button class="btn btn-success">Reply</button></a>
                                        @endif
                                        <a href="/astrologer/chat/view/{{ $chat->id }}"><button class="btn btn-info on-mob-table-btn">View</button></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $getChats->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title-text">
              Change Status
            </div>
            <button type="button" class="close" data-dismiss="modal" style="float: right;">&times;</button>
          </div>
          <div class="modal-body">
            <!-- <img src="/images/loader.gif" id="loading" style="height: 65px;"> -->
            <form  id="MailData" method="post">
                {{ csrf_field() }}
            <div class="form-group">
                <label for="title">Status</label>
                
            </div>
            <input type="hidden" name="" id="invshow">
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
                              var Id = $("#invshow").val();
                              $.ajax({
                                  url: '/change-status'+Id,
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
                                      toastr.success("Status change successfully","Status");
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