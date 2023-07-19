<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>V card</title>
        <link rel="stylesheet" href="{{ asset('assets/front/vendor/bootstrap/css/bootstrap.min.css') }}" media="all">
        <!-- <link rel="stylesheet" href="{{ asset('assets/front/vendor/bootstrap-icons/font/bootstrap-icons.css') }}" media="all"> -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Joan&family=Nuosu+SIL&family=Poppins:wght@400;500&display=swap');

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
            .card_inside_container h2, .card_inside_containe h3{
                font-family: Nuosu;
            }
            .card_inside_container p{
               font-family:  Poppins; 
            }
            .v_card_two .business_name{
                color: #2B303C;
                font-family: Nuosu;
            } 
            .banner_image img{
            	width: 400px;
            	max-width: 100%;
                margin: auto;
                border-radius: 6px;
            }
            .image_card_section .card{
            	width: 400px;
            	max-width: 100%;
            	margin: auto;
                border-style: none;
                box-shadow: 3px 3px 8px #00000038;
                position: relative;
                z-index: 3;
                top: -70px;
                font-family:  Poppins;
            } 
            .qr_code{
            	background-color: #2B303C;
            	color: #fff;
            } 
            .qr_code i::before{
                font-size: 120px;
            } 
           	.image_card_section::before{
           		content: '';
           		background: #F27724;
			    width: 100%;
			    height: 199px;
			    position: absolute;
			    z-index: 0;
			    bottom: 117px;
           	} 
            .banner_image{
            	position: relative;
            	z-index: 3;
            }  
            .services_section{
            	background-color: #2B303C;
            	color: #fff;
            }
            .services_number{
            	width: 70px;
			    height: 70px;
			    background-color: #fff;
			    border-radius: 50%;
			    /*padding: 11px 15px;*/
			    color: #2B303C;
			    margin: auto;
                line-height: 68px;

            } 
            .card_about{
            	background-color: #fff;
            	color: #2B303C;
            	box-shadow: 3px 3px 8px #00000038;
            	border-radius: 10px;
            	position: relative;
    			right: -72px;

            } 
            .about_us_img img{
            	width: 500px;
    			max-width: 100%;
                border-radius: 6px;
            } 
            .footer{
                background-color: #F27724;
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
            @media(max-width: 768px){
                .image_card_section .card {
                    top: 0px;
                }
                .card_about {
                    right: 0;
                }
                .logo_section{
                    text-align: center;
                }
                .services_heading h2{
                    text-align: center;
                }
                .banner_image img{
                    margin-top: 20px;
                }
            }

        </style>
    </head>
    <body>
        <section class="v_card v_card_two">
            <div class="container pb-5">
                {{--logo--}}
                <div class="card_inside_container logo_section pt-3">
	                <div class="logo">
	                    <img src="{{asset('assets/front/images/v_cards/logo2.png')}}" style="width: 80px;">
                    </div> 
                    <div class="business_name">
                        <h4 class="mb-0 mt-2">Eat & Treats</h4>
                        <p>Delight in every bite</p>
                    </div>
	            </div>  
	        </div>   
             {{--card and banner start--}} 
            <div class="image_card_section position-relative mb-5">
            	<div class="container">
            		<div class="card_inside_container">
            			<div class="row">
		            		<div class="col-12 col-sm-12 col-md-6 col-lg-6 order-2 order-md-1">
		            			<div class="banner_image text-center">
		            				<img src="{{asset('assets/front/images/v_cards/banner2.jpg')}}" >
		            			</div>
		            		</div>		
	            			<div class="col-12 col-sm-12 col-md-6 col-lg-6 order-1 order-md-2 ">
		            			<div class="card">
	                                <div class="qr_code d-flex justify-content-between align-items-center p-2 p-sm-4">
	                                    <i class="bi bi-qr-code"></i>
	                                    <h6 class="mt-2 ms-4">Scan this QR Code to save our contact details</h6>
	                                </div>
	                                <div class="contact_details p-2 p-sm-4">
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
             {{--card and banner end--}} 
             {{--services start--}} 
        	<div class="container">
        		<div class="card_inside_container services_heading">
        		 	<h2 class="mb-3">Sevices We Offer</h2>
        		</div>
        	</div>
        	<div class="services_section mb-5">
        		<div class="container">
        		 	<div class="card_inside_container">	 	
	            		<div class="row py-4">
	            			<div class="col-12 col-sm-12 col-md-4 col-lg-4 text-center pt-4">
	            				<h1 class="services_number mb-2">01</h1>
	            				<h3>Heading</h3>
	            				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit.</p>
	            			</div>	
	            			<div class="col-12 col-sm-12 col-md-4 col-lg-4 text-center pt-4">
	            				<h1 class="services_number mb-2">02</h1>
	            				<h3>Heading</h3>
	            				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit.</p>
	            			</div>
	            			<div class="col-12 col-sm-12 col-md-4 col-lg-4 text-center pt-4">
	            				<h1 class="services_number mb-2">03</h1>
	            				<h3>Heading</h3>
	            				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit.</p>
	            			</div>
	            		</div>	
            		</div>	
            	</div>
            </div>
             {{--services end--}} 
              {{--About uS start--}} 
        	<div class="container">
    		 	<div class="card_inside_container">
		            <div class="aboutus_section mb-5">
	        			<div class="row align-items-center">
	        				<div class="col-12 col-sm-12 col-md-6 col-lg-6 order-sm-2">
	        					<div class="about_us_img p-4">
	        					  <img src="{{asset('assets/front/images/v_cards/about_us2.jpg')}}">	
	        					</div>
	        				</div>
		            		<div class="col-12 col-sm-12 col-md-6 col-lg-6 order-sm-1">
		            			<div class="card_about p-3">
		            				<h2>About Us</h2> 
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>	
		            			</div>
		            		</div>	
	        			</div>
		        	</div>
		        </div>
            </div>   
            {{--About uS end--}} 
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
                    {{--footer end--}}
        </section>
        <script src="{{ asset('assets/front/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    </body>
</html>