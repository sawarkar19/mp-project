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

                <!-- links -->
                <div class="">
                    <div>
                        <a href="{{ route('business.future.index') }}" class="btn btn-primary btn-sm px-3 mr-3">
                            <i class="fas fa-arrow-left"></i> 
                            Back To Offer's List
                        </a>

                        <a href="{{ $offer->future_offer->promotion_url }}" target="_blank" class="btn btn-info btn-sm px-3">
                            Offer Preview
                            <i class="fas fa-arrow-right"></i> 
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- ================================================================ -->


    <!-- ==================================== Template if Page type Template ================================== -->

    <style>
        .ts_lable{
            position: relative;
            width: 100%;
        }
        .template_selection{
            position: relative;
            border-radius:5px;
            overflow:hidden;
            background-color:#F2F2F2;
            border-style: solid;
            border-width:2px;
            border-color:transparent;
            width: 100%;
        }
        .template_selection .thumb{
            position: relative;
            width: 100%;
            padding-bottom: 100%;
            background-color: #f2f2f2;
            background-size: cover;
            background-position: top center;
        }
    </style>

    @if($offer->future_offer->promotion_url == null)
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Template</h4>
                </div>
                <div class="col-4">
                    <div class="input-group">
                        <select class="form-control select2" name="business_type" id="business_type">
                            <option value="all">All</option>
                            @foreach($businesses as $business)
                            <option value="{{$business->id}}">{{$business->name}}</option>
                            @endforeach  
                        </select>
                    </div>
                </div>
                
                <div class="card-body">
                    <form id="templateform" action="{{ route('business.templateUpdate') }}" method="post">
                    @csrf
                    <p>You can change your page template below.</p>
                    <div class="form-row">
                        @foreach($templates as $template)
                        <div class="col-xl-2 col-md-3 col-sm-4 col-6 show_all template_{{ $template->business_type }}">
                            <div class="text-center mb-4">
                                <label class="ts_lable" for="temp_{{$template->id}}">
                                    <div class="template_selection @if($offer->future_offer->template_id == $template->id) border-primary @endif">
                                        <div class="px-2 py-1 d-flex">
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="radio" id="temp_{{$template->id}}" name="template_id" value="{{ $template->id }}" class="custom-control-input tempaltes_select" @if($offer->future_offer->template_id == $template->id) checked @endif>
                                                <label class="custom-control-label" for="temp_{{$template->id}}"></label>
                                                <input type="hidden" name="offer_id" value="{{ $offer->id }}" >
                                            </div>
                                        </div>
                                        <div class="thumb" style="background-image: url({{url('assets/'.$template->thumbnail)}});"></div>
                                        <!-- <img src="{{url('assets/'.$template->thumbnail)}}" class="img-fluid" alt=""> -->
                                    </div>
                                </label>

                                <a href="{{ url('business/offer-preview/' . $offer->id . '/' . $template->id) }}" class="btn btn-sm btn-primary py-1 mb-2 px-3" target="_blank" style="line-height:1;">Preview <i class="fa fa-external-link-alt"></i></a>

                                <a href="{{ url('business/template-preview/'. $template->id) }}" class="btn btn-sm btn-warning py-1 px-3" target="_blank" style="line-height:1;">Template <i class="fa fa-external-link-alt"></i></a>
                            </div>
                        </div>
                        @endforeach

                    </div>

                    <button type="submit" name="save_btn" value="save" class="btn btn-icon icon-left btn-success save_btn">
                        <i class="fas fa-check"></i>
                        Save Changes
                    </button>
                </form>
                </div>
            </div>
        </div>


    </div>
    @endif

    <!-- ======================================================================== -->

</div>
</section>




@endsection
@section('end_body')
    @include('business.offers.future.js')
@endsection