@extends('layouts.admin')
@section('title', 'Admin: Edit Channel')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'Edit Channel'])
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
                    <h4>{{ __('Edit Channel') }}</h4>
                </div>
                <div class="card-body">
                    {!! Form::model($channels, [
                        'method' => 'PATCH',
                        'route' => ['admin.channels.update', $channels->id],
                        'class' => 'basicformwithfunction',
                    ]) !!}
                    @include('admin.channels.form')
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
