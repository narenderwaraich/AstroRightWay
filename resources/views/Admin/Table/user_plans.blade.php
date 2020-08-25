@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>User Plans</h1>
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
                                <!-- <a href="#" class="btn btn-success btn-sm">
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
                                    <th>ID</th>
                                    <th>Amount</th>
                                    <th>User</th>
                                    <th>Plan</th>
                                    <th>Start</th>
                                    <th>Expire</th>
                                    <th>Status</th>
                                    <th>Message</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tableData as $table)
                                    <tr>
                                        <td>{{ $table->id }}</td>
                                        <td>{{ $table->amount }}</td>
                                        <td>{{ $table->user }}</td>
                                        <td>{{ $table->plan_id }}</td>
                                        <td>{{ $table->access_date }}</td>
                                        <td>{{ $table->expire_date }}</td>
                                        <td>@if($table->is_activated == 1)
                                            <span class="user-active">Verified</span>
                                            @else
                                            <span class="user-deactive">Unverified</span>
                                            @endif</td>
                                        <td>{{ $table->get_message }}</td>
                                        <td><!-- <a href="/user/plan/edit/{{ $table->id }}" class="btn btn-secondary">Edit</a> -->
                                        @if($table->is_activated == 0)
                                            <a href="/user/plan-active/{{$table->id}}" class="btn btn-success on-mob-table-btn">Active</a>
                                        @else
                                            <a href="/user/plan-inactive/{{$table->id}}" class="btn btn-warning on-mob-table-btn">Inactive</a>
                                        @endif
                                        </td>
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