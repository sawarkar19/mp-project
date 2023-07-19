@extends('layouts.business')
@section('title', 'Challenges: Business Panel')
@section('head')
    @include('layouts.partials.headersection',['title'=>'Channels'])
@endsection

@section('end_head')
<style>
	.channel_head i{
		font-size: 24px;
		color: #000;
	}
	#channel a{
		text-decoration: none;
	}
	#channel a:hover {
	    text-decoration: none;
	}
	.channel_head span{
		color: #fff;
		font-size: 8px;
		padding: 5px 8px
	}
	.card.channel .channel_body h6{
		color: #434D4A;
	}
	.card.channel .channel_body p{
		display: -webkit-box;
	    -webkit-line-clamp: 2;
	    -webkit-box-orient: vertical;
	    line-height: 20px;
	    overflow: hidden;
	    text-overflow: ellipsis;
	    cursor: pointer;
	    color: #434D4A;
	}
	.my_channels > .card{
		/*height: 100%;*/
	}
	/* .disable_box .card{
		opacity: 0.6;
	} */
	.disable_box{
		pointer-events: none;
		opacity: 0.6;
	}

	.card.channel{
		transition: all 300ms ease-in-out;
		height: 100%;
		margin-bottom: 0px;
	}
	.channel .card-body{
		padding-top: 15px;
		padding-bottom: 15px;
	}
	.card.channel:hover{  
    	box-shadow: 9px 9px 16px #e4e4e4fa;
	}
	.purchase-btn{
		position: absolute;
		left: 40px;
		bottom: 15px;
		opacity: 1;
		z-index: 2;
	}

</style>
@endsection

