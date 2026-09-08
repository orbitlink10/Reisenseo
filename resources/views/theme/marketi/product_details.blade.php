@extends('theme.marketi.header')

@section('title', $product->title . ' | ' . get_option(site_id().'_site_name'))

@section('meta_description')
@if(!empty($product->meta_description))
{{ substr(trim(preg_replace('/\s\s+/', ' ', strip_tags($product->meta_description))), 0, 160) }}
@else
{{ $product->title }} — buy genuine networking and CCTV equipment in Kenya with fast delivery and local support.
@endif
@endsection

@section('canonical', route('shop_description', $product->slug))

@section('content')
@php
  $category = $product->category_id ? \App\Models\Category::find($product->category_id) : null;
  $featured = \App\Models\Upload::wherePostId($product->id)->whereStatus('1')->first();
@endphp

@php
  $schemaData = [
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $product->title,
    'image' => $featured ? url($featured->file_path) : asset('resources/views/theme/marketi/assets/images/placeholder/product.png'),
    'description' => !empty($product->meta_description) ? strip_tags($product->meta_description) : $product->title,
  ];
  if ($category) {
    $schemaData['category'] = $category->name;
  }
  if (is_numeric($product->cost) && (float) $product->cost > 0) {
    $schemaData['offers'] = [
      '@type' => 'Offer',
      'priceCurrency' => 'KES',
      'price' => $product->cost,
      'availability' => 'https://schema.org/InStock',
      'url' => route('shop_description', $product->slug),
    ];
  }
@endphp
<script type="application/ld+json">
@php echo json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); @endphp
</script>
@if($category)
@php
  $breadcrumbData = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
      ['@type' => 'ListItem', 'position' => 2, 'name' => 'Shop', 'item' => route('shop')],
      ['@type' => 'ListItem', 'position' => 3, 'name' => $category->name, 'item' => route('shops_filter', $category->slug)],
      ['@type' => 'ListItem', 'position' => 4, 'name' => $product->title],
    ],
  ];
@endphp
<script type="application/ld+json">
@php echo json_encode($breadcrumbData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); @endphp
</script>
@endif
<main>

  {{-- ===== Hero / Banner (lightweight, consistent with site) ===== --}}
  <section
    class="banner-area bg-image paralax__animation"
    data-background="{{ asset('resources/views/theme/marketi/assets/images/banner/banner-bg.png') }}"
    style="background-image:url('{{ asset('resources/views/theme/marketi/assets/images/banner/banner-bg.png') }}');"
    aria-label="Product banner"
  >
    <div class="container">
      <div class="banner__content py-4">
        @if($category)
          <nav aria-label="Breadcrumb" class="mb-2 small">
            <a href="{{ url('/') }}" class="text-decoration-none">Home</a>
            <span aria-hidden="true"> / </span>
            <a href="{{ route('shop') }}" class="text-decoration-none">Shop</a>
            <span aria-hidden="true"> / </span>
            <a href="{{ route('shops_filter', $category->slug) }}" class="text-decoration-none">{{ $category->name }}</a>
          </nav>
        @endif
        <h1 class="h3 mb-2">{{ $product->title }}</h1>
        <span class="badge bg-success py-2 px-3">{{ price($product->cost) }}</span>
      </div>
    </div>
  </section>

  {{-- ===== Product Content ===== --}}
  <section class="pt-80 pb-120">
    <div class="container">

      {{-- Admin Edit Link --}}
      @auth
        @if(method_exists(auth()->user(), 'is_admin') && auth()->user()->is_admin())
          <div class="mb-3 text-end">
            <a href="{{ route('edit_post', $product->id) }}" target="_blank" class="btn btn-sm btn-secondary">
              Edit Product
            </a>
          </div>
        @endif
      @endauth

      {{-- Product Card --}}
      <div class="card shadow-sm mb-4">
        <div class="row g-0">
          {{-- Gallery --}}
          <div class="col-md-5 p-3">
            <div id="productCarousel" class="carousel slide border rounded" data-bs-ride="true" data-bs-touch="true">
              <div class="carousel-inner">
                @php $imgs = $uploads ?? collect(); @endphp

                @forelse($imgs as $upload)
                  <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <img
                      src="{{ url($upload->file_path) }}"
                      class="d-block w-100"
                      alt="{{ $product->title }} image {{ $loop->iteration }}"
                      @if($loop->first) loading="eager" fetchpriority="high" @else loading="lazy" @endif
                      style="aspect-ratio:1/1; object-fit:contain; background:#fff;"
                      width="1000" height="1000"
                    >
                  </div>
                @empty
                  <div class="carousel-item active">
                    <img
                      src="{{ asset('resources/views/theme/marketi/assets/images/placeholder/product.png') }}"
                      class="d-block w-100"
                      alt="Placeholder image"
                      loading="eager"
                      style="aspect-ratio:1/1; object-fit:contain; background:#fff;"
                      width="1000" height="1000"
                    >
                  </div>
                @endforelse
              </div>

              @if($imgs->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev" aria-label="Previous">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next" aria-label="Next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
              @endif
            </div>

            {{-- Thumbnails --}}
            @if($imgs->count() > 1)
              <div class="d-flex flex-wrap justify-content-center gap-2 mt-3">
                @foreach($imgs as $upload)
                  <button
                    class="p-0 border-0 bg-transparent"
                    type="button"
                    data-bs-target="#productCarousel"
                    data-bs-slide-to="{{ $loop->index }}"
                    aria-label="Go to image {{ $loop->iteration }}"
                  >
                    <img
                      src="{{ url($upload->file_path) }}"
                      class="img-thumbnail"
                      alt="{{ $product->title }} thumbnail {{ $loop->iteration }}"
                      loading="lazy"
                      style="width:60px; height:60px; object-fit:cover;"
                      width="60" height="60"
                    >
                  </button>
                @endforeach
              </div>
            @endif
          </div>

          {{-- Details --}}
          <div class="col-md-7">
            <div class="card-body">
              <h2 class="h4 fw-bold mb-2">{{ $product->title }}</h2>
              <p class="h5 text-primary mb-3">{{ price($product->cost) }}</p>
              <hr>
              <h5 class="mt-3 mb-2">Description</h5>
              <p class="text-muted mb-4">{!! $product->meta_description !!}</p>

              <a href="{{ route('pregister', ['id' => $product->id]) }}" class="btn btn-primary btn-lg">
                <i class="fa fa-shopping-cart me-2"></i> Buy Now
              </a>
            </div>
          </div>
        </div>
      </div>

      {{-- Full Description --}}
      <div class="card">
        <div class="card-body">
          {!! $product->description !!}
        </div>
      </div>

      {{-- Related / category navigation --}}
      @if($category)
        <div class="d-flex align-items-center justify-content-between mt-4">
          <a href="{{ route('shops_filter', $category->slug) }}" class="btn btn-outline-primary">
            More {{ $category->name }} <i class="fa fa-arrow-right ms-2"></i>
          </a>
          <a href="{{ route('shop') }}" class="btn btn-outline-secondary">All Products</a>
        </div>
      @endif

    </div>
  </section>

</main>
@endsection

@push('scripts')
<script>
  // Apply data-background fallback if not set inline
  document.querySelectorAll('[data-background]').forEach(function(el){
    if (!el.style.backgroundImage) {
      const bg = el.getAttribute('data-background');
      if (bg) el.style.backgroundImage = 'url(' + bg + ')';
    }
  });
</script>
@endpush
