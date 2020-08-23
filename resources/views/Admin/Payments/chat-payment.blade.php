@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Chat Payments</h1>
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
                                     <th>Order Id</th>
                                     <th>Name</th>
                                     <th>Email</th>
                                     <th>Plan</th>
                                     <th>Transaction Id</th>
                                     <th>Date</th>
                                     <th>Amount</th>
                                     <th width="290px">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($chatPayments as $payment)
                                    <tr>
                                        <td>{{ $payment->order_id }}</td>
                                        <td>{{ $payment->userName }}</td>
                                        <td>{{ $payment->userEmail }}</td>
                                        <td>{{ $payment->plan }}</td>
                                        <td>{{ $payment->transaction_id }}</td>
                                        <td>{{ $payment->transaction_date }}</td>
                                        <td>{{ $payment->amount }}</td>
                                        <td class="status-{{ $payment->transaction_status }}">{{ $payment->transaction_status }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $chatPayments->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection