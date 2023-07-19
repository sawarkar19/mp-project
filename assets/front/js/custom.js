$(document).ready(function(){

    /* Menu On scroll */
    var $win = $(window), $winheight = $win.height(), $winWidth = $win.width();
    $win.scroll(function(){
        var $scrolling = $win.scrollTop();
        if($scrolling >= $winheight){
            $("header").addClass("inside");
        }else{
            $("header").removeClass("inside");
        }
    });
    if($winWidth < 575){
        $("header").addClass("inside");
    }
    /* menu scroll end */


    /* carousel */
    $("#HomeCarousel").owlCarousel({
        autoplay: true,
        loop: true,
        margin:30,
        nav:false,
        dots:false,
        responsive : {
            0 : {
                items : 1.3,
                margin:15,
            },
            480 : {
                items : 2.3,
                margin:15,
            },
            767 : {
                items : 2.4,
            },
            991 : {
                items : 3.3,
            },
            1200 : {
                items : 4.3,
            }
        }
    });

    /* Says Carousel */
    $("#SaysCarousel").owlCarousel({
        autoplay: true,
        loop: true,
        margin:0,
        nav:true,
        dots:false,
        items:1,
        autoHeight: true,
    });


    /* menu click toggler */
    $("#menu-btn").on("click", function(){
        $("header").toggleClass("showMenu");
    })
});

/* Bootstrap Tooltip Code */
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})
/* End Bootstrap Tooltip Code */


/* Animation Scripts */
// AOS.init({
//     duration: 800,
//     easing: 'ease-in-out',
//     offset: 80,
// }); 

/*
 * E-Book Verify and Popup
 */
$(document).ready(function(){
    var EBookModal = new bootstrap.Modal(document.getElementById('EBookModal'));
    $("#ebookGetNow").click(function(){
        var email = $("#e_book_email");
        var emailVal = email.val();
        email.next("span").remove();
        if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(emailVal)){
            $("#book_email").val(emailVal);
            EBookModal.show();
        }else{
            email.css('border-color', 'red').after("<span class='text-danger ' style='font-size:12px;'>Please enter the valid E-mail address!</span>");
            setTimeout(() => {
                email.css('border-color', '').next("span").remove();
            }, 10000);
        }
    });


    $("#getEBookForm").on("submit", function(event){
        event.preventDefault();
        // get data from the inputs
        var name = $("#book_name").val();
        var number = $("#book_number").val();
        var email = $("#book_email").val();
        var submitForm = true;
        var errorMsg = '';
        $("#getEBookForm .error_mag").empty();
        if(name == ''){  // Validate Name (string)
            submitForm = false;
            errorMsg = errorMsg + '<p class="text-danger">Name should not be empty!</p>';
        }
        if(!number.match('[6789][0-9]{9}')){ // Validate 10 digit mobile number
            submitForm = false;
            errorMsg = errorMsg + '<p class="text-danger">Please enter a valid (10 digit) WhatsApp number!</p>';
        }
        if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){ // Validate email address
            submitForm = false;
            errorMsg = errorMsg + '<p class="text-danger">Please enter a valid Email-ID!</p>';
        }
        if(submitForm){ // if everything is okay
            var boboApi = 'https://ol.salesrobo.com/form/submit?formId=3';
            $.ajax({
                url: boboApi,
                type: "post",
                data: {
                    'mauticform[mail]' : email,
                    'mauticform[mobile]' : number,
                    'mauticform[f_name]' : name,
                    'mauticform[formId]' : 3,
                    'mauticform[return]' : '',
                    'mauticform[formName]' : 'pdfsubscription',
                },
                beforeSend: function() {
                    $("#getEBookForm .error_mag").html('<div><p class="text-dark">Please wait...</p></div>');
                },
                success: function(responce) {
                    console.log(responce);
                    $("#getEBookForm .error_mag").html('<div><p class="text-success"><b>Congrats!</b> Your E-Book has been sent to your E-Mail ID.</p></div>');
                },
            });
        }else{
            $("#getEBookForm .error_mag").html('<div>'+errorMsg+'</div>');
        }

        setTimeout(() => {
            $("#getEBookForm .error_mag").empty();
        }, 10000);

    })
});