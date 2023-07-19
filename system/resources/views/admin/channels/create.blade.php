@extends('layouts.admin')
@section('title', 'Admin: Create Channel')
@section('head')
    @include('layouts.partials.headersection',['title'=>'Create Channel'])
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
                    <h4>{{ __('Enter Channel Detail') }}</h4>
                </div>
                <div class="card-body">
                    {!! Form::open(array('route' => 'admin.channels.store','method'=>'POST', 'class'=>'basicformwithfunction')) !!}
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
        function success(res){
            setTimeout(function(){
                window.location.href = '{{ route('admin.channels.index') }}';
            }, 2000);
        }
        function error(res){
            console.log(res);
        }
    </script>
@endsection