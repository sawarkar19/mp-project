<script type="text/javascript">
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	function sendOTP() {

		if ($('#basicform').valid()) /* check if form is valid */
		{
			$(".mobile-error").val('');
			$(".email-error").val('');

			if ($('#mobile_resend').val().length != 0) {
				var number = $("#mobile_resend").val();
			}else{
				var number = $("#mobile").val();	 
			}
			var name = $("#name").val();
			var password = $("#password").val();
			var email = $("#email").val();

			if (number.length == 10 && number != null) {
				var input = {
					"mobile_number" : number,
					"name" : name,
					"email" : email,
					"password" : password,
					"action" : "send_otp",
					"_token" : CSRF_TOKEN
				};

				$('.send-otp-btn').val('Please Wait...');
				$('.send-otp-btn').prop("disabled",true);

				$.ajax({
					url : '{{ route('send_otp') }}',
					type : 'POST',
					data : input,
					dataType : "json",
					success : function(response) {		

						$('.send-otp-btn').prop("disabled",false);
						$('.send-otp-btn').val('Register Now');

						if(response.type == "error"){

							if(response.for == "mobile"){

								// $(".error").html(response.message);
								//$(".mobile-error").html(response.message);
								Sweet('error',response.message);
								$("#mobile").val('');

							}else if(response.for == "email"){
								// $(".error").html(response.message);
								//$(".email-error").html(response.message);
								Sweet('error',response.message);
								$("#email").val('');
							}else{								
								//$(".mobile-error").html(response.message);
								Sweet('error',response.message);
							}

						}else if(response.type == "success"){

							$('#__regisFrm__').hide();
							$('#__otpFrm__').show();
							if(response.otp_count >= 3){
								$('.otp-massage').html('OTP usage limit exceeded for today.');
								$('.otp-massage').show();
                        		$('.resend-count').hide();
								$('.js-timeout').hide();
								$('#ReSendOtpBtn').hide();
							}

							$('#home_tab').css('pointer-events','none')
							$("#valedit").val(response.sessionVal);
							$("#otp").val('');
							$("#mobile_resend").val('');
							$('#__chngPhFrm__').hide();

				            $('.js-timeout').text("2:00");
				            countdown();
            				$('#_OTP_Form_').show();
       //      				$('#otpColDiv').show();
						}
					}
				});
			} else {
				$(".error").html('Please enter a valid number!');
				$(".error").show();		
				$(".success").hide();
			}
		}
	}

	function showLoader(){
		var loader = document.getElementById("loading_icon");
		loader.style.display = 'inline-block';  
	}

	function hideLoader(){
		var loader = document.getElementById("loading_icon");
		loader.style.display = 'none';
	}

	function verifyOTP() {

		var otp = $("#otp").val();
		var number_verf = $("#valedit").val();

		if (otp.length == 6 && otp != null) {

			showLoader();
			$('#button_otpVer').prop('disabled','disabled');

			var inputVal = {	
				"mobile_number" : number_verf,
				"otp" : otp,		
				"action" : "verify_otp",
				"_token" : CSRF_TOKEN
			};

			$.ajax({
				url : '{{ route('verify_otp') }}',
				type : 'POST',
				dataType : "json",
				data : inputVal,
				success : function(response) {
					/*console.log(response);*/
					
					hideLoader();
					$('#button_otpVer').prop('disabled','');

					if(response.type == "error"){
						$(".text-error").show();
						$(".text-error").html(response.message);
						$(".error").html(response.message);
						$(".text-success").hide();
						$(".error").show();
						$("#otp").val('');
						$(".success").hide();
					}

					if(response.type == "success"){


						
						$("#Title").html('Registration Successful');
						$(".success").html(response.message);
						$(".text-success").hide();	
						$(".success").show();
						$(".error").hide();
						$(".text-error").hide();
						// $("#third_page").show();
						$("#front_page").hide();
						$("#second_page").hide();
						// $("#button_otpVer").hide();
						$("#button_otp").hide();
						// $("#payment").show();

						// SalesRobo Submit
						var mtc_form = $("form#mauticform_registerorsignupform");
						var bobo = submit_bobo_form(mtc_form);

						window.location.href = response.url;
						
					}
				}
			});
		} else {
			$(".error").html('You have entered wrong OTP.')
			$(".error").show();
			$(".success").hide();
		}

	}

	function resendOTP() {

		$(".mobile-error").val('');
		$(".email-error").val('');
		$(".text-error").hide();

		if ($('#mobile_resend').val().length != 0) {
			var number = $("#mobile_resend").val();
		}else{
			var number = $("#mobile").val();	 
		}
		var name = $("#name").val();
		var password = $("#password").val();
		var email = $("#email").val();
		var input = {
			"mobile_number" : number,
			"name" : name,
			"email" : email,
			"password" : password,
			"action" : "resend_otp",
			"_token" : CSRF_TOKEN
		};

		$('#ReSendOtpBtn').prop("disabled",true);

		$.ajax({
			url : '{{ route('resend_otp') }}',
			type : 'POST',
			data : input,
			dataType : "json",
			success : function(response) {	

				$('#ReSendOtpBtn').prop("disabled",false);	

				if(response.type == "error"){

					if(response.for == "mobile"){

						// $(".error").html(response.message);
						$(".mobile-error").html(response.message);
						$("#mobile").val('');

					}else if(response.for == "email"){
						// $(".error").html(response.message);
						$(".email-error").html(response.message);
						$("#email").val('');
					}

				}else if(response.type == "success"){

					$('#__regisFrm__').hide();
					$('#__otpFrm__').show();
					if(response.otp_count >= 3){
						$('.otp-massage').html('OTP usage limit exceeded for today.');
						$('.otp-massage').show();
                		$('.resend-count').hide();
						$('.js-timeout').hide();
						$('#ReSendOtpBtn').hide();
					}else{

			            $('.js-timeout').text("2:00");
			            countdown();

					}

					$('#home_tab').css('pointer-events','none')
					$("#valedit").val(response.sessionVal);
					$("#otp").val('');
					$("#mobile_resend").val('');
					$('#__chngPhFrm__').hide();
    				$('#_OTP_Form_').show();
				}
			}
		});
	}
</script>