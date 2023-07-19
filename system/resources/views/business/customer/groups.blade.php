@extends('layouts.business')
@section('title', 'Contact Groups: Business Panel')
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
		@media(max-width: 767px){
            .dataTables_wrapper .dataTables_filter{
                text-align: left;
            }
        }
	</style>
@endsection
@section('head')
@include('layouts.partials.headersection',['title'=>'Contact Groups'])
@endsection
@section('content')
<section>
	<div class="section">
		<div class="">
			<div class="row justify-content-between">
				<div class="col-md-8 col-sm-12 col-12">
					<div class="text-right_ mb-4">
						<a href="{{route('business.customers.import')}}" class="btn btn-success btn-lg px-4 mx-1">Import Contacts</a>
						@if($planData['userData']->current_account_status == 'paid')
							@if($planData['message_plan']->wallet_balance <= 0)
								<span  class="export btn btn-success btn-lg px-4 mx-1 @if($planData['message_plan']->wallet_balance <= 0) __pro__ @endif" id="zeroBalence">Export Contacts</span>
							@else
								<a href="{{route('business.customers.exportContacts')}}" class="export btn btn-success btn-lg px-4 mx-1">Export Contacts</a>
							@endif
						@else
						<span  class="export btn btn-success btn-lg px-4 mx-1 __pro__" id="zeroBalence">Export Contacts</span>
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-body px-0">
				<div class="table-responsive custom-table">
					<table class="table mb-0" id="contact_groups_data_table">
						<thead>
							<tr>
								<th style="width: 100px;">{{ __('Sr. No.') }}</th>
								<th class="am-title">{{ __('Name') }}</th>
								<th class="am-title">{{ __('Total Customers') }}</th>
								<th class="am-title">{{ __('Default Group') }}</th>
								<th class="am-date">{{ __('Action') }}</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@push('js')
	<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
	<script>
		$(document).on('click', '#zeroBalence', function(){
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				onOpen: (toast) => {
					toast.addEventListener('mouseenter', Swal.stopTimer)
					toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			})

			Sweet('error',"{{ Config::get('constants.payment_alert')}}");
		})

		$("#contact_groups_data_table").DataTable({
            processing: true,
            serverSide: true,
            bPaginate: true,
            autoWidth: false,
            searchable: true,
			oLanguage: {
                "sEmptyTable": "{{ Config::get('constants.no_record_found') }}"
            },
            ajax: {
                'url': "{{ url('business/get-contact-groups') }}",
                'type': 'GET',
                'data': function (d) {
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                {data: 'DT_RowIndex', "orderable": false},
                {data: 'name'},
                {data: 'total customers'},
                {data: 'default group'},
                {data: 'action'},
            ]
        });
	</script>
	
	@if(Session::get('error_msg'))
		<script>

			// sweet alert function 
			function Sweet(icon,title,time=3000){
    
				const Toast = Swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: time,
					timerProgressBar: true,
					onOpen: (toast) => {
						toast.addEventListener('mouseenter', Swal.stopTimer)
						toast.addEventListener('mouseleave', Swal.resumeTimer)
					}
				})

				Toast.fire({
					icon: icon,
					title: title,
				})
			}
			var msg = '{{ Session::get('error_msg') }}';

			Sweet('error',msg);
		</script>

		@php
			Session::forget('error_msg');
		@endphp
		
	@endif
	
@endpush
@section('end_body')
@endsection