<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Business Information Page</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="{{ asset('assets/front/vendor/bootstrap/css/bootstrap.min.css') }}" media="all">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('assets/front/css/responsive.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('assets/front/css/customs.css') }}" media="all">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:wght@500;600&display=swap');
        .vbg-color-shade{
            position: relative;
            width: 100%;
            padding-top: 50px;
            padding-bottom: 50px;
        }
        .vbg-color-shade::before{
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.3;
            /* z-index: -1; */
            background: #418b7b;
        }
        .vcard-bg{
            border-radius: 14px;
            box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px; 
            background: #06382D;
            position: relative;
            z-index: 4;
            max-width: 520px;
            color: #fff;
            font-family: 'Noto Sans', sans-serif;
        }
        .vcard-bg .qr_code i::before{
            font-size: 170px;
            color: #000;
        }
        .logo img{
            width: 80px;
            max-width: 100%;
        }
        .user_details .name i::before{
                font-size: 21px;
         }
        .user_details{
            position: relative;
            list-style: none;
            padding-left: 0px;
        }
        .user_details li{
            position: relative;
            padding-left: 40px;
            margin-bottom: 10px;
        }
        .user_details li > i{
            position: absolute;
            left: 0;
            top: 4px;
            display: block;
            text-align: center;
            font-size: 14px;
        }
        .user_details li > i:before{
            font-size: 16px;
        }
        .user_details .website:hover{
            color: #c29709;
        }
        
        .user_details a{
            color: inherit;
            text-decoration: none;
        }
         .mobile_number a:hover{
            color: #b84700;
        }
        .qr-code-inner{
            background: #fff;
            padding: 10px;
            width: 239px;
            margin: auto;
            max-width: 100%;
        }
        
        .footer_social_icons{
            position: relative;
            list-style: none;
            padding-left: 0px;
        }
        .footer_social_icons .inner_social_icons{
            display: inline-block;
            margin: 3px 4px;
        }
        .footer_social_icons .inner_social_icons > a{
            display: inline-block;
            width: 30px;
            height: 30px;
            text-align: center;
            transform: scale(1);
            transition: all 100ms ease;
            color: inherit;
        }
        .footer_social_icons .inner_social_icons > a > i{
            line-height: 32px;
            font-size: 20px;
        }
        .mobile_number{
            background: #fff;
            color: #06382D;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        .mobile_number a{
            text-decoration: none;
            color: #06382D;
        }

        /* QR Code */
        .qr-box{
            width: 100%;
            padding: 1px;
            text-align: center;
            /* border: 1px solid var(--bs-success); */
        }
        .qr-box svg{
            width: 100%!important;
            height: auto!important;
        }
        @media(max-width: 575px){
            .vbg-color-shade{
                padding-top: 5px;
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
            'number' => '+91'.$businessDetail->call_number ?? '',
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
    <div class="vbg-color-shade">
        <div class="container">
            <div class="vcard-bg mx-auto">
                <div class="pt-5">
                    <div class="">
                        @if($businessDetail->logo!='')
                            <div class="logo text-center">
                                <img src="{{ asset('assets/business/logos/'.$businessDetail->logo) }}" alt="">
                            </div>
                        @endif
                        <div class="business_name text-center">
                            @if($businessDetail->business_name!='')
                                <h4 class="mb-0 mt-2">{{ $businessDetail->business_name }}</h4>
                            @endif

                            @if($businessDetail->tag_line!='')
                                <p>{{ $businessDetail->tag_line }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="text-center">
                        <ul class="footer_social_icons">
                            @if($businessDetail->facebook_link != '')
                                <li class="inner_social_icons">
                                    <a href="{{ $businessDetail->facebook_link }}" target="_blank" title="Facebook"><i class="bi bi-facebook"></i></a>
                                </li>
                            @endif
                                
                            @if($businessDetail->instagram_link != '')
                                <li class="inner_social_icons">
                                    <a href="{{ $businessDetail->instagram_link }}" target="_blank" title="Instagram"><i class="bi bi-instagram"></i></a>
                                </li>
                            @endif

                            @if($businessDetail->twitter_link != '')
                                <li class="inner_social_icons">
                                    <a href="{{ $businessDetail->twitter_link }}" target="_blank" title="Twitter"><i class="bi bi-twitter"></i></a>
                                </li>
                            @endif
                            
                            @if($businessDetail->linkedin_link != '')
                                <li class="inner_social_icons">
                                    <a href="{{ $businessDetail->linkedin_link }}" target="_blank" title="LinkedIn" ><i class="bi bi-linkedin"></i></a>
                                </li>
                            @endif
                                    
                            @if($businessDetail->youtube_link != '')
                                <li class="inner_social_icons">
                                    <a href="{{ $businessDetail->youtube_link }}" target="_blank" title="YouTube"><i class="bi bi-youtube"></i></a>
                                </li>
                            @endif
                            
                            @if($businessDetail->google_review_placeid != '')
                                <li class="inner_social_icons">
                                    <a href="https://search.google.com/local/writereview?placeid={{ $businessDetail->google_review_placeid }}" target="_blank" title="Google"><i class="bi bi-google"></i></a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="qr_code text-center">
                        <div class="qr-code-inner">
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
                        </div>
                        <p class="mt-2 small">Scan this above QR Code to save our contact details</p>
                    </div>
                    <div class="vcard-inner-bg p-sm-4">
                        <div class="px-2 pb-4 px-sm-5">
                            <ul class="user_details">
                                {{-- Owner Name --}}
                                @if($businessDetail->owner->name!='')
                                    <li class="name"><i class="bi bi-person-fill"></i>{{ $businessDetail->owner->name }}</li>
                                @endif

                                {{-- website  --}}
                                <li class="website"><i class="bi bi-globe"></i> <a href="https://www.logicinnovates.com/" target="_blank"> logicinnovates.com</a></li>
                                
                                
                                {{-- EMail ID  --}}
                                @if($businessDetail->owner->email!='')
                                    <li style="word-break: break-word;"><i class="bi bi-envelope-fill"></i> <a href="mailto:{{ $businessDetail->owner->email }}">{{ $businessDetail->owner->email }}</a></li> 
                                @endif

                                {{-- Address  --}}
                                @if($businessDetail->address_line_1!='')
                                    <li>
                                        <i class="bi bi-geo-alt-fill"></i> 
                                        <p>
                                            {{ $businessDetail->address_line_1 }}, 
                                            {{ $businessDetail->city }},
                                            {{ $businessDetail->stateDetail->name }},
                                            {{ $businessDetail->country }} - {{ $businessDetail->pincode }}
                                        </p>    
                                    </li>
                                @endif
                            </ul>
                        </div> 
                    </div>
                    <div class="mobile_number text-center py-2">
                        <h4 class="fw-bold mb-0">
                            <a href="tel:{{ $businessDetail->call_number }}">Mobile No. {{ $businessDetail->call_number }}</a>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/front/vendor/jQuery/jQuery.min.js') }}"></script>
    <script src="{{ asset('assets/front/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>