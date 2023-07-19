@extends('layouts.front')

@section('title', 'Why you should go for OPENLINK | OpenLink ')
@section('description', 'OpenLink gets you more customers by incentivizing recommendations, exponentially grows your business brand trust  & social media presence. ')
@section('keywords', 'why openlink, what is openlink, mission of openlink, about us open link')
{{-- @section('image', '') --}}

@section('end_head')
    <style>
    .create:before{
        content: "";
        display: block;
        background: linear-gradient(-90deg, var(--color-thm-lth) -15%, var(--color-thm-drk) 115%);
        width: 15%;
        height: 70px;
        /*float: left;*/
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        z-index: -1;
    }
    @media(max-width: 767px){
        .create:before{
            top: 1px;
            transform: translateY(0%);
        }
    }
    .reach{
        position: relative;
    }
    .reach::before{
        content: "";
        position: absolute;
        top: 94px;
        left: 50%;
        height: calc(100% - 94px);
        margin-left: -3px;
        width: 6px;
        background:-webkit-linear-gradient(-90deg, var(--color-thm-lth) -15%, var(--color-thm-drk) 115%);
        width: 3px;
        border-radius: 4px;
    }
    .circle{
        background: -webkit-linear-gradient(-90deg, var(--color-thm-lth) -15%, var(--color-thm-drk) 115%);
        width: 200px;
        height: 200px;
        border-radius: 50%;
        padding: 3px;
        display: block;
    }
    .incircle{
        background: #ffffff;
        width: 194px;
        height: 194px;
        border-radius: 50%;
        display: block;
    }
    .matter1{

        position: relative;
    }
    .hrline{
        position: absolute;
        top: 94px;
        left: 197px;
        width: calc(3rem + 13px);
        height: 3px;
        box-sizing: border-box;
        /*border: 6px solid #000;
        border-color: transparent transparent #fff #fff;*/
        background: -webkit-linear-gradient(-90deg, var(--color-thm-lth) -15%, var(--color-thm-drk) 115%);
        border-radius: 4px 0px;
    }
    .bggradient{
        background: -webkit-linear-gradient(-90deg, var(--color-thm-lth) -15%, var(--color-thm-drk) 115%);
    }
    .bggradient h3{
        color: #ffffff;
    }
    .cb-1 {
        position:relative;
        /* margin:1em; */
        /* height: 100%; */
    }
    .cb-1:first-child:before {
        content:'';
        position:absolute;
        width:100%;
        height:6px;
        background:linear-gradient(-90deg, var(--color-thm-lth) -8%, var(--color-thm-drk) 140%);
        top:-3px;
        left:0;
    }
    .cb-1.card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.05), 0 6px 20px 0 rgba(0, 0, 0, 0.05);
    }

    .quote{
        position: relative;
    }
    .quote-back{
        transform: rotate(180deg);

    }  
    .h-b2{
        padding: 0.5rem 5.5rem;
        background: linear-gradient(-90deg, var(--color-thm-lth) -15%, var(--color-thm-drk) 115%);
    }

    .tab-flow{
        text-align: right;
        padding-right: 3rem;
    }



    @media(min-width: 992px){
        .tab-flow.righ-side{
            text-align: left;
            padding-left: 3rem;
            padding-right: 0rem;
        }
        .tab-flow.righ-side .hrline{
            left: calc(-3rem + -13px);
        }
    }

    @media(max-width: 991px){
        .tab-flow{
            text-align: left;
            padding-left: 1.5rem;
            padding-right: 1rem;
            margin-bottom: 3rem;
        }
        .hrline{
            width: calc(1.5rem + 1px);
            left: calc(-1.5rem + -1px);
        }

        .reach{
            position: relative;
        }
        .reach::before{
            top: 94px;
            left: 0%;
        }

    }
    @media(max-width: 545px){
        .circle{
            width: 150px;
            height: 150px;
            border-radius: 50%;
            padding: 3px;
            
        }
        .incircle{
            width: 144px;
            height: 144px;
            border-radius: 50%;
        }
        .hrline{
            width: calc(1.5rem + 3px);
            left: calc(-1.5rem + -1px);
            top: calc(94px + -15px);

        }
        .reach::before{
            top: 79px;
            left: 0%;
        }
        .h-1{
            margin-bottom: 0px;
        }
    }
    </style>
