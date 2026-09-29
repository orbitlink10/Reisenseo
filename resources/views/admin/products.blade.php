@extends('dashboard.layouts.app')

@section('title', 'Products')
@section('body-class', 'category-admin')

@section('page-css')
<link rel="stylesheet" href="{{ asset('assets/css/category-admin.css') }}?v=20260929">
<style>
    .product-thumb {
        display: block;
        width: 90px;
        height: 90px;
        object-fit: contain;
        border: 1px solid #dbe3ef;
        border-radius: 8px;
        background: #fff;
    }
    .product-thumb--placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #8b94a7;
        font-size: 13px;
        background: #f8fafc;
    }
    .category-page-sub { color: #64748b; margin-top: 6px; }
</style>
@endsection

@section('content')
@include('dashboard.partials.flash')

<section class="category-page-head">
    <div>
        <h1 class="category-page-title">Products</h1>
        <p class="category-page-sub">Manage and view all products available in the system</p>
    </div>
    <a class="category-primary-pill" href="{{ route('create_product') }}">+ Add Product</a>
</section>

<section class="category-list-panel">
    <div class="rsd-panel__head">
        <div>
            <p class="rsd-eyebrow">Catalog</p>
            <h2>Product List</h2>
        </div>
    </div>
    <div class="category-table-wrap">
        <table class="category-data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price (KES)</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    @php
                        $thumb = $post->uploads->first();
                        $catName = optional($categories->firstWhere('id', $post->category_id))->name ?? 'General';
                    @endphp
                    <tr>
                        <td>{{ $posts->firstItem() + $loop->index }}</td>
                        <td>
                            @if ($thumb)
                                <img class="product-thumb" src="{{ url($thumb->file_path) }}" alt="{{ $post->title }}">
                            @else
                                <div class="product-thumb product-thumb--placeholder">No Image</div>
                            @endif
                        </td>
                        <td>{{ $post->title }}</td>
                        <td class="nowrap">{{ number_format((float) $post->cost, 2) }}</td>
                        <td>{{ $catName }}</td>
                        <td>
                            <div class="category-action-row">
                                <a class="category-row-action tone-info" target="_blank" rel="noopener noreferrer" href="{{ route('shop_description', $post->slug) }}">Preview</a>
                                <a class="category-row-action tone-warning" href="{{ route('edit_product', $post->id) }}">Update</a>
                                <form method="POST" action="{{ route('delete_product') }}" onsubmit="return confirm('Delete this product?');">
                                    @csrf
                                    <input type="hidden" name="cat_id" value="{{ $post->id }}">
                                    <button type="submit" class="category-row-action tone-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="category-empty-cell">No products yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if (method_exists($posts, 'links'))
        <div class="rsd-pagination">{!! $posts->links('pagination::bootstrap-4') !!}</div>
    @endif
</section>
@endsection
