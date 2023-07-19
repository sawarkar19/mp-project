<script>
$(function(){
    /* 
    * messages chart start
    */
    var bal_data_array = @json($channelMessages);
    var msg_lable_position = 'bottom';

    if(win_screen >= 480 && win_screen <= 991){
        var msg_lable_position = 'right';
    }

    let selectedDatasetIndex = undefined;
    let selectedIndex = undefined;

    var ctx_balance_chart = document.getElementById("balance_chart");
    var center_texts = {
        'id': 'center_texts',
        afterDraw(chart, args, options){
            const { ctx, chartArea:{left, right, top, bottom, width, height} } = chart;
            
            var sum_value = {{ $totalMessageSent }};
            var status_legends = [];
            var legends = chart.legend.legendItems;
            
            for (let i = 0; i < bal_data_array.length; i++) {
                status_legends.push(legends[i].hidden);
            }
            
            for (let index = 0; index < bal_data_array.length; index++) {
                if (status_legends[index] == true) {
                    sum_value = sum_value - bal_data_array[index];
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
    
    var options_balance_chart = {
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
    var message_graph = new Chart(ctx_balance_chart, options_balance_chart); 
    /* ********* END Message Chart ************** */
});
</script>