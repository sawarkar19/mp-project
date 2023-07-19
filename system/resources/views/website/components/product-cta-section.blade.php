<section id="social_media_eng">
    <div class="py-5">
        <div class="container mt-md-5">
            <div class="social_media_eng mx-auto">
                <h4 class="social_media_head text-center font-700 mb-4">Increase your business reach, customers trust, social media engagement, & improve branding remarkably with mouthpublicity.io</h4>
                <div style="max-width: 450px; margin:auto;">
                    <!-- <form action="#" method="post" id="cta_email_form" class="form-type-one text-center">
                        <input type="hidden" name="form_id" value="{{$form_id}}" required>
                        <input type="hidden" name="form_name" value="{{$form_name}}" required>
                        <div class="form-group mb-2">
                            <input type="email" name="cta_email" id="cta_email" class="form-control shadow" placeholder="Enter Your Email ID..." required>
                        </div>
                        <div id="cta_form_status" class="font-small font-600 mb-3"></div>
                        <div class="">
                            <button type="submit" id="cta_btn" class="btn btn-primary-ol px-5" style="font-size: 20px;">Learn More</button>
                        </div>
                    </form> -->
                    <div class="text-center">
                        <a href="{{ url('signin?tab=register') }}" id="cta_btn" class="btn btn-primary-ol px-5" style="font-size: 20px;">Get Started For Free Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- <section id="social_media_eng_button" class="mt-5">
    <div class="py-5 text-center">
        <a href="{{ url('signin?tab=register') }}" id="cta_btn" class="btn btn-primary-ol px-5" style="font-size: 20px;">Get Started For Free</a>
    </div>
</section> -->

@push('end_body')
<script>
$(function(){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $('#cta_email_form').submit(function(event){
        event.preventDefault();

        var form = $(this);

        var btn = form.find('button#cta_btn');
        var btn_text = btn.text();
        var status = $('#cta_form_status');
        var email = $("#cta_email").val();

        if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
            status.html('<span class="text-danger">Please enter a valid Email-ID!</span>');
            return false;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN
            }
        });
        $.ajax({
            url: '{{ route('ctaForm') }}',
            type: 'post',
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function(){
                btn.prop('disabled', true).text('Please Wait...');
            },
            success: function (responce) {
                if(responce.status){
                    status.html('<span class="text-success">'+responce.message+'</span>');
                }else{
                    status.html('<span class="text-danger">Something went wrong! Please try again latter.</span>');
                }
            },
            error:function(errors, ero){
                status.html('<span class="text-warning">Some technical error occured! Please try after sometime.</span>');
            },
            complete: function(){
                btn.prop('disabled', false).text(btn_text);
            }
        });
    });
});
</script>
@endpush