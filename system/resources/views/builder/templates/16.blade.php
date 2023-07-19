<section id="Template" class="mb-5">
    <div id="builder_canvas">
        <main id="wrapper" class="">
            <section id="template-full-container"  class="template-container OL-EDITABLE OL-ACTIVE" data-tab="#_main_tab_">
                <div class="template-main" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->bg_image)}});background-color: {{ $template->bg_color }};" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->bg_image)}}" id="tem_back">
                    <div class="inner-wrapper">
                        <div>
                            <div class="container-fluid">
                                <div class="background_c mt-5">
                                    <div class="hero-banner">
                                        <div class="container-fluid">
                                            <div class="tmplt-container">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        {{-- Logo --}}
                                                        <div class="logo">
                                                            @if($business->logo != '')
                                                                <img src="{{ asset('assets/business/logos/'.$business->logo)}}" class="img-fluid" alt="Logo">
                                                            @endif
                                                        </div>
                                                        {{-- Business Name & Tagline  --}}
                                                        <div class="busines-name">
                                                            <h1 class="h3 mb-1">{{ $business->business_name }}</h1>
                                                            <p class="mb-0">{{ $business->tag_line }}</p>
                                                        </div>
                                                        <div class="pr-lg-5 pt-4 pb-5">
                                                            <div class="OL-EDITABLE" data-tab="#_text_1_">
                                                                <h2 class="h1 mb-1 text-uppercase" id="text_input_1">{{ $template->content[0]->content }}</h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                                <div class="tmplt-container">
                                   <div class="main_image"> 
                                        <div class="row justify-content-end">
                                            <div class="col-md-5">
                                                 <div class="OL-EDITABLE main_image1" data-tab="#_main_image_">
                                                    <img src="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" class="w-100" id="tem_main_img" alt="Banner">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="tmplt-container">
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
                                <div class="text_image">
                                    <div class="row align-items-center">  
                                        <div class="col-md-5 order-md-1 order-2">
                                         {{-- Gallery Images  --}}
                                            <div class="mb-3">
                                                <div>
                                                    <div class="">
                                                        @if(!empty($template->gallery))
                                                            @foreach($template->gallery as $gallery)
                                                            <div class="columns OL-EDITABLE" data-tab="#_gal_sec_{{$loop->iteration}}">
                                                                <div class="product-card">
                                                                    <div class="img-thumb" id="tem_img{{ $loop->iteration }}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}});"></div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7 order-md-2 order-1 mb-4 mb-md-0">
                                            {{-- Main Heading & Content  --}}
                                            <div class="mb-md-4 mt-4 mt-md-0">
                                                <h2 class="h3 font-700 text-uppercase OL-EDITABLE" data-tab="#_text_2_" id="text_input_2">{{ $template->content[1]->content }}</h2>
                                                <p class="OL-EDITABLE mb-0" data-tab="#_text_3_" id="text_input_3">{{ $template->content[2]->content }}</p>
                                            </div>
                                           {{-- call to action button --}}
                                            <div class="mb-3 mt-3 call-to-action">
                                                <div class="d-inline-block OL-EDITABLE" data-tab="#_call_to_action_1">
                                                    <a href="{{ $template->button[0]->link }}" class="btn btn-call-act cta_btn_element_1 @if($template->button[0]->is_hidden == 1) disabled @endif" id="action_btn_1" data-default-name="Read More" data-default-color="#000000" target="_blank">{{ $template->button[0]->name }}</a>
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
                                            <div class="">
                                                <div class="align-items-baseline">
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
                    </div>
                </div>    
            </section>
        </main>
    </div>
</section>



