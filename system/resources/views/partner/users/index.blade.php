@extends('layouts.partner')

@section('head') @include('layouts.partials.headersection',['title'=>'Users']) @endsection

@section('end_head')
<style>

</style>
@endsection

@section('content')


<section class="section">

    <div class="section-body">

<div class="row">
    <div class="col-12 mt-2">
        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                @if(count($users) >= 1)
                <table class="table table-striped table-hover text-center table-borderless">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th class="text-left">{{ __('Name') }}</th>
                  <th>{{ __('Email') }}</th>
                  <th>{{ __('Mobile') }}</th>
                  <th>{{ __('Payment Status') }}</th>
                  <th>{{ __('Join at') }}</th>
                </tr>
                </thead>

                <tbody>

                @foreach($users as $row)
                <tr id="row{{ $row->id }}">
                  <td>{{ $loop->iteration }}</td>
                  <td class="text-left">{{ $row->name }}</td>
                  <td><a href="mailto:{{ $row->email }}">{{ $row->email }}</a></td>
                  <td><a href="tel:{{ $row->mobile }}">{{ $row->mobile }}</a></td>
                  <td>
                    @if($row->paidTransaction != null)
                        <span class="btn btn-success">Paid</span>
                    @else
                        <span class="btn btn-danger">Unpaid</span>
                    @endif
                  </td>
                  <td>{{ \Carbon\Carbon::parse($row->created_at)->format('j M, Y') }}</td>
                </tr>
                @endforeach

                </tbody>
                </table>

                {{ $users->links('vendor.pagination.bootstrap-4') }}

                @else
                <h2 style="padding:50px;text-align:center;clear: both;">Sorry No Record Found!</h2>
                @endif
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

</section>


@endsection


