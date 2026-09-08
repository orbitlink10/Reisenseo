@extends('layouts.frontbar')

@section('title', 'Shop')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Latest Products</h1>
    <div class="row">
        @forelse($products as $product)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $product->title }}</h5>
                    <p class="card-text mt-auto">{{ price($product->cost ?? 0) }}</p>
                    <a href="{{ url('buy-product/' . $product->id) }}" class="btn btn-primary mt-2">View</a>
                </div>
            </div>
        </div>
        @empty
        <p>No products available.</p>
        @endforelse
    </div>
</div>
@endsection
