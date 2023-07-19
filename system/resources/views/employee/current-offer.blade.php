@if($current_offer != '')
{{-- Current (on going) offer  --}}
<div class="current_offer" style="max-width: 400px;">
    <a href="#" class="offer-article-href">
        <article class="article article-style-c">
            <div class="article-header">

                @php
                    if($current_offer->type == 'custom'){
                        if($current_offer->website_url != ''){
                            $img_url = asset('assets/img/default_website_img.jpg');
                        }else{
                            $img_url = asset('assets/templates/custom').'/'.$current_offer->image;
                        }
                        
                    }else{
                        $img_url = asset('assets/offer-thumbnails').'/'.$current_offer->offer_template->thumbnail;
                    }
                @endphp

                <div class="article-image" data-background="{{ $img_url }}"></div>
                {{-- <div class="article-badge">
                    <div class="article-badge-item bg-success py-1">On Going</div>
                </div> --}}
                @php
                $status = 'Upcoming';
                $now = \Carbon\Carbon::now()->format("Y-m-d");
                $start_date = date('Y-m-d', strtotime($current_offer->start_date));
                $end_date = date('Y-m-d', strtotime($current_offer->end_date));

                if($start_date <= $now && $now <= $end_date ){
                    $status = 'On Going';
                }
                @endphp

                <div class="article-title">
                    <span class="badge badge-success">{{ $status }}</span>
                </div>
            </div>
            <div class="article-details">
                <div class="article-title">
                    <h6>{{ $current_offer->title }}</h6>
                </div>
                <p style="line-height: 1.5;" class="mb-0 article-text">{{ $current_offer->description }}</p>
            </div>
            <div class="article-footer">
                <table class="table table-bordered text-center ">
                    <tr>
                        <td class="px-2">
                            <p class="mb-0"><b>Post Status</b></p>
                            @if($is_posted == 1)
                                <div class="badge badge-success py-1">Posted</div>
                            @else
                                <div class="badge badge-warning py-1">Scheduled</div>
                            @endif
                        </td>
                        <td class="px-2">
                            <p class="mb-0"><b>Start</b></p>
                            <p class="mb-0" style="line-height: 1.5;">{{ \Carbon\Carbon::parse($current_offer->start_date)->format('j M, Y') }}</p>
                        </td>
                        <td class="px-2">
                            <p class="mb-0"><b>End</b></p>
                            <p class="mb-0" style="line-height: 1.5;">{{ \Carbon\Carbon::parse($current_offer->end_date)->format('j M, Y') }}</p>
                        </td>
                    </tr>
                </table>
            </div>
        </article>
    </a>
</div>

@else

<!-- ================================== -->
{{-- if offer is not avilable --}}
{{-- <div class="w-100">
    <div class="py-5 px-3 px-lg-4 mb-3 text-center rounded" style="border: 2px dashed #ddd;">
        <p class="h5 text-warning">You don't have any offer to challenge!</p>
        <p class="">Please click below button to create or design new offer.</p>
         <a href="{{ route('business.designOffer.templates') }}" class="btn btn-sm btn-primary px-3">Design Offer</a>
    </div>
</div> --}}

<div class="card bg-design-offer-banner">
    <div class="card-body px-sm-5">
        <span class="design-img-top"><img src="{{asset('assets/business/design-offer-banner-dashboard/bg-design-img.png')}}" alt=""></span>
        <div class="bg-design-offer-banner-inner banner-responsive">
            <div class="design-offer-banner-text position-relative">
                <h3 class="do-banner-text-head">You don't have any <span class="font-weight-bold" style="color:#EF5744;">offer to challenge!</span></h3>
                <p class="do-banner-text-para">Please click below button to create or design new offer.</p>
                
            </div>
            <div class="design-offer-banner-img mt-4 mt-sm-0">
                <img src="{{asset('assets/business/design-offer-banner-dashboard/design-banner-new.png')}}" alt="" class="img-fluid">
            </div>
        </div>
        <span class="design-img-bottom"><img src="{{asset('assets/business/design-offer-banner-dashboard/bg-design-img.png')}}" alt=""></span>
    </div>
</div>
{{-- END --}}

@endif