@extends('layouts.master')
@section('content')

  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
            <h1>User</h1>
        </section>
      <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <form action="/member/update/{{ $member->id }}" method="post">
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
                                            placeholder="Enter Name" value="{{ $member->name }}"
                                            >
                                </div>

                                 <div class="form-group">
                                    <label for="title">Email</label>
                                     <div class="row">
                                      <div class="col-6"><input type="text" class="form-control" name="" value="{{ $member->email}}" readonly></div>
                                      <div class="col-6"><input type="email "class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Change Email" value="">
                                        @if ($errors->has('email'))
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $errors->first('email') }}</strong>
                                          </span>
                                          @endif
                                      </div>
                                    </div>
                              
                                
                                 </div>
                                 
                                  <div class="form-group">
                                    <label for="title">Phone</label>
                                    <input type="text" class="form-control {{ $errors->has('phone_no') ? ' is-invalid' : '' }}" name="phone_no" value="{{ $member->phone_no }}" placeholder="Enter Phone">
                                    @if ($errors->has('phone_no'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone_no') }}</strong>
                                        </span>
                                    @endif
                                  </div>
                                  <div class="form-group">
                                    <label for="title">Refer</label>
                                    <input type="text" class="form-control" name="refer_code" value="{{$member->refer_code}}">
                                  </div>
                                  <div class="form-group">
                                    <label for="title">Level</label>
                                    <select name="level" id="select" class="windows-form-input form-control ">
                                            <option value="">-- Select Level--</option>    
                                            <option value="Pearl" @if ($member->level == "Pearl") {{ 'selected' }} @endif>Pearl</option>
                                            <option value="Ruby" @if ($member->level == "Ruby") {{ 'selected' }} @endif>Ruby</option>
                                            <option value="Diamond" @if ($member->level == "Diamond") {{ 'selected' }} @endif>Diamond</option>
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