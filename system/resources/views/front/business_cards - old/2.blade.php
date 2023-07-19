<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>V card</title>
        <link rel="stylesheet" href="{{ asset('assets/front/vendor/bootstrap/css/bootstrap.min.css') }}" media="all">
        <!-- <link rel="stylesheet" href="{{ asset('assets/front/vendor/bootstrap-icons/font/bootstrap-icons.css') }}" media="all"> -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

        <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@300;400&family=Playfair+Display:wght@400;500;700&display=swap');
            .v_card{
                position: relative;
                width: 1000px;
                max-width: 100%;
                margin: auto;
                background-color: #F7F7F7;
            }
            .card_inside_container{
                position: relative;
                width: 940px;
                max-width: 100%;
                margin: auto; 
            }
            .background_image{
                padding: 140px 10px 185px;
                background-size: cover;
                opacity: 0.8;
                background-repeat: no-repeat; 
                background-image: url({{asset('assets/front/images/v_cards/banner1.jpg')}});
                
            }
            .bg_color{
            background-color: #2a0b00;
            }
            .business_name{
                color: #ffffff;
            }
            .image{
                position: relative;
            }
            .image .card{
                position: relative;
                top: -100px;
                width: 500px;
                max-width: 100%;
                margin: auto;
                border-style: none;
                box-shadow: 3px 3px 8px #00000038;
            }
            .qr-box{
                width: 100%;
                padding: 1px;
                border: 1px solid var(--bs-success);
            }
            .qr-box svg{
                width: 100%!important;
                height: auto!important;
            }
            .qr_code i::before{
                font-size: 110px;
            }
            .qr_code p{
                font-size: 12px;
                font-family: Lato;
            }
            .v_card{
                font-family: Lato;
            }
            .name i::before{
                font-size: 21px;
            }
            .bottom_line{
                position: absolute;
                transform: translateX(-50%);
                bottom: 0;
                left: 50%;
                width: 40%;
                text-align: center;
                height: 6px;
                background-color: #DE3C3C;
            }
            .v_card h2{
                font-family: Playfair Display;
                font-weight: 700;
            }
            .about_us_img img{
                width: 400px;
                max-width: 100%;
            }
            .services h4{
                font-family: Playfair Display;
                font-weight: 500;
            }
            .services_number h1{
                font-size: 66px;
                color: #8b8b8b;
            }
            .services_content{
                border-left: 2px solid #D12600;
            }
            .services_one, .services_two{
                border-bottom: 0.5px solid #eaeaea;
            }
            .gallery img{
                width: 400px;
                max-width: 100%;
            }
            .about_us_img::before{
                content: '';
                position: absolute;
                left: 0px;
                bottom: -19px;
                width: 80px;
                height: 80px;
                box-shadow: 1px 6px 14px #d2d2d2;
                border-radius: 50%;
                background-image: linear-gradient(to top, #DE3C3C, #F27724);
                overflow: hidden;
            }   
             .about_us_img::after{
                content: '';
                position: absolute;
                left: 0px;
                bottom: -35px;
                width: 22px;
                height: 22px;
                box-shadow: 1px 6px 14px #d2d2d2;
                border-radius: 50%;
                background-image: linear-gradient(to top, #DE3C3C, #F27724);
                overflow: hidden;
            } 
            .services_three::before{
                content: '';
                position: absolute;
                right: 11px;
                bottom: -17px;
                width: 70px;
                height: 70px;
                box-shadow: 1px 6px 14px #d2d2d2;
                border-radius: 50%;
                background-image: linear-gradient(to top, #DE3C3C, #F27724);
                overflow: hidden;
            } 
             .services_three::after{
                content: '';
                position: absolute;
                right: 2px;
                bottom: -42px;
                width: 22px;
                height: 22px;
                box-shadow: 1px 6px 14px #d2d2d2;
                border-radius: 50%;
                background-image: linear-gradient(to top, #DE3C3C, #F27724);
                overflow: hidden;
            }
            .footer{
                background-color: #DE3C3C;
            }
            .footer ul{
                list-style: none;
                display: inline-block;
            }
            .footer ul li{
                display: inline-block;
                padding-right: 10px;
            }
            .footer ul li i{
                display: inline-block;
                color: #fff;
                font-size: 20px;
            }
        @media(max-width: 768px){
            .background_image{
                padding: 50px 10px 50px;
            }    
            .image .card { 
                top: 10px;
            }  
            .gallery img{
                margin-bottom: 20px;
            }
            .services_content{
                border-style: none;
            }
        }          
        </style>
    </head>
    <body>
        @php
            // dd($businessDetail);
            // Personal Information
            $firstName = $businessDetail->business_name;
            $lastName = '';
            $title = '';
            $email = $businessDetail->owner->email;

            // Addresses
            $homeAddress = [
                'type' => 'home',
                'pref' => true,
                'street' => '',
                'city' => '',
                'state' => '',
                'country' => '',
                'zip' => ''
            ];

            if($businessDetail->address_line_2 != null){
                $address = $businessDetail->address_line_1.', '.$businessDetail->address_line_2;
            }else{
                $address = $businessDetail->address_line_1 ?? '';
            }

            $wordAddress = [
                'type' => 'work',
                'pref' => false,
                'street' => $address ?? '',
                'city' => $businessDetail->city ?? '',
                'state' => $businessDetail->state ?? '',
                'country' => 'India',
                'zip' => $businessDetail->pincode ?? ''
            ];
            
            $addresses = [$homeAddress, $wordAddress];
            
            // Phones
            $workPhone = [
                'type' => 'work',
                'number' => '+91'.$businessDetail->owner->mobile ?? '',
                'cellPhone' => false
            ];
            $homePhone = [
                'type' => 'home',
                'number' => '',
                'cellPhone' => false
            ];
            $cellPhone = [
                'type' => 'work',
                'number' => '',
                'cellPhone' => true
            ];
            
            $phones = [$workPhone, $homePhone, $cellPhone];
        @endphp

        <section class="v_card">
            <div class="container pb-5">
                {{--bg image and card section start--}}
                <div class="image pb-4 pb-sm-0">
                    <div class="bg_color">
                        <div class="background_image">
                            <div class="logo text-center">
                               <img src="{{ asset('assets/business/logos/'.$businessDetail->logo) }}" style="width: 100px;">
                           </div> 
                           <div class="business_name text-center">
                                @if($businessDetail->business_name!='')
                                   <h4 class="mb-0 mt-2">{{ $businessDetail->business_name }}</h4>
                                @endif
                                @if($businessDetail->tag_line!='')
                                    <p>{{ $businessDetail->tag_line }}</p>
                                @endif    
                           </div>
                        </div>    
                    </div>
                    
                    <div class="card p-3">
                        <div class="row align-items-center">
                            <div class="col-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="qr_code text-center">
                                    <div class="qr-box">
                                    {!! 
                                        QRCode::vCard($firstName, $lastName, $title, $email, $addresses, $phones)
                                        ->setErrorCorrectionLevel('H')
                                        ->setSize(4)
                                        ->setMargin(2)
                                        ->svg() 
                                    !!}
                                    </div>
                                    {{-- <i class="bi bi-qr-code"></i> --}}
                                    <p class="mt-2">Scan this above QR Code to save our contact details</p>
                                </div>    
                            </div> 
                            <div class="col-12 col-sm-8 col-md-8 col-lg-8">

                                {{-- Owner Name --}}
                                @if($businessDetail->owner->name!='')
                                    <div class="name d-flex mb-3">
                                        <i class="bi bi-person-fill pe-2"></i>
                                        <h6 class="mb-0">{{ $businessDetail->owner->name }}</h6>  
                                    </div>
                                @endif

                                {{-- EMail ID  --}}
                                @if($businessDetail->owner->email!='')
                                    <div class="mail d-flex mb-3">
                                        <i class="bi bi-envelope-fill pe-2"></i>
                                        <h6 class="mb-0">{{ $businessDetail->owner->email }}</h6>  
                                    </div>
                                @endif

                                {{-- Mobile  --}}
                                @if($businessDetail->owner->mobile!='')
                                    <div class="phone d-flex mb-3">
                                        <i class="bi bi-telephone-fill pe-2"></i>
                                        <h6 class="mb-0">{{ $businessDetail->owner->mobile }}</h6>  
                                    </div>
                                @endif

                                {{-- Address  --}}
                                @if($businessDetail->address_line_1!='')
                                    <div class="add d-flex mb-3">
                                        <i class="bi bi-geo-alt-fill pe-2"></i>
                                        <h6 class="mb-0">
                                            {{ $businessDetail->address_line_1 }}, 
                                            {{ $businessDetail->city }},
                                            {{ $businessDetail->state }},
                                            {{ $businessDetail->country }} - {{ $businessDetail->pincode }}
                                        </h6>
                                    </div>
                                @endif
                            </div>  
                        </div>
                        <div class="bottom_line"></div>
                    </div>    
                </div>
                {{--bg image and card section end--}}
                 {{--about us section start--}}
                <div class="card_inside_container mt-2 mt-md-0">
                    <div class="about_us py-4 pt-sm-0">
                      <div class="row justify-content-between">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6  ps-3">
                            <div class="about_us_content">
                                <h2 class="my-3">About Us</h2>    
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            </div>
                        </div>  
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="about_us_img position-relative text-center">
                                <img src="{{asset('assets/front/images/v_cards/about_us1.jpg')}}">
                            </div>
                            
                        </div>  
                      </div>  
                    </div>
                    {{--about us section end--}}
                    {{--services section start--}}
                    <div class="services py-5">
                        <h2>Services We Offer</h2>
                        <div class="services_one py-4">
                            <div class="row align-items-center">
                                <div class="col-12 col-sm-2 col-md-2 col-lg-2 text-center services_number">
                                    <h1>01</h1>
                                </div>
                                <div class="col-12 col-sm-10 col-md-10 col-lg-10 position-relative services_content ps-4">
                                    <div class="services_content_one">
                                        <h4>Heading</h4>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                </div>
                            </div>   
                        </div>
                        <div class="services_two py-4">
                            <div class="row align-items-center">
                                <div class="col-12 col-sm-2 col-md-2 col-lg-2 text-center services_number">
                                    <h1>02</h1>
                                </div>
                                <div class="col-12 col-sm-10 col-md-10 col-lg-10 position-relative services_content ps-4">
                                    <div class="services_content_one">
                                        <h4>Heading</h4>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                </div>
                            </div>   
                        </div>
                        <div class="services_three py-4 position-relative">
                            <div class="row align-items-center">
                                <div class="col-12 col-sm-2 col-md-2 col-lg-2 text-center services_number">
                                    <h1>03</h1>
                                </div>
                                <div class="col-12 col-sm-10 col-md-10 col-lg-10 position-relative services_content ps-4">
                                    <div class="services_content_one">
                                        <h4>Heading</h4>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                </div>
                            </div>   
                        </div>
                    </div>
                    {{--services section end--}}
                    {{--gallery section start--}}
                    <div class="gallery pb-4">
                        <h2>Look at Our Best work</h2> 
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                               <img src="{{ asset('assets/front/images/v_cards/gallery_img1.jpg')}}"> 
                            </div>  
                            <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                               <img src="{{ asset('assets/front/images/v_cards/gallery_img2.jpg')}}"> 
                            </div> 
                            <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                               <img src="{{ asset('assets/front/images/v_cards/gallery_img3.jpg')}}"> 
                            </div>    
                        </div>     
                    </div>
                </div>
            </div>        
                    {{--gallery section end--}}
                    <div class="footer">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <ul class="my-3">
                                        @if($businessDetail->facebook_link != '')
                                            <li>
                                                <a href="{{ $businessDetail->facebook_link }}" target="_blank">
                                                    <i class="bi bi-facebook"></i>
                                                </a>
                                            </li>
                                        @endif
                                        
                                        @if($businessDetail->facebook_link != '')
                                            <li>
                                                <a href="{{ $businessDetail->facebook_link }}" target="_blank">
                                                    <i class="bi bi-whatsapp"></i>
                                                </a>
                                            </li>
                                        @endif

                                        @if($businessDetail->instagram_link != '')
                                            <li>
                                                <a href="{{ $businessDetail->instagram_link }}" target="_blank">
                                                    <i class="bi bi-instagram"></i>
                                                </a>
                                            </li>
                                        @endif

                                        @if($businessDetail->linkedin_link != '')
                                            <li>
                                                <a href="{{ $businessDetail->linkedin_link }}" target="_blank">
                                                    <i class="bi bi-linkedin"></i>
                                                </a>
                                            </li>
                                        @endif

                                        @if($businessDetail->twitter_link != '')
                                            <li>
                                                <a href="{{ $businessDetail->twitter_link }}" target="_blank">
                                                    <i class="bi bi-twitter"></i>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>   
                            </div>   
                        </div>
                    </div>  
        </section>
        <script src="{{ asset('assets/front/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    </body>
</html>