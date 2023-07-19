@extends('layouts.admin')
@section('title', 'Admin: Sites Script')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'Sites Script'])
    <style>
        .is_required {
            color: red;
        }

        .custom-switch-input:checked~.custom-switch-indicator {
            background: #31ce55;
        }
    </style>
@endsection
@section('start_body')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-colorpicker.min.css') }}">
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mb-30">
                <div class="col-lg-6">
                    
                </div>
                <div class="col-lg-6">

                </div>
            </div>
            <br>
            <div class="card-action-filter">
                <form method="post" class="basicform_with_reload" action="{{ route('admin.sites-scripts.destroys') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="d-flex">
                                <div class="single-filter">
                                    <div class="form-group">
                                        <select class="form-control selectric" name="status">
                                            <option disabled="" selected="">Select Action</option>
                                            <option value="delete">{{ __('Delete Permanently') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="single-filter">
                                    <button type="submit" class="btn btn-primary btn-lg ml-2">{{ __('Apply') }}</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="add-new-btn">
                                <button type="button" class="btn btn-primary basicbtn float-right" data-toggle="modal"
                                    data-target="#exampleModalCenter">{{ __('Add Site Script') }}</button>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="table-responsive custom-table">
                @if (count($options) >= 1)

                    <table class="table">
                        <thead>
                            <tr>
                                <th class="am-select">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input checkAll" id="selectAll">
                                        <label class="custom-control-label checkAll" for="selectAll"></label>
                                    </div>
                                </th>
                                <th class="am-title">{{ __('Title') }}</th>
                                <th class="am-title">{{ __('Status') }}</th>
                                <th class="am-date" style="min-width: 200px;">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($options as $option)
                                <tr id="blog_id_{{ $option->id }}">
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="ids[]" class="custom-control-input"
                                                id="customCheck{{ $option->id }}" value="{{ $option->id }}">
                                            <label class="custom-control-label"
                                                for="customCheck{{ $option->id }}"></label>
                                        </div>
                                    </th>
                                    <td>
                                        {{ $option->title }}
                                    </td>

                                    <td>
                                        @if ($option->status == 1)
                                            <span class="badge badge-success">{{ __('Active') }}</span>
                                        @elseif($option->status == 0)
                                            <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a class="btn btn-icon icon-left btn-primary" data-toggle="modal" onclick="optionDetail({{ $option->id }})" data-target="#editModalScript"
                                            href="#"><i class="fa fa-edit"></i></a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                        </form>

                    </table>
                @else
                    <h3 style="padding:50px;text-align:center;clear: both;">Waiting for a great start...</h3>
                @endif
                {{ $options->links('vendor.pagination.bootstrap-4') }}

            </div>
        </div>
    </div>


    {{-- <!-- Button trigger modal -->
    <div class="form-group mb-4">
        <label class="col-form-label text-md-right"></label>
        <div class="">
            <button type="button" class="btn btn-primary basicbtn float-right" data-toggle="modal"
                data-target="#exampleModalCenter">{{ __('Add Site Script') }}</button><br>

        </div>
    </div> --}}


    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <form id="pageform" method="post" action="{{ route('admin.sites-scripts.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="custom-form pt-20">

                                            <div class="form-group">
                                                <label for="name">Title <span class="is_required">*</span></label>
                                                <input type="text" placeholder="Title" name="title"
                                                    class="form-control" id="name">
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Description<span
                                                        class="is_required">*</span></label>
                                                <textarea name="value" class="form-control editor description" id="value"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="name">Status</label>
                                                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect"
                                                    name="status">
                                                    <option value="1">{{ __('Active') }}</option>
                                                    <option value="0">{{ __('Inactive') }}</option>
                                                </select>
                                            </div>

                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                                Save Script</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- Edit Modal Script -->
    <div class="modal fade" id="editModalScript" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <form id="pageEditform" method="post" action="{{ route('admin.updateScript') }}"
                                        enctype="multipart/form-data">
                                        @csrf
						                @method('PUT')
                                        <div class="custom-form pt-20">

                                            <div class="form-group">
                                                <label for="name">Title <span class="is_required">*</span></label>
                                                <input type="hidden" name="id" id="optionId" value="">
                                                <input type="text" placeholder="Title" name="title"
                                                    class="form-control" id="titleName">
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Description<span
                                                        class="is_required">*</span></label>
                                                <textarea name="value" class="form-control editor description" id="editValue"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="name">Status</label>
                                                <select class="custom-select mr-sm-2" id="editStatus"
                                                    name="status">
                                                    <option value="1">{{ __('Active') }}</option>
                                                    <option value="0">{{ __('Inactive') }}</option>
                                                </select>
                                            </div>

                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                                Update Script</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
@section('end_body')
    <script src="{{ asset('assets/js/input-validation.js') }}"></script>
    <script>
        /* Create Page */
        $(document).ready(function() {
            $("#pageform").on('submit', function(e) {
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: this.action,
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        if (response.status == true) {
                            //$('#pageform').trigger('reset');
                            Sweet('success', response.message);
                            setTimeout(function() {
                                location.reload();
                            }, 3000);

                        } else {
                            Sweet('error', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        $.each(xhr.responseJSON.errors, function(key, item) {
                            Sweet('error', item);
                        });
                    }
                })
            });


            $("#pageEditform").on('submit', function(e){
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: this.action,
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(response){ 
                        console.log(response);
                        if(response.status == true){
                            //$('#pageform').trigger('reset');
                            Sweet('success',response.message);
                            setTimeout(function(){
                                location.reload();
                            },3000);
                        }else{
                            Sweet('error',response.message);
                        }
                    },
                    error: function(xhr, status, error) 
                    {
                        $.each(xhr.responseJSON.errors, function (key, item) 
                        {
                            Sweet('error',item);
                        });
                    }
                })
            });
        });

        $(".basicform_with_reload").on('submit', function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var basicbtnhtml=$('.basicbtn').html();
        $.ajax({
            type: 'POST',
            url: this.action,
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function() {
                
                $('.basicbtn').html("Please Wait....");
                $('.basicbtn').attr('disabled','')

            },
            
            success: function(response){ 
                $('.basicbtn').removeAttr('disabled')
                if (response.status == true) {
                    Sweet('success',response.message);
                            setTimeout(function(){
                                location.reload();
                            },2000);
                } else {
                    Sweet('error',response.message);
                }
                
                $('.basicbtn').html(basicbtnhtml);
            },
            error: function(xhr, status, error) 
            {
                $('.basicbtn').html(basicbtnhtml);
                $('.basicbtn').removeAttr('disabled')
                $('.errorarea').show();
                $.each(xhr.responseJSON.errors, function (key, item) 
                {
                    Sweet('error',item)
                    $("#errors").html("<li class='text-danger'>"+item+"</li>")
                });
                errosresponse(xhr, status, error);
            }
        })
    });

    // optionDetail(id);
    function optionDetail(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
                url: '{{ route('admin.sites-scripts.optionDetail') }}',
                type: 'POST',
                dataType: "JSON",
                data:{id:id},
                success: function(response) {
                    // Add response in Modal body
                    $("#optionId").val(response.options.id);
                    $("#titleName").val(response.options.title);
                    $("#editValue").val(response.options.value);
                    $("#editStatus").val(response.options.status);
                }
            });  
    }
    </script>
@endsection
