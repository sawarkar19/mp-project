
<script type="text/javascript">
    

//     function viewModal(){
      
// //    alert("viewModal");
//              $.ajax({
//                 url : '{{ route('admin.festival.getTemplates') }}',
//                 'type': 'GET',
//                 'data': function (d) {
//                     d._token = "{{ csrf_token() }}";
                    
//                 },
//                 success: function(response) {
//                     console.log(response.records.message)
                   
//                         $("#festivalMessages").modal('show'); /* modal open */
                        
//                     }
              
//             }); 
    
     
//     }
   



 function viewModal(message_template_category_id){
        var isChannelActive = {{ $isChannelActive['status'] }}

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // var modalId = ''; 
        var message = '';
        // var modalId = 'festivalMessages';




        var modalId = ''; 
    
        if (message_template_category_id == null) {
            
                modalId = 'festivalMessages';
            }



           
            var inputVal = {
                "_token" : CSRF_TOKEN
            };
   
            $.ajax({
                url : '{{ route('admin.festival.getTemplates') }}',
                type : 'get',
                dataType : "json",
                data : inputVal,
                success : function(res) {
                    
                    // console.log("return");
                    // console.log(res);
                    if(res.status == true){
                        // alert("hii");
                        $('.'+modalId+' .grid-item').remove();
                    
                        var instance = new Colcade('.'+modalId, {
                            columns: '.grid-col',
                            items: '.grid-item'
                        });

                        instance.destroy();
                        var data_col = "";

                        $.each(res.records, function(i, elm) {
                            var name = elm.category.name;
                            message = nl2br(elm.message);

                            // message = message.replaceAll('{#var#}');
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
    
        
    } 

    $("#festivalForm").on('submit', function(e) {
        
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
            processData: false,
           

            success: function(response) {
             console.log(response);
            },
          
        })
    });

  

</script>