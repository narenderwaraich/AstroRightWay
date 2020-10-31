@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>All Profit Payments</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">List <span style="float: right;"><a href="/profit-record/add"><i class="fa fa-plus-square-o"></i></a></span></h3>
                        </div>

                        <div class="box-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                     <th>Order Id</th>
                                     <th>Amount</th>
                                     <th>Message</th>
                                     <th>Member</th>
                                     <th>Order</th>
                                     <th>Astrologer Message</th>
                                     <th>Astrologer Security</th>
                                     <th>Astrologer</th>
                                     <th>User</th>
                                     <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($profitPayment as $payment)
                                    <tr>
                                        <td>{{ $payment->order_id }}</td>
                                        <td>{{ $payment->amount }}</td>
                                        <td>{{ $payment->message_payment }}</td>
                                        <td>{{ $payment->member_payment }}</td>
                                        <td>{{ $payment->order_profit }}</td>
                                        <td>{{ $payment->astrologer_msg_profit }}</td>
                                        <td>{{ $payment->astrologer_security }}</td>
                                        <td>{{ $payment->astrologer_id }}</td>
                                        <td>{{ $payment->user_id }}</td>
                                        <td>{{ date('d/m/Y', strtotime($payment->created_at)) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $profitPayment->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
