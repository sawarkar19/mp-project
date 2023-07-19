@extends('layouts.business')

@section('title', 'Import Contacts: Business Panel')

@section('end_head')
<style>
    .dargdrop-zone{
        position: relative;
        width: 100%;
        height: 170px;
        border: 2px dashed rgba(0, 0, 0, 0.2);
        margin-bottom: 25px;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        transition: all 300ms ease;
        cursor: pointer;
        background: rgba(255, 255, 255, 0.5);
    }
    .dargdrop-zone p{
        text-align: center;
        color: var(--secondary);
    }
    .dargdrop-zone input{
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        outline: none;
        opacity: 0;
        cursor: pointer;
    }
    .dargdrop-zone:hover{
        border: 2px dashed var(--primary);
    }
    
    .import-section{
        width: 100%;
        max-width: 700px;
        margin: 3rem auto;
        text-align: center;
    }
    
    .steps{
        position: relative;
        display: inline-block;
        width: 35px;
        height: 35px;
        border: 2px solid var(--primary);
        border-radius: 50%;
        text-align: center;
        line-height: 32px;
        font-size: 1rem;
        color: var(--primary);
    }
    
    .ol-alert{
        position: relative;
        padding: 10px 15px;
        border-width: 1px;
        border-style: solid;
        border-color: #272727;
        color: #272727;
        border-radius: 4px;
        background-color: #e3e3e3;
    }
    .ol-alert.ol-a-success{
        background-color: #d0eece;
        border-color:#2c932e;
        color: #2c932e;
    }
    .ol-alert.ol-a-danger{
        background-color: #eecece;
        border-color: #ae2424;
        color: #ae2424;
    }
    
    table.v-align-top tr > td{
        vertical-align: top!important;
    }
</style>
@endsection

@section('head')
    @include('layouts.partials.headersection', ['title'=>'Import Customers'])
@endsection

@section('content')
<section>
    <div class="section">

        <div class="alert alert-danger alert-has-icon">
            <div class="alert-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="alert-body">
              <div class="alert-title mb-0">If one or more customer blocks your number on WhatsApp, you may get permanently blocked by WhatsApp.</div>
              {{-- This is a danger alert. --}}
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card h-100 mb-0">
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="steps">1</span>
                        </div>
                        <div>
                            <h6>Download File</h6>
                        </div>
                        <div>
                            <p class="mb-3">Download the <span class="h6"><code>.xlsx</code></span> Excel file, click the button below.</p>
                            <a href="{{ asset('assets/business/customer-imports/customers.xlsx') }}" download class="btn btn-sm btn-primary px-3">Download File</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100 mb-0">
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="steps">2</span>
                        </div>
                        <div>
                            <h6>Update Data</h6>
                        </div>
                        <div>
                            <p class="mb-3">Fill in your customers' information in a specific column in this file and save it. Make sure the file extension should be <span class="h6"><code>.xlsx</code></span></p>
                            <a href="#" data-toggle="modal" data-target="#excel_info">How to Update File?</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100 mb-0">
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="steps">3</span>
                        </div>
                        <div>
                            <h6>Upload File</h6>
                        </div>
                        <div>
                            <p class="mb-0">Click Upload button after selecting or drag-drop the saved file to Import Contacts section.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row justify-content-center" id="import-main-section">
            <div class="col-md-10 col-lg-8 col-xl-7">

                <div class="import-section">
                    <h5 class="mb-3">Import Contacts</h5>
                    <hr>
                    <form method="POST" enctype="multipart/form-data" id="importCustomers" action="javascript:void(0)">
                        
                        <div class="form-group">
							<label for="group_name" style="float: left;">New Contact Group Name <span style="color: red">*</span></label>
							<input type="text" placeholder="Enter Contact Group Name" name="group_name" id="group_name" class="form-control" value="{{ old('group_name') }}" />
						</div>

                        @if(count($groups) > 0)
                            <p><b>OR</b></p>

                            <div class="form-group">
                                <label for="group_name" style="float: left;">Select From Old Groups <span style="color: red">*</span></label>
                                <select name="old_group" id="old_group"  class="form-control">
                                    <option value="">--Select Group--</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="dargdrop-zone">
                            <input name="customer_list" id="import_file" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                            <p class="mb-0">Drag your files here or click on the area. Only .xlsx file is allowed. <br> <span class="btn btn-sm btn-primary px-3">Browes File</span> </p>
                            <p class="mb-0" id="import_file_text"></p>
                        </div>
                        <button type="submit" class="btn btn-success px-4" id="uploadBtn">Upload</button>
                    </form>
                </div>


                {{-- success section  --}}
                <div class="mb-5" id="success-import" style="display: none;">
                    <div class="ol-alert ol-a-success mb-4">
                        Customer data has been uploaded successfully.
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3 px-1 text-center">
                                    <div class="mb-2 h6" id="successCount">0</div>
                                    <div class="text-small text-success font-weight-bold text-nowrap">Success</div>
                                </div>
                                <div class="col-3 px-1 text-center">
                                    <div class="mb-2 h6" id="failedCount">0</div>
                                    <div class="text-small text-danger font-weight-bold text-nowrap">Failed</div>
                                </div>
                                <div class="col-3 px-1 text-center">
                                    <div class="mb-2 h6" id="repeatedCount">0</div>
                                    <div class="text-small text-warning font-weight-bold text-nowrap">Repeated</div>
                                </div>
                                <div class="col-3 px-1 text-center">
                                    <div class="mb-2 h6" id="totalCount">0</div>
                                    <div class="text-small text-primary font-weight-bold text-nowrap">Total</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{route('business.contactGroups')}}" class="btn btn-primary px-4">View All Customers</a>
                    </div>
                </div>

                {{-- error section  --}}
                <div class="mb-5" id="error-import" style="display: none;">
                    <div class="ol-alert ol-a-danger mb-4">
                        Errors in the import file.<br>
                        Please check below error log (Fix these errors and again Upload the file).
                    </div>
                    <div class="card mb-4">
                        <div class="card-body p-0">
                            <table class="table table-hover table-striped mb-0 v-align-top">
                                <thead>
                                    <tr>
                                        <th>Row Number</th>
                                        <th>Errors List</th>
                                    </tr>
                                </thead>
                                <tbody id="error_list">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
    </div>
