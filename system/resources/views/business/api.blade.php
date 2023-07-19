@extends('layouts.business')
@section('head') @include('layouts.partials.headersection',['title'=>'API Integration']) @endsection
@section('end_head')
<style>
	.wa-content .alert code{background-color: unset;}

	.parameter-table{
		border-radius: 10px;
		overflow: hidden;
		margin-bottom: 0px;
	}
	.parameter-table td, 
	.parameter-table th{
		height: 45px!important;
	}
	.card.bg-dark{
		background-color: #152f4a!important;
	}

	.copy-ico{
		cursor: pointer;
	}
</style>
@endsection
@section('content')
<section class="section">
    <div class="section-body">

		<div class="card">
			<div class="card-header">
				<h4>Get your Credentials</h4>
			</div>
			<div class="card-body">
				<p>Click below button to get your credential for integration with Messaging API.</p>
				<button class="btn btn-primary px-3" onclick="credential();">
					Get Credentials <i class="fas fa-long-arrow-alt-right"></i>
				</button>
			</div>
		</div>

		<div class="card">
			<div class="card-header">
				<h4>Send Direct Message API</h4>
			</div>
			<div class="card-body">

				<div class="row">
					<div class="col-md-12">
						<h6>API Endpoint</h6>
						<div>
							<p class="mb-1">API(Via WhatsApp) enables you to send WhatsApp messages for POS systems/Billing systems, using our REST API.</p>
							<p class="mb-1">All API requests should be sent to <code>{{url('api/v1/WHATSAPP_MESSAGE_API/send?')}}</code>, where command is the API call you wish to execute, with the parameters included either in the <code>POST Header</code> or the <code>URL (GET)</code>.</p>
							<p>Here is an example of <code>URL (GET)</code>.</p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="card bg-dark mb-0">
							<div class="card-header justify-content-between py-1" style="min-height: auto">
								<h4 class="text-white">Example Request</h4>
								<div class="copy-parent">
									<button class="btn btn-sm btn-outline-light py-0 copy-btn" data-copy="#cp_api" title="Copy to clipboard" data-toggle="tooltip"><i class="fa fa-copy"></i></button>
								</div>
							</div>
							<div class="card-body">
								<p id="cp_api" class="mb-0">{{ $api_url }}</p>
							</div>
						</div>
					</div>
				</div>

				<hr class="my-5">

				<div>
					<div class="row">
						<div class="col-lg-12">
							<h6>Parameters</h6>
							<p>Every API request supports the following parameters.</p>
						</div>
						<div class="col-lg-12">
							<div class="table-responsive">
								<table class="table table-bordered table-striped parameter-table">
									<tr>
										<th>Name</th>
										<th>Type</th>
										<th>Info</th>
									</tr>
									<tr>
										<td>username</td>
										<td>string</td>
										<td>Autogenrated by the system after successfully QR code scan</td>
									</tr>
									<tr>
										<td>password</td>
										<td>string</td>
										<td>Autogenrated by the system after successfully QR code scan</td>
									</tr>
									<tr>
										<td>mobile</td>
										<td>12 Digits Number</td>
										<td>Includ 91 before 10 digit WA mobile number where you want to send message</td>
									</tr>
									<tr>
										<td>sendername</td>
										<td>6 Digit Alphabet</td>
										<td>Autogenrated by the system after successfully QR code scan</td>
									</tr>
									<tr>
										<td>message</td>
										<td>string</td>
										<td>text</td>
									</tr>
									<tr>
										<td>routetype</td>
										<td>boolean</td>
										<td>"0"</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>

				<hr class="my-5">

				<div>
					<div class="row">
						<div class="col-md-6">
							<h6>Responses</h6>
							<p>Responses are, by default, sent in JSON format.</p>
							<p>Every response will contain a "status" field, which can be either <code>true</code> or <code>false</code>. This field can be used to determine whether your request was successful.</p>
						</div>
						<div class="col-md-6">
							<div class="card bg-dark">
								<div class="card-header justify-content-between py-1" style="min-height: auto">
									<h4 class="text-white ">Responce</h4>
									<div class="copy-parent">
										<button class="btn btn-sm btn-outline-light py-0 copy-btn" data-copy="#cp_responce" title="Copy to clipboard" data-toggle="tooltip"><i class="fa fa-copy"></i></button>
									</div>
								</div>
								<div class="card-body">
									<p id="cp_responce" class="mb-0">{
											<br><span>&nbsp;&nbsp;&nbsp;</span>"status": true,
											<br><span>&nbsp;&nbsp;&nbsp;</span>"data": "{
												<br><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span>"status":"success",
												<br><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span>"message":"Success",
												<br><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span>"data":{
													<br><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span>"key":{
														<br><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span>"remoteJid":"91XXXXXXXXXX@c.us",
														<br><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span>"fromMe":true,
														<br><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span>"id":"BAE57D8********"
														<br><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span>},
														<br><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span>"message":{
															<br><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span>"extendedTextMessage":{
																<br><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span>"text":"TEXT MESSAGE BODY"
																<br><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span>}
																<br><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span>},
																<br><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span>"messageTimestamp":"16451****",
																<br><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span>"status":"SUCCESS"
																<br><span>&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;&nbsp;</span>}
																<br><span>&nbsp;&nbsp;&nbsp;</span>}",
																<br><span>&nbsp;&nbsp;&nbsp;</span>"message": "Message sent."
															<br>}<p>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>
