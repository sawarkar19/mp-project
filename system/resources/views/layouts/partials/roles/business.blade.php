<li class="{{ Request::is('business/dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('business.dashboard') }}">
        <i class="fntlo icon-dashboard"></i>
        <span>{{ __('Dashboard') }}</span>
    </a>
</li>

<li class="{{ Request::is('business/design-offer') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('business.designOffer') }}">
        <i class="fntlo icon-design-offer"></i>
        <span>{{ __('Design Offer') }}</span>
    </a>
</li>

<li class="{{ Request::is('business/channels') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('business.channels') }}">
        <i class="fntlo icon-channels"></i>
        <span>{{ __('Create Challenges') }}</span>
    </a>
</li>

<li class="{{ Request::is('business/share-links') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('business.shareLinks') }}">
        <i class="fntlo icon-make-and-share"></i>
        <span>{{ __('Send Challenges') }}</span>
    </a>
</li>

<li class="{{ Request::is('business/contact*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('business.contactGroups') }}">
        <i class="fntlo icon-contacts"></i>
        <span>{{ __('Contacts') }}</span>
    </a>
</li>

<li class="{{ Request::is('business/reports') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('business.reports') }}">
        <i class="fntlo icon-reports"></i>
        <span>{{ __('Reports') }}</span>
    </a>
</li>

 
{{-- MAKE & SHARE  --}}
{{-- <li class="@if(stripos(Request::fullUrl(), 'type=MadeShare') !== FALSE) active @endif">
    <a class="nav-link" href="{{ route('business.future.index','type=MadeShare') }}">
        <i class="fntlo icon-make-and-share_1"></i>
        <span>{{ __('Make & Share') }}</span>
    </a>
</li> --}}

{{-- SOCIAL POSTS  --}}
{{-- <li class="{{ Request::is('business/social-posts*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('business.socialPosts') }}">
        <i class="fntlo icon-offrer"></i>
        <span>{{ __('Social Post') }}</span>
    </a>
</li> --}}

