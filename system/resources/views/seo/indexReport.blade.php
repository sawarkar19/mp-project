@extends('layouts.seo')
@section('title', 'Reports: SEO Panel')
@section('head')
@include('layouts.partials.headersection',['title'=>'Reports'])
@endsection

@section('end_head')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterangepicker.css') }}">
<style>
    .repot{
        position: relative;
        scroll-behavior: smooth;
    }
    .report_sticky_top{
        width: 100%;
        position: sticky;
        top: 0;
        z-index: 5;
    }
    .report_tabs{
        width: 100%;
        background-color: #FFFFFF;
        z-index: 1;
        position: relative;
    }
    .report_tabs .report_tabs-inner{
        padding: 15px 0;
    }
    .flex-nav{
        position: relative;
        display: flex;
        flex-direction: row;
        justify-content:center;
        align-items: center;
    }

    @media(max-width:767px){
        .flex-nav{
            flex-wrap: wrap;
        }
        .scroll-btns a{
            line-height: 18px;
        }
        .list-tab-top{
            top: 115px;
        }
    }
    @media(max-width:575px){
        .scroll-btns .btn{
            margin-bottom: 10px;
        }
        .list_heading{
            padding-bottom: 10px;
        }
        /* for search bar width 100% in mobile view */
        .reports .card .card-header, .message-report .card .card-header{
            display: block;
        }
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

<section>
    <div class="report-page">
        <div class="repot">
            {{--tabs--}}
            <div class="report_sticky_top sticky-top mt-5_" id="">
                <div class="report_tabs rounded">
                    <div class="report_tabs-inner">
                        <div class="container-fluid">
                            <div class="flex-nav justify-content-md-between">

                                <div class="scroll-btns">
                                    <a href="#redeem_list"
                                        class="scrolly btn btn-sm  btn-primary py-1 px-3 h-auto">Redeems</a>
                                    <a href="#subscription_list"
                                        class="scrolly btn btn-sm btn-success py-1 mx-sm-1 px-3 h-auto">Challenge Subscribers</a>
                                    <a href="#message_list"
                                        class="scrolly btn btn-sm  py-1 btn-warning px-3 h-auto">Messages</a>
                                    <a href="#deduction_list"
                                        class="scrolly btn btn-sm  py-1 btn-info px-3 h-auto">Deductions</a>
                                    <a href="#social_impact"
                                        class="scrolly btn btn-sm  py-1 btn-secondary px-3 h-auto">Social Impact</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="position-relative" style="z-index: 0;">
                {{-- Redeem  --}}
                <div class="pb-5 pt-2" id="redeem_list">
                    <div class="card">
                        <div class="card-header list-tab-top justify-content-between" style="border-bottom: none;">
                            <h4 class="list_heading">Redeems</h4>
                        </div>
                       
                        <div class="card-body">
                            <div class="table-responsive custom-table">
                                <table class="table mb-0 data-table table-striped" id="redeem_list_data_table">
                                    <thead>
                                        <tr>
                                            <th>Sr. no</th>
                                            <th>Customer Number</th>
                                            <th>Offer Title</th>
                                            <th>Challenge Type</th>
                                            <th>Redeem Status</th>
                                            <th>Redeem Type</th>
                                            <th>Amount</th>
                                            <th>Paid Amount</th>
                                            <th>Discount Received</th>
                                            <th>Redeemed Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
               
                    </div>
                </div>
                {{-- Supscription List  --}}
                <div class="pb-5" id="subscription_list">
                    <div class="card">
                        <div class="card-header list-tab-top justify-content-between">
                            <h4 class="list_heading">Challenge Subscriber</h4>
                        </div>
                       
                            <div class="card-body">
                                <div class="table-responsive custom-table">
                                    <table class="table mb-0" id="subscription_list_data_table">
                                        <thead>
                                            <tr>
                                                <th width="100px">Sr. no</th>
                                                <th width="175px">Offer Title</th>
                                                <th>Subscriber Number</th>
                                                <th>Status</th>
                                                <th>Challenge Type</th>
                                                <th width="200px">Challenge Details</th>
                                                <th>Unique Clicks</th>
                                                <th>Completed Challenge</th>
                                                <th>Subscription Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                     
                    </div>
                </div>
                {{-- Challenges list end  --}}
            </div>
            {{-- Message list  --}}
            <div class="pb-5" id="message_list">
                <div class="card">
                    <div class="card-header list-tab-top justify-content-between" style="top:0px;">
                        <h4 class="list_heading">Messages</h4>
                    </div>
                    
                        <div class="card-body">
                            <div class="table-responsive custom-table">
                                <table class="table mb-0" id="message_list_data_table">
                                    <thead>
                                        <tr>
                                            <th>Sr. no</th>
                                            <th>Customer Number</th>
                                            <th>Sent By</th>
                                            <th>Sent Via</th>
                                            <th>Sent Date</th>
                                            <th>Status</th>
                                            <th>View Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    
                </div>
            </div>
            {{-- Message list end --}}
            {{-- Deduction list  --}}
            <div class="pb-5" id="deduction_list">
                <div class="card">
                    <div class="card-header list-tab-top justify-content-between" style="top:0px;">
                        <h4 class="list_heading">Deductions</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive custom-table">
                            <table class="table table-striped table-borderless mb-0" id="deduction_list_data_table">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Customer Name</th>
                                        <th>Deduction Towards</th>
                                        <th>Deducted Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Deduction list end --}}

            {{-- Social Impact list  --}}
            <div class="pb-5" id="social_impact">
                <div class="card">
                    <div class="card-header list-tab-top justify-content-between" style="top:0px;">
                        <h4 class="list_heading">Social Impact</h4>
                    </div>
                    
                        <div class="card-body">
                            <div class="table-responsive custom-table">
                                <table class="table table-striped table-borderless mb-0" id="social_impact_data_table">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Offer Title</th>
                                            <th>Facebook Comment</th>
                                            <th>Facebook like</th>
                                            <th>Instagram Comment</th>
                                            <th>Instagram Like</th>
                                            <th>Tweet Like</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
            </div>
            {{-- Social Impact list end --}}
        </div>
    </div>
