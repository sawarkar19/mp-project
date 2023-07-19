@extends('layouts.account')

@section('head')
    @include('layouts.partials.headersection', ['title' => 'Reports'])
@endsection

@section('end_head')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterangepicker.css') }}">
    <style>
        .counter-count-transaction {
            font-size: 50px;
            font-weight: bold;
            position: relative;
            color: #fff;
            text-align: center;
            display: inline-block;
        }

        .total-transaction {
            color: #fff;
            background-image: linear-gradient(to bottom, #293594, #8087c2);
        }

        .total_amount_recived.card .card-stats .card-stats-items {
            height: auto !important;
        }

        .circle-chart {
            width: 387px;
            height: 262px;
        }

        .circle-chart__circle {
            stroke: #00acc1;
            stroke-width: 1;
            stroke-linecap: square;
            fill: none;
            animation: circle-chart-fill 2s reverse;
            /* 1 */
            transform: rotate(-90deg);
            /* 2, 3 */
            transform-origin: center;
            /* 4 */
        }

        .circle-chart__circle--negative {
            transform: rotate(-90deg) scale(1, -1);
            /* 1, 2, 3 */
        }

        .circle-chart__background {
            stroke: #efefef;
            stroke-width: 1;
            fill: none;
        }

        .circle-chart__info {
            animation: circle-chart-appear 2s forwards;
            opacity: 0;
            transform: translateY(0.3em);
        }

        .circle-chart__percent {
            alignment-baseline: central;
            text-anchor: middle;
            font-size: 8px;
        }

        .circle-chart__subline {
            alignment-baseline: central;
            text-anchor: middle;
            font-size: 3px;
        }

        .success-stroke {
            stroke: #00c851;
        }

        .warning-stroke {
            stroke: #ffbb33;
        }

        .danger-stroke {
            stroke: #ff4444;
        }

        @keyframes circle-chart-fill {
            to {
                stroke-dasharray: 0 100;
            }
        }

        @keyframes circle-chart-appear {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .skills {
            color: black;
        }

        .skills_section {
            width: 100%;
            margin: 0 auto;
            margin-bottom: 80px;
        }

        .skill-head {
            margin: 80px 0;
        }

        .skill-head h1 {
            font-size: 60px;
            font-weight: 700;
        }

        .skill-head p {
            margin-bottom: 10px;
        }

        .skills-area {
            margin-top: 5%;
            display: flex;
            flex-wrap: wrap;
        }

        .single-skill {
            width: 100%;
            /* position: absolute;
                              top: 50%;
                              transform: translate(-50%, -50%);
                              left: 50%;*/
        }

        .success-stroke {
            stroke: rgb(129, 86, 252);
        }

        .circle-chart__background {
            stroke: #ede4e4;
            stroke-width: 1;
        }

        #RazorPaydiv,
        #CashFreediv,
        #PayPaldiv,
        #Paytmdiv,
        #Nftdiv,
        #Chequediv {
            display: none;
        }

        /* Extra small devices (portrait phones, less than 576px) */
        @media (max-width: 575.98px) {
            .skill-head {
                margin: 50px 0;
            }

            .skill-head h1 {
                font-size: 30px;
            }

            .skill-icon {
                width: 50%;
            }

            .skill-icon i {
                font-size: 70px;
            }

            .single-skill {
                width: 50%;
            }

            .circle-chart {
                width: 130px;
                height: 130px;
            }
        }
    </style>
@endsection

@section('content')


    <section class="section">

        <div class="section-body">
            <h2 class="section-title">Select Payment Gateway and Date</h2>
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-lg-5 col-md-5 col-sm-5 col-8">
                            <div class="form-group">
                                <label>Select Payment Gateway</label>
                                <select class="form-control" id="payment">
                                    <option value="All">All</option>
                                    <option value="RazorPay">RazorPay</option>
                                    <option value="CashFree">CashFree</option>
                                    <option value="PayPal">PayPal</option>
                                    <option value="Paytm">Paytm</option>
                                    <option value="Nft">Bank Transfer NFT</option>
                                    <option value="Cheque">Cheque</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-5 col-md-5 col-sm-5 col-8">
                            <div>
                                <form method="GET">
                                    <div class="form-group">
                                        <label>Date Range Picker</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>

                                            @if ($request->date)
                                                <input type="text" name="date" id="date"
                                                    value="{{ $request->date }}" class="form-control daterange-cus">
                                                
                                            @elseif ($financial_start_date . ' - ' . $financial_end_date)
                                                <input type="text" name="date" id="date"
                                                    value="{{ $financial_start_date . ' - ' . $financial_end_date }}"
                                                    class="form-control daterange-cus">
                                            @endif

                                                <div class="col-lg-2 col-md-2 col-sm-2 col-12">
                                                    <button class="btn btn-primary" type="submit">Apply</button>
                                                </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="card total-transaction">
                        <div class="card-header">
                            <h4 style="color: #fff;">Transactions Statistics</h4>
                        </div>
                        <div class="card-body py-5 pl-5">
                            <div class="count-up-transaction">
                                <h3 class="counter-count-transaction">{{ $totalTransactionCount }}</h3>
                                <h6>Total Transactions</h6>
                            </div>

                            <div class="pt-5">
                                <h2>&#8377; {{ $total }}</h2>
                                <h6>Total Amount</h6>
                            </div>
                            <div class="pt-5">
                                <h2>&#8377; {{ $totalGst }}</h2>
                                <h6>Total GST</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-12">
                    <div id="All" class="card card-statistic-2 total_amount_recived pb-4">
                        <div>
                            <div class="card">
                                <div class="card-header">
                                    <h4>Total of Amount Recived by Payment Gateway</h4>
                                </div>
                                <div class="card-body pl-3">
                                    <div class="row">
                                        @php
                                            $maxTotal = [
                                                'totalCashfree' => $totalCashfree,
                                                'totalNft' => $totalNft,
                                                'totalRazorpay' => $totalRazorpay,
                                                'totalPaypal' => $totalPaypal,
                                                'totalPaytm' => $totalPaytm,
                                                'totalCheque' => $totalCheque
                                            ];
                                            arsort($maxTotal);
                                        @endphp
                                        
                                        @foreach ($maxTotal as $key => $total)
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-12 pt-4">
                                            <h4>&#8377; {{ $total }}</h4>
                                            <h6>
                                                @if ($key == "totalCashfree")
                                                By CashFree
                                                @elseif ($key == "totalNft")
                                                By Bank Transfer NFT
                                                @elseif ($key == "totalRazorpay")
                                                By RazorPay
                                                @elseif ($key == "totalPaypal")
                                                By PayPal
                                                @elseif ($key == "totalPaytm")
                                                By Paytm
                                                @elseif ($key == "totalCheque")
                                                By Cheque
                                                @endif
                                            </h6>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="canvas-holder" class="pt-5" style="width: 500px; max-width: 100%;">
                            <canvas id="chart-area"></canvas>
                        </div>
                    </div>
                    {{-- RazorPay --}}
                    <div id="RazorPaydiv" class="card">
                        <div class="card-body">
                            <div class="RazorPay">
                                <div class="skills-area">
                                    <div class="single-skill text-center">
                                        <div class="circlechart" data-percentage="{{ number_format($razorpayPercentage, 0) }}"><svg class="circle-chart"
                                                viewBox="0 0 33.83098862 33.83098862" xmlns="http://www.w3.org/2000/svg">
                                                <circle class="circle-chart__background" cx="16.9" cy="16.9"
                                                    r="15.9"></circle>
                                                <circle class="circle-chart__circle success-stroke"
                                                    stroke-dasharray="92,100" cx="16.9" cy="16.9" r="15.9">
                                                </circle>
                                                <g class="circle-chart__info"> <text class="circle-chart__percent"
                                                        x="17.9" y="15.5"></text><text
                                                        class="circle-chart__subline" x="16.91549431" y="22">
                                                        by RazorPay
                                                    </text> </g>
                                            </svg></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- CashFree --}}
                    <div id="CashFreediv" class="card">
                        <div class="card-body">
                            <div class="CashFree">
                                <div class="skills-area">
                                    <div class="single-skill text-center">
                                        <div class="circlechart" data-percentage="{{ number_format($cashfreePercentage, 0) }}"><svg class="circle-chart"
                                                viewBox="0 0 33.83098862 33.83098862" xmlns="http://www.w3.org/2000/svg">
                                                <circle class="circle-chart__background" cx="16.9" cy="16.9"
                                                    r="15.9"></circle>
                                                <circle class="circle-chart__circle success-stroke"
                                                    stroke-dasharray="92,100" cx="16.9" cy="16.9"
                                                    r="15.9"></circle>
                                                <g class="circle-chart__info"> <text class="circle-chart__percent"
                                                        x="17.9" y="15.5"></text><text
                                                        class="circle-chart__subline" x="16.91549431" y="22">
                                                        by CashFree
                                                    </text> </g>
                                            </svg></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- PayPal --}}
                    <div id="PayPaldiv" class="card">
                        <div class="card-body">
                            <div class="PayPal">
                                <div class="skills-area">
                                    <div class="single-skill text-center">
                                        <div class="circlechart" data-percentage="{{ number_format($paypalPercentage, 0) }}"><svg class="circle-chart"
                                                viewBox="0 0 33.83098862 33.83098862" xmlns="http://www.w3.org/2000/svg">
                                                <circle class="circle-chart__background" cx="16.9" cy="16.9"
                                                    r="15.9"></circle>
                                                <circle class="circle-chart__circle success-stroke"
                                                    stroke-dasharray="92,100" cx="16.9" cy="16.9"
                                                    r="15.9"></circle>
                                                <g class="circle-chart__info"> <text class="circle-chart__percent"
                                                        x="17.9" y="15.5"></text><text
                                                        class="circle-chart__subline" x="16.91549431" y="22">
                                                        by PayPal
                                                    </text> </g>
                                            </svg></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Paytm --}}
                    <div id="Paytmdiv" class="card">
                        <div class="card-body">
                            <div class="Paytm">
                                <div class="skills-area">
                                    <div class="single-skill text-center">
                                        <div class="circlechart" data-percentage="{{ number_format($paytmPercentage, 0) }}"><svg class="circle-chart"
                                                viewBox="0 0 33.83098862 33.83098862" xmlns="http://www.w3.org/2000/svg">
                                                <circle class="circle-chart__background" cx="16.9" cy="16.9"
                                                    r="15.9"></circle>
                                                <circle class="circle-chart__circle success-stroke"
                                                    stroke-dasharray="92,100" cx="16.9" cy="16.9"
                                                    r="15.9"></circle>
                                                <g class="circle-chart__info"> <text class="circle-chart__percent"
                                                        x="17.9" y="15.5"></text><text
                                                        class="circle-chart__subline" x="16.91549431" y="22">
                                                        by Paytm
                                                    </text> </g>
                                            </svg></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Cheque --}}
                    <div id="Chequediv" class="card">
                        <div class="card-body">
                            <div class="Cheque">
                                <div class="skills-area">
                                    <div class="single-skill text-center">
                                        <div class="circlechart" data-percentage="{{ number_format($chequePercentage, 0) }}"><svg class="circle-chart"
                                                viewBox="0 0 33.83098862 33.83098862" xmlns="http://www.w3.org/2000/svg">
                                                <circle class="circle-chart__background" cx="16.9" cy="16.9"
                                                    r="15.9"></circle>
                                                <circle class="circle-chart__circle success-stroke"
                                                    stroke-dasharray="92,100" cx="16.9" cy="16.9"
                                                    r="15.9"></circle>
                                                <g class="circle-chart__info"> <text class="circle-chart__percent"
                                                        x="17.9" y="15.5"></text><text
                                                        class="circle-chart__subline" x="16.91549431" y="22">
                                                        by Cheque
                                                    </text> </g>
                                            </svg></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Bank Transfer Nft --}}
                    <div id="Nftdiv" class="card">
                        <div class="card-body">
                            <div class="Nft">
                                <div class="skills-area">
                                    <div class="single-skill text-center">
                                        <div class="circlechart" data-percentage="{{ number_format($nftPercentage, 0) }}"><svg class="circle-chart"
                                                viewBox="0 0 33.83098862 33.83098862" xmlns="http://www.w3.org/2000/svg">
                                                <circle class="circle-chart__background" cx="16.9" cy="16.9"
                                                    r="15.9"></circle>
                                                <circle class="circle-chart__circle success-stroke"
                                                    stroke-dasharray="92,100" cx="16.9" cy="16.9"
                                                    r="15.9"></circle>
                                                <g class="circle-chart__info"> <text class="circle-chart__percent"
                                                        x="17.9" y="15.5"></text><text
                                                        class="circle-chart__subline" x="16.91549431" y="22">
                                                        by Bank Transfer NFT
                                                    </text> </g>
                                            </svg></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--   {{-- Razor Pay --}}
                                    <div class="row">
                                        <div class="col-lg-8">
                                            
                                        </div>
                                    </div> -->
            <div class="row">
                <div class="col-12 mt-2">
                    <div class="card">
                        <div class="card-body p-0">

                            <div class="row justify-content-between align-items-center">
                                <div class="col-sm-4 col-12">
                                    <form>
                                        <div class="input-group mb-2">
                                            <select class="form-control selectric" name="no_of_users" id="no_of_users">
                                                <option value="10" @if ($request->no_of_users == '10') selected @endif>
                                                    {{ __('10') }}</option>
                                                <option value="25" @if ($request->no_of_users == '25') selected @endif>
                                                    {{ __('25') }}</option>
                                                <option value="50" @if ($request->no_of_users == '50') selected @endif>
                                                    {{ __('50') }}</option>
                                                <option value="100" @if ($request->no_of_users == '100') selected @endif>
                                                    {{ __('100') }}</option>
                                            </select>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit"><i
                                                        class="fas fa-search"></i></button>
                                            </div>
                                        </div>

                                    </form>

                                </div>

                                <div class="col-sm-6 col-12">
                                    <form>
                                        <div class="input-group mb-2">

                                            <input type="text" id="src" class="form-control"
                                                placeholder="Search..." name="src" autocomplete="off"
                                                value="{{ $request->src ?? '' }}">
                                            <select class="form-control selectric" name="term" id="term">
                                                <option value="name" @if ($request->name == 'name') selected @endif>
                                                    {{ __('Search By Name') }}</option>
                                                <option value="transaction_id"
                                                    @if ($request->term == 'transaction_id') selected @endif>
                                                    {{ __('Search By Transaction Id') }}</option>
                                                {{-- <option value="email">{{ __('Search By Mail') }}</option> --}}

                                            </select>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit"><i
                                                        class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive">
                                @if (count($transactions) >= 1)
                                    <table class="table table-striped table-hover text-left table-borderless">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Sr No') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Invoice No') }}</th>
                                                <th>{{ __('Date') }}</th>
                                                <th>{{ __('Transaction Id') }}</th>
                                                <th>{{ __('Amount') }}</th>
                                                <th>{{ __('GST Claimed') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($transactions))
                                                <?php $count = 1; ?>
                                                @foreach ($transactions as $index => $trans)
                                                    <tr>
                                                        <td>{{ $transactions->perPage() * ($transactions->currentPage() - 1) + $count }}
                                                        </td>
                                                        <td>{{ $trans->user->name ?? 'Customer' }}</td>
                                                        <td>{{ $trans->invoice_no }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($trans->created_at)->format('d M Y') }}
                                                        </td>
                                                        <td>{{ $trans->transaction_id }}</td>
                                                        <td class="text-center"><span
                                                                class="badge badge-success">{{ '₹' . ' ' . $trans->transaction_amount }}</span>
                                                        </td>
                                                        <td>
                                                            @if ($trans->gst_claim == 1)
                                                                <span
                                                                    class="badge badge-success">{{ __('Yes') }}</span>
                                                            @elseif ($trans->gst_claim == 0)
                                                                <span
                                                                    class="badge badge-danger">{{ __('No') }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($trans->transaction_amount <= 0)
                                                                <span class="badge badge-warning">Free User</span>
                                                            @else
                                                                <a href="{{ route('account.viewHistory',$trans->id) }}"
                                                                    class="btn btn-success"> <i class="fas fa-eye"></i>
                                                                    View
                                                                    Invoice</a>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                    <?php $count++; ?>
                                                @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                @else
                                    <div class="card-body">
                                        <h3>{{ Config::get('constants.no_record_found') }}</h3>
                                    </div>
                                @endif

                            </div>

                            <div class="card-footer text-center">
                                {{ $transactions->appends(array_except(Request::query(), $request->no_of_users))->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- END WA CONNECTIN TAB  --}}
    </section>


@endsection

@push('js')
    <script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    {{-- Date Picker --}}

    <script>
        $(document).ready(function() {

            $('.daterange-cus').daterangepicker({
                locale: {
                    format: 'DD-MM-YYYY'
                },
                singleDatePicker: false,
                timePicker: false,
                autoUpdateInput: true,
                autoApply: true,

            });
        })
    </script>
    {{-- Counter --}}
    <script>
        $('.counter-count-transaction').each(function() {
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
    {{-- Doughnut chart --}}
    <script>
        // var display_false = 'true';
        //     if ($(window).width() <= 600) {
        //         var display_false = 'false';    
        //     }

        var pai_position = 'right';
        if ($(window).width() <= 600) {
            var pai_position = 'bottom';
        }



        window.chartColors = {
            RazorPay: "rgb(222, 60, 60)",
            CashFree: "rgb(242, 156, 43)",
            PayPal: "rgb(255, 205, 86)",
            Paytm: "rgb(75, 192, 192)",
            Cheque: "rgb(47, 156, 40)",
            Nft: "rgb(3, 169, 244)",
            purple: "rgb(153, 102, 255)",
            grey: "rgb(231,233,237)"
        };
        var config = {
            type: "doughnut",
            data: {
                datasets: [{
                    data: @json($data),
                    backgroundColor: [
                        window.chartColors.RazorPay,
                        window.chartColors.CashFree,
                        window.chartColors.PayPal,
                        window.chartColors.Paytm,
                        window.chartColors.Cheque,
                        window.chartColors.Nft
                    ]
                }],
                labels: ["RazorPay", "CashFree", "PayPal", "Paytm", "Cheque" , "Bank Transfer Nft"]
            },
            // options: {
            //   // borderWidth:2,
            //   responsive: true,
            //   // cutout: 100,
            //   maintainAspectRatio: false,
            //   tooltips: {
            //     enabled: true
            //   },
            //   plugins:{
            //           legend: {
            //           position: pai_position,
            //           rtl:true
            //       }

            //   },
            //    cutoutPercentage: 80
            // }

            options: {
                legend: {
                    // display: display_false,
                    position: pai_position
                },
                elements: {
                    arc: {
                        borderWidth: 0,
                        borderJoinStyle: 'bevel'
                    }
                },
                cutoutPercentage: 80
            }
        };

        window.onload = function() {
            var ctx = document.getElementById("chart-area").getContext("2d");
            window.myPie = new Chart(ctx, config);


        };
    </script>


    <script>
        function makesvg(percentage, inner_text = "") {
            var abs_percentage = Math.abs(percentage).toString();
            var percentage_str = percentage.toString();
            var classes = "";

            if (percentage < 0) {
                classes = "danger-stroke circle-chart__circle--negative";
            } else if (percentage > 0 && percentage <= 30) {
                classes = "warning-stroke";
            } else {
                classes = "success-stroke";
            }

            var svg =
                '<svg class="circle-chart" viewbox="0 0 33.83098862 33.83098862" xmlns="http://www.w3.org/2000/svg">' +
                '<circle class="circle-chart__background" cx="16.9" cy="16.9" r="15.9" />' +
                '<circle class="circle-chart__circle ' +
                classes +
                '"' +
                'stroke-dasharray="' +
                abs_percentage +
                ',100"    cx="16.9" cy="16.9" r="15.9" />' +
                '<g class="circle-chart__info">' +
                '   <text class="circle-chart__percent" x="17.9" y="15.5">' +
                percentage_str +
                "%</text>";

            if (inner_text) {
                svg +=
                    '<text class="circle-chart__subline" x="16.91549431" y="22">' +
                    inner_text +
                    "</text>";
            }

            svg += " </g></svg>";

            return svg;
        }

        (function($) {
            $.fn.circlechart = function() {
                this.each(function() {
                    var percentage = $(this).data("percentage");
                    var inner_text = $(this).text();
                    $(this).html(makesvg(percentage, inner_text));
                });
                return this;
            };
        })(jQuery);

        $(function() {
            $(".circlechart").circlechart();
        });
    </script>
    {{-- reports --}}
    <script>
        $(document).ready(function() {
            $('#payment').on('change', function() {
                var payment = $(this).val();

                if (payment == "All") {
                    $("#All").show();
                } else {
                    $("#All").hide();
                }
                if (payment == "RazorPay") {
                    $("#RazorPaydiv").show();
                } else {
                    $("#RazorPaydiv").hide();
                }
                if (payment == "CashFree") {
                    $("#CashFreediv").show();
                } else {
                    $("#CashFreediv").hide();
                }
                if (payment == "PayPal") {
                    $("#PayPaldiv").show();
                } else {
                    $("#PayPaldiv").hide();
                }
                if (payment == "Paytm") {
                    $("#Paytmdiv").show();
                } else {
                    $("#Paytmdiv").hide();
                }
                if (payment == "Cheque") {
                    $("#Chequediv").show();
                } else {
                    $("#Chequediv").hide();
                }
                if (payment == "Nft") {
                    $("#Nftdiv").show();
                } else {
                    $("#Nftdiv").hide();
                }

            });
        });
    </script>
@endpush
@section('end_body')
@endsection
