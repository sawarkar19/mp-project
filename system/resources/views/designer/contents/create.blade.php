@extends('layouts.designer')
@section('title', 'Designer: Create Content')
@section('head')
    @include('layouts.partials.headersection',['title'=>'Create Content'])
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
                    <h4>{{ __('Enter Content Detail') }}</h4>
                </div>
                <div class="card-body">
                    {!! Form::open(array('route' => 'designer.contents.store','method'=>'POST', 'class'=>'basicformwithfunction')) !!}
                        @include('designer.contents.form')
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