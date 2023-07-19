@extends('layouts.business')
@section('title', 'Reports: Business Panel')
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
    /* offcanavs view message details*/
    .viewMsg-bs-canvas-overlay {
   		opacity: 0.85;
		z-index: 1100;
	}
    .viewMsg-bs-canvas {
		top: 0;
		z-index: 1110;
		overflow-x: hidden;
		overflow-y: auto;
		width: 330px;
	}
    .viewMsg-bs-canvas-overlay, .viewMsg-bs-canvas{
        transition: all .5s ease-out;
        -webkit-transition: all .5s ease-out;
        -moz-transition: all .5s ease-out;
        -ms-transition: all .5s ease-out;
    }
	
	.viewMsg-bs-canvas-header{
            background: linear-gradient(135deg, rgb(0,255,175, 1) -50%, rgba(0,36,156, 1));
        }
	.viewMsg-bs-canvas-right {
		right: 0;
		margin-right: -330px;
	}
    .message-content{
        background: #f7f7f7;
        padding: 10px;
        border-radius: 6px;
    }
   
    /* offcanavs view message details end*/


    /* .options{
        height: 100%;
        position: relative;
    }
    .options .radio_label{
        height: 100%;
        width: 100%;
        position: relative;
    }
    .options .card{
        height: 100%;
    }

    
    @media(max-width: 991px){
        .options{
            height: 100%;
            min-height: 100%;
        }

    } */

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
                                        class="scrolly btn btn-sm btn-outline-primary py-1 px-3 h-auto">Redeems</a>
                                    <a href="#subscription_list"
                                        class="scrolly btn btn-sm btn-outline-success py-1 mx-sm-1 px-3 h-auto">Challenge Subscribers</a>
                                    <a href="#message_list"
                                        class="scrolly btn btn-sm py-1 btn-outline-warning px-3 h-auto">Messages</a>
                                    <a href="#deduction_list"
                                        class="scrolly btn btn-sm py-1 btn-outline-info px-3 h-auto">Deductions</a>
                                    <a href="#social_impact"
                                        class="scrolly btn btn-sm py-1 btn-outline-secondary px-3 h-auto">Social Impact</a>
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
                        <div class="card-header list-tab-top justify-content-between px-3" style="border-bottom: none;">
                            <h4 class="list_heading">Redeems</h4>
                        </div>
                        @if($planData['userData']->current_account_status=='paid')
                        <div class="card-body p-0">
                            <div class="table-responsive custom-table">
                                <table class="table mb-0 data-table table-striped" id="redeem_list_data_table">
                                    <thead>
                                        <tr>
                                            <th>Sr. no</th>
                                            <th>Customer Name/Number</th>
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
                                    <th>Sr. no</th>
                                    <th>Customer Name/Number</th>
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
                        </table>
                        <div class="card recharge mb-0 shadow-none">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <div class="pr-sm-3">
                                        <h6 class="text-warning mb-1">Account balance is low.</h6>
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
                {{-- Supscription List  --}}
                <div class="pb-5" id="subscription_list">
                    <div class="card">
                        <div class="card-header list-tab-top justify-content-between px-3">
                            <h4 class="list_heading">Challenge Subscribers</h4>
                        </div>
                        @if($planData['userData']->current_account_status=='paid')
                            <div class="card-body p-0">
                                <div class="table-responsive custom-table">
                                    <table class="table mb-0" id="subscription_list_data_table">
                                        <thead>
                                            <tr>
                                                <th width="100px">Sr. no</th>
                                                <th width="175px">Offer Title</th>
                                                <th>Subscriber Name/Number</th>
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
                                        <th width="100px">Sr. no</th>
                                        <th width="175px">Offer Title</th>
                                        <th>Subscriber Name/Number</th>
                                        <th>Status</th>
                                        <th>Challenge Type</th>
                                        <th width="200px">Challenge Details</th>
                                        <th>Unique Clicks</th>
                                        <th>Completed Challenge</th>
                                        <th>Subscription Date</th>
                                    </tr>
                                </thead>
                            </table>
                            <div class="card recharge mb-0 shadow-none">
                                <div class="card-body">
                                    <div class="d-sm-flex justify-content-between align-items-center">
                                        <div class="pr-sm-3">
                                            <h6 class="text-warning mb-1">Account balance is low.</h6>
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
                {{-- Challenges list end  --}}
            </div>
            {{-- Message list  --}}
            <div class="pb-5" id="message_list">
                <div class="card">
                    <div class="card-header list-tab-top justify-content-between px-3" style="top:0px;">
                        <h4 class="list_heading">Messages</h4>
                    </div>
                    @if($planData['userData']->current_account_status=='paid')
                        <div class="card-body p-0">
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
                                            <th>View Messages</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                                    <th>Sr. no</th>
                                    <th>Customer Number</th>
                                    <th>Sent By</th>
                                    <th>Sent Via</th>
                                    <th>Sent Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        </table>
                        <div class="card recharge mb-0 shadow-none">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <div class="pr-sm-3">
                                        <h6 class="text-warning mb-1">Account balance is low.</h6>
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
            {{-- Message list end --}}
            {{-- Deduction list  --}}
            <div class="pb-5" id="deduction_list">
                <div class="card">
                    <div class="card-header list-tab-top justify-content-between px-3" style="top:0px;">
                        <h4 class="list_heading">Deductions</h4>
                    </div>
                    @if($planData['userData']->current_account_status=='paid')
                        <div class="card-body p-0">
                            <div class="table-responsive custom-table">
                                <table class="table table-striped table-borderless mb-0" id="deduction_list_data_table">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Name</th>
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
                                    <th>Sr. No.</th>
                                    <th>Name</th>
                                    <th>Deduction Towards</th>
                                    <th>Deducted Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                        </table>
                        <div class="card recharge mb-0 shadow-none">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <div class="pr-sm-3">
                                        <h6 class="text-warning mb-1">Account balance is low.</h6>
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
            {{-- Deduction list end --}}
            {{-- Social Impact list  --}}
            <div class="pb-5" id="social_impact">
                <div class="card">
                    <div class="card-header list-tab-top justify-content-betweenpx-3" style="top:0px;">
                        <h4 class="list_heading">Social Impact</h4>
                    </div>
                    @if($planData['userData']->current_account_status=='paid')
                        <div class="card-body p-0">
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
                                    <th>Sr. No.</th>
                                    <th>Offer Title</th>
                                    <th>Facebook Comment</th>
                                    <th>Facebook Like</th>
                                    <th>Instagram Comment</th>
                                    <th>Instagram Like</th>
                                    <th>Tweet Like</th>
                                </tr>
                            </thead>
                        </table>
                        <div class="card recharge mb-0 shadow-none">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <div class="pr-sm-3">
                                        <h6 class="text-warning mb-1">Account balance is low.</h6>
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
            {{-- Social Impact list end --}}
            
        </div>
    </div>
    
