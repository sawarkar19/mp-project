@extends('layouts.business')

@section('head')
@include('layouts.partials.headersection',['title'=>'Edit Offer Details'])
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

    <div class="section-body">
        
        <form id="futureform" action="{{ route('business.future.update',$offer_id) }}" method="post" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="offer_id" value="{{ $offer->id }}" />

        <div class="row justify-content-center my-5">
            <div class="col-md-8 col-xl-7">

                <!-- SECTION ONE -->
                @if($page_type == 'webpage')
                <div class="card" id="existing_url">
                    <div class="card-header">
                        <h4 class="mark-required">Website Link <span>*</span></h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-0">
                            <input type="text" name="promo_url" id="code" class="form-control promo_url" placeholder="Enter the URL of you webpage..." value="{{ $offer->future_offer->promotion_url }}">
                        </div>
                    </div>
                </div>
                @endif
                <!-- SECTION ONE END -->

                <!-- SECTION TWO (OFFER) -->
                <div class="card" id="offer_details">
                    <div class="card-header justify-content-between">
                        <h4>Offer Details</h4>
                        <a href="#" class="info-btn" data-toggle="modal" data-target="#offer_details_modal"><i class="fa fa-question-circle"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Offer Title <span>*</span></label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter title here..." value="{{ $offer->title }}">
                        </div>

                        @if($request_data['type'] != 'MadeShare')
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Start Date <span>*</span></label>
                                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $start_date }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>End Date <span>*</span></label>
                                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $end_date }}">
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <label>Offer Description <span>*</span></label>
                            <textarea class="form-control" name="offer_description" rows="3">{{ $offer->future_offer->offer_description }}</textarea>
                        </div>    
                        
                    </div>
                </div>
                <!-- SECTION TWO END -->
                <input type="hidden" name="discount_type" value="{{ $request_data['type'] }}" />

                @if($request_data['type'] != 'MadeShare')
                <div class="card">
                    <div class="card-header">
                        <h4>Challenge Details</h4>
                    </div>
                    <div class="card-body">
                        @if($request_data['type'] == 'PerClick')

                            <div class="form-group" id="maximum_input">
                                <label>Enter discount amount per click <span>*</span> </label>
                                <input type="text" name="discount_perclick" class="form-control offer_data_in" min="0" placeholder="Enter the amount of one single click" value="{{ $offer->future_offer->discount_value }}" disabled>
                                <p class="small mb-1 mt-1" style="line-height:1.6;"><i>Give cashback to your customer for each click while they share. Set fixed cashback amount per click you want to give to your customer.</i> </p>
                            </div>
                        @endif

                        @if($request_data['type'] == 'Percentage')

                            <div class="form-group" id="maximum_input">
                                <label>Enter Discount Percentage <span>*</span> </label>
                                <input type="text" name="discount_percent" class="form-control offer_data_in" min="0" max="100" placeholder="Enter Percentage between 0 to 100%" value="{{ $offer->future_offer->discount_value }}" disabled>
                                <p class="small mb-1 mt-1" style="line-height:1.6;"><i>Set the percentage of discount you want to give to your customer on the specific offer.</i> </p>
                            </div>
                        @endif

                        @if($request_data['type'] == 'Fixed')

                            <div class="form-group" id="maximum_input">
                                <label>Enter Discount Amount <span>*</span> </label>
                                <input type="text" name="discount_amount" class="form-control offer_data_in" min="0" placeholder="Enter Amount from 0" value="{{ $offer->future_offer->discount_value }}" disabled>
                                <p class="small mb-1 mt-1" style="line-height:1.6;"><i>Set the fixed amount in rupees, you want to give to your customer as an offer.</i> </p>
                            </div>
                        @endif
                        
                        @if($request_data['type'] == 'PerClick')
                        <div class="form-group">
                            <label>Minimum clicks To Redeem <span>*</span> </label>
                            <input type="text" name="minimum_click" min="1" class="form-control" placeholder="Enter clicks require to redeem the offer..." value="{{ $offer->future_offer->minimum_click }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>Maximum clicks(Visits) to be count! <span>*</span> </label>
                            <input type="text" name="max_promo_count" min="1" class="form-control" placeholder="Enter the number clicks to maximum limit..." value="{{ $offer->future_offer->max_promo_count }}" disabled>
                        </div>
                        @endif

                        @if($request_data['type'] == 'Percentage' || $request_data['type'] == 'Fixed')
                        <div class="form-group">
                            <label>Minimum clicks(Visits) Require? <span>*</span> </label>
                            <input type="text" name="promo_count" min="1" class="form-control" placeholder="Enter the number clicks to required to get the offer..." value="{{ $offer->future_offer->share_target }}" disabled>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Last Date To Redeem Code <span>*</span></label>
                                    <input type="date" id="redeem_date" name="redeem_date" class="form-control" value="{{ $redeem_date }}">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                @endif
                <!-- SECTION THREE END -->

                <!-- SECTION FOUR END -->

                <input type="hidden" name="is_draft" value="0" id="is_draft">

                <hr>
                <!-- SUBMIT  -->
                <div class="d-flex justify-content-between align-items-center">
                    @if($offer->is_draft == 1)
                    <div>
                        <button type="submit" class="draft_btn" name="draft_btn" value="draft">
                            Save in Draft
                        </button>
                    </div>
                    @endif

                    <div>
                        <!-- SUBMIT BUTTON -->
                        <button type="submit" name="save_btn" value="save" class="btn btn-icon icon-left btn-success save_btn saveOfferBtn">
                            <i class="fas fa-check"></i>
                            Save & Publish
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
    <script type="text/javascript">
        $(function(){
            var dtToday = new Date();
            
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();
            
            var maxDate = year + '-' + month + '-' + day;
            /*$('#start_date').attr('min', maxDate);*/
            $('#end_date').attr('min', maxDate);
        });

    </script>

@endsection