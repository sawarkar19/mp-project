<script>
$(function(){
    // Total Subscribers Start
    // let delayed1;
    var ctx_total_offer_challengers = document.getElementById("total_offer_challengers");

    var options_total_offer_challengers = {
        type: 'bar',
        data: {
            labels: @json($totalsubscriber7DaysDates),
            datasets:[
                {
                    label: 'Instant Challanges',
                    data: @json($totalsubscriber7DaysInstantChallanges),
                    backgroundColor: "rgba(35, 124, 216, 0.6)",
                    hoverBackgroundColor: "rgba(35, 124, 216, 1)",
                    borderRadius: 2,
                    barPercentage: 1,
                    categoryPercentage:0.3
                },
                {
                    label: 'Share Challanges',
                    data: @json($totalsubscriber7DaysShareChallanges),
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
            //         delayed1 = true;
            //     },
            //     delay: (context) => {
            //         let delay = 0;
            //         if (context.type === 'data' && context.mode === 'default' && !delayed1) {
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
                    }
                }
            },
        }
    };
    /* Render Chart */ 
    var total_offer_challengers = new Chart(ctx_total_offer_challengers, options_total_offer_challengers);
    

    /* --------- Data Between Dates Button Click events ----------- */
    /* 7 Day Click */
    $("#total_offer_challengers_btns .day7").on("click", function(event){
        event.preventDefault();

        var btn = $(this);

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var data = {
            "_token" : CSRF_TOKEN
        };
        $.ajax({
            url : "{{ route('business.last7DaysChallengers') }}",
            type : 'get',
            data : data,
            dataType : "json",
            success : function(res) {
                // btn.parent("#total_offer_challengers_btns").find(".active").removeClass("active");
                // btn.addClass("active");

                var labels = res.labels;
                var data = res.data;
                addChartData(total_offer_challengers, labels, data);
            }
        });  
    });
    
    $("#total_offer_challengers_btns .month1").on("click", function(event){
        event.preventDefault();

        var btn = $(this);

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var data = {
            "_token" : CSRF_TOKEN
        };
        $.ajax({
            url : "{{ route('business.last30DaysChallengers') }}",
            type : 'get',
            data : data,
            dataType : "json",
            success : function(res) {
                // btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                // btn.addClass("btn-primary");

                var labels = res.labels;
                var data = res.data;
                addChartData(total_offer_challengers, labels, data);
            }
        });
            
    });

    $("#total_offer_challengers_btns .year1").on("click", function(event){
        event.preventDefault();

        var btn = $(this);

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var data = {
            "_token" : CSRF_TOKEN
        };
        $.ajax({
            url : "{{ route('business.last365DaysChallengers') }}",
            type : 'get',
            data : data,
            dataType : "json",
            success : function(res) {
                // btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                // btn.addClass("btn-primary");

                var labels = res.labels;
                var data = res.data;
                addChartData(total_offer_challengers, labels, data);
            }
        });
            
    });

    $("#total_offer_challengers_btns .maxall").on("click", function(event){
        event.preventDefault();

        var btn = $(this);

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var data = {
            "_token" : CSRF_TOKEN
        };
        $.ajax({
            url : "{{ route('business.offerStartFromChallengers') }}",
            type : 'get',
            data : data,
            dataType : "json",
            success : function(res) {
                // btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                // btn.addClass("btn-primary");

                var labels = res.labels;
                var data = res.data;
                addChartData(total_offer_challengers, labels, data);
            }
        });
            
    });
}); 
</script>