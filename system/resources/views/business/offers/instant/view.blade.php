@extends('layouts.business')
@section('content')
<style>
    #error-number{
        color: red;
    }
    #success-number{
        color: #47c363;
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
                            <a href="{{ url($previewOffer) }}" target="_blank" class="btn btn-info mr-3">Preview Offer</a>
                            <a href="{{ route('business.instant.edit', $offer->id) }}" class="btn btn-primary">Edit Offer</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <div class="row mb-4">
                                @if($offer->instant_offer->offer_banner != '') 
                                    <div class="col-md-12 mb-3">
                                        <!-- Offer Image -->
                                        <img src="{{ asset('assets/offers/banners').'/'.$offer->instant_offer->offer_banner }}" class="img-fluid" alt="">
                                    </div>
                                    
                                @endif
                                
                                <div class="col-md-12">
                                    <!-- Offer Title -->
                                    <h4>{{ $offer->title }}</h4>
                                    <!-- Offer Description -->
                                    <p>{{ $offer->instant_offer->offer_description }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                <p class="mb-0">Task to complete:</p>
                                <!-- Required Counts  -->
                                <h3 class="text-success mb-0">{{ $offer->instant_offer->target }}</h3>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>

                <!-- ==================================COUPON DETAIL===================================== -->
                <div class="card">
                    <div class="card-header">
                        <h4>Discoount Details</h4>
                    </div>
                    <div class="card-body">

                        <div class="">
                            
                            <!-- if discount type is PERCENTAGE (%)  -->
                            @if($offer->instant_offer->discount_type == 'Percentage')
                            <div class="row" >
                                <div class="col-6">
                                    <p class="mb-0"><b><u>Type:</u></b></p>
                                    <div>
                                        <p> <span>{{ $offer->instant_offer->discount_type }}</span></p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <p class="mb-0"><b><u>Discount Percentage:</u></b></p>
                                    <div>
                                        <p> <span class="badge badge-success">{{ $offer->instant_offer->discount_value }}</span></p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($offer->instant_offer->discount_type != 'Percentage')
                            <!-- if discount type is Amount (Rs.)  -->
                            <div class="row" >
                                <div class="col-6">
                                    <p class="mb-0"><b><u>Type:</u></b></p>
                                    <div>
                                        <p> <span>{{ $offer->instant_offer->discount_type }}</span></p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <p class="mb-0"><b><u>Discount Amount:</u></b></p>
                                    <div>
                                        <p> <span class="badge badge-success">&#8377; {{ $offer->instant_offer->discount_value }}</span></p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- =======================================Right Section (Preview Section )-=========================================== -->
            
            <!-- Preview Section -->
            <div class="col-md-5">
                
                <div style="margin-top:_80px;">

                    <div>
                        <!-- <h3 class="mb-4">Statisticts</h3> -->
                        <div class="card">
                            <div class="card-header">
                                <h4>Statisticts</h4>
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
                                    <!-- <div class="col-6">
                                        <div class="card card-info">
                                            <div class="card-header">
                                                <h4><i class="fa fa-hand-pointer"></i></h4>
                                            </div>
                                            <div class="card-body">
                                                <p class="mb-0"><span class="h4 font-weight-bold">{{ $offer->total_visits }}</span> visits</p>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- ======= REGISTER ======= -->
                    <!-- <div class="card">
                        <div class="card-header">
                            <h4>Register Customer (Sharer)</h4>
                        </div>
                        <div class="card-body">
                            <form id="registerform">
                                @csrf
                                <div class="form-group">
                                    <label>Enter The Mobile Number</label>
                                    <input type="hidden" id="offer_id" name="offer_id" value="{{ $offer->id }}">
                                    <input type="number" name="number" id="number" class="form-control" placeholder="Enter number here..." >
                                    <span id="error-number"></span>
                                    <span id="success-number"></span>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary">Register & Share</button>
                                </div>
                            </form>
                        </div>
                    </div> -->

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
            
            if (number == 0 || number == -1 || number == -0) {
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