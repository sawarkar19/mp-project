<script>
    $(function() {
        var win_screen = window.innerWidth;

        /* CHART DEFAULT SETTINS SET */
        Chart.defaults.font.family = 'Poppins';

        /* 
         * Overall Clicks Data Graph/Chart
         */
        var ctx_2 = document.getElementById("clicks_data_chart");

        /* Checking the window size and if it is less than 575px it is setting the display_ticks
        variable to false. */
        var display_ticks = true;
        if (win_screen <= 575) {
            var display_ticks = false;
        }

        /* Creating a gradient for the background of the line data. */
        var bg_gradient_unique = ctx_2.getContext('2d').createLinearGradient(0, 0, 0, 300);
        bg_gradient_unique.addColorStop(0, 'rgba(43, 107, 170,.25)');
        bg_gradient_unique.addColorStop(1, 'rgba(43, 107, 170, 0)');

        var bg_gradient_extra = ctx_2.getContext('2d').createLinearGradient(0, 0, 0, 300);
        bg_gradient_extra.addColorStop(0, 'rgba(252, 156, 22,.25)');
        bg_gradient_extra.addColorStop(1, 'rgba(252, 156, 22, 0)');

        var click_options = {
            type: 'line',
            data: {
                labels: @json($clickChartDates),
                datasets: [{
                        label: 'Unique Clicks',
                        data: @json($chartUniqueClicks),
                        fill: true,
                        backgroundColor: bg_gradient_unique,
                        borderWidth: 3,
                        borderColor: "rgba(0,36,156, 1)",
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
                    }
                ],
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
                        display: false,
                    },
                    x: {
                        display: 'auto',
                        ticks: {
                            display: display_ticks,
                        },
                        grid: {
                            drawTicks: false,
                        }
                    }
                },
            },
        };
        var clicks_data_graph = new Chart(ctx_2, click_options);

        function addChartData(chart, labels, data) {
            chart.data.labels = labels
            chart.data.datasets.forEach((dataset, index) => {
                // console.log(index);
                dataset.data = data[index];
            });
            chart.update();
        }

        $(document).on("click", "#last7Days", function(event) {
            event.preventDefault();
            var btn = $(this);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token": CSRF_TOKEN
            };
            $.ajax({
                url: "{{ route('admin.last7days') }}",
                type: 'get',
                data: data,
                dataType: "json",
                success: function(res) {
                    console.log(res);
                    btn.parent(".btn-group").find(".btn-primary").removeClass(
                        "btn-primary");
                    btn.addClass("btn-primary");
                    var labels = res.labels;
                    var data = res.data;
                    addChartData(clicks_data_graph, labels, data);
                }
            });

        });

        $(document).on("click", "#sbr_month", function(event) {
            event.preventDefault();
            var btn = $(this);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token": CSRF_TOKEN
            };
            $.ajax({
                url: "{{ route('admin.lastMonth') }}",
                type: 'get',
                data: data,
                dataType: "json",
                success: function(res) {
                    console.log(res)
                    btn.parent(".btn-group").find(".btn-primary").removeClass(
                        "btn-primary");
                    btn.addClass("btn-primary");
                    var labels = res.labels;
                    var data = res.data;
                    addChartData(clicks_data_graph, labels, data);
                }
            });

        });

        $(document).on("click", "#this_month", function(event) {
            event.preventDefault();
            var btn = $(this);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token": CSRF_TOKEN
            };

            $.ajax({
                url: "{{ route('admin.thisMonth') }}",
                type: 'get',
                data: data,
                dataType: "json",
                success: function(res) {
                    console.log(res)
                    btn.parent(".btn-group").find(".btn-primary").removeClass(
                        "btn-primary");
                    btn.addClass("btn-primary");
                    var labels = res.labels;
                    var data = res.data;
                    addChartData(clicks_data_graph, labels, data);
                }
            });

        });

        $(document).on("click", "#sbr_year", function(event) {
            event.preventDefault();
            var btn = $(this);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token": CSRF_TOKEN
            };
            $.ajax({
                url: "{{ route('admin.lastTwelveMonth') }}",
                type: 'get',
                data: data,
                dataType: "json",
                success: function(res) {
                    console.log(res)
                    btn.parent(".btn-group").find(".btn-primary").removeClass(
                        "btn-primary");
                    btn.addClass("btn-primary");
                    var labels = res.labels;
                    var data = res.data;
                    addChartData(clicks_data_graph, labels, data);
                }
            });

        });
        /* ********* END Overall Clicks Chart ************** */

        /* Checking the screen size and setting the position of the label. */
        var data_array = @json($data);
        var msg_lable_position = 'bottom';
        if (win_screen >= 480 && win_screen <= 991) {
            var msg_lable_position = 'right';
        }

        let selectedDatasetIndex = undefined;
        let selectedIndex = undefined;
        var ctx_4 = document.getElementById("plans_chart");
        var center_texts = {
            'id': 'center_texts',
            afterDraw(chart, args, options) {
                const {
                    ctx,
                    chartArea: {
                        left,
                        right,
                        top,
                        bottom,
                        width,
                        height
                    }
                } = chart;
                /* variable for total value and hidden status of legends*/
                var sum_value = {{ $total_challenge }};
                var status_legends = [];
                var legends = chart.legend.legendItems;
                /* push hidden */
                for (let i = 0; i < data_array.length; i++) {
                    status_legends.push(legends[i].hidden);
                }
                /*minus total value with data value if status true*/
                for (let index = 0; index < data_array.length; index++) {
                    if (status_legends[index] == true) {
                        sum_value = sum_value - data_array[index];

                        console.log("data_array[index] ", data_array[index]);
                    }
                }
                sum_value = Math.abs(sum_value);
                sum_value = sum_value.toFixed();

                ctx.save();
                ctx.font = 'bold 15px Poppins';
                ctx.fillStyle = 'rgba(0,0,0,0.9)';
                ctx.textAlign = 'center';
                ctx.fillText(sum_value, width / 2 + left, height / 2 +
                    22); /* Add below total number of message are send */
                ctx.restore();

                ctx.font = 'normal 12px Poppins';
                ctx.fillStyle = 'rgba(0,0,0,0.7)';
                ctx.textAlign = 'center';
                ctx.fillText('Total Challenge', width / 2 + left, height / 2 + 40);
                ctx.restore();
            }
        }

        var data_array = @json($data);
        var labels = @json($labels);
        var msg_options = {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Clicks',
                    data: data_array,
                    offset: -5,
                    hoverOffset: 1,
                    circumference: 240,
                    rotation: -120,
                    backgroundColor: ['#003f5c', '#ef5675'],
                    // backgroundColor: ['#282A53', '#40437F', '#6167B6', '#AEB2F1'],
                }]
            },
            options: {
                maintainAspectRatio: false,
                cutout: 60,
                plugins: {
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(0, 0, 0, 1)',
                        padding: 15,
                    },
                    legend: {
                        position: msg_lable_position,
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                        }
                    }
                },
                layout: {
                    autoPadding: false
                },
            },
            plugins: [center_texts]
        };
        var message_graph = new Chart(ctx_4, msg_options); /* Render Chart */
        /* ********* END Message Chart ************** */


        /* for total transaction and total deduction challengers */
        var ctx_challengers = document.getElementById("total_offer_challengers");
        var challengers_options = {
            type: 'bar',
            data: {
                labels: @json($currentchartDates),
                datasets: [{
                        label: 'Total Transaction',
                        data: @json($totalTransaction),
                        backgroundColor: "rgba(35, 124, 216, 0.6)",
                        hoverBackgroundColor: "rgba(35, 124, 216, 1)",
                        borderRadius: 2,
                        barPercentage: 1,
                        categoryPercentage: 0.3
                    },
                    {
                        label: 'Total Deduction',
                        data: @json($totalDeduction),
                        backgroundColor: "rgba(58, 186, 244, 0.6)",
                        hoverBackgroundColor: "rgba(58, 186, 244, 1)",
                        borderRadius: 2,
                        barPercentage: 1,
                        categoryPercentage: 0.3
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
                //             delay = context.dataIndex * 300 + context.datasetIndex * 100;
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
            }
        };
        var total_offer_challengers = new Chart(ctx_challengers, challengers_options);
        // total offer challengers end

        // for total offer details of challengers
        function addChartChallengeData(chart, labels, data) {
            chart.data.labels = labels
            chart.data.datasets.forEach((dataset, index) => {
                // console.log(index);
                dataset.data = data[index];
            });
            chart.update();
        }

        $(document).on("click", "#last7Days_challengers", function(event) {
            event.preventDefault();
            var btn = $(this);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token": CSRF_TOKEN
            };
            $.ajax({
                url: "{{ route('admin.currentGraphLast7days') }}",
                type: 'get',
                data: data,
                dataType: "json",
                success: function(res) {
                    console.log(res, "this is seven day");
                    btn.parent(".btn-group").find(".btn-primary").removeClass(
                        "btn-primary");
                    btn.addClass("btn-primary");
                    var labels = res.labels;
                    var data = res.data;
                    addChartChallengeData(total_offer_challengers, labels, data);
                }
            });

        });

        $(document).on("click", "#sbr_month_challengers", function(event) {
            event.preventDefault();
            var btn = $(this);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token": CSRF_TOKEN
            };
            $.ajax({
                url: "{{ route('admin.currentGraphLastMonth') }}",
                type: 'get',
                data: data,
                dataType: "json",
                success: function(res) {
                    console.log(res, "this is last month");
                    btn.parent(".btn-group").find(".btn-primary").removeClass(
                        "btn-primary");
                    btn.addClass("btn-primary");
                    var labels = res.labels;
                    var data = res.data;
                    addChartChallengeData(total_offer_challengers, labels, data);
                }
            });

        });

        $(document).on("click", "#this_month_challengers", function(event) {
            event.preventDefault();
            var btn = $(this);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token": CSRF_TOKEN
            };
            $.ajax({
                url: "{{ route('admin.currentGraphThisMonth') }}",
                type: 'get',
                data: data,
                dataType: "json",
                success: function(res) {
                    console.log(res, "this is month");
                    btn.parent(".btn-group").find(".btn-primary").removeClass(
                        "btn-primary");
                    btn.addClass("btn-primary");
                    var labels = res.labels;
                    var data = res.data;
                    addChartChallengeData(total_offer_challengers, labels, data);
                }
            });

        });

        $(document).on("click", "#sbr_year_challengers", function(event) {
            event.preventDefault();
            var btn = $(this);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token": CSRF_TOKEN
            };
            $.ajax({
                url: "{{ route('admin.currentGraphLastTwelveMonth') }}",
                type: 'get',
                data: data,
                dataType: "json",
                success: function(res) {
                    console.log(res, "this is last 12 month");
                    btn.parent(".btn-group").find(".btn-primary").removeClass(
                        "btn-primary");
                    btn.addClass("btn-primary");
                    var labels = res.labels;
                    var data = res.data;
                    addChartChallengeData(total_offer_challengers, labels, data);
                }
            });

        });
        // for total offer details of challengers end




        // $(document).ready(function() {
        //     var ctx = document.getElementById("plans_chart").getContext('2d');
        //     var sub_graph = document.getElementById("subscribers_chart").getContext('2d');
        //     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //     var subscribers;
        //     var data = {
        //         "_token": CSRF_TOKEN
        //     };
        //     $.ajax({
        //         url: "{{ route('admin.doughnutChart') }}",
        //         type: 'get',
        //         data: data,
        //         dataType: "json",
        //         success: function(res) {
        //             console.log(res);
        //             var plans_chart = new Chart(ctx, {
        //                 type: 'doughnut',
        //                 data: {
        //                     datasets: [{
        //                         data: res.data,
        //                         backgroundColor: res.backgroundColor,
        //                         label: 'Dataset 1'
        //                     }],
        //                     labels: res.labels,
        //                 },
        //                 options: {
        //                     responsive: true,
        //                     legend: {
        //                         position: 'bottom',
        //                     },
        //                 }
        //             });
        //         }
        //     });
        //     $.ajax({
        //         url: "{{ route('admin.getLast7days') }}",
        //         type: 'get',
        //         data: data,
        //         dataType: "json",
        //         success: function(res) {
        //             subscribers = new Chart(sub_graph, {
        //                 type: 'line',
        //                 data: {
        //                     labels: res.labels,
        //                     datasets: [{
        //                         label: res.datasets.label,
        //                         data: res.datasets.data,
        //                         backgroundColor: res.datasets
        //                             .backgroundColor,
        //                         borderWidth: res.datasets.borderWidth,
        //                         borderColor: res.datasets.borderColor,
        //                         pointRadius: res.datasets.pointRadius,
        //                         pointBackgroundColor: res.datasets
        //                             .pointBackgroundColor,
        //                         pointHoverBackgroundColor: res.datasets
        //                             .pointHoverBackgroundColor,
        //                         // hoverRadius: 20,
        //                     }]
        //                 },
        //                 options: {
        //                     legend: {
        //                         display: false
        //                     },
        //                     tooltips: {
        //                         mode: 'index',
        //                         intersect: false
        //                     },
        //                     hover: {
        //                         mode: 'index',
        //                         intersect: false
        //                     },
        //                     scales: {
        //                         yAxes: [{
        //                             gridLines: {
        //                                 display: false,
        //                                 drawBorder: false,
        //                             },
        //                             // ticks: {
        //                             //     stepSize: 50
        //                             // }
        //                         }],
        //                         xAxes: [{
        //                             gridLines: {
        //                                 color: '#fbfbfb',
        //                                 lineWidth: 2
        //                             }
        //                         }]
        //                     },
        //                 }
        //             });
        //         }
        //     });






    });
</script>
