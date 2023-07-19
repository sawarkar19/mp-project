@extends('layouts.admin')
@section('title', 'Admin: Edit Subscriber')
@section('head')
<style type="text/css">
    .is_required {
        color: red;
    }
</style>
    @include('layouts.partials.headersection', ['title' => 'Edit Subscriber'])
@endsection
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Edit Subscriber') }}</h4>

                </div>
                <div class="card-body">

                    <form class="basicform" action="{{ route('admin.customer.update', $info->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Subscriber Name') }}
                                <span class="is_required">*</span></label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control char-spcs-validation" required=""
                                    name="name" value="{{ $info->name }}" maxlength="40">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Business Name') }}
                                <span class="is_required">*</span></label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control char-spcs-validation" required=""
                                    name="business_name" value="{{ $details->business_name }}" maxlength="40">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Subscriber Mobile') }}
                                <span class="is_required">*</span></label>
                            <div class="col-sm-12 col-md-7">
                                <input type="tel" class="form-control number-validation" required="" maxlength="10"
                                    name="mobile" value="{{ $info->mobile }}">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Subscriber Email') }}
                                <span class="is_required">*</span></label>
                            <div class="col-sm-12 col-md-7">
                                <input type="email" class="form-control check-email-input" required="" readonly name="email"
                                    value="{{ $info->email }}">
                            </div>
                        </div>

                        {{-- <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" >{{ __('Password') }}</label>
          <div class="col-sm-12 col-md-7">
            <input type="password" class="form-control" name="password">
          </div>
        </div> --}}

                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Status') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control" name="status">
                                    <option value="1" @if ($info->status == 1) selected="" @endif>
                                        {{ __('Active') }}</option>
                                    {{--  <option value="0" @if ($info->status == 0) selected="" @endif>
                                        {{ __('Trash') }}</option>  --}}
                                    <option value="2" @if ($info->status == 2) selected="" @endif>
                                        {{ __('Suspended') }}</option>
                                    {{-- <option value="3" @if ($info->status == 3) selected=""  @endif>{{ __('Pending') }}</option> --}}
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Is Partner') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control" name="is_enterprise">
                                    <option value="1" @if ($info->is_enterprise == 1) selected="" @endif>
                                        {{ __('Yes') }}</option>
                                    <option value="0" @if ($info->is_enterprise == 0) selected="" @endif>
                                        {{ __('No') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button class="btn btn-primary basicbtn" type="submit">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('end_body')
    {{-- <script src="{{ asset('assets/js/form.js') }}"></script> --}}
    <script src="{{ asset('assets/js/input-validation.js') }}"></script>

    <script>
        $(".basicform").on('submit', function(e) {
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
