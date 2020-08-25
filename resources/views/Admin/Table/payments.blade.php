@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Payments</h1>
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
                               <!--  <a href="#" class="btn btn-success btn-sm">
                                    <i class="fa fa-plus"></i> Add new
                                </a> -->
                                <button type="button" class="btn btn-default btn-sm" onClick="refreshPage()">
                                    <i class="fa fa-refresh"></i> Refresh
                                </button>
                            </div>
                        </div>

                        <div class="box-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Method</th>
                                    <th>Amount</th>
                                    <th>Transaction Id</th>
                                    <th>Status</th>
                                    <th>Bank Transaction</th>
                                    <th>Transaction Date</th>
                                    <th>Bank Name</th>
                                    <th>User</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tableData as $table)
                                    <tr>
                                        <td>{{ $table->order_id }}</td>
                                        <td>{{ $table->payment_method }}</td>
                                        <td>{{ $table->amount }}</td>
                                        <td>{{ $table->transaction_id }}</td>
                                        <td>{{ $table->transaction_status }}</td>
                                        <td>{{ $table->bank_transaction_id }}</td>
                                        <td>{{ $table->transaction_date }}</td>
                                        <td>{{ $table->bank_name }}</td>
                                        <td>{{ $table->user }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $tableData->links() !!} 
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection