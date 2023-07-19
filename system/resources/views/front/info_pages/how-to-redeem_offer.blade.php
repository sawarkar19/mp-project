{{-- @extends('front.info_pages.info_page_layout') --}}
@extends('layouts.front')

@section('title', 'Redeem Code | MouthPublicity')

@section('end_head')
<style>
    .content p,
    .content ol,
    .content ul{
        margin-bottom: 8px;
    }
    .content h4{
        margin-top: 20px;
        text-transform: capitalize;
    }
    
</style>
@endsection

@section('content')

<section id="banner-main" style="min-height: auto!important;">
    <div class="py-5">
        <div class="container">
            <div class="mb-5 mb-xl-0">
                <a href="{{ url('') }}" ><img src="{{ asset('assets/front/images/logo-light.svg') }}" class="main_logo" alt="MouthPublicity"></a>
            </div>

            <div class="text-white mt-5">
                <h1 class="font-h1 font-600">How do I redeem my offer!</h1>
            </div>

        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="py-5">
            <div class="content text-justify">

                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4>Let's complete the target.</h4>
                        <p>It's as simple as snow! Once you receive the link to the offer, Check the share target and validity of the offer. Complete your target within the given frame of time.</p>
                        <p>Once your target is completed, you will immediately receive the coupon code on your registered WhatsApp number.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ asset('assets/front/images/task-complete.svg') }}" class="img-fluid">
                    </div>
                </div>

                
                <div class="row align-items-center my-5">
                    <div class="col-md-4 order-2 order-md-1">
                        <img src="{{ asset('assets/front/images/offer-redeem.svg') }}" class="img-fluid">
                    </div>
                    <div class="col-md-8 order-1 order-md-2">
                        <h4>How to use a Coupon code?</h4>
                        <p>Once you have received the offer, visit the store and claim your offer on the counter with your next purchase. Show your redeemed code to the shop owner. They will cross-check the coupon on the system and give you the offer benefits as mentioned in the offer.</p>
                    </div>
                    
                </div>

                <h4>Why am I unable to use this offer?</h4>
                <p>The offer may have expired.</p>
                <p>Contact us at <a href="tel:+917887882244" style="color:inherit;text-decoration:none;font-weight: bold;"> +91 788 788 2244</a> or write email us at <a href="mailto:care@mouthpublicity.io" style="text-decoration: none;color:inherit; font-weight: bold;">care@mouthpublicity.io</a> for more information.</p>

                

            </div>
        </div>
    </div>
</section>

@endsection