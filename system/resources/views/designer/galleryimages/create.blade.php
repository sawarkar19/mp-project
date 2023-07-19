@extends('layouts.designer')
@section('title', 'Designer: Create Gallery')
@section('head')
    @include('layouts.partials.headersection',['title'=>'Create Gallery'])
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
                    <h4>{{ __('Enter Gallery Detail') }}</h4>
                </div>
                <div class="card-body">
                    {!! Form::open(array('route' => 'designer.galleryimages.store','method'=>'POST', 'class'=>'basicformwithfunction')) !!}
                        @include('designer.galleryimages.form')
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