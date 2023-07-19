@extends('layouts.business')
@section('title', 'Offers: Business Panel')
@section('head')
	<div class="section-header">
			@if($request_data['type'] == 'PerClick')
				<h1>Cash Per Click Offers</h1>
			@elseif($request_data['type'] == 'Fixed')
				<h1>Fixed Amount Offers</h1>
			@elseif($request_data['type'] == 'Percentage')
				<h1>Percentage Discount Offers</h1>
			@else
				<h1>Make & Share Offers</h1>
			@endif

			
			<div class="section-header-breadcrumb d-block mb-0">
				<p class="mb-0">
					Business
					/ Offers
					@if($request_data['type'] == 'PerClick')
						/ Cash Per Click Offers
					@elseif($request_data['type'] == 'Fixed')
						/ Fixed Amount Offers
					@elseif($request_data['type'] == 'Percentage')
						/ Percentage Discount Offers
					@else
						/ Make & Share Offers
					@endif
				</p>
			</div>
		</div>
@endsection
@section('end_head')
<style>
	label span,.mark-required{color:red;}

	.swal2-input{text-align:center;text-transform:uppercase;    font-size: 16px;}

    .container-redeem-invoice .calculate-total, .container-redeem .calculate-total{
    	border: 0;
	    border-radius: .25em;
	    background: initial;
	    background-color: #3085d6;
	    color: #fff;
	    font-size: 1.0625em;
	    display: inline-block;
	    border-left-color: rgb(48, 133, 214);
	    border-right-color: rgb(48, 133, 214);
	    padding: 10px;
        margin-bottom: 10px;
    }
    .container-redeem-invoice .calculate-total:hover, .container-redeem .calculate-total:hover{
	    background-image: linear-gradient(rgba(0,0,0,.1),rgba(0,0,0,.1));
    }
    .container-redeem-invoice .swal2-styled.swal2-confirm, .container-redeem .swal2-styled.swal2-confirm{
	    background-color: #30d654 !important;
        border-left-color: rgb(66 214 48) !important;
		border-right-color: rgb(66 214 48) !important;
    }
    .container-redeem-invoice .total-amount span, .container-redeem .total-amount span{
    	font-size: 16px !important;
    }
    hr.dashed {
	    border-top: 2px dashed #dedede;
    	margin: 0.4rem 0;
	}
	.reset-btn{
	    padding: 10px !important;
		width: 100px;
	}
	p.setDefault{
		cursor: pointer;
	    padding: 10px 20px;
	    font-size: 13px;
	    font-weight: 500;
	    line-height: 1.2;
	}
	.min-height{
		min-height: 200px;
	}
	#grid-style nav, #list-style nav{
		    width: 100% !important;
        margin-top: 20px;
	}

	.swal2-input{
		margin-top: 0px !important;
	}
	.popup-card .card-header{
		min-height: 55px;
		padding: 10px 15px;
	}
	.popup-card .card-body{
		padding: 10px 15px;
	}
	.popup-card .card-body p{
		font-weight: 300;
		font-size: 13px;
		text-align: left;
		line-height: 1.8;
	}
	.swal2-page-type .swal2-title{
		margin-top: 25px;
    	margin-bottom: 30px;
	}
	.subscription_count{
		color: rgb(48, 133, 214);
    font-weight: 600;
	}
