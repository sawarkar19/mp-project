<section id="Template" class="">
    <div id="builder_canvas">
        <main id="wrapper" class="">
            <section class="template-container OL-EDITABLE OL-ACTIVE" data-tab="#_main_tab_">
                <div class="template-main" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->bg_image)}});background-color: {{ $template->bg_color }};" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->bg_image)}}" id="tem_back">
                    <div class="inner-wrapper">
                            
                        <div class="mb-3 mb-md-5 position-relative">
                            <div class="bg-color">
                                <div class="temp-container">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="logo pl-1 pt-3 mb-3">
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
                                        <div class="contact-tab">
                                            <ul class="contact-section OL-EDITABLE" data-tab="#_contact_section_">
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
                            </div>

                            <div class="container-fluid">

                                <div class="temp-container">
                                   {{-- main banner --}}
                                    <div class="row align-items-center">
                                        <div class="col-sm-6">
                                            <div class="py-5">
                                                <div class="outer_box">
                                                    <div class="main_image OL-EDITABLE" data-tab="#_main_image_">
                                                        <img src="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->hero_image)}}" class="w-100" id="tem_main_img" alt="Banner">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="p-4 text-center">
                                                <div class="OL-EDITABLE" data-tab="#_text_1_">
                                                    <h2 class="h3" id="text_input_1">{{ $template->content[0]->content }}</h2>
                                                </div>
                                                <div class="image_sec">
                                                    <p class="editableText OL-EDITABLE mb-0" data-tab="#_text_2_" id="text_input_2">{{ $template->content[1]->content }}</p>
                                                </div>
                                                <div class="OL-EDITABLE" data-tab="#_text_3_">
                                                    <h2 class="h1 text-uppercase banHeadText" id="text_input_3">{{ $template->content[2]->content }}</h2>
                                                </div>
                                                <div class="OL-EDITABLE" data-tab="#_text_4_">
                                                    <hr class="hrTop">
                                                    <p id="text_input_4" class="text-uppercase h3 my-0" style="font-weight: bold;">{{ $template->content[3]->content }}</p>
                                                    <hr class="hrBtm">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="temp-container">

                                <div class="bg-theme py-4 px-3 mb-5 text-center">
                                    <div>
                                        <h2 class="h2 OL-EDITABLE" data-tab="#_text_5_" id="text_input_5">{{ $template->content[4]->content }}</h2>
                                        <p class="mb-0 OL-EDITABLE" data-tab="#_text_6_" id="text_input_6">{{ $template->content[5]->content }}</p>
                                    </div>
                                    {{-- call to action button --}}
                                    @if($template->button[0]->is_hidden != 1)
                                        <div class="my-3 text-center call-to-action">
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
                              
    
                                <div class="mb-5 p-2">
                                    <div>
                                        <div class="row align-items-center">
                                            @if(!empty($template->gallery))
                                                @foreach($template->gallery as $gallery)
                                                @if($loop->iteration < 5)
                                                <div class="col-12 col-sm-6 col-lg-3">
                                                <div class="columns OL-EDITABLE" data-tab="#_gal_sec_{{$loop->iteration}}">
                                                    <div class="product-card">
                                                        <div tag-name="{{ $gallery->tag_1 }}" class="img-thumb" id="tem_img{{ $loop->iteration }}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}});"></div>
                                                    </div>
                                                    <div class="position-relative">
                                                        <div class="title-bar">
                                                            <p class="mb-0" id="tem_image_title_{{ $loop->iteration }}" style="font-weight: bold;">{{ $gallery->title }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="priceAmount">
                                                        <p class="py-2">
                                                            <span class="price1">&#8377;<span class="price1 sale_price_{{ $loop->iteration }}">{{ $gallery->sale_price }}</span></span>
                                                            <span class="price2 price_{{ $loop->iteration }}">{{ $gallery->price }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                </div>
                                                @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-5 p-2">
                                    <div>
                                        <div class="row align-items-center">
                                            @if(!empty($template->gallery))
                                                @foreach($template->gallery as $gallery)
                                                @if($loop->iteration > 4)
                                                <div class="col-12 col-sm-6 col-lg-3 OL-EDITABLE" data-tab="#_gal_sec_{{$loop->iteration}}">
                                                <div class="columns">
                                                    <div class="product-card">
                                                        <div tag-name="{{ $gallery->tag_1 }}" class="img-thumb" id="tem_img{{ $loop->iteration }}" data-default-img="{{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}}" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$gallery->image_path)}});"></div>
                                                    </div>
                                                    <div class="position-relative">
                                                        <div class="title-bar">
                                                            <p class="mb-0" id="tem_image_title_{{ $loop->iteration }}" style="font-weight: bold;">{{ $gallery->title }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="priceAmount">
                                                        <p class="py-2">
                                                            <span class="price1">&#8377;</span><span class="price1 sale_price_{{ $loop->iteration }}">{{ $gallery->sale_price }}</span>
                                                            <span class="price2 price_{{ $loop->iteration }}">{{ $gallery->price }}</span>
                                                        </p>
                                                    </div>
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
                        <div class="pb-4">
                            <div class="container-fluid">
                                <div class="temp-container">
                                    <div class="row align-items-center">
                                       
                                        <div class="col-sm-12">
                                            <div class="OL-EDITABLE" data-tab="#_social_links_">
                                                <ul class="social-icons text-center mb-4">
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

                                         <div class="col-sm-12">
            
                                           {{-- Business Name & Tagline  --}}
                                            <div class="busines-name text-center">
                                            @if($only_view == 1)
                                                <h1 class="h5 mb-1">Grocery</h1>
                                                <p class="mb-sm-0 small">One Stop Platform</p>
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