<script>
    /* Create Page */
    $(document).ready(function() {
        $("#pageform").on('submit', function(e){
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
                            window.location.href = '{{ route('seo.frontendsearch.index') }}';
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


        $("#pageEditform").on('submit', function(e){
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
                            window.location.href = '{{ route('seo.frontendsearch.index') }}';
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