@extends('layouts.account')

@section('head')
    @include('layouts.partials.headersection', ['title' => 'Export Reports'])
@endsection
@section('end_head')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterangepicker.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">

                        <div class="col-lg-5 col-md-5 col-sm-5 col-8">
                            <div>
                                <form method="GET">
                                    <div class="form-group">
                                        <label>Date Range Picker</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>

                                            @if ($request->date)
                                                <input type="text" name="date" id="date"
                                                    value="{{ $request->date }}" class="form-control daterange-cus">
                                                
                                            @elseif ($financial_start_date . ' - ' . $financial_end_date)
                                                <input type="text" name="date" id="date"
                                                    value="{{ $financial_start_date . ' - ' . $financial_end_date }}"
                                                    class="form-control daterange-cus">
                                            @endif

                                                <div class="col-lg-2 col-md-2 col-sm-2 col-12">
                                                    <button class="btn btn-primary" type="submit">Apply</button>
                                                </div>
                                        </div>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12 mt-2">
                    <div class="card">
                        <div class="card-body p-0">

                            <div class="row justify-content-between align-items-center">
                                <div class="col-sm-4 col-12">
                                    <form>
                                        <div class="input-group mb-2">
                                            <select class="form-control selectric" name="no_of_users" id="no_of_users">
                                                <option value="10" @if ($request->no_of_users == '10') selected @endif>
                                                    {{ __('10') }}</option>
                                                <option value="25" @if ($request->no_of_users == '25') selected @endif>
                                                    {{ __('25') }}</option>
                                                <option value="50" @if ($request->no_of_users == '50') selected @endif>
                                                    {{ __('50') }}</option>
                                                <option value="100" @if ($request->no_of_users == '100') selected @endif>
                                                    {{ __('100') }}</option>
                                            </select>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit"><i
                                                        class="fas fa-search"></i></button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <form method="GET">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-12">
                                                <input type="hidden" name="export" id="export"
                                                    value="export" class="form-control">
                                                    <input type="hidden" name="date" id="date"
                                                    value="{{$request->date}}" class="form-control">
                                                <button class="btn btn-primary" type="submit">Export</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div> 

                            <div class="table-responsive">
                                @if (count($transactions) >= 1)
                                    <table class="table table-striped table-hover text-left table-borderless">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Sr No') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Invoice No') }}</th>
                                                <th>{{ __('Date') }}</th>
                                                <th>{{ __('Transaction Id') }}</th>
                                                <th>{{ __('Amount') }}</th>
                                                <th>{{ __('GST Claimed') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($transactions))
                                                <?php $count = 1; ?>
                                                @foreach ($transactions as $index => $trans)
                                                    <tr>
                                                        <td>{{ $transactions->perPage() * ($transactions->currentPage() - 1) + $count }}
                                                        </td>
                                                        <td>{{ $trans->user->name ?? 'Customer' }}</td>
                                                        <td>{{ $trans->invoice_no }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($trans->created_at)->format('d M Y') }}
                                                        </td>
                                                        <td>{{ $trans->transaction_id }}</td>
                                                        <td class="text-center"><span
                                                                class="badge badge-success">{{ '₹' . ' ' . $trans->transaction_amount }}</span>
                                                        </td>
                                                        <td>
                                                            @if ($trans->gst_claim == 1)
                                                                <span
                                                                    class="badge badge-success">{{ __('Yes') }}</span>
                                                            @elseif ($trans->gst_claim == 0)
                                                                <span
                                                                    class="badge badge-danger">{{ __('No') }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <?php $count++; ?>
                                                @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                @else
                                    <div class="card-body">
                                        <h3>{{ Config::get('constants.no_record_found') }}</h3>
                                    </div>
                                @endif

                            </div>

                            <div class="card-footer text-center">
                                {{ $transactions->appends(array_except(Request::query(), $request->no_of_users))->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- END WA CONNECTIN TAB  --}}
    </section>


@endsection
@push('js')
    <script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    {{-- Date Picker --}}

    <script>
        $(document).ready(function() {

            $('.daterange-cus').daterangepicker({
                locale: {
                    format: 'DD-MM-YYYY'
                },
                singleDatePicker: false,
                timePicker: false,
                autoUpdateInput: true,
                autoApply: true,

            });
        })
    </script>
@endpush