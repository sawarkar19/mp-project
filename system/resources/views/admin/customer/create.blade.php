@extends('layouts.admin')
@section('title', 'Admin: Create Subscriber')
@section('head')
    <style type="text/css">
        .is_required {
            color: red;
        }
    </style>
    @include('layouts.partials.headersection', ['title' => 'Create Subscriber'])
@endsection
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form class="basicform_with_reload" action="{{ route('admin.customer.store') }}" method="post">
                        @csrf

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Subscriber Name') }}
                                <span class="is_required">*</span></label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control char-spcs-validation" required=""
                                    name="name" maxlength="40">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Business Name') }}
                                <span class="is_required">*</span></label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control char-spcs-validation" required=""
                                    name="business_name" maxlength="40">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Subscriber Mobile') }}
                                <span class="is_required">*</span></label>
                            <div class="col-sm-12 col-md-7">
                                <input type="tel" class="form-control number-validation" maxlength="10" required=""
                                    name="mobile">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label
                                class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Subscriber Email') }}
                                <span class="is_required">*</span></label>
                            <div class="col-sm-12 col-md-7">
                                <input type="email" class="form-control check-email-input" required="" name="email">
                            </div>
                        </div>

                        {{-- <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" >{{ __('Password') }}</label>
          <div class="col-sm-12 col-md-7">
            <input type="password" class="form-control" required="" name="password">
          </div>
        </div> --}}

                        {{-- <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" >{{ __('Transaction Method') }}</label>
          <div class="col-sm-12 col-md-7">
            <select class="form-control" name="transaction_method">
              @foreach (App\Models\Category::where('type', 'payment_gateway')->get() as $row)
              <option value="{{ $row->id }}">{{ $row->name }}</option>
              @endforeach
            </select>
          </div>
        </div> --}}

                        {{-- <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" >{{ __('Transaction Id') }}</label>
          <div class="col-sm-12 col-md-7">
            <input type="text" class="form-control" required="" name="transaction_id">
          </div>
        </div> --}}

                        {{-- <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" >{{ __('Plan') }}</label>
          <div class="col-sm-12 col-md-7">
            <select class="form-control" name="plan">
               @foreach (App\Models\Plan::where('status', 1)->get() as $row)
              <option value="{{ $row->id }}">{{ $row->name }}</option>
              @endforeach
            </select>
          </div>
        </div> --}}

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button class="btn btn-primary basicbtn" type="submit">{{ __('Save') }}</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('end_body')
    {{--  <script src="{{ asset('assets/js/form.js') }}"></script>  --}}
    <script src="{{ asset('assets/js/input-validation.js') }}"></script>

    {{-- add code refresh page dinesh start --}}

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


    {{-- add code refresh page dinesh end --}}
@endsection
