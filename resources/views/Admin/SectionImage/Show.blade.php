@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Section Image</h1>
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
                               <a href="/section-image/create" class="btn btn-success btn-sm">
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
                                    <th>Page</th>
                                    <th>Section</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                   @foreach ($pageSetup as $pageSetupData)
                                    <tr>
                                        <td>{{ $pageSetupData->id }}</td>
                                        <td>{{ $pageSetupData->page_name }}</td>
                                        <td>{{ $pageSetupData->section }}</td>
                                        <td><img src="/public/images/bg/{{ $pageSetupData->bg_img }}" class="bannerShowImg"></td>
                                       <td><a href="/section-image/edit/{{ $pageSetupData->id }}" class="btn btn-secondary">Edit</a>
                                        <a onclick="return removeAlert();" href="/section-image/delete/{{ $pageSetupData->id }}" class="btn btn-danger on-mob-table-btn">Delete</a>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $pageSetup->links() !!}

                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
<style scoped>
    .bannerShowImg{
        height: 100px;
        width:  auto;
    }
</style>