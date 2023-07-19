@extends('layouts.account')

@section('head')
    @include('layouts.partials.headersection', ['title' => 'Payment Gateways'])
@endsection

@section('end_head')
    <style>
        @media (max-width: 767.98px) {

            .card .card-header h4+.card-header-action,
            .card .card-header h4+.card-header-form {
                width: auto;
            }
        }
    </style>
@endsection

@section('content')
    <section class="section">

        <div class="section-body">
            <div class="row">

                @if (count($payment_gateways) >= 1)
                        @foreach ($payment_gateways as $gateway)
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h4>{{ $gateway->name }}</h4>
                                        <div class="card-header-action">
                                            <div class="badges">

                                                @if ($gateway->status === 1)
                                                    <span class="badge badge-success m-0">{{ __('Active') }}</span>
                                                @else
                                                    <span class="badge badge-danger m-0">{{ __('Inactive') }}</span>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-1">
                                        
                                        @if ($gateway->preview)
                                        <img src="{{ asset('assets/' .$gateway->preview->content) }}"
                                        style="width: 120px;max-width:100%;">
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    
                @else
                    <div class="card-body">
                        <h3>{{ Config::get('constants.no_record_found') }}</h3>
                    </div>
                @endif
            </div>

            {{-- WA CONNECTIN TAB  --}}

            <!-- <div class="col-12 col-md-8 col-lg-8 col-xl-8">

                            <div class="card mb-0 h-100">
                                <div class="card-header">
                                  <h4>Settings</h4>
                                  
                                </div>
                                <div class="card-body p-0">
                                  <div class="table-responsive">
                                        <table class="table table-striped text-center">
                                            <thead>
                                                <tr>
                                                    <th>SR. NO.</th>
                                                    <th>PAYMENT GATEWAY</th>
                                                <tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>RazorPay</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>CashFree</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>PayPal</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Paytm</td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Cheque</td>
                                                </tr>
                                                        
                                            </tbody>
                                        </table>
                                    
                                    </div>
                                </div>
                            </div>
                        </div> -->




            {{-- END WA CONNECTIN TAB  --}}
        </div>
    </section>
@endsection

@push('js')
    <script src="{{ asset('assets/js/form.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/input-validation.js') }}"></script>
@endpush
@section('end_body')
@endsection
