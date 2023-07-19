@extends('layouts.website')

@section('title', 'Checkout | MouthPublicity.io')
{{-- @section('description', '') --}}
{{-- @section('keywords', '') --}}
{{-- @section('image', '') --}}

@section('end_head')
<style>
    .summary{
        position: relative;
        width: 100%;
        background: #FFF;
        border-radius: 8px;
    }
    .summary .sm_inner{
        position: relative;
        z-index: 2;
    }
    .summery_upper {
        color: #fff;
    }
    .pd_custom{
        padding: 3em;
    }
    @media (min-width:768px) and (max-width:991px){
        .summery_upper{
            max-width:450px;
            margin:auto;
        }
    }

    @media (max-width:480px){
        .summary .sm_inner{
            padding: 0 .6rem;
        }
        .pd_custom{
            padding: 1.5rem 1em;
        }
    }


    .billing_type_checks{
        position: relative;
        max-width: 400px;
    }
    .billing_type_checks .list-group-item{
        background-color: rgb(255 255 255 / 100%);
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
        font-family: var(--font-family-head);
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

    .br-left-to-top{
        border-radius: .6rem 0 0 .6rem;
    }
    .br-right-to-bottom{
        border-radius: 0 .6rem .6rem 0;
    }
    @media(max-width:991px){
        .br-left-to-top{
            border-radius: .6rem .6rem 0 0;
        }
        .br-right-to-bottom{
            border-radius: 0 0 .6rem .6rem;
        }
    }
</style>
@endsection

@section('content')
<section id="checkout">
    <div class="py-5">
        <div class="container">
            
            <div>
                <h1 class="h3 color-primary font-800">Checkout</h1>
            </div>

            @php    
                $payment_token = '';
                if(!empty($selectedPlan)){
                    $payment_token = $selectedPlan['payment_token_id'];
                }

                $name = $email = $mobile = '';
                $address = $state_id = $city = $pincode = '';

                if($paymentData != null){
                    $name = $paymentData->name;
                    $email = $paymentData->email;
                    $mobile = $paymentData->mobile;

                    $business_details = \DB::table('business_details')->where('user_id',$paymentData->user_id)->first();
                    
                    if($business_details){
                        $address = $business_details->billing_address_line_1;
                        $state_id = $business_details->billing_state;
                        $city = $business_details->billing_city;
                        $pincode = $business_details->billing_pincode;
                    }
                }elseif(Auth::id() != null){

                    $user_id = Auth::user()->id;
                    $name = Auth::user()->name;
                    $email = Auth::user()->email;
                    $mobile = Auth::user()->mobile;

                    if(Auth::user()->role_id == 3){
                        $user_id = Auth::user()->created_by;

                        $user_details = \DB::table('users')->where('id',$user_id)->first();

                        $name = $user_details->name;
                        $email = $user_details->email;
                        $mobile = $user_details->mobile;
                    }

                    $business_details = \DB::table('business_details')->where('user_id',$user_id)->first();
                    
                    if($business_details){
                        $address = $business_details->billing_address_line_1;
                        $state_id = $business_details->billing_state;
                        $city = $business_details->billing_city;
                        $pincode = $business_details->billing_pincode;
                    }
                    
                }
            @endphp

            <div class="summary">
                <div class="sm_inner">
                    <div class="row">
                        <div class="col-lg-6 pd_custom bg-color-gradient br-left-to-top">
                            <div class="summery_upper">
                                <h2 class="font-800 h4">Order Summary</h2>

                                <div class="bifurcation">
                                    <table class="w-100 font-400 font-h1">
                                        <tr>
                                            <td>@if(Session::has('package')) @if(Session::get('package') == 'business'){{ 'All Apps' }} @else{{ 'Selected Apps' }} @endif @else{{ $planData['plan_name'] }} @endif</td>
                                            <td class="text-end"> <span>&#8377; <span id="NetPrice" class="BillNetPrice">{{ round($withoutGst_price, 2) }}</span></span> </td>
                                        </tr>
                                        {{-- <tr id="gst_tr">
                                            <td>GST (18%)</td>
                                            <td class="text-end"> <span>&#8377; <span id="GSTPrice" class="BillGSTPrice">{{ round($gst_price, 2) }}</span></span> </td>
                                        </tr> --}}

                                        @if($name == '')
                                            <tr id="igst_tr">
                                                <td>IGST (18%)</td>
                                                <td class="text-end"> <span>&#8377; <span id="IGSTPrice" class="BillGSTPrice">{{ round($gst_price, 2) }}</span></span> </td>
                                            </tr>   
                                            <tr id="cgst_tr" style="display:none">
                                                <td>CGST (9%)</td>
                                                <td class="text-end"> <span>&#8377; <span id="CGSTPrice" class="BillGSTPrice">{{ round($cgst_price, 2) }}</span></span> </td>
                                            </tr>
                                            <tr id="sgst_tr" style="display:none">
                                                <td>SGST (9%)</td>
                                                <td class="text-end"> <span>&#8377; <span id="SGSTPrice" class="BillGSTPrice">{{ round($sgst_price, 2) }}</span></span> </td>
                                            </tr>
                                        @else
                                            @if($state_id == 14)
                                                <tr id="cgst_tr">
                                                    <td>CGST (9%)</td>
                                                    <td class="text-end"> <span>&#8377; <span id="CGSTPrice" class="BillGSTPrice">{{ round($cgst_price, 2) }}</span></span> </td>
                                                </tr>
                                                <tr id="sgst_tr">
                                                    <td>SGST (9%)</td>
                                                    <td class="text-end"> <span>&#8377; <span id="SGSTPrice" class="BillGSTPrice">{{ round($sgst_price, 2) }}</span></span> </td>
                                                </tr>
                                                <tr id="igst_tr" style="display:none">
                                                    <td>IGST (18%)</td>
                                                    <td class="text-end"> <span>&#8377; <span id="IGSTPrice" class="BillGSTPrice">{{ round($gst_price, 2) }}</span></span> </td>
                                                </tr> 
                                            @else
                                                <tr id="igst_tr">
                                                    <td>IGST (18%)</td>
                                                    <td class="text-end"> <span>&#8377; <span id="IGSTPrice" class="BillGSTPrice">{{ round($gst_price, 2) }}</span></span> </td>
                                                </tr> 
                                                <tr id="cgst_tr" style="display:none">
                                                    <td>CGST (9%)</td>
                                                    <td class="text-end"> <span>&#8377; <span id="CGSTPrice" class="BillGSTPrice">{{ round($cgst_price, 2) }}</span></span> </td>
                                                </tr>
                                                <tr id="sgst_tr" style="display:none">
                                                    <td>SGST (9%)</td>
                                                    <td class="text-end"> <span>&#8377; <span id="SGSTPrice" class="BillGSTPrice">{{ round($sgst_price, 2) }}</span></span> </td>
                                                </tr>
                                            @endif
                                        @endif
                                        
                                        
                                        <tr>
                                            <td class="small">Payable Amount</td>
                                            <td class="text-end"> <span class="fw-bold font-xlarge">&#8377; <span class="BillGrossPrice" id="PayablePrice">{{ $planData['payble_price'] }}</span></span> </td>
                                        </tr>
                                    </table>
                                    <hr>
                                    
                                </div>

                                <div>
                                    <p class="mb-0 small">You are just one step back from creating your first campaign. Create the offer, promote it, Build your customer listing easily & get more customers for the business, with MouthPublicity.io a Simple Promotion Tool.</p>
                                </div>
                            </div>
                            
                        </div>

                        <div class="col-lg-6 pd_custom border br-right-to-bottom">
                            <div>
                                
                                <div class="checkout_rf ">

                                    {{-- <script src="https://js.stripe.com/v3/"></script> --}}
                                    <form action="{{ url('make-charge'.'/'.$planData['plan_id']) }}" method="post" class="form-type-one checkoutform">
                                        @csrf
                                        {{-- @php $stripe=true; @endphp --}}

                                        <input type="hidden" name="mode" value="{{ $getway->id }}">
                                        <input type="hidden" name="payble_price" id="payble_price" value="{{ $planData['payble_price'] }}">
                                        
                                        @auth()
                                            <input type="hidden" name="old_user_id" value="{{ auth()->user()->id }}" />
                                        @else
                                            <input type="hidden" name="old_user_id" value="" />
                                        @endif

                                        <input type="hidden" name="plan_name" value="{{ $planData['plan_name'] }}">

                                        <input type="hidden" name="payment_token" value="{{ $payment_token }}" />
                                        {{-- <input type="hidden" name="enterprise_id" value="{{ $enterprise_id }}" /> --}}
                                        
                                        {{-- New Theme Inputs  --}}

                                        @if($name == '')
                                            <div class="form-group mb-3">
                                                <input type="text" name="name" id="name" class="form-control shadow-sm three-space-validation" placeholder="Your name *" value="{{ $name }}" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <input type="tel" name="phone" id="phone" class="form-control shadow-sm no-space-validation number-validation"  value="{{ $mobile }}" placeholder="Whatsapp Number *" minlength="10" maxlength="10" required >
                                                <div class="mobile-error"></div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <input type="email" name="email" id="email" class="form-control shadow-sm" value="{{ $email }}" placeholder="Email ID *" required>
                                                <div class="email-error"></div>
                                            </div>
                                        @else
                                            <p><b>Name: </b>{{ $name }}</p>
                                            <p><b>Mobile: </b>{{ $mobile }}</p>
                                            <p><b>Email: </b>{{ $email }}</p>

                                            <input type="hidden" name="name" id="name" value="{{ $name }}" >
                                            <input type="hidden" name="phone" id="phone" value="{{ $mobile }}" >
                                            <input type="hidden" name="email" id="email" value="{{ $email }}" >
                                        @endif

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group mb-3">
                                                    <input type="text" name="gst_address" class="form-control shadow-sm" id="gst_address" placeholder="Address *" title="Address" value="{{ $address }}" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-6">
                                                <div class="form-group mb-3">
                                                    <select name="gst_state" id="gst_state" title="State" class="form-select form-control shadow-sm">
                                                        <option value="0">Select State *</option>
                                                        @foreach($states as $state)
                                                            <option value="{{ $state->id }}" class="state_{{ $state->id }}" id="{{ $state->gst_code_id }}" @if($state_id == $state->id) selected @endif>{{ $state->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" name="gst_city" id="gst_city" class="char-validation form-control shadow-sm" placeholder="City *" title="City" value="{{ $city }}" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" name="gst_pincode" id="gst_pincode" class="no-space-validation number-validation form-control shadow-sm" placeholder="Pincode *" title="Area Pincode" minlength="6" maxlength="6"  value="{{ $pincode }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        {{-- GST  --}}
                                        <div>
                                            <div class="form-check mb-2 d-inline-block p-0 position-relative" >
                                                <input class="form-check-input tl-drk position-absolute m-0" type="checkbox" id="gst_claim" name="gst_claim" value="1" style="top: 7px;left: 7px;">
                                                <label class="form-check-label btn btn-dark btn-sm" style="padding-left: 32px;" for="gst_claim">
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
                                                                    <input type="text" class="form-control shadow-sm" placeholder="Enter GST Number *" title="GST Number" name="gst_number" id="gst_number_input">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <div class="form-group mb-3">
                                                                    <input type="text" class="form-control shadow-sm" placeholder="Enter Registered Business Name *" title="Registered Business Name" name="gst_business_name" id="gst_business_name_input">
                                                                </div>
                                                            </div>
                                                        </div>
    
                                                        <div class="mt-3">
                                                            <p class="mb-0 font-small">GSTIN : <span class="fw-bold">27AAECL6399Q1ZG</span> <span>(Logic Innovates)</span> </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <p class="small mb-1 font-h1">Payable amount is <span class="fw-bold">&#8377; <span class="BillGrossPrice" id="Payable_price_info">100</span>/-</span></p>
                                            <button type="button" class="btn btn-primary-ol btn-lg w-100" id="checkCheckout">Checkout Now</button>
                                            <button type="submit" style="display:none" id="submitForm"></button>
                                        </div>
                                    </form>

                                    <div class="mt-2">
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
</section>
<!-- Modal -->
<div class="modal fade" id="LoginModalIfUserExist" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title font-700 color-primary"><i class="bi bi-exclamation-circle-fill"></i> Account Exist</h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning small">
                    <div>Hello,</div>
                    <div>We found that you are already register with the us by your Mobile Number or Email-ID.</div>
                    <div>Please click on below Login button to login your existing account.</div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <a type="button" class="btn btn-primary-ol px-4" href="{{url('signin')}}">Go to Login</a>
                    <button type="button" class="btn btn-outline-secondary font-600 px-4" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/js/input-validation.js') }}"></script>
@endpush

@push('end_body')
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
        });
        Toast.fire({
            icon: icon,
            title: title,
        });
    }


    $(document).ready(function(){

        var payable_amount = '{{ $payable_amt }}';
        if(payable_amount != ''){
            sessionStorage.setItem("payable_amount", payable_amount);
        }
        
        //get payable_amount
        if(sessionStorage.getItem('payable_amount')){
            var amount_stored = sessionStorage.getItem("payable_amount");
            if(amount_stored < 100){
                amount_stored = 100;
            }

            var gst_price = (amount_stored - (amount_stored * (100 / (100 + 18 ) ) )).toFixed(2);
            var gst_half = (gst_price / 2).toFixed(2);
            var withoutGst_price = (amount_stored - gst_price).toFixed(2);

            $('#NetPrice').text(withoutGst_price);
            $('#GSTPrice').text(gst_price);
            $('#IGSTPrice').text(gst_price);
            $('#CGSTPrice').text(gst_half);
            $('#SGSTPrice').text(gst_half);
            $('#PayablePrice').text(amount_stored);

            $("#payble_price").val(amount_stored);
            $(".BillGrossPrice").text(amount_stored);
        }else{
            window.location.href = '{{ route('pricing') }}';
        }


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
            // var password = $('#password').val();

            if(name.length < 5){
                $("#name").focus();
                Sweet('error', 'Please enter valid name. Minimum 5 characters.');
                
                $('#checkCheckout').removeAttr('disabled');
                $('#checkCheckout').html('Checkout Now');

                return false;
            }

            if(phone == ''){
                $("#phone").focus();
                Sweet('error', 'Please enter Whatsapp number.');
                
                $('#checkCheckout').removeAttr('disabled');
                $('#checkCheckout').html('Checkout Now');

                return false;
            }

            if(phone.length < 10){
                $("#gst_pincode").focus();
                Sweet('error', 'Whatsapp number should be of 10 digit.');
                
                $('#checkCheckout').removeAttr('disabled');
                $('#checkCheckout').html('Checkout Now');

                return false;
            }

            if(email == ''){
                $("#email").focus();
                Sweet('error', 'Please enter email.');
                
                $('#checkCheckout').removeAttr('disabled');
                $('#checkCheckout').html('Checkout Now');

                return false;
            }

            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!regex.test(email)) {
                $("#email").focus();
                Sweet('error', 'Please enter valid email.');
                
                $('#checkCheckout').removeAttr('disabled');
                $('#checkCheckout').html('Checkout Now');

                return false;
            }

            if(gst_address == ''){
                $("#gst_address").focus();
                Sweet('error', 'Please enter address.');
                
                $('#checkCheckout').removeAttr('disabled');
                $('#checkCheckout').html('Checkout Now');

                return false;
            }

            if(gst_address.length < 6){
                $("#gst_address").focus();
                Sweet('error', 'Address is too short.');
                
                $('#checkCheckout').removeAttr('disabled');
                $('#checkCheckout').html('Checkout Now');

                return false;
            }

            if(gst_state == 0 || gst_state == undefined){
                $("#gst_state").focus();
                Sweet('error', 'Please select state.');
                
                $('#checkCheckout').removeAttr('disabled');
                $('#checkCheckout').html('Checkout Now');

                return false;
            }

            if(gst_city == ''){
                $("#gst_city").focus();
                Sweet('error', 'Please enter city.');
                
                $('#checkCheckout').removeAttr('disabled');
                $('#checkCheckout').html('Checkout Now');

                return false;
            }

            if(gst_city.length < 3){
                $("#gst_city").focus();
                Sweet('error', 'City name is too short.');
                
                $('#checkCheckout').removeAttr('disabled');
                $('#checkCheckout').html('Checkout Now');

                return false;
            }

            if(gst_pincode == ''){
                $("#gst_pincode").focus();
                Sweet('error', 'Please enter pincode.');
                
                $('#checkCheckout').removeAttr('disabled');
                $('#checkCheckout').html('Checkout Now');

                return false;
            }

            if(gst_pincode.length < 6){
                $("#gst_pincode").focus();
                Sweet('error', 'Pincode should be of 6 digit.');
                
                $('#checkCheckout').removeAttr('disabled');
                $('#checkCheckout').html('Checkout Now');

                return false;
            }

            if(gst_claim == 1){
                
                if(gst_number_input != ""){
                    var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9]{1}Z[a-zA-Z0-9]{1}$');
                    if (!gstinformat.test(gst_number_input)) {    
                        Sweet('error', 'Please Enter Valid GSTIN Number.');
                        $("#gst_number_input").focus();
                        
                        $('#checkCheckout').removeAttr('disabled');
                $('#checkCheckout').html('Checkout Now');

                        return false;  
                    }

                    var gst_state_code = gst_number_input.slice(0, 2);
                    var state_code = $('.state_'+gst_state).attr('id');

                    if(state_code != gst_state_code){
                        Sweet('error', 'Please Enter Valid GSTIN Number.');
                        $("#gst_number_input").focus();
                        
                        $('#checkCheckout').removeAttr('disabled');
                $('#checkCheckout').html('Checkout Now');

                        return false;
                    }
                    
                }else{
                    /*console.log('gst empty');*/
                    $("#gst_number_input").focus();
                    Sweet('error', 'Please insert GST Number.');
                    
                    $('#checkCheckout').removeAttr('disabled');
                $('#checkCheckout').html('Checkout Now');

                    return false;
                }
                $('.gst_number').val(gst_number_input);

                if(gst_busi_name == ''){
                    $("#gst_business_name_input").focus();
                    Sweet('error', 'Please enter the registered business name.');
                    
                    $('#checkCheckout').removeAttr('disabled');
                $('#checkCheckout').html('Checkout Now');

                    return false;
                }

                if(gst_busi_name.length < 3){
                    $("#gst_busi_name").focus();
                    Sweet('error', 'Registered business name is too short.');
                    
                    $('#checkCheckout').removeAttr('disabled');
                $('#checkCheckout').html('Checkout Now');

                    return false;
                }
            }

            return true;
        }

        /* Proceed for payment if click enter */
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                $('#checkCheckout').trigger('click');
                return false;
            }
        });

        /* Proceed for Payment */
        $(document).on('click', '#checkCheckout', function(e){
            e.preventDefault();
            var btn = $(this);
           
            btn.attr('disabled','')
            btn.html('Please Wait....')

            var payment_link_token = '{{ request()->get('token') }}';

            var url = '{{ route("checkUserPayment") }}';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                        mobile : $('#phone').val(),
                        email : $('#email').val(),
                        payment_link_token : payment_link_token,
					},
                dataType: 'json',
                success: function(response){ 

                    if(response.status == false){
                        $("#LoginModalIfUserExist").modal('show'); 
                        
                        return false;
                    }else{
                        var validate = validateInputs();
                        if(!validate){
                            return false;
                        }else{
                            $('#submitForm').click();
                        }
                    }
                    btn.removeAttr('disabled');
                    btn.html('Checkout Now');
                },
                error: function(xhr, status, error) 
                {
                    btn.removeAttr('disabled');
                    btn.html('Checkout Now');
                }
            });
        });

    });