</section>
@endsection
@push('js')
    <script src="{{ asset('assets/js/form.js') }}"></script>

    <script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
    {{-- Date Picker --}}
    {{-- <script>
        $(document).ready(function() {

            $('.daterange-cus').daterangepicker({
                locale: {
                    format: 'DD-MM-YYYY'
                },
                singleDatePicker: false,
                timePicker: false,
                autoUpdateInput: true,
                autoApply: true,

            });
        })
    </script> --}}
    <script type="text/javascript">
        $("#redeem_list_data_table").DataTable({
            processing: true,
            serverSide: true,
            bPaginate: true,
            autoWidth: false,
            searchable: true,
            oLanguage: {
                "sEmptyTable": "Sorry no records found!"
            },
            ajax: {
                'url': "{{ url('seo/get-redeems') }}",
                'type': 'GET',
                'data': function (d) {
                    d._token = "{{ csrf_token() }}";
                    d.id = "{{ $id }}"
                }
            },
            columns: [
                {data: 'DT_RowIndex', "orderable": false},
                {data: 'customer number'},
                {data: 'offer title'},
                {data: 'challenge type'},
                {data: 'redeem status'},
                {data: 'redeem type'},
                {data: 'amount'},
                {data: 'paid amount'},
                {data: 'discount received'},
                {data: 'redeemed date'},
            ]
        });

        $("#subscription_list_data_table").DataTable({
            processing: true,
            serverSide: true,
            bPaginate: true,
            autoWidth: false,
            searchable: true,
            oLanguage: {
                "sEmptyTable": "Sorry no records found!"
            },
            ajax: {
                'url': "{{ url('seo/get-subscriptions') }}",
                'type': 'GET',
                'data': function (d) {
                    d._token = "{{ csrf_token() }}";
                    d.id = "{{ $id }}"
                }
            },
            columns: [
                {data: 'DT_RowIndex', "orderable": false},
                {data: 'offer title'},
                {data: 'subscriber number'},
                {data: 'status'},
                {data: 'challenge type'},
                {data: 'challenge details'},
                {data: 'unique clicks'},
                {data: 'completed challenge'},
                {data: 'subscription date'},
            ]
        });

        $("#message_list_data_table").DataTable({
            processing: true,
            serverSide: true,
            bPaginate: true,
            autoWidth: false,
            searchable: true,
            oLanguage: {
                "sEmptyTable": "Sorry no records found!"
            },
            ajax: {
                'url': "{{ url('seo/get-messages') }}",
                'type': 'GET',
                'data': function (d) {
                    d._token = "{{ csrf_token() }}";
                    d.id = "{{ $id }}"
                }
            },
            columns: [
                {data: 'DT_RowIndex', "orderable": false},
                {data: 'customer number'},
                {data: 'sent by'},
                {data: 'sent via'},
                {data: 'sent date'},
                {data: 'status'},
                {data: 'view message'},
            ]
        });

        $("#deduction_list_data_table").DataTable({
            processing: true,
            serverSide: true,
            bPaginate: true,
            autoWidth: false,
            searchable: true,
            oLanguage: {
                "sEmptyTable": "Sorry no records found!"
            },
            ajax: {
                'url': "{{ url('seo/get-deductions') }}",
                'type': 'GET',
                'data': function (d) {
                    d._token = "{{ csrf_token() }}";
                    d.id = "{{ $id }}"
                }
            },
            columns: [
                {data: 'DT_RowIndex', "orderable": false},
                {data: 'name'},
                {data: 'deduction towards'},
                {data: 'deduction amount'},
                {data: 'date'},
            ]
        });
        $("#social_impact_data_table").DataTable({
            processing: true,
            serverSide: true,
            bPaginate: true,
            autoWidth: false,
            searchable: true,
            oLanguage: {
                "sEmptyTable": "{{ Config::get('constants.no_record_found') }}"
            },
            ajax: {
                'url': "{{ url('seo/get-social-impact') }}",
                'type': 'GET',
                'data': function (d) {
                    d._token = "{{ csrf_token() }}";
                    d.id = "{{ $id }}"
                }
            },
            columns: [
                {data: 'DT_RowIndex', "orderable": false},
                {data: 'offer title'},
                {data: 'facebook comment'},
                {data: 'facebook like'},
                {data: 'instagram comment'},
                {data: 'instagram like'},
                {data: 'tweet like'},
            ]
        });
    </script>
@endpush