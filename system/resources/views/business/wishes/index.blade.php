@extends('layouts.business')

@section('title', 'Personalised Messaging: Business Panel')

@section('head')
<div class="section-header">
    <h1>Personalised Messaging</h1>

    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">Business</a></div>
        <div class="breadcrumb-item">Personalised Messaging</div>
    </div>
</div>
@endsection

@section('end_head')
@section('end_head')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugin/quill/quill.snow.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugin/quill/quill.emoji.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}" rel="stylesheet">

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

    .frst_preview{
        position: relative;
        width: 100%;
    }
    .frst_preview .remove_btn{
        position: absolute;
        top: -5px;
        right: -5px;
        width: 20px;
        height: 20px;
        line-height: 20px;
        font-size: 14px;
        /* display: inline-block; */
        border-radius: 50%;
        text-align: center;
        color: #ffffff;
        background-color: var(--danger);
        cursor: pointer;
        display: none;
    }
</style>
@endsection

@section('content')
<section class="section">
    <div class="section-body">
        <!-- DOB section -->
        <div class="card">
            <div class="card-header justify-content-between">
                <h4 class="d-inline"><i class="fas fa-birthday-cake mr-2"></i> Personalised Birthday Wishes</h4>
                <div>
                    {{-- ON / OFF toggle button  --}}
                    <label class="custom-switch pl-2" data-toggle="tooltip" title="On / Off Automated greeting message to customers on their Birthday" >
                        <span class="bday_toggle_on mr-2" style="color: green;font-weight: 600;">ON</span>
                        <span class="bday_toggle_off mr-2" style="color: red;font-weight: 600;">OFF</span>
                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input dob-switch" id="">
                        <span class="custom-switch-indicator"></span>
                    </label>
                </div>

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div>
                            <h6 class="">Be with your customer on their special day!</h6>
                            <p class="text-black-50"  style="line-height: 20px;">Use MouthPublicity's WhatsApp template to greet your customer on their special day. Create a special birthday greeting for your customer and send it easily on their WhatsApp through MouthPublicity</p>
                            <p>You can use <b>[name]</b> and <b>[mobile]</b> following variables to create your customise WhatsApp Message.</p>
                        </div>
                        <div>

                            <div class="form-group mb-0">
                                <label class="text-primary mb-0">Choose Media <small class="text-dark">(Optional)</small> </label>
                                <div class="small mb-2">Select <span class="text-danger">JPG</span> or <span class="text-danger">JPEG</span> image, Max file size <span class="text-danger">2MB</span>, and Max image width <span class="text-danger">1024px</span>. For video select <span class="text-danger">MP4</span> with maximum <span class="text-danger">10MB</span> file size.</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="mb-3 form-group">
                                        <div class="custom-file">
                                            <input type="file" name="file" class="custom-file-input media_selector" data-preview="#dob_message_media" id="BD_WA_MEDIA" accept="image/jpeg, video/mp4">
                                            <label class="custom-file-label" for="BD_WA_MEDIA">Choose file</label>
                                        </div>
                                        <small class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-4 pl-sm-0">
                                    <div class="frst_preview">
                                        <div id="dob_message_media_small"></div>
                                        <span class="remove_btn" data-main="#BD_WA_MEDIA" data-toggle="tooltip" title="Remove Media">X</span>
                                    </div>
                                </div>
                            </div>

                            <!-- WhatsApp Editor -->
                            <div class="form-group mb-0">
                                <label class="text-primary">Message <span class="text-danger">*</span> </label>
                            </div>
                            <div class="position-relative">
                                <div class="wa-editor-area">
                                    <div class="wa-editor" id="BD_wa_editor" style="height: 170px;"></div>
                                    <button class="btn-post-wa trigger--fire-modal-4" id="post-dob" data-toggle="tooltip" title="Preview Message">Save Wish</button>
                                </div>
                            </div>
                            <!-- WhatsApp Editor End -->
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="mb-3">
                                    <h6 class="text-primary">Birthday Message Preview</h6>
                                </div>
                                <div>
                                    <div class="conversation">
                                        <div class="conversation-container pt-5 pb-3 rounded">
                                            <div class="message sent">
                                                <div id="dob_message_media" class="media-section"></div>
                                                <div id="dobmessaage_preview"></div>
                                                <span class="metadata">
                                                    <span class="time"></span>
                                                    <span class="tick"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" id="msg-dblcheck-ack" x="2063" y="2076"><path d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.88a.32.32 0 0 1-.484.032l-.358-.325a.32.32 0 0 0-.484.032l-.378.48a.418.418 0 0 0 .036.54l1.32 1.267a.32.32 0 0 0 .484-.034l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.88a.32.32 0 0 1-.484.032L1.892 7.77a.366.366 0 0 0-.516.005l-.423.433a.364.364 0 0 0 .006.514l3.255 3.185a.32.32 0 0 0 .484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z" fill="#4fc3f7"/></svg></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            {{-- <div class="mt-4 text-right">
                                <a href="#" class="btn btn-info px-4" data-toggle="tooltip" title="List of all the customers who have Birthday today.">Today's List</a>
                            </div> --}}
                        </div>

                    </div>
                </div>
           </div> 
        </div> 
        <!-- DOB-section end -->

        <!-- anniversary section -->
        <div class="card">
            <div class="card-header justify-content-between">
                <h4><i class="fas fa-heart mr-2"></i> Personalised Anniversary Wishes</h4>
                <div>
                    {{-- ON / OFF toggle button  --}}
                    <label class="custom-switch pl-2" data-toggle="tooltip" title="On / Off Automated greeting message to customers on their Anniversary" >
                        <span class="anni_toggle_on mr-2" style="color: green;font-weight: 600;">ON</span>
                        <span class="anni_toggle_off mr-2" style="color: red;font-weight: 600;">OFF</span>
                        <input type="checkbox" name="Anniversary" class="custom-switch-input anniversary-switch" id="">
                        <span class="custom-switch-indicator"></span>
                    </label>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div>
                            <h6 class="">Be with your customer on their special day!</h6>
                            <p class="text-black-50"  style="line-height: 20px;">Use MouthPublicity's WhatsApp template to greet your customer on their special day. Create a special anniversary greeting for your customer and send it easily on their WhatsApp through MouthPublicity</p>
                            <p>You can use <b>[name]</b> and <b>[mobile]</b> following variables to create your customise WhatsApp Message.</p>
                        </div>
                        <div>

                            <div class="form-group mb-0">
                                <label class="text-primary mb-0">Choose Media <small class="text-dark">(Optional)</small> </label>
                                <div class="small mb-2">Select <span class="text-danger">JPG</span> or <span class="text-danger">JPEG</span> image, Max file size <span class="text-danger">2MB</span>, and Max image width <span class="text-danger">1024px</span>. For video select <span class="text-danger">MP4</span> with maximum <span class="text-danger">10MB</span> file size.</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="mb-3 form-group">
                                        <div class="custom-file">
                                            <input type="file" name="file" class="custom-file-input media_selector" data-preview="#ani_message_media" id="AN_WA_MEDIA" accept="image/jpeg, video/mp4">
                                            <label class="custom-file-label" for="AN_WA_MEDIA">Choose file</label>
                                        </div>
                                        <small class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-4 pl-sm-0">
                                    <div class="frst_preview">
                                        <div id="ani_message_media_small"></div>
                                        <span class="remove_btn" data-main="#AN_WA_MEDIA" data-toggle="tooltip" title="Remove Media">X</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- WhatsApp Editor -->
                            <div class="form-group mb-0">
                                <label class="text-primary">Message <span class="text-danger">*</span> </label>
                            </div>
                            <div class="position-relative">
                                <div class="wa-editor-area">
                                    <div class="wa-editor" id="AN_wa_editor" style="height: 170px;"></div>
                                    <button class="btn-post-wa trigger-fire-modal-4" id="post-ani" data-toggle="tooltip" title="Save Message">Save Wish</button>
                                </div>
                            </div>
                             <!-- WhatsApp Editor End -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="mb-3">
                                    <h6 class="text-primary">Anniversary Message Preview</h6>
                                </div>
                                <div>
                                    <div class="conversation">
                                        <div class="conversation-container pt-5 pb-3 rounded">
                                            <div class="message sent">
                                                <div id="ani_message_media" class="media-section"></div>
                                                <div id="animessaage_preview"></div> 
                                                <span class="metadata">
                                                    <span class="time"></span>
                                                    <span class="tick"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" id="msg-dblcheck-ack" x="2063" y="2076"><path d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.88a.32.32 0 0 1-.484.032l-.358-.325a.32.32 0 0 0-.484.032l-.378.48a.418.418 0 0 0 .036.54l1.32 1.267a.32.32 0 0 0 .484-.034l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.88a.32.32 0 0 1-.484.032L1.892 7.77a.366.366 0 0 0-.516.005l-.423.433a.364.364 0 0 0 .006.514l3.255 3.185a.32.32 0 0 0 .484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z" fill="#4fc3f7"/></svg></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <!-- anniversary section end -->

        <!-- festival section -->
        <div class="card" >
            <div class="card-header justify-content-between">
                <h4><i class="fas fa-star mr-2"></i> Personalised Festival Wishes</h4>
                <div>
                    {{-- ON / OFF toggle button  --}}
                    <label class="custom-switch pl-2" data-toggle="tooltip" title="On / Off Automated greeting message to customers on the festival Day" >
                        <span class="festival_toggle_on mr-2" style="color: green;font-weight: 600;">ON</span>
                        <span class="festival_toggle_off mr-2" style="color: red;font-weight: 600;">OFF</span>
                        <input type="checkbox" name="festival" class="custom-switch-input festival-switch" id="">
                        <span class="custom-switch-indicator"></span>
                    </label>
                </div>
            </div>    
            <div class="card-body">
                <!--<p>You can use <b>[name]</b> and <b>[mobile]</b> following variables to create your customise WhatsApp Message.</p>-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="festival_head d-inline">
                            <div class="row">
                                <div class="form-group col-7">
                                    <label>Festival Name <span class="text-danger">*</span></label>
                                    <input type="text" id="festival_name" name="festival_name" class="form-control" required>
                                </div>
                                <div class="form-group col-5">
                                    <label>Festival Date <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" id="festival_date" name="festival_date" autocomplete="off" class="form-control schedule-date" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <label class="text-primary mb-0">Choose Media <small class="text-dark">(Optional)</small> </label>
                                        <div class="small mb-2">Select <span class="text-danger">JPG</span> or <span class="text-danger">JPEG</span> image, Max file size <span class="text-danger">2MB</span>, and Max image width <span class="text-danger">1024px</span>. For video select <span class="text-danger">MP4</span> with maximum <span class="text-danger">10MB</span> file size.</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="mb-4 form-group">
                                        <div class="custom-file">
                                            <input type="file" name="file" class="custom-file-input media_selector" data-preview="#fest_message_media" id="FT_WA_MEDIA" accept="image/jpeg, video/mp4">
                                            <label class="custom-file-label" for="FT_WA_MEDIA">Choose file</label>
                                        </div>
                                        <small class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-4 pl-sm-0">
                                    <div class="frst_preview">
                                        <div id="fest_message_media_small"></div>
                                        <span class="remove_btn" data-main="#FT_WA_MEDIA" data-toggle="tooltip" title="Remove Media">X</span>
                                    </div>
                                </div>
                            </div>
                            

                        </div>

                        <div>
                            <!-- WhatsApp Editor -->
                            <div class="form-group mb-0">
                                <label class="text-primary">Message <span class="text-danger">*</span> </label>
                            </div>
                            <div class="position-relative" id="festi_editor">
                                <div class="wa-editor-area">
                                    <div class="wa-editor" id="FS_wa_editor" style="height: 170px;"></div>
                                    <button class="btn-post-wa trigger-fire-modal-4" id="post-festi" data-toggle="tooltip" title="Save Message"> Save Wish</button>
                                </div>
                            </div>
                            <!-- WhatsApp Editor End -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div>
                                    <h6 class="mb-4 text-primary">Festival Message Preview</h6>
                                </div>
                                <div>
                                    <div class="conversation">
                                        <div class="conversation-container pt-5 pb-3 rounded">
                                            <div class="message sent">
                                                <div id="fest_message_media" class="media-section"></div>
                                                <div id="festimessaage_preview"></div> 
                                                <span class="metadata">
                                                    <span class="time"></span>
                                                    <span class="tick"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" id="msg-dblcheck-ack" x="2063" y="2076"><path d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.88a.32.32 0 0 1-.484.032l-.358-.325a.32.32 0 0 0-.484.032l-.378.48a.418.418 0 0 0 .036.54l1.32 1.267a.32.32 0 0 0 .484-.034l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.88a.32.32 0 0 1-.484.032L1.892 7.77a.366.366 0 0 0-.516.005l-.423.433a.364.364 0 0 0 .006.514l3.255 3.185a.32.32 0 0 0 .484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z" fill="#4fc3f7"/></svg></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="text-right">
                                <a href="#" class="btn btn-info px-4"> Today's List</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <!-- festival section end -->
        

    </div>
