<section id="Template" class="mb-5">
    <div id="builder_canvas">
        <main id="wrapper" class="">
            <section id="template-full-container" class="template-container OL-EDITABLE OL-ACTIVE" data-tab="#_main_tab_">
                <div class="template-main" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->bg_image)}});background-color: {{ $template->bg_color }};" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->bg_image)}}" id="tem_back">
                    <div class="inner-wrapper">
                        <div class="banner_image">
                            <div class="hero-banner">
                                {{-- Main Image (Hero)  --}}
                                <div class="main_image banner_overlay OL-EDITABLE" data-tab="#_main_image_">
                                    <img src="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" class="w-100" id="tem_main_img" alt="Banner">
                                </div>
                                {{-- Logo --}}
                                <div class="logo mt-2 my-sm-5">
                                        @if($business->logo != '')
                                        <img src="{{ asset('assets/business/logos/'.$business->logo)}}" class="img-fluid" alt="Logo">
                                        @endif
                                </div> 
                                <div class="banText">
                                    <div class="line_div heading_text">
                                        <h2 class="h3 text-uppercase text-center font-700 OL-EDITABLE" data-tab="#_text_1_" id="text_input_1">{{ $template->content[0]->content }}</h2>
                                    </div> 
                                </div>    
                                <div class="cn-icons-top">
                                    {{-- CONTACT OPTION  --}}
                                    <ul class="contact-section OL-EDITABLE" data-tab="#_contact_section_">
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
                                <div class="mt-5 mb-2 text-center">
                                    <h2 class="h1 mb-1 exHead OL-EDITABLE" data-tab="#_text_2_" id="text_input_2" style="font-weight: bold;">{{ $template->content[1]->content }}</h2>
                                </div>
                                {{-- call to action button --}}
                                <div class="mt-2 mb-5 text-center call-to-action">
                                    <div class="d-inline-block OL-EDITABLE" data-tab="#_call_to_action_1">
                                        <a href="{{ $template->button[0]->link }}" class="btn btn-call-act cta_btn_element_1 @if($template->button[0]->is_hidden == 1) disabled @endif" id="action_btn_1" data-default-name="Read More" data-default-color="#000000" target="_blank">{{ $template->button[0]->name }}</a>
                                    </div>
                                </div> 
                                {{-- Gallery Images  --}}
                                <div class="mb-5">
                                    <div class="row justify-content-center align-items-center">
                                        @if(!empty($template->gallery))
                                            @foreach($template->gallery as $gallery)
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="mb-4 OL-EDITABLE" data-tab="#_gal_sec_{{$loop->iteration}}">
                                                    <div class="product-card">
                                                        <div tag-name="{{ $gallery->tag_1 }}" class="img-thumb" id="tem_img{{ $loop->iteration }}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}});"></div>
                                                    </div>
                                                    <div class="title-bar">
                                                        <div class="bg_gallery_title">
                                                            <h5 class="d-inline font-weight-bold">
                                                                <span>&#8377; </span>
                                                                <span class="sale_price_{{ $loop->iteration }} text-dark">{{ $gallery->sale_price }}</span>
                                                            </h5>  
                                                        </div>
                                                        <p class="mb-0 ml-2 text-center gallery_title d-inline" id="tem_image_title_{{ $loop->iteration }}">{{ $gallery->title }}</p>
                                                    </div>
                                                </div>
                                            </div>
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

                            {{-- Footer  --}}
                            <div class="py-3 footer_background">
                                <div class="container-fluid">
                                    <div class="row align-items-center">
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
