

@foreach($all_offers as $all_offer)

{{-- @if(!in_array($all_offer->id, $userOfferIds)) --}}

<div class="col-xl-4 col-lg-6">
    <div class="offer-card shadow-sm">
        <div class="oc-inner">
            <!-- IMAGE THUMBNAIL -->
            <div class="oc-img">

                @php

                // dd($all_offer);
                    if($all_offer->type == 'custom'){
                        if($all_offer->website_url != ''){
                            $img_url = asset('assets/img/default_website_img.jpg');
                        }else{
                            $img_url = asset('assets/templates/custom').'/'.$all_offer->image;
                        }
                        
                    }else{
                        $img_url = asset('assets/offer-thumbnails').'/'.$all_offer->offer_template->thumbnail;
                    }
                @endphp
                
                <div class="oc-img-thumb" style="background-image:url({{ $img_url }});"></div>
            </div>
            <!-- TITLE -->
            <div class="oc-title">
                <h3 class="h6 mb-0">{{ $all_offer->title }}</h3>
            </div>


            <!-- DATE & SHARE BUTTON -->
            <div class="oc-share-option">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="">
                        
                        <div class="">
                            <!-- Date of the Offer ends -->
                            <p class="mb-0 small lh-1">Challenge ends on</p>
                            <p class="mb-0">{{ $all_offer->end_date->format('d M, Y')  }}</p>
                        </div>
                    
                    </div>
                    <div class="">
                        {{-- <div class="">
                            <form method="POST" action="{{ route('subscribeAndShare') }}">
                                @csrf
                                <input type="hidden" name="customer_id" value="{{ $guide->id }}" />
                                <input type="hidden" name="offer_id" value="{{ $all_offer->id }}" />
                                <button type="submit" class="btn btn-md btn-primary px-4">Subscribe</button>
                            </form>
                        </div> --}}
                    </div>
                </div>
            </div>

            <div class="dashed-diveder"></div>

            <!-- VENDER INFO  -->
            <div class="business-option">
                <div class="d-flex justify-content-between_ align-items-center">
                    <div class="flex-column me-3">
                        @if(isset($all_offer->business->bussiness_detail->logo))
                        <img src="{{asset('assets/business/logos/'.$all_offer->business->bussiness_detail->logo)}}" alt="" class="business-logo" />
                        @endif
                    </div>
                    <div class="flex-column">
                        <div class="">
                            @if(isset($all_offer->business->bussiness_detail->business_name))
                            <p class="mb-0 font-500 lh-1">{{ $all_offer->business->bussiness_detail->business_name }}</p>
                            @endif

                            @if(isset($all_offer->business->bussiness_detail->tag_line))
                            <p class="mb-0 small text-muted">{{ $all_offer->business->bussiness_detail->tag_line }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- @endif --}}
@endforeach