@extends('layouts.admin')
@section('title', 'Admin: Coupons')
@section('head')
@include('layouts.partials.headersection',['title'=>'Coupon Detail'])
@endsection
@section('content')

<div class="row">
    <div class="col-12 col-md-6 col-lg-6">
      <div class="card">
        @foreach($couponDetail as $row)
        <div class="card-header">
          <h4>{{ $row->name }} Coupon</h4>
        </div>
        
        <div class="card-body">
          
          <div>Coupon Code - {{ $row->code }}</div>
          <div>Description - {{ $row->description }}</div>
          <div>Coupon Type - {{ $row->coupon_type }}</div>
          <div>Discount - {{ $row->discount }}</div>
          <div>Start Date - {{ $row->start_date }}</div>
          <div>End Date - {{ $row->end_date }}</div>
          <div>Coupon For - {{ $row->coupon_for }}</div>
        </div>
        <!-- <div class="card-footer">
          Footer Card
        </div> -->
        @endforeach
      </div>
    </div>
</div>

@endsection
@section('end_body')
<script src="{{ asset('assets/js/form.js') }}"></script>
@endsection

