@extends('layouts.admin')
@section('title', 'Admin: Transactions')
@section('head') @include('layouts.partials.headersection', ['title' => 'Transactions']) @endsection
@section('content')

    <div class="row">
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-body">

                    <div class="float-right">
                        <form>
                            <div class="input-group mb-2">

                                <input type="text" id="src" class="form-control" placeholder="Search..." name="src"
                                    autocomplete="off" value="{{ $request->src ?? '' }}">
                                <select class="form-control selectric" name="term" id="term">
                                    <option value="name" @if ($request->name == 'name') selected @endif>
                                        {{ __('Search By Name') }}</option>
                                    <option value="transaction_id" @if ($request->term == 'transaction_id') selected @endif>
                                        {{ __('Search By Transaction Id') }}</option>
                                    {{-- <option value="email">{{ __('Search By Mail') }}</option> --}}

                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
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
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $index => $trans)
                                        <tr>
                                            <td>{{ $index + $transactions->firstItem() }}</td>
                                            <td>{{ $trans->user->name }}</td>
                                            <td>{{ $trans->invoice_no }}</td>
                                            <td>{{ \Carbon\Carbon::parse($trans->created_at)->format('d M Y') }}</td>
                                            <td>{{ $trans->transaction_id }}</td>
                                            <td class="text-center"><span
                                                    class="badge badge-success">{{ $trans->transaction_amount . " ₹"}}</span>
                                            </td>
                                            <td>
                                                @if ($trans->gst_claim == 1)
                                                    <span class="badge badge-success">{{ __('Yes') }}</span>
                                                @elseif ($trans->gst_claim == 0)
                                                    <span class="badge badge-danger">{{ __('No') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($trans->transaction_amount <= 0)
                                                    <span class="badge badge-warning">Free User</span>
                                                @else   
                                                   
                                                    <a href="{{ route('admin.customer.invoice', $trans->id) }}"
                                                        class="btn btn-success"> <i class="fas fa-eye"></i> View Invoice</a>
                                                    
                                                @endif  
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                        <div class="card-body">
                            <h3>{{ Config::get('constants.no_record_found') }}</h3>
                        </div>
                        @endif

                    </div>

                    {{ $transactions->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('end_body')
@endsection
