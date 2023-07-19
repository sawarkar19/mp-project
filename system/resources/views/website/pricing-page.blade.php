@extends('layouts.website')

@section('end_head')
<style>
    .view_pricing_btn{
        width: 17.5rem;
        max-width: 100%;
    }
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
    .pricing-details .card{
        border-radius: 1rem;
        border: transparent;
        background: rgba(255, 255, 255, 1);
        box-shadow: 0px 0px 32px #00000029;
    }
    .card-head-bg{
        background: rgba(0, 0, 0, 1);
        border-radius: 1rem 1rem 0 0;
    }
    .top-line{
        border-top: 1px solid #E3E3E3;
    }
    .buy-btn-green{
        background: #0E7900 linear-gradient(#9FD183 20%, #0F7C01 100%) 0% 0% no-repeat padding-box;
        border-radius: 1.3rem;
        width: 350px;
        max-width: 100%;
        font-size: 1.7rem;
    }
    .com-que-bg{
        background: rgba(247, 249, 250, 1);
    }
</style>
@endsection

@section('content')
{{-- Banner Section --}}
<section id="banner">
    <div class="pt-5 position-relative">
        <div class="banner_bg pt-4">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-5 order-lg-2">
                        <div class="">
                            <img src="assets/images/home-banner.svg" class="img-fluid" alt="The Pricing Plan">
                        </div>
                    </div>
                    <div class="col-lg-6 mb-5 mb-lg-0 order-lg-1">
                        <div class="banner-block pe-xl-5">
                            <h5 class="mb-5 text-capitalize h2 font-900 color-primary">The Pricing Plan That Doesn’t Need Comparison To Rethink</h1>
                            <h5 class="mb-4 text-uppercase font-600">CURATED TO TACKLE YOUR BUSINESS MARKETING NEED</h5>
                            <p>Reach a wide range of audiences, find qualified leads and start making sales with OPENLINK. Choose the plan and grow your business relatively more than your traditionally marketing methods with OPENLINK.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</section>

{{--pricing--}}
<section id="pricing">
    <div class="container">
        <div class="text-center mb-5 py-5">
            <div class="pricing_duration mb-5">
                <div class="pric-duration">
                    <div class="pricing-type">
                        <div class="pricing_btn">
                            <input type="radio" class="hidden_input" id="monthly" value="monthly" name="pricing_type" >
                            <label for="monthly">Monthly</label>
                        </div>
                    </div>
                    <div class="pricing-type">
                        <div class="pricing_btn">
                            <input type="radio" class="hidden_input" id="yearly" value="yearly" name="pricing_type"  checked >
                            <label for="yearly">Yearly</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pricing-details">
                <h4 class="text-uppercase h2 font-700 mb-3">BUY YEARLY AND SAVE 20%</h4>
                <h6 class="mx-auto" style="max-width:850px;">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim</h6>
                <div class="card mx-auto mt-5" style="max-width: 350px;">
                    <div class="card-head-bg p-3">
                        <h4 class="text-uppercase text-white mb-0 font-600">PREMIUM PLAN</h4>
                    </div>
                    <div class="card-body px-5">
                        <p class="text-uppercase mb-0">ONLY AT</p> 
                        <h4 class="h1 my-2 font-900" style="color: rgba(27, 144, 18, 1); font-family:'Roboto Slab', serif;">1598/-</h4>
                        <p class="text-uppercase mb-0">PER MONTH</p>
                        <div class="my-4">
                            <h6 class="text-capitalize top-line py-3 mb-0">Messaging API Integration</h6>
                            <h6 class="text-capitalize top-line py-3 mb-0">Social Media Posting</h6>
                            <h6 class="text-capitalize top-line py-3 mb-0">Personalized Greeting</h6>
                            <h6 class="text-capitalize top-line py-3 mb-0">Offers Widgets & Templates</h6>
                            <h6 class="text-capitalize top-line py-3 mb-0">2 Employee Pannel</h6>
                            <h6 class="text-capitalize top-line py-3 mb-0">1000 Free messages With client</h6>
                            <h6 class="text-capitalize top-line py-3 mb-0">(SMS + Whatsapp)</h6>
                            <h6 class="text-capitalize top-line py-3 mb-0">Analyatics & Reporting</h6>
                            <h6 class="text-capitalize top-line py-3 mb-0">Instant Reward</h6>
                            <h6 class="text-capitalize top-line py-3 mb-0" style="border-bottom: 1px solid #E3E3E3;">Share & reward</h6>
                        </div>
                    </div>
                </div>
                <div class="my-5">
                    <button class="btn px-5 py-3 text-uppercase text-white font-800 buy-btn-green">Buy now</button> 
                </div>
            </div>
        </div>
    </div>
</section>
{{--commen questions--}}
<section id="common-questions">
    <div class="com-que-bg">
        <div class="container">
            <div class="py-5">
                <h4 class="text-center h2 font-600">Common Questions</h4>
                <div class="row mt-5 justify-content-center">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5">
                        <h5 class="font-700 mb-3">Can I use OPENLINK for free?</h5>
                        <p>Yes, you can use OPENLINK for free. We have some features that can be used free of cost.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5 mt-md-0">
                        <h5 class="font-700 mb-3">Can I unsubscribe from OPENLINK? Will I get a refund?</h5>
                        <p>Yes, you can cancel your plan any time but you will only get a refund according to our terms and conditions.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">Can I use OPENLINK on a mobile?</h5>
                        <p>Yes, you can use OPENLINK via mobile on both android and iOS.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">Do I need a software developer to use OPENLINK?</h5>
                        <p>No, you don’t need to have any expertise to use OPENLINK. It is an easy-to-use and user-friendly software that can be used by anyone. If you have any doubts just watch the tutorials or you can contact the support team.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">Will my data be safe if I scan the QR code?</h5>
                        <p>Yes, your data will be absolutely safe. We have a strict privacy policy that doesn’t allow your details to be shared.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">How can I renew my plan after its validity expires?</h5>
                        <p>Login to your OPENLINK account. Click on the option to Buy/Renew/Recharge in our dashboard. You can renew the plan from this section.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">Can I use OPENLINK without having an internet connection?</h5>
                        <p>No, you need to have an internet connection to use OPENLINK.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">Through how many modes can I make the payment?</h5>
                        <p>You can pay using your debit /credit card, net banking, and UPI. We accept all kinds of payments done through online mode.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">Do I need to have billing software to use OPENLINK?</h5>
                        <p>No, it is not necessary for you to have billing software to use OPENLINK. Most of the features don’t require you to have billing software.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 mt-5">
                        <h5 class="font-700 mb-3">I have more questions. How can I ask them?</h5>
                        <p>If you have more questions you can send them to care@openlink.co.in or you can contact our support team at 7887882244.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection