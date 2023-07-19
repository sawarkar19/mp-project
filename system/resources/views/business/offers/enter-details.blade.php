@extends('layouts.business')
@section('title', 'Enter Offer Details: Business Panel')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'Enter Offer Details'])

    <link href="{{ asset('assets/css/jquery-ui.css') }}" rel="stylesheet" />

    <style>
        label span,
        .mark-required span {
            color: red;
        }

        .radio_tab {
            position: relative;
            width: 100%;
            background-color: #fff;
            border-radius: 4px;
            border-width: 2px !important;
            border-color: #fff;
            border-style: solid;
        }

        .radio_tab label,
        .radio_tab label>.card {
            margin-bottom: 0px;
            cursor: pointer;
        }

        .radio_tab label>.card>.card-header,
        .radio_tab label>.card>.card-body {
            min-height: 15px !important;
            padding: .8rem;
        }

        .radio_tab label>.card>.card-header>h4,
        .radio_tab label>.card>.card-body>p {
            line-height: 1.5;
        }

        .error-box {
            list-style-type: none;
            padding-left: 0px;
            margin-top: 50px;
        }

        .info-window {
            background-color: #d1ecf1 !important;
            color: #0c5460 !important;
        }

        .info-window p {
            line-height: 20px;
        }

        .draft_btn {
            background: transparent;
            border: none;
            color: #6777ef;
        }

        .img-type-box {
            padding-left: 0px;
            text-align: center;
        }

        .img-type-box .custom-control-label {
            cursor: pointer;
            position: relative;
            max-width: 100%;
        }

        .img-type-box .custom-control-label::before {
            border-radius: 0px;
            position: relative;
            width: 90px;
            height: 90px;
            background-color: #f2f2f2;
            border: 1px solid #EEE;
            margin-bottom: 10px;
            max-width: 100%;
            max-height: 100%;
        }

        .img-type-box .custom-control-label::after {
            display: none;
        }

        .img-type-box .custom-control-label::before {
            left: 0px;
        }

        .img-type-box.landscape .custom-control-label::before {
            width: 125px;
            height: 90px;
        }

        .img-type-box.portrait .custom-control-label::before {
            width: 70px;
            height: 90px;
        }

        .img-type-box .custom-control-input:checked~.custom-control-label::before {
            background-color: #dfe2ff !important;
        }

        .img-type-box .custom-control-input:focus~.custom-control-label::before {
            box-shadow: none !important;
        }

        #overlay {
            position: fixed;
            top: 0;
            z-index: 9999;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.6);
        }

        .cv-spinner {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px #ddd solid;
            border-top: 4px #2e93e6 solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }

        .is-hide {
            display: none;
        }

        .action_btn {
            padding: 0.5rem 0.8rem;
            font-size: 14px;
        }

        .date-input {
            position: relative;
        }

        .calendar-icon {
            position: absolute;
            top: 15px;
            right: 10px;
            opacity: 0.7;
        }

        /* css for read only input */
        .date-input .form-control[readonly] {
            background-color: #ffffff;
            opacity: 1;
        }
    </style>
@endsection


@section('content')

    <section class="section">

        <div class="section-body">

            <form id="offerform" action="{{ route('business.offerStore') }}" method="post" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="offer_id" value="{{ $offer_id }}" />
                <input type="hidden" name="offer_create_id" value="{{ $_GET['create_id'] }}" />

                <div class="row justify-content-center my-5">
                    <div class="col-md-8 col-xl-7">

                        <div class="card" id="offer_details">
                            <div class="card-header justify-content-between">
                                <h4>Offer Details <span class="small" style="color: red"> ( This will be showing in your
                                        offers meta )</span></h4>
                                <span class="info-btn" data-toggle="tooltip"
                                    title="You can add offer details and schedule your offer. The offer can be scheduled after it is already created,just edit the offer and select a date of your choice."><i
                                        class="fa fa-info-circle"></i></span>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="mb-0">Offer Title <span>*</span></label>
                                    <p class="text-muted mb-0">
                                        <small>The offer title is visible in both the offer preview and bottom of the offer
                                            link page. (limit is 60 characters)</small>
                                    </p>
                                    <input type="text" name="title" id="title" class="form-control"
                                        placeholder="Enter title here..." value="{{ $offer->title }}">
                                </div>

                                <div class="form-group">
                                    <label class="mb-0">Offer Description <span>*</span></label>
                                    <p class="text-muted mb-0">
                                        <small>The offer description will only be visible at the bottom of the offer link
                                            page. (limit is 160 characters)</small>
                                    </p>
                                    <textarea class="form-control" name="description" rows="3">{{ $offer->description }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <div class="ui calendar" id="rangestart">
                                                <div class="date-input">

                                                    <input type="text" name="start_date" id="start_date"
                                                        placeholder="Start Date"
                                                        value="@if ($offer->start_date != '') {{ \Carbon\Carbon::parse($offer->start_date)->format('m/d/Y') }} @endif"
                                                        class="form-control" autocomplete="off" readonly="true">
                                                    <i class="calendar-icon date-icon fa fa-calendar"
                                                        aria-hidden="true"></i>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <div class="ui calendar" id="rangeend">
                                                <div class="date-input">

                                                    <input type="text" name="end_date" id="end_date"
                                                        placeholder="End Date"
                                                        value="@if ($offer->end_date != '') {{ \Carbon\Carbon::parse($offer->end_date)->format('m/d/Y') }} @endif"
                                                        class="form-control" autocomplete="off" readonly="true">
                                                    <i class="calendar-icon date-icon fa fa-calendar"
                                                        aria-hidden="true"></i>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <p><span><b>Note : </b></span><span class="small" style="color: red">Dates used for
                                                others offer will be shown as disabled</span></p>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <hr>
                        @php
                            if ($offer_id != '') {
                                $btn_text = 'Update Offer';
                            } else {
                                $btn_text = 'Create Offer';
                            }
                        @endphp
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <button type="submit" name="save_btn" value="save"
                                    class="btn btn-icon icon-left btn-success save_btn saveOfferBtn">
                                    <i class="fas fa-check"></i>
                                    {{ $btn_text }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>


    </section>

    {{-- Modals  --}}
    <div class="modal fade" id="offer_details_modal" tabindex="-1" role="dialog"
        aria-labelledby="offer_details_modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Offer Details Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Easily create an offer with MouthPublicity, just by designing your offer content and choosing the
                        best template. Fill the below form with exact offer details, create it, share it with your customer
                        and keep track of it anytime with an engaging dashboard. </p>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('end_body')
    @include('business.offers.future.js')

    <script type="text/javascript">
        $(function() {

            var unavailableDates = @json($usedDates);
            var user = @json($user);

            /* next 30 days */
            var now = new Date();
            var next30days = new Date(now.setDate(now.getDate() + 30));

            /* unavailable dates */
            function unavailable(date) {
                dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();

                if ($.inArray(dmy, unavailableDates) == -1) {
                    return [true, ""];
                } else {
                    return [false, "", "Unavailable"];
                }
            }

            /* user check condition  start*/
            if (user == null) {
                var dateFormat = "mm/dd/yy",
                from = $("#start_date")
                .datepicker({
                    // defaultDate: "+1w",
                    changeMonth: true,
                    changeYear: true,
                    minDate: new Date(),
                    // maxDate: availableDates,
                    numberOfMonths: 1,
                    beforeShowDay: unavailable
                })
                .on("change", function() {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = $("#end_date").datepicker({
                    // defaultDate: "+1w",
                    changeMonth: true,
                    changeYear: true,
                    minDate: new Date(),
                    // maxDate: availableDates,
                    numberOfMonths: 1,
                    beforeShowDay: unavailable
                })
                .on("change", function() {
                    from.datepicker("option", "maxDate", getDate(this));
                });
            } else {
                var dateFormat = "mm/dd/yy",
                from = $("#start_date")
                .datepicker({
                    // defaultDate: "+1w",
                    changeMonth: true,
                    changeYear: true,
                    minDate: new Date(),
                    maxDate: next30days,
                    numberOfMonths: 1,
                    beforeShowDay: unavailable
                })
                .on("change", function() {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = $("#end_date").datepicker({
                    // defaultDate: "+1w",
                    changeMonth: true,
                    changeYear: true,
                    minDate: new Date(),
                    maxDate: next30days,
                    numberOfMonths: 1,
                    beforeShowDay: unavailable
                })
                .on("change", function() {
                    from.datepicker("option", "maxDate", getDate(this));
                });
            }
            /* user check condition end*/

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


        $(document).ready(function() {

            $(document).ajaxSend(function() {
                $("#overlay").fadeIn(300);
            });


            $("#offerform").on('submit', function(e) {
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: this.action,
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        $("#overlay").fadeOut(300);

                        if (response.status == true) {
                            Sweet('success', response.message);
                            const start_date = document.getElementById('start_date').value;
                            const end_date = document.getElementById('end_date').value;

                            if (start_date == "" || end_date == "") {
                                window.location.href = response.redirect_url +
                                    "?tab=unscheduled_tab";
                            } else {
                                window.location.href = response.redirect_url +
                                    "?tab=scheduled_tab";
                            }
                        } else {
                            Sweet('error', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        $("#overlay").fadeOut(300);
                        $.each(xhr.responseJSON.errors, function(key, item) {
                            Sweet('error', item);
                        });
                    }
                })
            });
        });

        window.onload = () => {
            const start_date = document.getElementById('start_date');
            start_date.onpaste = e => e.preventDefault();

            const end_date = document.getElementById('end_date');
            end_date.onpaste = e => e.preventDefault();
        }
    </script>

@endsection
