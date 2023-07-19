@extends('layouts.admin')
@section('title', 'Admin: Dashboard')
@section('content')
<style type="text/css">
  tr, th, td{
    border:1px solid #dcd7d7;
  }
  .gst-success,  
  .gst-danger{
    font-weight:bold;
    padding: 0.35rem 0.35rem;
    text-align: center;
  }
  .gst-success{
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
  }
  .gst-danger{
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
  }
</style>

<section class="section">


  <div class="row">

    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
          <i class="fas fa-users"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Total Subscribers</h4>
          </div>
          <div class="card-body">
            {{ $records['total_sub'] }}
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-success">
          <i class="fas fa-users"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Paid Subscribers</h4>
          </div>
          <div class="card-body">
            {{ count($records['paid_sub']) }}
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-danger">
          <i class="fas fa-hand-pointer"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Total Clicks</h4>
          </div>
          <div class="card-body">
            {{ $records['total_clicks'] }}
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-warning">
          <i class="far fa-file"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Extra Clicks</h4>
          </div>
          <div class="card-body">
            {{ $records['extra_clicks'] }}
          </div>
        </div>
      </div>
    </div>
    
  </div>
  {{-- first row end  --}}

  <div class="row">

    <!-- CHATRT -->
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h4>Subscribers</h4>

          <div class="card-header-action">
            <div class="btn-group">
              <a href="#" id="last7Days" class="btn btn-primary">Last 7 Days</a>
              <a href="#" id="sbr_month" class="btn">Last Month</a>
              <a href="#" id="sbr_year" class="btn">Last 12 Months</a>
            </div>
          </div>

        </div>

        <div class="card-body">
          <canvas id="subscribers_chart" height="150"></canvas>
        </div>

      </div>
    </div>

    {{-- Pi Chart  --}}
    <div class="col-lg-4">
      <div class="card">
        <div class="card-header">
          <h4>Subscription Plans</h4>
        </div>

        <div class="card-body">
          <canvas id="plans_chart" height="300"></canvas>
        </div>

      </div>
    </div>


  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header" style="display:block;">
          <h4>
            <span class="float-left">Latest Ten Transactions</span>
            <span class="float-right">
              <button class="btn btn-success">View All</button>
            </span>
          </h4>
        </div>
        <div class="card-body">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Invoice No</th>
                <th>Customer Name</th>
                <th>Date</th>
                <th>Transaction</th>
                <th>Amount</th>
                <th>GST Claimed</th>
              </tr>
            </thead>
            <tbody>
              @if($transactions)
                @foreach($transactions as $trans)
                @if($trans->user)
                <tr>
                  <td>{{ $trans->invoice_no }}</td>
                  <td>{{ $trans->user->name }}</td>
                  <td>{{ \Carbon\Carbon::parse($trans->created_at)->format('d M Y') }}</td>
                  <td>{{ $trans->transaction_id }}</td>
                  <td>{{ $trans->transaction_amount }}</td>
                  <td>
                    @if($trans->gst_claim == 1)
                    <div class="gst-success">
                      Yes
                    </div>
                    @else
                    <div class="gst-danger">
                      No
                    </div>
                    @endif
                    </td>
                </tr>
                @endif
                @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</section>

<input type="hidden" id="base_url" value="{{ url('/') }}">
<input type="hidden" id="site_url" value="{{ url('/') }}">
{{-- <input type="hidden" id="dashboard_static" value="{{ route('admin.dashboard.static') }}"> --}}
{{-- <input type="hidden" id="dashboard_perfomance" value="{{ url('/admin/dashboard/perfomance') }}">
<input type="hidden" id="dashboard_order_statics" value="{{ url('/admin/dashboard/order_statics') }}"> --}}
<input type="hidden" id="gif_url" value="{{ asset('assets/uploads/loader.gif') }}">
<input type="hidden" id="month" value="{{ date('F') }}">

@endsection

@push('js')
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.sparkline.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/index-0.js') }}"></script> --}}
    @include('admin.graph-script')
@endpush