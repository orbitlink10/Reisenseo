@extends('dashboard.layouts.app')

@section('title', 'Add Product')
@section('body-class', 'rsd-product-page')

@section('page-css')
<link rel="stylesheet" href="{{ asset('assets/css/product-form.css') }}?v=20260929">
@endsection

@section('content')
@include('dashboard.partials.flash')

@if ($errors->any())
    <div class="rsd-alert error">
        <ul style="margin:0; padding-left:18px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<header class="rsd-page-head">
    <div>
        <h1>Add Product</h1>
        <p>Fill in the product details below to add a new item</p>
    </div>
</header>

<div class="rsd-product-layout">
    <div>
        <section class="rsd-panel rsd-product-card" id="add-product" aria-label="Add product">
            <div class="rsd-panel__body">
                <form id="product-form" method="POST" action="{{ route('anew_product') }}">
                    @csrf
                    <input type="hidden" name="site_id" value="{{ old('site_id', Auth::user()->site_id) }}">

                    <div class="rsd-form-group">
                        <label for="product-name">Product Name</label>
                        <input id="product-name" type="text" class="rsd-form-control @error('title') is-invalid @enderror" name="title" placeholder="Enter product name" value="{{ old('title') }}" maxlength="255" required>
                        @error('title')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="rsd-form-group">
                        <label for="product-price">Price (KES)</label>
                        <input id="product-price" type="number" value="{{ old('cost') }}" class="rsd-form-control @error('cost') is-invalid @enderror" name="cost" placeholder="Enter product price" min="0" max="9999999999.99" step="0.01" required>
                        @error('cost')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="rsd-form-group">
                        <label for="product-marked-price">Marked Price (KES)</label>
                        <input id="product-marked-price" type="number" value="{{ old('marked_price') }}" class="rsd-form-control @error('marked_price') is-invalid @enderror" name="marked_price" placeholder="Enter marked price" min="0" max="9999999999.99" step="0.01">
                        @error('marked_price')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="rsd-form-group">
                        <label for="product-quantity">Quantity</label>
                        <input id="product-quantity" type="number" value="{{ old('quantity', 0) }}" class="rsd-form-control @error('quantity') is-invalid @enderror" name="quantity" min="0" max="2147483647" step="1" required>
                        @error('quantity')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="rsd-form-group">
                        <label for="product-category">Category</label>
                        <select id="product-category" class="rsd-form-control @error('category_id') is-invalid @enderror" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="rsd-form-group">
                        <label for="product-subcategory">Subcategory</label>
                        <select id="product-subcategory" class="rsd-form-control @error('sub_category') is-invalid @enderror" name="sub_category">
                            <option value="">Select Subcategory</option>
                            @foreach ($subCategories as $subcategory)
                                <option value="{{ $subcategory->id }}" data-category="{{ $subcategory->cat_id }}" {{ old('sub_category') == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                            @endforeach
                        </select>
                        @error('sub_category')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="rsd-form-group">
                        <label for="product-meta-description">Meta Description</label>
                        <textarea id="product-meta-description" class="rsd-form-control @error('meta_description') is-invalid @enderror" name="meta_description" rows="4" maxlength="255" placeholder="Write a short search-friendly summary">{{ old('meta_description') }}</textarea>
                        @error('meta_description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="rsd-form-group rsd-product-description">
                        <label for="product-description">Description</label>
                        <textarea id="product-description" class="rsd-form-control @error('description') is-invalid @enderror" name="description" rows="14" placeholder="Write the product description here...">{{ old('description') }}</textarea>
                        <p id="product-editor-status" class="rsd-editor-status" role="status" hidden></p>
                        @error('description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="rsd-form-group">
                        <label for="product-parent-page">Parent Page</label>
                        <select id="product-parent-page" class="rsd-form-control @error('parent_page') is-invalid @enderror" name="parent_page">
                            <option value="">Select Parent Page</option>
                            @foreach ($pages as $page)
                                <option value="{{ $page->id }}" {{ old('parent_page', Auth::user()->page_id) == $page->id ? 'selected' : '' }}>{{ $page->name }}</option>
                            @endforeach
                        </select>
                        @error('parent_page')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="rsd-product-actions">
                        <button type="submit" class="rsd-btn primary"><i class="fa fa-plus" aria-hidden="true"></i> Add Product</button>
                        <a href="#recent-products" class="rsd-btn">View Products</a>
                    </div>
                </form>
            </div>
        </section>

        <section class="rsd-panel" id="recent-products">
            <div class="rsd-panel__head">
                <div>
                    <p class="rsd-eyebrow">Catalog</p>
                    <h2>Recent Products</h2>
                </div>
            </div>
            <div class="rsd-table-wrap">
                <table class="rsd-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $post)
                            @php
                                $catName = $categories->firstWhere('id', $post->category_id)->name ?? 'Uncategorized';
                            @endphp
                            <tr>
                                <td data-label="Image"><span class="rsd-thumb">{{ strtoupper(mb_substr($post->title, 0, 1)) }}</span></td>
                                <td data-label="Product Name">
                                    <a class="rsd-cell-main" target="_blank" href="{{ route('shop_description', $post->slug) }}">{{ $post->title }}</a>
                                </td>
                                <td data-label="Category" class="muted">{{ $catName }}</td>
                                <td data-label="Price" class="nowrap">{{ price($post->cost ?? 0) }}</td>
                                <td data-label="Status"><span class="rsd-pill green">Published</span></td>
                                <td data-label="Actions">
                                    <div class="rsd-actions">
                                        <a class="rsd-action" target="_blank" href="{{ route('shop_description', $post->slug) }}" title="View"><i class="fa fa-eye"></i></a>
                                        <a class="rsd-action" href="{{ route('edit_post', $post->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                                        <a class="rsd-action danger" data-bs-toggle="modal" data-bs-target="#delete-product{{ $post->id }}" title="Delete"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="rsd-empty">No products yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if (method_exists($posts, 'links'))
                <div class="rsd-pagination">{!! $posts->links('pagination::bootstrap-4') !!}</div>
            @endif
        </section>
    </div>

    <aside aria-label="Product defaults">
        <section class="rsd-panel">
            <div class="rsd-panel__head">
                <div>
                    <p class="rsd-eyebrow">Defaults</p>
                    <h2>Set Defaults</h2>
                </div>
            </div>
            <div class="rsd-panel__body">
                <form method="POST" action="{{ route('update_default') }}">
                    @csrf
                    <div class="rsd-form-group">
                        <label>Default Category</label>
                        <select class="rsd-form-control" name="post_cat">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ Auth::user()->post_category == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="rsd-form-group">
                        <label>Parent Page</label>
                        <select class="rsd-form-control" name="page_id">
                            @foreach ($pages as $category)
                                <option value="{{ $category->id }}" {{ Auth::user()->page_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="rsd-form-group">
                        <label>Website</label>
                        <select class="rsd-form-control" name="site_id">
                            @foreach ($sites as $category)
                                <option value="{{ $category->id }}" {{ Auth::user()->site_id == $category->id ? 'selected' : '' }}>{{ $category->domain_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="rsd-btn primary">Save</button>
                </form>
            </div>
        </section>
    </aside>
</div>

{{-- Delete modals --}}
@foreach ($posts as $post)
    <div class="modal fade" id="delete-product{{ $post->id }}">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius:16px; border:none; box-shadow:0 20px 50px rgba(16,24,40,.2);">
                <div class="modal-header"><h6 class="modal-title">Delete Product #{{ $post->id }}</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button></div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('delete_product') }}">
                        @csrf
                        <input type="hidden" name="cat_id" value="{{ $post->id }}">
                        <p>Are you sure you want to delete this product?</p>
                        <button type="submit" class="rsd-btn danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection

@section('page-js')
<script src="https://cdn.jsdelivr.net/npm/tinymce@8.9.2/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/product-form.js') }}?v=20260929"></script>
@endsection
