@extends('layouts.admin')
@section('title', 'Admin: New City')
@section('head')
    @include('layouts.partials.headersection',['title'=>'Cities'])
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('New City') }}</h4>
                </div>
                <div class="card-body">
                    {!! Form::open(array('route' => 'admin.cities.store','method'=>'POST', 'class'=>'basicformwithfunction')) !!}
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
        $(document).ready(function () {
            $('#stateForCity').prepend('<option value="" selected="selected" disabled> Select State </option>');
        });
        function success(res){
            setTimeout(function(){
                window.location.href = '{{ route('admin.cities.index') }}';
            }, 2000);
        }
        function error(res){
            console.log(res);
        }
    </script>
@endsection