@section('content')
<section id="channel">
	

	@if(count($challenges) > 0)
	<section class="section"> 
		<div class="section-body">
			<h6 class="section-title text-primary mt-0">My Challenges</h6>
			<div class="my_channels">
				<div class="row">
				
					@foreach($challenges as $challenge)
					
					<div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-4">
						
						<a href="{{ url('business/channel/'.$challenge->id).$challenge->route }}">
							<div class="card channel">
								<div class="channel_head pt-3 mx-4 d-flex justify-content-start align-items-center">
									<i class="fntlo {{ $challenge->font_icon }} mr-2"></i>
									<h6 class="mb-0">{{ $challenge->name }}</h6>
								</div>
								<div class="card-body channel_body">
									<p>{{ $challenge->description }}</p>

									<div class="w-100 d-flex align-items-center justify-content-between">
										
										<div>
											@if($challenge->is_use_msg == 1)

												@php
													$route = App\Http\Controllers\Business\RouteToggleContoller::routeDetail($challenge->id, auth()->user()->id);
												@endphp

												@if($route->wa)
													<span class="badge badge-success" data-toggle="tooltip" title="WhatsApp Route: ON" id="{{ $challenge->slug.'_wa' }}">
														<i class="fab fa-whatsapp m-0"></i>
													</span>
												@else
													<span class="badge badge-secondary" data-toggle="tooltip" title="WhatsApp Route: OFF" id="{{ $challenge->slug.'_wa' }}">
														<i class="fab fa-whatsapp m-0"></i>
													</span>

												@endif

												@if($route->sms)
													<span class="badge badge-primary" data-toggle="tooltip" title="SMS Route: ON" id="{{ $challenge->slug.'_sms' }}">
														<i class="far fa-comment-dots m-0"></i>
													</span>
												@else
													<span class="badge badge-secondary" data-toggle="tooltip" title="SMS Route: OFF" id="{{ $challenge->slug.'_sms' }}">
														<i class="far fa-comment-dots m-0"></i>
													</span>

												@endif
											@endif
										</div>
										<div>
											@if($challenge->user_channel->status == 1)
												<label class="message-route-toggle custom-switch mb-0 pl-0" id="ch_{{ $challenge->id }}" data-toggle="tooltip" title="Change Status">
													<input type="checkbox" data-toggle="toggle" name="channel_id" value="{{$challenge->id}}" class="custom-switch-input" @if ($challenge->id) checked @endif onchange="changeStatus('{{$challenge->id}}', 0)">
													<span class="custom-switch-description ml-0 mr-1" id="span{{$challenge->id}}"></span>
													<span class="custom-switch-indicator"></span>
												</label>
											@else
												<label class="message-route-toggle custom-switch mb-0 pl-0" id="ch_{{ $challenge->id }}" data-toggle="tooltip" title="Change Status">
													<input type="checkbox" data-toggle="toggle" name="channel_id" value="{{$challenge->id}}" class="custom-switch-input" onchange="changeStatus('{{$challenge->id}}', 1)">
													<span class="custom-switch-description ml-0 mr-1" id="span{{$challenge->id}}"></span>
													<span class="custom-switch-indicator"></span>
												</label>
											@endif
										</div>
									</div>
				                </div>
								
			    			</div>
						</a>
						
					</div>

					@endforeach
			
				</div>
			</div>		
		</div>
	</section> 	
	@endif
	
	<br>
	<br>

	@if(count($channels) > 0)
	<section class="section"> 
		<div class="section-body">
			<h6 class="section-title text-primary mt-0">My Channels</h6>
			<div class="my_channels">
				<div class="row">
				
					@foreach($channels as $channel)
					
					<div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-4">
						<a href="{{ url('business/channel/'.$channel->id).$channel->route }}">
							<div class="card channel">
								<div class="channel_head pt-3 mx-4 d-flex justify-content-start align-items-center">
									<i class="fntlo {{ $channel->font_icon }} mr-2"></i>
									<h6 class="mb-0">{{ $channel->name }}</h6>
								</div>
								<div class="card-body channel_body">
									<p>{{ $channel->description }}</p>

									<div class="w-100 d-flex align-items-center justify-content-between">
										
										<div>
											@if($channel->is_use_msg == 1)

												@php
													$route = App\Http\Controllers\Business\RouteToggleContoller::routeDetail($channel->id, auth()->user()->id);
												@endphp

												@if($route->wa)
												
													@if($channel->id != 5)
														<span class="badge badge-success" data-toggle="tooltip" title="WhatsApp Route: ON" id="{{ $channel->slug.'_wa' }}">
															<i class="fab fa-whatsapp m-0"></i>
														</span>
													@endif
												@else
													@if($channel->id != 5)
														<span class="badge badge-secondary" data-toggle="tooltip" title="WhatsApp Route: OFF" id="{{ $channel->slug.'_wa' }}">
															<i class="fab fa-whatsapp m-0"></i>
														</span>
													@endif
													
												@endif

												@if($route->sms)
													<span class="badge badge-primary" data-toggle="tooltip" title="SMS Route: ON" id="{{ $channel->slug.'_sms' }}">
														<i class="far fa-comment-dots m-0"></i>
													</span>
												@else
													<span class="badge badge-secondary" data-toggle="tooltip" title="SMS Route: OFF" id="{{ $channel->slug.'_sms' }}">
														<i class="far fa-comment-dots m-0"></i>
													</span>
												@endif
											@endif
										</div>
										<div>
											@if($channel->user_channel->status == 1)
												<label class="message-route-toggle custom-switch mb-0 pl-0" id="ch_{{ $channel->id }}" data-toggle="tooltip" title="Change Status">
													<input type="checkbox" data-toggle="toggle" name="channel_id" value="{{$channel->id}}" class="custom-switch-input" @if ($channel->id) checked @endif onchange="changeStatus('{{$channel->id}}', 0)">
													<span class="custom-switch-description ml-0 mr-1" id="span{{$channel->id}}"></span>
													<span class="custom-switch-indicator"></span>
												</label>
											@else
												<label class="message-route-toggle custom-switch mb-0 pl-0" id="ch_{{ $channel->id }}" data-toggle="tooltip" title="Change Status">
													<input type="checkbox" data-toggle="toggle" name="channel_id" value="{{$channel->id}}" class="custom-switch-input" onchange="changeStatus('{{$channel->id}}', 1)">
													<span class="custom-switch-description ml-0 mr-1" id="span{{$channel->id}}"></span>
													<span class="custom-switch-indicator"></span>
												</label>
											@endif
										</div>
									</div>
				                </div>
							</a>
						</div>

					</div>

					@endforeach
			
				</div>
			</div>		
		</div>
	</section> 	
	@endif

</section>
  

@endsection
@section('end_body')

