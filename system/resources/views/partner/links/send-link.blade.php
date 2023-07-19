@extends('layouts.partner')

@section('title', 'Make Payment: Partner Panel')

@section('head')
	@include('layouts.partials.headersection',['title'=>'Enter Business Details'])

<style>
    .Whatsapp_button .btn-lg{
        font-size: 14px !important;
    }
    .Whatsapp_button .icon-whats-app:before {
        font-size: 16px;
    }
    .short_link_section input{
        height: 40px;
        width: 80%;
        float: left;
    }
    .short_link_section button{
        width: 20%;
        padding: 8px;
    }   
    @media(max-width: 575px){
        .short_link_section input{
            width: 70%;
        }
        .short_link_section button{
            width: 30%;
            padding: 8px 4px; 
        }
    }
</style>
@endsection

@section('content')

<div class="mb-5">
	
	<div class="row justify-content-center">
		<div class="col-lg-10">

			<div class="card">
				
				<div class="card-body">

					<form role="form" method="post" action="{{ route('business.partner.sendToBusiness') }}" id="sendLinkform">
						
						@csrf

                        <input type="hidden" name="paymentlink_id" value="{{ $paymentLink->id }}" />

						<div class="form-group row">
							<label for="mobile" class="col-sm-3 col-form-label">{{ __('Whatsapp Number') }}</label>
							<div class="col-sm-9">
								<input type="text" name="mobile" value="{{ $paymentLink->mobile }}" class="form-control" style="height: 40px;" id="mobile" disabled>
								<p><span><b>Note: </b></span><span style="color: red;">Link will be shared on this number.</span></p>
							</div>
						</div>

						<div class="form-group row">
							<label for="message" class="col-sm-3 col-form-label">{{ __('Message') }} ( Optional )</label>
							<div class="col-sm-9">
								<textarea name="message" id="message" class="form-control editor"></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label for="short_link" class="col-sm-3 col-form-label">{{ __('Payment Link') }}</label>
							<div class="col-sm-9 short_link_section">
								<input type="text" name="short_link" value="{{ $paymentLink->short_link }}" class="form-control"  id="short_link" readonly>
								<button type="button" class="btn btn-primary" onclick="copyToClipboard()">Copy Link</button>
							</div>
						</div>

						<div class="form-group row Whatsapp_button">
							<button class="btn btn-success btn-lg" id="send_link_wp" type="submit" style="display: block;margin: auto;">Send On Whatsapp <i class="fntlo icon-whats-app"></i></button>
						</div>

					</form>

				</div>
			</div>
			

		</div>
	</div>
</div>
@endsection
@section('end_body')

<script>
    /* Create Future Offer */
    $(document).ready(function() {
        $("#sendLinkform").on('submit', function(e){
            e.preventDefault();

            var instance = '{{ $instance }}';

            /* Check Whatsapp Status */
            if(instance == ''){
                Swal.fire({
                    title: '<strong>Whatsapp QR Scan</strong>',
                    icon: 'info',
                    html:
                        'You are not connected to Whatsapp. Go to setting and scan QR code to connect with your whatsapp.',
                    showCloseButton: false,
                    showCancelButton: true,
                    focusConfirm: false,
                    allowOutsideClick:false,
                    confirmButtonText:
                        'Go To Settings',
                    cancelButtonText:
                        'Close'
                }).then((result) => {
                    // console.log(result);
                    if (result.value == true) {
                        window.location.href = '{{ url('/business/settings?wa=true' ) }}'
                    } 
                });

    
            }else{
                var btn = $('#send_link_wp');

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
                        btn.attr('disabled','')
                        btn.html('Please Wait....')
                    },
                    success: function(response){ 
                        /*console.log(response);*/
                        if(response.status == true){
                            Sweet('success',response.message);
                            setTimeout(function(){
                                window.location.href = '{{ route('business.partner.paymentLinks') }}';
                            },500);
                        }else{
                            Sweet('error',response.message);
                            
                            btn.removeAttr('disabled');
					        btn.html('Send On Whatsapp ');
                        }

                    },
                    error: function(xhr, status, error) 
                    {
                        $.each(xhr.responseJSON.errors, function (key, item) 
                        {
                            Sweet('error',item);
                        });

                        btn.removeAttr('disabled');
					    btn.html('Send On Whatsapp ');
                    }
                })
            }

        });
    });

    function copyToClipboard() {
        /* Get the text field */
        var copyText = document.getElementById("short_link");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        navigator.clipboard.writeText(copyText.value);

        /* Alert the copied text */
        Sweet('success', 'Link copied to your clipboard.');
    }
</script>
@endsection

