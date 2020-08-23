@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Videos</h1>
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
                                <a href="/video/create" class="btn btn-success btn-sm">
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
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Video Id</th>
                                    <th width="200px;">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($videos as $videoData)
                                    <tr>
                                        <td>{{ $videoData->id }}</td>
                                        <td>{{ $videoData->title }}</td>
                                        <td>{{ $videoData->auth }}</td>
                                        <td>{{ $videoData->url }}</td>
                                        <td><a href="/video/edit/{{ $videoData->id }}" class="btn btn-secondary">Edit</a>
                                        <a onclick="return removeAlert();" href="/video/delete/{{ $videoData->id }}" class="btn btn-danger on-mob-table-btn">Delete</a>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $videos->links() !!}

                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

@endsection