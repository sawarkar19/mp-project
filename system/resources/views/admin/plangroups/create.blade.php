@extends('layouts.admin')
@section('title', 'Admin: Create Plan Group')
@section('head')
{{--  multiple select dropdown link start dinesh  --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
{{--  multiple select dropdown link end dinesh  --}}
    @include('layouts.partials.headersection',['title'=>'Create Plan Group'])
    <style type="text/css">
        .is_required{
          color:red;
        }
        .form-group textarea {
            height: 00px !important;
        }
        
      </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Enter Plan Group Detail') }}</h4>
                </div>
                <div class="card-body">
                    {!! Form::open(array('route' => 'admin.plangroups.store','method'=>'POST', 'class'=>'basicformwithfunction')) !!}
                        @include('admin.plangroups.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('end_body')
    <script src="{{ asset('assets/js/form.js') }}"></script>
    <script src="{{ asset('assets/js/input-validation.js') }}"></script>

    {{--  multiple select dropdown script start dinesh  --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{--  multiple select dropdown script end dinesh  --}}

    <script>
        function success(res){
            setTimeout(function(){
                window.location.href = '{{ route('admin.plangroups.index') }}';
            }, 2000);
        }
        function error(res){
            console.log(res);
        }
    </script>

    {{--  multiple select dropdown script start dinesh  --}}
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
              placeholder: "Select a Channel",
              allowClear: true,
              tags: true,
              tokenSeparators: [',', ' ']
            });
        });
    </script>
    {{--  multiple select dropdown script end dinesh  --}}
@endsection

