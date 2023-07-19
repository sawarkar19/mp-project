@extends('layouts.admin')
@section('title', 'Admin: Thank You')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'Thank You'])
    <style>
        .main-content {
            padding-left: 25px;
            padding-right: 25px;
        }

        .max-700 {
            max-width: 700px;
            margin: auto;
        }

        .table:not(.table-sm):not(.table-md):not(.dataTable) td,
        .table:not(.table-sm):not(.table-md):not(.dataTable) th {
            height: 50px;
        }
    </style>
@endsection

@section('content')

    <div class="main-content">
        <section class="section max-700">
            <div class="section-header">
                <div class="text-center w-100">
                    <div class="mb-3"><img src="{{ asset('assets/img/done.svg') }}" alt="success" style="width:55px;"></div>
                    <h1 class="text-success mb-2">Payment Successful</h1>
                    <p class="mb-0">Thank you for your payment.<br>An automated payment receipt will be sent to your
                        registered email.</p>
                </div>
            </div>
        </section>
    </div>

@endsection
@section('end_body')
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>

@endsection
