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
                        <div class="bg-color position-relative">
                            <div class="container-fluid py-3 py-md-5 px-sm-5 px-4">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-6 col-lg-7 logo-position">
                                        <div class="logo">
                                            @if($business->logo != '')
                                            <img src="{{ asset('assets/business/logos/'.$business->logo)}}" class="img-fluid logo" alt="Logo">
                                            @endif
                                        </div>
                                        <div class="marText">
                                            <h1 class="mb-4 banHead1 text-uppercase OL-EDITABLE" data-tab="#_text_1_" id="text_input_1">{{ $template->content[0]->content }}</h1>
                                            <p class="h1 mb-4 banHead2 text-uppercase OL-EDITABLE" data-tab="#_text_2_" id="text_input_2">{{ $template->content[1]->content }}</p>
                                        </div>
                                        <div class="contactDiv pb-5">
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
                                    <div class="col-12 col-md-6 col-lg-5">
                                        <div class="asset1">
                                            <img src="{{ asset('assets/templates/'.$id.'/Asset.png')}}" class="img-fluid" alt="img">
                                        </div>
                                        <div class="banner-image">
                                            <div class="OL-EDITABLE main-image" data-tab="#_main_image_">
                                                <img src="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" class="img-fluid" id="tem_main_img" alt="Banner">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid p-sm-5 p-4">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-5 order-2">
                                    <div class="asset2">
                                        <img src="{{ asset('assets/templates/'.$id.'/Asset.png')}}">
                                    </div>
                                    @if(!empty($template->gallery))
                                        <div class="text-center border_style">
                                            <div class="OL-EDITABLE"  data-tab="#_gal_sec_1" style="border-radius:49% 49% 0 0;">
                                                <div class="img-thumb-one offer-img img-fluid" id="tem_img1" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->gallery[0]->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->gallery[0]->image_path)}});">
                                                </div>
                                            </div>    
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12 col-md-7 pl-md-5 order-md-2">
                                    <h1 class="h2 offer-text-head text-uppercase OL-EDITABLE" data-tab="#_text_3_" id="text_input_3">{{ $template->content[2]->content }}</h1>
                                    <p class="offer-text OL-EDITABLE" data-tab="#_text_4_" id="text_input_4">{{ $template->content[3]->content }}</p>
                                    {{-- call to action button --}}
                                        <div class="mb-5 call-to-action">
                                            <div class="d-inline-block OL-EDITABLE" data-tab="#_call_to_action_1">
                                                <a href="{{ $template->button[0]->link }}" class="btn btn-call-act cta_btn_element_1 @if($template->button[0]->is_hidden == 1) disabled @endif" id="action_btn_1" data-default-name="Read More" data-default-color="#000000" target="_blank">{{ $template->button[0]->name }}</a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="row pt-md-5 p-sm-0">
                                <div class="col-12">
                                    <div class="asset3">
                                        <img src="{{ asset('assets/templates/'.$id.'/Asset.png')}}" class="img-fluid" alt="Banner">
                                    </div>
                                    <h1 class="h2 pt-md-0 pt-4 mb-3 offer-text-head text-uppercase OL-EDITABLE" data-tab="#_text_5_" id="text_input_5">{{ $template->content[4]->content }}</h1>
                                </div>
                            </div>    
                            <div class="d-sm-flex">
                                @if(!empty($template->gallery))
                                    @foreach($template->gallery as $gallery)
                                        @if($loop->iteration > 1 && $loop->iteration < 5)
                                            <div class="columns">
                                                <div class="OL-EDITABLE" data-tab="#_gal_sec_{{$loop->iteration}}">
                                                    <div class="product-card">
                                                        <div class="img-thumb ImG" tag-name="{{ $gallery->tag_1 }}" id="tem_img{{ $loop->iteration }}"data-default-img="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}});"></div>
                                                    </div>
                                                    <div class="position-relative text-center">
                                                        <div class="title-bar">
                                                            <p class="mb-1 h5" id="tem_image_title_{{ $loop->iteration }}">{{ $gallery->title }}</p>
                                                        </div>
                                                        <div class="priceAmount">
                                                            <p class="mb-0">
                                                                <!-- <span class="price1">&#8377; <span class="sale_price_{{ $loop->iteration }}">{{ $gallery->sale_price }}</span></span> -->
                                                                <span class="price2 h6">&#8377;<span class=" price_{{ $loop->iteration }}">{{ $gallery->price }}</span></span>
                                                            </p>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div> 
                        <div class="bg-color-footer">
                            <div class="container-fluid">
                                <div class="row align-items-center">
                                    <div class="col-12 col-sm-5 px-0">
                                        @if(!empty($template->gallery))
                                            <div class="offer-img OL-EDITABLE text-center" data-tab="#_gal_sec_5">
                                                <div class="img-thumb-footer img-fluid" id="tem_img5" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->gallery[4]->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->gallery[4]->image_path)}});">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-12 col-sm-7 text-color-footer">
                                        <div class="pt-3 pt-md-0">
                                            <div class="busines-name mb-1">
                                                <h1 class="h5 mb-1 text-uppercase">{{ $business->business_name }}</h1>
                                                <p class="mb-1">{{ $business->tag_line }}</p>
                                            </div>
                                            <div class="pb-3 pt-2">
                                                <h1 class="h4 business-features text-uppercase OL-EDITABLE" data-tab="#_text_6_" id="text_input_6">{{ $template->content[5]->content }}</h1>
                                                <div class="underline"></div>
                                            </div>
                                        </div>
                                        <div class="product-list ml-lg-0 px-4 px-sm-0 pr-sm-5">
                                            <div class="d-flex justify-content-between">
                                                <p class="OL-EDITABLE" data-tab="#_text_7_" id="text_input_7">{{ $template->content[6]->content }}</p>
                                                <p class="OL-EDITABLE" data-tab="#_text_8_" id="text_input_8">{{ $template->content[7]->content }}</p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="OL-EDITABLE" data-tab="#_text_9_" id="text_input_9">{{ $template->content[8]->content }}</p>
                                                <p class="OL-EDITABLE" data-tab="#_text_10_" id="text_input_10">{{ $template->content[9]->content }}</p>
                                            </div>
                                        </div>
                                        <div class="" data-tab="#_social_links_">
                                            <ul class="social-icons m-0 pt-2 pb-2 pb-sm-0">
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
