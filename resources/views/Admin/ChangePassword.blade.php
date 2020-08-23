@extends('layouts.master')
@section('content')

  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
            <h1>Change Password</h1>
        </section>
      <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <form action="/change-password" method="post">
                    {{ csrf_field() }}
                      <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Change</h3>
                            </div>

                            <div class="box-body">
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="current_password">Current Password</label>
                                    <input
                                            type="password"
                                            class="form-control"
                                            name="current_password"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="new_password">New Password</label>
                                    <input
                                            type="password"
                                            class="form-control"
                                            name="new_password"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="new_password_confirmation">Confirm New Password</label>
                                    <input
                                            type="password"
                                            class="form-control"
                                            name="new_password_confirmation"
                                            >
                                </div>
                            </div>
                            <div class="box-footer">
                              <button class="btn btn-primary btn-sm">Save</button>
                            </div>
                        </div>
                    </form>
                  </div>
              </div>
        </section>
</section>
@endsection
