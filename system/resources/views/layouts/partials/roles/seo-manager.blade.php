    <li class="{{ Request::is('seomanager/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('seomanager.dashboard') }}">
            <i class="fntlo icon-dashboard"></i>
            <span>{{ __('Dashboard') }}</span>
        </a>
    </li>
    
    <li class="{{ Request::is('seomanager/seo*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('seomanager.seo.index') }}">
            <i class="fntlo icon-superadmin_blogs"></i>
            <span>{{ __('SEO') }}</span>
        </a>
    </li>

    <li class="{{ Request::is('seomanager/blog*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('seomanager.blog.index') }}">
            <i class="fntlo icon-superadmin_blogs"></i> <span>{{ __('Blogs') }}</span>
        </a>
    </li>
