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
                    <div class="banner-bg-clr">
                        <div class="container-fluid">
                            <div class="row justify-content-end align-items-center px-5">
                                <div class="col-md-6 col-12 text-center text-md-left">
                                    <div class="logo mt-3 my-md-3">
                                        @if($only_view == 1)
                                            <img src="{{ asset('assets/templates/'.$id.'/logo.png')}}" class="img-fluid" alt="Logo">
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
                                <div class="col-md-6 col-12">
                                    <div class="text-center text-md-right">
                                        <ul class="contact-section mb-md-0 mt-2 d-line-block pl-0 OL-EDITABLE" data-tab="#_contact_section_">
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
                                <div class="col-md-12">
                                    <div class="bannerSec mt-3 mb-5 py-3">
                                        <div class="ban_tag_offer1">
                                            <p class="ban_tag_text m-0 text-uppercase OL-EDITABLE" data-tab="#_text_4_" id="text_input_4">{{ $template->content[3]->content }}</p>
                                        </div>
                                        <div class="bannertxt text-center text-md-left py-md-5 pl-0 pl-md-4">
                                            <h4 class="banhead1 text-uppercase OL-EDITABLE" data-tab="#_text_1_" id="text_input_1">{{ $template->content[0]->content }}</h4>
                                            <h1 class="banhead2 OL-EDITABLE" data-tab="#_text_2_" id="text_input_2">{{ $template->content[1]->content }}</h1>
                                            <h6 class="OL-EDITABLE" data-tab="#_text_3_" id="text_input_3">{{ $template->content[2]->content }}</h6>
                                        </div>
                                        <div class="ban_tag_offer2">
                                            <p class="ban_tag_text text-uppercase m-0 OL-EDITABLE" data-tab="#_text_5_" id="text_input_5">{{ $template->content[4]->content }}</p>
                                        </div>
                                        <div class="bannerImg">
                                            <div class="OL-EDITABLE" data-tab="#_main_image_">
                                                <img src="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" class="img-fluid" id="tem_main_img" alt="Banner">
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    {{-- about section --}}
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            @if(!empty($template->gallery))
                                <div class="col-12 col-md-6 px-0 OL-EDITABLE text-center" data-tab="#_gal_sec_1">
                                    <div class="">
                                        <div class="img-thumb-img img-fluid" id="tem_img1" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->gallery[0]->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->gallery[0]->image_path)}});">
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 col-md-6 pl-4 pl-md-0 py-4">
                                <h3 class="OL-EDITABLE" data-tab="#_text_6_" id="text_input_6" style="font-weight: bold;">{{ $template->content[5]->content }}</h3>
                                <p class="pt-2 OL-EDITABLE" data-tab="#_text_7_" id="text_input_7">{{ $template->content[6]->content }}</p>
                                {{-- call to action button --}}
                                @if($template->button[0]->is_hidden != 1)
                                    <div class="mb-5 call-to-action">
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

                    {{-- gallery section one --}}
                    <div class="container-fluid">
                        @if(!empty($template->gallery))
                        <div class="row">
                            @foreach($template->gallery as $gallery)
                            @if($loop->iteration > 1 && $loop->iteration < 4)
                            <div class="OL-EDITABLE col-md-6 col-sm-12 px-0 gallery_box" data-tab="#_gal_sec_{{$loop->iteration}}">
                                <div class="product-card">
                                    <div class="img-thumb" tag-name="{{ $gallery->tag_1 }}" id="tem_img{{ $loop->iteration }}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}});"></div>
                                </div>
                                <div class="gallery_desc py-4 text-center">
                                    <div class="title-bar">
                                        <p class="mb-0 h5" id="tem_image_title_{{ $loop->iteration }}">{{ $gallery->title }}</p>
                                    </div>
                                    <div class="price mt-3 text-center">
                                        <h5 class="mb-0 py-2">
                                            <span class="price2">&#8377;<span class=" price_{{ $loop->iteration }}">{{ $gallery->price }}</span></span>
                                            <span class="price1 mr-2">&#8377;<span class="sale_price_{{ $loop->iteration }}">{{ $gallery->sale_price }}</span></span>
                                            
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            
                            @endif
                            @endforeach
                        </div>
                        @endif
                    </div>

                    {{-- strip section --}}
                    <div class="banner-bg-clr">
                        <div class="container-fluid">
                                <div class="text-center text-uppercase py-3">
                                <h3 class="OL-EDITABLE" data-tab="#_text_8_" id="text_input_8" style="font-weight: bold;">{{ $template->content[7]->content }}</h3>
                                <h5 class="pt-2 OL-EDITABLE" data-tab="#_text_9_" id="text_input_9">{{ $template->content[8]->content }}</h5>
                            </div>
                        </div>
                    </div>

                    {{-- gallery section two --}}
                    <div class="container-fluid">
                        @if(!empty($template->gallery))
                        <div class="row">
                            @foreach($template->gallery as $gallery)
                            @if($loop->iteration > 3 && $loop->iteration < 6)
                            <div class="OL-EDITABLE col-md-6 col-sm-12 px-0 gallery_box" data-tab="#_gal_sec_{{$loop->iteration}}">
                                <div class="product-card">
                                    <div class="img-thumb" tag-name="{{ $gallery->tag_1 }}" id="tem_img{{ $loop->iteration }}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}});"></div>
                                </div>
                                <div class="gallery_desc_2 py-4 text-center">
                                    <div class="title-bar">
                                        <p class="mb-0 h5" id="tem_image_title_{{ $loop->iteration }}">{{ $gallery->title }}</p>
                                    </div>
                                    <div class="price mt-3 text-center">
                                        <h5 class="mb-0 py-2">
                                            <span class="price2">&#8377;<span class=" price_{{ $loop->iteration }}">{{ $gallery->price }}</span></span>
                                            <span class="price1 mr-2">&#8377;<span class="sale_price_{{ $loop->iteration }}">{{ $gallery->sale_price }}</span></span>
                                            
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            
                            @endif
                            @endforeach
                        </div>
                        @endif
                    </div>

                    {{-- footer section --}}
                    <div class="banner-bg-clr p-2">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12">
                                    <div class="OL-EDITABLE text-center text-md-left" data-tab="#_social_links_">
                                        <ul class="social-icons">
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
                                    {{-- <div class="my-2">
                                        @if($only_view != 1)
                                                <a href="tel:{{ $call_number }}" class="link_domain" id="website_link" style="color: initial;"><i class="bi bi-phone"></i> {{ $call_number }}</a>
                                            @else
                                                <a href="" class="link_domain" id="website_link" style="color: initial;"><i class="bi bi-phone"></i> 9123456789</a>
                                            @endif
                                    </div> --}}
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="busines-name text-center text-md-right mb-3">
                                        @if($only_view == 1)
                                            <h1 class="h4 mt-3 mb-1">The Food Store</h1>
                                            <p class="mb-0">Yummy Food with discount</p>
                                        @else

                                            @if($business->website != null)
                                            <h1 class="h4 text-uppercase"><a href="{{$business->website}}" target="_blank" class="website_anchr">{{ $business->business_name }}</a></h1>
                                            @else
                                            <h1 class="h4 text-uppercase">{{ $business->business_name }}</h1>
                                            @endif
                                            
                                            <p class="mb-0">{{ $business->tag_line }}</p>
                                        @endif
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