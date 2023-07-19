@extends('layouts.business')
@section('title', 'Design Offer: Business Panel')
@section('head')
    @include('layouts.partials.headersection',['title'=>'Design Offer'])
@endsection

@section('end_head')
<style>
    .ofr-card{
        position: relative;
        display: flex;
        width: 100%;
        justify-content: space-between;
        border-radius: 4px;
        /* overflow: hidden; */
        box-shadow: 1px 1px 8px 1px rgba(0, 0, 0, .1);
        background-color: #ffffff;
        margin-bottom: 15px;
    }
    .ofr-card .ofr-img{
        width: 30%;
        /* height: 100%; */
        position: relative;
        background-color: #f2f2f2;
        background-position: top center;
        background-size: cover;
        transition: all 800ms ease;
        border-radius: 4px 0 0 4px;
    }
    .ofr-card .ofr-img:hover{
        background-position: bottom center;
    }
    

    .ofr-card .ofr-body{
        width: 70%;
    }
    .ofr-card .ofr-body-inner{
        position: relative;
        padding: 15px;
    }
    .ofr-card .ofr-title,
    .ofr-card  .ofr-text{
        line-height: 1.5;
        overflow: hidden;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        display: -webkit-box;
        width: 100%;
    }
    .ofr-card  .ofr-title{
        font-weight: 500!important;
        margin-bottom: 5px;
        font-size: 1rem
    }
    .ofr-card .ofr-date-flex{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .ofr-card p{
        line-height: 1.5!important;
    }
    .ofr-main-card a{
        text-decoration: none!important;
        color: inherit;
    }
    .ofr-card:hover .ofr-title{
        color: var(--primary);
    }
    .ofr-card .analise{
        position: relative;
        display: flex;
        justify-content: space-around;
        width: 100%;
    }
    .ofr-card .analise > .analise-sec{
        width: 50%;
        text-align: center;
        background-color: #f3f8ff;
        color: var(--dark);
        padding: 5px;
        line-height: 1.5;
        border-top: 1px solid #c6d3e5;
        border-left: 1px solid #c6d3e5;
    }
    @media(max-width:575px){
        .ofr-card .analise > .analise-sec > span{
            display: block;
        }
    }


    /* offer navigation design  */
    #offers_list.nav{
        position: relative;
        border-radius: 4px;
        margin-bottom: 1.5rem;
    }
    #offers_list.nav .nav-item{
        width: 33.33%;
    }
    #offers_list.nav .nav-item > .nav-link{
        text-align: center;
        background-color: #f2f2f2;
        color: var(--secondary);
        text-transform: capitalize;
        /* font-size: 1rem; */
        padding: 1rem .5rem;
        font-weight: 500;
        line-height: 1;
        height: 100%;
        border: 1px solid rgba(0, 0, 0, .1);
        position: relative;
    }
    #offers_list.nav .nav-item:first-child > .nav-link{
        border-radius: 4px 0px 0px 4px;
    }
    #offers_list.nav .nav-item:last-child > .nav-link{
        border-radius: 0px 4px 4px 0px;
    }
    #offers_list.nav .nav-item > .nav-link > .badge{
        background-color: var(--secondary);
        color: var(--light);
    }
    #offers_list.nav .nav-item > .nav-link:hover{
        background-color: var(--light);
        /* color: #fff; */
    }
    #offers_list.nav .nav-item > .nav-link.active{
        background-color: var(--primary);
        color: #fff;
    }
    #offers_list.nav .nav-item > .nav-link.active > .badge{
        background-color: var(--light);
        color: var(--dark);
    }

    #offers_list.nav .nav-item > .nav-link.active::after{
        content: "";
        position: absolute;
        z-index: 2;
        left: 50%;
        transform: translateX(-50%);
        top: 100%;
        width: 0;
        height: 0;
        border-left: 10px solid transparent;
        border-right: 10px solid transparent;
        border-top: 10px solid var(--primary);
        clear: both;
    }


    .fc-daygrid-day-events .fc-event{
        opacity: .8;
        display: flex;
        align-items: end;
        box-shadow: 0px 0px 0px rgb(0 0 0 / 0%);
        /* border: 2px dotted transparent; */
        transition: all 300ms ease;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        overflow: hidden;
        justify-content: center;
        align-items: center;
    }
    .fc-daygrid-day-events .fc-event .fc-event-title i{
        margin-left: 2px;
        margin-top: 2px;
        font-size: .9rem;
    }
    .fc-day-today {
        background: transparent !important;
        border: 2px solid #237cd8 !important;
    }

    .popover.psnl_msg {
        background: #5495d6;
    }
    .popover .popover-header{
        font-size: .85rem!important;
    }
    .popover.psnl_msg .popover-body{
        color: #fff;
    }
    .popover.psnl_msg.bs-popover-top > .arrow::after,
    .popover.psnl_msg.bs-popover-top > .arrow::before {
        border-top-color: #5495d6;
    }
    .popover.psnl_msg > .arrow::after,
    .popover.psnl_msg > .arrow::before {
        border-bottom-color: #5495d6;
    }

    .popover.offer_msg .popover-header > span,
    .popover.offer_msg .popover-body > span{
        overflow: hidden;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        display: -webkit-box;
        width: 100%;
    }
    .popover.offer_msg .popover-body > span{
        -webkit-line-clamp: 3;
    }
    .default.alert-info {
        color: #0c5460;
        background-color: #f4fbfc;
        border: 1px solid #99c5cc;
    }
