@extends('layouts.admin')
@section('title', 'Admin: Create Plan')
@section('head')
    <style type="text/css">
        .is_required {
            color: red;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-colorpicker.min.css') }}">
    @include('layouts.partials.headersection', ['title' => 'Edit Plan'])
@endsection
@section('content')

    <div class="row">
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('admin.plan.update', $info->id) }}" class="basicform_with_reset">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <input type="hidden" name="slug">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Plan Name') }} <span class="is_required">*</span></label>
                                    <input type="text" name="name" class="form-control char-spcs-validation"
                                        maxlength="36" required value="{{ $info->name }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Discount') }} <span class="is_required">*</span></label>
                                    <input type="tel" step="any" name="discount"
                                        class="form-control number-validation" maxlength="3" required
                                        value="{{ $info->discount }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Months') }} <span class="is_required">*</span></label>
                                    <input type="tel" name="months" class="form-control number-validation"
                                        maxlength="8" required value="{{ $info->months }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Days') }} <span class="is_required">*</span></label>
                                    <input type="tel" name="days" class="form-control number-validation"
                                        maxlength="8" required value="{{ $info->days }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Ordering') }} <span class="is_required">*</span></label>
                                    <input type="tel" name="ordering" class="form-control number-validation"
                                        maxlength="8" required value="{{ $info->ordering }}">
                                </div>


                                <div class="form-group">
                                    <button class="btn btn-primary basicbtn" type="submit">{{ __('Update') }}</button>
                                </div>
                            </div>
                            <div class="col-sm-4">

                                {{-- <div class="form-group">
                                    <label>{{ __('Duration') }} <span class="is_required">*</span></label>
                                    <select class="form-control" name="days">
                                        <option value="365"@if ($info->days == 365) selected="" @endif>
                                            {{ __('Yearly') }}</option>
                                        <option value="30"@if ($info->days == 30) selected="" @endif>
                                            {{ __('Monthly') }}</option>

                                        <option value="7"@if ($info->days == 7) selected="" @endif>
                                            {{ __('Weekly') }}</option>
                                    </select>
                                </div> --}}


                                <div class="form-group">
                                    <label>{{ __('Is Default ?') }} <span class="is_required">*</span></label>
                                    <select class="form-control" name="is_default">
                                        <option value="0" @if ($info->is_default == 0) selected @endif>
                                            {{ __('No') }}</option>
                                        <option value="1" @if ($info->is_default == 1) selected @endif>
                                            {{ __('Yes') }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Status') }} <span class="is_required">*</span></label>
                                    <select class="form-control" name="status">
                                        <option value="1" @if ($info->status == 1) selected="" @endif>
                                            {{ __('Enable') }}</option>
                                        <option value="0" @if ($info->status == 0) selected="" @endif>
                                            {{ __('Disable') }}</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('end_body')
    <script src="{{ asset('assets/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/input-validation.js') }}"></script>
    <script>
        $(".basicform_with_reset").on('submit', function(e) {
            e.preventDefault();

            if ($('input[name="discount"]').val() < 0 || $('input[name="discount"]').val() > 100) {
                Sweet('error', 'The discount must be between 0 and 100 !');
                return false;

            }
            //console.log('hello');//
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
                        window.location.href = response.url;
                    } else {
                        Sweet('error', response.message);
                    }

                    $('.basicbtn').html(basicbtnhtml);
                    //location.reload();
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
