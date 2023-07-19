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
    <!-- ICONS (Bootstrap) V1.5.0 -->

    <link rel="stylesheet" href="{{ asset('assets/front/vendor/bootstrap-icons/font/bootstrap-icons.css') }}" media="all">
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('assets/front/css/responsive.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('assets/front/css/customs.css') }}" media="all">

    <style>
        .vbg-color-shade{
            position: relative;
            width: 100%;
            padding-top: 50px;
            padding-bottom: 50px;
            min-height: 100vh;
        }
        .vbg-color-shade::before{
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 1;
             z-index: -1; 
            background: #f2f2f2;
        }
        .bg-card-box{
            background: #070707;
            max-width: 800px;
            margin: auto;
            z-index: 1;
        }
        .busines-name-sec p {
            line-height: 2px;
        }
        .busines-name-sec hr {
            border-bottom: 2px solid #d1a22f;
            opacity: 1;
            width: 129px;
            background: transparent;
        }
        .contact-info-list{
            position: relative;
            list-style: none;
            padding-left: 0px;
        }
        .contact-info-list li{
            position: relative;
            padding-left: 40px;
            margin-bottom: 10px;
        }
        .contact-info-list li > i{
            position: absolute;
            left: 0;
            top: 0;
            display: block;
            background: #d1a22f;
            color: #fff;
            width: 25px;
            height: 25px;
            text-align: center;
            font-size: 14px;
        }
        .website:hover{
            color: #d1a22f;
        }   
        .mobile:hover{
            color: #d1a22f;
        } 
        .contact-info-list a{
            color: inherit;
            text-decoration: none;
        }
        .qr-div .qr-logo img{
            max-width: 100%;
            width: 80px;
        }
        .qr-div .qr-box i::before{
            font-size: 150px;
        }
        .qr_social_icons{
            position: relative;
            list-style: none;
            padding-left: 0px;
        }
        .qr_social_icons .qr_inner_social_icons{
            display: inline-block;
            margin: 3px 4px;
        }
        .qr_social_icons .qr_inner_social_icons > a{
            display: inline-block;
            width: 30px;
            height: 30px;
            text-align: center;
            transform: scale(1);
            transition: all 100ms ease;
            color: inherit;
            border: 2px solid #d1a22f;
        }
        .qr_social_icons .qr_inner_social_icons > a > i{
            line-height: 29px;
            font-size: 18px;
        }

        /* QR Code */
        .qr-box{
            width: 260px;
            max-width: 100%;
            padding: 1px;
            text-align: center;
            /* border: 1px solid var(--bs-success); */
        }
        .qr-box svg{
            width: 100%!important;
            height: auto!important;
        }
        @media(max-width:768px){
            .qr-box{
                 width:200px;
                 max-width: 100%;
            }
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
        <div class="container pt-md-5">

            <div class="bg-card-box p-3 text-white mt-5">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="qr-div text-md-center">
                            @if($businessDetail->logo!='')
                                <div class="qr-logo">
                                    <img src="{{ asset('assets/business/logos/'.$businessDetail->logo) }}" alt="">
                                </div>
                            @endif

                            <div class="qr-box my-2 my-md-4 mx-md-auto">
                                <div class="qr-box mx-md-auto">
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
                            <p class="mb-2" style="line-height: 1.2;"><small><i>Scan this below QR Code to save our contact details.</i></small></p>
                        </div>
                        <div class="text-md-center">
                            <ul class="qr_social_icons">
                                @if($businessDetail->facebook_link != '')
                                    <li class="qr_inner_social_icons">
                                        <a href="{{ $businessDetail->facebook_link }}" target="_blank" title="Facebook"><i class="bi bi-facebook"></i></a>
                                    </li>
                                @endif
                                        
                                @if($businessDetail->instagram_link != '')
                                    <li class="qr_inner_social_icons">
                                        <a href="{{ $businessDetail->instagram_link }}" target="_blank" title="Instagram"><i class="bi bi-instagram"></i></a>
                                    </li>
                                @endif
                                        
                                @if($businessDetail->twitter_link != '')
                                    <li class="qr_inner_social_icons">
                                        <a href="{{ $businessDetail->twitter_link }}" target="_blank" title="Twitter"><i class="bi bi-twitter"></i></a>
                                    </li>
                                @endif
                                        
                                @if($businessDetail->linkedin_link != '')
                                    <li class="qr_inner_social_icons">
                                        <a href="{{ $businessDetail->linkedin_link }}" target="_blank" title="LinkedIn" ><i class="bi bi-linkedin"></i></a>
                                    </li>
                                @endif
    
                                @if($businessDetail->youtube_link != '')
                                    <li class="qr_inner_social_icons">
                                        <a href="{{ $businessDetail->youtube_link }}" target="_blank" title="YouTube"><i class="bi bi-youtube"></i></a>
                                    </li>
                                @endif

                                @if($businessDetail->google_review_placeid != '')
                                    <li class="qr_inner_social_icons">
                                        <a href="https://search.google.com/local/writereview?placeid={{ $businessDetail->google_review_placeid }}" target="_blank" title="YouTube"><i class="bi bi-google"></i></a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="ms-md-3">
                            <div class="busines-name-sec">
                                @if($businessDetail->business_name!='')    
                                    <h5 class="h5" style="color: #d1a22f;">{{ $businessDetail->business_name }}</h5>
                                @endif

                                @if($businessDetail->tag_line!='')
                                    <p class="small">{{ $businessDetail->tag_line }}</p>
                                @endif

                                <hr>
                            </div>
                            <ul class="contact-info-list mt-4">
                                {{-- Owner Name --}}
                                @if($businessDetail->owner->name!='')
                                    <li><i class="bi bi-person-fill"></i>{{ $businessDetail->owner->name }}</li>
                                @endif

                                {{-- website  --}}
                                <li class="website"><i class="bi bi-globe"></i> <a href="https://www.logicinnovates.com/" target="_blank"> logicinnovates.com</a></li>
                                
                                 {{-- Mobile  --}}
                                @if($businessDetail->call_number!='')
                                    <li class="mobile"><i class="bi bi-telephone-fill"></i> <a href="tel:{{ $businessDetail->call_number }}">{{ $businessDetail->call_number }}</a> </li>
                                @endif

                                {{-- EMail ID  --}}
                                @if($businessDetail->owner->email!='')
                                    <li><i class="bi bi-envelope-fill"></i> <a href="mailto:{{ $businessDetail->owner->email }}">{{ $businessDetail->owner->email }}</a></li>   
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
                </div>    
        
            </div>
        </div>
    </div>
    

    <script src="{{ asset('assets/front/vendor/jQuery/jQuery.min.js') }}"></script>
    <script src="{{ asset('assets/front/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>