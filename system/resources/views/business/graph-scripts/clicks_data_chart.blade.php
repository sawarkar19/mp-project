<script>
    $(function() {
        /* 
        * Overall Clicks Data Graph/Chart Start
        */
        var ctx_clicks_data_chart = document.getElementById("clicks_data_chart");

        /* Checking the window size and if it is less than 575px it is setting the display_ticks
        variable to false. */
        var display_ticks = true;
        if(win_screen <= 575){
            var display_ticks = false;
        }

        /* Creating a gradient for the background of the line data. */
        var bg_gradient_unique = ctx_clicks_data_chart.getContext('2d').createLinearGradient(0, 0, 0, 300);
        bg_gradient_unique.addColorStop(0, 'rgba(43, 107, 170,.25)');
        bg_gradient_unique.addColorStop(1, 'rgba(43, 107, 170, 0)');

        var bg_gradient_extra = ctx_clicks_data_chart.getContext('2d').createLinearGradient(0, 0, 0, 300);
        bg_gradient_extra.addColorStop(0, 'rgba(252, 156, 22,.25)');
        bg_gradient_extra.addColorStop(1, 'rgba(252, 156, 22, 0)');

        var options_clicks_data_chart = {
            type: 'line',
            data: {
                labels: @json($clickChartDates),
                datasets: [{
                    label: 'Unique Clicks',
                    data: @json($chartUniqueClicks),
                    fill: true,
                    backgroundColor: bg_gradient_unique,
                    borderWidth: 3,
                    borderColor:"rgba(0,36,156, 1)",
                    pointRadius: 5,
                    pointBorderWidth: 0,
                    pointBackgroundColor: 'rgba(43, 107, 170, .15)',
                    pointHoverBackgroundColor: 'rgba(43, 107, 170, 1)',
                    tension: .3
                },
                {
                    label: 'Total Clicks',
                    data: @json($chartTotalClicks),
                    fill: true,
                    backgroundColor: bg_gradient_extra,
                    borderWidth: 3,
                    borderDash: [3, 3],
                    borderColor: 'rgb(252, 156, 22)',
                    pointRadius: 5,
                    pointBorderWidth: 0,
                    pointBackgroundColor: 'rgba(252, 156, 22, .15)',
                    pointHoverBackgroundColor: 'rgba(252, 156, 22, 1)',
                    tension: .3
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(0, 0, 0, 1)',
                        padding: 15,
                    },
                    legend: {
                        display: false,
                    },
                },
                layout: {
                    autoPadding: false
                },
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: {
                        // display: false,
                        ticks: {
                            precision:0
                            // stepSize:1
                            // display: false
                        },
                        beginAtZero: true,
                        suggestedMax: 5,
                    },
                    x: {
                        display: 'auto',
                        ticks:{
                            display: display_ticks,
                        },
                        grid:{
                            drawTicks: false,
                        }
                    }
                },
            },
        };
        var clicks_data_graph = new Chart(ctx_clicks_data_chart, options_clicks_data_chart); /* Render Chart */
        /* ********* END Overall Clicks Chart ************** */

    
        /* --------- Data Between Dates Button Click events ----------- */
        /* 7 Day Click */
        $("#clicks_data_chart_btns .day7").on("click", function(e) {
            e.preventDefault();

            var btn = $(this);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token" : CSRF_TOKEN
            };
            $.ajax({
                url : "{{ route('business.last7days') }}",
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
        /* One Month Click */
        $("#clicks_data_chart_btns .month1").on("click", function(e) {
            e.preventDefault();
            var btn = $(this);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token" : CSRF_TOKEN
            };
            $.ajax({
                url : "{{ route('business.thisMonth') }}",
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
        /* One Year Click */
        $("#clicks_data_chart_btns .year1").on("click", function(e) {
            e.preventDefault();
            var btn = $(this);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token" : CSRF_TOKEN
            };
            $.ajax({
                url : "{{ route('business.last365Days') }}",
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
        /* Max Click */
        $("#clicks_data_chart_btns .maxall").on("click", function(e) {
            e.preventDefault();
            var btn = $(this);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token" : CSRF_TOKEN
            };
            $.ajax({
                url : "{{ route('business.offerStartFromStaticGraph') }}",
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
        /* ********* END Current Offer  statistic Chart ************** */
    });
    </script>