@endsection
@push('js')
	<script>
		function changeStatus(id, status) {       
		if(id == 4 && status == 1) {
			
			var is_paid = '{{ auth()->user()->current_account_status }}';

            /*if(is_paid == 'free'){
                Sweet('error',"{{ Config::get('constants.payment_alert')}}");
                setTimeout(() => {
                            location.reload();
                }, 2000);
                return false;
            }*/

			var MsgAPIDeductionValue = "<?php echo $MsgAPIDeductionValue; ?>";
			var MsgDeductionValue = "<?php echo $MsgDeductionValue; ?>";
			var WalletBalance = "<?php echo $planData['message_plan']->wallet_balance; ?>";
			var MsgApidh = "<?php echo $MsgApidh; ?>";
			
			/*if(MsgApidh==1){
				if(MsgAPIDeductionValue > WalletBalance){
					Sweet('error',"{{ Config::get('constants.payment_alert')}}");
	                setInterval(() => {
                                window.location.href = '{{ url('/business/channels' ) }}';
                            }, 2000);
	                return false
				}
			}*/
			if(MsgApidh==1){
				$.get("{{URL::to('business/channel/changeStatus')}}",{id: id, status: status}, function(res){
						if(res.status==false){
							if(res.message=='Low'){
                            	return paidtofree();
	                        }else{
	                            Sweet('error','something went wrong');
	                        }
						}else{
							if(status == 0) {
								$('#ch_'+id+' input').remove();
								appendToggle(id, status)
							}else{
								$('#ch_'+id+' input').remove();
								appendToggle(id, status)
							}
						}
						
				})
			}else{
				Swal.fire({
		          title: '<strong>Please Note!</strong>',
		          icon: 'info',
		          html:
		            'You will be charged '+MsgAPIDeductionValue+' ₹/day on enabling Messaging API and You can send Unlimited Whatsapp Messages. Also you can send Unlimited SMS with just '+MsgDeductionValue+' Paisa/Message. But if you are a FREE user you will not be charged any amount and you can send Only 10 Whatsapp Messages per day.',
		          showCloseButton: false,
		          showCancelButton: true,
		          focusConfirm: false,
		          allowOutsideClick:false,
		          confirmButtonText:
		            'Enable',
		          cancelButtonText:
		            'Cancel'
		      }).then((result) => {

		        if (result.value == true) {
		          $.get("{{URL::to('business/channel/changeStatus')}}",{id: id, status: status}, function(res){
		          		if(res.status==false){
		          			if(res.message=='Low'){
                            	return paidtofree();
	                        }else{
	                            Sweet('error','something went wrong');
	                        }
		          		}else{
		          			if (status == 0) {
								$('#ch_'+id+' input').remove();
								appendToggle(id, status)
							}else{
								$('#ch_'+id+' input').remove();
								appendToggle(id, status)
							}
		          		}
						
					})
		        }else{
		        	window.location.href = '{{ url('/business/channels' ) }}';
		        }

		      });
			}
			
		  }else{

			  	$.get("{{URL::to('business/channel/changeStatus')}}",{id: id, status: status}, function(res){
			  		if(res.status==false){
						if(res.message=='Low'){
                            	return paidtofree();
	                    }else{
	                            Sweet('error','something went wrong');
	                    }
					}else{
						if (status == 0) {
							$('#ch_'+id+' input').remove();
							appendToggle(id, status)
						}else{
							$('#ch_'+id+' input').remove();
							appendToggle(id, status)
						}
					}
					
				})
		  }
			
		}

		function appendToggle(id, status){
			if (status == 0) {
				$('<input type="checkbox" data-toggle="toggle" name="channel_id" value="'+id+'" class="custom-switch-input" onchange="changeStatus('+id+', 1)">').insertBefore('#span'+id);
				Sweet('error', "Deactivated Successfully!");
			}else{
				$('<input type="checkbox" data-toggle="toggle" name="channel_id" value="'+id+'" class="custom-switch-input" checked onchange="changeStatus('+id+', 0)">').insertBefore('#span'+id);
				Sweet('success', "Activated Successfully!");
			}
		}

		function paidtofree(){
			$('.swal2-cancel').attr('id','btnCancel');
			$('.swal2-close').attr('id','btnCancel');
        Swal.fire({
                title: '<strong>Please recharge</strong>',
                icon: 'info',
                html:
                    '<strong>Note:</strong> If click on <strong>"Convert To Free"</strong> button your running <strong>Offer</strong> and <strong>Subscriptions</strong> will be marked as <strong>Expired</strong>.',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText:
                    'Convert To Free',
                confirmButtonAriaLabel: 'Convert To Free',
                cancelButtonText:
                    'Recharge Now',
                cancelButtonAriaLabel: 'Recharge Now',
                cancelButtonColor: '#31ce55',
            }).then((result) => {
                if(result.value){
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    var data = {
                        "_token" : CSRF_TOKEN
                    };
                    $.ajax({
                        url : "{{ route('business.convertPaidToFree') }}",
                        type : 'get',
                        data : data,
                        dataType : "json",
                        success : function(res) {
                            if(res.status == true){
                                Swal.fire({
                                    title: 'Your account successfully converted to FREE account.',
                                    showClass: {
                                        popup: 'animate__animated animate__fadeInDown'
                                    },
                                    hideClass: {
                                        popup: 'animate__animated animate__fadeOutUp'
                                    }
                                }).then((result) => {
                                    if(result.value){
                                        window.location.reload();
                                    }
                                });
                            }
                        }
                    });
                }else{
                   if(result.dismiss=="cancel"){
                   		window.location.href = '{{ route('pricing') }}';
                   }else{
                   		window.location.href = '{{ route('business.channels') }}';
                   }
                }

            });
    }
	</script>
@endpush
