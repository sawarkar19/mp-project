@extends('layouts.front')

@section('title', 'How much does OpenChallenge Cost? | OpenChallenge Pricing')
@section('description', 'Choose OpenChallenge pricing plans as per your business requirement and grow your brand trust relatively more than any marketing channel.')
@section('keywords', 'OpenChallenge costing, OpenChallenge pricing plans')


@section('end_head')

<style>
    .price-card{
        position: relative;
        height: 100%;
    }
    .price-card .price-card-inner{
        position: relative;
        height: 100%;
        padding: 24px 24px 48px;
        box-shadow: rgb(0 0 0 / 8%) 0px 2px 4px 0px;
        -webkit-box-shadow: rgb(0 0 0 / 8%) 0px 2px 4px 0px;
        border-radius: 1.5rem;
        border: 1px solid rgb(218, 222, 224);
        background: rgb(255, 255, 255);
        transition: all 0.2s ease-out 0s;
        display: flex;
        flex-flow: column nowrap;
        width: 100%;
        box-sizing: border-box;
        justify-content: space-between;
    }
    .price-card:hover .price-card-inner{
        transform: translateY(-0.1875rem);
        box-shadow: rgb(50 50 93 / 10%) 0px 1.125rem 2.1875rem, rgb(0 0 0 / 7%) 0px 0.5rem 0.9375rem;
        -webkit-box-shadow: rgb(50 50 93 / 10%) 0px 1.125rem 2.1875rem, rgb(0 0 0 / 7%) 0px 0.5rem 0.9375rem;
    }

    .btn-price{
        color: var(--color-thm-lth);
        font-family: var(--font-h1);
        font-weight: 500;
        padding: .5rem 1.5rem;
        border: 1px solid var(--color-thm-lth);
        border-radius: 10px;
        background-color: transparent;
        transition: 0.5s;
    }
    .btn-price:hover{
        color: #FFF;
        background-color: var(--color-thm-lth);
    }


    .price-card .price-card-inner.plan-tag{
        background: rgba(0,255,175,0.2);
        background: linear-gradient(316deg,rgba(0,255,175,0.2) 2%, rgba(0,36,156,0.2) 100%);
        background: -webkit-linear-gradient(316deg,rgba(0,255,175,0.2) 2%, rgba(0,36,156,0.2) 100%);
        background: -moz-linear-gradient(316deg,rgba(0,255,175,0.2) 2%, rgba(0,36,156,0.2) 100%);
    }
    .price-card .price-card-inner.plan-tag::before{
        content: attr(tag-name);
        padding: 2px 10px;
        border-radius: 15px;
        /* background-color: rgb(122, 219, 255); */
        text-transform: uppercase;
        font-size: 10px;
        font-weight: bold;
        color: #FFF;
        display: inline;
        position: absolute;
        top: -0.8125rem;

        background: var(--color-thm-lth);
    }
    .price-card .price-card-inner.plan-tag .btn-price{
        background-color:var(--color-thm-lth);
        color: #FFF;
    }
    .main-bc{
        /* width: 100%;
        max-width: 600px; */
        display: inline-block;
        margin: 10px auto;
        /* padding:5px; */
        background-color: #f8f8f8;
        border-radius: 50px;
    }
    .bill_cycle{
        position: relative;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .bill_cycle .bc_type{
        padding: 8px;
    }
    .bill_cycle .bc_radio_btn > input.hidden_input{
        appearance: none;
        display: none;
    }
    .bill_cycle .bc_radio_btn > label{
        font-size: 14px;
        font-family: var(--font-h1);
        text-transform: capitalize;
        text-align: center;
        cursor: pointer;
        border-radius: 40px;
        padding: 5px 20px;
        display: inline-block;
        background-color: #ffffff;
        transition: all 300ms ease;
    }
    .bill_cycle .bc_radio_btn > input.hidden_input:checked + label {
        background: #00ffaf;
        background: linear-gradient(64deg,#00ffaf 0%, #00249c 80%);
        background: -webkit-linear-gradient(64deg,#00ffaf 0%, #00249c 80%);
        background: -moz-linear-gradient(64deg,#00ffaf 0%, #00249c 80%);

        color: #FFF;
    }
    .pr_row{
        position: relative;
        display: flex;
        flex-direction: row;
        justify-content: center;
        flex-wrap: wrap;
    }
    .pr_row .pr_columns{
        position: relative;
        max-width: 330px;
        padding: 0 .5rem;
    }
</style>

@endsection

@section('content')
<section id="pricing_">
    <div class="py-5 position-relative">
        <div class="container">
            <div class="">
                <a href="{{ url('') }}" ><img src="{{ asset('assets/front/images/logo-dark.svg') }}" class="main_logo" alt="OpenChallenge"></a>
            </div>
            <div class="py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-9">
                        <div class="text-center">
                            <h1 class="oplk-text-gradient"><strong>Endless Marketing Plan!</strong></h1>
                            <p class="text-muted">Reach a wide range of audiences, find qualified leads and start making sales with OpenChallenge. Choose the plan and grow your business relatively more than your traditionally marketing methods with OpenChallenge.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- header end -->
        </div>
        
        {{-- Plan Selection --}}
        <div class="container">
            <div>
                <div class="text-center">
                    <p class="h6">Please select the billing cycle</p>
                </div>
                <div class="text-center mb-5">
                    <div class="main-bc">
                        <div class="bill_cycle">

                        @foreach($plans as $plan)

                            <div class="bc_type">
                                <div class="bc_radio_btn">
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
                </div>
            </div>
        </div>


        <div class="container">
            <div id="_plans_">
                <div class="pr_row">

                    @foreach($groups as $group)

                    <div class="pr_columns plan_groups"  id="{{ $group->slug }}">
                        <div class="price-card">
                            <div class="price-card-inner plan-tag" tag-name={{ $group->tag }}>
                                <div class="title">
                                    <h3 class="mb-0 font-600 plan_name">{{ $group->name }}</h3>
                                </div>
                                <div class="price mb-4">
                                    
                                    <p>&#8377; <span id="{{ $group->slug }}_total">{{ $pricing_data[$plan_slug][$group->slug]['total_price'] }}</span></p>

                                    <p>&#8377; <span id="{{ $group->slug }}_payable">{{ $pricing_data[$plan_slug][$group->slug]['payble_price'] }}</span></p>

                                    <p>&#8377; <span id="{{ $group->slug }}_monthly_total">{{ $pricing_data[$plan_slug][$group->slug]['mothly_total_price'] }}</span></p>

                                    <p>&#8377; <span id="{{ $group->slug }}_monthly_payable">{{ $pricing_data[$plan_slug][$group->slug]['mothly_payble_price'] }}</span></p>

                                    <p>&#8377; <span id="{{ $group->slug }}_discount">{{ $pricing_data[$plan_slug][$group->slug]['discount'] }}%</span></p>
                                    
                                    
                                </div>
                                <div class="flists">
                                    <ul class="features_list" style="list-style: none;padding-left: 0px;">

                                    @foreach($group->channels as $channel)

                                        <li><i class="bi bi-check text-success"></i> {{ $channel->channel_info->name }}</li>

                                    @endforeach
                                        
                                    </ul>
                                </div>
                                <div class="button">
                                    <button class="btn btn-price w-100 sendto-checkout text-uppercase proceed-to-checkout" id="{{ $group->slug }}">Buy Now</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach

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

@section('end_body')
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    @include('front.pricing-js')
@endsection