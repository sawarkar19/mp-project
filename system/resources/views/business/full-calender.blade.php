@extends('layouts.business')

@section('head') @include('layouts.partials.headersection',['title'=>'Offer Calendar']) 

<style>
    .offer-list{
        padding-left: 0px;
    }
    .offer-list li{
        font-size: 16px;
        background: black;
        color: white;
        padding: 5px 10px;
        margin-bottom: 2px;
    }

    .fc-content .fc-title{
        color: white;
    }
</style>
@endsection

@section('content')

<section class="section">

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4>Add Offer to the Calendar</h4>
                <hr>
                @php
                    $offers = \DB::table('offers')->where('user_id',Auth::id())->where('start_date', NULL)->where('end_date', NULL)->get();
                    $offer_count = count($offers);
                @endphp

                <select id="selected_offer" name="selected_offer">
                    @foreach($offers as $offer)
                        <option class="offer-title offer_{{ $offer->id }}" value="{{ $offer->id }}">{{ $offer->title }}</option>
                    @endforeach
                    
                </select>

                <input type="date" name="start_date" id="start_date" />
                <input type="date" name="end_date" id="end_date" />
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="add_offer">Add Offer</button>
            </div>
        </div>
    </div>
</div>

{{-- Date Range --}}
<div>
    <input type="hidden" name="offer_count" id="offer_count" value="{{ $offer_count }}" />
</div>

@endsection
@push('js')
<script>

    $(document).ready(function () {
        var SITEURL = "{{ url('/') }}";
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });

        var url = '{{ route("business.fullCalendar") }}';
        var action_url = '{{ route("business.fullCalendarAction") }}';

    
        var calendar = $('#calendar').fullCalendar({
            editable:true,
            header:{
                left:'prev,next today',
                center:'title',
                right:'month,agendaWeek,agendaDay'
            },
            events: url,
            selectable:true,
            selectHelper: true,
            loading: function (bool) { 
                if (bool) 
                    console.log('Loading..'); 
                else 
                    console.log('Loading Done'); 
            },
            select:function(start, end, allDay)
            {

                var count = $("#offer_count").val();
                if(count != 0){
                    var start = $.fullCalendar.formatDate(start, 'Y-MM-DD');
                    var end = $.fullCalendar.formatDate(end, 'Y-MM-DD');

                    addOffer(start, end);
                }else{
                    Sweet('error','No offers are found!');
                }
            },
            dayClick: function(date, jsEvent, view) {
                //$("#editModal").modal("show");
            },
            editable:true,
            eventResize: function(event, delta)
            {
                var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                var id = event.id;
                $.ajax({
                    url:action_url,
                    type:"POST",
                    data:{
                        start: start,
                        end: end,
                        id: id,
                        type: 'update'
                    },
                    success:function(response)
                    {
                        if(data.status == true){
                            calendar.fullCalendar('refetchEvents');
                            Sweet('success','Offer Updated Successfully!');
                        }else{
                            Sweet('error',data.message);
                        }
                        
                    }
                })
            },
            eventDrop: function(event, delta)
            {
                var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                var id = event.id;
                $.ajax({
                    url:action_url,
                    type:"POST",
                    data:{
                        start: start,
                        end: end,
                        id: id,
                        type: 'update'
                    },
                    success:function(response)
                    {
                        if(data.status == true){
                            calendar.fullCalendar('refetchEvents');
                            Sweet('success','Offer Updated Successfully!');
                        }else{
                            Sweet('error',data.message);
                        }
                        
                    }
                })
            },
    
            eventClick:function(event)
            {
                if(confirm("Are you sure you want to remove it?"))
                {
                    var id = event.id;
                    $.ajax({
                        url:action_url,
                        type:"POST",
                        data:{
                            id:id,
                            type:"delete"
                        },
                        success:function(response)
                        {
                            calendar.fullCalendar('refetchEvents');
                            Sweet('success','Offer Removed Successfully!');
                            getOfferList();
                        }
                    })
                }
            }
        });
    
        $("body").delegate("#add_offer", "click", function(){

            $("#editModal").modal("hide");
            var start = $("#start_date").val();
            var end = $("#end_date").val();
            var id = $("#selected_offer").val();

            var SITEURL = "{{ url('/') }}";
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });

            var action_url = '{{ route("business.fullCalendarAction") }}';
    
            $.ajax({
                url:action_url,
                type:"POST",
                data:{
                    start: start,
                    end: end,
                    id: id,
                    type: 'add'
                },
                success:function(data)
                {
                    if(data.status == true){
                        $('.offer_'+id).remove();
                        var count = $("#offer_count").val();
                        count = count - 1;
                        $("#offer_count").val(count);

                        $('#calendar').fullCalendar('refetchEvents');
                        Sweet('success','Offer Created Successfully!');
                    }else{
                        Sweet('error',data.message);
                    }
                    
                }
            });
        });

        function addOffer(start, end){
            $("#start_date").val(start);
            $("#end_date").val(end);
            
            $("#editModal").modal("show");
        }

        function getOfferList(){

            var SITEURL = "{{ url('/') }}";
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });

            var list_url = '{{ route("business.fullCalendarOfferList") }}';

            $.ajax({
                url:list_url,
                type:"GET",
                success:function(res)
                {
                    $('#selected_offer').empty();
                    $.each(res.offers, function( key, value ) {
                        $('#selected_offer').append('<option class="offer-title offer_' + value.id + '" value="' + value.id + '">' + value.title + '</option>');
                    });

                    $("#offer_count").val(res.count);
                    //console.log(res);
                }
            });
        }
    });
      
    </script>
@endpush