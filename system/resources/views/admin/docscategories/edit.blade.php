@extends('layouts.admin')
@section('title', 'Admin: Edit Document Category')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'Edit Document Category'])
    <style type="text/css">
        .is_required {
            color: red;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Edit Document Category') }}</h4>
                </div>
                <div class="card-body">
                    {!! Form::model($docscategories, [
                        'method' => 'PATCH',
                        'route' => ['admin.docscategories.update', $docscategories->id],
                        'class' => 'basicformwithfunction',
                    ]) !!}
                    @include('admin.docscategories.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('end_body')
    <script src="{{ asset('assets/js/form.js') }}"></script>
    <script src="{{ asset('assets/js/input-validation.js') }}"></script>
    <script>
        function success(res) {
            setTimeout(function() {
                window.location.href = '{{ URL::previous() }}';
            }, 2000);
        }

        function error(res) {
            console.log(res);
        }
    </script>
@endsection
