@extends('layouts.business')
@section('content')
<style>
    #error-number{
        color: red;
    }
    #success-number{
        color: #47c363;
    }
    label span{
        color: red;
    }
</style>

<section class="section">
    <div class="section-body">
        <div class="row justify-content-center">

            <div class="col-md-7 col-12">
                
                <!-- ======================OFFER DETAIL==================== -->
                <div class="card">
                    <div class="card-header justify-content-between">
                        <!-- Offer ID -->
                        <h4>#<span>{{ $offer->uuid }}</span> </h4>

                        <!-- Edit Button -->
                        <div>
                            @if ($offer->future_offer->promotion_url != null)
                                <a href="{{ url($offer->future_offer->promotion_url) }}" target="_blank" class="btn btn-info mr-3">Preview Offer</a>
                            @else
                                <a href="{{ url($previewOffer) }}" target="_blank" class="btn btn-info mr-3">Preview Offer</a>
                            @endif

                            @if($offer->future_offer->promotion_url != '')
                                <a href="{{ route('business.editWebpageOfferDetails', $offer->id.'?type='.$request_data['type']) }}" class="btn btn-primary">Edit Offer</a>
                            @else
                                <a href="{{ url('/business/offers/future/'.$offer->id.'/edit?type='.$request_data['type']) }}" class="btn btn-primary">Edit Offer</a>
                            @endif
                            
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <div class="row mb-4">
                                {{-- @if($offer->future_offer->promotion_url == null) 
                                    <div class="col-md-12 mb-3">
                                        <img src="{{ asset('assets/offers/banners').'/'.$offer->future_offer->offer_banner }}" class="img-fluid" alt="">
                                    </div>
                                    
                                @endif --}}
                                
                                <div class="col-md-12">
                                    <!-- Offer Title -->
                                    <h4>{{ $offer->title }}</h4>
                                    <!-- Offer Description -->
                                    <p>{{ $offer->future_offer->offer_description }}</p>
                                </div>
                            </div>

                            @if($request_data['type'] != 'MadeShare')
                            <div class="row">
                                {{-- <div class="col-md-4 mb-4 mb-md-0">
                                    <!-- Start Date -->
                                    <p class="mb-0">Start Date: <br> <b>{{ $offer->start_date->format('j F Y') }}</b> </p>
                                </div> --}}
                                <div class="col-md-4">
                                    <!-- End Date -->
                                    <p class="mb-0">End Date: <br> <b class="text-danger">{{ $offer->end_date->format('j F Y') }}</b> </p>
                                </div>
                                @if($offer->future_offer->share_target == '')
                                <div class="col-md-4">
                                    <p class="mb-0">Minimum Clicks:</p>
                                    <!-- Required Counts  -->
                                    <h3 class="text-success mb-0">{{ $offer->future_offer->minimum_click }}</h3>
                                </div>
                                @endif
                                
                                <div class="col-md-4">
                                
                                @if($offer->future_offer->share_target != '')
                                    <p class="mb-0">Required Visits:</p>
                                    <!-- Required Counts  -->
                                    <h3 class="text-success mb-0">{{ $offer->future_offer->share_target }}</h3>
                                @else
                                    <p class="mb-0">Maximum Clicks:</p>
                                    <!-- Required Counts  -->
                                    <h3 class="text-success mb-0">{{ $offer->future_offer->max_promo_count }}</h3>
                                @endif
                                </div>
                            </div> 
                            @endif

                        </div>
                    </div>
                </div>

                <!-- =================================Page TYPE====================================== -->
                <div class="card">
                    <div class="card-header">
                        <h4>Page Details</h4>
                    </div>
                    <div class="card-body">
                        <!-- Page Type -->
                        <p><b><u>Page Type:</u></b>
                        @if($offer->future_offer->promotion_url == null) 
                            <span class="badge badge-primary">Use Template</span>
                        @else
                            <span class="badge badge-primary">My Own Website</span>
                        @endif
                        </p>
                        <!-- Page Link -->
                        @if($offer->future_offer->promotion_url != null) 
                            <p><b><u>Page URL:</u></b> <a href="{{ $offer->future_offer->promotion_url }}" target="_blank">{{ $offer->future_offer->promotion_url }}</a></p>
                        @endif
                        
                    </div>
                </div>


                <!-- ==================================COUPON DETAIL===================================== -->
                {{-- <div class="card">
                    <div class="card-header">
                        <h4>Coupon Code Details</h4>
                    </div>
                    <div class="card-body">
                        <div>
                            <p><b class="mr-3"><u>Coupon Type:</u></b>
                                @if($offer->future_offer->coupon_type == 'Secured') 
                                    <!-- Secure coupon badge -->
                                    <span class="badge badge-success">Secure Coupon</span>
                                @else
                                    <!-- Fixed coupon badge -->
                                    <span class="badge badge-warning">Fixed Coupon</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="mb-0"><b><u>Coupon Code:</u></b></p>
                            <div class="bg-dark text-white p-3 rounded">
                                @if($offer->future_offer->coupon_type == 'Secured') 
                                    <!-- or  if secure coupon-->
                                    <p class="mb-0">Coupon will generate autometicaly after complete the task from user.</p>
                                @else
                                    <!-- If fixed coupn -->
                                    <b>{{ $offer->future_offer->coupon_code }}</b>
                                @endif 
                            </div>
                        </div>
                        @if($offer->future_offer->redeem_details != null)
                            <hr>
                            <div>
                                <p><b><u>Coupon Details:</u></b></p>
                                <!-- Coupon Deatils -->
                                <div>
                                    {{ $offer->future_offer->redeem_details }}
                                </div>
                            </div>
                        @endif

                        <hr class="border-primary">
                        <!-- DISCOUNT TYPE  -->
                        <div class="">
                            <div class="mb-4">
                                <h5 class="text-primary h6 font-weight-bold">Discount Type</h5>
                            </div>
                            <!-- if discount type is PERCENTAGE (%)  -->
                            @if($offer->future_offer->discount_type == 'Percentage')
                            <div class="row" >
                                <div class="col-6">
                                    <p class="mb-0"><b><u>Type:</u></b></p>
                                    <div>
                                        <p> <span>{{ $offer->future_offer->discount_type }}</span></p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <p class="mb-0"><b><u>Discount Percentage:</u></b></p>
                                    <div>
                                        <p> <span class="badge badge-success">{{ $offer->future_offer->discount_value }}</span></p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($offer->future_offer->discount_type != 'Percentage')
                            <!-- if discount type is Amount (Rs.)  -->
                            <div class="row" >
                                <div class="col-6">
                                    <p class="mb-0"><b><u>Type:</u></b></p>
                                    <div>
                                        <p> <span>{{ $offer->future_offer->discount_type }}</span></p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <p class="mb-0"><b><u>Discount Amount:</u></b></p>
                                    <div>
                                        <p> <span class="badge badge-success">&#8377; {{ $offer->future_offer->discount_value }}</span></p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                    </div>
                </div> --}}

                <!-- SECTION FOUR (LOCATION) -->
                {{-- <div class="card">
                    <div class="card-header">
                        <h4>Location</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <p><b class="mr-3"><u>Location Type:</u></b>
                            @if($offer->future_offer->location == 'anywhere') 
                                <span class="badge badge-success">Anywhere</span>
                            @else
                                <span class="badge badge-warning">Choose Location</span>
                            @endif
                            </p>
                        </div>
                        @if($offer->future_offer->location != 'anywhere') 
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-0"><b>State:</b> {{ $offer->future_offer->state->name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-0"><b>City:</b> {{ $offer->future_offer->city->name }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div> --}}
                <!-- SECTION FOUR END -->

                <!-- ======================================SCRIPT CODE=================================== -->
                <!-- If page type is My Own Website -->
                @if($offer->future_offer->promotion_url != null) 
                    <div class="card">
                        <div class="card-header">
                            <h4>Scripts</h4>
                        </div>
                        <div class="card-body">
                        
                            @php
                                $offer_content = '<meta name="description" content="'.$offer->future_offer->offer_description.'">';
                                $offer_title = '<meta name="og:title" content="'.$offer->title.'">';
                                $offer_image = '<meta name="og:image" content="'.asset('assets/offers/banners/'.$offer->future_offer->offer_banner).'">';
                                $offer_script = '<script src="'.asset('assets/js/targets-web.js').'"></script>'
                            @endphp

                            <div class="">
                                <p class="mb-0"><b>Step 1: <span class="text-danger">(Required)</span></b> Please add below code to <code>@php echo htmlspecialchars('<head>'); @endphp</code> tag.</p>
                                <!-- JAVASCRIPT Code Export -->
                                <p class="bg-dark text-white p-3 rounded">
                                    <code>
                                        @php echo htmlspecialchars($offer_script); @endphp
                                    </code>
                                </p>
                                <!-- JAVASCRIPT Code Export End -->
                            </div>
                            <hr>
                            <div class="">
                                <p class="mb-0"><b>Step 2: <span>(Optional)</span> </b> You can add meta tags in  <code>@php echo htmlspecialchars('<head>'); @endphp</code> tag, If you already have the meta tags you can skip the step.</p>
                                <!-- META CODE Export -->
                                <p class="bg-dark text-white p-3 rounded">

                                    <code>
                                        @php echo htmlspecialchars($offer_content); @endphp <br>
                                        @php echo htmlspecialchars($offer_title); @endphp <br>
                                        <!-- @php echo htmlspecialchars($offer_image); @endphp <br> -->
                                        <!-- @php echo htmlspecialchars('<meta name="app_id" content="">'); @endphp <br> -->
                                    </code>
                                </p>
                                <!-- META CODE Export End -->
                            </div>
                        </div>
                    
                    </div>
                    
                @endif

            </div>
            <!-- =======================================Right Section (Preview Section )-=========================================== -->
            
            <!-- Preview Section -->
            <div class="col-md-5">
                
                <div style="margin-top:_80px;">

                    <div>
                        <!-- <h3 class="mb-4">Statistics</h3> -->
                        <div class="card">
                            <div class="card-header">
                                <h4>Statistics</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card card-info">
                                            <div class="card-header">
                                                <h4><i class="fa fa-users"></i></h4>
                                            </div>
                                            <div class="card-body">
                                                <p class="mb-0"><span class="h4 font-weight-bold">{{ $offer->users_count }}</span> users</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card card-info">
                                            <div class="card-header">
                                                <h4><i class="fa fa-hand-pointer"></i></h4>
                                            </div>
                                            <div class="card-body">
                                                <p class="mb-0"><span class="h4 font-weight-bold">{{ $offer->total_visits }}</span> visits</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <hr> --}}

                    <!-- ======= REGISTER ======= -->
                    {{-- <div class="card">
                        <div class="card-header">
                            <h4>Register Customer (Sharer)</h4>
                        </div>
                        <div class="card-body">
                            <form id="registerform">
                                @csrf
                                <div class="form-group">
                                    <label>Enter The Mobile Number <span>*</span></label>
                                    <input type="hidden" id="offer_id" name="offer_id" value="{{ $offer->id }}">
                                    <input type="text" name="number" id="number" class="form-control" placeholder="Enter number here..." >
                                    <span id="error-number"></span>
                                    <span id="success-number"></span>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary">Register & Share</button>
                                </div>
                            </form>
                        </div>
                    </div> --}}

                </div>

            </div>

        </div>

    </div>
