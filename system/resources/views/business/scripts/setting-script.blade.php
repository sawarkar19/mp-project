<script>
    $(document).on("click", ".connect_to_youtube", function(){
        sessionStorage.setItem('connect_to', 'youtube');
        window.location.href = '{{ route('business.channel.instantRewards.modifyTasks') }}';
    });



    /* Billing address */
    $(document).on("change", "#same_to_bill", function(){
        
        if(this.checked) {
            $(this).prop("checked", true);
            $.ajax({
                url : '{{ route('business.checkSameBilling') }}',
                type : 'GET',
                dataType : "json", 
                success : function(record) {
                    console.log(record);
                    $('#billing_address_line_1').val(record.details.billing_address_line_1);
                    $('#billing_pincode').val(record.details.billing_pincode);
                    $('#billing_pincode').val(record.details.billing_pincode);
                    $('#billing_city').val(record.details.billing_city);
                    $('#billing_state').val(record.details.billing_state);
                    if(record.tab == 'billing_address'){
                        $('#billing_address .status-icon').empty();
                        $('#billing_address .status-icon').html('<i class="fas fa-check-circle text-success"></i>');
                    }
                    Sweet('success','Billing address set same as business address!');
                    return true;
                }
            });
        }else{
            $(this).prop("checked", true);
            swal.fire({
                title: 'Are you sure?',
                text: 'Once unchecked, your billing address will show empty!',
                type: 'question',
                icon: 'warning',
                animation: true,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes Delete',
                cancelButtonText: 'Cancel',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: true,
                focusConfirm: true
            })
            .then(function(data){
                /*console.log(data.value);*/
                if (data.value == true) {
                    $("#overlay").fadeIn(300);
                    
                    $.ajax({
                        type: 'POST',
                        url: "{{route('business.deleteBilling')}}",
                        data:  {"_token": "{{ csrf_token() }}"},
                        dataType: 'JSON',
                        success: function (res) {

                            $("#overlay").fadeOut(300);
                            
                            if(res.status == true){
                                Swal.fire(
                                  'Deleted!',
                                  res.message,
                                  'success'
                                )
                                
                                $('#billing_address_line_1').val('');
                                $('#billing_pincode').val('');
                                $('#billing_pincode').val('');
                                $('#billing_city').val('');
                                $('#billing_state').val('');

                                if(res.tab == 'billing_delete'){
                                    $('#billing_address .status-icon').empty();
                                    $('#billing_address .status-icon').html('<i class="fas fa-exclamation-circle text-warning"></i>');
                                }

                                $("#same_to_bill").prop("checked", false);

                            }else{
                                /* Swal.fire(
                                  'Deleted!',
                                  res.message,
                                  'success'
                                ) */

                                
                            }
                        }
                    });
                        
                } /*else {
                    Sweet('success','Your logo file is safe!');
                }*/
            });
            
        }
        // console.log(this.checked);
    });
    
    /* Tab Selection */
    $(document).on("click", ".setting-section", function(){
        sessionStorage.setItem("setting_section", $(this).attr('id'));

        var tab_id = $(this).attr('id');
        $(".setting-section-tab").removeClass("active");
        $(".setting-section-tab").removeClass("show");

        $("#"+tab_id+"_tab").addClass("active");
        $("#"+tab_id+"_tab").addClass("show");
    });


    /* Channel */
    $(document).on("change", ".custom-switch", function(){

        var parentId, checkbox, value;
        parentId = $(this).attr('id');
        checkbox = $('#'+parentId+' .custom-switch-input');

        const routeArr = parentId.split("_");
        var wa_instance = '{{ isset($planData['wa_session']->instance_id) ? $planData['wa_session']->instance_id : "" }}';
        
        if(routeArr[0] == 'wa' && wa_instance == ''){
            $('#'+parentId+' .custom-switch-input').prop('checked', false);
            Swal.fire({
                title: '<strong>Whatsapp QR Scan</strong>',
                icon: 'info',
                html:
                    'You are not connected to Whatsapp. Go to setting and scan QR code to connect with your whatsapp.',
                showCloseButton: false,
                showCancelButton: true,
                focusConfirm: false,
                allowOutsideClick:false,
                confirmButtonText:
                    'Go To Settings',
                cancelButtonText:
                    'Close'
            }).then((result) => {
                // console.log(result);
                if (result.value == true) {
                    window.location.href = '{{ url('/business/settings?wa=true' ) }}'
                } 
            })
        }else{  

            // if(routeArr[0] == 'sms' && wa_instance == '' && !checkbox.is(':checked')){
            //     $('#'+parentId+' .custom-switch-input').prop('checked', true);
            //     Swal.fire({
            //         title: '<strong>Whastapp QR Scan</strong>',
            //         icon: 'info',
            //         html:
            //             'To disable SMS route you have to connect to Whatsapp. Go to setting and scan QR code to connect with your whatsapp.',
            //         showCloseButton: false,
            //         showCancelButton: true,
            //         focusConfirm: false,
            //         allowOutsideClick:false,
            //         confirmButtonText:
            //             'Go To Settings',
            //         cancelButtonText:
            //             'Close'
            //     }).then((result) => {
            //         // console.log(result);
            //         if (result.value == true) {
            //             window.location.href = '{{ url('/business/settings?wa=true' ) }}'
            //         } 
            //     })

            //     return false;
            // }

            if(checkbox.is(':checked')) { 
                checkbox.val('1'); 
            }else{ 
                checkbox.val('0'); 
            }
            value = checkbox.val();
            /*if(value=='1'){
                var is_paid = '{{ auth()->user()->current_account_status }}';
                if(is_paid == 'free'){
                    $('#'+parentId+' .custom-switch-input').prop('checked', false);
                    Sweet('error',"{{ Config::get('constants.payment_alert')}}");
                    return false;
                }
            }*/
            $.ajax({
                url : '{{ route('business.msgToggle') }}',
                type : 'POST',
                data : {
                    "channel": parentId,
                    "value" : value,
                    "_token" : $('meta[name="csrf-token"]').attr('content')
                },
                dataType : "json", 
                success : function(record) {
                    
                    if(record.status == true){
                        // if(record.messager == true ){ $('#'+record.channel+' .custom-switch-input').prop('checked', true)}
                        Sweet('success',record.message);

                        setTimeout(() => {
                            location.reload();
                        }, 1200);

                        return true;
                    }else{
                        if(record.message=='Low'){
                                return paidtofree();
                        }else{
                           $('#'+parentId+' .custom-switch-input').prop('checked', false);         
                            Sweet('error',record.message);
                            return false; 
                        }         
                        
                    }
                    
                }
            });
        }
    });

    /* Notification*/
    $(document).on("change", ".custom-switch-notification", function(){

        var parentId, checkbox, value;
        parentId = $(this).attr('id');
        checkbox = $('#'+parentId+' .custom-switch-input');

        const routeArr = parentId.split("_");
        var wa_instance = '{{ isset($planData['wa_session']->instance_id) ? $planData['wa_session']->instance_id : "" }}';
 

            if(checkbox.is(':checked')) { 
                checkbox.val('1'); 
            }else{ 
                checkbox.val('0'); 
            }
            value = checkbox.val();
            $.ajax({
                url : '{{ route('business.emailToggle') }}',
                type : 'POST',
                data : {
                    "notification": parentId,
                    "value" : value,
                    "_token" : $('meta[name="csrf-token"]').attr('content')
                },
                dataType : "json", 
                success : function(record) {
                    // console.log(record);
                    if(record.status == true){
                        // if(record.messager == true ){ $('#'+record.channel+' .custom-switch-input').prop('checked', true)}
                        Sweet('success',record.message);

                        setTimeout(() => {
                            location.reload();
                        }, 1200);

                        return true;
                    }else{           
                        $('#'+parentId+' .custom-switch-input').prop('checked', false);         
                        Sweet('error',record.message);
                        return false;
                    }
                    
                }
            });
        

    });

    /* add number */
    $(document).ready(function(){
        $("#notification_number_form").on('submit', function(e){
            e.preventDefault();
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: this.action,
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                success: function(response){ 
                    console.log(response);
                    if(response.status == true){
                        //$('#pageform').trigger('reset');
                        Sweet('success',response.message);
                        setTimeout(function(){
                            location.reload();
                        },2000);
                    }else{
                        Sweet('error',response.message);
                    }
                },
                error: function(xhr, status, error) 
                {
                    $.each(xhr.responseJSON.errors, function (key, item) 
                    {
                        Sweet('error',item);
                    });
                }
            })
            
        });

    });

    /* remove number*/

    $(document).on('click', '.delete-item', function (e) {
        e.preventDefault();

        var notification_contact_id = $(this).attr('id');

            Swal.fire({
				title: 'Are you sure?',
				text: "Do you really want to remove this number?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete !'
			  }).then((result) => {
				if (result.value == true) {
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});
	
					$.ajax({
						type: 'POST',
						url: '{{ url('business/destroy-number') }}' + '/' + notification_contact_id,
						data: {
							notification_contact_id: notification_contact_id
						},
						dataType: 'json',
						success: function(response) {
							Sweet('success', response.message);
							$('#notification_contact_id' + notification_contact_id).css('display', 'none');
                            setTimeout(function() {
                                location.reload();
                            },2000);
						},
						error: function(xhr, status, error) {
							Sweet('error', 'Number not removed');
						}
	
					})
				}
			})
    });

    var hash = location.hash.replace(/^#/, '');  // ^ means starting, meaning only match the first hash
    if (hash) {
        $('.tab-pane a[href="#' + hash + '"]').tab('show');
    } 

    // Change hash for page-reload
    $('.tab-pane a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
    });


    $(document).ready(function () {

        if (window.location.href.indexOf("wa") > -1) {
            sessionStorage.setItem("setting_section", "whatsapp_setting");
            window.location.href = '{{ $setting_url }}';
        }

        /* Select tab */
        if(sessionStorage.getItem("setting_section")){
            var tab_id = sessionStorage.getItem("setting_section");
            $(".setting-section").removeClass("active");
            $(".setting-section").removeClass("show");

            $(".setting-section-tab").removeClass("active");
            $(".setting-section-tab").removeClass("show");

            $("#"+tab_id).addClass("active");
            $("#"+tab_id).addClass("show");

            $("#"+tab_id+"_tab").addClass("active");
            $("#"+tab_id+"_tab").addClass("show");
        }else{
            $("#business_details").addClass("active");
            $("#business_details").addClass("show");

            $("#business_details_tab").addClass("active");
            $("#business_details_tab").addClass("show");
        }

        let tabParams = new URLSearchParams(window.location.search)
        if(tabParams != '' && $(window).width() < 1023){
            setTimeout(() => {
                $('html, body').animate({
                    scrollTop: $('#settings_tab_content').offset().top
                }, 'slow');
            }, 600);
        }


    });

    $(document).ready(function () {

        $('input[name="chkNumber"]').click(function () {
            
            if ($(this).is(':checked')) {
                var number = $('#wa_number').text();
                if(number == ''){
                    Sweet('error','Scan QR to use Whatsapp number as Calling number!');
                    return false;
                }
                number = number.slice(2);

                $(this).prop('checked', true); // Checks it
                
                $('#call_number').val(number);
                $('#call_number').prop("disabled",true);
            }else{
                $(this).prop('checked', false); // Unchecks it
                $('#call_number').val('');
                $('#call_number').prop("disabled",false);
            }

        });
        // console.log(window.location.href.indexOf("wa"));
    });

    $(document).ready(function() {
        
        $("#removeLogo").click(function() {
            swal.fire({
                title: 'Are you sure?',
                text: 'Once deleted, you will not be able to recover this logo file!',
                type: 'question',
                icon: 'warning',
                animation: true,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes Delete',
                cancelButtonText: 'Cancel',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: true,
                focusConfirm: true
            })
            .then(function(data){
                /*console.log(data.value);*/
                if (data.value == true) {
                    $("#overlay").fadeIn(300);
                    
                    $.ajax({
                        type: 'POST',
                        url: "{{route('business.deleteLogo')}}",
                        data:  {"_token": "{{ csrf_token() }}"},
                        dataType: 'JSON',
                        success: function (res) {

                            $("#overlay").fadeOut(300);
                            
                            if(res.status == true){
                                Swal.fire(
                                  'Deleted!',
                                  res.message,
                                  'success'
                                )
                                
                                //$('.logo-wrap').empty();
                                $("input.img-preview-oi").val('');
                                $('.remove-business-logo').hide();
                                $("#preview_oi").removeAttr("src");
                                $("#cropImage").removeAttr("src");
                                $("#preview_oi").attr("alt",'');
                                $("#preview_oi").css("display",'none');
                                $("#imagestring").val("");
                                $('.sidebar-logo-round').remove();

                            }else{
                                Swal.fire(
                                  'Deleted!',
                                  res.message,
                                  'success'
                                )
                                $("#preview_oi").css("display",'none');
                                $('.sidebar-logo-round').remove();
                            }
                        }
                    });
                        
                } else {
                    Sweet('success','Your logo file is safe!');
                }
            });
        });
    });

    function changePageType(){
        var form = $('input[name="vw_page"]:checked').data('form');
        $('.page-form').hide();
        $(form).show();
        if(form === '#w-page-form'){
            $(form).find('input').focus();
        }
    }
    $(document).ready(function(){
        changePageType(); /* Exicute on page load */

        $('input[name="vw_page"]').on('change', function(){
            changePageType(); /* exicute on change of selection */
        })
    });

    /* when clicked cancel to image select or popup */
    function cancel_logo_selection(input){
        var img_pre = $('#preview_oi');
        var image = img_pre.attr('alt');
        img_pre.attr('src', image);
    }
    /* when select and crop clicked from cropperjs popup */
    function logo_preview(image) {
        $('.remove-business-logo').show();
        $("#preview_oi").attr("src", image);
        $("#preview_oi").css("display", "block");
        $("#imagestring").val(image);
    }

    $(document).ready(function() {
        // popover
        $('[data-toggle="popover"]').popover({
            container: 'body'
        });
    });

    function paidtofree(){
        Swal.fire({
                title: '<strong>Please recharge</strong>',
                icon: 'info',
                html:
                    '<strong>Note:</strong> If click on <strong>"Convert To Free"</strong> button your running <strong>Offer</strong> and <strong>Subscriptions</strong> will be marked as <strong>Expired</strong>.',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText:
                    'Convert To Free',
                confirmButtonAriaLabel: 'Convert To Free',
                cancelButtonText:
                    'Recharge Now',
                cancelButtonAriaLabel: 'Recharge Now',
                cancelButtonColor: '#31ce55',
                cancelTextColor: '#ffffff',
            }).then((result) => {
                // console.log(result);
                if(result.value){
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    var data = {
                        "_token" : CSRF_TOKEN
                    };
                    $.ajax({
                        url : "{{ route('business.convertPaidToFree') }}",
                        type : 'get',
                        data : data,
                        dataType : "json",
                        success : function(res) {
                            if(res.status == true){
                                Swal.fire({
                                    title: 'Your account successfully converted to FREE account.',
                                    showClass: {
                                        popup: 'animate__animated animate__fadeInDown'
                                    },
                                    hideClass: {
                                        popup: 'animate__animated animate__fadeOutUp'
                                    }
                                }).then((result) => {
                                    console.log(result);
                                    if(result.value){
                                        location.reload();
                                    }
                                });
                            }
                        }
                    });
                }else{
                    window.location.href = '{{ route('pricing') }}';
                }
            });
    }
</script>