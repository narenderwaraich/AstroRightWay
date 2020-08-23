@extends('layouts.master')
@section('content')

<section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
        <h1>Contact Reply</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="/contact-reply" method="post">
                    {{ csrf_field() }}
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Reply <span style="float: right;">
                                <button type="button" class="btn btn-danger btn-sm" >
                                    <span class="fa fa-chevron-left"></span> Back
                                </button></span>
                            </h3>
                        </div>

                        <div class="box-body">
                            <p>{{$contact->message}}</p>
                            <input type="hidden" name="email" value="{{$contact->email}}">
                            <input type="hidden" name="id" value="{{$contact->id}}">
                            <div class="form-group">
                                <label for="title">Reply Message</label>
                                <textarea name="reply" rows="5" placeholder="Reply Message" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-sm">Reply</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</section>
@endsection