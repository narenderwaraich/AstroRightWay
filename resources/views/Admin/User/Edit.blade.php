@extends('layouts.master')
@section('content')

  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
            <h1>User</h1>
        </section>
      <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <form action="/user/update/{{ $user->id }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                      <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit <span style="float: right;"> <a href="{{ URL::previous() }}"><button type="button" class="btn btn-danger btn-sm">
<span class="fa fa-chevron-left"></span> Back</button></a></span></h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="title">Name</label>
                                    <input
                                            type="text"
                                            class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            name="name"
                                            placeholder="Enter Name" value="{{ $user->name }}"
                                            >
                                </div>

                                 <div class="form-group">
                                    <label for="title">Email</label>
                                    <input
                                            type="email"
                                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            name="email"
                                            placeholder="Enter Email" value="{{ $user->email }}"
                                            >
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                                 </div>
                                  <div class="form-group">
                                    <label for="title">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Enter Password">
                                  </div>
                                  <div class="form-group">
                                    <label for="title">Phone</label>
                                    <input type="text" class="form-control {{ $errors->has('phone_no') ? ' is-invalid' : '' }}" name="phone_no" value="{{ $user->phone_no }}" placeholder="Enter Phone">
                                    @if ($errors->has('phone_no'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone_no') }}</strong>
                                        </span>
                                    @endif
                                  </div>
                                  <div class="form-group">
                                    <label for="title">Gender</label>
                                    <select name="gender" id="select" required class="windows-form-input form-control ">
                                            <option value="">-- Select Gender--</option>    
                                            <option value="male" @if ($user->gender == "male") {{ 'selected' }} @endif>Male</option>
                                            <option value="female" @if ($user->gender == "female") {{ 'selected' }} @endif>Female</option>
                                    </select>
                                 </div>
                                 <div class="form-group">
                                    <label for="title">Role</label>
                                      <select class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"  name="role">
                                        <option value="admin" disabled>Admin</option>
                                        <option value="administrator" @if ($user->role == "administrator") {{ 'selected' }} @endif>Administrator</option>
                                        <option value="user" @if ($user->role == "user") {{ 'selected' }} @endif>User</option>
                                        <option value="editor" @if ($user->role == "editor") {{ 'selected' }} @endif>Editor</option>
                                        <option value="author" @if ($user->role == "author") {{ 'selected' }} @endif>Author</option>
                                        <option value="astrologer" @if ($user->role == "astrologer") {{ 'selected' }} @endif>Astrologer</option>
                                      </select>
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