@extends('layouts.master')
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
                                <a href="/admin/Sent/chat">
                                    <button type="button" class="btn btn-success btn-sm">Sent</button>
                                </a>
                                <a href="/admin/Reply/chat">
                                    <button type="button" class="btn btn-danger btn-sm">Reply</button>
                                </a>
                                <a href="/admin/Pending/chat">
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
                                     <th class="">Assign</th>
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
                                        <td>{{ $chat->astrologer }}</td>
                                        <td>
                                        @if($chat->message_status == "Sent")
                                        <a href="/chat/reply/{{ $chat->id }}"><button class="btn btn-success">Reply</button></a>
                                        <a href="/chat/status/mark-reply/{{ $chat->id }}"><button class="btn btn-dark">Mark Reply</button></a>
                                        @endif
                                        @if($chat->message_status == "Pending")
                                        <a href="/chat/status/mark-sent/{{ $chat->id }}"><button class="btn btn-dark">Mark Sent</button></a>
                                        <a href="#" class="btn btn-warning trnsfer-msg" data-toggle="modal" data-target="#myModal" id="sendButton" data-id="{{ $chat->id }}">
                                            <i class="fa fa-exchange"></i> Transfer
                                        </a>
                                        @endif
                                        <a href="/chat/view/{{ $chat->id }}"><button class="btn btn-info on-mob-table-btn">View</button></a>
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




    <!--Send Mail Modal -->
                                    <div class="modal fade" id="myModal" role="dialog">
                                      <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <div class="modal-title-text">
                                              Transfer Message
                                            </div>
                                            <button type="button" class="close" data-dismiss="modal" style="float: right;">&times;</button>
                                          </div>
                                          <div class="modal-body">
                                            <!-- <img src="/images/loader.gif" id="loading" style="height: 65px;"> -->
                                            <form action="/message-transfer"  id="MailData" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" id="store_id">
                                            <div class="form-group">
                                                <label for="title">Astrologer</label>
                                                <select name="astrologer" id="astrologer"  class="input-style form-control {{ $errors->has('astrologer') ? ' is-invalid' : '' }}" required style="width: 70%;color: #ce2350;height: auto;border: 2px solid #ce2350 !important;">
                                                    <option value="">--Select Astrologer--</option>   
                                                      @foreach($astrologers as $astrologer)
                                                          <option value="{{$astrologer->id}}">{{$astrologer->name}}</option>
                                                      @endforeach
                                                </select>
                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            
                                            <center><button type="submit" class="btn modal-btn">
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
    /// mail send model
                    $('.trnsfer-msg').on('click', function() {
                        var messageId = $(this).attr('data-id'); console.log(messageId);
                        document.getElementById('store_id').value = messageId;
                        // $("#MailData").submit();
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
</script>
@endsection