</script>

<script>
window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted || ( typeof window.performance != "undefined" && window.performance.navigation.type === 2 );
  if ( historyTraversal ) {
    if($('#gst_claim').is(':checked')) {
        $("#gst_collapse").collapse("show");
    }
  }
});

$(document).ready(function () {

    if($('#gst_claim').is(':checked')) {
        $("#gst_collapse").collapse("show");
    }

    $(document).on('change', '#gst_claim', function(){
        var active = $(this).prop("checked") ? 1 : 0
        var state_id = $('#gst_state').val();

        if(active == 1){
            $("#gst_collapse").collapse("show");
        }else{
            if(state_id == 14){
                $('#cgst_tr').show();
                $('#sgst_tr').show();
                $('#igst_tr').hide();
                $("#gst_collapse").collapse("hide");
            }else{
                $('#igst_tr').show();
                $('#cgst_tr').hide();
                $('#sgst_tr').hide();
                $("#gst_collapse").collapse("hide");
            }
        }
        $('.gst_claim').val(active);
    });
    $(document).on('change', '#gst_state', function(){
        var state_id = $('#gst_state').val();
        var save_stateId = localStorage.setItem("state_id", state_id);

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
    
    /* Show igst, cgst and sgst start*/
    $(document).ready(function () {
        if (localStorage.getItem("state_id")) {
            var state_id = localStorage.getItem("state_id");
            if(state_id == 14){
                $('#cgst_tr').show();
                $('#sgst_tr').show();
                $('#igst_tr').hide();
            }else{
                $('#igst_tr').show();
                $('#cgst_tr').hide();
                $('#sgst_tr').hide();
            }
        }
    });
    /* Show igst, cgst and sgst end*/
});          
</script>
@endpush