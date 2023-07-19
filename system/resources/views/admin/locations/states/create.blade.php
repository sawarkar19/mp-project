@extends('layouts.admin')
@section('title', 'Admin: New State')
@section('head')
    @include('layouts.partials.headersection',['title'=>'States'])
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('New State') }}</h4>
                </div>
                <div class="card-body">
                    {!! Form::open(array('route' => 'admin.states.store','method'=>'POST', 'class'=>'basicformwithfunction')) !!}
                        @include('admin.locations.states.form')
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
                window.location.href = '{{ route('admin.states.index') }}';
            }, 2000);
        }
        function error(res){
            console.log(res);
        }
    </script>
@endsection