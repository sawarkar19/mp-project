@extends('layouts.partner')
@section('title', 'Payment Details: Partner Panel')
@section('head')
    @include('layouts.partials.headersection',['title'=>'User Details'])
@endsection

@section('end_head')

    @include('partner.plan.style')
    
    <style>
        #or {
            position: relative;
            width: 300px;
            height: 50px;
            line-height: 50px;
            text-align: center;
        }

        #or::before,
        #or::after {
            position: absolute;
            width: 130px;
            height: 1px;
            top: 24px;
            background-color: #aaa;
            content: '';
        }

        #or::before {
            left: 0;
        }
        #or::after {
            right: 0;
        }

        #continueBtn {
            width: fit-content;
            margin: 10px;
        }

        .partner-form .card-header{
            font-weight: bold;
            font-size: 16px;
        }
    </style>


@endsection

@section('content')
<section id="pricing">

    <form method="POST" action="{{ route('business.partner.updateUserDetail') }}" id="userDetailForm">
    @csrf
    
    <div class="partner-form">
        <div class="card">  
            <div class="card-header">Create New User</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-3">
                      <label  for="business_name">{{ __('Name') }}<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="business_name" name="business_name">
                    </div>
                    
                    <div class="form-group col-md-5">
                      <label for="business_email">{{ __('Email') }}<span class="text-danger">*</span></label>
                      <input type="email" class="form-control" id="business_email" name="business_email">
                    </div>

                    <div class="form-group col-md-4">
                      <label for="business_mobile">{{ __('Whatsapp Number') }}<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="business_mobile" name="business_mobile">
                    </div>
                </div>
            </div>

            
            <div id="or">OR</div>

            <div class="card-header">Select Existing User</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                      <label  for="old_user">{{ __('Select user') }}<span class="text-danger">*</span></label>
                        <select id="old_user" name="old_user" class="form-control">
                            <option value="">----- Select ------</option>
                            @foreach ($old_users as $user)
                                <option value="{{ $user->id }}">{{ ucfirst($user->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary" id="continueBtn">Continue</button>
        </div>
    </div>

    </form>
    
</section>

@endsection
@section('end_body')

<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $("#userDetailForm").on('submit', function(e){
            e.preventDefault();

            if($("#old_user").val() == ''){
                if($("#business_name").val() == '' || $("#business_email").val() == '' || $("#business_mobile").val() == ''){
                    Sweet("error", "Required fields can not empty.");
                    return false;
                }

                if($("#business_name").val().length < 2 || $("#business_name").val().length > 30){
                    $("#business_name").focus();
                    Sweet("error", "Name is either too short or too long.");
                    return false;
                }

                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                var email = $("#business_email").val();
                if(!regex.test(email)) {
                    $("#business_email").focus();
                    Sweet("error", "Please enter a valid email address.");
                    return false;
                }

                if($("#business_mobile").val().length != 10){
                    $("#business_mobile").focus();
                    Sweet("error", "Please enter 10 digit mobile number.");
                    return false;
                }
            }else{
                if($("#business_name").val() != '' || $("#business_email").val() != '' || $("#business_mobile").val() != ''){
                    Sweet("error", "You can not enter both New and Existing data.");
                    return false;
                }
            }

            var btn = $("#continueBtn");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: this.action,
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function() {	       			
	       			btn.attr('disabled','')
	       			btn.html('Please Wait....')
	    		},
                success: function(response){ 
                    if(response.status == true){
                        window.location.href = response.link;
                    }else{
                        Sweet('error', response.message);
                        btn.removeAttr('disabled');
					    btn.html('Continue');
                    }
                },
                error: function(xhr, status, error) 
                {

                    Sweet('error', "Please try again later.");

                    btn.removeAttr('disabled');
					btn.html('Continue');
                }
            })
        });
    });
</script>

@endsection