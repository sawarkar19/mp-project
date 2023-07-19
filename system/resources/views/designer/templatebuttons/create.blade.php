@extends('layouts.designer')
@section('title', 'Designer: Create Template Button')
@section('head')
    @include('layouts.partials.headersection',['title'=>'Create Template Button'])
    <style type="text/css">
        .is_required{
          color:red;
        }
      </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Enter Template Button Detail') }}</h4>
                </div>
                <div class="card-body">
                    {!! Form::open(array('route' => 'designer.templatebuttons.store','method'=>'POST', 'class'=>'basicformwithfunction')) !!}
                        @include('designer.templatebuttons.form')
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
                window.location.href = res.url;
            }, 2000);
        }
        function error(res){
            console.log(res);
        }
    </script>
@endsection