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

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            var data = {
                mobile: $("#mobile").val(),
                name: $("#name").val(), 
                dob: $("#dob").val(),
                anniversary: $("#anniversary").val(),
                offer_uuid: offer_uuid,
                customer_uuid: cookie_val,
                _token: CSRF_TOKEN
            };

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
                            var cookie_name = '-customer';
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
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            var data = {
                mobile: $("#mobile").val(),
                name: $("#name").val(), 
                dob: $("#dob").val(),
                anniversary: $("#anniversary").val(),
                offer_uuid: offer_uuid,
                _token: CSRF_TOKEN
            };

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

    //redeem code sent
    $(document).on("click", "#sendRedeemCode", function(event){
        var btn = $("#sendRedeemCode");

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        /*getting all url with parameters*/
        var urlParamsObject = new URLSearchParams(window.location.search)
        var urlParamsString = urlParamsObject.toString();
        var share_cnf = urlParamsObject.get('share_cnf');

       // $("#sendRedeemCode").prop('disabled', true);

        $.ajax({
            type: 'POST',
            url: "{{url('/instant/redeem/')}}",
            data: {uuid: share_cnf, _token: CSRF_TOKEN},
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
        $(document).ready(function(){
            $(document).on("click", ".minimize-verifing", function(e){
                e.preventDefault();
                var task_key = $(this).attr("data-task_key");
                var instance_task_id = $(this).attr("data-instance_task_id");

                var htmlIcon = '<span class="verifing_text" id="verifing_text_'+task_key+'" style="display: block">Verifying...</span>';
                htmlIcon += '<span class="pending_task_'+instance_task_id+'" ><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="rotate" viewBox="0 0 16 16"><path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/><path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/></svg></span>';
                // htmlIcon += oldSpanContainer;

                $("#task_container_"+instance_task_id).hide();

                var classList = $("#instant_task_id_"+instance_task_id).attr("class");
                $("#instant_task_id_"+instance_task_id).attr('data-classes', classList);
                $("#instant_task_id_"+instance_task_id).attr('class', '');
                $("#instant_task_id_"+instance_task_id).addClass('disable');

                // remove href
                var osCheck = getOS();
                if(osCheck=="iPhone" || osCheck=="iOS" || osCheck=="OS X"){
                    var hrefLink = $("#instant_task_id_"+instance_task_id).attr("href");
                    $("#instant_task_id_"+instance_task_id).attr('data-href', hrefLink);
                    document.getElementById("instant_task_id_"+instance_task_id).removeAttribute("href");
                }

                $("#verifing_conent_"+task_key).html();
                $(".verifing_loader_"+task_key).html(htmlIcon);
                Swal.close();
            });
        });

        function showErrorMsgInMinimize(task_key, instance_task_id){
            var htmlIcon = '<span class="verifing_text" id="verifing_text_'+task_key+'" style="display: none">Verifying...</span>';
            // htmlIcon += '<span class="pending_task_'+instance_task_id+'"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="fill: var(--bs-orange);" class="" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/></svg></span>';

            $("#task_container_"+instance_task_id).show();

            var classList =  $("#instant_task_id_"+instance_task_id).attr("data-classes");
            $("#instant_task_id_"+instance_task_id).attr('class', '');
            $("#instant_task_id_"+instance_task_id).attr('class', classList);

            // Add href
            var osCheck = getOS();
            if(osCheck=="iPhone" || osCheck=="iOS" || osCheck=="OS X"){
                var hrefLink = $("#instant_task_id_"+instance_task_id).attr("data-href");
                $("#instant_task_id_"+instance_task_id).attr('href', hrefLink);
            }

            $("#verifing_conent_"+task_key).html();
            $(".verifing_loader_"+task_key).html(htmlIcon);
        }

        function showSuccessMsgInMinimize(task_key, instance_task_id){
            var htmlIcon = '<span class="verifing_text" id="verifing_text_'+task_key+'" style="display: none">Verifying...</span>';
            // htmlIcon += '<span class="complete_task_'+instance_task_id+'" ><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#189325" viewBox="0 0 16 16"><path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"/></svg><span>';

            $("#task_container_"+instance_task_id).show();
            $("#set-single-task_"+instance_task_id).addClass('completed');
            // $("#instant_task_id_"+instance_task_id).removeAttr('class');
            // $("#instant_task_id_"+instance_task_id).addClass('disable');

            $("#verifing_conent_"+task_key).html();
            $(".verifing_loader_"+task_key).html(htmlIcon);
        }
    </script>
    <script>
        let maximumAjaxSocialRrequest = 20;
        let checkAjaxFbPageLikeRequestCount = checkAjaxFbPostCommentRequestCount = checkAjaxFbPostLikeRequestCount = 1;
        let checkAjaxTwFollow = checkAjaxTwLikedBy = 1;
        let checkAjaxInstaProfileFollowers = checkAjaxInstaLikes = checkAjaxInstaComments = 1;
        let checkAjaxYoutubSubcribe = checkAjaxYoutubComment = checkAjaxYoutubLike = 1;
        let checkAjaxGoogleReview = 1;

        // Facebook
        function checkFacebookLikeOurPage(instance_task_id){
            const fb_username = "facebook";
            const fb_business = "{{ $tasks_value['fb_page_url'] ?? '' }}";
            setTimeout(function () {
                Swal.fire({
                    title: "We need to Verify your action, please click on verify button",
                    icon: 'warning',
                    showCloseButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Verify',
                    allowOutsideClick: false,
                })
                .then((result) => {
                    if (result.value==true) {
                        // getting all url with parameters
                        var urlParamsObject = new URLSearchParams(window.location.search)
                        var urlParamsString = urlParamsObject.toString();
                        var share_cnf = urlParamsObject.get('share_cnf');
                        var task_key = 'fb_page_url';
                        if (fb_username) {
                            Swal.fire({
                                title: 'Verifying',
                                timerProgressBar: true,
                                allowOutsideClick: false,
                                text: 'Please wait while verifying or you can minimize and complete other tasks.',
                                footer: '<a class="minimize-verifing btn btn-primary btm-sm px-4" data-task_key="'+task_key+'" data-instance_task_id="'+instance_task_id+'" href="#">Minimize</a>',
                                onBeforeOpen () {
                                    Swal.showLoading();
                                    checkAjaxFbPageLikeRequestCount = 1;
                                    ajaxCheckFacebookLikeOurPage(fb_username, fb_business, share_cnf, instance_task_id, task_key);
                                },
                                onAfterClose () {
                                    Swal.hideLoading();
                                },
                            })
                            .then((result) => {
                            });
                        }
                    }
                })
            }, 3000);
        }

        function ajaxCheckFacebookLikeOurPage(fb_username, fb_business, share_cnf, instance_task_id, task_key){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: "{{url('/instant/fb-page-like')}}",
                data: {fb_username: fb_username, fb_business: fb_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function (results) {
                    $("#overlay").fadeOut(300);
                    if (results.status === true) {
                        Swal.hideLoading();
                        updateTask(instance_task_id ,share_cnf);
                        var check_is_verifing_text_hidden = 'verifing_text_'+task_key;
                        if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                            swal.fire("Done!", results.message, "success");
                        }
                        showSuccessMsgInMinimize(task_key, instance_task_id);
                    } else {
                        checkAjaxFbPageLikeRequestCount++;
                        if(checkAjaxFbPageLikeRequestCount <= maximumAjaxSocialRrequest){
                            ajaxCheckFacebookLikeOurPage(fb_username, fb_business, share_cnf, instance_task_id, task_key);
                        }
                        else{
                            Swal.hideLoading();
                            var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                            if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                                swal.fire(results.message, "", "error");
                            }
                            else{
                                showErrorMsgInMinimize(task_key, instance_task_id);
                            }
                        }   
                    }
                },
                error: function(xhr) { 
                    Swal.hideLoading();
                    $("#overlay").fadeOut(300);
                    // Swal.fire({
                    //     icon: 'error', 
                    //     // title: 'Oops...', 
                    //     text: 'Unable to get response from Facebook!'
                    // });
                    var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                    if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                        swal.fire("Not verified!", "", "error");
                    }
                    else{
                        showErrorMsgInMinimize(task_key, instance_task_id);
                    }
                },
            });
        }

        function checkFacebookPostComment(instance_task_id){
            const fb_username = "facebook";
            const fb_business = "{{ $tasks_value['fb_comment_post_url'] ?? '' }}";

            setTimeout(function () {
                Swal.fire({
                    title: "We need to Verify your action, please click on verify button",
                    icon: 'warning',
                    showCloseButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Verify',
                    allowOutsideClick: false,
                })
                .then((result) => {
                    if (result.value==true) {
                        // getting all url with parameters
                        var urlParamsObject = new URLSearchParams(window.location.search)
                        var urlParamsString = urlParamsObject.toString();
                        var share_cnf = urlParamsObject.get('share_cnf');
                        var task_key = 'fb_comment_post_url';
                        if (fb_username) {
                            Swal.fire({
                                title: 'Verifying',
                                timerProgressBar: true,
                                allowOutsideClick: false,
                                text: 'Please wait while verifying or you can minimize and complete other tasks.',
                                footer: '<a class="minimize-verifing btn btn-primary btm-sm px-4" data-task_key="'+task_key+'" data-instance_task_id="'+instance_task_id+'" href="#">Minimize</a>',
                                onBeforeOpen () {
                                    Swal.showLoading();
                                    checkAjaxFbPostCommentRequestCount = 1;
                                    ajaxCheckFacebookPostComment(fb_username, fb_business, share_cnf, instance_task_id, task_key);
                                },
                                onAfterClose () {
                                    Swal.hideLoading();
                                },
                            })
                            .then((result) => {
                            });
                        }
                    }
                });
            }, 3000);
        }

        function ajaxCheckFacebookPostComment(fb_username, fb_business, share_cnf, instance_task_id, task_key){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: "{{url('/instant/fb-post-comment')}}",
                data: {fb_username: fb_username, fb_business: fb_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function (results) {
                    $("#overlay").fadeOut(300);
                    if (results.status === true) {
                        Swal.hideLoading();
                        // updateTask(instance_task_id ,share_cnf);

                        var check_is_verifing_text_hidden = 'verifing_text_'+task_key;
                        if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                            swal.fire("Done!", results.message, "success");
                        }

                        $.map(results.updatedTasks, function(val, i ) {
                            updateTask(val.instant_task_id,share_cnf);
                            showSuccessMsgInMinimize(val.task_key, val.instant_task_id);
                        });
                    } else {
                        checkAjaxFbPostCommentRequestCount++;
                        if(checkAjaxFbPostCommentRequestCount <= maximumAjaxSocialRrequest){
                            ajaxCheckFacebookPostComment(fb_username, fb_business, share_cnf, instance_task_id, task_key);
                        }
                        else{
                            Swal.hideLoading();
                            var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                            if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                                swal.fire(results.message, "", "error");
                            }
                            else{
                                showErrorMsgInMinimize(task_key, instance_task_id);
                            }
                        }   
                    }
                },
                error: function(xhr) { 
                    Swal.hideLoading();
                    $("#overlay").fadeOut(300);
                    // Swal.fire({ 
                    //     icon: 'error', 
                    //     // title: 'Oops...', 
                    //     text: 'Unable to get response from Facebook!' 
                    // });
                    var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                    if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                        swal.fire("Not verified!", "", "error");
                    }
                    else{
                        showErrorMsgInMinimize(task_key, instance_task_id);
                    }
                },
            });
        }

        function checkFacebookPostLike(instance_task_id){
            const fb_username = "facebook";
            const fb_business = "{{ $tasks_value['fb_like_post_url'] ?? '' }}";
            setTimeout(function () {
                Swal.fire({
                    title: "We need to Verify your action, please click on verify button",
                    icon: 'warning',
                    showCloseButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Verify',
                    allowOutsideClick: false,
                })
                .then((result) => {
                    if (result.value==true) {
                        // getting all url with parameters
                        var urlParamsObject = new URLSearchParams(window.location.search)
                        var urlParamsString = urlParamsObject.toString();
                        var share_cnf = urlParamsObject.get('share_cnf');
                        var task_key = 'fb_like_post_url';
                        if (fb_username) {
                            Swal.fire({
                                title: 'Verifying',
                                timerProgressBar: true,
                                allowOutsideClick: false,
                                text: 'Please wait while verifying or you can minimize and complete other tasks.',
                                footer: '<a class="minimize-verifing btn btn-primary btm-sm px-4" data-task_key="'+task_key+'" data-instance_task_id="'+instance_task_id+'" href="#">Minimize</a>',
                                onBeforeOpen () {
                                    Swal.showLoading();
                                    checkAjaxFbPostLikeRequestCount = 1;
                                    ajaxCheckFacebookPostLike(fb_username, fb_business, share_cnf, instance_task_id, task_key);
                                },
                                onAfterClose () {
                                    Swal.hideLoading();
                                },
                            })
                            .then((result) => {
                            });
                        }
                    }
                });
            }, 3000);
        }

        function ajaxCheckFacebookPostLike(fb_username, fb_business, share_cnf, instance_task_id, task_key){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: "{{url('/instant/fb-post-like')}}",
                data: {fb_username: fb_username, fb_business: fb_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function (results) {
                    $("#overlay").fadeOut(300);
                    if (results.status === true) {
                        // updateTask(instance_task_id ,share_cnf);
                        var check_is_verifing_text_hidden = 'verifing_text_'+task_key;
                        if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                            swal.fire("Done!", results.message, "success");
                        }

                        Swal.hideLoading();
                        $.map(results.updatedTasks, function(val, i ) {
                            updateTask(val.instant_task_id,share_cnf);
                            showSuccessMsgInMinimize(val.task_key, val.instant_task_id);
                        });
                    } else {
                        checkAjaxFbPostLikeRequestCount++;
                        if(checkAjaxFbPostLikeRequestCount <= maximumAjaxSocialRrequest){
                            ajaxCheckFacebookPostLike(fb_username, fb_business, share_cnf, instance_task_id, task_key);
                        }
                        else{
                            Swal.hideLoading();
                            var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                            if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                                swal.fire(results.message, "", "error");
                            }
                            else{
                                showErrorMsgInMinimize(task_key, instance_task_id);
                            }
                        }   
                    }
                },
                error: function(xhr) { 
                    Swal.hideLoading();
                    $("#overlay").fadeOut(300);
                    // Swal.fire({
                    //     icon: 'error', 
                    //     // title: 'Oops...', 
                    //     text: 'Unable to get response from Facebook!' 
                    // })
                    var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                    if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                        swal.fire("Not verified!", "", "error");
                    }
                    else{
                        showErrorMsgInMinimize(task_key, instance_task_id);
                    }
                },
            });
        }

        // Twitter
        /* Add Subcription */
        function checkFollow(instance_task_id) {
            // const tw_username = Swal.getPopup().querySelector('#tw_username').value;
            const tw_username = "tw_username";
            const tw_business = "{{ $tasks_value['tw_username'] ?? '' }}";

            setTimeout(function () {
                Swal.fire({
                    title: "We need to Verify your action, please click on verify button",
                    icon: 'warning',
                    showCloseButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Verify',
                    allowOutsideClick: false,
                })
                .then((result) => {
                    if (result.value==true) {
                        var task_key = 'tw_username';
                        Swal.fire({
                            title: 'Verifying',
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            text: 'Please wait while verifying or you can minimize and complete other tasks.',
                                footer: '<a class="minimize-verifing btn btn-primary btm-sm px-4" data-task_key="'+task_key+'" data-instance_task_id="'+instance_task_id+'" href="#">Minimize</a>',
                            onBeforeOpen () {
                                Swal.showLoading ();
                                // getting all url with parameters
                                var urlParamsObject = new URLSearchParams(window.location.search)
                                var urlParamsString = urlParamsObject.toString();
                                var share_cnf = urlParamsObject.get('share_cnf');

                                if (tw_username) {
                                    checkAjaxTwFollow = 1;
                                    ajaxCheckFollow(tw_username, tw_business, share_cnf, instance_task_id, task_key);
                                }
                            },
                            onAfterClose () {
                                // Swal.hideLoading()
                            },
                        }).then((result) => {
                        })
                    }
                });
            }, 3000);
        }

        function ajaxCheckFollow(tw_username, tw_business, share_cnf, instance_task_id, task_key){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: "{{url('/instant/verify-twfollow')}}",
                data: {tw_username: tw_username, tw_business: tw_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function (results) {
                    $("#overlay").fadeOut(300);
                    if (results.status === true) {
                        updateTask(instance_task_id ,share_cnf);
                        var check_is_verifing_text_hidden = 'verifing_text_'+task_key;
                        if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                            swal.fire("Done!", results.message, "success");
                        }
                        showSuccessMsgInMinimize(task_key, instance_task_id);
                    } else {
                        checkAjaxTwFollow++;
                        if(checkAjaxTwFollow <= maximumAjaxSocialRrequest){
                            ajaxCheckFollow(tw_username, tw_business, share_cnf, instance_task_id, task_key);
                        }
                        else{
                            Swal.hideLoading();
                            var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                            if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                                swal.fire(results.message, "", "error");
                            }
                            else{
                                showErrorMsgInMinimize(task_key, instance_task_id);
                            }
                        }   
                    }
                },
                error: function(xhr) { 
                    Swal.hideLoading();
                    $("#overlay").fadeOut(300);
                    // Swal.fire({
                    //     icon: 'error', 
                    //     // title: 'Oops...', 
                    //     text: 'Unable to get response from Twitter!' 
                    // })
                    var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                    if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                        swal.fire("Not verified!", "", "error");
                    }
                    else{
                        showErrorMsgInMinimize(task_key, instance_task_id);
                    }
                },
            });
        }

        function checkTwLikedBy(instance_task_id) {
            const tw_username = "tw_username";
            const tw_business = "{{ $tasks_value['tw_tweet_url'] ?? '' }}";

            setTimeout(function () {
                Swal.fire({
                    title: "We need to Verify your action, please click on verify button",
                    icon: 'warning',
                    showCloseButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Verify',
                    allowOutsideClick: false,
                })
                .then((result) => {
                    if (result.value==true) {
                        var task_key = 'tw_tweet_url';
                        Swal.fire({
                            title: 'Verifying',
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            text: 'Please wait while verifying or you can minimize and complete other tasks.',
                            footer: '<a class="minimize-verifing btn btn-primary btm-sm px-4" data-task_key="'+task_key+'" data-instance_task_id="'+instance_task_id+'" href="#">Minimize</a>',
                            onBeforeOpen () {
                                Swal.showLoading ();
                                // getting all url with parameters
                                var urlParamsObject = new URLSearchParams(window.location.search)
                                var urlParamsString = urlParamsObject.toString();
                                var share_cnf = urlParamsObject.get('share_cnf');

                                if (tw_username) {
                                    checkAjaxTwLikedBy = 1;
                                    ajaxCheckTwLikedBy(tw_username, tw_business, share_cnf, instance_task_id, task_key);
                                }
                            },
                            onAfterClose () {
                                // Swal.hideLoading()
                            },
                        }).then((result) => {
                        })
                    }
                });
            }, 3000);
        }

        function ajaxCheckTwLikedBy(tw_username, tw_business, share_cnf, instance_task_id, task_key){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: "{{url('/instant/verify-twliked')}}",
                data: {tw_username: tw_username, tw_business: tw_business, share_cnf: share_cnf, instance_task_id:instance_task_id, _token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function (results) {
                    $("#overlay").fadeOut(300);
                    if (results.status === true) {
                        updateTask(instance_task_id,share_cnf);
                        var check_is_verifing_text_hidden = 'verifing_text_'+task_key;
                        if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                            swal.fire("Done!", results.message, "success");
                        }
                        showSuccessMsgInMinimize(task_key, instance_task_id);
                    } else {
                        checkAjaxTwLikedBy++;
                        if(checkAjaxTwLikedBy <= maximumAjaxSocialRrequest){
                            ajaxCheckTwLikedBy(tw_username, tw_business, share_cnf, instance_task_id, task_key);
                        }
                        else{
                            Swal.hideLoading();
                            var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                            if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                                swal.fire(results.message, "", "error");
                            }
                            else{
                                showErrorMsgInMinimize(task_key, instance_task_id);
                            }
                        }
                    }
                },
                error: function(xhr) { 
                    Swal.hideLoading();
                    $("#overlay").fadeOut(300);
                    // Swal.fire({ 
                    //     icon: 'error', 
                    //     // title: 'Oops...', 
                    //     text: 'Unable to get response from Twitter!'
                    // })
                    var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                    if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                        swal.fire("Not verified!", "", "error");
                    }
                    else{
                        showErrorMsgInMinimize(task_key, instance_task_id);
                    }
                },
            });
        }

        // Instagram
        function checkInstaProfile(instance_task_id){
            const insta_username = "instagram";
            const insta_business = "{{ $tasks_value['insta_profile_url'] ?? '' }}";

            setTimeout(function () {
                Swal.fire({
                    title: "We need to Verify your action, please click on verify button",
                    icon: 'warning',
                    showCloseButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Verify',
                    allowOutsideClick: false,
                })
                .then((result) => {
                    if (result.value==true) {
                        // getting all url with parameters
                        var urlParamsObject = new URLSearchParams(window.location.search)
                        var urlParamsString = urlParamsObject.toString();
                        var share_cnf = urlParamsObject.get('share_cnf');
                        var task_key = "insta_profile_url";

                        Swal.fire({
                            title: 'Verifying',
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            text: 'Please wait while verifying or you can minimize and complete other tasks.',
                            footer: '<a class="minimize-verifing btn btn-primary btm-sm px-4" data-task_key="'+task_key+'" data-instance_task_id="'+instance_task_id+'" href="#">Minimize</a>',
                            onBeforeOpen () {
                                Swal.showLoading();
                                checkAjaxInstaProfileFollowers = 1;
                                checkAjaxInstaProfile(insta_username, insta_business, share_cnf, instance_task_id, task_key);
                            },
                            onAfterClose () {
                                Swal.hideLoading();
                            },
                        })
                        .then((result) => {
                        });
                    }
                });
            }, 3000);
        }

        function checkAjaxInstaProfile(insta_username, insta_business, share_cnf, instance_task_id, task_key){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: "{{ route('instagramProfileFollowers') }}",
                data: {insta_username: insta_username, insta_business: insta_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function (results) {
                    $("#overlay").fadeOut(300);
                    if (results.status === true) {
                        Swal.hideLoading();
                        updateTask(instance_task_id ,share_cnf);
                        var check_is_verifing_text_hidden = 'verifing_text_'+task_key;
                        if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                            swal.fire("Done!", results.message, "success");
                        }
                        showSuccessMsgInMinimize(task_key, instance_task_id);
                    } else {
                        checkAjaxInstaProfileFollowers++;
                        if(checkAjaxInstaProfileFollowers <= maximumAjaxSocialRrequest){
                            checkAjaxInstaProfile(insta_username, insta_business, share_cnf, instance_task_id, task_key);
                        }
                        else{
                            Swal.hideLoading();
                            var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                            if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                                swal.fire(results.message, "", "error");
                            }
                            else{
                                showErrorMsgInMinimize(task_key, instance_task_id);
                            }
                        }   
                    }
                },
                error: function(xhr) { 
                    Swal.hideLoading();
                    $("#overlay").fadeOut(300);
                    // Swal.fire({
                    //     icon: 'error', 
                    //     // title: 'Oops...', 
                    //     text: 'Unable to get response from Instagram!'
                    // })

                    var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                    if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                        swal.fire("Not verified!", "", "error");
                    }
                    else{
                        showErrorMsgInMinimize(task_key, instance_task_id);
                    }
                },
            });
        }

        /* Add Instagram Links */
        function checkInstaLikes(instance_task_id){
            const insta_username = "instagram";
            const insta_business = "{{ $tasks_value['insta_post_url'] ?? '' }}";

            setTimeout(function () {
                Swal.fire({
                    title: "We need to Verify your action, please click on verify button",
                    icon: 'warning',
                    showCloseButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Verify',
                    allowOutsideClick: false,
                })
                .then((result) => {
                    if (result.value==true) {
                        // getting all url with parameters
                        var urlParamsObject = new URLSearchParams(window.location.search)
                        var urlParamsString = urlParamsObject.toString();
                        var share_cnf = urlParamsObject.get('share_cnf');
                        var task_key = "insta_post_url";

                        Swal.fire({
                            title: 'Verifying',
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            text: 'Please wait while verifying or you can minimize and complete other tasks.',
                            footer: '<a class="minimize-verifing btn btn-primary btm-sm px-4" data-task_key="'+task_key+'" data-instance_task_id="'+instance_task_id+'" href="#">Minimize</a>',
                            onBeforeOpen () {
                                Swal.showLoading();
                                checkAjaxInstaLikes = 1;
                                ajaxInstaLikes(insta_username, insta_business, share_cnf, instance_task_id, task_key);
                            },
                            onAfterClose () {
                                Swal.hideLoading();
                            },
                        })
                        .then((result) => {
                        });
                    }
                });
            }, 3000);
        }

        function ajaxInstaLikes(insta_username, insta_business, share_cnf, instance_task_id, task_key){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: "{{ route('instagramPostLike') }}",
                data: {insta_username: insta_username, insta_business: insta_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function (results) {
                    $("#overlay").fadeOut(300);
                    if (results.status === true) {
                        Swal.hideLoading();
                        var check_is_verifing_text_hidden = 'verifing_text_'+task_key;
                        if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                            swal.fire("Done!", results.message, "success");
                        }

                        $.map(results.updatedTasks, function(val, i ) {
                            updateTask(val.instant_task_id,share_cnf);
                            showSuccessMsgInMinimize(val.task_key, val.instant_task_id);
                        });
                    } else {
                        checkAjaxInstaLikes++;
                        if(checkAjaxInstaLikes <= maximumAjaxSocialRrequest){
                            ajaxInstaLikes(insta_username, insta_business, share_cnf, instance_task_id, task_key);
                        }
                        else{
                            Swal.hideLoading();
                            var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                            if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                                swal.fire(results.message, "", "error");
                            }
                            else{
                                showErrorMsgInMinimize(task_key, instance_task_id);
                            }
                        }
                    }
                },
                error: function(xhr) {
                    Swal.hideLoading();
                    $("#overlay").fadeOut(300);
                    // Swal.fire({ 
                    //     icon: 'error', 
                    //     // title: 'Oops...', 
                    //     text: 'Unable to get response from Instagram!'
                    // })

                    var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                    if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                        swal.fire("Not verified!", "", "error");
                    }
                    else{
                        showErrorMsgInMinimize(task_key, instance_task_id);
                    }
                },
            });
        }

        /* Add Instagram Comments */
        function checkInstaComments(instance_task_id){
            const insta_username = "instagram";
            const insta_business = "{{ $tasks_value['insta_comment_post_url'] ?? '' }}";

            setTimeout(function () {
                Swal.fire({
                    title: "We need to Verify your action, please click on verify button",
                    icon: 'warning',
                    showCloseButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Verify',
                    allowOutsideClick: false,
                })
                .then((result) => {
                    if (result.value==true) {
                        // getting all url with parameters
                        var urlParamsObject = new URLSearchParams(window.location.search)
                        var urlParamsString = urlParamsObject.toString();
                        var share_cnf = urlParamsObject.get('share_cnf');
                        var task_key = "insta_comment_post_url";

                        Swal.fire({
                            title: 'Verifying',
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            text: 'Please wait while verifying or you can minimize and complete other tasks.',
                            footer: '<a class="minimize-verifing btn btn-primary btm-sm px-4" data-task_key="'+task_key+'" data-instance_task_id="'+instance_task_id+'" href="#">Minimize</a>',
                            onBeforeOpen () {
                                Swal.showLoading();
                                checkAjaxInstaComments = 1;
                                ajaxInstaComments(insta_username, insta_business, share_cnf, instance_task_id, task_key);
                            },
                            onAfterClose () {
                                Swal.hideLoading();
                            },
                        })
                        .then((result) => {
                        });
                    }
                });
            }, 3000);
        }

        function ajaxInstaComments(insta_username, insta_business, share_cnf, instance_task_id, task_key){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: "{{ route('instagramPostComment') }}",
                data: {insta_username: insta_username, insta_business: insta_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function (results) {
                    $("#overlay").fadeOut(300);
                    if (results.status === true) {
                        Swal.hideLoading();
                        var check_is_verifing_text_hidden = 'verifing_text_'+task_key;
                        if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                            swal.fire("Done!", results.message, "success");
                        }

                        $.map(results.updatedTasks, function(val, i ) {
                            updateTask(val.instant_task_id,share_cnf);
                            showSuccessMsgInMinimize(val.task_key, val.instant_task_id);
                        });
                    }
                    else {
                        checkAjaxInstaComments++;
                        if(checkAjaxInstaComments <= maximumAjaxSocialRrequest){
                            ajaxInstaComments(insta_username, insta_business, share_cnf, instance_task_id, task_key);
                        }
                        else{
                            Swal.hideLoading();
                            var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                            if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                                swal.fire(results.message, "", "error");
                            }
                            else{
                                showErrorMsgInMinimize(task_key, instance_task_id);
                            }
                        }
                    }
                },
                error: function(xhr) { 
                    Swal.hideLoading();
                    $("#overlay").fadeOut(300);
                    // Swal.fire({ 
                    //     icon: 'error', 
                    //     // title: 'Oops...', 
                    //     text: 'Unable to get response from Instagram!'
                    // })

                    var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                    if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                        swal.fire("Not verified!", "", "error");
                    }
                    else{
                        showErrorMsgInMinimize(task_key, instance_task_id);
                    }
                },
            });
        }

        // Youtube
        /* Add Subcription */
        function checkSubscribe(instance_task_id) {
            setTimeout(function () {
                const yt_username = "youtube";
                const yt_business = "{{ $tasks_value['yt_channel_url'] ?? '' }}";

                Swal.fire({
                    title: "We need to Verify your action, please click on verify button",
                    icon: 'warning',
                    showCloseButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Verify',
                    allowOutsideClick: false,
                })
                .then((result) => {
                    if (result.value==true) {
                        // getting all url with parameters
                        var urlParamsObject = new URLSearchParams(window.location.search)
                        var urlParamsString = urlParamsObject.toString();
                        var share_cnf = urlParamsObject.get('share_cnf');
                        var task_key = 'yt_channel_url';

                        if (yt_username) {
                            Swal.fire({
                                title: 'Verifying',
                                timerProgressBar: true,
                                allowOutsideClick: false,
                                text: 'Please wait while verifying or you can minimize and complete other tasks.',
                                footer: '<a class="minimize-verifing btn btn-primary btm-sm px-4" data-task_key="'+task_key+'" data-instance_task_id="'+instance_task_id+'" href="#">Minimize</a>',
                                onBeforeOpen () {
                                    Swal.showLoading();
                                    checkAjaxYoutubSubcribe = 1;
                                    ajaxCheckSubscribe(yt_username, yt_business, share_cnf, instance_task_id, task_key);
                                },
                                onAfterClose () {
                                    Swal.hideLoading();
                                },
                            })
                            .then((result) => {
                            });
                        }
                    }
                });
            }, 3000);
        }

        function ajaxCheckSubscribe(yt_username, yt_business, share_cnf, instance_task_id, task_key){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: "{{url('/instant/verify-youtube-subscribe')}}",
                data: {yt_username: yt_username, yt_business: yt_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function (results) {
                    $("#overlay").fadeOut(300);
                    if (results.status === true) {
                        updateTask(instance_task_id,share_cnf);
                        var check_is_verifing_text_hidden = 'verifing_text_'+task_key;
                        if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                            swal.fire("Done!", results.message, "success");
                        }
                        showSuccessMsgInMinimize(task_key, instance_task_id);
                    } else {
                        checkAjaxYoutubSubcribe++;
                        if(checkAjaxYoutubSubcribe <= maximumAjaxSocialRrequest){
                            ajaxCheckSubscribe(yt_username, yt_business, share_cnf, instance_task_id, task_key);
                        }
                        else{
                            Swal.hideLoading();
                            var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                            if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                                swal.fire(results.message, "", "error");
                            }
                            else{
                                showErrorMsgInMinimize(task_key, instance_task_id);
                            }
                        } 
                    }
                },
                error: function(xhr) { 
                    Swal.hideLoading();
                    $("#overlay").fadeOut(300);
                    // Swal.fire({
                    //     icon: 'error', 
                    //     // title: 'Oops...', 
                    //     text: 'Unable to get response from Youtube!'
                    // })

                    var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                    if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                        swal.fire("Not verified!", "", "error");
                    }
                    else{
                        showErrorMsgInMinimize(task_key, instance_task_id);
                    }
                },
            });
        }

        /* Add Comment */
        function checkComment(instance_task_id) {
            const yt_username = "youtube";
            const yt_business = "{{ $tasks_value['yt_comment_url'] ?? '' }}";
            setTimeout(function () {
                Swal.fire({
                    title: "We need to Verify your action, please click on verify button",
                    icon: 'warning',
                    showCloseButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Verify',
                    allowOutsideClick: false,
                })
                .then((result) => {
                    if (result.value==true) {
                        // getting all url with parameters
                        var urlParamsObject = new URLSearchParams(window.location.search)
                        var urlParamsString = urlParamsObject.toString();
                        var share_cnf = urlParamsObject.get('share_cnf');
                        var task_key = "yt_comment_url";
                        if (yt_username) {
                            Swal.fire({
                                title: 'Verifying',
                                timerProgressBar: true,
                                allowOutsideClick: false,
                                text: 'Please wait while verifying or you can minimize and complete other tasks.',
                                footer: '<a class="minimize-verifing btn btn-primary btm-sm px-4" data-task_key="'+task_key+'" data-instance_task_id="'+instance_task_id+'" href="#">Minimize</a>',
                                onBeforeOpen () {
                                    Swal.showLoading();
                                    checkAjaxYoutubComment = 1;
                                    ajaxCheckComment(yt_username, yt_business, share_cnf, instance_task_id, task_key);
                                },
                                onAfterClose () {
                                    Swal.hideLoading();
                                },
                            })
                            .then((result) => {
                            });
                        }
                    }
                });
            }, 3000);
        }

        function ajaxCheckComment(yt_username, yt_business, share_cnf, instance_task_id, task_key){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: "{{url('/instant/verify-youtube-comment')}}",
                data: {yt_username: yt_username, yt_business: yt_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function (results) {
                    $("#overlay").fadeOut(300);
                    if (results.status === true) {
                        // updateTask(instance_task_id,share_cnf);
                        var check_is_verifing_text_hidden = 'verifing_text_'+task_key;
                        if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                            swal.fire("Done!", results.message, "success");
                        }

                        Swal.hideLoading();
                        $.map(results.updatedTasks, function(val, i ) {
                            updateTask(val.instant_task_id,share_cnf);
                            showSuccessMsgInMinimize(val.task_key, val.instant_task_id);
                        });
                    } else {
                        checkAjaxYoutubComment++;
                        if(checkAjaxYoutubComment <= maximumAjaxSocialRrequest){
                            ajaxCheckComment(yt_username, yt_business, share_cnf, instance_task_id, task_key);
                        }
                        else{
                            Swal.hideLoading();
                            var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                            if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                                swal.fire(results.message, "", "error");
                            }
                            else{
                                showErrorMsgInMinimize(task_key, instance_task_id);
                            }
                        }
                    }
                },
                error: function(xhr) { 
                    Swal.hideLoading();
                    $("#overlay").fadeOut(300);
                    // Swal.fire({ 
                    //     icon: 'error', 
                    //     // title: 'Oops...', 
                    //     text: 'Unable to get response from Youtube!' 
                    // })

                    var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                    if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                        swal.fire("Not verified!", "", "error");
                    }
                    else{
                        showErrorMsgInMinimize(task_key, instance_task_id);
                    }
                },
            });
        }

        /* Add Like */
        function checkLike(instance_task_id) {
            const yt_username = "youtube";
            const yt_business = "{{ $tasks_value['yt_like_url'] ?? '' }}";

            setTimeout(function () {
                Swal.fire({
                    title: "We need to Verify your action, please click on verify button",
                    icon: 'warning',
                    showCloseButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Verify',
                    allowOutsideClick: false,
                })
                .then((result) => {
                    if (result.value==true) {
                        // getting all url with parameters
                        var urlParamsObject = new URLSearchParams(window.location.search)
                        var urlParamsString = urlParamsObject.toString();
                        var share_cnf = urlParamsObject.get('share_cnf');
                        var task_key = "yt_like_url";
                        if (yt_username) {
                            Swal.fire({
                                title: 'Verifying',
                                timerProgressBar: true,
                                allowOutsideClick: false,
                                text: 'Please wait while verifying or you can minimize and complete other tasks.',
                                footer: '<a class="minimize-verifing btn btn-primary btm-sm px-4" data-task_key="'+task_key+'" data-instance_task_id="'+instance_task_id+'" href="#">Minimize</a>',
                                onBeforeOpen () {
                                    Swal.showLoading();
                                    checkAjaxYoutubLike = 1;
                                    ajaxCheckLike(yt_username, yt_business, share_cnf, instance_task_id, task_key);
                                },
                                onAfterClose () {
                                    Swal.hideLoading();
                                },
                            })
                            .then((result) => {
                            });
                        }
                    }
                });
            }, 3000);
        }

        function ajaxCheckLike(yt_username, yt_business, share_cnf, instance_task_id, task_key){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: "{{url('/instant/verify-youtube-like')}}",
                data: {yt_username: yt_username, yt_business: yt_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function (results) {
                    $("#overlay").fadeOut(300);
                    if (results.status === true) {
                        // updateTask(instance_task_id,share_cnf);
                        Swal.hideLoading();
                        var check_is_verifing_text_hidden = 'verifing_text_'+task_key;
                        if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                            swal.fire("Done!", results.message, "success");
                        }

                        $.map(results.updatedTasks, function(val, i ) {
                            updateTask(val.instant_task_id,share_cnf);
                            showSuccessMsgInMinimize(val.task_key, val.instant_task_id);
                        });
                    } else {
                        checkAjaxYoutubLike++;
                        if(checkAjaxYoutubLike <= maximumAjaxSocialRrequest){
                            ajaxCheckLike(yt_username, yt_business, share_cnf, instance_task_id, task_key);
                        }
                        else{
                            Swal.hideLoading();
                            var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                            if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                                swal.fire(results.message, "", "error");
                            }
                            else{
                                showErrorMsgInMinimize(task_key, instance_task_id);
                            }
                        }
                    }
                },
                error: function(xhr) { 
                    Swal.hideLoading();
                    $("#overlay").fadeOut(300);
                    // Swal.fire({ 
                    //     icon: 'error', 
                    //     // title: 'Oops...', 
                    //     text: 'Unable to get response from Youtube!'
                    // })

                    var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                    if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                        swal.fire("Not verified!", "", "error");
                    }
                    else{
                        showErrorMsgInMinimize(task_key, instance_task_id);
                    }
                },
            });
        }

        // Google Review
        function checkGoogleReview(instance_task_id) {
            var task_value = $("#instant_task_id_"+instance_task_id).attr("data-task_value");
            var task_key = $("#instant_task_id_"+instance_task_id).attr("data-task_key");
            var countResult = setInstantTaskCount('setCount', task_value, task_key, instance_task_id);

            setTimeout(function () {
                swal.fire({
                    title: 'Enter Your Name!',
                    html: `<input type="text" id="google_username" class="swal2-input" placeholder="Enter Your Name">`,
                    confirmButtonText: 'Verify',
                    focusConfirm: false,
                    showCancelButton: !0,
                    cancelButtonText: "Close",
                    allowOutsideClick: false,
                    reverseButtons: !0,
                    preConfirm: () => {
                        const google_username = Swal.getPopup().querySelector('#google_username').value;
                        const google_business = "{{ $tasks_value['google_review_link'] ?? '' }}";
                        if (google_username == '') {
                            Swal.showValidationMessage(`Please enter your name!`)
                        }
                        return { google_username: google_username, google_business: google_business }
                    }
                }).then(function (e) {
                    if(e.dismiss){
                        Swal.hideLoading();
                    }
                    else{
                        var task_key = 'google_review_link';
                        Swal.fire({
                            title: 'Verifying',
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            text: 'Please wait while verifying or you can minimize and complete other tasks.',
                            footer: '<a class="minimize-verifing btn btn-primary btm-sm px-4" data-task_key="'+task_key+'" data-instance_task_id="'+instance_task_id+'" href="#">Minimize</a>',
                            onBeforeOpen () {
                                Swal.showLoading ();
                                // getting all url with parameters
                                var urlParamsObject = new URLSearchParams(window.location.search)
                                var urlParamsString = urlParamsObject.toString();
                                var share_cnf = urlParamsObject.get('share_cnf');
                                if (e.value && e.value.google_username) {
                                    const google_username = e.value.google_username;
                                    const google_business = e.value.google_business;

                                    checkAjaxGoogleReview = 1;
                                    ajaxCheckGoogleReview(google_username, google_business, share_cnf, instance_task_id, task_key);
                                }
                            },
                            onAfterClose () {
                                // Swal.hideLoading()
                            },
                        }).then((result) => {
                        });
                    }
                }, function (dismiss) {
                    Swal.hideLoading();
                    return false;
                })
            }, 3000);
        }

        function ajaxCheckGoogleReview(google_username, google_business, share_cnf, instance_task_id, task_key){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: "{{url('/instant/verify-google-review')}}",
                data: {google_username: google_username, google_business: google_business, share_cnf: share_cnf, instance_task_id: instance_task_id, _token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function (results) {
                    $("#overlay").fadeOut(300);
                    if (results.status === true) {
                        updateTask(instance_task_id ,share_cnf);
                        var check_is_verifing_text_hidden = 'verifing_text_'+task_key;
                        if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                            swal.fire("Done!", results.message, "success");
                        }
                        showSuccessMsgInMinimize(task_key, instance_task_id);
                    } else {
                        checkAjaxGoogleReview++;
                        if(checkAjaxGoogleReview <= maximumAjaxSocialRrequest){
                            ajaxCheckGoogleReview(google_username, google_business, share_cnf, instance_task_id, task_key);
                        }
                        else{
                            Swal.hideLoading();
                            var check_is_verifing_text_hidden = 'verifing_text_'+task_key;
                            if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                                swal.fire(results.message, "", "error");
                            }
                            else{
                                showErrorMsgInMinimize(task_key, instance_task_id);
                            }
                        }   
                    }
                },
                error: function(xhr) { 
                    Swal.hideLoading();
                    $("#overlay").fadeOut(300);
                    // Swal.fire({
                    //     icon: 'error', 
                    //     title: 'Oops...', 
                    //     text: 'Unable to get response from Google!'
                    // });

                    var check_is_verifing_text_hidden = 'verifing_text_'+task_key; 
                    if($('#'+check_is_verifing_text_hidden).is(":visible") == false){
                        swal.fire("Not verified!", "", "error");
                    }
                    else{
                        showErrorMsgInMinimize(task_key, instance_task_id);
                    }
                },
            });
        }


        // Status may be => setCount OR verifyingCount 
        async function setInstantTaskCount(status, task_value, task_key, instant_task_id){
            return await instantTaskCount(status, task_value, task_key, instant_task_id);
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

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

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
                    _token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function (results) {
                    return results.status;
                    // console.log("instantTaskCount result "+ results);
                },
                error: function(xhr) { 
                    return false;
                    // console.log("instantTaskCount error "+ xhr);
                },
            });
        }
        
    </script>