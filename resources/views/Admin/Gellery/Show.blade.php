@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>gallery</h1>
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
                               <a href="/gallery/create" class="btn btn-success btn-sm">
                                    <i class="fa fa-plus"></i> Add new
                                </a>
                                <button type="button" class="btn btn-default btn-sm" onClick="refreshPage()">
<i class="fa fa-refresh"></i> Refresh</button>
                            </div>
                        </div>

                        <div class="box-body">
                            <table class="table table-hover scroll-table-full">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Link</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                   @foreach ($gallery as $galleryData)
                                    <tr>
                                        <td>{{ $galleryData->id }}</td>
                                        <td><img src="/public/images/gellery/{{ $galleryData->image }}" class="gelleryShowImg"></td>
                                        <td>{{ $galleryData->title }}</td>
                                        <td>{{ $galleryData->auth }}</td>
                                        <td>{{ $galleryData->url }}</td>
                                        <td>{{ $galleryData->description }}</td>
                                       <td><a href="/gallery/edit/{{ $galleryData->id }}" class="btn btn-secondary">Edit</a>
                                        <a onclick="return removeAlert();" href="/gallery/delete/{{ $galleryData->id }}" class="btn btn-danger on-mob-table-btn">Delete</a>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $gallery->links() !!}

                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
<style scoped>
    .gelleryShowImg{
        height: 100px;
        width: 100px;
        border-radius: 100%;
    }
</style>