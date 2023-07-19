@extends('layouts.account')
@section('title', 'Transaction History: Account Panel')

@section('end_head')
<style>
  .invoice-detail-item{
    display: flex;
    justify-content: end;
    align-items: center;
  }
  .invoice-detail-item .invoice-detail-value{
    min-width: 140px;
    margin-left: 15px;
    font-size: 15px!important;
  }
  .invoice-detail-item .invoice-detail-value.invoice-detail-value-lg{
    font-size: 20px!important;
  }
  /*.invoice-detail-value{
    text-align: right;
  }*/
  .invoice_ID{
    margin-top: 0px !important;
  }
  @media(max-width: 575px){
    .invoice_button a{
      padding: 0.3rem 0.3rem;
    }
    .invoice-detail-item{
      justify-content: space-between;
    }
  }
</style>
@endsection

@section('head')
    @include('layouts.partials.headersection', ['title'=>'View Transaction History'])    
@endsection

@section('content')

<section  class="section">
    
    <div class="section-body">
        <div class="invoice">
          <div class="invoice-print">
            <div class="row">
              <div class="col-lg-12">
                <div class="invoice-title">
                  <h2 class="d-inline">Invoice</h2>
                  <div class="invoice-number invoice_ID">Invoice ID: {{ $transaction->invoice_no }}</div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-6">
                    <address>
                      <strong>Plan Duration:</strong><br>
                      {{ $plan_period->name }}<br><br>
                    </address>
                  </div>
                  <div class="col-md-6 text-md-right">
                    <address>
                      <strong>Order Date:</strong><br>
                      {{ \Carbon\Carbon::parse($transaction->created_at)->format('j F, Y') }}<br><br>
                    </address>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mt-4">
              <div class="col-md-12">
                <div class="section-title">Invoice Summary</div>
                <div class="table-responsive">
                  <table class="table table-striped table-hover table-md">
                    <tr>
                      <th>Description</th>
                      <th class="text-right">Amount</th>
                    </tr>

                    <tr>
                      <td>MouthPublicity Account Balance</td>
                      <td class="text-right"><span>₹</span>{{ $transaction->transaction_amount }}</td>
                    </tr>

                  </table>
                </div>
                <div class="row mt-4">
                  <div class="col-xl-8 col-md-5 order-2 order-md-1">
                    <div class="section-title">Payment Method</div>
                    <p class="section-lead">{{ $transaction->method->name }}</p>
                  </div>

                  <div class="col-xl-4 col-md-7 order-1 order-md-2">

                    <div class="invoice-detail-item">
                      <div class="invoice-detail-name">Sub Total</div>
                      <div class="invoice-detail-value text-right"><span>₹</span>{{ $transaction->total_amount }}</div>
                    </div>
                    @if($transaction->added_discount_amount >= 1)
                    <div class="invoice-detail-item">
                      <div class="invoice-detail-name">Added Discount </div>
                      <div class="invoice-detail-value text-right"> - <span>₹</span>{{ $transaction->added_discount_amount }}</div>
                    </div>
                    @endif

                    @if($transaction->promocode_amount >= 1)
                    <div class="invoice-detail-item">
                      <div class="invoice-detail-name">Promo Code Discount  </div>
                      <div class="invoice-detail-value text-right"> - <span>₹</span>{{ $transaction->promocode_amount }}</div>
                    </div>
                    @endif
                    <hr class="mt-2 mb-2">
                    @php
                      // Calculate GST 
                      $gst = 0; $sgst = 0; $cgst = 0; $tax_amo = 0;
                      if ($transaction->transaction_amount >= 1){
                        $gst_18 = $transaction->transaction_amount - ($transaction->transaction_amount * (100/(100 + 18)));
                        $gst = round($gst_18, 2);
                        $sgst= round($gst/2, 2);
                        $cgst= round($gst/2, 2);

                        $tax_amo = round($transaction->transaction_amount - $gst, 2);
                      }
                    @endphp
                    <div class="invoice-detail-item">
                      <div class="invoice-detail-name">Taxable Amount</div>
                      <div class="invoice-detail-value text-right"><span>₹</span>{{ $tax_amo }}</div>
                    </div>

                    {{-- @if ($transaction->gst_claim) --}}
                      @if ($transaction->gst_state == 14)
                      <div class="invoice-detail-item">
                        <div class="invoice-detail-name">SGST(9%)</div>
                        <div class="invoice-detail-value text-right">+ <span>₹</span>{{ $sgst }}</div>
                      </div>
                      <div class="invoice-detail-item">
                        <div class="invoice-detail-name">CGST(9%)</div>
                        <div class="invoice-detail-value text-right">+ <span>₹</span>{{ $cgst }}</div>
                      </div>
                      @else
                      <div class="invoice-detail-item">
                        <div class="invoice-detail-name">IGST(18%)</div>
                        <div class="invoice-detail-value text-right">+ <span>₹</span>{{ $gst }}</div>
                      </div>
                      @endif
                    {{-- @else
                    <div class="invoice-detail-item">
                      <div class="invoice-detail-name">GST(18%)</div>
                      <div class="invoice-detail-value text-right">+ <span>₹</span>{{ $gst }}</div>
                    </div>
                    @endif --}}


                    <hr class="mt-2 mb-2">
                    <div class="invoice-detail-item">
                      <div class="invoice-detail-name">Paid Amount</div>
                      <div class="invoice-detail-value invoice-detail-value-lg text-right"><span>₹</span>{{ $transaction->transaction_amount }}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <hr>

          <div class="row">
            <div class="col-6 text-md-left invoice_button">
              <a href="{{ route('account.viewInvoice',$transaction->id) }}" class="btn btn-primary btn-icon icon-left"><i class="fas fa-eye"></i> View Invoice</a>
            </div>
            <div class="col-6 text-md-right invoice_button">
              <a href="{{ route('account.downloadHistory',$transaction->id) }}" class="btn btn-primary btn-icon icon-left"><i class="fas fa-download"></i> Download Invoice</a>
            </div>
          </div>
          
        </div>
    </div>

</section>

@endsection 