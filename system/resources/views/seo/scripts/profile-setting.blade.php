<script>
	function resendOTP(){
	    $("#verify_input").hide();
		$("#enter_input").show();
		$("#OtpBtn").show();	
		$("#VrfBtn").hide();
		$(".error").hide();
		$(".success").hide();
		$("#resend_name").show();
		$("#mobile_label").hide();
		$("#mobile").val('');
	}
	
	function sendOTP() {
		$(".error").html('');
		$.validator.addMethod("notEqualTo", function(value, element){
			return this.optional(element) || value != '0000000000';
		},"Shoule not accept '0000000000'");

		$('#basicformMobile').validate({
			rules: {				
				mobile: {
					required: true,
					rangelength: [10, 10],
					number: true,
					notEqualTo: true,
					minlength: 10
				}
			},
			messages: {
				mobile: {
					required: 'Please enter valid mobile number.',
					rangelength: 'Mobile number should be 10 digit long.',
					minlength: 'Mobile number should be 10 digit long.',
				}
			}
		});
	
		if ($('#basicformMobile').valid()){

			var number = $("#mobile").val();
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			var input = {
				"mobile_number" : number,
				"_token" : CSRF_TOKEN
			};

			$.ajax({
				url : '{{ route('business.numberUpdate') }}',
				type : 'POST',
				data : input,
				dataType : "json",
				success : function(response) {		
					console.log("res", response);

					if(response.type == "error"){

						$(".error").html(response.message);
						$(".error").show();
						//$("#mobile").val('');
						$(".success").hide();

					}else if(response.type == "success"){
						$(".success").html(response.message);
						$("#verify_input").show();
						$("#enter_input").hide();
						$("#resend_name").hide();
						$("#mobile_label").show();
						$("#OtpBtn").hide();
						$(".error").hide();
						$("#VrfBtn").show();
						$(".success").show();
					}
				}
			});
		}
	}
	  
	function verifyOTP() {
		
		var otp = $("#otp").val(); 
		var CSRF_TOKEN1 = $('meta[name="csrf-token"]').attr('content');
		
		if (otp.length == 6 && otp != null) {
	
			var inputVal = {
				"otp" : otp,
				"action" : "verify_otp",
				"_token" : CSRF_TOKEN1
		    };
	
			$.ajax({
				url : '{{ route('business.verifyUpdate') }}',
				type : 'POST',
				dataType : "json",
				data : inputVal,
				success : function(response) {
					
	                if(response.type == "error"){
						$(".error").html(response.message);
						$(".error").show();
						$("#otp").val('');
						$(".success").hide(); 
					}
	
					if(response.type == "success"){
						$("#verify_input").hide();
						$("#enter_input").show();
						$(".success").html(response.message); 
						$("#mobile").html(response.session_number); 
						$(".error").hide();
						$("#VrfBtn").hide();
						$("#OtpBtn").show();
						$(".success").show(); 
				  	}
				}
			});
	
		} else {
			$(".error").html('You have entered wrong OTP.')
			$(".error").show();
			$(".success").hide();
		}
	}
	
	/*$('.basicbtn').click(function(){

		var oldpassword =  $("#oldpassword").val();
		var password =  $("#password").val();
		var password1 =  $("#password1").val();

		if ( oldpassword != '' || password != '' || password1 != '' ) {
			setTimeout(function () {
				$("#oldpassword").val('');
				$("#password").val('');
				$("#password1").val('');
				$(".basicbtn").html('Change');
			}, 4000);

		}	
	});*/

	@php
		$showGoogleReviewModal=1;
		if(isset($basic->google_review_placeid) && $basic->google_review_placeid!=""){
			$showGoogleReviewModal=0;
		}
	@endphp

	var showGoogleReviewModal = '{{ $showGoogleReviewModal ?? 0 }}';
	var isGoogleReviewModalShowAlReady = 0;
	var btnName="";
	
$(".basicSettingform").on('submit', function(e){	
	e.preventDefault();
	var thisData = this;
	submitForm(thisData);
});

