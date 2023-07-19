@if($planData['current_offer'] != '')
{{-- Current (on going) offer  --}}

@php
    if($planData['current_offer']->type == 'custom'){
        if($planData['current_offer']->website_url != ''){
            $img_url = asset('assets/img/default_website_img.jpg');
        }else{
            $img_url = asset('assets/templates/custom').'/'.$planData['current_offer']->image;
        }
        
        $preview_url = url('business/offer/custom/preview/'.$planData['current_offer']->id);
    }else{
        $img_url = asset('assets/offer-thumbnails').'/'.$planData['current_offer']->offer_template->thumbnail;

        $preview_url = url('business/offer/preview/'.$planData['current_offer']->id);
    }
@endphp

<div class="current_offer" style="max-width: 400px;">
    <a href="{{ $preview_url }}" class="offer-article-href">
        <article class="article article-style-c">
            <div class="article-header">

                <div class="article-image" data-background="{{ $img_url }}"></div>
                {{-- <div class="article-badge">
                    <div class="article-badge-item bg-success py-1">On Going</div>
                </div> --}}
                @php
                $status = 'Upcoming';
                $now = \Carbon\Carbon::now()->format("Y-m-d");
                $start_date = date('Y-m-d', strtotime($planData['current_offer']->start_date));
                $end_date = date('Y-m-d', strtotime($planData['current_offer']->end_date));

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
                    <h6>{{ $planData['current_offer']->title }}</h6>
                </div>
                <input type="hidden" id="current_offer_id" name="current_offer_id" value="{{ $planData['current_offer']->id}}">
                <p style="line-height: 1.5;" class="mb-0 article-text">{{ $planData['current_offer']->description }}</p>
            </div>
            <div class="article-footer">
                <table class="table table-bordered text-center ">
                    <tr>
                        <td class="px-2">
                            <p class="mb-0"><b>Post Status</b></p>
                            @if($planData['is_posted'] == 1)
                                <div class="badge badge-success py-1">Posted</div>
                            @else
                                <div class="badge badge-warning py-1">Scheduled</div>
                            @endif
                        </td>
                        <td class="px-2">
                            <p class="mb-0"><b>Start</b></p>
                            <p class="mb-0" style="line-height: 1.5;">{{ \Carbon\Carbon::parse($planData['current_offer']->start_date)->format('j M, Y') }}</p>
                        </td>
                        <td class="px-2">
                            <p class="mb-0"><b>End</b></p>
                            <p class="mb-0" style="line-height: 1.5;">{{ \Carbon\Carbon::parse($planData['current_offer']->end_date)->format('j M, Y') }}</p>
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
        <a @if($isConnectAnySocialMedia!=0) href="{{ route('business.designOffer.templates') }}" @else href="javascript:void()" id="showConnectPopup" @endif class="btn btn-sm btn-primary px-3">Design Offer</a>
    </div>
</div> --}}
<div class="card bg-design-offer-banner">
    <div class="card-body px-sm-5">
        <span class="design-img-top"><img src="{{asset('assets/business/design-offer-banner-dashboard/bg-design-img.png')}}" alt=""></span>
        <div class="bg-design-offer-banner-inner banner-responsive">
            <div class="design-offer-banner-text position-relative">
                <h3 class="do-banner-text-head">You don't have any <span class="font-weight-bold" style="color:#EF5744;">offer to challenge!</span></h3>
                <p class="do-banner-text-para">Please click below button to create or design new offer.</p>
                <a  @if($isConnectAnySocialMedia!=0) href="{{ route('business.designOffer.templates') }}" @else href="javascript:void()" id="showConnectPopup" @endif><button class="btn design-offer-button px-4 font-weight-bold">Design Now</button></a>
            </div>
            <div class="design-offer-banner-img mt-4 mt-sm-0">
                <img src="{{asset('assets/business/design-offer-banner-dashboard/design-banner-new.png')}}" alt="" class="img-fluid">
            </div>
        </div>
        <span class="design-img-bottom"><img src="{{asset('assets/business/design-offer-banner-dashboard/bg-design-img.png')}}" alt=""></span>
    </div>
</div>
{{-- END --}}

<script >
    $(document).ready(function(){
        $(document).on('click', "#showConnectPopup", function(){
            const swalSocialConnectPopup = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success m-1',
                    cancelButton: 'btn btn-primary m-1'
                },
                buttonsStyling: false
            })

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
    });
</script>

@endif