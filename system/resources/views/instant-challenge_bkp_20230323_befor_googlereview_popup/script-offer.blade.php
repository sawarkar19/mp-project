<script type="text/javascript">
    /* Pre Defined Variables */
    var $calender = $('#date-month-modal');

    /* Check Customer */
    $( document ).ready(function() {
        var osCheck = getOS();
        // if(osCheck != 'Windows' && osCheck != 'Android'){
        // // if(osCheck == 'Windows' || osCheck == 'Android'){
        //     Swal.fire({
        //         title: 'Oops...',
        //         text: 'For now we are not available on iOS devices. We will be available on iOS soon.',
        //         icon: 'info',
        //         allowOutsideClick: false,
        //         allowEscapeKey: false,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Go to Business Page'
        //     }).then((result) => {
        //         if (result.value) {
        //             window.location.href = '{{ $vcard_url }}';
        //         }
        //     });
        //     return false;
        // }

        /*getting all url with parameters*/
        let urlParamsObject = new URLSearchParams(window.location.search)
        let share_cnf = urlParamsObject.get('share_cnf');
        if(share_cnf == null){
            checkUserCookie();
        }

        // alert(getOS());
    });

    function getOS() {
        var userAgent = window.navigator.userAgent,
        platform = window.navigator?.userAgentData?.platform || window.navigator.platform,
        macosPlatforms = ['Macintosh', 'MacIntel', 'MacPPC', 'Mac68K'],
        windowsPlatforms = ['Win32', 'Win64', 'Windows', 'WinCE'],
        iosPlatforms = ['iPhone', 'iPad', 'iPod'],
        os = null;

        if (macosPlatforms.indexOf(platform) !== -1) {
            os = 'Mac OS';
        } else if (iosPlatforms.indexOf(platform) !== -1) {
            os = 'iOS';
        } else if (windowsPlatforms.indexOf(platform) !== -1) {
            os = 'Windows';
        } else if (/Android/.test(userAgent)) {
            os = 'Android';
        } else if (/Linux/.test(platform)) {
            os = 'Linux';
        }

        return os;
    }

    /* Store cookie */
    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        let expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    /*getting all cookies values*/
    function checkUserCookie(){
        var old_customer = false;
        var customer_uuid = '';
        var allCookiesArray = document.cookie.split(';');
        for (var i = 0; i < allCookiesArray.length; i++ ){
            var singleCookie = allCookiesArray[i].split('=');
            if(singleCookie[0].trim() == 'openchallenge-customer'){
                customer_uuid = singleCookie[1];
                old_customer = true;
            }
        }

        if(old_customer == false){
            checkDeviceBrowser();
            if(isTaskListShow==true){
                $('#user_data_modal').modal('show');
            }
            // setCookie("openchallenge-customer", "226CUST20221014", 365);
        }else{
            addCustomer(customer_uuid);
        }
    }

    /* Proceed */
    $( "body" ).delegate( "#continueBtn", "click", function(e) {
        e.preventDefault();
        if($("#mobile").val() == ''){
            $("#mobile_error").show();
            return false;
        }else{
            $("#mobile_error").hide();
        }   
        addSubscription();
    });

    function addCustomer(cookie_val = null){
        var full_url = window.location.href;
        var urlArray = full_url.split("/");
        var offer_uuid = urlArray[urlArray.length - 1];

        // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var data = {
            mobile: $("#mobile").val(),
            name: $("#name").val(), 
            dob: $("#dob").val(),
            anniversary: $("#anniversary").val(),
            offer_uuid: offer_uuid,
            customer_uuid: cookie_val,
            // _token: CSRF_TOKEN,
            _token: '{{ csrf_token() }}'
        };

        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
        $.ajax({
            type: 'POST',
            url: "{{ route('addCustomerDetails') }}",
            data: data,
            dataType: 'JSON',
            success: function (response) {
                if(response.status == true){
                    if(response.link){
                        if(response.customer_uuid){
                            setCookie("openchallenge-customer", response.customer_uuid+"_"+response.business_uuid, 365);
                        }
                        window.location.href = response.link;
                    }
                }else if(response.status == false){
                    if((response.action == 'redirect_to_existing_subscription') || (response.action == 'redirect_to_business_vcard')){ 
                        window.location.href = response.link;
                    }

                    if(response.action == 'remove_cache_and_reload'){
                        var cookie_name = 'openchallenge-customer';
                        document.cookie = cookie_name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                        window.location.href = response.link;
                    }

                    if(response.action == 'ask_for_number'){ 
                        $('#user_data_modal').modal('show');
                    }

                    if(response.action == 'ask_for_name'){ 
                        $("#mobile_input").css("display", "none");
                        $("#name_input").css("display", "block");
                        $("#mobile").val(response.customer.mobile);
                        $('#user_data_modal').modal('show');
                    }

                    if(response.action == 'ask_for_dob'){ 
                        $("#mobile_input").css("display", "none");
                        $("#dob_input").css("display", "block");
                        $("#mobile").val(response.customer.mobile);
                        $("#name").val(response.customer_info.name);
                        $('#user_data_modal').modal('show');
                    }

                    if(response.action == 'ask_for_anniversary'){ 
                        $("#mobile_input").css("display", "none");
                        $("#anniversary_input").css("display", "block");
                        $("#mobile").val(response.customer.mobile);
                        $("#name").val(response.customer_info.name);
                        $("#dob").val(response.customer_info.dob);
                        $('#user_data_modal').modal('show');
                    }
                }
            },
            error: function(xhr) { 
                // $('#user_data_modal').modal('show');
            },
        });
    }

    function addSubscription(){
        var btn = $("#continueBtn");
        var full_url = window.location.href;
        var urlArray = full_url.split("/");
        var offer_uuid = urlArray[urlArray.length - 1];

        // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var data = {
            mobile: $("#mobile").val(),
            name: $("#name").val(), 
            dob: $("#dob").val(),
            anniversary: $("#anniversary").val(),
            offer_uuid: offer_uuid,
            // _token: CSRF_TOKEN,
            _token: '{{ csrf_token() }}'
        };

        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
        $.ajax({
            type: 'POST',
            url: "{{ route('continueWithSubscription') }}",
            data: data,
            dataType: 'JSON',
            beforeSend: function() {
                btn.attr('disabled','').addClass('btn-progress');
                btn.text('Please Wait....');
            },
            success: function (response) {
                if(response.status == true){
                    if(response.link){
                        if(response.customer_uuid){
                            var cookie_uuid = response.customer_uuid +"_"+ response.business_uuid;
                            setCookie("openchallenge-customer", cookie_uuid, 365);
                        }
                        window.location.href = response.link;
                    }
                }else{
                    if(response.link){
                        if(response.customer_uuid){
                            var cookie_uuid = response.customer_uuid +"_"+ response.business_uuid;
                            setCookie("openchallenge-customer", cookie_uuid, 365);
                        }

                        window.location.href = response.link;
                    }else{
                        btn.text('Continue');
                        btn.removeAttr('disabled').removeClass('btn-progress');
                    }
                }
            },
            error: function(xhr) { 
                // $('#user_data_modal').modal('show');
                btn.text('Continue');
                btn.removeAttr('disabled').removeClass('btn-progress');
            },
        });
    }

    function openDobModal(){
        // $("#dob").blur();
        // $('.modale').addClass('opened');
        // $(".modale").addClass("dob_modal");
        // $('#user_data_modal').modal('hide');

        $("#dob").blur();
        if($("#dob").val()!=""){
            var date = $("#dob").val().split(' ');
            showSelectDate(date[0]);
            showSelectMonth(date[1]);
        }
        else{
            showSelectDate("{{ date('d') }}");
            showSelectMonth("{{ date('F') }}");
        }
        $('#date-month-modal').removeClass('anniversary_modal').addClass('dob_modal').modal('show');
    }

    function openAnniversaryModal(){
        // $("#anniversary").blur();
        // $('.modale').addClass('opened');
        // $(".modale").addClass("anniversary_modal");
        // $('#user_data_modal').modal('hide');

        $("#anniversary").blur();
        if($("#anniversary").val()!=""){
            var date = $("#anniversary").val().split(' ');
            showSelectDate(date[0]);
            showSelectMonth(date[1]);
        }
        else{
            showSelectDate("{{ date('d') }}");
            showSelectMonth("{{ date('F') }}");
        }
        $('#date-month-modal').removeClass('dob_modal').addClass('anniversary_modal').modal('show');
    }

    $("body").delegate( ".close_calendar", "click", function(e) {
        e.preventDefault();
        closeModal();
        // $('#user_data_modal').modal('show');
    });

    function closeModal(){
        $calender.removeClass("dob_modal");
        $calender.removeClass("anniversary_modal");
        $calender.modal('hide');
    }

    function removeDate(){
        // $('.modale').removeClass('opened');
        if($calender.hasClass("dob_modal")){
            $("#dob").val('');
            $calender.removeClass("dob_modal");
        }
        if($calender.hasClass("anniversary_modal")){
            $("#anniversary").val('');
            $calender.removeClass("anniversary_modal");
        }
    }

    $("body").delegate( ".dateSelected", "click", function(e) {
        var day = $(this).attr("id");
        var month = $(".monthChange").val();
        var date = day +' '+ $(".monthChange option[value='"+month+"']").text();

        if($calender.hasClass("dob_modal")){
            $("#dob").val(date);
        }
        if($calender.hasClass("anniversary_modal")){
            $("#anniversary").val(date);
        }
        closeModal();
        // $('#user_data_modal').modal('show');
    });

    $("body").delegate( ".monthChange", "change", function(e) {
        var month = $(this).val();
        var days = 31;
        if(month == 2){
            days = 29;
        }
        if(month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month == 12){
            days = 31;
        }
        if(month == 4 || month == 6 || month == 9 || month == 11){
            days = 30;
        }

        $(".days").empty();
        for (let i = 1; i <= days; i++) {
            $(".days").append('<li class="dateSelected" id="'+i+'">'+i+'</li>');
        }
    });

    function showSelectDate(date){
        $(".dateSelected").removeClass("selected-date");
        $("#"+date).addClass("selected-date");
    }

    function showSelectMonth(month){
        var monthNo=1;
        if(month!="" || month!=undefined){
            if(month=='January'){
                monthNo = 1;
            }
            else if(month=='February'){
                monthNo = 2;
            }
            else if(month=='March'){
                monthNo = 3;
            }
            else if(month=='April'){
                monthNo = 4;
            }
            else if(month=='May'){
                monthNo = 5;
            }
            else if(month=='June'){
                monthNo = 6;
            }
            else if(month=='July'){
                monthNo = 7;
            }
            else if(month=='August'){
                monthNo = 8;
            }
            else if(month=='September'){
                monthNo = 9;
            }
            else if(month=='October'){
                monthNo = 10;
            }
            else if(month=='November'){
                monthNo = 11;
            }
            else if(month=='December'){
                monthNo = 12;
            }
        }
        $("#monthNo").val(monthNo);
    }

    /* $( "body" ).delegate( "#finishSetup", "click", function(e) {
    e.preventDefault();
    var btnName = 'finishSetup';
    var data = {
        mobile: $("#mobile").val(),
        name: $("#name").val(), 
        dob: $("#dob").val(),
        anniversary: $("#anniversary").val(),
        offer_id: {{ $offer->id }}
    };

    addDetails(data, btnName);
    }); */

    /* $( "body" ).delegate( "#skipSetup", "click", function(e) {
    e.preventDefault();
    // $('#user_data_modal').modal('hide');
    var btnName = 'skipSetup';
    var data = {
        mobile: $("#mobile").val(),
        name: $("#name").val(), 
        dob: $("#dob").val(),
        anniversary: $("#anniversary").val(),
        offer_id: {{ $offer->id }}
    };


    addDetails(data, btnName);
    }); */


    /* function addDetails(data, btnName)
    {
    // console.log(data);
    var btn = $('#'+btnName);

    var full_url = window.location.href;
    var urlArray = full_url.split("/");
    var offer_uuid = urlArray[urlArray.length - 1];

    $.ajax({
        url : '{{ route('addCustomerDetails') }}',
        type : 'POST',
        data : {
            "data": data,
            "_token" : $('meta[name="csrf-token"]').attr('content')
        },
        dataType : "json", 
        beforeSend: function() {
            btn.attr('disabled','');
            btn.html('Please Wait....');
        },
        success : function(res) {
            // console.log(res);
            window.location.href = res.link;
            $('#user_data_modal').modal('hide');
        }
    });
    } */
    /* Task Related Script */

    $(document).ajaxSend(function() {
        $("#overlay").fadeIn(300);　
    });

    $(document).on('click', '.task_click', function(){
        var task_key = $(this).attr('id');
        var urlParamsObject = new URLSearchParams(window.location.search)
        var urlParamsString = urlParamsObject.toString();
        var share_cnf = urlParamsObject.get('share_cnf');
        // setTimeout(function(){ 
        //     updateTask(task_key,share_cnf);
        // }, 6000);        
    });

    /*
    function updateTask(task_key,share_cnf){
        $("#overlay").fadeOut(300);
        $('.pending_task_'+task_key).css("display","none");
        // $('.processing_task_'+task_key).css("display","block");
        $('.complete_task_'+task_key).css("display","block");

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var input = {
            "user_code" : share_cnf,
            "instance_task_id" : task_key,
            "_token" : CSRF_TOKEN
        };
        var url = '{{ $services_url->value }}'+"/update-task-status";
        $.ajax({
            url : url,
            type : 'POST',
            data : input,
            dataType : "json",
            success : function(response) {

                // $("#"+task_key).removeAttr("class");
                // $("#"+task_key).css({'cursor' : ''});
                // $("#"+task_key).removeClass("task_click");
                // $("#"+task_key).addClass("disable");
                // $("#"+task_key).removeAttr("href target onclick");

                $("#instant_task_id_"+task_key).removeAttr("class");
                $("#instant_task_id_"+task_key).css({'cursor' : ''});
                $("#instant_task_id_"+task_key).removeClass("task_click");
                $("#instant_task_id_"+task_key).addClass("disable");
                $("#instant_task_id_"+task_key).removeAttr("href target onclick");
            },
            error: function(xhr, status, error) 
            {



            }
        });
    }
    */

    //redeem code sent
    $(document).on("click", "#sendRedeemCode", function(event){
        var btn = $("#sendRedeemCode");

        
        /*getting all url with parameters*/
        var urlParamsObject = new URLSearchParams(window.location.search)
        var urlParamsString = urlParamsObject.toString();
        var share_cnf = urlParamsObject.get('share_cnf');

        // $("#sendRedeemCode").prop('disabled', true);

        // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
        $.ajax({
            type: 'POST',
            url: "{{url('/instant/redeem/')}}",
            // data: {uuid: share_cnf, _token: CSRF_TOKEN},
            data: {uuid: share_cnf, _token: '{{ csrf_token() }}' },
            dataType: 'JSON',
            beforeSend: function() {
                btn.attr('disabled','').addClass('btn-progress');
                btn.text('Please Wait....');
            },
            success: function (results) {
                $("#overlay").fadeOut(300);
                if (results.status === true && results.type == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: results.message,
                        showConfirmButton: true,
                        confirmButtonText:
                        '<i class="fa fa-thumbs-up"></i> Okay!',
                        confirmButtonColor: '#3085d6',
                    })
                } else if(results.status === true && results.type == 'info'){
                    // $("#sendRedeemCode").prop('disabled', false);
                    Swal.fire({
                        icon: 'info',
                        title: results.message,
                        showConfirmButton: true,
                        confirmButtonText:
                        '<i class="fa fa-thumbs-up"></i> Okay!',
                        confirmButtonColor: '#3085d6',
                    })
                }else{
                    // $("#sendRedeemCode").prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: results.message,
                        showConfirmButton: true,
                        confirmButtonText:
                        '<i class="fa fa-thumbs-up"></i> Okay!',
                        confirmButtonColor: '#3085d6',
                    })
                }

                btn.text('Done');
                btn.removeAttr('disabled').removeClass('btn-progress');
            },
            error: function(xhr) { 
                // $("#sendRedeemCode").prop('disabled', false);
                $("#overlay").fadeOut(300);
                Swal.fire({
                    icon: 'error',
                    title: "Something went wrong!",
                    showConfirmButton: true,
                    confirmButtonText:
                    '<i class="fa fa-thumbs-up"></i> Okay!',
                    confirmButtonColor: '#3085d6',
                })

                btn.text('Done');
                btn.removeAttr('disabled').removeClass('btn-progress');
            },
        });
    });

    $(document).on("click", ".show_less", function(event){
        //event.preventDefault();
        $('.more_text').css('display','none');
        $('.less_text').css('display','block');
    });
    $(document).on("click", ".show_more", function(event){
        //event.preventDefault();
        $('.more_text').css('display','block');
        $('.less_text').css('display','none');
    });
