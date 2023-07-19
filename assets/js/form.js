(function ($) {
	"use strict";
  //basicform submit
    if ($('textarea[name="content"]').length > 0){
		CKEDITOR.replace('content');
	}	
	
	$("#productform").on('submit', function(e){
		e.preventDefault();
		var instance =$('.content').val()
		
		if (instance != null) {
			for ( instance in CKEDITOR.instances ) {
				CKEDITOR.instances[instance].updateElement();
			}
		}
		var btnhtml=$('.basicbtn').html();

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
       			
       			$('.basicbtn').attr('disabled','')
       			$('.basicbtn').html('Please Wait....')

    		},
			
			success: function(response){ 
				$('.basicbtn').removeAttr('disabled')
				Sweet('success',response)
				$('.basicbtn').html(btnhtml)
				success(response)
			},
			error: function(xhr, status, error) 
			{
				$('.basicbtn').removeAttr('disabled');
				$('.basicbtn').html(btnhtml);
				
				$.each(xhr.responseJSON.errors, function (key, item) 
				{
					Sweet('error',item)
					$("#errors").html("<li class='text-danger'>"+item+"</li>")
				});
				errosresponse(xhr, status, error);
			}
		})


	});


	$("#basicform").on('submit', function(e){
		e.preventDefault();
		
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
       			
				   $('.basicbtn').attr('disabled','');
				   
				  

    		},
			
			success: function(response){ 
				$('.basicbtn').removeAttr('disabled')
				Sweet('success',response)
				
				/*success(response)*/
				window.location.href = "{{ route('business.future.index') }}";
			},
			error: function(xhr, status, error) 
			{
				$('.basicbtn').removeAttr('disabled')
				$('.errorarea').show();
				$.each(xhr.responseJSON.errors, function (key, item) 
				{
					Sweet('error',item)
					$("#errors").html("<li class='text-danger'>"+item+"</li>")
				});
				//errosresponse(xhr, status, error);
			}
		})


	});

	$(".basicform").on('submit', function(e){
		e.preventDefault();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		var btn_submit = $(this).find('.basicbtn');
		var basicbtnhtml=btn_submit.html();
		$.ajax({
			type: 'POST',
			url: this.action,
			data: new FormData(this),
			dataType: 'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function() {

				btn_submit.html("Please Wait....");
				btn_submit.attr('disabled','')

			},
			
			success: function(response){ 
				btn_submit.removeAttr('disabled')
				Sweet('success',response);
				btn_submit.html(basicbtnhtml);
				//success(response);
			},
			error: function(xhr, status, error) 
			{
				btn_submit.html(basicbtnhtml);
				btn_submit.removeAttr('disabled')
				$('.errorarea').show();
				$.each(xhr.responseJSON.errors, function (key, item) 
				{
					Sweet('error',item)
					$("#errors").html("<li class='text-danger'>"+item+"</li>")
				});
				//errosresponse(xhr, status, error);
			}
		})
	});

	$(".basicSettingform").on('submit', function(e){
		
		e.preventDefault();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		var btn = $( this ).find('.basicbtn');
		var basicbtnhtml = btn.html();
		//console.log(basicbtnhtml);
		$.ajax({
			type: 'POST',
			url: this.action,
			data: new FormData(this),
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
				btn.html(basicbtnhtml);

				if(response.status == true){
					if(response.tab == 'basic'){
						$('#home-tab4 .status-icon').empty();
						$('#home-tab4 .status-icon').html('<i class="fas fa-check-circle"></i>');
					}else if(response.tab == 'business_address'){
						$('#profile_tab4 .status-icon').empty();
						$('#profile_tab4 .status-icon').html('<i class="fas fa-check-circle"></i>');
					}else if(response.tab == 'billing_address'){
						$('#contact_tab4 .status-icon').empty();
            			$('#contact_tab4 .status-icon').html('<i class="fas fa-check-circle"></i>');
					}else if(response.tab == 'social'){
						$('#contact_tab5 .status-icon').empty();
            			$('#contact_tab5 .status-icon').html('<i class="fas fa-check-circle"></i>');
					}else if(response.tab == 'business_address'){						
						$('#contact_tab6 .status-icon').empty();
            			$('#contact_tab6 .status-icon').html('<i class="fas fa-check-circle"></i>');
					}/*else if(response.tab == 'business_address'){

					}*/
					
					// console.log(response.message == 'Password updated successfully.');

					if(response.message == 'Password updated successfully.'){
						
						setTimeout(() => {
							window.location.href = response.redirect_url;
						}, 1200);
						
					}else{
						Sweet('success', response.message);
					}

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
	});

	$(".employeeSettingform").on('submit', function(e){
		
		e.preventDefault();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		var btn = $( this ).find('.basicbtn');
		var basicbtnhtml = btn.html();
		//console.log(basicbtnhtml);
		$.ajax({
			type: 'POST',
			url: this.action,
			data: new FormData(this),
			dataType: 'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function() {

				btn.html("Please Wait....");
				btn.attr('disabled','')

			},
			
			success: function(response){ 
				//console.log(response);
				btn.removeAttr('disabled');
				btn.html(basicbtnhtml);
				if(response.status == true){
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
				
				$.each(xhr.responseJSON.errors, function (key, item) 
				{
					Sweet('error',item)
				});
				errosresponse(xhr, status, error);
			}
		})
	});


	$(".basicform_with_reload").on('submit', function(e){
		e.preventDefault();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		var basicbtnhtml=$('.basicbtn').html();
		$.ajax({
			type: 'POST',
			url: this.action,
			data: new FormData(this),
			dataType: 'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function() {
				
				$('.basicbtn').html("Please Wait....");
				$('.basicbtn').attr('disabled','')

			},
			
			success: function(response){ 
				$('.basicbtn').removeAttr('disabled')
				Sweet('success',response);
				$('.basicbtn').html(basicbtnhtml);
				location.reload();
			},
			error: function(xhr, status, error) 
			{
				$('.basicbtn').html(basicbtnhtml);
				$('.basicbtn').removeAttr('disabled')
				$('.errorarea').show();
				$.each(xhr.responseJSON.errors, function (key, item) 
				{
					Sweet('error',item)
					$("#errors").html("<li class='text-danger'>"+item+"</li>")
				});
				errosresponse(xhr, status, error);
			}
		})


	});

	$(".basicform_with_reset").on('submit', function(e){
		e.preventDefault();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		var basicbtnhtml=$('.basicbtn').html();
		$.ajax({
			type: 'POST',
			url: this.action,
			data: new FormData(this),
			dataType: 'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function() {
				
				$('.basicbtn').html("Please Wait....");
				$('.basicbtn').attr('disabled','')

			},
			
			success: function(response){ 
				$('.basicbtn').removeAttr('disabled')
				Sweet('success',response.message);
				$('.basicbtn').html(basicbtnhtml);
				$('.basicform_with_reset').trigger('reset');
				window.location.href = response.redirect;
			},
			error: function(xhr, status, error) 
			{
				$('.basicbtn').html(basicbtnhtml);
				$('.basicbtn').removeAttr('disabled')
				$('.errorarea').show();
				$.each(xhr.responseJSON.errors, function (key, item) 
				{
					Sweet('error',item)
					$("#errors").html("<li class='text-danger'>"+item+"</li>")
				});
				errosresponse(xhr, status, error);
			}
		})


	});
	$(".basicform_with_remove").on('submit', function(e){
		e.preventDefault();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		var basicbtnhtml=$('.basicbtn').html();
		$.ajax({
			type: 'POST',
			url: this.action,
			data: new FormData(this),
			dataType: 'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function() {
				
				$('.basicbtn').html("Please Wait....");
				$('.basicbtn').attr('disabled','')

			},
			
			success: function(response){ 
				$('.basicbtn').removeAttr('disabled')
				Sweet('success',response);
				$('.basicbtn').html(basicbtnhtml);
				$('input[name="ids[]"]:checked').each(function(i){
					var ids = $(this).val();
					$('#row'+ids).remove();
				});

			},
			error: function(xhr, status, error) 
			{
				$('.basicbtn').html(basicbtnhtml);
				$('.basicbtn').removeAttr('disabled')
				$('.errorarea').show();
				$.each(xhr.responseJSON.errors, function (key, item) 
				{
					Sweet('error',item)
					$("#errors").html("<li class='text-danger'>"+item+"</li>")
				});
				errosresponse(xhr, status, error);
			}
		})


	});



	$(".loginform").on('submit', function(e){
		e.preventDefault();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		var basicbtnhtml=$('#loginFormBtn').val();

		$.ajax({
			type: 'POST',
			url: this.action,
			data: new FormData(this),
			dataType: 'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function() {
       			
       			$('#loginFormBtn').val("Please Wait....");
       			$('#loginFormBtn').attr('disabled','')
				
    		},
			
			success: function(response){
				console.log(response);
				
				/*location.reload();*/
				if(response.type == 'error'){
					Sweet('error',response.message);

					$('#loginFormBtn').removeAttr('disabled')
					$('#loginFormBtn').val(basicbtnhtml);

				}else if(response.type == 'success'){
					if(response.payment == 'pending'){
						window.location.href = response.redirect;
					}else{
						if(response.link && response.link != ''){
							window.location.href = response.link;
						}else{
							location.reload();
						}
						
					}
				}
				
			},
			error: function(xhr, status, error) 
			{
				/*console.log(error);*/
				
				Sweet('error',response.message);

				$('#loginFormBtn').val(basicbtnhtml);
				$('#loginFormBtn').removeAttr('disabled')
				
				/*$.each(xhr.responseJSON.errors, function (key, item) 
				{
					Sweet('error',item)
					$("#errors").html("<li class='text-danger'>"+item+"</li>")
				});
				errosresponse(xhr, status, error);*/
			}
		})


	});

	//id basicform1 when submit 
	$("#basicform1").on('submit', function(e){
		e.preventDefault();

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
			success: function(response){ 
				success(response)
			},
			error: function(xhr, status, error) 
			{
				$('.errorarea').show();

				$.each(xhr.responseJSON.errors, function (key, item) 
				{
					Sweet('error',item)
					$("#errors").html("<li class='text-danger'>"+item+"</li>")
				});
				errosresponse(xhr, status, error);
			}
		})
	});	
	
	$(".checkAll").on('click',function(){
		$('input:checkbox').not(this).prop('checked', this.checked);
	});

	$(".cancel").on('click',function(e) {
		e.preventDefault();
		var link = $(this).attr("href");
		
		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, Do It!'
		}).then((result) => {
			if (result.value == true) {
				window.location.href = link;
			}
		})
	});

	
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

	$("#futureform").on('submit', function(e){
		e.preventDefault();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		var basicbtnhtml=$('.futurebtn').html();
		$.ajax({
			type: 'POST',
			url: this.action,
			data: new FormData(this),
			dataType: 'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function() {

				$('.futurebtn').html("Please Wait....");
				$('.futurebtn').attr('disabled','')

			},
			
			success: function(response){ 
				console.log(response);
				if(response['status'] == true){
					$('.futurebtn').removeAttr('disabled');
					Sweet('success',response['message']);
					$('.futurebtn').html(basicbtnhtml);
					/*success(response);*/
					var url      = window.location.href; 
					/*location.reload();*/
					window.location.href = response.url;
				}else{
					$('.futurebtn').removeAttr('disabled');
					Sweet('error',response['message']);
					$('.futurebtn').html(basicbtnhtml);
					error(response);
				}
					
			},
			error: function(xhr, status, error) 
			{
				$('.basicbtn').html(basicbtnhtml);
				$('.basicbtn').removeAttr('disabled')
				$('.errorarea').show();
				$.each(xhr.responseJSON.errors, function (key, item) 
				{
					Sweet('error',item)
					$("#errors").html("<li class='text-danger'>"+item+"</li>")
				});
				errosresponse(xhr, status, error);
			}
		})

	});

	$("#editFutureForm").on('submit', function(e){
		e.preventDefault();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		var basicbtnhtml=$('.futurebtn').html();
		$.ajax({
			type: 'PATCH',
			url: this.action,
			data: new FormData(this),
			dataType: 'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function() {

				$('.futurebtn').html("Please Wait....");
				$('.futurebtn').attr('disabled','')

			},
			
			success: function(response){ 
				console.log(response);
				if(response['status'] == true){
					$('.futurebtn').removeAttr('disabled');
					Sweet('success',response['message']);
					$('.futurebtn').html(basicbtnhtml);
					/*success(response);*/
					var url      = window.location.href; 
					/*location.reload();*/
					/*window.location.href = response.url;*/
				}else{
					$('.futurebtn').removeAttr('disabled');
					Sweet('error',response['message']);
					$('.futurebtn').html(basicbtnhtml);
					error(response);
				}
					
			},
			error: function(xhr, status, error) 
			{
				$('.basicbtn').html(basicbtnhtml);
				$('.basicbtn').removeAttr('disabled')
				$('.errorarea').show();
				$.each(xhr.responseJSON.errors, function (key, item) 
				{
					Sweet('error',item)
					$("#errors").html("<li class='text-danger'>"+item+"</li>")
				});
				errosresponse(xhr, status, error);
			}
		})

	});

	$(".basicformwithfunction").on('submit', function(e){
		e.preventDefault();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		var basicbtnhtml=$('.basicbtn').html();
		$.ajax({
			type: 'POST',
			url: this.action,
			data: new FormData(this),
			dataType: 'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function() {

				$('.basicbtn').html("Please Wait....");
				$('.basicbtn').attr('disabled','')

			},
			
			success: function(response){ 

				$('.basicbtn').removeAttr('disabled')
				$('.basicbtn').html(basicbtnhtml);
				/*location.reload();*/
				if(response.type == 'error'){
					Sweet('error',response.message);
					error(response)
				}else if(response.type == 'success'){
					Sweet('success',response.message);
					success(response);
				}
			},
			error: function(xhr, status, error) 
			{
				$('.basicbtn').html(basicbtnhtml);
				$('.basicbtn').removeAttr('disabled')
				$('.errorarea').show();
				$.each(xhr.responseJSON.errors, function (key, item) 
				{
					Sweet('error',item)
					$("#errors").html("<li class='text-danger'>"+item+"</li>")
				});
				errosresponse(xhr, status, error);
			}
		})
	});
	
	$(".fullPackageUpdate").on('submit', function(e){
		e.preventDefault();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		var btn_submit = $(this).find('.basicbtn');
		var basicbtnhtml=btn_submit.html();
		$.ajax({
			type: 'POST',
			url: this.action,
			data: new FormData(this),
			dataType: 'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function() {

				btn_submit.html("Please Wait....");
				btn_submit.attr('disabled','')

			},
			
			success: function(response){ 
				btn_submit.removeAttr('disabled')
				Sweet('success',response.message);
				btn_submit.html(basicbtnhtml);
				//success(response);
			},
			error: function(xhr, status, error) 
			{
				btn_submit.html(basicbtnhtml);
				btn_submit.removeAttr('disabled')
				$('.errorarea').show();
				$.each(xhr.responseJSON.errors, function (key, item) 
				{
					Sweet('error',item)
					$("#errors").html("<li class='text-danger'>"+item+"</li>")
				});
				errosresponse(xhr, status, error);
			}
		})
	});
	
	
	$(".addMoreFeature").on('click', function(e){
		var html = '<div class="extraFeatureContainer"><input type="text" name="features[]" class="mb-3 form-control two-space-validation" placeholder="Enter Feature" required><span class="removeExtraFeature"><i class="fas fa-times"></i></span></div>';
		$('.appendFeatures').append(html);
	});
	
	$.fn.inputFilter = function(inputFilter) {
		return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
		  if (inputFilter(this.value)) {
			this.oldValue = this.value;
			this.oldSelectionStart = this.selectionStart;
			this.oldSelectionEnd = this.selectionEnd;
		  } else if (this.hasOwnProperty("oldValue")) {
			this.value = this.oldValue;
			this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
		  } else {
			this.value = "";
		  }
		});
	  };
	
	$(".validatePricingField").inputFilter(function(value) {
		return /^-?\d*[.]?\d*$/.test(value); 
    });
	
})(jQuery);	

$(document).on('click','.removeExtraFeature', function(e){
	$(this).parent(".extraFeatureContainer").remove();
});

function copyUrl(id){
	var copyText = document.getElementById("myUrl"+id);
	copyText.select();
	copyText.setSelectionRange(0, 99999)
	document.execCommand("copy");
	Sweet('success','Link copied to clipboard.');
}
function checkPermissionByGroup(className, checkThis){
    const groupIdName = $("#"+checkThis.id);
    const classCheckBox = $('.'+className+' input');
    if(groupIdName.is(':checked')){
            classCheckBox.prop('checked', true);
    }else{
        classCheckBox.prop('checked', false);
    }
}