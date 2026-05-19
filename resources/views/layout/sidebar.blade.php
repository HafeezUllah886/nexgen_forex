<div class="sidebar" id="sidebar">
    <!-- Logo -->
    <div class="sidebar-logo">
        <a href="{{ route('dashboard') }}" class="logo logo-normal">
            <img src="{{ asset('assets/img/icon_landscap.svg') }}" alt="Img">
        </a>
        <a href="{{ route('dashboard') }}" class="logo logo-white">
            <img src="{{ asset('assets/img/icon_landscap.svg') }}" alt="Img">
        </a>
        <a href="{{ route('dashboard') }}" class="logo-small">
            <img src="{{ asset('assets/img/icon.svg') }}" alt="Img">
        </a>
        <a href="{{ route('dashboard') }}" class="logo-small-white">
            <img src="{{ asset('assets/img/icon.svg') }}" alt="Img">
        </a>
        <a id="toggle_btn" href="javascript:void(0);">
            <i data-feather="chevrons-left" class="feather-16"></i>
        </a>
    </div>
    <!-- /Logo -->

    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li {{ request()->routeIs('dashboard') ? 'class=active' : '' }}>
                    <a href="{{ route('dashboard') }}"><i
                            class="ti ti-layout-grid fs-16 me-2"></i><span>{{ __('messages.dashboard') }}</span></a>
                </li>
                <li>
                    <a href="{{ route('transactions.create') }}" target="nexgen_create_transaction"
                        onclick="window.open(this.href, 'nexgen_create_transaction', 'width=1600,height=900,noopener,noreferrer,scrollbars=yes,resizable=yes'); return false;">
                        <i class="ti ti-plus fs-16 me-2"></i><span>{{ __('messages.create_transaction') }}</span>
                    </a>
                </li>
                <li {{ request()->routeIs('transactions.history') ? 'class=active' : '' }}>
                    <a href="{{ route('transactions.history') }}"><i
                            class="ti ti-history fs-16 me-2"></i><span>{{ __('messages.transaction_history') }}</span></a>
                </li>
                <li {{ request()->routeIs('accounts.index') ? 'class=active' : '' }}>
                    <a href="{{ route('accounts.index') }}"><i
                            class="ti ti-wallet fs-16 me-2"></i><span>{{ __('messages.accounts') }}</span></a>
                </li>
                <li {{ request()->routeIs('reports') ? 'class=active' : '' }}>
                    <a href="{{ route('reports') }}"><i
                            class="ti ti-chart-bar fs-16 me-2"></i><span>{{ __('messages.reports') }}</span></a>
                </li>
                <li class="menu-title"><span>{{ __('messages.settings') }}</span></li>
                <li {{ request()->routeIs('profile') ? 'class=active' : '' }}>
                    <a href="{{ route('profile') }}"><i
                            class="ti ti-user fs-16 me-2"></i><span>{{ __('messages.profile') }}</span></a>
                </li>
                <li {{ request()->routeIs('users.index') ? 'class=active' : '' }}>
                    <a href="{{ route('users.index') }}"><i
                            class="ti ti-users fs-16 me-2"></i><span>{{ __('messages.users') }}</span></a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="document.getElementById('logout-form').submit()"><i
                            class="ti ti-logout fs-16 me-2"></i><span>{{ __('auth.logout') }}</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
