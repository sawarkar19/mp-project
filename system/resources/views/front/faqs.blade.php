@extends('layouts.front')

@section('title', 'FAQS - MouthPublicity.io')
@section('description', 'Frequently Asked Questions - MouthPublicity.io')
@section('keywords', 'MouthPublicity.io Frequently Asked Questions, MouthPublicity.io FAQs')
{{-- @section('image', '') --}}

@section('end_head')
   <style>
        .create:before{
            content: "";
            display: block;
            background: linear-gradient(-90deg, var(--color-thm-lth) 0%, var(--color-thm-drk) 100%);
            width: 110px;
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
                top: 0;
                transform: translateY(0%);
                width: 15px;
            }
        }
        .search{
            position: relative;
        }
        .search input,
        .search input:focus,
        .search input:active{
            /* border-radius: 6px 0px 0px 6px; */
            background-color: #ebebeb;
            border: 1px solid transparent;
            padding: 0.8rem 1.5rem;
            font-family: var(--font-h1);
            font-weight: 300;
            position: relative;
            outline: none;
            box-shadow: none;
        }
        .search input:focus,
        .search input:active{
            border: 1px solid var(--color-thm-lth);
        }
        .search::before {
            content: "\F52A";
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-thm-lth);
            z-index: 99;

            display: inline-block;
            font-family: bootstrap-icons!important;
            font-style: normal;
            font-weight: 400!important;
            font-variant: normal;
            text-transform: none;
            line-height: 1;
            vertical-align: -0.125em;
            -webkit-font-smoothing: antialiased;

        }
        .faqsAc .accordion-item{
            border: 0px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            padding: 20px 0;
        }
        .faqsAc .accordion-item:last-child{
            border-bottom: 0px;
        }
        .faqsAc .accordion-header{
            cursor: pointer;
            padding: 10px 15px;
        }
        .faqsAc .accordion-header .faq-que{
            margin-bottom: 0px;
            font-size: 1.2rem;
            padding-left: 30px;
            position: relative;
            font-weight: 400;
        }
        .faqsAc .accordion-header .faq-que::before{
            content: "\f63b";
            font-family: bootstrap-icons !important;
            font-style: normal;
            font-weight: normal !important;
            font-variant: normal;
            text-transform: none;
            line-height: 1.5;
            vertical-align: -0.125em;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            position: absolute;
            left: 0;
            top: 1px;
            color:linear-gradient(-90deg, var(--color-thm-lth) -15%, var(--color-thm-drk) 115%);
             background: -webkit-linear-gradient(-90deg, var(--color-thm-lth) -15%, var(--color-thm-drk) 115%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .faqsAc .accordion-header.collapsed .faq-que::before{
            content: "\f64d";
        }

        .faqsAc .accordion-body p{
            position: relative;
            color: #868d96;
            padding-left: 15px;
            /* font-weight: 400; */
        }
        .faqsAc .accordion-body p::before{
            content: "";
            position:absolute;
            left: 0;
            top: 0;
            width: 2px;
            height: 100%;
            background:linear-gradient(-90deg, var(--color-thm-lth) -15%, var(--color-thm-drk) 115%); 
        }
        .b1{
            padding: 0.5rem 3.5rem;
            background:linear-gradient(-90deg, var(--color-thm-lth) -15%, var(--color-thm-drk) 115%);
        }

   </style>
@endsection

@section('content')
<section id="faqs">
    <div class="py-5">
      <!--   Logo section -->
        <div class="container">
            <div class="mb-5">
                <a href="{{ url('') }}" ><img src="{{ asset('assets/front/images/logo-dark.svg') }}" class="main_logo" alt="MouthPublicity.io"></a>
            </div>
        </div> 

        <!-- img and faq section -->
        <div class="container-fluid position-relative">
            {{-- <div class="create"></div> --}}

            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <div class="bg-white">
                        <div class="row align-items-center">
                             <div class="col-md-6">
                                <h1 style="line-height: 70px;" class="fw-bold">FAQS</h1>
                            </div>
                            <div class="col-md-6 text-center">
                                <img src="{{ asset('assets/front/images/faq-banner.svg') }}" class="w-100" style="max-width:500px" alt="MouthPublicity.io FAQ">
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>

<!-- text and search section -->
        <div class="row container-fluid justify-content-center align-items-center mt-5">
            <div class="col-xl-7 col-lg-8 text-center text1">  
                <div>
                    <h1>Frequently Asked Questions</h1>
                    <p class="mb-4">You can also browse the keywords below to find what you are looking for.</p>
                </div>

                <div>
                    <div class="form-group search">  
                        <input type="text" class="form-control" id="faq_search" placeholder="Find question">
                    </div>
                </div>
            </div>
        </div> 

        @php

        $faqs = array(
            array(
                'que' => 'Can I register twice with the same details on MouthPublicity.io?',
                'ans' => 'No, the system does not allow you to register with the same details twice.'
            ),
            array(
                'que' => 'How to create a page on social media using MouthPublicity.io?',
                'ans' => 'No, with MouthPublicity.io, you can\'t create any social media pages. You can just add and track social media activity to your offer page or social media platforms through MouthPublicity.io'
            ),
            array(
                'que' => 'How should I upgrade my plan?',
                'ans' => 'We are happy, you decided to walk one step ahead. Just go to the <a href="'.url('pricing').'">Pricing</a> page, select the package according to your business need and you are all set to go live with your Business features.'
            ),
            array(
                'que' => 'What is the difference between Select Apps and All Apps?',
                'ans' => 'The registration process for both plans is the same. In select apps, you can choose to customise plans and in All apps, you can select all the plans to buy. You can upgrade the plan as per your business need from the <a href="'.url('pricing').'">Pricing</a> Page.'
            ),
            array(
                'que' => 'I am already having an online business so how is this concept going to help me?',
                'ans' => 'MouthPublicity.io is built with the concept of offering true power of mouth publicity media to all businesses. This tool will individually just work on increasing business reach and will also give detailed analytics of your brand reach.'
            ),
            array(
                'que' => 'When exactly can a customer avail his discount or reward?',
                'ans' => 'Customers can avail of discounts, once they completed the task set for instant or share and rewards.'
            ),
            array(
                'que' => 'Are we supposed to provide a Coupon code to customers?',
                'ans' => 'As a business owner, you don\'t have to provide any coupon code, as your customer completes the task they will receive a coupon code from MouthPublicity.io, which will be availed/redeemed on the next purchase.'
            ),
            array(
                'que' => 'Is there any refund policy?',
                'ans' => 'Sorry, we won\'t provide any refund policy.'
            ),
            array(
                'que' => 'Is it possible to make offers on a Personal plan?',
                'ans' => 'Yes, you can make offers in a personal plan, but you can use the make and share feature where you can create your WhatsApp message with a customizable template and share it in your contact list.'
            ),
            array(
                'que' => 'How can I share an offer with the customer?',
                'ans' => 'As MouthPublicity.io provides you with WhatsApp API which can be integrated with an online billing system using you can share the links via WhatsApp at the time of billing. Apart you can share offers by subscribing to customers using contact details.'
            ),
            array(
                'que' => 'Do I have to redeem to every person who is forwarding the link in their network?',
                'ans' => 'No! You just have to provide an offer to your primary customers, who have visited your shop, have received a link from your side, and completed the target you have set.'
            ),
            array(
                'que' => 'Will you notify me when the target is achieved by the customer?',
                'ans' => 'No! however, you can track customer\'s targets and achievements for a respective offer on the MouthPublicity.io dashboard. Whereas your customer will receive the redeem code from MouthPublicity.io as they complete the target and will come to avail the offer to you.'
            ),
            array(
                'que' => 'What is MouthPublicity.io?',
                'ans' => 'MouthPublicity.io is a mouth publicity media to increase your brand reach by sharing your business content on customer\'s WhatsApp. One can easily register their business on MouthPublicity.io and create and share their business offers with their customers through MouthPublicity.io'
                ),
            array(
                'que' => 'What is an Instant reward?',
                'ans' => 'Instant offers are the fastest way to grow your social media presence. In an instant offer, you need to provide customers with an instant benefit on their recent purchase and ask them to visit and follow your social media pages.'
            ),
            array(
                'que' => 'What is the Share and Reward?',
                'ans' => 'Share and rewards provide you with different features like Cash Per Click, Fixed Amount, Percentage Discount and are the best way to grow your brand reach. In this, you need to provide customers a link via WhatsApp and ask them to share it in their network with some specified click target. Once the target is achieved by the customer, you can offer them future benefits on the next purchase.'
            ),
            array(
                'que' => 'How is it better than digital marketing?',
                'ans' => 'MouthPublicity.io is the organic mouth publicity media marketing tool that runs on the idea of organically spreading the word for business through its customer and growing brand reach. MouthPublicity.io also offers a detailed analytical view of each penny invested and helps you in micro-level targeting of customers. Whereas Digital Marketing helps your market your business on a vast level.'
            ),
            array(
                'que' => 'Can your MouthPublicity.io WhatsApp API be integrated with any online billing software?',
                'ans' => 'Our MouthPublicity.io WhatsApp API can be integrated with the specific billing software that supports API integration.'
            ),
            array(
                'que' => 'How can I integrate MouthPublicity.io WhatsApp API with my POS system/billing software?',
                'ans' => 'Whenever you subscribe to MouthPublicity.io\'s WhatsApp API, a unique API Key will be generated which you can replace or integrated with the help of your POS/ Billing Software vendor.'
            ),
            array(
                'que' => 'Is my data safe with MouthPublicity.io?',
                'ans' => 'Yes, your data is safe with MouthPublicity.io. For more details click on <a href="'.url('privacy-policy').'">Privacy policy</a>.'
            ),
            array(
                'que' => 'I don\'t have a website, can I still use MouthPublicity.io?',
                'ans' => 'Yes, you can still use MouthPublicity.io and create offers by using customised templates.'
            ),
            array(
                'que' => 'I don\'t have social media pages, can I use MouthPublicity.io?',
                'ans' => 'Yes, you can use MouthPublicity.io to create offer content and promote it to your customer base on their WhatsApp.'
            ),
            
            array(
                'que' => 'Can I use MouthPublicity.io to increase my social media followers?',
                'ans' => 'A big Yes! With MouthPublicity.io, you can create instant offers and share them with
                 your customer and increase your social media followers.'
            ),
            array(
                'que' => 'Can I use my website URL to share my promotional offers',
                'ans' => 'Yes, You can use your website URL for creating and promoting your business offer.'
            ),
            array(
                'que' => 'If I\'m paying for a monthly membership, do I get access to all your features of MouthPublicity.io?',
                'ans' => 'No, you will get access to all our features according to the plan you have subscribed to. As we have multiple plans that suit your business you can choose one and get all the features from that particular plan. You can view our plans here <a href="'.url('pricing').'"> MouthPublicity.io/pricing</a>.'
            ),
            array(
                'que' => 'Is there any amount required to get registered on MouthPublicity.io?',
                'ans' => 'No, you can freely get registered just by details like your name, contact number, and email to register you with MouthPublicity.io'
            ),
            array(
                'que' => 'How does your system prevent contestants from cheating the system?',
                'ans' => 'We have a track record of each click from the user and it is visible on the dashboard, while redeeming the offer he/she has to share their unique code which will be received on their number. Thus avoiding cheating from the system. For more details, you can check our privacy policy here.'
            ),
            array(
                'que' => 'How does an offer look on mobile?',
                'ans' => 'Nowadays, mobile has been a priority thing to promote offers. Our templates are mobile-friendly which makes your offers look amazing on mobile! Each template is designed to be mobile-friendly.'
            ),
            array(
                'que' => 'Can MouthPublicity.io help me get Twitter, Facebook, or Twitter followers?',
                'ans' => 'Yes! You can grow your social media followers by setting your campaign goal. You select Instant offers and can ask your audience to like/follow your social media pages and offer them instant benefits.'
            ),
            array(
                'que' => 'Can I customise my offers?',
                'ans' => 'Yes, MouthPublicity.io allows customization for your offers. It has multiple pre-designed templates you can choose it according to your business needs and create attractive offers.'
            ),
            array(
                'que' => 'What if I am unable to open or access the link?',
                'ans' => 'The error in Opening a link or accessing it will only and only occur if there is an internet connectivity issue. Kindly check your network connectivity once, if you still face the issue please contact 07887882244'
            ),
            array(
                'que' => 'How to share links on WhatsApp?',
                'ans' => 'Once you create a whole offer and save it then you are redirected to the next page with the subscribe button, click on it. You can share the link by adding a WhatsApp number.'
            ),
            array(
                'que' => 'How can I reset my Credentials?',
                'ans' => 'Click on forget the password, enter the registered email id or contact number, you will then receive a link on your registered email id and WhatsApp number, next reset the password Go to the link, reset the new password and you are all set to go with your new password.'
            ),
            array(
                'que' => 'How to track the clicks of subscribed customers?',
                'ans' => 'Go to MouthPublicity.io, click on the dashboard on the admin panel, Have a look at the clicks of all your customers right there on a single dashboard.'
            ),
            array(
                'que' => 'What are the benefits I would get after registration?',
                'ans' => 'Once you are registered with MouthPublicity.io, you can create make & share offers for your customers, and social posts too, for your social media followers. you can grow your customer reach, and also grow your social media presence.'
            ),
            array(
                'que' => 'What is the validity of the link?',
                'ans' => 'There is no validity of the link. If the offer ends and the customer comes to avail of the benefit. You need to offer them some other benefit at that time.'
            ),
            array(
                'que' => 'How can I change the offer?',
                'ans' => 'Once the offer is active and the link is shared you cannot make changes to it.'
            ),
            array(
                'que' => 'Can I Use MouthPublicity.io to Promote offers?',
                'ans' => 'Yes definitely! You can use MouthPublicity.io to easily create and promote your business offers in your customer network.'
            ),
             array(
                'que' => 'How to change my shop location?',
                'ans' => 'Please go to settings and edit the address of your shop.'
            ),
             array(
                'que' => 'How to track the customer moves?',
                'ans' => 'You can analyse all analytics of your customer on the dashboard.'
            ),
            array(
                'que' => 'I don\'t use WhatsApp. Can I use MouthPublicity.io?',
                'ans' => 'MouthPublicity.io all apps work through WhatsApp as its prominent feature is sharing the content. All the content sharing is carried out on WhatsApp; so to use MouthPublicity.io one need to compulsory have WhatsApp.'
            ),
            array(
                'que' => 'What is the benefit of social posts?',
                'ans' => 'You can use this for promotional purposes on social media.'
            ),
            array(
                'que' => 'Do I have to pay for a social post',
                'ans' => 'This is free from MouthPublicity.io with the plan.'
            ),
            array(
                'que' => 'What is the use of the draft offer option?',
                'ans' => 'We can create the offer and draft it for future purposes.'
            ),
            array(
                'que' => 'What is meant by unique & Extra click?',
                'ans' => '<b>Unique Click</b> - If a person opens the offer link once.<br> 
                <b>Extra Click </b>- If a person opens the offer link more than once.'
            ),
            array(
                'que' => 'Why am I unable to see Today\'s clicks statistics?',
                'ans' => 'Statistics show present data on the next day or you can see the last 7 days data at a time.'
            ),
            array(
                'que' => 'Where I can check my plan\'s expiry date?',
                'ans' => 'In admin dashboard in subscription option.'
            ),
            array(
                'que' => 'Can I add a video from YouTube to my offer?',
                'ans' => 'Yes, you can add video while creating an offer by using our offer template.'
            ),
            array(
                'que' => 'What is the use of the suspended option in the employee dashboard?',
                'ans' => 'For removing the employee from the employee list.'
            ),
            array(
                'que' => 'Whom should I approach in case of MouthPublicity.io product query?',
                'ans' => 'If you have any questions, just feel Personal to talk to us 24x7 i.e., anytime, from anywhere. Connect with us on <a href="'.url('mouthpublicity.io').'">care@mouthpublicity.io</a> or 07887882244.'
            ),
            array(
                'que' => 'Can MouthPublicity.io be used for any small-scale industry?',
                'ans' => 'Yes, You can use MouthPublicity.io for small as well as large-scale industries.'
            ),
            array(
                'que' => 'What is the use of an employee account?',
                'ans' => 'It provides a platform for multiple billing systems and employee details.'
            ),
            array(
                'que' => 'Can employees create an offer?',
                'ans' => 'No, the employee can share the offers but can not create offers.'
            ),
            array(
                'que' => 'Do employees need a WhatsApp Number to log in to an account?',
                'ans' => 'No, not required to be a WhatsApp user. but a WhatsApp number is mandatory to share the offers and posts.'
            ),
           
            


        );
        @endphp


    <!--  que ans section -->
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center mt-5">
            <div class="col-xl-7 col-lg-8 col-12 px-0 px-sm-3">
                <div class="accordion faqsAc" id="faq_accordian">

                    @php $i=0; @endphp
                    @foreach($faqs as $faq)
                    <div class="accordion-item">
                        <div class="accordion-header {{(!$i) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#faqs{{$i}}" aria-expanded="{{(!$i) ? 'true' : 'false' }}" aria-controls="faqs{{$i}}">
                            <h3 class="faq-que">{{$faq['que']}}</h3>
                        </div>
                        <div id="faqs{{$i}}" class="accordion-collapse collapse {{(!$i) ? 'show' : '' }}">
                            <div class="accordion-body">
                                <p class="faq-ans">{!!$faq['ans']!!}</p>
                            </div>
                        </div>
                    </div>
                    @php $i++; @endphp
                    @endforeach
                
                </div>
                {{-- <button type="button" class="btn-theme b1 mt-3 ">next</button>  --}}
            </div> 
        </div> 
    </div>

    </div>    
          
</section>
@endsection

@section('end_body')
    <script>
        // $(document).ready(function() {

        //     $('#search').keyup(function(e) {
        //         var s = $(this).val().trim();
        //         if (s === '') {
        //             $('#faq_accordian .accordion-item').show();
        //             return true;
        //         }
        //         $('#faq_accordian .faq-que:not(:contains(' + s + '))').parent('.accordion-item').hide();
        //         $('#faq_accordian .faq-que:contains(' + s + ')').parent('.accordion-item').show();
        //         return true;
        //     });

        // }); // end document ready
    </script>

<script src="https://cdn.jsdelivr.net/mark.js/7.0.0/jquery.mark.min.js"></script>
<script>
    $(function() {
      
        $("#faq_search").on("input.highlight", function() {

            var searchTerm = $(this).val();
            searchTerm = searchTerm.toLowerCase();

            $(".faq-que").unmark().mark(searchTerm);
            $(".faq-ans").unmark().mark(searchTerm);
            
            $(".accordion-item").each(function(){
                var que = $(this).text();
                que = que.toLowerCase();
                if(que.includes(searchTerm)){
                    $(this).show();
                }else{
                    $(this).hide();
                }
            });

        }).trigger("input.highlight").focus();

    });
</script>
@endsection