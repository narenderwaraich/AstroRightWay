@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Profit Transfer</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data <span style="float: right;"> <a href="{{ URL::previous() }}"><button type="button" class="btn btn-danger btn-sm">
<span class="fa fa-chevron-left"></span> Back</button></a></span></h3>
                        </div>

                        <div class="box-body">
                            <div class="btn-group">
                               <button type="button" class="btn btn-default btn-sm" onClick="refreshPage()">
<i class="fa fa-refresh"></i> Refresh</button>
                                <a href="/profit/calculat" class="btn btn-info btn-sm">
                                    <i class="fa fa-building-o"></i> Calculat
                                </a>
                                <a href="/profit/transfer" class="btn btn-success btn-sm">
                                    <i class="fa fa-truck"></i> Transfer
                                </a>
                            </div>
                        </div>

                        <div class="box-body">
                            <table class="table table-hover">
                                <tr>
                                    <td>Total Profit</td>
                                    <td>{{ $profitTable->total_profit }}</td>
                                  </tr>
                                  <tr>
                                    <td>Pay Profit</td>
                                    <td>{{ $profitTable->pay_profit }}</td>
                                  </tr>
                                  <tr>
                                    <td>Pending Profit</td>
                                    <td>{{ $profitTable->pending_profit }}</td>
                                  </tr>
                                  <tr>
                                    <td>Calculat Profit Date</td>
                                    <td>{{ $profitTable->cal_profit_date }}</td>
                                  </tr>
                                  <tr>
                                    <td>Last Pay Profit Date</td>
                                    <td>{{ $profitTable->last_pay_profit_date }}</td>
                                  </tr>
                            </table>  
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection