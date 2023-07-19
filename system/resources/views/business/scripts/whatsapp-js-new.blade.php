<script type="text/javascript">

    var n = 0;

    var interval;
    var refreshId;
    var intervalReconnect;
    var intervalCallNow;
    var QrScaned = false;
    var start = Date.now();

    function callNow(instance_id) {
        if(QrScaned != true){
            reconnect(instance_id);
        }
    }

    function updateBeat() {
        n = parseInt(n) + 1;
        // console.log(n*20+' Seconds Completed! & ', 'n = '+n);
    }

    function checkNow() {
        // console.log(n)
        if(n >= 3){
            clearInterval(interval);
            // clearInterval(refreshId);
            // clearInterval(intervalReconnect);
            clearInterval(intervalCallNow);
            return true;
        }else{
            return false;
        }
    }

    function reload(frame, url) {
        $(frame).load(url);
    }

    /* Countdown 2 */
    function countdown2(){
        // refreshId = setInterval(function() {
            if (checkNow()) {
                var image = new Image();
                image.src = "{{ asset('assets/click-to-reload1.jpg') }}";
                $('.reload-qr').hide();
                $("#qr_code_img img:last-child").remove()
                $('#qr_code_img').append(image);
                $("#qr_code_img img:last-child").attr('id', 'onClickReloadQR');
                // console.log("Sleep");
                $('#countdownTest').html('');
                $('#countdownTest').html('<span>Code will not change </span><b><span class="text-danger js-timeout">until</span> you reload.</b>');
                clearInterval(interval);
                // clearInterval(refreshId);
                // clearInterval(intervalReconnect);
                clearInterval(intervalCallNow);
                return false;
            }
            updateBeat();
            // get_wa_token();
            get_new_wa_token();
        // }, 20000);
    }
    

    /* 20 seconds countdown */
    function countdown() {
        clearInterval(interval);
        interval = setInterval( function() {
            var timer = $('.js-timeout').html();
            timer = timer.split(':');
            var minutes = timer[0];
            var seconds = timer[1];
            seconds -= 1;
            if (minutes < 0)
                return;
            else if (seconds < 0 && minutes != 0) {
                minutes -= 1;
                seconds = 59;
            }
            else if (seconds < 10 && length.seconds != 2)
                seconds = '0' + seconds;
                $('.js-timeout').html(minutes + ':' + seconds);

            if (minutes == 0 && seconds == 0)
                clearInterval(interval);

                var timeout = $('.js-timeout').html();
                if(timeout == '0:00'){
                    // get_wa_token();
                    countdown2();
                }
        }, 1000);
    }

    /* get instance id*/
    // var action = '{{ $wa_url->value }}/api';
    // var access_token = '{{ $userData->wa_access_token }}';

    // function get_wa_token(){
    //     $("#qr_code_img img").remove();
    //     $('.reload-qr').show();
    //     $.ajax({
    //         url : action+'/createinstance.php?access_token='+access_token,
    //         type : 'POST',
    //         dataType : "json", 
    //         success : function(res) {
    //             // console.log(res);
    //             if(res.status == 'success'){
    //                 $('#instance_id').text();
    //                 $('#instance_id').text(res.instance_id);
    //                 get_qrcode(res.instance_id);
    //             }
    //         }
    //     });
    // }

    /* New Wa Serve Code Start */
    var wa_action = '{{ $wa_api_url->value }}';
    var key_secret = '{{ $userData->wa_key_secret }}';
    var key_id = '{{ $userData->wa_key_id }}';
    var wa_mobile = '{{ $userData->mobile }}';

    function get_new_wa_token(){
        $("#qr_code_img img").remove();
        $('.reload-qr').show();
        $.ajax({
            url : wa_action+'/instance/init?key_secret='+key_secret+'&key_id='+key_id+'&wa_mobile='+wa_mobile,
            type : 'GET',
            dataType : "json", 
            success : function(res) {
                // console.log(res);
                if(res.error == false){
                    $('#instance_id').text();
                    $('#instance_id').text(res.key);
                    get_new_qrcode(res.key);
                }
            }
        });
    }
    /* New Wa Serve Code End */

    /* get QR Code */
    // function get_qrcode(instance_id){

    //     var user_data = @json(auth()->user());
        
    //     if(user_data.is_demo == 0){
    //         $.ajax({
    //             url : action+'/getqrcode.php?instance_id='+instance_id+'&access_token='+access_token,
    //             type : 'GET',
    //             dataType : "json", 
    //             success : function(res) {
    //                 // console.log(res.base64);
    //                 if(res.status == 'success'){
    //                     var image = new Image();
    //                     image.src = res.base64;
    //                     $('.reload-qr').hide();
    //                     $('#qr_code_img').append(image);
    //                     $('.js-timeout').html('0:20');
    //                     countdown();
    //                     // setInterval(function(){
    //                     //     reconnect(instance_id);
    //                     // }, 5000)
    //                     intervalCallNow = setInterval(function(){
    //                         callNow(instance_id);
    //                     }, 5000)
    //                 }
    //             }
    //         }); 
    //     }
        
    // }


    /* New Wa Serve Code Start */
    function get_new_qrcode(instance_id){

        var user_data = @json(auth()->user());

        if(user_data.is_demo == 0){
            $.ajax({
                url : wa_action+'/instance/qrbase64?key='+instance_id,
                type : 'GET',
                dataType : "json", 

                success : function(res) {
                    console.log(res.qrcode);
                    // if(res.status == 'success'){
                    //     var image = new Image();
                    //     image.src = res.base64;
                    //     $('.reload-qr').hide();
                    //     $('#qr_code_img').append(image);
                    //     $('.js-timeout').html('0:20');
                    //     countdown();
                        
                    //     intervalCallNow = setInterval(function(){
                    //         callNow(instance_id);
                    //     }, 5000)
                    // }
                }
            }); 
        }

    }
    /* New Wa Serve Code End */

    /* check instance id is connected or not*/
    function reconnect(instance_id){
        var user_data = @json(auth()->user());
        
        if(QrScaned != true && user_data.is_demo == 0){
            $.ajax({
                url : action+'/reconnect.php?instance_id='+instance_id+'&access_token='+access_token,
                type : 'POST',
                dataType : "json",
                success : function(res) {
                    console.log(res);
                    if(res.status == 'success'){
                        $.ajax({
                            url : '{{ route('business.setInstance') }}',
                            type : 'POST',
                            data : {
                                "instance_id": instance_id,
                                "data": res.data,
                                "_token" : $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType : "json", 
                            success : function(record) {
                                console.log(record);
                                var prof = '{{asset('assets/img/avatar/avatar-2.png')}}';
                                    if(record.status == true){
                                        // setWebhook(instance_id);
                                        var number = res.data['id'].split(':');
                                        
                                        $('#disconnected').hide();
                                        $('#connected img').attr('src', res.data['avatar']);
                                        $('#connected img').attr('title', number[0]);
                                        $('#connected #wa_name').text('');
                                        $('#connected #wa_name').text('('+res.data['id']+')');
                                        $('#connected #wa_number').text('');
                                        $('#connected #wa_number').text(number[0]);
                                        $('#connected').show();

                                        
                                        $('#contact_tab6 .status-icon').empty();
                                        $('#contact_tab6 .status-icon').html('<i class="fas fa-check-circle text-success"></i>');

                                        clearInterval(interval);
                                        clearInterval(intervalCallNow); 
                                        QrScaned = true;

                                        window.location.href = '{{ url("business/settings") }}'
                                    }
                                // }
                            }
                        });
                    }else{
                        $('#disconnected').show();
                        $('#connected').hide();

                        var wa_instance_id = '{{ isset($wa_session->instance_id) ? $wa_session->instance_id : '' }}';
                        if(wa_instance_id != ''){
                            $.ajax({
                                url : '{{ route('business.removeInstance') }}',
                                type : 'POST',
                                data : {
                                    "user_id": {{ $basic->user_id }},
                                    "_token" : $('meta[name="csrf-token"]').attr('content')
                                },
                                dataType : "json", 
                                success : function(record) {
                                    // console.log(record);
                                    // get_wa_token();
                                    window.location.href = '{{ url("business/settings") }}'
                                }
                            });
                        }

                        
                    }
                }
            });
        }
    }


    function reconnectOnLoad(instance_id){

        if(QrScaned != true){
            $.ajax({
                url : action+'/reconnect.php?instance_id='+instance_id+'&access_token='+access_token,
                type : 'POST',
                dataType : "json",
                success : function(res) {
                    console.log(res);
                    if(res.status == 'success'){
                        $.ajax({
                            url : '{{ route('business.setInstance') }}',
                            type : 'POST',
                            data : {
                                "instance_id": instance_id,
                                "data": res.data,
                                "_token" : $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType : "json", 
                            success : function(record) {
                                console.log(record);
                                var prof = '{{asset('assets/img/avatar/avatar-2.png')}}';
                                    if(record.status == true){
                                        // setWebhook(instance_id);
                                        var number = res.data['id'].split(':');
                                        
                                        $('#disconnected').hide();
                                        $('#connected img').attr('src', res.data['avatar']);
                                        $('#connected img').attr('title', number[0]);
                                        $('#connected #wa_name').text('');
                                        $('#connected #wa_name').text('('+res.data['id']+')');
                                        $('#connected #wa_number').text('');
                                        $('#connected #wa_number').text(number[0]);
                                        $('#connected').show();

                                        
                                        $('#contact_tab6 .status-icon').empty();
                                        $('#contact_tab6 .status-icon').html('<i class="fas fa-check-circle text-success"></i>');

                                        clearInterval(interval);
                                        clearInterval(intervalCallNow); 
                                        QrScaned = true;

                                        // window.location.href = '{{ url("business/settings?wa=true") }}'
                                    }
                                // }
                            }
                        });
                    }else{
                        $('#disconnected').show();
                        $('#connected').hide();

                        var wa_instance_id = '{{ isset($wa_session->instance_id) ? $wa_session->instance_id : '' }}';
                        if(wa_instance_id != ''){
                            $.ajax({
                                url : '{{ route('business.removeInstance') }}',
                                type : 'POST',
                                data : {
                                    "user_id": {{ $basic->user_id }},
                                    "_token" : $('meta[name="csrf-token"]').attr('content')
                                },
                                dataType : "json", 
                                success : function(record) {
                                    // console.log(record);
                                    // get_wa_token();
                                    window.location.href = '{{ url("business/settings") }}'
                                }
                            });
                        }

                        
                    }
                }
            });
        }
    }
    
    // function setWebhook(instance_id){
    //     $.ajax({
    //         url : '{{ route('business.setWebhook') }}',
    //         type : 'POST',
    //         data : {
    //             "instance_id": instance_id,
    //             "access_token": access_token,
    //             "_token" : $('meta[name="csrf-token"]').attr('content')
    //         },
    //         dataType : "json", 
    //         success : function(record) {
    //             // console.log(record);
    //         }
    //     });
    // }

    $(document).ready(function(){
        $(document).on('click', '#onClickReloadQR', function(){
            // console.log('Clicks');
            clearInterval(interval);
            clearInterval(refreshId);
            // clearInterval(intervalReconnect);
            clearInterval(intervalCallNow);
            $('#countdownTest').html('');
            $('#countdownTest').html('<span>Code will change in </span><b><span class="text-danger js-timeout">0:20</span> sec.</b>');
            n = 0;
            // get_wa_token(); 
            get_new_wa_token();
            countdown(); 
            // console.log(n);
        })


        /* Check Whatsapp Connection */
        var instance = '{{ isset($wa_session->instance_id) ? $wa_session->instance_id : '' }}';
        // console.log(instance);
        reconnectOnLoad(instance);
    });
        

    @if(!$wa_session || $wa_session->instance_id == '') 
    window.onload = function() { 
        // get_wa_token(); 
        get_new_wa_token(); 
        countdown(); 
    }; 
    @endif

    </script>