
<section id="Template" class="mb-5">
    <div id="builder_canvas">
        <main id="wrapper" class="">
            <section id="template-full-container" class="template-container OL-EDITABLE OL-ACTIVE" data-tab="#_main_tab_">
            <div class="template-main" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->bg_image)}});background-color: {{ $template->bg_color }};" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->bg_image)}}" id="tem_back">
                <div class="inner-wrapper">
                    <div class="bgBan">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="headTop text-center mt-3">
                                        {{-- Logo  --}}
                                        <div class="logo mx-auto">
                                            @if($business->logo != '')
                                                <img src="{{ asset('assets/business/logos/'.$business->logo)}}" class="img-fluid" alt="Logo">
                                                @endif
                                        </div>
                                        {{-- Business Name & Tagline  --}}
                                        <div class="busines-name text-center">
                                                <h1 class="h5 mb-0">{{ $business->business_name }}</h1>
                                                <p class="mb-sm-0 small">{{ $business->tag_line }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-10">
                                    <h1 class="f-bold OL-EDITABLE" data-tab="#_text_1_" id="text_input_1">{{ $template->content[0]->content }}</h1>
                                    <p class="OL-EDITABLE" data-tab="#_text_2_" id="text_input_2">{{ $template->content[1]->content }}</p>
                                    {{-- call to action button --}}
                                    <div class="mb-3 call-to-action">
                                        <div class="d-inline-block OL-EDITABLE" data-tab="#_call_to_action_1">
                                            <a href="{{ $template->button[0]->link }}" class="btn btn-call-act cta_btn_element_1 @if($template->button[0]->is_hidden == 1) disabled @endif" id="action_btn_1" data-default-name="Read More" data-default-color="#000000" target="_blank">{{ $template->button[0]->name }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    {{-- CONTACT OPTION  --}}
                                    <div class="contactDiv d-flex">
                                        <ul class="contact-section d-flex OL-EDITABLE" data-tab="#_contact_section_">
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

                        </div>
                    </div>
                    <div class="dotsDiv">
                        <div class="">
                            <svg id="imgBg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 424.56"><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="cls-1" d="M1200,84.45,184.94,420.88c-71.19,15.86-144.36-20.65-172.78-87.83A154.36,154.36,0,0,1,0,272.8V0H1200Z"/></g></g></svg>

                            <div class="mainImg-uppr">
                                <div class="mainImg-lwr">
                                    <div class="main_image text-center OL-EDITABLE" data-tab="#_main_image_">
                                
                                        <img src="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" class="img-mn" id="tem_main_img" alt="Banner">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                   
                    <div class="container-fluid mt-5">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mt_gallery py-5">
                                    <div>
                                        <div class="d-sm-flex gallery_image_div">
                                            @if(!empty($template->gallery))
                                                @foreach($template->gallery as $gallery)
                                                    <div class="columns">
                                                        <div class="OL-EDITABLE" data-tab="#_gal_sec_{{$loop->iteration}}">
                                                            <div class="product-card img_div">
                                                                <div class="img-thumb" id="tem_img{{ $loop->iteration }}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}});"></div>
                                                            </div>
                                                            <div class="title-bar text-center">
                                                                <p class="mb-0 bGText" id="tem_image_title_{{ $loop->iteration }}">{{ $gallery->title }}</p>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                @endforeach
                                            @endif
                                        </div>    
                                    </div>
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

                        {{-- Footer --}}
                        <div class="">
                            <div class="tmplt-container">
                                <div class="footer p-3">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-12">
                                                <div class="mt-2 text-sm-left text-center">
                                                        <a href="tel: {{ $call_number }}" class="link_domain" id="website_link"><i class="bi bi-phone"></i> {{ $call_number }}</a>
                                                </div>
                                            </div>
                                            {{-- Social Media Links --}}
                                            <div class="col-md-6 col-sm-6 col-13 social-number">

                                                {{-- Footer  --}}
                                                <div class="Tright text-sm-left text-center">
                                                    <div class="" data-tab="#_social_links_">
                                                        <ul class="social-icons pt-2 mb-2">
                                                            

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
                    </div>
                </div>
    
            </section>
        </main>
    </div>
</section>
