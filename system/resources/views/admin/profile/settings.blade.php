@extends('layouts.admin')
@section('title', 'Admin: Profile')
@section('head')
@include('layouts.partials.headersection',['title'=>'Profile Settings'])
@endsection
@section('content')

<?php  session_start(); ?>
<div class="card">
    <div class="card-body">
       <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger none">
              <ul id="errors">
              </ul>
          </div>
          <div class="alert alert-success none">
              <ul id="success">
              </ul>
          </div>
      </div>
      <div class="col-md-6">


        <form method="post" class="basicform" action="{{ route('admin.profile.update') }}">
            @csrf
            <h4 class="mb-20">{{ __('Genaral Settings') }}</h4>
            <div class="custom-form">
                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input type="text" name="name" id="name" class="form-control" required placeholder="Enter User's  Name" value="{{ Auth::user()->name }}"> 
                </div>
                <div class="form-group">
                    <label for="email">{{ __('Email') }}</label>
                    <input type="text" name="email" id="email" class="form-control" required placeholder="Enter Email"  value="{{ Auth::user()->email }}"> 
                </div>

                @if(Auth::user()->role_id == 4)

                <div class="form-group">
                    <label for="profile_pic">Profile Image</label>
                    <input type="file" name="profile_pic" class="form-control img-preview-oi" id="profile_pic">
                </div>

                @if(Auth::user()->profile_pic != null)
                <div class="col-4">
                    <img id="preview_oi" src="{{ URL::to('assets/blogs/authors/' . Auth::user()->profile_pic) }}" style="max-height:120px;" class="img-fluid" />
                </div><br>

                @else

                <div class="col-4">
                    <img id="preview_oi" src="" style="max-height:120px;" class="img-fluid" />
                </div><br>

                @endif


                <div class="form-group">
                    <label for="designation">{{ __('Designation') }}</label>
                    <input type="text" name="designation" id="designation" class="form-control char-spcs-validation" placeholder="Enter Designation" value="{{ Auth::user()->designation }}"> 
                </div>

                <div class="form-group">
                    <label for="bio">Bio (Description)</label>
                    <textarea name="bio" class="form-control " cols="30" rows="3" maxlength="500" placeholder="Bio (Description)" id="bio" maxlength="">{{ Auth::user()->bio }}</textarea>
                </div> 

                <div class="form-group">
                    <label for="linkedin_profile">{{ __('Linkedin Profile URL') }}</label>
                    <input type="url" name="linkedin_profile" id="linkedin_profile" class="form-control" placeholder="Enter Linkedin Profile URL" value="{{ Auth::user()->linkedin_profile }}"> 
                </div>

                <div class="form-group">
                    <label for="instagram_profile">{{ __('Instagram Profile URL') }}</label>
                    <input type="url" name="instagram_profile" id="instagram_profile" class="form-control" placeholder="Enter Instagram Profile URL" value="{{ Auth::user()->instagram_profile }}"> 
                </div> 

                <div class="form-group">
                    <label for="facebook_profile">{{ __('Facebook Profile URL') }}</label>
                    <input type="url" name="facebook_profile" id="facebook_profile" class="form-control" placeholder="Enter Facebook Profile URL" value="{{ Auth::user()->facebook_profile }}"> 
                </div>

                @endif
               
                <div class="form-group">
                    <button type="submit" class="btn btn-info basicbtn">{{ __('Update') }}</button>
                </div>
            </div>
        </form>

    </div>
    <div class="col-md-6">

        <form method="post" class="basicform" action="{{ route('admin.profile.update') }}">
            @csrf
            <h4 class="mb-20">{{ __('Change Password') }}</h4>
            <div class="custom-form">
                <div class="form-group">
                    <label for="oldpassword">{{ __('Old Password') }}</label>
                    <input type="password" name="password_current" id="oldpassword" class="form-control"  placeholder="Enter Old Password" required> 
                </div>
                <div class="form-group">
                    <label for="password">{{ __('New Password') }}</label>
                    <input type="password" name="password" id="password" class="form-control"  placeholder="Enter New Password" required> 
                </div>
                <div class="form-group">
                    <label for="password1">{{ __('Enter Again Password') }}</label>
                    <input type="password" name="password_confirmation" id="password1" class="form-control"  placeholder="Enter Again" required> 
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary basicbtn">{{ __('Change') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
@section('end_body')
<style>
  .success { color:green; }
  .error { color:green; }
</style>

<script src="{{ asset('assets/js/form.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/input-validation.js') }}"></script>
<script>

	$('.basicbtn').click(function(){

		var oldpassword =  $("#oldpassword").val();
		var password =  $("#password").val();
		var password1 =  $("#password1").val();

		if ( oldpassword != '' || password != '' || password1 != '' ) {
			setTimeout(function () {
				$("#oldpassword").val('');
				$("#password").val('');
				$("#password1").val('');
				$(".basicbtn").html('Change');
			}, 4000);

		}	
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
<script>
    $("input[name='profile_pic']").on("change", function(){
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
                Sweet('error',var file_name = file.name;
            var fileExt = file_name.split('.').pop();
            var ext = fileExt.toLowerCase();
            
            if(ext != 'jpeg' && ext != 'png' && ext != 'jpg'){'Image format is not supported. Please Upload jpg, jpeg or png image.');
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


    $("input[name='linkedin_profile']").on("blur", function(){
        var content = $(this).val();

        if(content.length > 0 && content.indexOf('linkedin.com') == -1){
            Sweet('error','Please enter valid Linkedin link or Keep it empty.');
            $( "#submitForm" ).prop('disabled', true);
            $(this).focus();
        }else{
            $( "#submitForm" ).prop('disabled',false);
        }
    });

    $("input[name='instagram_profile']").on("blur", function(){
        var content = $(this).val();

        if(content.length > 0 && content.indexOf('instagram.com') == -1){
            Sweet('error','Please enter valid Instagram link or Keep it empty.');
            $( "#submitForm" ).prop('disabled', true);
            $(this).focus();
        }else{
            $( "#submitForm" ).prop('disabled',false);
        }
    });


    $("input[name='facebook_profile']").on("blur", function(){
        var content = $(this).val();

        if(content.length > 0 && content.indexOf('facebook.com') == -1){
            Sweet('error','Please enter valid Facebook link or Keep it empty.');
            $( "#submitForm" ).prop('disabled', true);
            $(this).focus();
        }else{
            $( "#submitForm" ).prop('disabled',false);
        }
    });
</script>
@endsection

