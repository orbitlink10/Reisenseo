@extends('dashboard.layouts.app')

@section('title', 'Products')

@section('content')
@php
    $pages = \App\Models\Page::all();
@endphp

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
        <span class="rsd-eyebrow">Catalog Admin</span>
        <h1>Products</h1>
        <p>Create and manage your product catalog.</p>
    </div>
</header>

<div class="rsd-grid-2">
    <div>
        <section class="rsd-panel" id="add-product">
            <div class="rsd-panel__head">
                <div>
                    <p class="rsd-eyebrow">New Entry</p>
                    <h2>Add Product</h2>
                </div>
            </div>
            <div class="rsd-panel__body">
                <form method="POST" action="{{ route('anew_product') }}">
                    @csrf
                    <input type="hidden" name="site_id" value="{{ Auth::user()->site_id }}">

                    <div class="rsd-form-group">
                        <label>Title</label>
                        <input type="text" class="rsd-form-control @error('title') is-invalid @enderror" name="title" placeholder="Product title" value="{{ old('title') }}" required>
                        @error('title')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="rsd-form-group">
                        <label>Description</label>
                        <textarea class="content @error('description') is-invalid @enderror" name="description">{{ old('description') }}</textarea>
                    </div>

                    <div class="rsd-form-grid">
                        <div class="rsd-form-group">
                            <label>Product Cost</label>
                            <input type="number" value="{{ old('cost', 0) }}" class="rsd-form-control @error('cost') is-invalid @enderror" name="cost" required>
                            @error('cost')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="rsd-form-group">
                            <label>Category</label>
                            <select class="rsd-form-control @error('category_id') is-invalid @enderror" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="rsd-form-group">
                        <label>Parent Page</label>
                        <select class="rsd-form-control" name="parent_page">
                            @foreach ($pages as $category)
                                <option value="{{ $category->id }}" {{ Auth::user()->page_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="rsd-btn primary"><i class="fa fa-plus"></i> Submit Product</button>
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

    <aside>
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
<script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js"></script>
<script>
    (function () {
        var el = document.querySelector('textarea.content');
        if (el && window.ClassicEditor) {
            ClassicEditor.create(el).catch(function (error) { console.error(error); });
        }
    })();
</script>
@endsection
