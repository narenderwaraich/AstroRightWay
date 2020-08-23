@extends('layouts.master')
@section('content')

<section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
        <h1>Plan</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="/plan/create" method="post">
                    {{ csrf_field() }}
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create <span style="float: right;">
                                <a href="{{ URL::previous() }}"><button type="button" class="btn btn-danger btn-sm">
                                    <span class="fa fa-chevron-left"></span> Back
                                </button></a></span>
                            </h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" placeholder="Enter Name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" placeholder="Enter Amount" id="amount" value="{{ old('amount') }}">
                                @if ($errors->has('amount'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <input type="number" class="form-control{{ $errors->has('message') ? ' is-invalid' : '' }}" name="message" placeholder="Enter Message Number" id="message" value="{{ old('message') }}">
                                @if ($errors->has('message'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('message') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="access_day">Day</label>
                                <input type="number" class="form-control{{ $errors->has('access_day') ? ' is-invalid' : '' }}" name="access_day" placeholder="Enter Day" id="access_day" value="{{ old('access_day') }}">
                                @if ($errors->has('access_day'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('access_day') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</section>
@endsection