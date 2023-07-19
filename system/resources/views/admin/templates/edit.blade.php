@extends('layouts.admin')
@section('title', 'Admin: Edit Templates')
@section('head')
    @include('layouts.partials.headersection',['title'=>'Edit Templates'])
    <style type="text/css">
        .is_required{
          color:red;
          display: none;
        }
      </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Edit Templates') }}</h4>
                </div>
                <div class="card-body">
                    {!! Form::model($templates, ['method' => 'PATCH','route' => ['admin.templates.update', $templates->id],'class'=>'basicformwithfunction']) !!}
                        @include('admin.templates.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('end_body')
    <script src="{{ asset('assets/js/form.js') }}"></script>
    <script>
        function success(res){
            setTimeout(function(){
                window.location.href = '{{ URL::previous() }}';
            }, 2000);
        }
        function error(res){
            console.log(res);
        }
    </script>
@endsection