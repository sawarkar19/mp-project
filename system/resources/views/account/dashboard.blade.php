@extends('layouts.account')

@section('head')
    @include('layouts.partials.headersection', ['title' => 'Dashboard'])
@endsection

@section('end_head')
    <style>
        .paid_plan_cards_bg1 {
            background: #DBECFE !important;
        }

        .paid_plan_cards_bg2 {
            background: #E5E5FF !important;
        }

        .paid_plan_cards_bg3 {
            background: #FFF6F4 !important;
        }

        .paid_plan_cards_bg4 {
            background: #ffefee !important;
        }

        .paid_plan_cards_bg5 {
            background: #D3FFDB !important;
        }

        .paid_plan_cards_bg6 {
            background: #f7e8ff !important;
        }

        .paid_plan_cards.card.card-statistic-1 h4 {
            font-size: 18px;
            display: inline-block;
        }

        .fade_font_color_size {
            color: #87919B;
            font-size: 12px;
        }

        .paid_plan_cards i:before {
            font-size: 24px;
        }

        .counter-count {
            font-size: 50px;
            font-weight: bold;
            position: relative;
            color: #000000;
            text-align: center;
            display: inline-block;
        }

        /*total counts of month*/
        .month_amount i {
            font-size: 26px;
            color: #ff882d;
        }

        .total_business_user img {
            width: 265px;
        }

        .total_business_user h1 small {
            color: #ababab;
        }
    </style>
@endsection

@section('content')
    <section class="section">

        <div class="section-body">
            {{--  <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 paid_plan_cards paid_plan_cards_bg1 py-4">
                        <div class="paid_plan_card-icon ml-4">
                            <i class="fntlo icon-api-integration"></i>
                            <h4 class="ml-1">Messaging API</h4>
                        </div>
                        <div class="card-wrap">
                            <div class="card-body mt-4">
                                <h3 class="mb-0">480</h3>
                                <small class="fade_font_color_size">Total Sells</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 paid_plan_cards paid_plan_cards_bg2 py-4">
                        <div class="paid_plan_card-icon ml-4">
                            <i class="fntlo icon-share-and-reward"></i>
                            <h4 class="ml-1">Share Challenge</h4>
                        </div>
                        <div class="card-wrap">
                            <div class="card-body mt-4">
                                <h3 class="mb-0">680</h3>
                                <small class="fade_font_color_size">Total Sells</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 paid_plan_cards paid_plan_cards_bg3 py-4">
                        <div class="paid_plan_card-icon ml-4">
                            <i class="fntlo icon-instant_rewards"></i>
                            <h4 class="ml-1">Instant Challenge</h4>
                        </div>
                        <div class="card-wrap">
                            <div class="card-body mt-4">
                                <h3 class="mb-0">380</h3>
                                <small class="fade_font_color_size">Total Sells</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 paid_plan_cards paid_plan_cards_bg4 py-4">
                        <div class="paid_plan_card-icon ml-4">
                            <i class="fntlo icon-api-integration"></i>
                            <h4 class="ml-1">Employees</h4>
                        </div>
                        <div class="card-wrap">
                            <div class="card-body mt-4">
                                <h3 class="mb-0">480</h3>
                                <small class="fade_font_color_size">Total Sells</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 paid_plan_cards paid_plan_cards_bg5 py-4">
                        <div class="paid_plan_card-icon ml-4">
                            <i class="fntlo icon-api-integration"></i>
                            <h4 class="ml-1">D2C Post</h4>
                        </div>
                        <div class="card-wrap">
                            <div class="card-body mt-4">
                                <h3 class="mb-0">580</h3>
                                <small class="fade_font_color_size">Total Sells</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 paid_plan_cards paid_plan_cards_bg6 py-4">
                        <div class="paid_plan_card-icon ml-4">
                            <i class="fntlo icon-api-integration"></i>
                            <h4 class="ml-1">Personalised Messaging</h4>
                        </div>
                        <div class="card-wrap">
                            <div class="card-body mt-4">
                                <h3 class="mb-0">880</h3>
                                <small class="fade_font_color_size">Total Sells</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  --}}

            <div class="row">
                <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                    <div class="pb-4 h-100">
                        <div class="card mb-0 h-100">
                            <div class="card-header justify-content-between">
                                <div>
                                    <h4 class="d-inline">Transaction Statistics</h4>
                                </div>
                                <div class="card-header-action">
                                    <div class="btn-group">
                                        <a href="#" id="last7Days" class="btn btn-primary">Current 7 Days</a>
                                        {{--  <a href="#" id="this_month" class="btn">This Month</a>  --}}
                                        <a href="#" id="sbr_month" class="btn">Last Month</a>
                                        <a href="#" id="sbr_year" class="btn">Last 12 Months</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="clicks_data_chart" width="300" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                    {{--  <div class="card">
                        <div class="card-header justify-content-between">
                            <h4>Todays Total Sell</h4>
                        </div>
                        <div class="card-body">
                            <div class="count-up text-center">
                                <p class="counter-count" style="color: #ff882d;">100</p>
                                <h4>Total Sell</h4>
                            </div>
                        </div>
                    </div>  --}}
                    {{--  <div class="card">
                        <div class="card-header justify-content-between">
                            <h4>{{ $start_date . '-' . $end_date . ' Total Transactions ' }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="count-up text-center">
                                <p class="counter-count" style="color:#2f9c28;">{{ $transactionCount }}</p>
                                <h4>Total Transactions</h4>
                            </div>
                        </div>
                    </div>  --}}
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header month_amount">
                            <i class="fas fa-shopping-bag pr-3"></i>
                            <h5 class="mb-0">{{ $start_date . '-' . $end_date . ' Total Sell ' }}</h5>
                        </div>
                        <div class="card-body">
                            <h1>&#8377; {{ $total }}</h1>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header justify-content-between">
                            <h4>{{ $start_date . '-' . $end_date . ' Total Transactions ' }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="count-up text-center">
                                <p class="counter-count" style="color:#2f9c28;">{{ $transactionCount }}</p>
                                <h4>Total Transactions</h4>
                            </div>
                        </div>
                    </div>

                    {{--  <div class="card">
                        <div class="card-header month_amount">
                            <i class="fas fa-money-check-alt pr-3" style="color:#6457ea;"></i>
                            <h5 class="mb-0">Current Month Total GST</h5>
                        </div>
                        <div class="card-body">
                            <h1>&#8377; 60,000</h1>
                        </div>
                    </div>  --}}
                </div>
                <div class="col-lg-6">
                    <div class="card" style="background: #dbecfe;">
                        <div class="card-body total_business_user text-center">
                            <img src="{{ asset('assets/images/business_user.svg') }}">
                            <h1 class="my-3">{{ $userCount }} <small>Total Business Users</small></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="{{ asset('assets/js/form.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/input-validation.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @include('account.graph-script');
    
    <script>
        $('.counter-count').each(function() {
            $(this).prop('Counter', 0).animate({
                Counter: $(this).text()
            }, {

                //chnage count up speed here
                duration: 2000,
                easing: 'swing',
                step: function(now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
    </script>
@endpush

@section('end_body')
@endsection
