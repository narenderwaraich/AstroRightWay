@extends('layouts.astro')
@section('content')
    <div class="content mt-3">

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="fa fa-inr text-success border-success"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Total Profit</div>
                                        <div class="stat-digit">@if(isset($astrologer->total_amount)) {{ $astrologer->total_amount }} @endif</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-one">
                            <div class="stat-icon dib"><i class="fa fa-inr text-warning border-warning"></i></div>
                            <div class="stat-content dib">
                                <div class="stat-text">Withdraw</div>
                                <div class="stat-digit">{{ $astrologer->total_amount - $astrologer->left_amount }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-one">
                            <div class="stat-icon dib"><i class="fa fa-inr text-primary border-primary"></i></div>
                            <div class="stat-content dib">
                                <div class="stat-text">Left Amount</div>
                                <div class="stat-digit">@if(isset($astrologer->left_amount)) {{ $astrologer->left_amount }} @endif</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-one">
                            <div class="stat-icon dib"><i class="ti-email text-info border-info"></i></div>
                            <div class="stat-content dib">
                                <div class="stat-text">Message</div>
                                <div class="stat-digit"> {{ $totalMessage }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </div> <!-- .content -->
</div><!-- /#right-panel -->

    <!-- Right Panel -->

@endsection