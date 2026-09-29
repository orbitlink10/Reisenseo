@extends('dashboard.layouts.app')

@section('title', 'Categories')
@section('body-class', 'category-admin')

@section('page-css')
<link rel="stylesheet" href="{{ asset('assets/css/category-admin.css') }}?v=20260929">
@endsection

@section('content')
@include('dashboard.partials.flash')

<section class="category-page-head">
    <h1 class="category-page-title">Categories</h1>
    <a class="category-primary-pill" href="{{ route('create_category') }}">Create New Category</a>
</section>

<section class="category-list-panel">
    <div class="category-table-wrap">
        <table class="category-data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->category_slug ?: $category->slug }}</td>
                        <td>
                            @if (!empty($category->photo_url))
                                <img class="category-thumb" src="{{ $category->photo_url }}" alt="{{ $category->name }}">
                            @else
                                <div class="category-thumb category-thumb--placeholder">No Image</div>
                            @endif
                        </td>
                        <td>
                            <div class="category-action-row">
                                <a class="category-row-action tone-info" href="{{ route('shops_filter', $category->category_slug ?: $category->slug) }}" target="_blank" rel="noopener noreferrer">Preview</a>
                                <a class="category-row-action tone-warning" href="{{ route('edit_category', $category->id) }}">Update</a>
                                <form method="POST" action="{{ route('delete_cat') }}" onsubmit="return confirm('Delete this category?');">
                                    @csrf
                                    <input type="hidden" name="cat_id" value="{{ $category->id }}">
                                    <button type="submit" class="category-row-action tone-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="category-empty-cell">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if (method_exists($categories, 'links'))
        <div class="rsd-pagination">{!! $categories->links('pagination::bootstrap-4') !!}</div>
    @endif
</section>
@endsection
