<script>
$(function() {
    /* 
    * current offer statistics chart script start
    */
    var ctx_current_offer_chart = document.getElementById("current_offer_chart");
    
    /* Creating a gradient. */
    var bg_gradient = ctx_current_offer_chart.getContext('2d').createLinearGradient(0, 0, 0, 150);
    bg_gradient.addColorStop(0, 'rgba(49, 206, 85,.25)');
    bg_gradient.addColorStop(1, 'rgba(49, 206, 85, 0)');
    var bg_gradient_2 = ctx_current_offer_chart.getContext('2d').createLinearGradient(0, 0, 0, 150);
    bg_gradient_2.addColorStop(0, 'rgba(252, 156, 22,.25)');
    bg_gradient_2.addColorStop(1, 'rgba(252, 156, 22, 0)');

    var data_unique = @json($currentOfferUniqueClicks);
    var data_total = @json($currentOfferTotalClicks);
    var data_labels = @json($currentOfferDates);

    var options_current_offer_chart = {
        type: 'line',
        data: {
            labels: data_labels,
            datasets: [{
                label: 'Unique Clicks',
                data: data_unique,
                fill: true,
                backgroundColor: bg_gradient,
                borderWidth: 1,
                borderColor: 'rgba(49, 206, 85, 1)',
                pointRadius: 2,
                pointBorderWidth: 0,
                pointBackgroundColor: 'rgba(49, 206, 85, .1)',
                pointHoverBackgroundColor: 'rgba(49, 206, 85, 1)',
            },
            {
                label: 'Total Clicks',
                data: data_total,
                fill: true,
                backgroundColor: bg_gradient_2,
                borderWidth: 1,
                borderColor: 'rgba(252, 156, 22, 1)',
                pointRadius: 2,
                pointBorderWidth: 0,
                pointBackgroundColor: 'rgba(252, 156, 22, .1)',
                pointHoverBackgroundColor: 'rgba(252, 156, 22, 1)',
            }]
        },
        options: {
            maintainAspectRatio: false,
            elements:{
                line:{
                    tension: 0
                }
            },
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
                        precision:0,
                    },
                    beginAtZero: true,
                    suggestedMax: 5,
                },
                x: {
                    ticks: {
                        major:{
                            enabled: true
                        },
                        callback: function(value, index, ticks){
                            return get_lables_name(value, index, ticks, options_current_offer_chart)
                        },
                    },
                    grid: {
                        display: false
                    }
                }
            },
        }
    };

    /* --------- Rendering CHART ------------ */
    var current_offer_graph = new Chart(ctx_current_offer_chart, options_current_offer_chart); 


    /* --------- Data Between Dates Button Click events ----------- */
    /* 7 Day Click */
   

    $("#current_offer_chart_btns .day7").on("click", function(e) {
            e.preventDefault();

            var current_offer_id =  $("#current_offer_id").val();
            var btn = $(this);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token" : CSRF_TOKEN,
                "current_offer_id" : current_offer_id
            };
            $.ajax({
                url : "{{ route('business.last7daysCurrentOfferChart') }}",
                type : 'get',
                data : data,
                dataType : "json",
                success : function(res) {
                    // console.log(res)
                    // btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                    // btn.addClass("btn-primary");

                    var labels = res.labels;
                    var data = res.data;
                    addChartData(current_offer_graph, labels,data);
                }
            });
        });
    /* One Month Click */
 
    $("#current_offer_chart_btns .month1").on("click", function(e) {
            e.preventDefault();
            var current_offer_id =  $("#current_offer_id").val();
            var btn = $(this);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token" : CSRF_TOKEN,
                "current_offer_id" : current_offer_id
            };
            $.ajax({
                url : "{{ route('business.last30daysCurrentOfferChart') }}",
                type : 'get',
                data : data,
                dataType : "json",
                success : function(res) {
                    // btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                    // btn.addClass("btn-primary");
                    var labels = res.labels;
                    var data = res.data;
                    // alert(data);
                    addChartData(current_offer_graph, labels, data);
                }
            });
        });
    /* One Year Click */


    $("#current_offer_chart_btns .year1").on("click", function(e) {
            e.preventDefault();
            var btn = $(this);
            var current_offer_id =  $("#current_offer_id").val();

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token" : CSRF_TOKEN,
                "current_offer_id" : current_offer_id
            };
            $.ajax({
                url : "{{ route('business.last365daysCurrentOfferChart') }}",
                type : 'get',
                data : data,
                dataType : "json",
                success : function(res) {
                    // btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                    // btn.addClass("btn-primary");

                    var labels = res.labels;
                    var data = res.data;

                    addChartData(current_offer_graph, labels, data);
                }
            });
        });
    /* Max Click */
    $("#current_offer_chart_btns .maxall").on("click", function(e) {
            e.preventDefault();
            var btn = $(this);
            var current_offer_id =  $("#current_offer_id").val();

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token" : CSRF_TOKEN,
                "current_offer_id" : current_offer_id
            };
            $.ajax({
                url : "{{ route('business.offerStartFromCurrentOfferChart') }}",
                type : 'get',
                data : data,
                dataType : "json",
                success : function(res) {
                    // btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                    // btn.addClass("btn-primary");
                    
                    var labels = res.labels;
                    var data = res.data;
    
                    addChartData(current_offer_graph, labels,data);
                }
            });
        });

});
    /* ********* END Current Offer  statistic Chart ************** */

</script>