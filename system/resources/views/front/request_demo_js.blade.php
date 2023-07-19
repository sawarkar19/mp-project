<script type="text/javascript">
    $(document).ready(function(){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).on('click', '#requestDemo', function(){
            var btn = $(this);
            var mobile = $('#requestNumber').val();
            console.log(mobile);

            $.ajax({
                /* the route pointing to the post function */
                url: '{{ route('requestDemo') }}',
                type: "POST",
                /* send the csrf-token and the input to the controller */
                data: {
                    _token: CSRF_TOKEN,
                    mobile: mobile
                },
                dataType: 'JSON',
                beforeSend: function(){
                    btn.attr('disabled','')
                    btn.html('Please Wait....')
                },
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    console.log(data);
                    if(data.status == true){
                        $('#requestNumber').val('');
                        $('.success-message').show();
                        $('.success-message-text').html(data.message);
                        setTimeout(function() {
                            $(".success-message").fadeOut(700)
                            $('.success-message-text').html('');
                        }, 2000);
                    }else{
                    }
                },
                complete: function(){
                    btn.removeAttr('disabled')
                    btn.html('Sent Message')
               }
            });
        })
    });
</script>