@extends('layouts.employee')
@section('title', 'Send Challenges: Employee Panel')
@section('head')
    @include('layouts.partials.headersection',['title'=>'Send Challenges'])
@endsection

@section('end_head')
<style>
    .selected-date{
        color: #ffffff;
        background-color: #484bf8;
        border-radius: 4px;
    }

    #date-month-modal .modal-dialog{
        pointer-events: all;
    }
    /* .modale:before {
        content: "";
        display: none;
        background: rgba(0, 0, 0, 0.6);
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 10;
    }
    .opened:before {
        display: block;
    }
    .opened .modal-dialog {
        -webkit-transform: translate(0, 0);
        -ms-transform: translate(0, 0);
        transform: translate(0, 0);
        top: 20%;
    }
    .modal-dialog {
        background: #fefefe;
        border: #333333 solid 0px;
        border-radius: 5px;
        margin-left: -200px;
        text-align:center;
        position: fixed;
        left: 50%;
        top: -100%;
        z-index: 11;
        width: 360px;
        box-shadow:0 5px 10px rgba(0,0,0,0.3);
        -webkit-transform: translate(0, -500%);
        -ms-transform: translate(0, -500%);
        transform: translate(0, -500%);
        -webkit-transition: -webkit-transform 0.3s ease-out;
        -moz-transition: -moz-transform 0.3s ease-out;
        -o-transition: -o-transform 0.3s ease-out;
        transition: transform 0.3s ease-out;
    }
    .modal-body {
        padding: 20px;
    } */
    /* .modal-body input{
        width:200px;
        padding:8px;
        border:1px solid #ddd;
        color:#888;
        outline:0;
        font-size:14px;
        font-weight:bold
    } */
    /* .modal-header,
    .modal-footer {
        padding: 10px 20px;
    } */
    
    /* .modal-header h2 {
        font-size: 20px;
    }


    .days {
        padding: 10px 0;
        background: #fff;
        margin: 0;
        text-align: left;
    }

    .days li {
        list-style-type: none;
        display: inline-block;
        width: 13%;
        text-align: center;
        margin-bottom: 5px;
        font-size:12px;
        color: #777;
        cursor: pointer;
    }

    .days li:hover {
        color: #ffffff;
        background-color: #484bf8;
        border-radius: 15px;
    }

    .days li .active {
        padding: 5px;
        background: #1abc9c;
        color: white !important
    } */
    .custom_calendar .days {
        list-style: none;
        margin: 0;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: start;
        padding-left: 0px;
    }
    .custom_calendar .days li {
        text-align: center;
        cursor: pointer;
        flex: 0 1 14.20%;
        height: 38px;
        line-height: 38px;
    }
    .custom_calendar .days li:hover,
    .custom_calendar .days li:active,
    .custom_calendar .days li:focus {
        color: #ffffff;
        background-color: var(--primary);
        border-radius: 4px;
    }
    .custom_calendar .days li .active {
        padding: 5px;
        background: #1abc9c;
        color: white !important
    }

    .close_calendar{
        font-size: 20px;
        line-height: 28px;
        width: 28px;
        height: 28px;
        color: #000000;
        background-color: #ffffff;
        border: 1px solid #000000;
        border-radius: 50%;
        text-decoration: none !important;
        text-align: center;
    }

    /* .monthChange{
        text-align: center;
        padding: 5px;
        font-size: 20px;
    } */

    /* Invoice form */
    /* Let's make sure all tables have defaults */
    table.body-wrap td {
        vertical-align: top;
    }

    .body-wrap {
        background-color: #f6f6f6;
        width: 100%;
    }

    .body-wrap .container {
        display: block !important;
        max-width: 600px !important;
        margin: 0 auto !important;
        /* makes it centered */
        clear: both !important;
    }

    .body-wrap .content {
        max-width: 600px;
        margin: 0 auto;
        display: block;
    }

    .body-wrap .main {
        background: #fff;
        border: 1px solid #e9e9e9;
        border-radius: 3px;
    }

    .body-wrap .content-wrap {
        padding: 20px;
    }

    .body-wrap .content-block {
        padding: 0 0 20px;
    }

    .body-wrap .header {
        width: 100%;
        margin-bottom: 20px;
    }

    .body-wrap h1, .body-wrap h2, .body-wrap h3 {
        font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
        color: #000;
        margin: 0px;
        line-height: 1.2;
        font-weight: 400;
    }

    .body-wrap h1 {
        font-size: 32px;
        font-weight: 500;
    }

    .body-wrap h2 {
        font-size: 24px;
    }

    .body-wrap h3 {
        font-size: 18px;
    }

    .body-wrap h4 {
        font-size: 14px;
        font-weight: 600;
    }

    .body-wrap p, .body-wrap ul, .body-wrap ol {
        margin-bottom: 10px;
        font-weight: normal;
    }
    .body-wrap p li, .body-wrap ul li, .body-wrap ol li {
        margin-left: 5px;
        list-style-position: inside;
    }
    .body-wrap a {
        color: #1ab394;
        text-decoration: underline;
    }

    .body-wrap .btn-primary {
        text-decoration: none;
        color: #FFF;
        background-color: #1ab394;
        border: solid #1ab394;
        border-width: 5px 10px;
        line-height: 2;
        font-weight: bold;
        text-align: center;
        cursor: pointer;
        display: inline-block;
        border-radius: 5px;
        text-transform: capitalize;
    }

    .body-wrap .last {
        margin-bottom: 0;
    }

    .body-wrap .first {
        margin-top: 0;
    }

    .body-wrap .aligncenter {
        text-align: center;
    }

    .body-wrap .alignright {
        text-align: right;
    }

    .body-wrap .alignleft {
        text-align: left;
    }

    .body-wrap .clear {
        clear: both;
    }
    .body-wrap .alert {
        font-size: 16px;
        color: #fff;
        font-weight: 500;
        padding: 20px;
        text-align: center;
        border-radius: 3px 3px 0 0;
    }
    .body-wrap .alert a {
        color: #fff;
        text-decoration: none;
        font-weight: 500;
        font-size: 16px;
    }
    .body-wrap .alert.alert-warning {
        background: #f8ac59;
    }
    .body-wrap .alert.alert-bad {
        background: #ed5565;
    }
    .body-wrap .alert.alert-good {
        background: #1ab394;
    }

    .body-wrap .invoice {
        margin: 10px auto;
        text-align: left;
        width: 80%;
    }
    .body-wrap .invoice td {
        padding: 5px 0;
    }
    .body-wrap .invoice .invoice-items {
        width: 100%;
    }
    .body-wrap .invoice .invoice-items td {
        border-top: #eee 1px solid;
    }
    .body-wrap .invoice .invoice-items .total td {
        border-top: 2px solid #333;
        border-bottom: 2px solid #333;
        font-weight: 700;
    }
    #giftItem{
        word-break: break-all;
    }

    /* Add media queries for smaller screens */
    @media screen and (max-width:720px) {
        .days li {width: 13.1%;}
    }

    @media screen and (max-width: 420px) {
        .days li {width: 12.5%;}
        .days li .active {padding: 2px;}
    }

    @media screen and (max-width: 290px) {
        .days li {width: 12.2%;}
    }
