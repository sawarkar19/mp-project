<script>
    $(function() {
        var win_screen = window.innerWidth;

        /* CHART DEFAULT SETTINS SET */
        Chart.defaults.font.family = 'Poppins';
        /* 
        * current offer statistics chart script start
        */
        var ctx_1 = document.getElementById("current_offer_chart");
        
        /* Creating a gradient. */
        var bg_gradient = ctx_1.getContext('2d').createLinearGradient(0, 0, 0, 150);
        bg_gradient.addColorStop(0, 'rgba(49, 206, 85,.25)');
        bg_gradient.addColorStop(1, 'rgba(49, 206, 85, 0)');

        var bg_gradient_2 = ctx_1.getContext('2d').createLinearGradient(0, 0, 0, 150);
        bg_gradient_2.addColorStop(0, 'rgba(252, 156, 22,.25)');
        bg_gradient_2.addColorStop(1, 'rgba(252, 156, 22, 0)');

        
        var data_unique = @json($currentOfferUniqueClicks);
    //   alert(data_unique);
    //   console.log(res)
        var data_total = @json($currentOfferTotalClicks);
        
        var co_options = {
            type: 'line',
            data: {
                labels: @json($currentOfferDates),
                datasets: [{
                    label: 'Unique Clicks',
                    data: data_unique,
                    fill: true,
                    backgroundColor: bg_gradient,
                    borderWidth: 2,
                    borderColor: 'rgba(49, 206, 85, 1)',
                    pointRadius: 5,
                    pointBorderWidth: 0,
                    pointBackgroundColor: 'rgba(49, 206, 85, .1)',
                    pointHoverBackgroundColor: 'rgba(49, 206, 85, 1)',
                },
                {
                    label: 'Total Clicks',
                    data: data_total,
                    fill: true,
                    backgroundColor: bg_gradient_2,
                    borderWidth: 2,
                    borderColor: 'rgba(252, 156, 22, 1)',
                    pointRadius: 5,
                    pointBorderWidth: 0,
                    pointBackgroundColor: 'rgba(252, 156, 22, .1)',
                    pointHoverBackgroundColor: 'rgba(252, 156, 22, 1)',
                }]
            },
            options: {
                maintainAspectRatio: false,
                elements:{
                    line:{
                        tension: .25
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
                        // display: false,
                        ticks: {
                            // display: false,
                        }
                    }
                },
            }
        };
        var current_offer_graph = new Chart(ctx_1, co_options); 


        /* ********* END Current Offer  statistic Chart ************** */





        /* ************  Current Offer Subscribers Start ************** */
        let delayed;
        var ctx_subsc = document.getElementById("current_offer_subscriberes");

        var subsc_options = {
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
                animation: {
                    onComplete: () => {
                        delayed = true;
                    },
                    delay: (context) => {
                        let delay = 0;
                        if (context.type === 'data' && context.mode === 'default' && !delayed) {
                        delay = context.dataIndex * 300 + context.datasetIndex * 100;
                        }
                        return delay;
                    },
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
                /* yaha */
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
                        // display: false,
                        ticks: {
                            // display: false,
                        }
                    }
                },
            }
        };
        var current_subscriberes = new Chart(ctx_subsc, subsc_options); /* Render Chart */
        /* ********* END - Subscribers Count ************ */





        /* 
        * Overall Clicks Data Graph/Chart Start
        */
        var ctx_2 = document.getElementById("clicks_data_chart");

        /* Checking the window size and if it is less than 575px it is setting the display_ticks
        variable to false. */
        var display_ticks = true;
        if(win_screen <= 575){
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
        var clicks_data_graph = new Chart(ctx_2, click_options); /* Render Chart */
        /* ********* END Overall Clicks Chart ************** */




        
        /* Social Posts Chart Start */
        var ctx_3 = document.getElementById("social_cart").getContext('2d');
        // var socialChartData = $socialChartData;
        
        var social_options = {
            type: 'polarArea',
            data: {
                labels: ["Facebook", "Twitter"],
                datasets: [{
                    label: 'Clicks',
                    data: @json($socialChartData),
                    // data: [1,1],
                    backgroundColor: ['rgba(66, 103, 178, 0.7)','rgba(29, 161, 242, 0.7)', 'rgba(10, 102, 194, 0.7)'],
                    hoverBackgroundColor: ['rgba(66, 103, 178, 1)','rgba(29, 161, 242, 1)', 'rgba(10, 102, 194, 1)'],
                    borderWidth:1,
                    borderColor: '#ffffff',
                }]
            },
            options: {
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
                scale: {
                   ticks:{
                    precision:0
                   }
                }, 
            }
        };
        var social_posts_graph = new Chart(ctx_3, social_options); /* Render Chart */
        /* ********* END Social Posts Chart ************** */





        /* 
        * messages chart start
        */

        var data_array = @json($channelMessages);

        var msg_lable_position = 'bottom';
        if(win_screen >= 480 && win_screen <= 991){
            var msg_lable_position = 'right';
        }
        let selectedDatasetIndex = undefined;
        let selectedIndex = undefined;
        var ctx_4 = document.getElementById("message_chart");
        var center_texts = {
            'id': 'center_texts',
            afterDraw(chart, args, options){
                const { ctx, chartArea:{left, right, top, bottom, width, height} } = chart;
                
                var sum_value = {{ $totalMessageSent }};
                var status_legends = [];
                var legends = chart.legend.legendItems;
                
                for (let i = 0; i < data_array.length; i++) {
                    status_legends.push(legends[i].hidden);
                }
                
                for (let index = 0; index < data_array.length; index++) {
                    if (status_legends[index] == true) {
                        sum_value = sum_value - data_array[index];

                        console.log("data_array[index] ", data_array[index]);
                    }
                }
                sum_value = Math.abs(sum_value);
                sum_value = sum_value.toFixed(2);

                ctx.save();
                ctx.font = 'bold 15px Poppins';
                ctx.fillStyle = 'rgba(0,0,0,0.9)';
                ctx.textAlign = 'center';
                ctx.fillText(sum_value, width / 2 + left, height / 2 + 22); 
                ctx.restore();

                ctx.font = 'normal 12px Poppins';
                ctx.fillStyle = 'rgba(0,0,0,0.7)';
                ctx.textAlign = 'center';
                ctx.fillText('Account balance used', width / 2 + left, height / 2 + 40);
                ctx.textBaseline = 'bottom';
                ctx.restore();
            }
        }
        
        var deductionsTitles = @json($deductionsTitles);
        var deductionsTitlesColors = ['#003f5c', '#7a5195', '#ef5675', '#ffa600', '#9F5343', '#509FEA'];
        
        var msg_options = {
            type: 'doughnut',
            data: {
                labels: deductionsTitles,
                datasets: [{
                    label: 'Clicks',
                    data: @json($channelMessages),
                    offset: -5,
                    hoverOffset: 1,
                    circumference: 240,
                    rotation:-120,
                    backgroundColor: deductionsTitlesColors,
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
                        display: true,
                        labels:{
                            usePointStyle: true,
                            pointStyle: 'circle',
                        },
                        onClick: (event, legendItem, legend) => {
                            Chart.controllers.doughnut.overrides.plugins.legend.onClick(event, legendItem, legend)
                        },    
                    }
                },
                layout: {
                    autoPadding: false
                },
            },
            plugins: [center_texts]
        };
        var message_graph = new Chart(ctx_4, msg_options); 
        /* ********* END Message Chart ************** */










        function addChartData(chart, labels, data) {
            chart.data.labels = labels
            chart.data.datasets.forEach((dataset, index) => {
                dataset.data = data[index];
            });
            chart.update();
        }

        $(document).on("click", "#last7Days", function(event){
            // alert("last7Days stastic")
            event.preventDefault();
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
                    
                    btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                    btn.addClass("btn-primary");
                    var labels = res.labels;
                    var data = res.data;
                    addChartData(clicks_data_graph, labels, data);
                }
            });
                
        });

        $(document).on("click", "#this_month", function(event){
            event.preventDefault();
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
                    console.log(res)
                    btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                    btn.addClass("btn-primary");
                    var labels = res.labels;
                    var data = res.data;
                    addChartData(clicks_data_graph, labels, data);
                }
            });
                
        });

        $(document).on("click", "#sbr_month", function(event){
            event.preventDefault();
            var btn = $(this);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token" : CSRF_TOKEN
            };
            $.ajax({
                url : "{{ route('business.lastMonth') }}",
                type : 'get',
                data : data,
                dataType : "json",
                success : function(res) {
                    // console.log(res)
                    btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                    btn.addClass("btn-primary");
                    var labels = res.labels;
                    var data = res.data;
                    addChartData(clicks_data_graph, labels, data);
                }
            });
                
        });

        $(document).on("click", "#sbr_year", function(event){
            event.preventDefault();
            var btn = $(this);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token" : CSRF_TOKEN
            };
            $.ajax({
                url : "{{ route('business.lastTwelveMonth') }}",
                type : 'get',
                data : data,
                dataType : "json",
                success : function(res) {
                    console.log(res)
                    btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                    btn.addClass("btn-primary");
                    var labels = res.labels;
                    var data = res.data;
                    addChartData(clicks_data_graph, labels, data);
                }
            });
                
        });

    });






    
    // Total Subscribers Start

        let delayed1;
        var ctx_challengers = document.getElementById("total_offer_challengers");


        var challengers_options = {
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
                animation: {
                    onComplete: () => {
                        delayed1 = true;
                    },
                    delay: (context) => {
                        let delay = 0;
                        if (context.type === 'data' && context.mode === 'default' && !delayed1) {
                        delay = context.dataIndex * 300 + context.datasetIndex * 100;
                        }
                        return delay;
                    },
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
                        // display: false,
                        ticks: {
                            // display: false,
                        }
                    }
                },
            }
        };
        var total_challengers = new Chart(ctx_challengers, challengers_options);  /* Render Chart */
    

        
        
        function addChartChallengeData(chart, labels, data) {

            chart.data.labels = labels
            chart.data.datasets.forEach((dataset, index) => {
                // console.log(index);
                dataset.data = data[index];
            });
            chart.update();
        }

        $(document).on("click", "#last7Days_challengers", function(event){
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
                   
                    btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                    btn.addClass("btn-primary");
                    var labels = res.labels;
                    var data = res.data;
                    addChartChallengeData(total_challengers, labels, data);
                }
            });
                
        });
        
        $(document).on("click", "#this_month_challengers", function(event){
            event.preventDefault();
            var btn = $(this);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token" : CSRF_TOKEN
            };
            $.ajax({
                url : "{{ route('business.thisMonthChallengers') }}",
                type : 'get',
                data : data,
                dataType : "json",
                success : function(res) {
                    
                    btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                    btn.addClass("btn-primary");
                    var labels = res.labels;
                    var data = res.data;
                    addChartChallengeData(total_challengers, labels, data);
                }
            });
                
        });

        $(document).on("click", "#sbr_month_challengers", function(event){
            event.preventDefault();
            var btn = $(this);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token" : CSRF_TOKEN
            };
            $.ajax({
                url : "{{ route('business.lastMonthChallengers') }}",
                type : 'get',
                data : data,
                dataType : "json",
                success : function(res) {
                    console.log(res)
                    btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                    btn.addClass("btn-primary");
                    var labels = res.labels;
                    var data = res.data;
                    addChartChallengeData(total_challengers, labels, data);
                }
            });
                
        });

        $(document).on("click", "#sbr_year_challengers", function(event){
            event.preventDefault();
            var btn = $(this);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {
                "_token" : CSRF_TOKEN
            };
            $.ajax({
                url : "{{ route('business.lastTwelveMonthChallengers') }}",
                type : 'get',
                data : data,
                dataType : "json",
                success : function(res) {
                    console.log(res)
                    btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                    btn.addClass("btn-primary");
                    var labels = res.labels;
                    var data = res.data;
                    addChartChallengeData(total_challengers, labels, data);
                }
            });
                
        });
    
        // Total Subscribers End

    /* Social Media impact current offer */
    var ctx_sm = document.getElementById("current_offer_social_reach").getContext('2d');
    
    var fb_comment_post_url_count = @json($fb_comment_post_url_count);
    var fb_like_post_url_count = @json($fb_like_post_url_count);
    var insta_like_post_url_count = @json($insta_like_post_url_count);
    var insta_comment_post_url_count = @json($insta_comment_post_url_count);
    var tw_tweet_url_count = @json($tw_tweet_url_count);
    var yt_like_url_count = @json($yt_like_url_count);
    var yt_comment_url_count = @json($yt_comment_url_count);

    var social_sm_options = {
        type: 'polarArea',
        data: {
            labels: ["Facebook Comment", "Facebook Like", "Instagram Comment", "Instagram Like", "Tweet Like", "Youtube Comment", "Youtube Like"],
            datasets: [{
                label: 'Clicks',
                data: [fb_comment_post_url_count, fb_like_post_url_count, insta_comment_post_url_count,insta_like_post_url_count, tw_tweet_url_count, yt_comment_url_count,yt_like_url_count,],
                backgroundColor: ['rgb(58, 85, 159, 0.7)', 'rgb(23, 115, 234, 0.7)', 'rgba(161, 52, 185, 0.7)', 'rgba(214,41,118, 0.7)', 'rgba(29, 161, 242, 0.7)', 'rgba(199, 31, 30, 0.7)', 'rgba(255, 0, 0, 0.7)'],
                hoverBackgroundColor: ['rgba(66, 103, 178, 1)', 'rgba(66, 103, 178, 1)', 'rgba(214,41,118, 1)', 'rgba(214,41,118, 1)', 'rgba(29, 161, 242, 1)', 'rgba(255, 0, 0, 1)', 'rgba(255, 0, 0, 1)'],
                // hoverBackgroundColor: ['rgba(66, 103, 178, 1)','rgba(29, 161, 242, 1)', 'rgba(10, 102, 194, 1)'],
                borderWidth:1,
                borderColor: '#ffffff',
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(0, 0, 0, 1)',
                    padding: 15,
                },
                legend: {
                    // display: false,
                    position: 'right',
                    labels:{
                        usePointStyle: true,
                        pointStyle: 'circle',
                    },
                },
            },
        }
    };
    var current_offer_social_reach = new Chart(ctx_sm, social_sm_options); /* Render Chart */
    /* ********* END Social Posts Chart ************** */


    /* ************ Overall Social reach Count ************** */
    var ctx_social = document.getElementById("overall__social_reach");

    var fb_page_url_count = @json($fb_page_url_count);
    var insta_profile_url_count = @json($insta_profile_url_count);
    var tw_username_count = @json($tw_username_count);
    var yt_channel_url_count = @json($yt_channel_url_count);
    var google_review_link_count = @json($google_review_link_count);
