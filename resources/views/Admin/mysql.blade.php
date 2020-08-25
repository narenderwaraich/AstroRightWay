@extends('layouts.master')
@section('content')

<section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
        <h1>MySqul</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="/mysql" method="post">
                    {{ csrf_field() }}
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Query <span style="float: right;">
                               <a href="{{ URL::previous() }}"> <button type="button" class="btn btn-danger btn-sm" >
                                    <span class="fa fa-chevron-left"></span> Back
                                </button></a></span>
                            </h3>
                        </div>

                        <div class="box-body">
                            <a href="https://auth-db251.hostinger.com/index.php?db=u543792968_astro_db" target="_blank" class="btn btn-success btn-sm">
                                    <i class="fa fa-database"></i> Database
                                </a>
                            <div class="form-group">
                                <label for="title">Table List</label>
                                <select name="table" class="form-control">
                                    <option value="">--Table--</option>
                                @foreach($tables as $table)
                                    <option value="{{$table->Tables_in_u543792968_astro_db}}">{{$table->Tables_in_u543792968_astro_db}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">MySqul Query</label>
                                <textarea name="query" rows="5" placeholder="Enter Database Query" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-sm">Result</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</section>
@endsection