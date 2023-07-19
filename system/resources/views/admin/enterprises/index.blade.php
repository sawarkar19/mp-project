@extends('layouts.admin')
@section('title', 'Admin: Enterprises List')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'Enterprises List'])

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
                </div>
                <div class="col-lg-6">

                </div>
            </div>
            <br>
            <div class="card-action-filter">
                <form method="post" class="basicform_with_reload" action="{{ route('admin.enterprises.destroys') }}">
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
                                <a href="{{ route('admin.enterprises.create') }}"
                                    class="btn btn-primary float-right">{{ __('Add New Enterprise') }}</a>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="table-responsive custom-table">
                @if (count($enterprises) >= 1)

                    <table class="table">
                        <thead>
                            <tr>
                                <th class="am-select">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input checkAll" id="selectAll">
                                        <label class="custom-control-label checkAll" for="selectAll"></label>
                                    </div>
                                </th>
                                <th class="am-title">{{ __('Name') }}</th>
                                <th class="am-title">{{ __('Email') }}</th>
                                <th class="am-title">{{ __('Mobile') }}</th>
                                <th class="am-title">{{ __('Discount') }}</th>
                                <th class="am-title">{{ __('Commission') }}</th>
                                <th class="am-title">{{ __('Wa per month limit') }}</th>
                                <th class="am-date" style="min-width: 200px;">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($enterprises as $enterprise)
                                <tr id="blog_id_{{ $enterprise->id }}">
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="ids[]" class="custom-control-input"
                                                id="customCheck{{ $enterprise->id }}" value="{{ $enterprise->id }}">
                                            <label class="custom-control-label"
                                                for="customCheck{{ $enterprise->id }}"></label>
                                        </div>
                                    </th>
                                    <td>
                                        {{ $enterprise->name }}
                                    </td>
                                    <td>
                                        {{ $enterprise->email }}
                                    </td>
                                    <td>
                                        {{ $enterprise->mobile }}
                                    </td>

                                    <td>
                                        {{ $enterprise->discount." %" }}
                                    </td>
                                    <td>
                                        {{ $enterprise->commission." ₹" }}
                                    </td>

                                    <td>
                                        {{ $enterprise->wa_per_month_limit }}
                                    </td>

                                    <td>
                                        <a class="btn btn-icon icon-left btn-primary"
                                            href="{{ route('admin.enterprises.edit', $enterprise->id) }}"><i
                                                class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.enterprises.show', $enterprise->id) }}"
                                            class="btn btn-success text-center"><i class="far fa-eye"></i></a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                        </form>

                    </table>
                @else
                    <div class="card-body text-center">
                        <h3>{{ Config::get('constants.no_record_found') }}</h3>
                    </div>
                @endif
                {{ $enterprises->links('vendor.pagination.bootstrap-4') }}

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
                    if (response.status == true) {
                        Sweet('success', response.message);
                    } else {
                        Sweet('error', response.message);
                    }

                    $('.basicbtn').html(basicbtnhtml);
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
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
    </script>
@endsection
