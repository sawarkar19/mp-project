@extends('layouts.website')

@section('end_head')
<style>
    .pricing_duration{
        display: inline-block;
        margin: 10px auto;
        background-color: #E3E3E3;
        border-radius: 15px;
    }
    .pric-duration{
        position: relative;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .pric-duration .pricing_btn > input.hidden_input{
        appearance: none;
        display: none;
    }
    .pric-duration .pricing_btn > label{
        font-size: 1.3rem;
        text-transform: capitalize;
        text-align: center;
        cursor: pointer;
        font-weight:bold;
        padding: 14px 50px;
        display: inline-block;
        transition: all 300ms ease;
    }
    .pric-duration .pricing-type:nth-child(1) label{
        border-radius: 15px 0 0 15px;
    }
    .pric-duration .pricing-type:nth-child(2) label{
        border-radius: 0 15px 15px 0;
    }
    .pric-duration .pricing_btn > input.hidden_input:checked + label {
        color: rgba(255, 255, 255, 1);
        background: rgba(27, 144, 18, 1);
    }
    .pricing-banner img{
        width: 500px;
    }


</style>
@endsection

@section('content')
{{-- Banner Section --}}
<section id="banner">
    <div class="py-5 position-relative bg-dots">
        <div class="banner_bg pt-4">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-5 order-lg-2">
                        <div class="pricing-banner">
                            <img src="{{ asset('assets/website/images/pricing/pricing-banner.png') }}" class="img-fluid" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6 mb-5 mb-lg-0 order-lg-1">
                        <div class="banner-block pe-xl-5">
                            <h5 class="mb-4 text-uppercase h2 font-900 color-primary">The Pricing Plan That Doesn't Need Comparison To Rethink</h1>
                            <h5 class="mb-4 text-uppercase font-600">CURATED TO TACKLE YOUR BUSINESS MARKETING NEED</h5>
                            <p>Reach a wide range of audiences, find qualified leads and start making sales with MouthPublicity.io. Choose the plan and grow your business relatively more than your traditionally marketing methods with MouthPublicity.io.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</section>

{{--pricing--}}
<section id="_plans_">
    <div class="container">
        <div class="text-center mb-5 py-5">
            
            <div class="pricing-details">
                <h4 class="text-uppercase h2 font-800 mb-3">buy yearly and save 20%</h4>
                <h6 class="mx-auto mb-0" style="max-width:850px;">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim</h6>

                <div class="pricing_duration my-5">
                    <div class="pric-duration">

                        @foreach($plans as $plan)
                            <div class="pricing-type">
                                <div class="pricing_btn">
                                    <input type="radio" class="hidden_input" id="{{ $plan->slug }}" value="{{ $plan->slug }}" name="billing_type" @if($plan->is_default == 1) checked @endif>
                                    <label for="{{ $plan->slug }}">{{ $plan->name }}</label>
                                </div>
                            </div>
                            @php
                                if($plan->is_default == 1){
                                    $plan_slug = $plan->slug;
                                }
                            @endphp
                        @endforeach
                    </div>
                </div>
                
                <div class="d-flex flex-wrap gap-3 justify-content-center">
                    @foreach($groups as $group)
                        {{-- If Amount is greater than 0 then amount shown as number --}}
                        @if ($pricing_data[$plan_slug][$group->slug]['total_price'] > 0)
                        <div style="width: 300px;" class="plan_groups mb-4" id="{{ $group->slug }}">
                            <div class="pricing-card card h-100">
                                <div class="card-header">
                                    <h4 class="text-capitalize text-white mb-0 font-600 h5 py-1">{{ $group->name }}</h4>
                                </div>
                                <div class="card-body p-0">
                                    <div class="p-3">
                                        <p class="text-uppercase small font-600 mb-0">ONLY AT</p> 
                                        <h4 class="h3 my-2 font-700 color-primary">
                                            <span class="text-secondary font-small me-2 font-600 text-decoration-line-through">&#8377;<span id="{{ $group->slug }}_monthly_total">{{ $pricing_data[$plan_slug][$group->slug]['mothly_total_price'] }}</span></span> 
                                            <span>&#8377;<span id="{{ $group->slug }}_monthly_payable">{{ $pricing_data[$plan_slug][$group->slug]['mothly_payble_price'] }}</span></span>/-
                                        </h4>
                                        <p class="text-uppercase small font-600 mb-0">PER MONTH</p>
                                    </div>
                                    <div class="px-4">
                                        @php $employee_count = 1 /* Default set */ @endphp

                                        @foreach($group->channels as $channel)
                                        <h6 class="pricing-features-list small">{{ $channel->channel_info->name }}</h6>
                                        @if ($channel->channel_info->free_employee > 0)
                                            @php $employee_count = $channel->channel_info->free_employee @endphp
                                        @endif
                                        @endforeach
                                        <h6 class="pricing-features-list">{{$employee_count}} Employee(s)</h6>
                                        <h6 class="pricing-features-list">1000 Messages</h6>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <div>
                                        <span class="badge bg-danger mb-2"><span id="{{ $group->slug }}_discount">{{ $pricing_data[$plan_slug][$group->slug]['discount'] }}</span>% OFF</span>
                                    </div>
                                    <p class="font-small text-secondary mb-2">Payable amount is 
                                        <span class="text-decoration-line-through">&#8377;<span id="{{$group->slug}}_total">{{ $pricing_data[$plan_slug][$group->slug]['total_price'] }}</span></span> 
                                        <span class="font-700">&#8377;<span id="{{ $group->slug }}_payable">{{ $pricing_data[$plan_slug][$group->slug]['payble_price'] }}</span></span> 
                                    </p>
                                    <button class="btn btn-primary-ol btn-lg w-100 sendto-checkout proceed-to-checkout" id="{{ $group->slug }}">Buy Now</button>
                                </div>
                            </div>
                        </div>
                        
                        
                        {{-- if amount is 0 or less then FREE word shown on amount place --}}
                        @else
                            <div style="width: 300px;" class="plan_groups mb-4" id="{{ $group->slug }}">
                                <div class="pricing-card card h-100">
                                    <div class="card-header">
                                        <h4 class="text-capitalize text-white mb-0 font-600 h5 py-1">{{ $group->name }}</h4>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="p-3">
                                            <p class="text-uppercase small font-600 mb-0">LIFETIME</p> 
                                            <h4 class="h3 my-2 font-700 color-primary">
                                                {{-- <span class="text-secondary font-small me-2 font-600 text-decoration-line-through">&#8377;<span id="{{ $group->slug }}_monthly_total">{{ $pricing_data[$plan_slug][$group->slug]['mothly_total_price'] }}</span></span>  --}}
                                                <span>FREE</span>
                                            </h4>
                                            <p class="text-uppercase small font-600 mb-0">OF COST</p>
                                        </div>
                                        <div class="px-4">
                                            @foreach($group->channels as $channel)
                                            <h6 class="pricing-features-list small">{{ $channel->channel_info->name }}</h6>
                                            @endforeach
                                            <h6 class="pricing-features-list small">50 Messages</h6>
                                        </div>
                                    </div>
                                    <div class="p-3">
                                        <p class="font-small text-secondary mb-2">Payable amount is 
                                            <span class="font-700">&#8377; 0</span>
                                        </p>
                                        <!-- <button class="btn btn-primary-ol btn-lg w-100 sendto-checkout proceed-to-checkout" id="{{ $group->slug }}">Get Started</button> -->
                                        <a class="btn btn-primary-ol btn-lg w-100" href="{{url('signin?tab=register')}}">Get Started</a>
                                    </div>
                                </div>
                            </div>

                        @endif
                    @endforeach
                </div>
                
            </div>
        </div>
    </div>
</section>

{{--commen questions--}}
<section id="common-questions">
    <div class="bg-light">
        <div class="container">
            <div class="py-5">
                <h4 class="text-center h2 font-600">Common Questions</h4>
                <div class="row mt-5 justify-content-center">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5">
                        <h5 class="font-700 mb-3">Can I use MouthPublicity.io for free?</h5>
                        <p>Yes, you can use MouthPublicity.io for free. We have some features that can be used free of cost.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5 mt-md-0">
                        <h5 class="font-700 mb-3">Can I unsubscribe from MouthPublicity.io? Will I get a refund?</h5>
                        <p>Yes, you can cancel your plan any time but you will only get a refund according to our terms and conditions.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">Can I use MouthPublicity.io on a mobile?</h5>
                        <p>Yes, you can use MouthPublicity.io via mobile on both android and iOS.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">Do I need a software developer to use MouthPublicity.io?</h5>
                        <p>No, you don't need to have any expertise to use MouthPublicity.io. It is an easy-to-use and user-friendly software that can be used by anyone. If you have any doubts just watch the tutorials or you can contact the support team.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">Will my data be safe if I scan the QR code?</h5>
                        <p>Yes, your data will be absolutely safe. We have a strict privacy policy that doesn't allow your details to be shared.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">How can I renew my plan after its validity expires?</h5>
                        <p>Login to your MouthPublicity.io account. Click on the option to Buy/Renew/Recharge in our dashboard. You can renew the plan from this section.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">Can I use MouthPublicity.io without having an internet connection?</h5>
                        <p>No, you need to have an internet connection to use MouthPublicity.io.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">Through how many modes can I make the payment?</h5>
                        <p>You can pay using your debit /credit card, net banking, and UPI. We accept all kinds of payments done through online mode.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">Do I need to have billing software to use MouthPublicity.io?</h5>
                        <p>No, it is not necessary for you to have billing software to use MouthPublicity.io. Most of the features don't require you to have billing software.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">I have more questions. How can I ask them?</h5>
                        <p>If you have more questions you can send them to care@mouthpublicity.io or you can contact our support team at 7887882244.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="loader-overlap" style="display: none;" id="loader">
    <div class="d-flex flex-column h-100 align-items-center justify-content-center">
        <div class="spinner-border text-white" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

@endsection

@push('js')
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
@endpush

@push('end_body')
    @include('website.scripts.pricing-js')
@endpush