<script type="text/javascript">
    $(document).ready(function(){
        var timeout;
        $('#wa_subscribe_form').on('submit', function(event){
            event.preventDefault();
            
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var url = $(this).attr('action');
            var method = $(this).attr('method');
            var btn = $(this).find('button[type="submit"]');
            var formdata = new FormData(this);

            var input = $('#subscriber');
            var input_data = input.val();
            var input_pattern = input.attr('pattern');

            input.parent('div.subs_row').next().remove();

            /* Email validation */
            // if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
            //     $('#subscriber').parents('div.subscribe_form').append('<p class="text-danger small mb-0">Please enter a valid Email-ID!</p>');
            //     setTimeout(function() {
            //         $('#subscriber').parent('div.subs_row').next().remove();
            //     }, 5000)
            //     return false;
            // }
            
            /* Phone validation */
            var input_validate = input_data.match(input_pattern);
            if(!input_validate || input_data.length != 10){
                input.parents('div.subscribe_form').append('<p class="text-danger small mb-0">Please enter a valid 10 digits WhatsApp number!</p>');
                return false;
            }

            btn.attr('disabled','').html('Please Wait....');

            // SalesRobo Submit
            var mtc_form = $("form#mauticform_mpwebsitefooterform");
            var bobo = submit_bobo_form(mtc_form);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            });
            $.ajax({
                url: url,
                type: method,
                dataType: 'json',
                data: formdata,
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    btn.attr('disabled','').html('Please Wait....');
                },
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    /* console.log(data.status); */
                    if(data.status){
                        input.val('');
                        input.parents('div.subscribe_form').append('<p class="text-success small mb-0 fw-bold">'+data.message+'</p>');
                        window.location.href = '{{ url('/subscriber-footer/thankyou') }}';
                    }else{
                        input.parents('div.subscribe_form').append('<p class="text-info small mb-0">'+data.message+'</p>');
                    }
                },
                error:function(errors, ero){
                    input.parents('div.subscribe_form').append('<p class="text-warning small mb-0">Something went wrong! Please try after sometime.</p>');
                },
                complete: function(){
                    btn.removeAttr('disabled').html('Send');
                }
            });
        })
    });
</script>