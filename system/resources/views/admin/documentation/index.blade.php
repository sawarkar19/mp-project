@extends('layouts.admin')
@section('title', 'Admin: Documentation List')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'Documentations'])

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
                    <h4>{{ __('Documentation List') }}</h4>
                </div>
                <div class="col-lg-6">

                </div>
            </div>
            <br>
            <div class="card-action-filter">
                <form method="post" class="basicform_with_reload" action="{{ route('admin.documentations.destroys') }}">
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
                                <a href="{{ route('admin.documentation.create') }}"
                                    class="btn btn-primary float-right">{{ __('Add New documentation') }}</a>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="table-responsive custom-table">
                @if (count($documentations) >= 1)
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
                                {{--  <th class="am-title">{{ __('Url') }}</th>  --}}
                                {{-- <th class="am-date">{{ __('Last Update') }}</th> --}}
                                <th class="am-date" style="min-width: 200px;">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documentations as $documentation)
                                <tr id="documentation_id_{{ $documentation->id }}">
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="ids[]" class="custom-control-input"
                                                id="customCheck{{ $documentation->id }}" value="{{ $documentation->id }}">
                                            <label class="custom-control-label"
                                                for="customCheck{{ $documentation->id }}"></label>
                                        </div>
                                    </th>
                                    <td>
                                        {{ $documentation->title }}
                                    </td>
                                    {{--  <input type="text" class="offscreen" id="myUrl{{ $documentation->id }}" value="{{ url('/documentations',$documentation->slug)  }}">  --}}
                                    {{--  <td><a href="{{ url('/documentations',$documentation->slug)  }}" target="_blank">{{ url('/documentations',$documentation->slug)  }}</a></td>  --}}

                                    {{-- <td>{{ __('Last Modified') }}
								<div class="date">
									{{ $documentation->created_at->diffForHumans() }}
								</div>
							</td> --}}

                                    <td>
                                        <a class="btn btn-icon icon-left btn-primary"
                                            href="{{ route('admin.documentation.edit', $documentation->id) }}"><i
                                                class="fa fa-edit"></i></a>
                                        @if (Auth::user()->id == $documentation->user_id)
                                            <a class="btn btn-icon icon-left btn-danger delete-item"
                                                id="{{ $documentation->id }}" href="#"><i
                                                    class="fa fa-trash"></i></a>
                                            <label class="custom-switch pl-0 btn">
                                                <input type="checkbox" id="{{ $documentation->id }}"
                                                    class="custom-switch-input change-item-status"
                                                    @if ($documentation->status == 1) checked @endif>
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
                {{ $documentations->links('vendor.pagination.bootstrap-4') }}

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
            var documentation_id = $(this).attr('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to remove this documentation?",
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
                        url: '{{ url('admin/documentations/destroy-documentation') }}' + '/' +
                            documentation_id,
                        data: {
                            documentation_id: documentation_id
                        },
                        dataType: 'json',
                        success: function(response) {
                            Sweet('success', response.message);
                            $('#documentation_id_' + documentation_id).css('display', 'none');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        },
                        error: function(xhr, status, error) {
                            Sweet('error', 'Documentation not removed');
                        }

                    })
                }
            })

        });

        $(document).on('change', '.change-item-status', function(e) {
            e.preventDefault();

            var documentation_id = $(this).attr('id');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var url = '{{ route('admin.documentations.changedocumentationStatus', ':id') }}';
            url = url.replace(':id', documentation_id);

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    documentation_id: documentation_id
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
