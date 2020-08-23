@extends('layouts.astro')
@section('content')

<section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
        <h1>Today Rashifal</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="/today-rashi/create" method="post">
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
                                <label for="title">Date</label>
                                <input type="date" class="form-control{{ $errors->has('today_date') ? ' is-invalid' : '' }}" name="today_date" placeholder="Enter Date" value="{{ old('today_date') }}">
                                @if ($errors->has('today_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('today_date') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title">मेष राशि</label>
                                <textarea name="mesh"  rows="3" placeholder="मेष राशि" class="form-control{{ $errors->has('mesh') ? ' is-invalid' : '' }}"></textarea>
                                 @if ($errors->has('mesh'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mesh') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title">वृषभ राशि</label>
                                <textarea name="vrishabh"  rows="3" placeholder="वृषभ राशि" class="form-control{{ $errors->has('vrishabh') ? ' is-invalid' : '' }}"></textarea>
                                 @if ($errors->has('vrishabh'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('vrishabh') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title">मिथुन राशि</label>
                                <textarea name="mithun"  rows="3" placeholder="मिथुन राशि" class="form-control{{ $errors->has('mithun') ? ' is-invalid' : '' }}"></textarea>
                                 @if ($errors->has('mithun'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mithun') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title">कर्क राशि</label>
                                <textarea name="kark"  rows="3" placeholder="कर्क राशि" class="form-control{{ $errors->has('kark') ? ' is-invalid' : '' }}"></textarea>
                                 @if ($errors->has('kark'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('kark') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title">सिंह राशि</label>
                                <textarea name="simha"  rows="3" placeholder="सिंह राशि" class="form-control{{ $errors->has('simha') ? ' is-invalid' : '' }}"></textarea>
                                 @if ($errors->has('simha'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('simha') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title">कन्या राशि</label>
                                <textarea name="kanya"  rows="3" placeholder="कन्या राशि" class="form-control{{ $errors->has('kanya') ? ' is-invalid' : '' }}"></textarea>
                                 @if ($errors->has('kanya'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('kanya') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title">तुला राशि</label>
                                <textarea name="tula"  rows="3" placeholder="तुला राशि" class="form-control{{ $errors->has('tula') ? ' is-invalid' : '' }}"></textarea>
                                 @if ($errors->has('tula'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tula') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title">वृश्चिक राशि</label>
                                <textarea name="vrishchik"  rows="3" placeholder="वृश्चिक राशि" class="form-control{{ $errors->has('vrishchik') ? ' is-invalid' : '' }}"></textarea>
                                 @if ($errors->has('vrishchik'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('vrishchik') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title">धनु राशि</label>
                                <textarea name="dhanu"  rows="3" placeholder="धनु राशि" class="form-control{{ $errors->has('dhanu') ? ' is-invalid' : '' }}"></textarea>
                                 @if ($errors->has('dhanu'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('dhanu') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title">मकर राशि</label>
                                <textarea name="makar"  rows="3" placeholder="मकर राशि" class="form-control{{ $errors->has('makar') ? ' is-invalid' : '' }}"></textarea>
                                 @if ($errors->has('makar'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('makar') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title">कुंभ राशि</label>
                                <textarea name="kumbh"  rows="3" placeholder="कुंभ राशि" class="form-control{{ $errors->has('kumbh') ? ' is-invalid' : '' }}"></textarea>
                                 @if ($errors->has('kumbh'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('kumbh') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title">मीन राशि</label>
                                <textarea name="meen"  rows="3" placeholder="मीन राशि" class="form-control{{ $errors->has('meen') ? ' is-invalid' : '' }}"></textarea>
                                 @if ($errors->has('meen'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('meen') }}</strong>
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