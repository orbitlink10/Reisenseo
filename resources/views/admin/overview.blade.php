@extends('dashboard.layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    $subscriptionsCount = \App\Models\Payment::wherePaymentSource('subscription')->whereStatus(1)->count();
    $pendingTasks = \App\Models\Task::whereStatus(2)->count();

    $statusMap = [
        0 => ['Pending', 'amber'],
        1 => ['Available', 'blue'],
        2 => ['Assigned', 'violet'],
        3 => ['Editing', 'blue'],
        4 => ['Completed', 'green'],
        5 => ['Approved', 'green'],
        6 => ['Revision', 'amber'],
        7 => ['Cancelled', 'rose'],
        8 => ['Editor Revision', 'violet'],
        9 => ['Dispute', 'rose'],
    ];

    $seriesDates = [];
    $seriesUsers = [];
    $seriesOrders = [];
    $seriesSubs = [];
    for ($i = 6; $i >= 0; $i--) {
        $d = \Carbon\Carbon::today()->subDays($i);
        $seriesDates[] = $d->format('M j');
        $seriesUsers[] = \App\Models\User::whereUserType('client')->where(DB::raw('date(created_at)'), $d)->count();
        $seriesOrders[] = \App\Models\Order::where(DB::raw('date(created_at)'), $d)->count();
        $seriesSubs[] = \App\Models\Payment::wherePaymentSource('subscription')->whereStatus(1)->where(DB::raw('date(created_at)'), $d)->count();
    }
@endphp

@include('dashboard.partials.flash')

<header class="rsd-page-head">
    <div>
        <span class="rsd-eyebrow">Admin Overview</span>
        <h1>Dashboard</h1>
        <p>Manage orders, users, products, subscriptions and client activities.</p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a class="rsd-btn primary" href="{{ route('add_order') }}"><i class="fa fa-plus"></i> New Order</a>
        <a class="rsd-btn" href="{{ route('products') }}#add-product">New Product</a>
    </div>
</header>

<section class="rsd-stats" aria-label="Business summary">
    @include('dashboard.partials.stat-card', ['label' => 'Total Users', 'value' => number_format($stats['users']), 'desc' => 'Registered accounts', 'icon' => 'fa fa-users', 'color' => '#2563eb', 'soft' => '#eff6ff'])
    @include('dashboard.partials.stat-card', ['label' => 'Total Orders', 'value' => number_format($stats['orders']), 'desc' => $stats['pending'] . ' pending review', 'icon' => 'fa fa-shopping-cart', 'color' => '#0ea5e9', 'soft' => '#e0f2fe'])
    @include('dashboard.partials.stat-card', ['label' => 'Total Products', 'value' => number_format($stats['products']), 'desc' => 'Catalog listings', 'icon' => 'fa fa-cube', 'color' => '#14b8a6', 'soft' => '#ccfbf1'])
    @include('dashboard.partials.stat-card', ['label' => 'Total Revenue', 'value' => get_currency() . ' ' . number_format($stats['revenue'], 2), 'desc' => 'Paid orders', 'icon' => 'fa fa-dollar-sign', 'color' => '#22c55e', 'soft' => '#dcfce7'])
    @include('dashboard.partials.stat-card', ['label' => 'Subscriptions', 'value' => number_format($subscriptionsCount), 'desc' => 'Active subscriptions', 'icon' => 'fa fa-sync-alt', 'color' => '#8b5cf6', 'soft' => '#ede9fe'])
    @include('dashboard.partials.stat-card', ['label' => 'Pending Tasks', 'value' => number_format($pendingTasks), 'desc' => 'Tasks awaiting action', 'icon' => 'fa fa-clipboard-list', 'color' => '#f59e0b', 'soft' => '#fef3c7'])
</section>

<section class="rsd-panel" aria-label="Recent statistics">
    <div class="rsd-panel__head">
        <div>
            <p class="rsd-eyebrow">Analytics</p>
            <h2>Recent Statistics</h2>
        </div>
    </div>
    <div class="rsd-panel__body">
        <div class="rsd-chart"><canvas id="rsdStatsChart"></canvas></div>
    </div>
</section>

<section class="rsd-panel" aria-label="Recent orders">
    <div class="rsd-panel__head">
        <div>
            <p class="rsd-eyebrow">Orders Desk</p>
            <h2>Recent Orders</h2>
        </div>
        <a class="rsd-btn sm" href="{{ route('order') }}">View all &rarr;</a>
    </div>
    <div class="rsd-table-wrap">
        <table class="rsd-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Service</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentOrders as $order)
                    @php $s = $statusMap[$order->status] ?? ['Unknown', 'slate']; @endphp
                    <tr>
                        <td class="rsd-cell-main">#{{ $order->id }}</td>
                        <td>{{ $customers[$order->user_id] ?? 'Unavailable' }}</td>
                        <td>{{ subject($order->category_id) }}</td>
                        <td class="nowrap">{{ price((int) $order->ccost) }}</td>
                        <td><span class="rsd-pill {{ $s[1] }}">{{ $s[0] }}</span></td>
                        <td class="nowrap muted">{{ optional($order->created_at)->format('d M Y') }}</td>
                        <td>
                            <div class="rsd-actions">
                                <a class="rsd-action" href="{{ route('view_order', $order->slug) }}" title="View"><i class="fa fa-eye"></i></a>
                                <a class="rsd-action" href="{{ route('edit_order', $order->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="rsd-empty">No orders yet. New orders will appear here.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

<section class="rsd-panel" aria-label="Recent products">
    <div class="rsd-panel__head">
        <div>
            <p class="rsd-eyebrow">Catalog Admin</p>
            <h2>Recent Products</h2>
        </div>
        <a class="rsd-btn sm" href="{{ route('products') }}#recent-products">View all products &rarr;</a>
    </div>
    <div class="rsd-table-wrap">
        <table class="rsd-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Added</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentProducts as $product)
                    <tr>
                        <td><span class="rsd-thumb">{{ strtoupper(mb_substr($product->title, 0, 1)) }}</span></td>
                        <td class="rsd-cell-main">{{ $product->title }}</td>
                        <td>{{ $categoryNames[$product->category_id] ?? 'Uncategorized' }}</td>
                        <td class="nowrap">{{ price($product->cost ?? 0) }}</td>
                        <td class="nowrap muted">{{ optional($product->created_at)->format('d M Y') }}</td>
                        <td>
                            <div class="rsd-actions">
                                <a class="rsd-action" href="{{ route('edit_post', $product->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="rsd-empty">No products yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection

@section('page-js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function () {
        var ctx = document.getElementById('rsdStatsChart');
        if (!ctx) return;
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($seriesDates),
                datasets: [
                    {
                        label: 'Users',
                        data: @json($seriesUsers),
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, .08)',
                        borderWidth: 2.5,
                        tension: .35,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#2563eb',
                        pointRadius: 3
                    },
                    {
                        label: 'Orders',
                        data: @json($seriesOrders),
                        borderColor: '#0ea5e9',
                        backgroundColor: 'rgba(14, 165, 233, .08)',
                        borderWidth: 2.5,
                        tension: .35,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#0ea5e9',
                        pointRadius: 3
                    },
                    {
                        label: 'Subscriptions',
                        data: @json($seriesSubs),
                        borderColor: '#22c55e',
                        backgroundColor: 'rgba(34, 197, 94, .08)',
                        borderWidth: 2.5,
                        tension: .35,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#22c55e',
                        pointRadius: 3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: { color: '#64748b', usePointStyle: true, pointStyle: 'circle' }
                    }
                },
                scales: {
                    x: { ticks: { color: '#94a3b8' }, grid: { display: false } },
                    y: { ticks: { color: '#94a3b8', precision: 0 }, grid: { color: 'rgba(148,163,184,.16)' } }
                }
            }
        });
    })();
</script>
@endsection
