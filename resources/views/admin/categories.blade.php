@extends('dashboard.layouts.app')

@section('title', 'Categories')

@section('page-css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection

@section('content')
@include('dashboard.partials.flash')

<header class="rsd-page-head">
    <div>
        <span class="rsd-eyebrow">Catalog Admin</span>
        <h1>Categories</h1>
        <p>Organize your products and services into categories.</p>
    </div>
    <a class="rsd-btn primary" href="#add-category"><i class="fa fa-plus"></i> Create Category</a>
</header>

<div class="rsd-grid-2">
    <section class="rsd-panel">
        <div class="rsd-panel__head">
            <div>
                <p class="rsd-eyebrow">Catalog</p>
                <h2>All Categories</h2>
            </div>
        </div>
        <div class="rsd-table-wrap">
            <table class="rsd-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td data-label="ID" class="rsd-cell-main">#{{ $category->id }}</td>
                            <td data-label="Image">
                                <span class="rsd-thumb">
                                    @if (!empty($category->photo_url))
                                        <img src="{{ $category->photo_url }}" alt="{{ $category->name }}">
                                    @else
                                        {{ strtoupper(mb_substr($category->name, 0, 1)) }}
                                    @endif
                                </span>
                            </td>
                            <td data-label="Name">
                                <a class="rsd-cell-main" href="{{ route('shops_filter', $category->category_slug) }}">{{ $category->name }}</a>
                            </td>
                            <td data-label="Slug" class="muted">{{ $category->category_slug }}</td>
                            <td data-label="Actions">
                                <div class="rsd-actions">
                                    <a class="rsd-action" data-bs-toggle="modal" data-bs-target="#edit-cat{{ $category->id }}" title="Edit"><i class="fa fa-edit"></i></a>
                                    <a class="rsd-action danger" data-bs-toggle="modal" data-bs-target="#delete-cat{{ $category->id }}" title="Delete"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="rsd-empty">No categories yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if (method_exists($categories, 'links'))
            <div class="rsd-pagination">{!! $categories->links('pagination::bootstrap-4') !!}</div>
        @endif
    </section>

    <aside>
        <section class="rsd-panel" id="add-category">
            <div class="rsd-panel__head">
                <div>
                    <p class="rsd-eyebrow">New Entry</p>
                    <h2>Add Category</h2>
                </div>
            </div>
            <div class="rsd-panel__body">
                <form method="POST" action="{{ route('new_category') }}">
                    @csrf
                    <div class="rsd-form-group">
                        <label>Name</label>
                        <input type="text" class="rsd-form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="rsd-form-group">
                        <label>Category Type</label>
                        <select class="rsd-form-control" name="cat_type">
                            <option value="">Select Category</option>
                            @foreach ($tasks as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="rsd-btn primary">Submit</button>
                </form>
            </div>
        </section>
    </aside>
</div>

{{-- Modals --}}
@foreach ($categories as $category)
    {{-- Delete modal --}}
    <div class="modal fade" id="delete-cat{{ $category->id }}">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius:16px; border:none; box-shadow:0 20px 50px rgba(16,24,40,.2);">
                <div class="modal-header"><h6 class="modal-title">Delete #{{ $category->id }}</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button></div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('delete_cat') }}">
                        @csrf
                        <input type="hidden" name="cat_id" value="{{ $category->id }}">
                        <p>Are you sure you want to delete this category?</p>
                        <button type="submit" class="rsd-btn danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit modal --}}
    <div class="modal fade" id="edit-cat{{ $category->id }}">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border-radius:16px; border:none; box-shadow:0 20px 50px rgba(16,24,40,.2);">
                <div class="modal-header"><h6 class="modal-title">Edit Category #{{ $category->id }}</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button></div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('update_category') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="cat_id" value="{{ $category->id }}">

                        <div class="rsd-form-group">
                            <label>Name</label>
                            <input type="text" class="rsd-form-control" name="name" value="{{ $category->name }}" required>
                        </div>
                        <div class="rsd-form-group">
                            <label>Meta Description</label>
                            <input type="text" class="rsd-form-control" name="meta_description" value="{{ $category->meta_description }}">
                        </div>
                        <div class="rsd-form-group">
                            <label>Category Type</label>
                            <select class="rsd-form-control" name="cat_type">
                                <option value="{{ $category->cat_type }}" selected>{{ service($category->cat_type)->name ?? 'N/A' }}</option>
                                @foreach ($tasks as $task)
                                    <option value="{{ $task->id }}">{{ $task->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="rsd-form-group">
                            <label>Description</label>
                            <textarea class="category-editor" name="description">{{ $category->description }}</textarea>
                        </div>
                        <button type="submit" class="rsd-btn primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection

@section('page-js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(function () {
        $('.category-editor').summernote({
            placeholder: 'Type your description here',
            tabsize: 2,
            height: 240,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endsection
