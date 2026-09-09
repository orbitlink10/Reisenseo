@php
    $img = $post->uploads->first();
    $imgSrc = $img ? url($img->file_path) : ($placeholder ?? asset('resources/views/theme/marketi/assets/images/banner/banner-bg.png'));
@endphp
<div class="product-card">
    <div class="product-thumb">
        @if($loop->first)
            <span class="badge-hot">Hot</span>
        @endif
        <a href="{{ route('shop_description', $post->slug) }}" aria-label="View {{ $post->title }}">
            <img src="{{ $imgSrc }}" alt="{{ $post->title }}" loading="lazy">
        </a>
    </div>
    <div class="product-content">
        <h3 class="product-title">
            <a href="{{ route('shop_description', $post->slug) }}">{{ $post->title }}</a>
        </h3>
        <span class="price">
            <span class="amount">{{ get_currency() }} {{ number_format((float) $post->cost) }}</span>
            <small class="suffix">Excl. Tax</small>
        </span>
        <a href="{{ route('pregister', ['id' => $post->id]) }}" class="add-to-cart">Add to cart</a>
    </div>
</div>