@endsection

@section('content')
<section id="Whyopenlink">
    <div class="pt-5">
      <!--   Logo section -->
        <div class="container">
            <div class="mb-4">
                <a href="{{ url('') }}" ><img src="{{ asset('assets/front/images/logo-dark.svg') }}" class="main_logo" alt="OpenLink"></a>
            </div>
        </div> 
        <!--  img and heading section -->
        <section>
            <div class="position-relative">
                {{-- <div class="create"></div> --}}
                    <div class="container">
                        <div class="row justify-content-center mb-5">
                            <div class="col-lg-12">
                                <div class="bg-white">
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col-md-5">
                                        <h1 class="fw-bold oplk-text-gradient d-inline-block py-4" style="font-size: 50px;">Why<br>OPENLINK?</h1>
                                        <p>It's time to grow with your customers, turn them into your Marketers, and connect with them on WhatsApp. It's time to go OPENLINK.</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('assets/front/images/why-ol/why-openlink-banner.svg') }}" class="w-100" alt="Why OPENLINK">
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </section>

        <!--   img and heading section -->
        <section>
            <div class="container">
                <div class="click  text-center py-5">
                    <h1 class="font-600">Just one click makes you reach !!</h1>
                    <p class="mb-3">Take your business to new heights with OPENLINK and reach your new customers with ease of one click. </p>
                </div>
                <div class="reach">
                    <!-- part1 -->
                    <div class="row">
                        <div class="col-lg-6">

                            <div class="tab-flow">
                                <div class="matter1 ms-auto d-inline-block mb-3">
                                    <div class="circle">
                                        <div class="incircle">
                                            <img src="{{ asset('assets/front/images/why-ol/save_your_billing_cost.svg') }}" class="w-100" alt="ave your billing cost" style="padding:25px 10px 10px 10px;"> 
                                        </div>
                                    </div>
                                    <div class="hrline"></div>
                                </div>
                                <div>
                                    <h5 class="">Save your SMS API costing</h5>
                                    <p class="">It’s time to save on your billing communication with customers. Integrate OPENLINKS WhatsApp API with your running billing software and send your billing updates with a business alert, notifications, or offers on customer's WhatsApp. All this at RS 1/Day. WhatsApp API also maintains your customer's history on WhatsApp chat for future and loyal customer reference.</p>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            
                        </div>
                    </div>
                    <!-- part1 -->
                    <!-- part2 -->
                    <div class="row">
                        <div class="col-lg-6 order-lg-2">
                            <div class="tab-flow righ-side">
                                <div class="matter1 ms-auto d-inline-block mb-3">
                                    <div class="circle">
                                        <div class="incircle py-4 px-4">
                                            <img src="{{ asset('assets/front/images/why-ol/more-customers-walking.png')}}" class="w-100" alt="More Customers Walking"> 
                                        </div>
                                    </div>
                                    <div class="hrline"></div>
                                </div>
                                <div>
                                    <h5>More Customers Walking</h5>
                                    <p>Create amazing offers for your customers with OPENLINK to attract your customers and share them with your existing customers. Let your offer create a buzz among the market and bring more customer walking to your business.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 order-lg-1">
                        </div>
                    </div>
                    <!-- part2 -->
                    <!-- part3 -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="tab-flow">
                                <div class="matter1 ms-auto d-inline-block mb-3">
                                    <div class="circle">
                                        <div class="incircle py-4 px-4">
                                            <img src="{{ asset('assets/front/images/why-ol/reach-customers-through-your-clients.png') }}" class="w-100" alt="Reach Customers through your Clients"> 
                                        </div>
                                    </div>
                                    <div class="hrline"></div>
                                </div>
                                <div>
                                    <h5>Reach Customers through your Clients</h5>
                                    <p>OPENLINK lets you connect with your new customers through your existing customers. Create your business link, share it with your existing customers, ask them to share the same piece of content in their network, and let them avail themselves of the benefits for making your business reach easy to new customers.</p>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            
                        </div>
                    </div>
                    <!-- part3 -->
                    <!-- part 4 -->
                    <div class="row">
                        <div class="col-lg-6 order-lg-2">
                            <div class="tab-flow righ-side">
                                <div class="matter1 ms-auto d-inline-block mb-3">
                                    <div class="circle">
                                        <div class="incircle py-4 px-4">
                                            <img src="{{ asset('assets/front/images/why-ol/boost-your-social-media-presence.png') }}" class="w-100" alt="Boost your social media presence"> 
                                        </div>
                                    </div>
                                    <div class="hrline"></div>
                                </div>
                                <div>
                                    <h5 class="">Boost your social media presence</h5>
                                    <p class="">OPENLINK helps in boosting your business's social media presence by simply creating an offer link and sharing it with customers. Let customers avail of the offer and in return follow you on your business social media accounts.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 order-lg-1">
                        </div>
                    </div>
                    <!-- part4 -->
                    <!-- part5 -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="tab-flow">
                                <div class="matter1 ms-auto d-inline-block mb-3">
                                    <div class="circle">
                                        <div class="incircle py-4 px-4">
                                            <img src="{{ asset('assets/front/images/why-ol/promote-your-business.png') }}" class="w-100" alt="Promote your Business"> 
                                        </div>
                                    </div>
                                    <div class="hrline"></div>
                                </div>
                                <div>
                                    <h5>Promote your content with Customised templates on WhatsApp</h5>
                                    <p>Design your promotional content in a more aesthetic way with an available WhatsApp template on OPENLINK, and share it with your personal contacts or customer base to get more visibility and brand reach.</p>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            
                        </div>
                    </div>
                    <!-- part 5 -->
                    <!-- part6 -->
                    <div class="row">
                        <div class="col-lg-6 order-lg-2">
                            <div class="tab-flow righ-side">
                                <div class="matter1 ms-auto d-inline-block mb-3">
                                    <div class="circle">
                                        <div class="incircle py-4 px-4">
                                            <img src="{{ asset('assets/front/images/why-ol/design-landing-pages-contest.png') }}" class="w-100" alt="Design Landing Pages, Contest"> 
                                        </div>
                                    </div>
                                    <div class="hrline"></div>
                                </div>
                                <div>
                                    <h5>Design Landing Pages, Contest & Giveaways in No Time</h5>
                                    <p>Have a business but no business website? No worries OPENLINK still makes your business reach process easy. Select the template available as per your business and design your own landing pages of offers, contests, giveaways, or any other content, create the link and share it with your customers without any hassle.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 order-lg-1">
                        </div>
                    </div>

                    <!-- part5 -->             
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="tab-flow">
                                <div class="matter1 ms-auto d-inline-block mb-3">
                                    <div class="circle">
                                        <div class="incircle">
                                            <img src="{{ asset('assets/front/images/why-ol/post_and_track.svg') }}" class="w-100" alt="post and track" style="padding: 47px 16px 10px 17px;
}"> 
                                        </div>
                                    </div>
                                    <div class="hrline"></div>
                                </div>
                                <div>
                                    <h5>Post and track at one time</h5>
                                    <p>Post your social media content in one click on all social media platforms like Facebook, Twitter, and LinkedIn. Just select the template, create your amazing content, post it through OPENLINK and keep eye on the clicks you get on it. OPENLINK shows you the analytics of each unique click on the post and that too is free.</p>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 order-lg-2">
                            <div class="tab-flow righ-side">
                                <div class="matter1 ms-auto d-inline-block mb-3">
                                    <div class="circle">
                                        <div class="incircle py-4 px-4"><img src="{{ asset('assets/front/images/why-ol/increase-your-brand-visibility.png') }}" class="w-100" alt="Increase Your Brand Visibility, Followers & Engagement"> 
                                        </div>
                                    </div>
                                    <div class="hrline"></div>
                                </div>
                                <div>
                                   <h5>Increase Your Brand Visibility, Followers & Engagement</h5>
                                    <p>Create the link with attractive content of your business and share it with your customers. Let your audience re-share the link in their network. You can add different calls to action in your link content, like website visits, the command to follow, or comment on your different social media platforms. </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 order-lg-1">
                        </div>
                    </div>
                    <!-- part6 -->  
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="tab-flow">
                                <div class="matter1 ms-auto d-inline-block mb-3">
                                    <div class="circle">
                                        <div class="incircle">
                                            <img src="{{ asset('assets/front/images/why-ol/send_bulk_msg.svg')}}" class="w-100" alt="send bulk msg" style="padding: 32px 13px 10px 13px"> 
                                        </div>
                                    </div>
                                    <div class="hrline"></div>
                                </div>
                                <div>
                                    <h5>Send bulk messages on WhatsApp</h5>
                                    <p>Customise your message with available templates in OPENLINK and send it to your customers with a click. OPENLINK facilitates WhatsApp bulk messaging to the customer base save in it.</p>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            
                        </div>
                    </div>
                    <!-- part7 -->
                    <div class="row">
                        <div class="col-lg-6 order-lg-2">

                            <div class="tab-flow righ-side">
                                <div class="matter1 ms-auto d-inline-block mb-3">
                                    <div class="circle">
                                        <div class="incircle py-4 px-4"><img src="{{ asset('assets/front/images/why-ol/turn-out-visitors-into-potential-customers.png')}}" class="w-100" alt="Turn out Visitors into Potential Customers">  
                                        </div>
                                    </div>
                                    <div class="hrline"></div>
                                </div>
                                <div>
                                     <h5>Turn out Visitors into Potential Customers</h5>
                                    <p>Convert each of your visitors into potential customers by offering them amazing benefits behind each purchase. Let your customer feel special every time they visit your store. Avail them small benefits and make their every visit-worthy.</p>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6 order-lg-1">
                            
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="tab-flow">
                                <div class="matter1 ms-auto d-inline-block mb-3">
                                    <div class="circle">
                                        <div class="incircle py-4 px-4">
                                            <img src="{{ asset('assets/front/images/why-ol/increase-sales-transactions.png') }}" class="w-100" alt="Increase Sales & Transactions"> 
                                        </div>
                                    </div>
                                    <div class="hrline"></div>
                                </div>
                                <div>
                                    <h5>Increase Sales & Transactions</h5>
                                    <p>Amazing offers indirectly increase the count of potential customers. Reach your potential customers with OPENLINK and grow your business sales and increase your revenue line.</p>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            
                        </div>
                    </div>

                    <!-- part8 -->  
                    <div class="row">
                        <div class="col-lg-6 order-lg-2">

                            <div class="tab-flow righ-side">
                                <div class="matter1 ms-auto d-inline-block mb-3">
                                    <div class="circle">
                                        <div class="incircle py-4 px-4">
                                            <img src="{{ asset('assets/front/images/why-ol/employee_manegment.svg') }}" class="w-100" alt="employee manegment"> 
                                        </div>
                                    </div>
                                    <div class="hrline"></div>
                                </div>
                                <div>
                                    <h5>Employee Management</h5>
                                    <p>Easily create your employee ids in OPENLINK. Give them access to it and let them manage all the offer sharing and offer availing processes at the billing counter. The employee does not have full access to OPENLINK Software. </p>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6 order-lg-1">
                            
                        </div>
                    </div>

                    <!-- part9 -->             
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="tab-flow">
                                <div class="matter1 ms-auto d-inline-block mb-3">
                                    <div class="circle">
                                        <div class="incircle py-4 px-4">
                                            <img src="{{ asset('assets/front/images/why-ol/reduce-your-marketing-cost-time.png') }}" class="w-100" alt="Reduce Your Marketing Cost & Time"> 
                                        </div>
                                    </div>
                                    <div class="hrline"></div>
                                </div>
                                <div>
                                     <h5>Reduce Your Marketing Cost & Time</h5>
                                    <p>OPENLINK gives you a wide-open platform to reach your audience in a single click. Plan out your business strategy, create the link with the customised template and share it with your customer without any hassle. Let your customer re-share and create a buzz for your business without wasting much time and money.</p>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            
                        </div>
                    </div>

                    <!-- part10 -->  
                    <div class="row">
                        <div class="col-lg-6 order-lg-2">

                            <div class="tab-flow righ-side">
                                <div class="matter1 ms-auto d-inline-block mb-3">
                                    <div class="circle">
                                        <div class="incircle">
                                            <img src="{{ asset('assets/front/images/why-ol/special_day.svg') }}" class="w-100" alt="Wish your customer on their special day" style="padding: 33px 14px 10px 14px;"> 
                                        </div>
                                    </div>
                                    <div class="hrline"></div>
                                </div>
                                <div>
                                    <h5>Wish your customer on their special day</h5>
                                    <p>Create a customised birthday or anniversary message for your customer with all the templates available over there. OPENLINK automatically fetches the customer data and sends them a Birthday/anniversary greeting from your side on their important days. This keeps the business and customer relationship happy and going. </p>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6 order-lg-1">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="tab-flow">
                                <div class="matter1 ms-auto d-inline-block mb-3">
                                    <div class="circle">
                                        <div class="incircle py-4 px-4">
                                            <img src="{{ asset('assets/front/images/why-ol/track-your-campaigns-dashboard.png') }}" class="w-100" alt="Track Your Campaigns in a Single Dashboard">  
                                        </div>
                                    </div>
                                    <div class="hrline"></div>
                                </div>
                                <div>
                                    <h5>Track Your Campaigns in a Single Dashboard</h5>
                                    <p>Create links for different offers and discounts, share them with your customers, and track links activity anytime anywhere on a single OPENLINK Dashboard. Run different campaigns at a time, track them on a single dashboard, and once the task behind a specific offer is completed, notify your customers to avail the offer they are eligible for.</p>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            
                        </div>
                    </div>                                                           
                    
                </div>
            </div>


            <!-- quote -->
            <div class="bggradient my-5"> 
                <div class="container">
                    <div class="row py-5 quote">
                        <div class="col-lg-1 align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#ffffff" class="bi bi-quote" viewBox="0 0 16 16">   
                                <path d="M12 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1h-1.388c0-.351.021-.703.062-1.054.062-.372.166-.703.31-.992.145-.29.331-.517.559-.683.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.322 3.322 0 0 0-1.085.992 4.92 4.92 0 0 0-.62 1.458A7.712 7.712 0 0 0 9 7.558V11a1 1 0 0 0 1 1h2Zm-6 0a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1H4.612c0-.351.021-.703.062-1.054.062-.372.166-.703.31-.992.145-.29.331-.517.559-.683.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.322 3.322 0 0 0-1.085.992 4.92 4.92 0 0 0-.62 1.458A7.712 7.712 0 0 0 3 7.558V11a1 1 0 0 0 1 1h2Z"/>
                            </svg>
                        </div>  
                        <div class="col-lg-12">
                            <blockquote class="blockquote d-block quote1 mb-0"> 
                                <h3 class="text-center font-500 text mb-0">It's time to grow with your customers and turn them into your Marketers.<br>IT'S TIME TO GO OPENLINK.</h3>
                            </blockquote> 
                        </div> 
                        <div class="col-12 text-end">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#ffffff" class="bi bi-quote quote-back" viewBox="0 0 16 16">   
                                <path d="M12 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1h-1.388c0-.351.021-.703.062-1.054.062-.372.166-.703.31-.992.145-.29.331-.517.559-.683.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.322 3.322 0 0 0-1.085.992 4.92 4.92 0 0 0-.62 1.458A7.712 7.712 0 0 0 9 7.558V11a1 1 0 0 0 1 1h2Zm-6 0a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1H4.612c0-.351.021-.703.062-1.054.062-.372.166-.703.31-.992.145-.29.331-.517.559-.683.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.322 3.322 0 0 0-1.085.992 4.92 4.92 0 0 0-.62 1.458A7.712 7.712 0 0 0 3 7.558V11a1 1 0 0 0 1 1h2Z"/>
                            </svg>
                        </div>     
                        
                    </div>
                </div>   
            </div>

            <!-- card  -->    
            <section class="">
                <div class="container">
                    <div class="row pt-5">
                        <div class="col-lg-12 text-center">
                            <h1 class="font-800">Who Uses Open Link?</h1>
                            <p>No matter what business you are running, all types of businesses around the world can use OPENLINK to power their campaigns. Each campaign can generate a result for your business.</p>
                        </div>
                    </div>

                    @php
                        $uses = array(
                            array(
                                'title' => 'Brands',
                                'text' => 'Brands can use OPENLINK in different ways to engage their existing audience, reach new customers & and turn them into potential customers. OPENLINK is the best platform for all brands. They can use OPENLINK to give new product giveaways, run sales, and coupon downloads.',
                                'link' => '#',
                            ),
                            array(
                                'title' => 'E-commerce site',
                                'text' => 'Different E-commerce businesses can use OPENLINK to create buzz, increase website visits and grow social media followers. E-commerce sites can also use OPENLINK to create flash sales or festive offers.',
                                'link' => '#',
                            ),
                            array(
                                'title' => 'Creators & Influencers',
                                'text' => 'Want to grow your audience network, increase your content views or drive engagement? OPENLINK has brought cover for you all. Want to run giveaways, grow your YouTube views, or social media followers, create content with OPENLINK and share it anytime, anywhere with customers.',
                                'link' => '#',
                            ),
                            array(
                                'title' => 'Agencies',
                                'text' => 'Market your single product and grow your Agency reach with OPENLINK. Being an agency audience network matters the most. Build complex campaigns in a minute and run them with OPENLINK anytime. With OPENLINK boost your audience reach with one link and share.',
                                'link' => '#',
                            ),
                            array(
                                'title' => 'Marketing teams',
                                'text' => 'Being a social or marketing team engaging users and growing the social presence of a business is the most important aspect. OPENLINK makes it super easy to run daily campaigns for social media.',
                                'link' => '#',
                            ),
                            array(
                                'title' => 'StartUp',
                                'text' => 'The startup world itself describes the difficulties faced in starting any business. Finding new customers and making markets is the most difficult thing for any startup. With OPENLINK, you can easily create buzz for your startup and acquire new customers.',
                                'link' => '#',
                            ),
                            array(
                                'title' => 'Bloggers',
                                'text' => 'Bloggers can use OPENLINK directly to run competitions, product giveaways. Bloggers can even use OPENLINK to directly promote their blogging content.',
                                'link' => '#',
                            ),
                            array(
                                'title' => 'Event Organisers',
                                'text' => 'Event organizers can use OPENLINK in its best way to promote their events. Run scalable campaigns for ticket sales or virally spread your event among specific audiences',
                                'link' => '#',
                            ),
                            array(
                                'title' => 'Product Marketer',
                                'text' => 'Have a new product or added any new feature and want to hand it to your audience? OPENLINK is a perfect choice. Just create the link with some product offer or product giveaways with OPENLINK and share it with your audience.',
                                'link' => '#',
                            ),
                        );
                    @endphp

                    <div class="row my-4">
                        @foreach($uses as $u)
                        <div class="col-lg-4 my-4">
                            <div class="card cb-1 border-0 border-top h-100">
                                <div class="card-body" style="margin-bottom: 10px;">
                                    <div class="">
                                        <div>
                                            <h3 class="card-title font-600 pb-2 pt-4">{{$u['title']}}</h3>
                                            <p class="card-text">{{$u['text']}}</p>
                                        </div>
                                        {{-- <div>
                                            <a href="{{$u['link']}}" class="btn btn-app btn-sm">
                                                <span>See More</span>
                                                <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>  

            <!-- help  -->
            <section class="mt-5">
                <div class="oplk-bg-color-gradient py-5">
                    <div class="container">
                        <div class="row align-items-center text-white">
                            <div class="col-lg-9 col-md-8">
                                <h2 class="text-capitalize">create your first OPENLINK campaign now!</h2>
                                <p>OPENLINK lets you create your offer, discount link and grow your business.</p>
                            </div>
                            <div class="col-lg-3 col-md-4 text-md-end">
                                <button onclick="window.location.href='{{ url('signin?tab=register') }}';return false;" class="btn btn-light btn-lg px-4 font-600">Create Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
   
        </section>
    </div>
</section>
@endsection

@section('end_body')
    
@endsection