</style>

@endsection

@section('content')

<section class="section">

    <div class="section-body">
        <div class="row">

            <!-- Whatsapp Post section -->
            <div class="col-md-6 mb-4">
                <div class="card mb-0 ">
                    <div class="card-header">
                        <h4>Send Current Challenge</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" id="shareForm">
                            <div class="form-group">
                                <label>Enter Whatsapp Number <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="mobile" id="mobile" class="form-control indian-mobile-series" maxlength="10" placeholder="">
                                </div>
                                <span class="text-danger error-section" id="mobileError"></span>
                            </div>
                            <div class="form-group">
                                <label>Enter Name</label>
                                <div class="input-group">
                                    <input type="text" name="name" id="name" class="form-control char-and-spcs-validation" placeholder="">
                                </div>
                                <span class="text-danger error-section" id="nameError"></span>
                            </div>
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <div class="input-group">
                                    <input type="text" name="dob" id="dob" class="form-control" onclick="openDobModal()" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Anniversary Date</label>
                                <div class="input-group">
                                    <input type="text" name="anniversary" id="anniversary" class="form-control" onclick="openAnniversaryModal()" />
                                </div>
                            </div>

                            <button type="submit" id="share_btn" class="btn btn-success"><i class="fa fa-share"></i> &nbsp;Send</button>

                        </form>
                    </div>
                </div>
            </div>

            {{-- Hidden fields --}}
            <input type="hidden" name="redeem_id" value="" />
            <input type="hidden" name="type" value="" />
            <input type="hidden" name="discount_amount" value="" />
            <input type="hidden" name="discount_percent" value="" />
            <input type="hidden" name="discount_perclick" value="" />
            <input type="hidden" name="total_clicks" value="" />
            <input type="hidden" name="calculatedAmount" value="" />

            <div class="col-12 col-md-6 mb-4">
                <div class="card information mb-0_ @if($planData['BusinessUser']->current_account_status == 'free') __pro__ @endif">
                    <div class="card-header ">
                        <h4>Redeem Code</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" id="redeemCodeCheckForm">
                            <div class="form-group">
                                <label>Enter Redeem Code <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="redeem_code" id="redeem_code" class="form-control only-num-and-char" minlength="6" placeholder="" style="text-transform: uppercase;" >
                                </div>
                                <span class="text-danger error-section" id="codeError"></span>
                            </div>
                            {{-- <button type="submit" class="btn btn-success" id="codeApply"><i class="fa fa-gift"></i> &nbsp;Apply</button> --}}

                            @if($userBalance['wallet_balance'] > 0 )
                                <button type="submit" class="btn btn-success" id="codeApply"><i class="fa fa-gift"></i> &nbsp;Apply</button>
                            @else
                                <button type="button" class="btn btn-success" id="zeroBalence"><i class="fa fa-gift"></i> &nbsp;Apply</button>
                            @endif
                        </form>
                        <form method="POST" action="" id="redeemForm"  style="display: none;">
                            
                            <div class="form-group">
                                <label>Bill Amount <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="amount" id="amount" class="form-control two-decimal-only-validation" placeholder="" maxlength="9">
                                </div>
                                <span class="text-danger error-section" id="amountError"></span>
                            </div>

                            <div class="form-group">
                                <label>Invoice Number @if($invoice_required->value == '1') <span style="color: red;">*</span> @endif</label>
                                <div class="input-group">
                                    <input type="text" name="invoice" id="invoice" class="form-control" placeholder="" maxlength="15">
                                </div>
                                <span class="text-danger error-section" id="invoiceError"></span>
                            </div>
                            
                            <div class="form-group" id="gifts" style="display: none">
                                <label for="gift_items">Gift Items</label>
                                <select class="form-control" name="gift_items" id="gift_items" style="font-size: 13px;">
                                
                                </select>
                            </div>

                            <button  type="button" class="btn btn-warning" id="calculate"><i class="fa fa-calculator"></i> &nbsp;Calculate</button>
                            
                            <button  type="submit" class="btn btn-success" id="redeemOffer" disabled><i class="fa fa-gift"></i> &nbsp;Redeem</button>
                        </form>

                        <table class="body-wrap mt-4" id="invoiceDetails" style="display: none">
                            <tbody><tr>
                                <td></td>
                                <td class="container" width="600">
                                    <div class="content">
                                        <table class="main" width="100%" cellpadding="0" cellspacing="0">
                                            <tbody><tr>
                                                <td class="content-wrap aligncenter">
                                                    <table width="100%" cellpadding="0" cellspacing="0">
                                                        <tbody><tr>
                                                            <td class="content-block">
                                                                <h2>Bill Calculation</h2>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="content-block">
                                                                <table class="invoice">
                                                                    <tbody>
                                                                        
                                                                    <tr>
                                                                        <td>
                                                                            <table class="invoice-items" cellpadding="0" cellspacing="0">
                                                                                <tbody><tr>
                                                                                    <td>Bill Amount</td>
                                                                                    <td class="alignright">&#8377; <span id="billAmount">0</span></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Discount (<span id="discount_format"></span>)</td>
                                                                                    <td class="alignright">- &#8377; <span id="discountAmount">0</span></td>
                                                                                </tr>
                                                                                <tr id="giftSection" style="display: none">
                                                                                    <td>Gift</td>
                                                                                    <td class="alignright"><span id="giftItem">-</span></td>
                                                                                </tr>
                                                                                <tr class="total">
                                                                                    <td class="alignright" width="80%">Total Payable</td>
                                                                                    <td class="alignright">&#8377; <span id="billTotal">1000</span></td>
                                                                                </tr>
                                                                            </tbody></table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody></table>
                                                            </td>
                                                        </tr>
                    
                                                    </tbody></table>
                                                </td>
                                            </tr>
                                        </tbody></table>
                    
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                        </tbody></table>
                    </div>
                </div>
                
            </div>

        </div>
    </div>
