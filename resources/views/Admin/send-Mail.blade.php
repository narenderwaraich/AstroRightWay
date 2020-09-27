@extends('layouts.master')
@section('content')

<section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
        <h1>Send Mail</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="/send-mail" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">E-Mail <span style="float: right;">
                                <a href="{{ URL::previous() }}"><button type="button" class="btn btn-danger btn-sm" >
                                    <span class="fa fa-chevron-left"></span> Back
                                </button></a></span>
                            </h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="title">Email</label>
                                <input type="email" name="email" placeholder="Email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="title">Subject</label>
                                <input type="text" name="subject" placeholder="Subject" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="title">File</label>
                                <input type="file" name="document" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="title">Message</label>
                                <textarea name="message" rows="10" placeholder="Message" class="form-control" required></textarea>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-sm">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</section>
@endsection