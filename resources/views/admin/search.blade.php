@extends('dashboard.layouts.app')

@section('title', 'Search Categories')

@section('content')
@include('dashboard.partials.flash')

<header class="rsd-page-head">
    <div>
        <span class="rsd-eyebrow">Catalog</span>
        <h1>Search Categories</h1>
        <p>
            @if($term)
                Results for "{{ $term }}"
            @else
                Enter a term to search categories.
            @endif
        </p>
    </div>
    <form class="rsd-search" action="{{ route('search') }}" method="GET" style="max-width:360px; width:100%;">
        <button type="submit" class="rsd-search__submit" aria-label="Search"><i class="fa fa-search"></i></button>
        <input type="text" name="search" value="{{ $term }}" placeholder="Search categories..." autocomplete="off" autofocus>
    </form>
</header>

<section class="rsd-panel">
    <div class="rsd-panel__head">
        <div><p class="rsd-eyebrow">Catalog</p><h2>Categories ({{ $categories->count() }})</h2></div>
    </div>
    <div class="rsd-table-wrap">
        <table class="rsd-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Actions</th>
                </tr>
            </thead>
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
                    <tr><td colspan="4" class="rsd-empty">{{ $term ? 'No matching categories.' : 'Start typing to search categories.' }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
