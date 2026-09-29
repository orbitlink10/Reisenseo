@extends('dashboard.layouts.app')

@section('title', $category ? 'Edit Category' : 'Create Category')
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
        <h1>{{ $category ? 'Edit Category' : 'Create Category' }}</h1>
    </div>
</header>

<div class="rsd-product-layout">
    <section class="rsd-panel rsd-product-card" aria-label="{{ $category ? 'Edit category' : 'Create category' }}">
        <div class="rsd-panel__body">
            <form id="category-form" method="POST" action="{{ $category ? route('update_category') : route('store_category') }}" enctype="multipart/form-data">
                @csrf
                @if ($category)
                    <input type="hidden" name="cat_id" value="{{ $category->id }}">
                @endif

                <div class="rsd-form-group">
                    <label for="category-name">Name <span class="rsd-required" aria-hidden="true">*</span></label>
                    <input id="category-name" type="text" class="rsd-form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $category->name ?? '') }}" placeholder="Enter category name" required>
                    @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="rsd-form-group">
                    <label for="category-meta-description">Meta description</label>
                    <textarea id="category-meta-description" class="rsd-form-control @error('meta_description') is-invalid @enderror" name="meta_description" rows="4" placeholder="Enter category meta description">{{ old('meta_description', $category->meta_description ?? '') }}</textarea>
                    @error('meta_description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="rsd-form-group rsd-product-description">
                    <label for="category-description">Description (Optional)</label>
                    <textarea id="category-description" class="rsd-form-control @error('description') is-invalid @enderror" name="description" rows="14" placeholder="Enter category description">{{ old('description', $category->description ?? '') }}</textarea>
                    <p id="category-editor-status" class="rsd-editor-status" role="status" hidden></p>
                    @error('description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="rsd-form-group">
                    <label for="category-photo">Photo (Optional)</label>
                    @if (!empty($category?->photo_url))
                        <div style="margin-bottom:12px;">
                            <img src="{{ $category->photo_url }}" alt="{{ $category->name }}" style="max-width:240px; border-radius:12px; border:1px solid #e5e7eb;">
                        </div>
                    @endif
                    <input id="category-photo" type="file" class="rsd-form-control" name="photo" accept="image/*">
                    @error('photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="rsd-product-actions">
                    <button type="submit" class="rsd-btn primary">{{ $category ? 'Update Category' : 'Save Category' }}</button>
                    <a href="{{ route('categories') }}" class="rsd-btn">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@section('page-js')
<script src="https://cdn.jsdelivr.net/npm/tinymce@8.9.2/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/category-form.js') }}?v=20260929"></script>
@endsection
