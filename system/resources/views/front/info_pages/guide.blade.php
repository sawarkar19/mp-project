<!DOCTYPE html>
<html lang="en">
<head>
    <title>Guide Dashboard | MouthPublicity</title>
    <meta name="title" content="Guide Dashboard | MouthPublicity">
    <meta name="description" content=" See here & track your progress for all the businesses you took the challenge as a guide. Track the number of active offers, stores,  shared, completed, redeemed, etc.">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta property="og:image" content="{{ asset('assets/front/images/guide-page/guide-thumbnail.jpg') }}" />
    <meta property="og:image:width" content="1200"/>
    <meta property="og:image:height" content="627"/>

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="{{ asset('assets/front/vendor/bootstrap/css/bootstrap.min.css') }}" media="all">
    <!-- ICONS (Bootstrap) V1.5.0 -->
    <link rel="stylesheet" href="{{ asset('assets/front/vendor/bootstrap-icons/font/bootstrap-icons.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawsome/all.min.css') }}" media="all">
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}" media="all">
    

    <style>
        body{
            font-family: var(--font-h1);    
        }
        .section_body{
            position: relative;
            width: 100%;
            padding-top: 50px;
            padding-bottom: 50px;
            min-height: 100vh;
        }
        .section_body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.3;
            z-index: 1;
            background: #c0f3fe;
            /*background: var(--color-thm-shd);*/
        }
        .sb-upper{
            position: relative;
            z-index: 2;
        }
        
        .headings{
            font-family: var(--font-h1);
        }

        .user-card,
        .analytic-card,
        .offer-card{
            position: relative;
            background-color: #FFF;
            border-radius: 10px;
            overflow: hidden;
            width: 100%;
            max-width: 26rem;
            margin-top: .75rem;
            margin-bottom: .75rem;
            font-family: var(--font-h1);
        }
        .offer-card{
            margin: 10px auto;
        }
        .offer-card .oc-inner{
            padding: 5px
        }
        .offer-card .oc-img,
        .offer-card .oc-title{
            position: relative;
            text-align: center;
        }
        .offer-card .oc-title{
            padding: 15px 10px;
            color: var(--color-thm-lth);
        }
        .offer-card .oc-img > .oc-img-thumb{
            position: relative;
            width: 100%;
            padding-bottom: 60%;
            background-color: #F2F2F2;
            background-position: top left;
            background-size: cover;
            background-repeat: no-repeat;
            border-radius: 10px;
            transition: all 800ms ease;
            background-image: url({{asset('assets/front/images/no-preview.jpg')}});
        }
        .offer-card .oc-img > .oc-img-thumb:hover{
            background-position: bottom right;
        }
        .offer-card .oc-analytics{
            background-color: lemonchiffon;
            border-radius: 8px;
        }

        .offer-card .oc-analytics.expired{
            background-color: #ffcaca;
            border-radius: 8px;
        }

        .offer-card .oc-analytics .anlt-colm{
            text-align: center;
        }
        .offer-card .oc-analytics .col-4:not(:first-child) .anlt-colm{
            border-left: 1px solid rgba(0, 0, 0, 0.1);
        }
        .offer-card .oc-analytics .anlt-colm .head{
            font-size: 12px;
            margin-bottom: .3rem;
        }
        .offer-card .oc-analytics .anlt-colm .anlt-data{
            margin-bottom: 0px;
            font-size: 18px;
        }

        .offer-card .oc-complete{
            background-color: #dfffe9;
            border-radius: 8px;
        }
        .offer-card .oc-complete .ico-done{
            position: relative;
            width: 50px;
            margin-right: 10px;
        }
        .offer-card .oc-expired{
            background-color: #ffe5e4;
            border-radius: 8px;
        }

        .offer-card .oc-share-option,
        .offer-card .business-option{
            padding: 15px 10px;
        }
        .business-logo{
            height: 48px;
        }
        .small{
            font-size: 80%;
        }
        .dashed-diveder{
            position: relative;
            margin: 0 15px;
            width: calc(100% - 20px);
            border-bottom: 1px dashed rgba(0, 0, 0, 0.1);
        }

        li.marBtn {
            margin: 0px 5px;
        }
        .offer-nav{
            position: relative;
            /*background-color: #fff;
            border-radius: 10px;
            overflow: hidden;*/
        }
        .offer-nav .nav{
            justify-content: space-around;
            width: 100%;
            border: none;
        }
        .offer-nav .nav > .nav-item{
            min-width: 23%!important;
        }
        .offer-nav .nav > .nav-item > .nav-link{
            width: 100%;
            text-align: center;
            transition: all 300ms ease;
            border-radius: 10px; 
            border: 0px;
            background-color: #fff;
            color: #222;
            font-size: 19px;
            padding: 13px 0px;
        }
        .offer-nav .nav > .nav-item > .nav-link:hover{
            background: #f2f2f2;
        }
        .offer-nav .nav > .nav-item > .nav-link.active{
            background: var(--color-thm-shd);
            color: #fff; 
        }

        .imp-links{
            position: relative;
            list-style: none;
            padding-left: 0px;
            text-align: center;
        }
        .imp-links li{
            display: inline-block;
            margin: 0 10px 10px 0;
        }
        .imp-links li a{
            text-decoration: none;
            color: inherit;
            font-size: 13px;
            padding: .3rem;
            transition: all 300ms ease;
        }
        .imp-links li a:hover{
            text-decoration: underline;
        }


        #footer{
            font-family: var(--font-h1);
        }
        .footer-logo {
            width: 100%;
            max-width: 100px;
        }
        .lh-1{
            line-height: 1.3!important;
        }
        .redirect-to-offer{
            cursor: pointer;
        }
        .no_recored {
            position: relative;
            width: 100%;
            padding: 40px 10px;
            background: transparent;
            border: 1px dashed #222;
            border-radius: 4px;
            color: #222;
            font-size: 1rem;
            text-align: center;
        }        
        #accordion-complt-chlng .accordion-button:not(.collapsed) {
            color: #000000;
            background-color: #ffffff;
            box-shadow: inset 0 -1px 0 rgb(0 0 0 / 13%);
        }
        

        #accordion-complt-chlng .accordion-button:focus {
            box-shadow: none;
        }

        .challenge-type{
            background: var(--color-thm-shd);
            color: #fff;
            margin-bottom: 3px;
            border-radius: 7px;
            text-align: center;
        }

        @media(max-width:767px){
            .offer-nav .nav > .nav-item {
                min-width: 47%!important;
            }
            .offer-nav .nav > .nav-item > .nav-link{
                padding: 5px 10px;
                margin-bottom: 10px;
            }
        }
        @media(max-width:575px){
            .section_body{
                padding-top: 15px;
                padding-bottom: 15px;
            }
            
        }
    </style>
