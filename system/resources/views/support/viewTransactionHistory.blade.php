@extends('layouts.business')
@section('title', 'Transaction History: Business Panel')

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
                      <th>Plan Name</th>
                      <th class="text-right">Amount</th>
                    </tr>

                    <tr>
                      <td>MouthPublicity Recharge Plan</td>
                      <td class="text-right"><span>₹</span>{{ $transaction->transaction_amount }}</td>
                    </tr>

                    {{-- @php
                        $sr=1;
                    @endphp
                    @foreach($transaction->userplans_channel as $plan)
                      <tr>
                        <td>{{ $sr }}</td>
                        <td>
                          {{ @$plan->channel->name }}
                          @if(count($plan->freeEmployee) > 0)
                            <br />
                            [ {{ count($plan->freeEmployee) }} {{ __('Free User(s)') }} ]
                          @endif
                        </td>
                        <td class="text-center">
                          @if($transaction->employee_count > 0 && $plan->feature_id == 6)
                              {{ $transaction->employee_count }}
                          @elseif($transaction->direct_transaction_count > 0 && $plan->feature_id == 7)
                              {{ $transaction->direct_transaction_count }}
                          @else
                              -
                          @endif
                        </td>
                        <td class="text-right">
                          <span>₹</span>{{ @$plan->channel->price * $plan_period->months }}
                        </td>
                      </tr>
                      @php
                          $sr++;
                      @endphp
                    @endforeach

                    @if($count_free_paid_employee_ids > 0)
                        @php
                          $multiple = 1;
                          if($empPlanData->is_default == 1){
                              $multiple = $empPlanData->months;
                          }
                        @endphp
                      <tr>
                        <td>{{ $sr }}</td>
                        <td>{{ __('User(s)') }}</td>
                        <td class="text-center">
                          {{ $count_free_paid_employee_ids }}
                        </td>
                        <td class="text-right">
                          <span>₹</span>{{ $employee_price->value * $multiple * $count_free_paid_employee_ids }}
                        </td>
                      </tr>

                      @php
                          $sr++;
                      @endphp
                    @endif


                    @if($rechangeInfo)
                      <tr>
                        <td>{{ $sr }}</td>
                        <td>{{ __('Message Plans') }} [{{ $rechangeInfo['messages'] }} {{ __("Messages") }}]</td>
                        <td class="text-center">
                          -
                        </td>
                        <td class="text-right">
                          <span>₹</span>{{ $rechangeInfo['price'] }}
                        </td>
                      </tr>

                      @php
                          $sr++;
                      @endphp
                    @endif --}}

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
              <a href="{{ route('support.viewTransactionInvoice',$transaction->id) }}" class="btn btn-primary btn-icon icon-left"><i class="fas fa-eye"></i> View Invoice</a>
            </div>
            <div class="col-6 text-md-right invoice_button">
              <a href="{{ route('support.downloadTransactionHistory',$transaction->id) }}" class="btn btn-primary btn-icon icon-left"><i class="fas fa-download"></i> Download Invoice</a>
            </div>
          </div>
          
        </div>
    </div>

</section>

@endsection 