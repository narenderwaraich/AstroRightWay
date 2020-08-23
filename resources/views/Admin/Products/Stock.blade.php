@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Products Stock</h1>
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
<i class="fa fa-refresh"></i> Refresh</button>
                            </div>
                        </div>

                        <div class="box-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                     <th>Id</th>
                                     <th>Name</th>
                                     <th>Price</th>
                                     <th>Quantity</th>
                                     <th>Category</th>
                                     <th>Product Type</th>
                                     <th>Solid</th>
                                     <th>Stock</th> 
                                </tr>
                                </thead>
                                <tbody>
                                     @foreach ($products as $productData)
                                    <tr>
                                        <td>{{ $productData->no }}</td>
                                        <td>{{ $productData->name }}</td>
                                        <td>{{ $productData->price }}</td>
                                        <td>{{ $productData->qty }}</td>
                                        <td>{{ $productData->category }}</td>
                                        <td>{{ $productData->type }}</td>
                                        <td>0</td>
                                        <td>{{$productData->stock}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $products->links() !!}

                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection