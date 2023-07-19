<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>V card</title>
        <link rel="stylesheet" href="{{ asset('assets/front/vendor/bootstrap/css/bootstrap.min.css') }}" media="all">
        <!-- <link rel="stylesheet" href="{{ asset('assets/front/vendor/bootstrap-icons/font/bootstrap-icons.css') }}" media="all"> -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Poppins:wght@400;500&display=swap');

            .v_card{
                position: relative;
                width: 1000px;
                max-width: 100%;
                margin: auto;
                background-color: #F7F7F7;
            }
            .card_inside_container{
                position: relative;
                width: 940px;
                max-width: 100%;
                margin: auto; 
            }
            .v_card_three h2{
                font-family: Playfair Display;
                color: #F0C20E;

            }
            .business_name h4, .business_name p {
                color: #fff;
                font-size: 12px;
            }
            .v_card_three .nevigation_bar{
                background-color: #2B303C;
            }
            .nevigation_bar .navbar-toggler{
                background-color: #fff;
            }
            .menu ul li a{
                color: #fff !important;
                padding: 0 30px !important;
            }
            .banner_card{
                padding: 30px;
                background-size: cover;
                opacity: 0.8;
                background-repeat: no-repeat; 
                background-image: url({{asset('assets/front/images/v_cards/banner3.jpg')}});
            }
            .banner_card .card{
                position: relative;
                width: 500px;
                max-width: 100%;
                margin: auto;
                border-style: none;
                box-shadow: 3px 3px 8px #00000038;
            }
            .qr_code i::before{
                font-size: 110px;
            }
            .qr_code p{
                font-size: 12px;
            }
            .name i::before{
                font-size: 21px;
            }
            .about_us_img img{
                width: 100%;
            }
            .service .card{ 
                border-top: 3px solid #F0C20E;
                box-shadow: 2px 3px 6px #ebebeb;
            }
           .footer{
                background-color: #2B303C;
            }
            .footer ul{
                list-style: none;
                display: inline-block;
            }
            .footer ul li{
                display: inline-block;
                padding-right: 10px;
            }
            .footer ul li i{
                display: inline-block;
                color: #fff;
                font-size: 20px;
            }
            @media(max-width: 400px){
                .banner_card{
                    padding:10px 0px;
                }
            }

        </style>
    </head>
    <body>
        <section class="v_card v_card_three">
            {{--navbar start--}}
            <nav class="navbar nevigation_bar navbar-light navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand text-center" href="#"><img src="{{asset('assets/front/images/v_cards/logo3.png')}}" style="width: 50px;">
                        <div class="business_name text-center">
                            <h4 class="mb-0 mt-2">Fresh Vegetable</h4>
                            <p>Veggies On Your Door step</p>
                        </div>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse menu justify-content-end" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                              <a class="nav-link active" data-target="home" data-scroll="home" href="#home" aria-current="page">Home</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link"  data-target="about_us3" data-scroll="about_us3" href="#about_us3">About Us</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link"  data-target="service3" data-scroll="service3" href="#service3">Services</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav> 
            {{--navbar end--}}
            {{--banner and card start--}}
            <div class="banner_card position-relative">
                <div class="container-fluid">
                   <div class="row">
                        <div class="col-12 col-sm-8 col-md-6 col-lg-6">
                            <div class="container">
                                <div id="home" class="card p-2">
                                    <div class="qr_code d-sm-flex justify-content-between align-items-center p-2">
                                        <i class="bi bi-qr-code"></i>
                                        <h6 class="mt-2 ms-sm-4">Scan this QR Code to save our contact details</h6>
                                    </div>
                                    <div class="contact_detail p-2">
                                        <div class="name d-flex mb-3">
                                            <i class="bi bi-person-fill pe-2"></i>
                                            <h6 class="mb-0">Mamta Nandurkar</h6>  
                                        </div>
                                        <div class="mail d-flex mb-3">
                                            <i class="bi bi-envelope-fill pe-2"></i>
                                            <h6 class="mb-0">mamtanandurkar@gmail.com</h6>  
                                        </div>
                                        <div class="phone d-flex mb-3">
                                            <i class="bi bi-telephone-fill pe-2"></i>
                                            <h6 class="mb-0">+91 9876543214</h6>  
                                        </div>
                                        <div class="add d-flex mb-3">
                                            <i class="bi bi-geo-alt-fill pe-2"></i>
                                            <h6 class="mb-0">165, norway building, IT park nagpur </h6>
                                        </div>  
                                    </div>
                                </div>    
                            </div>    
                        </div>
                    </div>     
                </div> 
            </div> 
            {{--banner and card end--}}
            
            <div class="container">
                <div class="card_inside_container mt-4">
                    {{--About Us start--}}
                    <div id="about_us3" class="about_us3">
                      <h2 class="pb-4">About Us</h2> 
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-5 col-lg-5">
                                <div class="about_us_img">
                                    <img src="{{asset('assets/front/images/v_cards/about_us3.jpg')}}" >    
                                </div>
                            </div>   
                            <div class="col-12 col-sm-6 col-md-7 col-lg-7">
                                <div class="about_us_content mt-2 mt-sm-0">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
                                </div>    
                            </div>
                        </div>   
                    </div>
                    {{--About US end--}}
                    {{--Services  start--}}
                    <div id="service3" class="service">
                        <h2 class="pt-5">Service We Offer</h2> 
                        <div class="card p-4 mt-3 mb-5">
                            <h3>Heading</h3>    
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>    
                        </div>      
                    </div>
                    {{--Services  end--}}
                </div>
            </div>
            {{--footer start--}}
	        <div class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <ul class="my-3">
                                <li><i class="bi bi-facebook"></i></li>
                                <li><i class="bi bi-whatsapp"></i></li>
                                <li><i class="bi bi-instagram"></i></li>
                                <li><i class="bi bi-linkedin"></i></li>
                                <li><i class="bi bi-twitter"></i></li>
                            </ul>
                        </div>   
                    </div>   
                </div>
            </div>  
            {{--footerend--}}
        </section>
        <script src="{{ asset('assets/front/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script>
        $(function () {
      var link = $(".navbar a.dot");

      // Move to specific section when click on menu link
      link.on("click", function (e) {
        var target = $($(this).attr("href"));
        $("html, body").animate(
          {
            scrollTop: target.offset().top
          },
          600
        );
        $(this).addClass("active");
        e.preventDefault();
      });

      // Run the scrNav when scroll
      $(window).on("scroll", function () {
        scrNav();
      });

      // scrNav function
      // Change active dot according to the active section in the window
      function scrNav() {
        var sTop = $(window).scrollTop();
        $("section").each(function () {
          var id = $(this).attr("id"),
            offset = $(this).offset().top - 1,
            height = $(this).height();
          if (sTop >= offset && sTop < offset + height) {
            link.removeClass("active");
            $(".navbar")
              .find('[data-scroll="' + id + '"]')
              .addClass("active");
          }
        });
      }
      scrNav();
    });

</script>
    </body>
</html>