<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Page Meta -->
    @include('layouts.front.meta')
    <!-- Page CSS, JS & Other Links -->
    @include('layouts.front.link')

    <style type="text/css">
        .background{
                position: relative;
                width: 100%;
                background: #FFF;
                border-radius: 8px;
                padding: 10px;
        }
        .background::before{
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background:/*var(--color-thm-shd);*/#D3D3D3;
            opacity: 0.3;
            z-index: 1;
            transform: rotate(180deg);
            border-radius: 8px;
        }
        .img-use img{
            z-index: 3;
            position: relative;
        }
        .text_section .h1{
            color: #ff0000;
        }    
        .background_inner{

            position: relative;
            z-index: 2;
            padding: 3rem;
        }

        @media (max-width: 575px){
            .background_inner{
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <section id="faqs">
        <div class="py-5">
          <!--   Logo section -->
            <div class="container">
                <div class="mb-5">
                    <a href="{{ url('') }}" >
                        <img src="{{ asset('assets/front/images/logo-dark.svg') }}" class="main_logo" alt="MouthPublicity.io">
                    </a>
                </div>

            <div class="background">
                <div class="background_inner">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-md-6 text_section ps-lg-5">
                           <h3 class="h1 fw-bold text-uppercase_">Oops...</h3> 
                           <h2>Payment Failed</h2>
                           <p>Your transcation has failed due to some technical error, Please try Again.</p>
                           <button type="button" class="btn btn-theme px-4 btn-sm" onclick="window.location.href = @auth'{{ route('business.plan') }}'@else'{{ route('pricing') }}'@endauth">Try Again</button>
                        </div>
                        <div class="col-xl-5 col-md-6 img-use">
                            <div class="mt-4 mt-md-0">
                                <img src="{{ asset('assets/front/images/payment-error.png') }}" class="w-100 img-fluid" alt="Payment Error">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>

        </div>
    </section>

    @include('layouts.front.scripts')
    <script type="text/javascript">
        @auth
            $(document).ready(function(){
                window.setTimeout( function(){
                    window.location = "{{ route('business.plan') }}";
                }, 5000 );
            });
        @else
            $(document).ready(function(){
                window.setTimeout( function(){
                    window.location = "{{ route('pricing') }}";
                }, 5000 );
            });
        @endauth
    </script>
</body>
</html>