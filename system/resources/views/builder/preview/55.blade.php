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
            <section class="template-container OL-EDITABLE OL-ACTIVE" data-tab="#_main_tab_">
                <div class="template-main" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->bg_image)}});background-color: {{ $template->bg_color }};" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->bg_image)}}" id="tem_back">
                    <div class="inner-wrapper">
                        <div class="bg-grey position-relative">
                            <div class="pb-sm-5 pb-0 position-relative">
                                <div class="container-fluid">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-6 col-sm-6 logo pt-3 pt-sm-0">
                                            <div class="logo">
                                                @if($only_view == 1)
                                                    <img src="{{ asset('assets/templates/'.$id.'/logo.png')}}" class="head_img img-fluid" alt="Logo">
                                                @else
                                                    @if($business->logo != '')
                                                        
                                                        @if($business->website != null)
                                                        <a href="{{$business->website}}" target="_blank">
                                                            <img src="{{ asset('assets/business/logos/'.$business->logo)}}" class="img-fluid" alt="Logo">
                                                        </a>
                                                        @else
                                                        <img src="{{ asset('assets/business/logos/'.$business->logo)}}" class="img-fluid" alt="Logo">
                                                        @endif

                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-sm-6 mt-3 mt-sm-0">
                                            <div class="text-center text-sm-right contactDiv">
                                                <ul class="contact-section OL-EDITABLE my-2" data-tab="#_contact_section_">
                                                    @if($only_view == 1)
                                                    <li><a href=""><i class="bi bi-telephone"></i></a></li>
                                                    <li><a href=""><i class="bi bi-whatsapp"></i></a></li>
                                                    <li><a href="#" data-toggle="modal" data-target="#LocationModal"><i class="bi bi-geo-alt"></i></a></li>
                                                    <li><a href=""><i class="bi bi-globe2"></i></a></li>
                                                    @else
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
                                                            <p class="text-uppercase mb-1 OL-EDITABLE" data-tab="#_text_5_" id="text_input_5">{{ $template->content[4]->content }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-5 col-md-5">
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
                                            @if($template->button[0]->is_hidden != 1)
                                                <div class="mb-3 call-to-action">
                                                    <div class="d-inline-block">
                                                        @if($template->button[0]->link == '#')
                                                            <a href="{{ $template->button[0]->link }}" id="action_btn_1" class="btn btn-call-act">{{ $template->button[0]->name }}</a>
                                                        @else
                                                            <a href="{{ $template->button[0]->link }}" id="action_btn_1" class="btn btn-call-act" target="_blank">{{ $template->button[0]->name }}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
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
                                            @if($only_view == 1)
                                                <h5 class="mb-sm-0">HARILAL SWEETS</h5>
                                                <p class="mb-0 small">Flavor for royalty</p>
                                            @else

                                                @if($business->website != null)
                                                <h5 class="mb-sm-0"><a href="{{$business->website}}" target="_blank" class="website_anchr">{{ $business->business_name }}</a></h5>
                                                @else
                                                <h5 class="mb-sm-0">{{ $business->business_name }}</h5>
                                                @endif

                                                <p class="mb-0 small">{{ $business->tag_line }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6 text-center text-sm-right">
                                        <div class="OL-EDITABLE mt-2" data-tab="#_social_links_">
                                            <ul class="social-icons m-0">
                                                @if($only_view == 1)
                                            
                                                    <li class="si-tab">
                                                        <a href="" class="fb" title="Facebook" id="facebook_link" target="_blank"><i class="bi bi-facebook fb"></i></a>
                                                    </li>
                                                    
                                                    <li class="si-tab">
                                                        <a href="" class="ig" title="Instagram" id="instagram_link" target="_blank"><i class="bi bi-instagram ig"></i></a>
                                                    </li>
                                                    
                                                    <li class="si-tab">
                                                        <a href="" class="tw" title="Twitter" id="twitter_link" target="_blank"><i class="bi bi-twitter tw"></i></a>
                                                    </li>
                                                    
                                                    <li class="si-tab">
                                                        <a href="" class="li" title="LinkedIn" id="linkedin_link" target="_blank"><i class="bi bi-linkedin li"></i></a>
                                                    </li>
                                                    
                                                    
                                                    {{-- <li class="si-tab">
                                                        <a href="#" class="pr" title="Pinterest"><i class="bi bi-pinterest pr" target="_blank"></i></a>
                                                    </li> --}}

                                                    
                                                    <li class="si-tab">
                                                        <a href="" class="yt" title="YouTube" id="youtube_link" target="_blank"><i class="bi bi-youtube yt"></i></a>
                                                    </li>

                                                    <li class="si-tab">
                                                        <a href="" class="gr" title="Google" id="google_review_link" target="_blank"><i class="bi bi-google gr"></i></a>
                                                    </li>

                                                    @else

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
                                                @endif
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


@if($only_view != 1)
    <div class="modal fade" id="LocationModal" tabindex="-1" role="dialog" aria-labelledby="LocationModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
                <p class="mb-0">{{ $business['address_line_1'] }}, {{ $business['address_line_2'] }},<br>
                   {{ $business['city'] }},<br>
                   {{ $business['state'] }},<br>
                   {{ $business['pincode'] }}.<br>
                   Phone Number - {{ $business['call_number'] }}</p>
            </div>
        </div>
      </div>
    </div>
@endif