</style>
@endsection

@section('content')

<section class="section">
    <div>

        <div class="text-right mb-4">
            @if((count($scheduled) + count($unscheduled)) >= 10)
                <span class="badge badge-danger mb-3" style="white-space: normal !important; line-height: 1.6;">You have reached maximum design limit. Now you can create new design or duplicate old design only when one of your already created offer expire.</span>
            @endif

            <a @if($isConnectAnySocialMedia==0) href="javascript:void()" id="showConnectPopup" @else href="{{route('business.designOffer.templates')}}" @endif class="btn btn-primary mb-sm-3 btn-lg @if((count($scheduled) + count($unscheduled)) >= 10) disabled @endif">
                Design New Offer
            </a>
        </div>

        <div class="row">
            <div class="col-md-6">
                
                <div class="card">
                    <div class="card-body" style="padding: 15px !important;">
                        <div class="default alert alert-info mb-4 p-2">
                            <p style="line-height: 1.5"><b>The calendar shows your current and upcoming offers in colored dates. A bell icon is shown on the date on which Personalised Messaging is scheduled.</b></p>
                        </div> 
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div>

                    <div class="card_">
                        <div class="card-body_">


                            <ul class="nav" id="offers_list" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link design-offer" id="scheduled" data-toggle="tab" href="#scheduled_tab" role="tab" aria-controls="scheduled" aria-selected="true">scheduled <span class="badge py-1 px-2">{{ count($scheduled) }}</span> </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link design-offer" id="unscheduled" data-toggle="tab" href="#unscheduled_tab" role="tab" aria-controls="unscheduled" aria-selected="false">unscheduled <span class="badge py-1 px-2">{{ count($unscheduled) }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link design-offer" id="expired" data-toggle="tab" href="#expired_tab" role="tab" aria-controls="expired" aria-selected="false">expired <span class="badge py-1 px-2">{{ count($expired) }}</span></a>
                                </li>
                            </ul>

                            <div class="tab-content" id="tab_offers_list">

                                {{-- Scheduled Offers list --}}
                                <div class="tab-pane fade design-offer-tab" id="scheduled_tab" role="tabpanel" aria-labelledby="scheduled">
                                    <div class="ofrs_list">
                                        @php $c = 0; /* for offer's background color array */ @endphp
                                        @forelse ($scheduled as $s_offer)
                                            {{-- single offer  --}}
                                            <div class="ofr-main-card">
                                                @php
                                                    if($s_offer->type != 'custom'){
                                                        $preview_url = route("business.offerPreview", $s_offer->id);
                                                    }else{
                                                        $preview_url = route("business.customOfferPreview", $s_offer->id);
                                                        
                                                    }
                                                    
                                                @endphp
                                                {{--  --}}
                                                    <div class="ofr-card">
                                                        @php
                                                            if($s_offer->type == 'custom'){
                                                                if($s_offer->website_url != ''){
                                                                    if($s_offer->website_meta_image != ''){
                                                                        $img_url = $s_offer->website_meta_image;
                                                                    }else{
                                                                        $img_url = asset('assets/img/default_website_img.jpg');
                                                                    }
                                                                    
                                                                }else{
                                                                    $img_url = asset('assets/templates/custom').'/'.$s_offer->image;
                                                                }
                                                                
                                                            }else{
                                                                if($s_offer->offer_template != null){
                                                                    $img_url = asset('assets/offer-thumbnails').'/'.$s_offer->offer_template->thumbnail;
                                                                }else{
                                                                    $img_url = asset('assets/offer-thumbnails').'/';
                                                                }
                                                                
                                                            }

                                                            $status = 'Upcoming';
                                                            $now = \Carbon\Carbon::now()->format("Y-m-d");
                                                            $start_date = date('Y-m-d', strtotime($s_offer->start_date));
                                                            $end_date = date('Y-m-d', strtotime($s_offer->end_date));

                                                            if($start_date <= $now && $now <= $end_date ){
                                                                $status = 'On Going';
                                                            }

                                                            $edit_url = "javascript:void(0)";
                                                            if($status == "Upcoming"){
                                                                $nowEdit = \Carbon\Carbon::now()->format("Y-m-d");

                                                                $start_date = $end_date = '';
                                                                if($s_offer->start_date != null){
                                                                    $start_date = date('Y-m-d', strtotime($s_offer->start_date));
                                                                }

                                                                if($s_offer->end_date != null){
                                                                    $end_date = date('Y-m-d', strtotime($s_offer->end_date));
                                                                }

                                                                $current_offer = $expired_offer = false;
                                                                if(($start_date != '' && $end_date != '') && $start_date <= $now && $now <= $end_date ){
                                                                    $current_offer = true;
                                                                }

                                                                if(($start_date != '' && $end_date != '') && $start_date < $nowEdit && $end_date < $nowEdit){
                                                                    $expired_offer = true;
                                                                }

                                                                if($current_offer == true && $expired_offer == false){
                                                                    // Current Offer
                                                                }
                                                                elseif($current_offer == false && $expired_offer == true){
                                                                    // Expired
                                                                }
                                                                else{
                                                                    $edit_url = route('business.offerEdit', $s_offer->id);
                                                                }
                                                            }
                                                        @endphp
                                                        <a href="{{ $preview_url }}" class="ofr-img hover-to-cal" style="background-image: url({{ $img_url }});" data-startdate="{{ \Carbon\Carbon::parse($s_offer->start_date)->format('Y-m-d') }}" data-toggle="tooltip" title="Click to Preview Offer"></a>
                                                        <div class="ofr-body">
                                                            <div class="ofr-body-inner">
                                                                <div class="mb-3">
                                                                    <div class="d-flex">
                                                                        <a href="{{ $preview_url }}" class="hover-to-cal flex-fill" data-startdate="{{ \Carbon\Carbon::parse($s_offer->start_date)->format('Y-m-d') }}">
                                                                            <p class="ofr-title mb-0">{{ $s_offer->title }}</p>
                                                                        </a>
                                                                        <div class="dropdown" data-toggle="tooltip" title="More">
                                                                            <a class="px-2" href="#" role="button" id="moreDrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                <i class="fas fa-ellipsis-v"></i>
                                                                            </a>
                                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="moreDrop">
                                                                                <a href="javascript:void(0)" class="@if((count($scheduled) + count($unscheduled)) >= 10) disabled @else duplicate @endif dropdown-item" data-offer_id="{{ encrypt($s_offer->id) }}"><i class="far fa-copy mr-2"></i> {{ __("Duplicate") }}</a>

                                                                                @if($status == "Upcoming")
                                                                                    <a href="{{ $edit_url }}" class="dropdown-item"><i class="fas fa-edit mr-2"></i> {{ __("Edit") }}</a>

                                                                                    <a href="javascript:void(0)" class="dropdown-item setUnscheduleOffer" data-offer_id="{{ encrypt($s_offer->id) }}" ><i class="fas fa-calendar mr-2"></i> {{ __("Unschedule") }}</a>

                                                                                    <a href="javascript:void(0)" class="dropdown-item deleteOffer text-danger" data-offer_id="{{ encrypt($s_offer->id) }}"><i class="fas fa-trash-alt mr-2"></i> {{ __("Delete") }}</a>
                                                                                @else
                                                                                    <a href="javascript:void(0)" class="dropdown-item stopOffer text-danger" data-offer_id="{{ encrypt($s_offer->id) }}" ><i class="fas fa-ban mr-2"></i> {{ __("Stop") }}</a>
                                                                                @endif

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <span class="badge badge-success py-1">{{ $status }}</span> 
                                                                    {{-- <span class="badge badge-success py-1">Posted</span> --}}
                                                                </div>
                                                                <div>
                                                                    <div class="ofr-date-flex">
                                                                        <p class="mb-0">Start: <strong class="text-primary">{{ \Carbon\Carbon::parse($s_offer->start_date)->format('j M, Y') }}</strong></p>
                                                                        <p class="mb-0">End: <strong class="text-primary">{{ \Carbon\Carbon::parse($s_offer->end_date)->format('j M, Y') }}</strong></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="analise">

                                                           
                                        
                                      

                                                                <div class="analise-sec">
                                                                   
                                                                    <small>Unique Clicks</small>
                                                                    @if($planData['userData']->current_account_status == 'free')
                                                                    <span class="mb-0 __pro__"></span>
                                                                    @else
                                                                        <span class="mb-0">({{ $s_offer->unique_clicks_count }})</span>
                                                                    @endif
                                                                </div>
                                                                <div class="analise-sec">
                                                                    <small>Total Clicks</small> <span>({{ $s_offer->unique_clicks_count + $s_offer->extra_clicks_count }})</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- </a> --}}
                                            </div>
                                            {{-- offer END  --}}

                                            @php
                                            
                                                /* push data to veriable, for showning offers into calendaar table */
                                                $offer_dtl = [
                                                    "start"=> \Carbon\Carbon::parse($s_offer->start_date)->format('Y-m-d'),
                                                    "end"=> \Carbon\Carbon::parse($s_offer->end_date)->addDays(1)->format('Y-m-d'),
                                                    "overlap"=> false,
                                                    "display"=> 'background',
                                                    "backgroundColor"=> $offers_background_colors[$c], /* Color's variable defined in controller */
                                                    "description" => $s_offer->description,
                                                    /* extra parametere sent */
                                                    "event_type" => 'offer',
                                                    "title_ex"=> $s_offer->title,
                                                ];
                                                $events_json_data[] = $offer_dtl;
                                            @endphp
                                            @php $c++; @endphp
                                        @empty
                                            <div class="no_recored text-center py-3">
                                                <h6 class="mb-0"> {{ Config::get('constants.no_record_found') }}</h6>
                                            </div>
                                        @endforelse

                                    </div>
                                </div>
                                {{-- Scheduled Offer List - END --}}

                                {{-- Un-scheduled offers  --}}
                                <div class="tab-pane fade design-offer-tab" id="unscheduled_tab" role="tabpanel" aria-labelledby="unscheduled">
                                    <div class="ofrs_list">

                                        {{-- Add here the list of unscheduled offers --}}
                                        @forelse ($unscheduled as $u_offer)
                                            {{-- single offer  --}}
                                            <div class="ofr-main-card">

                                                @php
                                                    if($u_offer->type != 'custom'){
                                                        $preview_url = route("business.offerPreview", $u_offer->id);
                                                    }else{
                                                        $preview_url = route("business.customOfferPreview", $u_offer->id);
                                                        
                                                    }
                                                    
                                                @endphp

                                                
                                                    <div class="ofr-card">
                                                        @php
                                                            if($u_offer->type == 'custom'){
                                                                if($u_offer->website_url != ''){
                                                                    if($u_offer->website_meta_image != ''){
                                                                        $img_url = $u_offer->website_meta_image;
                                                                    }else{
                                                                        $img_url = asset('assets/img/default_website_img.jpg');
                                                                    }
                                                                }else{
                                                                    $img_url = asset('assets/templates/custom').'/'.$u_offer->image;
                                                                }
                                                                
                                                            }else{
                                                                if($u_offer->offer_template != null){
                                                                    $img_url = asset('assets/offer-thumbnails').'/'.$u_offer->offer_template->thumbnail;
                                                                }else{
                                                                    $img_url = asset('assets/offer-thumbnails').'/';
                                                                }
                                                            }

                                                            $status = 'Upcoming';
                                                            $now = \Carbon\Carbon::now()->format("Y-m-d");
                                                            $start_date = date('Y-m-d', strtotime($u_offer->start_date));
                                                            $end_date = date('Y-m-d', strtotime($u_offer->end_date));

                                                            if($start_date <= $now && $now <= $end_date ){
                                                                $status = 'On Going';
                                                            }

                                                            $edit_unschedule_url = "javascript:void(0)";
                                                            if($status == "Upcoming"){
                                                                $nowEdit = \Carbon\Carbon::now()->format("Y-m-d");

                                                                $start_date = $end_date = '';
                                                                if($u_offer->start_date != null){
                                                                    $start_date = date('Y-m-d', strtotime($u_offer->start_date));
                                                                }

                                                                if($u_offer->end_date != null){
                                                                    $end_date = date('Y-m-d', strtotime($u_offer->end_date));
                                                                }

                                                                $current_offer = $expired_offer = false;
                                                                if(($start_date != '' && $end_date != '') && $start_date <= $now && $now <= $end_date ){
                                                                    $current_offer = true;
                                                                }

                                                                if(($start_date != '' && $end_date != '') && $start_date < $nowEdit && $end_date < $nowEdit){
                                                                    $expired_offer = true;
                                                                }

                                                                if($current_offer == true && $expired_offer == false){
                                                                    // Current Offer
                                                                }
                                                                elseif($current_offer == false && $expired_offer == true){
                                                                    // Expired
                                                                }
                                                                else{
                                                                    $edit_unschedule_url = route('business.offerEdit', $u_offer->id);
                                                                }
                                                            }
                                                        @endphp
                                                    
                                                        <a href="{{ $preview_url }}" class="ofr-img hover-to-cal" style="background-image: url({{ $img_url }});" data-toggle="tooltip" title="Click to Preview Offer"></a>
                                                        <div class="ofr-body">
                                                            <div class="ofr-body-inner">
                                                                <div class="mb-3">
                                                                    <div class="d-flex">
                                                                        <a href="{{ $preview_url }}" class="flex-fill">
                                                                            <p class="ofr-title mb-0">{{ $u_offer->title }}</p>
                                                                        </a>
                                                                        <div class="dropdown" data-toggle="tooltip" title="More">
                                                                            <a class="px-2" href="#" role="button" id="moreDrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                <i class="fas fa-ellipsis-v"></i>
                                                                            </a>
                                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="moreDrop">
                                                                                <a href="javascript:void(0)" class="@if((count($scheduled) + count($unscheduled)) >= 10) disabled @else duplicate @endif dropdown-item" data-offer_id="{{ encrypt($u_offer->id) }}"><i class="far fa-copy mr-2"></i> {{ __("Duplicate") }}</a>

                                                                                <a href="{{ $edit_unschedule_url }}" class="dropdown-item"><i class="fas fa-edit mr-2"></i> {{ __("Edit") }}</a>

                                                                                <a href="javascript:void(0)" class="dropdown-item deleteOffer text-danger" data-offer_id="{{ encrypt($u_offer->id) }}"><i class="fas fa-trash-alt mr-2"></i> {{ __("Delete") }}</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    Currently your Offer is in unscheduled list, please select Start Date and End Date to run this offer.
                                                                </div>
                                                                <div>
                                                                    <div class="ofr-date-flex">
                                                                        {{-- <p class="mb-0">Start: <strong class="text-primary">-</strong></p> --}}
                                                                        <p class="mb-0">&nbsp;</strong></p>
                                                                        {{-- <p class="mb-0">End: <strong class="text-primary">-</strong></p> --}}
                                                                        <p class="mb-0">&nbsp;</strong></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="analise">
                                                                <div class="analise-sec ">
                                                                    <!-- <small>Unique Clicks</small> <span>({{ $u_offer->unique_clicks_count }})</span> -->
                                                                    <small>Unique Clicks</small>
                                                                    @if($planData['userData']->current_account_status == 'free')
                                                                    <span class="mb-0 __pro__"></span>
                                                                    @else
                                                                        <span class="mb-0">{{ $u_offer->unique_clicks_count }}</span>
                                                                    @endif
                                                                </div>
                                                                <div class="analise-sec">
                                                                    <small>Total Clicks</small> <span>({{ $u_offer->unique_clicks_coun + $u_offer->extra_clicks_count }})</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            {{-- offer END  --}}
                                        @empty
                                            <div class="no_recored text-center py-3">
                                                <h6 class="mb-0"> {{ Config::get('constants.no_record_found') }}</h6>
                                            </div>
                                        @endforelse
                                        

                                    </div>
                                </div>
                                {{-- UN-Secheduled offer - END --}}
                            
                                {{-- Expired offer --}}
                                <div class="tab-pane fade design-offer-tab" id="expired_tab" role="tabpanel" aria-labelledby="expired">

                                    @if(count($expired) > 0)
                                        <p class="badge badge-danger">{{ __('Showing last 10 expired offers.') }}</p>
                                    @endif
                                    
                                    <div class="ofrs_list">

                                        {{-- Add here the list of Expired offers --}}
                                        @forelse ($expired as $e_offer)
                                            {{-- single offer  --}}
                                            <div class="ofr-main-card">
                                                @php
                                                    if($e_offer->type != 'custom'){
                                                        $preview_url = route("business.offerPreview", $e_offer->id);
                                                    }else{
                                                        $preview_url = route("business.customOfferPreview", $e_offer->id);
                                                        
                                                    }
                                                    
                                                @endphp

                                                    <div class="ofr-card">
                                                        @php
                                                            if($e_offer->type == 'custom'){
                                                                if($e_offer->website_url != ''){
                                                                    if($e_offer->website_meta_image != ''){
                                                                        $img_url = $e_offer->website_meta_image;
                                                                    }else{
                                                                        $img_url = asset('assets/img/default_website_img.jpg');
                                                                    }
                                                                }else{
                                                                    $img_url = asset('assets/templates/custom').'/'.$e_offer->image;
                                                                }
                                                                
                                                            }else{
                                                                if($e_offer->offer_template != null){
                                                                    $img_url = asset('assets/offer-thumbnails').'/'.$e_offer->offer_template->thumbnail;
                                                                }else{
                                                                    $img_url = asset('assets/offer-thumbnails').'/';
                                                                }
                                                            }

                                                            
                                                            
                                                        @endphp
                                                        <a href="{{ $preview_url }}" class="ofr-img hover-to-cal" style="background-image: url({{ $img_url }});" data-toggle="tooltip" title="Click to Preview Offer"></a>
                                                        <div class="ofr-body">
                                                            <div class="ofr-body-inner">
                                                                <div class="mb-3">
                                                                    <div class="d-flex">
                                                                        <a class="flex-fill" href="{{ $preview_url }}" data-toggle="tooltip" title="Click to Preview Offer">
                                                                            <p class="ofr-title mb-0">{{ $e_offer->title }}</p>
                                                                        </a>
                                                                        <div class="dropdown" data-toggle="tooltip" title="More">
                                                                            <a class="px-2" href="#" role="button" id="moreDrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                <i class="fas fa-ellipsis-v"></i>
                                                                            </a>
                                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="moreDrop">
                                                                                <a href="javascript:void(0)" class="@if((count($scheduled) + count($unscheduled)) >= 10) disabled @else duplicate @endif dropdown-item" data-offer_id="{{ encrypt($e_offer->id) }}"><i class="far fa-copy mr-2"></i> {{ __("Duplicate") }}</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <span class="badge badge-danger py-1">Expired</span> 
                                                                    {{-- <span class="badge badge-success py-1">Posted</span> --}}
                                                                </div>
                                                                <div>
                                                                    <div class="ofr-date-flex">
                                                                        <p class="mb-0">Start: <strong class="text-primary">{{ \Carbon\Carbon::parse($e_offer->start_date)->format('j M, Y') }}</strong></p>
                                                                        <p class="mb-0">End: <strong class="text-primary">{{ \Carbon\Carbon::parse($e_offer->end_date)->format('j M, Y') }}</strong></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="analise">
                                                                <div class="analise-sec ">
                                                                    <!-- <small>Unique Clicks</small> <span>({{ $e_offer->unique_clicks_count }})</span> -->
                                                                    <small>Unique Clicks</small>
                                                                    @if($planData['userData']->current_account_status == 'free')
                                                                    <span class="mb-0 __pro__"></span>
                                                                    @else
                                                                        <span class="mb-0">{{ $e_offer->unique_clicks_count }}</span>
                                                                    @endif
                                                                </div>
                                                                <div class="analise-sec">
                                                                    <small>Total Clicks</small> <span>({{ $e_offer->unique_clicks_count + $e_offer->extra_clicks_count }})</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            {{-- offer END  --}}
                                        @empty
                                            <div class="no_recored text-center py-3">
                                                <h6 class="mb-0"> {{ Config::get('constants.no_record_found') }}</h6>
                                            </div>
                                        @endforelse
                                        

                                    </div>
                                </div>
                                {{-- Expired offer - END --}}
                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>

    </div>
