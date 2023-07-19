<section id="Template" class="mb-5">
    <div id="builder_canvas">
        <main id="wrapper" class="">
            <section id="template-full-container" class="template-container OL-EDITABLE OL-ACTIVE" data-tab="#_main_tab_">
                <div class="template-main" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->bg_image)}});background-color: {{ $template->bg_color }};" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->bg_image)}}" id="tem_back">
                    <div class="inner-wrapper">
                        <div class="banner_image">
                            {{-- Main Image (Hero)  --}}
                            <div class="main_image banner_overlay OL-EDITABLE" data-tab="#_main_image_">
                                <img src="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" class="w-100" id="tem_main_img" alt="Banner">
                            </div>
                            
                            <div class="banText text-center">
                                <div class="heading_text">
                                    <h2 class="h1 font-700 OL-EDITABLE" data-tab="#_text_1_" id="text_input_1">{{ $template->content[0]->content }}</h2>
                                    <hr class="hrline1">
                                    <p class="OL-EDITABLE" data-tab="#_text_2_" id="text_input_2">{{ $template->content[1]->content }}</p>
                                </div>    
                            </div>    
                            <div class="ban_subsec text-center">
                                <h2 class="h1 font-700 ban_Subhead OL-EDITABLE" data-tab="#_text_3_" id="text_input_3">{{ $template->content[2]->content }}</h2>
                                {{-- CONTACT OPTION  --}}
                                <div class="contactDiv">
                                    <ul class="contact-section mb-0 OL-EDITABLE" data-tab="#_contact_section_">
                                    
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
                            <div class="tmplt-container">
                                <div class="second-section-text text-center">
                                    <div class="OL-EDITABLE" data-tab="#_text_4_" >
                                        <h2 class="h2 mb-1" id="text_input_4" style="font-weight: bold;">{{ $template->content[3]->content }}</h2>
                                    </div>
                                    <hr class="hrline1">
                                    <div class="OL-EDITABLE" data-tab="#_text_5_">
                                        <p id="text_input_5" class="">{{ $template->content[4]->content }}</p>
                                    </div>
                                    {{-- call to action button --}}
                                    <div class="mb-5 text-center call-to-action">
                                        <div class="d-inline-block OL-EDITABLE" data-tab="#_call_to_action_1">
                                            <a href="{{ $template->button[0]->link }}" class="btn btn-call-act cta_btn_element_1 @if($template->button[0]->is_hidden == 1) disabled @endif" id="action_btn_1" data-default-name="Read More" data-default-color="#000000" target="_blank">{{ $template->button[0]->name }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container-fluid mt-5 bg-yellow">
                            <div class="row align-items-center">
                                @if(!empty($template->gallery))
                                <div class="col-md-6 px-0 OL-EDITABLE" data-tab="#_gal_sec_1">
                                    <div class="image_single">
                                        <div class="img-thumb img-fluid w-100" id="tem_img1" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->gallery[0]->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->gallery[0]->image_path)}});">
                                        </div>
                                    </div>
                                </div>
                                @endif
                                   <!--  <img src="{{ asset('assets/templates/'.$id.'/side-banner.png')}}" class="img-fluid w-100" alt="Banner"> -->
                                
                                <div class="col-md-6">
                                    <h2 class="h2 font-700 text-dark OL-EDITABLE" data-tab="#_text_6_" id="text_input_6">{{ $template->content[5]->content }}</h2>
                                    <hr class="hrline2 ml-0">
                                    <p class="text-dark OL-EDITABLE" data-tab="#_text_7_" id="text_input_7">{{ $template->content[6]->content }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Gallery Images  --}}
                        <div class="container-fluid my-5 text-center">
                            <div class="tmplt-container">
                                <div class="">
                                    <h2 class="h2 font-700 OL-EDITABLE" data-tab="#_text_8_" id="text_input_8" style="color: #222222;">{{ $template->content[7]->content }}</h2>
                                    <hr class="hrline1">
                                </div>
                                <div>
                                    <div class="row justify-content-center align-items-center">
                                        @if(!empty($template->gallery))
                                            @foreach($template->gallery as $gallery)
                                            @if($loop->iteration > 1)
                                            <div class="col-md-4 col-12 mb-4">
                                               <div class="OL-EDITABLE" data-tab="#_gal_sec_{{$loop->iteration}}">
                                                    <div class="product-card">
                                                        <div class="img-thumb" id="tem_img{{ $loop->iteration }}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}});"></div>
                                                    </div>
                                                    <div class="position-relative">
                                                        <div class="title-bar">
                                                            <p class="mb-0" id="tem_image_title_{{ $loop->iteration }}">{{ $gallery->title }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="priceAmount bg-yellow mt-3">
                                                        <p class="mb-0">
                                                            <span class="price1 text-dark">&#8377;<span class="sale_price_{{ $loop->iteration }} text-dark">{{ $gallery->sale_price }}</span></span>
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
                            </div>
                        </div>  


                        <div class="container-fluid outerDiv">
                            <div class="offerSec">
                                <div class="offerBorder">
                                    <h5 class="headP OL-EDITABLE mt-3" data-tab="#_text_9_" id="text_input_9">{{ $template->content[8]->content }}</h5>
                                    <p class="OL-EDITABLE" data-tab="#_text_10_" id="text_input_10">{{ $template->content[9]->content }}</p>
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

                            {{-- Footer  --}}
                            <div class="py-3 mt-sm-5">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            {{-- Logo --}}
                                            <div class="logo mt-2 text-center">
                                                @if($business->logo != '')
                                                    <img src="{{ asset('assets/business/logos/'.$business->logo)}}" class="img-fluid" alt="Logo">
                                                @endif
                                            </div> 
                                            <hr class="hrline1">
                                        </div>
                                        <div class="col-12 mb-2">
                                            {{-- Business Name & Tagline  --}}
                                            <div class="busines-name">
                                                
                                                    <h1 class="h4 mb-1">{{ $business->business_name }}</h1>
                                                    <p class="mb-0">{{ $business->tag_line }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="" data-tab="#_social_links_">
                                                <ul class="social-icons mb-0">
                                                   

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
