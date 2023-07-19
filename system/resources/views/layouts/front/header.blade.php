<header id="MainMenu">
    <button id="menu-btn">
        <!-- <img src="{{ asset('assets/front/images/menu-curve-btn.svg') }}" class="menu-btn-img" alt="Menu"> -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 59.94 247.9">
            <defs>
                <style>.menu-btn-svg-1{fill: var(--color-thm-lth);}</style>
                <linearGradient id="theme-gradient" x2="0.35" y2="1">
                    <stop offset="0%" stop-color="var(--color-thm-lth)" />
                    <stop offset="100%" stop-color="var(--color-thm-drk)" />
                </linearGradient>
            </defs>
            <g id="Layer_2" data-name="Layer 2"><g id="OBJECTS"><path class="menu-btn-svg-1" d="M59.94,0V247.9a82.4,82.4,0,0,0-31.2-64.79A75.13,75.13,0,0,1,0,124H0A75.11,75.11,0,0,1,28.73,64.8,82.41,82.41,0,0,0,59.94,0Z"/></g></g>
        </svg>
    </button>
    <nav class="">
        <div class="scroll-head">
            <div class="menu-inner-data">
                <ul class="menus">
                    <li class="nav-item">
                        <a href="{{ url('') }}" class="nav-link">
                            <i class="bi bi-house-door-fill nav_icon"></i>
                            <span class="nav_name">Home</span>
                        </a>
                    </li>
                    <li class="nav-item">

                        @auth
                            @if(Auth::user()->pass_token == '')
                                <a href="{{ url('signin') }}" class="nav-link">
                                    <i class="bi bi-person-circle nav_icon"></i>
                                    <span class="nav_name">Dashboard</span>
                                </a>
                            @else
                                <a href="{{ url('generate-password?token='.Auth::user()->pass_token) }}" class="nav-link">
                                    <i class="bi bi-person-circle nav_icon"></i>
                                    <span class="nav_name">Dashboard</span>
                                </a>
                            @endif
                        @else
                            <a href="{{ url('signin') }}" class="nav-link">
                                <i class="bi bi-person-circle nav_icon"></i>
                                <span class="nav_name">Login / Register</span>
                            </a>
                        @endauth

                    </li>
                    <li class="nav-item">
                        <a href="{{ url('about-us') }}" class="nav-link">
                            <i class="bi bi-info-circle-fill nav_icon"></i>
                            <span class="nav_name">About Us</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('features')}}" class="nav-link">
                            <i class="bi bi-x-diamond-fill nav_icon"></i>
                            <span class="nav_name">Features</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        @auth

                            @php

                                $user_role = Auth::user()->role_id;
                                $url = '';
                                if($user_role == 2){
                                    $url = url('/business/subscriptions/plans');
                                }

                                if($user_role == 1){
                                    $url = url('/admin/dashboard');
                                }

                                if($user_role == 3){
                                    $url = url('/employee/dashboard');
                                }

                                if($user_role == 4){
                                    $url = url('/seo/seo');
                                }

                                if($user_role == 5){
                                    $url = url('/account/dashboard');
                                }

                                if($user_role == 6){
                                    $url = url('/seomanager/seo');
                                }

                            @endphp

                            <a href="{{ $url }}" class="nav-link">
                                <i class="bi bi-cash-stack nav_icon"></i>
                                <span class="nav_name">Pricing</span>
                            </a>
                        @else
                            <a href="{{ url('pricing') }}" class="nav-link">
                                <i class="bi bi-cash-stack nav_icon"></i>
                                <span class="nav_name">Pricing</span>
                            </a>
                        @endauth
                        
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('why-openlink') }}" class="nav-link">
                            <i class="bi bi-question-diamond-fill"></i>
                            <span class="nav_name">Why MouthPublicity.io</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('blogs') }}" class="nav-link">
                            <i class="bi bi-pen"></i>
                            <span class="nav_name">Blogs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('articles') }}" class="nav-link">
                            <i class="bi bi-newspaper"></i>
                            <span class="nav_name">Articles</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('faqs') }}" class="nav-link">
                            <i class="bi bi-patch-question-fill nav_icon"></i>
                            <span class="nav_name">FAQs</span> 
                        </a>
                    </li>
                    
                    
                    <li class="nav-item">
                        <a href="{{ url('contact-us') }}" class="nav-link">
                            <i class="bi bi-person-lines-fill nav_icon"></i>
                            <span class="nav_name">Contact Us</span>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{ url('signin') }}" class="nav-link">
                            <i class="bi bi-person-plus-fill nav_icon"></i>
                            <span class="nav_name">Sign Up</span>
                        </a>
                    </li> --}}
                    
                </ul>
            </div>
        </div>
    </nav>
</header>