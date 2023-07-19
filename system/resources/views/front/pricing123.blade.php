@extends('layouts.front')

@section('title', 'How much does OpenChallenge Cost? | OpenChallenge Pricing')
@section('description', 'Choose OpenChallenge pricing plans as per your business requirement and grow your brand trust relatively more than any marketing channel.')
@section('keywords', 'OpenChallenge costing, OpenChallenge pricing plans')
{{-- @section('image', '') --}}

@section('end_head')
    <style>
        .price_card.active {
            overflow: hidden;
            position: relative;
            box-shadow: 0px 1px 8px rgb(0 0 0 / 7%);
            -webkit-box-shadow: 0px 1px 8px rgb(0 0 0 / 7%);
            /* transform: scale(1.05); */
            border: 1px solid var(--color-thm-lth);
        }
        .price_card.active::after{
            content: "Pro";
            position: absolute;
            width: 100px;
            background-color: var(--color-thm-lth);
            font-size: 14px;
            text-transform: uppercase;
            padding: 6px 15px;
            line-height: 1;
            color: #ffffff;
            font-weight: 500;
            font-family: var(--font-h1);
            top: 12px;
            left: -25px;
            transform: rotate(315deg);
            z-index: 1;
            letter-spacing: 1px;
        }
        /*.price_card.active::after{
            content: "Recommended";
            position: absolute;
            background-color: var(--color-thm-lth);
            font-size: 11px;
            text-transform: uppercase;
            padding: 6px 15px;
            line-height: 1;
            color: #fff;
            top: 0;
            left: 50%;
            z-index: 1;
            border-radius: 0px 0px 4px 4px;
            transform: translateX(-50%);
        }*/
    </style>
