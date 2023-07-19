@extends('layouts.website')

@section('title', 'Documentation - MouthPublicity.io')
@section('description',
    'MouthPublicity.io powers word-of-mouth marketing campaigns for businesses of all shapes and sizes.
    Try it for free today!')
@section('keywords', 'why MouthPublicity.io, what is MouthPublicity.io, mission of MouthPublicity.io, about us MouthPublicity.io')
{{-- @section('image', '') --}}

@section('end_head')
    <style>
        .doc-sidebar .nav-link:focus,
        .active {
            color: #0b03e3 !important;
            font-weight: 600;
        }

        /* Sidebar */
        .doc-sidebar ul li a {
            text-decoration: none;
            color: #000;
            font-size: 15px;
        }

        .doc-sidebar .nav-link:hover {
            z-index: 1;
            color: #0b03e3 !important;
            background: #ffffff;
            box-shadow: 0 0.3rem 0.5rem rgb(0 0 0 / 5%);
        }

        .doc-sidebar ul li {
            list-style: none;
        }

        .doc-sidebar .active {
            border-radius: 0;
            box-shadow: none;
        }

        .sub-sidebar li .submenu {
            list-style: none;
            margin: 0;
            padding: 0;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .submenu li a {
            color: #5c5c5c !important;
        }

        .documentation-section {
            max-width: 1690px;
        }

        .sub-sidebar {
            width: 250px;
        }

        .page-content-heading .dropdown-item.active,
        .dropdown-item:focus {
            color: #0b03e3 !important;
            text-decoration: none;
            background-color: transparent !important;
        }
        .head-section{
            box-shadow: 0 0.5rem 1rem rgb(0 0 0 / 5%), inset 0 -1px 0 rgb(207 206 206 / 15%);
        }
        .content{
            margin-top: 27px;
        }
        .content ol{
            padding-left: 1rem;
        }
        .dropdown .dropdown-menu .dropdown-item:hover {
            color: #01c9d4;
            background: transparent;
            font-weight: normal;
        }
        .hr-sidebar{
            display: none;
        }
        .page-section section:not(:first-child) .content{
            margin-top: 38px;
        }

        @media(min-width: 768px) {
            .page-content-heading button {
                visibility: hidden;
            }

            .page-content-heading .dropdown .dropdown-menu {
                position: relative;
                margin-top: 0px;
                box-shadow: none;
            }

            .page-content-heading .dropdown .dropdown-menu::before {
                border-left: 0px;
                border-top: 0px;
            }

            .page-content-heading {
                position: sticky;
                top: 4rem;
                display: block !important;
                height: calc(100vh - 6rem);
                padding-left: 0.25rem;
                margin-left: -0.25rem;
                overflow-y: visible;
            }

            .doc-sidebar {
                position: sticky;
                top: 4rem;
                width: 250px;
                z-index: 600;
                display: block !important;
                height: 100vh;
                padding-left: 0.25rem;
                margin-left: -0.25rem;
                overflow-y: visible;
                background-color: #f4fdff;
            }
            .dropdown .dropdown-menu .dropdown-item {
                padding: 8px 0px;
                font-weight: normal;
            }
            .hr-sidebar{
                border-top: 2px solid;
                margin-top: 0px;
                display: block;
            }

        }

        @media(max-width: 767px) {
            #close_main_navigation {
                color: #000;
            }

            #navbarSupportedContent {
                position: fixed;
                left: -300px;
                top: 4rem;
                background: #f3f3f3;
                width: 210px;
                max-width: 100%;
                text-align: left;
                padding: 70px 15px 10px 15px;
                height: 100% !important;
                overflow-y: auto;
                overflow-x: hidden;
                box-shadow: 0 5px 30px 5px rgb(66 71 76 / 10%);
                transition: all 0.2s ease-in-out;
            }

            .page-content-heading {
                width: 200px;
                position: absolute;
                top: 8rem;
                right: 0;
                display: block !important;
                height: auto;
                padding-left: 0.25rem;
                margin-left: -0.25rem;
                overflow-y: visible;
            }

            #navbarSupportedContent.show {
                left: 0px;
            }

            .page-content-heading .dropdown-menu.show {
                background: rgb(237 237 237) !important;
                transform: translate3d(10px, 41px, 0px) !important;
            }

            .page-content-heading .dropdown-menu:before {
                background-color: #ededed;
                left: 4.5rem;
            }

            .doc-sidebar {
                max-width: 150px;
                position: relative;
                top: 0rem;
                height: auto;
                background-color: transparent;
            }

            .page-section {
                width: 100%;
                padding-left: 10px;
                padding-right: 10px;
            }

            .sub-sidebar li .submenu {
                padding-left: 0;
                padding-right: 0;
            }

            .submenu li a {
                padding-left: 0;
                padding-right: 0;
            }

            .onthispage-text {
                visibility: hidden;
            }

            .on-this-page .btn:hover,
            .btn:focus {
                border-color: transparent !important;
                background-color: transparent;
                color: #0b03e3;
            }

            .on-this-page .btn-check:active+.btn,
            .btn-check:checked+.btn,
            .btn.active,
            .btn.show,
            .btn:active {
                color: var(--bs-btn-active-color);
                background-color: transparent;
                border-color: transparent;
            }

            .doc-sidebar .navbar .navbar-toggler {
                font-size: 1.6rem;
                color: #000;
                font-weight: bolder;
            }

            .doc-sidebar {
                position: absolute;
                top: 5.3rem;
            }
        }
    </style>
