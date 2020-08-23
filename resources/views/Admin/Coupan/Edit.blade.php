@extends('layouts.master')
@section('content')

<section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
        <h1>Discount</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="/discount/update/{{$discount->id}}" method="post">
                    {{ csrf_field() }}
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create <span style="float: right;">
                                <a href="{{ URL::previous() }}"><button type="button" class="btn btn-danger btn-sm">
<span class="fa fa-chevron-left"></span> Back</button></a></span>
                            </h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="title">Name</label>
                                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" placeholder="Enter Name" value="{{ $discount->name }}">
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                    <label for="title">Code</label>
                                    <input type="text" class="form-control{{ $errors->has('percentage') ? ' is-invalid' : '' }}" name="code" placeholder="Enter Name" value="{{ $discount->percentage }}" v-model="discount.code">
                                    @if ($errors->has('percentage'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('percentage') }}</strong>
                                </span>
                                @endif
                                </div>
                                <div class="form-group">
                                    <label for="title">Percentage</label>
                                    <input type="text" class="form-control{{ $errors->has('percentage') ? ' is-invalid' : '' }}" name="percentage" placeholder="Enter Percentage" value="{{ $discount->percentage }}">
                                    @if ($errors->has('percentage'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('percentage') }}</strong>
                                </span>
                                @endif
                                </div>
                                  <div class="form-group">
                                    <label for="title">Description</label>
                                    <textarea name="description" value="{{ $discount->description }}"  rows="5" placeholder="Description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" required>{{ $discount->description }}</textarea>
                                    @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                                </div>
                                <div class="form-group">
                                    <label for="title">Term-Condtions</label>
                                    <textarea name="term" value="{{ $discount->term }}"  rows="5" placeholder="Term-Condtions" class="form-control{{ $errors->has('term') ? ' is-invalid' : '' }}" required>{{ $discount->term }}</textarea>
                                    @if ($errors->has('term'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('term') }}</strong>
                                    </span>
                                    @endif
                                </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</section>
@endsection