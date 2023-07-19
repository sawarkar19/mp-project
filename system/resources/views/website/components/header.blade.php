
    <header id="main-header">
        <nav class="navbar navbar-expand-lg bg-navbar">
            <div class="container">
                <a class="navbar-brand order-1" href="{{url('/')}}">
                    {{-- <img src="{{asset('assets/website/images/logos/logo-dark.svg')}}" alt="MouthPublicity" class="main-logo"> --}}
                   <img src="{{asset('assets/website/images/logos/logo-light.svg')}}" alt="MouthPublicity" class="main-logo" id="mainLogo">
                </a>
                <button class="navbar-toggler main-web-nav-tog order-4" data-bs-toggle="collapse" data-bs-target="#mainNavCollapse" aria-controls="mainNavCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="bi bi-list"></span>
                </button> 
                {{-- mob number --}}
                {{-- <div class="mob_number order-lg-3 order-2 me-3">
                    <a href="" class="text-white" style="text-decoration: none;">Call +91 788 788 2244</a>
                </div> --}}
                {{-- searchbar --}}
                <div class="order-lg-3 order-3 search_bar mx-3">
                    <div class='search-container'> 
                        <span><i class="bi bi-search search-toggle"></i></span>
                        <div class="search-block">
                            <form action="{{ route('searchResults') }}" method="GET" class="search-form">
                                @csrf
                                <span><i class="bi bi-arrow-left search-cancel"></i></span>
                                <input type="search" name="keyword" class="search-input" placeholder="Search here...">
                            </form>
                        </div>
                    </div>
                </div>    
                {{-- Authentication links --}}
                <div class="order-lg-4 order-2 d-none d-sm-inline-block">

                    @auth
                        @if(Auth::user()->pass_token == '')
                            <a href="{{ url('signin') }}" class="btn btn-sm btn-dark px-3 font-600">{{-- <i class="bi bi-person-circle nav_icon"></i> --}} Dashboard</a>
                        @else
                            <a href="{{ url('generate-password?token='.Auth::user()->pass_token) }}" class="btn btn-sm btn-primary-ol px-3 font-600">{{-- <i class="bi bi-person-circle nav_icon"></i> --}} Dashboard</a>
                        @endif
                    @else
                        <div class="btn-group bg-color-gradient" role="group" aria-label="Authentication">
                            <a href="{{ url('signin') }}" class="btn btn-sm btn-primary-ol_ text-white px-md-3 font-600">Login</a>
                            <a href="{{ url('signin?tab=register') }}" class="btn btn-sm btn-primary-ol_ text-white px-md-3 font-600">Register</a>
                        </div>
                    @endauth
                </div>
    
                 <div class="collapse website_nav navbar-collapse order-lg-2" id="mainNavCollapse">
        
                    <ul class="navbar-nav me-auto nav-dropdown">
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" id="productsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Products
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="productsDropdown">
                                <li><a class="dropdown-item" href="{{route('channels', 'instant-challenge')}}">Instant Challenge</a></li>
                                <li><a class="dropdown-item" href="{{route('channels', 'share-challenge')}}">Share Challenge</a></li>
                                <li><a class="dropdown-item" href="{{route('channels', 'social-post')}}">Social Post</a></li>
                                <li><a class="dropdown-item" href="{{route('channels', 'personalised-message')}}">Personalised Messaging</a></li>
                                <li><a class="dropdown-item" href="{{route('channels', 'messaging-api')}}">Messaging API</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/how-it-works') }}" class="nav-link">How it Works</a>
                        </li>
                        <li class="nav-item">
                            {{-- @auth
                                @php
                                $user_role = Auth::user()->role_id;
                                $pricing_url = '';
                                if($user_role == 2){$pricing_url = url('/business/subscriptions/plans');}
                                if($user_role == 1){$pricing_url = url('/admin/dashboard');}
                                if($user_role == 3){$pricing_url = url('/employee/dashboard');}
                                if($user_role == 4){$pricing_url = url('/seo/seo');}
                                if($user_role == 5){$pricing_url = url('/account/dashboard');}
                                if($user_role == 6){$pricing_url = url('/seomanager/seo');}
                                @endphp
    
                                <a href="{{ $pricing_url }}" class="nav-link">Pricing</a>
                            @else
                                <a href="{{ url('pricing') }}" class="nav-link">Pricing</a>
                            @endauth --}}

                            <a href="{{ url('pricing') }}" class="nav-link">Pricing</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" id="resourcesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Resources
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="resourcesDropdown">
                                <li><a class="dropdown-item" href="{{url('blogs')}}">Blogs</a></li>
                                <li><a class="dropdown-item" href="{{url('articles')}}">Articles</a></li>
                                <li><a class="dropdown-item" href="{{url('faqs')}}">FAQs</a></li>
                                {{-- <li><a class="dropdown-item" href="{{url('articles')}}">PR News</a></li> --}}
                                {{-- <li><a class="dropdown-item" href="{{url('/')}}">How To Guide</a></li> --}}
                                {{-- <li><a class="dropdown-item" href="{{url('/')}}">Documentation</a></li> --}}
                            </ul>
                        </li>
                        @auth
                        <li class="nav-item d-sm-none">
                            @if(Auth::user()->pass_token == '')
                            <a href="{{ url('signin') }}" class="nav-link">Dashboard</a>
                            @else
                            <a href="{{ url('generate-password?token='.Auth::user()->pass_token) }}" class="nav-link">Dashboard</a>
                            @endif
                        </li>
                        @else
                        <li class="nav-item d-sm-none">
                            <a href="{{ url('signin') }}" class="nav-link">Login</a>
                        </li>
                        <li class="nav-item d-sm-none">
                            <a href="{{ url('signin?tab=register') }}" class="nav-link">Register</a>
                        </li>
                        @endauth
                        {{-- <li>
                            <div class="btn-group bg-color-gradient" role="group" aria-label="Authentication">
                                <a href="{{ url('signin?req=demo') }}" class="btn btn-sm btn-primary-ol_ text-white px-md-3 font-600">Demo</a>
                            </div>
                        </li> --}}
                        
                    </ul>
                    {{-- collapse close button --}}
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#mainNavCollapse" id="close_main_navigation" class="d-lg-none close-btn"><i class="bi bi-x-circle font-xlarge"></i> </a>
                </div> 
                
            </div>
        </nav>
    </header>
