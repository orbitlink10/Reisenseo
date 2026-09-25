@php
    $user = Auth::user();
@endphp

<header class="rsd-navbar">
    <button class="rsd-burger" type="button" onclick="rsdToggleSidebar()" aria-label="Toggle navigation">
        <i class="fa fa-bars"></i>
    </button>

    <form class="rsd-search" action="{{ route('order') }}" method="GET">
        <i class="fa fa-search"></i>
        <input type="text" name="search" placeholder="Search orders, users, products..." autocomplete="off">
    </form>

    <div class="rsd-navbar__right">
        <button class="rsd-icon-btn" type="button" title="Activity" onclick="window.location='{{ route('logActivity') }}'">
            <i class="fa fa-chart-line"></i>
        </button>

        <button class="rsd-icon-btn" type="button" title="Notifications" onclick="window.location='{{ route('messages') }}'">
            <i class="fa fa-bell"></i>
            @php $unread = \App\Models\Chat::whereMessageRead(0)->whereMessageTo($user->id)->count(); @endphp
            @if ($unread > 0) <span class="dot"></span> @endif
        </button>

        <div class="dropdown">
            <button class="rsd-btn primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-plus"></i> Add New
            </button>
            <div class="dropdown-menu dropdown-menu-end" style="border-radius: 14px; border: 1px solid #e5e7eb; box-shadow: 0 12px 30px rgba(16,24,40,.12);">
                <a class="dropdown-item" href="{{ route('add_order') }}"><i class="fa fa-file-alt me-2 text-muted"></i>New Order</a>
                <a class="dropdown-item" href="{{ route('post_page') }}"><i class="fa fa-file me-2 text-muted"></i>New Page</a>
                <a class="dropdown-item" href="{{ route('products') }}#add-product"><i class="fa fa-cube me-2 text-muted"></i>New Product</a>
                @if ($user->is_admin())
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('add_user') }}"><i class="fa fa-user me-2 text-muted"></i>New User</a>
                @endif
            </div>
        </div>

        <a class="rsd-icon-btn" href="{{ route('account') }}" title="Profile" style="padding: 2px;">
            <span class="rsd-avatar" style="width: 34px; height: 34px;">
                <img src="{{ $user->get_gravatar(80) }}" alt="">
            </span>
        </a>
    </div>
</header>
