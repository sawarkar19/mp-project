@extends('layouts.admin')
@section('title', 'Admin: Edit Template Button')
@section('head')
    @include('layouts.partials.headersection',['title'=>'Edit Template Button'])
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
                    <h4>{{ __('Edit Template Button') }}</h4>
                </div>
                <div class="card-body">
                    {!! Form::model($templateButtons, ['method' => 'PATCH','route' => ['admin.templatebuttons.update', $templateButtons->id],'class'=>'basicformwithfunction']) !!}
                        @include('admin.templatebuttons.form')
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