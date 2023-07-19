<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/js/form.js?v=1.0') }}"></script>
<script>
	CKEDITOR.replace('description',{
		filebrowserUploadUrl: "{{route('admin.ckeditorblog.upload', ['_token' => csrf_token() ])}}",
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
                        window.location.href = response.url;
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
</script>