</section> 
    <!-- Modal -->
    <div class="modal ol-modal popin" aria-hidden="true" id="date-month-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="font-600 color-primary mb-0">Select Month & Date</h6>
                    <a href="#" class="close_calendar" aria-hidden="true">&times;</a>
                </div>
                <div class="modal-body">
                    <div class="custom_calendar form-type-one">
                        <div class="form-group mb-3">
                            <select id="monthNo" class="form-control monthChange">
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div>
                            <ul class="days"> 
                                @for($x = 1; $x <= 31; $x++)
                                    <li class="dateSelected" id="{{ $x }}">{{ $x }}</li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                </div>
                {{-- <div class="modal-footer">
                    <button class="btn btn-primary" onclick="removeDate()">Remove Date</button>
                </div> --}}
            </div>
        </div>
    </div>
    <!-- /Modal -->  

@endsection
@section('end_body')
<script>
    /* Pre Defined Variables */
    var $calender = $('#date-month-modal');

    function openDobModal(){
        $("#dob").blur();

        if($("#dob").val()!=""){
            var date = $("#dob").val().split(' ');
            showSelectDate(date[0]);
            showSelectMonth(date[1]);
        }
        else{
            showSelectDate("{{ date('d') }}");
            showSelectMonth("{{ date('F') }}");
        }
        $calender.removeClass('anniversary_modal').addClass('dob_modal').modal('show');

    }

    function openAnniversaryModal(){
        $("#anniversary").blur();

        if($("#anniversary").val()!=""){
            var date = $("#anniversary").val().split(' ');
            showSelectDate(date[0]);
            showSelectMonth(date[1]);
        }
        else{
            showSelectDate("{{ date('d') }}");
            showSelectMonth("{{ date('F') }}");
        }
        $calender.removeClass('dob_modal').addClass('anniversary_modal').modal('show');

    }

    function closeModal(){
        $calender.removeClass("dob_modal");
        $calender.removeClass("anniversary_modal");
        $calender.modal('hide');
    }

    function removeDate(){
        if($calender.hasClass("dob_modal")){
            $("#dob").val('');
            $calender.removeClass("dob_modal");
        }
        if($calender.hasClass("anniversary_modal")){
            $("#anniversary").val('');
            $calender.removeClass("anniversary_modal");
        }
    }

    $calender.delegate( ".monthChange", "change", function(e) {
        var month = $(this).val();
        var days = 31;
        if(month == 2){
            days = 29;
        }
        if(month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month == 12){
            days = 31;
        }
        if(month == 4 || month == 6 || month == 9 || month == 11){
            days = 30;
        }

        $(".days").empty();

        for (let i = 1; i <= days; i++) {
            $(".days").append('<li class="dateSelected" id="'+i+'">'+i+'</li>');
        }
    });

    $calender.delegate( ".dateSelected", "click", function(e) {
        e.preventDefault();
        var day = $(this).attr("id");
        var month = $(".monthChange").val();
        var date = day +' '+ $(".monthChange option[value='"+month+"']").text();
        if($calender.hasClass("dob_modal")){
            $("#dob").val(date);
        }
        if($calender.hasClass("anniversary_modal")){
            $("#anniversary").val(date);
        }
        closeModal();
    });
    
    $calender.delegate( ".close_calendar", "click", function(e) {
        e.preventDefault();
        closeModal();
    });
    
    function showSelectDate(date){
      $(".dateSelected").removeClass("selected-date");
      $("#"+date).addClass("selected-date");
    }

    function showSelectMonth(month){
      var monthNo=1;
      if(month!="" || month!=undefined){
        if(month=='January'){
          monthNo = 1;
        }
        else if(month=='February'){
          monthNo = 2;
        }
        else if(month=='March'){
          monthNo = 3;
        }
        else if(month=='April'){
          monthNo = 4;
        }
        else if(month=='May'){
          monthNo = 5;
        }
        else if(month=='June'){
          monthNo = 6;
        }
        else if(month=='July'){
          monthNo = 7;
        }
        else if(month=='August'){
          monthNo = 8;
        }
        else if(month=='September'){
          monthNo = 9;
        }
        else if(month=='October'){
          monthNo = 10;
        }
        else if(month=='November'){
          monthNo = 11;
        }
        else if(month=='December'){
          monthNo = 12;
        }
      }
      $("#monthNo").val(monthNo);
    }
