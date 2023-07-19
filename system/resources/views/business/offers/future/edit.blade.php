@extends('layouts.business')
@section('content')

<section class="section">
    <div class="section-header">
        <h1>Edit Offer</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{url('business/dashboard')}}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{url('business/offers')}}">Offers</a></div>
            <div class="breadcrumb-item">Edit Offer</div>
        </div>
    </div>


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
        .hide-window{
            display: none !important;
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



    <div class="section-body">
        
        <form id="futureUpdateform" action="{{ route('business.future.update', $records->id) }}" method="put" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="offer_id" value="{{ $records->id }}" />
        <div class="select_page_type">
            <div class="row justify-content-center my-5">
                <div class="col-md-8 col-xl-7">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <h6 class="text-dark">Select the Page Type</h6>
                            <!-- <hr> -->
                        </div>

                        <div class="col-sm-12 @if($records->future_offer->promotion_url != null) hide-window @endif">
                            <div class="radio_tab @if($records->future_offer->promotion_url == null) border-primary @endif">
                                <label for="template">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="template" data-inputname="without_website" name="page_type" value="template" class="custom-control-input page_type_input" @if($records->future_offer->promotion_url == null) checked @endif>
                                                <label class="custom-control-label"></label>
                                            </div>
                                            <h4>Use Template</h4>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0">You can use our pre-defined offer templates to promote your offers, products, services etc.</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="col-sm-12 @if($records->future_offer->promotion_url == null) hide-window @endif">
                            <div class="radio_tab @if($records->future_offer->promotion_url != null) border-primary @endif">
                                <label for="ex_page">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="ex_page" data-inputname="with_website" name="page_type" value="webpage" class="custom-control-input page_type_input" @if($records->future_offer->promotion_url != null) checked @endif>
                                                <label class="custom-control-label"></label>
                                            </div>
                                            <h4>My Website Page</h4>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0">You can promote your own website page by providing the page URL and inserting the script provided by us in your website.</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row justify-content-center my-5">
            <div class="col-md-8 col-xl-7">

                <!-- SECTION ONE -->
                <div class="card @if($records->future_offer->promotion_url == null) hide-window @endif" id="existing_url">
                    <div class="card-header">
                        <h4 class="mark-required">Website Link <span>*</span></h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-0">
                            <input type="text" name="promo_url" id="code" class="form-control" placeholder="Enter the URL of you webpage..." value="{{old('promo_url', $records->future_offer->promotion_url)}}">
                        </div>
                    </div>
                </div>
                <!-- SECTION ONE END -->

                <!-- SECTION TWO (OFFER) -->
                <div class="card" id="offer_details">
                    <div class="card-header">
                        <h4>Offer Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Offer Title <span>*</span></label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter title here..." value="{{old('title',$records->title)}}">
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Start Date <span>*</span></label>
                                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{old('start_date',$start_date)}}" @if($records->is_draft != 1) disabled @endif>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>End Date <span>*</span></label>
                                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{old('end_date',$end_date)}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Offer Description <span>*</span></label>
                            <textarea class="form-control" name="offer_description" rows="3">{{old('offer_description', $records->future_offer->offer_description)}}</textarea>
                        </div>

                        @if($records->future_offer->promotion_url == null)
                        <div class="form-row justify-content-between align-items-end mb-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Template Image Type <span>*</span></label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="custom-control custom-radio img-type-box landscape">
                                    <input type="radio" id="landscape" name="template_type" class="custom-control-input" value="landscape" @if($records->future_offer->template_type == 'landscape') checked @endif>
                                    <label class="custom-control-label" for="landscape">Landscape</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="custom-control custom-radio img-type-box portrait">
                                    <input type="radio" id="portrait" name="template_type" class="custom-control-input" value="portrait" @if($records->future_offer->template_type == 'portrait') checked @endif >
                                    <label class="custom-control-label" for="portrait">Portrait</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="custom-control custom-radio img-type-box square">
                                    <input type="radio" id="square" name="template_type" class="custom-control-input" value="square" @if($records->future_offer->template_type == 'square') checked @endif>
                                    <label class="custom-control-label" for="square">Square</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-8">
                                <div class="form-group">
                                    <label>Offer Banner <span>*</span></label>
                                    <input type="file" name="offer_banner" id="image_offer" class="form-control img-preview-oi mb-1" >
                                    <input type="hidden" name="old_banner" value="{{ $records->future_offer->offer_banner }}" />
                                </div>
                            </div>
                            <div class="col-4"><img id="preview_oi" @if($records->future_offer->offer_banner != null) src="{{ URL::to('assets/offers/banners/' . $records->future_offer->offer_banner) }}" @else src="" @endif  style="max-height:120px;" class="img-fluid" /></div>
                        </div>
                        @endif
                        
                    </div>
                </div>
                <!-- SECTION TWO END -->

                <!-- SECTION THREE (COUPON) -->
                <div class="card @if($records->future_offer->promotion_url == null) hide-window @endif" id="coupon_type">
                    <div class="card-header">
                        <h4>Coupon Code</h4>
                    </div>
                    <div class="card-body">

                        <div class="row justify-content-between">
                            <div class="col-md-6 col-lg-5 mb-3 @if(($records->future_offer->coupon_type != 'Secured') && ($records->is_draft != 1)) hide-window @endif">
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="radio" id="Secured_coupon" name="coupon_type" value="Secured" class="custom-control-input" @if($records->future_offer->coupon_type == 'Secured') checked @endif>
                                    <label class="custom-control-label" for="Secured_coupon"><b>Secured Coupon</b> </label>
                                    <p class="small mb-0 mt-1" style="line-height:1.6;"><i>Secured coupon option will send a unique auto generated coupon code to the person who is ready to avail the offer.</i> </p>
                                </div>
                            </div>
                            <!-- <div class="col-md-6 col-lg-5 mb-3 @if(($records->future_offer->coupon_type != 'Fixed') && ($records->is_draft != 1)) hide-window @endif">
                                <div class="custom-control custom-checkbox mb-2 @if($records->future_offer->promotion_url == null) hide-window @endif">
                                    <input type="radio" id="Fixed_coupon" name="coupon_type" value="Fixed" class="custom-control-input" @if($records->future_offer->coupon_type == 'Fixed') checked @endif>
                                    <label class="custom-control-label" for="Fixed_coupon"><b>Fixed Coupon</b></label>
                                    <p class="small mb-0 mt-1" style="line-height:1.6;"><i>Fixed coupon is coupon which you have already generated for the people. That coupon you can provide here so that whenever someone complete the task, we will directly send them the coupon code. So that they can visit your website and avail the offer. </i> </p>
                                </div>
                            </div> -->
                        </div>

                        <div id="Fixed_comb" class="form-group @if($records->future_offer->coupon_type != 'Fixed') hide-window @endif">
                            <label>Coupon Code <span>*</span></label>
                            <input type="text" name="coupon_code" id="code" class="form-control @if($records->future_offer->coupon_type != 'Fixed') hide-window @endif" value="{{old('coupon_code', $records->future_offer->coupon_code)}}" placeholder="Enter coupon code here..." @if($records->is_draft != 1) disabled @endif>
                        </div>

                        <!-- <div class="form-group">
                            <label>Redeem Details </label>
                            <textarea class="form-control" name="redeem_details" rows="2">{{old('redeem_details', $records->future_offer->redeem_details)}}</textarea>
                        </div> -->
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>Challenge Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-md-12 mb-4 @if(($records->future_offer->discount_type != 'Perclick') && ($records->is_draft != 1)) hide-window @endif">
                                <label for="coupon_perclick" class="w-100">
                                    <div class="p-3 border border-primary rounded">
                                        <div class="custom-control custom-checkbox mb-2">
                                            <input type="radio" id="coupon_perclick" name="discount_type" value="Perclick" data-name="perclick" class="custom-control-input discount_type_input" @if($records->future_offer->discount_type == 'Perclick') checked @endif>
                                            <label class="custom-control-label" for="coupon_perclick"><b>Cashback per click</b> </label>
                                            <p class="small mb-1 mt-1" style="line-height:1.6;"><i>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Totam dolores fugiat odio maxime delectus.</i> </p>
                                            <input type="text" name="discount_perclick" class="form-control offer_data_in" min="0" placeholder="Enter the amount of one single click" value="@if($records->future_offer->discount_type == 'Perclick') {{old('discount_perclick',$records->future_offer->discount_value)}} @endif"  @if(($records->future_offer->discount_type != 'Perclick') || ($records->is_draft != 1)) disabled @endif>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-12 mb-4 @if(($records->future_offer->discount_type != 'Percentage') && ($records->is_draft != 1)) hide-window @endif">
                                <label for="coupon_percentage" class="w-100">
                                <div class="p-3 border rounded">
                                    <div class="custom-control custom-checkbox mb-2">
                                        <input type="radio" id="coupon_percentage" name="discount_type" value="Percentage" data-name="percentage" class="custom-control-input discount_type_input" @if($records->future_offer->discount_type == 'Percentage') checked @endif>
                                        <label class="custom-control-label" for="coupon_percentage"><b>Percent (%)</b> </label>
                                        <p class="small mb-1 mt-1" style="line-height:1.6;"><i>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Totam dolores fugiat odio maxime delectus.</i> </p>
                                        <input type="text" name="discount_percent" class="form-control offer_data_in" min="0" max="100" placeholder="Enter Percentage between 0 to 100%" value="@if($records->future_offer->discount_type == 'Percentage') {{old('discount_percent',$records->future_offer->discount_value)}} @endif" @if(($records->future_offer->discount_type != 'Percentage') || ($records->is_draft != 1)) disabled @endif>
                                    </div>
                                </div>
                                </label>
                            </div>
                            <div class="col-md-12 mb-4 @if(($records->future_offer->discount_type != 'Fixed') && ($records->is_draft != 1)) hide-window @endif">
                                <label for="coupon_amount" class="w-100">
                                <div class="p-3 border rounded">
                                    <div class="custom-control custom-checkbox mb-2">
                                        <input type="radio" id="coupon_amount" name="discount_type" value="Fixed" data-name="amount" class="custom-control-input discount_type_input"  @if($records->future_offer->discount_type == 'Fixed') checked @endif>
                                        <label class="custom-control-label" for="coupon_amount"><b>Amount (&#8377;)</b></label>
                                        <p class="small mb-1 mt-1" style="line-height:1.6;"><i>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Totam dolores fugiat odio maxime delectus.</i> </p>
                                        <input type="text" name="discount_amount" class="form-control offer_data_in" min="0" placeholder="Enter Amount from 0" value="@if($records->future_offer->discount_type == 'Fixed') {{old('discount_amount',$records->future_offer->discount_value)}} @endif" @if(($records->future_offer->discount_type != 'Fixed') || ($records->is_draft != 1)) disabled @endif>
                                    </div>
                                </div>
                                </label>
                            </div>
                        </div>

                        <hr class="border-primary">
                        
                        <div class="form-group @if($records->future_offer->discount_type != 'Perclick') hide-window @endif" id="maximum_input">
                            <label>Maximum clicks(Visits) to be count! <span>*</span> </label>
                            <input type="text" name="max_promo_count" min="1" class="form-control" placeholder="Enter the number clicks to maximum limit..." value="{{old('max_promo_count',$records->future_offer->max_promo_count)}}"  @if($records->is_draft != 1) disabled @endif>
                        </div>
                        <div class="form-group @if($records->future_offer->discount_type == 'Perclick') hide-window @endif" id="minimum_input">
                            <label>Minimum clicks(Visits) Require? <span>*</span> </label>
                            <input type="text" name="promo_count" min="1" class="form-control" placeholder="Enter the number clicks to required to get the offer..." value="{{old('promo_count',$records->future_offer->share_target)}}"  @if($records->is_draft != 1) disabled @endif>
                        </div>

                    </div>
                </div>
                <!-- SECTION THREE END -->

                <!-- SECTION FOUR (LOCATION) -->
                <div class="card">
                    <div class="card-header">
                        <h4>Location</h4>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-between">
                        <div class="col-md-6 col-lg-5 mb-3">
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="radio" id="anywhere" name="location_type" value="anywhere" class="custom-control-input" @if($records->future_offer->location == 'anywhere') checked @endif>
                                    <label class="custom-control-label" for="anywhere"><b>Anywhere</b></label>
                                    <p class="small mb-0 mt-1" style="line-height:1.6;"><i>Lorem ipsum dolor sit amet consectetur adipisicing elit.</i> </p>
                                </div>
                            </div>
                            <!-- <div class="col-md-6 col-lg-5 mb-3">
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="radio" id="location" name="location_type" value="location" class="custom-control-input" @if($records->future_offer->location == 'location') checked @endif>
                                    <label class="custom-control-label" for="location"><b>Choose Location</b> </label>
                                    <p class="small mb-0 mt-1" style="line-height:1.6;"><i>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</i> </p>
                                </div>
                            </div> -->
                        </div>

                        <div class="alert alert-info info-window" role="alert">
                          <p>Set an accurate location for your offer. Selecting specific targeted location increases the chance of converting customers into your potential customer.</p>
                        </div>

                        <div id="location_comb" class="@if($records->future_offer->location == 'anywhere') hide-window @endif">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select State <span>*</span></label>
                                        <select  id="state-id" name="loc_state" class="form-control">
                                            <option value="">Select State</option>
                                            @foreach ($states as $data)
                                            <option value="{{$data->id}}" {{$records->future_offer->state_id == $data->id  ? 'selected' : ''}}>
                                                {{$data->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label id="city-label">Select State then Select City <span>*</span></label>

                                        <select id="city-id" name="loc_city" class="form-control">
                                            <option value="">Select City</option>
                                            @foreach ($cities as $city)
                                            <option value="{{$city->id}}" {{$records->future_offer->city_id == $city->id  ? 'selected' : ''}}>
                                                {{$city->name}}
                                            </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- SECTION FOUR END -->

                <input type="hidden" name="is_draft" value="{{ $records->is_draft }}" id="is_draft">

                <hr>
                <!-- SUBMIT  -->
                <div class="d-flex justify-content-between align-items-center">
                    @if($records->status != 1)
                    <div>
                        <button type="submit" class="draft_btn" id="draft_btn" name="draft_btn" value="draft">
                            Save in Draft
                        </button>
                    </div>
                    @endif
                    <div>
                        <!-- SUBMIT BUTTON -->
                        <button type="submit" name="save_btn" id="save_btn" value="save" class="btn btn-icon icon-left btn-success save_btn">
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

@endsection
@section('end_body')
    @include('business.offers.future.js')
        <script type="text/javascript">
            $(function(){
                
                var start_date = $('#start_date').val();
                var date = new Date(start_date);
                //console.log(date);
                
                var month = date.getMonth() + 1;
                var day = date.getDate();
                var year = date.getFullYear();
                if(month < 10)
                    month = '0' + month.toString();
                if(day < 10)
                    day = '0' + day.toString();
                
                var maxDate = year + '-' + month + '-' + day;
                $('#start_date').attr('min', maxDate);


                var dtToday = new Date();
                var monthE = dtToday.getMonth() + 1;
                var dayE = dtToday.getDate();
                var yearE = dtToday.getFullYear();
                if(monthE < 10)
                    monthE = '0' + monthE.toString();
                if(dayE < 10)
                    dayE = '0' + dayE.toString();
                
                var maxDateE = yearE + '-' + monthE + '-' + dayE;
                $('#end_date').attr('min', maxDateE);
            });
        </script>
@endsection