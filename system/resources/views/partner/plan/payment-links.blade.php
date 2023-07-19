@extends('layouts.partner')
@section('title', 'Business: Payment Links')
@section('head')
@include('layouts.partials.headersection',['title'=>'Payment Links'])
@endsection
@section('content')

<div class="row">
  <div class="col-12 mt-2">
    <div class="card">
      <div class="card-body">

          <div class="table-responsive">
            @if(count($paymentLinks) >= 1)
            <table class="table table-striped table-hover text-center table-borderless">
              <thead>
                <tr>
                  <th class="text-left">{{ __('Name') }}</th>
                  <th>{{ __('Email') }}</th>
                  <th>{{ __('Mobile') }}</th>
                  <th>{{ __('Link') }}</th>
                  <th>{{ __('Action') }}</th>
                </tr>
              </thead>
              
              <tbody>
                
                @foreach($paymentLinks as $row)
                <tr id="row{{ $row->id }}">
                  <td class="text-left"><a href="{{ route('business.partner.paymentLink', $row->id) }}">{{ $row->name }}</a></td>
                  <td><a href="mailto:{{ $row->email }}">{{ $row->email }}</a></td>
                  <td><a href="tel:{{ $row->mobile }}">{{ $row->mobile }}</a></td>
                  <td>{{ $row->short_link }}</td>
                  <td>
                    <a class="btn btn-primary" href="{{ route('business.partner.paymentLink',$row->id) }}"><i class="fas fa-eye"></i> {{ __('View') }}</a>
                  
                  </td>
                </tr>
                @endforeach
                
              </tbody>
           </table>

           <div class="">
             {{ $paymentLinks->links('vendor.pagination.bootstrap-4') }}
           </div>

           @else
                <h2 style="padding:50px;text-align:center;clear: both;">Sorry No Record Found!</h2>
            @endif
         </div>
       
        
     </div>
   </div>
 </div>
</div>
@endsection


