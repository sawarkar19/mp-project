{{-- Wizard Modal --}}
<div class="modal ol-modal popin" id="SetupWizard" tabindex="-1" role="dialog" aria-labelledby="SetupWizardTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header d-block text-center">
                <h4 class="modal-title text-primary" id="SetupWizardTitle">Setup</h4>
            </div>

            <div class="modal-body">

                <div class="wizard-main">

                    {{-- Steps --}}
                    <div class="ol-wizard-steps mb-4">
                        <ul id="progressBar" class="progressbar px-lg-5 px-0">
                            <li id="progressList_1" class="d-inline-block fw-bold progressbar-list active">
                                Business Details
                            </li>
                            <li id="progressList_2" class="d-inline-block fw-bold progressbar-list">
                                Contact Details
                            </li>
                            <li id="progressList_3" class="d-inline-block fw-bold progressbar-list">
                                Connect With Whatsapp
                            </li>
                        </ul>
                    </div>
                    {{-- Steps END --}}

                    {{-- forms --}}
                    <div class="wizard-forms" style="max-width:100%;">

                        {{-- Section 1 --}}
                        <div id="form_1" class="forms-section">
                            {{-- <div class="text-center">
                                <h5 class="text-primary mb-0">Busines Details</h5>
                                <p>Please add all required details.</p>
                            </div> --}}
                            <form action="#" id="bussiness_details_form" enctype="multipart/form-data">
                                <div class="d-block text-center">
                                    {{-- <p class="mb-0">Please enter your business details.</p> --}}
                                </div>
                                <div class="mt-4 mb-4">
                                    <div class="d-sm-flex justify-content-center justify-content-sm-start">
                                        <div class="logo-priview mb-3 mx-auto mb-sm-0">
                                            <div class="logo-wrap logo-crop-position w-100">
                                                @if ($planData['business_detail']['logo'] != '')
                                                    <img id="businesslogo_preview_oi"
                                                        src="{{ asset('assets/business/logos/' . $planData['business_detail']['logo']) }}"
                                                        class="img-fluid logo_path" alt="">
                                                @else
                                                    <img id="businesslogo_preview_oi" src=""
                                                        class="img-fluid logo_path" alt=""
                                                        style="display: none">
                                                @endif

                                            </div>
                                            {{-- <i class="fa fa-times remove-business-logo" id="removeLogo" aria-hidden="true" data-toggle="tooltip" title="Remove Logo"></i> --}}
                                        </div>
                                        <div class="w-75 text-center text-sm-left mx-sm-0 mx-auto">
                                            <div class="form-group mb-0 pl-md-4">
                                                <label for="bl" class="text-primary mb-0 lh-1">

                                                    @if ($planData['business_detail']['logo'] != '')
                                                        Update Logo
                                                    @else
                                                        Select Logo
                                                    @endif
                                                    <small class="text-dark">({{ __('Optional') }})</small>
                                                </label>
                                                <div class="small mb-2 text-secondary">Please select <span>PNG</span>,
                                                    <span>JPG</span>, and <span>JPEG</span> image, Max file size
                                                    <span>1MB</span>, and Max image width <span>512px</span>.
                                                </div>
                                                <input type="file" name="logo" accept="image/png, image/jpeg"
                                                    class="form-control d-none img-preview-oi" id="wz-logo"
                                                    placeholder="Select your business logo">
                                                <button class="btn btn-sm btn-primary px-3"
                                                    onclick="$('#wz-logo').click();return false;">Choose Logo</button>
                                                <input type="hidden" name="imagestring" id="imagestring"
                                                    value="" />
                                                <span class="error" id="logo_size" style="display: none;"></span>
                                                <span class="error" id="logo_type" style="display: none;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">

                                    <label for="business_name" class="text-primary mb-0">{{ __('Business Name') }} <span
                                            class="text-danger">*</span></label>
                                    {!! Form::text('business_name', null, [
                                        'placeholder' => 'Enter the name of your Business',
                                        'onkeydown' => 'return /[a-z,0-9 ]/i.test(event.key)',
                                        'class' => 'form-control two-space-validation char-spcs-validation',
                                        'id' => 'wizard_business_name',
                                        'autocomplete' => 'off',
                                        'required',
                                        'maxlength' => '120',
                                    ]) !!}

                                    <span class="error" id="business_name" style="display: none;"></span>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="tag_line" class="text-primary mb-0">{{ __('Tag Line') }} <small
                                            class="text-dark">({{ __('Optional') }})</small></label>
                                    {!! Form::text('tag_line', null, [
                                        'placeholder' => 'Enter tag line here',
                                        'class' => 'form-control',
                                        'autocomplete' => 'off',
                                        'id' => 'tag_line',
                                        'maxlength' => '120',
                                    ]) !!}

                                    <span class="error" id="tags_lines" style="display: none;"></span>
                                </div>
                            </form>
                        </div>

                        {{-- section 2 --}}
                        <div id="form_2" class="forms-section hide-sec">
                            {{-- <div class="text-center">
                                <h5 class="text-primary mb-0">Contact Details</h5>
                                <p>Please add all required details.</p>
                            </div> --}}
                            <form action="#" id="contact_details_form">
                                <div class="d-block text-center mb-3">
                                    <p class="mb-0">Following details will be visible to your customers. Please modify
                                        if you want otherwise you can change it later on in the settings.</p>
                                </div>
                                <div id="address_">

                                    <div class="form-group mb-3">
                                        <label for="register_number" class="text-primary mb-0">Registered Number</label>
                                        {!! Form::tel('register_number', null, [
                                            'placeholder' => 'Enter you resister number...',
                                            'onkeydown' => 'return isNumberKey(event)',
                                            'maxlength' => '10',
                                            'class' => 'form-control number-validation',
                                            // 'autocomplete' => 'off',
                                            'id' => 'register_number',
                                            'disabled',
                                            'pattern' => '[6789][0-9]{9}',
                                        ]) !!}
                                    </div>

                                    <div class="form-group mb-3 mr-2">
                                        <input type="checkbox" id="checkbox" name="checkbox" class="check1 mr-2"> <span
                                            id="check" class="text-primary mb-0" style="cursor: context-menu">Use
                                            registered number
                                            as bussiness number</span>
                                    </div>

                                    <div class="form-group mb-3" id="showNumber">
                                        <label for="call_number" class="text-primary mb-0">Business Number <span
                                                class="text-danger">*</span></label>
                                        {!! Form::tel('call_number', null, [
                                            'placeholder' => 'Enter you business number...',
                                            'onkeydown' => 'return isNumberKey(event)',
                                            'maxlength' => '10',
                                            'class' => 'form-control number-validation',
                                            'autocomplete' => 'off',
                                            'id' => 'call_number',
                                            'required',
                                            'pattern' => '[6789][0-9]{9}',
                                        ]) !!}

                                        <span class="error" id="calls_numbers" style="display: none;"></span>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="address_line_1" class="text-primary mb-0">Address Line 1 <span
                                                class="text-danger">*</span></label>
                                        {!! Form::text('address_line_1', null, [
                                            'placeholder' => 'Enter Address line 1',
                                            'onkeydown' => 'return /[a-z,0-9, ]/i.test(event.key)',
                                            'class' => 'form-control',
                                            'autocomplete' => 'off',
                                            'id' => 'address_line_1',
                                            'required',
                                        ]) !!}

                                        <span class="error" id="address_1" style="display: none;"></span>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="address_line_2" class="text-primary mb-0">Address Line 2 <small
                                                class="text-dark">({{ __('Optional') }})</small></label>
                                        {!! Form::text('address_line_2', null, [
                                            'placeholder' => 'Enter Address line 2',
                                            'onkeydown' => 'return /[a-z,0-9, ]/i.test(event.key)',
                                            'class' => 'form-control',
                                            'autocomplete' => 'off',
                                            'id' => 'address_line_2',
                                        ]) !!}

                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label for="pincode_id" class="text-primary mb-0">Pin Code <span
                                                        class="text-danger">*</span></label>
                                                {!! Form::text('pincode', null, [
                                                    'placeholder' => 'Area Pin Code',
                                                    'onkeydown' => 'return isNumberKey(event)',
                                                    'class' => 'form-control',
                                                    'autocomplete' => 'off',
                                                    'id' => 'pincode_id',
                                                    'maxlength' => '6',
                                                ]) !!}

                                                <span class="error" id="pincode" style="display: none;"></span>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label for="city" class="text-primary mb-0">City <span
                                                        class="text-danger">*</span></label>
                                                {!! Form::text('city', null, [
                                                    'placeholder' => 'Enter City Name',
                                                    'onkeydown' => 'return /[a-z, ]/i.test(event.key)',
                                                    'class' => 'form-control  three-space-validation char-spcs-validation',
                                                    'id' => 'city',
                                                    'autocomplete' => 'off',
                                                    'required',
                                                ]) !!}

                                                <span class="error" id="cityname" style="display: none;"></span>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label for="state" class="text-primary mb-0">State <span
                                                        class="text-danger">*</span></label>
                                                <select name="state" id="wizardState" class="form-control">
                                                    {{-- @foreach ($states as $state)
                                                    <option value="{{ $state->name }}" @if ($basic->state == $state->name) selected @endif>{{ $state->name }}</option>
                                                @endforeach --}}
                                                </select>
                                                <!-- {!! Form::text('state', null, [
                                                    'placeholder' => 'Enter State Name',
                                                    'onkeydown' => 'return /[a-z, ]/i.test(event.key)',
                                                    'class' => 'form-control  three-space-validation char-spcs-validation',
                                                    'id' => 'state',
                                                    'required',
                                                ]) !!} -->

                                                <span class="error" id="state_id" style="display: none;"></span>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group mb-3">
                                                <label for="country" class="text-primary mb-0">Country</label>
                                                {!! Form::text('country', 'India', ['class' => 'form-control', 'id' => 'country', 'readonly' => '']) !!}
                                                <span class="error" id="country_id" style="display: none;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- section 3 --}}
                        <div id="form_3" class="form-section hide-sec">

                            <div class="p-4">

                                <div class="default alert alert-info mb-4">
                                    <p class="mb-2 lh-1"><b>WhatsApp Setting</b></p>
                                    <p class="mb-0 small lh-1">Connect your WhatsApp with MouthPublicity via QR code
                                        to start sharing your business offers to your customers. We will send the
                                        offers link to your customers WhatsApp through your WhatsApp.</p>
                                </div>

                                <div id="instance_key" style="display: none"></div>

                                <div id="disconnected" style="@if ($planData['wa_session'] && $planData['wa_session']->instance_id != '') display:none @endif">
                                    <div class="row mb-4">

                                        <div class="col-md-6">
                                            @if (auth()->user()->is_demo == 0)
                                                <div class="">
                                                    <div class="text-center mb-3" id="countdownTest">
                                                        <span>Code will change in</span>
                                                        <b><span class="text-danger js-timeout">1:00</span>
                                                            min.</b>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="wa-setting">
                                                        <div class="wa-div">
                                                            <div class="wa-qr" id="qr_code_img">
                                                                {{-- reload QR icon --}}
                                                                <div class="reload-qr">
                                                                    <div class="circle-reload" data-toggle="tooltip"
                                                                        title="Refresh QR code">
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
                                                        <span class="text-danger">Can not scan QR in demo
                                                            account.</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="wa-setting">
                                                        <div class="wa-div">
                                                            <div class="wa-qr" id="">
                                                                {{-- reload QR icon --}}
                                                                <img
                                                                    src="{{ asset('assets/img/disable-qr-code.png') }}" />
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
                                                            <i class="fas fa-shield-alt mt-1 text-primary"
                                                                style="font-size: 20px;"></i>
                                                        </div>
                                                        <div>
                                                            <p class="small mb-0" style="line-height: 1.7;">Your
                                                                WhatsApp account will be secured with MouthPublicity
                                                                as
                                                                we cant read, listen or store your personal or
                                                                business
                                                                conversation as per our data <a
                                                                    href="{{ url('privacy-policy') }}"
                                                                    target="_blank">Privacy policy</a>.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <h6 class="text-primary mb-4">Steps to Connect WhatsApp</h6>

                                            <ul class="list-unstyled list-unstyled-border mb-0">
                                                <li class="media align-items-center">
                                                    <div class="step-num">
                                                        <p>01.</p>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="media-title lh-1">Open WhatsApp</div>
                                                        <div class="text-muted lh-1">Open WhatsApp application on
                                                            your phone.</div>
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
                                                                <svg height="18px" viewBox="0 0 24 24"
                                                                    width="18px">
                                                                    <rect fill="#f2f2f2" height="24"
                                                                        rx="3" width="24"></rect>
                                                                    <path
                                                                        d="m12 15.5c.825 0 1.5.675 1.5 1.5s-.675 1.5-1.5 1.5-1.5-.675-1.5-1.5.675-1.5 1.5-1.5zm0-2c-.825 0-1.5-.675-1.5-1.5s.675-1.5 1.5-1.5 1.5.675 1.5 1.5-.675 1.5-1.5 1.5zm0-5c-.825 0-1.5-.675-1.5-1.5s.675-1.5 1.5-1.5 1.5.675 1.5 1.5-.675 1.5-1.5 1.5z"
                                                                        fill="#818b90"></path>
                                                                </svg>
                                                            </span>
                                                            Menu or
                                                            <span class="">
                                                                <svg width="18" height="18"
                                                                    viewBox="0 0 24 24">
                                                                    <rect fill="#F2F2F2" width="24"
                                                                        height="24" rx="3"></rect>
                                                                    <path
                                                                        d="M12 18.69c-1.08 0-2.1-.25-2.99-.71L11.43 14c.24.06.4.08.56.08.92 0 1.67-.59 1.99-1.59h4.62c-.26 3.49-3.05 6.2-6.6 6.2zm-1.04-6.67c0-.57.48-1.02 1.03-1.02.57 0 1.05.45 1.05 1.02 0 .57-.47 1.03-1.05 1.03-.54.01-1.03-.46-1.03-1.03zM5.4 12c0-2.29 1.08-4.28 2.78-5.49l2.39 4.08c-.42.42-.64.91-.64 1.44 0 .52.21 1 .65 1.44l-2.44 4C6.47 16.26 5.4 14.27 5.4 12zm8.57-.49c-.33-.97-1.08-1.54-1.99-1.54-.16 0-.32.02-.57.08L9.04 5.99c.89-.44 1.89-.69 2.96-.69 3.56 0 6.36 2.72 6.59 6.21h-4.62zM12 19.8c.22 0 .42-.02.65-.04l.44.84c.08.18.25.27.47.24.21-.03.33-.17.36-.38l.14-.93c.41-.11.82-.27 1.21-.44l.69.61c.15.15.33.17.54.07.17-.1.24-.27.2-.48l-.2-.92c.35-.24.69-.52.99-.82l.86.36c.2.08.37.05.53-.14.14-.15.15-.34.03-.52l-.5-.8c.25-.35.45-.73.63-1.12l.95.05c.21.01.37-.09.44-.29.07-.2.01-.38-.16-.51l-.73-.58c.1-.4.19-.83.22-1.27l.89-.28c.2-.07.31-.22.31-.43s-.11-.35-.31-.42l-.89-.28c-.03-.44-.12-.86-.22-1.27l.73-.59c.16-.12.22-.29.16-.5-.07-.2-.23-.31-.44-.29l-.95.04c-.18-.4-.39-.77-.63-1.12l.5-.8c.12-.17.1-.36-.03-.51-.16-.18-.33-.22-.53-.14l-.86.35c-.31-.3-.65-.58-.99-.82l.2-.91c.03-.22-.03-.4-.2-.49-.18-.1-.34-.09-.48.01l-.74.66c-.39-.18-.8-.32-1.21-.43l-.14-.93a.426.426 0 00-.36-.39c-.22-.03-.39.05-.47.22l-.44.84-.43-.02h-.22c-.22 0-.42.01-.65.03l-.44-.84c-.08-.17-.25-.25-.48-.22-.2.03-.33.17-.36.39l-.13.88c-.42.12-.83.26-1.22.44l-.69-.61c-.15-.15-.33-.17-.53-.06-.18.09-.24.26-.2.49l.2.91c-.36.24-.7.52-1 .82l-.86-.35c-.19-.09-.37-.05-.52.13-.14.15-.16.34-.04.51l.5.8c-.25.35-.45.72-.64 1.12l-.94-.04c-.21-.01-.37.1-.44.3-.07.2-.02.38.16.5l.73.59c-.1.41-.19.83-.22 1.27l-.89.29c-.21.07-.31.21-.31.42 0 .22.1.36.31.43l.89.28c.03.44.1.87.22 1.27l-.73.58c-.17.12-.22.31-.16.51.07.2.23.31.44.29l.94-.05c.18.39.39.77.63 1.12l-.5.8c-.12.18-.1.37.04.52.16.18.33.22.52.14l.86-.36c.3.31.64.58.99.82l-.2.92c-.04.22.03.39.2.49.2.1.38.08.54-.07l.69-.61c.39.17.8.33 1.21.44l.13.93c.03.21.16.35.37.39.22.03.39-.06.47-.24l.44-.84c.23.02.44.04.66.04z"
                                                                        fill="#818b90"></path>
                                                                </svg>
                                                            </span>
                                                            Settings and select <b class="text-primary">Linked
                                                                Devices</b>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="media align-items-center">
                                                    <div class="step-num">
                                                        <p>03.</p>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="media-title lh-1">Scan QR Code</div>
                                                        <div class="text-muted lh-1">Tap on <b
                                                                class="text-primary">Link a
                                                                Device</b> and Point
                                                            your phone to this screen to <b
                                                                class="text-primary">capture
                                                                the code</b></div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div id="connected" class="p-3 rounded"
                                    style="background: #f4fff8;@if (!$planData['wa_session'] || $planData['wa_session']->instance_id == '') display:none @endif">
                                    <div class="d-md-flex">
                                        <div class="avatar-item mb-3 mb-md-0 mr-3" style="max-width: 60px">
                                            @if (isset($planData['wa_session']->wa_avatar) && $planData['wa_session']->wa_avatar)
                                                <img alt="image" id="wa_avatar"
                                                    src="{{ $planData['wa_session']->wa_avatar }}"
                                                    class="img-fluid whatsapp_num" data-toggle="tooltip"
                                                    title="{{ $planData['whatsapp_num'] }}">
                                            @else
                                                <img alt="image"
                                                    src="{{ asset('assets/img/avatar/avatar-2.png') }}"
                                                    class="img-fluid" data-toggle="tooltip"
                                                    title="{{ $planData['whatsapp_num'] }}">
                                            @endif
                                        </div>
                                        <div>
                                            <p class="mb-2 h5"><b id="wa_number">{{ $planData['whatsapp_num'] }}</b>
                                                <small
                                                    id="wa_name">({{ isset($planData['wa_session']->wa_id) ? $planData['wa_session']->wa_id : '' }})</small>
                                            </p>
                                            <p class="mb-0"><i class="fa fa-wifi text-primary mr-2"></i> State:
                                                <span class="badge badge-success py-1">Connected</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    {{-- forms END --}}

                    {{-- <div id="wizard_msg"></div>
                    <div id="wizard_msg1"></div>
                    <div id="wizard_msg2"></div> --}}

                </div>

            </div>
            {{-- Next Button --}}
            <div class="modal-footer bg-light justify-content-center py-2">
                <button type="button" data-current-section="#form_1" id="save_next"
                    class="btn btn-sm btn-success px-3">Save & Next</button>
                <button type="button" data-current-section="#form_2" id="save_next_2"
                    class="btn btn-sm btn-success px-3" style="display:none;">Save & Next</button>
                <button type="button" data-current-section="#form_3" id="finish_setup"
                    class="btn btn-sm btn-success px-3" style="display:none;">Finish Setup</button>
            </div>

        </div>
    </div>
