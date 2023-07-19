@extends('layouts.designer')
@section('title', 'Designer: Edit Vcard')
@section('head')
    @include('layouts.partials.headersection',['title'=>'Edit Vcard'])
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
                    <h4>{{ __('Edit Vcard') }}</h4>
                </div>
                <div class="card-body">
                    {!! Form::model($vcards, ['method' => 'PATCH','route' => ['designer.vcards.update', $vcards->id],'class'=>'basicformwithfunction']) !!}
                        @include('designer.vcards.form')
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