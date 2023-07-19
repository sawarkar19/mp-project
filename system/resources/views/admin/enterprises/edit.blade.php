@extends('layouts.admin')
@section('title', 'Admin: Enterprises')
@section('head')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />

    @include('layouts.partials.headersection', ['title' => 'Edit Email'])
    <style>
        #error {
            color: #ff0000;
        }

        #success {
            color: green;
        }
    </style>
@endsection
@section('content')

    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <form id="blogform" method="post" action="{{ route('admin.enterprises.update', $enterprises->id) }}"
                        enctype="multipart/form-data">
                        @csrf
						@method('PUT')
                        <div class="custom-form pt-20">

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" placeholder="Name" name="name" class="form-control char-and-spcs-validation" id="name"
                                    value="{{ $enterprises->name }}">
                            </div>

                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="text" placeholder="Email" name="email" class="form-control check-email-input"
                                    id="email" value="{{ $enterprises->email }}">
                            </div>

                            <div class="form-group">
                                <label for="name">Mobile</label>
                                <input type="text" placeholder="Mobile" name="mobile" class="form-control number-validation indian-mobile-series"
                                    id="mobile" maxlength="10" value="{{ $enterprises->mobile }}">
                            </div>

                            <div class="form-group">
                                <label for="name">WhatsApp message per month limit</label>
                                <input type="text" placeholder="WhatsApp message per month limit" name="wa_per_month_limit" class="form-control number-validation"
                                    id="wa_per_month_limit" maxlength="10" value="{{ $enterprises->wa_per_month_limit }}">
                            </div>

                            <div class="form-group">
                                <label for="name">Discount</label>
                                <input type="text" placeholder="Discount" name="discount"
                                    class="form-control number-validation" id="discount" maxlength="10" value="{{ $enterprises->discount }}">
                            </div>

                            <div class="form-group">
                                <label for="name">Commission</label>
                                <input type="text" placeholder="Commission" name="commission"
                                    class="form-control number-validation" id="commission" maxlength="10" value="{{ $enterprises->commission }}">
                            </div>

                            <div class="form-group">
                                <label for="name">Onetime Signup</label>
                                <input type="text" placeholder="Onetime Signup" name="onetime_signup"
                                    class="form-control number-validation" id="onetime_signup" maxlength="10" value="{{ $enterprises->onetime_signup }}">
                            </div>

                            <div class="form-group">
                                <label for="name">Type</label>
                                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="type">
                                    <option value="Customer" @if($enterprises->type == "Customer") selected @endif>{{ __('Customer') }}</option>
                                    <option value="Collaboration" @if($enterprises->type == "Collaboration") selected @endif>{{ __('Collaboration') }}</option>
                                    <option value="Channel Partner" @if($enterprises->type == "Channel Partner") selected @endif>{{ __('Channel Partner') }}</option>
                                    <option value="Influencer" @if($enterprises->type == "Influencer") selected @endif>{{ __('Influencer') }}</option>
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
