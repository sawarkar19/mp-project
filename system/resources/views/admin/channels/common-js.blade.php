<script>
  /* message route toggle function */
  $(document).on("change", ".message-route-toggle", function(){
  
    var parentId, checkbox, value;
    parentId = $(this).attr('id');
    checkbox = $(this).find('input[type="checkbox"]');

    @php
          if(Auth::user()->is_sales_person == 1 && Auth::user()->is_sales_admin == 0 && Auth::user()->is_demo == 0){
      @endphp
          var checkbox = $('#'+parentId+' .custom-switch-input');
          if(checkbox.is(':checked')) { 
              $('#'+parentId+' .custom-switch-input').prop('checked', false);
          }else{ 
              $('#'+parentId+' .custom-switch-input').prop('checked', true);
          }

          Sweet('error', "You are not authorised to perform this action.");
          return false;
      @php
          }
      @endphp

    const routeArr = parentId.split("_");
    var wa_instance = '{{ isset($planData['wa_session']->instance_id) ? $planData['wa_session']->instance_id : "" }}';
    
    if(routeArr[0] == 'wa' && wa_instance == ''){
      $('#' + parentId).find('input[type="checkbox"]').prop('checked', false);
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
      //     $('#' + parentId).find('input[type="checkbox"]').prop('checked', true);
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
          // console.log(record);
          if(record.status == true){
            // if(record.messager == true ){
            //   $('#' + record.channel).find('input[type="checkbox"]').prop('checked', true);
            // }
            Sweet('success', record.message);
            return true;
          }else{            
            $('#' + parentId).find('input[type="checkbox"]').prop('checked', false);        
            Sweet('error', record.message);
            return false;
          }
        },
        complete:function(){
          $("#overlay").fadeOut(300);
        }
      });
    }
  });
</script>