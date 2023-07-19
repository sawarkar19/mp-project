@extends('layouts.business')
@section('title', 'Business: Create Customer')
@section('head')
@include('layouts.partials.headersection',['title'=>'Create Customer'])
@endsection
@section('end_head')
    <link rel="stylesheet" href="{{ asset('assets/auth/css/register.css') }}">
    <style>
        .mobile-error,
        .email-error{
            color: #ff0000;
            font-size: 15px;
            text-align: center;
        }
        label .star{
          color: red;
        }
    </style>
@endsection
@section('content')

 <div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">

        <div class="success"></div>
        <div class="error"></div>
        
        <form class="basicform" id="basicform" method="post" action="{{ route('business.customer.store') }}">
            @csrf
            <div class="card-body">
                <div id="front_page">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="mobile">{{ __('WhatsApp No.') }} <span class="star">*</span>
                            </label>
                            <input id="mobile" type="tel" class="form-control no-space-validation number-validation" value="" name="mobile" maxlength="10" required>
                            <div class="mobile-error"></div>
                        </div>
                        <div class="form-group col-12">
                            <label for="frist_name">{{ __('Name') }}</label>
                            <input id="first_name" type="text" class="form-control two-space-validation char-spcs-validation" value="" name="customer_name">
                        </div>

                        <div class="form-group col-12">
                            <label for="dob">Date of Birth</label>
                            <input type="date" id="dob" name="dob" class="form-control" value="">
                        </div>

                        <div class="form-group col-12">
                            <label for="anniversary_date">Anniversary Date</label>
                            <input type="date" id="anniversary_date" name="anniversary_date" class="form-control" value="">
                        </div>


                        {{-- <div class="form-group col-12">
                            <label for="email">{{ __('Email') }}</label>
                            <input id="email" type="email" class="form-control" value="" name="customer_email">
                            <div class="email-error"></div>
                        </div> --}}
                    </div>
                </div>
                <div class="form-group">
                    <input type="button" id="button_otp" class="btn btn-primary btn-lg btn-block basicbtn" value="Save" onClick="saveCustomer();">
                </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('end_body')
    <script src="{{ asset('assets/js/admin/register.js') }}"></script>
    <script src="{{ asset('assets/js/input-validation.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            setTimeout('$("#error").hide()',3000);
            setTimeout('$("#success").hide()',3000);
        });
    </script>
    @include('auth.scripts.validation')

    <script type="text/javascript">
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      function saveCustomer() {

        if ($('#basicform').valid()) /* check if form is valid */
        {
          $(".mobile-error").val('');
          $(".email-error").val('');

          var name = $("#first_name").val();
          var email = $("#email").val();
          var number = $("#mobile").val();
          var dob = $("#dob").val();
          var anniversary_date = $("#anniversary_date").val();

          if (number.length == 10 && number != null) {
            var input = {
              "mobile" : number,
              "name" : name,
              "email" : email,
              "dob" : dob,
              "anniversary_date" : anniversary_date,
              "_token" : CSRF_TOKEN
            };
            $.ajax({
              url : "{{ route('business.customer.store') }}",
              type : 'POST',
              data : input,
              dataType : "json",
              success : function(response) {

                if(response.success == true){
                    Sweet('success',response.message);  
                    $('#basicform').trigger('reset');
                }else{
                    Sweet('error',response.message);
                }  
                  
              },
              error: function(xhr, status, error) 
              {
                  $.each(xhr.responseJSON.errors, function (key, item) 
                  {
                      Sweet('error',item);
                  });
              }
            });
          } else {
            $(".error").html('Please enter a valid number!');
            $(".error").show();   
            $(".success").hide();
          }
        }
      }


      
        $(function(){
            var dtToday = new Date();
            
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();
            
            var maxDate = year + '-' + month + '-' + day;
            $('#anniversary_date').attr('max', maxDate);
            $('#dob').attr('max', maxDate);
        });

    </script>
@endsection