{{-- API  --}}
{{-- <li class="dropdown {{ Request::is('business/api-integration*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
    <i class="fntlo icon-api-integration"></i> <span>{{ __('API (Via WhatsApp)') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link  {{ Request::is('business/api-integration/keys*') ? 'active' : '' }}" href="{{ route('business.apiKeys') }}">
                {{ __('API Keys') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('business/api-integration/developer-docs*') ? 'active' : '' }}" href="{{ route('business.apiDocs') }}">
                {{ __('Developers Doc\'s') }}
            </a>
        </li>
    </ul>
</li> --}}

{{-- INSTANT OFFER  --}}
{{-- <li class="{{ Request::is('business/offers/instant*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('business.instant.index') }}">
        <i class="fntlo icon-instant_rewards"></i>
        <span>{{ __('Instant Challenge') }}</span>
    </a>
</li> --}}

{{-- FUTURE OFFER  --}}
{{-- <li class="dropdown {{ (Request::is('business/offers/future*') && stripos(Request::fullUrl(), 'type=MadeShare') === FALSE) ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fntlo icon-share-and-reward"></i>  <span>{{ __('Share Challenge') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link @if(stripos(Request::fullUrl(), 'type=PerClick') !== FALSE) active @endif" href="{{ route('business.future.index','type=PerClick') }}">
                {{ __('Cash Per Click') }}
            </a>
        </li>
        
        <li>
            <a class="nav-link @if(stripos(Request::fullUrl(), 'type=Fixed') !== FALSE) active @endif" href="{{ route('business.future.index','type=Fixed') }}">
                {{ __('Fixed Amount') }}
            </a>
        </li>
        <li>
            <a class="nav-link @if(stripos(Request::fullUrl(), 'type=Percentage') !== FALSE) active @endif" href="{{ route('business.future.index','type=Percentage') }}">
                {{ __('Percentage Discount') }}
            </a>
        </li>
    </ul>
</li> --}}

{{-- Redeem --}}
{{-- <li class="dropdown {{ Request::is('business/offer-redeem*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
    <i class="fntlo icon-superadmin_coupons_1"></i> <span>{{ __('Redeems') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link  {{ Request::is('business/offer-redeem/redeem*') ? 'active' : '' }}" href="{{ route('business.offerRedeem') }}">
                {{ __('Redeem Offer') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('business/offer-redeem/reports*') ? 'active' : '' }}" href="{{ route('business.redeemReports') }}">
                {{ __('Redeem Reports') }}
            </a>
        </li>
    </ul>
</li> --}}

{{-- EMPLOYEES  --}}
{{-- <li class="dropdown {{ Request::is('business/employee*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fntlo icon-employee_3"></i> <span>Employees</span>
    </a>
    <ul class="dropdown-menu">
        <li class="{{ Request::is('business/employee') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('business.employee.index') }}">
                {{ __('All Employees') }}
            </a>
        </li>
        <li class="{{ Request::is('business/employee/create') ? 'active' : '' }}">
            <a class="nav-link " href="{{ route('business.employee.create') }}">
                {{ __('Create Employee') }}
            </a>
        </li>
    </ul>
</li> --}}

{{-- CUSTOMERS  --}}
{{-- <li class="{{ Request::is('business/customer*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('business.customer.index') }}">
        <i class="fntlo icon-employee"></i>
        <span>{{ __('Customers') }}</span>
    </a>
</li> --}}

{{-- CUSTOMERS  --}}
{{-- <li class="dropdown {{ Request::is('business/customer*') ? 'active' : '' }} {{ Request::is('business/import') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fntlo icon-employee"></i> <span>Customers</span>
    </a>
    <ul class="dropdown-menu">
        <li class="{{ Request::is('business/customer') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('business.customer.index') }}">
                {{ __('All Customers') }}
            </a>
        </li>
        <li class="{{ Request::is('business/import') ? 'active' : '' }}">
            <a class="nav-link" href="{{route('business.customers.import')}}">
                {{ __('Import Customer') }}
            </a>
        </li>
    </ul>
</li> --}}

{{-- D2C POST  --}}
{{-- <li class="{{ Request::is('business/d2c-posts*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('business.waPosts') }}">
        <i class="fntlo icon-whats-app"></i>
        <span>{{ __('D2C Post') }}</span>
    </a>
</li> --}}

{{-- Personalised Messaging --}}
{{-- <li class="{{ Request::is('business/whatsapp-template*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('business.customWpTemplate') }}">
        <i class="fntlo icon-personalised-wish"></i>
        <span>{{ __('Personalised Messaging') }}</span>
    </a>
</li> --}}


{{-- <li class="{{ Request::is('business/subscriptions/plans') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('business.plan') }}">
        <i class="fntlo icon-payments"></i>
        <span>{{ __('Buy/Renew/Recharge') }}</span>
    </a>
</li> --}}

{{-- SUBSCRIPTIONS  --}}
{{-- <li class="dropdown {{ Request::is('business/subscriptions/subscribe') ? 'active' : '' }} {{ Request::is('business/subscriptions/history') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fntlo icon-subscription"></i> <span>{{ __('Subscriptions') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link  {{ Request::is('business/subscriptions/subscribe') ? 'active' : '' }}" href="{{ route('business.planSubscription') }}">
                {{ __('Subscribed') }}
            </a>
        </li>
        <li>
            <a class="nav-link {{ Request::is('business/subscriptions/history') ? 'active' : '' }}" href="{{ route('business.planHistory') }}">
                {{ __('History') }}
            </a>
        </li>
    </ul>
</li> --}}

{{-- Recharge  --}}
{{-- <li class="{{ Request::is('message-recharges*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('business.messageRecharge') }}">
        <i class="fntlo icon-recharge_1"></i>
        <span>{{ __('Recharge') }}</span>
    </a>
</li> --}}

{{-- SETTINGS  --}}
{{-- <li class="{{ Request::is('business/settings*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('business.settings') }}">
        <i class="fntlo icon-setting"></i>
        <span>{{ __('Business Settings') }}</span>
    </a>
</li> --}}