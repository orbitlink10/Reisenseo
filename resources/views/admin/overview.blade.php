<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Dashboard | ReisenSEO</title>
<link rel="stylesheet" href="{{ asset('assets/css/admin-overview.css') }}">
</head>
<body>
<div class="admin-shell">
<aside class="navigation">
<a class="brand" href="{{ route('dashboard') }}">Reisen<span>SEO</span><small>ADMIN PANEL</small></a>
<nav aria-label="Admin navigation">
<a class="selected" href="{{ route('dashboard') }}" aria-current="page">Dashboard</a>
<p>Content Management</p>
@foreach(['pages_setting'=>'Homepage Content', 'wreviews'=>'Reviews', 'categories'=>'Categories', 'products'=>'Products', 'websites'=>'Websites'] as $destination=>$label)
<a href="{{ route($destination) }}">{{ $label }}</a>
@endforeach
<p>Business</p>
@foreach(['order'=>'Orders', 'invoices'=>'Invoices', 'users'=>'Users', 'settings'=>'Settings'] as $destination=>$label)
<a href="{{ route($destination) }}">{{ $label }}</a>
@endforeach
</nav>
<a class="visit" href="{{ url('/') }}">View website &nearr;</a>
<form class="logout" method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Sign out</button></form></aside>
<main>
<header class="topbar"><span>Admin Overview</span><span>{{ Auth::user()->name }}</span></header>
<div class="workspace">
@include('flash_msg')
<div class="page-heading"><div><p class="eyebrow">YOUR BUSINESS AT A GLANCE</p><h1>Dashboard</h1><p>Manage your orders, customers, catalog, and account activations.</p></div><span class="breadcrumb">Home / Dashboard</span></div>
<div class="actions"><a class="button primary" href="{{ route('products') }}">+ Add Product</a><a class="button" href="{{ route('users') }}">Manage Users</a><a class="button" href="{{ route('products') }}">Manage Products</a><a class="button" href="{{ route('wreviews') }}">Manage Reviews</a></div>
<section class="summary-grid" aria-label="Business summary">
@foreach([
['Orders','orders','OR',$stats['pending'].' pending review','order'],
['Products','products','PR','Catalog listings','products'],
['Users','users','US','Registered accounts','users'],
['Activations','approvals','AC','Accounts awaiting activation','users']
] as [$label,$key,$icon,$description,$destination])
<article class="summary-card"><div class="card-top"><span>{{ $label }}</span><span class="metric-icon">{{ $icon }}</span></div><strong>{{ number_format($stats[$key]) }}</strong><p>{{ $description }}</p><a href="{{ route($destination) }}">View {{ strtolower($label) }} &rarr;</a></article>
@endforeach
</section>
<section class="secondary-grid" aria-label="Activity metrics">
@foreach([['Completed Orders','completed','Completed status'],['Recent Orders','recentOrders','Last 7 days'],['New Users','newUsers','Last 30 days'],['Product Categories','categories','Catalog organization']] as [$label,$key,$description])
<article><span>{{ $label }}</span><strong>{{ number_format($stats[$key]) }}</strong><small>{{ $description }}</small></article>
@endforeach
</section>
<div class="desk-grid">
<section class="panel"><div class="panel-heading"><div><p class="eyebrow">ORDERS DESK</p><h2>Recent Orders</h2></div><a href="{{ route('order') }}">View all &rarr;</a></div>
<div class="table-scroll"><table><thead><tr><th>Order</th><th>Customer</th><th>Status</th><th>Date</th></tr></thead><tbody>
@forelse($recentOrders as $order)
<tr><td><a href="{{ route('view_order', $order->slug) }}">#{{ $order->id }}</a><small>{{ \Illuminate\Support\Str::limit($order->title, 42) }}</small></td><td>{{ $customers[$order->user_id] ?? 'Unavailable' }}</td><td><span class="status">{{ [0=>'Pending',1=>'Available',2=>'Assigned',3=>'Editing',4=>'Completed',5=>'Approved',6=>'Revision',7=>'Cancelled'][$order->status] ?? 'Unknown' }}</span></td><td class="nowrap">{{ optional($order->created_at)->format('d M Y') }}</td></tr>
@empty<tr><td colspan="4" class="empty">No orders yet. New orders will appear here.</td></tr>@endforelse
</tbody></table></div></section>
<section class="panel"><div class="panel-heading"><div><p class="eyebrow">ACCOUNT QUEUE</p><h2>Pending Activations</h2></div></div>
@forelse($pendingAccounts as $account)<div class="account"><span class="avatar">{{ strtoupper(mb_substr($account->name,0,1)) }}</span><div><a href="{{ route('user_info', $account->id) }}">{{ $account->name }}</a><small>Awaiting activation</small></div></div>@empty<p class="empty">No accounts awaiting activation.</p>@endforelse
<a class="panel-footer" href="{{ route('users') }}">Manage accounts &rarr;</a></section>
</div>
<section class="panel catalog"><div class="panel-heading"><div><p class="eyebrow">CATALOG ADMIN</p><h2>Products</h2></div><a href="{{ route('products') }}">View all products &rarr;</a></div><div class="table-scroll"><table><thead><tr><th>Name</th><th>Category</th><th>Price</th><th>Added</th><th></th></tr></thead><tbody>
@forelse($recentProducts as $product)<tr><td>{{ $product->title }}</td><td>{{ $categoryNames[$product->category_id] ?? 'Uncategorized' }}</td><td class="nowrap">{{ price($product->cost ?? 0) }}</td><td class="nowrap">{{ optional($product->created_at)->format('d M Y') }}</td><td><a href="{{ route('edit_post', $product->id) }}">Edit<span class="sr-only"> {{ $product->title }}</span></a></td></tr>
@empty<tr><td colspan="5" class="empty">No products yet. Add your first product to build your catalog.</td></tr>@endforelse
</tbody></table></div></section>
<footer>ReisenSEO &middot; Administration</footer>
</div></main></div>
</body></html>
