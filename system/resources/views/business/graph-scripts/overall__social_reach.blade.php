<script>
$(function() {
    /* ************ Overall Social reach Count ************** */
    var ctx_overall__social_reach = document.getElementById("overall__social_reach");

    var fb_page_url_count = @json($fb_page_url_count);
    var insta_profile_url_count = @json($insta_profile_url_count);
    var tw_username_count = @json($tw_username_count);
    var yt_channel_url_count = @json($yt_channel_url_count);
    var google_review_link_count = @json($google_review_link_count);

    var options_overall__social_reach = {
        type: 'bar',
        data: {
            labels: ['Facebook Page Like', 'Instagram Followers', 'Twitter Followers', 'Youtube Subscribers', 'Google Reviews'],
            datasets:[
                {
                    // label: 'Instant',
                    data:[fb_page_url_count, insta_profile_url_count, tw_username_count, yt_channel_url_count, google_review_link_count],
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
        }
    };
    var overall__social_reach = new Chart(ctx_overall__social_reach, options_overall__social_reach); /* Render Chart */
    /* ********* END - Overall Social reach Count ************ */
});
</script>