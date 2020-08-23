@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Products</h1>
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
                                <a href="/product/create" class="btn btn-success btn-sm">
                                    <i class="fa fa-plus"></i> Add new
                                </a>
                                <button type="button" class="btn btn-default btn-sm" onClick="refreshPage()">
<i class="fa fa-refresh"></i> Refresh</button>
                            </div>
                        </div>

                        <div class="box-body">

                            <table class="table table-hover product-show-table scroll-table-full">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Original Price</th>
                                    <th>Sale Price</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product as $productData)
                                    <tr>
                                        <td>{{ $productData->id }}</td>
                                        <td><img src="/public/images/products/{{ $productData->image }}" class="productImg"></td>
                                        <td>{{ $productData->name }}</td>
                                        <td>{{ $productData->original_price }}</td>
                                        <td>{{ $productData->price }}</td>
                                        <td>{{ $productData->type }}</td>
                                        <td>{{ $productData->category }}</td>
                                       <td class="btn-div"><a href="/product/edit/{{ $productData->id }}" class="btn btn-secondary">Edit</a>
                                        <a onclick="return removeAlert();" href="/product/delete/{{ $productData->id }}" class="btn btn-danger on-mob-table-btn">Delete</a>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $product->links() !!}
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection