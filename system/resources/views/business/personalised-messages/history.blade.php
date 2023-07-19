@extends('layouts.business')

@section('title', 'History: Business Panel')

@section('head')
    @include('layouts.partials.headersection', ['title' => 'Personalised Messaging History'])
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

        .table:not(.table-sm):not(.table-md):not(.dataTable) td,
        .table:not(.table-sm):not(.table-md):not(.dataTable) th {
            padding: 0.75rem;
        }

        .groups-name-col .btn.groups-name-list {
            padding: 0px 10px;
            font-size: 10px;
            border-radius: 20px;
            display: block;
        }

        .groups-name-col .btn.groups-name-list span {
            padding: 2px 4px;
            font-size: 10px;
        }

        .groups-name-col .btn.groups-name-list:hover span {
            background: #fff;
            color: #237CD6;
        }

        .groups-name-col .btn.groups-name-list:not(:first-child) {
            margin-top: 10px;
        }
        /* offcanvas for menus */
        .bs-canvas-overlay {
            opacity: 0;
            z-index: -1;
            top: 0;
            left: 0;
        }
        .bs-canvas-overlay.show {
            opacity: 0.85;
            z-index: 1100;
        }
        .bs-canvas-overlay, .bs-canvas {
            transition: all .4s ease-out;
            -webkit-transition: all .4s ease-out;
            -moz-transition: all .4s ease-out;
            -ms-transition: all .4s ease-out;
        }
        .bs-canvas {
            top: 0;
            z-index: 1110;
            overflow-x: hidden;
            overflow-y: auto;
            width: 330px;		
        }
        .bs-canvas-left {
            left: 0;
            margin-left: -330px;
        }
        .bs-canvas-right {
            right: 0;
            margin-right: -330px;
        }
        .bs-canvas {
            background: #fff;
        }
        .bs-canvas-header{
            background: linear-gradient(135deg, rgb(0,255,175, 1) -50%, rgba(0,36,156, 1));
        }
        .contact-grp-table .tab-rounded{
            border-radius: 10px;
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

    <section class="section">
        <div class="section-body">
            @if($planData['userData']->current_account_status=='paid')
            <div class="row">
                {{--offer message history table new --}}
                @include('business.personalised-messages.offer-messages-list')

                {{--birthday history table --}}
                @include('business.personalised-messages.birthday-messages-list')

                {{--anniversary history table --}}
                @include('business.personalised-messages.anniversary-messages-list')

                {{--custom history table new --}}
                @include('business.personalised-messages.festival-messages-list')

                {{--custom history table new --}}
                @include('business.personalised-messages.custom-messages-list')
            </div>
            @else
            <style>
                    .card.recharge{
                    border: 2px dashed rgba(225, 125, 25, 0.3);
                    background: rgba(225, 125, 25, 0.05);
                }
            </style>
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
    </section>

   {{-- offcanvas view details --}}
    <div id="bs-canvas-right" class="bs-canvas bs-canvas-right position-fixed h-100">
        <div class="bs-canvas-header p-3 overflow-auto">
            <button type="button" class="bs-canvas-close close" aria-label="Close" aria-expanded="false"><span aria-hidden="true" class="text-white">&times;</span></button>
            <h5 class="d-inline-block text-white mb-0">Details</h5>
        </div>
        <div class="bs-canvas-content px-3 py-5" id="OffCanvasContent">
            
        </div>    
    </div>
    <div class="bs-canvas-overlay bg-dark position-fixed w-100 h-100"></div>
    
@endsection

@section('end_body')
@push('js')
    <script>
        // const resendMsgInterval = setInterval(resendMsg, 1000);

        function resendMsg(scheduleMsgs_id, type, date)
        { 
            if(scheduleMsgs_id != undefined)
            {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var data = {
                    "_token" : CSRF_TOKEN,
                    "scheduleMsgs_id" : scheduleMsgs_id,
                    "type" : type,
                    "date" : date
                };

                if(type == 'dob' || type == 'anniversary'){
                    var url = '{{ route("business.channel.personalisedMessage.resendFailedWishMsg") }}';
                }else{
                    var url = '{{ route("business.channel.personalisedMessage.resendFailedMsg") }}';
                }

                $.ajax({
                    url : url,
                    type : 'POST',
                    data : data,
                    dataType : "json",
                    success : function(response) {
                        $(".close").trigger("click"); 
                        if(response.status == true)
                        {
                            Sweet('success',response.message);
                            setTimeout(function(){location.reload();}, 3000);                          
                        }else{
                            Sweet('error',response.message);
                        } 
                        //clearInterval(resendMsgInterval);
                    }
                });
            }
        }

        function resendFailedOfferMsg(offer_id,date){
            if(offer_id != undefined)
            {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var data = {
                    "_token" : CSRF_TOKEN,
                    "offer_id" : offer_id,
                    "date" : date
                };

                var url = '{{ route("business.channel.personalisedMessage.resendFailedOfferMsg") }}';

                $.ajax({
                    url : url,
                    type : 'POST',
                    data : data,
                    dataType : "json",
                    success : function(response) {
                        $(".close").trigger("click"); 
                        if(response.status == true)
                        {
                            Sweet('success',response.message);
                            setTimeout(function(){location.reload();}, 3000);                          
                        }else{
                            Sweet('error',response.message);
                        } 
                        //clearInterval(resendMsgInterval);
                    }
                });
            }
        }
        
        // function resendofferMsg(offer_id,date)
        // { 
        //     if(offer_id != undefined)
        //     {
        //         var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //         var data = {
        //             "_token" : CSRF_TOKEN,
        //             "offer_id" : offer_id,
        //             "date" : date
        //         };

        //         var url = '{{ route("business.channel.personalisedMessage.resendFailedOfferMsg") }}';

        //         $.ajax({
        //             url : url,
        //             type : 'POST',
        //             data : data,
        //             dataType : "json",
        //             success : function(response) {
        //                 $(".close").trigger("click"); 
        //                 if(response.status == true)
        //                 {
        //                     Sweet('success',response.message);
        //                     setTimeout(function(){location.reload();}, 3000);                          
        //                 }else{
        //                     Sweet('error',response.message);
        //                 } 
        //                 //clearInterval(resendMsgInterval);
        //             }
        //         });
        //     }
        // }
</script>
@endpush
<script>
        $(document).ready(function() {
            var showChar = 130;
            var ellipsestext = "...";
            var moretext = "Read More";
            var lesstext = "Read less";
            $('.more').each(function() {
                var content = $(this).html();

                if (content.length > showChar) {

                    var c = content.substr(0, showChar);
                    var h = content.substr(showChar - 1, content.length - showChar);

                    var html = c + '<span class="moreellipses">' + ellipsestext +
                        '&nbsp;</span><span class="morecontent"><span>' + h +
                        '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                    $(this).html(html);
                }

            });

            $(".morelink").click(function() {
                if ($(this).hasClass("less")) {
                    $(this).removeClass("less");
                    $(this).html(moretext);
                } else {
                    $(this).addClass("less");
                    $(this).html(lesstext);
                }
                $(this).parent().prev().toggle();
                $(this).prev().toggle();
                return false;
            });
        });
    </script>

    {{-- offcanvas view details script--}}
    <script>
        jQuery(document).ready(function($){
            var bsOverlay = $('.bs-canvas-overlay');
            $("body").delegate("[data-toggle='canvas']", "click", function(event) {
                // $('[data-toggle="canvas"]').on('click', function(){
                var content = $(this).data('content');
                $('#OffCanvasContent').html($(content).html());


                var ctrl = $(this), 
                    elm = ctrl.is('button') ? ctrl.data('target') : ctrl.attr('href');
                $(elm).addClass('mr-0');
                $(elm + ' .bs-canvas-close').attr('aria-expanded', "true");
                $('[data-target="' + elm + '"], a[href="' + elm + '"]').attr('aria-expanded', "true");
                if(bsOverlay.length)
                    bsOverlay.addClass('show');
                return false;
            });
            
            $('.bs-canvas-close, .bs-canvas-overlay').on('click', function(){
                var elm;
                if($(this).hasClass('bs-canvas-close')) {
                    elm = $(this).closest('.bs-canvas');
                    $('[data-target="' + elm + '"], a[href="' + elm + '"]').attr('aria-expanded', "false");
                } else {
                    elm = $('.bs-canvas')
                    $('[data-toggle="canvas"]').attr('aria-expanded', "false");	
                }
                elm.removeClass('mr-0');
                $('.bs-canvas-close', elm).attr('aria-expanded', "false");
                if(bsOverlay.length)
                    bsOverlay.removeClass('show');
                return false;
            });
        });

        $("#dob_msgs_list_datatable").DataTable({
            processing: true,
            serverSide: true,
            bPaginate: true,
            autoWidth: false,
            searchable: true,
			oLanguage: {
                "sEmptyTable": "{{ Config::get('constants.no_record_found') }}"
            },
            ajax: {
                'url': "{{ url('business/channel/personalised-messages/get-dob-message-list') }}",
                'type': 'GET',
                'data': function (d) {
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                {data: 'DT_RowIndex', "orderable": false},
                {data: 'date'},
                {data: 'status'},
                {data: 'message'},
                {data: 'action'},
                {data: 'details'},
            ]
        });

        $("#anni_msgs_list_datatable").DataTable({
            processing: true,
            serverSide: true,
            bPaginate: true,
            autoWidth: false,
            searchable: true,
			oLanguage: {
                "sEmptyTable": "{{ Config::get('constants.no_record_found') }}"
            },
            ajax: {
                'url': "{{ url('business/channel/personalised-messages/get-anni-message-list') }}",
                'type': 'GET',
                'data': function (d) {
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                {data: 'DT_RowIndex', "orderable": false},
                {data: 'date'},
                {data: 'status'},
                {data: 'message'},
                {data: 'action'},
                {data: 'details'},
            ]
        });

        $("#fest_msgs_list_datatable").DataTable({
            processing: true,
            serverSide: true,
            bPaginate: true,
            autoWidth: false,
            searchable: true,
            oLanguage: {
                "sEmptyTable": "{{ Config::get('constants.no_record_found') }}"
            },
            ajax: {
                'url': "{{ url('business/channel/personalised-messages/get-fest-message-list') }}",
                'type': 'GET',
                'data': function (d) {
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                {data: 'DT_RowIndex', "orderable": false},
                {data: 'date'},
                {data: 'status'},
                {data: 'message'},
                {data: 'action'},
                {data: 'details'},
            ]
        });

        $("#cust_msgs_list_datatable").DataTable({
            processing: true,
            serverSide: true,
            bPaginate: true,
            autoWidth: false,
            searchable: true,
			oLanguage: {
                "sEmptyTable": "{{ Config::get('constants.no_record_found') }}"
            },
            ajax: {
                'url': "{{ url('business/channel/personalised-messages/get-cust-message-list') }}",
                'type': 'GET',
                'data': function (d) {
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                {data: 'DT_RowIndex', "orderable": false},
                {data: 'date'},
                {data: 'status'},
                {data: 'message'},
                {data: 'action'},
                {data: 'details'},
            ]
        });

        $("#ofr_msgs_list_datatable").DataTable({
            processing: true,
            serverSide: true,
            bPaginate: true,
            autoWidth: false,
            searchable: true,
            oLanguage: {
                "sEmptyTable": "{{ Config::get('constants.no_record_found') }}"
            },
            ajax: {
                'url': "{{ url('business/channel/personalised-messages/get-ofr-message-list') }}",
                'type': 'GET',
                'data': function (d) {
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                {data: 'DT_RowIndex', "orderable": false},
                {data: 'date'},
                {data: 'status'},
                {data: 'offer_title'},
                {data: 'action'},
                {data: 'details'},
            ]
        });
    </script>

@endsection