</style>
<style>
    #overlay{   
      position: fixed;
      top: 0;
      z-index: 9999;
      width: 100%;
      height:100%;
      display: none;
      background: rgba(0,0,0,0.6);
    }
    .cv-spinner {
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;  
    }
    .spinner {
      width: 40px;
      height: 40px;
      border: 4px #ddd solid;
      border-top: 4px #2e93e6 solid;
      border-radius: 50%;
      animation: sp-anime 0.8s infinite linear;
    }
    @keyframes sp-anime {
      100% { 
        transform: rotate(360deg); 
      }
    }
    .is-hide{
      display:none;
    }
    .action_btn{
	    padding: 0.5rem 0.8rem;
  		font-size: 14px;
    }

    .container-redeem-invoice .swal2-title{
	    display: flex;
	    background: linear-gradient( 
	115deg
	 , #00FFAF 0%, #00249C 80%);
	    -webkit-background-clip: text;
	    -webkit-text-fill-color: transparent;
	    margin-bottom: 25px !important;
	}
</style>
@endsection

@section('content')
	<section class="section">

	

		<div class="row">
			<div class="col-sm-12 mb-4">	
				<div class="row align-item-center">
					<div class="col-sm-8 mb-4 mb-sm-0">
						<a href="{{ route('business.future.index','type='.$request_data['type']) }}" class="mr-2 mb-1 btn btn-outline-primary @if($offer_type==="all") active @endif">{{ __('All') }} ({{ $all }})</a>
						<a href="{{ route('business.future.index','type='.$request_data['type'].'&offer_type=publish') }}" class="mr-2 btn btn-outline-primary @if($offer_type==="publish") active @endif">{{ __('Published') }} ({{ $published }})</a>
						<a href="{{ route('business.future.index','type='.$request_data['type'].'&offer_type=draft') }}" class="mr-2 btn btn-outline-warning @if($offer_type=="draft") active @endif">{{ __('Draft') }} ({{ $draft }})</a>
						
						@if($request_data['type'] != 'MadeShare')
							<a href="{{ route('business.future.index','type='.$request_data['type'].'&offer_type=expired') }}" class="mr-2 btn btn-outline-danger @if($offer_type=="expired") active @endif">{{ __('Expired') }} ({{ $expired }})</a>
						@endif

						
					</div>			
					<div class="col-sm-4 float-right" style="margin-bottom:1rem;">
						<a href="#" class="btn btn-primary btn-lg float-right"
						 onclick="createOffer()">
							Create Offer
						</a>
					</div>
				</div>
			</div>

			<div class="col-12">
				<div class="card card-primary">
					<div class="card-header">
						@if($request_data['type'] == 'PerClick')
							<h4>Cash Per Click Offers</h4>
						@elseif($request_data['type'] == 'Fixed')
							<h4>Fixed Amount Offers</h4>
						@elseif($request_data['type'] == 'Percentage')
							<h4>Percentage Discount Offers</h4>
						@else
							<h4>Make & Share Offers</h4>
						@endif
						<form class="card-header-form">
							@csrf
							<div class="d-flex">
								<input type="text" name="search" class="form-control" placeholder="Search Title..." value="{{ $search }}" >
								<input type="hidden" name="type" value="{{ $request_data['type'] }}" />
								<button class="btn btn-primary btn-icon" type="submit"><i class="fas fa-search"></i></button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="col-12 mb-4">
				<div class="row">
					<div class="col-md-8">
						<p>
							{{ __('Note') }}: <b class="text-danger">
								@if($request_data['type'] == 'MadeShare')
									{{ __('You can only able share to your own WhatsApp number.') }}
								@else
									{{ __('Remember to mark at least one offer as default offer.') }}
								@endif
							</b>	
						</p>
					</div>
					<div class="col-md-4 text-right">
						<div class="btn-group" role="group" aria-label="Basic example">
							<button type="button" class="btn @if($bussiness_detail->list_type == 'list') btn-primary @else btn-light @endif" title="List View" data-toggle="tooltip" id="switch-list-style"><i class="fa fa-list"></i></button>
							<button type="button" class="btn @if($bussiness_detail->list_type == 'grid') btn-primary @else btn-light @endif" title="Grid View" data-toggle="tooltip" id="switch-grid-style"><i class="fa fa-th-large"></i></button>
						</div>
					</div>
				</div>
			</div>

			{{-- LIST  --}}
			<div class="col-sm-12" id="list-style" style="@if($bussiness_detail->list_type == 'grid') display:none @endif">
				<div class="card">
					<div class="card-body p-3">
						<div class="table-responsive min-height">
							@if(count($records) >= 1)
							<table class="table table-striped table-md table-hover mb-0">
								<tbody id="offerTable">
									<tr>
										@if($request_data['type'] != 'MadeShare')
											<th style="width: 80px;">Set Default</th>
										@endif
										
										<th class="text-left" width="160">Title</th>
										<th class="text-left">Total Users</th>
										<th class="text-left">Total Visits</th>
										@if($request_data['type'] != 'MadeShare')
											<th class="text-left">End Date</th>
										@endif
										<th class="text-left">Actions</th>
									</tr>
									
									
									@foreach($records as $record)
										<tr>

											@if($request_data['type'] != 'MadeShare')
												<td>
													<div class="custom-control custom-checkbox">
														<input type="checkbox" name="ids[]" class="custom-control-input setDefaultCheckbox checkbox_{{$record->id}}" id="{{ $record->id }}" value="{{ $record->id }}" @if($record->is_default == 1) checked @endif>
														<label class="custom-control-label" for="{{ $record->id }}"></label>
													</div>
												</td>
											@endif

											
											<td>
												<a href="{{ route('business.future.show', $record->id.'?type='.$request_data['type']) }}">{{ $record->title }}</a>
											</td>
											<td class="text-left">
												<span class="badge badge-warning">{{ $record->users_count }}</span>
											</td>
											<td>
												<span class="badge badge-warning">{{ $record->total_visits }}</span>
											</td>
											@if($request_data['type'] != 'MadeShare')
												<td>
												<span class="badge badge-danger">
													@if(\Carbon\Carbon::today() <= $record->end_date )
														<span class="end-date" id="endDate{{ $record->id }}"></span>
														<script type="text/javascript">
															var enddate = "{{ \Carbon\Carbon::parse($record->end_date)->format('Y/m/d') }}";

															var today = new Date();
															var dd = String(today.getDate()).padStart(2, '0');
															var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
															var yyyy = today.getFullYear();

															today = yyyy + '/' + mm + '/' + dd;
															
															if(today < enddate) {
																$("#endDate{{ $record->id }}").countdown(enddate, function(event) {$(this).text(event.strftime('%D d : %H h : %M m : %S s'));});
															}else if(today == enddate){
																$("#endDate{{ $record->id }}").replaceWith( '<span class="end-date" id="endDate{{ $record->id }}">Offer Will End Today</span>' );
															}else if(today > enddate){
																$("#endDate{{ $record->id }}").replaceWith( '<span class="end-date" id="endDate{{ $record->id }}">Offer Ends</span>' );
															}
														</script>
													@else
														<span class="end-date" id="endDate{{ $record->id }}">Offer Ends</span>
													@endif
												</span>
											</td>
											@endif
											
											<td>
												@if($request_data['type'] != 'MadeShare')
													<button class="btn btn-icon icon-left btn-success action_btn" onclick="redeemOffer({{$record->id}})" data-toggle="tooltip" title="Redeem Code"><i class="fa fa-gift"></i></button>
												@endif
												

												{{-- <button class="btn btn-icon icon-left btn-primary action_btn" onclick="addSubscription({{$record->id}})"  data-toggle="tooltip" title="Subscribe Customer" @if($current_date > $record->end_date) disabled @endif><i class="fa fa-share"></i></button> --}}

												@if($request_data['type'] != 'MadeShare')
													<button class="btn btn-icon icon-left btn-primary action_btn" onclick="addSubscription({{$record->id}})"  data-toggle="tooltip" title="Subscribe Customer" @if($current_date > $record->end_date) disabled @endif><i class="fa fa-share"></i></button>
												@else
													<button class="btn btn-icon icon-left btn-primary action_btn" onclick="sendMessage({{$record->id}})"  data-toggle="tooltip" title="Send Message" @if($current_date > $record->end_date) disabled @endif><i class="fa fa-share"></i></button>
												@endif

												<div class="dropdown d-inline mr-2">
													<button class="btn btn-primary dropdown-toggle action_btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Actions
													</button>
													<div class="dropdown-menu">
														<a class="dropdown-item" href="{{ route('business.future.show', $record->id.'?type='.$request_data['type']) }}"><b>View Offer</b></a>

														@if($record->future_offer->promotion_url != '')
														<a class="dropdown-item" href="{{ route('business.editWebpageOfferDetails', $record->id.'?type='.$request_data['type']) }}"><b>Edit Offer</b></a>
														@else
														<a class="dropdown-item" href="{{ url('/business/offers/future/'.$record->id.'/edit?type='.$request_data['type']) }}"><b>Edit Offer</b></a>
														@endif
														
														<a class="dropdown-item duplicate-offer" id="{{$record->id}}" href="#"><b>Duplicate</b></a>

														<a class="dropdown-item delete-offer" id="{{$record->id}}" href="#"><b>Delete Offer</b></a>
														
														<!-- <div class="dropdown-divider"></div>
	                        							<p class="dropdown-item setDefault" id="{{$record->id}}"><b>Set as Default</b></p> -->
													</div>
												</div>
											</td>
											
										</tr>
									@endforeach
									
								</tbody>
							</table>
							{{ $records->links('vendor.pagination.bootstrap-4') }}
							@else
							<h3 style="padding:50px;text-align:center;clear: both;">{{ Config::get('constants.no_record_found') }}</h3>
							@endif
						</div>
					</div>
				</div>
			</div>

			{{-- GRID  --}}
			<div class="col-sm-12" id="grid-style" style="@if($bussiness_detail->list_type == 'list') display:none @endif">
				{{-- <h2 class="section-title">List of Offers</h2> --}}
				@if(count($records) >= 1)
				<div class="row">
					
					@foreach ($records as $record)	

					@php

						if(file_exists(base_path('public/assets/business/Website-offer-thumb-'.$record->user_id.'.jpg'))){
							$file = base_path('public/assets/business/Website-offer-thumb-'.$record->user_id.'.jpg');
						}else{
							$file = '';
						}

					@endphp


					<div class="col-12 col-sm-6 col-lg-4">
					  <article class="article article-style-c" id="grid_{{$record->id}}">
						<div class="article-header">
							@if($record->offer_template != null)
									<div class="article-image" data-background="{{asset('assets/offer-thumbnails/'.$record->offer_template->thumbnail)}}"></div>
							@elseif($file != '')
									<div class="article-image" data-background="{{asset('system/public/assets/business/Website-offer-thumb-'.$record->user_id.'.jpg')}}"></div>
							@else
									<div class="article-image" data-background="{{asset('assets/img/news/img11.jpg')}}"></div>
							@endif
							
							
							@if($record->is_default == 1) <div class="default-tag">Default</div> @endif

						</div>
						<div class="article-details">

							<div class="article-title">
								<h2><a href="{{ route('business.future.show', $record->id.'?type='.$request_data['type']) }}">{{ $record->title }}</a></h2>
							</div>

							<div class="mt-3">
								{{-- <hr> --}}
								<div class="d-flex w-100">
									<div class="w-50">
										<div class="">
											<p class="mb-0">Total Users: <span class="badge badge-warning text-center">{{ $record->users_count }}</span></p>
										</div>
									</div>
									<div class="w-50">
										<div class="">
											<p class="mb-0">Total Visits: <span class="badge badge-warning text-center">{{ $record->total_visits }}</span></p>
										</div>
									</div>
								</div>
								<hr>
							</div>

							@if($request_data['type'] != 'MadeShare')
								<div class="article-category mb-3">
									<span class="badge badge-danger">
										@if(\Carbon\Carbon::today() <= $record->end_date )
											<span class="end-date" id="endGridDate{{ $record->id }}"></span>
											<script type="text/javascript">
												var enddate = "{{ \Carbon\Carbon::parse($record->end_date)->format('Y/m/d') }}";

												var today = new Date();
												var dd = String(today.getDate()).padStart(2, '0');
												var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
												var yyyy = today.getFullYear();

												today = yyyy + '/' + mm + '/' + dd;
												
												if(today < enddate) {
													$("#endGridDate{{ $record->id }}").countdown(enddate, function(event) {$(this).text(event.strftime('%D d : %H h : %M m : %S s'));});
												}else if(today == enddate){
													$("#endGridDate{{ $record->id }}").replaceWith( '<span class="end-date" id="endGridDate{{ $record->id }}">Offer Will End Today</span>' );
												}else if(today > enddate){
													$("#endGridDate{{ $record->id }}").replaceWith( '<span class="end-date" id="endGridDate{{ $record->id }}">Offer Ends</span>' );
												}
											</script>
										@else
											<span class="end-date" id="endGridDate{{ $record->id }}">Offer Ends</span>
										@endif
									</span>
								</div>
							@endif
							

							<div>
								<div class="">

									@if($request_data['type'] != 'MadeShare')
										<button class="btn btn-sm px-2 btn-icon btn-outline-warning my-1 mr-2" onclick="redeemOffer({{$record->id}})">Redeem</button>
									@endif

									@if($request_data['type'] != 'MadeShare')
										<button class="btn btn-sm px-2 btn-icon btn-outline-success my-1 mr-2" onclick="addSubscription({{$record->id}})" @if($current_date > $record->end_date) disabled @endif>Subscribe</button>
									@else
										<button class="btn btn-sm px-2 btn-icon btn-outline-success my-1 mr-2" onclick="sendMessage({{$record->id}})" @if($current_date > $record->end_date) disabled @endif>Send Message</button>
									@endif

									<div class="dropdown d-inline-block my-1 mr-2">
										<button class="btn btn-outline-primary btn-sm px-2 dropdown-toggle" type="button" id="actionBtn" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
											Action
										</button>
										<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 29px, 0px);">
											<a class="dropdown-item has-icon" href="{{ route('business.future.show', $record->id.'?type='.$request_data['type']) }}"><i class="far fa-eye"></i> View Offer</a>
											@if($record->future_offer->promotion_url != '')
											<a class="dropdown-item has-icon" href="{{ route('business.editWebpageOfferDetails', $record->id.'?type='.$request_data['type']) }}"><i class="far fa-edit"></i> Edit Offer</a>
											@else
											<a class="dropdown-item has-icon" href="{{ url('/business/offers/future/'.$record->id.'/edit?type='.$request_data['type']) }}"><i class="far fa-edit"></i> Edit Offer</a>
											@endif
											
											<a class="dropdown-item has-icon duplicate-offer" id="{{$record->id}}"  href="#"><i class="far fa-copy"></i> Duplicate</a>

											<a class="dropdown-item has-icon delete-offer" id="{{$record->id}}"  href="#"><i class="far fa-copy"></i> Delete Offer</a>
											
											@if($record->is_default == 0)
												@if($request_data['type'] != 'MadeShare')
													<a class="dropdown-item has-icon setDefaultCheckbox checkbox_gr_{{$record->id}}" href="#" id="{{ $record->id }}"><i class="fa fa-tag"></i> Mark as Default</a>
												@endif
											
											@endif
										</div>
									</div>

								</div>
							</div>

						</div>
					  </article>
					</div>

					@endforeach
				</div>
				{{ $records->links('vendor.pagination.bootstrap-4') }}	
				@else
				<div class="card">
					<div class="card-body p-3">  
							<h3 style="padding:50px;text-align:center;clear: both;">{{ Config::get('constants.no_record_found') }}</h3>
					</div>
				</div>
		    	@endif
			</div>

		</div>
		
	</section>
