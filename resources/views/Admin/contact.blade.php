@extends('layouts.master')
@section('content')

    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Contacts</h1>
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
                            </div>
                        </div>

                        <div class="box-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                     <th>Name</th>
                                     <th>Email</th>
                                     <th>Phone</th>
                                     <th>Message</th>
                                     <th>Reply Message</th>
                                     <th width="290px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($getContacts as $contact)
                                    <tr>
                                        <td>{{ $contact->name }}</td>
                                        <td>{{ $contact->email }}</td>
                                        <td>{{ $contact->phone_number }}</td>
                                        <td>
                                            <p>{{ $contact->message }}</p>
                                          </td>
                                          <td>
                                            <p>{{ $contact->reply_message }}</p>
                                          </td>
                                        <td>
                                        @if($contact->status == "Pending")
                                        <a href="/contact/reply/{{ $contact->id }}"><button class="btn btn-success">Reply</button></a>
                                        <a href="/contact/mark-reply/{{ $contact->id }}"><button class="btn btn-dark">Mark Reply</button></a>
                                        @endif
                                        <a href="/contact/block/{{ $contact->id }}"><button class="btn btn-danger on-mob-table-btn">Block</button></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $getContacts->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection