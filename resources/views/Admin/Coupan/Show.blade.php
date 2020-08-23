@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Discount</h1>
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
                                <a href="/discount/create" class="btn btn-success btn-sm">
                                    <i class="fa fa-plus"></i> Add new
                                </a>
                                <button type="button" class="btn btn-default btn-sm" onClick="refreshPage()">
<i class="fa fa-refresh"></i> Refresh</button>
                            </div>
                        </div>

                        <div class="box-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Percentage</th>
                                    <th>Description</th>
                                    <th>Term-Condtions</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($discount as $discountData)
                                    <tr>
                                        <td>{{ $discountData->id }}</td>
                                        <td>{{ $discountData->name }}</td>
                                        <td>{{ $discountData->code }}</td>
                                        <td>{{ $discountData->percentage }}</td>
                                        <td>{{ $discountData->description }}</td>
                                        <td>{{ $discountData->term }}</td>
                                        <td><a href="/discount/edit/{{ $discountData->id }}" class="btn btn-secondary">Edit</a>
                                        <a onclick="return removeAlert();" href="/discount/delete/{{ $discountData->id }}" class="btn btn-danger">Delete</a>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $discount->links() !!}    
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection