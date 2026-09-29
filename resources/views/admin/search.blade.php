@extends('dashboard.layouts.app')

@section('title', 'Search')

@section('content')
@include('dashboard.partials.flash')

<header class="rsd-page-head">
    <div>
        <span class="rsd-eyebrow">Search</span>
        <h1>Search</h1>
        <p>
            @if($term)
                Results for "{{ $term }}"
            @else
                Enter a term to search orders, products, categories and users.
            @endif
        </p>
    </div>
    <form class="rsd-search" action="{{ route('search') }}" method="GET" style="max-width:360px; width:100%;">
        <button type="submit" class="rsd-search__submit" aria-label="Search"><i class="fa fa-search"></i></button>
        <input type="text" name="search" value="{{ $term }}" placeholder="Search orders, users, products..." autocomplete="off" autofocus>
    </form>
</header>

@if($term)
    <section class="rsd-panel">
        <div class="rsd-panel__head">
            <div><p class="rsd-eyebrow">Catalog</p><h2>Products ({{ $products->count() }})</h2></div>
        </div>
        <div class="rsd-table-wrap">
            <table class="rsd-table">
                <thead><tr><th>ID</th><th>Product</th><th>Price</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td class="rsd-cell-main">#{{ $product->id }}</td>
                            <td>{{ $product->title }}</td>
                            <td class="nowrap">{{ price($product->cost ?? 0) }}</td>
                            <td>
                                <div class="rsd-actions">
                                    <a class="rsd-action" target="_blank" href="{{ route('shop_description', $product->slug) }}" title="Preview"><i class="fa fa-eye"></i></a>
                                    <a class="rsd-action" href="{{ route('edit_product', $product->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="rsd-empty">No matching products.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="rsd-panel">
        <div class="rsd-panel__head">
            <div><p class="rsd-eyebrow">Catalog</p><h2>Categories ({{ $categories->count() }})</h2></div>
        </div>
        <div class="rsd-table-wrap">
            <table class="rsd-table">
                <thead><tr><th>ID</th><th>Name</th><th>Slug</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td class="rsd-cell-main">#{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td class="muted">{{ $category->category_slug ?: $category->slug }}</td>
                            <td>
                                <div class="rsd-actions">
                                    <a class="rsd-action" target="_blank" href="{{ route('shops_filter', $category->category_slug ?: $category->slug) }}" title="Preview"><i class="fa fa-eye"></i></a>
                                    <a class="rsd-action" href="{{ route('edit_category', $category->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="rsd-empty">No matching categories.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="rsd-panel">
        <div class="rsd-panel__head">
            <div><p class="rsd-eyebrow">Sales</p><h2>Orders ({{ $orders->count() }})</h2></div>
        </div>
        <div class="rsd-table-wrap">
            <table class="rsd-table">
                <thead><tr><th>ID</th><th>Title</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="rsd-cell-main">#{{ $order->id }}</td>
                            <td>{{ $order->title }}</td>
                            <td><a class="rsd-action" href="{{ route('view_order', $order->id) }}" title="View"><i class="fa fa-eye"></i></a></td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="rsd-empty">No matching orders.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="rsd-panel">
        <div class="rsd-panel__head">
            <div><p class="rsd-eyebrow">People</p><h2>Users ({{ $users->count() }})</h2></div>
        </div>
        <div class="rsd-table-wrap">
            <table class="rsd-table">
                <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse($users as $account)
                        <tr>
                            <td class="rsd-cell-main">#{{ $account->id }}</td>
                            <td>{{ $account->name }}</td>
                            <td class="muted">{{ $account->email }}</td>
                            <td><a class="rsd-action" href="{{ route('user_info', $account->id) }}" title="View"><i class="fa fa-eye"></i></a></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="rsd-empty">No matching users.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endif
@endsection
