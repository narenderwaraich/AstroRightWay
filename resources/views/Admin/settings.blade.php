@extends('layouts.master')
@section('content')

  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
            <h1>Setting</h1>
        </section>
      <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <form action="/settings/update" method="post">
                    {{ csrf_field() }}
                      <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit <span style="float: right;"><a href="{{ URL::previous() }}"><button type="button" class="btn btn-danger btn-sm">
<span class="fa fa-chevron-left"></span> Back</button></a></span></h3>
                            </div>

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="tax">Admin Email</label>
                                    <input type="text" class="form-control{{ $errors->has('admin_mail') ? ' is-invalid' : '' }}" name="admin_mail" placeholder="Enter Admin Email" value="{{ $data->admin_mail }}">
                                    @if ($errors->has('admin_mail'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('admin_mail') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="tax">Tax Rate</label>
                                    <input type="text" class="form-control{{ $errors->has('tax_rate') ? ' is-invalid' : '' }}" name="tax_rate" placeholder="Enter Tax Rate" value="{{ $data->tax_rate }}">
                                    @if ($errors->has('tax_rate'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tax_rate') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="ship_charge">Shipping Charge</label>
                                    <input type="text" class="form-control{{ $errors->has('ship_charge') ? ' is-invalid' : '' }}" name="ship_charge" placeholder="Enter Shipping Charge" value="{{ $data->ship_charge }}">
                                    @if ($errors->has('ship_charge'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('ship_charge') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="astrologer">Join Astrology</label>
                                    <input type="text" class="form-control{{ $errors->has('astrologer') ? ' is-invalid' : '' }}" name="astrologer" placeholder="Enter Join Astrology Fee" value="{{ $data->astrologer }}">
                                    @if ($errors->has('astrologer'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('astrologer') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="astrologer">Astrologer Profit</label>
                                    <input type="text" class="form-control{{ $errors->has('astrologer_profit_share') ? ' is-invalid' : '' }}" name="astrologer_profit_share" placeholder="Enter Profit" value="{{ $data->astrologer_profit_share }}">
                                    @if ($errors->has('astrologer_profit_share'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('astrologer_profit_share') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="member">Member</label>
                                    <input type="text" class="form-control{{ $errors->has('member') ? ' is-invalid' : '' }}" name="member" placeholder="Enter Member Fee" value="{{ $data->member }}">
                                    @if ($errors->has('member'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('member') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="talk_per_min">Talk Astrology Per Min</label>
                                    <input type="text" class="form-control{{ $errors->has('talk_per_min') ? ' is-invalid' : '' }}" name="talk_per_min" placeholder="Enter Talk Astrology Per Min" value="{{ $data->talk_per_min }}">
                                    @if ($errors->has('talk_per_min'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('talk_per_min') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="talk_15">Talk Astrology 15 Min</label>
                                    <input type="text" class="form-control{{ $errors->has('talk_15') ? ' is-invalid' : '' }}" name="talk_15" placeholder="Enter Talk Astrology 15 Min" value="{{ $data->talk_15 }}">
                                    @if ($errors->has('talk_15'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('talk_15') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="talk_30">Talk Astrology 30 Min</label>
                                    <input type="text" class="form-control{{ $errors->has('talk_30') ? ' is-invalid' : '' }}" name="talk_30" placeholder="Enter Talk Astrology 30 Min" value="{{ $data->talk_30 }}">
                                    @if ($errors->has('talk_30'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('talk_30') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Coupan Exp Days ({{ date('d-m-Y H:i:s', strtotime($data->coupan_exp_time)) }})</label>
                                    <input type="datetime-local" class="form-control" name="coupan_exp_time" placeholder="Enter Coupan Exp Time" value="">
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