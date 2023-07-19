@extends('layouts.business')

@section('title', 'Customer Info: Business Panel')
@section('head')
@include('layouts.partials.headersection',['title'=>'Customer Info'])
@endsection

@section('end_body')
<style type="text/css">
	a:not([href]){
		color:#fff !important;
	}

    .copy-notification {
        color: #ffffff;
        background-color: rgba(0,0,0,0.8);
        padding: 20px;
        border-radius: 30px;
        position: fixed;
        top: 50%;
        left: 50%;
        width: 150px;
        margin-top: -30px;
        margin-left: -85px;
        display: none;
        text-align:center;
    }


	#side-info-panel{
		position: fixed;
		width: 100%;
		height: 100%;
		background: rgba(0,0,0,0.3);
		z-index: -10;
		top: 0;
		left: 0;
		opacity: 0;
		overflow: hidden;
		outline: 0;
	}
	#side-info-panel .sip-bar{
		width: 100%;
		max-width:450px;
		height: 100vh;
		overflow-x: hidden;
		overflow-y: auto;
		background: #fbfbfb;
		position: fixed;
		z-index: 999;
		right: -460px;
		top: 0;
		transition: all 300ms ease;
	}
	#side-info-panel .sip-bar::-webkit-scrollbar{
		display: none;
	}
	#side-info-panel .sip-bar > .sip-inner{
		position: relative;
		padding: 30px;
	}

	#side-info-panel.show{
		z-index: 99999;
		opacity: 1;
		transition: all 300ms ease;
	}
	#side-info-panel.show .sip-bar{
		right: 0;
	}
</style>
@endsection

@section('content')

