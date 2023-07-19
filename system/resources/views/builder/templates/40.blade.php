<section id="Template" class="mb-5">
    <div id="builder_canvas">
        <main id="wrapper" class="">
            <section id="template-full-container" class="template-container OL-EDITABLE OL-ACTIVE" data-tab="#_main_tab_">
                <div class="template-main" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->bg_image)}});background-color: {{ $template->bg_color }};" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->bg_image)}}" id="tem_back">
                    <div class="inner-wrapper">

                    <div class="container-fluid ">
                        <div class="text-center py-3">

                            {{-- Logo  --}}
                            <div class="logo mx-auto">
                              
                                @if($business->logo != '')
                                <img src="{{ asset('assets/business/logos/'.$business->logo)}}" class="img-fluid" alt="Logo">
                                @endif
                            </div>

                            {{-- Business Name & Tagline  --}}
                            <div class="busines-name mb-4">
                                    <h1 class="h4 mb-1">{{ $business->business_name }}</h1>
                                    <p class="mb-0 small">{{ $business->tag_line }}</p>
                            </div>

                            <div class="cn-icons-top mb-5">
                                {{-- CONTACT OPTION  --}}
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

                            <div class="tmplt-container">
                                <div class="mb-1">
                                    <div class="main_image OL-EDITABLE" data-tab="#_main_image_">
                                        <img src="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" class="w-100" id="tem_main_img" alt="Banner">
                                    </div>
                                </div>
                            </div>

                            {{-- Main Heading & Content  --}}
                            <div class="tmplt-container py-2">
                                <h2 class="h1 mb-0 OL-EDITABLE" data-tab="#_text_1_" id="text_input_1">{{ $template->content[0]->content }}</h2>
                                <hr class="hr">
                                <p class="mt-3 OL-EDITABLE" data-tab="#_text_2_" id="text_input_2">{{ $template->content[1]->content }}</p>
                            </div>
                            {{-- call to action button --}}
                            <div class="mb-5 text-center call-to-action">
                                <div class="d-inline-block OL-EDITABLE" data-tab="#_call_to_action_1">
                                    <a href="{{ $template->button[0]->link }}" class="btn btn-call-act cta_btn_element_1 @if($template->button[0]->is_hidden == 1) disabled @endif" id="action_btn_1" data-default-name="Read More" data-default-color="#000000" target="_blank">{{ $template->button[0]->name }}</a>
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

                        {{-- Footer --}}
                        <div class="footer">
                            <div class="row align-items-center">
                                {{-- Contact Number  --}}
                                <div class="col-md-12 col-12 mb-2 text-center">
                                    <a href="tel: {{ $call_number }}" class="link_domain h6" id="website_link"><i class="bi bi-phone"></i> {{ $call_number }}</a>
                                </div>
                                {{-- Social Media Links --}}
                                <div class="col-md-12 col-12 mb-3">
                                    <div class="" data-tab="#_social_links_">
                                        <ul class="social-icons text-center mb-0">
                                        

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
            </section>
        </main>
    </div>
</section>

