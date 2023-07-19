<script>
    $(document).ajaxSend(function() {
        $("#overlay").fadeIn(300);　
    });

    $.validator.addMethod("validGooglemapLink", function(value, element) {
        const substring = "www.google.com/maps/place/";
        if(value.includes(substring) == false){
            return false;
        }
        else{
            return true;
        }
    }, 'Please enter valid google map link.');

    $(document).ready(function() {

        $('#instantform').validate({
            rules: {
                // facebook
                fb_page_url: {
                    required: true,
                    // url: true
                },
                fb_comment_post_url: {
                    required: true,
                    url: true
                },
                fb_like_post_url: {
                    required: true,
                    url: true
                },
                fb_share_post_url: {
                    required: true,
                    url: true
                },


                // insta
                insta_profile_url: {
                    required: true,
                    url: true
                },
                insta_post_url: {
                    required: true,
                    url: true
                },
                // twiter
                tw_username: {
                    required: true,
                },
                tw_tweet_url: {
                    required: true,
                    url: true
                },
                // linkedin
                li_company_url: {
                    required: true,
                    url: true
                },
                li_post_url: {
                    required: true,
                    url: true
                },

                // youtube
                yt_channel_url: {
                    required: true,
                    url: true
                },
                
                yt_like_url: {
                    required: true,
                    url: true
                },
                // yt_like_url: {
                //     required: '#yt_like_url_video:blank',
                //     url: true
                // },
                // yt_like_url_video: {
                //     required: '#yt_like_url_url:blank'
                // },
                
                yt_comment_url: {
                    required: true,
                    url: true
                },
                // yt_comment_url: {
                //     required: '#yt_comment_url_video:blank',
                //     url: true
                // },
                // yt_comment_url_video: {
                //     required: '#yt_comment_url:blank',
                // },

                // google
                google_review_link: {
                    required: true,
                    minlength: 20,
                    // url: true
                },
                google_map_link: {
                    required: true,
                    validGooglemapLink: true
                    // url: 'Please enter valid url!',
                },
                // website page
                visit_page_url: {
                    required: true,
                    url: true
                },

            },
            messages: {
                // facebook
                fb_page_url: {
                    required: 'Please enter page id!',
                    // url: 'Please enter valid url!',
                },
                fb_comment_post_url: {
                    required: 'Please enter url!',
                    url: 'Please enter valid url!',
                },
                fb_like_post_url: {
                    required: 'Please enter url!',
                    url: 'Please enter valid url!',
                },
                fb_share_post_url: {
                    required: 'Please enter url!',
                    url: 'Please enter valid url!',
                },

                // insta
                insta_profile_url: {
                    required: 'Please enter url!',
                    url: 'Please enter valid url!',
                },
                insta_post_url: {
                    required: 'Please enter url!',
                    url: 'Please enter valid url!',
                },
                // twiter
                tw_username: {
                    required: 'Please enter username!',
                },
                tw_tweet_url: {
                    required: 'Please enter url!',
                    url: 'Please enter valid url!',
                },
                // linkedin
                li_company_url: {
                    required: 'Please enter url!',
                    url: 'Please enter valid url!',
                },
                li_post_url: {
                    required: 'Please enter url!',
                    url: 'Please enter valid url!',
                },

                // youtube
                yt_channel_url: {
                    required: 'Please enter url!',
                    url: 'Please enter valid url!',
                },
                yt_like_url: {
                    required: 'Please enter url!',
                    url: 'Please enter valid url!',
                },
                // yt_like_url_video:{
                //     required: 'Please select video!',
                // },
                yt_comment_url: {
                    required: 'Please enter url!',
                    url: 'Please enter valid url!',
                },
                // yt_comment_url_video:{
                //     required: 'Please select video!',
                // },

                // google
                google_review_link: {
                    required: 'Please enter place id!',
                    minlength: 'Enter valid place id',
                    // url: 'Please enter valid url!',
                },
                google_map_link: {
                    required: 'Please enter google map link!',
                    // url: 'Please enter valid url!',
                },

                // website page
                visit_page_url: {
                    required: 'Please enter url!',
                    url: 'Please enter valid url!',
                },
            },
            submitHandler: function (form, e) {
                e.preventDefault();
                var isChannelActive = {{ $isChannelActive['status'] }}

                if(isChannelActive == 0){
                    var msg = "{{Config::get('constants.instant_challenge_status')}}"
                    Sweet("error", msg);
                    return false;
                }
                var btnSave = $('#save_btn');
                var btnDraft = $('#draft_btn');
                var btnSavehtml = btnSave.text();
                var btnDrafthtml = btnDraft.text();

                var formData = new FormData();

                formData.append('fb_page_url', $("input[name=fb_page_url]").val());

                formData.append('fb_comment_post_url', $("input[name=fb_comment_post_url]").val());
                
                formData.append('fb_like_post_url', $("input[name=fb_like_post_url]").val());

                formData.append('fb_share_post_url', $("input[name=fb_share_post_url]").val());

                formData.append('insta_profile_url', $("input[name=insta_profile_url]").val());

                formData.append('insta_post_url', $("input[name=insta_post_url]").val());

                formData.append('tw_username', $("input[name=tw_username]").val());

                formData.append('tw_tweet_url', $("input[name=tw_tweet_url]").val());

                formData.append('li_company_url', $("input[name=li_company_url]").val());

                formData.append('li_post_url', $("input[name=li_post_url]").val());

                formData.append('yt_channel_url', $("input[name=yt_channel_url]").val());

                formData.append('yt_like_url', $("input[name=yt_like_url]").val());
                // var yt_like_url_video = $("#yt_like_url_video")[0];
                // formData.append('yt_like_url_video', yt_like_url_video);

                formData.append('yt_comment_url', $("input[name=yt_comment_url]").val());
                // var yt_comment_url_video = $("#yt_comment_url_video")[0];
                // formData.append('yt_comment_url_video', yt_comment_url_video);

                formData.append('google_review_link', $("input[name=google_review_link]").val());
                formData.append('google_map_link', $("input[name=google_map_link]").val());

                formData.append('visit_page_url', $("input[name=visit_page_url]").val());

                formData.append('deleted_item', $("#deleted_item").val());

                $(".errorSocialLinks").html("");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    // url: this.action,
                    url: "{{ URL::to('business/channel/instant-reward/update-tasks') }}",
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData:false,
                    beforeSend: function() {                    
                        btnSave.attr('disabled','')
                        btnSave.html('Please Wait....')
                        btnDraft.attr('disabled','')
                        btnDraft.html('Please Wait....')
                    },
                    success: function(response){ 
                        $("#overlay").fadeOut(300);

                        // Update header setting status
                        $('.refresh-settings-status').click();

                        if(response.status == true){
                            $('#instantform').trigger('reset');
                            $("#preview_oi").attr("src", '');
                            Sweet('success',response.message);
                            window.location.href = response.redirect_url;
                        }else{
                            btnSave.removeAttr('disabled');
                            btnSave.html(btnSavehtml);
                            btnDraft.removeAttr('disabled');
                            btnDraft.html(btnDrafthtml);
                            
                            Sweet('error',response.message);
                            response.errors.forEach(element => {
                                $("#error_"+element.key).html("<p class='error'>"+element.msg+"</p>");
                            });
                        }

                        if(response.input != undefined){
                            $('input[name="'+response.input+'"]').focus();
                        }
                    },
                    error: function(xhr, status, error) 
                    {
                        $("#overlay").fadeOut(300);
                        // $.each(xhr.responseJSON.errors, function (key, item) 
                        // {
                        //     Sweet('error',item);
                        // });
                    }
                });
            }
        });


        // validate form
        
        // $("#instantform").on('submit', function(e){
        //     e.preventDefault();
        //     var btnSave = $('#save_btn');
        //     var btnDraft = $('#draft_btn');
        //     var btnSavehtml = btnSave.text();
        //     var btnDrafthtml = btnDraft.text();

        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     $.ajax({
        //         type: 'POST',
        //         url: this.action,
        //         data: new FormData(this),
        //         dataType: 'json',
        //         contentType: false,
        //         cache: false,
        //         processData:false,
        //         beforeSend: function() {                    
        //             btnSave.attr('disabled','')
        //             btnSave.html('Please Wait....')
        //             btnDraft.attr('disabled','')
        //             btnDraft.html('Please Wait....')
        //         },
        //         success: function(response){ 
        //             $("#overlay").fadeOut(300);

        //             if(response.status == true){
        //                 $('#instantform').trigger('reset');
        //                 $("#preview_oi").attr("src", '');
        //                 Sweet('success',response.message);
        //                 window.location.href = response.redirect_url;
        //             }else{
        //                 btnSave.removeAttr('disabled');
        //                 btnSave.html(btnSavehtml);
        //                 btnDraft.removeAttr('disabled');
        //                 btnDraft.html(btnDrafthtml);
                        
        //                 Sweet('error',response.message);
        //             }

        //             if(response.input != undefined){
        //                 $('input[name="'+response.input+'"]').focus();
        //             }
        //         },
        //         error: function(xhr, status, error) 
        //         {
        //             $("#overlay").fadeOut(300);
        //             $.each(xhr.responseJSON.errors, function (key, item) 
        //             {
        //                 Sweet('error',item);
        //             });
        //         }
        //     })
        // });
    });

     $(".draft_btn").on('click', function(e){
        $('#is_draft').val(1);
    });

    $(".save_btn").on('click', function(e){
        $('#is_draft').val(0);
    });
</script>


<script>

    $( ".setDefaultCheckbox" ).on("click", function() {

        $(".setDefaultCheckbox").prop('checked', false);
        $(this).prop('checked', true);

        var offerID = $(this).attr("id");
        //console.log(offerID);

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: "{{url('business/set-default-instant')}}/" + offerID,
            data: {_token: CSRF_TOKEN},
            dataType: 'JSON',
            success: function(response){ 
                //console.log(response);
                $("#overlay").fadeOut(300);
                if(response.status == true){
                    Sweet('success',response.message);
                    
                    $(".default-tag").remove();
                    $("#grid_" + offerID).children(".article-header").append('<div class="default-tag">Default</div>');
                    $(".checkbox_gr_" + offerID).remove();

                }else{
                    Sweet('error',response.message);
                    setTimeout(function(){
                        location.reload();
                    },1000);
                }
            },
            error: function(xhr, status, error) 
            {
                $("#overlay").fadeOut(300);
                $.each(xhr.responseJSON.errors, function (key, item) 
                {
                    Sweet('error',item);
                });
            },
        });
    });

</script>