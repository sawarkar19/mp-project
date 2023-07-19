@extends('layouts.admin')
@section('title', 'Admin: Enterprises')
@section('head')
    <style>
        .dargdrop-zone {
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

        .dargdrop-zone p {
            text-align: center;
            color: var(--secondary);
        }

        .dargdrop-zone input {
            position: absolute;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            outline: none;
            opacity: 0;
            cursor: pointer;
        }

        .dargdrop-zone:hover {
            border: 2px dashed var(--primary);
        }

        .import-section {
            width: 100%;
            max-width: 700px;
            margin: 3rem auto;
            text-align: center;
        }

        .steps {
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

        .ol-alert {
            position: relative;
            padding: 10px 15px;
            border-width: 1px;
            border-style: solid;
            border-color: #272727;
            color: #272727;
            border-radius: 4px;
            background-color: #e3e3e3;
        }

        .ol-alert.ol-a-success {
            background-color: #d0eece;
            border-color: #2c932e;
            color: #2c932e;
        }

        .ol-alert.ol-a-danger {
            background-color: #eecece;
            border-color: #ae2424;
            color: #ae2424;
        }

        table.v-align-top tr>td {
            vertical-align: top !important;
        }
    </style>
    @include('layouts.partials.headersection', ['title' => 'Enterprise Details'])
@endsection
@section('content')

    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-6 col-md-6 col-lg-6 card profile-widget">
                    <p class="profile-widget-item-label">{{ __('Name :') }}</p>
                    <h5 class="profile-widget-item-value">&nbsp;{{ $enterprises->name }}</h5>
                    <p class="profile-widget-item-label">{{ __('Email :') }}</p>
                    <h5 class="profile-widget-item-value">&nbsp;{{ $enterprises->email }}</h5>
                    <p class="profile-widget-item-label">{{ __('Mobile :') }}</p>
                    <h5 class="profile-widget-item-value">&nbsp;{{ $enterprises->mobile }}</h5>
                    <p class="profile-widget-item-label">{{ __('WhatsApp message per month limit :') }}</p>
                    <h5 class="profile-widget-item-value">&nbsp;{{ $enterprises->wa_per_month_limit }}</h5>

                </div>

                <div class="col-6 col-md-6 col-lg-6 card profile-widget">
                    <div class="import-section">
                        <h5 class="mb-3">Import Users</h5>
                        <hr>
                        <form method="POST" enctype="multipart/form-data" id="importCustomers" action="javascript:void(0)">
                            @csrf
                            <div class="dargdrop-zone">
                                <input name="customer_list" id="import_file" type="file"
                                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                <p class="mb-0">Drag your files here or click on the area. Only .xlsx file is allowed.
                                    <br> <span class="btn btn-sm btn-primary px-3">Browes File</span>
                                </p>
                                <p class="mb-0" id="import_file_text"></p>
                            </div>
                            <button type="submit" class="btn btn-success px-4" id="uploadBtn">Upload</button>
                        </form>
                    </div>

                    {{-- success section  --}}
                    {{-- <div class="mb-5" id="success-import" style="display: none;">
                        <div class="ol-alert ol-a-success mb-4">
                            User data has been uploaded successfully.
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
                            <a href="{{ route('admin.enterprises.show', $enterprises->id) }}"
                                class="btn btn-primary px-4">View All Users</a>
                        </div>
                    </div> --}}

                    {{-- error section  --}}
                    {{-- <div class="mb-5" id="error-import" style="display: none;">
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
                    </div> --}}

                </div>
            </div>

            {{-- user data with enterprise id start --}}
            <div class="card">
                <div class="card-body">
                    
                    <div class="table-responsive custom-table">
                        @if (count($users) >= 1)
        
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="am-title">{{ __('Sr.No') }}
                                        </th>
                                        <th class="am-title">{{ __('Name') }}</th>
                                        <th class="am-title">{{ __('Email') }}</th>
                                        <th class="am-title">{{ __('Mobile') }}</th>
                                        <th class="am-title">{{ __('Status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    @foreach ($users as $index => $user)
                                        <tr id="blog_id_{{ $user->id }}">
                                            <th>
                                                {{ $index + $users->firstItem() }}
                                            </th>
                                            <td>
                                                {{ $user->name }}
                                            </td>
                                            <td>
                                                {{ $user->email }}
                                            </td>
                                            <td>
                                                {{ $user->mobile }}
                                            </td>
                                            <td>
                                                @if ($user->status == 1)
                                                <span class="badge badge-success">{{ __('Active') }}</span>
                                                @elseif($user->status == 0)
                                                <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="card-body text-center">
                                <h3>{{ Config::get('constants.no_record_found') }}</h3>
                            </div>
                        @endif
                        <div class="card-footer text-center">
                            {{ $users->links('vendor.pagination.bootstrap-4') }}
                          </div>
                        
        
                    </div>
                </div>
            </div>
            {{-- user data with enterprise id end --}}

        </div>

    </section>
@endsection
@section('end_body')
    <script src="{{ asset('assets/js/form.js') }}"></script>
    <script>
        var media_selector = $("#import_file");
        var media_text = $("#import_file_text");
        var allowed_ext = ['xlsx'];
        var allowed_file = ['application'];
        var allowed_size = 2; // in MB

        $(document).ready(function() {
            var fname, fsize, fpath, fext, ftype;

            media_selector.on("change", function(evnt) {
                var media = evnt.target.files[0];

                media_text.empty();
                $(".dargdrop-zone").removeClass("border-danger").removeClass("border-success");

                if (evnt.target.files.length > 0) {
                    let mediaOK = true;
                    let mediaError = '';

                    fpath = (window.URL || window.webkitURL).createObjectURL(media); // Path
                    fext = media.name.split('.').pop(); // extension
                    fsize = media.size / 1024 / 1024; // size in MB
                    ftype = media.type;
                    ftype = ftype.substr(0, ftype.indexOf("/")).toLowerCase(); // type
                    console.table(ftype);
                    /* Validations */
                    if (allowed_file.indexOf(ftype) >= 0) {
                        if (allowed_ext.indexOf(fext) == -1) {
                            mediaOK = false;
                            mediaError += ' "' + fext.toUpperCase() +
                                '" file extension is not allowed. Only ' + allowed_ext.join(', ')
                                .toUpperCase() + ' are allowed. ';
                        }
                        if (fsize > allowed_size) {
                            mediaOK = false;
                            mediaError += 'File size should be less than equals to ' + allowed_size +
                                ' MB. ';
                        }
                    } else {
                        mediaOK = false;
                        mediaError += 'Only Excel (.xlsx) file type is allowed. ';
                    }

                    if (mediaOK) {
                        let reader = new FileReader();
                        reader.readAsDataURL(media);
                        reader.onloadend = function(evt) {
                            if (evt.target.readyState == FileReader.DONE) {
                                $(".dargdrop-zone").addClass("border-success");
                                media_text.html('<span class="text-success">' + media.name + '</span>');
                            }
                        }
                    } else {
                        media_selector.val('');
                        $(".dargdrop-zone").addClass("border-danger");
                        media_text.html('<span class="text-danger">' + mediaError + '</span>');
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
            $("#error_list").empty();

            //console.log($("#import_file").val());
            if ($("#import_file").val() == '') {
                Sweet('error', "Select file to Upload.");
                return false;
            }

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.enterprises.importUsers') }}",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(responce) {
                    /*console.log(responce);*/
                    media_text.empty();
                    $(".dargdrop-zone").removeClass("border-danger").removeClass("border-success");

                    $('#importCustomers').trigger('reset');
                    $("#overlay").fadeOut(300);
                    if (responce.status == true) {
                        Sweet('success', responce.message);
                        // $('#success-import').show();
                        // $('#successCount').text(responce.data.success_count);
                        // $('#failedCount').text(responce.data.failed_count);
                        // $('#totalCount').text(responce.data.total_count);
                        // $('#repeatedCount').text(responce.data.repeated_count);

                        // setTimeout(function() {
                        //     location.reload();
                        // }, 2000);
                    } else {

                        // if ($.isEmptyObject(responce.data) != true) {
                        //     $('#error-import').show();
                        // } else {
                        //     $('#error-import').hide();
                        // }

                        // $.each(responce.data, function(i, val) {

                        //     var data_row = '<tr><td><p>Row ' + i +
                        //         '</p></td><td><ul class="pl-0 mb-0" style="list-style:none;" id="error_row_' +
                        //         i + '"></ul></td></tr>'

                        //     $("#error_list").append(data_row);

                        //     $.each(responce.data[i], function(j, error) {
                        //         $("#error_row_" + i).append("<li>" + error + "</li>");
                        //     });

                        // });

                        Sweet('error', responce.message);
                    }

                    // $('html, body').animate({
                    //     scrollTop: $('#import-main-section').offset().top
                    // }, 1000);
                },
                error: function(data) {
                    /*console.log(data);*/
                    $("#overlay").fadeOut(300);
                }
            });
        });
    </script>
@endsection
