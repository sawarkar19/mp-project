@extends('layouts.business')
@section('title', 'Messaging API: MouthPublicity')
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

	.lh-normal,
	.lh-normal p{
		line-height: 1.3;
	}

	.code-area{
		color: #FFF!important;
		font-family: SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;
	}
</style>
@endsection
@section('content')
<section class="section">
    <div class="section-body">

		<div class="row">
			<div class="col-sm-5">
				<a href="{{ route('business.channel.apiDocs') }}" class="btn btn-primary mb-3" ><i class="far fa-copy copy-ico"></i> Documentation</a>
			</div>
			<div class="col-sm-7">
				@if(isset($routes) && !empty($routes))
					@include('business.channels.routes-toggle')
				@endif
			</div>
		</div>
		
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


		<div class="card" style="overflow: hidden;">
			<div class="card-body p-0">
				<div class="border-bottom">
					<div class="row">
						<div class="col-md-7">
							<div class="p-3 lh-normal pb-md-5 pb-4">
								<p class="text-primary"><b>API (GET Method)</b></p>
								<p>Here is the example of MouthPublicity Messaging API from the <b class="text-danger">GET Method</b>.</p>
								<p class="mb-1">URL addresses that you need to use to connect to MouthPublicity WA API is:</p>
								<p><code>{{url('api/v1/WHATSAPP_MESSAGE_API/send?')}}</code></p>
								<p class="mb-0">Just copy & paste this URL in your POS system/Billing system.</p>
							</div>
						</div>
						<div class="col-md-5">
							<div class="h-100 bg-dark p-3 pb-md-5">
								<div class="code-area">
									<code class="text-success">GET/</code>
									<p class="mb-0">{{ $api_url }}</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div>
					<div class="row">
						<div class="col-md-7">
							<div class="p-3 lh-normal pt-5 pb-md-5 pb-4">
								<p class="text-primary"><b>API (POST Method)</b></p>
								<p>Here is the example of MouthPublicity Messaging API from the <b class="text-danger">POST Method</b>.</p>
								<p class="mb-1">URL addresses that you need to use to connect to MouthPublicity WA API is:</p>
								<p class="mb-0"><code>{{url('api/v1/WHATSAPP_MESSAGE_API/send')}}</code></p>
							</div>
						</div>
						<div class="col-md-5">
							<div class="h-100 bg-dark p-3 pt-md-5 pb-md-5">
								<div class="code-area">
									<code class="text-success">POST/</code>
									<p><code>URL:</code> {{url('api/v1/WHATSAPP_MESSAGE_API/send')}}</p>
									<p class="mb-0"><code>Paremeters:</code></p>
									<table class="w-100 para-table mb-0">
										<tr>
											<td style="width: 75px">username</td>
											<td>:</td>
											<td>{{$apiData->username}}</td>
										</tr>
										<tr>
											<td>password</td>
											<td>:</td>
											<td>{{$apiData->password}}</td>
										</tr>
										<tr>
											<td>mobile</td>
											<td>:</td>
											<td>91XXXXXXXXXX</td>
										</tr>
										<tr>
											<td>sendername</td>
											<td>:</td>
											<td>{{$apiData->sendername}}</td>
										</tr>
										<tr>
											<td>message</td>
											<td>:</td>
											<td>{{ $message }}</td>
										</tr>
										<tr>
											<td>routetype</td>
											<td>:</td>
											<td>1</td>
										</tr>
									</table>
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

@include('business.channels.common-js')

@endsection