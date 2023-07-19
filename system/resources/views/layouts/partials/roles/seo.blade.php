<li class="{{ Request::is('seo/dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('seo.dashboard') }}">
        <i class="fntlo icon-dashboard"></i>
        <span>{{ __('Dashboard') }}</span>
    </a>
</li>

<li class="{{ Request::is('seo/userList') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('seo.userList') }}">
        <i class="fntlo icon-employee"></i>
        <span>{{ __('Users') }}</span> 
    </a>
</li>

<li class="{{ Request::is('seo/seo*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('seo.seo.index') }}">
        <i class="fntlo icon-dashboard"></i>
        <span>{{ __('SEO') }}</span>
    </a>
</li>

<li class="dropdown {{ Request::is('seo/page*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fntlo icon-dashboard"></i></i> <span>{{ __('Pages') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link {{ Request::is('seo/page/create') ? 'active' : '' }}" href="{{ route('seo.page.create') }}">
                {{ __('Create') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('seo/page') ? 'active' : '' }}" href="{{ route('seo.page.index') }}">
                {{ __('All Pages') }}
            </a>
        </li>
    </ul>
</li>


<li class="dropdown {{ Request::is('seo/blog*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fntlo icon-dashboard"></i> <span>{{ __('Blogs') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link {{ Request::is('seo/blog/create') ? 'active' : '' }}" href="{{ route('seo.blog.create') }}">
                {{ __('Create') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('seo/blog') ? 'active' : '' }}" href="{{ route('seo.blog.index') }}">
                {{ __('All Blogs') }}
            </a>
        </li>
        <li>
            <!--<a class="nav-link {{ Request::is('seo/blog/setting') ? 'active' : '' }}" href="#">-->
            <a class="nav-link {{ Request::is('seo/blog/setting') ? 'active' : '' }}" href="{{ route('seo.blogs.settings') }}">
                {{ __('Settings') }}
            </a>
        </li>
    </ul>
</li>

<li class="dropdown {{ Request::is('seo/article*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fntlo icon-dashboard"></i> <span>{{ __('Articles') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link {{ Request::is('seo/article/create') ? 'active' : '' }}" href="{{ route('seo.article.create') }}">
                {{ __('Create') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('seo/article') ? 'active' : '' }}" href="{{ route('seo.article.index') }}">
                {{ __('All Articles') }}
            </a>
        </li>
        <li>
            <!--<a class="nav-link {{ Request::is('seo/article/setting') ? 'active' : '' }}" href="#">-->
            <a class="nav-link {{ Request::is('seo/article/setting') ? 'active' : '' }}" href="{{ route('seo.articles.settings') }}">
                {{ __('Settings') }}
            </a>
        </li>
    </ul>
</li>

<li class="dropdown {{ Request::is('seo/ebook*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fntlo icon-dashboard"></i> <span>{{ __('Ebooks') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link {{ Request::is('seo/ebook/create') ? 'active' : '' }}" href="{{ route('seo.ebook.create') }}">
                {{ __('Create') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('seo/ebook') ? 'active' : '' }}" href="{{ route('seo.ebook.index') }}">
                {{ __('All Ebooks') }}
            </a>
        </li>
        {{-- <li>
            <a class="nav-link {{ Request::is('seo/ebook/setting') ? 'active' : '' }}" href="{{ route('seo.ebooks.settings') }}">
                {{ __('Settings') }}
            </a>
        </li> --}}
    </ul>
</li>


<li class="{{ Request::is('seo/marketing') ? 'active' : '' }}">
  <a class="nav-link" href="{{ route('seo.marketing.index') }}">
    <i class="fntlo icon-dashboard"></i> <span>{{ __('Marketing Tools') }}</span>
  </a>
</li>


<li class="{{ Request::is('seo/docscategories*') ? 'active' : '' }}">
    <a class="nav-link {{ Request::is('seo/docscategories') ? 'active' : '' }}"
        href="{{ route('seo.docscategories.index') }}">
        <i class="fntlo icon-dashboard"></i>
        <span>{{ __('Document Category') }}</span>
    </a>
</li>

<li class="dropdown {{ Request::is('seo/documentation*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fntlo icon-dashboard"></i></i> <span>{{ __('Documentaions') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link {{ Request::is('seo/documentation/create') ? 'active' : '' }}"
                href="{{ route('seo.documentation.create') }}">
                {{ __('Create Documentaion') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('seo/documentation') ? 'active' : '' }}"
                href="{{ route('seo.documentation.index') }}">
                {{ __('All Documentaions') }}
            </a>
        </li>
    </ul>
</li>

<li class="{{ Request::is('seo/frontendsearch') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('seo.frontendsearch.index') }}">
        <i class="fntlo icon-dashboard"></i></i> <span>{{ __('Frontend Search') }}</span>
    </a>
  </li>

