<section id="Template" class="mb-5_">
    <div id="builder_canvas">
        <main id="wrapper" class="">
            <section id="template-full-container" class="template-container OL-EDITABLE OL-ACTIVE" data-tab="#_main_tab_">
                <div class="template-main" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->bg_image)}});background-color: {{ $template->bg_color }};" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->bg_image)}}" id="tem_back">
                    
                    <div class="inner-wrapper">
                        <div class="banner-bg-sec">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="top_section">
                                            {{-- main banner --}}
                                            <div class="logo mt-4 mb-3 text-center mx-auto">
                                                @if($business->logo != '')
                                                    <img src="{{ asset('assets/business/logos/'.$business->logo)}}" class="img-fluid" alt="Logo">
                                                @endif
                                            </div> 
                                            <div class="py-3 text-center">
                                                <h2 class="h2 text-uppercase OL-EDITABLE" data-tab="#_text_1_" id="text_input_1" style="font-weight: bold;">{{ $template->content[0]->content }}</h2>
                                                <h1 class="h1 text-uppercase OL-EDITABLE" data-tab="#_text_2_" id="text_input_2" style="font-weight: bold;">{{ $template->content[1]->content }}</h1>
                                                <p class="h5 text-uppercase OL-EDITABLE" data-tab="#_text_3_" id="text_input_3" style="font-weight: bold;">{{ $template->content[2]->content }}</p>
                                            </div>                                         
                                            <div class="contact-tab mb-4 mb-md-0 text-center">
                                                <ul class="contact-section d-inline-block OL-EDITABLE" data-tab="#_contact_section_">
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
                                    <div class="col-md-12 pr-md-0">
                                        <div class="banner_image">
                                            <div class="main_image OL-EDITABLE mx-auto" data-tab="#_main_image_">
                                                <img src="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" class="w-100" id="tem_main_img" alt="Banner">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="container-fluid asset-image">
                            <div class="asset1">
                                <img src="{{ asset('assets/templates/'.$id.'/asset_1.png')}}" class="img-fluid" alt="Banner">
                            </div>
                            <div class="container">
                                <div class="extra_text">
                                   <div class="mt-5 mb-4">
                                        <h4 class="OL-EDITABLE text-uppercase" data-tab="#_text_4_" id="text_input_4" >{{ $template->content[3]->content }}</h4>
                                        <p class="mb-0 banHead2 OL-EDITABLE" data-tab="#_text_5_" id="text_input_5">{{ $template->content[4]->content }}</p>
                                        <hr class="underline1">
                                    </div>
                                </div>
                               {{-- call to action button --}}
                               @if($template->button[0]->is_hidden != 1)
                               <div class="mb-5 call-to-action">
                                    <div class="d-inline-block OL-EDITABLE" data-tab="#_call_to_action_1">
                                        <a href="{{ $template->button[0]->link }}" class="btn btn-call-act cta_btn_element_1 @if($template->button[0]->is_hidden == 1) disabled @endif" id="action_btn_1" data-default-name="Read More" data-default-color="#000000" target="_blank">{{ $template->button[0]->name }}</a>
                                    </div>
                               </div>
                               @endif
                                {{-- extra gallery --}}
                                <div class="row">
                                    @if(!empty($template->gallery))
                                        <div class="col-12 col-md-6 text-center">
                                            <div class="extra-gal-image ">
                                                <p class="OL-EDITABLE mb-2" data-tab="#_text_7_" id="text_input_7" >{{ $template->content[6]->content }}</p>
                                                <h5 class="OL-EDITABLE mb-2" data-tab="#_text_8_" id="text_input_8" >{{ $template->content[7]->content }}</h5>
                                                <div class="extra-gal-image-inner OL-EDITABLE" data-tab="#_gal_sec_7">
                                                    <div class="img-thumb-section" id="tem_img7" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->gallery[6]->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->gallery[6]->image_path)}});">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if(!empty($template->gallery))
                                        <div class="col-12 col-md-6 text-center" >
                                            <div class="extra-gal-image">
                                                <p class="OL-EDITABLE mb-2" data-tab="#_text_9_" id="text_input_9" >{{ $template->content[8]->content }}</p>
                                                <h5 class="OL-EDITABLE mb-2" data-tab="#_text_10_" id="text_input_10" >{{ $template->content[9]->content }}</h5>
                                                <div class="extra-gal-image-inner OL-EDITABLE" data-tab="#_gal_sec_8">
                                                    <div class="img-thumb-section" id="tem_img8" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->gallery[7]->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->gallery[7]->image_path)}});">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>  
                        <div class="container-fluid asset-image">
                            <div class="asset2">
                                <img src="{{ asset('assets/templates/'.$id.'/asset_2.png')}}" class="img-fluid" alt="Banner">
                            </div>
                            <div class="container mb-4">
                                <div class="mt-5 mb-4">
                                    <h4 class="OL-EDITABLE text-uppercase" data-tab="#_text_6_" id="text_input_4" >{{ $template->content[5]->content }}</h4>
                                    <hr class="underline1">
                                </div>
                                {{-- <div class="row">
                                    @if(!empty($template->gallery))
                                        <div class="col-12 col-md-6 OL-EDITABLE" data-tab="#_gal_sec_7">
                                            <div class="coupon_gal_sec mb-2">
                                                <div class="coupon_text_sec">
                                                    <p class="OL-EDITABLE mb-2" data-tab="#_text_13_" id="text_input_13" >{{ $template->content[12]->content }}</p>
                                                    <p class="OL-EDITABLE" data-tab="#_text_14_" id="text_input_14" style="font-weight: bold;">{{ $template->content[13]->content }}</p>
                                                </div>
                                                <div class="img-thumb-coupon" id="tem_img7" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->gallery[6]->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->gallery[6]->image_path)}});">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if(!empty($template->gallery))
                                        <div class="col-12 col-md-6 OL-EDITABLE" data-tab="#_gal_sec_8">
                                            <div class="coupon_gal_sec mb-2">
                                                <div class="coupon_text_sec">
                                                    <p class="OL-EDITABLE mb-2" data-tab="#_text_15_" id="text_input_15" >{{ $template->content[14]->content }}</p>
                                                    <p class="OL-EDITABLE" data-tab="#_text_14_" id="text_input_14" style="font-weight: bold;">{{ $template->content[13]->content }}</p>
                                                </div>
                                                <div class="img-thumb-coupon" id="tem_img8" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->gallery[7]->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->gallery[7]->image_path)}});">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div> --}}
                            </div>
                        </div>                   
                        <div class="container-fluid asset-image">
                            <div class="asset3">
                                <img src="{{ asset('assets/templates/'.$id.'/asset_1.png')}}" class="img-fluid" alt="Banner">
                            </div>
                            <div class="container mt-5 mb-4">
                                <div>
                                    <div class="row align-items-center">
                                        @if(!empty($template->gallery))
                                            @foreach($template->gallery as $gallery)
                                            @if($loop->iteration > 0 && $loop->iteration < 7)
                                            <div class="col-12 col-sm-6 col-md-4">
                                                <div class="columns d-inline-block mb-3 OL-EDITABLE" data-tab="#_gal_sec_{{$loop->iteration}}">
                                                    
                                                    <div class="product-card" tag-name="{{ $gallery->tag_1 }}">
                                                        <div class="text-center">
                                                            <div class="title-bar">
                                                                <p class="mb-0 text-uppercase h6" id="tem_image_title_{{ $loop->iteration }}">{{ $gallery->title }}</p>
                                                            </div>
                                                            <div class="priceAmount">
                                                                <p class="mb-2">
                                                                    <span class="price1">&#8377;<span class="sale_price_{{ $loop->iteration }} text-dark">{{ $gallery->sale_price }}</span></span>
                                                                    <span class="price2">&#8377;<span class="price_{{ $loop->iteration }}">{{ $gallery->price }}</span></span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="img-thumb" id="tem_img{{ $loop->iteration }}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}});"></div>
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


                        @php
                            $facebook_link = $business->facebook_link ?? '';
                            $instagram_link = $business->instagram_link ?? '';
                            $twitter_link = $business->twitter_link ?? '';
                            $linkedin_link = $business->linkedin_link ?? '';
                            $youtube_link = $business->youtube_link ?? '';
                            $call_number = $business->call_number ?? '';
                            $google_review_placeid = $business->google_review_placeid ?? '';


                        @endphp
                        <div class="footer-bg">
                            <div class="container-fluid">
                                <div class="temp-container">
                                    <div class="row text-center">
                                        <div class="col-md-12">
                                            <div class="busines-name">
                                                <h1 class="h5 b_head mb-0">{{ $business->business_name }}</h1>
                                                <p class="mb-0">{{ $business->tag_line }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">            
                                            <div class="" data-tab="#_social_links_">
                                                <ul class="social-icons mb-4">
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
                                                        
                                                     
                                                        <li class="si-tab" style="@if($youtube_link == '') display: none; @endif">
                                                            <a href="{{ $youtube_link }}" class="yt" title="YouTube" id="youtube_link" target="_blank"><i class="bi bi-youtube yt"></i></a>
                                                        </li>

                                                        <li class="si-tab" style="@if($google_review_placeid == '') display: none; @endif">
                                                            <a href="https://search.google.com/local/writereview?placeid={{ $google_review_placeid }}" class="gr" title="Google" id="google_review_link" target="_blank"><i class="bi bi-google gr"></i></a>
                                                        </li>
                                                </ul>
                                            </div>    
                                        </div>
                                        
                                        
                                    </div>
                                </div>    
                            </div>
                        </div>                           
                    </div>

                </div>
            </section>
        </main>
    </div>
</section>
