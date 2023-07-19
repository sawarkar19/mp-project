<script>
$(function() {
    /* ************  Current Offer Subscribers Start ************** */
    // let delayed;
    var ctx_current_offer_subscriberes = document.getElementById("current_offer_subscriberes");

    var options_current_offer_subscriberes = {
        type: 'bar',
        data: {
            labels: @json($current7DaysOfferDates),
            datasets:[
                {
                    label: 'Instant Challanges',
                    data: @json($current7DaysOfferUniqueClicks),
                    backgroundColor: "rgba(35, 124, 216, 0.6)",
                    hoverBackgroundColor: "rgba(35, 124, 216, 1)",
                    borderRadius: 2,
                    barPercentage: 1,
                    categoryPercentage:0.3
                },
                {
                    label: 'Share Challanges',
                    data: @json($current7DaysOfferTotalClicks),
                    backgroundColor: "rgba(58, 186, 244, 0.6)",
                    hoverBackgroundColor: "rgba(58, 186, 244, 1)",
                    borderRadius: 2,
                    barPercentage: 1,
                    categoryPercentage:0.3
                }
            ],
        },
        options: {
            maintainAspectRatio: false,
            // animation: {
            //     onComplete: () => {
            //         delayed = true;
            //     },
            //     delay: (context) => {
            //         let delay = 0;
            //         if (context.type === 'data' && context.mode === 'default' && !delayed) {
            //         delay = context.dataIndex * 300 + context.datasetIndex * 100;
            //         }
            //         return delay;
            //     },
            // },
            plugins: {
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(0, 0, 0, 1)',
                    padding: 15,
                },
                legend: {
                    display: false
                },
            },
            layout: {
                autoPadding: false
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                    ticks: {
                        precision:0
                    },
                    beginAtZero: true,
                    suggestedMax: 5,
                },
                x: {
                    ticks: {
                        // major:{
                        //     enabled: true
                        // },
                        callback: function(value, index, ticks){
                            return get_lables_name(value, index, ticks, options_current_offer_subscriberes)
                        },
                    }
                }
            },
        }
    };
    var current_subscriberes = new Chart(ctx_current_offer_subscriberes, options_current_offer_subscriberes); /* Render Chart */
    /* ********* END - Subscribers Count ************ */ 


    /* --------- Data Between Dates Button Click events ----------- */
    /* 7 Day Click */
   

       /* 7 Day Click */
       $("#current_offer_subscriberes_btns .day7").on("click", function(e) {
            e.preventDefault();

            var current_offer_id =  $("#current_offer_id").val();
            var btn = $(this);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token" : CSRF_TOKEN,
                "current_offer_id" : current_offer_id
            };
            $.ajax({
                url : "{{ route('business.last7daysCurrentOfferSubscriberes') }}",
                type : 'get',
                data : data,
                dataType : "json",
                success : function(res) {
                    // console.log(res)
                    // btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                    // btn.addClass("btn-primary");

                    var labels = res.labels;
                    var data = res.data;
                    addChartData(current_subscriberes, labels, data);
                }
            });
        });
    /* One Month Click */
   
      /* One Month Click */
      $("#current_offer_subscriberes_btns .month1").on("click", function(e) {
            e.preventDefault();
            var current_offer_id =  $("#current_offer_id").val();
            var btn = $(this);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token" : CSRF_TOKEN,
                "current_offer_id" : current_offer_id
            };
            $.ajax({
                url : "{{ route('business.last30daysCurrentOfferSubscriberes') }}",
                type : 'get',
                data : data,
                dataType : "json",
                success : function(res) {
                    // btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                    // btn.addClass("btn-primary");
                    var labels = res.labels;
                    var data = res.data;
                    addChartData(current_subscriberes, labels, data);
                }
            });
        });
    /* One Year Click */
 

    $("#current_offer_subscriberes_btns .year1").on("click", function(e) {
            e.preventDefault();
            var btn = $(this);
            var current_offer_id =  $("#current_offer_id").val();

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token" : CSRF_TOKEN,
                "current_offer_id" : current_offer_id
            };
            $.ajax({
                url : "{{ route('business.last365daysCurrentOfferSubscriberes') }}",
                type : 'get',
                data : data,
                dataType : "json",
                success : function(res) {
                    // btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                    // btn.addClass("btn-primary");

                    var labels = res.labels;
                    var data = res.data;

                    addChartData(current_subscriberes, labels, data);
                }
            });
        });
    /* Max Click */
  

    $("#current_offer_subscriberes_btns .maxall").on("click", function(e) {
            e.preventDefault();
            var btn = $(this);
            var current_offer_id =  $("#current_offer_id").val();

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token" : CSRF_TOKEN,
                "current_offer_id" : current_offer_id
            };
            $.ajax({
                url : "{{ route('business.offerStartFromCurrentOfferSubscriberes') }}",
                type : 'get',
                data : data,
                dataType : "json",
                success : function(res) {
                    // btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                    // btn.addClass("btn-primary");
                    
                    var labels = res.labels;
                    var data = res.data;
                    addChartData(clicks_data_graph, labels, data);
                }
            });
        });

});
</script>