function submitForm(thisData){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	var btn = $( thisData ).find('.basicbtn');
	var basicbtnhtml = btn.html();
	var tabName = "{{ app('request')->input('vcard') }}";
	console.log(tabName);
	// if(tabName=='true'){
		var vw_page = $('input[name="vw_page"]:checked').val();
		if(vw_page=='vcard'){
			var select_v_card = $('input[name="select_v_card"]:checked').val();
			if(select_v_card==undefined||select_v_card==''){
				Sweet('error', "Please select v-card page design");
				return false;
			}
		}
		else{
			var website_url = $("#website_url").val();

			var is_valid = true;
                
			var checkOne = 'https://';
			var checkTwo = 'http://';
			if(website_url.indexOf(checkOne) == -1 && website_url.indexOf(checkTwo) == -1){
				is_valid = false;
			}

			var checkThree = '.in';
			var checkFour = '.com';
			var checkFive = '.org';
			var checkSix = '.net';
			var checkSeven = '.co.in';
			if(website_url.indexOf(checkThree) == -1 && website_url.indexOf(checkFour) == -1 && website_url.indexOf(checkFive) == -1 && website_url.indexOf(checkSix) == -1 && website_url.indexOf(checkSeven) == -1){
				is_valid = false;
			}

			if(is_valid == false){
				Sweet('error','Please enter valid URL.');
				return false;
			}

			// if(website_url == ''){
			// 	Sweet("error", "Please enter website URL.");
			// 	return false;
            // }
			// else if(website_url != ''){
            //     if(website_url.indexOf('https') != -1){
            //         /* Valid */
            //     }else{
            //         Sweet("error", "Please enter valid URL.");
            //         return false;
            //     }
            // }
		}
	// }

	btnName = $( thisData ).find('button').prop('name');
	
	$.ajax({
		type: 'POST',
		url: thisData.action,
		data: new FormData(thisData),
		dataType: 'json',
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function() {
			btn.html("Please Wait....");
			btn.attr('disabled','')
		},
		success: function(response){ 
			// console.log(response);
			btn.removeAttr('disabled');
			// console.log("btnName ", btnName);
			if(btnName==undefined||btnName==""){
				btn.html(basicbtnhtml);
			}
			else{
				btn.html(btnName);
			}

			if(response.status == true){
				if(response.tab == 'basic'){
					$('#home-tab4 .status-icon').empty();
					$('#home-tab4 .status-icon').html('<i class="fas fa-check-circle text-success"></i>');

					if(response.logo != ''){
						var biz_logo = $('.sidebar-logo-round img').attr('src');

						if(biz_logo == undefined){
							
							var url = '{{ $logo_url ?? "" }}';

							var new_logo = url+'/'+response.logo;
							var html = '<div class="sidebar-logo-round"><img src="'+new_logo+'" class="sidebar-logo" id="img" alt="Vikas Free"></div>';

							$(".sidebar-logo-sec .align-items-center").prepend(html);
						}else{
							var url = biz_logo.substr(0, biz_logo.lastIndexOf("/"));
							var new_logo = url+'/'+response.logo;
							$('.sidebar-logo-round img').attr('src', new_logo);

							console.log('2');
						}
					}else{
						$('.sidebar-logo-round').remove();
					}

				}else if(response.tab == 'business_address'){
					$('#profile_tab4 .status-icon').empty();
					$('#profile_tab4 .status-icon').html('<i class="fas fa-check-circle text-success"></i>');
				}else if(response.tab == 'billing_address'){
					$('#contact_tab4 .status-icon').empty();
					$('#contact_tab4 .status-icon').html('<i class="fas fa-check-circle text-success"></i>');
				}else if(response.tab == 'social'){
					$('#contact_tab5 .status-icon').empty();
					$('#contact_tab5 .status-icon').html('<i class="fas fa-check-circle text-success"></i>');
				}else if(response.tab == 'business_address'){						
					$('#contact_tab6 .status-icon').empty();
					$('#contact_tab6 .status-icon').html('<i class="fas fa-check-circle text-success"></i>');
				}/*else if(response.tab == 'business_address'){

				}*/
				Sweet('success',response.message);

				setTimeout(() => {
					location.reload();
				}, 1200);

			}else{
				Sweet('error',response.message);
			}
			//success(response);
		},
		error: function(xhr, status, error) 
		{
			btn.html(basicbtnhtml);
			btn.removeAttr('disabled')
			$('.errorarea').show();
			$.each(xhr.responseJSON.errors, function (key, item) 
			{
				Sweet('error',item)
				$("#errors").html("<li class='text-danger'>"+item+"</li>")
			});
			errosresponse(xhr, status, error);
		}
	})
}
</script>