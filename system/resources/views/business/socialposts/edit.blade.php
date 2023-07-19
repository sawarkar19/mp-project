@extends('layouts.business')

@section('title', 'Edit Social Post: Business Panel')

@section('head')
    @include('layouts.partials.headersection', ['title' => 'Edit Post'])
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
                        <div class="form-group">
                            <label class="form-label mb-0">Post Image</label>
                            <div class="d-flex">
                                <div style="width:70%;" class="mr-3">
                                    <div class="small mb-2">Please select <span class="text-danger">PNG</span>, <span class="text-danger">JPG</span> or <span class="text-danger">JPEG</span> image with maximum 2MB file size.</div>
                                    <input type="file" name="post_image" class="form-control img-preview-oi" title="Select The Post Image">
                                    <i class="small"><span class="text-danger">Note:-</span> For best view of the image on social media, use the image size <strong>1200px X 630px</strong>.</i>
                                </div>
                                <div style="width:30%;" class="logo-priview">
                                    <div class="logo-wrap">
                                        <img id="preview_oi" src="{{ asset('assets/socialposts/'.$post->image) }}" class="img-fluid logo_path">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Post Title <span class="text-danger">*</span> </label>
                            <input type="text" name="post_title" class="form-control" value="{{$post->title}}" title="Post Title" required>
                        </div>
                        <div class="form-group">
                            <label>Post Description</label>
                            <textarea name="post_description" class="form-control" rows="4" title="Post Description">{{$post->description}}</textarea>
                        </div>
                        @if($post->status == 0)
                        <div class="form-group">
                            <label for="password_confirmation">Select Status</label>
                            <select name="status" class="form-control" id="status" required>
                                <option value="1" @if($post->status == 1) selected @endif>Active</option>
                                <option value="0" @if($post->status != 1) selected @endif>Draft</option>
                            </select>
                        </div>
                        @endif
                        <div>
                            <button type="submit" class="btn btn-primary px-3">Update</button>
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
                var reader = new FileReader();
                reader.onload = function(e){

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
            $.ajax({
                url : "{{route('business.socialPostsUpdate', $post->id)}}",
                type : 'POST',
                data : $formdata,
                processData: false,
                contentType: false,
                dataType : "json",
                success : function(response) {
                    if(response.success == true){
                        Sweet('success', response.message);  
                        /*$('#post_form').trigger('reset');*/
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