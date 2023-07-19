@extends('layouts.business')
@section('title', 'Statements: Business Panel')
@section('head')
@include('layouts.partials.headersection',['title'=>'Statements'])
@endsection
@section('end_head')
<style>
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
@section('content')
<div class="row justify-content-center">
	<div class="col-sm-12">
		@if(Session::has('fail'))
			<div class="alert alert-danger alert-dismissible show fade">
				<div class="alert-body">
					<button class="close" data-dismiss="alert">
						<span>×</span>
					</button>
					{{ Session::get('fail') }}
				</div>
			</div>
		@endif
		@if(Session::has('success'))
			<div class="alert alert-success alert-dismissible show fade">
				<div class="alert-body">
					<button class="close" data-dismiss="alert">
						<span>×</span>
					</button>
					{{ Session::get('success') }}
				</div>
			</div>
		@endif
	</div>
</div>

<div class="card">
	<div class="card-header">
		<h4>{{ __('Transactions') }}</h4>
	</div>
	<div class="card-body p-0">
		<div class="table-responsive">
			<table class="table table-hover table-nowrap card-table" id="statement_data_table">
				<thead>
					<tr>
						<th style="width: 100px;">{{ __('Sr. No.') }}</th>
						<th>{{ __('Payment ID') }}</th>
						<th>{{ __('Status') }}</th>
						<th>{{ __('Amount') }}</th>
						<th>{{ __('Transaction Date') }}</th>
						{{-- <th>{{ __('Invoice Date') }}</th> --}}
						<th>{{ __('Action') }}</th>
					</tr>
				</thead>
				<tbody class="list font-size-base rowlink" data-link="row">
					
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection	

@push('js')
    <script type="text/javascript">
        $("#statement_data_table").DataTable({
            processing: true,
            serverSide: true,
            bPaginate: true,
            autoWidth: false,
            searchable: true,
            oLanguage: {
                "sEmptyTable": "{{ Config::get('constants.no_record_found') }}"
            },
            ajax: {
                'url': "{{ url('business/subscriptions/get-statement') }}",
                'type': 'GET',
                'data': function (d) {
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                {data: 'DT_RowIndex', "orderable": false},
                {data: 'payment id'},
                {data: 'status'},
                {data: 'amount'},
                {data: 'transaction date'},
                {data: 'action'},
            ]
        });
    </script>
@endpush