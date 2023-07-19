<script>
            
$(document).ready(function(){

    var standard_offer_data = @json($standard_offer_data);

    if(Object.keys(standard_offer_data).length > 1){

        $("#overlay").fadeIn(300);

        if(standard_offer_data.string_main_image){
            $("#main_img_preview").attr("src",standard_offer_data.string_main_image);
            $("#string_main_image").val(standard_offer_data.string_main_image);
            $("#tem_main_img").attr("src",standard_offer_data.string_main_image);
        }

        if(standard_offer_data.string_background_image){
            $("#tem_back").css('background-image', 'url(' + standard_offer_data.string_background_image + ')');
            $("#bi_preview").attr("src",standard_offer_data.string_background_image);
            $("#string_background_image").val(standard_offer_data.string_background_image);
        }

        if(standard_offer_data.contact_icon_color){
            document.documentElement.style.setProperty('--color-icon-contact', standard_offer_data.contact_icon_color);
        }

        if(standard_offer_data.website_icon_color){
            document.documentElement.style.setProperty('--color-icon-website', standard_offer_data.website_icon_color);
        }

        if(standard_offer_data.whatsapp_icon_color){
            document.documentElement.style.setProperty('--color-icon-whatsapp', standard_offer_data.whatsapp_icon_color);
        }

        if(standard_offer_data.location_icon_color){
            document.documentElement.style.setProperty('--color-icon-location', standard_offer_data.location_icon_color);
        }

        if(standard_offer_data.background_color){
            document.documentElement.style.setProperty('--color-background', standard_offer_data.background_color);
        }

        if(standard_offer_data.default_color){
            document.documentElement.style.setProperty('--color-default-color', standard_offer_data.default_color);
        }

        if(standard_offer_data.video_url){
            $("#video_url").val(standard_offer_data.video_url);

            var content = standard_offer_data.video_url;
            var domain = content.match(/^https:\/\/[^/]+/);
            if(domain[0]== 'https://youtu.be'){
                var video_id = content.substring(content.lastIndexOf('/') + 1);
            }else{
                var video_id = content.split('v=')[1];
                var ampersandPosition = video_id.indexOf('&');
                if(ampersandPosition != -1) {
                video_id = video_id.substring(0, ampersandPosition);
                }
            }

            updateYtThumbnail(content, video_id)
        }

        for (let i = 1; i <= Object.keys(standard_offer_data).length; i++) {
            // console.log(standard_offer_data['string_image_'+i]);
            
            if(standard_offer_data['string_image_'+i]){
                
                $("#galleryImage"+i).attr("src",standard_offer_data['string_image_'+i]);
                $("#tem_img"+i).css('background-image', 'url(' + standard_offer_data['string_image_'+i] + ')');
                $("#string_image_"+i).val(standard_offer_data['string_image_'+i]);
            }

            if(standard_offer_data['text_content_'+i]){
                $("#text_content_"+i).val(standard_offer_data['text_content_'+i]);
                $("#text_input_"+i).text(standard_offer_data['text_content_'+i]);
            }

            if(standard_offer_data['image_title_'+i]){
                $("#hero_title_"+i).val(standard_offer_data['image_title_'+i]);
                $("#tem_image_title_"+i).text(standard_offer_data['image_title_'+i]);
            }

            if(standard_offer_data['gallery_price_'+i]){
                $("#gallery_price_"+i).val(standard_offer_data['gallery_price_'+i]);
                $(".price_"+i).text(standard_offer_data['gallery_price_'+i]);
            }

            if(standard_offer_data['gallery_sale_price_'+i]){
                $("#gallery_sale_price_"+i).val(standard_offer_data['gallery_sale_price_'+i]);
                $(".sale_price_"+i).text(standard_offer_data['gallery_sale_price_'+i]);
            }

            if(standard_offer_data['tag_1_bg_'+i+'_color']){
                document.documentElement.style.setProperty('--color-tag1-bg'+i, standard_offer_data['tag_1_bg_'+i+'_color']);
            }

            if(standard_offer_data['tag_2_bg_'+i+'_color']){
                document.documentElement.style.setProperty('--color-tag2-bg'+i, standard_offer_data['tag_2_bg_'+i+'_color']);
            }

            if(standard_offer_data['cta_button_name_'+i]){
                $("#cta_button_name_"+i).val(standard_offer_data['cta_button_name_'+i]);
                $("#action_btn_"+i).text(standard_offer_data['cta_button_name_'+i]);
            }

            if(standard_offer_data['cta_button_url_'+i]){
                $("#cta_button_url_"+i).val(standard_offer_data['cta_button_url_'+i]);
            }

            if(standard_offer_data['text_content_color_'+i]){
                document.documentElement.style.setProperty('--color-text-content'+i, standard_offer_data['text_content_color_'+i]);
            }

            if(standard_offer_data['image_'+i+'_color']){
                document.documentElement.style.setProperty('--color-image-title'+i, standard_offer_data['image_'+i+'_color']);
            }

            if(standard_offer_data['cta_button_text_color_'+i]){
                document.documentElement.style.setProperty('--color-btn-text'+i, standard_offer_data['cta_button_text_color_'+i]);
            }
            
            if(standard_offer_data['cta_button_bg_color_'+i]){
                console.log(standard_offer_data['cta_button_bg_color_'+i]);
                document.documentElement.style.setProperty('--color-btn-bg'+i, standard_offer_data['cta_button_bg_color_'+i]);
            }

        }

        $("#overlay").fadeOut(300);
    }

    

    // console.log(standard_offer_data);
    // console.log(standard_offer_data.string_background_image);
    // console.log(standard_offer_data.string_image_1);







    /*Show error msg*/
    if('{{$errors->first('image_error')}}'){
        Sweet('error','{{$errors->first('image_error')}}');
    }

    $(".close-ea").on("click", function(){
        $("#inputs_area").toggleClass("show");
    });
    
    // $('')document.documentElement.style.getProperty('--color-temp-head');

    var $olEditable = $(".OL-EDITABLE");
    $olEditable.on("click", function(e){
        var input_tab = $(this).data("tab");

        console.log($("#blank_input").val());

        /* Check for blank and Valid inputs */
        if($("#blank_input").val() != ''){

             /* Button Update */
            @php
                $b = 1;   
                foreach ($button_colors as $key => $button) {
            @endphp

                    /* URL check */
                    var content = $('#cta_button_url_{{ $key }}').val();
                    if(content != '#' && $("#blank_input").val() == 'cta_button_url_{{ $key }}'){
                        var $selector = $("#action_btn_{{ $key }}");
                        
                        var is_valid = true;
                
                        var checkOne = 'https://';
                        var checkTwo = 'http://';
                        if(content.indexOf(checkOne) == -1 && content.indexOf(checkTwo) == -1){
                            is_valid = false;
                        }

                        var checkThree = '.in';
                        var checkFour = '.com';
                        var checkFive = '.org';
                        var checkSix = '.net';
                        var checkSeven = '.co.in';
                        var checkEight = '.io';
                        if(content.indexOf(checkThree) == -1 && content.indexOf(checkFour) == -1 && content.indexOf(checkFive) == -1 && content.indexOf(checkSix) == -1 && content.indexOf(checkSeven) == -1 && content.indexOf(checkEight) == -1){
                            is_valid = false;
                        }

                        if(is_valid == false){
                            Sweet('error','Please enter valid URL.');
                            $( "#submitForm" ).prop('disabled', true);
                            $("#blank_input").val('cta_button_url_{{ $key }}');
                            $('#cta_button_url_{{ $key }}').focus();
                            return false;
                        }else{
                            $( "#submitForm" ).prop('disabled', false);
                            $("#blank_input").val('');
                        }
                    }

            @php
                    $b++;
                }
            @endphp


            return false;
        }

        /* stop color update interval */
        stopColorUpdate();
        // console.log('stop');

        $olEditable.removeClass("OL-ACTIVE");
        $(".section-edit-tab").hide();

        $(input_tab).show();
        $(this).addClass("OL-ACTIVE");

        $("#inputs_area").addClass("show");

        e.stopPropagation();
    });
    
    // default background image
    $("#default_background_img").on("click", function(){
        var img = $("#tem_back").data("default-img");
        $("#bi_preview").attr("src", img);
        $("#tem_back").css("background-image", "url("+ img +")");
        $("input[name='background_image']").val("");

        $("input[name='bg_type']").val('');
        
        $("#bi_preview").attr("crop-modal", "");
    });

    // On Background COLOR change function
    $("input[name='background_color']").on("change", function(){
        var color = $(this).val();

        $("#bi_preview").removeAttr("src");
        $("#tem_back").css("background-image", "");
        $("input[name='background_image']").val("");

        $("#tem_back").css("background-image", "").css("background-color", color);
        document.documentElement.style.setProperty('--color-background', color);

        $("input[name='bg_type']").val('color');
    });

    // On HEADING COLOR change function
    $("input[name='business_name_color']").on("change", function(){
        var color = $(this).val();
        document.documentElement.style.setProperty('--color-business-name', color);
    });

    // On TEXT COLOR change function
    $("input[name='tag_line_color']").on("change", function(){
        var color = $(this).val();
        document.documentElement.style.setProperty('--color-tag-line', color);
    });

    $("input[name='default_color']").on("change", function(){
        var color = $(this).val();
        document.documentElement.style.setProperty('--color-default-color', color);
    });







    // On HEADING COLOR change function
    $("input[name='heading_color']").on("change", function(){
        var color = $(this).val();
        document.documentElement.style.setProperty('--color-temp-head', color);
    });

    // On TEXT COLOR change function
    $("input[name='text_color']").on("change", function(){
        var color = $(this).val();
        document.documentElement.style.setProperty('--color-text-color', color);
    });

    // On HEADING COLOR change function
    $("input[name='extra_heading_1_color']").on("change", function(){
        var color = $(this).val();
        document.documentElement.style.setProperty('--color-extra-head', color);
    });

    // On TEXT COLOR change function
    $("input[name='extra_text_1_color']").on("change", function(){
        var color = $(this).val();
        document.documentElement.style.setProperty('--color-extra-text', color);
    });

    // On HEADING Content change function
    $("input[name='heading']").on("keyup change", function(){
        var content = $(this).val();
        $("#tem_heading").html(content);
    });

    // On TEXT Content change function
    $("textarea[name='text']").on("keyup change", function(){
        var content = $(this).val();
        $("#tem_text").html(content);
    });

    // On HEADING Content change function
    $("input[name='extra_heading_1']").on("keyup change", function(){
        var content = $(this).val();
        $("#extra_heading_1").html(content);
    });

    // On TEXT Content change function
    $("textarea[name='extra_text_1']").on("keyup change", function(){
        var content = $(this).val();
        $("#extra_text_1").html(content);
    });




    // default main image
    $("#default_main_img").on("click", function(){
        var img = $("#tem_main_img").data("default-img");
        $("#main_img_preview").attr("src", img);
        $("#tem_main_img").attr("src", img);
        $("input[name='main_image']").val("");

        $("#main_img_preview").attr("crop-modal", "");
    });

    // On Main image change function
    /*$("input.gall_img_upld").on("change", function(){

        if(this.files[0].size > 2097152){
            $(this).val('');
            Sweet('error','Image size must be smaller than 2MB or equal.');
            return false;
        }
        
        var pre_to_self = $(this).parents("div.form-group").find("img");
        var pre_to_temp = $("#" + $(this).data("id"));
        var file = $(this).get(0).files[0];

        if(file){
            var file_type = file.type;
            var file_name = file.name;
            var fileExt = file_name.split('.').pop();
            var ext = fileExt.toLowerCase();
            
            if(ext != 'jpeg' && ext != 'png' && ext != 'jpg'){
                // var default_gall_imgs = $(this).parents("div.form-group").find(".default_gall_imgs");
                // default_gall_imgs.trigger('click');

                Sweet('error','Image format is not supported. Please Upload jpg, jpeg or png image.');
                return false;
            }
            
            var reader = new FileReader();
            reader.onload = function(){
                pre_to_self.attr("src", reader.result);
                pre_to_temp.css("background-image", "url("+ reader.result +")");

                var image = new Image();
                image.src = e.target.result;
                    
                //Validate the File Height and Width.
                image.onload = function () {
                    var height = this.height;
                    var width = this.width;

                    if(width > 1000 || height > 1000){
                        $('#default_main_img').trigger('click');
                        Sweet('error','Image Resolutions are too high.');
                        return;
                    }
                }
            }
            reader.readAsDataURL(file);
        }
    });*/

    // default main image
    $(".default_gall_imgs").on("click", function(){
        
        var pre_to_self = $(this).parents("div.form-group").find("img");
        var pre_to_temp = $(this).parents("div.form-group").find("input");
        var tem_pre =  $("#" + pre_to_temp.data("id"));
        
        var img = tem_pre.data("default-img");

        pre_to_self.attr("src", img);
        tem_pre.css("background-image", "url("+ img +")");
        pre_to_temp.val("");

        var default_id = $(this).attr('id');
        // console.log(default_id);
        var galleryDefaultArr = default_id.split('_')
        $("#galleryImage"+galleryDefaultArr[1]).attr("crop-modal", "");
    });
   

    // block anchor tags in #builder_canvas div
    $("#builder_canvas a").on("click", function(e){
        e.preventDefault();
    });


    /* Text Content Update */
    @php
        $c = 1;   
        foreach ($text_colors as $key => $text) {
    @endphp
        /* Update Sale Price On Gallery */
        $("textarea[name='text_content_{{ $key }}']").on("keyup change", function(){
            var $selector = $("#text_input_{{ $key }}");
            if ( $(this).val() != ""){
                var content = $(this).val();
                $selector.css('opacity', 1);
            }else{
                var content = 'Please enter your text';
                $selector.css('opacity', 0.2);
            }
            $selector.html(content);
        });

        /* Update Color of Title On Gallery */
        $("input[name='text_content_color_{{ $key }}']").on("change", function(){
            var color = $(this).val();
            document.documentElement.style.setProperty('--color-text-content{{ $key }}', color);
        });

        /* Validate image title */
        $("textarea[name='text_content_{{ $key }}']").on("blur keyup", function(){
            var content = $(this).val();

            if(content.length < 1){
                Sweet('error','Please enter something. It can not be empty.');
                $( "#submitForm" ).prop('disabled', true);
                $("#blank_input").val('text_content_{{ $key }}');
                $(this).focus();
            }else{
                $( "#submitForm" ).prop('disabled',false);
                $("#blank_input").val('');
            }
        });

    @php
            $c++;
        }
    @endphp


    /* Gallery Update */
    @php
        $g = 1;   
        foreach ($gallery_color_titles as $key => $title_col) {
    @endphp
        /* Update Sale Price On Gallery */
        $("input[name='gallery_sale_price_{{ $key }}']").on("keyup change", function(){
            var content = $(this).val();
            $(".sale_price_{{ $key }}").html(content);
        });

        /* Update Price On Gallery */
        $("input[name='gallery_price_{{ $key }}']").on("keyup change", function(){
            var content = $(this).val();
            $(".price_{{ $key }}").html(content);
        });

        /* Update Tag 1 On Gallery */
        $("input[name='gallery_tag_1_{{ $key }}']").on("keyup change", function(){
            var content = $(this).val();
            $("#tem_img{{ $key }}").attr('tag-name', content);
        });

        /* Update Tag 2 On Gallery */
        $("input[name='gallery_tag_2_{{ $key }}']").on("keyup change", function(){
            var content = $(this).val();
            $("#tem_tag_bg{{ $key }}").html(content);
        });

        /* Update Title On Gallery */
        $("input[name='image_title_{{ $key }}']").on("keyup change", function(){
            var content = $(this).val();
            $("#tem_image_title_{{ $key }}").html(content);
        });

        /* Update Color of Title On Gallery */
        $("input[name='image_{{ $key }}_color']").on("change", function(){
            var color = $(this).val();
            document.documentElement.style.setProperty('--color-image-title{{ $key }}', color);
        });

        /* Update Color of Tag 1 On Gallery */
        $("input[name='tag_1_bg_{{ $key }}_color']").on("change", function(){
            var color = $(this).val();
            document.documentElement.style.setProperty('--color-tag1-bg{{ $key }}', color);
        });

        /* Update Color of Tag 2 On Gallery */
        $("input[name='tag_2_bg_{{ $key }}_color']").on("change", function(){
            var color = $(this).val();
            document.documentElement.style.setProperty('--color-tag2-bg{{ $key }}', color);
        });

        /* Validate image title */
        $("input[name='image_title_{{ $key }}']").on("blur keyup", function(){
            var content = $(this).val();

            if(content.length < 1){
                Sweet('error','Please enter something. It can not be empty.');
                $( "#submitForm" ).prop('disabled', true);
                $("#blank_input").val('image_title_{{ $key }}');
                $(this).focus();
            }else{
                $( "#submitForm" ).prop('disabled',false);
                $("#blank_input").val('');
            }
        });

        /* Validate Gallery Price */
        $("input[name='gallery_price_{{ $key }}']").on("blur keyup", function(){
            var content = $(this).val();

            if(content.length < 1){
                Sweet('error','Please enter something. It can not be empty.');
                $( "#submitForm" ).prop('disabled', true);
                $("#blank_input").val('gallery_price_{{ $key }}');
                $(this).focus();
            }else{
                $( "#submitForm" ).prop('disabled',false);
                $("#blank_input").val('');
            }
        });

        /* Validate Gallery Sale Price */
        $("input[name='gallery_price_{{ $key }}']").on("blur keyup", function(){
            var content = $(this).val();

            if(content.length < 1){
                Sweet('error','Please enter something. It can not be empty.');
                $( "#submitForm" ).prop('disabled', true);
                $("#blank_input").val('gallery_price_{{ $key }}');
                $(this).focus();
            }else{
                $( "#submitForm" ).prop('disabled',false);
                $("#blank_input").val('');
            }
        });
    

    @php
            $g++;
        }
    @endphp



    /* Button Update */
    @php
        $b = 1;   
        foreach ($button_colors as $key => $button) {
    @endphp
        /* Update Name */
        $("input[name='cta_button_name_{{ $key }}']").on("keyup change", function(){

            /* URL check */
            var content = $('#cta_button_url_{{ $key }}').val();
            if(content != '#'){
                var $selector = $("#action_btn_{{ $key }}");

                var is_valid = true;
                
                var checkOne = 'https://';
                var checkTwo = 'http://';
                if(content.indexOf(checkOne) == -1 && content.indexOf(checkTwo) == -1){
                    is_valid = false;
                }

                var checkThree = '.in';
                var checkFour = '.com';
                var checkFive = '.org';
                var checkSix = '.net';
                var checkSeven = '.co.in';
                var checkEight = '.io';
                if(content.indexOf(checkThree) == -1 && content.indexOf(checkFour) == -1 && content.indexOf(checkFive) == -1 && content.indexOf(checkSix) == -1 && content.indexOf(checkSeven) == -1 && content.indexOf(checkEight) == -1){
                    is_valid = false;
                }

                if(is_valid == false){
                    Sweet('error','Please enter valid URL.');
                    $( "#submitForm" ).prop('disabled', true);
                    $("#blank_input").val('cta_button_url_{{ $key }}');
                    $('#cta_button_url_{{ $key }}').focus();
                    return false;
                }else{
                    $( "#submitForm" ).prop('disabled', false);
                    $("#blank_input").val('');
                }
            }


            var $selector = $("#action_btn_{{ $key }}");
            if ( $(this).val() != ""){
                var content = $(this).val();
                $selector.css('opacity', 1);
            }else{
                var content = 'Please enter your text';
                $selector.css('opacity', 0.2);
            }
            $selector.html(content);
        });

        /* Validate name */
        $("input[name='cta_button_name_{{ $key }}']").on("blur keyup", function(){

            /* URL check */
            var content = $('#cta_button_url_{{ $key }}').val();
            if(content != '#'){
                var $selector = $("#action_btn_{{ $key }}");
                
                var is_valid = true;
                
                var checkOne = 'https://';
                var checkTwo = 'http://';
                if(content.indexOf(checkOne) == -1 && content.indexOf(checkTwo) == -1){
                    is_valid = false;
                }

                var checkThree = '.in';
                var checkFour = '.com';
                var checkFive = '.org';
                var checkSix = '.net';
                var checkSeven = '.co.in';
                var checkEight = '.io';
                if(content.indexOf(checkThree) == -1 && content.indexOf(checkFour) == -1 && content.indexOf(checkFive) == -1 && content.indexOf(checkSix) == -1 && content.indexOf(checkSeven) == -1 && content.indexOf(checkEight) == -1){
                    is_valid = false;
                }

                if(is_valid == false){
                    Sweet('error','Please enter valid URL.');
                    $( "#submitForm" ).prop('disabled', true);
                    $("#blank_input").val('cta_button_url_{{ $key }}');
                    $('#cta_button_url_{{ $key }}').focus();
                    return false;
                }else{
                    $( "#submitForm" ).prop('disabled', false);
                    $("#blank_input").val('');
                }
            }




            var content = $(this).val();

            if(content.length < 1){
                Sweet('error','Please enter something. It can not be empty.');
                $( "#submitForm" ).prop('disabled', true);
                $("#blank_input").val('cta_button_name_{{ $key }}');
                $(this).focus();
            }else{
                $( "#submitForm" ).prop('disabled',false);
                $("#blank_input").val('');
            }
        });

        /* Validate link */

        $("input[name='cta_button_url_{{ $key }}']").on("blur", function(){
            
            if($("#cta_button_url_{{ $key }}").val() == ''){
                $("#cta_button_url_{{ $key }}").val('#');
                $( "#submitForm" ).prop('disabled',false);
                $("#blank_input").val('');
            }

            if($("#cta_button_url_{{ $key }}").val() != '#'){
                $("#blank_input").val('cta_button_url_{{ $key }}');
            }

            /* URL check */
            var content = $('#cta_button_url_{{ $key }}').val();
            if(content != '#'){
                var $selector = $("#action_btn_{{ $key }}");
                
                var is_valid = true;
                
                var checkOne = 'https://';
                var checkTwo = 'http://';
                if(content.indexOf(checkOne) == -1 && content.indexOf(checkTwo) == -1){
                    is_valid = false;
                }

                var checkThree = '.in';
                var checkFour = '.com';
                var checkFive = '.org';
                var checkSix = '.net';
                var checkSeven = '.co.in';
                var checkEight = '.io';
                if(content.indexOf(checkThree) == -1 && content.indexOf(checkFour) == -1 && content.indexOf(checkFive) == -1 && content.indexOf(checkSix) == -1 && content.indexOf(checkSeven) == -1 && content.indexOf(checkEight) == -1){
                    is_valid = false;
                }

                if(is_valid == false){
                    Sweet('error','Please enter valid URL.');
                    $( "#submitForm" ).prop('disabled', true);
                    $("#blank_input").val('cta_button_url_{{ $key }}');
                    $('#cta_button_url_{{ $key }}').focus();
                    return false;
                }else{
                    $( "#submitForm" ).prop('disabled', false);
                    $("#blank_input").val('');
                }
            }

        });

         /* Update Button Color */
         $("input[name='cta_button_text_color_{{ $key }}']").on("change", function(){
            var color = $(this).val();
            document.documentElement.style.setProperty('--color-btn-text{{ $key }}', color);
        });


         /* Update Button Background Color */
        $("input[name='cta_button_bg_color_{{ $key }}']").on("change", function(){
            var color = $(this).val();
            document.documentElement.style.setProperty('--color-btn-bg{{ $key }}', color);
        });

        $("input[name='cta_button_hide_{{ $key }}']").on("change", function(){
            var content = $("input[name='cta_button_hide_{{ $key }}']:checked").val();
            var inputs = $('.cta_info_section_{{ $key }}').find('input');
            // console.log(content);
            if(content == 1){
                $('.cta_btn_element_{{ $key }}').addClass('disabled');
                inputs.prop('readonly', true).prop('disabled', true);
                $('#cta_button_url_{{ $key }}').val('#');
            }else{
                $('.cta_btn_element_{{ $key }}').removeClass('disabled');
                inputs.prop('readonly', false).prop('disabled', false);
            }
        });

    @php
            $b++;
        }
    @endphp


    @php
        $b = 1; 
        if($template->button != ''){  
            foreach ($template->button as $key => $button) {
    @endphp
    
            var template_btn = @json($template->button);
            var btn_seq = {{ $key }};
            
            /* Button inputs */
            var inputs = $('.cta_info_section_{{ $b }}').find('input');
            if(template_btn[btn_seq].is_hidden == 1){
                inputs.prop('readonly', true).prop('disabled', true);
            }else{
                inputs.prop('readonly', false).prop('disabled', false);
            }
        
    @php
                $b++;
            }
        }
    @endphp

   
    $("input[name='video_url']").on("keyup change", function(){
        var content = $(this).val();

        if(content.indexOf('youtube.com') == -1 && content.indexOf('youtu.be') == -1){
            $("#blank_input").val('video_url');
        }else{
            var domain = content.match(/^https:\/\/[^/]+/);
            if(domain[0]== 'https://youtu.be'){
                var video_id = content.substring(content.lastIndexOf('/') + 1);
            }else{
                var video_id = content.split('v=')[1];
                var ampersandPosition = video_id.indexOf('&');
                if(ampersandPosition != -1) {
                video_id = video_id.substring(0, ampersandPosition);
                }
            }

            if(video_id){
                updateYtThumbnail(content, video_id);
            }
            $("#blank_input").val('');
        }      
    });


    $("input[name='video_url']").on("blur", function(){
        var content = $(this).val();

        if(content.indexOf('youtube.com') == -1 && content.indexOf('youtu.be') == -1){
            Sweet('error','Please enter valid Youtube Video link.');
            $( "#submitForm" ).prop('disabled', true);
            $(this).focus();
        }else{
            $( "#submitForm" ).prop('disabled',false);
        }
    });

    function updateYtThumbnail(content, video_id){
        $("#videoFrame").attr("src", content);

        //save thumbnail
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var data = {
            "_token" : CSRF_TOKEN,
            video_id : video_id,
            template_id : {{ $template->slug }}
        };
        $.ajax({
            url : "{{ route('business.updateYoutubeThumbnail') }}",
            type : 'post',
            data : data,
            dataType : "json",
            success : function(res) {
                if(res.status == true){
                    $('#videoOverlay').css('background-image', 'url('+ res.thumb_path + ')');
                }else{
                    $('#videoOverlay').css('background-image', 'url('+ res.thumb_path + ')');
                }

                $("#overlay").fadeOut(300); 
            }
        });
    }

    /* update color */
    var colorInterval = '';
    function startColorUpdate(){

        colorInterval = setInterval(()=>{
            
            /* Button Colors */
            @php   
                if(!empty($button_colors)){
                    foreach ($button_colors as $key => $button) {
            @endphp
                    var color = $("input[name='cta_button_bg_color_{{ $key }}']").val();
                    document.documentElement.style.setProperty('--color-btn-bg{{ $key }}', color);

                    var color = $("input[name='cta_button_text_color_{{ $key }}']").val();
                    document.documentElement.style.setProperty('--color-btn-text{{ $key }}', color);

            @php
                    }
                }
            @endphp

            @php
                if(!empty($gallery_color_titles)){   
                    foreach ($gallery_color_titles as $key => $title_col) {
            @endphp
                        var color = $("input[name='image_{{ $key }}_color']").val();
                        document.documentElement.style.setProperty('--color-image-title{{ $key }}', color);

                        var color = $("input[name='tag_1_bg_{{ $key }}_color']").val();
                        document.documentElement.style.setProperty('--color-tag1-bg{{ $key }}', color);

                        var color = $("input[name='tag_2_bg_{{ $key }}_color']").val();
                        document.documentElement.style.setProperty('--color-tag2-bg{{ $key }}', color);
            @php
                    }
                }
            @endphp

           
            var color = $("input[name='contact_icon_color']").val();
            document.documentElement.style.setProperty('--color-icon-contact', color);
                
            var color = $("input[name='whatsapp_icon_color']").val();
            document.documentElement.style.setProperty('--color-icon-whatsapp', color);

            var color = $("input[name='location_icon_color']").val();
            document.documentElement.style.setProperty('--color-icon-location', color);

            var color = $("input[name='website_icon_color']").val();
            document.documentElement.style.setProperty('--color-icon-website', color);

            var color = $("input[name='business_name_color']").val();
            document.documentElement.style.setProperty('--color-business-name', color);

            var color = $("input[name='tag_line_color']").val();
            document.documentElement.style.setProperty('--color-tag-line', color);
            
            var color = $("input[name='default_color']").val();
            document.documentElement.style.setProperty('--color-default-color', color);


            @php
                if(!empty($text_colors)){  
                    foreach ($text_colors as $key => $text) {
            @endphp
                    var color = $("input[name='text_content_color_{{ $key }}']").val();
                    document.documentElement.style.setProperty('--color-text-content{{ $key }}', color);
            @php
                    }
                }
            @endphp

            // var color = $("input[name='background_color']").val();
            // $("#tem_back").css("background-image", "").css("background-color", color);
            // document.documentElement.style.setProperty('--color-background', color);
           
            var color = $("input[name='heading_color']").val();
            document.documentElement.style.setProperty('--color-temp-head', color);
            
            var color = $("input[name='text_color']").val();
            document.documentElement.style.setProperty('--color-text-color', color);
            
            var color = $("input[name='extra_heading_1_color']").val();
            document.documentElement.style.setProperty('--color-extra-head', color);

            var color = $("input[name='extra_text_1_color']").val();
            document.documentElement.style.setProperty('--color-extra-text', color);
            
            // console.log('color change');
        }, 200);
        
    }

    function stopColorUpdate(){
        clearInterval(colorInterval);
    }


    $('.colorpickerinput input').on("click", function(){
        startColorUpdate();
    });
    
    //clearInterval(colorInterval);


    $("input[name='heading']").on("blur keyup", function(){
        var content = $(this).val();

        if(content.length < 1){
            Sweet('error','Please enter something. It can not be empty.');
            $( "#submitForm" ).prop('disabled', true);
            $("#blank_input").val('heading');
            $(this).focus();
        }else{
            $( "#submitForm" ).prop('disabled',false);
            $("#blank_input").val('');
        }
    });

    $("input[name='text']").on("blur keyup", function(){
        var content = $(this).val();

        if(content.length < 1){
            Sweet('error','Please enter something. It can not be empty.');
            $( "#submitForm" ).prop('disabled', true);
            $("#blank_input").val('text');
            $(this).focus();
        }else{
            $( "#submitForm" ).prop('disabled',false);
            $("#blank_input").val('');
        }
    });

    $("input[name='extra_heading_1']").on("blur keyup", function(){
        var content = $(this).val();

        if(content.length < 1){
            Sweet('error','Please enter something. It can not be empty.');
            $( "#submitForm" ).prop('disabled', true);
            $("#blank_input").val('extra_heading_1');
            $(this).focus();
        }else{
            $( "#submitForm" ).prop('disabled',false);
            $("#blank_input").val('');
        }
    });

    $("input[name='extra_text_1']").on("blur keyup", function(){
        var content = $(this).val();

        if(content.length < 1){
            Sweet('error','Please enter something. It can not be empty.');
            $( "#submitForm" ).prop('disabled', true);
            $("#blank_input").val('extra_text_1');
            $(this).focus();
        }else{
            $( "#submitForm" ).prop('disabled',false);
            $("#blank_input").val('');
        }
    })









    //icon color
    $("input[name='contact_icon_color']").on("change", function(){
        var color = $(this).val();
        document.documentElement.style.setProperty('--color-icon-contact', color);
        if($('.sameColor:checkbox:checked').length > 0){
            $('.sameColor').prop('checked', false);
        }
    });

    $("input[name='whatsapp_icon_color']").on("change", function(){
        var color = $(this).val();
        document.documentElement.style.setProperty('--color-icon-whatsapp', color);
    });

    $("input[name='location_icon_color']").on("change", function(){
        var color = $(this).val();
        document.documentElement.style.setProperty('--color-icon-location', color);
    });

    $("input[name='website_icon_color']").on("change", function(){
        var color = $(this).val();
        document.documentElement.style.setProperty('--color-icon-website', color);
    });

    $('.sameColor').on('click', function(){
        var color = $('#contact_icon_color').val();
        //console.log(color);
        if($('.sameColor:checkbox:checked').length > 0){
            $('#whatsapp_icon_color').attr('disabled',true);
            $('#location_icon_color').attr('disabled',true);
            $('#website_icon_color').attr('disabled',true);

            $('#whatsapp_icon_color').val(color);
            $('#location_icon_color').val(color);
            $('#website_icon_color').val(color);

            document.documentElement.style.setProperty('--color-icon-whatsapp', color);
            document.documentElement.style.setProperty('--color-icon-location', color);
            document.documentElement.style.setProperty('--color-icon-website', color);
        }else{
            $('#whatsapp_icon_color').attr('disabled',false);
            $('#location_icon_color').attr('disabled',false);
            $('#website_icon_color').attr('disabled',false);
        }
        
    });



    

});


    $("input[name='background_color']").val('{{ trim($template->bg_color) }}');
    $("input[name='business_name_color']").val('{{ trim($template->business_name_color) }}');
    $("input[name='tag_line_color']").val('{{ trim($template->tag_line_color) }}');
    $("input[name='default_color']").val('{{ trim($template->default_color) }}');

    $("input[name='contact_icon_color']").val('{{ trim($template->contact_icons->contact_icon_color) }}');
    $("input[name='whatsapp_icon_color']").val('{{ trim($template->contact_icons->whatsapp_icon_color) }}');
    $("input[name='location_icon_color']").val('{{ trim($template->contact_icons->location_icon_color) }}');
    $("input[name='website_icon_color']").val('{{ trim($template->contact_icons->website_icon_color) }}');








    $("input[name='extra_heading_1_color']").val('{{ trim($template->extra_heading_1_color) }}');
    $("input[name='extra_text_1_color']").val('{{ trim($template->extra_text_1_color) }}');

    $("input[name='heading_color']").val('{{ trim($template->hero_title_color) }}');
    $("input[name='text_color']").val('{{ trim($template->hero_text_color) }}');








    //Text Color
    var text_colors = @json($text_colors);

    $.each(text_colors, function( index, value ) {
        // console.log(value);
        $("input[name='text_content_color_"+index+"']").val(value);
    });


    //Gallery Image Title Color
    var gallery_color_titles = @json($gallery_color_titles);

    $.each(gallery_color_titles, function( index, value ) {
        $("input[name='image_"+index+"_color']").val(value);
    });


    //Gallery Tag Background
    var tag_1_bg_colors = @json($tag_1_bg_colors);

    $.each(tag_1_bg_colors, function( index, value ) {
        $("input[name='tag_1_bg_"+index+"_color']").val(value);
    });

    var tag_2_bg_colors = @json($tag_2_bg_colors);

    $.each(tag_2_bg_colors, function( index, value ) {
        $("input[name='tag_2_bg_"+index+"_color']").val(value);
    });

