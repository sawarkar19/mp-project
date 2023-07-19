<script type="text/javascript">
    $(document).ready(function(){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).on('click', '#subscribeEmail', function(event){

            event.preventDefault();

            var btn = $(this);
            var email = $('#subscriber').val();

            $('#subscriber').parent('div.subs_row').next().remove();


            if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
                $('#subscriber').parents('div.subscribe_form').append('<p class="text-danger small mb-0">Please enter a valid Email-ID!</p>');
                setTimeout(function() {
                    $('#subscriber').parent('div.subs_row').next().remove();
                }, 5000)
                return false;
            }

            /*console.log(email);*/
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                /* the route pointing to the post function */
                url: '{{ route('subscribe') }}',
                type: "POST",
                /* send the csrf-token and the input to the controller */
                data: {
                    // _token: CSRF_TOKEN,
                    email: email
                },
                // dataType: 'JSON',
                beforeSend: function(){
                    btn.attr('disabled','').html('Please Wait....');
                },
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    console.log(data);
                    if(data.status == true){
                        $('#subscriber').val('');
                        $('#subscriber').parents('div.subscribe_form').append('<p class="text-success small mb-0">'+data.message+'</p>');
                        // $('.error-message-sec').show();
                        // $('.text-message-success').text(data.message);
                        // setTimeout(function() {
                            // $(".error-message-sec").fadeOut(700)
                            // $('.text-message-success').text('');
                        // }, 2000);
                    }else{
                        $('#subscriber').parents('div.subscribe_form').append('<p class="text-danger small mb-0">'+data.message+'</p>');
                        // $('.error-message-sec').show();
                        // $('.text-message-error').text(data.message);
                        // setTimeout(function() {
                            // $(".error-message-sec").fadeOut(700)
                            // $('.text-message-error').text('');
                        // }, 2000);
                    }
                    setTimeout(function() {
                        $('#subscriber').parent('div.subs_row').next().remove();
                    }, 10000)
                },
                error:function(errors, ero){
                    console.log(ero);
                },
                complete: function(){
                    btn.removeAttr('disabled').html('Send');
                }
            });
        })
    });
</script>