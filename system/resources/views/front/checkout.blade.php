@extends('layouts.front')
@section('title', 'Checkout | MouthPublicity.io')

@section('end_head')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<style>
    .summary{
        position: relative;
        width: 100%;
        background: #FFF;
        border-radius: 8px;
    }
    .summary::before{
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        /*background:var(--color-thm-shd);*/
        /*background: #e5e5e5;*/
        opacity: 0.3;
        z-index: 1;
        transform: rotate(180deg);
        border-radius: 8px;
    }
    .summary .sm_inner{
        position: relative;
        z-index: 2;
    }
    .summery_upper {
        color: #fff;
    }
    .text-custom {
        color: #e3dcdc;
    }
    .oplk-backgroundCustom{
        background: rgb(0 233 255 / 90%);
    }
    .pd_custom{
        padding: 3em;
    }

    .billing_type_checks{
        position: relative;
        max-width: 400px;
    }
    .billing_type_checks .list-group-item{
        background-color: rgb(255 255 255 / 87%);
        padding: 1em;
    }
    .billing_type_checks .list-group-item:first-child{
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }
    .billing_type_checks .list-group-item:last-child{
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
    }
    .billing_type_checks .form-check{
        margin-bottom: 0px;
        min-height: auto;
    }
    .billing_type_checks .form-check > .form-check-input{
        margin-top: 0;
    }
    .billing_type_checks .form-check > .form-check-label{
        line-height: 1;
        font-family: var(--font-h1);
        display: block;
        /* color: var(--color-thm-lth); */
    }
    .price_mt,
    .price_yr{
        font-size: 16px;
        font-weight: bold;
    }

    .bifurcation{
        position: relative;
        width: 100%;
        max-width: 400px;
    }
    .checkout_rf{
        position: relative;
        width: 100%;
        max-width: 450px;
        margin: auto;
    }
    .form-select{
        padding: 9px 0.5em;
        border: 0.075em solid #ddd;
        border-radius: 0.5em;
        color: #adafca;
    }
    
    .form-row {
      display: flex;
      margin: 20px 0;
      position: relative;
    }
    .form-row > span {
      background: #fff;
      color: #adafca;
      display: inline-block;
      font-weight: 400;
      left: 1em;
      padding: 0 0.5em;
      position: absolute;
      pointer-events: none;
      transform: translatey(-50%);
      top: 50%;
      border-radius: 7px;
      transition: all 300ms ease;
      -webkit-user-select: none;
         -moz-user-select: none;
          -ms-user-select: none;
              user-select: none;
    }
    .form-row > input {
      border-radius: 0.5em;
      font-family: inherit;
      padding: 6px 0.5em;
      width: 100%;
    }
    .form-row > input {
      font-weight: bold;
      transition: 100ms ease all;
      width: 100%;
    }
    .form-row > input{
      border: 0.075em solid #ddd;
    }
    .form-row > input:valid + span {
      top: 0;
      font-size: 0.9rem;
    }
    .form-row > input:invalid + span {
      top: 50%;
    }
    .form-row > input:focus + span {
      top: 0;
    }
    .form-row > input:required {
      box-shadow: none;
    }
    .form-row > input:focus {
      border-color: #7b5dfa;
      outline: none;
    }
    .form-row > input:focus:invalid {
      box-shadow: none;
      top: 50%;
    }
    .form-row > input:focus:valid {
      top: 0;
    }
    
    @media (min-width:768px) and (max-width:991px){
        .summery_upper{
            max-width:450px;
            margin:auto;
        }
    }

    @media (max-width:480px){
        .summary .sm_inner{
            padding: 1.5rem;
        }
    }

    .line-inputs input::placeholder{
        font-size: 13px;
    }
</style>
@endsection

