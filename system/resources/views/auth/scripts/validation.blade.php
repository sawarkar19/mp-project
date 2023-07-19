<script type="text/javascript">
	jQuery.validator.addMethod("lettersonly", function(value, element) 
	{
		return this.optional(element) || /^[a-z," "]+$/i.test(value);
	}, "Letters and spaces only please");  

	$.validator.addMethod("notEqualTo", function(value, element){
		return this.optional(element) || value != '0000000000';
	},"Shoule not accept '0000000000'");

	jQuery.validator.addMethod("emailValidate", function(value, element) 
	{
		return this.optional(element) || /\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i.test(value);
	}, "Please enter a valid email address.");  

	$(document).ready( function() {

		$('#basicform').validate({
			rules: {
				name: {
					required: true,
					minlength: 5,
					lettersonly: true
				},
				email: {
					required: true,
					emailValidate: true,
				},		
				mobile: {
					required: true,
					rangelength: [10, 10],
					number: true,
					notEqualTo: true,
					minlength: 10
				},
				mobile_resend: {
					required: true,
					rangelength: [10, 10],
					number: true,
					notEqualTo: true,
					minlength: 10
				},
				password: {
					required: true,
					minlength: 8
				},
				confirm_password: {
					required: true,
					equalTo: "#password"
				},
				if_password: {
					minlength: 8
				},
			},	 
			messages: {
				name: {
					required: 'Please enter alphabetical name.',
					minlength: 'Name should be minimum 5 alphabates.',
				},		
				lettersonly: 'Please enter only alphabetical values.',		
				mobile: {
					required: 'Please enter valid mobile number.',
					rangelength: 'Mobile number should be 10 digit long.',
					minlength: 'Mobile number should be 10 digit long.',
				},
				mobile_resend: {
					required: 'Please enter valid mobile number.',
					rangelength: 'Mobile number should be 10 digit long.',
					minlength: 'Mobile number should be 10 digit long.',
				},		
				password: {
					required: 'Please enter Password.',
					minlength: 'Password must be at least 8 characters long.',
				},
				confirm_password: {
					required: 'Please enter Confirm Password.',
					equalTo: 'Confirm Password do not match with Password.',
				}
			}
		});
	});
</script>