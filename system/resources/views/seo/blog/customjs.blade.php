<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/js/form.js?v=1.0') }}"></script>
<script>
	CKEDITOR.replace('description',{
		filebrowserUploadUrl: "{{route('seo.ckeditorblog.upload', ['_token' => csrf_token() ])}}",
		filebrowserUploadMethod: 'form'
	});
</script>
<script>
    /* Create Future Offer */
    $(document).ready(function() {
        $("#blogform").on('submit', function(e){
            e.preventDefault();

            for (instance in CKEDITOR.instances) {
		        CKEDITOR.instances[instance].updateElement();
		    }

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
                        Sweet('success',response.message);
                        setTimeout(function(){
                            window.location.href = '{{ route('seo.blog.index') }}';
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

    $("#setting-form1").on('submit', function(e){
        e.preventDefault();

        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var basicbtnhtml=$('.basicbtn').html();
        $.ajax({
            type: 'POST',
            url: this.action,
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function() {

                $('.basicbtn').html("Please Wait....");
                $('.basicbtn').attr('disabled','')

            },
            
            success: function(response){ 
                //console.log(response);
                $('.basicbtn').removeAttr('disabled')
                if(response.type == 'success'){
                    Sweet('success',response.message);
                }else{
                    Sweet('error','Failed to update.');
                }
                $('.basicbtn').html(basicbtnhtml);
                //success(response);
            },
            error: function(xhr, status, error) 
            {
                $('.basicbtn').html(basicbtnhtml);
                $('.basicbtn').removeAttr('disabled')
                $('.errorarea').show();
                $.each(xhr.responseJSON.errors, function (key, item) 
                {
                    Sweet('error',item)
                    $("#errors").html("<li class='text-danger'>"+item+"</li>")
                });
                errosresponse(xhr, status, error);
            }
        })
    }); 

    $("#setting-form2").on('submit', function(e){
        e.preventDefault();

        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var basicbtnhtml=$('.basicbtn').html();
        $.ajax({
            type: 'POST',
            url: this.action,
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function() {

                $('.basicbtn').html("Please Wait....");
                $('.basicbtn').attr('disabled','')

            },
            
            success: function(response){ 
                $('.basicbtn').removeAttr('disabled')
                if(response.type == 'success'){
                    Sweet('success',response.message);
                }else{
                    Sweet('error','Failed to update.');
                }
                $('.basicbtn').html(basicbtnhtml);
                //success(response);
            },
            error: function(xhr, status, error) 
            {
                $('.basicbtn').html(basicbtnhtml);
                $('.basicbtn').removeAttr('disabled')
                $('.errorarea').show();
                $.each(xhr.responseJSON.errors, function (key, item) 
                {
                    Sweet('error',item)
                    $("#errors").html("<li class='text-danger'>"+item+"</li>")
                });
                errosresponse(xhr, status, error);
            }
        })
    });

    $("#setting-form3").on('submit', function(e){
        e.preventDefault();

        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var basicbtnhtml=$('.basicbtn').html();
        $.ajax({
            type: 'POST',
            url: this.action,
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function() {

                $('.basicbtn').html("Please Wait....");
                $('.basicbtn').attr('disabled','')

            },
            
            success: function(response){ 
                $('.basicbtn').removeAttr('disabled')
                if(response.type == 'success'){
                    Sweet('success',response.message);
                    setTimeout(function(){
                        window.location.href = '{{ route('seo.blog.index') }}';
                    },2000);
                }else{
                    Sweet('error','Failed to update.');
                }
                $('.basicbtn').html(basicbtnhtml);
                //success(response);
            },
            error: function(xhr, status, error) 
            {
                $('.basicbtn').html(basicbtnhtml);
                $('.basicbtn').removeAttr('disabled')
                $('.errorarea').show();
                $.each(xhr.responseJSON.errors, function (key, item) 
                {
                    Sweet('error',item)
                    $("#errors").html("<li class='text-danger'>"+item+"</li>")
                });
                errosresponse(xhr, status, error);
            }
        })
    });
</script>

<script>
	$(document).ready(function () {
        $("input.img-preview-oi").on("change", function() {
            var file = $(this).get(0).files[0];
            if(file){
                var file_name = file.name;
                var fileExt = file_name.split('.').pop();
                var ext = fileExt.toLowerCase();
                
                if(ext != 'jpeg' && ext != 'png' && ext != 'jpg'){
                    $("input.img-preview-oi").val('');
                    $('.remove-business-logo').hide();
                    $("#preview_oi").removeAttr("src");
                    $("#preview_oi").attr("alt",'');
                    
                    Sweet('error','Image format is not supported. Please Upload jpg, jpeg or png image.');
                    return;
                }
                    
                var reader = new FileReader();
                reader.onload = function(e){
                    /*$("#preview_oi").attr("src", reader.result);*/

                    var image = new Image();
                    image.src = e.target.result;
                        
                    //Validate the File Height and Width.
                    image.onload = function () {
                        var height = this.height;
                        var width = this.width;

                        if(width > 1000 || height > 1000){
                            $("input.img-preview-oi").val('');
                            $('.remove-business-logo').hide();
                            $("#preview_oi").removeAttr("src");
                            $("#preview_oi").attr("alt",'');

                            Sweet('error','Image Resolutions are too high.');
                            return false; 
                        }else{
                            $('.remove-business-logo').show();
                            $("#preview_oi").attr("src", reader.result);
                        }
                        /*console.log(width);*/
                    }
                }
                reader.readAsDataURL(file);
            }else{
                $("#preview_oi").removeAttr("src");
            }
        })
    });
</script>
<script type="text/javascript">  
 function add_tags(){
   var tag = $('#tag').val(); 
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
   if (tag != '') {      
		$.ajax({
			url : '{{ route('seo.blogs.add_tags') }}',
			type : 'POST',
			data : {tag: tag, _token: CSRF_TOKEN},
			dataType : "json",
			success : function(response) {	
				if(response.type == "success"){	
					$('#success').html(response.message);
					$('#error').html('');
					$('#tag').val('');

					if(response)
	                {
	                    $.each(response,function(key,value){
	                        $('#tag_listing').append($("<option/>", {
	                           value: value.id,
	                           text: value.tag
	                        }));
	                    });
	                }
				}
			}
		});
   }else{       
	   $('#error').html('Tag should not be empty!');
	   $('#success').html('');
   }
 }  
</script>