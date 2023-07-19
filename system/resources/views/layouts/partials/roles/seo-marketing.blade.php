<li class="{{ Request::is('seo/seo*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('seo.seo.index') }}">
        <i class="flaticon-member"></i>
        <span>{{ __('SEO') }}</span>
    </a>
</li>

<li class="dropdown {{ Request::is('admin/page*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="flaticon-pricing"></i> <span>{{ __('Pages') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link {{ Request::is('admin/page/create') ? 'active' : '' }}" href="{{ route('admin.page.create') }}">
                {{ __('Create') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('admin/page') ? 'active' : '' }}" href="{{ route('admin.page.index') }}">
                {{ __('All Pages') }}
            </a>
        </li>
    </ul>
</li>


<li class="dropdown {{ Request::is('seo/blog*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="flaticon-pricing"></i> <span>{{ __('Blogs') }}</span>
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

<li class="dropdown {{ Request::is('admin/article*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="flaticon-pricing"></i> <span>{{ __('Articles') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link {{ Request::is('admin/article/create') ? 'active' : '' }}" href="{{ route('admin.article.create') }}">
                {{ __('Create') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('admin/article') ? 'active' : '' }}" href="{{ route('admin.article.index') }}">
                {{ __('All Articles') }}
            </a>
        </li>
        <li>
            <!--<a class="nav-link {{ Request::is('admin/article/setting') ? 'active' : '' }}" href="#">-->
            <a class="nav-link {{ Request::is('admin/article/setting') ? 'active' : '' }}" href="{{ route('admin.articles.settings') }}">
                {{ __('Settings') }}
            </a>
        </li>
    </ul>
</li>

<li class="dropdown {{ Request::is('admin/ebook*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="flaticon-pricing"></i> <span>{{ __('Ebooks') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link {{ Request::is('admin/ebook/create') ? 'active' : '' }}" href="{{ route('admin.ebook.create') }}">
                {{ __('Create') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('admin/ebook') ? 'active' : '' }}" href="{{ route('admin.ebook.index') }}">
                {{ __('All Ebooks') }}
            </a>
        </li>
        {{-- <li>
            <a class="nav-link {{ Request::is('admin/ebook/setting') ? 'active' : '' }}" href="{{ route('admin.ebooks.settings') }}">
                {{ __('Settings') }}
            </a>
        </li> --}}
    </ul>
</li>


<li class="{{ Request::is('seo/marketing') ? 'active' : '' }}">
  <a class="nav-link" href="{{ route('seo.marketing.index') }}">
   <i class="flaticon-megaphone"></i> <span>{{ __('Marketing Tools') }}</span>
  </a>
</li>


<li class="{{ Request::is('admin/docscategories*') ? 'active' : '' }}">
    <a class="nav-link {{ Request::is('admin/docscategories') ? 'active' : '' }}"
        href="{{ route('admin.docscategories.index') }}">
        <i class="fntlo icon-superadmin_blogs"></i>
        <span>{{ __('Document Category') }}</span>
    </a>
</li>

<li class="dropdown {{ Request::is('admin/documentation*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fntlo icon-superadmin_documentations"></i> <span>{{ __('Documentaions') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link {{ Request::is('admin/documentation/create') ? 'active' : '' }}"
                href="{{ route('admin.documentation.create') }}">
                {{ __('Create Documentaion') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('admin/documentation') ? 'active' : '' }}"
                href="{{ route('admin.documentation.index') }}">
                {{ __('All Documentaions') }}
            </a>
        </li>
    </ul>
</li>

<li class="{{ Request::is('admin/frontendsearch') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.frontendsearch.index') }}">
     <i class="flaticon-megaphone"></i> <span>{{ __('Frontend Search') }}</span>
    </a>
  </li>