</section>


<div class="modal fade" id="excel_info" tabindex="-1" role="dialog" aria-labelledby="excel_infoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-primary" id="excel_infoLabel">How to update excel file?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>In the Excel file, there are four columns WhatsApp number, Customer Name, Date of Birth, and Anniversary Date.</p>

          <table class="table table-bordered table-hover table-md">
            <tr>
                <td>A</td>
                <td>WhatsApp Number</td>
                <td>In this column add 10 digit customer's WhatsApp number</td>
            </tr>
            <tr>
                <td>B</td>
                <td>Customer Name</td>
                <td>In this column add the customer's name</td>
            </tr>
            <tr>
                <td>C</td>
                <td>Date of Birth</td>
                <td>Add the customer's date of birth. Add only date and month in format of (DD-MM)</td>
            </tr>
            <tr>
                <td>D</td>
                <td>Anniversary Date</td>
                <td>Add the customer's anniversary date. Add only date and month in format of (DD-MM)</td>
            </tr>
          </table>

          <p class="mb-0">Check this below example of Excel.</p>
          <img src="{{asset('assets/img/excel-example.jpg')}}" class="img-fluid">
        </div>
      </div>
    </div>
</div>

@endsection

@section('end_body')
<script>
    var media_selector = $("#import_file");
    var media_text = $("#import_file_text");
    var allowed_ext = ['xlsx'];
    var allowed_file = ['application'];
    var allowed_size = 2; // in MB

    $(document).ready(function() {
        var fname, fsize, fpath, fext, ftype;

        media_selector.on("change", function(evnt){
            var media = evnt.target.files[0];

            media_text.empty();
            $(".dargdrop-zone").removeClass("border-danger").removeClass("border-success");

            if(evnt.target.files.length > 0){
                let mediaOK = true;
                let mediaError = '';

                fpath = (window.URL || window.webkitURL).createObjectURL(media); // Path
                fext = media.name.split('.').pop(); // extension
                fsize = media.size / 1024 / 1024; // size in MB
                ftype = media.type;
                ftype = ftype.substr(0, ftype.indexOf("/")).toLowerCase(); // type
                console.table(ftype);
                /* Validations */
                if(allowed_file.indexOf(ftype) >= 0){
                    if (allowed_ext.indexOf(fext) == -1) {
                        mediaOK = false;
                        mediaError += ' "'+fext.toUpperCase()+'" file extension is not allowed. Only '+allowed_ext.join(', ').toUpperCase()+' are allowed. ';
                    }
                    if(fsize > allowed_size){
                        mediaOK = false;
                        mediaError += 'File size should be less than equals to '+allowed_size+' MB. ';
                    }
                }else{
                    mediaOK = false;
                    mediaError += 'Only Excel (.xlsx) file type is allowed. ';
                }

                if(mediaOK){
                    let reader = new FileReader();
                    reader.readAsDataURL(media);
                    reader.onloadend = function(evt){
                        if (evt.target.readyState == FileReader.DONE){
                            $(".dargdrop-zone").addClass("border-success");
                            media_text.html('<span class="text-success">'+media.name+'</span>');
                        }
                    }
                }else{
                    media_selector.val('');
                    $(".dargdrop-zone").addClass("border-danger");
                    media_text.html('<span class="text-danger">'+mediaError+'</span>');
                }
            }
        });
    });
