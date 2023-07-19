<script>


    $(document).ready(function() {
        
        $("input.instant_checkbox").on('change', function (e) {
            e.preventDefault();

            var $input = $(this);
            var $parent = $input.parent();

            if($input.is(":checked")){ // Check if option is selcted
                $parent.find('.hidden_inputs').show(); // Visible Link input related to selected option
                /*$parent.find('.hidden_inputs input').attr('required', 'required');*/ // add input as required field
            }else{ // if unselecte the option
                $parent.find('.hidden_inputs').hide(); //Hide Link input related to unselected option
                $parent.find('.hidden_inputs input').val(''); //empty value to input
                /*$parent.find('.hidden_inputs input').removeAttr('required');*/ // remove rquired field
            }
        })
    });

        
</script>

<script>
    // function for seclect Template (Non Website) promo
    function with_website() {
        // URL ENABLE
        /*$("#existing_url").show().find("input").prop("required", true);*/
        $("#existing_url").show();

        // Disable Offer Image
        $("#image_offer").parents("div.form-row").hide();

        // Disable Tempplate
        $(".custom-control-input").parents("div.form-row").hide();

        // Enable fixed coupon
        $("#Fixed_coupon").removeAttr("disabled");
        $("#coupon_type").show();
    }

    function without_website() {
        // Website URL Disable
        /*$("#existing_url").hide().find("input").prop("required", false).val("");*/
        $("#existing_url").hide();
        $("input[name='promo_url']").val('');
        // Visible Offer Image
        $("#image_offer").parents("div.form-row").show();

        // Disable Tempplate
        $(".custom-control-input").parents("div.form-row").show();

        // Disable fixed coupon and checked secure coupon
        $("#coupon_type").hide();
        $("#Fixed_coupon").attr("disabled", "disabled");
        $("#Secured_coupon").click();
    }


    // Selection animation for Page type (Craete Offer page)
    $(document).ready(function() {
        var $page_type_input = $("input.page_type_input");
        $page_type_input.on("change", function() {

            // get the checked input data
            var $selected = $("input.page_type_input:checked");

            $page_type_input.parents("div.radio_tab").removeClass('border-primary');
            $selected.parents("div.radio_tab").addClass('border-primary');

            if($selected.data("inputname") == "without_website"){
                without_website();
            }
            else if($selected.data("inputname") == "with_website"){
                with_website();
            }
        })
    });


    // Input File image Preview
    $(document).ready(function () {
        $("input.img-preview-oi").on("change", function() {
            var file = $(this).get(0).files[0];
            if(file){
                var reader = new FileReader();
                reader.onload = function(e){
                    /*$("#preview_oi").attr("src", reader.result);*/

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
        })
    })

    // On change coupon type
    $(document).ready(function() {
        var $coupon_type_ = $("input[name='coupon_type']");
        $coupon_type_.on("change", function() {
            var $idname = $(this).attr("id");
            if($idname == "Fixed_coupon"){
                $("#Secure_comb").hide();
                /*$("#Fixed_comb").show().children("input").attr("required", "required");*/
                $("#Fixed_comb").show();
            }
            else if($idname == "Secured_coupon"){
                $("#Secure_comb").show();
                $("#Fixed_comb").hide();
                $("input[name='coupon_code']").val('');
                /*$("#Fixed_comb").hide().children("input").removeAttr("required").val("");*/
            }
        })
    });

    // on chane location type 
    $(document).ready(function() {
        var $location_type_ = $("input[name='location_type']");
        $location_type_.on("change", function() {
            var $idname = $(this).attr("id");
            if($idname == "location"){
                /*$("#location_comb").show().find("select").attr("required", "required");*/
                $("#location_comb").show();
            }
            else if($idname == "anywhere"){
                /*$("#location_comb").hide().find("select").removeAttr("required").val("");*/
                $("#state-id").val('');
                $("#city-id").val('');
                $("#location_comb").hide();
            }
        })
    });

    // =============================================
    $(document).ready(function() {
        var $tempaltes_select = $("input.tempaltes_select");
        $tempaltes_select.on("change", function() {

            // get the checked input data
            var $selected = $("input.tempaltes_select:checked");

            $tempaltes_select.parents("div.template_selection").removeClass('border-primary');
            $selected.parents("div.template_selection").addClass('border-primary');
            
        })
    });

    // =============================================
    $(document).ready(function() {
        // on the change of discount type (percent or Amount) [Coupon detail block]
        var $discount_type_input = $("input.discount_type_input");
        $discount_type_input.on("change", function() {
            // get the checked input data
            var $selected = $("input.discount_type_input:checked");

            $discount_type_input.parents("div.border").removeClass('border-primary');
            $discount_type_input.nextAll('input.offer_data_in').prop('disabled', true).val('');
            
            $selected.nextAll('input.offer_data_in').prop('disabled', false).focus();
            $selected.parents("div.border").addClass('border-primary');

            if($selected.data("name") == "percentage"){
                $("#maximum_input").hide().children('input').prop("required", false).val('');
                $("#minimum_input").show().children('input').prop("required", true);

            }else if($selected.data("name") == "amount"){
                $("#maximum_input").hide().children('input').prop("required", false).val('');
                $("#minimum_input").show().children('input').prop("required", true);
            }
            else if($selected.data("name") == "perclick"){
                $("#minimum_input").hide().children('input').prop("required", false).val('');
                $("#maximum_input").show().children('input').prop("required", true);
            }


            // if($selected.data("name") == "percentage"){
            //     $selected.parents("div.border").addClass('border-primary');

            //     $("#coupon_perclick_input").hide().children('input').prop("required", false).val('');
            //     $("#coupon_amount_input").hide().children('input').prop("required", false).val('');

            //     $("#coupon_percentage_input").show().children('input').prop("required", true);

            // }else if($selected.data("name") == "amount"){
            //     $selected.parents("div.border").addClass('border-primary');

            //     $("#coupon_perclick_input").hide().children('input').prop("required", false).val('');
            //     $("#coupon_percentage_input").hide().children('input').prop("required", false).val('');

            //     $("#coupon_amount_input").show().children('input').prop("required", true);
            // }
            // else if($selected.data("name") == "perclick"){
            //     $selected.parents("div.border").addClass('border-primary');

            //     $("#coupon_amount_input").hide().children('input').prop("required", false).val('');
            //     $("#coupon_percentage_input").hide().children('input').prop("required", false).val('');

            //     $("#coupon_perclick_input").show().children('input').prop("required", true);
            // }

        });
    });


    /* Create Future Offer */
    $(document).ready(function() {

        $(document).ajaxSend(function() {
            $("#overlay").fadeIn(300);　
        });

        $("#futureform").on('submit', function(e){
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
                    $("#overlay").fadeOut(300);
                    //console.log(response);
                    if(response.status == true && response.type == 'template'){
                        Sweet('success',response.message);
                        window.location.href = response.redirect_url;
                    }else if(response.status == true && response.type == 'webpage'){
                        window.location.href = response.redirect_url;
                    }else{
                        Sweet('error',response.message);
                    }
                },
                error: function(xhr, status, error) 
                {
                    $("#overlay").fadeOut(300);
                    $.each(xhr.responseJSON.errors, function (key, item) 
                    {
                        Sweet('error',item);
                    });
                }
            })
        });
    });

    $(".draft_btn").on('click', function(e){
        $('#is_draft').val(1);
    });

    $(".save_btn").on('click', function(e){
        $('#is_draft').val(0);
    });

    $(document).ready(function() {
        $("#futureUpdateform").on('submit', function(e){
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
                    //console.log(response);
                        $("#overlay").fadeOut(300);
                    if(response.status == true){
                        //console.log(response.redirect_url);
                        window.location.href = response.redirect_url;
                        //Sweet('success',response.message);
                    }else{
                        Sweet('error',response.message);
                    }
                },
                error: function(xhr, status, error) 
                {
                    $("#overlay").fadeOut(300);
                    $.each(xhr.responseJSON.errors, function (key, item) 
                    {
                        Sweet('error',item);
                    });
                }
            })
        });
    });


    /* Update Offer Template */
    $(document).ready(function() {
        $("#templateform").on('submit', function(e){
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
                    $("#overlay").fadeOut(300);
                    console.log(response);
                    if(response.status == true){
                        window.location.href = response.redirect_url;
                    }else{
                        Sweet('error',response.message);
                    }
                },
                error: function(xhr, status, error) 
                {
                    $("#overlay").fadeOut(300);
                    $.each(xhr.responseJSON.errors, function (key, item) 
                    {
                        Sweet('error',item);
                    });
                }
            })
        });
    });