@endsection
@section('end_body')
    {{-- @include('business.scripts.whatsapp-js')
    @include('business.scripts.profile-setting') --}}


	<script>
		function copyToClipboard(element) {
			var $temp = $("<input>");
			$("body").append($temp);
			$temp.val($(element).text()).select();
			document.execCommand("copy");
			$temp.remove();
		}
		$(document).ready(function(){
			$(".copy-btn").on("click", function(event){
				event.preventDefault();
				var element = $(this).data("copy");
				copyToClipboard(element);
				$(this).parent("div.copy-parent").prepend('<span style="font-size:10px;">Copied!</span>');
				setTimeout(() => {
					$(this).parent("div.copy-parent").children('span').remove();
				}, 3000);
			})
		});
	</script>

	<script>
		function credential(){
			
			var username = "{{ ($apiData != null ) ? $apiData->username : '' }}";
			var password = "{{ ($apiData != null ) ? $apiData->password : '' }}";
			var sendername = "{{ ($apiData != null ) ? $apiData->sendername : '' }}";

			Swal.fire({
				title: '<h5>Credentials</h5>',
				text: 'You clicked the button!',
				icon: 'info',
				allowOutsideClick: false,
				showConfirmButton: false,
				showCloseButton: true,
				html:'<table class="table text-left table-sm mx-auto" style="max-width:320px;">' +
					'<tr>' +
						'<td style="color:var(--primary);font-weight:500;">Username</td>' +
						'<td>:</td>' +
						'<td><font face="monospace" id="un_copy">'+username+'</font></td>' +
						'<td><i class="far fa-copy copy-ico" data-toggle="tooltip" title="Copy" onclick="copyToClipboard(\'#un_copy\');$(this).attr(\'title\',\'Copied!\');"></i></td>' +
					'</tr>' +
					'<tr>' +
						'<td style="color:var(--primary);font-weight:500;">Password</td>' +
						'<td>:</td>' +
						'<td><font face="monospace" id="pw_copy">'+password+'</font></td>' +
						'<td><i class="far fa-copy copy-ico" data-toggle="tooltip" title="Copy" onclick="copyToClipboard(\'#pw_copy\');$(this).attr(\'title\',\'Copied!\');"></i></td>' +
					'</tr>' +
					'<tr>' +
						'<td style="color:var(--primary);font-weight:500;">Sender Name</td>' +
						'<td>:</td>' +
						'<td><font face="monospace" id="sn_copy">' +sendername+ '</font></td>' +
						'<td><i class="far fa-copy copy-ico" data-toggle="tooltip" title="Copy" onclick="copyToClipboard(\'#sn_copy\');$(this).attr(\'title\',\'Copied!\');"></i></td>' +
					'</tr>' +
					'</table>',
			})
		}
	</script>
@endsection