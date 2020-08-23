@extends('layouts.master')
@section('content')

  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
            <h1>User</h1>
        </section>
      <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <form action="/user/create" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                      <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Create <span style="float: right;"> <a href="{{ URL::previous() }}"><button type="button" class="btn btn-danger btn-sm">
<span class="fa fa-chevron-left"></span> Back</button></a></span></h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="title">Name</label>
                                    <input
                                            type="text"
                                            class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            name="name"
                                            placeholder="Enter Name"
                                            >
                                </div>

                                 <div class="form-group">
                                    <label for="title">Email</label>
                                    <input
                                            type="email"
                                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            name="email"
                                            placeholder="Enter Email"
                                            >
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                                 </div>

                                 <div class="form-group">
                                    <label for="title">Role</label>
                                      <select class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"  name="role">
                                        <option value="admin" disabled>Admin</option>
                                        <option value="user">User</option>
                                      </select>
                                 </div>

                                  <div class="form-group">
                                    <label for="title">Password</label>
                                    <input
                                            type="password"
                                            class="form-control"
                                            name="password"
                                            placeholder="Enter Password"
                                            >
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