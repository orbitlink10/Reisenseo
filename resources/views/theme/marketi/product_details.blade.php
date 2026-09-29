@extends('theme.marketi.header')

@section('title', e(($product->meta_title ?: $product->title) . ' | ' . get_option(site_id().'_site_name')))
@section('meta_description', e(strip_tags($product->meta_description ?: $product->title)))
@section('canonical', route('shop_description', $product->slug))
@section('og_type', 'product')
@section('og_title', $product->meta_title ?: $product->title)
@section('og_description', $product->meta_description ?: $product->title)
@if ($uploads->isNotEmpty())
    @section('og_image', url($uploads->first()->file_path))
@endif

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/product-details.css') }}?v=20260930">
@endpush

@section('content')
@php
    $category = $product->category_id ? \App\Models\Category::find($product->category_id) : null;
    $images = $uploads ?? collect();
    $mainImage = $images->first();
    $currency = site_option('currency_sign', 'KES');
    $hasPrice = is_numeric($product->cost) && (float) $product->cost > 0;
    $onSale = $hasPrice && (float) $product->marked_price > (float) $product->cost;
    $stockKnown = $product->quantity !== null;
    $inStock = $stockKnown && (int) $product->quantity > 0;
    $stockLabel = $stockKnown ? ($inStock ? 'In stock' : 'Out of stock') : 'Confirm availability';
    $phone = site_option('phone', '+254 714 804 532');
    $phoneHref = preg_replace('/[^0-9+]/', '', $phone);
    $schema = [
        '@context' => 'https://schema.org', '@type' => 'Product',
        'name' => $product->title,
        'description' => $product->meta_description ?: $product->title,
        'url' => route('shop_description', $product->slug),
    ];
    if ($images->isNotEmpty()) $schema['image'] = $images->map(fn ($image) => url($image->file_path))->values()->all();
    if ($category) $schema['category'] = $category->name;
    if ($hasPrice) {
        $schema['offers'] = [
            '@type' => 'Offer', 'priceCurrency' => 'KES',
            'price' => number_format((float) $product->cost, 2, '.', ''),
            'url' => route('shop_description', $product->slug),
        ];
        if ($stockKnown) $schema['offers']['availability'] = 'https://schema.org/'.($inStock ? 'InStock' : 'OutOfStock');
    }
    $breadcrumbs = [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Shop', 'item' => route('shop')],
    ];
    if ($category) $breadcrumbs[] = ['@type' => 'ListItem', 'position' => 3, 'name' => $category->name, 'item' => route('shops_filter', $category->slug)];
    $breadcrumbs[] = ['@type' => 'ListItem', 'position' => count($breadcrumbs) + 1, 'name' => $product->title];
@endphp
<script type="application/ld+json">{!! json_encode($schema, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES) !!}</script>
<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $breadcrumbs], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES) !!}</script>