</div>
{{-- Wizard Modal End  --}}

<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
{{-- @include('business.wizard.whatsapp-wizard-js'); --}}

{{-- WA API --}}
@include('business.wizard.wapost-whatsapp-wizard-js');

<script>
    $(document).ready(function() {

        getStates();

        function getStates() {

            $.ajax({
                url: '{{ URL::to('business/getStates') }}',
                type: 'GET',
                dataType: "JSON",
                success: function(response) {
                    // Add response in Modal body
                    $("#wizardState").html('<option value="">{{ __('Select State') }}</option>');
                    $("#wizardState").append(response);
                }
            });
        }

        /*=================modal popup script================= */
        $('#SetupWizard').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });


        /* ===================wizard script=================== */

        /* hidden things */
        $(".hide-sec").hide();

        /* Next button click */
        $("#save_next").on("click", function() {

            /* [ADD VALIDATION HERE] */
            // var validate = $(this).parents(".row").find(".card").hasClass("active-card");
            var validate = false;
            var msg = "";
            var business_name = $("#wizard_business_name").val().trim();
            if (business_name == "" || business_name.length < 5) {
                validate = false;
                if (business_name == "") {
                    msg = "{{ __('Please enter business name') }}";
                    $("#business_name").text(msg).show();
                } else if (business_name.length < 5) {
                    msg = "{{ __('Business name must me more than 5 character') }}";
                    $("#business_name").text(msg).show();
                }

            } else {
                $("#business_name").text(msg).hide();
                validate = true;
            }

            /* Check required validations and move to next */
            if (validate) {
                var CSRF_TOKEN = "{{ csrf_token() }}";

                var formData = new FormData($('#bussiness_details_form')[0]);

                // Attach file
                // formData.append('image', $('#wz-logo')[0].files[0]);
                // formData.append('business_name', $('#wizard_business_name').val());
                // formData.append('tag_line', $('#tag_line').val());
                formData.append("_token", CSRF_TOKEN);

                $.ajax({
                    url: '{{ URL::to('business/business-detail-wizard') }}',
                    type: 'POST',
                    dataType: "JSON",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        // console.log(response, "response form1");
                        // Add response in Modal body
                        if (response.status == true) {
                            /* Change progress bar status */
                            $("#progressBar").find(".active").removeClass("active")
                                .addClass("done").next().addClass("active");

                            /* Hide error message if any */
                            $("#wizard_msg").empty();

                            /* hide current section and show next */
                            var getCurrentSection = $('#form_1');
                            var getNextSection = $("#form_2");
                            getCurrentSection.fadeOut("fast", function() {
                                getNextSection.fadeIn("fast");
                            });

                            /* change button "data-current-section" to next section ID */
                            $("#save_next").hide();
                            $("#save_next_2").show();

                            if ($(".wizard-forms").children("div.forms-section").last()
                                .attr('id') === getNextSection.attr("id")) {

                                $("#call_number").val("");
                                $("#address_line_1").val("");
                                $("#address_line_2").val("");
                                $("#pincode_id").val("");
                                $("#city").val("");
                                $("#wizardState").val("");

                                getloginUserDetails();
                            }

                            /* Update Logo */
                            var old_logo = $('.sidebar-logo').attr('src');
                            var new_logo = '{{ asset('assets/business/logos') }}/' +
                                response.data.logo;

                            if (!old_logo) {
                                var logo_tag =
                                    '<div class="sidebar-logo-round"><img src="' +
                                    new_logo +
                                    '" class="sidebar-logo" id="img" alt=""></div>';

                                $('.business-detail-sec').prepend(logo_tag);
                            } else {
                                $('.sidebar-logo').attr('src', new_logo);
                            }

                            $('.customer-logo-text').text(response.data.business_name);
                        } else {
                            alert(response.message);
                        }
                    }
                });

            } else {
                /* if not validate data then show error message */

                // $("#wizard_msg").html("<div class='alert alert-danger'>" + msg + "</div>");
            }
        });

        getloginUserDetails();

        function getloginUserDetails() {
            $.ajax({
                url: '{{ URL::to('business/getUserDetails') }}',
                type: 'GET',
                dataType: "JSON",
                success: function(response) {
                    // Add response in Modal body
                    $("#wizard_business_name").val(response.businessDetail.business_name);
                    $("#tag_line").val(response.businessDetail.tag_line);
                    $("#register_number").val(response.userNumber);
                    $("#address_line_1").val(response.businessDetail.address_line_1);
                    $("#address_line_2").val(response.businessDetail.address_line_2);
                    $("#pincode_id").val(response.businessDetail.pincode);
                    $("#city").val(response.businessDetail.city);
                    $("#wizardState").val(response.businessDetail.state);
                }
            });
        }


        /* Next button contact details click */
        $(".hide-sec").hide();
        $(document).on("click", "#save_next_2", function() {

            /* [ADD VALIDATION HERE] */
            // var validate = $(this).parents(".row").find(".card").hasClass("active-card");
            var validate1 = true;
            var msg1 = "";
            var msg2 = "";
            var call_number = $("#call_number").val().trim();
            var address_line_1 = $("#address_line_1").val().trim();
            var address_line_2 = $("#address_line_2").val().trim();
            var pincode = $("#pincode_id").val().trim();
            var city = $("#city").val().trim();
            var state = $("#wizardState").val();
            var country = $("#country").val().trim();

            if (call_number.length != 10) {
                validate1 = false;
                msg1 = "{{ __('Please enter 10 digit business number') }}";
                $("#calls_numbers").text(msg1).show();

            } else {
                $("#calls_numbers").text(msg1).hide();
            }

            if (address_line_1 == "") {
                validate1 = false;
                msg1 = "{{ __('Please enter address') }}";
                $("#address_1").text(msg1).show();
            } else {
                $("#address_1").text(msg1).hide();
            }

            if (pincode == "" || pincode.length != 6) {
                validate1 = false;

                if (pincode == "") {
                    msg1 = "{{ __('Please enter pincode') }}";
                    $("#pincode").text(msg1).show();
                } else if (pincode.length != 6) {
                    msg2 = "{{ __('Please enter valid pincode') }}";
                    $("#pincode").text(msg2).show();
                }

            } else {
                $("#pincode").text(msg1).hide();
                $("#pincode").text(msg2).hide();
            }

            if (city == "") {
                validate1 = false;
                msg1 = "{{ __('Please enter city name') }}";
                $("#cityname").text(msg1).show();
            } else {
                $("#cityname").text(msg1).hide();
            }

            if (state == "") {
                validate1 = false;
                msg1 = "{{ __('Please enter state name') }}";
                $("#state_id").text(msg1).show();
            } else {
                $("#state_id").text(msg1).hide();
            }

            if (country == "") {
                validate1 = false;
                msg1 = "{{ __('Please enter country name') }}";
                $("#country_id").text(msg1).show();
            } else {
                $("#country_id").text(msg1).hide();
            }

            /* Check required validations and move to next */
            if (validate1 == true) {
                var CSRF_TOKEN = "{{ csrf_token() }}";

                var formData = new FormData($('#contact_details_form')[0]);

                // Attach file
                // formData.append('image', $('#wz-logo')[0].files[0]);
                // formData.append('business_name', $('#wizard_business_name').val());
                // formData.append('tag_line', $('#tag_line').val());
                formData.append("_token", CSRF_TOKEN);

                $.ajax({
                    url: '{{ URL::to('business/contact-detail-wizard') }}',
                    type: 'POST',
                    dataType: "JSON",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        // Add response in Modal body
                        if (response.status == true) {
                            // console.log(response, "response ok");
                            /* Change progress bar status */
                            $("#progressBar").find(".active").removeClass("active")
                                .addClass("done").next().addClass("active");

                            /* Hide error message if any */
                            $("#wizard_msg1").empty();

                            /* hide current section and show next */
                            var getCurrentSection1 = $('#form_2');
                            var getNextSection1 = $("#form_3");
                            getCurrentSection1.fadeOut("fast", function() {
                                getNextSection1.fadeIn("fast");
                            });

                            /* change button "data-current-section" to next section ID */
                            $("#save_next_2").hide();
                            $("#finish_setup").show();

                            if ($(".wizard-forms").children("div.forms-section").last()
                                .attr('id') === getNextSection1.attr("id")) {
                                // whatsappSettings();
                                FinishSetup();
                            }
                        } else {
                            alert(response.message);
                        }
                    }
                });

            } else {
                /* if not validate data then show error message */
                // $("#wizard_msg").html("<div class='alert alert-danger'>Please fill all required fields, only then you can move further!</div>");
                // $("#wizard_msg1").html("<div class='alert alert-danger'>" + msg1 + "</div>");
            }
        });


        // whatsappSettings();
        // var waSession = [];

        // function whatsappSettings() {
        //     $.ajax({
        //         url: '{{ URL::to('business/whatsapp-settings') }}',
        //         type: 'GET',
        //         dataType: "JSON",
        //         success: function(response) {
        //             // Add response in Modal body
        //             waSession.push(response);
        //             if (response.wa_session != null) {
        //                 $("#wa_number").val(response.wa_session.wa_number);
        //                 $(".wa_name").val(response.wa_session.wa_name);
        //                 $("#wa_avatar").value(response.wa_session.wa_avatar);
        //             }
        //         }
        //     });
        // }


        /* Finish Setup */
        $(document).on("click", "#finish_setup", function() {
            /* AJAX HERE */
            // alert('Yo...');
            $("#wizard_msg2").html(" ");
            var validate2 = false;
            var msg2 = "";

            if (validate2 == false) {

                $.ajax({
                    url: '{{ URL::to('business/finish-setup') }}',
                    type: 'GET',
                    dataType: "JSON",
                    success: function(response) {
                        // Add response in Modal body
                        // console.log(response);
                        if (response.status == true) {
                            $('#SetupWizard').modal('hide');

                            /* Setup complete Success message code (SweetAlert Popup) */
                            var redirect_url = "{{ url('business/dashboard') }}";
                            const successSetupMsg = Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-primary px-3 mx-1 mb-4',
                                    cancelButton: 'btn btn-sm btn-outline-primary px-3 mx-1 mb-4'
                                },
                                buttonsStyling: false
                            });
                            successSetupMsg.fire({
                                title: 'Setup Complete',
                                text: "Your business settings has been updated. ",
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonText: 'Dasboard',
                                cancelButtonText: 'Setup Other Settings',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    redirect_url =
                                        "{{ url('business/dashboard') }}";
                                } else if (result.dismiss === Swal.DismissReason
                                    .cancel) {
                                    redirect_url =
                                        "{{ url('business/settings') }}";
                                }
                                window.location.replace(redirect_url);
                            });
                            /* END */
                        } else {
                            alert(response.message);
                        }
                    }
                });

            } else {
                /* if not validate data then show error message */
                // $("#wizard_msg1").html("<div class='alert alert-danger'>Please fill all required fields, only then you can move further!</div>");
                // $("#wizard_msg2").html("<div class='alert alert-danger'>" + msg2 + "</div>");
            }

        });

        $("#wz-logo").change(function() {
            readURL(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                $("#overlay").fadeIn(300);
                reader.onload = function(e) {
                    $("#overlay").fadeOut(300);
                    $('.logo_path').attr('src', e.target.result);
                    $("#businesslogo_preview_oi").css("display", "block");
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#removeLogo").on("click", function() {
            $('.logo_path').attr('src', "");
        });

    });

    // $(document).ready(function() {

    //     $('input[name="chkNumber"]').click(function() {

    //         if ($(this).is(':checked')) {
    //             var number = $('#wa_number').text();
    //             if (number == '') {
    //                 Sweet('error', 'Scan QR to use Whatsapp number as Calling number!');
    //                 return false;
    //             }
    //             number = number.slice(2);

    //             $(this).prop('checked', true); // Checks it

    //             $('#call_number').val(number);
    //             $('#call_number').prop("disabled", true);
    //         } else {
    //             $(this).prop('checked', false); // Unchecks it
    //             $('#call_number').val('');
    //             $('#call_number').prop("disabled", false);
    //         }

    //     });
    //     // console.log(window.location.href.indexOf("wa"));
    // });

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    /* register number use as business number start*/
    $(function() {
        $(checkbox).click(function() {
            if ($('#checkbox').is(':checked')) {
                var text1 = document.getElementById("register_number").value;
                var text2 = document.getElementById("call_number").value = text1;
                $('#showNumber').find('input').prop('readonly', true);
            } else {
                $('#showNumber').find('input').prop('readonly', false);
            }
        });
    });

    $(function() {
        $(check).click(function() {
            var checked = $('#checkbox').is(':checked');
            if (checked == false) {
                $('#checkbox').prop('checked', true);
                $('#showNumber').find('input').prop('readonly', true);
                var text1 = document.getElementById("register_number").value;
                var text2 = document.getElementById("call_number").value = text1;
            } else {
                $('#checkbox').prop('checked', false);
                $('#showNumber').find('input').prop('readonly', false);
            }
        });
    });
    /* register number use as business number end*/

    /* image validation start */
    $("#wz-logo").each(function() {
        // $('#overlay').fadeIn(300);
        $this = $(this), $this.on("change", function() {
            msg = "{{ __('File size too large! Please upload less than 1MB') }}";
            message = "{{ __('This type of files are not allowed!') }}";

            $("#logo_type").text(message).hide();
            $("#logo_size").text(msg).hide();

            var t = $this[0].files[0].size,
                h = ($this[0].files[0].type, $this[0].files[0].name),
                i = h.substring(h.lastIndexOf(".") + 1);
             validExtensions = ["jpg", "jpeg", "png"], -1 == $.inArray(i, validExtensions) ? (
                $("#logo_type").text(message).show(), this.value = "", !1) : !(t >
                1048576) || ($("#logo_size").text(msg).show(), this.value = "",
                    !1)        
        })
    });
    /* image validation end */
</script>