<div class="row">
	<div class="col-sm-6">
		<div class="card">
			<div class="card-body">
				<ul class="list-group">
					<li class="list-group-item d-flex justify-content-between align-items-center">
						{{ __('Mobile') }}: <b>{{ $info->mobile }}</b>
					</li>
					<li class="list-group-item d-flex justify-content-between align-items-center">
						{{ __('Name') }}: <b>@if($info->detail->name){{ $info->detail->name }}@else{{ '---' }}@endif</b> 
					</li>
					<li class="list-group-item d-flex justify-content-between align-items-center">
						{{ __('DOB') }}: <b>@if($info->detail->dob){{ \Carbon\Carbon::parse($info->detail->dob)->format('j M') }}@else{{ '---' }}@endif</b>
					</li>
					<li class="list-group-item d-flex justify-content-between align-items-center">
						{{ __('Anniversary date') }}: <b>@if($info->detail->anniversary_date){{ \Carbon\Carbon::parse($info->detail->anniversary_date)->format('j M') }}@else{{ '---' }}@endif</b>
					</li>
					{{-- <li class="list-group-item d-flex justify-content-between align-items-center">
						{{ __('Registration Date') }}: <b>{{ \Carbon\Carbon::parse($info->created_at)->format('j F, Y') }}</b>
					</li> --}}
				</ul>   		
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="card">
			<div class="card-body">
				<ul class="list-group">
					<li class="list-group-item d-flex justify-content-between align-items-center">
						{{ __('Total Offers') }}
						<span class="badge badge-info badge-pill">{{ $info->offers_count }}</span>
					</li>
					<li class="list-group-item d-flex justify-content-between align-items-center">
						{{ __('Total Active Offers') }}
						<span class="badge badge-warning badge-pill">{{ $info->offers_active_count }}</span>
					</li>
					<li class="list-group-item d-flex justify-content-between align-items-center">
						{{ __('Total Complete Offers') }}
						<span class="badge badge-success badge-pill">{{ $info->offers_complete_count }}</span>
					</li>
					<li class="list-group-item d-flex justify-content-between align-items-center">
						{{ __('Total Incomplete Offers') }}
						<span class="badge badge-primary badge-pill">{{ $info->offers_incomplete_count }}</span>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4>{{ __('Offer History')}}</h4>
			</div>
			<div class="card-body p-0">
				@if(count($offers) != 0)
					<div class="table-responsive table-invoice">
						<table class="table table-striped">
							<tbody><tr>
								<th>{{ __('Offer Id') }}</th>
								<th>{{ __('Offer Name') }}</th>
								
								<th>{{ __('Offer Type') }}</th>
								<th>{{ __('Offer Status') }}</th>
								<th>{{ __('Action') }}</th>
							</tr>
							@foreach($offers as $row)
							@php
								if($row->offer->type == 'future'){
									$targets = \DB::table('offer_futures')->where('offer_id', $row->offer_id)->first();
									$required_target = $targets->share_target;
								}else{
									$targets = \DB::table('offer_instants')->where('offer_id', $row->offer_id)->first();
									$required_target = $targets->target;
								}
							@endphp
							<tr>
								<td>
									@if($row->offer->type == 'future')
										<a href="{{ route('business.future.show',$row->offer->id.'?type='.$row->offer->sub_type) }}">#{{ $row->offer->uuid }}</a>
									@elseif($row->offer->type == 'instant')
										<a href="{{ route('business.instant.show',$row->offer->id) }}">#{{ $row->offer->uuid }}</a>
									@endif
									
								</td>
								<td class="font-weight-600">
									{{ $row->offer->title }}
								</td>
								<td>
									@if($row->offer->type == 'future')
										@if($row->offer->sub_type == 'MadeShare')
											<span class="badge badge-warning">Make & Share</span>
										@else
											<span class="badge badge-warning">{{ $row->offer->sub_type }}</span>
										@endif
										
									@elseif($row->offer->type == 'instant')
										<span class="badge badge-success">{{ __('Instant') }}</span>
									@endif
								</td>
								<td>
									@if($row->status=='1')
										<span class="badge badge-primary">{{ __('Active') }}</span>
									@elseif($row->status=='2')
										@if($row->is_redeemed)
											<span class="badge badge-success">{{ __('Redeemed') }}</span>
										@else
											<span class="badge badge-success">{{ __('Completed') }}</span>
										@endif
										
									@elseif($row->status=='3')
										<span class="badge badge-danger">{{ __('Incomplete') }}</span>
									@elseif($row->status=='4')
										<span class="badge badge-danger">{{ __('Canceled') }}</span>
									@endif
								</td>
								{{-- <td>
									{{Carbon\Carbon::parse($row->offer->end_date)->isoFormat('Do MMM Y')}}
								</td> --}}

								<td>
									@if($row->offer->sub_type != 'MadeShare')
									<a href="#" class="btn btn-info sip-info-btn" id="{{ $row->id }}">Offer Details</a>
									@endif
								</td>
								
							</tr>
							@endforeach
							</tbody>
						</table>
						{{ $offers->links('vendor.pagination.bootstrap-4') }}
					</div>
				@else
					<div>
						<h3 style="text-align:center;">No Offer Record Found!</h3>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>

