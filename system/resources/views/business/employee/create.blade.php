@extends('layouts.business')
@section('title', 'Business: Create User')
@section('head')
@include('layouts.partials.headersection',['title'=>'Create User'])
@endsection
@section('end_head')
    <!-- <link rel="stylesheet" href="{{ asset('assets/auth/css/register.css') }}"> -->
    <style>
        .mobile-error,
        .email-error{
            color: #ff0000;
            font-size: 15px;
            text-align: center;
        }
        label.error{
          width: 100%;
        }
        label .star{
          color: red;
        }
        
    </style>
@endsection
@section('content')

 <div class="row">
  <div class="col-md-6 offset-md-3">
    <div class="card">
        <div class="card-header">
            <h4>User Details</h4>
        </div>
      <div class="card-body">

        <div class="success"></div>
        <div class="error"></div>
        
        <form class="basicform" id="basicform" method="post" action="{{ route('business.employee.store') }}">
            @csrf
      
                <div id="front_page">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="frist_name">{{ __('User Name') }} <span class="star">*</span>
                            </label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  <i class="fas fa-user"></i>
                                </div>
                              </div>
                              <input id="first_name" type="text" class="form-control three-space-validation char-spcs-validation" value="" name="name" required>
                            </div>
                            
                        </div>
                        <div class="form-group col-12">
                            <label for="mobile">{{ __('Mobile No.') }} <span class="star">*</span>
                            </label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  <i class="fas fa-phone-alt"></i>
                                </div>
                              </div>
                               <input id="mobile" type="tel" class="form-control no-space-validation number-validation" value="" name="mobile" maxlength="10" required>
                            <div class="mobile-error"></div>
                            </div>
                            
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="password">{{ __('Password') }} <span class="star">*</span>
                            </label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  <i class="fas fa-lock"></i>
                                </div>
                              </div>
                               <input id="password" type="password" class="form-control no-space-validation" value="" name="password" required>
                            </div>
                           
                        </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-12">
                        <label for="status">{{ __('Status') }} <span class="star">*</span>
                        </label>
                        <select class="form-control" name="status" id="status">
                          <option value="1" >{{ __('Active') }}</option>
                          <option value="0" >{{ __('Deactivated') }}</option>
                        </select>
                      </div>
                    </div>

                </div>
                    <input type="button" id="button_otp" class="btn btn-primary btn-lg basicbtn" value="Save" onClick="saveEmployee();">
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
      function saveEmployee() {

        if ($('#basicform').valid()) /* check if form is valid */
        {
          $(".mobile-error").val('');
          /*$(".email-error").val('');*/

          var name = $("#first_name").val();
          var password = $("#password").val();
          /*var email = $("#email").val();*/
          var number = $("#mobile").val();
          var status = $("#status").val();

          if (number.length == 10 && number != null) {

            if(status==1){

              $.ajax({
                url : "{{ route('business.employees.checkEmployeeLogin') }}",
                type : 'POST',
                data:{
                  type: 'checkDeductions',
                  form_type: 'addUser',
                  _token: "{{ csrf_token() }}"
                },
                dataType : "json",
                success : function(response) {
                  console.log("checkEmployeeLogin " + response);

                  if(response.status==true && response.code=="deduction_popup_show"){
                    var empDeductMsg = "Rs. {{ $deductionDetail->amount ?? 0 }} will be deducted from your wallet balance for each active employee.";

                    Swal.fire({
                      title: '<strong>Please Note</strong>',
                      html: empDeductMsg,
                      icon: 'info',
                      showCloseButton: false,
                      showCancelButton: true,
                      focusConfirm: false,
                      allowOutsideClick: false,
                      confirmButtonText: 'Accept',
                      cancelButtonText: 'Cancel'
                    }).then((result) => {
                        // console.log(result.value);
                        if (result.value == true) {
                          $.ajax({
                            url : "{{ route('business.employees.checkEmployeeLogin') }}",
                            type : 'POST',
                            data:{
                              type: 'checkBalance',
                              _token: "{{ csrf_token() }}"
                            },
                            dataType : "json",
                            success : function(response) {
                              if(response.status==true){
                                var input = {
                                  "mobile" : number,
                                  "name" : name,
                                  /*"email" : email,*/
                                  "password" : password,
                                  "status" : status,
                                  "_token" : CSRF_TOKEN
                                };
                                ajaxCall(input);
                              }
                              else{
                                Swal.fire({
                                  title: response.message,
                                  icon: 'info',
                                  html: "or create deactive user",
                                  showCloseButton: false,
                                  showCancelButton: true,
                                  focusConfirm: false,
                                  allowOutsideClick:false,
                                  confirmButtonText: 'Recharge now',
                                  cancelButtonText:  'Close'
                                }).then((result) => {
                                  console.log(result);
                                  if (result.value == true) {
                                      window.open('{{ route("pricing") }}', '_blank');
                                  }
                                })
                              }
                            }
                          });
                        }
                    });
                  }else{
                    var input = {
                      "mobile" : number,
                      "name" : name,
                      /*"email" : email,*/
                      "password" : password,
                      "status" : status,
                      "_token" : CSRF_TOKEN
                    };
                    ajaxCall(input);
                  }

                }
              });
            }
            else{
              var input = {
                "mobile" : number,
                "name" : name,
                /*"email" : email,*/
                "password" : password,
                "status" : status,
                "_token" : CSRF_TOKEN
              };
              ajaxCall(input);
            }
          } else {
            $(".error").html('Please enter a valid number!');
            $(".error").show();   
            $(".success").hide();
          }
        }
      }

      function ajaxCall(input){
        $.ajax({
          url : "{{ route('business.employee.store') }}",
          type : 'POST',
          data : input,
          dataType : "json",
          success : function(response) {  
            if(response.success == true){
                Sweet('success',response.message);  
                window.location.href = response.url;
                // $('#basicform').trigger('reset');
            }else{
                Sweet('error',response.message);
            } 
          }
        });
      }
    </script>
@endsection

