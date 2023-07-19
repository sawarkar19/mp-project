@extends('layouts.admin')
@section('title', 'Admin: Edit Gallery')
@section('head')
    @include('layouts.partials.headersection',['title'=>'Edit Gallery'])
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
                    <h4>{{ __('Edit Gallery') }}</h4>
                </div>
                <div class="card-body">
                    {!! Form::model($gallery_imgs, ['method' => 'PATCH','route' => ['admin.galleryimages.update', $gallery_imgs->id],'class'=>'basicformwithfunction']) !!}
                        @include('admin.galleryimages.form')
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