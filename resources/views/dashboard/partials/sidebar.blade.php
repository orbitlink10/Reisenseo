@php
    $user = Auth::user();
    $active = function ($name) {
        return Route::currentRouteName() === $name ? ' active' : '';
    };
    $messagesCount = \App\Models\Chat::whereMessageRead(0)->whereMessageTo($user->id)->count();
@endphp

<aside class="rsd-sidebar" id="rsdSidebar" aria-label="Admin navigation">
    <a class="rsd-sidebar__brand" href="{{ route('dashboard') }}">
        <span class="rsd-brand-mark" aria-hidden="true">RS</span>
        <span class="rsd-brand-name">{{ domain_name() }}<small>ADMIN PANEL</small></span>
    </a>

    <nav class="rsd-sidebar__nav">
        <a class="rsd-nav-link{{ $active('dashboard') }}" href="{{ route('dashboard') }}">
            <i class="fa fa-th-large"></i><span>Dashboard</span>
        </a>

        @if ($user->is_admin())
            <a class="rsd-nav-link{{ $active('issues') }}" href="{{ route('issues') }}">
                <i class="fa fa-clipboard-list"></i><span>My Tasks</span>
            </a>
        @endif

        @if ($user->is_admin() || $user->is_author())
            <p class="rsd-nav-heading">Catalog</p>
            <a class="rsd-nav-link{{ $active('categories') }}" href="{{ route('categories') }}">
                <i class="fa fa-tags"></i><span>Categories</span>
            </a>
            <a class="rsd-nav-link{{ $active('products') }}" href="{{ route('products') }}">
                <i class="fa fa-cube"></i><span>Products</span>
            </a>
        @endif

        <p class="rsd-nav-heading">Commerce</p>
        <a class="rsd-nav-link{{ $active('order') }}" href="{{ route('order') }}">
            <i class="fa fa-shopping-cart"></i><span>Orders</span>
        </a>

        @if ($user->is_admin())
            <a class="rsd-nav-link{{ $active('users') }}" href="{{ route('users') }}">
                <i class="fa fa-users"></i><span>Users</span>
            </a>
            <a class="rsd-nav-link{{ $active('subscriptions') }}" href="{{ route('subscriptions') }}">
                <i class="fa fa-sync-alt"></i><span>Subscriptions</span>
            </a>
        @endif

        <a class="rsd-nav-link{{ $active('invoices') }}" href="{{ $user->is_client() ? route('custom_invoices') : route('invoices') }}">
            <i class="fa fa-file-invoice-dollar"></i><span>Invoices</span>
        </a>

        <a class="rsd-nav-link{{ $active('messages') }}" href="{{ route('messages') }}">
            <i class="fa fa-bell"></i><span>Notifications</span>
            @if ($messagesCount > 0)
                <span class="rsd-nav-badge">{{ $messagesCount }}</span>
            @endif
        </a>

        @if ($user->is_admin())
            <p class="rsd-nav-heading">System</p>
            <a class="rsd-nav-link{{ $active('settings') }}" href="{{ route('settings') }}">
                <i class="fa fa-cog"></i><span>Settings</span>
            </a>
        @endif
    </nav>

    <div class="rsd-sidebar__footer">
        <div class="rsd-signed-in">
            <span class="rsd-avatar">
                <img src="{{ $user->get_gravatar(80) }}" alt="">
            </span>
            <div>
                <strong>{{ $user->name }}</strong>
                <small>{{ ucfirst($user->user_type) }}</small>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="rsd-logout"><i class="fa fa-sign-out-alt"></i> Sign out</button>
        </form>
    </div>
</aside>
