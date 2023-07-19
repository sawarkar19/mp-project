@extends('layouts.business')
@section('content')

<section class="section">
<div class="section-body">

    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="mr-3">
                    <img src="{{ asset('assets/img/done.svg') }}" alt="success" style="width:45px;">
                </div>
                <div>
                    <h3 class="text-success h5 font-weight-bold mb-0">Offer Saved Successfully.</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================= SCRIPT If Page type Own Website================================ -->

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

                <!-- links -->
                <div class="">
                    <div>
                        <a href="{{ route('business.future.index', 'type='.$offer->sub_type) }}" class="btn btn-primary btn-sm px-3 mr-3">
                            <i class="fas fa-arrow-left"></i> 
                            Back To Offer's List
                        </a>

                        <a href="{{ $offer->future_offer->promotion_url }}" target="_blank" class="btn btn-info btn-sm px-3">
                            Preview Webpage
                            <i class="fas fa-arrow-right"></i> 
                        </a>
                    </div>
                </div>
            </div>
        </div>

    <!-- ======================================================================== -->

</div>
</section>




@endsection
@section('end_body')
    @include('business.offers.future.js')
@endsection