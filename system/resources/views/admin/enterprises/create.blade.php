@extends('layouts.admin')
@section('title', 'Admin: Enterprises')
@section('head')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />

    @include('layouts.partials.headersection', ['title' => 'Add New Enterprise'])
    <style>
        #error {
            color: #ff0000;
        }

        #success {
            color: green;
        }

        .is_required {
            color: red;
        }
    </style>
@endsection
@section('content')

    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <form id="blogform" method="post" action="{{ route('admin.enterprises.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="custom-form pt-20">

                            <div class="form-group">
                                <label for="name">Name<span class="is_required">*</span></label>
                                <input type="text" placeholder="Name" name="name"
                                    class="form-control char-and-spcs-validation" id="name">
                            </div>

                            <div class="form-group">
                                <label for="name">Email<span class="is_required">*</span></label>
                                <input type="text" placeholder="Email" name="email"
                                    class="form-control check-email-input" id="email">
                            </div>

                            <div class="form-group">
                                <label for="name">Mobile<span class="is_required">*</span></label>
                                <input type="text" placeholder="Mobile" name="mobile"
                                    class="form-control number-validation indian-mobile-series" id="mobile"
                                    maxlength="10">
                            </div>

                            <div class="form-group">
                                <label for="name">WhatsApp message per month limit</label>
                                <input type="text" placeholder="WhatsApp message per month limit"
                                    name="wa_per_month_limit" class="form-control number-validation" id="wa_per_month_limit"
                                    maxlength="10">
                            </div>

                            <div class="form-group">
                                <label for="name">Discount</label>
                                <input type="text" placeholder="Discount" name="discount"
                                    class="form-control number-validation" id="discount" maxlength="10">
                            </div>

                            <div class="form-group">
                                <label for="name">Commission</label>
                                <input type="text" placeholder="Commission" name="commission"
                                    class="form-control number-validation" id="commission" maxlength="10">
                            </div>

                            <div class="form-group">
                                <label for="name">Onetime Signup</label>
                                <input type="text" placeholder="Onetime Signup" name="onetime_signup"
                                    class="form-control number-validation" id="onetime_signup" maxlength="10">
                            </div>

                            <div class="form-group">
                                <label for="name">Type</label>
                                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="type">
                                    <option value="Customer">{{ __('Customer') }}</option>
                                    <option value="Collaboration">{{ __('Collaboration') }}</option>
                                    <option value="Channel Partner">{{ __('Channel Partner') }}</option>
                                    <option value="Influencer">{{ __('Influencer') }}</option>
                                </select>
                            </div>

                            <div class="btn-publish text-center">
                                <button for="submit" type="submit" class="btn btn-primary btn-lg"><i
                                        class="fa fa-save"></i>
                                    {{ __('Save') }}
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('end_body')
    @include('admin.enterprises.customjs')
    <script src="{{ asset('assets/js/input-validation.js') }}"></script>
@endsection