</section>
{{-- offcanvas view message details start--}}
<div class="viewMsg-bs-canvas viewMsg-bs-canvas-right position-fixed bg-white h-100" id="viewMsg-bs-canvas-right">
    <div class="viewMsg-bs-canvas-header p-3 overflow-auto">
        <h5 class="d-inline-block text-white mb-0">Message</h5>
        <button type="button" class="viewMsg-bs-canvas-close close" aria-label="Close"><span aria-hidden="true" class="text-light">&times;</span></button> 
    </div>
    <div class="viewMsg-bs-canvas-content px-3 py-5" id="viewMsgOffCanvasContent">
    </div>    
</div>
<div class="bs-canvas-overlay bg-dark position-fixed w-100 h-100"></div>
{{-- offcanvas view message details end--}}

@endsection
@push('js')
    <script src="{{ asset('assets/js/form.js') }}"></script>

    <script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
   <script>
        $(document).ready(function() {
            $.fn.dataTable.ext.errMode = 'throw';
        });
    </script>
    <script type="text/javascript">
        

        $("#redeem_list_data_table").DataTable({
            processing: true,
            serverSide: true,
            bPaginate: true,
            autoWidth: false,
            searchable: true,
            oLanguage: {
                "sEmptyTable": "{{ Config::get('constants.no_record_found') }}"
            },
            ajax: {
                'url': "{{ url('business/get-redeems') }}",
                'type': 'GET',
                'data': function (d) {
                    d._token = "{{ csrf_token() }}";
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
                "sEmptyTable": "{{ Config::get('constants.no_record_found') }}"
            },
            ajax: {
                'url': "{{ url('business/get-subscriptions') }}",
                'type': 'GET',
                'data': function (d) {
                    d._token = "{{ csrf_token() }}";
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
                "sEmptyTable": "{{ Config::get('constants.no_record_found') }}"
            },
            ajax: {
                'url': "{{ url('business/get-messages') }}",
                'type': 'GET',
                'data': function (d) {
                    d._token = "{{ csrf_token() }}";
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
                "sEmptyTable": "{{ Config::get('constants.no_record_found') }}"
            },
            ajax: {
                'url': "{{ url('business/get-deductions') }}",
                'type': 'GET',
                'data': function (d) {
                    d._token = "{{ csrf_token() }}";
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
                'url': "{{ url('business/get-social-impact') }}",
                'type': 'GET',
                'data': function (d) {
                    d._token = "{{ csrf_token() }}";
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
{{-- off canvas view message --}}
    <script>
        jQuery(document).ready(function($){
            $(document).on('click', '.pull-bs-canvas-right', function(){
                $('body').prepend('<div class="viewMsg-bs-canvas-overlay bg-dark position-fixed w-100 h-100"></div>');
                if($(this).hasClass('pull-bs-canvas-right')){
                    $('.viewMsg-bs-canvas-right').addClass('mr-0');
                    var content = $(this).data('content');
                    $('#viewMsgOffCanvasContent').html($(content).html());
                }
                return false;
            });
            
            $(document).on('click', '.viewMsg-bs-canvas-close, .viewMsg-bs-canvas-overlay', function(){
                var elm = $(this).hasClass('viewMsg-bs-canvas-close') ? $(this).closest('.viewMsg-bs-canvas') : $('.viewMsg-bs-canvas');
                elm.removeClass('mr-0 ml-0');
                $('.viewMsg-bs-canvas-overlay').remove();
                return false;
            });
        });
    </script>
    
    {{-- tabs sctive button and scroll to respective div --}}
    <script>
    //button scroll
    $(document).ready(function(){
        $('.scroll-btns a').on('click', function(){
            $(".scroll-btns a").removeClass('active');
            $(this).addClass('active');
            // take the value of id of anchor tag in variable
            var elem = $(this).attr('href');

            $('html,body').animate({
                    scrollTop: $(elem).offset().top - 70
            },'slow');
        })
    });
    </script>
@endpush