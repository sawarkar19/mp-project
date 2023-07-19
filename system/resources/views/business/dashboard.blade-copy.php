@extends('layouts.business')
@section('title', 'Dashboard: Business Panel')

@section('head')
@include('layouts.partials.headersection',['title'=>'Dashboard'])

<style>
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

  
  .wa-used-counts{
    padding-left: 0;
    padding-right: 31px;
    position: relative;
    border-right: 1px solid #e7e7e7;
    height: 100%;
  }
  .wa-used-counts .wa-uc-inner {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
    text-align: center;
  }
  .wa-send-msg-counts .col:last-child .wa-used-counts{
    border-right: 0;
  }
  .wa-used-counts .wa-uc-title {
    color: var(--cl-prime);
    margin-bottom: 10px;
    display: block;
    position: relative;
    font-weight: 500;
  }
  .wa-used-counts .wa-uc-count {
    font-size: 26px;
    line-height: 1;
    color: #73879C;
  }
  .tile_count .wa-used-counts span {
    font-size: 11px;
  }

  .lh-1{
    line-height: 1.2!important;
  }
  .totalPostsSocial{
    position: relative;
    display: inline-block;
    width: 100%;
    max-width: 80px;
    border: 1px solid #82879c;
    text-align: center;
    margin: 10px 0;
    padding-top: 7px;
    padding-bottom: 3px;
    border-radius: 4px;
  }
  .totalPostsSocial span{
    position: absolute;
    top: 0;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #fff;
    line-height: 1;
    min-width: 58px;
  }
  .ofr-card{
      position: relative;
      display: flex;
      width: 100%;
      justify-content: space-between;
      border-radius: 4px;
      overflow: hidden;
      box-shadow: 1px 1px 8px 1px rgba(0, 0, 0, .1);
      background-color: #ffffff;
      margin-bottom: 15px;
  }
  .ofr-card .ofr-img{
      width: 30%;
      /* height: 100%; */
      position: relative;
      background-color: #f2f2f2;
      background-position: center;
      background-size: cover;
  }
  .ofr-card .ofr-body{
      width: 70%;
      position: relative;
      padding: 15px;
  }
  .ofr-card .ofr-title,
  .ofr-card  .ofr-text{
      line-height: 1.5;
      overflow: hidden;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      display: -webkit-box;
      width: 100%;
  }
  .ofr-card  .ofr-title{
      font-weight: 500!important;
      margin-bottom: 5px;
      font-size: 1rem
  }
  .ofr-card .ofr-date-flex{
      display: flex;
      justify-content: space-between;
      align-items: center;
  }

  .ofr-card p{
      line-height: 1.5!important;
  }
  .messagesHigh{
    box-shadow: 3px 3px 8px -2px #d3d3d3ba; 
    /*background-color: #0092a5; */
    padding: 5px 0px; 
    border-radius: 7px; 
    border: 1px solid #0092a5;
  }
</style>
@endsection

@section('content')

