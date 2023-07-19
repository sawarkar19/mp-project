@extends('layouts.admin')
@section('title', 'Admin: Edit City')
@section('head')
    @include('layouts.partials.headersection',['title'=>'States'])
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Edit City') }}</h4>
                </div>
                <div class="card-body">
                    {!! Form::model($cities, ['method' => 'PATCH','route' => ['admin.cities.update', $cities->id],'class'=>'basicformwithfunction']) !!}
                        @include('admin.locations.cities.form')
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