@php
    // dd($planData['wa_api_url']->value);
@endphp

<script type="text/javascript">

    var n = 0;

    var interval;
    var refreshId;
    var intervalReconnect;
    var intervalCallNow;
    var QrScaned = false;
    var start = Date.now();

    function callNow(instance_key) {
        if(QrScaned != true){
            get_key_info(instance_key);
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
        if (checkNow()) {
            var image = new Image();
            image.src = "{{ asset('assets/click-to-reload1.jpg') }}";
            $('.reload-qr').hide();
            $("#qr_code_img img:last-child").remove()
            $('#qr_code_img').append(image);
            $("#qr_code_img img:last-child").attr('id', 'onClickReloadQR');
            $('#countdownTest').html('');
            $('#countdownTest').html('<span>Code will not change </span><b><span class="text-danger js-timeout">until</span> you reload.</b>');
            clearInterval(interval);
            clearInterval(intervalCallNow);
            return false;
        }
        updateBeat();
        get_wa_token();
    }
    

    /* 20 seconds countdown */
    function countdown() {
        // console.log('hey');
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
                    countdown2();
                }
        }, 1000);
    }

    /* get instance id*/
    var wa_action = "{{ $planData['wa_api_url']->value ?? NULL }}";
    var key_secret = "{{ $planData['wa_session']->key_secret ?? NULL }}";
    var key_id = "{{ $planData['wa_session']->key_id ?? NULL }}";
    var wa_mobile = "{{ $planData['userData']->mobile ? '91'.$planData['userData']->mobile : NULL }}";
    
    function get_wa_token(){
        $("#qr_code_img img").remove();
        $('.reload-qr').show();
        $.ajax({
            url : wa_action+'/instance/init?key_secret='+key_secret+'&key_id='+key_id+'&wa_mobile='+wa_mobile,
            type : 'GET',
            dataType : "json", 
            success : function(res) {
                
                if(res.error == false) {
                    $('#instance_key').text();
                    $('#instance_key').text(res.key);
                    // console.log('get_wa_token:', $('#instance_key').text());
                    setTimeout(function() { 
                        get_qrcode(res.key); 
                    }, 2000);
                    
                }
            }
        });
    }

    /* get QR Code */
    function get_qrcode(instance_key){
        // console.log(instance_key);
        $.ajax({
            url : wa_action+'/instance/qrbase64?key='+instance_key,
            type : 'GET',
            dataType : "json", 
            success : function(res) {
                // console.log('get_qrcode: ',res);
                if(res.error == false){
                    var image = new Image();
                    image.src = res.qrcode;
                    $('.reload-qr').hide();
                    $('#qr_code_img').append(image);
                    $('.js-timeout').html('1:00');
                    countdown();
                    intervalCallNow = setInterval(function(){
                        callNow(instance_key);
                    }, 4000)
                }
            }
        });        
    }

    /* check instance id is connected or not*/
    function get_key_info(instance_key){
        let phone_connected = false;
        let current_instance_key = $("#instance_key").text();   
        if(QrScaned != true && current_instance_key == instance_key){
            $.ajax({
                url : wa_action+'/instance/info?key='+instance_key,
                type : 'GET',
                dataType : "json",
                success : function(res) {
                    // console.log('get_key_info: ',res);
                    phone_connected = res.instance_data.phone_connected;
                    if(res.error == false && (phone_connected != undefined || phone_connected == true)){
                        // console.log('Connected');
                        let wa_data = set_key(res.instance_data);
                        let number = res.instance_data.user.id.split(':');
                        $('#disconnected').hide();
                        
                        $('#connected img').attr('title', number[0]);
                        $('#connected #wa_name').text('');
                        $('#connected #wa_name').text('('+res.instance_data.user.id+')');
                        $('#connected #wa_number').text('');
                        $('#connected #wa_number').text(number[0]);
                        $('#connected').show();

                        $('#contact_tab6 .status-icon').empty();
                        $('#contact_tab6 .status-icon').html('<i class="fas fa-check-circle text-success"></i>');
                        $("#progressList_3").addClass("done");  

                        clearInterval(interval);
                        clearInterval(intervalCallNow);
                        QrScaned = true;

                    }else{
                        // console.log('Not Connected');
                    }
                }
            });
        }
    }

    /* inserting instance data into database */
    function set_key(instance_data){
        var jid = instance_data.user.id;
        var number = jid.split(':');
        var instance_key = instance_data.instance_key;
        $.ajax({
            url : "{{ route('business.setInstanceKey') }}",
            type : 'POST',
            data : {
                "jid": jid,
                "number" : number[0],
                "instance_key" : instance_key,
                "_token" : $('meta[name="csrf-token"]').attr('content')
            },
            dataType : "json", 
            success : function(res) {
                // console.log('set_key: ',res);
                if(res.error == false){
                    $('#instance_key').text();
                    $('#instance_key').text(instance_key);
                }
            }
        });
    }

    function reset_key(){
        
        $.ajax({
            url : "{{ route('business.resetInstanceKey') }}",
            type : 'POST',
            data : {
                "key_id": key_id,
                "key_secret" : key_secret,
                "_token" : $('meta[name="csrf-token"]').attr('content')
            },
            dataType : "json", 
            success : function(res) {
                // console.log('reset_key: ',res);
                
            }
        });
    }

    function reconnectOnLoad(instance_key){

        if(QrScaned != true){
            if(instance_key != '' || instance_key != null){
                $.ajax({
                    url : wa_action+'/instance/qrbase64?key='+instance_key,
                    type : 'GET',
                    dataType : "json", 
                    success : function(res) {
                        // console.log('reconnectOnLoad: ',res);
                        if(res.error == false){
                            if(res.qrcode == '' || res.qrcode == ' '){
                                let data = get_wa_token();
                            }
                            $('#instance_key').text();
                            $('#instance_key').text(res.key);
                        }else{
                            //
                        }
                    }
                });
            }else{
                let data = get_wa_token();
                // console.log(data);                
            }
        }
    }

    /* at end of the all script */
    $(document).ready(function(){
        $(document).on('click', '#onClickReloadQR', function(){
            clearInterval(interval);
            clearInterval(refreshId);
            clearInterval(intervalCallNow);
            $('#countdownTest').html('');
            $('#countdownTest').html('<span>Code will change in </span><b><span class="text-danger js-timeout">0:20</span> sec.</b>');
            n = 0;
            get_wa_token(); countdown(); 
            // console.log(n);
        })
        
        var instance_key = "{{ isset($wa_session->instance_id) ? $wa_session->instance_id : '' }}";
        // console.log(instance_key);
        if(instance_key){ 
            // get_key_info(instance_key)
            // reconnectOnLoad(instance_key) 

            $.ajax({
                url : wa_action+'/instance/info?key='+instance_key,
                type : 'GET',
                dataType : "json",
                success : function(res) {
                    // console.log('get_key_info: ',res);
                    phone_connected = res.instance_data.phone_connected;
                    if(phone_connected != undefined && phone_connected == false){
                        $('#instance_key').text();
                        $('#connected').hide();
                        $('#disconnected').show();
                        reset_key();
                        get_wa_token();

                        // reconnectOnLoad(instance_key) 
                        // console.log('Not Connected');
                    }
                }
            });
        }else{ 
            get_wa_token(); 
        }
    });

    </script>