<script>
$(function(){
    /* Social Media impact current offer */
    var ctx_current_offer_social_reach = document.getElementById("current_offer_social_reach").getContext('2d');
    
    var fb_comment_post_url_count = @json($fb_comment_post_url_count);
    var fb_like_post_url_count = @json($fb_like_post_url_count);
    var insta_like_post_url_count = @json($insta_like_post_url_count);
    var insta_comment_post_url_count = @json($insta_comment_post_url_count);
    var tw_tweet_url_count = @json($tw_tweet_url_count);
    var yt_like_url_count = @json($yt_like_url_count);
    var yt_comment_url_count = @json($yt_comment_url_count);

    var options_current_offer_social_reach = {
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
    var current_offer_social_reach = new Chart(ctx_current_offer_social_reach, options_current_offer_social_reach); /* Render Chart */
    /* ********* END Social Posts Chart ************** */
});
</script>