</script>


<script>
    $(document).ready(function () {
        $('#state-id').on('change', function () {
            var idState = this.value;
            if(idState){
                $('#city-label').replaceWith('<label id="city-label">Select City <span>*</span></label>');
            }else{
                $('#city-label').replaceWith('<label id="city-label">Select State then Select City <span>*</span></label>');
            }
            $("#city-id").html('');
            $.ajax({
                url: "{{url('business/cities')}}",
                type: "POST",
                data: {
                    state_id: idState,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res) {
                    $("#overlay").fadeOut(300);
                    $('#city-id').html('<option value="">Select City</option>');
                    $.each(res.cities, function (key, value) {
                        $("#city-id").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                },
                error: function(xhr, status, error) 
                {

                    $("#overlay").fadeOut(300);
                    /*error*/
                }
            });
        });
    });

</script>
    <script>
        $( ".setDefault" ).on("click", function() {

            var offerID = $(this).attr("id");
            //console.log(offerID);
            $(".setDefaultCheckbox").prop('checked', false);
            $(".checkbox_"+offerID).prop('checked', true);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'POST',
                url: "{{url('business/set-default')}}/" + offerID,
                data: {_token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function(response){ 
                    $("#overlay").fadeOut(300);
                    //console.log(response);
                    if(response.status == true){
                        Sweet('success',response.message);
                    }else{
                        Sweet('error',response.message);
                    }
                },
                error: function(xhr, status, error) 
                {
                    $("#overlay").fadeOut(300);
                    $.each(xhr.responseJSON.errors, function (key, item) 
                    {
                        Sweet('error',item);
                    });
                },
            });
        });

        $( ".setDefaultCheckbox" ).on("click", function() {

            var offerID = $(this).attr("id");

            $(".setDefaultCheckbox").prop('checked', false);
            $(".setDefaultCheckbox#" + offerID).prop('checked', true);

            //console.log(offerID);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'POST',
                url: "{{url('business/set-default')}}/" + offerID,
                data: {_token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function(response){ 
                    $("#overlay").fadeOut(300);
                    //console.log(response);
                    if(response.status == true){
                        Sweet('success',response.message);

                        $(".default-tag").remove();
                        $("#grid_" + offerID).children(".article-header").append('<div class="default-tag">Default</div>');
                        $(".checkbox_gr_" + offerID).remove();

                    }else{
                        Sweet('error',response.message);
                    }
                },
                error: function(xhr, status, error) 
                {
                    $("#overlay").fadeOut(300);
                    $.each(xhr.responseJSON.errors, function (key, item) 
                    {
                        Sweet('error',item);
                    });
                },
            });
        });
</script>
<script>
    $( "body" ).delegate( ".page_type_input", "click", function() {
        var type = $(this).val();
        $('#page_type_input').val(type);
    });
    

    $('.tc-inner').on('click', function(){
        var temp_id = $(this).attr('id');
        window.location.href = temp_id;
    });

</script>