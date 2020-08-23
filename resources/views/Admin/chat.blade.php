@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Chat List</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">List</h3>
                        </div>

                        <div class="box-body">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm" onClick="refreshPage()">
                                    <i class="fa fa-refresh"></i> Refresh
                                </button>
                                <a href="/admin/Sent/chat">
                                    <button type="button" class="btn btn-success btn-sm">Sent</button>
                                </a>
                                <a href="/admin/Reply/chat">
                                    <button type="button" class="btn btn-danger btn-sm">Reply</button>
                                </a>
                                <a href="/admin/Pending/chat">
                                    <button type="button" class="btn btn-warning btn-sm">Pending</button>
                                </a>
                            </div>
                        </div>

                        <div class="box-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                     <th>Name</th>
                                     <th>Email</th>
                                    <!--  <th>Phone</th> -->
                                     <th class="on-mob-user-chat">User</th>
                                     <th class="on-mob-admin-chat">Astro</th>
                                     <th class="">Assign</th>
                                     <th width="290px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($getChats as $chat)
                                    <tr>
                                        <td>{{ $chat->name }}</td>
                                        <td>{{ $chat->email }}</td>
                                        <!-- <td></td> -->
                                        <td>
                                            <p>{{ \Illuminate\Support\Str::limit($chat->user_message, 100, '...') }}</p>
                                          </td>
                                          <td>
                                            <p>{{ \Illuminate\Support\Str::limit($chat->reply_message, 100, '...') }}</p>
                                        </td>
                                        <td>{{ $chat->astrologer }}</td>
                                        <td>
                                        @if($chat->message_status == "Sent")
                                        <a href="/chat/reply/{{ $chat->id }}"><button class="btn btn-success">Reply</button></a>
                                        @endif
                                        <a href="/chat/view/{{ $chat->id }}"><button class="btn btn-info on-mob-table-btn">View</button></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $getChats->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection