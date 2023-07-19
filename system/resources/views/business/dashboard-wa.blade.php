@extends('layouts.business')
@section('title', 'Dashboard: Business Panel')

@section('head')
@include('layouts.partials.headersection',['title'=>'Dashboard'])

<style>
  .media-title, .media-title:hover {
    text-decoration: none;
    color: #237cd8 !important;
  }
  .media-title p{
    margin-bottom: 0px;
  }
  .icon_size i{
    font-size: 30px;
    line-height: 62px;
  }
  .icon_fb{
    background-color: #4267B2;
  }
  .icon{
    width: 60px;
    height: 60px;
    border-radius: 50%;
    margin: auto;
  }
  .icon_tw{
    background-color: #00ACEE;
  }
  .icon i::before{
    color: #ffffff;
  }
  .icon_ln{
    background-color: #0E76A8;
  }
  .click_text p{
    margin-bottom: 0;
    line-height: 18px;
  }
  .click_text span{
    font-size: 9px;
  }
</style>
@endsection

@section('content')

@if(Auth::user()->status == 1)
    <section class="section">

      <div class="row">

        <div class="col-xl-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1" data-toggle="tooltip" title="The number of overall clicks by users on your shared links.">
            <div class="card-icon bg-primary">
              <i class="fas fa-hand-pointer"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>{{__('Total Clicks')}}</h4>
              </div>
              <div class="card-body">
                {{ $clicksCount }}
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1" data-toggle="tooltip" title="Total number of registered users on your offers.">
            <div class="card-icon bg-dark">
              <i class="fas fa-users"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>{{__('Total Customers')}}</h4>
              </div>
              <div class="card-body">
                {{ $totalCustomers }}
              </div>
            </div>
          </div>
        </div>


        <div class="col-xl-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1" data-toggle="tooltip" title="The number of overall Unique clicks by users on your shared links.">
            <div class="card-icon bg-success">
              <i class="fas fa-hand-pointer"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>{{__('Total Unique Clicks')}}</h4>
              </div>
              <div class="card-body">
                {{ $total_unique_clicks }}
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1" data-toggle="tooltip" title="The number of overall Extra clicks by users on your shared links.">
            <div class="card-icon bg-warning">
              <i class="fas fa-hand-pointer"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>{{__('Total Extra Clicks')}}</h4>
              </div>
              <div class="card-body">
                {{ $total_extra_clicks }}
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="row">

        <!-- M & S Shares count -->
        <div class="col-lg-12 mb-4 order-lg-1">
          <div class="card mb-0 h-100">
            <div class="card-header">
              <h4>Make & Share Statistics</h4>
            </div>
            <div class="card-body">
               <canvas id="ms_statistic" height="130"></canvas> 
            </div>
          </div> 
        </div>


        {{-- Social Post Counts  --}}
        <div class="col-lg-7 order-lg-3 mb-4">
            <div class="card mb-0 h-100">
                <div class="card-header">
                  <h4>Social Post Clicks</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col mb-4 mb-lg-0 text-center icon_size">
                      <div class="icon icon_fb"><i class="fab fa-facebook"></i></div>
                      <div class="mt-2 font-weight-bold">Facebook</div>
                      <div class="text-small click_text">
                        <p class="text-primary">{{ $social_counts['fb_unique_count'] }}  <span class="text-muted">Unique Clicks</span></p> 
                        <p class="text-muted">{{ $social_counts['fb_extra_count'] }} <span class="">Extra clicks</span></p>
                      </div>
                    </div>
                    <div class="col mb-4 mb-lg-0 text-center icon_size">
                      <div class="icon icon_tw"><i class="fab fa-twitter"></i></div>
                      <div class="mt-2 font-weight-bold">Twitter</div>
                      <div class="text-small click_text">
                        <p class="text-primary">{{ $social_counts['tw_unique_count'] }}  <span class="text-muted">Unique Clicks</span></p> 
                        <p class="text-muted">{{ $social_counts['tw_extra_count'] }} <span class="text-muted">Extra clicks</span></p>

                      </div>
                    </div>
                    <div class="col mb-4 mb-lg-0 text-center icon_size">
                      <div class="icon icon_ln"><i class="fab fa-linkedin"></i></div>
                      <div class="mt-2 font-weight-bold">Linkedln</div>
                      <div class="text-small click_text">
                        <p class="text-primary">{{ $social_counts['li_unique_count'] }}  <span class="text-muted">Unique Clicks</span></p> 
                        <p class="text-muted">{{ $social_counts['li_extra_count'] }} <span>Extra clicks</span></p>

                      </div>
                    </div>
                </div>
              </div>
            </div>
        </div>

        <!-- WhatsApp message -->
        <div class="col-lg-5 col-md-6 mb-4 order-lg-2">
          <div class="card mb-0 h-100">
              <div class="card-header">
                <h4>WhatsApp Message Counts</h4>
              </div>
              <div class="card-body">
                <div class="position-relative">
                  <canvas id="pia_chart_wa" height="160"></canvas>
                </div>
              </div>
          </div>
        </div>

      </div> 


  </section>
  @endif