</script>

<script type="text/javascript">
    function openNextPopup(task_key){
        $("#verifyPopUp__"+task_key+"Modal").modal('show');
    }

    function closeNextPopup(task_key){
        $("#verifyPopUp__"+task_key+"Modal").modal('hide');
    }

    function closePopupMsg(){
        $("#showPopupMsgModal").modal('hide');
    }

    function setNormalTab(instant_task_id, task_key){
        var classList = $("#instant_task_id_"+instant_task_id).attr("data-classes");
        $("#instant_task_id_"+instant_task_id).removeAttr('class');
        $("#instant_task_id_"+instant_task_id).addClass(classList);

        var hrefLink = $("#instant_task_id_"+instant_task_id).attr("data-href");
        if(hrefLink!=""){
            $("#instant_task_id_"+instant_task_id).removeAttr('href');
            $("#instant_task_id_"+instant_task_id).attr('href', hrefLink);
        }

        $("#set-single-task_"+instant_task_id).removeClass("verifying");
    }
    

    function setVerifyingTask(instant_task_id){
        var classList = $("#instant_task_id_"+instant_task_id).attr("class");
        $("#instant_task_id_"+instant_task_id).attr('data-classes', classList);
        $("#instant_task_id_"+instant_task_id).attr('class', '');
        
        // reverify
        $("#set-single-task_"+instant_task_id).removeClass("unverify");

        $("#set-single-task_"+instant_task_id).addClass("verifying");
        $("#instant_task_id_"+instant_task_id).addClass("disabled");

        // remove href
        var osCheck = getOS();
        // if(osCheck=="iPhone" || osCheck=="iOS" || osCheck=="OS X"){
            var hrefLink = $("#instant_task_id_"+instant_task_id).attr("href");
            $("#instant_task_id_"+instant_task_id).attr('data-href', hrefLink);
            document.getElementById("instant_task_id_"+instant_task_id).removeAttribute("href");
        // }
    }

    function setUnverifiedTask(instant_task_id, task_key){
        $("#set-single-task_"+instant_task_id).removeClass("verifying");
        // $("#instant_task_id_"+instant_task_id).removeClass("disabled");
        $("#set-single-task_"+instant_task_id).addClass("unverify");
    
        var username = business = ajaxcall = "";

        // Facebook
        if(task_key=="fb_page_url"){
            username = "facebook";
            business = "{{ $tasks_value['fb_page_url'] ?? NULL }}";
            ajaxcall = "ajaxCheckFacebookLikeOurPage";
        }
        else if(task_key=="fb_comment_post_url"){
            username = "facebook";
            business = "{{ $tasks_value['fb_comment_post_url'] ?? NULL }}";
            ajaxcall = "ajaxCheckFacebookPostComment";
        }
        else if(task_key=="fb_like_post_url"){
            username = "facebook";
            business = "{{ $tasks_value['fb_like_post_url'] ?? NULL }}";
            ajaxcall = "ajaxCheckFacebookPostLike";
        }

        // Instagram
        else if(task_key=="insta_profile_url"){
            username = "instagram";
            business = "{{ $tasks_value['insta_profile_url'] ?? NULL }}";
            ajaxcall = "ajaxCheckInstaProfile";
        }
        else if(task_key=="insta_post_url"){
            username = "instagram";
            business = "{{ $tasks_value['insta_post_url'] ?? NULL }}";
            ajaxcall = "ajaxCheckInstaLikes";
        }
        else if(task_key=="insta_comment_post_url"){
            username = "instagram";
            business = "{{ $tasks_value['insta_comment_post_url'] ?? NULL }}";
            ajaxcall = "ajaxCheckInstaComments";
        }

        // Twitter
        else if(task_key=="tw_username"){
            username = "tw_username";
            business = "{{ $tasks_value['tw_username'] ?? NULL }}";
            ajaxcall = "ajaxCheckFollow";
        }
        else if(task_key=="tw_tweet_url"){
            username = "tw_username";
            business = "{{ $tasks_value['tw_tweet_url'] ?? NULL }}";
            ajaxcall = "checkTwLikedBy";
        }

        // Youtube
        else if(task_key=="yt_channel_url"){
            username = "youtube";
            business = "{{ $tasks_value['yt_channel_url'] ?? NULL }}";
            ajaxcall = "ajaxCheckSubscribe";
        }
        else if(task_key=="yt_like_url"){
            username = "youtube";
            business = "{{ $tasks_value['yt_like_url'] ?? NULL }}";
            ajaxcall = "ajaxCheckLike";
        }
        else if(task_key=="yt_comment_url"){
            username = "youtube";
            business = "{{ $tasks_value['yt_comment_url'] ?? NULL }}";
            ajaxcall = "ajaxCheckComment";
        }

        // Google Review
        if(task_key=="google_review_link"){
            username = username;
            business = "{{ $tasks_value['google_review_link'] ?? NULL }}";
            ajaxcall = "ajaxCheckGoogleReview";
        }

        $("#set-single-task_"+instant_task_id+"_failed_reverify_"+task_key).addClass("reverify_tasks");
        $("#set-single-task_"+instant_task_id+"_failed_reverify_"+task_key).attr('data-ajaxcall', ajaxcall);
        $("#set-single-task_"+instant_task_id+"_failed_reverify_"+task_key).attr('data-username', username);
        $("#set-single-task_"+instant_task_id+"_failed_reverify_"+task_key).attr('data-business', business);
        $("#set-single-task_"+instant_task_id+"_failed_reverify_"+task_key).attr('data-instant_task_id', instant_task_id);
        $("#set-single-task_"+instant_task_id+"_failed_reverify_"+task_key).attr('data-task_key', task_key);

        // Add href for IOS
        // var osCheck = getOS();
        // if(osCheck=="iPhone" || osCheck=="iOS" || osCheck=="OS X"){
        //     var hrefLink = $("#instant_task_id_"+instant_task_id).attr("data-href");
        //     $("#instant_task_id_"+instant_task_id).attr('href', hrefLink);
        // }
    }

    function setUnverifiedwTaskWithName(instant_task_id, task_key, username){
        $("#set-single-task_"+instant_task_id).removeClass("verifying");
        // $("#instant_task_id_"+instant_task_id).removeClass("disabled");
        $("#set-single-task_"+instant_task_id).addClass("unverify");

        // Google Review
        if(task_key=="google_review_link"){
            username = username;
            business = "{{ $tasks_value['google_review_link'] ?? NULL }}";
            ajaxcall = "ajaxCheckGoogleReview";
        }

        $("#set-single-task_1568_failed_reverify_google_review_link").addClass("reverify_tasksWithName");
        $("#set-single-task_1568_failed_reverify_google_review_link").attr('data-ajaxcall', ajaxcall);
        $("#set-single-task_1568_failed_reverify_google_review_link").attr('data-username', username);
        $("#set-single-task_1568_failed_reverify_google_review_link").attr('data-business', business);
        $("#set-single-task_1568_failed_reverify_google_review_link").attr('data-instant_task_id', instant_task_id);
        $("#set-single-task_1568_failed_reverify_google_review_link").attr('data-task_key', task_key);
    }

    function updateTask(instant_task_id, task_key, share_cnf, noOfTask){
        var input = {
            "user_code" : share_cnf,
            "instance_task_id" : instant_task_id,
            _token: '{{ csrf_token() }}'
        };
        var url = '{{ $services_url->value }}'+"/update-task-status";
        $.ajax({
            url : url,
            type : 'POST',
            data : input,
            dataType : "json",
            success : function(response) {
                if(response.status == true){
                    // set Verify
                    // $("#set-single-task_"+instant_task_id).removeClass("unverify");
                    // $("#set-single-task_"+instant_task_id).removeClass("verifying");
                    $("#instant_task_id_"+instant_task_id).removeAttr("class");
                    $("#instant_task_id_"+instant_task_id).addClass("disabled");
                    
                    var subscriptionType = "{{ $settings->type ?? '' }}";
                    if(subscriptionType != 'Free'){
                        if(noOfTask==1){
                            autoSendRedeemCode();
                        }
                    }
                    
                    setVerifiedTask(instant_task_id, task_key);
                }
            },
            error: function(xhr, status, error){
                console.log("error => updateTask");
            }
        });
    }

    function setVerifiedTask(instant_task_id, task_key){
        var removeClassName = addClassName = "";
        // Facebook
        if(task_key=="fb_page_url" || task_key=="fb_like_post_url"){
            removeClassName = "FB-like";
            addClassName = "FB-liked";
        }
        else if(task_key=="fb_comment_post_url"){
            removeClassName = "FB-comment";
            addClassName = "FB-commented";
        }
        else if(task_key=="fb_share_post_url"){
            removeClassName = "FB-share";
            addClassName = "FB-shared";
        }

        // Instagram
        else if(task_key=="insta_profile_url"){
            removeClassName = "IG-follow";
            addClassName = "IG-following";
        }
        else if(task_key=="insta_post_url"){
            removeClassName = "IG-like";
            addClassName = "IG-liked";
        }
        else if(task_key=="insta_comment_post_url"){
            removeClassName = "IG-comment";
            addClassName = "IG-commented";
        }

        // Twitter
        else if(task_key=="tw_username"){
            removeClassName = "TW-follow";
            addClassName = "TW-following";
        }
        else if(task_key=="tw_tweet_url"){
            removeClassName = "TW-like";
            addClassName = "TW-liked";
        }

        // Youtube
        else if(task_key=="yt_channel_url"){
            removeClassName = "YT-subscribe";
            addClassName = "YT-subscribed";
        }
        else if(task_key=="yt_like_url"){
            removeClassName = "YT-like";
            addClassName = "YT-liked";
        }
        else if(task_key=="yt_comment_url"){
            removeClassName = "YT-comment";
            addClassName = "YT-commented";
        }

        // Google Review
        // else if(task_key=="google_review_link"){
        //     removeClassName = "GL-review";
        //     addClassName = "GL-reviewed";
        // }



        $("#set-single-task_"+instant_task_id).removeClass("verifying");
        $("#set-single-task_"+instant_task_id).removeClass("unverify");
        $("#set-single-task_"+instant_task_id).addClass("verified");
        $("#instant_task_id_"+instant_task_id).addClass("disabled");

        $("#task_icon_status__"+instant_task_id).removeClass(removeClassName);
        $("#task_icon_status__"+instant_task_id).addClass(addClassName);
    }

    // Show Task Complete Anumation and sent Redeem code
    function autoSendRedeemCode(){
        $("#forResend").show();
        /*getting all url with parameters*/
        var urlParamsObject = new URLSearchParams(window.location.search)
        var urlParamsString = urlParamsObject.toString();
        var share_cnf = urlParamsObject.get('share_cnf');
        $.ajax({
            type: 'POST',
            url: "{{ url('/instant/redeem/') }}",
            // data: {uuid: share_cnf, _token: CSRF_TOKEN},
            data: {uuid: share_cnf, _token: '{{ csrf_token() }}'},
            dataType: 'JSON',
            success: function (results) {
                if (results.status === true && results.type == 'success') {
                    congrats();
                }
            },
            error: function(xhr) { 
                console.error("redeem code error => ", xhr);
            },
        });
    }



    let maximumAjaxSocialRrequest = 5;
    let checkAjaxFbPageLikeRequestCount = checkAjaxFbPostCommentRequestCount = checkAjaxFbPostLikeRequestCount = 1;
    let checkAjaxTwFollow = checkAjaxTwLikedBy = 1;
    let checkAjaxInstaProfileFollowers = checkAjaxInstaLikes = checkAjaxInstaComments = 1;
    let checkAjaxYoutubSubcribe = checkAjaxYoutubComment = checkAjaxYoutubLike = 1;
    let checkAjaxGoogleReview = 1;

    // Check Tasks
    function checkTask(task_key, instant_task_id){
        var urlParamsObject = new URLSearchParams(window.location.search)
        var urlParamsString = urlParamsObject.toString();
        var share_cnf = urlParamsObject.get('share_cnf');
        
        var username = business = "";

        // Facebook
        if(task_key=="fb_page_url"){
            username = "facebook";
            business = "{{ $tasks_value['fb_page_url'] ?? NULL }}";
            checkAjaxFbPageLikeRequestCount = 1;
            setTimeout(() => {
                ajaxCheckFacebookLikeOurPage(username, business, share_cnf, instant_task_id, task_key);
            }, 2000);
        }
        else if(task_key=="fb_comment_post_url"){
            username = "facebook";
            business = "{{ $tasks_value['fb_comment_post_url'] ?? NULL }}";
            checkAjaxFbPostCommentRequestCount = 1;
            setTimeout(() => {
                ajaxCheckFacebookPostComment(username, business, share_cnf, instant_task_id, task_key);
            }, 2000);
        }
        else if(task_key=="fb_like_post_url"){
            username = "facebook";
            business = "{{ $tasks_value['fb_like_post_url'] ?? NULL }}";
            checkAjaxFbPostLikeRequestCount = 1;
            setTimeout(() => {
                ajaxCheckFacebookPostLike(username, business, share_cnf, instant_task_id, task_key);
            }, 2000);
        }

        // Instagram
        else if(task_key=="insta_profile_url"){
            username = "instagram";
            business = "{{ $tasks_value['insta_profile_url'] ?? NULL }}";
            checkAjaxInstaProfileFollowers = 1;
            setTimeout(() => {
                ajaxCheckInstaProfile(username, business, share_cnf, instant_task_id, task_key);
            }, 2000);
        }
        else if(task_key=="insta_post_url"){
            username = "instagram";
            business = "{{ $tasks_value['insta_post_url'] ?? NULL }}";
            checkAjaxInstaLikes = 1;
            setTimeout(() => {
                ajaxCheckInstaLikes(username, business, share_cnf, instant_task_id, task_key);
            }, 2000);
        }
        else if(task_key=="insta_comment_post_url"){
            username = "instagram";
            business = "{{ $tasks_value['insta_comment_post_url'] ?? NULL }}";
            checkAjaxInstaComments = 1;
            setTimeout(() => {
                ajaxCheckInstaComments(username, business, share_cnf, instant_task_id, task_key);
            }, 2000);
        }

        // Twitter
        else if(task_key=="tw_username"){
            username = "tw_username";
            business = "{{ $tasks_value['tw_username'] ?? NULL }}";
            checkAjaxTwFollow = 1;
            setTimeout(() => {
                ajaxCheckFollow(username, business, share_cnf, instant_task_id, task_key);
            }, 2000);
        }
        else if(task_key=="tw_tweet_url"){
            username = "tw_username";
            business = "{{ $tasks_value['tw_tweet_url'] ?? NULL }}";
            checkAjaxTwLikedBy = 1;
            setTimeout(() => {
                ajaxCheckTwLikedBy(username, business, share_cnf, instant_task_id, task_key);
            }, 2000);
        }

        // Youtube
        else if(task_key=="yt_channel_url"){
            username = "youtube";
            business = "{{ $tasks_value['yt_channel_url'] ?? NULL }}";
            checkAjaxYoutubSubcribe = 1;
            setTimeout(() => {
                ajaxCheckSubscribe(username, business, share_cnf, instant_task_id, task_key);
            }, 2000);
        }
        else if(task_key=="yt_like_url"){
            username = "youtube";
            business = "{{ $tasks_value['yt_like_url'] ?? NULL }}";
            checkAjaxYoutubLike = 1;
            setTimeout(() => {
                ajaxCheckLike(username, business, share_cnf, instant_task_id, task_key);
            }, 2000);
        }
        else if(task_key=="yt_comment_url"){
            username = "youtube";
            business = "{{ $tasks_value['yt_comment_url'] ?? NULL }}";
            checkAjaxYoutubComment = 1;
            setTimeout(() => {
                ajaxCheckComment(username, business, share_cnf, instant_task_id, task_key);
            }, 2000);
        }

        // Google Review
        else if(task_key=="google_review_link"){
            username = "google_review";
            business = "{{ $tasks_value['google_review_link'] ?? NULL }}";
            checkAjaxGoogleReview = 1;
            setTimeout(() => {
                setGoogleReviewAjaxData(username, business, share_cnf, instant_task_id, task_key);
            }, 2000);

            $("#instant_task_id_"+instant_task_id).removeAttr("href");
            $("#instant_task_id_"+instant_task_id).removeAttr("onclick");
            $("#instant_task_id_"+instant_task_id).removeAttr("onClick");
        }

        closeNextPopup(task_key);
        setVerifyingTask(instant_task_id);
    }

    function checkTaskWithName(task_key, instant_task_id, username){
        var urlParamsObject = new URLSearchParams(window.location.search)
        var urlParamsString = urlParamsObject.toString();
        var share_cnf = urlParamsObject.get('share_cnf');

        if(task_key=="google_review_link"){
            business = "{{ $tasks_value['google_review_link'] ?? NULL }}";
            checkAjaxGoogleReview = 1;

            alert("checkTaskWithName");

            // ajaxCheckGoogleReview(username, business, share_cnf, instant_task_id, task_key);
        }

        setVerifyingTask(instant_task_id);
    }

    // Ajax Tasks
    /*####      FACEBOOK       ####*/
    // # FacebookLikeOurPage
    function ajaxCheckFacebookLikeOurPage(fb_username, fb_business, share_cnf, instance_task_id, task_key){
        $.ajax({
            type: 'POST',
            url: "{{ url('/instant/fb-page-like') }}",
            // data: {fb_username: fb_username, fb_business: fb_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
            data: {fb_username: fb_username, fb_business: fb_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: '{{ csrf_token() }}'},
            dataType: 'JSON',
            success: function (results) {
                if (results.status === true) {
                    updateTask(instance_task_id, task_key, share_cnf, 1);
                } else {
                    checkAjaxFbPageLikeRequestCount++;
                    if(checkAjaxFbPageLikeRequestCount <= maximumAjaxSocialRrequest){
                        ajaxCheckFacebookLikeOurPage(fb_username, fb_business, share_cnf, instance_task_id, task_key);
                    }
                    else{
                        setUnverifiedTask(instance_task_id, task_key);
                    }   
                }
            },
            error: function(xhr) { 
                setUnverifiedTask(instance_task_id, task_key);
            },
        });
    }

    // # FacebookPostComment
    function ajaxCheckFacebookPostComment(fb_username, fb_business, share_cnf, instance_task_id, task_key){
        $.ajax({
            type: 'POST',
            url: "{{url('/instant/fb-post-comment')}}",
            // data: {fb_username: fb_username, fb_business: fb_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
            data: {fb_username: fb_username, fb_business: fb_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: '{{ csrf_token() }}'},
            dataType: 'JSON',
            success: function (results) {
                if (results.status === true) {
                    var ongoingInstantTaskIds = [];
                    var loopNo = 1;
                    $.map(results.updatedTasks, function(val, i ) {
                        ongoingInstantTaskIds.push(val.instant_task_id);
                        updateTask(val.instant_task_id, val.task_key, share_cnf, loopNo);
                        loopNo++;
                    });

                    if(ongoingInstantTaskIds.includes(instance_task_id) == false){
                        // setUnverifiedTask(instance_task_id, task_key);
                        setNormalTab(instance_task_id, task_key);
                    }
                } else {
                    checkAjaxFbPostCommentRequestCount++;
                    if(checkAjaxFbPostCommentRequestCount <= maximumAjaxSocialRrequest){
                        ajaxCheckFacebookPostComment(fb_username, fb_business, share_cnf, instance_task_id, task_key);
                    }
                    else{
                        setUnverifiedTask(instance_task_id, task_key);
                    }   
                }
            },
            error: function(xhr) {
                setUnverifiedTask(instance_task_id, task_key);
            },
        });
    }

    // # FacebookPostLike
    function ajaxCheckFacebookPostLike(fb_username, fb_business, share_cnf, instance_task_id, task_key){
        $.ajax({
            type: 'POST',
            url: "{{url('/instant/fb-post-like')}}",
            // data: {fb_username: fb_username, fb_business: fb_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
            data: {fb_username: fb_username, fb_business: fb_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: '{{ csrf_token() }}'},
            dataType: 'JSON',
            success: function (results) {
                if (results.status === true) {
                    var ongoingInstantTaskIds = [];
                    var loopNo = 1;
                    $.map(results.updatedTasks, function(val, i ) {
                        ongoingInstantTaskIds.push(val.instant_task_id);
                        updateTask(val.instant_task_id, val.task_key, share_cnf, loopNo);
                        loopNo++;
                    });

                    if(ongoingInstantTaskIds.includes(instance_task_id) == false){
                        // setUnverifiedTask(instance_task_id, task_key);
                        setNormalTab(instance_task_id, task_key);
                    }
                } else {
                    checkAjaxFbPostLikeRequestCount++;
                    if(checkAjaxFbPostLikeRequestCount <= maximumAjaxSocialRrequest){
                        ajaxCheckFacebookPostLike(fb_username, fb_business, share_cnf, instance_task_id, task_key);
                    }
                    else{
                        setUnverifiedTask(instance_task_id, task_key);
                    }   
                }
            },
            error: function(xhr) { 
                setUnverifiedTask(instance_task_id, task_key);
            },
        });
    }

    /*####      INSTAGRAM       ####*/
    // # Instagram Profile
    function ajaxCheckInstaProfile(insta_username, insta_business, share_cnf, instance_task_id, task_key){
        $.ajax({
            type: 'POST',
            url: "{{ route('instagramProfileFollowers') }}",
            // data: {insta_username: insta_username, insta_business: insta_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
            data: {insta_username: insta_username, insta_business: insta_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: '{{ csrf_token() }}'},
            dataType: 'JSON',
            success: function (results) {
                if (results.status === true) {
                    updateTask(instance_task_id, task_key, share_cnf, 1);
                } else {
                    checkAjaxInstaProfileFollowers++;
                    if(checkAjaxInstaProfileFollowers <= maximumAjaxSocialRrequest){
                        ajaxCheckInstaProfile(insta_username, insta_business, share_cnf, instance_task_id, task_key);
                    }
                    else{
                        setUnverifiedTask(instance_task_id, task_key);
                    }   
                }
            },
            error: function(xhr) { 
                setUnverifiedTask(instance_task_id, task_key);
            },
        });
    }

    // # Instagram Post like
    function ajaxCheckInstaLikes(insta_username, insta_business, share_cnf, instance_task_id, task_key){
        $.ajax({
            type: 'POST',
            url: "{{ route('instagramPostLike') }}",
            // data: {insta_username: insta_username, insta_business: insta_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
            data: {insta_username: insta_username, insta_business: insta_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: '{{ csrf_token() }}'},
            dataType: 'JSON',
            success: function (results) {
                if (results.status === true) {
                    var ongoingInstantTaskIds = [];
                    var loopNo = 1;
                    $.map(results.updatedTasks, function(val, i ) {
                        ongoingInstantTaskIds.push(val.instant_task_id);
                        updateTask(val.instant_task_id, val.task_key, share_cnf, loopNo);
                        loopNo++;
                    });

                    if(ongoingInstantTaskIds.includes(instance_task_id) == false){
                        // setUnverifiedTask(instance_task_id, task_key);
                        setNormalTab(instance_task_id, task_key);
                    }
                } else {
                    checkAjaxInstaLikes++;
                    if(checkAjaxInstaLikes <= maximumAjaxSocialRrequest){
                        ajaxCheckInstaLikes(insta_username, insta_business, share_cnf, instance_task_id, task_key);
                    }
                    else{
                        setUnverifiedTask(instance_task_id, task_key);
                    }
                }
            },
            error: function(xhr) {
                setUnverifiedTask(instance_task_id, task_key);
            },
        });
    }

    // # Instagram Post comments
    function ajaxCheckInstaComments(insta_username, insta_business, share_cnf, instance_task_id, task_key){
        $.ajax({
            type: 'POST',
            url: "{{ route('instagramPostComment') }}",
            // data: {insta_username: insta_username, insta_business: insta_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
            data: {insta_username: insta_username, insta_business: insta_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: '{{ csrf_token() }}'},
            dataType: 'JSON',
            success: function (results) {
                if (results.status === true) {
                    var ongoingInstantTaskIds = [];
                    var loopNo = 1;
                    $.map(results.updatedTasks, function(val, i ) {
                        ongoingInstantTaskIds.push(val.instant_task_id);
                        updateTask(val.instant_task_id, val.task_key, share_cnf, loopNo);
                        loopNo++;
                    });

                    if(ongoingInstantTaskIds.includes(instance_task_id) == false){
                        // setUnverifiedTask(instance_task_id, task_key);
                        setNormalTab(instance_task_id, task_key);
                    }
                }
                else {
                    checkAjaxInstaComments++;
                    if(checkAjaxInstaComments <= maximumAjaxSocialRrequest){
                        ajaxCheckInstaComments(insta_username, insta_business, share_cnf, instance_task_id, task_key);
                    }
                    else{
                        setUnverifiedTask(instance_task_id, task_key);
                    }
                }
            },
            error: function(xhr) { 
                setUnverifiedTask(instance_task_id, task_key);
            },
        });
    }

    /*####      TWITTER       ####*/
    // # Twitter Follows
    function ajaxCheckFollow(tw_username, tw_business, share_cnf, instance_task_id, task_key){
        $.ajax({
            type: 'POST',
            url: "{{url('/instant/verify-twfollow')}}",
            // data: {tw_username: tw_username, tw_business: tw_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
            data: {tw_username: tw_username, tw_business: tw_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: '{{ csrf_token() }}'},
            dataType: 'JSON',
            success: function (results) {
                if (results.status === true) {
                    updateTask(instance_task_id, task_key, share_cnf, 1);
                } else {
                    checkAjaxTwFollow++;
                    if(checkAjaxTwFollow <= maximumAjaxSocialRrequest){
                        ajaxCheckFollow(tw_username, tw_business, share_cnf, instance_task_id, task_key);
                    }
                    else{
                        setUnverifiedTask(instance_task_id, task_key);
                    }   
                }
            },
            error: function(xhr) { 
                setUnverifiedTask(instance_task_id, task_key);
            },
        });
    }

    // # Twitter Tweet Like
    function ajaxCheckTwLikedBy(tw_username, tw_business, share_cnf, instance_task_id, task_key){
        $.ajax({
            type: 'POST',
            url: "{{url('/instant/verify-twliked')}}",
            // data: {tw_username: tw_username, tw_business: tw_business, share_cnf: share_cnf, instance_task_id:instance_task_id, _token: CSRF_TOKEN},
            data: {tw_username: tw_username, tw_business: tw_business, share_cnf: share_cnf, instance_task_id:instance_task_id, _token: '{{ csrf_token() }}'},
            dataType: 'JSON',
            success: function (results) {
                if (results.status === true) {
                    updateTask(instance_task_id, task_key, share_cnf, 1);
                } else {
                    checkAjaxTwLikedBy++;
                    if(checkAjaxTwLikedBy <= maximumAjaxSocialRrequest){
                        ajaxCheckTwLikedBy(tw_username, tw_business, share_cnf, instance_task_id, task_key);
                    }
                    else{
                        setUnverifiedTask(instance_task_id, task_key);
                    }
                }
            },
            error: function(xhr) { 
                setUnverifiedTask(instance_task_id, task_key);
            },
        });
    }

    /*####      YOUTUBE       ####*/
    // # Youtube Channel Subscribe
    function ajaxCheckSubscribe(yt_username, yt_business, share_cnf, instance_task_id, task_key){
        $.ajax({
            type: 'POST',
            url: "{{url('/instant/verify-youtube-subscribe')}}",
            // data: {yt_username: yt_username, yt_business: yt_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
            data: {yt_username: yt_username, yt_business: yt_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: '{{ csrf_token() }}'},
            dataType: 'JSON',
            success: function (results) {
                if (results.status === true) {
                    updateTask(instance_task_id, task_key, share_cnf, 1);
                } else {
                    checkAjaxYoutubSubcribe++;
                    if(checkAjaxYoutubSubcribe <= maximumAjaxSocialRrequest){
                        ajaxCheckSubscribe(yt_username, yt_business, share_cnf, instance_task_id, task_key);
                    }
                    else{
                        setUnverifiedTask(instance_task_id, task_key);
                    } 
                }
            },
            error: function(xhr) { 
                setUnverifiedTask(instance_task_id, task_key);
            },
        });
    }

    // # Youtube Post Like
    function ajaxCheckLike(yt_username, yt_business, share_cnf, instance_task_id, task_key){
        $.ajax({
            type: 'POST',
            url: "{{url('/instant/verify-youtube-like')}}",
            // data: {yt_username: yt_username, yt_business: yt_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
            data: {yt_username: yt_username, yt_business: yt_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: '{{ csrf_token() }}'},
            dataType: 'JSON',
            success: function (results) {
                if (results.status === true) {
                    var ongoingInstantTaskIds = [];
                    var loopNo = 1;
                    $.map(results.updatedTasks, function(val, i ) {
                        ongoingInstantTaskIds.push(val.instant_task_id);
                        updateTask(val.instant_task_id, val.task_key, share_cnf, loopNo);
                        loopNo++;
                    });

                    if(ongoingInstantTaskIds.includes(instance_task_id) == false){
                        // setUnverifiedTask(instance_task_id, task_key);
                        setNormalTab(instance_task_id, task_key);
                    }
                } else {
                    checkAjaxYoutubLike++;
                    if(checkAjaxYoutubLike <= maximumAjaxSocialRrequest){
                        ajaxCheckLike(yt_username, yt_business, share_cnf, instance_task_id, task_key);
                    }
                    else{
                        setUnverifiedTask(instance_task_id, task_key);
                    }
                }
            },
            error: function(xhr) { 
                setUnverifiedTask(instance_task_id, task_key);
            },
        });
    }

    // # Youtube Post Comment
    function ajaxCheckComment(yt_username, yt_business, share_cnf, instance_task_id, task_key){
        $.ajax({
            type: 'POST',
            url: "{{url('/instant/verify-youtube-comment')}}",
            // data: {yt_username: yt_username, yt_business: yt_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
            data: {yt_username: yt_username, yt_business: yt_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: '{{ csrf_token() }}'},
            dataType: 'JSON',
            success: function (results) {
                if (results.status === true) {
                    var ongoingInstantTaskIds = [];
                    var loopNo = 1;
                    $.map(results.updatedTasks, function(val, i ) {
                        ongoingInstantTaskIds.push(val.instant_task_id);
                        updateTask(val.instant_task_id, val.task_key, share_cnf, loopNo);
                        loopNo++;
                    });

                    if(ongoingInstantTaskIds.includes(instance_task_id) == false){
                        // setUnverifiedTask(instance_task_id, task_key);
                        setNormalTab(instance_task_id, task_key);
                    }
                } else {
                    checkAjaxYoutubComment++;
                    if(checkAjaxYoutubComment <= maximumAjaxSocialRrequest){
                        ajaxCheckComment(yt_username, yt_business, share_cnf, instance_task_id, task_key);
                    }
                    else{
                        setUnverifiedTask(instance_task_id, task_key);
                    }
                }
            },
            error: function(xhr) { 
                setUnverifiedTask(instance_task_id, task_key);
            },
        });
    }

    /*####      GOOGLE REVIEW       ####*/
    function checkGoogleReview(instance_task_id) {
        var task_value = $("#instant_task_id_"+instance_task_id).attr("data-task_value");
        var task_key = $("#instant_task_id_"+instance_task_id).attr("data-task_key");

        // Google Review URL
        var one_extra_field_value = $("#instant_task_id_"+instance_task_id).attr("data-one_extra_field_value");
        
        // var countResult = setInstantTaskCount('setCount', task_value, task_key, instance_task_id);
        setLaoding();
        getContribeIdUrl(task_key);
    }

    function getContribeIdUrl(task_key){
        var urlParamsObject = new URLSearchParams(window.location.search)
        var urlParamsString = urlParamsObject.toString();
        var share_cnf = urlParamsObject.get('share_cnf');

        var requestType = "getContributId";
        $.ajax({
            type: 'POST',
            url: "{{ route('verifyGoogleReview' )}}",
            data: { share_cnf:share_cnf, requestType: requestType, _token: '{{ csrf_token() }}'},
            dataType: 'JSON',
            beforeSend: function() {
                $("#loaderFetchRecord").show();
            },
            complete: function() {
                $("#loaderFetchRecord").hide();
            },
            success: function (results) {
                if(results.status==true){
                    var x = screen.width/2 - 700/2;
                    var y = screen.height/2 - 450/2;
                    var newWindow = window.open("{{ route('googleReviewAuth') }}", "google", 'height=485,width=700,left='+x+',top='+y);

                    if (newWindow == null || typeof(newWindow)=='undefined') {
                        var browser_name = "{{ $agent->browser() ?? Other }}";

                        var popupBlockerMessage = "<h4>Pop-up blocked. Please allow pop-ups for this site and try again.<h4>";
                        
                        // Safari Browser
                        if(browser_name == "Safari" || browser_name == "safari"){
                            // Prompt the user to allow pop-ups in Safari
                            if(isDevice=='desktop'){
                                $("#safari-desktop").show();
                                $("#safari-mobile").hide();
                                $("#chrome-desktop").hide();
                                $("#chrome-mobile").hide();
                            }
                            else{
                                $("#safari-mobile").show();
                                $("#safari-desktop").hide();
                                $("#chrome-desktop").hide();
                                $("#chrome-mobile").hide();
                            }
                        }
                        else{
                            // Window Browser
                            // Prompt the user to allow pop-ups in their browser settings
                            if(isDevice=='desktop'){
                                $("#chrome-desktop").show();
                                $("#chrome-mobile").hide();
                                $("#safari-mobile").hide();
                                $("#safari-desktop").hide();
                            }else{
                                $("#chrome-mobile").show();
                                $("#chrome-desktop").hide();
                                $("#safari-mobile").hide();
                                $("#safari-desktop").hide();
                            }
                        }
                        // $("#show-popup-msg").html(popupBlockerMessage);
                        $("#showPopupMsgModal").modal('show');
                    } else {
                        // Window opened successfully
                        newWindow.focus();
                        newWindow.onload = function() {
                            newWindow.document.body.insertAdjacentHTML('afterbegin', results.htmlAuth);
                        };

                        openNextPopup(task_key);
                    }
                }
            },
            error: function(xhr) { 
                console.log("getContribeIdUrl error ", xhr);
            },
        });
    }

    function setGoogleReviewAjaxData(username, business, share_cnf, instant_task_id, task_key){
        var one_extra_field_value = $("#instant_task_id_"+instant_task_id).attr("data-one_extra_field_value");
        ajaxSendGoogleReviewUrl(task_key, business, one_extra_field_value, instant_task_id);
    }

    function ajaxSendGoogleReviewUrl(task_key="", task_value="", one_extra_field_value="", instant_task_id) {
        var urlParamsObject = new URLSearchParams(window.location.search)
        var urlParamsString = urlParamsObject.toString();
        var share_cnf = urlParamsObject.get('share_cnf');

        var requestType = "sendUrl";
        var review_id = localStorage.getItem("google_review_id");
        // alert(review_id);
        $.ajax({
            type: 'POST',
            url: "{{ route('verifyGoogleReview' )}}",
            data: { task_key:task_key, task_value:task_value, one_extra_field_value:one_extra_field_value, share_cnf:share_cnf, instant_task_id:instant_task_id, requestType:requestType, review_id:review_id, _token: '{{ csrf_token() }}'},
            dataType: 'JSON',
            success: function (results) {
                if (results.status === true) {
                    updateTask(instant_task_id, task_key, share_cnf, 1);
                } else {
                    checkAjaxGoogleReview++;
                    if(checkAjaxGoogleReview <= maximumAjaxSocialRrequest){
                        ajaxSendGoogleReviewUrl(task_key, task_value, one_extra_field_value, instant_task_id);
                    }
                    else{
                        setUnverifiedTask(instant_task_id, task_key);
                    }   
                }
            },
            error: function(xhr) { 
                console.log("ajaxSendGoogleReviewUrl error ", xhr);
            },
        });
    }

    /*
    function ajaxCheckGoogleReview(google_username, google_business, share_cnf, instance_task_id, task_key){
        // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
        $.ajax({
            type: 'POST',
            url: "{{url('/instant/verify-google-review')}}",
            // data: {google_username: google_username, google_business: google_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
            data: {google_username: google_username, google_business: google_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: '{{ csrf_token() }}'},
            dataType: 'JSON',
            success: function (results) {
                if (results.status === true) {
                    updateTask(instance_task_id, task_key, share_cnf);
                } else {
                    checkAjaxGoogleReview++;
                    if(checkAjaxGoogleReview <= maximumAjaxSocialRrequest){
                        ajaxCheckGoogleReview(google_username, google_business, share_cnf, instance_task_id, task_key);
                    }
                    else{
                        setUnverifiedwTaskWithName(instance_task_id, task_key, google_username);
                    }   
                }
            },
            error: function(xhr) { 
                setUnverifiedwTaskWithName(instance_task_id, task_key, google_username);
            },
        });
    }
    */

    $(document).ready(function(){
        $(document).on("click", ".nextTaskBtn", function(){
            var task_key = $(this).attr('data-task_key');
            var instant_task_id = $(this).attr('data-instant_task_id');
            checkTask(task_key, instant_task_id)
        });

        // Reverify
        $(document).on("click", ".reverify_tasks", function(){
            var task_key = $(this).attr('data-task_key');
            var instant_task_id = $(this).attr('data-instant_task_id');
            checkTask(task_key, instant_task_id)
        });

        $(document).on("click", ".reverify_tasksWithName", function(){
            var task_key = $(this).attr('data-task_key');
            var instant_task_id = $(this).attr('data-instant_task_id');
            var username = $(this).attr('data-username');
            checkTaskWithName(task_key, instant_task_id, username)
        });

        $(document).on("click", "#popupMsgCloseBtn", function(){
            closePopupMsg();
        });
    });

