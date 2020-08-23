@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Product Type</h1>
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
                                <a href="/product-type/create" class="btn btn-success btn-sm">
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
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                   @foreach ($productType as $productData)
                                    <tr>
                                        <td>{{ $productData->id }}</td>
                                        <td>{{ $productData->name }}</td>
                                        <td><a href="/product-type/edit/{{ $productData->id }}" class="btn btn-secondary">Edit</a>
                                        <a onclick="return removeAlert();" href="/product-type/delete/{{ $productData->id }}" class="btn btn-danger on-mob-table-btn">Delete</a>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $productType->links() !!}         
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection