<li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="fntlo icon-dashboard"></i>
        <span>{{ __('Dashboard') }}</span>
    </a>
</li>
{{-- <li class="{{ Request::is('admin/order*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.order.index') }}">
        <i class="flaticon-note"></i>
        <span>{{ __('Subscriptions') }}</span>
    </a>
</li> --}}

{{-- <li class="dropdown {{ Request::is('admin/plan*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fntlo icon-ebook"></i> <span>{{ __('Plans') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link {{ Request::is('admin/plan/create') ? 'active' : '' }}"
                href="{{ route('admin.plan.create') }}">
                {{ __('Create') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('admin/plan') ? 'active' : '' }}" href="{{ route('admin.plan.index') }}">
                {{ __('All Plans') }}
            </a>
        </li>
    </ul>
</li> --}}

{{-- <li class="dropdown {{ Request::is('admin/customer*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fntlo icon-subscription"></i> <span>{{ __('Subscribers') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link {{ Request::is('admin/customer/create') ? 'active' : '' }}"
                href="{{ route('admin.customer.create') }}">
                {{ __('Create') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('admin/customer') ? 'active' : '' }}"
                href="{{ route('admin.customer.index') }}">
                {{ __('All Subscribers') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('admin/transaction') ? 'active' : '' }}"
                href="{{ route('admin.customer.transactions') }}">
                {{ __('All Transactions') }}
            </a>
        </li>
    </ul>
</li> --}}

<li class="{{ Request::is('admin/customer') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.customer.index') }}">
        <i class="fntlo icon-contacts"></i>
        <span>{{ __('All Users') }}</span>
    </a>
</li>

<li class="{{ Request::is('admin/transactions') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.customer.transactions') }}">
        <i class="fntlo icon-dashboard"></i>
        <span>{{ __('All Transactions') }}</span>
    </a>
</li>
<li class="{{ Request::is('admin/deductions_list') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.deductionsList') }}">
        <i class="fntlo icon-dashboard"></i>
        <span>{{ __('Deductions') }}</span>
    </a>
</li> 
<li class="{{ Request::is('admin/festival') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.festival.create') }}">
        <i class="fntlo icon-dashboard"></i>
        <span>{{ __('Festivals') }}</span>
    </a>
</li>

{{-- <li class="dropdown {{ Request::is('admin/page*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fntlo icon-web-pages"></i> <span>{{ __('Pages') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link {{ Request::is('admin/page/create') ? 'active' : '' }}"
                href="{{ route('admin.page.create') }}">
                {{ __('Create') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('admin/page') ? 'active' : '' }}"
                href="{{ route('admin.page.index') }}">
                {{ __('All Pages') }}
            </a>
        </li>
    </ul>
</li> --}}

<li class="dropdown {{ Request::is('admin/blog*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fntlo icon-superadmin_blogs"></i> <span>{{ __('Blogs') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link {{ Request::is('admin/blog/create') ? 'active' : '' }}"
                href="{{ route('admin.blog.create') }}">
                {{ __('Create') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('admin/blog') ? 'active' : '' }}"
                href="{{ route('admin.blog.index') }}">
                {{ __('All Blogs') }}
            </a>
        </li>
        <li>
            <!--<a class="nav-link {{ Request::is('admin/blog/setting') ? 'active' : '' }}" href="#">-->
            <a class="nav-link {{ Request::is('admin/blog/setting') ? 'active' : '' }}"
                href="{{ route('admin.blogs.settings') }}">
                {{ __('Settings') }}
            </a>
        </li>
    </ul>
</li>

<li class="dropdown {{ Request::is('admin/article*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fntlo icon-articles"></i> <span>{{ __('Articles') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link {{ Request::is('admin/article/create') ? 'active' : '' }}"
                href="{{ route('admin.article.create') }}">
                {{ __('Create') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('admin/article') ? 'active' : '' }}"
                href="{{ route('admin.article.index') }}">
                {{ __('All Articles') }}
            </a>
        </li>
        <li>
            <!--<a class="nav-link {{ Request::is('admin/article/setting') ? 'active' : '' }}" href="#">-->
            <a class="nav-link {{ Request::is('admin/article/setting') ? 'active' : '' }}"
                href="{{ route('admin.articles.settings') }}">
                {{ __('Settings') }}
            </a>
        </li>
    </ul>
</li>

<li class="dropdown {{ Request::is('admin/ebook*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fntlo icon-ebook"></i> <span>{{ __('Ebooks') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link {{ Request::is('admin/ebook/create') ? 'active' : '' }}"
                href="{{ route('admin.ebook.create') }}">
                {{ __('Create') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('admin/ebook') ? 'active' : '' }}"
                href="{{ route('admin.ebook.index') }}">
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

<li class="dropdown {{ Request::is('admin/locations*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fntlo icon-location"></i> <span>{{ __('Locations') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link {{ Request::is('admin/locations/states') ? 'active' : '' }}"
                href="{{ route('admin.states.index') }}">
                {{ __('All States') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('admin/locations/cities') ? 'active' : '' }}"
                href="{{ route('admin.cities.index') }}">
                {{ __('All Cities') }}
            </a>
        </li>
    </ul>
</li>

<li class="{{ Request::is('admin/payment-geteway*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.payment-geteway.index') }}">
        <i class="fntlo icon-payment-gateway"></i>
        <span>{{ __('Payment Gateways') }}</span>
    </a>
</li>

<li class="{{ Request::is('admin/coupon*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.coupon.index') }}">
        <i class="fntlo icon-coupons"></i>
        <span>{{ __('Coupons') }}</span>
    </a>
</li>

{{-- <li class="dropdown {{ Request::is('admin/appearance*') ? 'active' : '' }}  {{ Request::is('admin/gallery*') ? 'active' : '' }} {{ Request::is('admin/menu*') ? 'active' : '' }} {{ Request::is('admin/seo*') ? 'active' : '' }}">
  <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="flaticon-settings"></i> <span>{{ __('Appearance') }}</span></a>
  <ul class="dropdown-menu">
    <li><a class="nav-link" href="{{ route('admin.appearance.show','header') }}">{{ __('Frontend Settings') }}</a></li>
    <li><a class="nav-link" href="{{ route('admin.menu.index') }}">{{ __('Menu') }}</a></li>
    <li><a class="nav-link" href="{{ route('admin.seo.index') }}">{{ __('SEO') }}</a></li>
    <li><a class="nav-link" href="{{ route('admin.page.index') }}">{{ __('Page Settings') }}</a></li>
  </ul>
</li> --}}

<li class="{{ Request::is('admin/marketing') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.marketing.index') }}">
        <i class="fntlo icon-ebook"></i> <span>{{ __('Marketing Tools') }}</span>
    </a>
</li>

<li class="{{ Request::is('admin/seo*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.seo.index') }}">
        <i class="fntlo icon-seo-analytics"></i>
        <span>{{ __('SEO') }}</span>
    </a>
</li>

<li
    class="dropdown {{ Request::is('admin/site-settings*') ? 'active' : '' }} {{ Request::is('admin/system-environment*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fntlo icon-settings"></i>
        <span>{{ __('Settings') }}</span></a>
    <ul class="dropdown-menu">

        <li><a class="nav-link" href="{{ route('admin.sites-scripts.index') }}">{{ __('Sites Script') }}</a></li>

        <li><a class="nav-link" href="{{ route('admin.site.settings') }}">{{ __('Site Settings') }}</a></li>

        <li><a class="nav-link" href="{{ route('admin.business.settings') }}">{{ __('Business Settings') }}</a></li>

        <li><a class="nav-link" href="{{ route('admin.site.environment') }}">{{ __('System Environment') }}</a></li>

    </ul>
</li>

<li class="{{ Request::is('admin/users*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.users.index') }}">
        <i class="fntlo icon-superadmin_blogs"></i>
        <span>{{ __('Admins') }}</span>
    </a>
</li>

<li class="{{ Request::is('admin/templates*') ? 'active' : '' }}">
    <a class="nav-link {{ Request::is('admin/templates') ? 'active' : '' }}"
        href="{{ route('admin.templates.index') }}">
        <i class="fntlo icon-subscription"></i>
        <span>{{ __('Templates') }}</span>
    </a>
</li>

{{-- <li class="{{ Request::is('admin/channels*') ? 'active' : '' }}">
    <a class="nav-link {{ Request::is('admin/channels') ? 'active' : '' }}"
        href="{{ route('admin.channels.index') }}">
        <i class="fntlo icon-superadmin_blogs"></i>
        <span>{{ __('Channels') }}</span>
    </a>
</li> --}}

<li class="dropdown {{ Request::is('admin/emailmanage*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fntlo icon-superadmin_blogs"></i> <span>{{ __('Email Management') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link {{ Request::is('admin/emailmanage/create') ? 'active' : '' }}"
                href="{{ route('admin.emailmanages.create') }}">
                {{ __('Create Email') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('admin/emailmanage') ? 'active' : '' }}"
                href="{{ route('admin.emailmanages.index') }}">
                {{ __('All Emails') }}
            </a>
        </li>
    </ul>
</li>

{{-- <li class="{{ Request::is('admin/plangroups') ? 'active' : '' }}">
    <a class="nav-link {{ Request::is('admin/plangroups') ? 'active' : '' }}"
        href="{{ route('admin.plangroups.index') }}">
        <i class="fntlo icon-subscription"></i>
        <span>{{ __('Plan Groups') }}</span>
    </a>
</li> --}}

<li class="{{ Request::is('admin/vcards*') ? 'active' : '' }}">
    <a class="nav-link {{ Request::is('admin/vcards') ? 'active' : '' }}"
        href="{{ route('admin.vcards.index') }}">
        <i class="fntlo icon-web-pages"></i>
        <span>{{ __('Business Vcard') }}</span>
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
        <i class="fntlo icon-coupons"></i> <span>{{ __('Documentaions') }}</span>
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
        {{--  <li>
            <!--<a class="nav-link {{ Request::is('admin/blog/setting') ? 'active' : '' }}" href="#">-->
            <a class="nav-link {{ Request::is('admin/blog/setting') ? 'active' : '' }}"
                href="{{ route('admin.blogs.settings') }}">
                {{ __('Settings') }}
            </a>
        </li>  --}}
    </ul>
</li>


<li class="dropdown {{ Request::is('admin/demo-accounts*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fntlo icon-subscription"></i> <span>{{ __('Demo Accounts') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link {{ Request::is('admin/demo-accounts/create') ? 'active' : '' }}"
                href="{{ route('admin.demo-accounts.create') }}">
                {{ __('Create Demo Account') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('admin/demo-accounts') ? 'active' : '' }}"
                href="{{ route('admin.demo-accounts.index') }}">
                {{ __('All Demo Accounts') }}
            </a>
        </li>
    </ul>
</li>

<li class="{{ Request::is('admin/frontendsearch') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.frontendsearch.index') }}">
     <i class="fntlo icon-ebook"></i> <span>{{ __('Frontend Search') }}</span>
    </a>
</li>

<li class="{{ Request::is('admin/contact-request') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.contacts-request.contactList') }}">
     <i class="fntlo icon-ebook"></i> <span>{{ __('Contacts Request') }}</span>
    </a>
</li>

<li class="dropdown {{ Request::is('admin/enterprises*') ? 'active' : '' }}">
    <a href="{{ route('admin.enterprises.index') }}" class="nav-link">
        <i class="fntlo icon-superadmin_blogs"></i> <span>{{ __('All Enterprises') }}</span>
    </a>
</li>