</script>


<script>
jQuery(function($){
    $(document).ajaxSend(function() {
        $("#overlay").fadeIn(300);
    });

    

    $('body').bind("mousewheel", function() {
        return false;
    });

    $('#submitForm').click(function(){
        $( "#submitForm" ).prop('disabled', true);

        /*Scroll to top before capture*/
        $([document.documentElement, document.body]).animate({
            scrollTop: $(".main-content").offset().top
        }, 1);

        $("body").css("overflow-y", "hidden");

        /*Remove Selection before capture*/
        var selected_ele = $('.OL-ACTIVE');
        $(selected_ele).removeClass('OL-ACTIVE');

        /* Remove hidden buttons */
        @php   
            foreach ($button_colors as $key => $button) {
        @endphp
                var content = $("input[name='cta_button_hide_{{ $key }}']:checked").val();
                if(content == 1){
                    $('.cta_btn_element_{{ $key }}').parent().remove();
                }
        @php
            }
        @endphp

        var width = $("#template-full-container").width() / 2;
        var height = $("#template-full-container").height() / 2;

            /* html2canvas(document.getElementById("template-full-container"),
            {
                allowTaint: true,
                useCORS: true
            }).then(function (canvas) {
                
                var extra_canvas = document.createElement("canvas");
                extra_canvas.setAttribute('width',width);
                extra_canvas.setAttribute('height',height);
                var ctx = extra_canvas.getContext('2d');
                ctx.drawImage(canvas,0,0,canvas.width, canvas.height,0,0,width,height);
                var dataURL = extra_canvas.toDataURL();

                //var dataURL = canvas.toDataURL();
                //console.log(dataURL);
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url : "{{ route('business.saveOfferThumbnail') }}",
                    type : 'POST',
                    data :  {
                                "_token" : CSRF_TOKEN,
                                "imgBase64" : dataURL
                            },
                    dataType : "json",
                    success : function(res) {
                        
                        //console.log(res);
                        $("input[name='thumbnail']").val(res.filename);
                        $("#overlay").fadeOut(300);
                        $('#builderForm').submit();
                        $( "#submitForm" ).prop('disabled', false);
                        $("body").css("overflow-y", "unset");
                    },
                    error: function(xhr, status, error) 
                    {
                        $( "#submitForm" ).prop('disabled', false);
                        $("body").css("overflow-y", "unset");

                        $.each(xhr.responseJSON.errors, function (key, item) 
                        {
                            Sweet('error',item);
                        });
                    }
                }).done(function() {
                    setTimeout(function(){
                        $("#overlay").fadeOut(300);
                    },500);
                });
            }); */

            var html_body = document.getElementById("template-full-container");
            html2canvas(html_body, {
                allowTaint: true,
                useCORS: true,
                windowWidth: 991,
                // windowHeight: 'auto',
            }).then(function(canvas) {
                var dataURL = canvas.toDataURL();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url : "{{ route('business.saveOfferThumbnail') }}",
                    type : 'POST',
                    data : {
                        "_token" : CSRF_TOKEN,
                        "imgBase64" : dataURL
                    },
                    dataType : "json",
                    success : function(res) {
                        $("input[name='thumbnail']").val(res.filename);
                        $("#overlay").fadeOut(300);
                        $('#builderForm').submit();
                        $( "#submitForm" ).prop('disabled', false);
                        $("body").css("overflow-y", "unset");
                    },
                    error: function(xhr, status, error){
                        $( "#submitForm" ).prop('disabled', false);
                        $("body").css("overflow-y", "unset");
                        $.each(xhr.responseJSON.errors, function (key, item){
                            Sweet('error',item);
                        });
                    }
                }).done(function() {
                    setTimeout(function(){
                        $("#overlay").fadeOut(300);
                    }, 500);
                });
            });
        
    });  
    
    $("#changeTemplate").click(function(e){
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "Your template will be replaced with fresh one!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Continue'
        }).then((result) => {
            // console.log(result);
            if (result.value) {
                window.location.href = '{!! $template_url !!}';
                //alert('ok');
            }
        })
    });
});
</script>

<script>
/* When click cancel on image selection (for Gallery images) */
function click_default_gal(input){
    var default_ = input.parents('div.form-group').find('span.dd_btn');
    default_.click();
}

function templats_images_preview(image) {
    var last_image = $('#last_image').val();
    // console.log(last_image);
    $("#bi_preview").attr("crop-modal", "");
    $("#main_img_preview").attr("crop-modal", "");

    if(last_image == 'background_image'){
        $("#bi_preview").attr("src", image);
        $("#bi_preview").attr("crop-modal", 1);
        $("#tem_back").css("background-image", "url("+ image +")");
        $("input[name='bg_type']").val('image');
    }

    if(last_image == 'main_image'){
        $("#main_img_preview").attr("src", image);
        $("#main_img_preview").attr("crop-modal", 1);
        $("#tem_main_img").attr("src", image);
    }

    if(last_image != 'background_image' && last_image != 'main_image'){
        const imageArr = last_image.split("_");
        $("#galleryImage"+imageArr[1]).attr("src", image);
        $("#galleryImage"+imageArr[1]).attr("crop-modal", 1);
        $("#tem_img"+imageArr[1]).css("background-image", "url("+ image +")");
    }
    $("#string_"+last_image).val(image);
}
</script>