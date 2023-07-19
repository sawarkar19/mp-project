<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;chartset=utf-8">
        <title>MouthPublicity-Invoice</title>

        <style>
            *, ::after, ::before {
                box-sizing: border-box;
            }
            html, body{
                margin: 0;
                /* font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji"; */
                font-family: Arial, Helvetica, sans-serif;
                font-size: 1rem;
                /* line-height: 1.5; */
                -webkit-text-size-adjust: 100%;
                color: #212529;
                background-color: #fff;

                width: 100%;
                
            }

            h1, h2, h3, h4, h5, h6, p{
                margin-top: 0px;
                /* line-height: 1; */
            }

            .full-area{
              /* width: 2480px;
                min-height: 3508px; */
                /* width: 595px;
                min-height: 842px; */
                width: 955px;
                min-height: 1123px;
            }
            .inside-area{
                position: relative;
                width: 100%;
                padding:50px;
            }

            .head{
                display: table;
                /* flex-direction: row; */
                /* justify-content: space-between; */
                margin-bottom: 30px;
                width: 100%;
            }
            .head .logo{
                text-align: right;
            }
            .invoice-details{
                display: table;
                width: 100%;
                /* flex-direction: row; */
                /* justify-content: start; */
            }
            .ind-col{
                display: table-cell;
                width: 290px;
                padding-right: 25px;
                vertical-align: top;
            }
            .ind-col-50{
                display: table-cell;
                width: 450px;
            }
            .ind-col h5,
            .ind-col-50 h5{
                color: #617081;
                margin-bottom: 10px;
                text-transform: uppercase;
            }
            .ind-col p,
            .ind-col-50 p{
                color: #080808;
                font-weight: 400;
                margin-bottom: 10px;
            }

            table{
                width: 100%;
                text-align: left;
                border: 0px;
            }
            table tr > th,
            table tr > td{
                padding:10px 10px;
                border: 0px;
                line-height: 1;
                vertical-align: top;
            }
            table.list-table tr > th{
              text-align: left;
            }
            table.list-table tr > th,
            table.list-table tbody > tr:last-child > td{
                border-bottom: 1px solid rgba(0, 0, 0, 0.2);
            }
            ul{
                list-style: none;
                padding-left: 20px;
            }
            ul li{
                line-height: 1.5;
            }
            .capitalize{
              text-transform: capitalize;
            }

            table.less-padding tr td{
                padding: 8px 10px;
                vertical-align: middle;
                line-height: 1;
            }
        </style>
    </head>
    <body>
        
        <div class="full-area">
            <div class="inside-area">
                <div class="head">
                    <div style="display: table-cell;">
                        <h1>Invoice</h1>

                        <div class="invoice-details">
                            <div class="ind-col">
                                <h5>Invoice Number:</h5>
                                <p>{{ $transaction->invoice_no }}</p>
                            </div>
                            <div class="ind-col">
                                <h5>Invoice Date:</h5>
                                <p>{{ \Carbon\Carbon::parse($transaction->created_at)->format('j F, Y') }}</p>
                            </div>
                            <div class="ind-col" style="width: auto;"></div>
                        </div>

                    </div>
                    <div class="logo" style="display: table-cell;text-align:right;">
                        <img src="{{asset('assets/logic/logic-logo.png')}}" style="width: 200px;" alt="">
                    </div>
                </div>

                <div class="invoice-details">
                    <div class="ind-col-50" style="padding-right: 25px;">
                        <h5>Billed To:</h5>
                        @if ($transaction->gst_claim == 1)
                            <p><b>{{$transaction->gst_business_name}}</b></p>
                            <p>{{$transaction->gst_address}}, {{$transaction->gst_city}}, {{$transaction->state->name}} - {{$transaction->gst_pincode}}</p>
                            <p><small><u>GSTN</u></small>: {{$transaction->gst_number}}</p>
                        @else
                            @if(isset($business->business_name) && $business->business_name != '')
                                <p><b>{{ $business->business_name }}</b></p>
                            @else
                                <p><b>{{ $user->name }}<b></p>
                            @endif
                            @if(isset($business->city) && $business->city != '')
                                <p class="capitalize">{{ $business->address_line_1 }}, {{ $business->address_line_2 }}@if($business->address_line_2 != ''), @endif {{ $business->city }}, {{ $business->stateDetail->name }} - {{ $business->pincode }}</p>
                            @endif
                        @endif
                        
                        <p><small><u>E-mail</u></small>: {{ $user->email }}</p>
                        <p style="margin-bottom: 0px;"><small><u>Mobile</u></small>: {{ $user->mobile }}</p>
                    </div>
                    <div class="ind-col-50">
                        <h5>Bill From:</h5>
                        <p><b>Logic Innovates Pvt. Ltd</b></p>
                        <p class="capitalize">kranti surya nagar, katol road, nagpur, maharashtra - 440013, India.</p>

                        {{-- <h5>Contact:</h5> --}}
                        <p><small><u>E-mail</u></small>: care@mouthpublicity.io</p>
                        <p style="margin-bottom: 0px;"><small><u>Mobile</u></small>: +91 7887882244</p>
                    </div>

                    {{-- <div class="ind-col" style="width: 200px;">
                        <h5>Contact:</h5>
                        <p>care@mouthpublicity.io</p>
                        <p>+91 7887882244</p>
                    </div>
                    <div class="ind-col" style="width: auto;"></div> --}}
                </div>
            </div>

            <div class="">
                <div class="inside-area" style="background: #f5faff;">
                    <table class="list-table">
                        <tr>
                            <th>Plan Name</th>
                            {{-- <th style="width:120px;">Rate</th> --}}
                            {{-- <th style="width:80px;">Qty</th> --}}
                            <th style="text-align: right;width:120px;">Amount</th>
                        </tr>
                        <tbody>

                            <tr>
                                <td>MouthPublicity Recharge Plan</td>
                                <td style="text-align: right;width:120px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ $transaction->transaction_amount }}</td>
                            </tr>

                        {{-- @foreach($transaction->userplans_channel as $plan)
                        <tr>
                            <td>
                                {{ @$plan->channel->name }}
                                @if(count($plan->freeEmployee) > 0)
                                    <br />
                                    [ {{ count($plan->freeEmployee) }} {{ __('Free User(s)') }} ]
                                @endif
                            </td>
                            <td>
                                @if($transaction->employee_count > 0 && $plan->feature_id == 6)
                                    {{ $transaction->employee_count }}
                                @elseif($transaction->direct_transaction_count > 0 && $plan->feature_id == 7)
                                    {{ $transaction->direct_transaction_count }}
                                @else
                                    -
                                @endif
                            </td>
                            <td style="text-align: right;width:120px;">
                                <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ @$plan->channel->price * $plan_period->months }}
                            </td>
                        </tr>
                        @endforeach

                        @if($count_free_paid_employee_ids > 0)
                            @php
                            $multiple = 1;
                            if($empPlanData->is_default == 1){
                                $multiple = $empPlanData->months;
                            }
                            @endphp
                            <tr>
                                <td>{{ __('User(s)') }}</td>
                                <td>
                                    {{ $count_free_paid_employee_ids }}
                                </td>
                                <td style="text-align: right;width:120px;">
                                    <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ $employee_price->value * $multiple * $count_free_paid_employee_ids }}
                                </td>
                            </tr>
                        @endif


                        @if($rechangeInfo)
                            <tr>
                                <td>{{ __('Message Plans') }} [{{ $rechangeInfo['messages'] }} {{ __("Messages") }}]</td>
                                <td>-</td>
                                <td style="text-align: right;width:120px;">
                                    <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ $rechangeInfo['price'] }}
                                </td>
                            </tr>
                        @endif --}}

                        </tbody>
                        
                    </table>

                    <table style="text-align: right;margin-bottom:0px;" class="less-padding">
                        <tr>
                            <td>Sub Total</td>
                            <td style="width:120px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ $transaction->total_amount }}</td>
                        </tr>
                        @if($transaction->added_discount_amount >= 1)
                        <tr>
                            <td>Added Discount</td>
                            <td style="width:120px;">-<span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ $transaction->added_discount_amount }}</td>
                        </tr>
                        @endif

                        @if($transaction->promocode_amount >= 1)
                        <tr>
                            <td>Promo Code Discount</td>
                            <td style="width:120px;">-<span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ $transaction->promocode_amount }}</td>
                        </tr>
                        @endif

                        @php
                            // Calculate GST 
                            $gst = 0; $sgst = 0; $cgst = 0; $p_amo = $transaction->transaction_amount;

                            if ($transaction->transaction_amount >= 1){
                                $gst_18 = $transaction->transaction_amount - ($transaction->transaction_amount * (100/(100 + 18)));
                                $gst = round($gst_18, 2);
                                $sgst= round($gst/2, 2);
                                $cgst= round($gst/2, 2);

                                $p_amo = round($transaction->transaction_amount - $gst, 2);
                            }
                        @endphp

                        <tr>
                            <td >Taxable Amount</td>
                            <td style="border-top: 1px solid rgba(0, 0, 0, 0.2);width:120px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ $p_amo }}</td>
                        </tr>
                        
                        {{-- @if ($transaction->gst_claim) --}}
                            @if ($transaction->gst_state == 14)
                                {{-- if user check the Claim GST and select state (14) maharashtra Then, Show the SGST & CGST
                                    14 is a ID of the Maharashtra row from "states" --}}
                                <tr>
                                    <td>SGST(9%)</td>
                                    <td style="width:120px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ $sgst }}</td>
                                </tr>
                                <tr>
                                    <td>CGST(9%)</td>
                                    <td style="width:120px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ $cgst }}</td>
                                </tr>
                            @else
                                {{-- else if user not check Claim GST or Select other state will shown IGST  --}}
                                <tr>
                                    <td>IGST(18%)</td>
                                    <td style="width:120px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ $gst }}</td>
                                </tr>
                            @endif
                        {{-- @else
                            <tr>
                                <td>GST(18%)</td>
                                <td style="width:120px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ $gst }}</td>
                            </tr>
                        @endif --}}
                        
                        <tr>
                            <td>Paid Amount</td>
                            <td style="border-top: 1px solid rgba(0, 0, 0, 0.2);width:120px;"><b style="font-size:18px"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ $transaction->transaction_amount }}</b> </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="inside-area">
                <div class="invoice-details" style="justify-content: space-between;">
                    <div>
                        <div class="invoice-details">
                            {{-- <div class="ind-col">
                                <h5>Term:</h5>
                            </div> --}}
                            <div class="ind-col">
                                <h5>Account Details:</h5>
                                <p><b>Logic Innovates  Pvt. Ltd</b></p>
                                <p><span>GSTIN No.:</span> 27AAECL6399Q1ZG</p>
                                <p><span>SAC Code:</span> 998314</p>
                            </div>
                        </div>
                    </div>

                    <div class="ind-col" style="text-align: right;padding-right:0px;">
                        <h5>Invoice Total</h5>
                        <h6 style="margin-bottom: 10px;">(Including GST)</h6>
                        <h2><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ $transaction->transaction_amount }}</h2>
                    </div>
                </div>
            </div>

            <div class="inside-area" style="padding:0 50px 0 50px;">
              <p><small><i>This invoice is auto generated by the system. </i></small></p>
            </div>

        </div>

    </body>
</html>