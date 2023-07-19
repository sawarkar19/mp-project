@extends('layouts.admin')
@section('title', 'Admin: Edit Plan Group')
@section('head')
    {{-- multiple select dropdown link start dinesh --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- multiple select dropdown link end dinesh --}}
    @include('layouts.partials.headersection', ['title' => 'Edit Plan Group'])
    <style type="text/css">
        .is_required {
            color: red;
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
                    <h4>{{ __('Edit Plan Group') }}</h4>
                </div>
                <div class="card-body">
                    {!! Form::model($plangroups, [
                        'method' => 'PATCH',
                        'route' => ['admin.plangroups.update', $plangroups->id],
                        'class' => 'basicformwithfunction',
                    ]) !!}

                    {{-- {!! Form::model($plangroup_id, [
                        'route' => ['admin.plangroups.update', $plangroup_id->id],
                        'method' => 'PATCH',
                        'class' => 'basicformwithfunction',
                    ]) !!} --}}

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
    {{-- multiple select dropdown script start dinesh --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- multiple select dropdown script end dinesh --}}
    <script>
        function success(res) {
            setTimeout(function() {
                window.location.href = '{{ URL::previous() }}';
            }, 2000);
        }

        function error(res) {
            console.log(res);
        }
    </script>


    @if (@$plangroup_id)
        @php
            $channel_ids = [];
        @endphp
        @foreach ($plangroup_id as $key => $group)
            @php
                array_push($channel_ids, $group['channel_id']);
            @endphp
        @endforeach
    @endif

    {{-- multiple select dropdown script start dinesh --}}
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
            data = [];
            data = <?php echo json_encode($channel_ids); ?>;
            $('.js-example-basic-single').val(data);

            $('.js-example-basic-single').trigger('change');
        });
    </script>



    // multiple select dropdown script end dinesh//
@endsection
