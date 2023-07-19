<!DOCTYPE html>
<html>
<head>
    <title>Laravel Crop Image Before Upload</title>
    <meta name="_token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha256-WqU1JavFxSAMcLP2WIOI+GB2zWmShMI82mTpLDcqFUg=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" crossorigin="anonymous">
</head>
<style type="text/css">
img {
  display: block;
  max-width: 100%;
}
.preview {
  overflow: hidden;
  width: 160px; 
  height: 160px;
  margin: 10px;
  border: 1px solid red;
}
.modal-lg{
  max-width: 1000px !important;
}
.ratio-btn{
  margin-bottom: 0px !important;
}
</style>
<body>
<div class="container">
    <h1>Laravel Crop Image Before Upload</h1>
    <input type="file" name="image" class="image">
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Crop Image Before Upload</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                <div class="col-md-8">
                    <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                </div>
                <div class="col-md-4">
                    <div class="preview"></div>
                </div>
            </div>
        </div>
      </div>
        <div class="modal-footer">

            <div class="btn-group">
                <button type="button" class="btn btn-primary zoom-in" data-method="zoom" data-option="0.1" title="Zoom In">
                  <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                    <span class="fa fa-search-plus"></span>
                  </span>
                </button>
                <button type="button" class="btn btn-primary zoom-out" data-method="zoom" data-option="-0.1" title="Zoom Out">
                  <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                    <span class="fa fa-search-minus"></span>
                  </span>
                </button>
            </div>

            <div class="btn-group d-flex flex-nowrap" data-toggle="buttons">
                <label class="btn btn-primary ratio-btn" input-ele="aspectRatio1">
                  <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.7777777777777777">
                  <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                    16:9
                  </span>
                </label>
                <label class="btn btn-primary ratio-btn" input-ele="aspectRatio2">
                  <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1.3333333333333333">
                  <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                    4:3
                  </span>
                </label>
                <label class="btn btn-primary ratio-btn" input-ele="aspectRatio3">
                  <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="1">
                  <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                    1:1
                  </span>
                </label>
                <label class="btn btn-primary ratio-btn" input-ele="aspectRatio4">
                  <input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="0.6666666666666666">
                  <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                    2:3
                  </span>
                </label>
                <label class="btn btn-primary ratio-btn active" input-ele="aspectRatio5">
                  <input type="radio" class="sr-only" id="aspectRatio5" name="aspectRatio" value="NaN">
                  <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                    Free
                  </span>
                </label>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary ratate-anticlockwise" data-method="rotate" data-option="-45" title="Rotate Left">
                  <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                    <span class="fa fa-undo-alt"></span>
                  </span>
                </button>
                <button type="button" class="btn btn-primary ratate-clockwise" data-method="rotate" data-option="45" title="Rotate Right">
                  <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                    <span class="fa fa-redo-alt"></span>
                  </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary flip-horizontal" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                  <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                    <span class="fa fa-arrows-alt-h"></span>
                  </span>
                </button>
                <button type="button" class="btn btn-primary flip-verticle" data-method="scaleY" data-option="-1" title="Flip Vertical">
                  <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="">
                    <span class="fa fa-arrows-alt-v"></span>
                  </span>
                </button>
            </div>

            <div class="btn-group mb-2 ml-2">
              <button type="button" class="btn btn-primary" id="cropReset">Reset</button>
              {{-- <button type="button" class="btn btn-primary" id="cropDestroy">Destroy</button> --}}
              
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>

            <div class="mb-2 ml-2">
                <button type="button" class="btn btn-success" id="crop">Crop</button>
            </div>

        </div>
    </div>
  </div>
</div>

</div>
</div>
<script>

var $modal = $('#modal');
var image = document.getElementById('image');
var cropper;
  
$("body").on("change", ".image", function(e){
    var files = e.target.files;
    var done = function (url) {
      image.src = url;
      $modal.modal('show');
    };
    var reader;
    var file;
    var url;

    if (files && files.length > 0) {
      file = files[0];

      if (URL) {
        done(URL.createObjectURL(file));
      } else if (FileReader) {
        reader = new FileReader();
        reader.onload = function (e) {
          done(reader.result);
        };
        reader.readAsDataURL(file);
      }
    }
});

$modal.on('shown.bs.modal', function () {
    cropper = new Cropper(image, {
	  aspectRatio: NaN,
	  viewMode: 3,
	  preview: '.preview'
    });
}).on('hidden.bs.modal', function () {
   cropper.destroy();
   cropper = null;
});

$("#crop").click(function(){
    canvas = cropper.getCroppedCanvas({
	    width: 1500,
	    height: 1500,
    });

    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
         reader.readAsDataURL(blob); 


         
         reader.onloadend = function() {
            //var base64data = reader.result;	
            var fullQuality = canvas.toDataURL('image/jpeg', 1.0);

            var url = '{{ route("business.imageCropperUpload") }}';
        
            $.ajax({
                type: "POST",
                dataType: "json",
                url: url,
                data: {'_token': $('meta[name="_token"]').attr('content'), 'image': fullQuality},
                success: function(data){
                    $modal.modal('hide');
                    alert("success upload image");
                }
              });
         }
    });
})

//Change AspectRatio
$(".ratio-btn").click(function(){
    var input = $(this).attr('input-ele');
    var ratio = $('#'+input).val();
    changeRatio(ratio);
})

function changeRatio(ratio) {
    cropper.setAspectRatio(Number(ratio))
}

//Rotate Image
$(".ratate-anticlockwise").click(function(){
    cropper.rotate(-45)
})

$(".ratate-clockwise").click(function(){
    cropper.rotate(45)
})

//Flip image
$(".flip-horizontal").click(function(){
    var attr = $(this).attr('data-option');
    cropper.scaleX(attr)

    if(attr == 1){
      $(this).attr('data-option', -1);
    }else{
      $(this).attr('data-option', 1);
    }
})

$(".flip-verticle").click(function(){
    var attr = $(this).attr('data-option');
    cropper.scaleY(attr)

    if(attr == 1){
      $(this).attr('data-option', -1);
    }else{
      $(this).attr('data-option', 1);
    }
})

//Zoom
$(".zoom-in").click(function(){
    cropper.zoom(0.1)
})

$(".zoom-out").click(function(){
    cropper.zoom(-0.1)
})

//Reset
$("#cropReset").click(function(){
    cropper.reset()
})

//destroy
/* $("#cropDestroy").click(function(){
    cropper.destroy()
}) */


</script>
</body>
</html> 