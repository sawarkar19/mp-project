<li class="{{ Request::is('business/partner') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('business.partner.index') }}">
        <i class="fntlo icon-dashboard"></i>
        <span>{{ __('Payments') }}</span>
    </a>
</li>
<li class="{{ Request::is('business/partner/payment-links*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('business.partner.paymentLinks') }}">
        <i class="fntlo icon-payments"></i>
        <span>{{ __('Payment Links') }}</span>
    </a>
</li>
<li class="{{ Request::is('business/partner/users*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('business.partner.userList') }}">
        <i class="fntlo icon-contacts"></i>
        <span>{{ __('Users') }}</span>
    </a>
</li>
<li class="{{ Request::is('business/partner/transactions*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('business.partner.transactionHistory') }}">
        <i class="fntlo icon-payments"></i>
        <span>{{ __('Transactions') }}</span>
    </a>
</li>
