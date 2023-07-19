<script type="text/javascript">
    
    function editModal(offer_id){
        if(offer_id!='0'){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var modalId = 'shareOfferMessage';
            var inputVal = {
                   "offer_id" : offer_id,
                    "_token" : CSRF_TOKEN
                };
            $.ajax({
                url:'{{ route('business.channel.personalisedMessage.getOfferDetails')}}',
                type:'POST',
                dataType : "json",
                    data : inputVal,
                    success : function(res) {
                        if(res.status == true){
                            var d = new Date();
                            var hours=d.getHours();
                            if(hours<10){
                              var hourss='0'+d.getHours();
                            }else{
                                var hourss=d.getHours();
                            }
                            var minutes=d.getMinutes();
                            if(minutes<10){
                              var minutess='0'+d.getMinutes();
                            }else{
                                var minutess=d.getMinutes();
                            }
                            var seconds=d.getSeconds();
                            var scheduletime=parseInt('100000');
                            var current_time=parseInt(hourss+""+minutess+""+seconds);
                            
                            if(scheduletime>current_time){
                                var min = new Date();
                            }else{
                                var min = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
                            }
                            $("#start_date").datepicker({
                                dateFormat: "dd-mm-yy",
                                changeMonth: true,
                                changeYear: true,
                                minDate: min,
                                maxDate: new Date(res.offerDeatils['end_date'])
                            });
                            $('#'+modalId).modal('toggle');
                        }else{
                            Sweet('error','Something went wrong');
                        }
                    }
            });
        }else{
            Swal.fire({
                        title: 'No current offer found!',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
            return false;
        }
        
    }

    function viewModal(message_template_category_id){
        
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var modalId = ''; 
        var message = '';
        if (message_template_category_id != null) {
            if(message_template_category_id == '7'){
                modalId ='birthdayTemplate';
            }else if(message_template_category_id == '8'){
                modalId ='anniversaryTemplate';
            }else{
                modalId = 'personalisedMessages';
            }
    
            var inputVal = {
                "message_template_category_id" : message_template_category_id,
                "_token" : CSRF_TOKEN
            };
   
            $.ajax({
                url : '{{ route('business.channel.personalisedMessage.getTemplates') }}',
                type : 'POST',
                dataType : "json",
                data : inputVal,
                success : function(res) {
                    // console.log(res.records);
                    if(res.status == true){
                        
                        $('.'+modalId+' .grid-item').remove();
                    
                        var instance = new Colcade('.'+modalId, {
                            columns: '.grid-col',
                            items: '.grid-item'
                        });

                        instance.destroy();
                        var data_col = "";
                        var busniess_name = '{{ $busniess_name }}';

                        $.each(res.records, function(i, elm) {
                            var name = elm.category.name;
                            message = nl2br(elm.message);

                            message = message.replaceAll('{#var#}', busniess_name);
                            // console.log(message);

                            data_col = '<div class="options card-msg-option chooseTemplate" data-templatecategory_id="'+elm.message_template_category_id+'" data-template_id="'+elm.id+'"  ><input type="radio" name="bdaytemp"  id="temp_'+elm.id+'" value="'+elm.id+'" class="radio_button"><label class="radio_label mb-2 d-block" for=temp_'+elm.id+'"><div class="card"><div class="card_style"><h6 class="card-message-hedding">'+name+'</h6><p class="mb-0 card-message-selection">“'+message+'”</p></div></div></label></div>';

                            instance.append([
                                makeItem(data_col, 'message_template_category_'+elm.message_template_category_id)
                            ]);
                        });

                        $('#temp_'+res.schedule.template_id).prop("checked", true);  
                        $('#'+modalId).modal('toggle');
                        
                    }
                }
            });
    
        } else {
            alert('error');
        }
    }

    function shareOffer(){
        var is_paid = '{{ auth()->user()->current_account_status }}';
            if(is_paid == 'free'){
                modalId ='shareOfferMessage';
                Sweet('error',"{{ Config::get('constants.payment_alert')}}");
                return false;
            }
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var groups_id = $('#myGroupsContacts').val();
        var start_date = $('#start_date').val();
        
                if(start_date == undefined || start_date == ''){
                   Swal.fire({
                        title: 'Please select date!',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                    return false; 
                }else if(groups_id == undefined || groups_id == ''){
                    Swal.fire({
                        title: 'Please select contact groups!',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                    return false;
                }

            var inputVal = {
                "groups_id" : groups_id,
                "start_date" : start_date,
                "_token" : CSRF_TOKEN
            };
            $.ajax({
                url : '{{ route('business.channel.personalisedMessage.shareOffer') }}',
                    type : 'POST',
                    dataType : "json",
                    data : inputVal,
                    success : function(res) {
                        if(res.status == true){
                            Sweet('success',res.message);
                            setInterval(() => {
                                window.location.href = "{{ URL::to('business/channel/5/personalised-messages') }}";
                            }, 1500);
                        }else{
                          Sweet('error',res.message);  
                        }
                    }
            });
    }

    function setTemplate(message_template_category_id){

        var isChannelActive = {{ $isChannelActive['status'] }}
        var is_paid = '{{ auth()->user()->current_account_status }}';
        if(isChannelActive == 0){
            var msg = "{{Config::get('constants.personalised_messaging_status')}}"
            Sweet("error", msg);
            return false;
        }
        
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var channel_id, id, modalId, cardId, temp_id, date, time, groups, message;
        channel_id = $('#channel_id').val();

        temp_id = $('#template_id').val();
        
        if(message_template_category_id == 7 && temp_id == ''){
            temp_id = '{{ @$dobTemp->template_id }}';
        }
        else if(message_template_category_id == 8 && temp_id == ''){
            temp_id = '{{ @$anniTemp->template_id }}';
        }

        if(message_template_category_id==1){
            if(is_paid=='free'){
                Sweet('error',"{{ Config::get('constants.payment_alert')}}");
                return false;
            }else{
                message_template_category_id = $("#checkTemplateCategory").val();
                temp_id = $("#checkTemplateID").val();  
            }
                       
        }

        date = $('#personalisedDate').val();
        time = $('#personalisedTime').val();
        groups = $('#myGroups').val();
        
        if (message_template_category_id != null && temp_id != '') {

            if(message_template_category_id == 7){
                cardId ='dobCard';
                modalId ='birthdayTemplate';
                id = $('#dob_message_id').val();
            }else if(message_template_category_id == 8){
                cardId ='anniversaryCard';
                modalId ='anniversaryTemplate';
                id = $('#anni_message_id').val();
            }else{
                cardId = 'anniversaryCard';
                modalId = 'personalisedMessages';
                id = $('#other_message_id').val();

                if(date == undefined || date == ''){
                    
                    Swal.fire({
                        title: 'Please select date!',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                    return false;
                }
                else if(time == undefined || time == ''){
                    
                    Swal.fire({
                        title: 'Please select time!',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                    return false;
                }
                else if(groups == undefined || groups == ''){
                    
                    Swal.fire({
                        title: 'Please select groups!',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                    return false;
                }
            }
    
            var inputVal = {
                "id" : id,
                "message_template_category_id" : message_template_category_id,
                "channel_id" : channel_id,
                "temp_id" : temp_id,
                "date" : date,
                "time" : time,
                "groups" : groups,
                "_token" : CSRF_TOKEN
            };
    
            $.ajax({
                url : '{{ route('business.channel.personalisedMessage.setTemplate') }}',
                type : 'POST',
                dataType : "json",
                data : inputVal,
                success : function(res) {
                    console.log('setTemplate: ', res);
                    if(res.status == true){
                        if(message_template_category_id==7 || message_template_category_id==8){
                            message = nl2br(res.temp);

                            /* Inserting a new card after the existing card (After Anniversary Card). */
                            message = nl2br(res.temp);
                            if(message_template_category_id == 7){
                                $('#activeBirthdayMsg').html(message);
                            }
                            else if(message_template_category_id == 8){
                                $('#activeAnniMsg').html(message);
                            }
                            // else if(message_template_category_id != 8 && message_template_category_id != 7){
                            //     $('#activeFestiveMsg').html(message);
                            // }
                            
                            $('#'+modalId).modal('toggle');

                        }else{
                            if(res.created){
                                
                                var html = '<div class="col-xl-4 col-sm-6 mb-4 newPersonaliseMsg"><div class="message-box card pt-1" id="personaliseMsg'+res.id+'"><div class="card-body"><div class="mb-3"><h6 class="text-warning mb-0">'+res.title+'</h6></div><div class="mb-1"><p class="lh-1 mb-0">'+res.temp+'</p></div><div><p class="mb-0 font-weight-500" style="color: #7b848c;"><i class="far fa-calendar-check text-warning mr-1" data-toggle="tooltip" title="Scheduled On"></i> '+res.date+' | '+res.time+'</p></div></div><div class="card-footer"><div><button class="btn btn-icon btn-sm btn-outline-dark" onclick="editRow('+res.id+');return false;" data-toggle="tooltip" title="Edit Message"><i class="fas fa-pen"></i></button><button class="btn btn-icon btn-sm btn-outline-danger" onclick="cancelRow('+res.id+');return false;" data-toggle="tooltip" title="Cancel Message"><i class="fas fa-ban"></i></button></div></div></div></div>';
                                $(html).insertAfter('#anniversary_card');     

                                

                                $('#'+modalId).modal('toggle');
                            }
                            else{
                                
                                $('#personalisedTime').val("");
                                $('#'+modalId).modal('toggle');
                            }
                        }
                        
                        Sweet('success',res.message);
                        
                        setInterval(() => {
                            window.location.href = "{{ URL::to('business/channel/5/personalised-messages') }}";
                        }, 1500);
                    }
                    else{
                        Sweet('error',res.message);
                    }
                }
            });
    
        } else {
            Swal.fire({
                // title: 'Please select template message!',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                html:'<h2>Please select template message!</h2>',
                confirmButtonText: 'Ok'
            });
        }
    }



    function setTemplateFestival(message_template_category_id){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var isChannelActive = {{ $isChannelActive['status'] }}

        if(isChannelActive == 0){
            var msg = "{{Config::get('constants.personalised_messaging_status')}}"
            Sweet("error", msg);
            return false;
        }
        var channel_id, id, modalId, cardId, temp_id, date, time, groups, message;
        channel_id = $('#channel_id').val();

        temp_id = $('#template_id_fest').val();
                

        if(message_template_category_id==2){
            message_template_category_id = $("#checkFestTemplateCategory").val();
            temp_id = $("#checkFestTemplateID").val();            
        }

        date = $('#festivalDate').val();
        time = $('#festivalTime').val();
        groups = $('#myGroupsFest').val();

        if (message_template_category_id != null && temp_id != '') {

            if(message_template_category_id != 7 && message_template_category_id != 8){
                cardId ='festivalCard';
                modalId ='festivalMessages';
                id = $('#fest_message_id').val();
                // id_fest = $('#fest_message_id').val();
            }else{
                cardId = 'anniversaryCard';
                modalId = 'festivalMessages';
                id = $('#other_message_id').val();
                // id_fest = $('#fest_message_id').val();

                if(date == undefined || date == ''){
                    
                    Swal.fire({
                        title: 'Please select date!',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                    return false;
                }
                else if(time == undefined || time == ''){
                   
                    Swal.fire({
                        title: 'Please select time!',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                    return false;
                }
                else if(groups == undefined || groups == ''){
                    
                    Swal.fire({
                        title: 'Please select groups!',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                    return false;
                }
            }
    
            var inputVal = {
                "id" : id,
                // "id_fest" : id_fest,
                "message_template_category_id" : message_template_category_id,
                "channel_id" : channel_id,
                "temp_id" : temp_id,
                "date" : date,
                "time" : time,
                "groups" : groups,
                "_token" : CSRF_TOKEN
            };
    
            $.ajax({
                url : '{{ route('business.channel.personalisedMessage.setTemplateFestival') }}',
                type : 'POST',
                dataType : "json",
                data : inputVal,
                success : function(res) {
                    console.log('setTemplate: ', res);
                    if(res.status == true){
                        if(message_template_category_id==7 || message_template_category_id==8){
                            message = nl2br(res.temp);

                            /* Inserting a new card after the existing card (After Anniversary Card). */
                            message = nl2br(res.temp);
                            if(message_template_category_id == 7){
                                $('#activeBirthdayMsg').html(message);
                            }
                            else if(message_template_category_id == 8){
                                $('#activeAnniMsg').html(message);
                            }
                            // else if(message_template_category_id != 8 && message_template_category_id != 7){
                            //     $('#activeFestiveMsg').html(message);
                            // }
                            
                            $('#'+modalId).modal('toggle');

                        }else{
                            if(res.created){
                                
                                // $(msg_card).insertAfter('#anniversary_card');
                                // newPersonaliseMsg
                                var html = '<div class="col-xl-4 col-sm-6 mb-4 newPersonaliseMsg"><div class="message-box card pt-1" id="personaliseMsg'+res.id+'"><div class="card-body"><div class="mb-3"><h6 class="text-warning mb-0">'+res.title+'</h6></div><div class="mb-1"><p class="lh-1 mb-0">'+res.temp+'</p></div><div><p class="mb-0 font-weight-500" style="color: #7b848c;"><i class="far fa-calendar-check text-warning mr-1" data-toggle="tooltip" title="Scheduled On"></i> '+res.date+' | '+res.time+'</p></div></div><div class="card-footer"><div><button class="btn btn-icon btn-sm btn-outline-dark" onclick="editRowFest('+res.id+');return false;" data-toggle="tooltip" title="Edit Message"><i class="fas fa-pen"></i></button><button class="btn btn-icon btn-sm btn-outline-danger" onclick="cancelRow('+res.id+');return false;" data-toggle="tooltip" title="Cancel Message"><i class="fas fa-ban"></i></button></div></div></div></div>';
                                $(html).insertAfter('#anniversary_card');     


                                $('#'+modalId).modal('toggle');
                            }
                            else{
                                $('#personalisedTime').val("");
                                $('#'+modalId).modal('toggle');
                            }
                        }
                        
                        Sweet('success',res.message);
                        
                        setInterval(() => {
                            window.location.href = "{{ URL::to('business/channel/5/personalised-messages') }}";
                        }, 1500);
                    }
                    else{
                        Sweet('error',res.message);
                    }
                }
            });
    
        } else {
            Swal.fire({
                // title: 'Please select template message!',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                html:'<h2>Please select template message!</h2>',
                confirmButtonText: 'Ok'
            });
        }
    }

    function addNewRow(type){

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var modalId, cardId, channel_id, temp_id, date, time, groups, message;
        channel_id = $('#channel_id').val();
        temp_id = $('#template_id').val();
        date = $('#personalisedDate').val();
        time = $('#personalisedTime').val();
        groups = $('#myGroups').val();
        if (type != null && temp_id != '') {

            if(type == '5'){
                cardId ='dobCard';
                modalId ='birthdayTemplate';
            }else if(type == '6'){
                cardId ='anniversaryCard';
                modalId ='anniversaryTemplate';
            }else{
                cardId = 'anniversaryCard';
                modalId = 'personalisedMessages';

                if(date == undefined || date == ''){
                    alert('Please select date.');
                }
                if(time == undefined || time == ''){
                    alert('Please select time.');
                }
                if(groups == undefined || groups == ''){
                    alert('Please select groups.');
                }
            }
    
            var inputVal = {
                "type" : type,
                "channel_id" : channel_id,
                "temp_id" : temp_id,
                "date" : date,
                "time" : time,
                "groups" : groups,
                "_token" : CSRF_TOKEN
            };
    
            $.ajax({
                url : '{{ route('business.channel.personalisedMessage.setTemplate') }}',
                type : 'POST',
                dataType : "json",
                data : inputVal,
                success : function(res) {
                    // console.log(res);
                    if(res.status == true){
                        message = nl2br(res.temp);
                        $('#'+cardId+' .card-message').empty();
                        $('#'+cardId+' .card-message').html(message);
                        $('#'+modalId).modal('toggle');
                    }
                }
            });
    
        } else {
            alert('Please select template message.');
        }
    }

    function editRow(id){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var modalId, cardId, channel_id, temp_id, date, time, groups, message;
        temp_id = $('#template_id').val();
        $('#personalisedDate').val('');
        $('#personalisedTime').val('');
        $('#myGroups').val('');
        $('#other_message_id').val(id);
        var inputVal = { "id" : id, "_token" : CSRF_TOKEN };
        $.ajax({
            url : '{{ route('business.channel.personalisedMessage.editTemplate') }}',
            type : 'POST',
            dataType : "json",
            data : inputVal,
            success : function(res) {
                // console.log('res: ', res.record.templates);
                if(res.status == true){
            

                    // Custom MSG
                    
                    modalId = "personalisedMessages";

                    console.log('templates: ', res.record);
                    $("#personalisedDate").val(res.record.date);
                    // $("#personalisedTime").val(res.record.time_slot_id).change();
                    $("#personalisedTime option[value='1']").attr("selected", true);
                    // $("#myGroups").select2('val', [res.record.groups]);   


                    $('.'+modalId+' .grid-item').remove();
                
                    var instance = new Colcade('.'+modalId,{
                        columns: '.grid-col',
                        items: '.grid-item'
                    });

                    instance.destroy();
                    var data_col = "";
                    var templates = res.record.templates;

                    var busniess_name = '{{ $busniess_name }}';
                    $.each(templates, function(i, elm) {
                        var name = elm.category.name;
                        message = nl2br(elm.message);
                        
                        var isChecked = "";
                        if(elm.id == res.record.template_id){
                            isChecked = "checked";
                            $("#checkTemplateCategory").val(elm.message_template_category_id);
                            $("#checkTemplateID").val(res.record.template_id);
                        }

                        message = message.replaceAll('{#var#}', busniess_name);
                        // console.log(message);

                        data_col = '<div class="options card-msg-option chooseTemplate" data-templatecategory_id="'+elm.message_template_category_id+'" data-template_id="'+elm.id+'"><input type="radio" '+isChecked+' name="bdaytemp"  id="temp_'+elm.id+'" value="'+elm.id+'" class="radio_button"><label class="radio_label mb-2 d-block" for=temp_'+elm.id+'"><div class="card"><div class="card_style"><h6 class="card-message-hedding">'+name+'</h6><p class="mb-0 card-message-selection">“'+message+'”</p></div></div></label></div>';

                        instance.append([
                            makeItem(data_col, 'message_template_category_'+res.record.message_template_category_id)
                        ]);
                    });
                    $('#temp_'+res.template_id).prop("checked", true);
                    $('#'+modalId).modal('toggle');
                }
            }
        });
    }

    function editRowFest(id){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var modalId, cardId, channel_id, temp_id, date, time, groups, message;
        temp_id = $('#template_id').val();
        $('#festivalDate').val('');
        $('#festivalTime').val('');
        $('#myGroupsFest').val('');
        $('#fest_message_id').val(id);
        var inputVal = { "id" : id, "_token" : CSRF_TOKEN };
        $.ajax({
            url : '{{ route('business.channel.personalisedMessage.editFestivalTemplate') }}',
            type : 'POST',
            dataType : "json",
            data : inputVal,
            success : function(res) {
                // console.log('res: ', res.record.templates);
                if(res.status == true){
                    

                    // Custom MSG
                    
                    modalId = "festivalMessages";

                    console.log('templates: ', res.record);
                    $("#festivalDate").val(res.record.date);
                    // $("#personalisedTime").val(res.record.time_slot_id).change();
                    $("#festivalTime option[value='1']").attr("selected", true);
                    // $("#myGroups").select2('val', [res.record.groups]);   


                    $('.'+modalId+' .grid-item').remove();
                
                    var instance = new Colcade('.'+modalId,{
                        columns: '.grid-col',
                        items: '.grid-item'
                    });

                    instance.destroy();
                    var data_col = "";
                    var templates = res.record.templates;

                    var busniess_name = '{{ $busniess_name }}';
                    $.each(templates, function(i, elm) {
                        var name = elm.category.name;
                        message = nl2br(elm.message);
                        
                        var isChecked = "";
                        if(elm.id == res.record.template_id){
                            isChecked = "checked";
                            $("#checkFestTemplateCategory").val(elm.message_template_category_id);
                            $("#checkFestTemplateID").val(res.record.template_id);
                        }

                        message = message.replaceAll('{#var#}', busniess_name);
                        // console.log(message);

                        data_col = '<div class="options card-msg-option chooseFestTemplate" data-templatecategory_id="'+elm.message_template_category_id+'" data-template_id="'+elm.id+'"><input type="radio" '+isChecked+' name="festtemp"  id="temp_'+elm.id+'" value="'+elm.id+'" class="radio_button"><label class="radio_label mb-2 d-block" for=temp_'+elm.id+'"><div class="card"><div class="card_style"><h6 class="card-message-hedding">'+name+'</h6><p class="mb-0 card-message-selection">“'+message+'”</p></div></div></label></div>';

                        instance.append([
                            makeItem(data_col, 'message_template_category_'+res.record.message_template_category_id)
                        ]);
                    });
                    $('#temp_'+res.template_id).prop("checked", true);
                    $('#'+modalId).modal('toggle');
                }
            }
        });
    }

    function cancelRow(id){

        Swal.fire({
			title: 'Are you sure?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, Do It!'
		}).then((result) => {
			if (result.value == true) {
				var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $('#other_message_id').val(id);
                var inputVal = { "id" : id, "_token" : CSRF_TOKEN };
                $.ajax({
                    url : '{{ route('business.channel.personalisedMessage.cancelTemplate') }}',
                    type : 'POST',
                    dataType : "json",
                    data : inputVal,
                    success : function(res) {
                        console.log('res: ', res);
                        if(res.status == true){
                            $('#personaliseMsg'+id).remove();
                        }
                    }
                });
			}
		});
    }

    function nl2br (str, is_xhtml) {   
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
    }

    $(document).ready(function(){
        $(document).on('click', '.card-msg-option', function(){
            $('#template_id').val('');
            var temp_id, input;
            input = $(this).parent().children().children('input');
            input.prop('checked', true);
            temp_id = input.attr('id').substr(5);
            $('#template_id').val(temp_id);
        });

        $('.modal').on('hidden.bs.modal', function () {
            $('#template_id').val('');
            $('#personalisedDate').val('');
            $('#personalisedTime').val('');
            $('#myGroups').val('');
            $('#other_message_id').val('');
        });
    });
    //function for search template
    function makeItem(htm_data, unq_class) {
        var item = document.createElement('div');
        item.classList.add('grid-item');
        item.classList.add(unq_class);
        item.classList.add('msg-search-sec');
        item.innerHTML = htm_data;
        return item;
    }
    function template_search(text, category) {

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        var inputVal = {
            "text" : text,
            "category" : category,
            "_token" : CSRF_TOKEN
        };

        $.ajax({
            url: '{{ route('business.channel.personalisedMessage.searchTemplates') }}',
            type : 'post',
            dataType : 'json',
            data : inputVal,
            beforeSend:function() {
                $('#st_loader').show();
                $('#st_grid').hide();

                colcade.destroy();

                $('#st_grid .grid-item').remove();
            },
            success:function(res) {

                if(res.status == true){

                    var modalId = "personalisedMessages";
                    $('.'+modalId+' .grid-item').remove();
                    var instance = new Colcade('.'+modalId,{
                        columns: '.grid-col',
                        items: '.grid-item'
                    });

                    instance.destroy();
                    var data_col = "";
                    var templates = res.records;

                    // console.log(templates);
                    var busniess_name = '{{ $busniess_name }}';
                    $.each(templates, function(i, elm) {
                        var name = elm.category.name;
                        message = nl2br(elm.message);
                        
                        var isChecked = "";
                        
                        message = message.replaceAll('{#var#}', busniess_name);

                        data_col = '<div class="options card-msg-option chooseTemplate" data-templatecategory_id="'+elm.category.id+'" data-template_id="'+elm.id+'"><input type="radio" '+isChecked+' name="bdaytemp"  id="temp_'+elm.id+'" value="'+elm.id+'" class="radio_button"><label class="radio_label mb-2 d-block" for=temp_'+elm.id+'"><div class="card"><div class="card_style"><h6 class="card-message-hedding">'+name+'</h6><p class="mb-0 card-message-selection">“'+message+'”</p></div></div></label></div>';

                        instance.append([
                            makeItem(data_col, 'message_template_category_'+elm.category.id)
                        ]);
                    });

                }
            },
            error:function(xhr, exeception) {
                alert('Something went wrong!');
            },
            complete:function() {
                $('#st_loader').hide();
                $('#st_grid').show();
            }
        });
    }

    function template_search_fest(text_fest , category_fest) {

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        var inputVal = {
            "text_fest" : text_fest,
            "category_fest" : category_fest,
            "_token" : CSRF_TOKEN
        };

        $.ajax({
            url: '{{ route('business.channel.personalisedMessage.searchTemplatesFest') }}',
            type : 'post',
            dataType : 'json',
            data : inputVal,
            beforeSend:function() {
                $('#st_loader').show();
                $('#st_grid').hide();

                colcade.destroy();

                $('#st_grid .grid-item').remove();
            },
            success:function(res) {

                if(res.status == true){

                    var modalId = "festivalMessages";
                    $('.'+modalId+' .grid-item').remove();
                    var instance = new Colcade('.'+modalId,{
                        columns: '.grid-col',
                        items: '.grid-item'
                    });

                    instance.destroy();
                    var data_col = "";
                    var templates = res.records;

                    // console.log(templates);
                    var busniess_name = '{{ $busniess_name }}';
                    $.each(templates, function(i, elm) {
                        var name = elm.category.name;
                        message = nl2br(elm.message);
                        
                        var isChecked = "";
                        
                        message = message.replaceAll('{#var#}', busniess_name);

                        data_col = '<div class="options card-msg-option chooseTemplate" data-templatecategory_id_fest="'+elm.category.id+'" data-template_id_fest="'+elm.id+'"><input type="radio" '+isChecked+' name="festivaltemp"  id="temp_'+elm.id+'" value="'+elm.id+'" class="radio_button"><label class="radio_label mb-2 d-block" for=temp_'+elm.id+'"><div class="card"><div class="card_style"><h6 class="card-message-hedding">'+name+'</h6><p class="mb-0 card-message-selection">“'+message+'”</p></div></div></label></div>';

                        instance.append([
                            makeItem(data_col, 'message_template_category_'+elm.category.id)
                        ]);
                    });

                }
            },
            error:function(xhr, exeception) {
                alert('Something went wrong!');
            },
            complete:function() {
                $('#st_loader').hide();
                $('#st_grid').show();
            }
        });
        }
    //filter selected templates
    $(document).ready(function(event){

        /*On Search text input*/
        $('#st_text_input').on('keyup', function(){
            /*get filter inputs value*/
            var text = $('#st_text_input').val();
            var category = $('#st_category_input').val();
            /*when text value lenght is greater than 2 or more, call the function*/
            // if (text.length > 2) {
                template_search(text, category);
            // }
        });
        /*when category select*/
        $('#st_category_input').on('change', function(){
            /*get filter inputs value*/
            var text = $('#st_text_input').val();
            var category = $('#st_category_input').val();

            template_search(text, category);
        });
          /*On Search text input for festival*/
          $('#st_text_input_fest').on('keyup', function(){
           
           /*get filter inputs value*/
           var text_fest = $('#st_text_input_fest').val();
           var category_fest = $('#st_category_input_fest').val();

           /*when text value lenght is greater than 2 or more, call the function*/
           // if (text.length > 2) {
               template_search_fest(text_fest, category_fest);
           // }
       });
         /*when category select*/
         $('#st_category_input_fest').on('change', function(){
            /*get filter inputs value*/
            var text_fest = $('#st_text_input_fest').val();
            var category_fest = $('#st_category_input_fest').val();

            template_search_fest(text_fest, category_fest);
        });

    });



    $(document).ready(function(){
        
        //current offer message enable/disable
        $(document).on('click',".setSelectedGroups",function(){
            var is_paid = '{{ auth()->user()->current_account_status }}';
            var is_checked = $(this).prop("checked");
            if(is_paid == 'free'){
                if(is_checked==true){
                    Sweet('error',"{{ Config::get('constants.payment_alert')}}");
                    return false;
                }   
            }
            
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var inputVal = {
               "is_checked" : is_checked,
                "_token" : CSRF_TOKEN
            };
            $.ajax({
                url : '{{ route('business.channel.personalisedMessage.shareOfferSendEnable') }}',
                type : 'POST',
                dataType : "json",
                data : inputVal,
                success:function(response){
                    if(response.status == true){
                        Sweet('success',response.message);
                    }else{
                        Sweet('error','Something went wrong');
                    }
                }
            });
        });
        // schedule Birthday MSG
        $(document).on("click", ".setIsSchedule", function(){

            var is_paid = '{{ auth()->user()->current_account_status }}';
            var is_checked = $(this).prop("checked");
            if(is_paid == 'free'){
                if(is_checked==true){
                    Sweet('error',"{{ Config::get('constants.payment_alert')}}");
                    return false;
                }   
            }

            var category_type_id = $(this).attr('data-scheduleType');
            /*var groups_id = $('#selectChoice').val();*/
            
            $.ajax({
                url: '{{ URL::to("business/channel/personalised-messages/scheduleMsg") }}',
                type:"POST",
                data:{
                    "is_checked": is_checked,
                    "category_type_id": category_type_id,
                    //"groups_id": groups_id,
                    "_token": "{{ csrf_token() }}"
                },
                success:function(response){
                    if(response.status == true){
                        Sweet('success',response.message);
                    }else{
                        if(response.message=='Low'){
                            return paidtofree();
                        }else{
                            Sweet('error',response.message);
                        }
                    }
                }
            })
        });


        $(document).on("click", ".chooseTemplate", function(){
            $("#checkTemplateCategory").val($(this).data("templatecategory_id"));
            $("#checkTemplateID").val($(this).data("template_id"));
        });
        $(document).on("click", ".chooseFestTemplate", function(){
            $("#checkFestTemplateCategory").val($(this).data("templatecategory_id_fest"));
            $("#checkFestTemplateID").val($(this).data("template_id_fest"));
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
            }).then((result) => {
                
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
                                    
                                    if(result.value){
                                        location.reload();
                                    }
                                });
                            }
                        }
                    });
                }else{
                    
                    if(result.dismiss=="cancel"){
                        window.location.href = '{{ route('pricing') }}';
                   }else{
                        window.location.href = '{{ route('business.dashboard') }}';
                   }
                }
            });
    }

</script>