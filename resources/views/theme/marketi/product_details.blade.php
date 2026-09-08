@extends('theme.marketi.header')

@section('title', $product->title)

@section('content')
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
