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
                    <div class="">
                        <div class="position-relative">
                            <div class="contact-sec-div">
                                <ul class="contact-section mb-md-0 mt-2 d-line-block pl-0 OL-EDITABLE" data-tab="#_contact_section_">
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
                            <div class="container">
                                <div class="row px-5">
                                    <div class="col-md-12 text-center text-md-left">
                                        <div class="logo mt-3 my-md-3">
                                                @if($business->logo != '')
                                                
                                                    <img src="{{ asset('assets/business/logos/'.$business->logo)}}" class="img-fluid" alt="Logo">
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                            <div class="OL-EDITABLE" data-tab="#_main_image_">
                                <img src="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" class="img-fluid" id="tem_main_img" alt="Banner">
                            </div>
                            <div class="ban_txt_sec">
                                <div class="ban_txt_inner">
                                    <h3 class="ban_tag_text m-0 text-uppercase OL-EDITABLE" data-tab="#_text_4_" id="text_input_4">{{ $template->content[3]->content }}</h3>
                                </div>    
                                <div class="ban_txt_inner_round">
                                    <div class="ban_round_text">
                                        <p class="mb-0 text-uppercase OL-EDITABLE" data-tab="#_text_5_" id="text_input_5">{{ $template->content[4]->content }}</p>
                                        <p class="mb-0 price-bold text-uppercase OL-EDITABLE" data-tab="#_text_6_" id="text_input_6">{{ $template->content[5]->content }}</p>
                                        <p class="mb-0 text-uppercase OL-EDITABLE" data-tab="#_text_7_" id="text_input_7">{{ $template->content[6]->content }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                    {{-- about section --}}
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-12 py-4 text-center">
                                <h3 class="OL-EDITABLE" data-tab="#_text_2_" id="text_input_2" style="font-weight: bold;">{{ $template->content[1]->content }}</h3>
                                <p class="pt-2 OL-EDITABLE" data-tab="#_text_3_" id="text_input_3">{{ $template->content[2]->content }}</p>
                                {{-- call to action button --}}
                                @if($template->button[0]->is_hidden != 1)
                                    <div class="mb-5_ call-to-action">
                                        <div class="d-inline-block OL-EDITABLE" data-tab="#_call_to_action_1">
                                            <a href="{{ $template->button[0]->link }}" class="btn btn-call-act cta_btn_element_1 @if($template->button[0]->is_hidden == 1) disabled @endif" id="action_btn_1" data-default-name="Read More" data-default-color="#000000" target="_blank">{{ $template->button[0]->name }}</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                        </div>
                    </div>

                    {{-- gallery section one --}}
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-12 py-4">
                                <h3 class="OL-EDITABLE" data-tab="#_text_1_" id="text_input_1" style="font-weight: bold;">{{ $template->content[0]->content }}</h3>
                            </div>
                        </div>
                        <div class="mb-4">
                            @if(!empty($template->gallery))
                            <div class="row">
                                @foreach($template->gallery as $gallery)
                                @if($loop->iteration > 0 && $loop->iteration < 4)
                                <div class="OL-EDITABLE col-md-4 col-sm-12 gallery_box" data-tab="#_gal_sec_{{$loop->iteration}}">
                                    <div class="product-card">
                                        <div class="img-thumb" tag-name="{{ $gallery->tag_1 }}" id="tem_img{{ $loop->iteration }}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}});"></div>

                                        <p class="py-2 h5 text-uppercase gal_title_para" id="tem_image_title_{{ $loop->iteration }}">{{ $gallery->title }}</p>
                                    </div>
                                </div>
                                
                                @endif
                                @endforeach
                            </div>
                            @endif
                        </div>
                        
                    </div>
                 
                    {{-- footer section --}}
                    <div class="footer-bg-clr p-2">

                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12">
                                    <div class="text-center text-md-left" data-tab="#_social_links_">
                                        <ul class="social-icons">
                                            

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
                                <div class="col-md-6 col-12">
                                    <div class="busines-name text-center text-md-right mb-3">
                                        <h1 class="h4 text-uppercase mb-0">{{ $business->business_name }}</h1>
                                        <p class="mb-0">{{ $business->tag_line }}</p>
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
