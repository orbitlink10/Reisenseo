@extends('theme.marketi.header')

{{-- =========================
     SEO / Meta
========================= --}}
@section('title')
  @if(isset($currentCategory))
    {{ $currentCategory->name }} – Best Products in Kenya | {{ domain_name() }}
  @else
    Best Sellers in Kenya | {{ domain_name() }}
  @endif
@endsection

@section('meta_description')
  @if(isset($currentCategory) && !empty($currentCategory->meta_description))
    {{ $currentCategory->meta_description }}
  @else
    Discover the best-selling products in Kenya at {{ domain_name() }}. Shop our curated collection of top-rated items with fast delivery and local support.
  @endif
@endsection

@section('meta_keywords')
  @if(isset($currentCategory) && !empty($currentCategory->meta_keywords))
    {{ $currentCategory->meta_keywords }}
  @else
    best sellers, Kenya marketplace, online shopping, top products, {{ domain_name() }}
  @endif
@endsection

{{-- =========================
     Page Content
========================= --}}
@section('content')
<main>
  {{-- Page Banner (aligned with marketi hero style) --}}
  <section
    class="banner-area bg-image paralax__animation"
    data-background="{{ asset('resources/views/theme/marketi/assets/images/banner/banner-bg.png') }}"
    style="background-image:url('{{ asset('resources/views/theme/marketi/assets/images/banner/banner-bg.png') }}');"
    aria-label="Category banner"
  >
    <div class="container">
      <div class="banner__content py-5">
        <h4 class="mb-10 wow fadeInRight">
          @if(isset($currentCategory))
            Curated Picks in {{ $currentCategory->name }}
          @else
            Shop Kenya’s Best Sellers
          @endif
        </h4>
        <h1 class="wow fadeInUp">
          @if(isset($currentCategory))
            {{ $currentCategory->name }}
          @else
            Welcome to the <span class="text-primary">{{ domain_name() }}</span> marketplace!
          @endif
        </h1>
        @if(isset($currentCategory) && !empty($currentCategory->meta_description))
          <p class="mt-3 wow fadeInUp">{!! $currentCategory->meta_description !!}</p>
        @else
          <p class="mt-3 wow fadeInUp">Browse top-rated items handpicked for performance, value, and reliability.</p>
        @endif
      </div>
    </div>
  </section>

  {{-- Shop + Sidebar (adapts to the marketi layout used above) --}}
  <section class="product-area pt-120 pb-120" aria-labelledby="shopHeading">
    <div class="container">
      <div class="row g-4">
        {{-- Sidebar: Categories --}}
        <aside class="col-lg-3" aria-label="Product Categories">
          <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0">
              <h5 class="mb-0">Categories</h5>
            </div>
            <div class="list-group list-group-flush">
              <a
                href="{{ route('shop') }}"
                class="list-group-item list-group-item-action {{ !isset($currentCategory) ? 'active' : '' }}"
                aria-current="{{ !isset($currentCategory) ? 'true' : 'false' }}"
              >
                All Products
              </a>

              @php
                $cats = $categories ?? collect();
              @endphp

              @foreach($cats as $cat)
                <a
                  href="{{ route('shops_filter', $cat->slug) }}"
                  class="list-group-item list-group-item-action {{ (isset($currentCategory) && $currentCategory->slug === $cat->slug) ? 'active' : '' }}"
                  aria-current="{{ (isset($currentCategory) && $currentCategory->slug === $cat->slug) ? 'true' : 'false' }}"
                >
                  {{ $cat->name }}
                </a>
              @endforeach
            </div>
          </div>
        </aside>

        {{-- Main Product Grid --}}
        <section class="col-lg-9">
          <div class="section-header__wrp mb-3">
            <div class="section-header d-flex align-items-center justify-content-between">
              <div>
                <h5 class="wow fadeInUp">{{ isset($currentCategory) ? $currentCategory->name : 'Latest Products' }}</h5>
                <h2 id="shopHeading" class="wow fadeInUp">
                  {{ isset($currentCategory) ? 'Shop ' . $currentCategory->name : 'Shop Now' }}
                </h2>
              </div>
            </div>
          </div>

          <div class="row g-4">
            @forelse($posts as $post)
              <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                <div class="card h-100 text-center p-3">
                  @php
                    $thumb = \Illuminate\Support\Facades\Cache::remember("shop_thumb_{$post->id}", 1800, function() use ($post) {
                      return \App\Models\Upload::wherePostId($post->id)->whereStatus('1')->select('file_path')->first();
                    });
                    $imgSrc = $thumb && $thumb->file_path ? url($thumb->file_path) : asset('resources/views/theme/marketi/assets/images/placeholder/product.png');
                  @endphp

                  <a href="{{ route('shop_description', $post->slug) }}" class="d-block mb-3" aria-label="View {{ $post->title }}">
                    <img
                      src="{{ $imgSrc }}"
                      class="img-fluid"
                      alt="{{ $post->title }}"
                      loading="lazy"
                      width="480" height="480"
                      style="object-fit:cover; aspect-ratio: 1/1;"
                    >
                  </a>

                  <h6 class="mb-1">
                    <a href="{{ route('shop_description', $post->slug) }}">{{ $post->title }}</a>
                  </h6>

                  <p class="text-primary fw-bold mb-2">{{ price($post->cost) }}</p>

                  <div class="d-flex align-items-center justify-content-center gap-2 small text-warning" aria-label="Product rating">
                    <span aria-hidden="true">★ ★ ★ ★ ☆</span>
                    <span class="visually-hidden">Rated 4 out of 5</span>
                  </div>

                  <div class="mt-3">
                    <a href="{{ route('shop_description', $post->slug) }}" class="btn btn-primary btn-sm">
                      View Details
                    </a>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12">
                <div class="alert alert-info mb-0" role="status">
                  No products found in this category. Please try another category.
                </div>
              </div>
            @endforelse
          </div>

          {{-- Category long description (SEO friendly) --}}
          @if(isset($currentCategory) && !empty($currentCategory->description))
            <div class="card mt-4 border-0 shadow-sm">
              <div class="card-body">
                {!! $currentCategory->description !!}
              </div>
            </div>
          @endif

          {{-- Extra CMS block (kept from the old layout) --}}
          @if(function_exists('get_option') && get_option(site_id().'_show_21_content'))
            <div class="card mt-4 border-0 shadow-sm">
              <div class="card-body">
                {!! get_option(site_id().'_show_21_content') !!}
              </div>
            </div>
          @endif

          {{-- Pagination --}}
          <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
          </div>
        </section>
      </div>
    </div>
  </section>
</main>
@endsection

{{-- =========================
     Page Styles / Scripts
========================= --}}
@push('styles')
<style>
  .list-group-item.active {
    background-color: #00a86b;
    border-color: #00a86b;
    color: #fff;
  }
  .card img { border-radius: .5rem; }
</style>
@endpush

@push('scripts')
<script>
  // Ensure data-background is applied (same helper used in the other page)
  document.querySelectorAll('[data-background]').forEach(function(el){
    if (!el.style.backgroundImage) {
      const bg = el.getAttribute('data-background');
      if (bg) el.style.backgroundImage = 'url(' + bg + ')';
    }
  });
</script>
@endpush
