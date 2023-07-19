@extends('layouts.admin')
@section('title', 'Admin: Subscriber')
@section('head')
@include('layouts.partials.headersection',['title'=>'Subscribers'])
@endsection
@section('content')

 <div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>{{ __('Edit Customer Plan Data') }}</h4>
                
      </div>
      <div class="card-body">

        <form class="basicform" action="{{ route('admin.customer.updateplaninfo',$planinfo->id) }}" method="post">
          @csrf
          @method('PUT')

          <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" >{{ __('Plan Name') }}</label>
          <div class="col-sm-12 col-md-7">
            <input type="text" class="form-control" disabled=""  value="{{ $planinfo->name }}">
          </div>
         </div>

        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" >{{ __('Offers Limit') }}</label>
          <div class="col-sm-12 col-md-7">
            <input type="text" class="form-control" required="" name="offers_limit"   value="{{ $planinfo->offers_limit }}">
          </div>
         </div>
             
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
          <div class="col-sm-12 col-md-7">
            <button class="btn btn-primary basicbtn" type="submit">{{ __('Save') }}</button>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('end_body')
<script src="{{ asset('assets/js/form.js') }}"></script>
@endsection

