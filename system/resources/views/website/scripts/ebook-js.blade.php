<script>
    $(function() {

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        /*
        * E-Book Form submit
        */

        /* Validating the email address and mobile number and then sending the data to the server. */
        var EBookModal = new bootstrap.Modal(document.getElementById('EBookModal'));
        $("#ebookGetNow").click(function(){
            var email = $("#e_book_email");
            var emailVal = email.val();
            email.next("span").remove();
            if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(emailVal)){
                $("#book_email").val(emailVal);
                EBookModal.show();
            }else{
                email.css('border-color', 'red').after("<span class='text-danger ' style='font-size:12px;'>Please enter the valid E-mail address!</span>");
                setTimeout(() => {
                    email.css('border-color', '').next("span").remove();
                }, 10000);
            }
        });

        /* Submit data */
        $("#getEBookForm").on("submit", function(event){
            event.preventDefault();
            // get data from the inputs
            var name = $("#book_name").val();
            var number = $("#book_number").val();
            var email = $("#book_email").val();
            var submitForm = true;
            var errorMsg = '';
            $("#getEBookForm .error_mag").empty();
            if(name == ''){  // Validate Name (string)
                submitForm = false;
                errorMsg = errorMsg + '<p class="text-danger">Name should not be empty!</p>';
            }
            if(!number.match('[6789][0-9]{9}')){ // Validate 10 digit mobile number
                submitForm = false;
                errorMsg = errorMsg + '<p class="text-danger">Please enter a valid WhatsApp number!</p>';
            }
            if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){ // Validate email address
                submitForm = false;
                errorMsg = errorMsg + '<p class="text-danger">Please enter a valid Email-ID!</p>';
            }
            if(submitForm){ // if everything is okay


                // SalesRobo Submit
                var mtc_form = $("form#mauticform_ebooksubscription");
                var bobo = submit_bobo_form(mtc_form);
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                });
                $.ajax({
                    url: '{{route("ebookDownload")}}',
                    type: "post",
                    data: {
                        'email' : email,
                        'mobile' : number,
                        'name' : name,
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $("#getEBookForm .error_mag").html('<div class="text-dark">Please wait...</div>');
                    },
                    success: function(responce) {
                        if(responce.status){
                            $("#getEBookForm").trigger('reset');
                            $("#getEBookForm .error_mag").html('<div class="text-success">'+ responce.message + '</div>');
                        }else{
                            $("#getEBookForm .error_mag").html('<div class="text-danger">Something went wrong! Please try again latter.</div>');
                        }
                    },
                    error: function(){
                        $("#getEBookForm .error_mag").html('<div class="text-danger">Some technical error occured! Please try again latter.</div>');
                    },
                    complete: function(){
                        setTimeout(() => {
                            $("#getEBookForm .error_mag").empty();
                        }, 20000);
                    }
                });

                
            }else{
                $("#getEBookForm .error_mag").html('<div>'+errorMsg+'</div>');
            }
            
        });
        /* E-Book End */ 
    });
</script>