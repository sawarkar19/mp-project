@extends('layouts.account')
@section('title', 'Plans and Pricing - MouthPublicity.io')
@section('description', 'Upgrade to MouthPublicity.io and Convert your customers to mouth publicity marketing team. Get it
    at an incomparable price.')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'Pricing'])
@endsection

<link rel="stylesheet" href="{{ asset('assets/website/vendor/rangeslider.js-2.3.0/rangeslider.css') }}">
<!-- favicon -->
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

<!-- Bootstrap 5.2.0 -->
<link rel="stylesheet" href="{{ asset('assets/website/vendor/bootstrap/css/bootstrap.min.css') }}" media="all">

<!-- ICONS (Bootstrap) V1.5.0 -->
<link rel="stylesheet" href="{{ asset('assets/website/vendor/bootstrap-icons/font/bootstrap-icons.css') }}"
    media="all">
<link rel="stylesheet" href="{{ asset('assets/css/fontello/css/fontello.css') }}">

<style>
    :root {
        --font-family-head: 'Raleway', sans-serif;
        --font-family-text: 'Arial', sans-serif;
        --color-one: 40, 182, 169
            /* 35, 162, 167 */
        ;
        --color-two: 0, 42, 156;
        --color-text-dark: 60, 70, 79;
        --color-text-light: '';
        --color-primary: 22, 109, 162;
        --font-size: '1rem';
    }

    .pricing-banner img {
        width: 500px;
    }

    .btn-opn-green {
        background: rgba(27, 144, 18, 1);
        color: #fff;
    }

    .text-opn-green {
        color: rgba(27, 144, 18, 1);
    }

    .pricing-range {
        width: 100%;
        box-shadow: inset 3px 3px 5px rgba(0, 0, 0, .15);
        border-radius: 80px;
        background: #f6f6f6;
        padding: 20px 10px;
    }

    /* .pricing-range .range__input{
        width: 100%;
        display: block;
    } */
    #range_amount_input {
        width: 100% !important;
    }

    .pricing-input {
        width: 100% !important;
        box-shadow: inset 3px 3px 5px rgba(0, 0, 0, .15) !important;
        background: #f6f6f6 !important;
        border-radius: 80px !important;
        height: 48px !important;
        padding-left: 18px !important;
        font-weight: 600 !important;
        font-size: 1.3rem !important;
    }

    .social-count-card {
        background: #f6f6f6;
        box-shadow: inset 3px 3px 5px rgba(0, 0, 0, .15);
        border-radius: 18px;
        opacity: 1;
        backdrop-filter: blur(30px);
        -webkit-backdrop-filter: blur(30px);
        padding-left: 2rem;
    }

    .pricing-card-social-icons li {
        text-decoration: none;
        display: inline-block;
        list-style: none;
    }

    .range__thumb {
        position: absolute;
        left: 0;
        bottom: 40px;
        background-color: rgba(22, 109, 162);
        transform: translateX(-50%);
        border-radius: 8px;
        color: #fff;
        font-weight: 600;
        font-size: 14px;
        padding: 8px 10px;
        line-height: 1;
        z-index: 2;
        min-width: 82px;
    }

    .range__thumb::before {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border-top: 8px solid rgba(22, 109, 162);
        border-left: 8px solid transparent;
        border-right: 8px solid transparent;
    }

    .rangeslider,
    .rangeslider__fill {
        -webkit-box-shadow: inset 0px 1px 3px rgb(0 0 0 / 15%);
        */ box-shadow: inset 0px 1px 3px rgb(0 0 0 / 15%);
        */
    }

    .rangeslider--horizontal {
        height: 8px;
    }

    .rangeslider__fill {
        background: rgba(22, 109, 162);
    }

    .rangeslider--horizontal .rangeslider__handle {
        top: -8px;
        width: 25px;
        height: 25px;
        background-image: none;
    }

    .rangeslider--horizontal .rangeslider__handle:after {
        width: 15px;
        height: 15px;
        background: rgba(22, 109, 162);
    }

    .color-primary {
        color: rgba(22, 109, 162);
    }

    .btn-primary-ol {
        background: transparent linear-gradient(108deg, rgba(var(--color-one), 1) 0%, rgba(var(--color-two), 1) 100%) 0% 0% no-repeat padding-box !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        border: 0px !important;
    }
</style>


