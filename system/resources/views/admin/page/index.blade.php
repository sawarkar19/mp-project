@extends('layouts.admin')
@section('title', 'Admin: Page List')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'Page Settings'])

    <style>
        .custom-switch-input:checked~.custom-switch-indicator {
            background: #31ce55;
        }
    </style>
@endsection
@section('content')

    <div class="card">
        <div class="card-body">
            <div class="card-action-filter">
                <form method="post" class="basicform_with_reload" action="{{ route('admin.pages.destroys') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="d-flex">
                                <div class="single-filter">
                                    <div class="form-group">
                                        <select class="form-control selectric" name="status">
                                            <option disabled="" selected="">Select Action</option>
                                            <option value="delete">{{ __('Delete Permanently') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="single-filter">
                                    <button type="submit" class="btn btn-primary btn-lg ml-2">{{ __('Apply') }}</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="add-new-btn">
                                <a href="{{ route('admin.page.create') }}"
                                    class="btn btn-primary float-right">{{ __('Add New Page') }}</a>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="table-responsive custom-table">
                @if (count($pages) >= 1)
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="am-select">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input checkAll" id="selectAll">
                                        <label class="custom-control-label checkAll" for="selectAll"></label>
                                    </div>
                                </th>
                                <th class="am-title">{{ __('Title') }}</th>
                                <th class="am-title">{{ __('URL') }}</th>
                                <th class="am-date">{{ __('Status') }}</th>
                                <th class="am-date">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pages as $page)
                                <tr id="page_id_{{ $page->id }}">
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="ids[]" class="custom-control-input"
                                                id="customCheck{{ $page->id }}" value="{{ $page->id }}">
                                            <label class="custom-control-label"
                                                for="customCheck{{ $page->id }}"></label>
                                        </div>
                                    </th>
                                    <td>
                                        {{ $page->title }}
                                    </td>
                                    <td>
                                        <a href="{{ $page->url }}" target="_blank">{{ $page->url }}</a>
                                    </td>
                                    <td>

                                        <span class="badge badge-success" id="active-badge"
                                            @if ($page->status == 0) style="display: none;" @endif>{{ __('Active') }}</span>

                                        <span class="badge badge-danger" id="deactive-badge"
                                            @if ($page->status == 1) style="display: none;" @endif>{{ __('Deactive') }}</span>

                                    </td>
                                    <td>
                                        <a class="btn btn-icon icon-left btn-primary"
                                            href="{{ route('admin.page.edit', $page->id) }}"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-icon icon-left btn-danger delete-item" id="{{ $page->id }}"
                                            href="#"><i class="fa fa-trash"></i></a>
                                        <label class="custom-switch pl-0 btn">
                                            <input type="checkbox" id="{{ $page->id }}"
                                                class="custom-switch-input change-item-status"
                                                @if ($page->status == 1) checked @endif>
                                            <span class="custom-switch-indicator" style="margin-left: 10px;"></span>
                                        </label>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        </form>
                    </table>
                @else
                    <div class="card-body">
                        <h3>{{ Config::get('constants.no_record_found') }}</h3>
                    </div>
                @endif

                {{ $pages->links('vendor.pagination.bootstrap-4') }}

            </div>
        </div>
    </div>
@endsection
@section('end_body')
    <script>
        $(".basicform_with_reload").on('submit', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var basicbtnhtml = $('.basicbtn').html();
            $.ajax({
                type: 'POST',
                url: this.action,
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {

                    $('.basicbtn').html("Please Wait....");
                    $('.basicbtn').attr('disabled', '')

                },

                success: function(response) {
                    $('.basicbtn').removeAttr('disabled')
                    Sweet('success', response);
                    $('.basicbtn').html(basicbtnhtml);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    $('.basicbtn').html(basicbtnhtml);
                    $('.basicbtn').removeAttr('disabled')
                    $('.errorarea').show();
                    $.each(xhr.responseJSON.errors, function(key, item) {
                        Sweet('error', item)
                        $("#errors").html("<li class='text-danger'>" + item + "</li>")
                    });
                    errosresponse(xhr, status, error);
                }
            })
        });

        $(document).on('click', '.delete-item', function(e) {
            e.preventDefault();
            var page_id = $(this).attr('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to remove this page?",
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
                        url: '{{ url('admin/pages/destroy-page') }}' + '/' + page_id,
                        data: {
                            page_id: page_id
                        },
                        dataType: 'json',
                        success: function(response) {
                            Sweet('success', response.message);
                            $('#page_id_' + page_id).css('display', 'none');
                            setTimeout(function(){
                                location.reload();
                            },2000);
                        },
                        error: function(xhr, status, error) {
                            Sweet('error', 'Page not removed');
                        }

                    })
                }
            })

        });

        $(document).on('change', '.change-item-status', function(e) {
            e.preventDefault();

            var page_id = $(this).attr('id');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '{{ url('admin/pages/change-page-status') }}' + '/' + page_id,
                data: {
                    page_id: page_id
                },
                dataType: 'json',
                success: function(response) {
                    Sweet('success', response.message);
					console.log(response, "testing done");
					$('#page_id' + response.hide).hide();
					$('#page_id' + response.show).show();
					location.reload();
                },
                error: function(xhr, status, error) {
                    Sweet('error', 'Page status not changed');
                }

            })
        });
    </script>
@endsection
