<script>
$(function() {
    /* Social Posts Chart Start */
    var ctx_social_cart = document.getElementById("social_cart").getContext('2d');

    var options_social_cart = {
        type: 'polarArea',
        data: {
            labels: ["Facebook", "Twitter"],
            datasets: [{
                label: 'Clicks',
                data: @json($socialChartData),
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
    /* Render Chart */
    var social_posts_graph = new Chart(ctx_social_cart, options_social_cart); 
    /* ********* END Social Posts Chart ************** */

});
</script>