</section>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4>Add Offer to the Calendar</h4>
                @php
                    $offers = \DB::table('offers')->where('user_id',Auth::id())->where('start_date', NULL)->where('end_date', NULL)->get();
                    $offer_count = count($offers);
                @endphp
                <ol class="offer-list">
                    @foreach($offers as $offer)
                        <li class="offer-title offer_{{ $offer->id }}" id="{{ $offer->id }}">{{ $offer->title }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Date Range --}}
<div class="d-none">
    <input type="hidden" name="start_date" id="start_date" value="" />
    <input type="hidden" name="end_date" id="end_date" value="" />
    <input type="hidden" name="offer_count" id="offer_count" value="{{ $offer_count }}" />
</div>
@endsection


@section('end_body')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap-4',

            eventDidMount: function(info) {
                var custom_class;
                if(info.event.extendedProps.event_type === 'personalised_msg'){
                    $(info.el).find(".fc-event-title").prepend("<i class='fa fa-"+info.event.extendedProps.icon+"'></i>");
                    custom_class = 'psnl_msg'
                }else{
                    custom_class = 'offer_msg'
                }

                var popover_body = '<div class="popover '+custom_class+'" role="tooltip"><div class="arrow"></div><h5 class="popover-header"></h5><div class="popover-body small"></div></div>';
                $(info.el).popover({
                    template: popover_body,
                    title: "<span>" + info.event.extendedProps.title_ex + "</span>",
                    content: "<span>" + info.event.extendedProps.description + "</span>",
                    placement : 'bottom',
                    trigger: "hover",
                    container: "body",
                    html:true
                });
            },

            events: @json($events_json_data),
        });
        calendar.render();
    });
