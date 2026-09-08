@extends('theme.marketi.header')
@section('title', 'Blog | ' . get_option(site_id().'_site_name'))
@section('meta_description', 'Read guides and insights on networking equipment, CCTV security systems and IT infrastructure in Kenya from ' . get_option(site_id().'_site_name') . '.')

@section('content')
<main>
  <section class="banner-area bg-image paralax__animation"
    data-background="{{ asset('resources/views/theme/marketi/assets/images/banner/banner-bg.png') }}"
    style="background-image:url('{{ asset('resources/views/theme/marketi/assets/images/banner/banner-bg.png') }}');">
    <div class="container">
      <div class="banner__content py-5">
        <h1 class="wow fadeInUp">Blog</h1>
        <p class="mt-3 wow fadeInUp">Guides and insights on networking and CCTV equipment.</p>
      </div>
    </div>
  </section>

  <section class="pt-80 pb-120">
    <div class="container">
      <div class="row g-4">
        @forelse($posts as $post)
          <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
              <div class="card-body">
                <h5 class="card-title">
                  <a href="{{ route('blog_single', $post->slug) }}">{{ $post->title }}</a>
                </h5>
                <p class="text-muted small mb-0">
                  {{ substr(trim(preg_replace('/\s\s+/', ' ', strip_tags($post->description))), 0, 140) }}
                </p>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <div class="alert alert-info mb-0">No posts found yet.</div>
          </div>
        @endforelse
      </div>

      <div class="d-flex justify-content-center mt-4">
        {{ $posts->links() }}
      </div>
    </div>
  </section>
</main>
@endsection