</script>
<script>

    $(document).ready(function() {

        $(document).on('keyup', '#dob', function(){
            openDobModal();
        });

        $(document).on('keyup', '#anniversary', function(){
            openDobModal();
        });
       
        $('#shareForm').on('submit', function(event) {
           event.preventDefault();

           /* If dont have running offer or not posted */
           var is_posted = {{ $planData['is_posted'] }};
            if(is_posted == 0){
                Sweet("error", "First Create and Post offer on Social Media.");
                return false;
            }


           $('.error-section').text('');

           var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
           var btn = $('#share_btn');

            var $data = {
                'mobile' : $("#mobile").val(),
                'name' : $("#name").val(),
                'dob' : $("#dob").val(),
                'anniversary' : $("#anniversary").val(),
                '_token' : CSRF_TOKEN
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            });
            $.ajax({
                url: "{{ route('employee.shareOffer') }}",
                type: "post",
                dataType: "json",
                data: $data,
                beforeSend: function() {
                    btn.attr('disabled','').addClass('btn-progress');
                },
                success: function(response) {
                    if(response.status == true){
                        Sweet('success', response.message);
                        $("#mobile").val('');
                        $("#name").val('');
                        $("#dob").val('');
                        $("#anniversary").val('');
                    }else{
                        Sweet('error', response.message);
                    }
                    
                    
                    btn.removeAttr('disabled').removeClass('btn-progress');
                },
                error: function(response) {
                    console.log(response.responseJSON.errors);
                    $('#nameError').text(response.responseJSON.errors.name);
                    $('#mobileError').text(response.responseJSON.errors.mobile);
                    
                    btn.removeAttr('disabled').removeClass('btn-progress');
                },
                complete: function(){
                    btn.removeAttr('disabled').removeClass('btn-progress');
                }
           })

        });

       //get Customer info
        $('#mobile').on('keyup', function(event) {
            var mobile = $(this).val();
            var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;

            if(filter.test(mobile) == true && mobile.length == 10){
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                var $data = {
                    'mobile' : $("#mobile").val(),
                    '_token' : CSRF_TOKEN
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                });
                $.ajax({
                    url: "{{ route('employee.customerInfo') }}",
                    type: "post",
                    dataType: "json",
                    data: $data,
                    success: function(response) {
                        if(response.status == true){
                            $("#name").val(response.data.customer_info.name);
                            $("#dob").val(response.data.customer_info.dob);
                            $("#anniversary").val(response.data.customer_info.anniversary_date);
                        }else{
                            $("#name").val('');
                            $("#dob").val('');
                            $("#anniversary").val('');
                        }
                    },
                    error: function(response) {
                        //
                    }
                })
            }else{
                $("#name").val('');
                $("#dob").val('');
                $("#anniversary").val('');
                return false;
            }

        });

        $('#redeemCodeCheckForm').on('submit', function(event) {
           event.preventDefault();
           $('.error-section').text('');

           var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
           var btn = $('#codeApply');

            var $data = {
                'redeem_code' : $("#redeem_code").val(),
                '_token' : CSRF_TOKEN
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            });
            $.ajax({
                url: "{{ route('employee.applyRedeemCode') }}",
                type: "post",
                dataType: "json",
                data: $data,
                beforeSend: function() {
                    btn.attr('disabled','').addClass('btn-progress');
                },
                success: function(response) {
                    if(response.status == true){
                        $("#redeemCodeCheckForm").hide();
                        $("#redeemForm").show();

                        $('input[name="redeem_id"]').val(response.redeemDetails.redeem_id);
                        $('input[name="type"]').val(response.redeemDetails.type);
                        $('input[name="total_clicks"]').val(response.redeemDetails.total_clicks);

                        if(response.redeemDetails.type == "Gift"){
                            var gifts = response.redeemDetails.details.gift.split(",");
                            $("#gifts").show();
                            $.each(gifts, function( index, value ) {
                                //console.log( index + ": " + value );
                                $("#gift_items").append('<option value="'+value+'">'+value+'</option>');
                            });
                        }
                        
                        if(response.redeemDetails.type == "Cash Per Click"){
                            $('input[name="discount_perclick"]').val(response.redeemDetails.details.discount_perclick);
                        }

                        if(response.redeemDetails.type == "Fixed Amount"){
                            $('input[name="discount_amount"]').val(response.redeemDetails.details.discount_amount);
                        }

                        if(response.redeemDetails.type == "Percentage Discount"){
                            $('input[name="discount_percent"]').val(response.redeemDetails.details.discount_percent);
                        }
                    }else{
                        Sweet('error', response.message);
                    }
                    
                    btn.removeAttr('disabled').removeClass('btn-progress');
                },
                error: function(response) {
                    // console.log(response);
                    $('#codeError').text(response.responseJSON.errors.redeem_code);
                    
                    btn.removeAttr('disabled').removeClass('btn-progress');
                },
                complete: function(){
                    btn.removeAttr('disabled').removeClass('btn-progress');
                }
           })

        });

        //calculate
        $('#calculate').on('click', function(event) {
            // console.log('calculate');
            $('.error-section').text('');
            var type = $('input[name="type"]').val();
            
            var amount = $('#amount').val();
            if (!isNaN(amount) && amount != 0 && amount != -1 && amount != -0) {
				$("#billAmount").text(amount);
			}else{
				$('#amountError').text('Please enter valid amount!');
                return false;
			}

            var invoice_required = @json($invoice_required);
            if(invoice_required.value == '1'){
                var invoice = $('#invoice').val();
                if (invoice == null || invoice == '' || invoice.length < 4) {
                    $('#invoiceError').text('Please enter valid invoice number!');
                    return false;
                }
            }

            var total = 0;
            var discount = 0;

            if(type == 'Gift'){
                $("#giftSection").show();
                var gift = $("#gift_items").val();
                $("#giftItem").text(gift);             

                total = amount;

                $("#discount_format").text('Gift');
            }

            if(type == 'Cash Per Click'){
                var discount_perclick = $('input[name="discount_perclick"]').val();
                var total_clicks = $('input[name="total_clicks"]').val();
                
                discount = discount_perclick * total_clicks;
                total = amount - discount;

                $("#discount_format").text('₹ '+discount_perclick+' X '+total_clicks+' clicks');
            }

            if(type == 'Fixed Amount'){
                var discount_amount = $('input[name="discount_amount"]').val();
                
                discount = discount_amount;
                total = amount - discount;

                $("#discount_format").text('₹ '+discount_amount);
            }

            if(type == 'Percentage Discount'){
                var discount_percent = $('input[name="discount_percent"]').val();

                discount = amount * discount_percent/100;
                total = amount - discount;

                $("#discount_format").text(discount_percent+'%');
            }
            
            $('input[name="calculatedAmount"]').val(total);
            if(total <= 0){
                total = 0;
            }

            $("#discountAmount").text(discount);
            // $("#billTotal").text(total);
            $("#billTotal").text(total.toFixed(2));

            $("#invoiceDetails").show();
            $("#calculate").prop("disabled", true);
            $("#redeemOffer").prop("disabled", false);
        });

        //change amount
        $('#amount').on('keyup', function(event) {
            $("#invoiceDetails").hide();
            $("#redeemOffer").prop("disabled", true);
            $("#calculate").prop("disabled", false);
        });

        var invoice_required = @json($invoice_required);
        if(invoice_required.value == '1'){
            $('#invoice').on('keyup', function(event) {
                $("#invoiceDetails").hide();
                $("#redeemOffer").prop("disabled", true);
                $("#calculate").prop("disabled", false);
            });
        }

        $('#gift_items').on('change', function(event) {
            $("#invoiceDetails").hide();
            $("#redeemOffer").prop("disabled", true);
            $("#calculate").prop("disabled", false);
        });

        $('#redeemForm').on('submit', function(event) {
            event.preventDefault();
            $('.error-section').text('');

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var btn = $('#redeemOffer');

            var no_of_clicks = $('input[name="total_clicks"]').val();
            var type = $('input[name="type"]').val();
            if(type == 'Gift'){
                $("#giftSection").show();
                var gift = $("#gift_items").val();
                $("#giftItem").text(gift);             

                total = amount;

                $("#discount_format").text('Gift');
            }

            if(type == 'Cash Per Click'){
                var discount_value = $('input[name="discount_perclick"]').val();
            }

            if(type == 'Fixed Amount'){
                var discount_value = $('input[name="discount_amount"]').val();
            }

            if(type == 'Percentage Discount'){
                var discount_value = $('input[name="discount_percent"]').val();
            }

            // var billTotal = parseInt($("#billTotal").text(), 10);
            // var billAmount = parseInt($("#billAmount").text(), 10);
            // var discount_received = parseInt($("#discountAmount").text(), 10);
            
            var billTotal = $("#billTotal").text();
            var billAmount = $("#billAmount").text();
            var discount_received = $("#discountAmount").text();

            var calculated_amount = $('input[name="calculatedAmount"]').val();
            
            var $data = {
                'redeem_id' : $('input[name="redeem_id"]').val(),
                'type': type,
                'discount_value': discount_value,
                'no_of_clicks': no_of_clicks,
                'redeem_amount': billTotal,
                'actual_amount': billAmount,
                'calculated_amount': calculated_amount,
                'discount_received': discount_received,
                '_token' : CSRF_TOKEN
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            });
            $.ajax({
                url: "{{ route('employee.redeemOffer') }}",
                type: "post",
                dataType: "json",
                data: $data,
                beforeSend: function() {
                    btn.attr('disabled','').addClass('btn-progress');
                },
                success: function(response) {
                    if(response.status == true){
                        $("#redeem_code").val('');
                        $("#invoiceDetails").hide();
                        $("#redeemCodeCheckForm").show();
                        $("#redeemForm").hide();
                        $("#amount").val('');
                        $("#invoice").val('');

                        Sweet('success', response.message);
                    }else{
                        Sweet('error', response.message);
                    }
                    
                    
                    btn.removeAttr('disabled').removeClass('btn-progress');
                },
                error: function(response) {
                    // console.log(response);
                    $('#codeError').text(response.responseJSON.errors.redeem_code);
                    
                    btn.removeAttr('disabled').removeClass('btn-progress');
                },
                complete: function(){
                    btn.removeAttr('disabled').removeClass('btn-progress');
                }
           })

        });
    });

    
</script>
<script>
    $(document).on('click', '#zeroBalence', function(){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Sweet('error',"{{ Config::get('constants.payment_alert')}}");
    })
</script>
@endsection