<input type="hidden" id="base_url" value="{{ url('/') }}">
<input type="hidden" id="site_url" value="{{ url('/') }}">
{{-- <input type="hidden" id="dashboard_perfomance" value="{{ url('/seller/dashboard/perfomance') }}"> --}}
{{-- <input type="hidden" id="dashboard_order_statics" value="{{ url('/seller/dashboard/order_statics') }}"> --}}
<input type="hidden" id="gif_url" value="{{ asset('assets/uploads/loader.gif') }}">
<input type="hidden" id="month" value="{{ date('F') }}">
@endsection
@push('js')
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.sparkline.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/seller/dashboard.js') }}"></script> --}}
    @include('business.graph-script')


<script>
/* Doughnut / Pia Char for WA Messages counts */
var total_wa_counts = {{$wp_counts['wp_success'] + $wp_counts['wp_pending'] + $wp_counts['wp_failed']}};

var wa_msg_ctx = document.getElementById("pia_chart_wa").getContext('2d');

var gradientSuccess = wa_msg_ctx.createLinearGradient(0, 0, 0, 150);
gradientSuccess.addColorStop(0, '#5aff15');
gradientSuccess.addColorStop(1, '#00b712');
var gradientPending = wa_msg_ctx.createLinearGradient(0, 0, 0, 150);
gradientPending.addColorStop(0, '#EFC616');
gradientPending.addColorStop(1, '#E8D527');
var gradientFailed = wa_msg_ctx.createLinearGradient(0, 0, 0, 150);
gradientFailed.addColorStop(0, '#EA4C46');
gradientFailed.addColorStop(1, '#F07470');
var doughnut_chart = new Chart(wa_msg_ctx, {
    type: 'doughnut',
	plugins: [{
      beforeDraw: function(chart, options) {
        var width = chart.chart.width,
          height = chart.chart.height,
          ctx = chart.chart.ctx;

        ctx.restore();
        var fontSize = (height / 150).toFixed(2);
        ctx.font = fontSize + "em 'Poppins', sans-serif";
        ctx.textBaseline = "middle";

        var Num = total_wa_counts,
            NumX = Math.round((width - ctx.measureText(Num).width) / 2),
            NumY = height / 2;

        ctx.fillText(Num, NumX, NumY - 5);
        ctx.save();
      },
      afterDraw: function(chart, options) {
        var width = chart.chart.width,
          height = chart.chart.height,
          ctx = chart.chart.ctx;

        ctx.restore();
        var fontSize = (height / 300).toFixed(2);
        ctx.font = "200 " + fontSize + "em 'Poppins', sans-serif";
        ctx.textBaseline = "middle";

        var text = "Messages",
            textX = Math.round((width - ctx.measureText(text).width) / 2),
            textY = height / 2;

        ctx.fillText(text, textX, textY + 12);
        ctx.save();
      },
    }],
    data: {
        labels: ["Success", "Pending", "Faild"],
        datasets: [{
            data: [{{ $wp_counts['wp_success'] }}, {{ $wp_counts['wp_pending'] }}, {{ $wp_counts['wp_failed'] }}],
            backgroundColor: [
                  gradientSuccess,
                  gradientPending,
                  gradientFailed,
            ],
            borderWidth: 0,
        }]
    },
    options: {
      legend:{
		display: false,
        position: 'bottom',
      },
      elements:{
        arc:{
          borderWidth: 0,
          borderJoinStyle: 'bevel'
        }
      },
      cutoutPercentage: 75
    }
});
</script>


<script>
    $(document).ready(function(){
 
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var data = {
            "_token" : CSRF_TOKEN
        };
        $.ajax({
            url : "{{ route('business.getGraphData') }}",
            type : 'get',
            data : data,
            dataType : "json",
            success : function(res) {
              console.log(res);
                var ctx = document.getElementById("ms_statistic").getContext('2d');
                var msChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels: res.labels,
                      datasets: [{
                          label: 'Unique Clicks',
                          data: res.unique,
                          backgroundColor: "#237cd8"
                      }, {
                          label: 'Extra Clicks',
                          data: res.extra,
                          backgroundColor: "rgba(0,0,0, 0.3)"
                      }],
                  },
                  options: {
                      scales: {
                          yAxes: [{
                              gridLines: {
                                  display: false,
                                  drawBorder: false,
                              },
                              ticks: {
                                  beginAtZero: true
                              },
                              scaleLabel: {
                                  display: true,
                                  labelString: 'Clicks'
                              }
                          }],
                          xAxes: [{
                              gridLines: {
                                  color: '#fbfbfb',
                                  lineWidth: 2
                              },
                              barThickness: 20,
                          }]
                      },
                      borderRadius: [10, 10, 10, 10]
                  },
                });
            }
        });
    });
</script>
@endpush