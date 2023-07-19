@extends('layouts.business')

@section('title', 'Personalised Messaging: Business Panel')

@section('head')
    @include('layouts.partials.headersection', ['title'=>'Personalised Messaging'])
@endsection

@section('end_head')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugin/quill/quill.snow.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugin/quill/quill.emoji.css')}}">

<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/plugin/select2/css/select2.css') }}" rel="stylesheet">
<!-- <link rel="stylesheet" href="{{ asset('assets/plugin/multiselect/css/multiselect.css') }}" rel="stylesheet"> -->

<style type="text/css">
    .btn-post-wa{
        position: relative;
        border: 0px;
        color: #FFF;
        background-color: #128C7E;
        border-radius: 40px;
        display: inline-block;
        text-align: center;
        transform: scale(1);
        transition: all 300ms ease;
        padding: 8px 15px;
        outline: none!important;
        margin-top: 10px;
    }
    .btn-post-wa i{
        margin-right:10px
    }
    .btn-post-wa:hover{
        transform: scale(1.06);
        background-color: #075E54;
    }
    /*editor */
    .ql-toolbar.ql-snow{
        border-radius: 8px 8px 0 0;
    }
    .wa-editor{
        border-radius: 0 0 8px 8px;
        font-size: 1rem;
        background-color: #fbfffc;
    }
    .wa-editor p{
        line-height: 1.3;
    }
    #overlay {
        position: fixed;
        top: 0;
        z-index: 9999;
        width: 100%;
        height: 100%;
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


    #media_preview{
        border-radius: 6px;
        overflow: hidden;
    }
    #media_preview img,
    #media_preview video{
        max-width: 100%!important;
        height: auto!important;
        display: block;
    }
    #removeAttachment{
        cursor: pointer;
        font-weight: bold;
        position: absolute;
        right: 8px;
        top: -7px;
        display:none;
        padding: 0px 5px;
        background: #f00;
        border-radius: 50%;
        color: #fff;
        z-index: 999;
    }
    
    #birthdayTemplate_modal .modal-dialog , #anniversaryTemplate_modal .modal-dialog, #d2CTemplate_modal .modal-dialog{
        max-width: 80%;
    }
    .radio_button{
        visibility: hidden;
        position: absolute;
        top: 0;
        left: 0;
    }
    .options input:checked + .radio_label:before{
        visibility: hidden;
    }
    .options input:checked + .radio_label:after{
        visibility: visible;
    } 
    .options input:checked + .radio_label .card{
        border: 1px solid #006ba2;
        background: #effaff;
    }
    .options .card {
        background: #f9f9f9;
        margin-bottom: 0;
        border: 1px solid #ebebeb;
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
    .d2C_box {
        border: 2px dashed #ddd;
        padding: 15px 20px;
    }
    .d2C_box button {
        font-size: 14px;
        margin-right: 15px;
        padding: 5px 20px;
    }


    .form-group textarea {
        height: auto !important; 
        width: 100% !important;
    }
    label span{
        color: red;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        color: #222;
    }
</style>
@endsection

@section('content')

<section class="section">

    <div class="section-body">

        <div class="row justify-content-end">
            <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
                <div class="toggle_buttons_share_share">
                   <div class="form-group float-sm-right">
                        <div class="custom-switches-stacked mt-2">
                            <label class="custom-switch justify-content-sm-between">
                              <input type="checkbox" checked data-toggle="toggle"  name="option" value="1" class="custom-switch-input" checked>
                              <span class="custom-switch-description mr-4">Via SMS</span><span class="custom-switch-indicator"></span>
                            </label>
                            <label class="custom-switch justify-content-sm-between">
                              <input type="checkbox" checked data-toggle="toggle" name="option" value="2" class="custom-switch-input">
                              <span class="custom-switch-description mr-4">Via WhatsApp</span>
                              <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                    </div> 
                </div>
                
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                      <h4><i class="fa fa-gift"></i> &nbsp;Birthday Message</h4>
                      <div class="card-header-action">
                        <!-- <a href="#" class="btn btn-info">Change <i class="fas fa-chevron-right"></i></a> -->
                        <button class="btn btn-primary" data-toggle="modal" data-target="#birthdayTemplate_modal">Change</button>
                      </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                           <div class="options">
                                <div class="card">
                                    <div class="card_style">
                                        <h6>HAPPY BIRTHDAY</h6> 
                                        <p class="mb-0">“Our age is merely the number of years the world has been enjoying us!”</p> 
                                    </div>
                                </div>  
                            </div>
                           <div class="onOf_Sec">
                            <div class="form-group float-sm-right">
                                <div class="custom-switches-stacked mt-2">
                                    <label class="custom-switch justify-content-sm-between">
                                      <input type="checkbox" checked data-toggle="toggle"  name="option" value="3" class="custom-switch-input" checked>
                                      <span class="custom-switch-description mr-2">OFF</span><span class="custom-switch-indicator"></span><span class="custom-switch-description ml-2">ON</span>
                                    </label>
                                </div>
                            </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                      <h4><i class="fa fa-gift"></i> &nbsp;Anniversary Message</h4>
                      <div class="card-header-action">
                        <!-- <a href="#" class="btn btn-info">Change <i class="fas fa-chevron-right"></i></a> -->
                        <button class="btn btn-primary" data-toggle="modal" data-target="#anniversaryTemplate_modal">Change</button>
                      </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="options">
                                <div class="card">
                                    <div class="card_style">
                                        <h6>HAPPY ANNIVERSARY</h6> 
                                        <p class="mb-0">“Our age is merely the number of years the world has been enjoying us!”</p> 
                                    </div>
                                </div>  
                            </div> 
                           <div class="onOf_Sec">
                            <div class="form-group float-sm-right">
                                <div class="custom-switches-stacked mt-2">
                                    <label class="custom-switch justify-content-sm-between">
                                      <input type="checkbox" checked data-toggle="toggle"  name="option" value="3" class="custom-switch-input" checked>
                                      <span class="custom-switch-description mr-2">OFF</span><span class="custom-switch-indicator"></span><span class="custom-switch-description ml-2">ON</span>
                                    </label>
                                </div>
                            </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-8 mb-5">
                <div class="d2C_box d-flex align-items-center">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#d2CTemplate_modal">Add Message</button> 
                    <p class="mb-0">You can add more messages by clicking on the button.</p>
                </div>
            </div>

            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                      <h4>Message Title</h4>
                      <div class="card-header-action">
                        <!-- <a href="#" class="btn btn-info">Change <i class="fas fa-chevron-right"></i></a> -->
                        <button class="btn btn-primary">Edit</button>
                        <button class="btn btn-danger">Cancel</button>
                      </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                           <div class="options">
                                <div class="card">
                                    <div class="card_style">
                                        <h6>HAPPY ANNIVERSARY</h6> 
                                        <p class="mb-0">“Our age is merely the number of years the world has been enjoying us!”</p> 
                                    </div>
                                </div>  
                            </div>
                           <div class="date-time-sec">
                                <div class="m-2"><b class="text-primary" style="font-size: 15px;">Date:</b> 02-06-2022</div>
                                <div class="m-2"><b class="text-primary" style="font-size: 15px;">Time:</b> 15:32</div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

</section>


<!-- new birthday template modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="birthdayTemplate_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary">Select Template</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row ms">
            <div class="col-lg-4 col-md-4 col-sm-12 mb-2"> 
                <div class="options">
                    <input type="radio" name="bdayposts"  id="bdaytemp1" class="radio_button" checked=""> 
                    <label class="radio_label mb-2" for="bdaytemp1">
                        <div class="card">
                            <div class="card_style">
                                <h6>HAPPY BIRTHDAY</h6> 
                                <p class="mb-0">“It's your special day — get out there and celebrate!”</p>
                            </div>
                        </div> 
                    </label>    
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 mb-2"> 
                <div class="options">
                    <input type="radio" name="bdayposts"  id="bdaytemp2" class="radio_button"> 
                    <label class="radio_label mb-2" for="bdaytemp2">
                        <div class="card">
                            <div class="card_style">
                                <h6>HAPPY BIRTHDAY</h6> 
                                <p class="mb-0">“It's your special day — get out there and celebrate!”</p>
                            </div>
                        </div> 
                    </label>    
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 mb-2"> 
                <div class="options">
                    <input type="radio" name="bdayposts"  id="bdaytemp3" class="radio_button"> 
                    <label class="radio_label mb-2" for="bdaytemp3">
                        <div class="card">
                            <div class="card_style">
                                <h6>HAPPY BIRTHDAY</h6> 
                                <p class="mb-0">“It's your special day — get out there and celebrate!”</p> 
                            </div>
                        </div> 
                    </label>    
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 mb-2"> 
                <div class="options">
                    <input type="radio" name="bdayposts"  id="bdaytemp4" class="radio_button"> 
                    <label class="radio_label mb-2" for="bdaytemp4">
                        <div class="card">
                            <div class="card_style">
                                <h6>HAPPY BIRTHDAY</h6> 
                                <p class="mb-0">“It's your special day — get out there and celebrate!”</p>
                            </div>
                        </div> 
                    </label>    
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 mb-2"> 
                <div class="options">
                    <input type="radio" name="bdayposts"  id="bdaytemp5" class="radio_button"> 
                    <label class="radio_label mb-2" for="bdaytemp5">
                        <div class="card">
                            <div class="card_style">
                                <h6>HAPPY BIRTHDAY</h6> 
                                <p class="mb-0">“It's your special day — get out there and celebrate!”</p>
                            </div>
                        </div> 
                    </label>    
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 mb-2"> 
                <div class="options">
                    <input type="radio" name="bdayposts" id="bdaytemp6" class="radio_button"> 
                    <label class="radio_label mb-2" for="bdaytemp6">
                        <div class="card">
                            <div class="card_style">
                                <h6>HAPPY BIRTHDAY</h6> 
                                <p class="mb-0">“It's your special day — get out there and celebrate!”</p> 
                            </div>
                        </div> 
                    </label>    
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer br">
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- new anniversary template modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="anniversaryTemplate_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary">Select Template</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 mb-2"> 
                <div class="options">
                    <input type="radio" name="bdayposts"  id="annitemp1" class="radio_button" checked=""> 
                    <label class="radio_label mb-2" for="annitemp1">
                        <div class="card">
                            <div class="card_style">
                                <h6>HAPPY ANNIVERSARY</h6> 
                                <p class="mb-0">“Our age is merely the number of years the world has been enjoying us!”</p> 
                            </div>
                        </div> 
                    </label>    
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 mb-2"> 
                <div class="options">
                    <input type="radio" name="bdayposts"  id="annitemp2" class="radio_button"> 
                    <label class="radio_label mb-2" for="annitemp2">
                        <div class="card">
                            <div class="card_style">
                               <h6>HAPPY ANNIVERSARY</h6> 
                                <p class="mb-0">“Our age is merely the number of years the world has been enjoying us!”</p> 
                            </div>
                        </div> 
                    </label>    
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 mb-2"> 
                <div class="options">
                    <input type="radio" name="bdayposts"  id="annitemp3" class="radio_button"> 
                    <label class="radio_label mb-2" for="annitemp3">
                        <div class="card">
                            <div class="card_style">
                               <h6>HAPPY ANNIVERSARY</h6> 
                                <p class="mb-0">“Our age is merely the number of years the world has been enjoying us!”</p> 
                            </div>
                        </div> 
                    </label>    
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 mb-2"> 
                <div class="options">
                    <input type="radio" name="bdayposts"  id="annitemp4" class="radio_button"> 
                    <label class="radio_label mb-2" for="annitemp4">
                        <div class="card">
                            <div class="card_style">
                               <h6>HAPPY ANNIVERSARY</h6> 
                                <p class="mb-0">“Our age is merely the number of years the world has been enjoying us!”</p> 
                            </div>
                        </div> 
                    </label>    
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 mb-2"> 
                <div class="options">
                    <input type="radio" name="bdayposts"  id="annitemp5" class="radio_button"> 
                    <label class="radio_label mb-2" for="annitemp5">
                        <div class="card">
                            <div class="card_style">
                               <h6>HAPPY ANNIVERSARY</h6> 
                                <p class="mb-0">“Our age is merely the number of years the world has been enjoying us!”</p> 
                            </div>
                        </div> 
                    </label>    
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 mb-2"> 
                <div class="options">
                    <input type="radio" name="bdayposts"  id="annitemp6" class="radio_button"> 
                    <label class="radio_label mb-2" for="annitemp6">
                        <div class="card">
                            <div class="card_style">
                               <h6>HAPPY ANNIVERSARY</h6> 
                                <p class="mb-0">“Our age is merely the number of years the world has been enjoying us!”</p> 
                            </div>
                        </div> 
                    </label>    
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer br">
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- new d2c template modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="d2CTemplate_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary">Add Messages</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="D2ctitle">Enter Title <span>*</span></label>
                        <input type="text" class="form-control" id="D2ctitle">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="D2cdate">Select Date <span>*</span></label>
                        <input type="date" class="form-control" id="D2cdate">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="D2ctime">Select Time <span>*</span></label>
                        <input type="time" class="form-control" id="D2ctime">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="myMulti" class="d-block_">Select Group <span>*</span></label>
                        <select id="myMulti" class="js-example-basic-multiple w-100" multiple="multiple">
                            <option value="Group 1">Group 1</option>
                            <option value="Group 2">Group 2</option>
                            <option value="Group 3">Group 3</option>
                            <option value="Group 4">Group 4</option>
                            <option value="Group 5">Group 5</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <h5>Select Template</h5> 
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 mb-2"> 
                    <div class="options">
                        <input type="radio" name="bdayposts"  id="d2ctemp1" class="radio_button" checked=""> 
                        <label class="radio_label mb-2" for="d2ctemp1">
                            <div class="card">
                                <div class="card_style">
                                    <h6>HAPPY ANNIVERSARY</h6> 
                                    <p class="mb-0">“Our age is merely the number of years the world has been enjoying us!”</p> 
                                </div>
                            </div> 
                        </label>    
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 mb-2"> 
                    <div class="options">
                        <input type="radio" name="bdayposts"  id="d2ctemp2" class="radio_button"> 
                        <label class="radio_label mb-2" for="d2ctemp2">
                            <div class="card">
                                <div class="card_style">
                                   <h6>HAPPY ANNIVERSARY</h6> 
                                    <p class="mb-0">“Our age is merely the number of years the world has been enjoying us!”</p> 
                                </div>
                            </div> 
                        </label>    
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 mb-2"> 
                    <div class="options">
                        <input type="radio" name="bdayposts"  id="d2ctemp3" class="radio_button"> 
                        <label class="radio_label mb-2" for="d2ctemp3">
                            <div class="card">
                                <div class="card_style">
                                   <h6>HAPPY ANNIVERSARY</h6> 
                                    <p class="mb-0">“Our age is merely the number of years the world has been enjoying us!”</p> 
                                </div>
                            </div> 
                        </label>    
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 mb-2"> 
                    <div class="options">
                        <input type="radio" name="bdayposts"  id="d2ctemp4" class="radio_button"> 
                        <label class="radio_label mb-2" for="d2ctemp4">
                            <div class="card">
                                <div class="card_style">
                                   <h6>HAPPY ANNIVERSARY</h6> 
                                    <p class="mb-0">“Our age is merely the number of years the world has been enjoying us!”</p> 
                                </div>
                            </div> 
                        </label>    
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 mb-2"> 
                    <div class="options">
                        <input type="radio" name="bdayposts"  id="d2ctemp5" class="radio_button"> 
                        <label class="radio_label mb-2" for="d2ctemp5">
                            <div class="card">
                                <div class="card_style">
                                   <h6>HAPPY ANNIVERSARY</h6> 
                                    <p class="mb-0">“Our age is merely the number of years the world has been enjoying us!”</p> 
                                </div>
                            </div> 
                        </label>    
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 mb-2"> 
                    <div class="options">
                        <input type="radio" name="bdayposts"  id="d2ctemp6" class="radio_button"> 
                        <label class="radio_label mb-2" for="d2ctemp6">
                            <div class="card">
                                <div class="card_style">
                                   <h6>HAPPY ANNIVERSARY</h6> 
                                    <p class="mb-0">“Our age is merely the number of years the world has been enjoying us!”</p> 
                                </div>
                            </div> 
                        </label>    
                    </div>
                </div>               
            </div>
        </div>
        <div class="modal-footer my-0">
            <button type="button" class="btn btn-primary">Save</button>
        </div>
        
      </div>
      
    </div>
  </div>
</div>



@endsection

@section('end_body')
<!-- <script src="{{ asset('assets/plugin/multiselect/js/multiselect.js') }}"></script> -->
<script src="{{ asset('assets/plugin/select2/js/select2.full.js') }}"></script>
<script>
$(function()
{
  $(".js-example-basic-multiple").select2();
});
</script>
<!-- <script src="https://harvesthq.github.io/chosen/chosen.jquery.js"></script> 
<script>
    document.getElementById('output').innerHTML = location.search;
    $(".chosen-select").chosen();
</script>-->
<script src="{{ asset('assets/js/daterangepicker.js') }}"></script>


@endsection