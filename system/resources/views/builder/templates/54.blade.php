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
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 px-0">
                                    <div class="bannerimage">
                                        <div class="">
                                            <div class="bannerTxt text-center">
                                                <h2 class="banhead1 OL-EDITABLE" data-tab="#_text_1_" id="text_input_1">{{ $template->content[0]->content }}</h2>
                                                <h1 class="sale OL-EDITABLE" data-tab="#_text_2_" id="text_input_2">{{ $template->content[1]->content }}</h1>
                                                <div>
                                                    <img src="{{ asset('assets/templates/'.$id.'/asset2.png')}}" alt="lineimage" class="line">
                                                </div>
                                                <h5 class="flat mt-2 mb-1 OL-EDITABLE text-uppercase" data-tab="#_text_3_" id="text_input_3">{{ $template->content[2]->content }}</h5>
                                                <div>
                                                    <img src="{{ asset('assets/templates/'.$id.'/asset2.png')}}" alt="lineimage" class="line">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid pb-5">
                            <div class="temp-container">
                                <div class="contactDiv text-center">
                                    <ul class="contact-section OL-EDITABLE mb-0" data-tab="#_contact_section_">
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
                                <div class="row">
                                    <div class="col-12 text-center pt-5">
                                        <h3 class="banhead2 OL-EDITABLE" data-tab="#_text_4_" id="text_input_4">{{ $template->content[3]->content }}</h3>
                                        <h5 class="mt-3 ptext OL-EDITABLE" data-tab="#_text_5_" id="text_input_5">{{ $template->content[4]->content }}</h5>
                                        {{-- call to action button --}}
                                        <div class="mb-5 mt-4 text-center call-to-action">
                                            <div class="d-inline-block OL-EDITABLE" data-tab="#_call_to_action_1">
                                                <a href="{{ $template->button[0]->link }}" class="btn btn-call-act cta_btn_element_1 @if($template->button[0]->is_hidden == 1) disabled @endif" id="action_btn_1" data-default-name="Read More" data-default-color="#000000" target="_blank">{{ $template->button[0]->name }}</a>
                                            </div>
                                        </div>
                                        <div class="OL-EDITABLE mt-5" data-tab="#_main_image_">
                                            <img src="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" class="img-fluid mainimage" id="tem_main_img" alt="Banner">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-start pt-5">
                                            <h3 class="banhead3 OL-EDITABLE" data-tab="#_text_6_" id="text_input_6">{{ $template->content[5]->content }}</h3>
                                            <hr class="hrline">
                                        </div>
                                   </div>
                                </div>
                            </div>
                        </div> 
                        <div class="banmidcolor">
                            <div class="container-fluid">
                                <div class="temp-container sideImages">
                                    <div class="mt-5 text-center">
                                        <span class="offer_img">
                                            <img src="{{ asset('assets/templates/'.$id.'/asset1.png')}}" class="img-fluid diya" alt="Offer Banner">
                                        </span>
                                        <span class="offer_img">
                                            <img src="{{ asset('assets/templates/'.$id.'/asset2.png')}}" class="img-fluid line3" alt="Offer Banner">
                                        </span>
                                        <span class="offer_img">
                                            <img src="{{ asset('assets/templates/'.$id.'/asset1.png')}}" class="img-fluid diya2" alt="Offer Banner">
                                        </span>
                                    </div>
                                    <div class="row align-items-center">
                                        @if(!empty($template->gallery))
                                            @foreach($template->gallery as $gallery)
                                                <div class="col-12 col-md-6 mt-4">
                                                    <div class="OL-EDITABLE" data-tab="#_gal_sec_{{$loop->iteration}}">
                                                        <div class="columns">
                                                            <div class="product-card">
                                                                <div class="img-thumb" tag-name="{{ $gallery->tag_1 }}" id="tem_img{{ $loop->iteration }}"data-default-img="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}});"></div>
                                                            </div>
                                                        </div>   
                                                        <div class="position-relative title_bg mx-auto ">
                                                            <div class="priceAmount mt-3">
                                                                <p class="mb-0 product_price p-2">
                                                                    <span class="price1">&#8377;<span class="sale_price_{{ $loop->iteration }}">{{ $gallery->sale_price }}</span></span>
                                                                    <span class="price2">&#8377;<span class=" price_{{ $loop->iteration }}">{{ $gallery->price }}</span></span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                   </div>
                                    <div class="my-3 text-center">
                                        <span class="offer_img">
                                            <img src="{{ asset('assets/templates/'.$id.'/asset1.png')}}" class="img-fluid diya" alt="Offer Banner">
                                        </span>
                                        <span class="offer_img">
                                            <img src="{{ asset('assets/templates/'.$id.'/asset2.png')}}" class="img-fluid line3" alt="Offer Banner">
                                        </span>
                                        <span class="offer_img">
                                            <img src="{{ asset('assets/templates/'.$id.'/asset1.png')}}" class="img-fluid diya2" alt="Offer Banner">
                                        </span>
                                    </div>
                                    <div class="my-5">
                                            <span class="offer_img1">
                                            <img src="{{ asset('assets/templates/'.$id.'/asset2.png')}}" class="img-fluid" alt="Offer Banner">
                                            </span>
                                    </div>
                                    <div class="my-5 text-right">
                                        <span class="offer_img2">
                                            <img src="{{ asset('assets/templates/'.$id.'/asset2.png')}}" class="img-fluid" alt="Offer Banner">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="footer pt-5 ">
                                <div class="logo mb-1 text-center">
                                    @if($business->logo != '')
                                        <img src="{{ asset('assets/business/logos/'.$business->logo)}}" class="logo" alt="Logo">
                                    @endif
                                </div>
                                <div class="busines-name businessname text-center">
                                        <h1 class="h5 mb-0">{{ $business->business_name }}</h1>
                                        <p class="mb-sm-0 small">{{ $business->tag_line }}</p>
                                </div>
                                <div class="mt-2" data-tab="#_social_links_">
                                    <ul class="social-icons text-center m-0 pb-3">
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
            </section>
        </main>
    </div>
</section>