@section('content')
{{-- @php
$stripe=false;
@endphp --}}
<section id="pricing">

    <span class="splashes dots-color-bottom"></span>
    <div class="py-5">
        <div class="container">

            <div class="mb-5">
                <div class="">
                    <div class="mb-4">
                        <a href="{{ url('') }}" ><img src="{{ asset('assets/front/images/logo-dark.svg') }}" class="main_logo" alt="MouthPublicity.io"></a>
                    </div>
                </div>
            </div>

            <div class="summary">
                <div class="sm_inner">
                    <div class="line-form_">
                        <div class="row">
                            <div class="col-lg-6 pd_custom" style="background: #1a3aa6;border-radius: 10px 0px 0px 10px;">
                                <div class="summery_upper">
                                    <h4>Order Summary</h4>
                                    <p class="text-custom mb-2">Selected Package</p>
                                    <p class="font-600 font-h1 text-capitalize lh-1 text-dark small"> 
                                        @foreach($channels as $channel)
                                        <span class="me-1 py-1 px-2 oplk-backgroundCustom rounded-3 d-inline-block mb-1">{{ $channel->name }} @if($channel->free_employee > 0)({{ $channel->free_employee }} Employees)@endif</span>
                                        @endforeach
                                    </p>

                                    <div class="billing_type_checks">
                                        <ul class="list-group mb-3">
                                            
                                            <li class="list-group-item">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="billing_type" id="yearly" value="year" checked>
                                                    <label class="form-check-label" for="yearly">
                                                      <div>
                                                        <span class="text-uppercase">{!! strtr($planData['billing_type'] , '_', ' ')  !!}</span>
                                                        <span class="price_yr float-end">&#8377; {{ $planData['payble_price'] }}</span>
                                                    </div>
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="bifurcation">
                                        <table class="w-100 font-400 font-h1">
                                            <tr>

                                                <td>@if(Session::has('package')) @if(Session::get('package') == 'business'){{ 'All Apps' }} @else{{ 'Selected Apps' }} @endif @else{{ $planData['plan_name'] }} @endif</td>
                                                <td class="text-end"> <span>&#8377; <span class="BillNetPrice">{{ round($withoutGst_price, 2) }}</span></span> </td>
                                            </tr>
                                            <tr id="gst_tr">
                                                <td>GST (18%)</td>
                                                <td class="text-end"> <span>&#8377; <span class="BillGSTPrice">{{ round($gst_price, 2) }}</span></span> </td>
                                            </tr>
                                            <tr id="igst_tr" style="display:none">
                                                <td>IGST (18%)</td>
                                                <td class="text-end"> <span>&#8377; <span class="BillGSTPrice">{{ round($gst_price, 2) }}</span></span> </td>
                                            </tr>
                                            <tr id="cgst_tr" style="display:none">
                                                <td>CGST (9%)</td>
                                                <td class="text-end"> <span>&#8377; <span class="BillGSTPrice">{{ round($cgst_price, 2) }}</span></span> </td>
                                            </tr>
                                            <tr id="sgst_tr" style="display:none">
                                                <td>SGST (9%)</td>
                                                <td class="text-end"> <span>&#8377; <span class="BillGSTPrice">{{ round($sgst_price, 2) }}</span></span> </td>
                                            </tr>
                                            <tr>
                                                <td class="small">Payable Amount</td>
                                                <td class="text-end"> <span class="fw-bold font-xlarge">&#8377; <span class="BillGrossPrice">{{ $planData['payble_price'] }}</span></span> </td>
                                            </tr>
                                        </table>
                                        <hr>
                                        
                                    </div>
                                    {{-- <p class="mb-0">MouthPublicity.io Subcription Plan</p> --}}
                                    <p class="small">
                                        Billed <span class="BillTypeName text-uppercase">{!! strtr($planData['billing_type'] , '_', ' ')  !!}</span> for &#8377;<span class="BillGrossPrice fw-bold">{{ $planData['payble_price'] }}</span>/-
                                        <span class="small text-custom">(Including GST)</span>
                                    </p>


                                    <div>
                                        <p>You are just one step back from creating your first campaign. Create the offer, promote it, Build your customer listing easily & get more customers for the business, with MouthPublicity.io a Simple Promotion Tool.</p>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="col-lg-6 pd_custom" style="border: 1px solid #efebeb;border-radius: 0px 10px 10px 0px;">
                                <div>
                                    
                                    <div class="checkout_rf line-inputs_">

                                        {{-- <script src="https://js.stripe.com/v3/"></script> --}}
                                        <form action="{{ url('make-charge'.'/'.$planData['plan_id']) }}" method="post" class="line-form_ basicform">
                                            @csrf
                                            {{-- @php
                                            $stripe=true;
                                            @endphp --}}

                                            <input type="hidden" name="mode" value="{{ $getway->id }}">
                                            <input type="hidden" name="payble_price" value="{{ $planData['payble_price'] }}">
                                            <input type="hidden" name="plan_group_id" value="{{ $planData['plan_group_id'] }}">
                                            <input type="hidden" name="plan_name" value="{{ $planData['plan_name'] }}">
                                            <input type="hidden" name="billing_type" value="{{ $planData['billing_type'] }}">

                                            <input type="hidden" id="publishable_key" value="{{ $getway->credentials->publishable_key }}">
                                            <div class="form-row mb-4">
                                                <input type="text" name="name" id="name" class="three-space-validation" placeholder="" value="{{ Session::get("name") }}" required>
                                                <span>Username *</span>
                                            </div>
                                            <div class="form-row mb-4">
                                                <input type="tel" name="phone" id="phone" class="no-space-validation number-validation"  value="{{ Session::get("mobile") }}" placeholder="" minlength="10" maxlength="10" required>
                                                <span>Whatsapp Number *</span>
                                                <div class="mobile-error"></div>
                                            </div>
                                            <div class="form-row mb-2">
                                                <input type="email" name="email" id="email" class=""  value="{{ Session::get("email") }}" placeholder="" required>
                                                <span>Email *</span>
                                                <div class="email-error"></div>
                                            </div>

                                            <div class="row mb-4">
                                                    <div class="col-12">
                                                        <div class="form-row mb-2">
                                                            <input type="text" name="gst_address" class="" id="gst_address" placeholder="" title="Address" required>
                                                            <span>Address *</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-6">

                                                        <div class="form-row mb-0">
                                                            <select name="gst_state" id="gst_state" title="State" class="form-select select2">
                                                                <option value="0">Select State</option>
                                                                @foreach($states as $state)
                                                                    <option value="{{ $state->id }}" class="state_{{ $state->id }}" id="{{ $state->gst_code_id }}">{{ $state->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <!-- <span style="font-size: 12px;color: red;">Please Select State*</span> -->
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-row mb-2">
                                                            <input type="text" name="gst_city" id="gst_city" class="char-validation" placeholder="" title="City" required>
                                                            <span>City *</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-row mb-sm-0 mb-3">
                                                            <input type="text" name="gst_pincode" id="gst_pincode" class="no-space-validation number-validation" placeholder="" title="Area Pincode" minlength="6" maxlength="6" required>
                                                            <span>Pincode *</span>
                                                        </div>
                                                    </div>
                                                   
                                                </div>

                                            <div>

                                                <div class="form-check btn btn-dark btn-sm mb-2 d-inline-block" style="padding-left: 32px;">
                                                    <input class="form-check-input tl-drk" type="checkbox" id="gst_claim" name="gst_claim" value="1">
                                                    <label class="form-check-label" for="gst_claim">
                                                        Claim GST
                                                    </label>
                                                </div>
                                                <div class="collapse" id="gst_collapse">
                                                    <div class="border_ border-dark_ mb-4 rounded_ p-2_" style="max-width: 480px">
                                                        <div class="line-inputs">
                                                            <p class="font-small mb-1">(To claim your GST, please provide your GST account details)</p>
                                                            <div class="row">
                                                                <div class="col-md-5">
                                                                    <div class="form-group mb-3">
                                                                        <input type="text" class="form-control border-dark text-dark" placeholder="Enter GST Number *" title="GST Number" name="gst_number" id="gst_number_input">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <div class="form-group mb-3">
                                                                        <input type="text" class="form-control border-dark text-dark" placeholder="Enter Registered Business Name *" title="Registered Business Name" name="gst_business_name" id="gst_business_name_input">
                                                                    </div>
                                                                </div>
                                                            </div>
        
                                                            <div class="mt-3">
                                                                <p class="mb-0 font-small">GSTIN : <span class="BillGrossPrice fw-bold">27AAECL6399Q1ZG</span> <span>(Logic Innovates)</span> </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <p class="small mb-1 font-h1">Payable amount is <span class="fw-bold">&#8377; <span class="BillGrossPrice">{{ $planData['payble_price'] }}/-</span></span></p>
                                                <button type="button" class="btn btn-theme btn-lg w-100" id="checkCheckout">Checkout Now</button>
                                                <button type="submit" style="display:none" id="submitForm"></button>
                                            </div>
                                            {{-- <input type="hidden" name="gst_claim" class="gst_claim" value="0"> --}}
                                            {{-- <input type="hidden" name="gst_state" class="gst_state"  value="0">
                                            <input type="hidden" name="gst_number" class="gst_number"  value="0"> --}}
                                        </form>

                                        <div class="mt-3">
                                            <p class="small mb-0"><i class="bi bi-shield-check"></i> Secure Checkout With <span style="color:#012652" class="fw-bold font-h1"><i>{{ $getway->name }}</i></span> </p>
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
</section>
@endsection

@section('end_body')
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/js/input-validation.js') }}"></script>
<script>
    function Sweet(icon,title,time=3000){
        
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: time,
                timerProgressBar: true,
                onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: icon,
                title: title,
            })
        }


    $(document).ready(function(){

        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                $('#checkCheckout').trigger('click');
                return false;
            }
        });


        function validateInputs() {
            var gst_claim = $('#gst_claim').prop("checked") ? 1 : 0 ;
            var gst_busi_name = $('#gst_business_name_input').val();
            var gst_address = $('#gst_address').val();
            var gst_state = $('#gst_state').val();
            var gst_city = $('#gst_city').val();
            var gst_pincode = $('#gst_pincode').val();
            var gst_number_input = $('#gst_number_input').val();
            var name = $('#name').val();
            var phone = $('#phone').val();
            var email = $('#email').val();
            var password = $('#password').val();

            if(name == ''){
                $("#name").focus();
                Sweet('error', 'Please enter name.');
                return false;
            }

            if(phone == ''){
                $("#phone").focus();
                Sweet('error', 'Please enter Whatsapp number.');
                return false;
            }

            if(phone.length < 10){
                $("#gst_pincode").focus();
                Sweet('error', 'Whatsapp number should be of 10 digit.');
                return false;
            }

            if(email == ''){
                $("#email").focus();
                Sweet('error', 'Please enter email.');
                return false;
            }

            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!regex.test(email)) {
                $("#email").focus();
                Sweet('error', 'Please enter valid email.');
                return false;
            }

            if(gst_address == ''){
                $("#gst_address").focus();
                Sweet('error', 'Please enter address.');
                return false;
            }

            if(gst_address.length < 6){
                $("#gst_address").focus();
                Sweet('error', 'Address is too short.');
                return false;
            }

            if(gst_state == 0 || gst_state == undefined){
                $("#gst_state").focus();
                Sweet('error', 'Please select state.');
                return false;
            }

            if(gst_city == ''){
                $("#gst_city").focus();
                Sweet('error', 'Please enter city.');
                return false;
            }

            if(gst_city.length < 3){
                $("#gst_city").focus();
                Sweet('error', 'City name is too short.');
                return false;
            }

            if(gst_pincode == ''){
                $("#gst_pincode").focus();
                Sweet('error', 'Please enter pincode.');
                return false;
            }

            if(gst_pincode.length < 6){
                $("#gst_pincode").focus();
                Sweet('error', 'Pincode should be of 6 digit.');
                return false;
            }

            if(gst_claim == 1){
                
                if(gst_number_input != ""){
                    var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9]{1}Z[a-zA-Z0-9]{1}$');
                    if (!gstinformat.test(gst_number_input)) {    
                        Sweet('error', 'Please Enter Valid GSTIN Number.');
                        $("#gst_number_input").focus();
                        return false;  
                    }

                    var gst_state_code = gst_number_input.slice(0, 2);
                    var state_code = $('.state_'+gst_state).attr('id');

                    if(state_code != gst_state_code){
                        Sweet('error', 'Please Enter Valid GSTIN Number.');
                        $("#gst_number_input").focus();
                        return false;
                    }
                    
                }else{
                    /*console.log('gst empty');*/
                    $("#gst_number_input").focus();
                    Sweet('error', 'Please insert GST Number.');
                    return false;
                }
                $('.gst_number').val(gst_number_input);

                if(gst_busi_name == ''){
                    $("#gst_business_name_input").focus();
                    Sweet('error', 'Please enter the registered business name.');
                    return false;
                }

                if(gst_busi_name.length < 3){
                    $("#gst_busi_name").focus();
                    Sweet('error', 'Registered business name is too short.');
                    return false;
                }
            }

            return true;
        }

        $(document).on('click', '#checkCheckout', function(){
            var btn = $(this);

            var validate = validateInputs();
            if(!validate){
                return false;
            }

            @auth()
                var auth = '{{ Auth::User()->role_id }}';
            @else
                var auth = '';
            @endauth

            var gst_claim = $('#gst_claim').prop("checked") ? 1 : 0 ;
            var gst_busi_name = $('#gst_business_name_input').val();
            var gst_address = $('#gst_address').val();
            var gst_state = $('#gst_state').val();
            var gst_city = $('#gst_city').val();
            var gst_pincode = $('#gst_pincode').val();
            var gst_number_input = $('#gst_number_input').val();
            var name = $('#name').val();
            var phone = $('#phone').val();
            var email = $('#email').val();
            var password = $('#password').val();

            var plan_id = '{{ $planData['plan_id'] }}';

            if(gst_claim != 1){
                gst_busi_name = '';
                gst_number_input = '';
            }

            if(auth != ''){

                if(auth == '2'){
                    window.location.href = "{{ url('/business/subscriptions/plans') }}";
                }

                if(auth == '3'){
                    window.location.href = "{{ url('/employee/dashboard') }}";
                }

                if(auth == '4'){
                    window.location.href = "{{ url('/seo/seo') }}";
                }

                if(auth == '5'){
                    window.location.href = "{{ url('/account/dashboard') }}";
                }
                
                return;
            }
            /* console.log(btn) */
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            /* console.log(plan_id); */
            if(plan_id){
                $.ajax({
                    /* the route pointing to the post function */
                    url: '{{ route('checkUserPayment') }}',
                    type: "post",
                    /* send the csrf-token and the input to the controller */
                    data: {
                        _token: CSRF_TOKEN,
                        email: email,
                        mobile: phone,
                        password: password,
                        plan_id: plan_id,
                        gst_claim: gst_claim,
                        gst_business_name: gst_busi_name,
                        gst_address: gst_address,
                        gst_state: gst_state,
                        gst_city: gst_city,
                        gst_pincode: gst_pincode,
                        gst_number: gst_number_input
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        
                        btn.attr('disabled','')
                        btn.html('Please Wait....')

                    },
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        /*console.log(data);*/
                        btn.removeAttr('disabled');
                        btn.html('Checkout Now');

                        if(data.status == true){
                            if(data.url){
                                window.location = data.url;
                            }else{
                                $('#submitForm').click();
                            }

                            $("#password-input").remove();
                            
                        }else{
                            Sweet('error',data.message);

                            /*$("#password-input").css("display", "block");*/

                            $("#password-input").remove();

                            $(data.password).insertAfter("#email");
                        }
                    }
                });
            }
        });


        $billedtype = $("input[name='billing_type']");
        $billedtype.on("change", function(){
            var valu = $billedtype.filter(":checked").val();

            if(valu === 'month'){
                $(".BillTypeName").html('Monthly');
                $(".BillGrossPrice").html("999");
                $(".BillNetPrice").html("847");
                $(".BillGSTPrice").html("152");
            }
            else if(valu === 'year'){
                $(".BillTypeName").html('Yearly');
                $(".BillGrossPrice").html("9999");
                $(".BillNetPrice").html("8474");
                $(".BillGSTPrice").html("1525");
            }
        })
    })