@endsection
@section('end_body')
<script>
	$(document).ready(function(){
			$("#switch-list-style").on("click", function(e){
					e.preventDefault();
					$('#list-style').show();
					$('#grid-style').hide();

					$(this).removeClass( "btn-light" );
					$(this).addClass( "btn-primary" );
					$('#switch-grid-style').removeClass( "btn-primary" );
					$('#switch-grid-style').addClass( "btn-light" );

					updateListStyle('list');
			});

			$("#switch-grid-style").on("click", function(e){
					e.preventDefault();
					$('#grid-style').show();
					$('#list-style').hide();

					$(this).removeClass( "btn-light" );
					$(this).addClass( "btn-primary" );
					$('#switch-list-style').removeClass( "btn-primary" );
					$('#switch-list-style').addClass( "btn-light" );

					updateListStyle('grid');
			});

			function updateListStyle(type){

					var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

          $.ajax({
              type: 'POST',
              url: "{{url('/business/update-list-style')}}",
              data: {data: type, _token: CSRF_TOKEN},
              dataType: 'JSON',
              success: function (results) {
              	$("#overlay").fadeOut(300);
                  console.log('Updated list style.');
              },
              error: function(xhr) { 
              	$("#overlay").fadeOut(300);
                  console.log('Failed to Update list style.');
              },
          });
			}

	});


	//duplicate

	$(document).on('click', '.duplicate-offer', function(e){
        e.preventDefault();

        var id = $(this).attr('id');
        duplicateOffer(id);
  });
		

	function duplicateOffer(id){
			Swal.fire({
			  title: 'Do you want to duplicate the Offer?',
			  showCancelButton: true,
			  confirmButtonText: 'Duplicate',
			}).then((result) => {
			  if (result.value == true) {
			    window.location.href = '{{ url('business/offer/duplicate') }}/'+id;
			  } 
			});
	}


	//delete
	$(document).on('click', '.delete-offer', function(e){
      e.preventDefault();
      var id = $(this).attr('id');

      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

      $.ajax({
          type: 'POST',
          url: "{{url('/business/offer/subscriptions')}}/" + id,
          data: {id: id, _token: CSRF_TOKEN},
          dataType: 'JSON',
          success: function (results) {
              $("#overlay").fadeOut(300);
              
              if(results.offer_subscriptions > 0){
				          Swal.fire({
				            title: 'Can\'t Delete',
				            html: '<p>Offer is Subscribed to <b class="subscription_count">'+results.offer_subscriptions+'</b> customer(s)!</p>',
				            icon: 'warning',
				            showCancelButton: false,
				          }).then((result) => {
				          })
				      }else{
				          deleteOffer(id);
				      }
          },
          error: function(xhr) { 
              $("#overlay").fadeOut(300);
              
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!'
              })
          },
      });
  });

	function deleteOffer(id){
			Swal.fire({
			  title: 'Do you want to delete the Offer?',
			  showCancelButton: true,
			  confirmButtonText: 'Delete',
			}).then((result) => {
					var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

					if(result.value == true){
				      $.ajax({
			          type: 'POST',
			          url: "{{url('/business/offer/delete')}}/" + id,
			          data: {id: id, _token: CSRF_TOKEN},
			          dataType: 'JSON',
			          success: function (results) {
			              $("#overlay").fadeOut(300);
			              Swal.fire({
			                icon: 'success',
			                title: 'Done',
			                text: results.message
			              });
			              location.reload();
			          },
			          error: function(xhr) { 
			              $("#overlay").fadeOut(300);
			              
			              Swal.fire({
			                icon: 'error',
			                title: 'Oops...',
			                text: 'Something went wrong!'
			              })
			          },
			      });
					}

			});
	}