@endsection

@section('content')
    <section id="documentation">
        <div class="pt-3">
            <!-- sidebar -->
            <div class="">
                <div class="container-fluid_">
                    <div class="head-section border-bottom pb-2">
                        <h4 class="fw-bold ps-5 ms-3 ms-md-0 ps-md-4">Documentation</h4>
                    </div>
                </div>
                <div class="documentation-section d-md-flex">
                    <div class="doc-sidebar">
                        <nav id="sidebarMenu" class="collapse d-block sub-sidebar navbar navbar-expand-md">
                            <div class="position-md-sticky">
                                <button class="navbar-toggler ms-3 pt-1" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="bi bi-list"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul class="ps-0 nav flex-column mx-0 mx-md-3 mt-4" id="nav_accordion">

                                        @foreach ($category as $cate)
                                            <li class="">
                                                <a href="{{ route('documentation', $cate->id) }}" class="px-1 nav-link">
                                                    <span>{{ $cate->name }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <a href="#" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                                        id="close_main_navigation" class="d-lg-none close-btn"><i
                                            class="bi bi-x-circle font-xlarge"></i> </a>
                                </div>
                            </div>
                        </nav>
                    </div>

                    <div class="flex-fill">
                        <div class="container-fluid my-md-3 mt-5 page-section ps-3 ps-md-4">
                            @if (count($documentation) >= 1)
                                @foreach ($documentation as $docs)
                                    <!-- Start Home Section -->
                                    <section id="#">
                                        <div class="content">

                                            <h5 class="fw-bold">{{ $docs->title }}</h5>
                                            <p>
                                                {!! $docs->content !!}
                                            </p>
                                            
                                            
                                        </div>
                                    </section>

                                    <!-- End Home Section -->
                                @endforeach
                            @else
                                <h3 style="padding:50px;text-align:center;clear: both;">Sorry, Content Not Found !</h3>
                            @endif

                        </div>
                    </div>

                    <div class="page-content-heading mt-3 px-3">
                        <div class="dropdown on-this-page text-end text-md-start">
                            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                On this page
                            </button>
                            <h6 class="fw-bold onthispage-text">On this page</h6>
                            <hr class="hr-sidebar">
                            <ul class="dropdown-menu d-md-block" style="border: 0;">

                                @foreach ($documentation as $docs)
                                    <li>
                                        <a class="dropdown-item page_content_sidebar"
                                            href="#">{{ $docs->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                {{-- <div class="documentation-section d-md-flex">
                    <div class="doc-sidebar">
                        <nav id="sidebarMenu" class="collapse d-block sub-sidebar navbar navbar-expand-md">
                            <div class="position-md-sticky">
                                <button class="navbar-toggler ms-3 pt-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="bi bi-list"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul class="ps-0 nav flex-column mx-3 mt-4" id="nav_accordion">

                                        <li class="">
                                            <a href="https://mouthpublicity.io/documentation/1" class="px-2 nav-link">
                                                <span>Business Settings</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="https://mouthpublicity.io/documentation/2" class="px-2 nav-link">
                                                <span>Steps to use Free Version</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="https://mouthpublicity.io/documentation/3" class="px-2 nav-link">
                                                <span>Steps to login from paid version</span>
                                            </a>
                                        </li>
                                                                                   
                                    </ul>
                                    <a href="#" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" id="close_main_navigation" class="d-lg-none close-btn"><i class="bi bi-x-circle font-xlarge"></i> </a>
                                </div>
                            </div>
                        </nav>
                    </div>

                    <div class="flex-fill">
                        <div class="container-fluid my-md-3 mt-5 page-section ps-4">
                            <!-- Start Home Section -->
                            <section id="#">
                                <div class="content">

                                    <h4 class="fw-bold">Business Details</h4>
                                    <p></p>
                                    <ol>
                                        <li>Enter the name of your business.</li>
                                        <li>You can upload the “<strong>logo</strong>” of your business.&nbsp; The image should be in&nbsp;PNG,&nbsp;JPG,&nbsp; or in the JPEG&nbsp;image format. The image should be within 1 MB because the Max file size&nbsp;is 1MB, and image width should be below 512px because the Max image width is&nbsp;512px.</li>
                                        <li>You can also add the “<strong>Tagline</strong>” and the “<strong>Website Link</strong>” of your business. Click on save details after you are done entering the details you want.</li>
                                    </ol>
                                    <p></p>
                                    
                                    
                                </div>
                            </section>
                            <!-- End Home Section -->
                            <!-- Start Home Section -->
                            <section id="#">
                                <div class="content">
                                    <h4 class="fw-bold">Business Contact</h4>
                                    <p></p>
                                    <ol>
                                        <li>Enter your business number and the business address. You can add 2 address lines i.e Address line 1 and Address line 2.</li>
                                        <li>Enter the Pin Code, City, State and the Country of your business.</li>
                                        <li>You can also add the <strong>“Google Map Link” </strong>so that your business is easily accessible to your customers.</li>
                                        <li>Click on <strong>“ Save Address”</strong> to save the entered details.</li>
                                    </ol>
                                    <p></p>
                                    
                                    
                                </div>
                            </section>
                            <!-- End Home Section -->              
                                                            
                        </div>
                    </div>

                    <div class="page-content-heading mt-3 px-3">
                        <div class="dropdown on-this-page text-end text-md-start">
                            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                On this page
                            </button>
                            <h6 class="fw-bold onthispage-text">On this page</h6>
                            <hr class="hr-sidebar" style=" border-top: 2px solid; margin-top: 0px;">
                            <ul class="dropdown-menu d-md-block" style="border: 0;">

                                <li>
                                    <a class="dropdown-item page_content_sidebar" href="#">Business Details
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item page_content_sidebar" href="#">Business Contact
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item page_content_sidebar" href="#">Billing Address
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item page_content_sidebar" href="#">Social  Links
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item page_content_sidebar" href="#">WhatsApp
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item page_content_sidebar" href="#">Message Route
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item page_content_sidebar" href="#">V-Card/Website
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>

    </section>
@endsection
@push('end_body')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.sub-sidebar .nav-link').forEach(function(element) {

                element.addEventListener('click', function(e) {

                    let nextEl = element.nextElementSibling;
                    let parentEl = element.parentElement;

                    if (nextEl) {
                        e.preventDefault();
                        let mycollapse = new bootstrap.Collapse(nextEl);

                        if (nextEl.classList.contains('show')) {
                            mycollapse.hide();
                        } else {
                            mycollapse.show();
                            // find other submenus with class=show
                            var opened_submenu = parentEl.parentElement.querySelector(
                                '.submenu.show');
                            // if it exists, then close all of them
                            if (opened_submenu) {
                                new bootstrap.Collapse(opened_submenu);
                            }
                        }
                    }
                }); // addEventListener
            }) // forEach
        });
    </script>

    <script>
        $(document).on('click', '.page_content_sidebar', function(e) {
            // target element id
            var id = $(this).attr('href');

            // target element
            var $id = $(id);
            if ($id.length === 0) {
                return;
            }


            e.preventDefault();


            var pos = $id.offset().top;


            $('body, html').animate({
                scrollTop: pos
            });
        });
    </script>
@endpush