</script>
<script type="text/javascript">      
$(document).ready(function () {

    if($('#gst_claim').is(':checked')) {
        $("#gst_collapse").toggle("collapse");
    }

    $(document).on('change', '#gst_claim', function(){
    // $("#gst_claim").on("change", function(){
        var active = $(this).prop("checked") ? 1 : 0
        $("#gst_collapse").toggle("collapse");
        if(active == 0){
            $('#gst_tr').show();
            $('#igst_tr').hide();
            $('#cgst_tr').hide();
            $('#sgst_tr').hide();
            $('#gst_state').val('0');
        }else{ }
        $('.gst_claim').val(active);
    });
    $(document).on('change', '#gst_state', function(){
        var state_id = $(this).val();
        /*console.log(state_id);*/
        $('.gst_state').val(state_id);
        if(state_id != 14){
            $('#gst_tr').hide();
            $('#cgst_tr').hide();
            $('#sgst_tr').hide();
            $('#igst_tr').show();
        }else{
            $('#gst_tr').hide();
            $('#igst_tr').hide();
            $('#cgst_tr').show();
            $('#sgst_tr').show();
        }
    })
    $(document).on('change', '#gst_number_input', function () {    
        var inputvalues = $(this).val();
        var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9]{1}Z[a-zA-Z0-9]{1}$');    
        if (gstinformat.test(inputvalues)) {
            $('.gst_number').val(inputvalues);
            return true;    
        } else {
            Sweet('error', 'Please Enter Valid GSTIN Number.');
            $("#gst_number_input").focus();
        }
    });          
});          
  </script>
{{-- @if($stripe == true)
<script src="{{ asset('assets/js/stripe.js') }}"></script>
 <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
     $(function(){
        if(jQuery().select2) {
            $(".select2").select2();
        }
    });
    </script>
@endif --}}
@endsection