@extends('layouts.frontbar')

@section('title', $service->name)

@section('meta')
    <meta name="description" content="{{ $service->meta_description }}">
    <meta name="keywords" content="{{ $service->meta_keywords ?? '' }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="service">
    <meta property="og:title" content="{{ $service->name }}">
    <meta property="og:description" content="{{ $service->meta_description }}">
    @if($service->image_path)
        <meta property="og:image" content="{{ url($service->image_path) }}">
    @endif
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $service->name }}">
    <meta name="twitter:description" content="{{ $service->meta_description }}">
    @if($service->image_path)
        <meta name="twitter:image" content="{{ url($service->image_path) }}">
    @endif

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}" />
@endsection

@section('content')
<div class="container my-5">
 

    {{-- Service Details Card --}}
    <div class="card shadow-sm">
        <div class="row g-0">
            <div class="col-md-5">
                @if($service->image_path)
                    <img src="{{ url($service->image_path) }}" alt="{{ $service->name }}" class="img-fluid">
                @endif
            </div>
            <div class="col-md-7">
                <div class="card-body">
                    <h1 class="h4 fw-bold">{{ $service->name }}</h1>
                    <p class="text-muted mb-4">{!! $service->meta_description !!}</p>
                    <hr>
                    <div>
                        {!! $service->description !!}
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('pregister', ['id' => $service->id]) }}" class="btn btn-primary btn-lg">
                            <i class="fa fa-sign-in me-2"></i> Buy Service
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-js')
{{-- Optional JS --}}
@endsection
