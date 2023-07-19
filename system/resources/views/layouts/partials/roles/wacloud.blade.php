<li class="{{ Request::is('wacloud/dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('wacloud.dashboard') }}">
        <i class="fntlo icon-dashboard"></i>
        <span>{{ __('Dashboard') }}</span>
    </a>
</li>
