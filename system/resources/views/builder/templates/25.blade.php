<section id="Template" class="mb-5">
    <div id="builder_canvas">
        <main id="wrapper" class="">
            <section id="template-full-container" class="template-container OL-EDITABLE OL-ACTIVE" data-tab="#_main_tab_">
            <div class="template-main" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->bg_image)}});background-color: {{ $template->bg_color }};" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->bg_image)}}" id="tem_back">
                <div class="inner-wrapper">
                    <div class="back">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12"> 
                                    <div class="float-sm-right">
                                       {{-- Logo  --}}
                                        <div class="logo mb-2 mt-3 mr-4">
                                            @if($business->logo != '')
                                                <img src="{{ asset('assets/business/logos/'.$business->logo)}}" class="img-fluid" alt="Logo">
                                            @endif
                                        </div> 
                                    </div>
                                </div> 
                            </div> 
                            <div class="pt-2">
                                <div class="tmplt-container">
                                    <div class="hero-banner">
                                        <div class="row">
                                            <div class="col-md-6">
                                                 {{-- Main Image (Hero)  --}}
                                                <div class="main_image img-fluid OL-EDITABLE" data-tab="#_main_image_">
                                                    <img src="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" class="w-100" id="tem_main_img" alt="Banner">
                                                </div>
                                            </div>    
                                            <div class="col-md-6">   
                                                <div class="mt-5">
                                                    <div class="OL-EDITABLE " data-tab="#_text_1_">
                                                        <h2 class="display-4 mb-1 text-capitalize" id="text_input_1">{{ $template->content[0]->content }}</h2>
                                                    </div>
                                                    <div class="OL-EDITABLE" data-tab="#_text_2_">
                                                        <p id="text_input_2" class="mt-4 pb-2 ml-1">{{ $template->content[1]->content }}</p>
                                                    </div>
                                                </div>
                                            </div>        
                                        </div>  
                                    </div>
                                </div>   
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
                    <!-- banner end -->
                    <!-- 2nd section start -->
                    <div class="tmplt-container">
                        <div class="container-fluid">
                            <!-- 2nd heading start -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="mb-5 pb-3">
                                        <div class="text">
                                            <h2 class="h1 mt-4 text-capitalize OL-EDITABLE" data-tab="#_text_3_" id="text_input_3">{{ $template->content[2]->content }}</h2>
                                            <div class="hrline1"></div>
                                            <p class="mt-3 OL-EDITABLE" data-tab="#_text_4_" id="text_input_4">{{ $template->content[3]->content }}</p>
                                        </div>
                                        {{-- call to action button --}}
                                        <div class="mb-5 call-to-action">
                                            <div class="d-inline-block OL-EDITABLE" data-tab="#_call_to_action_1">
                                                <a href="{{ $template->button[0]->link }}" class="btn btn-call-act cta_btn_element_1 @if($template->button[0]->is_hidden == 1) disabled @endif" id="action_btn_1" data-default-name="Read More" data-default-color="#000000" target="_blank">{{ $template->button[0]->name }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- 2nd heading end -->
                            <!-- gallery images -->
                            <div>
                                <div class="d-sm-flex justify-content-center mb-2 mb-sm-5">
                                    @if(!empty($template->gallery))
                                        @foreach($template->gallery as $gallery)
                                            <div class="columns">
                                                <div class="OL-EDITABLE" data-tab="#_gal_sec_{{$loop->iteration}}">
                                                    <div class="product-card img_div">
                                                        <div class="box"></div>
                                                        <div class="img-thumb" id="tem_img{{ $loop->iteration }}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}});"></div>
                                                        <h5 class="text-center mt-3 image_title" id="tem_image_title_{{ $loop->iteration }}">{{ $gallery->title }}</h5>
                                                    </div>
                                                </div>
                                            </div>    
                                        @endforeach
                                    @endif
                                </div>    
                            </div>
                            <!-- gallery images end -->
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
                    <div class="back">
                        <div class="tmplt-container">
                            <div class="footer py-3">
                                <div class="container-fluid">
                                    <div class="row d-flex align-items-center">
                                    {{-- tag line --}}
                                        <div class="col-md-6 col-sm-6">
                                            <div class="busines-name text-center text-sm-left mb-1">
                                                <h1 class="h5 mb-0 text-uppercase">{{ $business->business_name }}</h1>
                                                <p class="mb-sm-0 small">{{ $business->tag_line }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 social-number">


                                    {{-- social media  --}}
                                            <div class="">
                                                <div class="" data-tab="#_social_links_">
                                                    <ul class="social-icons mb-2">
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
