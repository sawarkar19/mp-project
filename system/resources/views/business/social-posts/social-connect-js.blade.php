
<script>


    var isFacebookCheck = '{{ $isFacebookCheck ?? 0 }}';
    var isFacebookConnected = '{{ $isFacebookConnected ?? 0 }}';
    var facebook_page_id = '{{ @$userSocialConnection->facebook_page_id ?? NULL }}';

    function connectGoogleReview(){
        var htmlTag = '<h4>Enter details for Google review </h4>';
        htmlTag += '<hr />';
        htmlTag += '<div class="text-left">Place Id <a href="#" class="info-btn" data-toggle="modal" data-target="#google_details_modal" data-backdrop="static" data-keyboard="false"><i class="fa fa-info-circle"></i></a></div>';
        htmlTag += '<input type="text" id="googlereview_placeid" class="form-control" placeholder="Ex. ChIJ339JWrTB1DsROneeiQgmhr4">';

        htmlTag += '<div class="text-left mt-1">Google Map Link <a href="#" class="info-btn" data-toggle="modal" data-target="#google_map_link_modal" data-backdrop="static" data-keyboard="false"><i class="fa fa-info-circle"></i></a></div>';
        htmlTag += '<input type="text" id="googlereview_maplink" class="form-control" placeholder="Ex. https://www.google.com/maps/">';

        swal.fire({
            html: htmlTag,
            // html: `<h4>Enter Google review place id <a href="#" class="info-btn" data-toggle="modal" data-target="#google_details_modal" data-backdrop="static" data-keyboard="false"><i class="fa fa-info-circle"></i></a></h4><input type="text" id="googlereview_placeid" class="swal2-input" placeholder="Ex. ChIJ339JWrTB1DsROneeiQgmhr4">`,
            confirmButtonText: 'Connect',
            focusConfirm: false,
            showCancelButton: !0,
            cancelButtonText: "Close",
            allowOutsideClick: false,
            reverseButtons: !0,
            preConfirm: () => {
                const review_placeid = Swal.getPopup().querySelector('#googlereview_placeid').value;
                const review_maplink = Swal.getPopup().querySelector('#googlereview_maplink').value;
                const substring = "www.google.com/maps/place/";

                if(review_placeid == '' || review_placeid.length < 10){
                    Swal.showValidationMessage("Please enter valid place id");
                    // Sweet('error', "Please enter place id");
                    return false;
                }

                if(review_maplink == ''){
                    Swal.showValidationMessage("Please enter google map link");
                    return false;
                }

                if(review_maplink.includes(substring) == false){
                    Swal.showValidationMessage("Please enter valid google map link");
                    return false;
                }

                return { review_placeid: review_placeid, review_maplink:review_maplink }
            }
        }).then(function (e) {
            // console.log("Enter Name", e.value.review_placeid);
            // alert(e.value.review_placeid);
            if(e.value.review_placeid){
                var socialAccount = "google";
                var review_placeid = e.value.review_placeid;
                var review_maplink = e.value.review_maplink;
                $.ajax({
                    url: '{{ URL::to("business/connect-social-media") }}',
                    type: "POST",
                    data: {
                        _token: CSRF_TOKEN,
                        review_placeid: review_placeid,
                        socialAccount: socialAccount,
                        review_maplink: review_maplink,
                    },
                    dataType: 'JSON',
                    beforeSend: function() {   
                        var loader = document.getElementById("loading_icon_"+socialAccount);
                        loader.style.display = 'inline-block';
                        $(this).text("");
                    },
                    complete: function(){
                        var loader = document.getElementById("loading_icon_"+socialAccount);
                        loader.style.display = 'none';
                    },
                    success: function (response) {
                        if(response.response.status==true){
                            Sweet('success', "Connected Successfully!");
                            setTimeout(() => {
                                location.reload();
                            }, 1200);
                                
                        }
                        else{
                            Sweet('error', response.message);
                        }
                    }
                });
            }
        });
    }

    $(document).ready(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        
        $(document).on("click", ".connect-to-social-media", function(e){
            $("#modalFacebookPages").modal('hide');
            sessionStorage.setItem("setting_section", "social_connection");
            var socialAccount = $(this).attr("data-socialAccount");
            if(socialAccount == "instagram" ){
                var isFacebookConnect = "{{ $userSocialConnection->is_facebook_auth ?? 0 }}";
                if(isFacebookConnect!=1){
                    Swal.fire({
                        title: 'Unable to connect',
                        text: 'First need to connect with Facebook',
                        icon: 'info',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmButtonColor: '#3085d6'
                    });
                    return false;
                }
            }
            $.ajax({
                url: '{{ URL::to("business/connect-social-media") }}',
                type: "POST",
                data: {
                    _token: CSRF_TOKEN,
                    socialAccount: socialAccount
                },
                dataType: 'JSON',
                beforeSend: function() {   
                    var loader = document.getElementById("loading_icon_"+socialAccount);
		            loader.style.display = 'inline-block';
		            $(this).text("");
                },
                complete: function(){
                    var loader = document.getElementById("loading_icon_"+socialAccount);
            		loader.style.display = 'none';
                },
                success: function (response) {
                    console.log(response);
                    if(response.response==null){
                        $("#userModalLabel").text("Connection Failed");
                        $("#authConnectSocialMedia").text("Unable to connect with "+socialAccount);
                        $("#modalConnectSocialMedia").modal('toggle');
                    }
                    else if(response.social_account_type == "twitter" || response.status == true){
                        $("#authConnectSocialMedia").html(response.response)
                        $("#modalConnectSocialMedia").modal('toggle');
                    }
                    else{
                        Sweet('error', "Something went wrong!");
                    }
                }
            });
        });

        // Google Review
        var showGoogleReviewModal = 1;
        var isGoogleReviewModalShowAlReady = 0;
        $(document).on('click', ".showMsgPopup", function(){
            // if (showGoogleReviewModal == 1 && isGoogleReviewModalShowAlReady==0) {
            // 	var googleReviewMsg = "Rs. {{ $googleReviewDeductCost->amount ?? 0 }} will be deducted from your wallet balance for each review.";
            //     Swal.fire({
            //         title: '<strong>Please Note</strong>',
            //         html: googleReviewMsg,
            //         icon: 'info',
            //         showCloseButton: false,
            //         showCancelButton: true,
            //         focusConfirm: false,
            //         allowOutsideClick: false,
            //         confirmButtonText: 'Accept',
            //         cancelButtonText: 'Cancel'
            //     }).then((result) => {
            //         if (result.value) {
            //             isGoogleReviewModalShowAlReady = 1;
            //             connectGoogleReview();
            //         }
            //     });
            // }
            // else{
                connectGoogleReview();
            // }
        });

        // Facebook Page setup
        $(document).on("submit", "#facebookPagesForm", function(e){
            e.preventDefault();
            $("#error_fbpages").text('');
            if (!$("input[name='facebook_pages']:checked").val()) {
                $("#error_fbpages").text('Please select Any One Page');
                return false;
            }

            var facebook_page = $('input[name="facebook_pages"]:checked').val();
            $.ajax({
                url: '{{ route("business.save-facebook-page") }}',
                type: "POST",
                data: {
                    _token: CSRF_TOKEN,
                    facebook_page:facebook_page
                },
                dataType: 'JSON',
                success: function (response) {
                    if(response.status==200){
                        $("#modalFacebookPages").modal('hide');
                        Sweet('success',response.message);

                        window.setTimeout(function() {
                            sessionStorage.setItem("setting_section", "social_connection");
                            window.location.href = "{{ route('business.settings') }}";
                        }, 1500);
                    }
                    else{
                        Sweet('error',response.message);
                    }
                }
            });
        });

        // console.log(isFacebookCheck+" "+facebook_page_id);
        // if(isFacebookCheck!=0 && (facebook_page_id==null || facebook_page_id=='')){        
        if(isFacebookCheck!=0){
            if(isFacebookConnected!=1){
                showConnectionFailedPopup('facebook');
            }
            else{
                facebookPagesShow();
            }
        }

        $(document).on("click", "#updatePage", function(e){
            facebookPagesShow();
        });
        
        // LinkedIn Page setup
        $(document).on("submit", "#linkedinPagesForm", function(e){
            e.preventDefault();
            $("#error_linkedin_page").text('');
            if (!$("#linkedin_page_id").val()) {
                $("#error_linkedin_page").text('Please enter page id');
                return false;
            }
            else if(!$.isNumeric($("#linkedin_page_id").val())){
                $("#error_linkedin_page").text('Please enter valid page id');
                return false;
            }
            else if ($("#linkedin_page_id").val().length <= 5) {
                $("#error_linkedin_page").text('Please enter valid page id');
                return false;
            }

            var linkedin_page_id = $("#linkedin_page_id").val();
            $.ajax({
                url: '{{ route("business.save-linkedin-page") }}',
                type: "POST",
                data: {
                    _token: CSRF_TOKEN,
                    linkedin_page_id:linkedin_page_id
                },
                dataType: 'JSON',
                success: function (response) {
                    // console.log(response);
                    if(response.status==200){
                        $("#modalLinkedInPages").modal('toggle');
                        Sweet('success',response.message);

                        window.setTimeout(function() {
                            sessionStorage.setItem("setting_section", "social_connection");
                            window.location.href = "{{ route('business.settings') }}";
                        }, 1500);
                    }
                    else{
                        Sweet('error',response.message);
                    }
                }
            });
        });

        var isTwitterCheck = '{{ $isTwitterCheck ?? 0 }}';
        if(isTwitterCheck!=0){
            getTwitterUsername();
        }

        var islinkedInCheck = '{{ $islinkedInCheck ?? 0 }}';
        if(islinkedInCheck!=0){
            linkedinPagesShow();
        }

        $(document).on("click", "#updatePageLinkedIn", function(e){
            linkedinPagesShow();
        });

        var isInstagramCheck = '{{ $isInstagramCheck ?? 0 }}';
        var isInstagramConnected = '{{ $isInstagramConnected ?? 0 }}';
        if(isInstagramCheck!=0){
            if(isInstagramConnected!=1){
                showConnectionFailedPopup('instagram');
            }
            else{
                getInstagramUsername();
            }
        }
    });

    function showConnectionFailedPopup(socialMedia){
        var failedSuggestions = "";
        if(socialMedia=="facebook"){
            failedSuggestions = "<h5>Unable to Connect, please check below suggestions:</h5>";
            failedSuggestions += "<div style='text-align: start; margin-left: 45px;font-size: 13px;'>";
            failedSuggestions += "1. Facebook page not Available.";
            failedSuggestions += "</div>";
        }
        else if(socialMedia=="instagram"){
            failedSuggestions = "<h5>Unable to Connect, please check below suggestions:</h5>";
            failedSuggestions += "<div style='text-align: start; margin-left: 45px;font-size: 13px;'>";
            failedSuggestions += "1. Instagram business account not found.<br/>";
            failedSuggestions += "2. Connect Instagram business account with Facebook page.";
            failedSuggestions += "</div>";
        }

        Swal.fire({
            // title: "Unable to Connect, please check suggestions",
            html: failedSuggestions,
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok'
        });

        // Swal.fire({
        //     icon: 'info',
        //     title: 'Unable to Connect, please check suggestions',
        //     text: 'Unable to Connect, please check suggestions',
        //     html: failedSuggestions,
        //     showCloseButton: false,
        //     focusConfirm: false,
        //     allowOutsideClick: false,
        //     confirmButtonText: 'Ok',
        //     cancelButtonText: 'Cancel'
        // });
    }

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    function facebookPagesShow(){
        $.ajax({
            url: '{{ route("business.get-facebook-pages") }}',
            type: "POST",
            data: { _token: CSRF_TOKEN, },
            dataType: 'JSON',
            success: function (response) {
                // console.log(response);
                var html="<div class='table' >";
                if(response.page_ids.length>0){
                    response.page_ids.forEach(element => {
                        var is_checked = '';
                        if(element.id==response.facebook_page_id){
                            is_checked = 'checked';
                        }
                        html += '<div class="">'+
                        '<div class="custom-control custom-radio custom-control-inline">'+
                                    '<input type="radio" id="fbp_'+element.id+'" name="facebook_pages" class="custom-control-input" value="'+element.id+'" '+is_checked+'>'+
                                    '<label class="custom-control-label" for="fbp_'+element.id+'">'+element.name+'</label>'+
                                    '</div>'+
                                '</div>';
                    });
                    html += "<p class='error' id='error_fbpages' ></p>";

                    $(".updateFbModalBtns").show();
                    $(".closeFbModalBtns").hide();
                }
                else{
                    html += "Pages not Found!";
                    $(".updateFbModalBtns").hide();
                    $(".closeFbModalBtns").show();
                }
                html += "</div>";
                $("#facebookPages").html(html);
                $("#modalFacebookPages").modal('show');
            }
        });
    }

    function getTwitterUsername(){
        $("#overlay").fadeIn();
        $.ajax({
            url: '{{ route("business.saveTwitterUsername") }}',
            type: "POST",
            data: { _token: CSRF_TOKEN, },
            dataType: 'JSON',
            success: function (response) {
                // console.log(response);
                $("#overlay").fadeOut(300);
            }
        });
    }

    function linkedinPagesShow(){
        $("#modalLinkedInPages").modal('toggle');
    }

    function getInstagramUsername() {
        $("#overlay").fadeIn();
        $.ajax({
            url: '{{ route("business.saveInstagramUsername") }}',
            type: "POST",
            data: { _token: CSRF_TOKEN, },
            dataType: 'JSON',
            success: function (response) {
                console.log(response);
                $("#overlay").fadeOut(300);
            }
        });
    }
</script>