<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Dashboard | ReisenSEO</title>
<link rel="stylesheet" href="{{ asset('assets/css/admin-overview.css') }}?v=20260924">
</head>
<body>
<a class="skip-link" href="#main-content">Skip to dashboard</a>
<div class="admin-shell">
    <aside class="navigation" aria-label="Administration">
        <a class="brand" href="{{ route('dashboard') }}" aria-label="ReisenSEO dashboard">
            <span class="brand-mark" aria-hidden="true">RS<span></span></span>
            <span class="brand-name">ReisenSEO<small>ADMIN PANEL</small></span>
        </a>
        <details class="navigation-menu" open>
            <summary>Navigation @include('admin.partials.overview-icon', ['icon' => 'menu'])</summary>
            <nav aria-label="Admin navigation">
                <a class="nav-link selected" href="{{ route('dashboard') }}" aria-current="page">
                    <span class="nav-icon">@include('admin.partials.overview-icon', ['icon' => 'dashboard'])</span><span>Dashboard</span>
                </a>
                <p class="nav-heading">Content Management</p>
                @foreach([
                    ['homepage', 'Homepage Content', 'content'],
                    ['wreviews', 'Reviews', 'reviews'],
                    ['categories', 'Categories', 'categories'],
                    ['products', 'Products', 'products'],
                    ['post_page', 'Pages', 'page'],
                ] as [$destination, $label, $icon])
                    <a class="nav-link" href="{{ route($destination) }}"><span class="nav-icon">@include('admin.partials.overview-icon', ['icon' => $icon])</span><span>{{ $label }}</span></a>
                @endforeach
                <p class="nav-heading">Business Management</p>
                @foreach([['order', 'Orders', 'orders'], ['invoices', 'Invoices', 'invoice'], ['users', 'Users', 'users']] as [$destination, $label, $icon])
                    <a class="nav-link" href="{{ route($destination) }}"><span class="nav-icon">@include('admin.partials.overview-icon', ['icon' => $icon])</span><span>{{ $label }}</span></a>
                @endforeach
                <p class="nav-heading">Administration</p>
                @foreach([['websites', 'Websites', 'globe'], ['settings', 'Settings', 'settings']] as [$destination, $label, $icon])
                    <a class="nav-link" href="{{ route($destination) }}"><span class="nav-icon">@include('admin.partials.overview-icon', ['icon' => $icon])</span><span>{{ $label }}</span></a>
                @endforeach
            </nav>
            <div class="navigation-footer">
                <a class="visit" href="{{ url('/') }}">View website @include('admin.partials.overview-icon', ['icon' => 'external'])</a>
                <div class="signed-in"><span class="avatar">{{ strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}</span><span>{{ Auth::user()->name }}<small>Administrator</small></span></div>
                <form class="logout" method="POST" action="{{ route('logout') }}">@csrf<button type="submit">@include('admin.partials.overview-icon', ['icon' => 'logout']) Sign out</button></form>
            </div>
        </details>
    </aside>
<main id="main-content" tabindex="-1">
<div class="workspace">
    @include('flash_msg')
    <header class="page-heading">
        <div class="page-intro">
            <span class="overview-label">Admin Overview</span>
            <h1>Dashboard</h1>
            <p>View and manage all customer orders, users,<br class="desktop-break"> products, and account activations.</p>
        </div>
        <div class="actions" aria-label="Quick actions">
            <a class="button primary" href="{{ route('products') }}#add-product"><span aria-hidden="true">+</span> New Product</a>
            <a class="button" href="{{ route('users') }}">Manage Users</a>
            <a class="button" href="{{ route('products') }}#recent-products">Manage Products</a>
            <a class="button" href="{{ route('wreviews') }}">Manage Reviews</a>
        </div>
    </header>
    <nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span aria-hidden="true">/</span><span aria-current="page">Dashboard</span></nav>
    <section class="summary-grid" aria-label="Business summary">
        @foreach([
            ['Orders', 'orders', 'OR', number_format($stats['pending']).' pending review', route('order'), 'View orders', 'blue'],
            ['Products', 'products', 'PR', number_format($stats['products']).' catalog listings', route('products').'#recent-products', 'View products', 'teal'],
            ['Users', 'users', 'US', 'Registered accounts', route('users'), 'View users', 'slate'],
            ['Activations', 'approvals', 'AC', 'Accounts awaiting activation', '#pending-activations', 'Review activations', 'rose'],
        ] as [$label, $key, $icon, $description, $destination, $linkLabel, $color])
            <article class="summary-card tone-{{ $color }}">
                <span class="metric-icon" aria-hidden="true">{{ $icon }}</span>
                <h2>{{ $label }}</h2>
                <strong class="metric-value">{{ number_format($stats[$key]) }}</strong>
                <p>{{ $description }}</p>
                <a class="metric-link" href="{{ $destination }}">{{ $linkLabel }} <span aria-hidden="true">&gt;</span></a>
            </article>
        @endforeach
    </section>
    <section class="secondary-grid" aria-label="Activity metrics">
        <article class="activity-card tone-slate">
            <h2>Total Revenue</h2>
            <strong class="metric-value revenue"><span class="currency">{{ get_currency() }}</span>{{ number_format($stats['revenue'], 2) }}</strong>
            <p>Paid orders</p>
        </article>
        @foreach([['Recent Orders', 'recentOrders', 'Last 7 days', 'blue'], ['New Users', 'newUsers', 'Last 30 days', 'navy'], ['Active Users', 'activeUsers', 'Last 24 hours', 'teal']] as [$label, $key, $description, $color])
            <article class="activity-card tone-{{ $color }}"><h2>{{ $label }}</h2><strong class="metric-value">{{ number_format($stats[$key]) }}</strong><p>{{ $description }}</p></article>
        @endforeach
    </section>
<div class="desk-grid">
<section class="panel"><div class="panel-heading"><div><p class="eyebrow">ORDERS DESK</p><h2>Recent Orders</h2></div><a href="{{ route('order') }}">View all &rarr;</a></div>
<div class="table-scroll" tabindex="0" role="region" aria-label="Recent orders table"><table><thead><tr><th scope="col">Order</th><th scope="col">Customer</th><th scope="col">Status</th><th scope="col">Date</th></tr></thead><tbody>
@forelse($recentOrders as $order)
<tr><td><a href="{{ route('view_order', $order->slug) }}">#{{ $order->id }}</a><small>{{ \Illuminate\Support\Str::limit($order->title, 42) }}</small></td><td>{{ $customers[$order->user_id] ?? 'Unavailable' }}</td><td><span class="status">{{ [0=>'Pending',1=>'Available',2=>'Assigned',3=>'Editing',4=>'Completed',5=>'Approved',6=>'Revision',7=>'Cancelled'][$order->status] ?? 'Unknown' }}</span></td><td class="nowrap">{{ optional($order->created_at)->format('d M Y') }}</td></tr>
@empty<tr><td colspan="4" class="empty">No orders yet. New orders will appear here.</td></tr>@endforelse
</tbody></table></div></section>
<section class="panel" id="pending-activations"><div class="panel-heading"><div><p class="eyebrow">ACCOUNT QUEUE</p><h2>Pending Activations</h2></div></div>
@forelse($pendingAccounts as $account)<div class="account"><span class="avatar">{{ strtoupper(mb_substr($account->name,0,1)) }}</span><div><a href="{{ route('user_info', $account->id) }}">{{ $account->name }}</a><small>Awaiting activation</small></div></div>@empty<p class="empty">No accounts awaiting activation.</p>@endforelse
<a class="panel-footer" href="{{ route('users') }}">Manage accounts &rarr;</a></section>
</div>
<section class="panel catalog"><div class="panel-heading"><div><p class="eyebrow">CATALOG ADMIN</p><h2>Products</h2></div><a href="{{ route('products') }}#recent-products">View all products &rarr;</a></div><div class="table-scroll" tabindex="0" role="region" aria-label="Products table"><table><thead><tr><th scope="col">Name</th><th scope="col">Category</th><th scope="col">Price</th><th scope="col">Added</th><th scope="col"><span class="sr-only">Actions</span></th></tr></thead><tbody>
@forelse($recentProducts as $product)<tr><td>{{ $product->title }}</td><td>{{ $categoryNames[$product->category_id] ?? 'Uncategorized' }}</td><td class="nowrap">{{ price($product->cost ?? 0) }}</td><td class="nowrap">{{ optional($product->created_at)->format('d M Y') }}</td><td><a href="{{ route('edit_post', $product->id) }}">Edit<span class="sr-only"> {{ $product->title }}</span></a></td></tr>
@empty<tr><td colspan="5" class="empty">No products yet. Add your first product to build your catalog.</td></tr>@endforelse
</tbody></table></div></section>
<footer>ReisenSEO &middot; Administration</footer>
</div></main></div>
<script>
    (() => {
        const menu = document.querySelector('.navigation-menu');
        const mobile = window.matchMedia('(max-width: 760px)');
        const updateMenu = () => { menu.open = !mobile.matches; };
        updateMenu();
        mobile.addEventListener('change', updateMenu);
    })();
</script>
</body></html>
