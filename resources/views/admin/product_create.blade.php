@extends('dashboard.layouts.app')

@section('title', $post ? 'Edit Product' : 'Add Product')
@section('body-class', 'rsd-product-page')

@section('page-css')
<link rel="stylesheet" href="{{ asset('assets/css/product-form.css') }}?v=20260930-2">
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
        <h1>{{ $post ? 'Edit Product' : 'Add Product' }}</h1>
        <p>Fill in the product details below to {{ $post ? 'update this' : 'add a new' }} item</p>
    </div>
</header>

<div class="rsd-product-layout">
    <section class="rsd-panel rsd-product-card" aria-label="{{ $post ? 'Edit product' : 'Add product' }}">
        <div class="rsd-panel__body">
            <form id="product-form" method="POST" action="{{ $post ? route('updatesingle_product') : route('anew_product') }}" enctype="multipart/form-data">
                @csrf
                @if ($post)
                    <input type="hidden" name="page_id" value="{{ $post->id }}">
                    <input type="hidden" name="post_type" value="product">
                @endif
                <input type="hidden" name="site_id" value="{{ old('site_id', $post->site_id ?? Auth::user()->site_id) }}">

                <div class="rsd-form-group">
                    <label for="product-name">Product Name</label>
                    <input id="product-name" type="text" class="rsd-form-control @error('title') is-invalid @enderror" name="title" placeholder="Enter product name" value="{{ old('title', $post->title ?? '') }}" maxlength="255" required>
                    @error('title')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <fieldset class="rsd-product-images">
                    <legend>Product images</legend>
                    <p class="rsd-image-help">Upload JPG, PNG or WebP images, up to 2 MB each. The main image appears in the shop and on the product page.</p>
                    <div class="rsd-image-fields">
                        <div class="rsd-image-upload">
                            <label for="product-image">Main product image</label>
                            <input id="product-image" type="file" name="product_image" accept="image/jpeg,image/png,image/webp" aria-describedby="product-image-help" data-image-input data-preview="product-image-preview">
                            <small id="product-image-help">{{ $post ? 'Choose an image to replace the main photo. The previous photo stays in the gallery.' : 'Choose the main photo for this product.' }}</small>
                            @error('product_image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            <div id="product-image-preview" class="rsd-image-previews" aria-live="polite"></div>
                        </div>
                        <div class="rsd-image-upload">
                            <label for="product-gallery">Gallery images (optional)</label>
                            <input id="product-gallery" type="file" name="gallery_images[]" accept="image/jpeg,image/png,image/webp" multiple aria-describedby="product-gallery-help" data-image-input data-preview="product-gallery-preview">
                            <small id="product-gallery-help">Add up to 8 extra photos at a time. Existing gallery images are kept.</small>
                            @error('gallery_images')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            @error('gallery_images.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            <div id="product-gallery-preview" class="rsd-image-previews" aria-live="polite"></div>
                        </div>
                    </div>
                    @if ($post && $post->uploads->isNotEmpty())
                        <p class="rsd-image-current-label">Current images</p>
                        <div class="rsd-image-previews">
                            @foreach ($post->uploads as $upload)
                                <figure><img src="{{ url($upload->file_path) }}" alt="{{ $post->title }} image {{ $loop->iteration }}" width="110" height="110"><figcaption>{{ $loop->first ? 'Main image' : 'Gallery image' }}</figcaption></figure>
                            @endforeach
                        </div>
                    @endif
                    @if ($errors->any())<p class="rsd-image-help">If you selected new images, please select them again before saving.</p>@endif
                </fieldset>

                <div class="rsd-form-group">
                    <label for="product-price">Price (KES)</label>
                    <input id="product-price" type="number" value="{{ old('cost', $post->cost ?? '') }}" class="rsd-form-control @error('cost') is-invalid @enderror" name="cost" placeholder="Enter product price" min="0" max="9999999999.99" step="0.01" required>
                    @error('cost')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="rsd-form-group">
                    <label for="product-marked-price">Marked Price (KES)</label>
                    <input id="product-marked-price" type="number" value="{{ old('marked_price', $post->marked_price ?? '') }}" class="rsd-form-control @error('marked_price') is-invalid @enderror" name="marked_price" placeholder="Enter marked price" min="0" max="9999999999.99" step="0.01">
                    @error('marked_price')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="rsd-form-group">
                    <label for="product-quantity">Quantity</label>
                    <input id="product-quantity" type="number" value="{{ old('quantity', $post->quantity ?? 0) }}" class="rsd-form-control @error('quantity') is-invalid @enderror" name="quantity" min="0" max="2147483647" step="1" required>
                    @error('quantity')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="rsd-form-group">
                    <label for="product-category">Category</label>
                    <select id="product-category" class="rsd-form-control @error('category_id') is-invalid @enderror" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="rsd-form-group">
                    <label for="product-meta-title">Meta/SEO Title</label>
                    <input id="product-meta-title" type="text" class="rsd-form-control @error('meta_title') is-invalid @enderror" name="meta_title" placeholder="Write the SEO title" value="{{ old('meta_title', $post->meta_title ?? '') }}" maxlength="255">
                    <small class="text-muted">Shown as the page title in search results and the browser tab.</small>
                    @error('meta_title')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="rsd-form-group">
                    <label for="product-meta-description">Meta Description</label>
                    <textarea id="product-meta-description" class="rsd-form-control @error('meta_description') is-invalid @enderror" name="meta_description" rows="4" maxlength="255" placeholder="Write a short search-friendly summary">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
                    @error('meta_description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="rsd-form-group rsd-product-description">
                    <label for="product-description">Description</label>
                    <textarea id="product-description" class="rsd-form-control @error('description') is-invalid @enderror" name="description" rows="14" placeholder="Write the product description here...">{{ old('description', $post->description ?? '') }}</textarea>
                    <p id="product-editor-status" class="rsd-editor-status" role="status" hidden></p>
                    @error('description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="rsd-form-group">
                    <label for="product-parent-page">Parent Page</label>
                    <select id="product-parent-page" class="rsd-form-control @error('parent_page') is-invalid @enderror" name="parent_page">
                        <option value="">Select Parent Page</option>
                        @foreach ($pages as $page)
                            <option value="{{ $page->id }}" {{ old('parent_page', $post->parent_page ?? Auth::user()->page_id) == $page->id ? 'selected' : '' }}>{{ $page->name }}</option>
                        @endforeach
                    </select>
                    @error('parent_page')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="rsd-product-actions">
                    <button type="submit" class="rsd-btn primary">{{ $post ? 'Update Product' : 'Add Product' }}</button>
                    <a href="{{ route('products') }}" class="rsd-btn">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@section('page-js')
<script src="https://cdn.jsdelivr.net/npm/tinymce@8.9.2/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/product-form.js') }}?v=20260930-2"></script>
@endsection
