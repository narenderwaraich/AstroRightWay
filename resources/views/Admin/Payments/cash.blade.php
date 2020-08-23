@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>All Payments</h1>
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
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                     <th>Order No.</th>
                                     <th>Name</th>
                                     <th>Method</th>
                                     <th>Date</th>
                                     <th>Amount</th>
                                     <th width="290px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->order_number }}</td>
                                        <td>{{ $payment->userName }}</td>
                                        <td>{{ $payment->payment_method }}</td>
                                        <td>{{ $payment->transaction_date }}</td>
                                        <td>{{ $payment->amount }}</td>
                                        <td>
                                        <a href="/payment/refund/{{ $payment->id }}"><button class="btn btn-danger">Refund</button></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $payments->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection