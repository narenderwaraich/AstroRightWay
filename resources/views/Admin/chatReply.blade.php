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
                                <a href="{{ URL::previous() }}"><button type="button" class="btn btn-danger btn-sm" >
                                    <span class="fa fa-chevron-left"></span> Back
                                </button>
                                </a></span>
                            </h3>
                        </div>

                        <div class="box-body">
                            @foreach ($allMessage->take(5) as $message)
                                    @if($message->user_message)
                                        <div class="user-message-chat-box">
                                        <p class="user-message-drop">{!! nl2br($message->user_message) !!}</p>
                                        </div>
                                    @endif
                                    @if($message->reply_message)
                                        <div class="admin-message-chat-box">
                                        <p class="admin-message-drop">{!! nl2br($message->reply_message) !!}</p>
                                        </div>
                                    @endif
                                @endforeach
                            <p>{{$chat->user_message}}</p>
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