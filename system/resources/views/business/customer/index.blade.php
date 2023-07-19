@extends('layouts.business')
@section('title', 'Groups: Business Panel')
@section('end_head')
	<style>
		.dropdown-item{cursor:pointer;}

		.dataTables_wrapper .row{
			justify-content: space-between;
			align-items: center;
		}
		.dataTables_wrapper .row:not(:first-child){
			margin-top: 1rem;
		}
		.dataTables_wrapper .row:first-child{
        padding: 0px 16px;
        }
        .dataTables_wrapper .row:last-child{
            margin-bottom: 1rem;
            padding: 0px 16px;
        }
		.dataTables_wrapper .dataTables_filter{
			text-align: right
		}
		.dataTables_wrapper .dataTables_length > label,
		.dataTables_wrapper .dataTables_filter > label{
			width: 100%;
		}
		.dataTables_wrapper .dataTables_length > label > select{
			max-width: 65px;
			height: calc(1.5em + 0.5rem + 2px)!important;
			padding: 0.25rem 0.5rem!important;
		}
		.dataTables_wrapper .dataTables_filter > label > input{
			display: inline;
			width: auto;
			margin-left: 5px;
		}
		.dataTables_wrapper .dataTables_paginate > .pagination{
			justify-content: end;
			margin-bottom: 0px;
		}
	
	</style>