<div class="rs-product">
    <div class="container">
        <nav class="rs-product__breadcrumbs" aria-label="Breadcrumb">
            <a href="{{ url('/') }}">Home</a><span aria-hidden="true">/</span>
            <a href="{{ route('shop') }}">Shop</a><span aria-hidden="true">/</span>
            @if ($category)
                <a href="{{ route('shops_filter', $category->slug) }}">{{ $category->name }}</a><span aria-hidden="true">/</span>
            @endif
            <span aria-current="page">{{ $product->title }}</span>
        </nav>
        @auth
            @if (auth()->user()->is_admin())
                <div class="rs-product__edit"><a href="{{ route('edit_product', $product->id) }}">Edit product <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></a></div>
            @endif
        @endauth

        <div class="rs-product__overview">
            <section class="rs-gallery" aria-label="Product images" data-product-gallery>
                <div class="rs-gallery__stage">
                    @if ($onSale)
                        <span class="rs-gallery__sale">Save {{ round((1 - (float) $product->cost / (float) $product->marked_price) * 100) }}%</span>
                    @endif
                    @if ($mainImage)
                        <a class="rs-gallery__zoom" href="{{ url($mainImage->file_path) }}" target="_blank" rel="noopener" data-gallery-zoom aria-label="Enlarge {{ $product->title }} image">
                            <img id="product-main-image" src="{{ url($mainImage->file_path) }}" alt="{{ $product->title }}" width="800" height="800" fetchpriority="high">
                            <span class="rs-gallery__zoom-icon"><i class="fa-solid fa-magnifying-glass-plus" aria-hidden="true"></i></span>
                        </a>
                    @else
                        <div class="rs-gallery__empty"><i class="fa-regular fa-image" aria-hidden="true"></i><span>Product image coming soon</span></div>
                    @endif
                </div>
                @if ($images->count() > 1)
                    <div class="rs-gallery__thumbnails" aria-label="Choose a product image">
                        @foreach ($images as $image)
                            <a href="{{ url($image->file_path) }}" class="rs-gallery__thumbnail {{ $loop->first ? 'is-active' : '' }}" data-gallery-thumbnail data-image-alt="{{ $product->title }} — image {{ $loop->iteration }}" aria-label="View image {{ $loop->iteration }}" @if ($loop->first) aria-current="true" @endif>
                                <img src="{{ url($image->file_path) }}" alt="{{ $product->title }} thumbnail {{ $loop->iteration }}" width="80" height="80" loading="lazy">
                            </a>
                        @endforeach
                    </div>
                @endif
                @if ($mainImage)
                    <p class="rs-gallery__hint">Select an image to view it. Click the main image to enlarge.</p>
                    <dialog class="rs-gallery__dialog" aria-label="Enlarged product image" data-gallery-dialog>
                        <button type="button" data-gallery-close aria-label="Close enlarged image">&times;</button>
                        <img src="{{ url($mainImage->file_path) }}" alt="{{ $product->title }}" width="1000" height="1000">
                    </dialog>
                @endif
            </section>

            <section class="rs-product__summary" aria-labelledby="product-title">
                @if ($category)<a class="rs-product__category" href="{{ route('shops_filter', $category->slug) }}">{{ $category->name }}</a>@endif
                <h1 id="product-title">{{ $product->title }}</h1>
                <div class="rs-product__stock {{ $inStock ? 'is-available' : '' }}"><span aria-hidden="true"></span>{{ $stockLabel }}</div>
                <div class="rs-product__price">
                    @if ($hasPrice)
                        <strong>{{ $currency }} {{ number_format((float) $product->cost, 2) }}</strong>
                        @if ($onSale)<del aria-label="Previous price">{{ $currency }} {{ number_format((float) $product->marked_price, 2) }}</del>@endif
                    @else
                        <strong>Contact us for a price</strong>
                    @endif
                </div>
                @if ($onSale)<p class="rs-product__saving">You save {{ $currency }} {{ number_format((float) $product->marked_price - (float) $product->cost, 2) }}</p>@endif
                @if ($product->meta_description)<p class="rs-product__intro">{{ strip_tags($product->meta_description) }}</p>@endif
                <a class="rs-product__details-link" href="#product-details">View product details <i class="fa-solid fa-arrow-down" aria-hidden="true"></i></a>

                <div class="rs-product__purchase">
                    @if ($hasPrice && (! $stockKnown || $inStock))
                        <a class="rs-product__button rs-product__button--primary" href="{{ route('pregister', ['id' => $product->id]) }}"><i class="fa-solid fa-bag-shopping" aria-hidden="true"></i> Buy Now</a>
                    @elseif ($stockKnown && ! $inStock)
                        <button class="rs-product__button rs-product__button--primary" type="button" disabled>Out of stock</button>
                    @endif
                    <a class="rs-product__button rs-product__button--outline" href="tel:{{ $phoneHref }}"><i class="fa-solid fa-phone" aria-hidden="true"></i> Enquire about this product</a>
                </div>
                <dl class="rs-product__meta">
                    @if ($category)<div><dt>Category</dt><dd><a href="{{ route('shops_filter', $category->slug) }}">{{ $category->name }}</a></dd></div>@endif
                    <div><dt>Availability</dt><dd>{{ $inStock ? (int) $product->quantity.' available' : $stockLabel }}</dd></div>
                </dl>
                <div class="rs-product__help"><i class="fa-solid fa-headset" aria-hidden="true"></i><div><strong>Need help choosing?</strong><p>Talk to our team at <a href="tel:{{ $phoneHref }}">{{ $phone }}</a></p></div></div>
            </section>
        </div>

        <section class="rs-product__details" id="product-details" aria-label="Product details" data-product-tabs>
            <nav class="rs-product__tabs" aria-label="Product information">
                <a href="#product-description-panel" id="product-description-tab" data-product-tab>Product details</a>
                <a href="#product-information-panel" id="product-information-tab" data-product-tab>Additional information</a>
            </nav>
            <div id="product-description-panel" class="rs-product__panel rs-product__description" data-product-panel>
                <h2>Product details</h2>
                @if (trim(strip_tags($product->description ?? '')) !== '' || preg_match('/<(img|video|iframe)\b/i', $product->description ?? ''))
                    {!! preg_replace('/<h1(\s[^>]*)?>(.*?)<\/h1>/is', '<h2$1>$2</h2>', $product->description) !!}
                @else
                    <p>Contact our team for more information about {{ $product->title }}.</p>
                @endif
            </div>
            <div id="product-information-panel" class="rs-product__panel" data-product-panel>
                <h2>Additional information</h2>
                <table class="rs-product__specifications"><tbody>
                    <tr><th scope="row">Product</th><td>{{ $product->title }}</td></tr>
                    @if ($category)<tr><th scope="row">Category</th><td>{{ $category->name }}</td></tr>@endif
                    <tr><th scope="row">Price</th><td>{{ $hasPrice ? $currency.' '.number_format((float) $product->cost, 2) : 'Contact us for a price' }}</td></tr>
                    <tr><th scope="row">Availability</th><td>{{ $stockLabel }}</td></tr>
                </tbody></table>
            </div>
        </section>
        <div class="rs-product__browse"><span>Keep exploring</span><a href="{{ $category ? route('shops_filter', $category->slug) : route('shop') }}">{{ $category ? 'More in '.$category->name : 'All products' }} <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/product-details.js') }}?v=20260930" defer></script>
@endpush