@if(Auth::user()->status == 1)
<section class="section">



  <div class="row">

    {{-- Social Post Counts  --}}
    <div class="col-lg-6 order-lg-2 mb-4">
      <div class="card mb-0 h-100">
        <div class="card-header">
          <h4 data-toggle="tooltip" title="See analytics of unique and extra clicks of social media post">Social Posts Clicks</h4>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col mb-4 mb-lg-0 text-center icon_size">
              <div class="icon icon_fb"><i class="fab fa-facebook"></i></div>
              <div class="mt-2 font-weight-bold">Facebook</div>
              <div class="text-small click_text">
                <div class="totalPostsSocial">
                  <span>Total Posts</span>
                  <p class="mb-0 lh-1">{{ $facebook_post_count }}</p>
                </div>
                <p class="text-primary lh-1 mb-2">{{ $social_counts['fb_unique_count'] }}<br><span class="text-muted">Unique Clicks</span></p> 
                <p class="text-muted lh-1">{{ $social_counts['fb_extra_count'] }}<br><span class="">Extra clicks</span></p>
              </div>
            </div>
            <div class="col mb-4 mb-lg-0 text-center icon_size">
              <div class="icon icon_tw"><i class="fab fa-twitter"></i></div>
              <div class="mt-2 font-weight-bold">Twitter</div>
              <div class="text-small click_text">
                <div class="totalPostsSocial">
                  <span>Total Posts</span>
                  <p class="mb-0 lh-1">{{ $twitter_post_count }}</p>
                </div>
                <p class="text-primary lh-1 mb-2">{{ $social_counts['tw_unique_count'] }}<br><span class="text-muted">Unique Clicks</span></p> 
                <p class="text-muted lh-1">{{ $social_counts['tw_extra_count'] }}<br><span class="text-muted">Extra clicks</span></p>
              </div>
            </div>
            <div class="col mb-4 mb-lg-0 text-center icon_size">
              <div class="icon icon_ln"><i class="fab fa-linkedin"></i></div>
              <div class="mt-2 font-weight-bold">Linkedln</div>
              <div class="text-small click_text">
                <div class="totalPostsSocial">
                  <span>Total Posts</span>
                  <p class="mb-0 lh-1">{{ $linkedin_post_count }}</p>
                </div>
                <p class="text-primary lh-1 mb-2">{{ $social_counts['li_unique_count'] }}<br><span class="text-muted">Unique Clicks</span></p> 
                <p class="text-muted lh-1">{{ $social_counts['li_extra_count'] }}<br><span>Extra clicks</span></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- WhatsApp message -->
    <div class="col-lg-6 col-md-6 mb-4 order-lg-1">
      <div class="card mb-0 h-100">
          <div class="card-header">
            <h4 data-toggle="tooltip" title="See analytics of success, pending and failed whatsapp message">Current Offer</h4>
          </div>
          <div class="card-body">
            <!-- <div class="position-relative">
              <canvas id="pia_chart_wa" height="160"></canvas>
            </div> -->
            <div class="ofr-card">
                <div class="ofr-img" style="background-image: url('https://openlink.co.in/assets/offer-thumbnails/thumb-24052022061810.jpg');"> </div>
                <div class="ofr-body">
                    <div>
                        <p class="ofr-title">Vestibulum imperdiet odio sed neque ultricies, ut dapibus mi maximus</p>
                        <p class="ofr-text mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis aliquid autem ex accusantium voluptates soluta distinctio eos facere nesciunt, doloremque, beatae non voluptas dolorum, voluptatum fuga omnis earum ducimus sequi.</p>
                    </div>
                    <div class="mb-2">
                        <span class="badge badge-warning py-1">Upcoming</span> {{-- <span class="badge badge-success py-1">Posted</span> --}}
                    </div>
                    <div>
                        <div class="ofr-date-flex">
                            <p class="mb-0">Start: <strong class="text-primary">01 Aug 2022</strong></p>
                            <p class="mb-0">End: <strong class="text-primary">31 Aug 2022</strong></p>
                        </div>
                    </div>
                </div>
            </div>

          </div>
      </div>
    </div>
  
  </div>

  <div class="row">
    <div class="col-lg-12 mb-4">
      <div class="card mb-0 h-100">
        <div class="card-header">
          <h4>Messages Balance</h4>
        </div>
        <div class="card-body">
          <div class="row wa-send-msg-counts justify-content-between">
            <!-- <div class="col-lg-1 col-sm-2 col-3 mb-4 px-0"></div> -->
            <div class="col-lg-2 col-sm-4 col-6 mb-4 px-0">
                <div class="wa-used-counts" style="padding-left: 9px; padding-right: 17px;">
                  <div class="wa-uc-inner messagesHigh">
                    <span class="wa-uc-title">Messages</span>
                    <div class="wa-uc-count" style="font-size: 28px;font-weight: 500;">{{ $commonCount }}</div>
                    <span style="font-weight: 400;padding-top: 2px;"> Out of <span>
                      @empty($messageWallet)
                        {{ '0' }}
                      @else
                        {{ $messageWallet->recharge_wallet }}
                      @endempty
                      </span> </span>
                      <span class="small">Valid upto 31/07/22</span>
                  </div>
                </div>
              </div>
              
              <div class="col-lg-2 col-sm-4 col-6 mb-4 px-0">
                <div class="wa-used-counts">
                  <div class="wa-uc-inner">
                    <span class="wa-uc-title">Share Challenge</span>
                    <div class="wa-uc-count">{{ $sharerewardsCount }}</div>
                    <span class="small"> Used from <span>
                      @empty($messageWallet)
                        {{ '0' }}
                      @else
                        {{ $messageWallet->share_rewards_wallet }}
                      @endempty
                    </span></span>
                  </div>
                </div>
              </div>
              <div class="col-lg-2 col-sm-4 col-6 mb-4 px-0">
                <div class="wa-used-counts">
                  <div class="wa-uc-inner">
                    <span class="wa-uc-title">Instant Challenge</span>
                    <div class="wa-uc-count">{{ $instantrewardsCount }}</div>
                    <span class="small"> Used from <span>
                      @empty($messageWallet)
                        {{ '0' }}
                      @else
                        {{ $messageWallet->instant_rewards_wallet }}
                      @endempty
                      </span></span>
                  </div>
                </div>
              </div>
              <div class="col-lg-2 col-sm-4 col-6 mb-4 px-0">
                <div class="wa-used-counts">
                  <div class="wa-uc-inner">
                    <span class="wa-uc-title">Personalised Messaging</span>
                    <div class="wa-uc-count">{{$d2cCount}}</div>
                    <span class="small"> Used from <span>
                      @empty($messageWallet)
                        {{ '0' }}
                      @else
                        {{ $messageWallet->d2c_post_wallet }}
                      @endempty
                      </span></span>
                  </div>
                </div>
              </div>
              <div class="col-lg-2 col-sm-4 col-6 mb-4 px-0">
                <div class="wa-used-counts">
                  <div class="wa-uc-inner">
                    <span class="wa-uc-title">API</span>
                    <div class="wa-uc-count">{{ $apiCount }}</div>
                    <span class="small"> Used from <span>
                      @empty($messageWallet)
                        {{ '0' }}
                      @else
                        {{ $messageWallet->openlink_api_wallet }}
                      @endempty
                      </span></span>
                  </div>
                </div>
              </div>
              <!-- <div class="col-lg-1 col-sm-2 col-3 mb-4 px-0"></div>  -->
          </div>
        </div>
      </div>
    </div>
  </div>
  
    
  
    
      <div class="row">
        
        <!-- Statistics All offres clicks  -->
        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
          <div class="pb-4 h-100">
            <div class="card mb-0 h-100">
                <div class="card-header justify-content-between">
                    <div>
                      <h4 class="d-inline">Statistics</h4>
                      <a href="#" class="info-btn" data-toggle="tooltip"  title="This graph shows the number of total clicks on your overall campaigns."><i class="fa fa-question-circle"></i></a>
                    </div>
                    <div class="card-header-action">
                        <div class="btn-group">
                            <a href="#" id="last7Days" class="btn btn-primary">Current 7 Days</a>
                            <a href="#" id="sbr_month" class="btn">Last Month</a>
                            <a href="#" id="sbr_year" class="btn">Last 12 Months</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="clicksCounts" height="180"></canvas>
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
        labels: ["Successfully Sent", "Pending Messages", "Failed Messages"],
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