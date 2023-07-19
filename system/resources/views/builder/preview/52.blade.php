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
                        <div class="position-relative">
                            <div class="container-fluid mb-md-5 pb-md-5">
                                <div class="row">
                                    <div class="col-12 col-md-7 order-2 order-md-1 main_image px-0">
                                       <div class="OL-EDITABLE main_image_hght" data-tab="#_main_image_">
                                            <img src="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" class="Head_img main_image_hght" id="tem_main_img" alt="Banner">
                                        </div>
                                    </div>
                                    <div class="bg-color col-12 order-1 order-md-2 col-md-5 px-0">
                                        <div class="p-3">
                                            <div class="banImg text-center">
                                                <span class="corner_design">
                                                    <img src="{{ asset('assets/templates/'.$id.'/design.png')}}" class="img-fluid" alt="Banner">
                                                </span>
                                                <span class="corner_design">
                                                    <img src="{{ asset('assets/templates/'.$id.'/design.png')}}" class="img-fluid" alt="Banner">
                                                </span>
                                                <span class="corner_design">
                                                    <img src="{{ asset('assets/templates/'.$id.'/design.png')}}" class="img-fluid" alt="Banner">
                                                </span>
                                                <span class="corner_design">
                                                    <img src="{{ asset('assets/templates/'.$id.'/design.png')}}" class="img-fluid" alt="Banner">
                                                </span>                                                        
                                                <div class="logo mx-auto">
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
                                                <div class="bandImg mx-auto">
                                                    <img src="{{ asset('assets/templates/'.$id.'/band.png')}}" class="img-fluid" alt="Logo">
                                                </div>  
                                                <div class="text-center marText">
                                                    <h1 class="banHead1 OL-EDITABLE" data-tab="#_text_1_" id="text_input_1">{{ $template->content[0]->content }}</h1>
                                                    <h1 class="banHead2 text-uppercase OL-EDITABLE" data-tab="#_text_2_" id="text_input_2">{{ $template->content[1]->content }}</h1>
                                                    <p class="banHead3 text-uppercase OL-EDITABLE" data-tab="#_text_3_" id="text_input_3" style="display: inline-block;">{{ $template->content[2]->content }}</p>
                                                    <span class="banHead2  OL-EDITABLE" data-tab="#_text_4_" id="text_input_4" style="display: inline-block; font-family: lato;">{{ $template->content[3]->content }}</span>
                                                    <p class="banHead3 text-uppercase OL-EDITABLE" data-tab="#_text_5_" id="text_input_5" style="display: inline-block;">{{ $template->content[4]->content }}</p>
                                                </div>
                                                <div class="mb-5 underline">
                                                    <hr class="banner_underline">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid">
                                <div class="row couponimg_position mt-5 mt-md-3 m-md-4 mb-md-5 align-items-center">
                                    @if(!empty($template->gallery))
                                        <div class="col-12 col-md-4 px-0  couponimg OL-EDITABLE text-center" data-tab="#_gal_sec_1">
                                            <div class="">
                                                <div class="img-thumb-section img-fluid" id="tem_img1" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->gallery[0]->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->gallery[0]->image_path)}});">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-12 col-md-4 coupon_content">
                                        <h3 class="coupon_box mt-4 mb-2 p-2 text-uppercase OL-EDITABLE" data-tab="#_text_6_" id="text_input_6" style="font-family: lato;font-weight: 600;">{{ $template->content[5]->content }}</h3>
                                        <h3 class="h5 coupon_head text-uppercase OL-EDITABLE" data-tab="#_text_7_" id="text_input_7">{{ $template->content[6]->content }}</h3>
                                        <p class="OL-EDITABLE mb-1" data-tab="#_text_8_" id="text_input_8">{{ $template->content[7]->content }}</p>
                                        <p class="mb-2 coupon_text OL-EDITABLE" data-tab="#_text_9_" id="text_input_9" style="line-height: 20px;">{{ $template->content[8]->content }}</p>
                                        {{-- call to action button --}}
                                        @if($template->button[0]->is_hidden != 1)
                                            <div class="mt-3 mb-1 text-center call-to-action">
                                                <div class="d-inline-block">
                                                    @if($template->button[0]->link == '#')
                                                        <a href="{{ $template->button[0]->link }}" id="action_btn_1" class="btn btn-call-act">{{ $template->button[0]->name }}</a>
                                                    @else
                                                        <a href="{{ $template->button[0]->link }}" id="action_btn_1" class="btn btn-call-act" target="_blank">{{ $template->button[0]->name }}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        <div class="contactDiv py-3">
                                            <ul class="contact-section d-inline-block mb-0 OL-EDITABLE" data-tab="#_contact_section_">
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
                                    @if(!empty($template->gallery))
                                        <div class="col-12 col-md-4 px-0  couponimg OL-EDITABLE text-center" data-tab="#_gal_sec_2">
                                            <div class="">
                                                <div class="couponimg2 img-thumb-section img-fluid" id="tem_img2" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->gallery[1]->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->gallery[1]->image_path)}});">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>   
                            </div>
                            <div class="container-fluid">
                                <div class="mb-sm-5 px-2 px-sm-5">
                                    <h2 class="product_title text-uppercase OL-EDITABLE mb-4 mb-sm-2 mt-4" data-tab="#_text_10_" id="text_input_10">{{ $template->content[9]->content }}</h2>
                                       
                                    <div class="row align-items-centers">
                                    @if(!empty($template->gallery))
                                        @foreach($template->gallery as $gallery)
                                        @if($loop->iteration > 2 && $loop->iteration < 9)
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <div class="columns mb-4 OL-EDITABLE" data-tab="#_gal_sec_{{$loop->iteration}}">
                                                <div class="product-card mb-3">
                                                    <div class="img-thumb ImG" tag-name="{{ $gallery->tag_1 }}" id="tem_img{{ $loop->iteration }}"data-default-img="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}});"></div>
                                                </div>
                                                <div class="priceAmount">
                                                    <p class="mb-0">
                                                        <span class="price1">&#8377;<span class="sale_price_{{ $loop->iteration }}">{{ $gallery->sale_price }}</span></span>
                                                        <span class="price2">&#8377;<span class=" price_{{ $loop->iteration }}">{{ $gallery->price }}</span></span>
                                                    </p>
                                                </div> 
                                                <div class="position-relative text-center">
                                                    <div class="title-bar">
                                                        <p class="py-2 mt-2 mb-0" id="tem_image_title_{{ $loop->iteration }}">{{ $gallery->title }}</p>
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
                            <div class="container-fluid">
                                    <div class="row">
                                        @if(!empty($template->gallery))
                                        <div class="col-12 footer_img px-0 OL-EDITABLE text-center" data-tab="#_gal_sec_9">
                                            <div class="">
                                                <div class="img-fluid img-thumb-footer" id="tem_img9" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->gallery[8]->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->gallery[8]->image_path)}});">
                                                </div>
                                            </div>
                                        </div>
                                    @endif  
                                    </div>
                                    <div class="row footer pt-3">
                                        <div class="col-12 col-md-6">
                                            <div class="busines-name ml-3">
                                                @if($only_view == 1)
                                                    <h1 class="h5 mb-1">Grocery</h1>
                                                    <p class="mb-sm-0 small">Apki Apni Dukan</p>
                                                @else
                                                    @if($business->website != null)
                                                    <h1 class="h5 mb-1"><a href="{{$business->website}}" target="_blank" class="website_anchr">{{ $business->business_name }}</a></h1>
                                                    @else
                                                    <h1 class="h5 mb-1">{{ $business->business_name }}</h1>
                                                    @endif
                                                    <p class="mb-sm-0 small">{{ $business->tag_line }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="OL-EDITABLE text-center text-md-right mr-3" data-tab="#_social_links_">
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