</script>
<script>
    // Status may be => setCount OR verifyingCount 
    function setInstantTaskCount(status, task_value, task_key, instant_task_id){   
        // setTimeout(function() {
            instantTaskCount(status, task_value, task_key, instant_task_id);
            return true;
        // }, 500);
    }

    function instantTaskCount(status, task_value, task_key, instant_task_id){
        let username = business = "";
        // Facebook
        if(task_key == "fb_page_url"){
            username = "facebook";
            business = "{{ $tasks_value['fb_page_url'] ?? '' }}";
        }
        else if(task_key == "fb_comment_post_url"){
            username = "facebook";
            business = "{{ $tasks_value['fb_comment_post_url'] ?? '' }}";
        }
        else if(task_key == "fb_like_post_url"){
            username = "facebook";
            business = "{{ $tasks_value['fb_like_post_url'] ?? '' }}";
        }

        // Instagram
        else if(task_key == "insta_profile_url"){
            username = "instagram";
            business = "{{ $tasks_value['insta_profile_url'] ?? '' }}";
        }
        else if(task_key == "insta_post_url"){
            username = "instagram";
            business = "{{ $tasks_value['insta_post_url'] ?? '' }}";
        }
        else if(task_key == "insta_comment_post_url"){
            username = "instagram";
            business = "{{ $tasks_value['insta_comment_post_url'] ?? '' }}";
        }

        // Twitter
        else if(task_key == "tw_username"){
            username = "tw_username";
            business = "{{ $tasks_value['tw_username'] ?? '' }}";
        }
        else if(task_key == "tw_tweet_url"){
            username = "tw_username";
            business = "{{ $tasks_value['tw_tweet_url'] ?? '' }}";
        }

        // Youtube
        else if(task_key == "yt_channel_url"){
            username = "youtube";
            business = "{{ $tasks_value['yt_channel_url'] ?? '' }}";
        }
        else if(task_key == "yt_comment_url"){
            username = "youtube";
            business = "{{ $tasks_value['yt_comment_url'] ?? '' }}";
        }
        else if(task_key == "yt_like_url"){
            username = "youtube";
            business = "{{ $tasks_value['yt_like_url'] ?? '' }}";
        }

        // Google Review
        else if(task_key == "google_review_link"){
            username = "google_review_link";
            business = "{{ $tasks_value['google_review_link'] ?? '' }}";
        }

        var urlParamsObject = new URLSearchParams(window.location.search)
        var urlParamsString = urlParamsObject.toString();
        var share_cnf = urlParamsObject.get('share_cnf');

        // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
        $.ajax({
            type: 'POST',
            url: "{{ route('checkInstantTasksCount') }}",
            data: {
                username: username, 
                business: business, 
                share_cnf: share_cnf, 
                instant_task_id: instant_task_id, 
                status: status, 
                task_value: task_value,
                task_key: task_key,
                // _token: CSRF_TOKEN,
                _token: '{{ csrf_token() }}'
            },
            async:false,
            dataType: 'JSON',
            beforeSend: function(){
                $("#loaderFetchRecord").show();
            },
            success: function (results) {
                $("#loaderFetchRecord").hide();
                return results.status;
                // console.log("instantTaskCount result "+ results);
            },
            error: function(xhr) { 
                $("#loaderFetchRecord").hide();
                return false;
                // console.log("instantTaskCount error "+ xhr);
            },
        });
    }
    
</script>