@extends('layouts.admin')
@section('title', 'Admin: Emails')
@section('head')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />

    @include('layouts.partials.headersection', ['title' => 'Add New Email'])
    <style>
        #error {
            color: #ff0000;
        }

        #success {
            color: green;
        }
    </style>
@endsection
@section('content')

    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <form id="blogform" method="post" action="{{ route('admin.emailmanages.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="custom-form pt-20">

                            <div class="form-group">
                                <label for="name">Subject</label>
                                <input type="text" placeholder="Title" name="subject" class="form-control"
                                    id="name">
                            </div>

                            <div class="form-group">
                                <label for="description">Content</label>
                                <textarea name="content" class="form-control editor description" id="description"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="name">Status</label>
                                <select class="custom-select mr-sm-2 form-control" id="inlineFormCustomSelect"
                                    name="status">
                                    <option value="1">{{ __('Yes') }}</option>
                                    <option value="0">{{ __('No') }}</option>
                                </select>
                            </div>

                            <div class="btn-publish text-center">
                                <button for="submit"  type="submit" class="btn btn-primary btn-lg"><i
                                        class="fa fa-save"></i>
                                    {{ __('Save') }}
								</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('end_body')
    @include('admin.emailmanage.customjs')
@endsection
