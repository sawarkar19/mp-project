<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li>
                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            {{-- <li>
                <a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none">
                    <i class="fas fa-search"></i>
                </a>
            </li> --}}
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">

        @if (session('current_panel') == 'partner' && Auth::user()->is_enterprise == 1)
            <li class="mr-2 mr-sm-3">
                <a href="{{ route('business.dashboard') }}" class="btn btn-sm btn-primary px-3 "
                    style="box-shadow: none;" data-toggle="tooltip" title="Switch to Business Panel">
                    <i class="far fa-user d-none d-sm-inline-block"></i>
                    Business
                </a>
            </li>
        @endif

        @if (session('current_panel') == 'business' && Auth::user()->is_enterprise == 1)
            <li class="mr-2 mr-sm-3">
                <a href="{{ route('business.partner.index') }}" class="btn btn-sm btn-dark px-3 "
                    style="box-shadow: none;" data-toggle="tooltip" title="Switch to Partner Panel">
                    <i class="far fa-user d-none d-sm-inline-block"></i>
                    Partner
                </a>
            </li>
        @endif

        @if (Auth::user()->role_id == 2)
            @php
                $unread = 0;
                foreach ($notification_list as $notification) {
                    if ($notification->mark_read == '0') {
                        $unread++;
                    }
                }
            @endphp
            <li class="dropdown dropdown-list-toggle">
                <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg"
                    aria-expanded="false">
                    <i class="far fa-bell"></i>
                    @if ($unread >= 10)
                        <span class="badge-noti">9+</span>
                    @else
                        @if ($unread != 0)
                            <span class="badge-noti">{{ $unread }}</span>
                        @endif
                    @endif

                </a>
                <div class="dropdown-menu dropdown-list dropdown-menu-right">
                    <div class="dropdown-header">
                        Notifications
                    </div>

                    @if (count($notification_list) >= 1)

                        <div class="dropdown-list-content dropdown-list-icons noti-listing" style="overflow-y: auto;">

                            @foreach ($notification_list as $notification)
                                @if ($loop->iteration < 4)
                                    <a href="{{ route('business.viewNotification', $notification->id) }}"
                                        class="notification-item dropdown-item dropdown-item-unread @if ($notification->mark_read == '0') font-weight-bold bg-light @endif">
                                        <div class="dropdown-item-desc">
                                            <p class="mb-0">{{ $notification->subject }}</p>
                                            <small class="noti-message">{!! substr_replace($notification->message, '...', 100) !!}</small>
                                            <div class="time text-primary">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            @endforeach


                        </div>
                        <div class="dropdown-footer text-center">
                            <a href="{{ route('business.notifications') }}">View All <i
                                    class="fas fa-chevron-right"></i></a>
                        </div>
                    @else
                        <div class="dropdown-footer text-center">
                            <p>No new notifications!</p>
                        </div>
                        <div class="dropdown-footer text-center">
                            <a href="{{ route('business.notifications') }}">View All <i
                                    class="fas fa-chevron-right"></i></a>
                        </div>

                    @endif

                </div>
            </li>
        @endif

        <li class="dropdown" style="outline: 0px;">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user"
                style="outline: 0px;">
                <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                @if (Auth::user()->role_id == 2)
                    <a href="{{ route('business.profileSettings') }}" class="dropdown-item has-icon">
                        <i class="text-secondary fa fa-user"></i> {{ __('Profile') }}
                    </a>
                    <a href="{{ route('business.settings') }}" class="dropdown-item has-icon">
                        <i class="text-secondary fa fa-cogs"></i> {{ __('Settings') }}
                    </a>
                    <a href="{{ url('documentation/business-settings') }}" target="_blank"
                        class="dropdown-item has-icon">
                        <i class="text-secondary fa fa-book"></i> {{ __('Documentation') }}
                    </a>

                    <div class="dropdown-title font-weight-600" style="background: #f8f9fa;">ACCOUNTS</div>

                    <a href="{{ route('business.employee.index') }}" class="dropdown-item has-icon">
                        <i class="text-secondary fa fa-users"></i> {{ __('User Management') }}
                    </a>
                    <a href="{{ route('pricing') }}" class="dropdown-item has-icon">
                        <i class="text-secondary fa fa-credit-card"></i> {{ __('Recharge Now') }}
                    </a>
                    <a href="{{ route('business.planHistory') }}" class="dropdown-item has-icon">
                        <i class="text-secondary fa fa-file-invoice"></i> {{ __('Statements') }}
                    </a>
                @elseif(Auth::user()->role_id == 3)
                    <a href="{{ route('employee.profile.settings') }}" class="dropdown-item has-icon"><i
                            class="far fa-user"></i> {{ __('Profile') }}</a>
                    <a href="{{ route('pricing') }}" class="dropdown-item has-icon">
                        <i class="text-secondary fa fa-credit-card"></i> {{ __('Recharge Now') }}
                    </a>
                @elseif(Auth::user()->role_id == 5)
                    <a href="{{ route('account.profileSettings') }}" class="dropdown-item has-icon"><i
                            class="far fa-user"></i> {{ __('Profile') }}</a>
                @elseif(Auth::user()->role_id == 6)
                    <a href="{{ route('seomanager.profileSettings') }}" class="dropdown-item has-icon">
                        <i class="text-secondary fa fa-user"></i> {{ __('Profile') }}
                    </a>
                @elseif(Auth::user()->role_id == 7)
                    <a href="{{ route('support.profileSettings') }}" class="dropdown-item has-icon">
                        <i class="text-secondary fa fa-user"></i> {{ __('Profile') }}
                    </a>
                @elseif(Auth::user()->role_id == 8)
                    <a href="{{ route('designer.profileSettings') }}" class="dropdown-item has-icon">
                        <i class="text-secondary fa fa-user"></i> {{ __('Profile') }}
                    </a>
                @elseif(Auth::user()->role_id == 9)
                    <a href="{{ route('wacloud.profileSettings') }}" class="dropdown-item has-icon">
                        <i class="text-secondary fa fa-user"></i> {{ __('Profile') }}
                    </a>
                @else
                    <a href="{{ route('admin.profile.settings') }}" class="dropdown-item has-icon"><i
                            class="far fa-user"></i> {{ __('Profile') }}</a>
                @endif
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
                    class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="none">@csrf</form>
            </div>
        </li>
    </ul>
</nav>
