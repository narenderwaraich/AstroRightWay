@extends('layouts.astro')
@section('content')

<section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
        <h1>Chat Message</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Message
                            </h3>
                        </div>

                        <div class="box-body">
                            <p style="text-align: right;">
                                @if($chat->file)
                                    <img src="/public/images/user/messages/{{$chat->file}}" style="width: 320px;">
                                    <br>
                                @endif
                                {{$chat->user_message}}
                            </p>
                            <br>
                            <p style="text-align: left;">{{$chat->reply_message}}</p>
                        </div>

                        <div class="box-footer">
                           <a href="{{ URL::previous() }}"> <button type="button" class="btn btn-danger btn-sm" >
                                    <span class="fa fa-chevron-left"></span> Back
                                </button>
                            </a>
                        </div>
                    </div>
            </div>
        </div>
    </section>
</section>
@endsection