@extends('layouts.front')

@section('title', 'MouthPublicity.io Features | MouthPublicity.io')
@section('description', 'Create, Share & Manage offers, discounts, product-service promo videos landing pages wit MouthPublicity.io\'s simple to setup tool. Track your results at one glance. Set up your first campaign for free now. ')
@section('keywords', 'landing pages, offers templates')
{{-- @section('image', '') --}}

@section('end_head')
   <style>
       .bt1{
            font-size: 3rem;
            line-height: 4rem;
        }
        .bt2{
            font-size: 2rem;
            color: rgb(100, 100, 100);
        }
        .bt3{
            border-radius: 16px;
            background:linear-gradient(-90deg, var(--color-thm-lth) -8%, var(--color-thm-drk) 140%);
        }
        .sec{
            margin-top: 110px;
        }
       .sec1{
            font-size: 4rem;
            background: linear-gradient(251deg, var(--color-thm-lth) 37%, var(--color-thm-drk) 68%);
            -webkit-background: -webkit-linear-gradient(90deg, var(--color-thm-lth) 20%, var(--color-thm-drk) 120%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .sec2{
            font-size: 2rem;
        }
         .sec4{
            font-size: 2.5rem;
            background: linear-gradient(300deg, var(--color-thm-lth) 82%, var(--color-thm-drk) 110%);
            -webkit-background: -webkit-linear-gradient(90deg, var(--color-thm-lth) 20%, var(--color-thm-drk) 120%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0px;
        }
        .boxtext{
            font-size: 1rem;
        }
        .opacity{
            font-size: 1.8rem;
            opacity: 0.7;
            background: linear-gradient(300deg, var(--color-thm-lth) 82%, var(--color-thm-drk) 110%);
            -webkit-background: -webkit-linear-gradient(90deg, var(--color-thm-lth) 20%, var(--color-thm-drk) 120%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .backgroundimg{
            background-image:url("{{ asset('assets/front/images/streep-01.png')}}");
            background-repeat: no-repeat;
            width: 100%;
            height: auto;
            background-size: cover;
            background-position: center;
        }
        .bt4{
            border-width: 3px;
            border-style: solid;
            border-image-slice: 2;
            border-image-source: linear-gradient(-90deg, var(--color-thm-lth) -8%, var(--color-thm-drk) 140%);
            float: right;
         }  
         .imgsize{
            max-width: 170px;
         } 
         .bgcolor{
            background: rgb(245, 245, 245);
         }
        .review{
            position:   relative;
        }
         .review h1::before {
            content: "";
            position: absolute;
            bottom: 12px;
            left: 171px;
            width: 271px;
            height: 4px;
            background: var(--color-thm-shd);  
        }    
        .box{
            max-width: 200px;
            max-height: 200px;
            background-color:  rgb(226, 226, 226);
        }
        .box img{
            border-radius: 50%;
        }
        .features-alt{
            background: #f8f8f8;
            padding: 10px;
            box-shadow: 2px 2px 5px #d3d3d3;
        }
            
        @media(max-width: 575px){
            .features-alt .text{
                text-align: center;
            }
        }
   </style>
@endsection

@section('content')
<section id="features">
    <div class="py-5">
      <!--   Logo section -->
        <div class="container">
            <div class="mb-4">
                <a href="{{ url('') }}" ><img src="{{ asset('assets/front/images/logo-dark.svg') }}" class="main_logo" alt="MouthPublicity.io"></a>
            </div> 
   <!--  section1 -->  
            <section id="starting">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-lg-5 col-md-7">
                            <h1 class="font-900 color-lht text-uppercase bt1">Expand Your Business Reach</h1>
                            <h3 class="py-2">With Digital Mouth Publicity Media</h3>
                            <a href="{{url('signin')}}" class="btn btn-theme">Get Started</a> 
                        </div>
                        <div class="col-lg-6 col-md-5">
                            <img src="{{ asset('assets/front/images/images-02.png') }}" class="w-100" alt="MouthPublicity.io Featurs">
                        </div>
                    </div>
            </section>        
          
 <!--  section2 -->  
            <section id="dashboard">
                    <div class="row justify-content-center text-center py-5 sec">  
                        <div class="col-lg-10 col-md-10"> 
                                <h1 class="font-900 sec1 text-uppercase">MouthPublicity.io</h1>
                                <h3 class="text-capitalize"> Helps You To Manage & Market Your Business With Single Dashboard</h3>
                                <img src="{{ asset('assets/front/images/dashboard-features.png') }}" class="w-100" alt="MouthPublicity.io Dashboard" style="max-width: 900px;">
                        </div> 
                    </div>
            </section>        
<!--  section3 -->  
            <section id="content">
                    <div class="row  my-sm-3 pb-5 align-items-center justify-content-between">
                        <div class="col-lg-5 col-md-5">
                                <h3 class="color-lht font-700 sec2 mb-4" >CONTENT SHARING</h3>
                                <p class="text-justify_ mb-4"> Create content, regarding your business billing, marketing, promotion objective and share it with your customer on their WhatsApp. You can also share your social media post from the Single MouthPublicity.io platform. You can add anything to your content, may it can be some promotional content, website link, offers, discounts, giveaway, etc. It depends on what is your business goal.</p>
                                <h5 class="color-lht font-600 mb-3"> Create your first campaign now!</h5>
                                <a href="{{url('signin')}}" class="btn btn-theme">Create Now</a>
                        </div> 
                        <div class="col-lg-6 col-md-5 text-center"> 
                                <img src="{{ asset('assets/front/images/tab.png') }}" class="w-100 img-fluid" alt="features4" style="max-width:450px;">
                        </div>
                    </div> 
            </section>        
            <!-- section Heading --> 
            <div class="row mt-5">
                <div class="col-12">
                   <h1 class="font-900 sec4 text-uppercase mb-3"> MouthPublicity.io MARKETING SOLUTION </h1>
                </div>
            </div>
        </div>    
            <!-- section 6  -->  
        <!-- make and share -->
            <section id="tab2">   
                <div class="container"> 
                    <div class="row py-5 my-sm-5 align-items-center justify-content-between">  
                        <div class="col-lg-7 order-sm-2">  
                            <h1 class="color-lht font-700 sec2 pt-4 pb-2 text-uppercase">Make & Share</h1>
                            <h6 class="font-700 opacity">Create an attractive WhatsApp message and share</h6>
                            <p class="text-justify_">Boost your promotional content reach and visibility now with MouthPublicity.io Easily select your template, create your content, build your message and share it on WhatsApp with MouthPublicity.io With MouthPublicity.io Make & Share feature, you can promote your personal or business content to contacts on WhatsApp. Make and Share gives you the customised template to make your content attractive and give a good touch to uplift your content. Start making & sharing your content now at no cost.
                            </p>
                            <a href="{{ url('signin?tab=register') }}" class="btn btn-theme">Register Now</a>
                        </div>
                        <div class="col-lg-4 order-sm-1 text-center pt-3 pt-sm-0">  
                            <img src="{{ asset('assets/front/images/features/make_and_share.svg') }}" class="img-fluid"  alt="make and share">
                        </div> 
                        
                    </div>  
                </div> 
            </section> 
        <!-- social media post -->
            <section id="tab1">  
                <div class="bgcolor">   
                    <div class="container"> 
                        <div class="row py-5 justify-content-between align-items-center">   
                            <div class="col-lg-5 pb-3 pb-sm-0">  
                                <h1 class="color-lht font-700 sec2 pt-4 pb-2 text-uppercase">Social Media Post</h1>
                                <h6 class="font-700 opacity">Automate your social media posting in one click!</h6>
                                <p class="text-justify_">MouthPublicity.io is the perfect solution to improve your social media presence and maximize your results. MouthPublicity.io Social Media Post allows you to publish your social media content on different platforms like Facebook, LinkedIn, Twitter all at one time, and that too in a single click. Just simply select the template, create your posting content, select the platform you want to share, and publish it.</p>
                                <p>MouthPublicity.io Social media posts also let you keep your eye on every single click by your followers. Start managing your social media at one platform at zero cost of investment. </p>
                                <a href="{{ url('signin?tab=register') }}" class="btn btn-theme">Register Now</a>
                            </div>
                            <div class="col-lg-6 text-center">  
                                <img src="{{ asset('assets/front/images/features/social_media_post.svg') }}" class="img-fluid" style="max-width: 550px;" alt="social media post">
                            </div>
                        </div>  
                    </div>
                </div>  
            </section>
 <!-- whatsapp API -->
        <div class="container">
            <section id="whatsapp API">
                <div class="mt-4"> 
                    <div class="row"> 
                        <div class="col-lg-6">
                            <div class="row align-items-center">
                                <div class="col-lg-2 col-md-3 col-3">
                                    <img src="{{ asset('assets/front/images/features/whatsapp_api_icon.svg') }}" class="w-100 img-fluid pt-2" alt="box">
                                </div>
                                <div class="col-4 ">  
                                    <h4 class="color-lht sec2 font-700 pt-4 lh-sm">WHATSAPP API</h4>
                                </div> 
                            </div>
                        </div>    
                    </div>
                    <div class="row">
                        <div class="col-12">
                             <h4 class="mt-4 font-700 opacity">Replace your SMS with WhatsApp</h4>
                        </div>        
                    </div>  
                        <div class="row py-5">
                            <div class="col-12">
                                <div class="text-center">
                                    <img src="{{ asset('assets/front/images/features/whatsapp_api_new.svg') }}"  class="img-fluid pt-2" alt="WhatsApp API">
                                </div> 
                            </div>
                            <div class="text-justify_ mt-5">
                                <p>Easily Integrate any billing application with a secure, scalable, and powerful MouthPublicity.io WhatsApp API. The MouthPublicity.io WhatsApp API allows you to integrate your billing software and send messages to your customer’s WhatsApp. You can send billing messages, notifications, alerts, offers, and any custom message to individual customers directly on their WhatsApp.
                                WhatsApp API helps you save a big amount of money on your billing communication. MouthPublicity.io also helps you promote your business offer with your billing communication which saves time for you and your employees.
                                </p>
                            </div>
                            {{-- <div class="my-4 b">
                                <button type="button" class="btn bt4 py-1 px-4">Read more</button>   
                            </div>          --}}
                        </div>
                    </div>    
            </section> 
            <!-- instant rewards -->    
            <section id="instant offer">
                <div class="row pt-3"> 
                    <div class="col-lg-6">
                        <div class="row align-items-center">
                            <div class="col-lg-2 col-md-3 col-3">
                               <img src="{{ asset('assets/front/images/offer-15.png') }}" class="w-100 img-fluid pt-2" alt="box">
                            </div>
                            <div class="col-4 ">  
                                <h4 class="color-lht sec2 font-700 pt-4 lh-sm">INSTANT REWARD</h4>
                            </div> 
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-12">
                        <h4 class="mt-4 font-700 opacity">Grow your social media presence now!</h4>
                    </div>        
                </div>       
            </section> 
        </div>      
            <section id="backimage">
                <div  class="container-fluid">
                    <div class="backgroundimg bg-image">   
                        <div class="row py-5">
                            <div class="col-lg-12">
                                <div class="text-center">
                                    <img src="{{ asset('assets/front/images/feature-1.svg') }}" style="max-width: 450px;" class="img-fluid pt-2" alt="INSTANT OFFER">
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="container"> 
                    <div class="row mb-5">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="text-justify">
                                <p>One can easily create an instant giveaway or run offers to engage the audience with an open link. Instant offers are the ones that are beneficial for the customers right at the same time there today itself. MouthPublicity.io'S Instant Reward helps you grow your social media presence with your own customers.</p>    
                                <p>Create an Instant reward task for your customer, you can ask them to follow, like, subscribe on your business social media platform and avail them back with a small offer or benefit after doing the task. </p>
                                <p>Instant reward makes your own customers your social media followers. It keeps your customers always in connection with you on your social media platform.</p>           
                            </div> 
                            {{-- <div class=" py-4 b">
                                <button type="button" class="btn bt4 py-1 px-4">Read more</button>   
                            </div>  --}}
                        </div>    
                    </div>
                </div>    
            </section>  
            <!-- share & reward --> 
        <div class="container">
            <section id="future offer">
                <div class=""> 
                    <div class="row"> 
                        <div class="col-lg-6">
                            <div class="row align-items-center">
                                <div class="col-lg-2 col-md-3 col-3">
                                    <img src="{{ asset('assets/front/images/features/share_and_reward_icon.svg') }}" class="w-100 img-fluid pt-2" alt="box">
                                </div>
                                <div class="col-4 ">  
                                    <h4 class="color-lht sec2 font-700 pt-4 lh-sm">SHARE & REWARD</h4>
                                </div> 
                            </div>
                        </div>    
                    </div>
                    <div class="row">
                        <div class="col-12">
                             <h4 class="mt-4 font-700 opacity">Boost your brand reach with one click!</h4>
                        </div>        
                    </div>  
                    <div class="row py-5">
                        <div class="col-12">
                            <div class="text-center">
                                <img src="{{ asset('assets/front/images/features/share_and_reward.svg') }}"  class="img-fluid pt-2" alt="FUTURE OFFER">
                            </div> 
                        </div>
                        <div class="text-justify_ mt-5">
                            <p>Today sharing and availing the benefit in the future is one of the trendy features. Through MouthPublicity.io, a mouth publicity media, you can create, share and reward your customer very smoothly. Easily create the link with the content you want to promote and expand your business. Now, share it with your customers and ask your customers to promote it. Once the basic promotion criteria are fulfilled, give them some benefit in the future through your business.</p> 
                            <p>Suppose you want to promote your new business product, create the content link with MouthPublicity.io. Share it with your existing customers, ask them to re-share it in their contacts, ask for specific numbers of clicks (maybe 50 clicks), and give them an offer (maybe 20% discount) on their next purchase. Share & Reward will not only grow and engage customers, but your customers will also bring you, other new customers. MouthPublicity.io's future content makes your customers your brand promoters.</p>
                            <p>Through MouthPublicity.io you can offer the following different types of Rewards to your customer, attract them through it and grow your reach.</p>
                        </div>
                        {{-- <div class="my-4 b">
                            <button type="button" class="btn bt4 py-1 px-4">Read more</button>   
                        </div>          --}}
                    </div>
                </div>    
            </section>
            <section id="offer">
                <div class="">
                    <div class="row justify-content-center mb-5">

                        <div class="col-lg-12">
                            <div>
                               <!--  <div class="features-alt">
                                    <div class="row mb-5">
                                        <div class="col-12">
                                            <div class="row align-items-center justify-content-center">       
                                                <div class="col-lg-2 col-md-4 col-sm-4 text-center mb-2 imgsize ">
                                                    <img src="{{ asset('assets/front/images/Flash-Sale.png') }}" class="w-100 img-fluid" alt="box">
                                                </div>
                                                <div class="col-lg-10 col-md-6 col-sm-8">
                                                    <h5 class="text text-muted"><span class="color-lht">Flash Sale</span> - Flash sales are best offered for a short time, start promoting your flash sale days in advance.</h5>
                                                </div>
                                            </div>    
                                        </div>    
                                    </div>
                                </div>
                                <div class="features-alt">
                                    <div class="row my-5">
                                        <div class="col-12">
                                            <div class="row align-items-center justify-content-center">
                                                <div class="col-lg-2 col-md-4 col-sm-4 imgsize mb-2 order-sm-2">
                                                    <img src="{{ asset('assets/front/images/Free-Offer.png') }}" class="w-100 img-fluid" alt="box">
                                                </div>
                                                <div class="col-lg-10 col-md-6 col-sm-8 order-sm-1 justify-content-center">
                                                    <h5 class="text text-muted"><span class="color-lht">Free Offer</span>- Customers find Buy One Get One FREE stuff more valuable than discounts provide them with that for their convenience.</h5>
                                                </div>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>          
                                <div class="features-alt">
                                    <div class="row my-5">
                                        <div class="col-12">
                                            <div class="row align-items-center justify-content-center">
                                                <div class="col-lg-2 col-md-4 col-sm-4 mb-2 imgsize">
                                                    <img src="{{ asset('assets/front/images/Couponsgift-cards.png') }}" class="w-100 img-fluid" alt="box">
                                                </div>
                                                <div class="col-lg-10 col-md-6 col-sm-8">
                                                    <h5 class="text text-muted"><span class="color-lht">Coupons/gift cards</span>- The offer for a coupon or gift card with a purchase is a deal for both of you and your customers.</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>   
                                </div> 
                                <div class="features-alt">
                                    <div class="row my-5">
                                        <div class="col-12">
                                            <div class="row align-items-center justify-content-center">
                                                <div class="col-lg-2 col-md-4 col-sm-4 text-center mb-2 imgsize order-sm-2">
                                                    <img src="{{ asset('assets/front/images/Rewards.png') }}" class="w-100 img-fluid" alt="box">
                                                </div>
                                                <div class="col-lg-10 col-md-6 col-sm-8 order-sm-1">
                                                    <h5 class="text text-muted"><span class="color-lht">Rewards</span>- By giving your customers rewards, you will build customer loyalty and potential value.</h5>
                                                </div>
                                            </div> 
                                        </div>       
                                    </div>
                               </div>     
                               <div class="features-alt">
                                    <div class="row my-5">
                                        <div class="col-12">
                                             <div class="row align-items-center justify-content-center">
                                                <div class="col-lg-2 col-md-4 col-sm-4 imgsize">
                                                    <img src="{{ asset('assets/front/images/Giveaways.png') }}" class="w-100 img-fluid" alt="box">
                                                </div>
                                                <div class="col-lg-10 col-md-6 col-sm-8">
                                                    <h5 class="text text-muted"><span class="color-lht">Giveaways</span>- To delight your current followers and attract new visitors to your page, you should consider Giveaways. Firstly choose a prize, then determine the entry criteria, put a time limit for your contest. Lastly, launch and promote your Giveaway Contest.</h5>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                               </div> -->
                               <div class="features-alt">
                                    <div class="row my-5">
                                        <div class="col-12">
                                            <div class="row align-items-center justify-content-center">
                                                <div class="col-lg-2 col-md-4 col-sm-4 text-center mb-2 imgsize">
                                                    <img src="{{ asset('assets/front/images/features/cash-per-click.png') }}" class="w-100 img-fluid" alt="box">
                                                </div>
                                                <div class="col-lg-10 col-md-6 col-sm-8">
                                                    <h6 class="text text-muted"><span class="color-lht h5">Cash-per-click</span>- Cash per click means that you pay your customer for each unique click-on offer link that you have shared with them. For Cash-per-click, you can set a click amount and click limit by yourself. Once you fix the per click budget and clicks target you are all ready to share your link. When any customer completes the click target you have set or they have achieved n number of clicks and comes to redeem the offer. You need to avail them of the benefit by giving cashback on their purchase as per their number of clicks and your each click set budget.</h6>
                                                </div>
                                            </div> 
                                        </div>       
                                    </div>
                               </div>
                                <div class="features-alt">
                                    <div class="row my-5">
                                        <div class="col-12">
                                             <div class="row align-items-center justify-content-center">
                                                <div class="col-lg-2 col-md-4 col-sm-4 imgsize">
                                                    <img src="{{ asset('assets/front/images/features/fixed-ammount.png') }}" class="w-100 img-fluid" alt="box">
                                                </div>
                                                <div class="col-lg-10 col-md-6 col-sm-8">
                                                    <h6 class="text text-muted"><span class="color-lht h5">Fixed Amount</span>- A fixed amount is a very simple way to reward your customer. Create your promotional content, set the exact click target for your customer, and exact fixed reward amount too. Once the customer achieves the target and comes to purchase in the future, avail them with a fixed amount offer benefit.</h6>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                               </div>
                               <div class="features-alt">
                                    <div class="row my-5">
                                        <div class="col-12">
                                            <div class="row align-items-center justify-content-center">
                                                <div class="col-lg-2 col-md-4 col-sm-4 text-center mb-2 imgsize">
                                                    <img src="{{ asset('assets/front/images/features/percent-discount.png') }}" class="w-100 img-fluid" alt="box">
                                                </div>
                                                <div class="col-lg-10 col-md-6 col-sm-8">
                                                    <h6 class="text text-muted"><span class="color-lht h5">Percentage Discount</span>- Percentage Discount is one of the most popular reward series. Offer customers with a specific amount of discount every time they achieve the target. Simply create the offer, set the click target you want, and also the amount of percentage discount you want to give. Once the customer shares the content in there and achieves the target of clicks, avail them with a set percentage discount on their purchase. </h6>
                                                </div>
                                            </div> 
                                        </div>       
                                    </div>
                               </div> 
                            </div> 
                        </div>
                    </div>
                </div>
            </section>    
        </div>
        <!-- D2C post -->
            <section id="tab3">  
                <div class="bgcolor">   
                    <div class="container"> 
                        <div class="row py-5 justify-content-between align-items-center">   
                             <div class="col-lg-6">  
                                <h1 class="color-lht font-700 sec2 pt-4 pb-2 text-uppercase">D2C Post</h1>
                                <h6 class="font-700 opacity">Send many just in one click</h6>
                                <p class="text-justify_">MouthPublicity.io D2C Post gives you an easily accessible and effective platform to share your content i.e your business update, alerts, or any other message on your customer's WhatsApp that too in one click to your Customer Base. MouthPublicity.io D2C posting is a WhatsApp bulk messaging service.</p>
                                <p>You can send customised messages to your customer base 24/7 on their WhatsApp in one click. D2C post gives you 100% assurance for instant delivery within no time.</p>

                            </div>
                            <div class="col-lg-5 text-center">  
                            <img src="{{ asset('assets/front/images/features/D2C_post.svg') }}" class="img-fluid" style="max-width: 360px;" alt="D2C post">
                        </div> 
                        </div>  
                    </div>
                </div>  
           </section>  
           <!-- personalised greetings -->
           <section id="tab4">   
                <div class="container"> 
                    <div class="row py-5 my-sm-5 align-items-center justify-content-between">   
                        <div class="col-lg-5 order-sm-2">  
                            <h1 class="color-lht font-700 sec2 pt-4 pb-2 text-uppercase">Personalised Greetings</h1>
                            <h6 class="font-700 opacity">Greet your customers on their special day effortlessly</h6>
                            <p class="text-justify_">MouthPublicity.io'S Personalised Greetings is designed to send birthday and anniversary wishes automatically. Just create your message with a customised template available and save it. That’s done! MouthPublicity.io will automatically send your customer your message as per your saved customer database on their special day. Personalised Greetings through MouthPublicity.io takes care of happy customer service for your business.</p>
                        </div>
                        <div class="col-lg-6 order-sm-1 text-center">  
                            <img src="{{ asset('assets/front/images/features/personalised_wishing.svg') }}" class="img-fluid" style="max-width: 450px;" alt="personalised wishing">
                        </div>
                    </div>  
                </div> 
           </section>
           <!-- employee accounts -->
           <section id="tab3">  
                <div class="bgcolor">   
                    <div class="container"> 
                        <div class="row py-5 justify-content-between align-items-center">   
                             <div class="col-lg-6">  
                                <h1 class="color-lht font-700 sec2 pt-4 pb-2 text-uppercase">Employee account</h1>
                                <h6 class="font-700 opacity">Let your employee manage your offers </h6>
                                <p class="text-justify_">Easily manage your business offer creation, sharing and offer availing process through your employee base. Just sit, relax and create your employee account in OpenChallenge, and let your employee manage all the offer based task. Don’t worry your employee don’t have access to any other OpenChallenge’S business feature. Employees can just share the offer with customers and carry forward the offer availing process at billing counter. There is track of each offer and each customer, which you can tally anytime, anywhere on OpenChallenge Dashboard.</p>

                            </div>
                            <div class="col-lg-5 text-center">  
                            <img src="{{ asset('assets/front/images/features/employee_account.svg') }}" class="img-fluid" alt="employee account">
                        </div> 
                        </div>  
                    </div>
                </div>  
           </section>        
    </div>    
</section>
@endsection

@section('end_body')
    
@endsection