</section>
@endsection
@section('end_body')

<script src="{{ asset('assets/plugin/quill/quill.editor.js')}}"></script>
<script src="{{ asset('assets/plugin/quill/quill.emoji.js')}}"></script>
<script src="{{ asset('assets/js/daterangepicker.js') }}"></script>

<script>
    var media_selector = $(".media_selector");
    var allowed_ext = ['jpeg', 'jpg', 'mp4'];
    var allowed_file = ['image', 'video'];

    $(document).ready(function() {

        var fname, fsize, fpath, fext, ftype;

        media_selector.on("change", function(evnt){

            var media = evnt.target.files[0];

            $(this).parent('div.custom-file').next().remove('span');

            var pre_media = $($(this).data('preview'));
            pre_media.empty();
            
            var pre_media_small = $($(this).data('preview') + '_small');
            pre_media_small.empty().next('span.remove_btn').hide();

            if(evnt.target.files.length > 0){
                let mediaOK = true;
                let mediaError = '';
                
                fpath = (window.URL || window.webkitURL).createObjectURL(media); // Path
                fext = media.name.split('.').pop(); // extension
                fsize = media.size / 1024 / 1024; // size in MB
                ftype = media.type;
                ftype = ftype.substr(0, ftype.indexOf("/")).toLowerCase(); // type
                /* Validations */
                if(allowed_file.indexOf(ftype) >= 0){
                    if (allowed_ext.indexOf(fext) == -1) {
                        mediaOK = false;
                        mediaError += ' "'+fext.toUpperCase()+'" this file extension are not allowed. Only '+allowed_ext.join(', ').toUpperCase()+' are allowed. ';
                    }
                    if(ftype == 'video' && fsize > 10){
                        mediaOK = false;
                        mediaError += 'Video file size should be less than equals to 10 MB. ';
                    }
                    if(ftype == 'image' && fsize > 1.5){
                        mediaOK = false;
                        mediaError += 'Image file size should be less than equals to 1.5 MB. ';
                    }
                }else{
                    mediaOK = false;
                    mediaError += 'Only '+allowed_file.join(', ').toUpperCase()+' file types are allowed. ';
                }

                if(mediaOK){
                    let reader = new FileReader();
                    reader.readAsDataURL(media);
                    reader.onloadend = function(evt){
                        if (evt.target.readyState == FileReader.DONE){
                            
                            let tmpElement;
                            //# if IMAGE...
                            if ( ftype == "image" ){
                                tmpElement = $('<img />', {
                                                class: 'img-fluid',
                                                alt: ''
                                            });
                            }
                            //# if VIDEO...
                            if ( ftype == "video" ){
                                tmpElement = $('<video />', {
                                                class: 'img-fluid',
                                                type: 'video/mp4',
                                                controls: true
                                            });
                            }

                            tmpElement.attr("src", fpath);

                            pre_media.html(tmpElement);
                            pre_media_small.html(pre_media.html()).next('span.remove_btn').show();
                        }
                    }
                }else{
                    $('<span class="text-danger small">'+mediaError+'</span>').insertAfter($(this).parent('div.custom-file'))
                    media_selector.val('');
                    pre_media.html('');
                    pre_media_small.html('').next('span.remove_btn').hide();
                }
            }
        });


        $('.remove_btn').on('click', function() {
            var main = $(this).data('main');
            $(main).val('');  /* Empty input */

            var pre_media = $($(main).data('preview')); 
            pre_media.empty(); /* Empty main preview */
            
            var pre_media_small = $($(main).data('preview') + '_small');
            pre_media_small.empty().next('span.remove_btn').hide(); /* Empty first preview */

        });
    });
