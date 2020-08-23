@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Today Rashifal</h1>
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
                                <a href="/today-rashi/create" class="btn btn-success btn-sm">
                                    <i class="fa fa-plus"></i> Add new
                                </a>
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
                                    <th>Day</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rashifal as $rashifalData)
                                    <tr>
                                        <td>{{ $rashifalData->id }}</td>
                                        <td>{{ date('l', strtotime($rashifalData->today_date)) }}</td>
                                        <td>{{ date('d/m/Y', strtotime($rashifalData->today_date)) }}</td>
                                        <td><a href="/today-rashi/edit/{{ $rashifalData->id }}" class="btn btn-secondary">Edit</a>
                                        <a onclick="return removeAlert();" href="/today-rashi/delete/{{ $rashifalData->id }}" class="btn btn-danger on-mob-table-btn">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $rashifal->links() !!} 
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection