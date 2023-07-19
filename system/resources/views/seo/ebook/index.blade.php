@extends('layouts.seo')
@section('title', 'seo: Ebook List')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'Ebooks'])

    <style>
        .custom-switch-input:checked~.custom-switch-indicator {
            background: #31ce55;
        }
    </style>
@endsection
@section('content')

    <div class="card">
        <div class="card-body">
            <div class="row mb-30">
                <div class="col-lg-6">
                    <h4>{{ __('Ebook List') }}</h4>
                </div>
                <div class="col-lg-6">

                </div>
            </div>
            <br>
            <div class="card-action-filter">
                <form method="post" class="basicform_with_reload" action="{{ route('seo.ebooks.destroys') }}">
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
                                <a href="{{ route('seo.ebook.create') }}"
                                    class="btn btn-primary float-right">{{ __('Add New Ebook') }}</a>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="table-responsive custom-table">
                @if (count($ebooks) >= 1)
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
                                <th class="am-title">{{ __('Url') }}</th>
                                <th class="am-date">{{ __('Last Update') }}</th>
                                <th class="am-date">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ebooks as $ebook)
                                <tr id="ebook_id_{{ $ebook->id }}">
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="ids[]" class="custom-control-input"
                                                id="customCheck{{ $ebook->id }}" value="{{ $ebook->id }}">
                                            <label class="custom-control-label"
                                                for="customCheck{{ $ebook->id }}"></label>
                                        </div>
                                    </th>
                                    <td>
                                        {{ $ebook->title }}
                                    </td>
                                    <input type="text" class="offscreen" id="myUrl{{ $ebook->id }}"
                                        value="{{ url('/ebooks', $ebook->slug) }}">

                                    <td><a href="{{ url('/ebooks', $ebook->slug) }}"
                                            target="_blank">{{ url('/ebooks', $ebook->slug) }}</td>

                                    <td>{{ __('Last Modified') }}
                                        <div class="date">
                                            {{ $ebook->created_at->diffForHumans() }}
                                        </div>
                                    </td>

                                    <td>

                                        <a class="btn btn-icon icon-left btn-primary"
                                            href="{{ route('seo.ebook.edit', $ebook->id) }}"><i
                                                class="fa fa-edit"></i></a>

                                        @if (Auth::user()->id == $ebook->user_id)
                                            <a class="btn btn-icon icon-left btn-danger delete-item"
                                                id="{{ $ebook->id }}" href="#"><i class="fa fa-trash"></i></a>
                                            <label class="custom-switch pl-0 btn">
                                                <input type="checkbox" id="{{ $ebook->id }}"
                                                    class="custom-switch-input change-item-status"
                                                    @if ($ebook->status == 1) checked @endif>
                                                <span class="custom-switch-indicator" style="margin-left: 10px;"></span>
                                            </label>
                                        @endif
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
                {{ $ebooks->links('vendor.pagination.bootstrap-4') }}

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
            var ebook_id = $(this).attr('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to remove this ebook?",
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
                        url: '{{ url('admin/ebooks/destroy-ebook') }}' + '/' + ebook_id,
                        data: {
                            ebook_id: ebook_id
                        },
                        dataType: 'json',
                        success: function(response) {
                            Sweet('success', response.message);
                            $('#ebook_id_' + ebook_id).css('display', 'none');
                            setTimeout(function(){
                                location.reload();
                            },2000);
                        },
                        error: function(xhr, status, error) {
                            Sweet('error', 'Ebook not removed');
                        }

                    })
                }
            })

        });

        $(document).on('change', '.change-item-status', function(e) {
            e.preventDefault();

            var ebook_id = $(this).attr('id');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '{{ url('admin/ebooks/change-ebook-status') }}' + '/' + ebook_id,
                data: {
                    ebook_id: ebook_id
                },
                dataType: 'json',
                success: function(response) {
                    Sweet('success', response.message);
                    $('#' + response.hide).hide();
                    $('#' + response.show).show();
                },
                error: function(xhr, status, error) {
                    Sweet('error', 'Page status not changed');
                }

            })
        });
    </script>
@endsection