</section>

@endsection


@section('end_body')
    <script>
    /* Add Subcription */
        $("#registerform").on('submit', function(e){  
            e.preventDefault();

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var number = $("#number").val();
            var offer_id = $("#offer_id").val();
            
            var check = Math.sign(number);
            console.log(check);
            if (isNaN(check) || check == 0 || check == -1 || check == -0) {
                $( "#error-number" ).replaceWith( '<span id="error-number">Please enter a valid number</span>' );
                return false;
            }

            if(number.length != 10){
                $( "#error-number" ).replaceWith( '<span id="error-number">Please enter a 10 digit number</span>' );
                return false;
            }

            $.ajax({
                type: 'POST',
                url: "{{url('/business/share-to-customer')}}/" + offer_id,
                data: {number: number, _token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function (results) {
                    
                    if (results.success === true) {
                        $( "#error-number" ).replaceWith( '<span id="error-number"></span>' );
                        $( "#success-number" ).replaceWith( '<span id="success-number">'+results.message+'</span>' );
                        
                    } else {
                        $( "#error-number" ).replaceWith( '<span id="error-number">'+results.message+'</span>' );
                        $( "#success-number" ).replaceWith( '<span id="success-number"></span>' );
                    }
                },
                error: function(xhr) { 
                    $( "#error-number" ).replaceWith( '<span id="error-number">Something went wrong</span>' );
                    $( "#success-number" ).replaceWith( '<span id="success-number"></span>' );
                },
            });
            
        });
    </script>
@endsection