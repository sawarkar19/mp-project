<section id="Template" class="">
    <div id="builder_canvas">
        <main id="wrapper" class="">
            <section class="template-container OL-EDITABLE OL-ACTIVE" data-tab="#_main_tab_">
                <div class="template-main" style="background-image: url({{ asset('assets/templates/'.$id.'/'.$template->bg_image)}});background-color: {{ $template->bg_color }};" data-default-img="{{ asset('assets/templates/'.$id.'/'.$template->bg_image)}}" id="tem_back">
                    <div class="inner-wrapper">

                    <div class="container-fluid ">
                        <div class="text-center py-5">

                            {{-- Logo  --}}
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

                            {{-- Business Name & Tagline  --}}
                            <div class="busines-name mb-4">
                                @if($only_view == 1)
                                    <h1 class="h4 mb-1">Automotive</h1>
                                    <p class="mb-0 small text-uppercase">We're Truly Auto Motivate</p>
                                @else
                                    
                                    @if($business->website != null)
                                    <h1 class="h4 mb-1"><a href="{{$business->website}}" target="_blank" class="website_anchr">{{ $business->business_name }}</a></h1>
                                    @else
                                    <h1 class="h4 mb-1">{{ $business->business_name }}</h1>
                                    @endif

                                    <p class="mb-0 small text-uppercase">{{ $business->tag_line }}</p>
                                @endif
                            </div>

                            {{-- Main Heading & Content  --}}
                            <div class="tmplt-container py-4">
                                <div>
                                    <h2 class="h1 mb-3 OL-EDITABLE" data-tab="#_text_1_" id="text_input_1">{{ $template->content[0]->content }}</h2>
                                    <p class="OL-EDITABLE" data-tab="#_text_2_" id="text_input_2">{{ $template->content[1]->content }}</p>
                                </div>
                            </div>
                            {{-- call to action button --}}
                            @if($template->button[0]->is_hidden != 1)
                                <div class="mb-5 text-center call-to-action">
                                    <div class="d-inline-block">
                                        @if($template->button[0]->link == '#')
                                            <a href="{{ $template->button[0]->link }}" id="action_btn_1" class="btn btn-call-act">{{ $template->button[0]->name }}</a>
                                        @else
                                            <a href="{{ $template->button[0]->link }}" id="action_btn_1" class="btn btn-call-act" target="_blank">{{ $template->button[0]->name }}</a>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="tmplt-container">

                                <div class="cn-icons-top mb-5">
                                    {{-- CONTACT OPTION  --}}
                                    <ul class="contact-section d-inline-block OL-EDITABLE" data-tab="#_contact_section_">
                                        @if($only_view == 1)
                                           <li><a href="" ><i class="bi bi-telephone pr-1"></i> Call</a></li>
                                           <li><a href=""><i class="bi bi-whatsapp pr-1"></i> Whatsapp</a></li>
                                           <li><a href="#" data-toggle="modal" data-target="#LocationModal"><i class="bi bi-geo-alt pr-1"></i> Location</a></li>
                                           <li><a href=""><i class="bi bi-globe2 pr-1"></i> Web</a></li>
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

                                <div class="mb-5">
                                    {{-- Main Video  --}}
                                    <div class="main_video OL-EDITABLE" data-tab="#_main_video_">
                                        <div class="video" id="vplayer">
                                            <iframe
                                                frameborder="0"
                                                allowfullscreen="1"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" title="YouTube video player"
                                                src="https://www.youtube.com/embed/{{ $video_id }}?autoplay=0&mute=0&rel=0"
                                                id="videoFrame" class="br"
                                            >
                                            </iframe>
                                        </div>
                                    </div>
                                    <script>
                                        $(document).ready(function(){
                                            var player_div = $("#vplayer");
                                            var $width = player_div.width();
                                            var $height = ($width / 100) * 58;
                                            player_div.children("iframe").css("width", "100%").css("height", $height);
                                        });
                                    </script>
                                </div>

                                {{-- Footer --}}
                                <div class="footer mt-2">
                                    <div class="row align-items-center">
                                        {{-- Social Media Links --}}
                                        <div class="col-sm-12 mb-3">

                                            @php
                                                $facebook_link = $business->facebook_link ?? '';
                                                $instagram_link = $business->instagram_link ?? '';
                                                $twitter_link = $business->twitter_link ?? '';
                                                $linkedin_link = $business->linkedin_link ?? '';
                                                $youtube_link = $business->youtube_link ?? '';
                                                $call_number = $business->call_number ?? '';
                                                $google_review_placeid = $business->google_review_placeid ?? '';
                                            @endphp
                                            
                                            <div class="OL-EDITABLE" data-tab="#_social_links_">
                                                <ul class="social-icons text-center mb-0">
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
                                        {{-- Contact Number  --}}
                                        <div class="col-sm-12 tel-number text-center">
                                            @if($only_view != 1)
                                                <a href="tel: {{ $call_number }}" class="link_domain h5" id="website_link"><i class="bi bi-phone"></i> {{ $call_number }}</a>
                                            @else
                                                <a href="" class="link_domain text-dark h5" id="website_link"><i class="bi bi-phone"></i> 9123456789</a>
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