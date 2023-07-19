<li class="{{ Request::is('employee/dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('employee.dashboard') }}">
        <i class="fntlo icon-dashboard"></i>
        <span>{{ __('Dashboard') }}</span>
    </a>
</li>

<li class="{{ Request::is('employee/share-links') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('employee.shareLinks') }}">
        <i class="fntlo icon-make-and-share"></i>
        <span>{{ __('Send Challenge') }}</span>
    </a>
</li>
