@extends('layouts.master')
@section('content')

<section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
        <h1>Covid19</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="/covid19/update/{{$covid19->id}}" method="post">
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
                                <label for="title">Confirmed Case</label>
                                <input type="number" class="form-control{{ $errors->has('confirmed') ? ' is-invalid' : '' }}" name="confirmed" placeholder="Enter Confirmed" value="{{ $covid19->confirmed }}">
                                @if ($errors->has('confirmed'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('confirmed') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title">Recovered Case</label>
                                <input type="number" class="form-control{{ $errors->has('recovered') ? ' is-invalid' : '' }}" name="recovered" placeholder="Enter Recovered Case" value="{{ $covid19->recovered }}">
                                @if ($errors->has('recovered'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('recovered') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title">Deceased Case</label>
                                <input type="number" class="form-control{{ $errors->has('deceased') ? ' is-invalid' : '' }}" name="deceased" placeholder="Enter Deceased Case" value="{{ $covid19->deceased }}">
                                @if ($errors->has('deceased'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('deceased') }}</strong>
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
