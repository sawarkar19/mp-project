<script>
    var xyValues
    var ctx_2 = document.getElementById("clicks_data_chart");

    var click_options = {
        type: 'bar',
        data: {
            labels: @json($chartDates),
            datasets: [{
                label: "Dataset #1",
                backgroundColor: "rgba(54, 97, 235,0.8)",
                hoverBackgroundColor: "rgba(54, 97, 235,1)",
                barPercentage: 5,
                barThickness: 28,
                maxBarThickness: 30,
                minBarLength: 8,
                data: @json($totalTransaction)
            }],
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    ticks: {
                        stepSize: 200
                    },
                    stacked: true,
                    grid: {
                        display: false,
                        color: "rgba(255,99,132,0.2)"
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
        },
    };
    var clicks_data_graph = new Chart(ctx_2, click_options);


    function addChartData(chart, labels, data) {
        chart.data.labels = labels
        chart.data.datasets.forEach((dataset, index) => {
            dataset.data = data;
            console.log(dataset.data);
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
            url: "{{ route('account.last7days') }}",
            type: 'get',
            data: data,
            dataType: "json",
            success: function(res) {
                console.log(res)
                btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
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
            url: "{{ route('account.lastMonth') }}",
            type: 'get',
            data: data,
            dataType: "json",
            success: function(res) {
                console.log(res);
                btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                btn.addClass("btn-primary");
                var labels = res.labels;
                var data = res.data;
                addChartData(clicks_data_graph, labels, data);
            }
        });

    });

    {{--  $(document).on("click", "#this_month", function(event) {
        event.preventDefault();
        var btn = $(this);

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var data = {
            "_token": CSRF_TOKEN
        };
        $.ajax({
            url: "{{ route('account.thisMonth') }}",
            type: 'get',
            data: data,
            dataType: "json",
            success: function(res) {
                console.log(res)
                btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                btn.addClass("btn-primary");
                var labels = res.labels;
                var data = res.data;
                addChartData(clicks_data_graph, labels, data);
            }
        });

    });  --}}

    $(document).on("click", "#sbr_year", function(event) {
        event.preventDefault();
        var btn = $(this);

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var data = {
            "_token": CSRF_TOKEN
        };
        $.ajax({
            url: "{{ route('account.lastTwelveMonth') }}",
            type: 'get',
            data: data,
            dataType: "json",
            success: function(res) {
                console.log(res)
                btn.parent(".btn-group").find(".btn-primary").removeClass("btn-primary");
                btn.addClass("btn-primary");
                var labels = res.labels;
                var data = res.data;
                addChartData(clicks_data_graph, labels, data);
            }
        });

    });
</script>