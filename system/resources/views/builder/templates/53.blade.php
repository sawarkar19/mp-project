 @php
    $facebook_link = $business->facebook_link ?? '';
    $instagram_link = $business->instagram_link ?? '';
    $twitter_link = $business->twitter_link ?? '';
    $linkedin_link = $business->linkedin_link ?? '';
    $youtube_link = $business->youtube_link ?? '';
    $call_number = $business->call_number ?? '';
    $google_review_placeid = $business->google_review_placeid ?? '';
@endphp

<section id="Template" class="">
    <div id="builder_canvas">
        <main id="wrapper" class="">
            <section id="template-full-container" class="template-container OL-EDITABLE OL-ACTIVE" data-tab="#_main_tab_">
                <div class="template-main" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->bg_image)}});background-color: {{ $template->bg_color }};" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->bg_image)}}" id="tem_back">
                    <div class="inner-wrapper">
                        <div class="backgroundImg position-relative">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 px-0">
                                        <div class="banner_bg_flower">
                                             <div class="pt-5">
                                                    <img src="{{ asset('assets/templates/'.$id.'/img.png')}}" class="tiTle img-fluid" alt="Banner">
                                                </div>
                                            <div class="main_image mt-5 pt-5">
                                                <div class="main_image">
                                                    <span class="Design0">
                                                        <img src="{{ asset('assets/templates/'.$id.'/banner_border.png')}}" style="transform: rotate(180deg);">
                                                    </span>
                                                    <span>
                                                        <div class="OL-EDITABLE d-inline-block" data-tab="#_main_image_">
                                                            <img src="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" class="img-fluid BannerJwelImg" id="tem_main_img" alt="Banner">
                                                        </div>
                                                    </span>
                                                    <span class="Design1">
                                                        <img src="{{ asset('assets/templates/'.$id.'/banner_border.png')}}">
                                                    </span>
                                                    <span class="Design2">
                                                        <img src="{{ asset('assets/templates/'.$id.'/banner_border.png')}}">
                                                    </span> 
                                                    <span class="Design3">
                                                        <img src="{{ asset('assets/templates/'.$id.'/banner_border.png')}}">
                                                    </span> 
                                                </div>
                                            </div>
                                            <div class="temporary-container mx-auto">
                                                <div class="text-center py-5 mb-5">
                                                    <h1 class="banHead1 text-uppercase OL-EDITABLE mb-2" data-tab="#_text_1_" id="text_input_1">{{ $template->content[0]->content }}</h1>
                                                    <h3 class="banHead2 OL-EDITABLE" data-tab="#_text_2_" id="text_input_2">{{ $template->content[1]->content }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-strip">
                            <div class="container-fluid">
                                <div class="contactDiv text-center py-2 mx-auto">
                                    <ul class="contact-section d-inline-block OL-EDITABLE mb-0" data-tab="#_contact_section_">
                                        @if ($business->call_number != '')
                                            <li><a href="tel:{{ $business->call_number }}"><i class="bi bi-telephone"></i></a></li>   
                                        @endif
                                        @if ($business->whatsapp_number != '')
                                            <li><a target="_blank" href="https://wa.me/{{ $business->whatsapp_number }}"><i class="bi bi-whatsapp"></i></a></li>
                                        @endif
                                        <li>
                                            @if($business->google_map_link == '')
                                                <a href="#" data-toggle="modal" data-target="#LocationModal"><i class="bi bi-geo-alt"></i></a>
                                            @else
                                                <a href="{{ $business->google_map_link }}" target="_blank"><i class="bi bi-geo-alt"></i></a>
                                            @endif
                                        </li>
                                        @if($business->website != '')
                                            <li><a target="_blank" href="{{ $business->website }}"><i class="bi bi-globe2"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                           <div class="temp-container">
                                <div class="mt-5 pt-md-4">
                                    <div class="row">
                                        @if(!empty($template->gallery))
                                            <div class="col-12 col-md-6 mt-2 mt-md-0 order-2">
                                                <div class="OL-EDITABLE text-center" data-tab="#_gal_sec_1">
                                                    <div class="img-fluid OfferImg" id="tem_img1" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->gallery[0]->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->gallery[0]->image_path)}});"></div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-12 col-md-6 order-md-2 OfferTop">
                                            <h2 class="h3 OfferTitle OL-EDITABLE" data-tab="#_text_3_" id="text_input_3">{{ $template->content[2]->content }}</h2>
                                            <h6 class="offer_text OL-EDITABLE" data-tab="#_text_4_" id="text_input_4">{{ $template->content[3]->content }}</h6>
                                            {{-- call to action button --}}
                                            <div class="my-3 call-to-action">
                                                <div class="d-inline-block OL-EDITABLE" data-tab="#_call_to_action_1">
                                                    <a href="{{ $template->button[0]->link }}" class="btn btn-call-act cta_btn_element_1 @if($template->button[0]->is_hidden == 1) disabled @endif" id="action_btn_1" data-default-name="Read More" data-default-color="#000000" target="_blank">{{ $template->button[0]->name }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-5">
                                        <div class="row">
                                            <div class="col-12">
                                                <h3 class="h2 pl-1 OfferTitle OL-EDITABLE mb-3" data-tab="#_text_5_" id="text_input_5">{{ $template->content[4]->content }}</h3>
                                            </div>
                                        </div> 
                                        <div class="row align-items-center">
                                            @if(!empty($template->gallery))
                                                @foreach($template->gallery as $gallery)
                                                    @if($loop->iteration > 1 && $loop->iteration < 5)
                                                        <div class="col-12 col-12 col-sm-4 mb-4">
                                                            <div class="columns OL-EDITABLE" data-tab="#_gal_sec_{{$loop->iteration}}"">
                                                                <div class="product-card">
                                                                    <div class="img-thumb" tag-name="{{ $gallery->tag_1 }}" id="tem_img{{ $loop->iteration }}"data-default-img="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}});"></div>
                                                                </div>
                                                            </div>   
                                                            <div class="position-relative title_bg mx-auto ">
                                                                <div class="title-bar ml-2">
                                                                    <p class="h6 product_name" id="tem_image_title_{{ $loop->iteration }}">{{ $gallery->title }}</p>
                                                                </div>
                                                             
                                                            <div class="priceAmount ml-2">
                                                                <p class="mb-0 product_price">
                                                                    <span class="price1">&#8377;<span class="sale_price_{{ $loop->iteration }}">{{ $gallery->sale_price }}</span></span>
                                                                    <span class="price2">&#8377;<span class=" price_{{ $loop->iteration }}">{{ $gallery->price }}</span></span>
                                                                </p>
                                                            </div>
                                                            </div> 
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mx-0 my-5">
                                        @if(!empty($template->gallery))
                                            @foreach($template->gallery as $gallery)
                                                @if($loop->iteration >= 5 && $loop->iteration < 9)
                                                    <div class="col-6 col-sm-3">
                                                        <div class="OL-EDITABLE px-0 px-sm-2" data-tab="#_gal_sec_{{$loop->iteration}}">
                                                            <div class="shipping-column">
                                                                <div class="shipping-card">
                                                                    <div class="shipping-img-thumb" tag-name="{{ $gallery->tag_1 }}" id="tem_img{{ $loop->iteration }}"data-default-img="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}});"></div>
                                                                </div>
                                                            </div>   
                                                            <div class="position-relative text-center">
                                                                <div class="shipping-description">
                                                                    <p class="mt-4 mx-4 h6" id="tem_image_title_{{ $loop->iteration }}">{{ $gallery->title }}</p>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>   
                        </div>
                                         
                        <div class="container-fluid">
                            <div class="row offer2_bg align-items-center">
                                @if(!empty($template->gallery))
                                    <div class="col-12 col-sm-5 px-0">
                                        <div class="OL-EDITABLE text-center" data-tab="#_gal_sec_9">
                                            <div class="img-fluid offer2_img" id="tem_img9" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->gallery[8]->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->gallery[8]->image_path)}});"></div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-12 col-sm-7 px-0 ">
                                    <div class="offer2_description m-5">
                                        <h6 class="h5 offer2Head1 OL-EDITABLE" data-tab="#_text_6_" id="text_input_6">{{ $template->content[5]->content }}</h6>
                                        <h3 class="h2 offer2Head2 OL-EDITABLE" data-tab="#_text_7_" id="text_input_7">{{ $template->content[6]->content }}</h3>
                                        <p class="mt-3 OL-EDITABLE" data-tab="#_text_8_" id="text_input_8">{{ $template->content[7]->content }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="row footer p-md-5">
                                <div class="col-12 col-md-6 order-2 my-4 mt-md-0">
                                    <div class="logo">
                                        @if($business->logo != '')
                                            <img src="{{ asset('assets/business/logos/'.$business->logo)}}" class="img-fluid" alt="Logo">
                                        @endif
                                    </div>

                                    <div class="busines-name">
                                    {{-- Business Name & Tagline  --}}
                                        <h1 class="h5 mb-1">{{ $business->business_name }}</h1>
                                        <p class="mb-3 small">{{ $business->tag_line }}</p>
                                    </div>

                                    {{-- <p class="business-address OL-EDITABLE" data-tab="#_text_9_" id="text_input_9">{{ $template->content[8]->content }}</p>
                                    <p class="business-address OL-EDITABLE" data-tab="#_text_10_" id="text_input_10">{{ $template->content[9]->content }}</p> --}}
                                    <p class="business-address">{{ $business['call_number'] }}</p>
                                    <p class="business-address">
                                        {{ $business['address_line_1'] }}, 
                                        @if($business['address_line_2'] != '')
                                        {{ $business['address_line_2'] }},
                                        @endif
                                        {{ $business['city'] }}, 
                                        {{ $business['state'] }}, 
                                        {{ $business['pincode'] }}.
                                    </p>
                                    <div class="" data-tab="#_social_links_">
                                        <ul class="social-icons m-0">
                                            <li class="si-tab" style="@if($facebook_link == '') display: none; @endif">
                                                <a href="{{ $facebook_link }}" class="fb" title="Facebook" id="facebook_link" target="_blank"><i class="bi bi-facebook fb"></i></a>
                                            </li>
                                            
                                            <li class="si-tab" style="@if($instagram_link == '') display: none; @endif">
                                                <a href="{{ $instagram_link }}" class="ig" title="Instagram" id="instagram_link" target="_blank"><i class="bi bi-instagram ig"></i></a>
                                            </li>
                                            
                                            <li class="si-tab" style="@if($twitter_link == '') display: none; @endif">
                                                <a href="{{ $twitter_link }}" class="tw" title="Twitter" id="twitter_link" target="_blank"><i class="bi bi-twitter tw"></i></a>
                                            </li>
                                            
                                            <li class="si-tab" style="@if($linkedin_link == '') display: none; @endif">
                                                <a href="{{ $linkedin_link }}" class="li" title="LinkedIn" id="linkedin_link" target="_blank"><i class="bi bi-linkedin li"></i></a>
                                            </li>
                                            
                                            {{-- <li class="si-tab">
                                                <a href="#" class="pr" title="Pinterest" target="_blank"><i class="bi bi-pinterest pr"></i></a>
                                            </li> --}}
                                            
                                            <li class="si-tab" style="@if($youtube_link == '') display: none; @endif">
                                                <a href="{{ $youtube_link }}" class="yt" title="YouTube" id="youtube_link" target="_blank"><i class="bi bi-youtube yt"></i></a>
                                            </li>

                                            <li class="si-tab" style="@if($google_review_placeid == '') display: none; @endif">
                                                <a href="https://search.google.com/local/writereview?placeid={{ $google_review_placeid }}" class="gr" title="Google" id="google_review_link" target="_blank"><i class="bi bi-google gr"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 order-md-2 mt-4 mt-md-0">
                                    @if(!empty($template->gallery))
                                        <div class="OL-EDITABLE text-center" data-tab="#_gal_sec_10">
                                            <div class="">
                                                <div class="img-fluid footerImg" id="tem_img10" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->gallery[9]->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->gallery[9]->image_path)}});"></div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</section>