</script>

<script>
var shareRewards = '{{$planData["share_rewards"]}}';
var type = '{{$request_data['type']}}';

var purchaseHistory = '{{$purchaseHistory}}';
if(purchaseHistory>0){
	var shareRewardValidationMsg = 'Your Share Challenge Plan Has Expired';
}else{
	var shareRewardValidationMsg = 'Please Purchase Share Challenge Plan';
}

function showValidationPop(validation,message){
	  
	  Swal.fire({
		  title: '<strong>'+message+'</strong>',
		  icon: 'info',
		  html:
			'Please Subscribe to our plans.',
		  showCloseButton: true,
		  showCancelButton: false,
		  focusConfirm: false,
		  confirmButtonText: 'Please Upgrade',
	 }).then(function(data) { console.log(data);
			if(data.dismiss=='close' || data.dismiss=='backdrop'){
			}else{
				window.location = '{{ route('business.plan') }}';
			}
	 });
}

    function createOffer() {
		
		if(shareRewards==0 && type != 'MadeShare'){
			showValidationPop('shareRewards',shareRewardValidationMsg);
			return false;
		}

		var offer_type = '{{ $request_data['type'] }}';
		var ENDPOINT = "{{ url('/') }}";

        Swal.fire({
            title: 'Select the Page Type!',
            html: `<div class="row">
                        <div class="col-sm-6">
                            <div class="radio_tab border-primary">
                                <label for="template">
                                    <div class="card popup-card">
                                        <div class="card-header">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="template" data-inputname="without_website" name="page_type" value="template" class="custom-control-input page_type_input" checked>
                                                <label class="custom-control-label" for="template"></label>
                                            </div>
                                            <h4>Use Template</h4>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0">Use and customise our pre-designed offer templates to promote your offers, products, services, etc. easily within a few clicks.</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="radio_tab">
                                <label for="ex_page">
                                    <div class="card popup-card">
                                        <div class="card-header">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="ex_page" data-inputname="with_website" name="page_type" value="webpage" class="custom-control-input page_type_input">
                                                <label class="custom-control-label" for="ex_page"></label>
                                            </div>
                                            <h4>My Website Page</h4>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0">Promote your website page just by providing the page URL and inserting the script provided by us on your website.</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <input type="hidden" id="page_type_input" value="template" />
                    </div>`,
            confirmButtonText: 'Continue',
            focusConfirm: true,
            showCancelButton: false,
            showCloseButton: true,
            allowOutsideClick: false,
            reverseButtons: !0,
            width: 650,
						customClass: 'swal2-page-type',
            preConfirm: () => {
                var type = Swal.getPopup().querySelector('#page_type_input').value;
                
                if (type == '') {
                    Swal.showValidationMessage(`Please select the Page Type!`);
                }

                return { type: type }
            }
        }).then(function (e) {
            //console.log(e.value.type);
            if(e.value.type == 'template'){
                window.location.href = ENDPOINT + "/business/offer/future/template?type=" + offer_type;
            }else{
                window.location.href = ENDPOINT + "/business/offer/future/webpage?type=" + offer_type;
            }
        }, function (dismiss) {
            return false;
        })
    }


    /* Add Subcription */
    function addSubscription(offerID) {

        var html = '<div class="subscribe-form"><h6>Enter Customer\'s Whatsapp number <span class="mark-required">*</span></h6><input  type="text" id="redeemOffer'+offerID+'" class="swal2-input customer-num" placeholder="Enter number.">';

        if('{{ $businessSettings['ask_for_name'] }}' == 'Yes'){
            html = html+'<h6>Enter Customer\'s Name @if($businessSettings['name_required'] == 'Yes')<span class="mark-required">*</span>@endif</h6><input  type="text" id="customerName'+offerID+'" class="swal2-input customer-name" placeholder="Enter name.">';
        }

        if('{{ $businessSettings['ask_for_dob'] }}' == 'Yes'){
            html = html+'<h6>Select Customer\'s Date Of Birth @if($businessSettings['dob_required'] == 'Yes')<span class="mark-required">*</span>@endif</h6><input  type="date" id="customerDOB'+offerID+'" class="swal2-input customer-dob">';
        }

        if('{{ $businessSettings['ask_for_anniversary_date'] }}' == 'Yes'){
            html = html+'<h6>Select Customer\'s Anniversary Date @if($businessSettings['anniversary_date_required'] == 'Yes')<span class="mark-required">*</span>@endif</h6><input  type="date" id="customerADate'+offerID+'" class="swal2-input customer-anniversary">';
        }

       html = html+'</div>';

       /*Disable Future Date*/
       $(function(){
            var dtToday = new Date();
            
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();
            
            var maxDate = year + '-' + month + '-' + day;
            $('input[type="date"]').attr('max', maxDate);
        });

       	/*Show Pop Up*/
        swal.fire({
            title: 'Enter Customer Details!',
            html: html,
            confirmButtonText: 'Subscribe',
            focusConfirm: false,
            showCancelButton: !0,
            cancelButtonText: "Close",
            allowOutsideClick: false,
            reverseButtons: !0,
            width: 400,
            preConfirm: () => {
                var number = Swal.getPopup().querySelector('#redeemOffer'+offerID).value;

                if (isNaN(number) || number == 0 || number == -1 || number == -0) {
                    Swal.showValidationMessage(`Please enter valid mobile number!`)
                }

                if (number.length != 10) {
                    Swal.showValidationMessage(`Mobile number should be 10 digits!`)
                }


                /*Other info*/
                var customerName = '';
                if(Swal.getPopup().querySelector('#customerName'+offerID) == null){
                		customerName = '';
                }else{
                		customerName = Swal.getPopup().querySelector('#customerName'+offerID).value;
                }

                var customerDOB = '';
                if(Swal.getPopup().querySelector('#customerDOB'+offerID) == null){
                		customerDOB = '';
                }else{
                		customerDOB = Swal.getPopup().querySelector('#customerDOB'+offerID).value;
                }

                var customerADate = '';
                if(Swal.getPopup().querySelector('#customerADate'+offerID) == null){
                		customerADate = '';
                }else{
                		customerADate = Swal.getPopup().querySelector('#customerADate'+offerID).value;
                }

                //validation
                if('{{ $businessSettings['name_required'] }}' == 'Yes' && customerName == '' && number != ''){
				            Swal.showValidationMessage(`Customer name can't be blank!`)
				        }

				        if('{{ $businessSettings['dob_required'] }}' == 'Yes' && customerDOB == '' && number != ''){
				            Swal.showValidationMessage(`Date of birth can't be blank!`)
				        }

				        if('{{ $businessSettings['anniversary_date_required'] }}' == 'Yes' && customerADate == '' && number != ''){
				            Swal.showValidationMessage(`Anniversary date can't be blank!`)
				        }

                return { number: number, customerName: customerName, customerDOB: customerDOB, customerADate: customerADate }
            }
        }).then(function (e) {
            
            if (e.value && e.value.number) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: 'POST',
                    url: "{{url('/business/share-to-customer')}}/" + offerID,
                    data: {number: e.value.number, customerName: e.value.customerName, customerDOB: e.value.customerDOB, customerADate: e.value.customerADate, _token: CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function (results) {
                        $("#overlay").fadeOut(300);
                        
                        if (results.success === true) {
                            swal.fire("Done!", results.message, "success");
                            
                            setTimeout(function(){
                                location.reload();
                            },2000);
                        } else {
                            swal.fire("Error!", results.message, "error");
                        }
                    },
                    error: function(xhr) { 
                        $("#overlay").fadeOut(300);
                        
                        Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Something went wrong!'
                        })
                    },
                });

            }
        }, function (dismiss) {
            return false;
        })
    }

    /* Send message to own */
    function sendMessage(offerID) {

        var html = '<div class="subscribe-form"><h6>This message is sent to your own WhatsApp number!</h6><input type="hidden" id="redeemOffer'+offerID+'" class="swal2-input" placeholder="{{ $wa_number }}" value="{{ $wa_number }}">';

       html = html+'</div>';

        swal.fire({
            title: 'Send message to own!',
            html: html,
            confirmButtonText: 'Send',
            focusConfirm: false,
            showCancelButton: !0,
            cancelButtonText: "No",
            allowOutsideClick: false,
            reverseButtons: !0,
            width: 400,
            preConfirm: () => {
                var number = Swal.getPopup().querySelector('#redeemOffer'+offerID).value;

                if (isNaN(number) || number == 0 || number == -1 || number == -0) {
                    Swal.showValidationMessage(`Please enter valid mobile number!`)
                }

                if (number.length != 10) {
                    Swal.showValidationMessage(`Mobile number should be 10 digits!`)
                }

                /*Other info*/
                var customerName = '';
                var customerDOB = '';
                var customerADate = '';

                return { number: number, customerName: customerName, customerDOB: customerDOB, customerADate: customerADate }
            }
        }).then(function (e) {
            
            if (e.value && e.value.number) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: 'POST',
                    url: "{{url('/business/share-to-customer')}}/" + offerID,
                    data: {number: e.value.number, customerName: e.value.customerName, customerDOB: e.value.customerDOB, customerADate: e.value.customerADate, _token: CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function (results) {
                        $("#overlay").fadeOut(300);
                        console.log(results);
                        if (results.success === true) {
                            swal.fire("Done!", results.message, "success");
                            
                            setTimeout(function(){
                                location.reload();
                            },2000);
                        } else {
                            swal.fire("Error!", results.message, "error");
                        }
                    },
                    error: function(xhr) { 
                        $("#overlay").fadeOut(300);
                        
                        Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Something went wrong!'
                        })
                    },
                });

            }
        }, function (dismiss) {
            return false;
        })
    }
