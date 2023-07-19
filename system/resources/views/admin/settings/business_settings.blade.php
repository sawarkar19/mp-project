@extends('layouts.admin')
@section('title', 'Admin: Business Settings')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'Business Settings'])
@endsection
@section('start_body')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-colorpicker.min.css') }}">
@endsection
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Update Business Settings') }}</h4><br>

                </div>
                <div class="card-body">
                    <form class="basicform" action="{{ route('admin.business_settings.update') }}" method="post">
                        @csrf

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                                {{ __('Guide Page Link') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" name="guide_link" class="form-control"
                                    value="{{ $guide_page->value ?? '' }}" />
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                                {{ __('Invoice Field') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <label class="custom-switch mt-2 pl-0">
                                    <input type="checkbox" id="ask_for_invoice" name="ask_for_invoice"
                                        class="custom-switch-input"
                                        @if (isset($ask_for_invoice->value) && $ask_for_invoice->value == 1) checked="checked" @endif />
                                    <span class="custom-switch-indicator"></span>
                                </label>
                                <small style="display: block;color: red;"><b style="color: black;">Note:</b> Show Invoice
                                    Field On Redeem Form</small>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                                {{ __('Mark Invoice Required') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <label class="custom-switch mt-2 pl-0">
                                    <input type="checkbox" id="invoice_required" name="invoice_required"
                                        class="custom-switch-input"
                                        @if (isset($invoice_required->value) && $invoice_required->value == 1) checked="checked" @endif />
                                    <span class="custom-switch-indicator"></span>
                                </label>
                                <small style="display: block;color: red;"><b style="color: black;">Note:</b> Mark Invoice
                                    Field As Required On Redeem Form</small>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                                {{ __('Ask For Name') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <label class="custom-switch mt-2 pl-0">
                                    <input type="checkbox" id="ask_for_name" name="ask_for_name" class="custom-switch-input"
                                        @if (isset($ask_for_name->value) && $ask_for_name->value == 1) checked="checked" @endif />
                                    <span class="custom-switch-indicator"></span>
                                </label>
                                <small style="display: block;color: red;"><b style="color: black;">Note:</b> Ask for
                                    Customer name while subscribing to Offer.</small>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                                {{ __('Mark Name Required') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <label class="custom-switch mt-2 pl-0">
                                    <input type="checkbox" id="name_required" name="name_required"
                                        class="custom-switch-input"
                                        @if (isset($name_required->value) && $name_required->value == 1) checked="checked" @endif />
                                    <span class="custom-switch-indicator"></span>
                                </label>
                                <small style="display: block;color: red;"><b style="color: black;">Note:</b> Mark Customer
                                    Name Field As Required On Subscribe Form</small>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                                {{ __('Ask For Date Of Birth') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <label class="custom-switch mt-2 pl-0">
                                    <input type="checkbox" id="ask_for_dob" name="ask_for_dob" class="custom-switch-input"
                                        @if (isset($ask_for_dob->value) && $ask_for_dob->value == 1) checked="checked" @endif />
                                    <span class="custom-switch-indicator"></span>
                                </label>
                                <small style="display: block;color: red;"><b style="color: black;">Note:</b> Ask for
                                    Customer DOB while subscribing to Offer.</small>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                                {{ __('Mark DOB Required') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <label class="custom-switch mt-2 pl-0">
                                    <input type="checkbox" id="dob_required" name="dob_required" class="custom-switch-input"
                                        @if (isset($dob_required->value) && $dob_required->value == 1) checked="checked" @endif />
                                    <span class="custom-switch-indicator"></span>
                                </label>
                                <small style="display: block;color: red;"><b style="color: black;">Note:</b> Mark Customer
                                    DOB Field As Required On Subscribe Form</small>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                                {{ __('Ask For Anniversary Date') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <label class="custom-switch mt-2 pl-0">
                                    <input type="checkbox" id="ask_for_anniversary_date" name="ask_for_anniversary_date"
                                        class="custom-switch-input"
                                        @if (isset($ask_for_anniversary_date->value) && $ask_for_anniversary_date->value == 1) checked="checked" @endif />
                                    <span class="custom-switch-indicator"></span>
                                </label>
                                <small style="display: block;color: red;"><b style="color: black;">Note:</b> Ask for
                                    Customer Anniversary Date while subscribing to Offer.</small>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                                {{ __('Mark Anniversary Date Required') }}</label>
                            <div class="col-sm-12 col-md-7">
                                <label class="custom-switch mt-2 pl-0">
                                    <input type="checkbox" id="anniversary_date_required" name="anniversary_date_required"
                                        class="custom-switch-input"
                                        @if (isset($anniversary_date_required->value) && $anniversary_date_required->value == 1) checked="checked" @endif />
                                    <span class="custom-switch-indicator"></span>
                                </label>
                                <small style="display: block;color: red;"><b style="color: black;">Note:</b> Mark Customer
                                    Anniversary Date Field As Required On Subscribe Form</small>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                                {{ __('Route Setting') }}</label>
                            <div class="col-sm-12 col-md-7">
                                    <select class="form-control" name="route_setting">
                                        <option value="business_routes" @if (isset($route_setting->value) && $route_setting->value == "business_routes") selected @endif>{{ __('Business Routes') }}</option>
                                        <option value="sms" 
                                        @if (isset($route_setting->value) && $route_setting->value == "sms") selected @endif>{{ __('SMS') }}</option>
                                        <option value="whatsapp" @if (isset($route_setting->value) && $route_setting->value == "whatsapp") selected  @endif>{{ __('Whatsapp') }}</option>
                                    </select>
                                
                                <small style="display: block;color: red;"><b style="color: black;">Note:</b> This will update Message Routes for all users !</small>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button class="btn btn-primary basicbtn" type="submit">{{ __('Save') }}</button><br>
                                <small>{{ __('Note:') }} </small> <small
                                    class="text-danger mt-4">{{ __('After You Update Settings The Action Will Work After 5 Minutes') }}</small>
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
    <script src="{{ asset('assets/js/form.js') }}"></script>
@endsection
