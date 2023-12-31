<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;chartset=utf-8">
    <title>Invoice</title>
    
    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table.item {
            text-align: center;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            font-weight: bold;
            padding: 10px 0;
        }

        

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        body {
            font-family: DejaVu Sans;
        }

        /* RTL */
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }
        .text-left{
            text-align: left;
        }
        .text-right{
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0" style="font-family: DejaVu Sans;">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ url('/uploads/logo.png') }}">
                                
                            </td>
                            
                            <td>
                                <strong>Invoice No: </strong>{{ $info->order_no }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
           
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>

                            <td>
                               To <br>
                               Name: {{ $info->user->name ?? '' }}<br>
                               Email: {{ $info->user->email ?? '' }}<br>
                               Domain: {{ $user->user_domain->domain ?? '' }}<br>
                               Purchased At: {{ $info->created_at->format('Y-m-d') }}<br />
                               Expired At: {{ $info->will_expire_on }}<br />
                               {{-- @if(!empty($gst_code_cust->value))
                               GST Code: {{ $gst_code_cust->value ?? '' }}<br>
                               @endif
                               @if(!empty($hsn_code_cust->value))
                               HSN Code: {{ $hsn_code_cust->value ?? '' }}<br>
                               @endif --}}
                           </td>
                           

                           
                           
                           <td>
                            @if(!empty($company_info))
                            <strong>{{ $company_info->name }}</strong><br>
                            {{ $company_info->address }},{{ $company_info->city }}<br>
                            {{ $company_info->state }},{{ $company_info->country }}<br>
                            Postal Code: {{ $company_info->zip_code }}<br>
                            Email: {{ $company_info->email1 }}<br>
                            Phone: {{  $company_info->phone1 }}<br>
                            {{-- GST Code: {{ $gst_code->value ?? '' }}<br>
                            HSN Code: {{ $hsn_code->value ?? '' }}<br> --}}
                            @endif
                        </td>
                    </tr>                    
                    <tr>
                        <td>
                            Payment Status: <br>
                            @if(!empty($info->trasection_id))

                            @if($info->payment_method->status==2)
                            <div class="badge">Pending</div>
                            @elseif($info->payment_method->status==1)
                            <div class="badge">Paid</div>
                            @elseif($info->payment_method->status==0)
                            <div class="badge">Cancel</div>
                            @elseif($info->payment_method->status==3)
                            <div class="badge">Incomplete</div>
                            @endif

                            @endif

                        </td>

                        <td>
                            Payment Mode <br>
                             @if(!empty($info->trasection_id))
                            {{ $info->payment_method->method->name }} 
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <table class="item" style="font-family: DejaVu Sans;">
            <tbody>
                <tr class="heading">
                    <td class="text-left">Description</td>
                    <td class="text-right">Amount</td>
                </tr>
                @if(!empty($info->plan_info))
                <tr>
                    <td class="text-left">{{ $info->plan_info->name }}</td>
                    <td class="text-right">{{ amount_format($plan->price) }}</td>
                </tr>
                @endif
                        
                {{-- <?php                   
                  $order_price = $info->amount - $plan->price;
                  $cgst = $order_price / 2;
                  $sgst = $order_price - $cgst;
                ?>
                @if($state->value == 'Maharashtra')
                <tr>                    
                    <td class="text-right">CGST(9%):</td>
                    <td class="text-right"> {{ amount_format($cgst) }}</td>
                </tr>

                <tr>                    
                    <td class="text-right">SGST(9%):</td>
                    <td class="text-right"> {{ amount_format($sgst) }}</td>
                </tr>
                @endif

                @if($state->value != 'Maharashtra')
                <tr>                    
                    <td class="text-right">IGST(18%):</td>
                    <td class="text-right"> {{ amount_format($order_price) }}</td>
                </tr>
                @endif --}}
                <tr class="subtotal">
                    <td></td>
                    <td><hr></td>
                </tr>       
                <tr>
                    <td class="text-right">Total:</td>
                    <td class="text-right">{{ amount_format($info->amount) }}</td>
                </tr>
            </tbody>
        </table>
    </table>
</div>
</body>
</html>