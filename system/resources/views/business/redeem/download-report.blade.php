<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;chartset=utf-8">
        <title>MouthPublicity - Redeem Report</title>

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

            .full-area{
              /* width: 2480px;
                min-height: 3508px; */
                /* width: 595px;
                min-height: 842px; */
                width: 1018px;
                min-height: 1123px;
            }
            .inside-area{
                position: relative;
                width: 100%;
                padding:0 20px 50px 20px;
            }

            h1, h2, h3, h4, h5, h6, p{
                margin-top: 0px;
                /* line-height: 1; */
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


            h5.title{
                color: #617081;
                margin-bottom: 10px;
                text-transform: uppercase;
            }
            p.text{
                color: #080808;
                font-weight: 400;
                margin-bottom: 10px;
                line-height: 1;
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


            .analytic-card{
                background-color: rgb(235, 244, 255);
                padding: 20px;
                border-radius: 10px;
            }

            .list-table{
                font-size: 0.8rem;
            }
            .list-table thead{
                background-color: #242d38;
            }
            .list-table thead > tr > th{
                color: #fff;
            }
            .list-table tbody tr:nth-of-type(odd){
                background-color: rgba(0, 0, 0, 0.02);
            }


            .table-bordered td, .table-bordered th {
                border: 1px solid #dee2e6;
            }

        </style>
    </head>
    <body>
        
        <div class="full-area">
            <div class="inside-area">

                <div class="head">
                    <div style="display: table-cell;">
                        <h2>Discount Report</h2>

                        <div>
                            <h5 class="title">Date:</h5>
                            <p class="text">{{$date_range}}</p>
                        </div>

                    </div>
                    <div class="logo" style="display: table-cell;text-align:right;">
                        <img src="{{asset('assets/emails/images/logo-dark.png')}}" style="width: 200px;" alt="MouthPublicity">
                    </div>
                </div>

                <hr>
                
                <div class="page-data">

                    <div class="data-analytics" style="margin-bottom:30px;">
                        <table cellpadding="0px" cellspacing="10px" border="0px">
                            <tr>
                                <td style="width:25%;padding:0px;">
                                    <div class="analytic-card">
                                        <p>Total Amount</p>
                                        <h3 style="margin-bottom:0px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{$total_amo}}</h3>
                                    </div>
                                </td>
                                <td style="width:25%;padding:0px;">
                                    <div class="analytic-card">
                                        <p>Recieved Amount</p>
                                        <h3 style="margin-bottom:0px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{$recieved_amo}}</h3>
                                    </div>
                                </td>
                                <td style="width:25%;padding:0px;">
                                    <div class="analytic-card">
                                        <p>Discounted Amount</p>
                                        <h3 style="margin-bottom:0px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{$discount_amo}}</h3>
                                    </div>
                                </td>
                                <td style="width:25%;padding:0px;">
                                    <div class="analytic-card">
                                        <p>Total Discount (%)</p>
                                        <h3 style="margin-bottom:0px;">{{$total_discounted}} %</h3>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    @if(count($records) >= 1)
                    <div class="data-list">
                        <div>
                            <p>All the list of customers who get the discount from MouthPublicity coupen code are as follow:</p>
                        </div>
                        <table style="" class="list-table" cellpadding="0px" cellspacing="0px">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>{{ __('Customer') }}</th>
                                    <th>{{ __('Offer') }}</th>
                                    <th>{{ __('Bill Amount') }}</th>
                                    <th>{{ __('Paid Amount') }}</th>
                                    <th>{{ __('Discount') }}</th>
                                    <th>{{ __('Discount Info') }}</th>
                                    <th>{{ __('Redeem At') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($records as $row)
                                <tr>
                                    <td>{{ $records->firstItem() + $loop->index }}</td>
                                    <td>{{ $row->subscription_details->customer->mobile }}</td>
                                    <td>
                                        <p style="margin-bottom: 3px;"><b>{{ $row->subscription_details->offer->uuid }}</b></p>
                                        @if ($row->subscription_details->offer->type == 'future')
                                            <p style="margin-bottom: 0px;"><small>(Share Challenge)</small></p>
                                        @else
                                            <p style="margin-bottom: 0px;"><small>(Instant Challenge)</small></p>
                                        @endif
                                    </td>
                                    <td>
                                        <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{ $row->actual_amount }}
                                    </td>
                                    <td>
                                        <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{ $row->redeem_amount }}
                                    </td>
                                    <td>
                                        <b><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{number_format($row->actual_amount - $row->redeem_amount, 2)}}</b>
                                    </td>
                                    <td>
                                        @php
                                            if ($row->discount_type == "Percentage") {
                                                $sufix = '%';
                                                $prefix = '';
                                            }else{
                                                $prefix = '<span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>';
                                                $sufix = '';
                                            }
                                        @endphp

                                        <p style="margin-bottom: 0px;" ><b>{!!$prefix!!} {{ $row->discount_value }}{{$sufix}}</b></p>

                                        @if ($row->discount_type == "Percentage")
                                            <small>(Percentage Discount)</small>
                                        @elseif ($row->discount_type == "Perclick")
                                            <small>(Cash Per Click Discount)</small>
                                        @elseif ($row->discount_type == "Fixed")
                                            <small>(Fixed Amount Discount)</small>
                                        @endif
                                    </td>
                                    <td>
                                        {{\Carbon\Carbon::parse($row->created_at)->format('d/m/Y - H:i')}}
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>

                        </table>
                    </div>
                    @endif

                    
                </div>


        </div>

    </body>
</html>