<div id="side-info-panel">
	<div class="sip-bar" id="sip-bar">
		<div class="sip-inner">

			<div class="mb-3">
				<a href="#" class="badge badge-danger" id="close_sip">X</a>
			</div>
			
			<div id="content_card">

				<div class="card card-primary">
					<div class="card-header px-3" style="min-height: auto;">
						<h4>Offer Detail</h4>
						<div class="card-header-action">
							{{-- Offer Status --}}
							<span id="offer_status" class="badge badge-success">N/A</span>
						</div>
					</div>
					<div class="card-body">
						<h6 id="offer_name" class="mb-4">Offer name here.</h6>
						<div>
							<table class="table table-borderless table-sm">
								<tr id="offer_type">
									<td>Offer Type</td>
									<td>:</td>
									<td id="offer_type_val">N/A</td>
								</tr>
								<tr class="require_visits" style="display: none;">
									<td>Required Visits</td>
									<td>:</td>
									<td class="require_visits_val">N/A</td>
								</tr>
								<tr class="max_visits" style="display: none;">
									<td>Maximum Visits</td>
									<td>:</td>
									<td class="max_visits_val">N/A</td>
								</tr>
								<tr class="task_to_complete" style="display: none;">
									<td>Task To Complete</td>
									<td>:</td>
									<td class="task_to_complete_val">N/A</td>
								</tr>
							</table>
						</div>
					</div>
				</div>

				<div class="card card-warning">
					<div class="card-header px-3" style="min-height: auto;">
					  <h4 class="text-warning">Subscription Detail</h4>
					</div>
					<div class="card-body">
						<div>
							<table class="table table-borderless table-sm">
								<tr>
									<td>Subscribe Date</td>
									<td>:</td>
									<td id="subscription_date">N/A</td>
								</tr>
								{{-- required --}}
								<tr class="require_visits" style="display: none;">
									<td>Required Visits</td>
									<td>:</td>
									<td class="require_visits_val">N/A</td>
								</tr>
								<tr class="max_visits" style="display: none;">
									<td>Maximum Visits</td>
									<td>:</td>
									<td class="max_visits_val">N/A</td>
								</tr>
								<tr class="task_to_complete" style="display: none;">
									<td>Task To Complete</td>
									<td>:</td>
									<td class="task_to_complete_val">N/A</td>
								</tr>
								{{-- acheived --}}
								<tr class="clicks_completed" style="display: none;">
									<td>Unique Clicks</td>
									<td>:</td>
									<td class="unique_clicks_val">N/A</td>
								</tr>
								<tr class="clicks_completed" style="display: none;">
									<td>Extra Clicks</td>
									<td>:</td>
									<td class="repeated_clicks_val">N/A</td>
								</tr>
								<tr class="clicks_completed" style="display: none;">
									<td>Total Clicks</td>
									<td>:</td>
									<td class="total_clicks_val">N/A</td>
								</tr>

								<tr class="task_completed" style="display: none;">
									<td>Task Completed</td>
									<td>:</td>
									<td class="task_completed_val">N/A</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
	
				<div class="card card-success" id="normalRedeem" style="display: none;">
					<div class="card-header px-3" style="min-height: auto;">
					  <h4 class="text-success">Redeem Detail</h4>
					</div>
					<div class="card-body">
						<div>
							<table class="table table-borderless table-sm">
								<tr>
									<td>Is Redeemed</td>
									<td>:</td>
									<td>
										<span class="text-success yes_redeemed" style="display:none;">Yes</span> 
										<span class="text-danger not_redeemed" style="display:none;">No</span> 
									</td>
								</tr>
								<tr class="if_redeemed">
									<td>Redeem Date</td>
									<td>:</td>
									<td class="redeemed_date">N/A </td>
								</tr>
								<tr class="if_redeemed">
									<td>Redeem Amount</td>
									<td>:</td>
									<td class="redeemed_amount">&#8377; N/A</td>
								</tr>
								<tr class="if_redeemed">
									<td>On Total Bill </td>
									<td>:</td>
									<td class="total_amount">&#8377; N/A</td>
								</tr>
								<tr class="if_redeemed">
									<td>Paid Bill </td>
									<td>:</td>
									<td class="paid_amount">&#8377; N/A</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
	
				<div class="card card-success" id="repeatedRedeem" style="display: none;">
					<div class="card-header px-3" style="min-height: auto;">
					  <h4 class="text-success">Redeem Detail</h4>
					</div>
					<div class="card-body">
						<div>
							<table class="table table-borderless table-sm">
								<tr class="not_redeemed" style="display:none;">
									<td>Is Redeemed</td>
									<td>:</td>
									<td>
										<span class="text-danger">No</span> 
									</td>
								</tr>
								<tr id="total_redeemed_amount" style="display: none;">
									<td>Total Redeem Amount</td>
									<td>:</td>
									<td id="redeemed_amount_val">&#8377; N/A</td>
								</tr>
								<tr id="total_redeemed_count" style="display: none;">
									<td>Redeem Counts</td>
									<td>:</td>
									<td id="redeemed_count_val">N/A</td>
								</tr>
							</table>
	
							<div>
								<div class="list-group" id="redeemed_list" style="display: none;">
									
								  </div>
							</div>
	
						</div>
					</div>
				</div>

			</div>

		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$(".sip-info-btn").on("click", function(e){
			e.preventDefault();

			var sub_id = $(this).attr('id');
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			var input = {
				'sub_id': sub_id,
				'_token': CSRF_TOKEN
			}

			$.ajax({
				url: '{{ route('business.getSubscriptionData') }}',
				type: 'POST',
				data: input,
				dataType: 'json',
				success: function(response){

					console.log(response.data);

					//offer title
					$('#offer_name').text(response.data.offer_details.title);

					if(response.data.offer_details.sub_type == null){
						$('#offer_type_val').text('Instant');

						$('.task_to_complete').show();
						$('.task_to_complete_val').text(response.data.target);

						$('.task_completed').show();
						$('.task_completed_val').text(response.data.completed_task.length);
					}else{
						$('#offer_type_val').text(response.data.offer_details.sub_type);
						if(response.data.offer_details.sub_type == 'PerClick'){
							$('.max_visits').show();
							$('.max_visits_val').text(response.data.offer_details.future_offer.max_promo_count);
						}else{
							$('.require_visits').show();
							$('.require_visits_val').text(response.data.target);
						}

						var unique = (response.data.targets.length + response.data.targets_parent.length);
						var extra = (response.data.extra_targets.length + response.data.extra_targets_parent.length);
						var total = unique + extra;
						$('.clicks_completed').show();
						$('.unique_clicks_val').text(unique);
						$('.repeated_clicks_val').text(extra);
						$('.total_clicks_val').text(total);
					}

					//offer status update
					if(response.data.status == 1){
						$('#offer_status').text('Active');
						$('#offer_status').css('background-color','#08379c');
					}
					if(response.data.status == 2){
						if(response.data.redeem_data[0].is_redeemed == 0){
							$('#offer_status').text('Completed');
						}else{
							$('#offer_status').text('Redeemed');
						}
						$('#offer_status').css('background-color','#47c363');
					}
					if(response.data.status == 3){
						$('#offer_status').text('Incomplete');
						$('#offer_status').css('background-color','#fc544b');
					}
					if(response.data.status == 4){
						$('#offer_status').text('Canceled');
						$('#offer_status').css('background-color','#fc544b');
					}

					//subscription details
					const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
						];

					var formattedDate = new Date(response.data.created_at);
					var d = formattedDate.getDate();
					var y = formattedDate.getFullYear();

					$("#subscription_date").text(d + " " + monthNames[formattedDate.getMonth()] + ", " + y);

					//redeem details
					if(response.data.redeem_data.length > 0 && response.data.offer_details.sub_type == 'PerClick'){
						$('#repeatedRedeem').show();

						if(response.data.redeem_data[0].is_redeemed == 0){
							$('.not_redeemed').show();
						}else{
							$('#total_redeemed_amount').show();
							$('#total_redeemed_count').show();
							$('#redeemed_list').show();

							var total_redeem_amt = 0;
							var total_redeem_count = 0;
							var clicks = 0;
							var redeem_list = '';

							$.each( response.data.redeem_data, function( i, val ) {
								var redeem_amount = val.redeem_details.actual_amount - val.redeem_details.calculated_amount;

								if(val.is_redeemed == 1){
									total_redeem_amt = total_redeem_amt + parseFloat(redeem_amount);
									total_redeem_count = total_redeem_count + 1;
								}

								clicks = val.redeem_details.no_of_clicks;
								var formattedDate = new Date(val.redeem_details.created_at);
								var d = formattedDate.getDate();
								var y = formattedDate.getFullYear();
								var redeem_date = d + " " + monthNames[formattedDate.getMonth()] + ", " + y;

								var redeemed_amount = (val.redeem_details.actual_amount - val.redeem_details.redeem_amount).toFixed(2);;
								var total_amount = (val.redeem_details.actual_amount - 0).toFixed(2);;
								var paid_amount = (val.redeem_details.redeem_amount - 0).toFixed(2);;

								redeem_list = redeem_list+'<span class="list-group-item list-group-item-action flex-column align-items-start"><div class="d-flex w-100 justify-content-between"><h6 class="mb-1 p-1">For <strong>'+clicks+' Click(s)</strong></h6><small>'+redeem_date+'</small></div><table class="table table-borderless table-sm"><tr><td>Redeem Amount</td><td>:</td><td>&#8377; '+redeemed_amount+'</td></tr><tr><td>On Total Bill OF</td><td>:</td><td>&#8377; '+total_amount+'</td></tr><tr><td>Paid Amount</td><td>:</td><td>&#8377; '+paid_amount+'</td></tr></table></span>';
								
							  	
							});

							$('#redeemed_amount_val').text('₹ '+total_redeem_amt.toFixed(2));
							$('#redeemed_count_val').text(total_redeem_count);
							$('#redeemed_list').html(redeem_list);
						}
					}else if(response.data.redeem_data.length > 0 && response.data.offer_details.sub_type != 'PerClick'){
						$('#normalRedeem').show();

						if(response.data.redeem_data[0].is_redeemed == 0){
							$('.not_redeemed').show();
							$('.if_redeemed').hide();
						}else{
							$('.yes_redeemed').show();
							$('.if_redeemed').show();

							var redeemed_amount = (response.data.redeem_data[0].redeem_details.actual_amount - response.data.redeem_data[0].redeem_details.redeem_amount).toFixed(2);
							var total_amount = (response.data.redeem_data[0].redeem_details.actual_amount - 0).toFixed(2);
							var paid_amount = (response.data.redeem_data[0].redeem_details.redeem_amount - 0).toFixed(2);;

							$('.redeemed_amount').text('₹ '+redeemed_amount);
							$('.total_amount').text('₹ '+total_amount);
							$('.paid_amount').text('₹ '+paid_amount);

							var formattedDate = new Date(response.data.redeem_data[0].redeem_details.created_at);
							var d = formattedDate.getDate();
							var y = formattedDate.getFullYear();
							var redeem_date = d + " " + monthNames[formattedDate.getMonth()] + ", " + y;

							$('.redeemed_date').text(redeem_date);
						}
					}
					


					if(response.success == true){
	                    $("#side-info-panel").toggleClass('show');
	                }else{
	                    Sweet('error',response.message);
	                } 
				},
				error: function(xhr, status, error){
					$.each(xhr.responseJSON.errors, function(key, item){
						Sweet('error',item);
					});
				}
			})
			
		});

		$("#close_sip").on("click", function(e){
			e.preventDefault();
			$("#side-info-panel").toggleClass('show');

			hideElements();
		});
	});

	$(document).mouseup(function(e) {
		var container = $("#sip-bar");
		if (!container.is(e.target) && container.has(e.target).length === 0){
			container.parent("#side-info-panel").removeClass('show');

			hideElements();
		}
	});

	function hideElements(){
		//hide data
		$('.task_to_complete').hide();
		$('.max_visits').hide();
		$('.require_visits').hide();
		$('.task_completed').hide();
		$('.clicks_completed').hide();
		$('#normalRedeem').hide();
		$('#repeatedRedeem').hide();
		$('.yes_redeemed').hide();
		$('.not_redeemed').hide();
		$('.if_redeemed').hide();
		$('#total_redeemed_amount').hide();
		$('#total_redeemed_count').hide();
		$('#redeemed_list').hide();
	}
</script>

@endsection

@section('end_body')

	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.btn-primary', function (e) {
				$(this).popover('show').focus();
			});
		});
	</script>
	<script>

        function CopyToClipboard(value, showNotification, notificationText) {
        	var copyText = value;
            copyText.select();
		  	navigator.clipboard.writeText(copyText.value);

            if (typeof showNotification === 'undefined') {
                showNotification = true;
            }
            if (typeof notificationText === 'undefined') {
                notificationText = "Copied to clipboard";
            }

            var notificationTag = $("div.copy-notification");
            if (showNotification && notificationTag.length == 0) {
                notificationTag = $("<div/>", { "class": "copy-notification", text: notificationText });
                $("body").append(notificationTag);

                notificationTag.fadeIn("slow", function () {
                    setTimeout(function () {
                        notificationTag.fadeOut("slow", function () {
                            notificationTag.remove();
                        });
                    }, 1000);
                });
            }
        }
	</script>

@endsection