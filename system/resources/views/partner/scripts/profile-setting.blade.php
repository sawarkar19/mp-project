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

					if(response.type == "error"){

						$(".error").html(response.message);
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


	
$(".basicSettingform").on('submit', function(e){	

	var showGoogleReviewModal = '{{ $showGoogleReviewModal ?? 0 }}';
	var google_review_placeid = $("#google_review_placeid").val();
	var isSubmitForm = false;
	var thisData = this;
	e.preventDefault();
	if(showGoogleReviewModal==1 && google_review_placeid!=""){
		// show confirm popup for google review
		Swal.fire({
			title: '<strong>Please Note</strong>',
			html: 'One Message will be deducted from your wallet balance for each review.',
			icon: 'info',
			showCloseButton: false,
			showCancelButton: true,
			focusConfirm: false,
			allowOutsideClick:false,
			confirmButtonText: 'Accept',
			cancelButtonText: 'Cancel'
		}).then((result) => {
			if(result.value){
				submitForm(thisData);
			}
			else{
				return false;
			}
		});
	}else{
		submitForm(thisData);
	}
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
	
	if(tabName=='true'){
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
			if(website_url == ''){
				Sweet("error", "Please enter website URL.");
				return false;
            }
			else if(website_url != ''){
                if(website_url.indexOf('https') != -1){
                    /* Valid */
                }else{
                    Sweet("error", "Please enter valid URL.");
                    return false;
                }
            }
		}
	}
	
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
			console.log(response);
			btn.removeAttr('disabled');
			btn.html(basicbtnhtml);
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