</script>
<script>
    $(document).ajaxSend(function() {
        $("#overlay").fadeIn(300);
    });

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#importCustomers').submit(function(e) {
        
        e.preventDefault();
        $('#success-import').hide();
        $('#error-import').hide();
        $("#error_list" ).empty();

        //console.log($("#import_file").val());
        if($("#import_file").val() == ''){
            Sweet('error', "Select file to Upload.");
            return false;
        }
        var formData = new FormData(this);

        var name = '';
        var old_name = '';
        name = $("#group_name").val();
        old_name = $("#old_group").val();

        if(name == '' && (old_name == '' || old_name == undefined)){
            //Get Group Name
            Sweet('error', "Please enter Contact Group Name.");
            return false;
        }else if(name != ''){

            $.ajax({
                url: '{{ route("business.customers.groupCheck") }}',
                type: "POST",
                data: {
                    group_name: name, old_group: old_name
                },
                dataType : "json",
                success: function (responce) {
                    $("#overlay").fadeOut(300);
                    if(responce.status == true){
                        uploadContacts(formData);
                    }else{
                        Sweet('error', responce.message);
                    }
                    
                },
                error: function(data) 
                {
                    $("#overlay").fadeOut(300);
                }
            });  
        }else{
            uploadContacts(formData);
        }
        
    });

    function uploadContacts(formData){
        $.ajax({
            url: "{{ route('business.customers.importCustomer') }}",
            type: "POST",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function (responce) {
                /*console.log(responce);*/
                media_text.empty();
                $(".dargdrop-zone").removeClass("border-danger").removeClass("border-success");

                $('#importCustomers').trigger('reset');
                $("#overlay").fadeOut(300);

                if(responce.status == true){
                    Sweet('success',responce.message);

                    $('#success-import').show();
                    $('#successCount').text(responce.data.success_count);
                    $('#failedCount').text(responce.data.failed_count);
                    $('#totalCount').text(responce.data.total_count);
                    $('#repeatedCount').text(responce.data.repeated_count);
                }else{
                    //console.log(responce.data);
                    if($.isEmptyObject(responce.data) != true){
                        $('#error-import').show();
                    }else{
                        $('#error-import').hide();
                    }

                    $.each( responce.data, function( i, val ) {

                        var data_row = '<tr><td><p>Row '+i+'</p></td><td><ul class="pl-0 mb-0" style="list-style:none;" id="error_row_'+i+'"></ul></td></tr>'

                        $("#error_list").append(data_row);

                        $.each( responce.data[i], function( j, error ) {
                            $("#error_row_"+i).append("<li>"+error+"</li>");
                        });

                    });

                    Sweet('error',responce.message);
                }


                $('html, body').animate({
                    scrollTop: $('#import-main-section').offset().top
                }, 1000);
            },
            error: function(data) 
            {
                /*console.log(data);*/
                $("#overlay").fadeOut(300);
            }
        });
    }

    $("#old_group").change(function(){
        $("#group_name").val('');
    });

    $("#group_name").change(function(){
        $("#old_group").val('');
    });

</script>
@endsection