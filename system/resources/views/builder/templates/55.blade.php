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
                        <div class="bg-grey position-relative">
                            <div class="pb-sm-5 pb-0 position-relative">
                                <div class="container-fluid">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-6 col-sm-6 logo pt-3 pt-sm-0">
                                            <div class="logo">
                                                @if($business->logo != '')
                                                    <img src="{{ asset('assets/business/logos/'.$business->logo)}}" class="img-fluid head_img" alt="Logo">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-sm-6 mt-3 mt-sm-0">
                                            <div class="text-center text-sm-right contactDiv">
                                                <ul class="contact-section d-inline-block OL-EDITABLE my-2" data-tab="#_contact_section_">
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
                                    <div class="row m-0 my-md-4 my-sm-4 position-relative">
                                        <div class="col-12 col-md-7 col-sm-7 text-center position-relative">
                                            <div class="banner_img">
                                                <img src="{{ asset('assets/templates/'.$id.'/Asset.png')}}" class="banner_img1">
                                                <div class="banner_text">
                                                    <div class="offer_text">
                                                        <p class="text-uppercase mb-0 OL-EDITABLE" data-tab="#_text_1_" id="text_input_1">{{ $template->content[0]->content }}</p>
                                                    </div>
                                                    <div class="offer">
                                                        <h1 class="OL-EDITABLE" data-tab="#_text_2_" id="text_input_2">{{ $template->content[1]->content }}</h1>
                                                        <h2 class="OL-EDITABLE" data-tab="#_text_3_" id="text_input_3">{{ $template->content[2]->content }}</h2>
                                                    </div>
                                                    <div class="offer_HR">
                                                        <hr class="offer_line1 mt-0">
                                                        <hr class="offer_line2">
                                                    </div>
                                                    
                                                    <div class="banner_img2">
                                                        <img src="{{ asset('assets/templates/'.$id.'/Asset12.png')}}" class="banner_width">
                                                        <div class="discount">
                                                            <h4 class="OL-EDITABLE mb-1" data-tab="#_text_4_" id="text_input_4">{{ $template->content[3]->content }}</h4>
                                                            <p class="text-uppercase OL-EDITABLE mb-1" data-tab="#_text_5_" id="text_input_5">{{ $template->content[4]->content }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-5 col-sm-5">
                                            <div class="main-banner">
                                                <div class="img-div">
                                                    <div class="OL-EDITABLE main_image" data-tab="#_main_image_">
                                                        <img src="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" class="img-fluid" id="tem_main_img" alt="Banner" style="border-radius: 0px 75px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="temp-container">
                                <div class="row my-5">
                                    <div class="col-12 col-sm-10 col-md-7">
                                        <div class="headtxt px-4">
                                            <h3 class="h1 OL-EDITABLE" data-tab="#_text_6_" id="text_input_6">{{ $template->content[5]->content }}</h3>
                                            <p class="textW OL-EDITABLE" data-tab="#_text_7_" id="text_input_7">{{ $template->content[6]->content }}</p>
                                            {{-- call to action button --}}
                                            <div class="mb-3 call-to-action">
                                                <div class="d-inline-block OL-EDITABLE" data-tab="#_call_to_action_1">
                                                    <a href="{{ $template->button[0]->link }}" class="btn btn-call-act cta_btn_element_1 @if($template->button[0]->is_hidden == 1) disabled @endif" id="action_btn_1" data-default-name="Read More" data-default-color="#000000" target="_blank">{{ $template->button[0]->name }}</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row px-4 align-items-center">
                                    @if(!empty($template->gallery))
                                        @foreach($template->gallery as $gallery)
                                            <div class="col-12 col-sm-6 col-md-4">
                                                <div class="col-border mb-5">
                                                    <div class="columns OL-EDITABLE" data-tab="#_gal_sec_{{$loop->iteration}}">
                                                        <div class="product-card">
                                                            <div class="img-thumb" tag-name="{{ $gallery->tag_1 }}" id="tem_img{{ $loop->iteration }}"data-default-img="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}});"></div>
                                                                <div class="position-relative title_bg mx-auto ">
                                                                    <div class="priceAmount py-2">
                                                                        <p class="mb-0 product_price p-2">
                                                                            <span class="price1">&#8377;<span class="sale_price_{{ $loop->iteration }}">{{ $gallery->sale_price }}</span></span>
                                                                            <span class="price2">&#8377;<span class=" price_{{ $loop->iteration }}">{{ $gallery->price }}</span></span>
                                                                        </p>
                                                                    </div>
                                                                </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>    
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="footer p-4">
                            <div class="container-fluid">
                                <div class="row align-items-center">
                                    <div class="col-sm-6 py-sm-2">
                                        <div class="busines-name text-center text-sm-left">
                                            <h5 class="mb-sm-0">{{ $business->business_name }}</h5>
                                            <p class="mb-0 small">{{ $business->tag_line }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 text-center text-sm-right">
                                        <div class="mt-2" data-tab="#_social_links_">
                                            <ul class="social-icons m-0">
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
