@extends('layouts.business')
@section('title', 'Business Settings')
@section('head') @include('layouts.partials.headersection',['title'=>'Business Settings']) @endsection

@section('end_head')
    @include('business.styles.setting-style')
@endsection

@section('content')
<section>
    <div class="section">

        <div class="card" style="overflow: hidden;">
            {{-- <div class="card-header">
                <h4>Basic Details</h4>
            </div> --}}
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-12 col-sm-5 col-md-4 pr-sm-0">
                        <ul class="nav flex-column h-100" style="border-right: 1px solid #e1e7ed;" id="b-setting-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link setting-section active" id="business_details" data-toggle="tab" href="#" role="tab"
                                    aria-controls="home" aria-selected="true">

                                    <div class="sb-tabs">
                                        <div class="inner">

                                            <div class="status-icon">
                                                @if(!$basic->business_name)
                                                <i class="fas fa-exclamation-circle text-warning"></i>
                                                @else
                                                <i class="fas fa-check-circle text-success"></i>
                                                @endif
                                            </div>

                                            <div class="title_">
                                                <h6>Business Details</h6>
                                                <p class="text-secondary">Update all required fields</p>
                                            </div>

                                            <div class="dirction-ico">
                                                <i class="fas fa-angle-right"></i>
                                            </div>

                                        </div>
                                    </div>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link setting-section" id="business_contact" data-toggle="tab" href="#" role="tab"
                                    aria-controls="profile" aria-selected="false">

                                    <div class="sb-tabs">
                                        <div class="inner">

                                            <div class="status-icon">
                                                @if(!$basic->call_number)
                                                <i class="fas fa-exclamation-circle text-warning"></i>
                                                @else
                                                <i class="fas fa-check-circle text-success"></i>
                                                @endif
                                            </div>

                                            <div class="title_">
                                                <h6>Business Contact</h6>
                                                <p class="text-secondary">Add your business contacts</p>
                                            </div>

                                            <div class="dirction-ico">
                                                <i class="fas fa-angle-right"></i>
                                            </div>

                                        </div>
                                    </div>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link setting-section" id="billing_address" data-toggle="tab" href="#" role="tab"
                                    aria-controls="contact" aria-selected="false">
                                    <div class="sb-tabs">
                                        <div class="inner">

                                            <div class="status-icon">
                                                @if(!$basic->billing_address_line_1)
                                                <i class="fas fa-exclamation-circle text-warning"></i>
                                                @else
                                                <i class="fas fa-check-circle text-success"></i>
                                                @endif
                                            </div>

                                            <div class="title_">
                                                <h6>Billing Address</h6>
                                                <p class="text-secondary">Add your billing address for invoices</p>
                                            </div>

                                            <div class="dirction-ico">
                                                <i class="fas fa-angle-right"></i>
                                            </div>

                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link setting-section" id="social_connection" data-toggle="tab" href="#" role="tab"
                                    aria-controls="contact" aria-selected="false">

                                    <div class="sb-tabs">
                                        <div class="inner">
                                            <div class="status-icon">
                                                @if(
                                                    isset($userSocialConnection) && 
                                                    $userSocialConnection->is_facebook_auth!=1 && $userSocialConnection->is_instagram_auth!=1 && $userSocialConnection->is_twitter_auth!=1 && $userSocialConnection->is_linkedin_auth!=1 && 
                                                    $youtubeTasks == 0
                                                )
                                                <i class="fas fa-exclamation-circle text-warning"></i>
                                                @else
                                                <i class="fas fa-check-circle text-success"></i>
                                                @endif
                                            </div>

                                            <div class="title_">
                                                <h6>Social Connections</h6>
                                                <p class="text-secondary">Connect to your social platforms</p>
                                            </div>

                                            <div class="dirction-ico">
                                                <i class="fas fa-angle-right"></i>
                                            </div>

                                        </div>
                                    </div>

                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link setting-section" id="social_link" data-toggle="tab" href="#" role="tab"
                                    aria-controls="contact" aria-selected="false">

                                    <div class="sb-tabs">
                                        <div class="inner">
                                            <div class="status-icon">
                                                @if(!$basic->facebook_link && !$basic->instagram_link &&!$basic->twitter_link && !$basic->linkedin_link &&!$basic->youtube_link)
                                                <i class="fas fa-exclamation-circle text-warning"></i>
                                                @else
                                                <i class="fas fa-check-circle text-success"></i>
                                                @endif
                                            </div>

                                            <div class="title_">
                                                <h6>Social Links</h6>
                                                <p class="text-secondary">Add your social media pages</p>
                                            </div>

                                            <div class="dirction-ico">
                                                <i class="fas fa-angle-right"></i>
                                            </div>

                                        </div>
                                    </div>

                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link setting-section" id="whatsapp_setting" data-toggle="tab" href="#" role="tab"
                                    aria-controls="contact" aria-selected="false">

                                    <div class="sb-tabs">
                                        <div class="inner">

                                            <div class="status-icon">
                                                @if($wa_session->instance_id == '')
                                                <i class="fas fa-exclamation-circle text-warning"></i>
                                                @else
                                                <i class="fas fa-check-circle text-success"></i>
                                                @endif
                                            </div>

                                            <div class="title_">
                                                <h6>WhatsApp</h6>
                                                <p class="text-secondary">Scan your WhatsApp to send messages.</p>
                                            </div>

                                            <div class="dirction-ico">
                                                <i class="fas fa-angle-right"></i>
                                            </div>

                                        </div>
                                    </div>

                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link setting-section" id="message_route" data-toggle="tab" href="#" role="tab"
                                    aria-controls="contact" aria-selected="false">

                                    <div class="sb-tabs">
                                        <div class="inner">

                                            <div class="status-icon">
                                                @if($activeRoute)
                                                    <i class="fas fa-check-circle text-success"></i>
                                                    
                                                @else
                                                    <i class="fas fa-exclamation-circle text-warning"></i>
                                                @endif
                                            </div>

                                            <div class="title_">
                                                <h6>Message Routes</h6>
                                                <p class="text-secondary">Set message route for channels</p>
                                            </div>

                                            <div class="dirction-ico">
                                                <i class="fas fa-angle-right"></i>
                                            </div>

                                        </div>
                                    </div>

                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link setting-section" id="vcard_setting" data-toggle="tab" href="#" role="tab" aria-controls="contact" aria-selected="false">
                                <div class="sb-tabs">
                                    <div class="inner">
                                        <div class="status-icon">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        <div class="title_">
                                            <h6>V-Card / Website</h6>
                                            <p class="text-secondary">Set redirection page for expire offer/challenge link</p>
                                        </div>
                                        <div class="dirction-ico">
                                            <i class="fas fa-angle-right"></i>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link setting-section" id="notification_setting" data-toggle="tab" href="#" role="tab"
                                    aria-controls="contact" aria-selected="false">

                                    <div class="sb-tabs">
                                        <div class="inner">

                                            <div class="status-icon">
                                                @if($notification_status_active)
                                                    <i class="fas fa-check-circle text-success"></i>
                                                    
                                                @else
                                                    <i class="fas fa-exclamation-circle text-warning"></i>
                                                @endif
                                            </div>

                                            <div class="title_">
                                                <h6>Notifications</h6>
                                                <p class="text-secondary">Set message route for channels</p>
                                            </div>

                                            <div class="dirction-ico">
                                                <i class="fas fa-angle-right"></i>
                                            </div>

                                        </div>
                                    </div>

                                </a>
                            </li>
                            
                        </ul>
                    </div>
                    <div class="col-12 col-sm-7 col-md-8 pl-sm-0">
                        <div class="tab-content no-padding" id="settings_tab_content">

                            {{-- Section 1 --}}
                            <div class="tab-pane fade setting-section-tab" id="business_details_tab" role="tabpanel" aria-labelledby="business_details">
                                <div class="p-4">

                                    <div class="default alert alert-info mb-4">
                                        <p class="mb-2 lh-1"><b>Business Details</b></p>
                                        <p class="mb-0 small lh-1">Your customers will be able to see this information on offer pages/templates.</p>
                                    </div>

                                    {!! Form::model($basic, ['method' => 'POST','route' => 'business.basicDetails', 'files'=>true, 'class'=> 'basicSettingform']) !!}

                                    

                                    <div class="mb-4">
                                        <div class="d-md-flex">
                                            <div class="logo-priview mb-3 mb-md-0">
                                                <div class="logo-wrap crop-again">
                                                    <img id="preview_oi" src="{{ asset('assets/business/logos/'.$basic->logo) }}" class="img-fluid logo_path" alt="{{ asset('assets/business/logos/'.$basic->logo) }}" style="@if($basic->logo == '') display:none @endif">
                                                </div>
                                                <i class="fa fa-times remove-business-logo" style="@if($basic->logo == '') display: none; @endif" id="removeLogo" aria-hidden="true" data-toggle="tooltip" title="Remove Logo"></i>
                                            </div>
                                            <div>
                                                <div class="form-group mb-0 pl-md-4">
                                                    <label for="bl" class="text-primary mb-0 lh-1">Select Logo<small> ({{__('Optional')}})</small></label>
                                                    <div class="small mb-2 lh-1">Select <span class="text-danger">PNG</span>, <span class="text-danger">JPG</span>, and <span class="text-danger">JPEG</span> image, Max file size <span class="text-danger">1MB</span>, and Max image width <span class="text-danger">512px</span>.</div>
                                                    <input type="file" name="logo" accept="image/png, image/jpeg" id="bl" placeholder="Select your business logo"
                                                        class="form-control img-preview-oi cropperjs_input" 
                                                        data-function-name="logo_preview" 
                                                        data-cancel-function="cancel_logo_selection($(this));"
                                                        data-exts="jpeg|jpg|png"
                                                    />

                                                    <input type="hidden" name="imagestring" id="imagestring" value="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="business_name" class="text-primary mb-0">{{__('Business Name')}} <span class="text-danger">*</span></label>
                                        {!! Form::text('business_name', null, array('placeholder' => 'Enter the name of your Business','class' => 'form-control two-space-validation char-spcs-validation ', "id"=>"business_name",  "autocomplete" => "off", 'required')) !!}
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="tag_line" class="text-primary mb-0">{{__('Tag Line')}}<small> ({{__('Optional')}})</small></label>
                                        {!! Form::text('tag_line', null, array('placeholder' => 'Enter tag line here','class' => 'form-control',"autocomplete" => "off", "id"=>"tag_line")) !!}
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="website" class="text-primary mb-0">{{__('Website link')}} <small>({{__('Optional')}})</small></label>
                                        {!! Form::url('website', null, array('placeholder' => 'Enter Website link','class' => 'form-control',"autocomplete" => "off", "id"=>"website")) !!}
                                    </div>

                                    {{-- @php
                                        $timingArr = [
                                        '8.00' => '8.00 AM',
                                        '9.00' => '9.00 AM',
                                        '10.00' => '10.00 AM',
                                        '11.00' => '11.00 AM',
                                        '12.00' => '12.00 PM',
                                        '13.00' => '1.00 PM',
                                        '14.00' => '2.00 PM',
                                        '15.00' => '3.00 PM',
                                        '16.00' => '4.00 PM',
                                        '17.00' => '5.00 PM',
                                        '18.00' => '6.00 PM',
                                        '19.00' => '7.00 PM',
                                        '20.00' => '8.00 PM',
                                        '21.00' => '9.00 PM',
                                        '22.00' => '10.00 PM',
                                        '23.00' => '11.00 PM',
                                        '24.00' => '12.00 AM',
                                    ];
                                    @endphp

                                    

                                    <div class="form-group">
                                        <label for="daily_reporting_time" class="text-primary mb-0">{{__('Daily report timing')}} <span class="text-danger">*</span></label>
                                        <select id="daily_reporting_time" name="daily_reporting_time" class="form-control choise-groups" required>
                                            @foreach($timingArr as $keys => $timing)
                                                <option value="{{ $keys }}" @if($basic->daily_reporting_time == $timing) selected @endif>{{ $timing }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}

                                    {{-- <div class="form-group mb-3">
                                        <label for="actual_link" class="text-primary mb-0">{{ __('Footer Message') }} <small>({{__('Optional')}})</small></label>
                                        {!! Form::text('message', $basic->business_msg, array('class' => 'form-control editor', "id"=>"message")) !!}
                                    </div> --}}

                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary px-4 basicbtn">Save Details</button>
                                    </div>

                                    </form>
                                </div>
                            </div>
                            {{-- section 1 end  --}}

                            {{-- section 2 --}}
                            <div class="tab-pane fade setting-section-tab" id="business_contact_tab" role="tabpanel" aria-labelledby="business_contact">
                                <div class="p-4">

                                    <div class="default alert alert-info mb-4">
                                        <p class="mb-2 lh-1"><b>Business Contact</b></p>
                                        <p class="mb-0 small lh-1">Please fill in all your contact details appropriately. These contact details are used in campaigns as a point of contact for your customers.</p>
                                    </div>

                                    {!! Form::model($basic, ['method' => 'POST','route' => 'business.businessAddress', "autocomplete" => "off", 'class'=> 'basicSettingform']) !!}
                                    {{-- @csrf --}}
                                        <div id="address_">

                                            <div class="form-group mb-3">
                                                <label for="call_number" class="text-primary mb-0">Business Number <span class="text-danger">*</span></label>
                                                {!! Form::tel('call_number', null, array('placeholder' => 'Enter you business number...','class' => 'form-control number-validation',"autocomplete" => "off", "id"=>"call_number", 'required', 'pattern' => '[6789][0-9]{9}')) !!}
                                            </div>

                                            <hr>
                                            <p class="text-dark"><b>Business Address</b>:</p>

                                            <div class="form-group mb-3">
                                                <label for="address_line_1" class="text-primary mb-0">Address Line 1 <span class="text-danger">*</span></label>
                                                {!! Form::text('address_line_1', null, array('placeholder' => 'Enter Address line 1','class' => 'form-control',"autocomplete" => "off", "id"=>"address_line_1", 'required')) !!}
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="address_line_2" class="text-primary mb-0">Address Line 2</label>
                                                {!! Form::text('address_line_2', null, array('placeholder' => 'Enter Address line 2','class' => 'form-control',"autocomplete" => "off", "id"=>"address_line_2")) !!}
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group mb-3">
                                                        <label for="pincode" class="text-primary mb-0">Pin Code <span class="text-danger">*</span></label>
                                                        {!! Form::tel('pincode', null, array('placeholder' => 'Area Pin Code','class' => 'form-control number-validation',"autocomplete" => "off", "id"=>"pincode", 'required', 'minlength' => '6', 'maxlength' => '6')) !!}
                                                    </div>        
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group mb-3">
                                                        <label for="city" class="text-primary mb-0">City <span class="text-danger">*</span></label>
                                                        {!! Form::text('city', null, array('placeholder' => 'Enter City Name','class' => 'form-control  three-space-validation char-spcs-validation', "id"=>"city","autocomplete" => "off", 'required')) !!}
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group mb-3">
                                                        <label for="state" class="text-primary mb-0">State <span class="text-danger">*</span></label>
                                                        <select name="state" class="form-control">
                                                        @foreach($states as $state)
                                                            <option value="{{ $state->id }}" @if($basic->state == $state->id) selected @endif>{{ $state->name }}</option>
                                                        @endforeach
                                                        </select>
                                                        <!-- {!! Form::text('state', null, array('placeholder' => 'Enter State Name','class' => 'form-control  three-space-validation char-spcs-validation', "id"=>"state", 'required')) !!} -->
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group mb-3">
                                                        <label for="country" class="text-primary mb-0">Country</label>
                                                        {!! Form::text('country', 'India', array('class' => 'form-control', "id"=>"country", "readonly"=>"")) !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-3">
                                                <div class="d-flex justify-content-between">
                                                    <label for="google_map_link" class="text-primary mb-0">Google Map Link<small> ({{__('Optional')}})</small></label>
                                                    <div  aria-expanded="false" data-toggle="modal" data-target="#google-map"><i class="fas fa-info-circle"></i></div>
                                                </div>
                                                {!! Form::text('google_map_link', null, array('placeholder' => 'https://www.google.com/maps/','class' => 'form-control',"autocomplete" => "off", "id"=>"google_map_link")) !!}
                                            </div>
                                            {{-- <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group mb-3">
                                                        <label for="latitude" class="text-primary mb-0">
                                                            Latitude<small> ({{__('Optional')}})</small>
                                                        </label>
                                                        {!! Form::text('latitude', null, array('class' => 'form-control', "id"=>"latitude", 'placeholder'=> '21.*******')) !!}
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group mb-3">
                                                        <label for="longitude" class="text-primary mb-0">
                                                            Longitude<small> ({{__('Optional')}})</small>
                                                        </label>
                                                        {!! Form::text('longitude', null, array('class' => 'form-control', "id"=>"longitude", 'placeholder'=> '78.*******')) !!}
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary px-4 basicbtn">Save Address</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            {{-- Section 2 end  --}}

                            {{-- section 3  --}}
                            <div class="tab-pane fade setting-section-tab" id="billing_address_tab" role="tabpanel" aria-labelledby="billing_address">
                                <div class="p-4">

                                    <div class="default alert alert-info mb-4">
                                        <p class="mb-2 lh-1"><b>Billing Address</b></p>
                                        <p class="mb-0 small lh-1">Please fill in your billing address details appropriately. These address details are used only in invoice, bills etc.</p>
                                    </div>

                                    {!! Form::model($basic, ['method' => 'POST', 'route' => 'business.billingAddress',  "autocomplete" => "off", 'class'=> 'basicSettingform']) !!}
                                        @csrf
                                        <div id="bill_address_">
                                            

                                            <div class="row align-items-end">
                                                <div class="col-12">
                                                    <div class="form-group mb-2">
                                                        <div class="custom-control custom-checkbox mb-0" >
                                                            <input type="checkbox" id="same_to_bill" name="same_as_address"  class="custom-control-input" @if($basic->is_same_address == 1) checked @endif>
                                                            <label class="custom-control-label"  for="same_to_bill"><b> Same as above business address</b> </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            

                                            <div class="form-group mb-3">
                                                <label for="billing_address_line_1" class="text-primary mb-0">Address Line 1 <span class="text-danger">*</span></label>
                                                {!! Form::text('billing_address_line_1', null, array('placeholder' => 'Enter Address line 1','class' => 'form-control',"autocomplete" => "off", "id"=>"billing_address_line_1", 'required')) !!}
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="billing_address_line_2" class="text-primary mb-0">Address Line 2</label>
                                                {!! Form::text('billing_address_line_2', null, array('placeholder' => 'Enter Address line 2','class' => 'form-control',"autocomplete" => "off", "id"=>"billing_address_line_2")) !!}
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group mb-3">
                                                        <label for="billing_pincode" class="text-primary mb-0">Pin Code <span class="text-danger">*</span></label>
                                                        {!! Form::tel('billing_pincode', null, array('placeholder' => 'Area Pin Code','class' => 'form-control number-validation',"autocomplete" => "off", "id"=>"billing_pincode", 'required', 'minlength' => '6', 'maxlength' => '6')) !!}
                                                    </div>        
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group mb-3">
                                                        <label for="billing_city" class="text-primary mb-0">City <span class="text-danger">*</span></label>
                                                        {!! Form::text('billing_city', null, array('placeholder' => 'Enter City Name','class' => 'form-control  three-space-validation char-spcs-validation', "id"=>"billing_city","autocomplete" => "off", 'required')) !!}
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group mb-3">
                                                        <label for="billing_state" class="text-primary mb-0">State <span class="text-danger">*</span></label>
                                                        <select name="billing_state" class="form-control" id="billing_state">
                                                        @foreach($states as $state)
                                                            <option value="{{ $state->id }}" @if($basic->billing_state == $state->id) selected @endif>{{ $state->name }}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group mb-3">
                                                        <label for="country" class="text-primary mb-0">Country</label>
                                                        {!! Form::text('country', 'India', array('class' => 'form-control', "id"=>"country", "readonly"=>"")) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            

                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary px-4 basicbtn">Save Billing Address</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            {{-- section 3 end  --}}

                            {{-- section 4  --}}
                            <div class="tab-pane fade setting-section-tab" id="social_connection_tab" role="tabpanel" aria-labelledby="social_connection">
                                <div class="p-4">

                                    <div class="section">

                                        <div class="my-5 text-center">
                                            <h5>Connect Social Media Accounts</h5>
                                            <p>Here you can connect your social media Accounts / Pages / Groups / Profiles to directly auto-post your offer.</p>
                                        </div>
                                
                                        <div>
                                            <div class="row justify-content-center">
                                
                                                @php $columns = 'col-md-4 col-sm-6 mb-4' @endphp
                                                @if($userSocialPlatform!=NULL)
                                                    
                                                    @foreach ($userSocialPlatform as $key => $platform)
                                                        @php
                                                            $platform_keyname = $platform->platform_key;
                                                            $platform_key = 'is_'.$platform_keyname.'_auth';
                                                            $platform_page_id = $platform_keyname."_page_id";
                                                            
                                                            $is_page_id = $is_show_page = $is_link_redirect = 0;
                                                            $pagePlatforms = ["facebook", "linkedin"];
                                                            if(in_array($platform_keyname, $pagePlatforms)){
                                                                $is_page_id = 1;
                                                            }
                                                            $showPageNames = ["instagram", "twitter", "youtube"];
                                                            if(in_array($platform_keyname, $showPageNames)){
                                                                $is_show_page = 1;
                                                            }

                                                            $setPageLink = ["youtube", "google"];
                                                            if(in_array($platform_keyname, $setPageLink)){
                                                                $is_link_redirect = 1;
                                                            }
                                                        @endphp
                                
                                                        <div class="{{$columns}}">
                                                            <div class="sconnect card">

                                                                @if($platform->status==1)
                                                                    @if($platform->platform_key == 'youtube' && $youtubeTasks > 0)
                                                                        <i class="fas fa-check-circle connected-icon"></i>
                                                                        
                                                                        @if($is_show_page && isset($showLinkTasks['youtube_channel']['task_value']))
                                                                            <a href="{{ url($showLinkTasks['youtube_channel']['task_value']) }}" target="_blank" rel="nofollow">
                                                                                <i class="fas fa-link update-icon text-primary" id="{{ $platform->page_popup_id }}" 
                                                                                    
                                                                                @if($platform_keyname=="youtube")
                                                                                    title="View Channel" 
                                                                                @else
                                                                                    title="View Page"
                                                                                @endif
                                                                                ></i>
                                                                            </a>
                                                                        @endif
                                                                    @else

                                                                        @if($userSocialConnection->$platform_key) 
                                                                            <i class="fas fa-check-circle connected-icon"></i>
                                                                            @if($is_page_id)
                                                                                <i class="fas fa-pen update-icon text-primary" id="{{ $platform->page_popup_id }}" title="Update Page" ></i>
                                                                            @endif

                                                                            @if($is_show_page==1)

                                                                            {{-- social media icon connection popover --}}
                                                                                <button class="fas fa-eye update-icon pop-icon text-primary"
                                                                                    data-toggle="popover"
                                                                                    data-trigger="focus"
                                                                                    data-placement="bottom"
                                                                                    data-html="true"
                                                                                    @php
                                                                                        $username = '';
                                                                                        $sbrand = '';
                                                                                        if ($platform_keyname=="instagram") {
                                                                                            $sbrand = 'instagram';
                                                                                            $username = $userSocialConnection->instagram_username ?? '';
                                                                                        }
                                                                                        elseif ($platform_keyname=="twitter") {
                                                                                            $sbrand = 'twitter';
                                                                                            $username = $userSocialConnection->twitter_username ?? '';
                                                                                        }
                                                                                    @endphp
                                                                                    data-content="<div class='connect-pop'><i class='fab fa-{{$sbrand}} {{$sbrand}}-bg mr-1'></i> {{$username}}</div>"
                                                                                    data-template='<div class="popover bg-dark text-center" role="tooltip"><div class="arrow dark"></div><div class="popover-body text-white"></div></div>'>
                                                                                </button>

                                                                                {{-- social media icon connection modal popup --}}
                                                                                {{-- <i class="fas fa-eye update-icon text-primary" id="{{ $platform->page_popup_id }}" 
                                                                                    
                                                                                @if($platform_keyname=="instagram")
                                                                                    data-username="{{ $userSocialConnection->instagram_username ?? '' }}"
                                                                                    data-modaltitle="Instagram Business Account Profile"

                                                                                    title="Instargram Business Account Profile" 
                                                                                @elseif($platform_keyname=="twitter")
                                                                                    data-username="{{ $userSocialConnection->twitter_username ?? '' }}"
                                                                                    data-modaltitle="Twitter Profile"

                                                                                    title="View Profile"
                                                                                @else
                                                                                    title="View Page"
                                                                                @endif
                                                                                ></i> --}}
                                                                            @endif

                                                                            @if($is_link_redirect==1 && isset($showLinkTasks['google_review']['task_value']))
                                                                                <a href="{{ url('https://search.google.com/local/writereview?placeid='.$showLinkTasks['google_review']['task_value']) }}" target="_blank" rel="nofollow">
                                                                                    <i class="fas fa-link update-icon text-primary" id="{{ $platform->page_popup_id }}"
                                                                                    @if($platform_keyname=="google")
                                                                                        
                                                                                        title="View Review Page" 
                                                                                    @else
                                                                                        title="View Page"
                                                                                    @endif
                                                                                    ></i>
                                                                                </a>
                                                                            @endif

                                                                        @endif
                                                                    @endif
                                                                @endif
                                
                                                                <div class="card-body">
                                                                    <div class="sc-icon mb-2">
                                                                        {{-- <i class="{{ $platform->icon_class_name }}" style="color: {{ $platform->icon_color_code }};"></i> --}}
                                                                        {!! $platform->icon_class_name !!}
                                                                    </div>
                                                                    <h6>{{ $platform->name }}  </h6>
                                                                    <div class="text-secondary">{{ $platform->subname }}</div>
                                                                </div>

                                                                @if($platform->status==1)
                                                                    @if($platform->platform_key == 'youtube')
                                                                        @if($youtubeTasks > 0) 
                                                                            <a class="connected text-decoration-none" data-socialAccount="{{ $platform->social_account_name }}" href="javascript:void(0)" >
                                                                                <b>Connected</b>
                                                                            </a> 
                                                                        @else 
                                                                            <a class="new_connect text-decoration-none connect_to_youtube" data-socialAccount="{{ $platform->social_account_name }}" href="javascript:void(0)" >
                                                                                <b>Connect Now</b>
                                                                            </a>
                                                                        @endif
                                                                    @else
                                                                        <a class="@if($userSocialConnection->$platform_key) connected @else new_connect @endif text-decoration-none @if($platform->platform_key != "google") connect-to-social-media @else showMsgPopup @endif " data-socialAccount="{{ $platform->social_account_name }}" href="javascript:void(0)" >
                                                                            <b> @if($userSocialConnection->$platform_key) Connected @else Connect Now @endif </b>
                                                                            <span id="loading_icon_{{ $platform->social_account_name }}" class="ms-2" style="display:none;">
                                                                                <i class="fa fa-spinner fa-2x fa-spin"></i>
                                                                            </span>
                                                                        </a>
                                                                    @endif
                                                                @else
                                                                    <div class="new_connect a_disable" data-toggle="tooltip" data-placement="bottom" title="Coming soon..." >
                                                                        <b>Connect Now</b>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                
                                                    @endforeach
                                                @else
                                                    <div class="col-12">
                                                        <div class="sconnect card">
                                                            <p>Social Platform not found!</p>
                                                        </div>
                                                    </div>
                                                @endif
                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="container">
                                        <div class="py-5">
                                            {{-- social-post-steps --}}
                                            <div class="row justify-content-center">  
                                                <div class="col-xl-12 col-lg-12 col-12">
                                                    <div class="text-center mb-5">
                                                        <h4 class="font-800">Can't connect social media account?</h4>
                                                        <h6>Follow the steps below</h6>
                                                        <div class="underline-text"></div>
                                                    </div> 
                                                    <div class="social-post-setps">
                                                        {{-- How to switch from your personal to professional Instagram account --}}
                                                        <div class="accordion social-steps insta-switch" id="insta-switch-accordion">
                                                            <div class="accordion-item">
                                                              <div class="accordion-header" id="insta-switch-head" data-toggle="collapse" data-target="#insta-switch" aria-expanded="false" aria-controls="insta-switch">
                                                                   <div class="d-flex justify-content-between align-items-center">
                                                                        <div class="d-inline-block mt-2 mt-md-0">
                                                                            <h6 class="mb-0">How to switch from your personal to professional Instagram account?</h6>
                                                                        </div>
                                                                        <div class="">
                                                                            <i class="fas fa-angle-down" style="font-size: 20px;"></i>
                                                                        </div>
                                                                   </div>
                                                                    
                                                              </div>
                                                          
                                                              <div id="insta-switch" class="collapse" aria-labelledby="insta-switch-head" data-parent="#insta-switch-accordion">
                                                                <div class="accordion-body steps-lineHeight insta-switch-steps mt-4">
                                                                    <div class="insta-switch-step1">
                                                                        <p><b>Step 1:</b> Go to your Profile and tap More.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/personal-insta-professional/step1.png') }}" alt="" class="img-fluid">
                                                                    </div>
                                                                    <div class="insta-switch-step2 mt-4">
                                                                        <p><b>Step 2:</b> Click on Settings.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/personal-insta-professional/step2.png') }}" alt="" class="img-fluid">
                                                                    </div>
                                                                    <div class="insta-switch-step3 mt-4">
                                                                        <p><b>Step 3:</b> For some accounts, the switch to Professional Account option will be listed directly under Settings.If not then tap on Account.</p>
                                                                    </div>
                                                                    <div class="insta-switch-step4 mt-4">
                                                                        <p><b>Step 4:</b> Tap on switch to Professional Account.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/personal-insta-professional/step3.png') }}" alt="" class="img-fluid">
                                                                    </div>
                                                                    <div class="insta-switch-step5 mt-4">
                                                                        <p><b>Step 5 :</b> Select business and click on next.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/personal-insta-professional/step4.png') }}" alt="" class="img-fluid">
                                                                    </div>
                                                                    <div class="insta-switch-step6 mt-4">
                                                                        <p><b>Step 6 :</b> Click on Next</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/personal-insta-professional/step5.png') }}" alt="" class="img-fluid">
                                                                    </div>
                                                                    <div class="insta-switch-step7 mt-4">
                                                                        <p><b>Step 7:</b> Select/type the category for your business and tap Done.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/personal-insta-professional/step6.png') }}" alt="" class="img-fluid">
                                                                    </div>
                                                                    <div class="insta-switch-step8 mt-4">
                                                                        <p><b>Step 8:</b> Add contact details and tap Next. Or tap don't use my contact info to skip this step.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/personal-insta-professional/step7.png') }}" alt="" class="img-fluid">
                                                                    </div>
                                                                    <div class="insta-switch-step9 mt-4">
                                                                        <p><b>Step 9:</b> Click on done.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/personal-insta-professional/step8.png') }}" alt="" class="img-fluid">
                                                                    </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                        </div>
                                                        {{-- How to link your facebook account to Instagram account --}}
                                                        <div class="accordion social-steps fb-link-insta" id="fb-link-insta-accordion">
                                                            <div class="accordion-item">
                                                              <div class="accordion-header" id="fb-link-insta-head" data-toggle="collapse" data-target="#fb-link-insta" aria-expanded="false" aria-controls="fb-link-insta">
                                                                    <div class="d-flex justify-content-between align-items-center">    
                                                                        <div class="d-inline-block mt-2 mt-md-0">
                                                                            <h6 class="mb-0">How to link your Facebook account to Instagram account?</h6>
                                                                        </div>
                                                                        <div class="">
                                                                            <i class="fas fa-angle-down" style="font-size: 20px;"></i>
                                                                        </div>
                                                                    </div>        
                                                              </div>
                                                          
                                                              <div id="fb-link-insta" class="collapse" aria-labelledby="fb-link-insta-head" data-parent="#fb-link-insta-accordion">
                                                                <div class="accordion-body steps-lineHeight fb-link-insta-steps mt-4">
                                                                    <div class="fb-link-insta-step1">
                                                                        <p><b>Step 1:</b> From facebook, Click on your page.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/fbpage-connect-instapage/step1.png') }}" alt="" class="img-fluid">
                                                                    </div>
                                                                    <div class="fb-link-insta-step2 mt-4">
                                                                        <p><b>Step 2:</b> Scroll the manage pages and profiles section and Click on settings present in bottom.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/fbpage-connect-instapage/step2.png') }}" alt="" class="img-fluid">
                                                                    </div>
                                                                    <div class="fb-link-insta-step3 mt-4">
                                                                        <p><b>Step 3:</b> From Page settings scroll down the section and click on instagram.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/fbpage-connect-instapage/step3.png') }}" alt="" class="img-fluid">
                                                                    </div>
                                                                    <div class="fb-link-insta-step4 mt-4">
                                                                        <p><b>Step 4:</b> Click on Connect account.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/fbpage-connect-instapage/step4.png') }}" alt="" class="img-fluid">
                                                                    </div>
                                                                    <div class="fb-link-insta-step5 mt-4">
                                                                        <p><b>Step 5:</b> Click on Connect.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/fbpage-connect-instapage/step5.png') }}" alt="" class="img-fluid">
                                                                    </div>
                                                                    <div class="fb-link-insta-step6 mt-4">
                                                                        <p><b>Step 6:</b> Click on confirm.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/fbpage-connect-instapage/step6.png') }}" alt="" class="img-fluid">
                                                                    </div>
                                                                    <div class="fb-link-insta-step7 mt-4">
                                                                        <p><b>Step 7:</b> Then Enter the credentials(username and password) of account which you have to link.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/fbpage-connect-instapage/step7.png') }}" alt="" class="img-fluid">
                                                                    </div>
                                                                    <div class="fb-link-insta-step8 mt-4">
                                                                        <p><b>Step 8:</b> Come back to your facebook page and you will get one popup then click on done.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/fbpage-connect-instapage/step8.png') }}" alt="" class="img-fluid">
                                                                    </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                        </div>
                                
                                                        {{--how to create facebook business page --}}
                                                        <div class="accordion social-steps facebook-business-page" id="facebook-business-accordion">
                                                            <div class="accordion-item">
                                                            <div class="accordion-header" id="facebookHeading-business" data-toggle="collapse" data-target="#facebook-business" aria-expanded="false" aria-controls="facebook">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div class="d-inline-block">
                                                                            <h6 class="mb-0">How to create facebook business page?</h6>
                                                                        </div>
                                                                        <div class="">
                                                                            <i class="fas fa-angle-down" style="font-size: 20px;"></i>
                                                                        </div>
                                                                    </div>    
                                                            </div>
                                                        
                                                            <div id="facebook-business" class="collapse" aria-labelledby="facebookHeading-business" data-parent="#facebook-business-accordion">
                                                                <div class="accordion-body steps-lineHeight steps-lineHeight fb-business-steps mt-4">
                                                                    <div class="fb-business-step1">
                                                                        <p><b>Step 1:</b> From your facebook account click on Pages.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/facebook-business-page/business-facebook-step1.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="fb-business-step2 mt-4">
                                                                        <p><b>Step 2:</b> From the Pages section, click Create New Page.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/facebook-business-page/business-facebook-step2.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="fb-business-step3 mt-4">
                                                                        <p><b>Step 3:</b> Add your Page name, category and page's bio and click on Create Page.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/facebook-business-page/business-facebook-step3.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="fb-business-step4 mt-4">
                                                                        <p><b>Step 4:</b>  Add information, such as contact, location (its optional), and click on Next.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/facebook-business-page/business-facebook-step4.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="fb-business-step5 mt-4">
                                                                        <p><b>Step 5:</b> Add profile and cover photos, edit the action button (its optional) and click Next.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/facebook-business-page/business-facebook-step5.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="fb-business-step6 mt-4">
                                                                        <p><b>Step 6:</b> You can connect whatsapp to your page by adding whatsapp number and the click on get code and follow the instructions given by screen or you can Skip it just by clicking on Skip.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/facebook-business-page/business-facebook-step6.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="fb-business-step7 mt-4">
                                                                        <p><b>Step 7:</b> Invite friends to connect with your Page (its optional), and click Next.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/facebook-business-page/business-facebook-step7.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="fb-business-step8 mt-4">
                                                                        <p><b>Step 8:</b> Click Done.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/facebook-business-page/business-facebook-step8.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        {{-- facebook --}}
                                                        <div class="accordion social-steps facebook" id="facebook-accordion">
                                                            <div class="accordion-item">
                                                              <div class="accordion-header" id="facebookHeading" data-toggle="collapse" data-target="#facebook" aria-expanded="false" aria-controls="facebook">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div class="d-inline-block">
                                                                            <h6 class="mb-0">Connect with Facebook</h6>
                                                                        </div>
                                                                        <div class="">
                                                                            <i class="fas fa-angle-down" style="font-size: 20px;"></i>
                                                                        </div>
                                                                    </div>    
                                                              </div>
                                                          
                                                              <div id="facebook" class="collapse" aria-labelledby="facebookHeading" data-parent="#facebook-accordion">
                                                                <div class="accordion-body steps-lineHeight steps-lineHeight fb-steps mt-4">
                                                                    <div class="fb-step1">
                                                                        <p><b>Step 1:</b> Click on the Connect Now from facebook card. It will redirect to  your facebook account.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/facebook/socialpost-fb-step1.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="fb-step2 mt-4">
                                                                        <p><b>Step 2:</b> Facebook screen will appear, enter you facebook credentials and Sing in. Then click on Edit button.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/facebook/socialpost-fb-step2.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="fb-step3 mt-4">
                                                                        <p><b>Step 3:</b> Select the Facebook Business Account you want to connect.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/facebook/socialpost-fb-step3.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="fb-step4 mt-4">
                                                                        <p><b>Step 4:</b> Allow all manage permission by managemedias by enabling all the toggle buttons.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/facebook/socialpost-fb-step4.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="fb-step5 mt-4">
                                                                        <p><b>Step 5:</b> The facebook page will redirect to your dashboard account. Select your facebook page and click on update page</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/facebook/socialpost-fb-step5.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="fb-step6 mt-4">
                                                                        <p><b>Step 6:</b> Make sure to check green tick and connected on Facebook card.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/facebook/socialpost-fb-step6.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                        </div>
                                                        {{-- instagram --}}
                                                        <div class="accordion social-steps instagram" id="instagram-accordion">
                                                            <div class="accordion-item">
                                                              <div class="accordion-header" id="instagramHeading" data-toggle="collapse" data-target="#instagram" aria-expanded="false" aria-controls="instagram">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div class="d-inline-block">
                                                                            <h6 class="mb-0">Connect with Instagram</h6>
                                                                        </div>
                                                                        <div class="">
                                                                            <i class="fas fa-angle-down" style="font-size: 20px;"></i>
                                                                        </div>
                                                                    </div>    
                                                              </div>
                                                          
                                                              <div id="instagram" class="collapse" aria-labelledby="instagramHeading" data-parent="#instagram-accordion">
                                                                <div class="accordion-body steps-lineHeight insta-steps mt-4">
                                                                    <h6 class="text-warning">Note: To connect with instagram you have to first connect with facebook</h6>
                                                                    <div class="insta-step1">
                                                                        <p><b>Step 1:</b> Click on the Connect Now from instagram card. It will redirect to  your facebook account.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/instagram/socialpost-insta-step1.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="insta-step2 mt-4">
                                                                        <p><b>Step 2:</b> Authenticate it by clicking on Continue button.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/instagram/socialpost-insta-step2.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="insta-step3 mt-4">
                                                                        <p><b>Step 3:</b> Select the Instagram Business Account you want to connect.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/instagram/socialpost-insta-step3.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="insta-step4 mt-4">
                                                                        <p><b>Step 4:</b> Proceed to next screen by clicking on Next button.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/instagram/socialpost-insta-step4.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="insta-step5 mt-4">
                                                                        <p><b>Step 5:</b> Allow all manage permission by managemedias by enabling all the toggle buttons.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/instagram/socialpost-insta-step5.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="insta-step6 mt-4">
                                                                        <p><b>Step 6:</b> Click on Ok</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/instagram/socialpost-insta-step6.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="insta-step7 mt-4">
                                                                        <p><b>Step 7:</b> The facebook page will redirect to your dashboard account and make sure to check green tick and connected on instagram card.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/instagram/socialpost-insta-step7.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                        </div>
                                                        {{-- twitter --}}
                                                        <div class="accordion social-steps twitter" id="twitter-accordion">
                                                            <div class="accordion-item">
                                                              <div class="accordion-header" id="twitterHeading" data-toggle="collapse" data-target="#twitter" aria-expanded="false" aria-controls="twitter">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div class="d-inline-block">
                                                                            <h6 class="mb-0">Connect with Twitter</h6>
                                                                        </div>
                                                                        <div class="">
                                                                            <i class="fas fa-angle-down" style="font-size: 20px;"></i>
                                                                        </div>
                                                                    </div>
                                                              </div>
                                                          
                                                              <div id="twitter" class="collapse" aria-labelledby="twitterHeading" data-parent="#twitter-accordion">
                                                                <div class="accordion-body steps-lineHeight twitter-steps mt-4">
                                                                    <div class="twitter-step1">
                                                                        <p><b>Step 1:</b> Click on the Connect Now from Twitter card. It will redirect to  your Twitter sign in page.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/twitter/socialpost-twitter-step1.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="twitter-step2 mt-4">
                                                                        <p><b>Step 2:</b> Authenticate it by clicking on Authorize App button.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/twitter/socialpost-twitter-step2.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="twitter-step3 mt-4">
                                                                        <p><b>Step 3:</b> The Twitter page will redirect to your dashboard account and make sure to check green tick and connected on Twitter card.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/twitter/socialpost-twitter-step3.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                        </div>
                                                        {{-- linkedIn --}}
                                                        <!-- <div class="accordion social-steps linkedin" id="linkedin-accordion">
                                                            <div class="accordion-item">
                                                              <div class="accordion-header" id="linkedinHeading" data-toggle="collapse" data-target="#linkedin" aria-expanded="false" aria-controls="linkedin">
                                                                    <div class="d-flex justify-content-between align-items-center">    
                                                                        <div class="d-inline-block">
                                                                            <h6 class="mb-0">Connect with linkedIn</h6>
                                                                        </div>
                                                                        <div class="">
                                                                            <i class="fas fa-angle-down" style="font-size: 20px;"></i>
                                                                        </div>
                                                                    </div>    
                                                              </div>
                                                          
                                                              <div id="linkedin" class="collapse" aria-labelledby="linkedinHeading" data-parent="#linkedin-accordion">
                                                                <div class="accordion-body steps-lineHeight linkedin-steps mt-4">
                                                                    <div class="linkedin-step1">
                                                                        <p><b>Step 1:</b> Click on the Connect Now from LinkedIn card. It will redirect to your LinkedIn Account.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/linkedin/socialpost-linkedin-step1.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="linkedin-step2 mt-4">
                                                                        <p><b>Step 2:</b> Authenticate it by clicking on Allow button.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/linkedin/socialpost-linkedin-step2.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="linkedin-step3 mt-4">
                                                                        <p><b>Step 3:</b> The LinkedIn page will redirect to your dashboard account. It will ask you about your LinkedIn Page Id.</p>
                                                                    </div>
                                                                    <div class="linkedin-step4 mt-4">
                                                                        <p><b>Step 4:</b> For LinkedIn Page Id, From your linkedin account go to your business page and copy the Id present in URL.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/linkedin/socialpost-linkedin-step3.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="linkedin-step5 mt-4">
                                                                        <p><b>Step 5:</b> Paste the LinkedIn Page Id on dashboard and click on update page.</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/linkedin/socialpost-linkedin-step4.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                    <div class="linkedin-step6 mt-4">
                                                                        <p><b>Step 6:</b> Make sure to check green tick and connected on LinkedIn card</p>
                                                                        <img src="{{ asset('assets/business/social-post-steps/linkedin/socialpost-linkedin-step5.png') }}" class="w-100" alt="">
                                                                    </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="rounded alert default alert-info p-2 p-lg-3  text-warning">
                                            <h6>Please note if you have recently created your social media account it might take few days to start posting your offer to social media.</h6>
                                        </div>
                                    </div> 

                                    
                                </div>
                            </div>
                            {{-- section 4 end  --}}

                            {{-- section 5  --}}
                            <div class="tab-pane fade setting-section-tab" id="social_link_tab" role="tabpanel" aria-labelledby="social_link">
                                <div class="p-4">

                                    <div class="default alert alert-info mb-4">
                                        <p class="mb-2 lh-1"><b>Social Links</b></p>
                                        <p class="mb-0 small lh-1">Add your social media pages or account url, This links are used in offers footer for the customer to follow your business page.</p>
                                    </div>

                                    {!! Form::model($basic, ['method' => 'POST', 'route' => 'business.socialLinks',  'class'=> 'basicSettingform']) !!}
                                        <div id="social_links_">
                                            
                                            <div class="form-group mb-3">
                                                <div class="d-flex justify-content-between">
                                                    <label for="facebook_link" class="text-primary mb-0">Facebook</label> 
                                                    <a href="#" class="info-btn" data-toggle="modal" data-target="#facebook_page_modal" data-backdrop="static" data-keyboard="false"><i class="fa fa-info-circle"></i></a>
                                                </div>
                                                

                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                      <span class="input-group-text facebook-bg" >
                                                        <i class="fab fa-facebook fa-2x lh-1"></i>
                                                      </span>
                                                    </div>
                                                    {!! Form::text('facebook_link', null, array('placeholder' => 'https://facebook.com/page-or-account-url', 'class' => 'form-control', "autocomplete" => "off", "id"=>"facebook_link")) !!}
                                                </div>
                                            </div>

                                            <div class="form-group mb-3">
                                                <div class="d-flex justify-content-between">
                                                    <label for="instagram_link" class="text-primary mb-0">Instagram</label>
                                                    <a href="#" class="info-btn" data-toggle="modal" data-target="#instagram_page_modal" data-backdrop="static" data-keyboard="false"><i class="fa fa-info-circle"></i></a>
                                                </div>
                                                

                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                      <span class="input-group-text instagram-bg" >
                                                        <i class="fab fa-instagram fa-2x lh-1"></i>
                                                      </span>
                                                    </div>
                                                    {!! Form::text('instagram_link', null, array('placeholder' => 'https://instagram.com/account-url', 'class' => 'form-control', "autocomplete" => "off", "id"=>"instagram_link")) !!}
                                                </div>
                                            </div>

                                            <div class="form-group mb-3">
                                                <div class="d-flex justify-content-between">
                                                    <label for="twitter_link" class="text-primary mb-0">Twitter</label>
                                                    <a href="#" class="info-btn" data-toggle="modal" data-target="#tweet_page_modal" data-backdrop="static" data-keyboard="false"><i class="fa fa-info-circle"></i></a>
                                                </div>
                                                

                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                      <span class="input-group-text twitter-bg" >
                                                        <i class="fab fa-twitter fa-2x lh-1"></i>
                                                      </span>
                                                    </div>
                                                    {!! Form::text('twitter_link', null, array('placeholder' => 'https://twitter.com/account-url', 'class' => 'form-control', "autocomplete" => "off", "id"=>"twitter_link")) !!}
                                                </div>
                                            </div>

                                            <div class="form-group mb-3">
                                                <div class="d-flex justify-content-between">
                                                    <label for="linkedin_link" class="text-primary mb-0">LinkedIn</label>
                                                    <a href="#" class="info-btn" data-toggle="modal" data-target="#linkedin_page_modal" data-backdrop="static" data-keyboard="false"><i class="fa fa-info-circle"></i></a>
                                                </div>
                                                

                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                      <span class="input-group-text linkedin-bg" >
                                                        <i class="fab fa-linkedin fa-2x lh-1"></i>
                                                      </span>
                                                    </div>
                                                    {!! Form::text('linkedin_link', null, array('placeholder' => 'https://linkedin.com/company-url', 'class' => 'form-control', "autocomplete" => "off", "id"=>"linkedin_link")) !!}
                                                </div>
                                            </div>

                                            <div class="form-group mb-3">
                                                <div class="d-flex justify-content-between">
                                                    <label for="youtube_link" class="text-primary mb-0">YouTube</label> 
                                                    <a href="#" class="info-btn" data-toggle="modal" data-target="#youtube_url_modal" data-backdrop="static" data-keyboard="false"><i class="fa fa-info-circle"></i></a>
                                                </div>

                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                      <span class="input-group-text youtube-bg" >
                                                        <i class="fab fa-youtube fa-2x lh-1"></i>
                                                      </span>
                                                    </div>
                                                    {!! Form::text('youtube_link', null, array('placeholder' => 'https://youtube.com/channel-url', 'class' => 'form-control', "autocomplete" => "off", "id"=>"youtube_link")) !!}
                                                </div>
                                            </div>

                                            
                                            {{-- <div class="form-group mb-3">
                                                <div class="d-flex justify-content-between">
                                                    <label for="google_review_placeid" class="text-primary mb-0">Google Review</label> 
                                                    <a href="#" class="info-btn" data-toggle="modal" data-target="#google_details_modal" data-backdrop="static" data-keyboard="false"><i class="fa fa-info-circle"></i></a>
                                                </div>
                                                

                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text google_placeid-bg google_card google-review">
                                                          <img src="{{asset('assets/business/google-review.png')}}" alt="">
                                                        </span>
                                                    </div>
                                                    {!! Form::text('google_review_placeid', null, array('placeholder' => 'ChIJ339JWrTB1DsROneeiQgmhr4', 'class' => 'form-control', "autocomplete" => "off", "id"=>"google_review_placeid")) !!}
                                                </div>
                                            </div> --}}

                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary px-4 basicbtn">Save Links</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                            {{-- section 5 end  --}}

                            {{-- section 6  --}}
                            <div class="tab-pane fade setting-section-tab" id="whatsapp_setting_tab" role="tabpanel" aria-labelledby="whatsapp_setting">
                                <div class="p-4">

                                    <div class="default alert alert-info mb-4">
                                        <p class="mb-2 lh-1"><b>WhatsApp Setting</b></p>
                                        <p class="mb-0 small lh-1">Connect your WhatsApp with MouthPublicity via QR code to start sharing your business offers to your customers. We will send the offers link to your customer's WhatsApp through your WhatsApp.</p>
                                    </div>

                                    <div id="instance_key" style="display: none"></div>

                                    <div id="disconnected" style="@if($wa_session &&   $wa_session->instance_id != '') display:none @endif">
                                        <div class="d-flex flex-column mx-auto mb-4" style="width: 100%;max-width:500px;">



                                            @if(auth()->user()->is_demo == 0)
                                            <div class="">
                                                <div class="text-center mb-3" id="countdownTest">
                                                    <span>Code will change in</span> 
                                                    <b><span class="text-danger js-timeout">1:00</span> min.</b>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="wa-setting">
                                                    <div class="wa-div">
                                                        <div class="wa-qr" id="qr_code_img">
                                                            {{-- reload QR icon --}}
                                                            <div class="reload-qr">
                                                                <div class="circle-reload" data-toggle="tooltip" title="Refresh QR code">
                                                                    <i class="fa fa-redo-alt fa-3x fa-spin"></i>
                                                                </div>
                                                            </div>
                                                            {{-- QR code img tag --}}
                                                        </div>
                                                        <div id="instance_id" style="display:none"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            @else   
                                            <div class="">
                                                <div class="text-center mb-3" id="countdownTest">
                                                    <span class="text-danger">Can not scan QR in demo account.</span>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="wa-setting">
                                                    <div class="wa-div">
                                                        <div class="wa-qr" id="">
                                                            {{-- reload QR icon --}}
                                                            <img src="{{ asset('assets/img/disable-qr-code.png') }}" />
                                                            {{-- QR code img tag --}}
                                                        </div>
                                                        <div id="instance_id" style="display:none"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
    
                                            <div>
                                                <div class="card card-body p-3 mt-3">
                                                    <div class="d-flex">
                                                        <div class="mr-3">
                                                            <i class="fas fa-shield-alt mt-1 text-primary" style="font-size: 20px;"></i>
                                                        </div>
                                                        <div>
                                                            <p class="small mb-0" style="line-height: 1.7;">Your WhatsApp account will be secured with MouthPublicity as we can't read, listen or store your personal or business conversation as per our data <a href="{{url('privacy-policy')}}" target="_blank">Privacy policy</a>.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div>
                                                <h6 class="text-primary mb-4">Steps to Connect WhatsApp</h6>
    
                                                <ul class="list-unstyled list-unstyled-border mb-0">
                                                    <li class="media align-items-center">
                                                    <div class="step-num">
                                                        <p>01.</p>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="media-title lh-1">Open WhatsApp</div>
                                                        <div class="text-muted lh-1">Open WhatsApp application on your phone.</div>
                                                    </div>
                                                    </li>
                                                    <li class="media align-items-center">
                                                    <div class="step-num">
                                                        <p>02.</p>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="media-title lh-1">Select Linked Devices</div>
                                                        <div class="text-muted lh-1">Tap on 
                                                            <span class="">
                                                                <svg height="18px" viewBox="0 0 24 24" width="18px">
                                                                    <rect fill="#f2f2f2" height="24" rx="3" width="24"></rect>
                                                                    <path d="m12 15.5c.825 0 1.5.675 1.5 1.5s-.675 1.5-1.5 1.5-1.5-.675-1.5-1.5.675-1.5 1.5-1.5zm0-2c-.825 0-1.5-.675-1.5-1.5s.675-1.5 1.5-1.5 1.5.675 1.5 1.5-.675 1.5-1.5 1.5zm0-5c-.825 0-1.5-.675-1.5-1.5s.675-1.5 1.5-1.5 1.5.675 1.5 1.5-.675 1.5-1.5 1.5z" fill="#818b90"></path>
                                                                </svg>
                                                            </span> 
                                                            Menu or 
                                                            <span class="">
                                                                <svg width="18" height="18" viewBox="0 0 24 24">
                                                                    <rect fill="#F2F2F2" width="24" height="24" rx="3"></rect>
                                                                    <path d="M12 18.69c-1.08 0-2.1-.25-2.99-.71L11.43 14c.24.06.4.08.56.08.92 0 1.67-.59 1.99-1.59h4.62c-.26 3.49-3.05 6.2-6.6 6.2zm-1.04-6.67c0-.57.48-1.02 1.03-1.02.57 0 1.05.45 1.05 1.02 0 .57-.47 1.03-1.05 1.03-.54.01-1.03-.46-1.03-1.03zM5.4 12c0-2.29 1.08-4.28 2.78-5.49l2.39 4.08c-.42.42-.64.91-.64 1.44 0 .52.21 1 .65 1.44l-2.44 4C6.47 16.26 5.4 14.27 5.4 12zm8.57-.49c-.33-.97-1.08-1.54-1.99-1.54-.16 0-.32.02-.57.08L9.04 5.99c.89-.44 1.89-.69 2.96-.69 3.56 0 6.36 2.72 6.59 6.21h-4.62zM12 19.8c.22 0 .42-.02.65-.04l.44.84c.08.18.25.27.47.24.21-.03.33-.17.36-.38l.14-.93c.41-.11.82-.27 1.21-.44l.69.61c.15.15.33.17.54.07.17-.1.24-.27.2-.48l-.2-.92c.35-.24.69-.52.99-.82l.86.36c.2.08.37.05.53-.14.14-.15.15-.34.03-.52l-.5-.8c.25-.35.45-.73.63-1.12l.95.05c.21.01.37-.09.44-.29.07-.2.01-.38-.16-.51l-.73-.58c.1-.4.19-.83.22-1.27l.89-.28c.2-.07.31-.22.31-.43s-.11-.35-.31-.42l-.89-.28c-.03-.44-.12-.86-.22-1.27l.73-.59c.16-.12.22-.29.16-.5-.07-.2-.23-.31-.44-.29l-.95.04c-.18-.4-.39-.77-.63-1.12l.5-.8c.12-.17.1-.36-.03-.51-.16-.18-.33-.22-.53-.14l-.86.35c-.31-.3-.65-.58-.99-.82l.2-.91c.03-.22-.03-.4-.2-.49-.18-.1-.34-.09-.48.01l-.74.66c-.39-.18-.8-.32-1.21-.43l-.14-.93a.426.426 0 00-.36-.39c-.22-.03-.39.05-.47.22l-.44.84-.43-.02h-.22c-.22 0-.42.01-.65.03l-.44-.84c-.08-.17-.25-.25-.48-.22-.2.03-.33.17-.36.39l-.13.88c-.42.12-.83.26-1.22.44l-.69-.61c-.15-.15-.33-.17-.53-.06-.18.09-.24.26-.2.49l.2.91c-.36.24-.7.52-1 .82l-.86-.35c-.19-.09-.37-.05-.52.13-.14.15-.16.34-.04.51l.5.8c-.25.35-.45.72-.64 1.12l-.94-.04c-.21-.01-.37.1-.44.3-.07.2-.02.38.16.5l.73.59c-.1.41-.19.83-.22 1.27l-.89.29c-.21.07-.31.21-.31.42 0 .22.1.36.31.43l.89.28c.03.44.1.87.22 1.27l-.73.58c-.17.12-.22.31-.16.51.07.2.23.31.44.29l.94-.05c.18.39.39.77.63 1.12l-.5.8c-.12.18-.1.37.04.52.16.18.33.22.52.14l.86-.36c.3.31.64.58.99.82l-.2.92c-.04.22.03.39.2.49.2.1.38.08.54-.07l.69-.61c.39.17.8.33 1.21.44l.13.93c.03.21.16.35.37.39.22.03.39-.06.47-.24l.44-.84c.23.02.44.04.66.04z" fill="#818b90"></path>
                                                                </svg>
                                                            </span> 
                                                            Settings and select <b class="text-primary">Linked Devices</b>
                                                        </div>
                                                    </div>
                                                    </li>
                                                    <li class="media align-items-center">
                                                    <div class="step-num">
                                                        <p>03.</p>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="media-title lh-1">Scan QR Code</div>
                                                        <div class="text-muted lh-1">Tap on <b class="text-primary">Link a Device</b> and Point your phone to this screen to <b class="text-primary">capture the code</b></div>
                                                    </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="connected" class="p-3 rounded" style="background: #f4fff8;@if(!$wa_session ||  $wa_session->instance_id == '') display:none @endif">
                                        <div class="d-md-flex">
                                            <div class="avatar-item mb-3 mb-md-0 mr-3" style="max-width: 60px">
                                                @if(isset($wa_session->wa_avatar) && $wa_session->wa_avatar)
                                                    <img alt="image" src="{{$wa_session->wa_avatar}}" class="img-fluid" data-toggle="tooltip" title="{{ $whatsapp_num }}">
                                                @else
                                                    <img alt="image" src="{{asset('assets/img/avatar/avatar-2.png')}}" class="img-fluid" data-toggle="tooltip" title="{{ $whatsapp_num }}">
                                                @endif
                                            </div>
                                            <div>
                                                <p class="mb-2 h5"><b id="wa_number">{{ $whatsapp_num }}</b> <small id="wa_name">({{ isset($wa_session->wa_id) ? $wa_session->wa_id : '' }})</small> </p>
                                                <p class="mb-0"><i class="fa fa-wifi text-primary mr-2"></i> State: <span class="badge badge-success py-1">Connected</span></p>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    
                                </div>
                            </div>
                            {{-- section 6 end  --}}
                           
                            {{-- section 7 --}}
                            <div class="tab-pane fade setting-section-tab" id="message_route_tab" role="tabpanel" aria-labelledby="message_route">
                                <div class="p-4">

                                    <div class="default alert alert-info mb-4">
                                        <p class="mb-2 lh-1"><b>Message Routes</b></p>
                                        <p class="mb-0 small lh-1">Set your message route for every channel</p>
                                    </div>

                                    {!! Form::model($basic, ['method' => 'POST', 'route' => 'business.businessAddress',  'class'=> 'basicSettingform']) !!}
                                        <div id="channel_message_">
                                            @foreach($channels as $channel)
                                            <div class="channel_list">
                                                <div class="inner d-md-flex">
                                                    <div>
                                                        <h6 class="mb-3 mb-md-0">{{$channel->name}}</h6>
                                                    </div>

                                                    @php
                                                        $route = App\Http\Controllers\Business\RouteToggleContoller::routeDetail($channel->id, auth()->user()->id);

                                                        // dd($route->wa);
                                                    @endphp 

                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="_sms_ mr-3">
                                                            @if($channel->id != 5)
                                                            <label class="custom-switch p-0" id="{{'wa_'.$channel->id}}">
                                                                <input type="checkbox" data-toggle="toggle" name="{{ $channel->id }}_wa" value="" class="custom-switch-input" 
                                                                
                                                                @if(@$route->wa==1) checked @endif
                                                                >
                                                                <span class="custom-switch-description small mr-1 ml-0">WhatsApp</span>
                                                                <span class="custom-switch-indicator"></span>
                                                            </label>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <label class="custom-switch p-0" id="{{'sms_'.$channel->id}}">
                                                                <input type="checkbox" data-toggle="toggle"  name="{{ $channel->id }}_sms" value="" class="custom-switch-input"
                                                                
                                                                @if(@$route->sms==1) checked @endif
                                                                >
                                                                <span class="custom-switch-description small mr-1 ml-0">SMS</span>
                                                                <span class="custom-switch-indicator"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </form>
                                </div>
                            </div>
                            {{-- section 7 end  --}}

                            {{-- section 8 --}}
                            <div class="tab-pane fade setting-section-tab" id="vcard_setting_tab" role="tabpanel" aria-labelledby="vcard_setting">
                                <div class="p-4">
                                    <div class="default alert alert-info mb-4">
                                        <p class="mb-2 lh-1"><b>V-Card / Website</b></p>
                                        <p class="mb-0 small lh-1">Below is possible cases in which Vcard will be shown.</p>
                                        <ol class="vcard_redirect">
                                            <li>If master switch for a specific channel is disabled.</li>
                                            <li>When your ongoing offer expires.</li>
                                            <li>When challenges your shared with your contacts gets expired due to Offer end.</li>
                                            <li>If you have not updated your Instant Challenge Settings.</li>
                                            <li>If you have not updated your Share Challenge Settings.</li>
                                            <li>If do not have task to perform in your instant challenge.</li>
                                            <li>If you do not have your message routes enabled.</li>
                                        </ol>
                                    </div>
                                    <div>
                                        {!! Form::model($basic, ['method' => 'POST', 'route' => 'business.storeVcardDetail',  'class'=> 'basicSettingform']) !!}
                                            <div>
                                                <p class="mb-2">Select type:</p>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="vw">
                                                        <input type="radio" class="vw_input" name="vw_page" value="vcard" id="v-page" data-form="#v-page-form" {{ $basic->vcard_type=='vcard' ? 'checked' : '' }} >
                                                        <label for="v-page" class="card">
                                                            <div class="card-body">
                                                                <h6>V-card Page</h6>
                                                                <p class="mb-0 small">Choose your pre-designed V-Card page from below.</p>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="vw">
                                                        <input type="radio" class="vw_input" name="vw_page" value="webpage" id="w-page" data-form="#w-page-form" {{ $basic->vcard_type=='webpage' ? 'checked' : '' }} >
                                                        <label for="w-page" class="card">
                                                            <div class="card-body">
                                                                <h6>Website Page</h6>
                                                                <p class="mb-0 small">Set your website page url where your customer redirect to.</p>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                {{-- V-Card Form Section --}}
                                                <div id="v-page-form" class="page-form" style="display:none">
                                                    <div class="form-group">
                                                        <label class="form-label">Choose V-Card Design <span class="text-danger">*</span></label>
                                                        <div class="row gutters-sm">

                                                            @foreach ($vcard as $card)
                                                                <div class="col-sm-6 col-md-4  mb-4">
                                                                    {{-- <label class="imagecheck">
                                                                        <input name="select_v_card" type="radio" value="{{ $card->slug }}" class="imagecheck-input" {{ $card->slug==$basic->business_card_id ? 'checked' : '' }} >
                                                                        <figure class="imagecheck-figure">
                                                                            <img src="{{ asset('assets/business/vcards/'.$card->thumbnail) }}" alt="" class="imagecheck-image">
                                                                        </figure>
                                                                    </label>
                                                                    <a href="{{ route('business.vcardInfoPreview', [$card->slug]) }}" target="_blank" class="vw_page_preview">Preview</a> --}}

                                                                    {{-- New V-card function --}}
                                                                    
                                                                     
                                                                   
                                                                    <label class="imagecheck vw_page_preview">
                                                                        <input name="select_v_card" type="radio" value="{{ $card->slug }}" class="imagecheck-input" {{ $card->slug==$basic->business_card_id ? 'checked' : '' }} >
                                                                        <div class="selectable-name">
                                                                            <span>Select</span>
                                                                        </div>
                                                                    </label>
                                                                    <a href="{{ route('business.vcardInfoPreview', [$card->slug]) }}" target="_blank" class="link_preview">
                                                                        <figure class="imagecheck-figure">
                                                                            <img src="{{ asset('assets/business/vcards/'.$card->thumbnail) }}" alt="" class="imagecheck-image">
                                                                        </figure>
                                                                    </a>
                                                                </div>
                                                            @endforeach
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- END - V-Card Form Section --}}

                                                {{-- website Form Section --}}
                                                <div id="w-page-form" class="page-form" style="display:none;">
                                                    <div class="form-group">
                                                        <label>Website Page URL <span class="text-danger">*</span></label>
                                                        <input type="text" name="website_url" id="website_url" class="form-control web_url_input" placeholder="https://example.com" value="{{ $basic->webpage_url }}" >
                                                        <small>Enter your website URL where the expired offer/challenge link will be redirect.</small>
                                                    </div>
                                                </div>
                                                {{-- END - website Form Section --}}

                                                <div class="mt-3 text-right">
                                                    <button class="btn btn-primary px-4 basicbtn" type="submit">Save Details</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            {{-- section 8 end  --}}

                            {{-- section 9 --}}
                            <div class="tab-pane fade setting-section-tab" id="notification_setting_tab" role="tabpanel" aria-labelledby="notification_setting">
                                <div class="p-4">

                                    <div class="default alert alert-info mb-4">
                                        <p class="mb-2 lh-1"><b>Notifications</b></p>
                                        <p class="mb-0 small lh-1">Change your notitication settings</p>
                                    </div>

                                    {!! Form::model($basic, ['method' => 'POST', 'route' => 'business.dailyReportTime',  'class'=> 'basicSettingform']) !!}
                                        <div id="channel_message_">
                                            @foreach ($notifications as $notification)
                                            <div class="channel_list">
                                                <div class="inner row">
                                                    <div class="col-md-7">
                                                        <div>
                                                            <h6 class="mb-3 mb-md-0">{{ $notification->title }}</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="d-flex justify-content-between justify-content-md-end align-items-center">
                                                            <div class="_sms_ mr-3">

                                                                @php
                                                                $notificationToggle = App\Http\Controllers\Business\RouteToggleContoller::notificationDetail($notification->id, auth()->user()->id);
                                                            @endphp
                                                                @if ($notification->id != "")
                                                                <label class="custom-switch-notification  p-0" id="{{'wa_'.$notification->id}}">
                                                                    <input type="checkbox" data-toggle="toggle" name="{{ $notification->id }}_wa" value="" class="custom-switch-input"
                                                                    @if (@$notificationToggle->wa==1) checked @endif>
                                                                    <span class="custom-switch-description small mr-1 ml-0">WhatsApp</span>
                                                                    <span class="custom-switch-indicator"></span>
                                                                </label>
                                                                @endif
                                                                
                                                            </div>
                                                            <div>
                                                                <label class="custom-switch-notification p-0" id="{{'email_'.$notification->id }}">
                                                                    <input type="checkbox" data-toggle="toggle" name="{{ $notification->id }}_email" value="" class="custom-switch-input" @if(@$notificationToggle->email==1) checked @endif>
                                                                    <span class="custom-switch-description small mr-1 ml-0">Email</span>
                                                                    <span class="custom-switch-indicator"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            @endforeach
                                        </div>
 
                                        {{-- Daily Report time input fields start --}}
                                        @php
                                            $timingArr = [
                                                '8.00' => '8.00 AM',
                                                '9.00' => '9.00 AM',
                                                '10.00' => '10.00 AM',
                                                '11.00' => '11.00 AM',
                                                '12.00' => '12.00 PM',
                                                '13.00' => '1.00 PM',
                                                '14.00' => '2.00 PM',
                                                '15.00' => '3.00 PM',
                                                '16.00' => '4.00 PM',
                                                '17.00' => '5.00 PM',
                                                '18.00' => '6.00 PM',
                                                '19.00' => '7.00 PM',
                                                '20.00' => '8.00 PM',
                                                '21.00' => '9.00 PM',
                                                '22.00' => '10.00 PM',
                                                '23.00' => '11.00 PM',
                                            ];
                                        @endphp

                                    <div class="inner"></div>
                                    <div class="inner pb-3 m-2">
                                        <label for="daily_reporting_time" class="text-primary mb-0">{{__('Daily report timing')}} <span class="text-danger">*</span></label>
                                        <div class="input-group mt-3">
                                            
                                            <select id="daily_reporting_time" name="daily_reporting_time" class="form-control choise-groups" required>
                                                @foreach($timingArr as $keys => $timing)
                                                    <option value="{{ $keys }}" @if($basic->daily_reporting_time == $keys) selected @endif>{{ $timing }}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <button class="input-group-text btn btn-primary  text-white px-3" type="submit">Save Time</button>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- Daily Report time input fields end --}}
                                        
                                    </form>

                                    {{-- notification input fields  --}}
                                    <div class="types-to-input  blank-inputs  form-group row" style="" id="notification_number">
                                        <div class="col-md-12 col-md-8 col-form-label">
                                            <form id="notification_number_form" method="post" action="{{ route('business.storeUserMobile') }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="default alert alert-info mb-4">
                                                    <p class="mb-2 lh-1"><b>Add Number</b></p>
                                                    <p class="mb-0 small lh-1" style="color:red !important;">Here you can add up to 5 mobile numbers to whom you want to send the above notifications.</p>
                                                </div>

                                                <div class="input-group mt-3">
                                                    <input type="mobile" name="mobile" maxlength="10" class="form-control input-notification mb-2" placeholder="Enter Number...">
                                                    <div class="input-group-append">
                                                        <button class="input-group-text btn btn-primary  text-white px-3" type="submit"><i class="fa fa-plus mr-2"></i>Add</button>
                                                    </div>
                                                </div>
                                            </form>    

                                            <ul class="list-group notification_number_list mt-3">
                                                @foreach ($notification_contacts as $contact)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    {{ $contact->mobile }}
                                                    <a href="#" class="badge badge-danger badge-pill delete-item" id="{{ $contact->id }}">X</a>
                                                  </li>
                                                @endforeach
                                                
                                            </ul>
                                        </div> 
                                       
                                    </div>
                                </div>
                            </div>
                            {{-- section 9 end  --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


    <div class="modal fade" id="google-map" tabindex="-1" role="dialog" aria-labelledby="google-map-Title" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="google-map-Title">Steps to get google map link</h5>
            <button type="button" class="close google_map_btn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="registered_address-tab" data-toggle="tab" href="#registered_address" role="tab" aria-controls="registered_address" aria-selected="true">Registered Address</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#unknown_address" role="tab" aria-controls="unknown_address" aria-selected="false">Unknown Address</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-4">
                        <div class="tab-pane fade active show" id="registered_address" role="tabpanel" aria-labelledby="registered_address-tab">
                            <div class="row">
                                <p class="step_sec_head">If user have registered address.</p>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                                    <div class="mb-4">
                                        <span class="step font-weight-bold mb-3"><b>Step 1:</b></span>
                                        <p class="mb-1">Click here to visit <a href="https://www.google.co.in/maps" target="_blank">Google Map</a></p>
                                        <img src="{{ asset('assets/business/google_map_step/step1.png') }}" class="w-100">
                                    </div>
                                
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                                    <div class="mb-4">
                                        <span class="mb-0 font-weight-bold Steps">Step 2: </span>
                                        <p class="mb-1">Type registered address.</p>
                                        <img src="{{ asset('assets/business/google_map_step/step2.png') }}" class="w-100">
                                    </div>
                                </div> 
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                                    <div class="mb-4">
                                        <span class="mb-0 font-weight-bold Steps">Step 3: </span>
                                        <p class="mb-1">Click on the share button.</p>
                                        <img src="{{ asset('assets/business/google_map_step/stepnew3.png') }}" class="w-100">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                                    <div class="mb-4">
                                        <span class="mb-0 font-weight-bold Steps">Step 4: </span>
                                        <p class="mb-1">Click on the Copy Link button.</p>
                                        <img src="{{ asset('assets/business/google_map_step/stepnew4.png') }}" class="w-100">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                                    <div class="mb-4">
                                        <span class="mb-0 font-weight-bold Steps">Step 5: </span>
                                        <p class="mb-1">Paste the URL in google map link.</p>
                                        <img src="{{ asset('assets/business/google_map_step/stepnew5.png') }}" class="w-100">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="unknown_address" role="tabpanel" aria-labelledby="unknown_address-tab3">
                            <div class="row">
                                <p class="step_sec_head"> If user have unknown address.</p>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                                    <div class="mb-4">
                                        <span class="step font-weight-bold mb-3"><b>Step 1:</b></span>
                                        <p class="mb-1">Click here to visit <a href="https://www.google.co.in/maps" target="_blank">Google Map</a></p>
                                        <img src="{{ asset('assets/business/google_map_step/step1.png') }}" class="w-100">
                                    </div>
                                
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                                    <div class="mb-4">
                                        <span class="mb-0 font-weight-bold Steps">Step 2: </span>
                                        <p class="mb-1">Left click on the position where your address is located.</p>
                                        <img src="{{ asset('assets/business/google_map_step/stepnew6.png') }}" class="w-100">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                                    <div class="mb-4">
                                        <span class="mb-0 font-weight-bold Steps">Step 3: </span>
                                        <p class="mb-1">Click on the share button.</p>
                                        <img src="{{ asset('assets/business/google_map_step/stepnew7.png') }}" class="w-100">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                                    <div class="mb-4">
                                        <span class="mb-0 font-weight-bold Steps">Step 4: </span>
                                        <p class="mb-1">Click on the Copy Link button.</p>
                                        <img src="{{ asset('assets/business/google_map_step/stepnew8.png') }}" class="w-100">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                                    <div class="mb-4">
                                        <span class="mb-0 font-weight-bold Steps">Step 5: </span>
                                        <p class="mb-1">Paste the URL in google map link.</p>
                                        <img src="{{ asset('assets/business/google_map_step/stepnew5.png') }}" class="w-100">
                                    </div>
                                </div>
                            </div>
                        </div>
                     
                    </div>
                </div>

            </div>
        </div>
        </div>
    </div>

    {{--modal discription for google url--}}
    <div class="modal fade discription_modal" id="google_details_modal" tabindex="-1" role="dialog" aria-labelledby="google_details_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary text-capitalize">Steps to get Google Review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <span class="mb-0 font-weight-bold Steps">Step 1: </span>
                    <p class="mb-1">Click on the link <a href="https://developers.google.com/maps/documentation/places/web-service/place-id" target="_blank">google.com/maps</a></p>
                    <img src="{{ asset('assets/business/steps_images/google-review-step1.png') }}" class="w-100">    
                </div>
                <div class="mb-4">
                <span class="mb-0 font-weight-bold Steps">Step 2: </span>
                <p class="mb-1">Scroll down to <b>Find the ID of a particular place</b> section</p>
                <img src="{{ asset('assets/business/steps_images/google-review-step2.png') }}" class="w-100">    
                </div>
                <div class="mb-4">
                <span class="mb-0 font-weight-bold Steps">Step 3: </span>
                <p class="mb-1">Type your business location</p>
                <img src="{{ asset('assets/business/steps_images/google-review-step3.png') }}" class="w-100">    
                </div>
                <div class="mb-4">
                <span class="mb-0 font-weight-bold Steps">Step 4: </span>
                <p class="mb-1">Copy the page ID</p>
                <img src="{{ asset('assets/business/steps_images/google-review-step4.png') }}" class="w-100">    
                </div>
                <div class="mb-4">
                <span class="mb-0 font-weight-bold Steps">Step 5: </span>
                <p class="mb-1">Paste the Page ID in google review url</p>
                <img src="{{ asset('assets/business/steps_images/google-review-step-setting-page.png') }}" class="w-100">    
                </div>
            </div>
            </div>
        </div>
    </div>

    {{--modal discription for twitter tweet--}}
    <div class="modal fade discription_modal" id="tweet_page_modal" tabindex="-1" role="dialog" aria-labelledby="tweet_page_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary text-capitalize">Steps to get tweet URL</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                    <div class="mb-4">
                        <span class="step mb-3"><b>Step 1:</b></span>
                        <p class="mb-1">From Home Feed, Click on the Page Profile.</p>
                        <img src="{{ asset('assets/business/steps_images/twitter-setting-step01.png') }}" class="w-100">
                    </div>
                    {{-- <div class="card h-100 mb-0">
                        <div class="card-body">
                        
                        </div>
                    </div> --}}
                </div> 
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                    <div class="mb-4">
                        <span class="step mb-3"><b>Step 2:</b></span>
                        <p class="mb-1">Copy the URL present in searchbar.</p>
                        <img src="{{ asset('assets/business/steps_images/twitter-setting-step02.png') }}" class="w-100">
                    </div>
                    {{-- <div class="card h-100 mb-0">
                        <div class="card-body">
                        
                        </div>
                    </div> --}}
                </div> 
                
            </div>
            </div>
        </div>
    </div>

    {{--modal discription for linkedin--}}
    <div class="modal fade discription_modal" id="linkedin_page_modal" tabindex="-1" role="dialog" aria-labelledby="linkedin_page_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary text-capitalize">Steps to get Linkedin Page URL </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                    <div class="mb-4">
                        <span class="step mb-3"><b>Step 1:</b></span>
                        <p class="mb-1"> From Home Feed, Search your company name.</p>
                        <img src="{{ asset('assets/business/steps_images/linkedin-step1.png') }}" class="w-100">
                    </div>
                    {{-- <div class="card h-100 mb-0">
                        <div class="card-body">
                        
                        </div>
                    </div> --}}
                </div> 
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                    <div class="mb-4">
                        <span class="step mb-3"><b>Step 2:</b></span>
                        <p class="mb-1">Tap on the comapny name.</p>
                        <img src="{{ asset('assets/business/steps_images/linkedin-step2.png') }}" class="w-100">
                    </div>
                </div> 
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                    <div class="mb-4">
                        <span class="step mb-3"><b>Step 3:</b></span>
                        <p class="mb-1">Copy the URL Present in search bar.</p>
                        <img src="{{ asset('assets/business/steps_images/linkedin-step3.png') }}" class="w-100">
                    </div>
                </div> 
            </div>
            </div>
        </div>
    </div>

    {{--modal discription for instagram page--}}
    <div class="modal fade discription_modal" id="instagram_page_modal" tabindex="-1" role="dialog" aria-labelledby="instagram_page_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary text-capitalize">Steps to get Instagram Page URL</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                    <div class="mb-4">
                        <span class="step mb-3"><b>Step 1:</b></span>
                        <p class="mb-1"> From Home Feed, click on your profile.</p>
                        <img src="{{ asset('assets/business/steps_images/insta-step1.png') }}" class="w-100">
                    </div>
                    {{-- <div class="card h-100 mb-0">
                        <div class="card-body">
                        
                        </div>
                    </div> --}}
                </div> 
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                    <div class="mb-4">
                        <span class="step mb-3"><b>Step 2:</b></span>
                        <p class="mb-1"> Copy the URL present in searchbar.</p>
                        <img src="{{ asset('assets/business/steps_images/insta-step2.png') }}" class="w-100">
                    </div>
                    {{-- <div class="card h-100 mb-0">
                        <div class="card-body">
                        
                        </div>
                    </div> --}}
                </div> 
            </div>
            </div>
        </div>
    </div>

    {{-- modal discription for facebook Page--}}
    <div class="modal fade discription_modal" id="facebook_page_modal" tabindex="-1" role="dialog" aria-labelledby="facebook_page_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary text-capitalize">Steps to get Facebook page URL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                            <div class="mb-4">
                                <span class="step mb-3"><b>Step 1:</b></span>
                                <p class="mb-1">From your facebook page, click on your page in the bottom left-hand-side of menu.</p>
                                <img src="{{ asset('assets/business/steps_images/fb-url1.png') }}" class="w-100">
                            </div>
                            {{-- <div class="card h-100 mb-0">
                            <div class="card-body">
                                
                            </div>
                            </div> --}}
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                            <div class="mb-4">
                                <span class="step mb-3"><b>Step 2:</b></span>
                                <p class="mb-1">Copy the URL present in searchbar.</p>
                                <img src="{{ asset('assets/business/steps_images/fb-url2.png') }}" class="w-100">
                            </div>
                        
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--modal discription for youtube subscribe--}}
    <div class="modal fade discription_modal" id="youtube_url_modal" tabindex="-1" role="dialog" aria-labelledby="youtube_url_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary text-capitalize">Steps to get Youtube Channel URL</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                    <div class="mb-4">
                        <span class="step mb-3"><b>Step 1:</b></span>
                        <p class="mb-1">From Home Feed go to your profile and click on your channel.</p>
                        <img src="{{ asset('assets/business/steps_images/yt-step1.png') }}" class="w-100">
                    </div>
                    {{-- <div class="card h-100 mb-0">
                        <div class="card-body">
                        
                        </div>
                    </div> --}}
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                    <div class="mb-4">
                        <span class="step mb-3"><b>Step 2:</b></span>
                        <p class="mb-1">In channel, Click on Customise Channel</p>
                        <img src="{{ asset('assets/business/steps_images/yt-step2.png') }}" class="w-100">
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                    <div class="mb-4">
                        <span class="step mb-3"><b>Step 3:</b></span>
                        <p class="mb-1">Click on Basic Info.</p>
                        <img src="{{ asset('assets/business/steps_images/yt-step3.png') }}" class="w-100">
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                    <div class="mb-4">
                        <span class="step mb-3"><b>Step 4:</b></span>
                        <p class="mb-1">Under Channel URL copy your Channel URL.</p>
                        <img src="{{ asset('assets/business/steps_images/yt-step4.png') }}" class="w-100">
                    </div>
                </div>
                
            </div>
            </div>
        </div>
    </div>


        
    {{-- modal of Add users  start --}}
    <div class="modal fade" id="modalConnectSocialMedia" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Connecting...</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body " style="word-break:break-all" id="authConnectSocialMedia">
                    
                </div>
            </div>
        </div>
    </div>
    {{-- modal of Add users end --}}

    {{-- modal of Facebook Pages start --}}
    <form method="POST" action="{{ route('business.save-facebook-page') }}" id="facebookPagesForm">
        <div class="modal ol-modal popin" id="modalFacebookPages" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="facebookPagesLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary">Facebook Pages</h5>
                        {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> --}}
                    </div>
                    <div class="modal-body" id="facebookPages">
                        
                    </div>
                    <div class="modal-footer justify-content-start pt-0 m-0">
                        <button type="submit" class="btn btn-success mr-2 mb-2 updateFbModalBtns" >Save Page</button>

                        <a class="@if($userSocialConnection->is_facebook_auth) connected @else new_connect @endif text-decoration-none connect-to-social-media btn btn-primary m-0 mb-1 updateFbModalBtns"  data-socialAccount="facebook" href="javascript:void(0)" >
                            Add New Pages
                            <span  id="loading_icon_facebook" class="ms-2" style="display:none;">
                                <i class="fa fa-spinner fa-2x fa-spin"></i>
                            </span>
                        </a>

                        <a href="javascript:void(0)" data-dismiss="modal" class="btn btn-danger closeFbModalBtns">Close</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    {{-- modal of Facebook Pages end --}}


    {{-- modal of LinkedIn Pages start --}}
    <form method="POST" action="{{ route('business.save-linkedin-page') }}" id="linkedinPagesForm">
        <div class="modal ol-modal popin" id="modalLinkedInPages" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="facebookPagesLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary">LinkedIn Page</h5>
                        {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> --}}
                    </div>
                    <div class="modal-body" id="linkedinPages">
                        <div class="form-group mb-0">

                            <div class="d-flex justify-content-between">
                                <label for="" class="text-primary">LinkedIn Page Id</label>
                                <a href="#" class="info-btn" data-toggle="modal" data-target="#linkedin_pageid_modal" data-backdrop="static" data-keyboard="false"><i class="fa fa-info-circle"></i></a>
                            </div>

                            @php
                                $linkedInPageId="";
                                if($userSocialConnection!=NULL){
                                    $linkedInPageId = $userSocialConnection->linkedin_page_id ?? '';
                                    $linkedInPageId = $linkedInPageId != 0 ? $linkedInPageId : '';
                                }
                            @endphp

                            <input type="text" name="linkedin_page_id" id="linkedin_page_id" class="form-control" placeholder="Enter the linkedin page id" value="{{ $linkedInPageId }}">
                            <p class='error' id='error_linkedin_page' ></p>

                        </div>
                    </div>
                    <div class="modal-footer justify-content-start pt-0">
                        <button type="submit" class="btn btn-success" >Update Page</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    {{-- modal of Facebook Pages end --}}

    {{-- View Page, Profile start --}}
    <div class="modal ol-modal popin" id="showMediaModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="showMedia" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="mediaModalTitle">Media Title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 id="mediaModalValue">Media Value</h5>
                </div>
            </div>
        </div>
    </div>
    {{-- View Page, Profile End --}}



    {{-- Include Cropper-Js component --}}
    @include('components.cropperjs')

@endsection

@push('js')
    {{-- <script src="{{ asset('assets/js/form.js') }}"></script> --}}
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/input-validation.js') }}"></script>

@endpush

@section('end_body')

    {{-- @include('business.scripts.whatsapp-js') --}}
    {{-- WA API --}}
    @include('business.scripts.connection-js')
    
    @include('business.scripts.profile-setting')

    @include('business.settings.social-connections.social-connect-js')
    @include('business.settings.social-connections.social-media-modals')

    @include('business.scripts.setting-script')

    
@endsection