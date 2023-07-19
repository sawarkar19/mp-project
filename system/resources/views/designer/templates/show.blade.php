@extends('layouts.designer')
@section('title', 'Designer: Templates')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'Template Details'])
@endsection
@section('content')

    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Templates Name :') }}</div>
                                    <div class="profile-widget-item-value">{{ $templates->name }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Templates Type') }}</div>
                                    <div class="profile-widget-item-value">{{ $templates->template_type }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Business Type') }}</div>
                                    <div class="profile-widget-item-value">{{ $templates->business_type }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Status') }}</div>
                                    <div class="profile-widget-item-value">
                                        @if ($templates->status == 1)
                                            <span class="badge badge-success">{{ __('Active') }}</span>
                                        @elseif($templates->status == 0)
                                            <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="profile-widget-header">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Select Image :') }}</div>
                                    <div class="profile-widget-item-value"><img
                                            src="{{ asset('assets/' . $templates->thumbnail) }}" style="max-height: 100px"
                                            class="img-fluid border" id="main_img_preview" alt="">
                                    </div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Background Image :') }}</div>
                                    <div class="profile-widget-item-value">
                                        <img src="{{ asset('assets/templates/' . $templates->id . '/' . $templates->bg_image) }}"
                                            style="max-height: 100px" class="img-fluid border" id="bi_preview"
                                            alt="">
                                    </div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Background Color:') }}</div>
                                    <div class="profile-widget-item-value">{{ $templates->bg_color }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Default Color:') }}</div>
                                    <div class="profile-widget-item-value">{{ $templates->default_color }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="profile-widget-header">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Business Name Color:') }}</div>
                                    <div class="profile-widget-item-value">{{ $templates->business_name_color }}</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Tag Line Color:') }}</div>
                                    <div class="profile-widget-item-value">{{ $templates->tag_line_color }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Hero Image:') }}</div>
                                    <div class="profile-widget-item-value"><img
                                            src="{{ asset('assets/templates/' . $templates->id . '/' . $templates->hero_image) }}"
                                            style="max-height: 100px" class="img-fluid border" id="main_img_preview"
                                            alt=""></div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Hero Title:') }}</div>
                                    <div class="profile-widget-item-value">{{ $templates->hero_title }}</div>
                                </div>

                            </div>
                        </div>

                        <div class="profile-widget-header">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Hero Title Color:') }}</div>
                                    <div class="profile-widget-item-value">{{ $templates->hero_title_color }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Hero Text Content:') }}</div>
                                    <div class="profile-widget-item-value">{{ $templates->hero_text }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Hero Text Color:') }}</div>
                                    <div class="profile-widget-item-value">{{ $templates->hero_text_color }}</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Video Url:') }}</div>
                                    <div class="profile-widget-item-value">{{ $templates->video_url }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="profile-widget-header">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Video Autoplay:') }}</div>
                                    <div class="profile-widget-item-value">{{ $templates->video_autoplay }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Heading Content:') }}</div>
                                    <div class="profile-widget-item-value">{{ $templates->extra_heading_1 }}</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Heading Color:') }}</div>
                                    <div class="profile-widget-item-value">{{ $templates->extra_heading_1_color }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Text Content:') }}</div>
                                    <div class="profile-widget-item-value">{{ $templates->extra_text_1 }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="profile-widget-header">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Contact Icons:') }}</div>
                                    <div class="profile-widget-item-value">{{ $templates->contact_icons }}</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Text Content Color:') }}</div>
                                    <div class="profile-widget-item-value">{{ $templates->extra_text_1_color }}</div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                {{-- add content code start dinesh --}}
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Content Details') }}</h4>
                        </div>
                        <div class="col-sm-4 text-left">
                            <a href="{{ route('designer.contents.create', ['id' => $templates->id]) }}"
                                class="btn btn-primary">{{ __('Add Content') }}</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                @if (count($contents) >= 1)
                                    <table class="table table-striped table-hover text-center table-borderless">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Sr.No') }}</th>
                                                <th>{{ __('Content') }}</th>
                                                <th>{{ __('Content Color') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($contents as $index => $cont)
                                                <tr>
                                                    <td>{{ $index + $contents->firstItem() }}</td>
                                                    <td>{{ $cont->content }}</td>
                                                    <td>{{ $cont->content_color }}</td>
                                                    <td>
                                                        <a href="{{ route('designer.contents.edit', $cont->id) }}"
                                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>
                                                        </a>

                                                        <a class="btn btn-sm btn-icon icon-left btn-danger delete-item1"
                                                            id="{{ $cont->id }}" href="#"><i
                                                                class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                @else
                                    <h3 style="padding:50px;text-align:center;clear: both;">Sorry, No Record Found!</h3>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        {{ $contents->appends(array_except(Request::query(), 'no_of_content'))->links() }}
                    </div>

                </div>
                {{-- add content code end dinesh --}}

                {{-- add gallery code start dinesh --}}
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Gallery Details') }}</h4>
                        </div>
                        <div class="col-sm-4 text-left">
                            <a href="{{ route('designer.galleryimages.create', ['id' => $templates->id]) }}"
                                class="btn btn-primary">{{ __('Add Gallery') }}</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                @if (count($gallery_imgs) >= 1)

                                    <table class="table table-striped table-hover text-center table-borderless">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Sr.No') }}</th>
                                                <th>{{ __('Title Name') }}</th>
                                                <th>{{ __('Image') }}</th>
                                                {{-- <th>{{ __('Tag 1') }}</th> --}}
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($gallery_imgs as $index => $gal)
                                                <tr>
                                                    <td>{{ $index + $gallery_imgs->firstItem() }}</td>
                                                    <td>{{ $gal->title }}</td>
                                                    <td>
                                                        <img src="{{ asset('assets/templates/' . $gal->template_id . '/' . $gal->image_path) }}"
                                                            style="max-height: 100px" class="img-fluid border"
                                                            id="main_img_preview" alt="">
                                                    </td>
                                                    {{-- <td>{{ $gal->tag_1 }}</td> --}}
                                                    <td>
                                                        <a href="{{ route('designer.galleryimages.edit', $gal->id) }}"
                                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>
                                                        </a>

                                                        <a class="btn btn-sm btn-icon icon-left btn-danger delete-item2"
                                                            id="{{ $gal->id }}" href="#"><i
                                                                class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                @else
                                    <h3 style="padding:50px;text-align:center;clear: both;">Sorry, No Record Found!</h3>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        {{ $gallery_imgs->appends(array_except(Request::query(), 'page'))->links() }}
                    </div>

                </div>
                {{-- add gallery code end dinesh --}}

                {{-- add buttons code start dinesh --}}
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Template Buttons Details') }}</h4>
                        </div>
                        <div class="col-sm-4 text-left">
                            <a href="{{ route('designer.templatebuttons.create', ['id' => $templates->id]) }}"
                                class="btn btn-primary">{{ __('Add Template Button') }}</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                @if (count($templateButtons) >= 1)

                                    <table class="table table-striped table-hover text-center table-borderless">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Sr.No') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Link') }}</th>
                                                <th>{{ __('Button Text Color') }}</th>
                                                <th>{{ __('Button Style Type') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($templateButtons as $index => $button)
                                                <tr>
                                                    <td>{{ $index + $templateButtons->firstItem() }}</td>
                                                    <td>{{ $button->name }}</td>
                                                    <td>
                                                        <a href="{{ $button->link }}"
                                                            target="_blank">{{ $button->link }}</a>
                                                    </td>
                                                    <td>{{ $button->btn_text_color }}</td>
                                                    <td>
                                                        @if ($button->btn_style_type == 'Background')
                                                            <span
                                                                class="badge badge-success">{{ __('Background') }}</span>
                                                        @elseif($button->btn_style_type == 'Border')
                                                            <span class="badge badge-danger">{{ __('Border') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('designer.templatebuttons.edit', $button->id) }}"
                                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>
                                                        </a>

                                                        <a class="btn btn-sm btn-icon icon-left btn-danger delete-item"
                                                            id="{{ $button->id }}" href="#"><i
                                                                class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                @else
                                    <h3 style="padding:50px;text-align:center;clear: both;">Sorry, No Record Found!</h3>
                                @endif
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $templateButtons->appends(array_except(Request::query(), 'per_page'))->links() }}
                        </div>
                    </div>

                </div>
                {{-- add buttons code end dinesh --}}
            </div>
        </div>

    </section>
@endsection
@section('end_body')
    <script src="{{ asset('assets/js/form.js') }}"></script>
    <script>
        //content start
        $(document).on('click', '.delete-item1', function(e) {
            e.preventDefault();
            var template_content_id = $(this).attr('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to remove this content?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete !'
            }).then((result) => {
                if (result.value == true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: '{{ url('designer/content/destroy-page') }}' + '/' + template_content_id,
                        data: {
                            template_content_id: template_content_id
                        },
                        dataType: 'json',
                        success: function(response) {
                            Sweet('success', response.message);
                            $('#template_content_id_' + template_content_id).css('display',
                                'none');
                            setTimeout(function(){
                                location.reload();
                            },2000);
                        },
                        error: function(xhr, status, error) {
                            Sweet('error', 'Content not removed');
                        }

                    })
                }
            })

        });
        //content end

        //gallery image start
        $(document).on('click', '.delete-item2', function(e) {
            e.preventDefault();
            var gallery_image_id = $(this).attr('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to remove this gallery image?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete !'
            }).then((result) => {
                if (result.value == true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: '{{ url('designer/galleryimage/destroy-page') }}' + '/' +
                            gallery_image_id,
                        data: {
                            gallery_image_id: gallery_image_id
                        },
                        dataType: 'json',
                        success: function(response) {
                            Sweet('success', response.message);
                            $('#gallery_image_id_' + gallery_image_id).css('display', 'none');
                            setTimeout(function(){
                                location.reload();
                            },2000);
                        },
                        error: function(xhr, status, error) {
                            Sweet('error', 'Gallery image not removed');
                        }

                    })
                }
            })

        });
        //gallery image end

        //template button start
        $(document).on('click', '.delete-item', function(e) {
            e.preventDefault();
            var template_button_id = $(this).attr('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to remove this template button?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete !'
            }).then((result) => {
                if (result.value == true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: '{{ url('designer/templatebutton/destroy-page') }}' + '/' +
                            template_button_id,
                        data: {
                            template_button_id: template_button_id
                        },
                        dataType: 'json',
                        success: function(response) {
                            Sweet('success', response.message);
                            $('#template_button_id_' + template_button_id).css('display',
                                'none');
                            setTimeout(function(){
                                location.reload();
                            },2000);
                        },
                        error: function(xhr, status, error) {
                            Sweet('error', 'Template button not removed');
                        }

                    })
                }
            })

        });
        //template button end
    </script>
@endsection
