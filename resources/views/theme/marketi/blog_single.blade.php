@extends('theme.marketi.header')
@section('title', $post->title)
@section('meta_description')
@if(!empty($post->meta_description))
{{ substr(trim(preg_replace('/\s\s+/', ' ', strip_tags($post->meta_description))), 0, 160) }}
@else
{{ substr(trim(preg_replace('/\s\s+/', ' ', strip_tags($post->description))), 0, 160) }}
@endif
@endsection
@section('canonical', route('blog_single', $post->slug))

@section('content')
<main>
  <section class="banner-area bg-image paralax__animation"
    data-background="{{ asset('resources/views/theme/marketi/assets/images/banner/banner-bg.png') }}"
    style="background-image:url('{{ asset('resources/views/theme/marketi/assets/images/banner/banner-bg.png') }}');">
    <div class="container">
      <div class="banner__content py-5">
        <h1 class="wow fadeInUp">{{ $post->title }}</h1>
      </div>
    </div>
  </section>

  <section class="pt-80 pb-120">
    <div class="container">
      <div class="card shadow-sm border-0">
        <div class="card-body">
          {!! $post->description !!}
        </div>
      </div>

      @auth
        @if(method_exists(auth()->user(), 'is_admin') && auth()->user()->is_admin())
          <div class="mt-3 text-end">
            <a href="{{ route('edit_post', $post->id) }}" target="_blank" class="btn btn-sm btn-secondary">Edit Post</a>
          </div>
        @endif
      @endauth
    </div>
  </section>
</main>
@endsection
