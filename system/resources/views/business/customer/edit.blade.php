@extends('layouts.business')
@section('title', 'Edit Customer: Business Panel')
@section('head')
    @include('layouts.partials.headersection',['title'=>'Edit Customer'])
@endsection

@section('end_head')
<style>
    .selected-date{
      color: #ffffff;
      background-color: var(--primary);
      border-radius: 4px;
    }

    #date-month-modal .modal-dialog{
        pointer-events: all;
    }
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
                <div class="card mb-0">
                    <div class="card-header justify-content-between">
                        <h4>Edit Customer</h4>
                        <a href="#" class="info-btn" data-toggle="tooltip"  title="Enter these basic customer’s details to share your current Instant Challenge Offer."><i class="fa fa-info-circle"></i></a>
                    </div>
                    <div class="card-body">

                        @php                        
                          $name = isset($info->detail->name) ? $info->detail->name : ''; 
                          $dob = isset($info->detail->dob) ? $info->detail->dob : '';
                          $anniversary_date = isset($info->detail->anniversary_date) ? $info->detail->anniversary_date : '';
                        @endphp

                        <form method="POST" action="{{ route('business.customer.update',$info->id) }}" id="updateContactForm">
                            <div class="form-group">
                                <label>Enter Mobile Number <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="mobile" id="mobile" class="form-control no-space-validation number-validation" maxlength="10" placeholder="Enter mobile number" value="{{ $info->mobile }}" disabled>
                                </div>
                                <span class="text-danger error-section" id="mobileError"></span>
                            </div>
                            <div class="form-group">
                                <label>Enter Name</label>
                                <div class="input-group">
                                    <input type="text" name="name" id="name" class="form-control two-space-validation char-spcs-validation" value="{{ $name }}" placeholder="Enter name" >
                                </div>
                                <span class="text-danger error-section" id="nameError"></span>
                            </div>
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <div class="input-group">
                                    <input type="text" name="dob" id="dob" class="form-control" value="{{ $dob }}" onclick="openDobModal()" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Anniversary Date</label>
                                <div class="input-group">
                                    <input type="text" name="anniversary" id="anniversary" class="form-control" value="{{ $anniversary_date }}" onclick="openAnniversaryModal()" />
                                </div>
                            </div>

                            <button type="submit" id="btnUpdate" class="btn btn-success"> &nbsp;Update</button>

                        </form>
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
                  url: "{{ route('business.customerInfo') }}",
                  type: "post",
                  dataType: "json",
                  data: $data,
                  success: function(response) {
                      if(response.status == true){
                          $("#name").val(response.data.info.name);
                          $("#dob").val(response.data.info.dob);
                          $("#anniversary").val(response.data.info.anniversary_date);
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

      $("#updateContactForm").on('submit', function(event) {
          event.preventDefault();

          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          var btn = $('#btnUpdate');

          var $data = {
            // 'mobile' : $("#mobile").val(),
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
                url: "{{ route('business.customer.update', $info->id) }}",
                type: "PUT",
                dataType: "json",
                data: $data,
                beforeSend: function() {
                    // btn.attr('disabled','').addClass('btn-progress');
                },
                success: function(response) {
                  console.log(response);
                    if(response.success == true){
                        Sweet('success', response.message);
                        setTimeout(function () {
                            window.location.href = "{{ route('business.viewGroup', request()->get('group_id')) }}";
                        }, 100);

                    }else{
                        Sweet('error', response.message);
                    }
                    btn.removeAttr('disabled').removeClass('btn-progress');
                },
                error: function(response) {
                    console.log(response.responseJSON.errors);
                    $('#nameError').text(response.responseJSON.errors.name);
                    // $('#mobileError').text(response.responseJSON.errors.mobile);
                    btn.removeAttr('disabled').removeClass('btn-progress');
                },
                complete: function(){
                    btn.removeAttr('disabled').removeClass('btn-progress');
                }
          });

      });
  });    
</script>
@endsection