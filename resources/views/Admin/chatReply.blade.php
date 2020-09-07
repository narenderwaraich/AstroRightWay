@extends('layouts.master')
@section('content')

<section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
        <h1>Chat Reply</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="/chat-reply/{{$chat->id}}" method="post">
                    {{ csrf_field() }}
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Reply <span style="float: right;">
                                <a href="{{ URL::previous() }}"><button type="button" class="btn btn-danger" >
                                    <span class="fa fa-chevron-left"></span> Back
                                </button>
                                </a></span>
                            </h3>
                        </div>

                        <div class="box-body">
                            <table class="table table-hover" style="width: 100%;">
                                <thead>
                                <tr>
                                     <th style="width: 50%;float: left;">User Message</th>
                                     <th style="width: 50%;float: right;">Reply Message</th>
                                </tr>
                                </thead>
                                <tbody>
                            @foreach ($allMessage->take(5) as $message)
                            <tr>
                                        <td style="width: 50%;float: left;">@if($message->user_message)
                                            @if($message->file)
                                                <img src="/public/images/user/messages/{{$message->file}}" style="width: 320px;">
                                            @endif
                                            <p>{!! nl2br($message->user_message) !!}
                                                <br>
                                                <span style="font-size: 11px;font-weight: 400;color: #878787;">{{$message->created_at}}</span></p>
                                            @endif
                                        </td>
                                        <td style="width: 50%;float: right;">
                                            @if($message->reply_message)
                                                <p>{!! nl2br($message->reply_message) !!}</p>
                                            @endif
                                        </td>
                                </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <br>
                            <h6>Open Message</h6>
                            <br>
                            <p style="border: 2px dashed;padding: 15px;">
                                @if($message->file)
                                    <img src="/public/images/user/messages/{{$message->file}}" style="width: 320px;">
                                    <br>
                                @endif
                                {{$chat->user_message}}
                            </p>
                            <div class="form-group">
                                <label for="title">Reply Message</label>
                                <textarea name="reply_message" rows="5" placeholder="Reply Message" class="form-control"></textarea>
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