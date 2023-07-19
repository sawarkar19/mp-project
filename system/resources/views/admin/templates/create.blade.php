@extends('layouts.admin')
@section('title', 'Admin: Create Template')
@section('head')
    @include('layouts.partials.headersection',['title'=>'Create Template'])
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
                    <h4>{{ __('Enter Template Detail') }}</h4>
                </div>
                <div class="card-body">
                    {!! Form::open(array('route' => 'admin.templates.store','method'=>'POST', 'class'=>'basicformwithfunction')) !!}
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
                window.location.href = '{{ route('admin.templates.index') }}';
            }, 2000);
        }
        function error(res){
            console.log(res);
        }
    </script>
@endsection