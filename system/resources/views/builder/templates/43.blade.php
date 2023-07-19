<section id="Template" class="mb-5">
    <div id="builder_canvas">
        <main id="wrapper" class="">
            <section id="template-full-container" class="template-container OL-EDITABLE OL-ACTIVE" data-tab="#_main_tab_">
                <div class="template-main" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->bg_image)}});background-color: {{ $template->bg_color }};" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->bg_image)}}" id="tem_back">
                    <div class="inner-wrapper">
                        {{-- main banner --}}
                        <div class="mb-3 mb-md-5 position-relative bg-color">
                            <div class="container-fluid">
                                <div class="temp-container">
                                    <div class="logo pt-3 mb-3">
                                        @if($business->logo != '')
                                        <img src="{{ asset('assets/business/logos/'.$business->logo)}}" class="img-fluid" alt="Logo">
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="py-5 main_image OL-EDITABLE" data-tab="#_main_image_">
                                                <img src="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" class="w-100" id="tem_main_img" alt="Banner">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ban-upper p-4">
                                        <div class="d-flex flex-column justify-content-between" style="height: 300px_">
                                            <div>
                                                <h2 id="text_input_1" class="text-uppercase OL-EDITABLE" data-tab="#_text_1_">{{ $template->content[0]->content }}</h2>
                                                <hr class="headHr ml-0">
                                            </div>
                                            {{-- call to action button --}}
                                            <div class="mb-5 call-to-action">
                                                <div class="d-inline-block OL-EDITABLE" data-tab="#_call_to_action_1">
                                                    <a href="{{ $template->button[0]->link }}" class="btn btn-call-act cta_btn_element_1 @if($template->button[0]->is_hidden == 1) disabled @endif" id="action_btn_1" data-default-name="Read More" data-default-color="#000000" target="_blank">{{ $template->button[0]->name }}</a>
                                                </div>
                                            </div>
                                            <div class="contact-tab">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="temp-container">
                                <div class="bg-theme py-4 mb-5">
                                    <div class="">
                                        <h2 class="h3 OL-EDITABLE tmp-head-text" data-tab="#_text_2_" id="text_input_2">{{ $template->content[1]->content }}</h2>
                                        <p class="mb-0 OL-EDITABLE tmp-subhead-text" data-tab="#_text_3_" id="text_input_3">{{ $template->content[2]->content }}</p>
                                    </div>
                                </div>

                                <div class="position-relative">
                                    <p class="productHead mb-2 "><span class="text-dark OL-EDITABLE" data-tab="#_text_4_" id="text_input_4">{{ $template->content[3]->content }}</span></p>
                                    <hr class="hrline1">
                                </div>
    
                                <div class="mb-5">
                                    <div class="">
                                        <div class="d-sm-flex justify-content-between align-items-center">
                                            @if(!empty($template->gallery))
                                                @foreach($template->gallery as $gallery)
                                                @if($loop->iteration < 5)
                                                <div class="columns OL-EDITABLE" data-tab="#_gal_sec_{{$loop->iteration}}">
                                                    <div class="product-card">
                                                        <div tag-name="{{ $gallery->tag_1 }}" class="img-thumb" id="tem_img{{ $loop->iteration }}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}});"></div>
                                                    </div>
                                                    <div class="position-relative">
                                                        <div class="title-bar">
                                                            <p class="mb-0" id="tem_image_title_{{ $loop->iteration }}">{{ $gallery->title }}</p>
                                                        </div>
                                                        <span class="discountSec" id="tem_tag_bg{{ $loop->iteration }}">{{ $gallery->tag_2 }}</span>
                                                    </div>
                                                    <div class="priceAmount">
                                                        <p class="mb-0">
                                                            <span class="price1 text-dark">&#8377;<span class="sale_price_{{ $loop->iteration }} text-dark">{{ $gallery->sale_price }}</span></span>
                                                            <span class="price2 text-dark">&#8377;<span class="price_{{ $loop->iteration }}">{{ $gallery->price }}</span></span>
                                                        </p>
                                                    </div>
                                                </div>
                                                @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="position-relative mt-5">
                                    <p class="productHead mb-2"><span class="text-dark OL-EDITABLE" data-tab="#_text_5_" id="text_input_5">{{ $template->content[4]->content }}</span></p>
                                    <hr class="hrline1">
                                </div>
    
                                <div class="mb-5">
                                    <div>
                                        <div class="d-sm-flex justify-content-between align-items-center">
                                            @if(!empty($template->gallery))
                                                @foreach($template->gallery as $gallery)
                                                @if($loop->iteration > 4)
                                                <div class="columns OL-EDITABLE" data-tab="#_gal_sec_{{$loop->iteration}}">
                                                    <div class="product-card">
                                                        <div tag-name="{{ $gallery->tag_1 }}" class="img-thumb" id="tem_img{{ $loop->iteration }}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}});"></div>
                                                    </div>
                                                    <div class="position-relative">
                                                        <div class="title-bar">
                                                            <p class="mb-0" id="tem_image_title_{{ $loop->iteration }}">{{ $gallery->title }}</p>
                                                        </div>
                                                        <span class="discountSec" id="tem_tag_bg{{ $loop->iteration }}">{{ $gallery->tag_2 }}</span>
                                                    </div>

                                                    <div class="priceAmount">
                                                        <p>
                                                            <span class="price1 text-dark">&#8377;<span class="sale_price_{{ $loop->iteration }} text-dark">{{ $gallery->sale_price }}</span></span>
                                                            <span class="price2 text-dark">&#8377;<span class="price_{{ $loop->iteration }}">{{ $gallery->price }}</span></span>
                                                        </p>
                                                    </div>
                                                </div>
                                                @endif

                                                @endforeach
                                            @endif
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
                        <div class="bg-color py-4">
                            <div class="container-fluid">
                                <div class="temp-container">
                                    <div class="row align-items-center">
                                       
                                        <div class="col-sm-6">
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

                                         <div class="col-sm-6">
            
                                           {{-- Business Name & Tagline  --}}
                                            <div class="busines-name text-right">
                                                <h1 class="h5 mb-0">{{ $business->business_name }}</h1>
                                                <p class="mb-sm-0 small">{{ $business->tag_line }}</p>
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