</head>
<body>
    <section class="section_body">

        <div class="container sb-upper">

            <!--user Details -->
            <div class="">
                <div class="user-card_ shadow-sm_">
                    <div class="inner p-3">
                        <div class="">
                            <h6>Hello,</h6>
                            <h5 class="mb-0">{{ $guide->mobile }}</h5> <!-- Customer User Mobile Number -->
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div id="analytics">
                <div class="row">

                    <div class="col-lg-3 col-6 redirect-to-offer" data-challenge_card_name="total_challenge">
                        <div class="analytic-card shadow-sm">
                            <div class="inner text-center p-3">
                                <div class="">
                                    <h2>{{ $total_count }}</h2>
                                </div>
                                <div>
                                    <p class="small mb-0">Total Challenges</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6 redirect-to-offer" data-challenge_card_name="challenge_in_progress">
                        <div class="analytic-card shadow-sm">
                            <div class="inner text-center p-3">
                                <div class="">
                                    <h2>{{ $active_count }}</h2>
                                </div>
                                <div>
                                    <p class="small mb-0">Challenges in Progress</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-6 redirect-to-offer" data-challenge_card_name="instant_challenge">
                        <div class="analytic-card shadow-sm">
                            <div class="inner text-center p-3">
                                <div class="">
                                    <h2>{{ $instant_reward }}</h2>
                                </div>
                                <div>
                                    <p class="small mb-0">Instant Challenge</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6 redirect-to-offer" data-challenge_card_name="share_challenge">
                        <div class="analytic-card shadow-sm">
                            <div class="inner text-center p-3">
                                <div class="">
                                    <h2>{{ $share_and_reward }}</h2>
                                </div>
                                <div>
                                    <p class="small mb-0">Share Challenge</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <hr>

           
            <div class="accordion py-3" id="accordion-complt-chlng">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingChlng">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseChnlng" aria-expanded="false" aria-controls="collapseChnlng">How to complete the challenge to get discounts and gifts ?</button>
                    </h2>
                    <div id="collapseChnlng" class="accordion-collapse collapse" aria-labelledby="headingChlng" data-bs-parent="#accordion-complt-chlng">
                      <div class="accordion-body">
                        <div class="complete-challenge-accord px-3">
                            <h5 class="h5 mt-3">1. How to Complete the Instant Challenge?</h3>
                            <ul class="mt-3">
                                <li>Click on the first challenge link you have received from the shopkeeper or business on your WhatsApp or SMS.</li>
                                <li>Complete the minimum number of tasks as shown on the page ( such as like, share, follow, subscribe, visit website etc.)</li>
                                <li>Once you complete the challenge, you'll receive a redeem code on your WhatsApp or SMS inbox.</li>
                                <li>Share the received Redeem code with the business/shopkeeper to get a discount or a gift.</li>
                            </ul>
                            {{-- <h5 class="h5 mt-3">2. How to Complete the Share Challenge?</h3>
                            <ul class="mt-3">
                                <li>Click on the 2nd challenge link you have received from the shopkeeper or business on your WhatsApp & open the webpage on your web/mobile browser.</li>
                                <li>Copy the link you have opened in your browser and share it in your network through social media channels like WhatsApp, Facebook, Twitter, etc.</li>
                                <li>Share as much as possible to achieve the targeted clicks to unlock the discounts, gifts, or cashback. On completion of target clicks, you'll receive the code/OTP.</li>
                                <li>Share the OTP/redeem code with the business/shopkeeper to get the gift, discount, or a cashback.</li>
                            </ul> --}}
                            <h5 class="h5 mt-3">2. How to Complete the Share Challenge?</h3>
                                <ul class="mt-3">
                                    <li>You will receive the link from the shopkeeper or business person after few hours/days of completion of Instant Challenge.</li>
                                    <li>Click on the link you have received from the shopkeeper or business person on your WhatsApp or SMS & open on your web/mobile browser.</li>
                                    <li>Click on the share button which is placed on the bottom left of the page.</li>
                                    <li>You can copy the link from the address bar also you can use the browser's default share button and share it with your network through social media channels like WhatsApp, Facebook, Twitter, etc. as much as possible to get counts.</li>
                                    <li>Once you completed the number of counts which is targeted by shopkeeper or business person, you will receive a Redeem code on your WhatsApp or SMS.</li>
                                    <li>Share the received Redeem code with the business/shopkeeper to get a discount or a gift.</li>
                                </ul>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <hr>
            

            <div class="headings">
                <h3 class="fw-bold">Your Challenges</h3>

                <div class="offer-nav my-4">
                    <ul class="nav nav-tabs" id="OTab" role="tablist">
                        <li class="nav-item marBtn" role="presentation" id="mystore_challenge">
                            <a class="nav-link challenge_nav_link" href="#" id="mystore-tab" data-bs-toggle="tab" data-bs-target="#mystore" role="tab" aria-controls="mystore" aria-selected="false">My Stores</a>
                        </li>
                        <li class="nav-item marBtn" role="presentation" id="total_challenge">
                            <a class="nav-link challenge_nav_link" href="#" id="alloff-tab" data-bs-toggle="tab" data-bs-target="#alloff" role="tab" aria-controls="alloff" aria-selected="true">All Challenges</a>
                        </li>
                        <li class="nav-item marBtn" role="presentation" id="challenge_in_progress">
                            <a class="nav-link challenge_nav_link" href="#" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" role="tab" aria-controls="active" aria-selected="false">Active</a>
                        </li>
                        <li class="nav-item marBtn" role="presentation" id="completed_challenge">
                            <a class="nav-link challenge_nav_link" href="#" id="complete-tab" data-bs-toggle="tab" data-bs-target="#complete" role="tab" aria-controls="complete" aria-selected="false">Completed</a>
                        </li>

                    </ul>

                </div>

            </div>

            {{-- Tabs --}}
            <div class="">
                <div class="tab-content" id="OfferTabs">

                {{-- My Stores --}}
                <div class="tab-pane challenge_tab fade" id="mystore" role="tabpanel" aria-labelledby="mystore-tab">
                    <div class="row">
                    @if(count($my_stores) >= 1)
                        {{-- All Offer List --}}
                    
                        @include('front.info_pages.store_offers', ['all_offers' => $my_stores])

                    @else
                        <div class="col-md-12"  id="offerNotFound">
                           <div class="no_recored text-center">
                                <h3>{{ Config::get('constants.no_record_found') }}</h3>
                           </div>
                         </div>
                    @endif

                        {{-- END - All Offer List --}}
                    </div>

                    <div class="offer-pagination text-center" style="margin: 25px auto;">
                        {{ $my_stores->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
                
                {{-- All Offers --}}
                <div class="tab-pane challenge_tab fade show" id="alloff" role="tabpanel" aria-labelledby="alloff-tab">
                    <div class="row">
                    @if(count($all_offers) >= 1)
                        {{-- All Offer List --}}
                    
                        @include('front.info_pages.all_offer', ['all_offers' => $all_offers])

                    @else
                        <div class="col-md-12"  id="offerNotFound">
                           <div class="no_recored text-center">
                                <h3>{{ Config::get('constants.no_record_found') }}</h3>
                           </div>
                         </div>
                    @endif

                        {{-- END - All Offer List --}}
                    </div>

                    <div class="offer-pagination text-center" style="margin: 25px auto;">
                        {{ $all_offers->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>

                {{-- Active Offers --}}
                <div class="tab-pane challenge_tab fade" id="active" role="tabpanel" aria-labelledby="active-tab">
                    <div class="row">
                    @if(count($active_offers) >= 1)
                        {{-- All Offer List --}}
                    
                        @include('front.info_pages.all_offer', ['all_offers' => $active_offers])

                    @else
                        <div class="col-md-12"  id="offerNotFound">
                           <div class="no_recored text-center">
                                <h3>{{ Config::get('constants.no_record_found') }}</h3>
                           </div>
                         </div>
                    @endif

                        {{-- END - All Offer List --}}
                    </div>

                    <div class="offer-pagination text-center" style="margin: 25px auto;">
                        {{ $active_offers->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>

                {{-- Completed Offers --}}
                <div class="tab-pane challenge_tab fade" id="complete" role="tabpanel" aria-labelledby="complete-tab">
                    <div class="row">
                    @if(count($completed_offers) >= 1)
                        {{-- All Offer List --}}
                    
                        @include('front.info_pages.all_offer', ['all_offers' => $completed_offers])

                    @else
                        <div class="col-md-12"  id="offerNotFound">
                           <div class="no_recored text-center">
                                <h3>{{ Config::get('constants.no_record_found') }}</h3>
                           </div>
                         </div>
                    @endif

                        {{-- END - All Offer List --}}
                    </div>

                    <div class="offer-pagination text-center" style="margin: 25px auto;">
                        {{ $completed_offers->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>

            </div>


            <footer id="footer">
                <div class="text-center">
                    <div>
                        <p class="copyright">&copy; {{ date('Y') }} All rights reserved | Powered By 
                            <a href="https://logicinnovates.com/" target="_blank" class="brandname">
                            <span class="color-drk">Logic Innovates</span>
                            </a>
                        </p>
                    </div>
    
                    <div>
                        <ul class="imp-links mb-0">
                            <li><a target="_blank" href="{{ url('privacy-policy') }}">Privacy Policy</a></li>
                            <li><a data-bs-toggle="modal" data-bs-target="#termsandcondition">Terms & Conditions</a></li>
                            {{-- <li><a target="_blank" href="{{ url('terms-and-conditions') }}">Terms & Condition</a></li> --}}
                            <!-- <li><a target="_blank" href="{{ url('how-to-redeem') }}">How to redeem?</a></li> -->
                        </ul>
                    </div>
                </div>
            </footer>
        </div>




        

    </section>

    <!-- Terms and Conditions Modal -->
    <div class="modal fade" id="termsandcondition" tabindex="-1" aria-labelledby="termsandconditionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="termsandconditionLabel">Terms & Conditions</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="terms-div">
                        <ul>
                            <li class="mb-2 small">The task Share challenge you can complete from anywhere.</li>
                            <li class="mb-2 small">It is not necessary to be present in the shop for completing the task.</li>
                            <li class="mb-2 small">Here a business person sends you a link via SMS or Whatsapp for completing the task share challenge.</li>
                            <li class="mb-2 small">In this task business owners set the time period like 2 hours, 4 hours, 6 hours, 24 hours, 1 day, or 72 hours, and they want a minimum 10 clicks from you, after that you are eligible to take a discount.</li>
                            <li class="mb-2 small">Suppose in a link a business owner gives you 4 hours to complete the task, and gives you a task that you have share with your networks, family, friends, etc.</li>
                            <li class="mb-2 small">After sharing the link with family and friends, ensure that they click on the link. Because they didn’t click on your given link then you are not eligible for a discount.</li>
                            <li class="mb-2 small">Suppose you will get 10 links from your network then you are eligible for a discount, because a business person wants a minimum 10 clicks from you.</li>
                            <li class="mb-2 small">After completing the task, the business owner sends you a code.</li>
                            <li class="mb-2 small">Then you have to visit the shop to get the discount on purchase.</li>
                            {{-- <li class="mb-2 small text-danger">Note:  This offer is only valid once per customer during the offer period.</li> --}}
                        </ul>
                        <p class="text-danger">Note:  This offer is only valid once per customer during the offer period.</p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/front/vendor/jQuery/jQuery.min.js') }}"></script>
    <script src="{{ asset('assets/front/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <script>

        /* Store cookie */
        function setCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            let expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        /*getting all cookies values*/
        function checkUserCookie(){
            var old_customer = false;
            var customer_uuid = '';
            var allCookiesArray = document.cookie.split(';');
            var hasCookie = false;

            for (var i = 0; i < allCookiesArray.length; i++ ){
                var singleCookie = allCookiesArray[i].split('=');

                if(singleCookie[0].trim() == 'guide_page_tab'){
                    var selected_tab = singleCookie[1];
                    if(selected_tab == "completed_challenge"){
                        $("#complete-tab").addClass('active');
                        $("#complete").addClass('show');
                        $("#complete").addClass('active');
                    }
                    else if(selected_tab == "total_challenge"){
                        $("#alloff-tab").addClass('active');
                        $("#alloff").addClass('show');
                        $("#alloff").addClass('active');
                    }else if(selected_tab == "challenge_in_progress"){
                        $("#active-tab").addClass('active');
                        $("#active").addClass('show');
                        $("#active").addClass('active');
                    }else if(selected_tab == "mystore_challenge"){
                        $("#mystore-tab").addClass('active');
                        $("#mystore").addClass('show');
                        $("#mystore").addClass('active');
                    }

                    hasCookie = true;
                }
            }

            if(hasCookie == false){
                $("#alloff-tab").addClass('active');
                $("#alloff").addClass('show');
                $("#alloff").addClass('active');
            }

            if(sessionStorage.getItem("scroll_view") == "true"){
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#alloff-tab").offset().top
                }, 500);
            }
            
        }

        $(".nav-item.marBtn").click(function() {
            //set cookie
            var tabSelected = $(this).attr('id');
            setCookie('guide_page_tab', tabSelected, 1);

            
            sessionStorage.removeItem("scroll_view");

            window.location.href = '{{ $guide_url }}';
        });

        $( document ).ready(function() {
            sessionStorage.removeItem("scroll_view");
            checkUserCookie();
        });

        $(".redirect-to-offer").click(function() {
            sessionStorage.setItem("scroll_view", "true");
            
            // Active Tab as per select Card
            var challenge_card_name = $(this).attr("data-challenge_card_name");
            $(".challenge_nav_link").removeClass('active');
            $(".challenge_tab").removeClass('show');
            $(".challenge_tab").removeClass('active');

            var tab_name = 'total_challenge';
            if(challenge_card_name == "challenge_in_progress"){
                tab_name = 'challenge_in_progress';
            }
            else{
                tab_name = 'total_challenge';
            }

            //set cookie
            setCookie('guide_page_tab', tab_name, 1);

            window.location.href = '{{ $guide_url }}';
        });

        $(document).on('click', '.cashbackRedeem', function(e){
            e.preventDefault();

            var btn = $(this);
            var btnhtml = btn.text();
            
            var uuid = $(this).attr('id');

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var input = {
                "uuid" : uuid,
                "_token" : CSRF_TOKEN
            };

            $.ajax({
                url : "{{url('/cashback/redeem')}}/" + uuid,
                type : 'POST',
                data : input,
                dataType : "json",
                beforeSend: function() {                    
                    btn.attr('disabled','')
                    btn.html('Please Wait....')
                },
                success : function(data) {
                    
                    if(data.status == false){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.response
                        });
                    }else if(data.status == true){
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.response
                          });
                    }
                    btn.removeAttr('disabled');
                    btn.html(btnhtml);
                }
            });
        });
    </script>

    
</body>
</html>