</script>
<script type="text/javascript">

			/* Redeem */
    function redeemOffer(offerID) {

        // 
            Swal.fire({
                title: 'Enter A Coupon Code!',
                html: `<input type="text" id="couponCode`+offerID+`" class="swal2-input" placeholder="Type Coupon Code To Redeem Code!">`,
                confirmButtonText: 'Verify Coupon',
                focusConfirm: false,
                showCancelButton: !0,
                cancelButtonText: "Close",
                allowOutsideClick: false,
                reverseButtons: !0,
                customClass: {
                  container: 'container-redeem-invoice',
                },
                preConfirm: () => {
                    var code = Swal.getPopup().querySelector('#couponCode'+offerID).value
                    
                    if (!code) {
                        Swal.showValidationMessage(`Please enter code!`)
                    }

                    return { code: code }
                }
            }).then(function (e) {
                
                if (e.value && e.value.code) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        type: 'POST',
                        url: "{{url('/business/redeem-offer')}}/" + offerID,
                        data: {code: e.value.code, _token: CSRF_TOKEN},
                        dataType: 'JSON',
                        success: function (results) {
                            $("#overlay").fadeOut(300);
                            if (results.success === true) {
                                proceedWithInvoiceRedeem(results);
                                Swal.disableButtons();
                            } else {
                                Swal.fire({
                                  icon: 'error',
                                  title: results.message,
                                  text: 'Please enter a valid coupon'
                                })
                            }
                        },
                        error: function(xhr) { 
                            $("#overlay").fadeOut(300);
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Something went wrong!'
                            })
                        },
                    });

                }
            }, function (dismiss) {
                return false;
            })
        // }

    }

        /* proceed With Invoice Redeem */
        function proceedWithInvoiceRedeem(results){
            /*console.log(results);*/

            var html =   $('<div id="inputBox">')
                            .append(createAmountInput(results.data.redeem_id, function() {}));

            if('{{ $businessSettings['ask_for_invoice'] }}' == 'Yes'){
		            html = html.append(createInvoiceInput(results.data.redeem_id, function() {}));
		        }

          	html = html.append(createDiscountType(results.data.offer.future_offer.discount_type, function() {}))
                        .append(createTargetAchieved(results.data.targets, function() {}))
                        .append(createDiscountValue(results.data.offer.future_offer.discount_value, function() {}))
                        .append(resetWithInvoiceButton(results.data.redeem_id, function() {}))
                        .append(createWithInvoiceButton(results.data.redeem_id, function() {}))
                        .append(createHiddenInput('', function() {}))
                        .append(createInputBox('totalBox', function() {}));
            

            swal.fire({
                title: 'Enter Redeem Details!',
                html: html,
                confirmButtonText: 'Redeem',
                focusConfirm: false,
                showCloseButton: true,
                allowOutsideClick: false,
                reverseButtons: !0,
                footer: '<table class="table table-bordered"><thead><tr><th scope="col text-center" colspan="4">Offer Details</th></tr></thead><tbody><tr><th scope="row">Title</th><td>'+results.data.offer.title+'</td></tr></tbody></table>',
                customClass: {
                    container: 'container-redeem-invoice',
                },
                width: 500,
                preConfirm: () => {
                    var actualAmount = Swal.getPopup().querySelector('#actualAmount'+results.data.redeem_id).value;

                    if(Swal.getPopup().querySelector('#invoice'+results.data.redeem_id) == null){
                    		var invoice = '';
                    }else{
                    		var invoice = Swal.getPopup().querySelector('#invoice'+results.data.redeem_id).value;
                    }
                    
                    var redeem_amount = Swal.getPopup().querySelector('#redeem_amount').value;
                    var targets = Swal.getPopup().querySelector('#targets').value;

                    if (!actualAmount) {
                        Swal.showValidationMessage(`Please enter amount!`)
                    }

                    if (isNaN(actualAmount)) {
                        Swal.showValidationMessage(`Please enter valid amount!`)
                    }

                    if('{{ $businessSettings['invoice_required'] }}' == 'Yes' && invoice == '' && actualAmount != ''){
						            Swal.showValidationMessage(`Please enter valid Invoice Number!`)
						        }

                    if(redeem_amount == ''){
                        Swal.showValidationMessage(`Please calculate total!`)
                    }

                    var calculated_amount = redeem_amount;
                    var final_amount = redeem_amount;
                    if (Math.sign(redeem_amount) == -1) {
                        final_amount = 0;
                    }

                    var final_discount = results.data.offer.future_offer.discount_value;
                    if(results.data.offer.future_offer.discount_type == 'Perclick'){
                        final_discount = (results.data.offer.future_offer.discount_value * targets);
                    }

                    return { offer_id:results.data.offer.id, actualAmount: actualAmount, invoice: invoice, discount_type: results.data.offer.future_offer.discount_type, discount_value: final_discount, redeem_amount  : final_amount, calculated_amount:calculated_amount, targets : targets }
                }
            }).then(function (e) {
                console.log(e.value);
                if (e.value && e.value.actualAmount) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        type: 'POST',
                        url: "{{url('/business/proceed-redeem')}}/" + results.data.redeem_id,
                        data: {data: e.value, _token: CSRF_TOKEN},
                        dataType: 'JSON',
                        success: function (results) {
                            $("#overlay").fadeOut(300);
                            if (results.success === true) {
                                swal.fire("Done!", results.message, "success");
                                
                                setTimeout(function(){
                                    location.reload();
                                },2000);
                            } else {
                                swal.fire("Error!", results.message, "error");
                            }
                        },
                        error: function(xhr) { 
                            $("#overlay").fadeOut(300);
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Something went wrong!'
                            })
                        },
                    });

                }
            }, function (dismiss) {
                return false;
            })
        }

        function createWithInvoiceButton(redeem_id) {
            return $('<button onclick="calculateWithInvoice('+redeem_id+')" class="calculate-total">Calculate</button>');
        }

        function resetWithInvoiceButton(redeem_id) {
            return $('<button onclick="resetWithInvoiceInputs('+redeem_id+')" class="swal2-cancel swal2-styled reset-btn">Reset</button>');
        }

        function createInputBox(id) {
            return $('<div id="'+id+'"></div>');
        }

        function resetWithInvoiceInputs(redeem_id){
            Swal.getPopup().querySelector('#actualAmount'+redeem_id).value= '';
            if(Swal.getPopup().querySelector('#invoice'+redeem_id) != null){
            		Swal.getPopup().querySelector('#invoice'+redeem_id).value = '';
            }
            
            Swal.getPopup().querySelector('#targets').value = '';
            $( "#totalBox" ).replaceWith( '<div id="totalBox" class="total-amount"></div>' );
            Swal.disableButtons();
        }

        function calculateWithInvoice(redeem_id){

            var actualAmount = Swal.getPopup().querySelector('#actualAmount'+redeem_id).value;
            if(Swal.getPopup().querySelector('#invoice'+redeem_id) == null){
            		var invoice = '';
            }else{
            		var invoice = Swal.getPopup().querySelector('#invoice'+redeem_id).value;
            }
            
            var discountType = Swal.getPopup().querySelector('#discountType').value;
            var discountValue = Swal.getPopup().querySelector('#discountValue').value;
            var targets = Swal.getPopup().querySelector('#targets').value;

            var amount = Math.sign(actualAmount); 
            if (!isNaN(amount) && amount != 0 && amount != -1 && amount != -0) {

	            	if('{{ $businessSettings['invoice_required'] }}' == 'Yes' && invoice == ''){
				            Swal.showValidationMessage(`Please enter valid Invoice Number!`);
				            return false;
				        }else{
				        		Swal.resetValidationMessage();
				        }
                
                
                var amount = 0;
                var discount_amount = 0;
                var type = '%';

                if(discountType == 'Perclick'){
                    amount = actualAmount - (discountValue * targets);
                    type = '₹ Per Click';
                }else if(discountType == 'Percentage'){
                    amount = actualAmount - (actualAmount / 100) * discountValue;
                    amount = amount.toFixed(2);
                    type = '%';

                }else{
                    amount = actualAmount - discountValue;
                    type = '₹';
                }

                discount_amount = actualAmount - amount;
                discount_amount = discount_amount.toFixed(2);

                if (Math.sign(amount) == -1) {
                    amount = 0;
                }

                Swal.enableButtons();

                $("#redeem_amount").val(amount);

                $( "#totalBox" ).replaceWith( '<div id="totalBox" class="total-amount"><div class="px-4 py-2"><span class="theme-color">Payment Summary</span><div class="mb-3"><hr class="dashed"></div><div class="d-flex justify-content-between"><span class="font-weight-bold">Amount</span> <span class="text-muted">'+actualAmount+' ₹</span></div><div class="d-flex justify-content-between"> <small>Discount ( '+discountValue+' '+type+' )</small> <small>-'+discount_amount+' ₹</small> </div><div class="d-flex justify-content-between mt-3"> <span class="font-weight-bold">Total</span><span class="font-weight-bold theme-color">'+amount+' ₹</span></div></div></div>' );
                
            }else{
                Swal.showValidationMessage(`Please enter valid amount!`)
            }
        }

        function createAmountInput(id) {
            return $(`<input type="text" id="actualAmount`+id+`" class="swal2-input amount-input" placeholder="Enter amount before discount">`);
        }

        function createHiddenInput(amount) {
            return $(`<input type="hidden" id="redeem_amount" value="`+amount+`" >`);
        }

        function createInvoiceInput(id) {
            return $(`<input type="text" id="invoice`+id+`" class="swal2-input invoice-input" placeholder="Enter invoice number">`);
        }

        function createDiscountType(type) {
            return $(`<input type="hidden" id="discountType" value="`+type+`">`);
        }

        function createTargetAchieved(targets) {
            return $(`<input type="hidden" id="targets" value="`+targets+`">`);
        }

        function createDiscountValue(val) {
            return $(`<input type="hidden" id="discountValue" value="`+val+`">`);
        }


        /* disable redeem */
        $(document).ready(function(){
            $( "body" ).delegate( ".amount-input", "keyup", function() {
                Swal.disableButtons();
                $( "#totalBox" ).replaceWith( '<div id="totalBox" class="total-amount"></div>' );
            });

            $( "body" ).delegate( ".invoice-input", "keyup", function() {
            		if('{{ $businessSettings['invoice_required'] }}' == 'Yes'){
				            Swal.disableButtons();
                		$( "#totalBox" ).replaceWith( '<div id="totalBox" class="total-amount"></div>' );
				        }
                
            });

        });
</script>

@include('business.offers.future.js')
@endsection