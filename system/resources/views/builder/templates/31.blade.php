<section id="Template" class="mb-5">
    <div id="builder_canvas">
        <main id="wrapper" class="">
            <section id="template-full-container" class="template-container OL-EDITABLE OL-ACTIVE" data-tab="#_main_tab_">
                <div class="template-main" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->bg_image)}});background-color: {{ $template->bg_color }};" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->bg_image)}}" id="tem_back">
                    <div class="inner-wrapper">

                        <div class="hero-banner">
                            {{-- Main Image (Hero)  --}}
                            <div class="main_image OL-EDITABLE" data-tab="#_main_image_">
                                
                                <img src="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" class="w-100" id="tem_main_img" alt="Banner">
                                {{-- <svg style="visibility: hidden; position: absolute;" width="0" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1">
                                    <defs>
                                          <filter id="round">
                                              <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />    
                                              <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo" />
                                              <feComposite in="SourceGraphic" in2="goo" operator="atop"/>
                                              <path id="curve" d="M100,250 C100,100 400,100 400,250" />
                                            </filter>
                                      </defs>
                                  </svg> --}}
                            </div>
                            <div class="cn-icons-top mb-md-4">
                                {{-- CONTACT OPTION  --}}
                                <ul class="contact-section OL-EDITABLE" data-tab="#_contact_section_">
                                    <li><a href="tel:{{ $business->call_number }}"><i class="bi bi-telephone"></i></a></li>
                                    <li><a target="_blank" href="https://wa.me/{{ $business->whatsapp_number }}"><i class="bi bi-whatsapp"></i></a></li>
                                    <li><a href="#" data-toggle="modal" data-target="#LocationModal"><i class="bi bi-geo-alt"></i></a></li>
                                    @if($business->website != '')
                                    <li><a target="_blank" href="{{ $business->website }}"><i class="bi bi-globe2"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                            {{-- <svg id="imgPurple" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 650.21 173.83"><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="cls-1" d="M650.21,173.83H0V65.36l207.29,83.06a112.94,112.94,0,0,0,85.15-.47L650.21,0Z"/></g></g></svg> --}}

                            {{-- <svg id="imgBg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 650.21 173.83"><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="cls-1" d="M650.21,173.83H0V65.36l207.29,83.06a112.94,112.94,0,0,0,85.15-.47L650.21,0Z"/></g></g></svg> --}}
                        </div>

                        <div class="middle-area">
                            <div class="container">
                                <div class="inner pt-4">

                                    {{-- Main Heading & Content  --}}
                                    <div>
                                        <h2 class="h1 OL-EDITABLE" data-tab="#_text_1_" id="text_input_1">{{ $template->content[0]->content }}</h2>
                                        <p class="OL-EDITABLE" data-tab="#_text_2_" id="text_input_2">{{ $template->content[1]->content }}</p>
                                    </div>
                                    
                                    {{-- call to action button --}}
                                    <div class="mb-3 text-center call-to-action">
                                        <div class="d-inline-block OL-EDITABLE" data-tab="#_call_to_action_1">
                                            <a href="{{ $template->button[0]->link }}" class="btn btn-call-act cta_btn_element_1 @if($template->button[0]->is_hidden == 1) disabled @endif" id="action_btn_1" data-default-name="Read More" data-default-color="#000000" target="_blank">{{ $template->button[0]->name }}</a>
                                        </div>
                                    </div>
                                    {{-- Gallery --}}
                                    <div class="mb-5">
                                        <div>
                                            <div class="d-sm-flex justify-content-around align-items-center pb-sm-5">
                                                @if(!empty($template->gallery))
                                                    @foreach($template->gallery as $gallery)
                                                    <div class="columns">
                                                        <div class="OL-EDITABLE" data-tab="#_gal_sec_{{$loop->iteration}}">
                                                            <div class="product-card">
                                                                <div class="img-thumb" id="tem_img{{ $loop->iteration }}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}});"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Extra Heading  --}}
                                    <div class="mb-3">
                                        <h2 class="h1 mb-1 OL-EDITABLE" data-tab="#_text_3_" id="text_input_3">{{ $template->content[2]->content }}</h2>
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
                        <div class="" style="margin-top: 25px;background-color: #5C4B75;">
                            <div class="tmplt-container">
                                <div class="footer p-3">
                                    <div class="container-fluid">
                                        <div class="row">
                                        
                                            <div class="col-md-6 col-sm-6 col-6">
                                                {{-- Logo  --}}
                                                <div class="logo text-center text-sm-left m-auto m-sm-2">
                                                   
                                                        @if($business->logo != '')
                                                        <img src="{{ asset('assets/business/logos/'.$business->logo)}}" class="img-fluid" alt="Logo">
                                                            @endif
                                                </div>
                                            </div>
                                            {{-- Social Media Links --}}
                                            <div class="col-md-6 col-sm-6 col-6 social-number">
                                                {{-- Footer  --}}
                                                <div class="text-center text-sm-right">
                                                    {{-- Business Name & Tagline  --}}
                                                    <div class="busines-name text-center text-sm-right mr-sm-2">
                                                        
                                                            <h1 class="h4 mb-1">{{ $business->business_name }}</h1>
                                                            <p class="mb-0 small">{{ $business->tag_line }}</p>
                                                    </div>
                                                    <div class="" data-tab="#_social_links_">
                                                        <ul class="social-icons text-sm-right pt-2 mb-2">

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