@endsection
@section('content')
<section id="pricing">

    <span class="splashes dots-color-bottom"></span>
    <div class="py-5">
        <div class="container">

            <div class="mb-4">
                <a href="{{ url('') }}" ><img src="{{ asset('assets/front/images/logo-dark.svg') }}" class="main_logo" alt="OpenChallenge"></a>
            </div>
            <div class="my-5 pb-lg-5">
                <div class="row justify-content-center align-items-center">
                    <div class="col-xl-4_ col-lg-6 order-lg-2">
                        <div class="support">
                            <div class="mb-5 text-lg-end_">
                                <h1 class="oplk-text-gradient"><strong>Endless Marketing Plan!</strong></h1>
                                <h4 class="fw-bolder text-uppercase">We are always here</h4>
                                <p class="text-muted">Reach a wide range of audiences, find qualified leads and start making sales with OpenChallenge.</p>
                                <p class="text-muted">Choose the plan as per your business requirement and grow your business relatively more than your traditionally marketing methods with OpenChallenge.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 order-lg-1" >
                        <div class="text-center">
                            <img src="{{ asset('assets/front/images/pricing.svg') }}" class="w-100" style="max-width:350px" alt="OpenChallenge Support">
                        </div>
                    </div>
                    
                </div>
            </div>

            <div>
                <div class="row justify-content-center">
                    @foreach($plans as $plan)
                    <div class="col-md-6 col-xl-4">
                        <div class="card price_card @if($plan->featured  == 1){{ 'active' }}@endif">
                            <div class="card-body">
                                <div class="title">
                                    <h3>{{ $plan->name }}</h3>
                                    <h2>&#8377; {{ $plan->price }}/<span>@if($plan->days == 365){{ 'year' }}@else{{ 'month' }}@endif</span> </h2>
                                </div>
                                <div class="tagln">
                                    <p>Unlimited customers per month</p>
                                </div>
                                <div class="flists">
                                    <ul class="features_list">
                                        <li>
                                            <i class="bi bi-check"></i>
                                            @if($plan->future_limit >= 100)
                                            {{ "Unlimited" }}
                                            @elseif($plan->future_limit >= 50)
                                            {{ "50+" }}
                                            @elseif($plan->future_limit >= 10)
                                            {{ "10+" }}
                                            @else
                                            {{ $plan->future_limit }}
                                            @endif
                                            Cash Per Click Offer
                                        </li>

                                        <li>
                                            <i class="bi bi-check"></i>
                                            @if($plan->future_limit >= 100)
                                            {{ "Unlimited" }}
                                            @elseif($plan->future_limit >= 50)
                                            {{ "50+" }}
                                            @elseif($plan->future_limit >= 10)
                                            {{ "10+" }}
                                            @else
                                            {{ $plan->future_limit }}
                                            @endif
                                            Fixed Amount Offer
                                        </li>

                                        <li>
                                            <i class="bi bi-check"></i>
                                            @if($plan->future_limit >= 100)
                                            {{ "Unlimited" }}
                                            @elseif($plan->future_limit >= 50)
                                            {{ "50+" }}
                                            @elseif($plan->future_limit >= 10)
                                            {{ "10+" }}
                                            @else
                                            {{ $plan->future_limit }}
                                            @endif
                                            Percentage Offer
                                        </li>
                                        <li>
                                            <i class="bi bi-check"></i>
                                            @if($plan->instant_limit >= 100)
                                            {{ "Unlimited" }}
                                            @elseif($plan->instant_limit >= 50)
                                            {{ "50+" }}
                                            @elseif($plan->instant_limit >= 10)
                                            {{ "10+" }}
                                            @else
                                            {{ $plan->instant_limit }}
                                            @endif
                                            Instant Tasks
                                        </li>

                                        <li>
                                            <i class="bi bi-check"></i>
                                            Unlimited Draft Offer
                                        </li>
                                        <li>
                                            <i class="bi bi-check"></i>
                                            @if($plan->employee_limit==0)
                                            {{ 'No Employee' }}
                                            @else
                                            {{ $plan->employee_limit.' Employees' }} & 
                                            @endif
                                            Dashboard
                                        </li>
                                        <li>
                                            <i class="bi bi-check"></i>
                                            @if($plan->redeem_limit >= 100)
                                            {{ "Unlimited" }}
                                            @elseif($plan->redeem_limit >= 50)
                                            {{ "50+" }}
                                            @elseif($plan->redeem_limit >= 10)
                                            {{ "10+" }}
                                            @else
                                            {{ $plan->redeem_limit }}
                                            @endif
                                            Time Redeem / Month
                                        </li>
                                        <li><i class="bi bi-check"></i>
                                            @if($plan->support_limit == 'email_chat_call')
                                            {{ 'Online support 24*7' }}
                                            @else
                                            Limited (@if($plan->support_limit == 'email_chat'){{ "Emails & Chat" }}@else{{ $plan->support_limit }}@endif support)
                                            @endif
                                        </li>
                                        <li>
                                            <i class="bi bi-check"></i>
                                            @if($plan->statistic_limit == 'full')
                                                {{ 'Full Dashboard' }}
                                            @else
                                                {{ 'Limited' }}
                                            @endif
                                            Statistics
                                        </li>
                                        <li>
                                            <i class="bi bi-check"></i>
                                            @if($plan->template_limit >= 10)
                                            {{ "10+" }}
                                            @elseif($plan->template_limit >= 50)
                                            {{ "50+" }}
                                            @elseif($plan->template_limit >= 100)
                                            {{ "Unlimited" }}
                                            @endif
                                            Offer Templates
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <button class="btn btn-theme px-4 btn-sm set-price" id="plan{{ $plan->id }}">Subscribe Now</button>
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
@endsection
@section('end_body')
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).on('click', '.set-price', function(){
                var btn = $(this);
                var auth = '{{ Auth::User() }}';
                if(auth){
                    window.location.href = "{{ route('business.plan') }}";
                    return;
                }
                console.log(btn)
                var plan_id = btn.attr('id').substr(4);
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                console.log(plan_id);
                if(plan_id){
                    $.ajax({
                        /* the route pointing to the post function */
                        url: '{{ route('setPlan') }}',
                        type: "post",
                        /* send the csrf-token and the input to the controller */
                        data: {
                            _token: CSRF_TOKEN,
                            plan_id: plan_id
                        },
                        dataType: 'JSON',
                        beforeSend: function() {
                            
                            btn.attr('disabled','')
                            btn.html('Please Wait....')

                        },
                        /* remind that 'data' is the response of the AjaxController */
                        success: function (data) {
                            btn.removeAttr('disabled')
                            btn.html('Subscribe Now')
                            if(data.price == '0'){
                                window.location.href = "{{ route('login').'?tab=register' }}";
                            }else{
                                window.location.href = "{{ route('checkout') }}";
                            }
                        }
                    });
                }                    
            });
        })
    </script>
@endsection