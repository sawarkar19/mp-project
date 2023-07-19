@extends('layouts.business')

@section('head')
@include('layouts.partials.headersection',['title'=>'Enter Offer Details'])

    <link href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css" rel="stylesheet" />

@endsection


@section('content')

<section class="section">

    <style>
        label span, .mark-required span{
            color:red;
        }
        .radio_tab{
            position: relative;
            width:100%;
            background-color:#fff;
            border-radius:4px;
            border-width:2px!important;
            border-color:#fff;
            border-style: solid;
        }
        .radio_tab label,
        .radio_tab label > .card{
            margin-bottom:0px;
            cursor: pointer;
        }
        .radio_tab label > .card > .card-header,
        .radio_tab label > .card > .card-body{
            min-height: 15px !important;
            padding: .8rem;
        }
        .radio_tab label > .card > .card-header > h4,
        .radio_tab label > .card > .card-body > p{
            line-height:1.5;
        }
        .error-box{
            list-style-type: none;
            padding-left: 0px;
            margin-top: 50px;
        }
        .info-window{
            background-color: #d1ecf1 !important;
            color: #0c5460 !important;
        }
        .info-window p{
            line-height: 20px;
        }
        .draft_btn{
            background: transparent;
            border: none;
            color: #6777ef;
        }

        .img-type-box{
            padding-left:0px;
            text-align:center;
        }
        .img-type-box .custom-control-label{
            cursor: pointer;
            position: relative;
            max-width:100%;
        }
        .img-type-box .custom-control-label::before{
            border-radius:0px;
            position:relative;
            width: 90px;
            height: 90px;
            background-color:#f2f2f2;
            border:1px solid #EEE;
            margin-bottom:10px;
            max-width:100%;
            max-height:100%;
        }
        .img-type-box .custom-control-label::after{
            display:none;
        }
        .img-type-box .custom-control-label::before{
            left:0px;
        }
        .img-type-box.landscape .custom-control-label::before{
            width: 125px;
            height: 90px;
        }
        .img-type-box.portrait .custom-control-label::before{
            width: 70px;
            height: 90px;
        }

        .img-type-box .custom-control-input:checked ~ .custom-control-label::before{
            background-color: #dfe2ff !important;
        }
        .img-type-box .custom-control-input:focus~.custom-control-label::before{
            box-shadow:none!important;
        }

    </style>
    <style>
        #overlay{   
          position: fixed;
          top: 0;
          z-index: 9999;
          width: 100%;
          height:100%;
          display: none;
          background: rgba(0,0,0,0.6);
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
        .is-hide{
          display:none;
        }
        .action_btn{
            padding: 0.5rem 0.8rem;
            font-size: 14px;
        }
    </style>
    <style>
        .date-input{
            position: relative;
        }
        .calendar-icon{
            position: absolute;
            top: 15px;
            right: 10px;
            opacity: 0.7;
        }
    </style>

    <div class="section-body">
        
        <form id="futureform" action="{{ route('business.future.store') }}" method="post" enctype="multipart/form-data">
        @csrf

            <div class="row justify-content-center my-5">
                <div class="col-md-8 col-xl-7">

                    <div class="card" id="offer_details">
                        <div class="card-header justify-content-between">
                            <h4>Offer Details</h4>
                            <a href="#" class="info-btn" data-toggle="modal" data-target="#offer_details_modal"><i class="fa fa-question-circle"></i></a>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Offer Title <span>*</span></label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="Enter title here..." value="">
                            </div>

                            <div class="form-group">
                                <label>Offer Description <span>*</span></label>
                                <textarea class="form-control" name="offer_description" rows="3"></textarea>
                            </div>    
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <div class="ui calendar" id="rangestart">
                                            <div class="date-input">
                                            
                                            <input type="text" name="start_date"  id="start_date" placeholder="Start Date" value="" class="form-control" >
                                            <i class="calendar-icon date-icon fa fa-calendar" aria-hidden="true"></i>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <div class="ui calendar" id="rangeend">
                                            <div class="date-input">
                                            
                                            <input type="text" name="end_date"  id="end_date" placeholder="End Date" value="" class="form-control" >
                                            <i class="calendar-icon date-icon fa fa-calendar" aria-hidden="true"></i>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <button type="submit" name="save_btn" value="save" class="btn btn-icon icon-left btn-success save_btn saveOfferBtn">
                                <i class="fas fa-check"></i>
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>


</section>

{{-- Modals  --}}
<div class="modal fade" id="offer_details_modal" tabindex="-1" role="dialog" aria-labelledby="offer_details_modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Offer Details Info</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Easily create an offer with MouthPublicity, just by designing your offer content and choosing the best template. Fill the below form with exact offer details, create it, share it with your customer and keep track of it anytime with an engaging dashboard. </p>
          </div>
        </div>
    </div>
</div>

@endsection
@section('end_body')
    @include('business.offers.future.js')

    <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>

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
            to.datepicker("option", "minDate", getDate(this));
        }),
        to = $("#end_date").datepicker({
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
    </script>

@endsection