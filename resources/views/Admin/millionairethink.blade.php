@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Contacts</h1>
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
                                    <i class="fa fa-refresh"></i> Refresh
                                </button>
                            </div>
                        </div>

                        <div class="box-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                     <th>Name</th>
                                     <th>Email</th>
                                     <th>Phone</th>
                                     <th>Message</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($getQuery as $query)
                                    <tr>
                                        <td>{{ $query->name }}</td>
                                        <td>{{ $query->email }}</td>
                                        <td>{{ $query->phone }}</td>
                                        <td>
                                            <p>{{ $query->message }}</p>
                                          </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $getQuery->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection