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

						<div class="form-group row">
							<label for="actual_link" class="col-sm-3 col-form-label">{{ __('Actual Link') }}</label>
							<div class="col-sm-9">
								<input type="text" name="actual_link" value="{{ $paymentLink->actual_link }}" class="form-control" style="height: 40px;" id="actual_link" disabled>
							</div>
						</div>

						<div class="form-group row">
							<label for="actual_link" class="col-sm-3 col-form-label">{{ __('Whatsapp Number') }}</label>
							<div class="col-sm-9">
								<input type="text" name="actual_link" value="{{ $paymentLink->mobile }}" class="form-control" style="height: 40px;" id="actual_link" disabled>
								<p><span><b>Note: </b></span><span style="color: red;">Link will be shared on this number.</span></p>
							</div>
						</div>

						<div class="form-group row">
							<label for="actual_link" class="col-sm-3 col-form-label">{{ __('Message') }} ( Optional )</label>
							<div class="col-sm-9">
								<textarea name="message" id="message" class="form-control editor"></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label for="short_link" class="col-sm-3 col-form-label">{{ __('Short Link') }}</label>
							<div class="col-sm-9 short_link_section">
								<input type="text" name="short_link" value="{{ $paymentLink->short_link }}" class="form-control"  id="short_link" readonly>
								<button type="button" class="btn btn-primary" onclick="copyToClipboard()">Copy Link</button>
							</div>
						</div>

						<div class="form-group row Whatsapp_button">
							<button class="btn btn-primary btn-lg" id="send_link_wp" type="submit" style="display: block;margin: auto;">Send On Whatsapp <i class="fntlo icon-whats-app"></i></button>
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

            $('#send_link_wp').prop("disabled", true);

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
                    /*console.log(response);*/
                    if(response.status == true){
                        Sweet('success',response.message);
                        setTimeout(function(){
                            window.location.href = '{{ route('business.partner.paymentLinks') }}';
                        },500);
                    }else{
                        Sweet('error',response.message);
                        $('#send_link_wp').prop("disabled", false);
                    }

                },
                error: function(xhr, status, error) 
                {
                    $.each(xhr.responseJSON.errors, function (key, item) 
                    {
                        Sweet('error',item);
                    });

                    $('#send_link_wp').prop("disabled", false);
                }
            })
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

