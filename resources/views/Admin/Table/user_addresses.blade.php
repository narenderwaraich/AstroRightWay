@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Users Address List</h1>
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
                                    <th>User</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Country</th>
                                    <th>Code</th>
                                    <th>Address</th>
                                    <!-- <th>Actions</th> -->
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tableData as $table)
                                    <tr>
                                        <td>{{ $table->id }}</td>
                                        <td>{{ $table->user }}</td>
                                        <td>{{ $table->city }}</td>
                                        <td>{{ $table->state }}</td>
                                        <td>{{ $table->country }}</td>
                                        <td>{{ $table->zipcode }}</td>
                                        <td><p>{{ $table->address }}</p></td>
                                        <!-- <td><a href="#/edit/{{ $table->id }}" class="btn btn-secondary">Edit</a>
                                        <a onclick="return removeAlert();" href="#/delete/{{ $table->id }}" class="btn btn-danger on-mob-table-btn">Delete</a>
                                        </td> -->
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