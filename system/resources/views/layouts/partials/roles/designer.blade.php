<li class="{{ Request::is('designer/dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('designer.dashboard') }}">
        <i class="fntlo icon-dashboard"></i>
        <span>{{ __('Dashboard') }}</span>
    </a>
</li>

<li class="{{ Request::is('designer/templates*') ? 'active' : '' }}">
    <a class="nav-link {{ Request::is('designer/templates') ? 'active' : '' }}"
        href="{{ route('designer.templates.index') }}">
        <i class="fntlo icon-subscription"></i>
        <span>{{ __('Templates') }}</span>
    </a>
</li>

<li class="{{ Request::is('designer/vcards*') ? 'active' : '' }}">
    <a class="nav-link {{ Request::is('designer/vcards') ? 'active' : '' }}"
        href="{{ route('designer.vcards.index') }}">
        <i class="fntlo icon-web-pages"></i>
        <span>{{ __('Business Vcard') }}</span>
    </a>
</li>