@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>All Member Payments</h1>
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
                                <a href="/member/payment/Success">
                                    <button type="button" class="btn btn-success btn-sm">Success</button>
                                </a>
                                <a href="/member/payment/Fields">
                                    <button type="button" class="btn btn-danger btn-sm">Fields</button>
                                </a>
                                <a href="/member/payment/Pending">
                                    <button type="button" class="btn btn-warning btn-sm">Pending</button>
                                </a>
                            </div>
                        </div>

                        <div class="box-body">
                            <table class="table table-hover scroll-table-full">
                                <thead>
                                <tr>
                                     <th>Order No.</th>
                                     <th>Order Id</th>
                                     <th>Name</th>
                                     <th>Method</th>
                                     <th>Bank</th>
                                     <th>Transaction Id</th>
                                     <th>Bank Transaction Id</th>
                                     <th>Date</th>
                                     <th>Amount</th>
                                     <th>Status</th>
                                     <th width="290px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($memberPayments as $memberPayment)
                                    <tr>
                                        <td>{{ $memberPayment->order_number }}</td>
                                        <td>{{ $memberPayment->order_id }}</td>
                                        <td>{{ $memberPayment->userName }}</td>
                                        <td>{{ $memberPayment->payment_method }}</td>
                                        <td>{{ $memberPayment->bank_name }}</td>
                                        <td>{{ $memberPayment->transaction_id }}</td>
                                        <td>{{ $memberPayment->bank_transaction_id }}</td>
                                        <td>{{ date('d/m/Y', strtotime($memberPayment->transaction_date)) }}</td>
                                        <td>{{ $memberPayment->amount }}</td>
                                        <td class="status-{{ $memberPayment->transaction_status }}">{{ $memberPayment->transaction_status }}</td>
                                        <td>
                                       @if($memberPayment->transaction_status == "Fields")
                                            <a href="/member/payment/mark-success/{{$memberPayment->id}}" class="btn btn-success on-mob-table-btn">Mark Success</a>
                                        @endif
                                        @if($memberPayment->transaction_status == "Pending")
                                            <a href="/member/payment/manual/{{$memberPayment->id}}" class="btn btn-success on-mob-table-btn">Manual</a>
                                        @endif
                                        <a href="/payment/refund/{{ $memberPayment->id }}"><button class="btn btn-danger">Refund</button></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $memberPayments->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