</script>

<script type="text/javascript">
    var toolbarOptions = {
      modules: {
        "toolbar": {
          container: [
            ['bold', 'italic', 'strike'],
            ['clean'],
            ['emoji'],
          ]
        },
        "emoji-toolbar": true,
        "emoji-shortname": false,
        "emoji-textarea": false
      },
      placeholder: 'Compose an epic...',
      theme: 'snow',
    }

    var quill_BD = new Quill('#BD_wa_editor', toolbarOptions);
    var quill_AN = new Quill('#AN_wa_editor', toolbarOptions);
    var quill_FS = new Quill('#FS_wa_editor', toolbarOptions);
</script>

<script>
    $(document).ready(function() {
        $(".ql-formats button").each(function(){
            var name = $(this).attr('class').split('-');
            $(this).attr('data-bs-toggle', 'tooltip').attr('title', name[1].toLowerCase().replace(/\b(\w)/g, s => s.toUpperCase()));
        });

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>

<!-- for conversion of tags -->

<script type="text/javascript">

    /* get html text format like wa message */
    function addWsNodes(s) {
        var waFormat = s;
        waFormat = waFormat.replaceAll("<strong>", " <strong>").replaceAll("</strong>", "</strong> ").replaceAll("<b>", " <b>").replaceAll("</b>", "</b> ");
        waFormat = waFormat.replaceAll("<em>", " <em>").replaceAll("</em>", "</em> ").replaceAll("<i>", " <i>").replaceAll("</i>", "</i> ");
        waFormat = waFormat.replaceAll("<s>", " <s>").replaceAll("</s>", "</s> ").replaceAll("<strike>", " <strike>").replaceAll("</strike>", "</strike> ");
        return waFormat;
    }
    /* END -- get html text format like wa message */


    /* get html to wa message format */
    function prepareFormattedContent(htmlContent) {
        var waFormat = htmlContent
        var trimSpace = $('<div></div>').html(waFormat);
        $(trimSpace).find('strong, b, i, em, s, del, p').each(function(i,v) {
            var $elem = $(this).html();
            $(this).html($elem.trim());
            waFormat = waFormat.replace($elem, v.innerHTML);
        });
        waFormat = waFormat.replace(/&nbsp;/gi," ").replace(/&amp;/gi,"&").replace(/&quot;/gi,'"').replace(/&lt;/gi,'<').replace(/&gt;/gi,'>');
        waFormat = waFormat.replace(/<b [^>]*>/mgi, ' *').replace(/<\/b>/mgi, '* ');
        waFormat = waFormat.replace(/<strong[^>]*>/mgi, ' *').replace(/<\/strong>/mgi, '* ');
        waFormat = waFormat.replace(/<i[^>]*>/mgi, ' _').replace(/<\/i>/mgi, '_ ');
        waFormat = waFormat.replace(/<em[^>]*>/mgi, ' _').replace(/<\/em>/mgi, '_ ');
        waFormat = waFormat.replaceAll('<s>', ' ~').replace(/<s [^>]*>/mgi, ' ~').replace(/<\/s>/mgi, '~ ');
        waFormat = waFormat.replace(/<strike[^>]*>/mgi, ' ~').replace(/<\/strike>/mgi, '~ ');
        waFormat = waFormat.replace(/<del[^>]*>/mgi, ' ~').replace(/<\/del>/mgi, '~ ');
        waFormat = waFormat.replaceAll('<p> ', '<p>').replace('<div> ', '<div>');
        waFormat = waFormat.replace(/<\/p[^>]*>/mgi, '\n').replace(/<\/div[^>]*>/mgi, '\n');
        waFormat = waFormat.replace(/(<([^>]+)>)/mgi, "");
        waFormat = waFormat.replaceAll("_ *", "_*")
                            .replaceAll("* _", "*_")
                            .replaceAll("~ _", "~_")
                            .replaceAll("_ ~", "_~")
                            .replaceAll("* ~", "*~")
                            .replaceAll("~ *", "~*");
        waFormat.trim();

        return waFormat;
    }
    /* END - get html to wa message format */
  
    function showValidationPop(validation,message){
        
        Swal.fire({
            title: '<strong>'+message+'</strong>',
            icon: 'info',
            html:
                'Please Subscribe to our plans.',
            showCloseButton: true,
            showCancelButton: false,
            focusConfirm: false,
            confirmButtonText: 'Please Upgrade',
        }).then(function(data) { console.log(data);
                if(data.dismiss=='close' || data.dismiss=='backdrop'){
                }else{
                    window.location = '{{ route('business.plan') }}';
                }
        });
    }


    /*for Perview*/
    /*Date of brith*/

    $(document).ready(function(){
        
        @php
        
        $fest_date = $fest_html = $fest_title = $fest_attachment = $ani_attachment = $dob_attachment = '';
        $extArr = ['jpg','jpeg','mp4'];
        if(!empty($whatsappTemplates)){
            foreach ($whatsappTemplates as $whatsappTemplate){
                if($whatsappTemplate->template_type=='birthday'){
                    
                    if(!empty($whatsappTemplate->template_content)){
                        $dob_html = addslashes($whatsappTemplate->template_content);
                    }
                    $dob_id = $whatsappTemplate->id;
                    $dob_status = $whatsappTemplate->send_wish;
                    $dob_attachment_url = $whatsappTemplate->attachment_url;
                    $extension = pathinfo($dob_attachment_url, PATHINFO_EXTENSION);
                    if($extension == 'mp4'){
                        $dob_attachment = '<video class="img-fluid" controls="controls"  src="'.$dob_attachment_url.'" />';
                    }else if($extension == 'jpg' || $extension == 'jpeg'){
                        $dob_attachment = '<img class="img-fluid" src="'.$dob_attachment_url.'" />';
                    }
                }else if($whatsappTemplate->template_type=='anniversary'){
                
                    if(!empty($whatsappTemplate->template_content)){
                        $ani_html = addslashes($whatsappTemplate->template_content);
                    }
                    $ani_id = $whatsappTemplate->id;
                    $ani_status = $whatsappTemplate->send_wish;
                    $ani_attachment_url = $whatsappTemplate->attachment_url;
                    $extension = pathinfo($ani_attachment_url, PATHINFO_EXTENSION);
                    if($extension == 'mp4'){
                        $ani_attachment = '<video class="img-fluid" controls="controls"  src="'.$ani_attachment_url.'" />';
                    }else if($extension == 'jpg' || $extension == 'jpeg'){
                        $ani_attachment = '<img class="img-fluid" src="'.$ani_attachment_url.'" />';
                    }
                }else if($whatsappTemplate->template_type=='festival'){
                
                    if(!empty($whatsappTemplate->template_content)){
                        $fest_title = $whatsappTemplate->title;
                        $fest_html = addslashes($whatsappTemplate->template_content);
                        
                        $schedule_date_recent = isset($whatsappTemplate->festival_date) ? $whatsappTemplate->festival_date : ''; //dd($schedule_date_recent);
                        
                        $fest_date = date('Y-m-d 12:00 a',strtotime('+1 days'));

                        if(!empty($schedule_date_recent)){
                            if(strtotime(date('Y-m-d',strtotime($schedule_date_recent))) > strtotime(date('Y-m-d'))){
                                $fest_date = date('Y-m-d h:i a',strtotime($schedule_date_recent));
                            }
                        }
                        
                        $fest_attachment_url = $whatsappTemplate->attachment_url;
                        $extension = pathinfo($fest_attachment_url, PATHINFO_EXTENSION);
                        if($extension == 'mp4'){
                            $fest_attachment = '<video class="img-fluid" controls="controls"  src="'.$fest_attachment_url.'" />';
                        }else if($extension == 'jpg' || $extension == 'jpeg'){
                            $fest_attachment = '<img class="img-fluid" src="'.$fest_attachment_url.'" />';
                        }
                    }else{
                        $fest_date = date('Y-m-d 12:00 a',strtotime('+1 days'));
                    }
                    $fest_id = $whatsappTemplate->id;
                    $fest_status = $whatsappTemplate->send_wish;
                }
            }
        }
        
        $startDate = date('Y-m-d',strtotime("+ 1 day"));
        @endphp
        
        var check = Date.parse("{!! $fest_date !!}");
        var schedule_date = "{!! $fest_date !!}";
        $('.schedule-date').daterangepicker({
            minDate: moment('{{ $startDate }}').startOf('hour'),
            startDate: moment(check),
            singleDatePicker: true,
            timePicker: true,
            timePicker24Hour: false,
            locale: {
                format: 'YYYY-MM-DD hh:mm a'
            }
        });
        
        var dob_attachment = '{!! $dob_attachment !!}';
        if(dob_attachment != ''){
            $('#dob_message_media').html(dob_attachment);
            $('#dob_message_media_small').html(dob_attachment).next('span.remove_btn').show();
        }
        
        var ani_attachment = '{!! $ani_attachment !!}';
        if(ani_attachment != ''){
            $('#ani_message_media').html(ani_attachment);
            $('#ani_message_media_small').html(ani_attachment).next('span.remove_btn').show();
        }
        
        var fest_attachment = '{!! $fest_attachment !!}';
        if(fest_attachment != ''){
            $('#fest_message_media').html(fest_attachment);
            $('#fest_message_media_small').html(fest_attachment).next('span.remove_btn').show();
        }
        
        
        // Date of birth pre defined data
        var dob_html = '{!! $dob_html !!}';
        quill_BD.root.innerHTML = dob_html; // saved data set to editor data
        if(dob_html != ''){
            dob_html = addWsNodes(dob_html);
        }
        $('#dobmessaage_preview').html(dob_html); // preview data
        
        var dob_id = {{ $dob_id }};
        $('.dob-switch').attr('id',dob_id);
        
        var dob_status = '{{ $dob_status }}';
        if(dob_status == '1'){
            $('.dob-switch').prop('checked', true);
            $('.bday_toggle_on').css('display','block');
            $('.bday_toggle_off').css('display','none');
        }else{
            $('.dob-switch').prop('checked', false);
            $('.bday_toggle_on').css('display','none');
            $('.bday_toggle_off').css('display','block');
        }
        
        var customisedWishing = '{{$planData["customised_wishing"]}}';
        var purchaseHistory = '{{$purchaseHistory}}';
        if(purchaseHistory>0){
            var customiseWishingValidationMsg = 'Your Customised Wishing Plan Has Expired';
        }else{
            var customiseWishingValidationMsg = 'Please Purchase Customised Wishing Plan';
        }
        //var customisedWishing = 0;

        // Annivercery pre defined data
        var ani_html = '{!! $ani_html !!}';
        quill_AN.root.innerHTML = ani_html; // saved data set to editor data
        if(ani_html != ''){
            ani_html = addWsNodes(ani_html);
        }
        $('#animessaage_preview').html(ani_html); // preview data
        
        var ani_id = {{ $ani_id }};
        $('.anniversary-switch').attr('id',ani_id);

        var ani_status = '{{ $ani_status }}';
        if(ani_status == '1'){
            $('.anniversary-switch').prop('checked', true);
            $('.anni_toggle_on').css('display','block');
            $('.anni_toggle_off').css('display','none');
        }else{
            $('.anniversary-switch').prop('checked', false);
            $('.anni_toggle_on').css('display','none');
            $('.anni_toggle_off').css('display','block');
        }
        
        // Festival pre defined data
        var fest_html = '{!! $fest_html !!}';
        quill_FS.root.innerHTML = fest_html;
        if(fest_html != ''){
            fest_html = addWsNodes(fest_html);
        }
        $('#festimessaage_preview').html(fest_html);
        $('#festival_name').val('{{ $fest_title }}');
        $('#festival_date').val('{{ $fest_date }}');
        
        var fest_id = {{ $fest_id }};
        $('.festival-switch').attr('id',fest_id);

        var fest_status = '{{ $fest_status }}';
        if(fest_status == '1'){
            $('.festival-switch').prop('checked', true);
            $('.festival_toggle_on').css('display','block');
            $('.festival_toggle_off').css('display','none');
        }else{
            $('.festival-switch').prop('checked', false);
            $('.festival_toggle_on').css('display','none');
            $('.festival_toggle_off').css('display','block');
        }


        /* Date of Birth*/
        $("#post-dob").on('click', function() {
            var getcontent = quill_BD.root.innerHTML;
            var returndata = prepareFormattedContent(getcontent);
            $("#dobmessaage_preview").html(addWsNodes(getcontent));
            let title = 'birthday';
            let type = 'birthday';
            if (!document.getElementById("BD_WA_MEDIA").value) {
                $('#dob_message_media').html('');
            }
            if(customisedWishing==0){
                showValidationPop('customisedWishingNotEnabled',customiseWishingValidationMsg);
            }else{
                saveTemplate(title,type,getcontent,returndata);
            }
        });
        /*anniversary*/
        $("#post-ani").on('click', function() {
            var getcontent = quill_AN.root.innerHTML ;
            var returndata = prepareFormattedContent(getcontent);
            $("#animessaage_preview").html(addWsNodes(getcontent));
            let title = 'anniversary';
            let type = 'anniversary';
            if (!document.getElementById("AN_WA_MEDIA").value) {
                $('#ani_message_media').html('');
            }
            if(customisedWishing==0){
                showValidationPop('customisedWishingNotEnabled',customiseWishingValidationMsg);
            }else{
                saveTemplate(title,type,getcontent,returndata);
            }
            
        });
        /*festival*/
         $("#post-festi").on('click', function() {
            var getcontent = quill_FS.root.innerHTML ;
            var returndata = prepareFormattedContent(getcontent);
            $("#festimessaage_preview").html(addWsNodes(getcontent));
            let title = $('#festival_name').val();
            let type = 'festival';
            let festival_date = $('#festival_date').val();
            
            if (!document.getElementById("FT_WA_MEDIA").value) {
                $('#fest_message_media').html('');
            }
            
            if(customisedWishing==0){
                showValidationPop('customisedWishingNotEnabled',customiseWishingValidationMsg);
            }else{
                saveTemplate(title,type,getcontent,returndata,festival_date);
            }
        });
        
        
        function saveTemplate(title,type,getcontent,returndata,festival_date='') {
            returndata = returndata.trim();
            if(getcontent == '' || returndata == ''){
                Sweet('error','Post message can not be blank.');
                return false;
            }
            
            var festivalSwitch = '';
            if(type=='festival'){
                $("#overlay").fadeIn(300);
                var file_data = $("#FT_WA_MEDIA").prop("files")[0];
                var festivalSwitch = $('.festival-switch').is(':checked');
            }else if(type=='birthday'){
                var file_data = $("#BD_WA_MEDIA").prop("files")[0];
            }else if(type=='anniversary'){
                var file_data = $("#AN_WA_MEDIA").prop("files")[0];
            }
            
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            var form_data = new FormData();
            form_data.append("file", file_data);
            form_data.append("title", title);
            form_data.append("type", type);
            form_data.append("festival_date", festival_date);
            form_data.append("template_content", getcontent);
            form_data.append("whatsapp_content", returndata);
            form_data.append("festival_switch", festivalSwitch);
            form_data.append("_token", CSRF_TOKEN);
            
            $.ajax({
                url : '{{ route('business.saveWaTemplate') }}',
                type : 'POST',
                data : form_data,
                dataType : "json",
                cache: false,
                contentType: false,
                processData: false,
                success : function(response) {
                    if(response.success == true){
                        Sweet('success',response.message);
                    }else{
                        Sweet('error',response.message);
                    }
                    $("#overlay").fadeOut(300);
                },
                error: function(xhr, status, error) 
                {
                    $.each(xhr.responseJSON.errors, function (key, item) 
                    {
                        Sweet('error',item)
                        $("#errors").html("<li class='text-danger'>"+item+"</li>")
                    });
                    $("#overlay").fadeOut(300);
                }
            });
        }
        
        
        function switchWishing(send_wish,id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var input = {
                "send_wish" : send_wish,
                "wish_id" : id,
                "_token" : CSRF_TOKEN
            };
            $.ajax({
                url : '{{ route('business.changeWishStatus') }}',
                type : 'POST',
                data : input,
                dataType : "json",
                success : function(response) {
                    if(response.success == true){
                        console.log(response);
                        if(response.send_wish == '1' && response.template_type == 'anniversary'){
                            $('.anni_toggle_on').css('display','block');
                            $('.anni_toggle_off').css('display','none');
                        }else if(response.send_wish == '0' && response.template_type == 'anniversary'){
                            $('.anni_toggle_on').css('display','none');
                            $('.anni_toggle_off').css('display','block');
                        }

                        if(response.send_wish == '1' && response.template_type == 'birthday'){
                            $('.bday_toggle_on').css('display','block');
                            $('.bday_toggle_off').css('display','none');
                        }else if(response.send_wish == '0' && response.template_type == 'birthday'){
                            $('.bday_toggle_on').css('display','none');
                            $('.bday_toggle_off').css('display','block');
                        }

                        if(response.send_wish == '1' && response.template_type == 'festival'){
                            $('.festival_toggle_on').css('display','block');
                            $('.festival_toggle_off').css('display','none');
                        }else if(response.send_wish == '0' && response.template_type == 'festival'){
                            $('.festival_toggle_on').css('display','none');
                            $('.festival_toggle_off').css('display','block');
                        }

                        Sweet('success',response.message);
                    }else{
                        Sweet('error',response.message);
                    }
                },
                error: function(xhr, status, error) 
                {
                    $.each(xhr.responseJSON.errors, function (key, item) 
                    {
                        Sweet('error',item)
                        $("#errors").html("<li class='text-danger'>"+item+"</li>")
                    });
                }
            });
        }
        

        $(document).on('change', '.custom-switch-input', function(){
            
            if(customisedWishing==0){
                showValidationPop('customisedWishingNotEnabled',customiseWishingValidationMsg);
                $(this).prop('checked',false);
                return false;
            }
            
            var send_wish = $(this).is(':checked');
            var id = $(this).attr('id');
            
            if($(this).hasClass('festival-switch')){

                if(send_wish==false){
                    Swal.fire({
                      title: 'Are you sure?',
                      text: "You won't be able to revert this!",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes, Cancel it!',
                      cancelButtonText: 'Not Now'
                    }).then((result) => {
                        if (result.value) {
                            $(this).prop('checked',false);
                            switchWishing(send_wish,id);
                            $('#festival_name').val('');
                            $('#festival_date').val('');
                            $('#festimessaage_preview').html('');
                            $('#fest_message_media').html('');
                            quill_FS.root.innerHTML = '';
                        }else{
                            $(this).prop('checked',true);
                        }
                    });
                }else{ $(this).prop('checked',true);
                    switchWishing(send_wish,id);
                }
                
            }else{
                switchWishing(send_wish,id);
            }
            
            
        
        });
    });
   
</script>
@endsection