<li class="{{ Request::is('support/dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('support.dashboard') }}">
        <i class="fntlo icon-dashboard"></i>
        <span>{{ __('Dashboard') }}</span>
    </a>
</li>
<li class="{{ Request::is('support/userList') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('support.userList') }}">
        <i class="fntlo icon-employee"></i>
        <span>{{ __('Users') }}</span> 
    </a>
</li>
