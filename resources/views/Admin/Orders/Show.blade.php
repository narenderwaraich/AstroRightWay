@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Orders</h1>
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
                            </div>
                        </div>

                        <div class="box-body">
                            <table class="table table-hover scroll-table-full">
                                <thead>
                                <tr>
                                     <th>Order No.</th>
                                     <th>Method</th>
                                     <th>Subtotal</th>
                                     <th>Shiping</th>
                                     <th>Discount</th>
                                     <th>Amount</th>
                                     <th>Status</th>
                                     <th>Address</th>
                                     <th width="290px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->method }}</td>
                                        <td>{{ $order->subtotal }}</td>
                                        <td>{{ $order->ship_charge }}<!-- @if($order->status == 0)<p class="avaibility"><i class="fa fa-circle"></i> In Stock</p>@else<p class="avaibility"><i class="fa fa-circle" style="color: red;"></i> Out of Stock</p>@endif --></td>
                                        <td>{{ $order->discount }}</td>
                                        <td>{{ $order->net_amount }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td>
                                            <div>{{ $order->userAddress }}</div>
                                            <div>{{ $order->userPINCode }} {{ $order->userCity }}</div>
                                            <div>{{ $order->userState }} {{ $order->userCountry }}</div>
                                          </td>
                                        <td>
                                    @if($order->status != 'Cancel') 
                                        @if($order->status == 'Pending' || $order->status == 'Process')   
                                        <a href="/orders/accept/{{ $order->id }}"><button class="btn btn-success">Accept</button></a>
                                        <button data-toggle="modal" data-target="#rejectOrderModel" id="openModel" type="button" class="btn btn-danger rejectBtnModal" data-id="{{ $order->id }}">Reject</button>
                                        <!-- <a href="/orders/reject/{{ $order->id }}"><button class="btn btn-danger on-mob-table-btn">Reject</button></a> -->
                                        @endif
                                        @if($order->status == 'Accept')
                                        <!-- <a href="/orders/dispatch/{{ $order->id }}"> --><button data-toggle="modal" data-target="#sendTrackCode" id="openModel" type="button" class="btn btn-info btnModal" data-id="{{ $order->id }}">Dispatch</button><!-- </a> -->
                                        @endif
                                        @if($order->status == 'Dispatch') 
                                        <a href="/orders/complete/{{ $order->id }}"><button class="btn btn-success">Complete</button></a>
                                        @endif
                                        @if($order->status == 'Complete') 
                                        <a href="#"><button class="btn btn-success">Close</button></a>
                                        @endif
                                    @endif
                                    @if($order->status == 'Cancel')
                                    <a href="#"><button class="btn btn-danger disabled">Cancel</button></a>
                                    @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $orders->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

    <!-- Add sendTrackCode Model -->

        <div class="modal fade" id="sendTrackCode" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-backdrop="static">
          <div class="modal-dialog modal-sm" role="document">
              <div class="modal-content">
                <div class="modal-header">
                            <div class="modal-title-text">
                              Dispatch Code
                            </div>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                  <div class="modal-body">
                      <form id="orderData" method="post" enctype="multipart/form-data">
                         {{ csrf_field() }}
                          <div class="form-group">
                              <label>Code</label>
                              <input type="text" class="form-control model-form-input" name="code" placeholder="Enter Code" required>
                              <input type="hidden" name="dispatch_id" id="orderID">
                          </div>
                      
                         </div>
                           <div class="modal-footer">
                            
                            <center><button type="submit" id="send-mail-btn" class="btn modal-btn">
                                  <span id="send-btn">Send</span>
                                  <span id="mail-button-sending" style="display:none;">Sending…</span>
                                  </button>
                            </center> 
                          </div>
                        </form>
                  </div>
              </div>
          </div>

 <!-- End model -->

     <!-- Add rejectOrderModel Model -->

        <div class="modal fade" id="rejectOrderModel" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-backdrop="static">
          <div class="modal-dialog modal-sm" role="document">
              <div class="modal-content">
                <div class="modal-header">
                            <div class="modal-title-text">
                              Reject Order
                            </div>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                  <div class="modal-body">
                      <form id="orderData" method="post" enctype="multipart/form-data">
                         {{ csrf_field() }}
                          <div class="form-group">
                              <label>Message</label>
                              <textarea name="message"  rows="5" placeholder="Message" class="form-control model-form-input" maxlength="300" minlength="5" required></textarea>
                              <input type="hidden" name="reject_id" id="rejectOrderID">
                          </div>
                      
                         </div>
                           <div class="modal-footer">
                            
                            <center><button type="submit" id="send-mail-btn" class="btn modal-btn">
                                  <span id="reject-send-btn">Send</span>
                                  <span id="reject-mail-btn-sending" style="display:none;">Sending…</span>
                                  </button>
                            </center> 
                          </div>
                        </form>
                  </div>
              </div>
          </div>

 <!-- End model -->

<script src="/public/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript">

                $(".btnModal").click(function () {
                    var passedID = $(this).data('id');//get the id of the selected button
                    $('#orderID').val(passedID);//set the id to the input on the modal
                });

                $("form#orderData").submit(function(e) {
                  e.preventDefault();    
                  var formData = new FormData(this);

                  $.ajax({
                      url: '/orders/dispatch', 
                      type: 'POST',
                      data: formData,
                      beforeSend: function() {
                          $('#send-btn').hide();
                          $('#mail-button-sending').show();
                      },
                      success: function (data) {
                          // console.log(data);
                          $('#sendTrackCode').hide(); /// hide modal 
                          $(".modal .close").click(); /// close modals
                          if (data['success']) {
                                toastr.success("Order Dispatch","Success");
                                
                            } else if (data['error']) {
                               toastr.error(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                            setTimeout(function(){
                              location.reload();
                            }, 1000);
                      },
                      error: function (data) {
                        alert(data.responseText);
                    },
                      cache: false,
                      contentType: false,
                      processData: false
                  });

                  $(".rejectBtnModal").click(function () {
                    var passedID = $(this).data('id');//get the id of the selected button
                    $('#rejectOrderID').val(passedID);//set the id to the input on the modal
                  });


                  $.ajax({
                      url: '/orders/reject', 
                      type: 'POST',
                      data: formData,
                      beforeSend: function() {
                          $('#reject-send-btn').hide();
                          $('#reject-mail-btn-sending').show();
                      },
                      success: function (data) {
                          // console.log(data);
                          $('#rejectOrderModel').hide(); /// hide modal 
                          $(".modal .close").click(); /// close modals
                          if (data['success']) {
                                toastr.success("Order Reject","Success");
                                
                            } else if (data['error']) {
                               toastr.error(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                            setTimeout(function(){
                              location.reload();
                            }, 1000);
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