@endsection
@section('head')
@include('layouts.partials.headersection',['title'=> $group->name.''])
@endsection
@section('content')
<section>
	<div class="section">

		<div class="mb-4">
			<div class="row justify-content-between">
				<div class="col-6"></div>
			</div>
		</div>

		<div class="card">
			<div class="card-header px-3">
				<h4>List of contacts</h4>
			</div>
			<div class="card-body p-0">
				<div class="table-responsive custom-table">
					@if($planData['userData']->current_account_status == 'paid')
					@if($userBalance['wallet_balance'] > 0)
						<table class="table" id="view_groups_data_table">
							<thead>
								<tr>
									<th style="width: 100px;">{{ __('Sr. No.') }}</th>
									<th class="am-title">{{ __('WhatsApp Mobile') }}</th>
									<th class="am-title">{{ __('Name') }}</th>
									<th class="am-title">{{ __('Date of birth') }}</th>
									<th class="am-title">{{ __('Anniversary Date') }}</th>
									<th class="am-title">{{ __('Total Subscription') }}</th>
									<th class="am-date">{{ __('Action') }}</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					@else
						<style>
						    .card.recharge{
						        border: 2px dashed rgba(225, 125, 25, 0.3);
						        background: rgba(225, 125, 25, 0.05);
						    }
						</style>
						<table class="table">
							<thead>
								<tr>
									<th style="width: 100px;">{{ __('Sr. No.') }}</th>
									<th class="am-title">{{ __('WhatsApp Mobile') }}</th>
									<th class="am-title">{{ __('Name') }}</th>
									<th class="am-title">{{ __('Date of birth') }}</th>
									<th class="am-title">{{ __('Anniversary Date') }}</th>
									<th class="am-title">{{ __('Total Subscription') }}</th>
									<th class="am-date">{{ __('Action') }}</th>
								</tr>
							</thead>
						</table>
						<div class="card recharge mb-0 shadow-none  @if($planData['userData']->current_account_status == 'free') __pro__ @endif">
						    <div class="card-body">
						        <div class="d-sm-flex justify-content-between align-items-center">
						            <div class="pr-sm-3">
						                <h6 class="text-warning mb-1">Account balance is low. (&#8377;{{$userBalance['wallet_balance']}})</h6>
						                <p class="mb-sm-0">Get access to pro features by recharging with a minimum amount of 100. Recharge now to view the details of your contacts.</p>
						            </div>
						            <div>
						                <a href="{{route('pricing')}}" class="btn btn-primary px-4">Recharge Now</a>
						            </div>
						        </div>
						    </div>
						</div>
					@endif
					@else
					<style>
						    .card.recharge{
						        border: 2px dashed rgba(225, 125, 25, 0.3);
						        background: rgba(225, 125, 25, 0.05);
						    }
						</style>
						<table class="table">
							<thead>
								<tr>
									<th style="width: 100px;">{{ __('Sr. No.') }}</th>
									<th class="am-title">{{ __('WhatsApp Mobile') }}</th>
									<th class="am-title">{{ __('Name') }}</th>
									<th class="am-title">{{ __('Date of birth') }}</th>
									<th class="am-title">{{ __('Anniversary Date') }}</th>
									<th class="am-title">{{ __('Total Subscription') }}</th>
									<th class="am-date">{{ __('Action') }}</th>
								</tr>
							</thead>
						</table>
						<div class="card recharge mb-0 shadow-none  @if($planData['userData']->current_account_status == 'free') __pro__ @endif">
						    <div class="card-body">
						        <div class="d-sm-flex justify-content-between align-items-center">
						            <div class="pr-sm-3">
						                <p class="mb-sm-0">Get access to pro features by recharging with a minimum amount of 100. Recharge now to view the details of your contacts.</p>
						            </div>
						            <div>
						                <a href="{{route('pricing')}}" class="btn btn-primary px-4">Recharge Now</a>
						            </div>
						        </div>
						    </div>
						</div>
					@endif
				</div>
			</div>
		</div>


	</div>
</section>
@endsection
@push('js')
	<script src="{{ asset('assets/js/form.js') }}"></script>
	<script>

		$("#view_groups_data_table").DataTable({
            processing: true,
            serverSide: true,
            bPaginate: true,
            autoWidth: false,
            searchable: true,
			oLanguage: {
                "sEmptyTable": "{{ Config::get('constants.no_record_found') }}"
            },
            ajax: {
                'url': "{{ url('business/get-groups-list') }}",
                'type': 'GET',
                'data': function (d) {
                    d._token = "{{ csrf_token() }}";
					d.id = "{{$id}}"
                }
            },
            columns: [
                {data: 'DT_RowIndex', "orderable": false},
                {data: 'whatsapp mobile'},
                {data: 'name'},
                {data: 'date of birth'},
                {data: 'anniversary date'},
                {data: 'total subscription'},
                {data: 'action'},
            ]
        });

		$(document).on('click', '#removeCustomers', function() {
				var filter_type = $('select[name="filter_type"]').val();

				if(filter_type == ''){
						Sweet('error', 'Please select a action.');
						return false;
				}

				swal.fire({
	          title: 'Are you sure?',
	          text: 'Note: It will delete only customers with 0 subscriptions!',
	          type: 'question',
	          icon: 'question',
	          animation: true,
	          showCancelButton: true,
	          confirmButtonColor: '#3085d6',
	          cancelButtonColor: '#d33',
	          confirmButtonText: 'Yes Delete',
	          cancelButtonText: 'Cancel',
	          confirmButtonClass: 'btn btn-success',
	          cancelButtonClass: 'btn btn-danger',
	          buttonsStyling: true,
	          focusConfirm: true
	      })
	      .then(function(data){
	          if (data.value == true) {
	              var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
				        var data = {
				            "_token" : CSRF_TOKEN,
				            "action" : filter_type,
				        };

				        var url = '{{ route("business.customerDeleteBulk") }}';
            		

									$.ajax({
			              url : url,
			              type : 'POST',
			              data : data,
			              dataType : "json",
			              success : function(response) {  
			                  if(response.success == true){
			                      Sweet('success',response.message);  

			                      location.reload();
			                  }else{
			                      Sweet('error',response.message);
			                  } 
			              }
			            });
	                  
	          }
	      });
		});

		$(document).on('click', '.deleteCustomer', function() {
			var customer_id = $(this).attr('id');

			swal.fire({
          title: 'Are you sure?',
          text: 'Once deleted, you will not be able to recover this customer!',
          type: 'question',
          icon: 'question',
          animation: true,
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes Delete',
          cancelButtonText: 'Cancel',
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: true,
          focusConfirm: true
      })
      .then(function(data){
          if (data.value == true) {
              var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			        var data = {
			            "_token" : CSRF_TOKEN
			        };

			        var url = '{{ route("business.customerDelete", ":id") }}';
            	url = url.replace(':id', customer_id);

								$.ajax({
		              url : url,
		              type : 'POST',
		              data : data,
		              dataType : "json",
		              success : function(response) {  
		                  if(response.success == true){
		                      Sweet('success',response.message);  

		                      location.reload();
		                  }else{
		                      Sweet('error',response.message);
		                  } 
		              }
		            });
                  
          }
      });

		});
	</script>

@endpush
@section('end_body')
@endsection