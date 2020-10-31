@extends('layouts.master')
@section('content')

<section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
        <h1>Profit</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="/profit-record/store" method="post">
                    {{ csrf_field() }}
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create <span style="float: right;">
                                <a href="{{ URL::previous() }}"><button type="button" class="btn btn-danger btn-sm">
                                    <span class="fa fa-chevron-left"></span> Back
                                </button></a></span>
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="title">Order Id</label>
                                <input type="text" class="form-control" name="order_id" placeholder="Enter Order Id" required>
                            </div>
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="number" class="form-control" name="amount" placeholder="Enter Amount">
                            </div>
                            <div class="form-group">
                                <label>Astrologer Security</label>
                                <input type="number" class="form-control" name="astrologer_security" placeholder="Enter  Id">
                            </div>
                            <div class="form-group">
                                <label>Astrologer Message</label>
                                <input type="number" class="form-control" name="astrologer_msg_profit" placeholder="Enter Astrologer Message">
                            </div>
                            <div class="form-group">
                                <label>Order Profit</label>
                                <input type="number" class="form-control" name="order_profit" placeholder="Enter Order Profit">
                            </div>
                            <div class="form-group">
                                <label>Message Payment</label>
                                <input type="number" class="form-control" name="message_payment" placeholder="Enter message_payment">
                            </div>
                            <div class="form-group">
                                <label>Astrologer Id</label>
                                <input type="number" class="form-control" name="astrologer_id" placeholder="Enter Astrologer Id">
                            </div>
                            <div class="form-group">
                                <label>User Id</label>
                                <input type="number" class="form-control" name="user_id" placeholder="Enter User Id">
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</section>
@endsection