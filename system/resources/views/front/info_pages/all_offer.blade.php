@foreach($all_offers as $all_offer)
<div class="col-xl-4 col-lg-6">
    @php 
        $completed = $clicks = 0;
        // dd($all_offer);
        if($all_offer->reward != ''){
            $reward_type = $all_offer->reward->type;
        }else{
            $reward_type = '';
        }

        
        $details = json_decode($all_offer->reward->details);
        // dd($details->minimum_click);

            $max_click = '';
            $per_click = '';
            $percentage = 0;

        if($all_offer->channel_id == 2){

            $max_click = '';
            $per_click = '';
            $percentage = 0;

            if(($all_offer->completed_task_count >= $details->minimum_task) && ($all_offer->channel_id == 2) && ($all_offer->reward != null && $all_offer->reward->type != 'Free'))
            {
                $completed = 1;
            }

        }else if($all_offer->channel_id == 3){

            $targets_parent_count = 0;

            if(($all_offer->targets_count + $targets_parent_count) >= $details->minimum_click){
                $clicks = $details->minimum_click;
            }else{
                $clicks = ($all_offer->targets_count + $targets_parent_count);
            }

            if($reward_type == 'Cash Per Click' && $reward_type != ''){
                $max_click = $details->maximum_click;
                $per_click = $details->discount_perclick;
                $percentage = 0;

                $redeem_amount = $per_click * ($all_offer->targets_count + $targets_parent_count);
                $redeem_amount = round($redeem_amount, 2);
            }elseif($reward_type != ''){
                $max_click = '';
                $per_click = '';
                $percentage = 0;

                $percentage = ($clicks / $details->minimum_click)*100;
                $percentage = round($percentage, 2);
            }else{
                $max_click = '';
                $per_click = '';
                $percentage = 0;
            }

            if((($all_offer->targets_count + $targets_parent_count) >= $details->minimum_click) && ($all_offer->channel_id == 3) && ($all_offer->reward != null && $all_offer->reward->type != 'Free'))
            {
                $completed = 1;
            }
        }

        $today = Carbon\Carbon::now()->format("Y-m-d");
        $offer_date = Carbon\Carbon::parse($all_offer->offer_details->end_date)->format("Y-m-d");
        $stats_class = 'oc-analytics';
        
        if($all_offer->offer_details->stop_date != NULL){
            $offer_date = Carbon\Carbon::parse($all_offer->offer_details->stop_date)->format("Y-m-d");
        }

        if($today > $offer_date){
            $stats_class = 'oc-analytics expired';
        }

        
        
    @endphp
    <div class="offer-card shadow-sm">
        <div class="oc-inner">
            {{-- Challenge Type --}}
            <div class="challenge-type">
                @if($all_offer->channel_id == 3)
                    Share Challenge
                @else
                    Instant Challenge
                @endif
            </div>

            <!-- IMAGE THUMBNAIL -->
            <div class="oc-img">

                @php
                    if($all_offer->offer_details->type == 'custom'){
                        if($all_offer->offer_details->website_url != ''){
                            $img_url = asset('assets/img/default_website_img.jpg');
                        }else{
                            $img_url = asset('assets/templates/custom').'/'.$all_offer->offer_details->image;
                        }
                        
                    }else{
                        $img_url = asset('assets/offer-thumbnails').'/'.$all_offer->offer_details->offer_template->thumbnail;
                    }
                @endphp
                <div class="oc-img-thumb" style="background-image:url({{ $img_url }});"></div>
                
            </div>
            <!-- TITLE -->
            <div class="oc-title">
                <h3 class="h6 mb-0">{{ $all_offer->offer_details->title }}</h3>
            </div>

            
            @if($max_click == '')
            @if(($all_offer->channel_id == 3) && ($completed != 1))
            <!-- ANALYTICS DATA -->
                @if($all_offer->reward != null && $all_offer->reward->type != 'Free')
                    <div class="{{ $stats_class }}">
                        <div class="p-2">
                            <div class="row">
                                <div class="col-4 px-0">
                                    <div class="anlt-colm">
                                        <!-- Require clicks to achive offer -->
                                        <p class="head">Required Clicks</p>
                                        <h4 class="anlt-data">{{ isset($details->minimum_click) ? $details->minimum_click : 0 }}</h4>
                                    </div>
                                </div>
                                <div class="col-4 px-0">
                                    <div class="anlt-colm">
                                        <!-- Total Clicks are achived -->
                                        <p class="head">Completed Clicks</p>
                                        <h4 class="anlt-data">{{ $clicks }}</h4>
                                    </div>
                                </div>
                                <div class="col-4 px-0">
                                    <div class="anlt-colm">
                                        <!-- Persentage of clicks -->
                                        <p class="head">Complete</p>
                                        <h4 class="anlt-data fw-bold">{{ $percentage }}%</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            @elseif(($all_offer->channel_id == 2) && ($completed != 1))
            <!-- ANALYTICS DATA -->
                @if($all_offer->reward != null && $all_offer->reward->type != 'Free')
                    <div class="{{ $stats_class }}">
                        <div class="p-2">
                            <div class="row">
                                <div class="col-4 px-0">
                                    <div class="anlt-colm">
                                        <!-- Require clicks to achive offer -->
                                        <p class="head">Required Tasks</p>
                                        <h4 class="anlt-data">{{ isset($details->minimum_task) ? $details->minimum_task : 0 }}</h4>
                                    </div>
                                </div>
                                <div class="col-4 px-0">
                                    <div class="anlt-colm">
                                        <!-- Total Clicks are achived -->
                                        <p class="head">Completed Tasks</p>
                                        <h4 class="anlt-data">{{ $all_offer->completed_task_count }}</h4>
                                    </div>
                                </div>
                                <div class="col-4 px-0">
                                    <div class="anlt-colm">
                                        <!-- Persentage of clicks -->
                                        <p class="head">Complete</p>
                                        <h4 class="anlt-data fw-bold">{{ $percentage }}%</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
            @endif
            @endif

            @if($max_click != '')
            <!-- ANALYTICS DATA -->
            <div class="{{ $stats_class }}">
                <div class="p-2">
                    <div class="row">
                        <div class="col-4 px-0">
                            <div class="anlt-colm">
                                <!-- Require clicks to achive offer -->
                                <p class="head">Per Click</p>
                                <h4 class="anlt-data">{{ $per_click }} ₹</h4>
                            </div>
                        </div>
                        <div class="col-4 px-0">
                            <div class="anlt-colm">
                                <!-- Total Clicks are achived -->
                                <p class="head">Total Clicks</p>
                                <h4 class="anlt-data">{{ ($all_offer->targets_count + $targets_parent_count) }}</h4>
                            </div>
                        </div>
                        <div class="col-4 px-0">
                            <div class="anlt-colm">
                                <!-- Persentage of clicks -->
                                <p class="head">Redeem Amount</p>
                                <h4 class="anlt-data fw-bold">{{ $redeem_amount }} ₹</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if(($completed == 1) && ($max_click == '') && ($all_offer->is_redeemed == ''))
            <!-- COMPLETE MESSAGE -->
            <div class="oc-complete">
                <div class="p-2">
                    <div class="d-flex justify-content-start align-items-center">
                        <div>
                            <img src="{{asset('assets/instant_card/imgs/done.gif')}}" class="ico-done" alt="">
                        </div>
                        <div class="">
                            <p class="fw-bold mb-1 lh-1 text-success">Completed!</p>

                            @if($all_offer->reward->type != 'No Reward')
                                
                                <p class="lh-1 mb-0 small fw-light">Your challenge has been completed, We have sent coupon code to your mobile number. To redeem visit us.</p>

                            @else   
                                <p class="lh-1 mb-0 small fw-light">Your challenge has been completed. Thank you for shopping with us.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if(($all_offer->is_redeemed != '') && ($max_click == ''))
            <!-- COMPLETE MESSAGE -->
            <div class="oc-complete">
                <div class="p-2">
                    <div class="d-flex justify-content-start align-items-center">
                        <div>
                            <img src="{{asset('assets/instant_card/imgs/done.gif')}}" class="ico-done" alt="">
                        </div>
                        <div class="">
                            <p class="fw-bold mb-1 lh-1 text-success">Redeem!</p>
                            <p class="lh-1 mb-0 small fw-light">You have already completed and redeemed this offer.</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- DATE & SHARE BUTTON -->
            <div class="oc-share-option">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="">
                        {{-- @if($all_offer->channel_id == 3) --}}
                            <div class="">
                                <!-- Date of the Offer ends -->
                                @if($all_offer->status == '3' || $all_offer->status == '0')
                                    <p class="mb-0 small lh-1">Challenge expired</p>
                                @elseif($all_offer->status == '2')
                                    <p class="mb-0 small lh-1">Challenge completed</p>
                                @else
                                    
                                    @if($today > $offer_date)
                                        <p class="mb-0 small lh-1">Challenge expired</p>
                                    @else
                                        <p class="mb-0 small lh-1">Challenge ends on</p>

                                        <p class="mb-0">
                                            @if($all_offer->offer_details->stop_date != NULL)
                                                {{ Carbon\Carbon::parse($all_offer->offer_details->stop_date)->format('d M, Y'); }}
                                            @else
                                                {{ $all_offer->offer_details->end_date->format('d M, Y') }}
                                            @endif
                                        </p>
                                    @endif
                                    
                                @endif

                                {{-- @if($today > $offer_date)
                                    <p class="mb-0 small lh-1">Challenge expired</p>
                                @else
                                    <p class="mb-0 small lh-1">Challenge ends on</p>
                                     
                                    <p class="mb-0">
                                        @if($all_offer->offer_details->stop_date != NULL)
                                            {{ Carbon\Carbon::parse($all_offer->offer_details->stop_date)->format('d M, Y'); }}
                                        @else
                                            {{ $all_offer->offer_details->end_date->format('d M, Y') }}
                                        @endif
                                    </p>
                                    
                                @endif --}}
                            </div>
                        {{-- @endif --}}
                        
                    </div>
                    <div class="">
                        <div class="">
                            @if($all_offer->channel_id == 2)
                                <a target="_blank" href="{{ $domain.$all_offer->share_link }}" class="btn btn-md btn-success px-4">
                                    View Tasks
                                </a>
                            @elseif($all_offer->channel_id == 3)
                                @if($all_offer->offer_details->type == "standard" || ($all_offer->offer_details->type == "custom" && $all_offer->offer_details->website_url == ""))
                                    
                                    <a target="_blank" href="{{ $domain.$all_offer->share_link }}" class="btn btn-md btn-success px-4">
                                        View & Share
                                    </a>
                                @else
                                    
                                    <a target="_blank" href="{{ $all_offer->share_link }}" class="btn btn-md btn-success px-4">
                                        View & Share
                                    </a>
                                @endif
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashed-diveder"></div>

            @if(($max_click != '' && isset($details->minimum_click)) && $details->minimum_click > ($all_offer->targets_count + $targets_parent_count))
                <p class="alert alert-info small pt-0 pb-0" role="alert">
                Minimum <b>{{ $details->minimum_click }}</b> click(s) require to redeem the offer.
                </p>
            @endif

            @if(($max_click != '') && ($redeem_amount > 0) && isset($details->minimum_click) && ($details->minimum_click <= ($all_offer->targets_count + $targets_parent_count)))
            
                @if($today <= $offer_date)
                    @if($details->minimum_click < $details->pending_click)
                        <!-- REDEEM BUTTON -->
                        <div class="oc-share-option">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="">
                                    <div class="">

                                        <button type="button" id="{{ $all_offer->uuid }}" class="btn btn-md btn-success px-4 cashbackRedeem">REDEEM NOW!</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else 

                        <p class="alert alert-info small pt-0 pb-0" role="alert">You won't be able to redeem anymore because You already Redeemed for <b>{{ $details->maximum_click - $details->pending_click }}</b> click(s). Maximum <b>{{ $details->maximum_click }}</b> click(s) is allowed. Pending click(s) is <b>{{ $details->pending_click }}</b> and Minimum click(s) required is <b>{{ $details->minimum_click }}</b>.
                        </p>
                    @endif
                @endif

                
            @endif

            <div class="dashed-diveder"></div>

            <!-- VENDER INFO  -->
            <div class="business-option">
                <div class="d-flex justify-content-between_ align-items-center">
                    <div class="flex-column me-3">
                        <img src="{{asset('assets/business/logos/'.$all_offer->offer_details->business->bussiness_detail->logo)}}" alt="" class="business-logo" />
                    </div>
                    <div class="flex-column">
                        <div class="">
                            <p class="mb-0 font-500 lh-1">{{ $all_offer->offer_details->business->bussiness_detail->business_name }}</p>
                            <p class="mb-0 small text-muted">{{ $all_offer->offer_details->business->bussiness_detail->tag_line }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach