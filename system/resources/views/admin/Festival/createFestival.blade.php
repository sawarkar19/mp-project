@extends('layouts.admin')

@section('title', 'Festivals: Admin Panel')

@section('head')
    @include('layouts.partials.headersection', ['title'=>'Festivals'])

    <link href="{{ asset('assets/css/jquery-ui.css') }}" rel="stylesheet" />
    
@endsection



@section('end_head')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugin/quill/quill.snow.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugin/quill/quill.emoji.css')}}"> --}}

<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}" rel="stylesheet">
{{-- <link rel="stylesheet" href="{{ asset('assets/plugin/select2/css/select2.css') }}" rel="stylesheet"> --}}

<link rel="stylesheet" href="{{ asset('assets/plugin/choices.js/styles/choices.min.css') }}">

<style type="text/css">
    .lh-1{
        line-height: 1.5;
    }
    label span{
        color: red;
    }

    .btn-icon{
        min-width: 30px;
    }
    .message-box{
        height: 100%;
        margin-bottom: 0px!important;
    }
    .message-box .card-body,
    .message-box .card-footer{
        padding: 15px!important;
    }


    /* .radio_button{
        visibility: hidden;
        position: absolute;
        top: 0;
        left: 0;
    } */
    .options input:checked + .radio_label:before{
        visibility: visible;
    }
    .options input:checked + .radio_label:after{
        visibility: visible;
    } 
    .options input:checked + .radio_label .card{
        border: 2px solid #144DB1;
        /* background: #effaff; */
    }
    .options .card {
        /* background: #f5f5f7; */
        margin-bottom: 0;
        /* border-radius: 10px 10px 10px 0px; */
        border: 2px solid #f8f8f8;
    }
    .card_style{
        padding: 12px;
    }
    .card_style h6{
        font-size: 14px;
        margin-bottom: 6px;
    }
    .card_style p{
        font-size: 12px;
        line-height: 16px;
    }



    .form-group textarea {
        height: auto !important; 
        width: 100% !important;
    }
        
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        color: #434d4a;
    }
    .card-message-selection{
        pointer-events:none;
    }
    .card-message-hedding{
        pointer-events:none;
        color: #412272;
    }
        

    /* Add message box design */
    .add-message-box{
        height: 100%;
        min-height: auto;
        cursor: pointer;
    }
    .amb-inner{
        position: relative;
        padding: 15px;
        width: 100%;
        height: 100%;
        border: 1px dashed var(--secondary);
        border-radius: 3px;
        text-align: center;
        transition: all 300ms ease;
    }
    .amb-inner .amb-body{
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .amb-inner .title{
        transition: all 300ms ease;
        color: var(--dark);
    }
    .add-message-box:hover .amb-inner{
        border: 1px dashed var(--primary);
    }
    .add-message-box:hover .amb-inner .title{
        color: var(--primary);
    }
    
    .tempSec_Bg {
        background: #f9f9f9;
        padding: 25px;
        border-top-left-radius: 0.3rem;
        border-top-right-radius: 0.3rem;
    }
    /* .add-pr-msg .modal-body{
        padding: 15px;
        padding-top: 0px;
    } */
    .search::before {
        content: "\f002";
        position: absolute;
        right: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--color-thm-lth);
        z-index: 99;
        display: inline-block;
        font-family: "Font Awesome 5 Free";
        font-style: normal;
        font-weight: 400!important;
        font-variant: normal;
        text-transform: none;
        line-height: 1;
        vertical-align: -0.125em;
        -webkit-font-smoothing: antialiased;
    }
    .scroll_temp{
        max-height: 400px;
        overflow-y: scroll;
        overflow-x: hidden;
        /* margin-bottom: 20px; */
    }
    .modal_fullwidth{
        width: 100%;
        max-width: 1024px;
    }

    .grid {
        display: flex;
        flex-wrap: wrap;
    }
    .grid-col {
        flex: 1;
        padding: 0 0.1em;
    }
    .grid-col--2, .grid-col--3 {
    display: none;
    }
    /* new popups */
    .birthday-images-section{
        background-image: url({{ asset('assets/business/pop-up-images/personalised-message/background-img.png')}});
        background-repeat: no-repeat;
        background-size: 100% 100%;
    }
    .anni-images-section{
        background: #F6E9CA;
        border-radius: 0.3rem 0 0 0.3rem;
    }
   
    .text-color{
        color: #412272;
    }
    .options{
        position: relative;
    }
    .radio_button{
        visibility: hidden;
        position: absolute;
        top: 14px;
        right: 6px;
        z-index: 10;
    }
    .radio_button[type="radio"]:checked + label:before,
    .radio_button[type="radio"]:not(:checked) + label:before {
        content: '';
        border: 1px solid #ddd;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        position: absolute;
        top: 12px;
        right: 6px;
        z-index: 10;
    }
    .radio_button[type="radio"]:checked + label:after,
    .radio_button[type="radio"]:not(:checked) + label:after {
        border: 1px solid #fff;
        border-top: 0;
        border-left: 0;
        content: "";
        display: block;
        height: 6px;
        position: absolute;
        top: 18px;
        right: 12px;
        transform: rotate(45deg) translate(-50%, -50%);
        width: 4px;
    }
   
    .radio_button[type="radio"]:not(:checked) + label:after {
        opacity: 0;
    }
    .radio_button[type="radio"]:checked + label:before{
        background: #144DB1;
    }
    .radio_button[type="radio"]:checked + label:after {
        opacity: 1;
        z-index: 11;
    }
    .date-time .form-group{
        max-width: 350px;
        padding: 0.5rem 0;
    }
    .tab-select ul.nav.nav-tabs{
        border-bottom: 2px solid #ebebeb;
    }
    .tab-select .nav-tabs .nav-link.active{
        border-bottom: 2px solid #412272;
        color: #412272;
        font-weight: 500;
        background: transparent;
    }
    .tab-select .nav-tabs .nav-link {
        border: 2px solid transparent;
        border-top-left-radius: 0rem;
        border-top-right-radius: 0rem;
        color: #777777;
    }
    .anni-card{
        position: relative;
    }
    
    .anniversary-msg .modal-body{
        padding: 0px 15px !important;
    }
      
    .personalised-inner-image{
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }
    .personalised-design-img{
        position: absolute;
        top: 0;
        left:-1px;
    }
    .birthday-design {
        max-width: 200px;
    }
    .birthday-inner{
         max-width: 160px;
    }
    .anni-card-img{
        max-width: 120px;
    }
    .anni-flower{
        max-width: 100px;
    }
    .birthday-msg button.close, .anniversary-msg button.close, .add-pr-msg button.close{   
        color: #164287;
        opacity: 0.8;
        font-size: 1.2rem;
        position: absolute;
        right:0;
        top: 0;
        z-index: 10;
    }
    .tab-select .nav-link{
        padding: 0.5rem 0rem;
    }
    @media (min-width: 768px) {  
        .grid-col {
            padding: 0 0.5em;
        }
        .grid-col--2 {
            display: block;
        }
        .birthday-msg .modal-dialog.modal-lg, .anniversary-msg .modal-dialog.modal-lg{
            max-width: 700px;
        }
        .tab-select .nav-tabs li {
            margin: 0 20px;
        }
        .tab-select .nav-tabs li:first-child{
            margin: 0 20px 0 0;
        }
    }
    @media(max-width:768px){
        .personalised-design-img{
            width: 130px;
        }
        .tab-select .nav-tabs li{
            width: 40%;
        }
        .add-message-img-inner img{
            max-width: 100px;
        }
        .personalised-inner-image{
            position: relative;
            max-width: 117px;
            top: 25px;
            left: 50%;
            transform: translateX(-50%);
        }  
        .anni-card-img{
            max-width: 66px;
            padding-bottom: 20px;
        }
        .anni-flower{
            width:91px;
        } 
        .add-pr-msg button.close{
            line-height: 1.3;
        }
        
    }
     /* new popups end*/
    /**--grid-list view css-**/
    .message-box .innerBox{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }
    .message-box .innerBox .greet-title-msg .greetTitle.marBtm-3{
        margin-bottom: 1rem;
    }
    .message-box .innerBox .greet-title-msg {
        display: flex;
        flex-direction: column;
    }
    .message-box .innerBox .greet-title-msg .greetTitle h6 {
        white-space: nowrap;
        overflow-x: clip;
        text-overflow: ellipsis;
        align-items: center;
        max-width: 500px;
        overflow: hidden;
    }
    .message-box .innerBox .greetActions-icons{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .addmsg-mar{
        margin-bottom: 1.5rem;
    }
    button.btn-cls-outline{
        padding: 0rem;
        outline: none!important;
    }
    button.btn-cls-outline:focus{
        padding: 0rem;
        margin-top: 3px;
    }
    .form-control[readonly] {
        background-color: #fdfdff;
        opacity: 1;
    }
    .tempSec_Bg .choices__list--dropdown .choices__item--selectable
    {
        padding-right: 4px;
    }
    .tempSec_Bg .choices__list--dropdown .choices__item--selectable:after
    {
        display: none;
    }

    /* view message details Modal start */
    .message-view-modal .modal-header .close-button{
        outline: transparent;
    }
    /* .message-view-modal .modal-header{
        padding-top: 8px;
    } */
    .msg-title-color{
        color: #626262;
    }
    .view-msg-contact-table{
        font-weight: 500 !important;
        height: 40px !important;
    }
     /* view message details Modal end */
    @media (min-width: 575px){
        .list{
            display: block;
        }
        .list .colWidthfull{
        max-width: 100%;  
        }
        .list .addmsg-mar{
            margin-bottom: 0px;
        }
        .list .message-box .innerBox{
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            height: 100%;
        }
        .list .message-box .innerBox .greet-title-msg{
            display: flex;
            flex-direction: row;
            flex: auto;
            align-items: center;
        } 
        .list .message-box .innerBox .greet-title-msg .greetTitle{
            max-width: 400px;
            width: 30%;
        }
        .list .message-box .innerBox .greet-title-msg .greetTitle h6 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            white-space: pre-wrap;
        }
        .list .message-box .innerBox .greet-title-msg .greetTitle.marBtm-3 {
            margin-bottom: 0px;
        }
        .list .message-box .innerBox .marRight{
            margin-right: 10px;
        }
    }
    /**--end grid-list view css-**/

    /**--ipad save cancel btn--**/
    /* @media (max-width: 991px){
        .pers-msg-btn{
            font-size: 10px;
            padding: 0px 8px;
        }
    } */
    @media (min-width: 768px) and  (max-width: 991px){
        .add-pr-msg .modal-dialog{
            max-width: 700px;
        }
    }
</style>
@endsection

@section('content')
<section class="section">
    <div class="section-body">

        


        <div class="row @if(isset($_COOKIE['listing_view'])) {{$_COOKIE['listing_view']}} @else list @endif" id="gridListSwitch">
            @php
                $grid = true;
                
                if ($grid) {
                    $columns = 'col-xl-4 col-sm-6';
                    $view_type = 'grid';
                }else{
                    $columns = 'col-12';
                    $view_type = 'list';
                }
            @endphp

           

    

            <form id="festivalForm" method="post" action="{{ route('admin.storeFestival') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="custom-form pt-20">

                        <div class="form-group">
                            <label for="name">Festival Name</label>
                            <input type="text" placeholder="Title" name="festivalName" class="form-control"
                                id="festivalName">
                        </div>

                        <div class="">
                            <label for="festivalDate">Select Date <span>*</span></label>
                            <input type="text" class="form-control" name="festivalDate" data-edit_temp_id="0" id="festivalDate"
                                min="{{ Carbon\Carbon::tomorrow()->format('d-m-Y') }}">
                        </div>

                        <div class="">
                            <label for="festivalTime">Select Year <span>*</span></label>
                            <input type="text" name="yearpicker" id="yearpicker" class="form-control">
                        </div>

                        <script>
                        for (i = new Date().getFullYear(); i > 2023; i--) {
                            $('#yearpicker').append($('<option />').val(i).html(i));
                        }
                        </script>

                        <div>
                            <label for="festivalTime">Select Time <span>*</span></label>
                            <select name="timeSlot_id" class="from-control choices-time-festival" id="festivalTime"
                                placeholder="Select time slot..." required>
                                <option value="">- Time Slot -</option>
                                @foreach($slots_array as $slot)
                                <option value="{{ $slot['value'] }}">{{ $slot['label'] }}</option>
                                @endforeach
                            </select>
                        </div>

                    



                        <div class="{{$columns}} colWidthfull mb-4 " >
                            <div class="add-message-box" onclick="viewModal('1')">
                                <div class="amb-inner">
                                    <div class="amb-body">
                                        <h6 class="title "><i class="fas fa-plus" style="font-size: inherit;"></i><br>Add Message</h6>
                                        <p class="text text-secondary mb-0">Click here to add message of festival greetings, offers, and more...</p>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <div>
                            <label for="festivalTime">Select Message Template Category <span>*</span></label>
                            <select name="messageTemplateCategory_id" class="from-control choices-time-festival" id="messageTemplateCategory"
                                placeholder="Select Message Template Category" required>
                                <option value=""> Message Template Category</option>
                                @foreach($groups_array as $groups)
                                <option value="{{ $groups['value'] }}">{{ $groups['label'] }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-lg-3">
                            <div class="single-area">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="btn-publish">
                                            <button type="submit" class="btn btn-primary col-12"><i class="fa fa-save"></i>
                                                {{ __('Save') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

            </form>
        </div>
      



  

     
    


       

 

           
        </div>

    </div>  
</section>
<!--view festivals Modal start-->
<!-- <div class="modal fade bg-white" id="festivalMessages" tabindex="-1" aria-labelledby="festivalMessagesLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content shadow border-white p-3">
            <div class="modal-body">
         

           

            </div>
            <div class="modal-footer justify-content-center border-top-0">
                
                <a type="button" href="#"class="btn btn-outline-secondary ms-3 px-4" data-bs-dismiss="modal" id="logincancel">Cancel</a>
            </div>
          </div>
        </div>
    </div> -->

@endsection

@section('end_body')

    <script src="{{ asset('assets/plugin/choices.js/scripts/choices.min.js') }}"></script>
    <script>
    $(function() {
        var groups = new Choices('.choice-group', {
            removeItemButton: true,
            removeItems: true,
            position: 'bottom'
        });

        var groups = new Choices('.choise-groups', {
            allowHTML: true,
            shouldSort: false,
            searchEnabled: true,
            searchChoices: true,
            removeItemButton: true,
            position: 'bottom',
            prependValue: null
        }).setChoices(
            @json($groups_array),
            'value',
            'label',
            false
        );
        var timeslot = new Choices('.choices-time', {
            allowHTML: true,
            shouldSort: false,
            searchPlaceholderValue: 'Search time slot...',
            position: 'bottom',
        }).setChoices(
            @json($slots_array),
            'value',
            'label',
            false
        );

        
        var timeslotFestival = new Choices('.choices-time-festival', {
            allowHTML: true,
            shouldSort: false,
            searchPlaceholderValue: 'Search time slot...',
            position: 'bottom',
        }).setChoices(
            @json($slots_array),
            'value',
            'label',
            false
        );

        var groupsFestival = new Choices('.choise-groups-festival', {
            allowHTML: true,
            shouldSort: false,
            searchEnabled: true,
            searchChoices: true,
            removeItemButton: true,
            position: 'bottom',
            prependValue: null
        }).setChoices(
            @json($groups_array),
            'value',
            'label',
            false
        );

  

        $(".closeModalTemp").click(function(e){
            groups.removeActiveItems();
            groups.setChoices(defaults(), 'value', 'label', false);

            groupsFestival.removeActiveItems();
            groupsFestival.setChoices(defaults(), 'value', 'label', false);
        })

 

      
   
// Edit Festival function start



        $( function() {

            var unavailableDates = @json($usedDates);

            function unavailable(date) {
                dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
                if ($.inArray(dmy, unavailableDates) == -1) {
                    return [true, ""];
                } else {
                    return [false, "", "Unavailable"];
                }
            }

            function getDate(element) {
                var date;
                try {
                    date = $.datepicker.parseDate(dateFormat, element.value);
                } catch (error) {
                    date = null;
                }

                return date;
            }
            


            $("#festivalDate").datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                minDate: new Date(new Date().getTime() + 24 * 60 * 60 * 1000),
                numberOfMonths: 1,
                // beforeShowDay: unavailable
                beforeShowDay: function(date){

                    var editTempIdFestival = $("#festivalDate").attr("data-edit_temp_id_fest");
                    // console.log("editTempId ",editTempIdFestival);
                    
                    if(editTempIdFestival == "0"){
                        dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();

                        console.log("dmy ", dmy);
                        console.log("unavailableDates ", unavailableDates);
                        if ($.inArray(dmy, unavailableDates) == -1) {
                            return [true, ""];
                        } else {
                            return [false, "", "Unavailable"];
                        }
                    }
                    // else{
                    //     dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
                    //     // alert(dmy);
                    //     const dtData = [];
                    //     $.ajax({
                    //         url : "{{ route('business.getFestivalMsgInfo') }}",
                    //         type : 'POST',
                    //         dataType : "JSON",
                    //         data : {
                    //             editTempIdFestival: editTempIdFestival,
                    //             "_token": "{{ csrf_token() }}"
                    //         },
                    //         success : function(res) {
                    //             dtData.push(res.dates);
                    //         }
                    //     });

                    //     if ($.inArray(dmy, dtData) == -1) {
                    //         return [true, ""];
                    //     } else {
                    //         return [false, "", "Unavailable"];
                    //     }
                    // }
                }
            });

        } );
    });
    </script>
   <script src="{{ asset('assets/plugin/colcade/js/colcade.js') }}"></script>
    <script>
        var colcade = new Colcade( '.grid' , {
            columns: '.grid-col',
            items: '.grid-item'
        });
    </script>
    {{-- <script src="{{ asset('assets/plugin/select2/js/select2.full.js') }}"></script>
    <script>
        $(function(){
            if(jQuery().select2) {
                $(".select2").select2();
            }
        });
    </script> --}}


    <script src="{{ asset('assets/js/daterangepicker.js') }}"></script>

    @include('admin.festival.scripts')
    @include('admin.channels.common-js')
    
@endsection