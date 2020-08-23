@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Covid19</h1>
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
                                <a href="/covid19/create" class="btn btn-success btn-sm">
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
                                    <th>Confirmed</th>
                                    <th>Recovered</th>
                                    <th>Active</th>
                                    <th>Deceased</th>
                                    <th>Date</th>
                                    <th>Last Update</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($covid19 as $covid19Data)
                                    <tr>
                                        <td>{{ $covid19Data->id }}</td>
                                        <td>{{ $covid19Data->confirmed }}</td>
                                        <td>{{ $covid19Data->recovered }}</td>
                                        <td>{{ $covid19Data->active }}</td>
                                        <td>{{ $covid19Data->deceased }}</td>
                                        <td>{{ date('l, d/m/Y', strtotime($covid19Data->created_at)) }}</td>
                                        <td>{{ $covid19Data->updated_at->diffForHumans() }}</td>
                                        <td><a href="/covid19/edit/{{ $covid19Data->id }}" class="btn btn-secondary">Edit</a>
                                        <a onclick="return removeAlert();" href="/covid19/delete/{{ $covid19Data->id }}" class="btn btn-danger on-mob-table-btn">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $covid19->links() !!} 
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection