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
                    <div class="bg-color position-relative p-4">
                        <div class="border-banner">
                            <div class="container p-3">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-7">
                                        <div class="logo">
                                            @if($business->logo != '')
                                                <img src="{{ asset('assets/business/logos/'.$business->logo)}}" class="img-fluid logo" alt="Logo">
                                            @endif
                                        </div>
                                        <div class="border-text text-center p-3 mt-5">
                                            <h1 class="banHead1 text-uppercase OL-EDITABLE" data-tab="#_text_1_" id="text_input_1">{{ $template->content[0]->content }}</h1>
                                            <h3 class="h1 mb-0 mt-3 banHead2 text-uppercase OL-EDITABLE" data-tab="#_text_2_" id="text_input_2">{{ $template->content[1]->content }}</h3>
                                        </div>
                                        <div class="my-3 text-center">
                                            <p class="h3 offer-text-head text-uppercase OL-EDITABLE" data-tab="#_text_3_" id="text_input_3">{{ $template->content[2]->content }}</p>
                                        </div>
                                       
                                        {{-- call to action button --}}
                                        <div class="mb-5 call-to-action text-center">
                                            <div class="d-inline-block OL-EDITABLE" data-tab="#_call_to_action_1">
                                                <a href="{{ $template->button[0]->link }}" class="btn btn-call-act cta_btn_element_1 @if($template->button[0]->is_hidden == 1) disabled @endif" id="action_btn_1" data-default-name="Read More" data-default-color="#000000" target="_blank">{{ $template->button[0]->name }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <div class="banner-image">
                                            <div class="OL-EDITABLE main-image text-center text-sm-left" data-tab="#_main_image_">
                                                <img src="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" class="img-fluid" id="tem_main_img" alt="Banner">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="contactDiv py-5 text-center">
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
                            <div class="image-brand-section mb-5">
                                <div class="inner-image-brand">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-sm-4">
                                            @if(!empty($template->gallery))
                                                <div class="text-center columns">
                                                    <div class="OL-EDITABLE product-card-brand p-3"  data-tab="#_gal_sec_1">
                                                        <div class="img-thumb-brand img-fluid" id="tem_img1" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->gallery[0]->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->gallery[0]->image_path)}});">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-12 col-sm-8">
                                            <div class="image-brand-text text-center text-sm-left pt-3 pt-sm-0 pb-5 pb-sm-0">
                                                <h3 class="h1 OL-EDITABLE brand-head-text px-1" data-tab="#_text_4_" id="text_input_4">{{ $template->content[3]->content }}</h3>
                                                <p class="h5 OL-EDITABLE" data-tab="#_text_5_" id="text_input_5">{{ $template->content[4]->content }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        
                            <div class="row justify-content-center">
                                @if(!empty($template->gallery))
                                    @foreach($template->gallery as $gallery)
                                        @if($loop->iteration > 1 && $loop->iteration < 8)
                                        <div class="col-12 col-sm-5 col-md-5 my-3">
                                            <div class="columns gallery-img-bg">
                                                <div class="OL-EDITABLE" data-tab="#_gal_sec_{{$loop->iteration}}">
                                                    <div class="product-card">
                                                        <div class="img-thumb ImG" tag-name="{{ $gallery->tag_1 }}" id="tem_img{{ $loop->iteration }}"data-default-img="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}});"></div>
                                                    </div>
                                                    <div class="position-relative text-center">
                                                        <div class="title-bar py-4">
                                                            <p class="mb-0 h6 font-weight-bold" id="tem_image_title_{{ $loop->iteration }}">{{ $gallery->title }}</p>
                                                        </div>
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
                    <div class="bg-color-footer">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-12 col-sm-6">
                                    <div class="py-3 text-center text-sm-left">
                                        <div class="busines-name mb-1">
                                            <h1 class="h5 mb-1">{{ $business->business_name }}</h1>
                                            <p class="mb-1">{{ $business->tag_line }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="OL-EDITABLE py-3" data-tab="#_social_links_">
                                        <ul class="social-icons text-center text-sm-right">
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
                            </div> 
                        </div>
                    </div>                                
                </div>
            </div>    
        </section>
    </main>
</div>
</section>

