@extends('layouts.account')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'Checkout'])
@endsection

@section('end_head')
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ asset('assets/website/css/style.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('assets/website/css/responsive.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('assets/website/css/customs.css') }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/chosen2/chosen.min.css') }}" />
    <link href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css" rel="stylesheet" />
    <style>
        .summary {
            position: relative;
            width: 100%;
            background: #FFF;
            border-radius: 8px;
        }

        .text-capitalize {
            color: black;
        }

        .summary .sm_inner {
            position: relative;
            z-index: 2;
        }

        .summery_upper {
            color: #fff;
        }

        .pd_custom {
            padding: 3em;
        }

        @media (min-width:768px) and (max-width:991px) {
            .summery_upper {
                max-width: 450px;
                margin: auto;
            }
        }

        @media (max-width:480px) {
            .summary .sm_inner {
                padding: 0 .6rem;
            }

            .pd_custom {
                padding: 1.5rem 1em;
            }
        }


        .billing_type_checks {
            position: relative;
            max-width: 400px;
        }

        .billing_type_checks .list-group-item {
            background-color: rgb(255 255 255 / 100%);
            padding: 1em;
        }

        .billing_type_checks .list-group-item:first-child {
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .billing_type_checks .list-group-item:last-child {
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .billing_type_checks .form-check {
            margin-bottom: 0px;
            min-height: auto;
        }

        .billing_type_checks .form-check>.form-check-input {
            margin-top: 0;
        }

        .billing_type_checks .form-check>.form-check-label {
            line-height: 1;
            font-family: var(--font-family-head);
            display: block;
            /* color: var(--color-thm-lth); */
        }

        .price_mt,
        .price_yr {
            font-size: 16px;
            font-weight: bold;
        }

        .bifurcation {
            position: relative;
            width: 100%;
            max-width: 400px;
        }

        .checkout_rf {
            position: relative;
            width: 100%;
            max-width: 450px;
            margin: auto;
        }

        .br-left-to-top {
            border-radius: .6rem 0 0 .6rem;
        }

        .br-right-to-bottom {
            border-radius: 0 .6rem .6rem 0;
        }

        @media(max-width:991px) {
            .br-left-to-top {
                border-radius: .6rem .6rem 0 0;
            }

            .br-right-to-bottom {
                border-radius: 0 0 .6rem .6rem;
            }
        }

        .is_required {
            color: red;
        }
    </style>
@endsection

@section('content')
    <section id="checkout">
        <div class="py-5">
            <div class="container">
                <div>
                    <h1 class="h3 color-primary font-800">Checkout</h1>
                </div>

                @php
                    $payment_token = '';
                    if (!empty($selectedPlan)) {
                        $payment_token = $selectedPlan['payment_token_id'];
                    }
                @endphp

                @php
                    $name = $email = $mobile = '';
                    $address = $state_id = $city = $pincode = '';
                    if ($userDetails != null) {
                        $name = $userDetails->name;
                        $email = $userDetails->email;
                        $mobile = $userDetails->mobile;
                    
                        if ($businessDetails) {
                            $address = $businessDetails->billing_address_line_1;
                            $state_id = $businessDetails->billing_state;
                            $city = $businessDetails->billing_city;
                            $pincode = $businessDetails->billing_pincode;
                        }
                    }
                @endphp

                <div class="summary">
                    <div class="sm_inner">
                        <div class="row">
                            <div class="col-lg-6 pd_custom bg-color-gradient br-left-to-top">
                                <div class="summery_upper">
                                    <h4 class="font-800">Order Summary</h4>

                                    <div class="bifurcation">
                                        <table class="w-100 font-400 font-h1">
                                            <tr>
                                                <td>
                                                    @if (Session::has('package'))
                                                        @if (Session::get('package') == 'business')
                                                            {{ 'All Apps' }} @else{{ 'Selected Apps' }} @endif @else{{ $planData['plan_name'] }}
                                                    @endif
                                                </td>
                                                <td class="text-end"> <span>&#8377; <span id="NetPrice"
                                                            class="BillNetPrice">{{ round($withoutGst_price, 2) }}</span></span>
                                                </td>
                                            </tr>
                                            @if ($name == '')
                                                <tr id="igst_tr">
                                                    <td>IGST (18%)</td>
                                                    <td class="text-end"> <span>&#8377; <span id="IGSTPrice"
                                                                class="BillGSTPrice">{{ round($gst_price, 2) }}</span></span>
                                                    </td>
                                                </tr>
                                                <tr id="cgst_tr" style="display:none">
                                                    <td>CGST (9%)</td>
                                                    <td class="text-end"> <span>&#8377; <span id="CGSTPrice"
                                                                class="BillGSTPrice">{{ round($cgst_price, 2) }}</span></span>
                                                    </td>
                                                </tr>
                                                <tr id="sgst_tr" style="display:none">
                                                    <td>SGST (9%)</td>
                                                    <td class="text-end"> <span>&#8377; <span id="SGSTPrice"
                                                                class="BillGSTPrice">{{ round($sgst_price, 2) }}</span></span>
                                                    </td>
                                                </tr>
                                            @else
                                                @if ($state_id == 14)
                                                    <tr id="cgst_tr">
                                                        <td>CGST (9%)</td>
                                                        <td class="text-end"> <span>&#8377; <span id="CGSTPrice"
                                                                    class="BillGSTPrice">{{ round($cgst_price, 2) }}</span></span>
                                                        </td>
                                                    </tr>
                                                    <tr id="sgst_tr">
                                                        <td>SGST (9%)</td>
                                                        <td class="text-end"> <span>&#8377; <span id="SGSTPrice"
                                                                    class="BillGSTPrice">{{ round($sgst_price, 2) }}</span></span>
                                                        </td>
                                                    </tr>
                                                    <tr id="igst_tr" style="display:none">
                                                        <td>IGST (18%)</td>
                                                        <td class="text-end"> <span>&#8377; <span id="IGSTPrice"
                                                                    class="BillGSTPrice">{{ round($gst_price, 2) }}</span></span>
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr id="igst_tr">
                                                        <td>IGST (18%)</td>
                                                        <td class="text-end"> <span>&#8377; <span id="IGSTPrice"
                                                                    class="BillGSTPrice">{{ round($gst_price, 2) }}</span></span>
                                                        </td>
                                                    </tr>
                                                    <tr id="cgst_tr" style="display:none">
                                                        <td>CGST (9%)</td>
                                                        <td class="text-end"> <span>&#8377; <span id="CGSTPrice"
                                                                    class="BillGSTPrice">{{ round($cgst_price, 2) }}</span></span>
                                                        </td>
                                                    </tr>
                                                    <tr id="sgst_tr" style="display:none">
                                                        <td>SGST (9%)</td>
                                                        <td class="text-end"> <span>&#8377; <span id="SGSTPrice"
                                                                    class="BillGSTPrice">{{ round($sgst_price, 2) }}</span></span>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif


                                            <tr>
                                                <td class="small">Payable Amount</td>
                                                <td class="text-end"> <span class="fw-bold font-xlarge">&#8377; <span
                                                            class="BillGrossPrice"
                                                            id="PayablePrice">{{ $planData['payble_price'] }}</span></span>
                                                </td>
                                            </tr>

                                        </table>
                                        <hr>

                                    </div>
                                    {{-- <p class="mb-0">MouthPublicity.io Subcription Plan</p> --}}


                                    <div>
                                        <p class="mb-0 small">You are just one step back from creating your first campaign.
                                            Create the offer, promote it, Build your customer listing easily & get more
                                            customers for the business, with MouthPublicity.io a Simple Promotion Tool.</p>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-6 pd_custom border br-right-to-bottom">
                                <div>

                                    <div class="checkout_rf ">

                                        {{-- <script src="https://js.stripe.com/v3/"></script> --}}
                                        <form action="{{ url('make-charge' . '/' . $planData['plan_id']) }}" method="post"
                                            class="form-type-one basicform">
                                            @csrf
                                            {{-- @php $stripe=true; @endphp --}}

                                            <input type="hidden" name="mode" value="{{ $getway->id }}">
                                            <input type="hidden" name="payble_price" id="payble_price"
                                                value="{{ $planData['payble_price'] }}">

                                            @auth()
                                                <input type="hidden" name="old_user_id" value="{{ $userDetails->id }}" />
                                            @else
                                                <input type="hidden" name="old_user_id" value="" />
                                                @endif

                                                <input type="hidden" name="plan_name" value="{{ $planData['plan_name'] }}">

                                                <input type="hidden" name="payment_token" value="{{ $payment_token }}" />

                                                {{-- New Theme Inputs  --}}

                                                @if ($name == '')
                                                    <div class="form-group mb-3">
                                                        <input type="text" name="name" id="name"
                                                            class="form-control shadow-sm three-space-validation"
                                                            placeholder="Your name *" value="{{ $name }}" required>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="tel" name="phone" id="phone"
                                                            class="form-control shadow-sm no-space-validation number-validation"
                                                            value="{{ $mobile }}" placeholder="Whatsapp Number *"
                                                            minlength="10" maxlength="10" required>
                                                        <div class="mobile-error"></div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="email" name="email" id="email"
                                                            class="form-control shadow-sm" value="{{ $email }}"
                                                            placeholder="Email ID *" required>
                                                        <div class="email-error"></div>
                                                    </div>
                                                @else
                                                    <p><b>Name: </b>{{ $name }}</p>
                                                    <p><b>Mobile: </b>{{ $mobile }}</p>
                                                    <p><b>Email: </b>{{ $email }}</p>

                                                    <input type="hidden" name="name" id="name"
                                                        value="{{ $name }}">
                                                    <input type="hidden" name="phone" id="phone"
                                                        value="{{ $mobile }}">
                                                    <input type="hidden" name="email" id="email"
                                                        value="{{ $email }}">
                                                @endif

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group mb-3">
                                                            <input type="text" name="gst_address"
                                                                class="form-control shadow-sm" id="gst_address"
                                                                placeholder="Address *" title="Address"
                                                                value="{{ $address }}" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group mb-3">
                                                            <select name="gst_state" id="gst_state" title="State"
                                                                class="form-select form-control shadow-sm">
                                                                <option value="0">Select State *</option>
                                                                @foreach ($states as $state)
                                                                    <option value="{{ $state->id }}"
                                                                        class="state_{{ $state->id }}"
                                                                        id="{{ $state->gst_code_id }}"
                                                                        @if ($state_id == $state->id) selected @endif>
                                                                        {{ $state->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group mb-3">
                                                            <input type="text" name="gst_city" id="gst_city"
                                                                class="char-validation form-control shadow-sm"
                                                                placeholder="City *" title="City"
                                                                value="{{ $city }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group mb-3">
                                                            <input type="text" name="gst_pincode" id="gst_pincode"
                                                                class="no-space-validation number-validation form-control shadow-sm"
                                                                placeholder="Pincode *" title="Area Pincode" minlength="6"
                                                                maxlength="6" value="{{ $pincode }}" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <label class="text-capitalize payment_gateway">Select Payment Gateway :</label>
                                                {{-- Payment cheque, Nft, upi start --}}
                                                <div>
                                                    <div class="form-check mb-2 d-inline-block p-0 position-relative">
                                                        <input
                                                            class="form-check-input tl-drk position-absolute m-0 payment_type"
                                                            type="radio" id="cheque" name="check" value="1"
                                                            style="top: 7px;left: 7px;">
                                                        <label class="form-check-label btn btn-dark btn-sm"
                                                            style="padding-left: 32px;" for="cheque">
                                                            Cheque
                                                        </label>
                                                    </div>

                                                    <div class="form-check mb-2 d-inline-block p-0 position-relative">
                                                        <input
                                                            class="form-check-input tl-drk position-absolute m-0 payment_type"
                                                            type="radio" id="nft" name="check" value="2"
                                                            style="top: 7px;left: 7px;">
                                                        <label class="form-check-label btn btn-dark btn-sm"
                                                            style="padding-left: 32px;" for="nft">
                                                            NFT
                                                        </label>
                                                    </div>

                                                    <div class="form-check mb-2 d-inline-block p-0 position-relative">
                                                        <input
                                                            class="form-check-input tl-drk position-absolute m-0 payment_type"
                                                            type="radio" id="upi" name="check" value="3"
                                                            style="top: 7px;left: 7px;">
                                                        <label class="form-check-label btn btn-dark btn-sm"
                                                            style="padding-left: 32px;" for="upi">
                                                            UPI
                                                        </label>
                                                    </div>

                                                    {{--  cheque details start  --}}
                                                    <div class="collapse" id="cheque_collapse">
                                                        <div class="border_ border-dark_ mb-4 rounded_ p-2_"
                                                            style="max-width: 480px">
                                                            <div class="line-inputs">

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group mb-3">
                                                                            <label> Account Number</label><span
                                                                                class="is_required">*</span>
                                                                            <input type="text"
                                                                                class="form-control shadow-sm number-validation"
                                                                                maxlength="14"
                                                                                placeholder="Enter Account Number"
                                                                                title="Account Number" name="account_number"
                                                                                id="account_number_input">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group mb-3">
                                                                            <label> Cheque Number</label><span
                                                                                class="is_required">*</span>
                                                                            <input type="text"
                                                                                class="form-control shadow-sm number-validation"
                                                                                maxlength="6"
                                                                                placeholder="Enter Cheque Number"
                                                                                title="Cheque Number" name="cheque_number"
                                                                                id="cheque_number_input">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label> Cheque Date</label><span
                                                                                class="is_required">*</span>
                                                                            <div class="ui calendar" id="rangestart">
                                                                                <div class="date-input">
                                                                                    <input type="text" name="cheque_date"
                                                                                        id="start_date"
                                                                                        placeholder="mm/dd/yyyy"
                                                                                        value="{{ old('cheque_date') }}"
                                                                                        class="form-control"
                                                                                        autocomplete="off" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--  cheques details end   --}}

                                                    {{--  NFT details start   --}}
                                                    <div class="collapse" id="nft_collapse">
                                                        <div class="border_ border-dark_ mb-4 rounded_ p-2_"
                                                            style="max-width: 480px">
                                                            <div class="line-inputs">

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group mb-3">
                                                                            <label> Account Number</label><span
                                                                                class="is_required">*</span>
                                                                            <input type="text"
                                                                                class="form-control shadow-sm number-validation"
                                                                                maxlength="14"
                                                                                placeholder="Enter Account Number"
                                                                                title="Account Number" name="account_number"
                                                                                id="account_number_input_nft">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group mb-3">
                                                                            <label> Transaction Id</label><span
                                                                                class="is_required">*</span>
                                                                            <input type="text"
                                                                                class="form-control shadow-sm number-validation"
                                                                                maxlength="14"
                                                                                placeholder="Enter Transaction Id"
                                                                                title="Transaction Id" name="transaction_id"
                                                                                id="transaction_id">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label> Date</label><span
                                                                                class="is_required">*</span>
                                                                            <div class="ui calendar" id="rangestart">
                                                                                <div class="date-input">
                                                                                    <input type="text" name="nft_date"
                                                                                        id="nft_date"
                                                                                        placeholder="mm/dd/yyyy"
                                                                                        value="{{ old('date') }}"
                                                                                        class="form-control"
                                                                                        autocomplete="off" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--  NFT details end   --}}

                                                    {{--  UPI details start   --}}
                                                    <div class="collapse" id="upi_collapse">
                                                        <div class="border_ border-dark_ mb-4 rounded_ p-2_"
                                                            style="max-width: 480px">
                                                            <div class="line-inputs">

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group mb-3">
                                                                            <label> UPI Id</label><span
                                                                                class="is_required">*</span>
                                                                            <input type="text"
                                                                                class="form-control shadow-sm number-validation"
                                                                                maxlength="14" placeholder="Enter UPI Id"
                                                                                title="UPI Id" name="upi_id"
                                                                                id="account_number_input_upi">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group mb-3">
                                                                            <label> Transaction Id</label><span
                                                                                class="is_required">*</span>
                                                                            <input type="text"
                                                                                class="form-control shadow-sm number-validation"
                                                                                maxlength="14"
                                                                                placeholder="Enter Transaction Id"
                                                                                title="Transaction Id"
                                                                                name="upi_transaction_id"
                                                                                id="upi_transaction_id">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label> Date</label><span
                                                                                class="is_required">*</span>
                                                                            <div class="ui calendar" id="rangestart">
                                                                                <div class="date-input">
                                                                                    <input type="text" name="upi_date"
                                                                                        id="upi_date"
                                                                                        placeholder="mm/dd/yyyy"
                                                                                        value="{{ old('date') }}"
                                                                                        class="form-control"
                                                                                        autocomplete="off" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--  UPI details end   --}}

                                                </div>
                                                {{-- cheque, Nft, Upi --}}

                                                {{-- GST Start --}}
                                                <label class="text-capitalize">Select Claim GST :</label>
                                                <div>
                                                    <div class="form-check mb-2 d-inline-block p-0 position-relative">
                                                        <input class="form-check-input tl-drk position-absolute m-0"
                                                            type="checkbox" id="gst_claim" name="gst_claim" value="1"
                                                            style="top: 7px;left: 7px;">
                                                        <label class="form-check-label btn btn-dark btn-sm"
                                                            style="padding-left: 32px;" for="gst_claim">
                                                            Claim GST
                                                        </label>
                                                    </div>

                                                    <div class="collapse" id="gst_collapse">
                                                        <div class="border_ border-dark_ mb-4 rounded_ p-2_"
                                                            style="max-width: 480px">
                                                            <div class="line-inputs">
                                                                <p class="font-small mb-1">(To claim your GST, please provide
                                                                    your GST account details)</p>
                                                                <div class="row">
                                                                    <div class="col-md-5">
                                                                        <div class="form-group mb-3">
                                                                            <input type="text"
                                                                                class="form-control shadow-sm no-space-validation only-num-and-char"
                                                                                placeholder="Enter GST Number *"
                                                                                title="GST Number" name="gst_number"
                                                                                id="gst_number_input" maxlength="15">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <div class="form-group mb-3">
                                                                            <input type="text"
                                                                                class="form-control shadow-sm text-capitalize char-num-and-spcs"
                                                                                placeholder="Enter Registered Business Name *"
                                                                                title="Registered Business Name"
                                                                                name="gst_business_name"
                                                                                id="gst_business_name_input" maxlength="300">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="mt-3">
                                                                    <p class="mb-0 font-small">GSTIN : <span
                                                                            class="BillGrossPrice fw-bold">27AAECL6399Q1ZG</span>
                                                                        <span>(Logic Innovates)</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div>
                                                    <p class="small mb-1 font-h1">Payable amount is <span
                                                            class="fw-bold">&#8377; <span
                                                                class="BillGrossPrice">{{ $planData['payble_price'] }}/-</span></span>
                                                    </p>
                                                    <button type="button" class="btn btn-primary-ol btn-lg w-100"
                                                        id="checkCheckout">Payment Now</button>
                                                    <button type="submit" style="display:none" id="submitForm"></button>
                                                </div>
                                            </form>

                                            <div class="mt-2">
                                                <p class="small mb-0"><i class="bi bi-shield-check"></i> Secure Checkout With
                                                    <span style="color:#012652"
                                                        class="fw-bold font-h1"><i>{{ $getway->name }}</i></span>
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- Modal -->
        {{--  <div class="modal fade" id="LoginModalIfUserExist" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title font-700 color-primary"><i class="bi bi-exclamation-circle-fill"></i> Account
                        Exist</h5>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning small">
                        <div>Hello,</div>
                        <div>We found that you are already register with the us by your Mobile Number or Email-ID.</div>
                        <div>Please click on below Login button to login your existing account.</div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <a type="button" class="btn btn-primary-ol px-4" href="{{ url('signin') }}">Go to Login</a>
                        <button type="button" class="btn btn-outline-secondary font-600 px-4"
                            data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>  --}}
    @endsection

    @push('js')
        <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
        <script src="{{ asset('assets/js/input-validation.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap-colorpicker.min.js') }}"></script>
        <script src="{{ asset('assets/js/form.js') }}"></script>
        <script src="{{ asset('assets/js/chosen2/chosen.jquery.min.js') }}"></script>
        <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    @endpush

    @section('end_body')
        <script>
            function Sweet(icon, title, time = 3000) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: time,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: icon,
                    title: title,
                });
            }

            $(document).ready(function() {

                //get payable_amount
                if (sessionStorage.getItem('payable_amount')) {
                    var amount_stored = sessionStorage.getItem("payable_amount");
                    if (amount_stored < 100) {
                        amount_stored = 100;
                    }

                    var gst_price = (amount_stored - (amount_stored * (100 / (100 + 18)))).toFixed(2);
                    var gst_half = (gst_price / 2).toFixed(2);
                    var withoutGst_price = (amount_stored - gst_price).toFixed(2);

                    $('#NetPrice').text(withoutGst_price);
                    $('#GSTPrice').text(gst_price);
                    $('#IGSTPrice').text(gst_price);
                    $('#CGSTPrice').text(gst_half);
                    $('#SGSTPrice').text(gst_half);
                    $('#PayablePrice').text(amount_stored);

                    $("#payble_price").val(amount_stored);
                    $(".BillGrossPrice").text(amount_stored);
                } else {
                    window.location.href = '{{ route('account.userCreditPayment') }}';
                }

                function validateInputs() {

                    var gst_claim = $('#gst_claim').prop("checked") ? 1 : 0;
                    var cheque = $('#cheque').prop("checked") ? 1 : 0;
                    var nft = $('#nft').prop("checked") ? 2 : 0;
                    var upi = $('#upi').prop("checked") ? 3 : 0;

                    var cheque_number = $('#cheque_number_input').val();
                    var gst_address = $('#gst_address').val();
                    var gst_state = $('#gst_state').val();
                    var gst_city = $('#gst_city').val();
                    var gst_pincode = $('#gst_pincode').val();
                    var account_number_input = $('#account_number_input').val();
                    var account_number_input_nft = $('#account_number_input_nft').val();
                    var account_number_input_upi = $('#account_number_input_upi').val();
                    var cheque_date = $('#start_date').val();
                    var transaction_id = $('#transaction_id').val();
                    var upi_transaction_id = $('#upi_transaction_id').val();
                    var nft_date = $('#nft_date').val();
                    var upi_date = $('#upi_date').val();
                    var gst_busi_name = $('#gst_business_name_input').val();
                    var gst_number_input = $('#gst_number_input').val();
                    var payble_price = $("#payble_price").val();

                    if (gst_address == '') {
                        $("#gst_address").focus();
                        Sweet('error', 'Please enter address.');
                        return false;
                    }

                    if (gst_address.length < 6) {
                        $("#gst_address").focus();
                        Sweet('error', 'Address is too short.');
                        return false;
                    }

                    if (gst_state == 0 || gst_state == undefined) {
                        $("#gst_state").focus();
                        Sweet('error', 'Please select state.');
                        return false;
                    }

                    if (gst_city == '') {
                        $("#gst_city").focus();
                        Sweet('error', 'Please enter city.');
                        return false;
                    }

                    if (gst_city.length < 3) {
                        $("#gst_city").focus();
                        Sweet('error', 'City name is too short.');
                        return false;
                    }

                    if (gst_pincode == '') {
                        $("#gst_pincode").focus();
                        Sweet('error', 'Please enter pincode.');
                        return false;
                    }

                    if (gst_pincode.length < 6) {
                        $("#gst_pincode").focus();
                        Sweet('error', 'Pincode should be of 6 digit.');
                        return false;
                    }

                    if (gst_claim == 1) {

                        if (gst_number_input != "") {
                            var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9]{1}Z[a-zA-Z0-9]{1}$');
                            if (!gstinformat.test(gst_number_input)) {
                                Sweet('error', 'Please Enter Valid GSTIN Number.');
                                $("#gst_number_input").focus();
                                return false;
                            }

                            var gst_state_code = gst_number_input.slice(0, 2);
                            var state_code = $('.state_' + gst_state).attr('id');

                            if (state_code != gst_state_code) {
                                Sweet('error', 'Please Enter Valid GSTIN Number.');
                                $("#gst_number_input").focus();
                                return false;
                            }

                        } else {
                            /*console.log('gst empty');*/
                            $("#gst_number_input").focus();
                            Sweet('error', 'Please insert GST Number.');
                            return false;
                        }
                        $('.gst_number').val(gst_number_input);

                        if (gst_busi_name == '') {
                            $("#gst_business_name_input").focus();
                            Sweet('error', 'Please enter the registered business name.');
                            return false;
                        }

                        if (gst_busi_name.length < 3) {
                            $("#gst_busi_name").focus();
                            Sweet('error', 'Registered business name is too short.');
                            return false;
                        }
                    }

                    if (cheque == 1) {
                        if (account_number_input != "") {
                            var chequeinformat = new RegExp('^[0-9]*$');
                            if (!chequeinformat.test(account_number_input)) {
                                Sweet('error', 'Please Enter Valid Account Number.');
                                $("#account_number_input").focus();
                                return false;
                            }

                        } else {
                            /*console.log('gst empty');*/
                            $("#account_number_input").focus();
                            Sweet('error', 'Please insert Account Number.');
                            return false;
                        }
                        $('.account_number').val(account_number_input);

                        if (cheque_number == '') {
                            $("#cheque_number_input").focus();
                            Sweet('error', 'Please enter the Cheque Number.');
                            return false;
                        }

                        if (cheque_number.length < 3) {
                            $("#cheque_number").focus();
                            Sweet('error', 'Cheque Number is too short.');
                            return false;
                        }
                    } else if (nft == 2) {
                        if (account_number_input_nft != "") {
                            var nftinformat = new RegExp('^[0-9]*$');
                            if (!nftinformat.test(account_number_input_nft)) {
                                Sweet('error', 'Please Enter Valid Account Number.');
                                $("#account_number_input_nft").focus();
                                return false;
                            }

                        } else {
                            /*console.log('gst empty');*/
                            $("#account_number_input_nft").focus();
                            Sweet('error', 'Please insert Account Number.');
                            return false;
                        }
                        $('.account_number_input_nft').val(account_number_input_nft);

                        if (transaction_id == '') {
                            $("#transaction_id").focus();
                            Sweet('error', 'Please enter the transaction id.');
                            return false;
                        }

                        if (transaction_id.length < 3) {
                            $("#transaction_id").focus();
                            Sweet('error', 'transaction id is too short.');
                            return false;
                        }
                    } else if (upi == 3) {
                        if (account_number_input_upi != "") {
                            var upiinformat = new RegExp('^[0-9]*$');
                            if (!upiinformat.test(account_number_input_upi)) {
                                Sweet('error', 'Please Enter Valid Upi Number.');
                                $("#account_number_input_upi").focus();
                                return false;
                            }

                        } else {
                            /*console.log('gst empty');*/
                            $("#account_number_input_upi").focus();
                            Sweet('error', 'Please insert Upi Number.');
                            return false;
                        }
                        $('.account_number_input_upi').val(account_number_input_upi);

                        if (upi_transaction_id == '') {
                            $("#upi_transaction_id").focus();
                            Sweet('error', 'Please enter the upi transaction id.');
                            return false;
                        }

                        if (upi_transaction_id.length < 3) {
                            $("#upi_transaction_id").focus();
                            Sweet('error', 'transaction id is too short.');
                            return false;
                        }
                    } else {
                        Sweet('error', 'Please select payment gateway.');
                        return false;
                    }

                    return true;
                }

                $(document).on('click', '#checkCheckout', function() {
                    var btn = $(this);

                    var validate = validateInputs();
                    if (!validate) {
                        return false;
                    }

                    {{--  @auth()
                    var auth = '{{ Auth::User()->role_id }}';
                @else
                    var auth = '';
                @endauth  --}}

                    var gst_claim = $('#gst_claim').prop("checked") ? 1 : 0;
                    var cheque_number = $('#cheque_number_input').val();
                    var gst_address = $('#gst_address').val();
                    var gst_state = $('#gst_state').val();
                    var gst_city = $('#gst_city').val();
                    var gst_pincode = $('#gst_pincode').val();
                    var account_number_input = $('#account_number_input').val();
                    var account_number_input_nft = $('#account_number_input_nft').val();
                    var account_number_input_upi = $('#account_number_input_upi').val();
                    var cheque_date = $('#start_date').val();
                    var transaction_id = $('#transaction_id').val();
                    var upi_transaction_id = $('#upi_transaction_id').val();
                    var nft_date = $('#nft_date').val();
                    var upi_date = $('#upi_date').val();
                    var gst_busi_name = $('#gst_business_name_input').val();
                    var gst_number_input = $('#gst_number_input').val();
                    var payble_price = $("#payble_price").val();

                    var plan_id = '{{ $planData['plan_id'] }}';

                    if (gst_claim != 1) {
                        gst_busi_name = '';
                        gst_number_input = '';
                    }

                    /* console.log(btn) */
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    /* console.log(plan_id); */
                    if (plan_id) {
                        $.ajax({
                            /* the route pointing to the post function */
                            url: '{{ route('account.SucessPayment') }}',
                            type: "post",
                            /* send the csrf-token and the input to the controller */
                            data: {
                                _token: CSRF_TOKEN,
                                plan_id: plan_id,
                                gst_claim: gst_claim,
                                cheque_number: cheque_number,
                                gst_address: gst_address,
                                gst_state: gst_state,
                                gst_city: gst_city,
                                gst_pincode: gst_pincode,
                                account_number: account_number_input,
                                account_number_input_nft: account_number_input_nft,
                                account_number_input_upi: account_number_input_upi,
                                cheque_date: cheque_date,
                                transaction_id: transaction_id,
                                upi_transaction_id: upi_transaction_id,
                                nft_date: nft_date,
                                upi_date: upi_date,
                                gst_business_name: gst_busi_name,
                                gst_number: gst_number_input,
                                payble_price: payble_price
                            },
                            dataType: 'JSON',
                            beforeSend: function() {

                                btn.attr('disabled', '')
                                btn.html('Please Wait....')

                            },
                            /* remind that 'data' is the response of the AjaxController */
                            success: function(data) {
                                btn.removeAttr('disabled');
                                btn.html('Payment Now');

                                if (data.status == true) {
                                    if (data) {
                                        Sweet('success', data.message);
                                        setTimeout(function() {
                                            window.location.href =
                                                '{{ route('account.userCreditPayment') }}';
                                        }, 2000);

                                    } else {
                                        $('#submitForm').click();
                                    }

                                    $("#password-input").remove();

                                } else {
                                    // 

                                    /*$("#password-input").css("display", "block");*/

                                    // $("#password-input").remove();


                                    // $(data.password).insertAfter("#email");
                                    {{--  $('#LoginModalIfUserExist').modal('show');  --}}

                                }
                            }
                        });
                    }
                });


                {{--  $billedtype = $("input[name='billing_type']");
            $billedtype.on("change", function() {
                var valu = $billedtype.filter(":checked").val();

                if (valu === 'month') {
                    $(".BillTypeName").html('Monthly');
                    $(".BillGrossPrice").html("999");
                    $(".BillNetPrice").html("847");
                    $(".BillGSTPrice").html("152");
                } else if (valu === 'year') {
                    $(".BillTypeName").html('Yearly');
                    $(".BillGrossPrice").html("9999");
                    $(".BillNetPrice").html("8474");
                    $(".BillGSTPrice").html("1525");
                }
            })  --}}
            })
        </script>

        {{--  new code cheque date start  --}}
        <script>
            window.addEventListener("pageshow", function(event) {
                var historyTraversal = event.persisted || (typeof window.performance != "undefined" && window
                    .performance.navigation.type === 2);
                if (historyTraversal) {
                    if ($('#cheque').is(':checked')) {
                        $("#cheque_collapse").collapse("show");
                        $("#nft_collapse").collapse("hide");
                        $("#upi_collapse").collapse("hide");
                    }
                }
            });

            $(document).ready(function() {

                if ($('#cheque').is(':checked')) {
                    $("#cheque_collapse").collapse("show");
                    $("#nft_collapse").collapse("hide");
                    $("#upi_collapse").collapse("hide");
                }

                $(document).on('change', '#cheque', function() {
                    // $("#gst_claim").on("change", function(){
                    var active = $(this).prop("checked") ? 1 : 0;
                    if (active == 1) {
                        $("#cheque_collapse").collapse("show");
                        $("#nft_collapse").collapse("hide");
                        $("#upi_collapse").collapse("hide");
                    } else {
                        $('#gst_tr').show();
                        $('#igst_tr').hide();
                        $('#cgst_tr').hide();
                        $('#sgst_tr').hide();
                        // $('#gst_state').val('0');

                        $("#cheque_collapse").collapse("hide");
                    }
                    $('.cheque').val(active);
                });
                $(document).on('change', '#gst_state', function() {
                    var state_id = $(this).val();
                    /*console.log(state_id);*/
                    $('.gst_state').val(state_id);
                    if (state_id != 14) {
                        $('#gst_tr').hide();
                        $('#cgst_tr').hide();
                        $('#sgst_tr').hide();
                        $('#igst_tr').show();
                    } else {
                        $('#gst_tr').hide();
                        $('#igst_tr').hide();
                        $('#cgst_tr').show();
                        $('#sgst_tr').show();
                    }
                })
                $(document).on('change', '#account_number_input', function() {
                    var inputvalues = $(this).val();
                    var chequeinformat = new RegExp('^[0-9]*$');
                    if (chequeinformat.test(inputvalues)) {
                        $('.account_number').val(inputvalues);
                        return true;
                    } else {
                        Sweet('error', 'Please Enter Valid Account Number.');
                        $("#account_number_input").focus();
                    }
                });
            });
        </script>

        <script type="text/javascript">
            $(function() {
                var dateFormat = "mm/dd/yy",
                    from = $("#start_date")
                    .datepicker({
                        // defaultDate: "+1w",
                        changeMonth: true,
                        changeYear: true,
                        minDate: new Date(),
                        //maxDate: '5/5/2020',
                        numberOfMonths: 1
                    })

                    .on("change", function() {
                        from.datepicker("option", "maxDate", getDate(this));
                    });

                function getDate(element) {
                    var date;
                    try {
                        date = $.datepicker.parseDate(dateFormat, element.value);
                    } catch (error) {
                        date = null;
                    }

                    return date;
                }

                $("#showTo").click(function() {
                    $("#start_date").datepicker("show");
                });
            });

            window.onload = () => {
                const start_date = document.getElementById('start_date');
                start_date.onpaste = e => e.preventDefault();
            }
        </script>
        {{--  new code cheque date end  --}}

        {{--  new code NFT date start  --}}
        <script>
            window.addEventListener("pageshow", function(event) {
                var historyTraversal = event.persisted || (typeof window.performance != "undefined" && window
                    .performance.navigation.type === 2);
                if (historyTraversal) {
                    if ($('#nft').is(':checked')) {
                        $("#nft_collapse").collapse("show");
                        $("#cheque_collapse").collapse("hide");
                        $("#upi_collapse").collapse("hide");
                    }
                }
            });

            $(document).ready(function() {

                if ($('#nft').is(':checked')) {
                    $("#nft_collapse").collapse("show");
                    $("#cheque_collapse").collapse("hide");
                    $("#upi_collapse").collapse("hide");
                }

                $(document).on('change', '#nft', function() {

                    var active = $(this).prop("checked") ? 2 : 0
                    if (active == 2) {
                        $("#nft_collapse").collapse("show");
                        $("#cheque_collapse").collapse("hide");
                        $("#upi_collapse").collapse("hide");
                    } else {
                        $("#nft_collapse").collapse("hide");
                    }
                    $('.nft').val(active);
                });

                $(document).on('change', '#account_number_input_nft', function() {
                    var inputvalues = $(this).val();
                    var nftinformat = new RegExp('^[0-9]*$');
                    if (nftinformat.test(inputvalues)) {
                        $('.account_number_input_nft').val(inputvalues);
                        return true;
                    } else {
                        Sweet('error', 'Please Enter Valid Account Number.');
                        $("#account_number_input_nft").focus();
                    }
                });
            });
        </script>

        <script type="text/javascript">
            $(function() {
                var dateFormat = "mm/dd/yy",
                    from = $("#nft_date")
                    .datepicker({
                        // defaultDate: "+1w",
                        changeMonth: true,
                        changeYear: true,
                        minDate: new Date(),
                        //maxDate: '5/5/2020',
                        numberOfMonths: 1
                    })

                    .on("change", function() {
                        from.datepicker("option", "maxDate", getDate(this));
                    });

                function getDate(element) {
                    var date;
                    try {
                        date = $.datepicker.parseDate(dateFormat, element.value);
                    } catch (error) {
                        date = null;
                    }

                    return date;
                }

                $("#showTo").click(function() {
                    $("#nft_date").datepicker("show");
                });
            });

            window.onload = () => {
                const start_date = document.getElementById('nft_date');
                start_date.onpaste = e => e.preventDefault();
            }
        </script>
        {{--  new code NFT date end  --}}

        {{--  new code UPI date start  --}}
        <script>
            window.addEventListener("pageshow", function(event) {
                var historyTraversal = event.persisted || (typeof window.performance != "undefined" && window
                    .performance.navigation.type === 2);
                if (historyTraversal) {
                    if ($('#upi').is(':checked')) {
                        $("#upi_collapse").collapse("show");

                    }
                }
            });

            $(document).ready(function() {

                if ($('#upi').is(':checked')) {
                    $("#upi_collapse").collapse("show");
                    $("#nft_collapse").collapse("hide");
                    $("#cheque_collapse").collapse("hide");
                }

                $(document).on('change', '#upi', function() {

                    var active = $(this).prop("checked") ? 3 : 0
                    if (active == 3) {
                        $("#upi_collapse").collapse("show");
                        $("#nft_collapse").collapse("hide");
                        $("#cheque_collapse").collapse("hide");
                    } else {
                        $("#upi_collapse").collapse("hide");
                    }
                    $('.upi').val(active);
                });

                $(document).on('change', '#account_number_input_upi', function() {
                    var inputvalues = $(this).val();
                    var upiinformat = new RegExp('^[0-9]*$');
                    if (upiinformat.test(inputvalues)) {
                        $('.account_number_input_upi').val(inputvalues);
                        return true;
                    } else {
                        Sweet('error', 'Please Enter Valid Upi Number.');
                        $("#account_number_input_upi").focus();
                    }
                });
            });
        </script>

        <script type="text/javascript">
            $(function() {
                var dateFormat = "mm/dd/yy",
                    from = $("#upi_date")
                    .datepicker({
                        // defaultDate: "+1w",
                        changeMonth: true,
                        changeYear: true,
                        minDate: new Date(),
                        //maxDate: '5/5/2020',
                        numberOfMonths: 1
                    })

                    .on("change", function() {
                        from.datepicker("option", "maxDate", getDate(this));
                    });

                function getDate(element) {
                    var date;
                    try {
                        date = $.datepicker.parseDate(dateFormat, element.value);
                    } catch (error) {
                        date = null;
                    }

                    return date;
                }

                $("#showTo").click(function() {
                    $("#upi_date").datepicker("show");
                });
            });

            window.onload = () => {
                const start_date = document.getElementById('upi_date');
                start_date.onpaste = e => e.preventDefault();
            }
        </script>
        {{--  new code UPI date end  --}}

        {{--  gst start  --}}
        <script>
            window.addEventListener("pageshow", function(event) {
                var historyTraversal = event.persisted || (typeof window.performance != "undefined" && window
                    .performance.navigation.type === 2);
                if (historyTraversal) {
                    if ($('#gst_claim').is(':checked')) {
                        $("#gst_collapse").collapse("show");
                    }
                }
            });


            $(document).ready(function() {

                if ($('#gst_claim').is(':checked')) {
                    $("#gst_collapse").collapse("show");
                }

                $(document).on('change', '#gst_claim', function() {
                    // $("#gst_claim").on("change", function(){
                    var active = $(this).prop("checked") ? 1 : 0
                    if (active == 1) {
                        $("#gst_collapse").collapse("show");
                    } else {
                        $('#gst_tr').show();
                        $('#igst_tr').hide();
                        $('#cgst_tr').hide();
                        $('#sgst_tr').hide();
                        // $('#gst_state').val('0');

                        $("#gst_collapse").collapse("hide");
                    }
                    $('.gst_claim').val(active);
                });
                $(document).on('change', '#gst_state', function() {
                    var state_id = $(this).val();
                    /*console.log(state_id);*/
                    $('.gst_state').val(state_id);
                    if (state_id != 14) {
                        $('#gst_tr').hide();
                        $('#cgst_tr').hide();
                        $('#sgst_tr').hide();
                        $('#igst_tr').show();
                    } else {
                        $('#gst_tr').hide();
                        $('#igst_tr').hide();
                        $('#cgst_tr').show();
                        $('#sgst_tr').show();
                    }
                })
                $(document).on('change', '#gst_number_input', function() {
                    var inputvalues = $(this).val();
                    var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9]{1}Z[a-zA-Z0-9]{1}$');
                    if (gstinformat.test(inputvalues)) {
                        $('.gst_number').val(inputvalues);
                        return true;
                    } else {
                        Sweet('error', 'Please Enter Valid GSTIN Number.');
                        $("#gst_number_input").focus();
                    }
                });
            });
        </script>
        {{--  gst end  --}}
    @endsection