</script>


<script>
    $(document).ready(function () {

        if (window.location.href.indexOf("tab") > -1) {
            var urlParams = new URLSearchParams(window.location.search);
            var tab_value = urlParams.get('tab');
            var tab_arr = tab_value.split('_');
            sessionStorage.setItem("design_offer", tab_arr[0]);
            // location.reload();
        }
        /* Select tab */
        if(sessionStorage.getItem("design_offer")){
            var tab_id = sessionStorage.getItem("design_offer");
            $(".design-offer").removeClass("active");
            $(".design-offer").removeClass("show");

            $(".design-offer-tab").removeClass("active");
            $(".design-offer-tab").removeClass("show");

            $("#"+tab_id).addClass("active");
            $("#"+tab_id).addClass("show");

            $("#"+tab_id+"_tab").addClass("active");
            $("#"+tab_id+"_tab").addClass("show");
        }else{
            $("#scheduled").addClass("active");
            $("#scheduled").addClass("show");

            $("#scheduled_tab").addClass("active");
            $("#scheduled_tab").addClass("show");
        }


        var SITEURL = "{{ url('/') }}";
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // var calendar_ = document.getElementById('calendar');
        // var calendar;

        // calendar = new FullCalendar.Calendar(calendar_, {
        //     editable:true,
        //     themeSystem: 'bootstrap-5',
        //     // header:{
        //     //     left:'prev,next today',
        //     //     center:'title',
        //     //     right:'month,agendaWeek,agendaDay'
        //     // },

        //     // events: SITEURL + '/business/design-offer',

        //     // events:{
        //     //     url: SITEURL + '/business/design-offer',
        //     // },

        //     events: {!!json_encode($events_json_data)!!},

        //     selectable:true,
        //     selectHelper: true,
            
        //     loading: function (bool) { 
        //         if (bool) 
        //             console.log('Loading..'); 
        //         else 
        //             console.log('Loading Done'); 
        //     },

        //     select:function(start, end, allDay)
        //     {

        //         var count = $("#offer_count").val();
        //         if(count != 0){
        //             var start = $.fullCalendar.formatDate(start, 'Y-MM-DD');
        //             var end = $.fullCalendar.formatDate(end, 'Y-MM-DD');
        //             addOffer(start, end);
        //         }else{
        //             Sweet('error','No offers are found!');
        //         }
        //     },

        //     dayClick: function(date, jsEvent, view) {
        //         //$("#editModal").modal("show");
        //     },

        //     eventResize: function(event, delta)
        //     {
        //         var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD');
        //         var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD');
        //         var id = event.id;
        //         $.ajax({
        //             url:SITEURL + "/business/design-offer/action",
        //             type:"POST",
        //             data:{
        //                 start: start,
        //                 end: end,
        //                 id: id,
        //                 type: 'update'
        //             },
        //             success:function(response)
        //             {
        //                 if(data.status == true){
        //                     calendar.fullCalendar('refetchEvents');
        //                     Sweet('success','Offer Updated Successfully!');
        //                 }else{
        //                     Sweet('error',data.message);
        //                 }
                        
        //             }
        //         })
        //     },
        //     eventDrop: function(event, delta)
        //     {   
        //         var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD');
        //         var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD');
        //         var id = event.id;
        //         $.ajax({
        //             url:SITEURL + "/business/design-offer/action",
        //             type:"POST",
        //             data:{
        //                 start: start,
        //                 end: end,
        //                 id: id,
        //                 type: 'update'
        //             },
        //             success:function(response)
        //             {
        //                 if(data.status == true){
        //                     calendar.fullCalendar('refetchEvents');
        //                     Sweet('success','Offer Updated Successfully!');
        //                 }else{
        //                     Sweet('error',data.message);
        //                 }
                        
        //             }
        //         })
        //     },

        //     eventClick:function(event)
        //     {
        //         if(confirm("Are you sure you want to remove it?"))
        //         {
        //             var id = event.id;
        //             $.ajax({
        //                 url:SITEURL + "/business/design-offer/action",
        //                 type:"POST",
        //                 data:{
        //                     id:id,
        //                     type:"delete"
        //                 },
        //                 success:function(response)
        //                 {
        //                     calendar.fullCalendar('refetchEvents');
        //                     Sweet('success','Offer Removed Successfully!');
        //                     getOfferList();
        //                 }
        //             })
        //         }
        //     },
        // });

        // calendar.render();
    
        $("body").delegate(".offer-title", "click", function(){
            $("#editModal").modal("hide");
            var start = $("#start_date").val();
            var end = $("#end_date").val();
            var id = $(this).attr('id');

            var SITEURL = "{{ url('/') }}";
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            $.ajax({
                url:SITEURL + "/business/design-offer/action",
                type:"POST",
                data:{
                    start: start,
                    end: end,
                    id: id,
                    type: 'add'
                },
                success:function(data)
                {
                    if(data.status == true){
                        $('.offer_'+id).hide();
                        var count = $("#offer_count").val();
                        count = count - 1;
                        $("#offer_count").val(count);

                        $('#calendar').fullCalendar('refetchEvents');
                        Sweet('success','Offer Created Successfully!');
                    }else{
                        Sweet('error',data.message);
                    }
                    
                }
            });
        });

        function addOffer(start, end){
            $("#start_date").val(start);
            $("#end_date").val(end);
            
            $("#editModal").modal("show");
        }

        function getOfferList(){

            var SITEURL = "{{ url('/') }}";
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:SITEURL + "/business/design-offer/offer-list",
                type:"GET",
                success:function(res)
                {
                    $('.offer-list').empty();
                    $.each(res.offers, function( key, value ) {
                        $('.offer-list').append('<li class="offer-title offer_' + value.id + '" id="' + value.id + '">' + value.title + '</li>');
                    });

                    $("#offer_count").val(res.count);
                    //console.log(res);
                }
            });
        }
    });

    
    /*
    * When hover on the offer card, Shows shadow on FullCalendar's Offer
    * On hover class(hover-to-cal), Add or Remove class(hover_) from the FC element has offer's date
    */
    $(document).ready(function(){
        var hover_offer = $('.hover-to-cal');
        hover_offer.hover(function() {
            var cal_event = $(".fc-day[data-date='"+ $(this).data('startdate') +"']").find('div.fc-event');
            cal_event.addClass('hover_');
        }, function () {
            var cal_event = $(".fc-day[data-date='"+ $(this).data('startdate') +"']").find('div.fc-event');
            cal_event.removeClass('hover_');
        });


        $(document).on("click", ".duplicate", function(){
            var offer_id = $(this).data("offer_id");
            $("#overlay").fadeIn();
            $.ajax({
                url: "{{ URL::to('business/duplicate-offer') }}",
                type:"POST",
                data:{
                    offer_id:offer_id
                },
                success:function(data)
                {
                    $("#overlay").fadeOut(300);
                    if(data.status == true){
                        Sweet('success',data.message);
                        setTimeout(function () {
                            window.location.href = data.redirect_url+"?tab=unscheduled_tab";
                        }, 1500);
                    }else{
                        Sweet('error',data.message);
                    }
                }
            });
        });

        $(document).on("click", ".setUnscheduleOffer", function(){
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to convert this offer to Unschedule!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Continue'
            }).then((result) => {
                if (result.value == true) {
                    $("#overlay").fadeIn();
                    var offer_id = $(this).data("offer_id");
                    $.ajax({
                        url: "{{ route('business.setUnscheduleOffer') }}",
                        type:"POST",
                        data:{
                            offer_id:offer_id
                        },
                        success:function(res)
                        {
                            $("#overlay").fadeOut(300);
                            if(res.status == true){
                                Sweet('success',res.message);
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);
                            }else{
                                Sweet('error',res.message);
                            }
                        }
                    });
                }
            });
        });

        $(document).on("click", ".deleteOffer", function(){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value == true) {
                    $("#overlay").fadeIn();
                    var offer_id = $(this).data("offer_id");
                    $.ajax({
                        url: "{{ URL::to('business/delete-offer') }}",
                        type:"POST",
                        data:{
                            offer_id:offer_id
                        },
                        success:function(data)
                        {
                            $("#overlay").fadeOut(300);
                            if(data.status == true){
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'Okay',
                                    confirmButtonColor: 'rgb(4 183 44)',
                                }).then((result) => {
                                    if(result.value==true){
                                        setTimeout(function () {
                                            window.location.href = data.redirect_url;
                                        }, 500);
                                    }
                                });
                            }else{
                                Sweet('error',data.message);
                            }
                        }
                    });
                    
                }
            });
        });

        $(document).on("click", "#showConnectPopup", function(){
            const swalSocialConnectPopup = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success m-1',
                    cancelButton: 'btn btn-primary m-1'
                },
                buttonsStyling: false
            });
            swalSocialConnectPopup.fire({
                title: "You are not connected to social media",
                text: "If you are not connected to any social media then need to post manually!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Go to connect page!',
                cancelButtonText: 'Design new offer!',
                reverseButtons: true,
                allowOutsideClick: false,
                showCloseButton: true,
            }).
            then((result) => {
                if (result.value == true) {
                    sessionStorage.setItem("setting_section", "social_connection");
                    window.location.href = "{{ route('business.settings') }}";
                } 
                else if (result.dismiss === "cancel") {
                    window.location.href = "{{ route('business.designOffer.templates') }}";
                }
            });
        });

        $(document).on("click", ".stopOffer", function(){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, STOP!'
            }).then((result) => {
                console.log(result);
                if (result.value == true) {
                    // $("#overlay").fadeOut(300);
                    var offer_id = $(this).data("offer_id");
                    $.ajax({
                        url: "{{ route('business.expireOffer') }}",
                        type:"POST",
                        data:{
                            offer_id:offer_id
                        },
                        success:function(data)
                        {
                            $("#overlay").fadeOut(300);
                            if(data.status == true){
                                Sweet('success', data.message);
                                setTimeout(function () {
                                    window.location.href = data.redirect_url;
                                }, 1500);
                            }else{
                                Sweet('error',data.message);
                            }
                        }
                    });
                }
            });
        });


        $(document).on("click", ".design-offer", function(){
            sessionStorage.setItem("design_offer", $(this).attr('id'));
            // console.log($(this).attr('id'));
        });
        
    })
</script>
@endsection