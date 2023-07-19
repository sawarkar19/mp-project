@extends('layouts.business')

@section('title', 'Create Social Post: Business Panel')

@section('head')
    @include('layouts.partials.headersection', ['title'=>'Create New Post'])
@endsection

@section('content')
<section class="section">

    <div class="row">
        <div class="col-md-8 col-xl-6">

            <div class="card">
                <div class="card-header">
                  <h4>Enter Post Details Below</h4>
                </div>
                <div class="card-body">
                    <form action="#" method="post" id="post_form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-0">
                            <label class="form-label mb-0">Post Image <span class="text-danger">*</span></label>
                            <div class="small mb-2">Please select <span class="text-danger">PNG</span>, <span class="text-danger">JPG</span> or <span class="text-danger">JPEG</span> image with maximum 2MB file size.</div>
                            <div class="d-flex">
                                <div class="mr-3">
                                    <input type="file" name="post_image" class="form-control img-preview-oi mb-2" title="Select The Post Image" required>
                                    <i class="small"><span class="text-danger">Note:-</span> For best view of the image on social media, use the image size <strong>1200px X 630px</strong>.</i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group my-1">
                            <div class="d-flex">
                                <div class="logo-priview">
                                    <div class="logo-wrap">
                                        <img id="preview_oi" src="" class="img-fluid logo_path">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Post Title <span class="text-danger">*</span> </label>
                            <input type="text" name="post_title" id="post_title" class="form-control" title="Post Title" required>
                        </div>
                        <div class="form-group">
                            <label>Post Description</label>
                            <textarea name="post_description" id="post_description" class="form-control" rows="4" title="Post Description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Select Status</label>
                            <select name="status" class="form-control" id="status" required>
                                <option value="1">Active</option>
                                <option value="0">Draft</option>
                            </select>
                        </div>
                        
                        <div>
                            <button type="submit" class="btn btn-primary px-3" id="post_btn">Create Post</button>
                        </div>
                        <div class="mt-3">
                            <div class="success text-success"></div>
                            <div class="error text-danger"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</section>
@endsection

@section('end_body')

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
        });
    });
</script>

<script type="text/javascript">
        
    $(document).ready(function(){
        $('#post_form').on("submit", function(event){
            event.preventDefault();
            var $formdata = new FormData(this);
            var btn = $('#post_btn');
            $.ajax({
                url : "{{route('business.socialPostsStore')}}",
                type : 'POST',
                data : $formdata,
                processData: false,
                contentType: false,
                dataType : "json",
                beforeSend: function() {
                
                    btn.attr('disabled','');
                    btn.html('Please Wait....');

                },
                success : function(response) {
                    btn.removeAttr('disabled','');
                    btn.html('Create Post');
                    if(response.success == true){
                        Sweet('success', response.message);  
                        $('#post_form').trigger('reset');
                        $("#preview_oi").removeAttr("src");
                    }else{
                        Sweet('error',response.message);
                    }
                },
                error: function(xhr, status, error){
                    $.each(xhr.responseJSON.errors, function (key, item){
                        Sweet('error',item);
                    });
                }
            });
        })
    });

    $("input[name='post_image']").on("change", function(){
        if(this.files[0].size > 2097152){
            $(this).val('');
            Sweet('error','Image size must be smaller than 2MB or equal.');
            return false;
        }

        var file = $(this).get(0).files[0];
        if(file){
            var file_type = file.type;
            var file_name = file.name;
            var fileExt = file_name.split('.').pop();
            var ext = fileExt.toLowerCase();
            
            if(ext != 'jpeg' && ext != 'png' && ext != 'jpg'){
                $(this).val('');
                Sweet('error','Image format is not supported. Please Upload jpg, jpeg or png image.');
                return false;
            }
            
        }
    });

</script>

@endsection