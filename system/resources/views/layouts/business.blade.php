<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Custom Links After Start-Head Tag -->
        @yield('start_head')
        <!-- Page Title -->
        <title>@yield('title')</title>
        <!-- Page Meta -->
        @include('layouts.business.meta')
        <!-- Page CSS, JS & Other Links -->
        @include('layouts.business.link')
        <!-- Custom Links After End-Head Tag -->
        @yield('end_head')



       <!--  @php
        /* Get the Marketing tool data like Google Analytics, Google Tag Manager, Facebook Pixel */
        $marketing_tools = DB::table('options')->where('key', 'marketing_tool')->first();
        $mt_data = json_decode($marketing_tools->value);
        @endphp -->



        {{-- zoho sales IQ Start --}}

            @php

            $zoho_script_data = DB::table('options')->where('key', 'zoho_sales')->first();
            $zoho_script = $zoho_script_data->value;

            @endphp

            @if ($zoho_script_data != null && $zoho_script_data->status == 1)
                {!! $zoho_script !!}
            @endif

        {{-- zoho sales IQ End --}}


        <!--Start of Tawk.to Script-->
        {{-- <script type="text/javascript">
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/6315880554f06e12d892bb5b/1gc61mlmk';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
            })();
        </script> --}}
        <!--End of Tawk.to Script-->

        <script src="{{ asset('assets/js/input-validation.js') }}" type="text/javascript" ></script>

        <style>
            .important_text{
               color: red;
            }
 
            .hero{
                padding: 25px;
            }
            .hero-tab{
                position: relative;
                border-radius: 6px;
                overflow: hidden;
                background-color: #fff;
                box-shadow: 0 4px 8px rgb(0 0 0 / 3%);
                -webkit-box-shadow: 0 4px 8px rgb(0 0 0 / 3%);
            }
            .hero-footer{
                padding: 10px 25px;
            }
            .hero-contact{
                position: relative;
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
            .hero-contact a.link{
                text-decoration: none;
                color: inherit;
                font-size: 18px;
            }
            @media (max-width:767px){
                 .hero-contact{
                     flex-direction: column;
                 }
                 .hero-contact .hf-col{
                     margin: 10px
                 }
            }
 
             .info-btn{
                color: inherit;
                font-size: 18px;
             }
 
 
 
 
             .un-ftr-cards{
                 position: relative;
             }
             .un-ftr-cards .ftr-inner{
                 position: relative;
                 padding: 2rem;
                 border-radius: 5px;
                 overflow: hidden;
                 background-color: var(--primary);
                 color: #FFF;
             }
             .un-ftr-cards .ftr-inner > .ftr-flex{
                 display: flex;
                 align-items: center;
             }
             .un-ftr-cards .img-ftr{
                 width: 130px;
                 margin-right: 15px;
             }
             .un-ftr-cards .cnt{
                 width: calc(100% - 130px);
             }
             .un-ftr-cards .ftr-content .content{
                 display: block;
                 position: relative;
                 width: 100%;
                 height: 40px;
                 overflow: hidden;
                 line-height: 1.5;
                 margin-bottom: 12px;
             }
 
             @media(max-width:575px){
                 .un-ftr-cards .ftr-inner{
                     padding: 1rem .5rem;
                 }
                 .un-ftr-cards .img-ftr{
                     width: 90px;
                 }
                 .un-ftr-cards .cnt{
                     width: calc(100% - 90px);
                 }
                 .un-ftr-cards .ftr-content .title{
                     font-size: 14px;
                 }
                 .un-ftr-cards .ftr-content .content{
                     font-size: 11px;
                     height: 49px;
                 }
                 .un-ftr-cards .ftr-btns .btn{
                     padding: 0px 8px !important;
                     height: auto;
                     line-height: 1.5;
                 }
             }
             .bg-gred-1{background-image: linear-gradient(to right, #F9BD46, #FD8259 );}
             .bg-gred-2{background-image: linear-gradient(to right, #FC8078, #FB5B76 );}
             .bg-gred-3{background-image: linear-gradient(to right, #BFB0FF, #856BE1 );}
             .bg-gred-4{background-image: linear-gradient(to right, #DAF3F3, #46A6A5 );}
             .bg-gred-5{background-image: linear-gradient(to right, #F9BD46, #FD8259 );}
             .bg-gred-6{background-image: linear-gradient(to right, #FC8078, #FB5B76 );}
             .bg-gred-7{background-image: linear-gradient(to right, #BFB0FF, #856BE1 );}
             .bg-gred-8{background-image: linear-gradient(to right, #DAF3F3, #46A6A5 );}
 
             #unpurchesed_features .owl-dots{
                 margin-top: 0px!important;
                 text-align: end;
             }
             #unpurchesed_features .owl-dots .owl-dot{
                 outline: none!important;
             }
 
             .sb-tabs{
                 position: relative;
                 width: 100%;
 
                 border-bottom: 1px solid #e1e7ed;
                 /* border-top: 1px solid #e1e7ed; */
                 border-left: 3px solid transparent;
             }
             .sb-tabs .inner{
                 position: relative;
                 padding: 20px 12px;
                 display: flex;
                 flex-direction: row;
                 justify-content: space-around;
                 align-items: center
             }
             .sb-tabs .status-icon{
                 width: 35px;
                 text-align: left;
             }
             .sb-tabs .status-icon i{
                 font-size: 1rem!important;
             }
             .sb-tabs .dirction-ico{
                 width: 15px;
                 text-align: right;
             }
             .sb-tabs .title_{
                 width: calc(100% - 50px);
                 text-align: left;
             }
             .sb-tabs .title_ h6{
                 color: #38404b;
                 margin-bottom: 3px;
                 font-size: .9rem;
                 line-height: 1.2!important;
             }
             .sb-tabs .title_ p{
                 color: rgb(117, 117, 117);
                 margin-bottom: 0px;
                 font-size: .6rem;
                 line-height: 1.2!important;
             }
 
             #b-setting-tab .nav-item >.nav-link{
                 padding: 0px;
             }
             #b-setting-tab .nav-item >.nav-link.active > .sb-tabs{
                 /* border-bottom: 1px solid #e1e7ed;
                 border-top: 1px solid #e1e7ed; */
                 border-left: 3px solid var(--primary);
                 background-color: #f8fbff;
             }
 
 
 
             .step-num{
                 margin-right: 15px;
                 width: 48px;
             }
             .step-num p{
                 font-size: 2rem;
                 margin-bottom: 0px;
                 line-height: 1;
                 color: #d9e3f3;
             }
             .wa-div{
                 position: relative;
                 width: 100%;
                 max-width: 280px;
                 margin: auto;
             }
             .wa-qr{
                 position: relative;
                 width: 100%;
                 height: auto;
                 /*padding: 5px 0px;*/
                 border: 2px solid #128C7E;
                 text-align: center;
             }
             .wa-qr img{
                 width: 100%;/*
                 max-width: 270px;*/
             }
             .reload-qr{
                 width: 100%;
                 height: 100%;
                 min-height: 280px;
                 display: flex;
                 justify-content: center;
                 align-items: center;
             }
             .reload-qr .circle-reload{
                 display: inline;
                 width: 80px;
                 height: 80px;
                 border-radius: 50%;
                 background-color: #128C7E;
                 color: #ffffff;
                 text-align: center;
             }
             .reload-qr .circle-reload i{
                 line-height: 80px;
             }
             #onClickReloadQR{
                 cursor:pointer;
             }
             .lh-1{
                 line-height: 1.5!important;
             }
 
             .default.alert-info{
                 color: #0c5460;
                 background-color: #f4fbfc;
                 border:1px solid #99c5cc;
             }
         </style>
    </head>
    <body @if (isset($_COOKIE["sidebar"]) && $_COOKIE["sidebar"] === 'mini') class="sidebar-mini" {{$_COOKIE["sidebar"]}} @endif>
        @yield('start_body')
        <div id="app">
            <div class="main-wrapper">
                <div class="navbar-bg"></div>
                    @include('layouts.partials.header')
                    @include('layouts.partials.sidebar')
                <!-- Main Content -->
                <div class="main-content">
                    <section class="section">
                        @yield('head')
                        <div class="section-body"></div>
                    </section>
                    
                    {{-- @php

                        $features = \DB::table('features')->where('status','1')->pluck('id')->toArray();

                        $todays_date = date("Y-m-d");
                        $userplan = \DB::table('userplans')->where('user_id', Auth::id())->where('will_expire_on','>=',$todays_date)->where('status',1)->pluck('feature_id')->toArray();
                        sort($userplan);

                    @endphp --}}

                    {{-- @php
                        $unpurcheased = array(
                            array('id' => 3, 'title'=>'API (via whatsapp)','img'=> 'img_8.svg','link_buy'=>3,'link_read'=>'#','content'=>'Easily Integrate any billing application with a secure, scalable, and powerful OpenChallenges Whatsapp API and communicate with your customer on Whatsapp. Save on your billing communication by replacing your SMS API with Whatsapp API that too at just at Rs1/Day.'),
                            array('id' => 4, 'title'=>'Share Challengd','img'=> 'img_5.svg','link_buy'=>4,'link_read'=>'#','content'=>'Let your own customer spread the word for your business digitally by sharing links through OpenChallenge. Set the click target and Reward them back when they achieve the target with different offers on their next purchase.'),
                            array('id' => 5, 'title'=>'Instant Challenge','img'=> 'img_6.svg','link_buy'=>5,'link_read'=>'#','content'=>'Make your customers your social media followers. Create an Instant offer, set the social media target, reward customers & grow your social media presence now!'),
                            array('id' => 6, 'title'=>'Employee','img'=> 'img_7.svg','link_buy'=>6,'link_read'=>'#','content'=>'Sit back relax, create your employee account in OpenChallenge and let your employees manage your offer sharing and offer availing process at the billing counter now.'),
                            array('id' => 7, 'title'=>'D2C Post','img'=> 'img_2.svg','link_buy'=>7,'link_read'=>'#','content'=>'Share your business update, alerts, or any other message in bulk on your customer\'s WhatsApp that too in one click. OpenChallenge gives you 100% assurance for instant delivery within no time.'),
                            array('id' => 8, 'title'=>'Personalised Messaging','img'=> 'img_3.svg','link_buy'=>8,'link_read'=>'#','content'=>'Start wishing your customer on their special day effectively and effortlessly. Just create your Birthday/Anniversary message and OpenChallenge will automatically fetch your customer data and greet them on their special day. '),
                        );
                    @endphp --}}

                    {{-- <div class="mb-4 ">
                        <div class="owl-carousel owl-theme slider" id="unpurchesed_features">
                            @if (!empty($unpurcheased))
                            @php $i = 1; @endphp
                            @foreach ($unpurcheased as $item)

                            @if(!in_array($item['id'],$userplan))
                            <div class="item">
                                <div class="un-ftr-cards">
                                    <div class="ftr-inner bg-gred-{{$i}}">
                                        <div class="ftr-flex">
                                            <div class="img-ftr">
                                                <img src="{{ asset('assets/img/cards/'.$item['img']) }}" class="w-100">
                                            </div>
                                            <div class="cnt">
                                                <div class="ftr-content">
                                                    <h5 class="title">{{$item['title']}}</h5>
                                                    <p class="content">{{$item['content']}}</p>
                                                </div>
                                                <div class="ftr-btns">
                                                    <a href="{{url('business/subscriptions/plans?feature_id='.$item['link_buy'])}}" class="btn btn-light px-sm-3 btn-sm btn-icon icon-left" style="background-color: #fff;"><i class="fas fa-shopping-cart"></i> Buy Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @php $i++; @endphp
                            @endforeach
                            @endif
                        </div>
                    </div> --}}
                    

                    @yield('content')
                </div>
                <footer class="main-footer">
                    <div class="footer-left">Copyright &copy; {{ date('Y') }}
                        <div class="bullet"></div>Powered By 
                        {{-- <a href="{{ url('/') }}">{{ env('APP_NAME') }}</a> --}}
                        <a href="https://logicinnovates.com/" target="_blank">
                        <span>Logic Innovates</span>
                        </a>
                    </div>
                </footer>
            </div>

            <a class="refresh-settings-status" href="javascript:void(0)" style="display: none">refresh-settings-status</a>
        </div>
        @include('layouts.business.scripts')
        @yield('end_body')
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });


            $(document).ready(function(){
                $("#unpurchesed_features").owlCarousel({
                    items:1,
                    margin: 10,
                    loop: true,
                    autoplay: true,
                    smartSpeed: 1000,
                    // stagePadding: 50,
                    nav:false,
                    autoplayTimeout:10000,
                });

                $(document).on("click", ".redirectOnClick", function(){
                    var tabname = $(this).attr("data-tabname");
                    sessionStorage.setItem("setting_section", tabname);
                    window.location.href = "{{ route('business.settings') }}";
                });

                $(document).on("click", ".refresh-settings-status", function(){
                    refreshSettingStatus();
                });
                // refreshSettingStatus();
                function refreshSettingStatus(){
                    $.ajax({
                        url: '{{ route("business.refreshSettingsStatus") }}',
                        type: 'GET',
                        dataType : "HTML",
                        data: { _token: '{{ csrf_token() }}' },
                        success : function(res) {
                            $("#overlay").fadeOut(300);
                            $("#refresh-status").html("");
                            $("#refresh-status").html(res);
                        }
                    });
                }
            })
        </script>

        <div id="overlay">
          <div class="cv-spinner">
            <span class="spinner"></span>
          </div>
        </div>

        {{-- Setup wizard file include  --}}
        @if(businessWizardSetup(Auth::id()) == 0)
            @include('business.wizard.index')
        @endif        
    </body>
</html>