// alert(insta_profile_url_count);
    var social_options = {
        type: 'bar',
        data: {
            labels: ['Facebook Page Like', 'Instagram Followers', 'Twitter Followers', 'Youtube Subscribers', 'Google Reviews'],
            datasets:[
                {
                    // label: 'Instant',
                    data:[fb_page_url_count, insta_profile_url_count, tw_username_count, yt_channel_url_count, google_review_link_count],
                    // data:@json($fb_page_url_count),
                    // data:[6,7,3,2,1],
                    backgroundColor: ['rgba(66, 103, 178, 1)', 'rgba(214,41,118, 1)', 'rgba(29, 161, 242, 1)', 'rgba(255,0,0,1.0)', 'rgba(251,188,4,1.0)'],
                    // hoverBackgroundColor: "rgba(35, 124, 216, 1)",
                    borderRadius: 2,
                    barPercentage: 1,
                    categoryPercentage:0.3
                }
            ],
        },
        options: {
            maintainAspectRatio: false,
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
           /*  scales: {
                    y: {
                        // display: false,
                        ticks: {
                            precision:0
                            // stepSize:1
                            // display: false
                        },
                        // beginAtZero: true,
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
                }, */
            
        }
    };
    var overall__social_reach = new Chart(ctx_social, social_options); /* Render Chart */
    /* ********* END - Overall Social reach Count ************ */

</script>