@section('content')

    {{-- New Pricing --}}
    <section id="pricing-new">
        <div class="container">
            <div class="text-center py-5">
                <div class="pricing-details">
                    <h4 class="text-uppercase h2 font-800 mb-3 color-primary">PAY AS YOU GO</h4>
                    <p class="mx-auto mb-0" style="max-width:780px;">Start using MouthPublicity.io with full potential and make your business mouth publicity remarkable. Simply recharge with minimum price of Rs.100 to get full access. Pay as you go with product usage.</p>
                </div>


                <div class="mt-5 mx-auto" style="max-width: 800px;">
                    <div class="card border-0 p-sm-5 px-3 py-4 bg-light_"
                        style="box-shadow: 15px 20px 60px rgb(0 0 0 / 15%);border-radius:15px;">
                        <div class="row justify-content-between">
                            <div class="col-md-3 col-sm-4 text-start">
                                <label for="" class="mb-0 font-small font-600">Amount</label>
                                <input type="number" name="amount" id="payable_amount_input" value="5000"
                                    class="form-control my-2 my-sm-0 pricing-input" min="100" max="100000"
                                    placeholder="e.g 5000">
                            </div>

                            <div class="col-md-9 col-sm-8 text-start">
                                <label for="" class="mb-0 font-small font-600">Select the amount range</label>
                                <div class="pricing-range d-block px-4">
                                    <div class="position-relative">
                                        <span class="range__thumb" id="range__thumb">5000</span>
                                        <input class="range__input my-2 my-sm-0" id="range_amount_input" type="range"
                                            value="5000" min="100" max="100000" step="1">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <h6 class="color-primary font-800">&#8377; 100</h6>
                                    <h6 class="color-primary font-800">&#8377; 1,00,000</h6>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4 mt-md-5">
                            <button class="btn btn-primary-ol btn-lg" id="recharge_now">Recharge Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="loader-overlap" style="display: none;" id="loader">
        <div class="d-flex flex-column h-100 align-items-center justify-content-center">
            <div class="spinner-border text-white" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('assets/website/vendor/rangeslider.js-2.3.0/rangeslider.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <script>
        function set_price(amount) {
            sessionStorage.setItem("payable_amount", amount);
        }

        function remove_price() {
            sessionStorage.removeItem("payable_amount");
        }

        function calc_aprox_roi(amount) {
            var amount = $("#payable_amount_input").val();

            const per_msg_price = 0.10;
            const per_user_cost = 0.50;
            const avg_reach_per_user = 400;

            /* Calculating reach */
            var reach = (amount / per_user_cost) * avg_reach_per_user;
            var reach_value = Math.floor(reach);
            $("#aprox_reach").text(reach_value.toLocaleString());
        }

        function range_thumb(amount) {
            var range_input = document.getElementById("range_amount_input");
            var range_thumb = document.getElementById("range__thumb");
            const bulletPosition = (range_input.value / range_input.max),
                space = range_input.offsetWidth - range_thumb.offsetWidth;
            // range_thumb.style.left = (bulletPosition * space) + 'px';

            range_thumb.style.left = (bulletPosition * range_input.offsetWidth) + 'px';
            range_thumb.innerHTML = '&#8377; ' + amount;
        }

        $(function() {
            var amount = $("#payable_amount_input").val();
            $("#range_amount_input").val(amount).change();
            calc_aprox_roi(amount);
            range_thumb(amount);

            /* Check sessionStorage and add amount to inputs */
            var amount_stored = sessionStorage.getItem("payable_amount");
            if (amount_stored) {
                var amount = amount_stored;
                $("#payable_amount_input").val(amount);
                $("#range_amount_input").val(amount);
                range_thumb(amount);
                calc_aprox_roi(amount);
            }


            $("#payable_amount_input").on("change", function() {
                let amount = $(this).val();
                $("#range_amount_input").val(amount).change();
                // range_thumb(amount);
                // calc_aprox_roi(amount);
            });

            $("#range_amount_input").rangeslider({
                polyfill: false,
                // update: true,
                onSlide: function(position, value) {
                    if (value >= 100) {
                        $("#payable_amount_input").val(value);
                        range_thumb(value);
                        calc_aprox_roi(amount);
                    }
                },
            });

            $("#recharge_now").click(function() {
                var amount = $("#payable_amount_input").val();

                if (amount >= 100) {
                    set_price(amount);
                    window.location.href = "{{ route('account.checkout') }}";

                } else {
                    Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        onOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    }).fire({
                        icon: 'error',
                        title: 'Please select a valid amount greater tha equals to 100.'
                    })
                }

            });
        });
    </script>
@endpush

@push('end_body')
    {{-- @include('website.scripts.pricing-js') --}}
@endpush
