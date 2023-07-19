<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Track Shares</title>

    <!-- Bootstrap 5 -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/front/vendor/bootstrap/css/bootstrap.min.css') }}" media="all"> --}}
    @include('layouts.front.link')

    <style>
        :root{
            --c-prime: #5D98DE;
            --f-global:'Roboto Condensed', sans-serif;
            --background-light: #F7F7F7;
        }
        body{
            font-family: var(--f-global);
            font-size: 1rem;
            background-color: var(--bs-light);
        }
        .nav-link{
            cursor: pointer;
        }
        .offer_card,
        .user_card,
        .bl_card{
            position: relative;
            background-color: #FFF;
            border-radius: 10px;
            overflow: hidden;
            width: 100%;
            max-width: 26rem;
            /* margin: 0 auto; */
            margin-bottom: 1.5rem;
        }
        .offer_card .img,
        .offer_card .title{
            position: relative;
            width: 100%;
        }
        .offer_card .img > .img_thumb{
            position: relative;
            width: 100%;
            padding-bottom: 60%;
            background-color: #F2F2F2;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-image: url('../images/no-preview.jpg');
        }
        .offer_card .title,
        .offer_card .info{
            padding: 10px 15px;
            text-align: center;
        }
        .offer_card .title h3{
            /* font-size: 1.5rem; */
            color: var(--c-prime);
            font-weight: bold;
            margin-bottom: 0px;
        }
        .offer_card .analytics .anlt_colm{
            text-align: center;
        }
        .offer_card .analytics .col-4:not(:first-child) .anlt_colm{
            border-left: 1px solid rgba(255, 255, 255, 0.3);
        }
        .offer_card .analytics .anlt_colm .head{
            font-size: 12px;
            margin-bottom: .5rem;
        }
        .offer_card .analytics .anlt_colm .anlt_data{
            margin-bottom: 0px;
        }

        .offer_card .share_option,
        .offer_card .business_option{
            padding: 10px 15px;
        }
        .offer_card .link_small{
            font-size: 12px;
            text-decoration: underline;
        }

        .dashed-diveder{
            position: relative;
            margin: 0 15px;
            width: calc(100% - 20px);
            border-bottom: 1px dashed rgba(0, 0, 0, 0.1);
        }

        .business_logo{
            height: 48px;
        }
        .logo_footer{
            color: var(--c-prime);
            font-weight: 600;
            font-style: italic;
            font-size: 14px;
            text-transform: uppercase;
        }
        .smallest{
            font-size: 12px;
        }
        .small-links{
            font-size: 12px;
            text-decoration: underline;
            color: inherit;
        }


        .bl_card{
            max-width: 100%;
            margin-bottom: 1rem;
        }
        .bl_card a{
            text-decoration: none!important;
            color: inherit!important;
        }
        .bl_card .inner{
            padding: .5rem;
        }
        .bl_card .bl_logo{
            margin-right: 1rem
        }
        .bl_card .bl_logo > .bl_logo_thumb{
            position: relative;
            width: 60px;
            height: 60px;
            background-color: #f2f2f2;
            border-radius: 4px;
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain;
            background-image: url('../images/no-preview.jpg');
        }
        .bl_card .bl_analytics{
            padding: 0 1.5rem;
            border-left: 1px dashed rgba(0, 0, 0, 0.3);
        }
        .bl_card .bl_analytics > p{
            line-height: 1;
            font-style: italic;
        }
        .bl_card .bl_analytics > .status{
            font-weight: 500;
        }
        .bl_card .bl_analytics > .status.active{
            color: #06E406;
        }

    </style>
</head>
<body>
    
    <section id="user">
        <div class="container">


                <!--user Details -->
                <div class="my-4">
                    <div class="user_card shadow-sm rounded">
                    <div class="inner p-3">
                        <div class="">
                        <div class="">
                            <h6>Hello,</h6>
                            <h5 class="mb-0">95****0303</h5> <!-- Customer User Mobile Number -->
                        </div>
                        </div>
                    </div>
                    </div>
                </div>

                <hr>


                <div class="row">

                    <div class="col-xl-3_ col-lg-4 col-sm-6">
                        <div class="offer_card shadow-sm font-h1">
                            <div class="inner">
                              <!-- IMAGE THUMBNAIL -->
                              <div class="img mb-1">
                                <div class="img_thumb" style="background-image:url('cu_assets/images/offer-1.jpg');"></div>
                              </div>
                              <!-- TITLE -->
                              <div class="title pt-4">
                                <h3 class="font-6500 h6 mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing</h3>
                              </div>
                              <!-- INFORMATION DATA -->
                              <div class="info">
                                <p class="mb-0 font-small font-300">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</p>
                              </div>

                            <!-- ANALYTICS DATA -->
                            <div class="analytics bg-secondary text-white">
                                <div class="p-2">
                                <div class="row mx-0">
                                    <div class="col-4 px-0">
                                    <div class="anlt_colm">
                                        <!-- counts by Business user -->
                                        <p class="head">Required</p>
                                        <h4 class="anlt_data">1000</h4>
                                    </div>
                                    </div>
                                    <div class="col-4 px-0">
                                    <div class="anlt_colm">
                                        <!-- total counts achieved by customer user -->
                                        <p class="head">Total Counts</p>
                                        <h4 class="anlt_data">635</h4>
                                    </div>
                                    </div>
                                    <div class="col-4 px-0">
                                    <div class="anlt_colm">
                                        <!-- persentage of counts -->
                                        <p class="head">Complete</p>
                                        <h4 class="anlt_data fw-bold mb-0">63%</h4>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                
                              <div class="dashed-diveder"></div>
                
                              <!-- DATE & SHARE BUTTON -->
                              <div class="share_option">
                                <div class="d-flex justify-content-between align-items-center">
                                  <div class="flex-column">
                                    <div class="">
                                      <!-- Date of the Offer ends -->
                                      <p class="mb-0 lh-1">Offer Ends In</p>
                                      <p class="mb-0 fw-bold">30 SEP 2021</p>
                                    </div>
                                  </div>
                                  <div class="flex-column">
                                    <div class="">
                                      <!-- Share Button -->
                                      <a href="#" class="btn btn-md btn-success px-4">
                                        View & Share
                                      </a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                
                              <div class="dashed-diveder"></div>
                              <!-- VENDER INFO  -->
                              <div class="business_option">
                                <div class="d-flex justify-content-between_ align-items-center">
                                  <div class="flex-column me-3">
                                    <img src="cu_assets/images/no-preview.jpg" alt="Vender Name" class="business_logo" />
                                  </div>
                                  <div class="flex-column">
                                    <div class="">
                                      <p class="mb-0 font-600 lh-1">Business Name Here</p>
                                      <p class="mb-0 font-small text-muted">Your tag link here</p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                
                            </div>
                        </div>
                    </div>

                </div>


        </div>
    </section>


    <footer class="mt-5">
		<div class="py-2 bg-light">
			<div class="container text-center">
				<div class="copyright">
					<p class="mb-0 text-dark">&copy; {{ date('Y') }} All rights reserved | Powered By 
                        <a href="https://logicinnovates.com/" target="_blank" class="brandname">
                        <span class="color-drk">Logic Innovates</span>
                        </a>
                    </p>
				</div>
			</div>
		</div>
	</footer>
</body>
</html>