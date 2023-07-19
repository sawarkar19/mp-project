<li class="{{ Request::is('account/dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('account.dashboard') }}">
        <i class="fntlo icon-dashboard"></i>
        <span>{{ __('Dashboard') }}</span>
    </a>
</li>
{{-- Users  --}}
<li class="{{ Request::is('account/user') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('account.user') }}">
        <i class="fntlo icon-employee"></i>
        <span>{{ __('Users') }}</span>
    </a>
</li>

{{-- reports  --}}
<li class="{{ Request::is('account/report') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('account.report') }}">
        <i class="fntlo icon-articles"></i>
    <span>{{ __('Reports') }}</span>
    </a>
</li>

{{-- export reports  --}}
<li class="{{ Request::is('account/export-report') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('account.exportReport') }}">
        <i class="fntlo icon-articles"></i>
    <span>{{ __('Export Reports') }}</span>
    </a>
</li>

{{-- Coupons  --}}
<li class="{{ Request::is('account/coupons') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('account.coupons') }}">
        <i class="fntlo icon-coupons"></i>
        <span>{{ __('Coupons') }}</span>
    </a>
</li>
{{-- SETTINGS  --}}
<li class="{{ Request::is('account/payment-geteway*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('account.settings') }}">
        <i class="fntlo icon-payment-gateway"></i>
        <span>{{ __('Payment Gateways') }}</span>
    </a>
</li>
{{-- Profile  --}}
<li class="{{ Request::is('account/user-credit-payment*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('account.userCreditPayment') }}">
        <i class="fntlo icon-employee"></i>
    <span>{{ __('Free User Payments') }}</span>
    </a>
</li>