@extends('layouts.business')

@section('title', 'Offer Messages: Business Panel')

@section('head')
@include('layouts.partials.headersection', ['title'=>'Offer Contact List'])
@endsection

@section('end_head')
<style>
    a.morelink {
        text-decoration: none;
        outline: none;
    }

    .morecontent span {
        display: none;
    }

    .comment {
        width: 360px;
        background: #f5f5f7;
        border-radius: 5px;
    }
    .table:not(.table-sm):not(.table-md):not(.dataTable) td, .table:not(.table-sm):not(.table-md):not(.dataTable) th {
        padding: 0.75rem;
    }
    .groups-name-col .btn.groups-name-list{
        padding: 0px 10px;
        font-size: 10px;
        border-radius: 20px;
        display: block;
    }
    .groups-name-col .btn.groups-name-list span{
        padding: 2px 4px;
        font-size: 10px;
    }
    .groups-name-col .btn.groups-name-list:hover span{
        background: #fff;
        color: #237CD6;
    }
    .groups-name-col .btn.groups-name-list:not(:first-child){
        margin-top: 10px;
    }

    .dataTables_wrapper .row{
			justify-content: space-between;
			align-items: center;
		}
		.dataTables_wrapper .row:not(:first-child){
			margin-top: 1rem;
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

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Sent/Failed Via Sms</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive custom-table">
                            <table class="table mb-0" id="offer-msg-list-datatable">
                                <thead>
                                    <tr class="text-left">
                                        <th>Sr. No.</th>
                                        <th>Number</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

      
        </div>
    </div>        
</section>
@endsection
@push('js')
    <script src="{{ asset('assets/js/form.js') }}"></script>
    <script>
        $("#offer-msg-list-datatable").DataTable({
            processing: true,
            serverSide: true,
            bPaginate: true,
            autoWidth: false,
            searchable: true,
			oLanguage: {
                "sEmptyTable": "Sorry no records found!"
            },
            ajax: {
                'url': "{{ url('business/channel/personalised-messages/get-offer-message-list') }}",
                'type': 'GET',
                'data': function (d) {
                    d._token = "{{ csrf_token() }}";
                    d.id = "{{$id}}"
                }
            },
            columns: [
                {data: 'DT_RowIndex', "orderable": false},
                {data: 'number'},
                {data: 'name'},
                {data: 'date'},
                {data: 'status'},
            ]
        });
    </script>
@endpush
@section('end_body')
@endsection
