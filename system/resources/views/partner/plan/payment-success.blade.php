@extends('layouts.partner')
@section('title', 'Partner Dashboard')
@section('head') @include('layouts.partials.headersection',['title'=>'Payment Successful']) @endsection

@section('end_head')
<style>
 .payment-details{
        width: 100%;
        margin: 0 auto;
    }
    .payment-details span {
        font-size: 14px;
    }
    span.pay-amount {
        font-size: 15px;
        font-weight: bold;
    }
    @media (max-width: 575){
        .payment-details{
            max-width: 440px;
        }
    }
</style>
@endsection

@section('content')
<section>
    <div class="section">
        <div class="row justify-content-center my-5">
            <div class="col-lg-7 col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center py-4">
                            
                            <div class="mb-3"><img src="{{ asset('assets/img/done.svg') }}" alt="success" style="width:55px;"></div>
                            <h4 class="text-success mb-3">Payment Successful!!</h4>
                            <p class="mb-0">Thank you for your payment.<br>An automated payment receipt will be sent to your registered email.</p>
                            <div class="payment-details mt-5">
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span style="color: #6c757d;">Date</span>
                                    <span>{{ Carbon\Carbon::parse($transaction->created_at)->format("j M, Y h:i A") }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span style="color: #6c757d;">Transaction ID</span>
                                    <span>{{ $paymentData['payment_id'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span style="color: #6c757d;">Payment Mode</span>
                                    <span>{{ ucfirst($paymentData['payment_method']) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <span class="pay-amount" style="color: #6c757d;">Total Amount</span>
                                    <span  class="pay-amount">&#8377;{{ $transaction->transaction_amount }}</span>
                                </div>
                                {{-- <div class="payment-act-btn-sec mt-5">
                                    <a href="{{ route('business.viewHistory',$transaction->id) }}" class="btn btn-primary mx-2">View Invoice</a>
                                    </div>
                                </div> --}}
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection


@section('end_body')
   
@endsection