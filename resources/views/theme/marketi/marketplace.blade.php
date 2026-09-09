<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $siteName = get_option(site_id().'_site_name') ?: 'Reisen SEO';
        $pageTitle = isset($currentCategory) && $currentCategory
            ? $currentCategory->name . ' – Best Prices in Kenya | ' . $siteName
            : ($siteName . ' – Networking Equipment & CCTV Cameras in Kenya');
    @endphp
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ isset($currentCategory) && $currentCategory && !empty($currentCategory->meta_description) ? $currentCategory->meta_description : 'Shop networking equipment, CCTV cameras, POS systems, routers and more in Kenya at ' . $siteName . '. Best prices with fast delivery.' }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" href="{{ favicon_url() }}" sizes="32x32">

    {{-- Theme assets --}}
    <link rel="stylesheet" href="{{ asset('resources/views/theme/marketi/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('resources/views/theme/marketi/assets/css/all.min.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --theme-color: #ff9803;
            --theme-color-dark: #e88600;
            --banner-blue: #0E4DA5;
            --text-color: #0a0a0a;
            --muted: #7a7a7a;
            --border: #e8e8e8;
            --font: 'Montserrat', sans-serif;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: var(--font);
            color: var(--text-color);
            background: #ffffff;
            font-size: 14px;
        }
        a { color: inherit; text-decoration: none; }
        img { max-width: 100%; display: block; }
        .container { width: 100%; max-width: 1280px; margin: 0 auto; padding: 0 15px; }

        /* ===== Sticky contact banner ===== */
        .simple-banner {
            background: var(--banner-blue);
            color: #fff;
            position: sticky;
            top: 0;
            z-index: 9999;
            text-align: center;
            font-size: 13px;
            padding: 8px 15px;
        }
        .simple-banner a { color: #FF9803; font-weight: 600; }

        /* ===== Header ===== */
        .site-header {
            background: #fff;
            border-bottom: 1px solid var(--border);
            position: relative;
            z-index: 1000;
        }
        .site-header__inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 14px 0;
        }
        .site-logo img { max-height: 52px; width: auto; }
        .main-nav { display: flex; align-items: center; gap: 26px; }
        .main-nav > li { list-style: none; position: relative; }
        .main-nav > li > a {
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: .3px;
            color: var(--text-color);
            padding: 8px 0;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .main-nav > li > a:hover { color: var(--theme-color); }
        .dropdown { position: relative; }
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 240px;
            background: #fff;
            border: 1px solid var(--border);
            box-shadow: 0 8px 24px rgba(0,0,0,.08);
            padding: 8px 0;
            display: none;
            z-index: 1001;
        }
        .dropdown:hover .dropdown-menu { display: block; }
        .dropdown-menu a {
            display: block;
            padding: 9px 20px;
            font-size: 13px;
            color: #333;
        }
        .dropdown-menu a:hover { background: #f7f7f7; color: var(--theme-color); }
        .header-actions { display: flex; align-items: center; gap: 18px; }
        .header-actions a { font-size: 20px; color: var(--text-color); position: relative; }
        .header-actions a:hover { color: var(--theme-color); }
        .search-form {
            display: flex;
            align-items: center;
            border: 1px solid var(--border);
            border-radius: 4px;
            overflow: hidden;
        }
        .search-form input {
            border: none;
            outline: none;
            padding: 9px 14px;
            font-family: var(--font);
            font-size: 13px;
            width: 200px;
        }
        .search-form button {
            border: none;
            background: var(--theme-color);
            color: #fff;
            padding: 9px 14px;
            cursor: pointer;
        }
        .nav-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: var(--text-color);
        }

        /* ===== Hero ===== */
        .hero-banner {
            background: linear-gradient(120deg, #0E4DA5 0%, #1b6fd0 55%, #ff9803 130%);
            color: #fff;
            padding: 70px 0;
        }
        .hero-banner__inner { max-width: 720px; }
        .hero-banner .kicker {
            display: inline-block;
            background: rgba(255,255,255,.15);
            padding: 5px 14px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .5px;
            margin-bottom: 16px;
        }
        .hero-banner h1 { font-size: 38px; line-height: 1.15; font-weight: 800; margin: 0 0 14px; }
        .hero-banner p { font-size: 15px; opacity: .92; margin: 0 0 24px; }
        .hero-cta {
            display: inline-block;
            background: var(--theme-color);
            color: #fff;
            font-weight: 700;
            padding: 13px 30px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: .5px;
            font-size: 13px;
        }
        .hero-cta:hover { background: var(--theme-color-dark); color: #fff; }

        /* ===== Product sections ===== */
        .product-section { padding: 40px 0 10px; }
        .product-list-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid var(--theme-color);
            padding-bottom: 10px;
            margin-bottom: 22px;
        }
        .product-list-top h2 {
            font-size: 20px;
            font-weight: 800;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: .3px;
        }
        .view-all { font-size: 13px; font-weight: 600; color: var(--theme-color); white-space: nowrap; }
        .view-all:hover { text-decoration: underline; }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }
        @media (min-width: 576px) { .products-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (min-width: 992px) { .products-grid { grid-template-columns: repeat(4, 1fr); } }
        @media (min-width: 1200px) { .products-grid { grid-template-columns: repeat(5, 1fr); } }

        .product-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 6px;
            overflow: hidden;
            transition: box-shadow .2s ease, transform .2s ease;
            display: flex;
            flex-direction: column;
        }
        .product-card:hover { box-shadow: 0 10px 26px rgba(0,0,0,.10); transform: translateY(-3px); }
        .product-thumb {
            position: relative;
            background: #fafafa;
            aspect-ratio: 1 / 1;
            overflow: hidden;
        }
        .product-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .35s ease;
        }
        .product-card:hover .product-thumb img { transform: scale(1.06); }
        .badge-hot {
            position: absolute;
            top: 10px;
            left: 10px;
            background: var(--theme-color);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 3px 9px;
            border-radius: 3px;
            z-index: 2;
        }
        .product-content { padding: 14px; display: flex; flex-direction: column; flex: 1; }
        .product-title {
            font-size: 13px;
            font-weight: 600;
            line-height: 1.35;
            margin: 0 0 8px;
            min-height: 36px;
        }
        .product-title a:hover { color: var(--theme-color); }
        .price { margin-bottom: 12px; }
        .price .amount { font-size: 16px; font-weight: 800; color: var(--text-color); }
        .price .suffix { font-size: 11px; color: var(--muted); margin-left: 3px; }
        .add-to-cart {
            margin-top: auto;
            display: block;
            text-align: center;
            background: var(--theme-color);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 10px;
            border-radius: 4px;
            letter-spacing: .4px;
        }
        .add-to-cart:hover { background: var(--theme-color-dark); color: #fff; }

        .breadcrumb-bar { background: #f7f7f7; border-bottom: 1px solid var(--border); padding: 12px 0; font-size: 13px; }
        .breadcrumb-bar a:hover { color: var(--theme-color); }
        .section-heading { margin: 36px 0 20px; }
        .section-heading h2 { font-size: 22px; font-weight: 800; text-transform: uppercase; }

        /* ===== Footer ===== */
        .site-footer { background: #101828; color: #cbd2dc; margin-top: 50px; }
        .site-footer__top { padding: 50px 0 30px; display: grid; gap: 30px; grid-template-columns: 1fr; }
        @media (min-width: 768px) { .site-footer__top { grid-template-columns: repeat(4, 1fr); } }
        .site-footer h4 { color: #fff; font-size: 15px; text-transform: uppercase; margin: 0 0 16px; }
        .site-footer ul { list-style: none; padding: 0; margin: 0; }
        .site-footer ul li { margin-bottom: 10px; }
        .site-footer ul li a:hover { color: var(--theme-color); }
        .site-footer .about-text { font-size: 13px; line-height: 1.7; }
        .site-footer__bottom { border-top: 1px solid #22304a; padding: 18px 0; font-size: 13px; text-align: center; }
        .social-links a { display: inline-block; margin-right: 10px; font-size: 18px; color: #cbd2dc; }
        .social-links a:hover { color: var(--theme-color); }

        .empty-state { text-align: center; padding: 60px 20px; color: var(--muted); }

        @media (max-width: 991px) {
            .main-nav, .search-form, .header-actions .cart-link { display: none; }
            .nav-toggle { display: block; }
            .mobile-nav {
                display: none;
                background: #fff;
                border-top: 1px solid var(--border);
                padding: 10px 0;
            }
            .mobile-nav.open { display: block; }
            .mobile-nav a { display: block; padding: 10px 0; font-weight: 600; border-bottom: 1px solid #f1f1f1; }
        }
    </style>
</head>
<body>

{{-- Sticky contact banner (CTC-style) --}}
<div class="simple-banner">
    Call us on <a href="tel:+254714804532">+254 714 804 532</a> or email us on <a href="mailto:info@reisenseo.com">info@reisenseo.com</a>
</div>

{{-- Header --}}
<header class="site-header">
    <div class="container">
        <div class="site-header__inner">
            <a href="{{ route('home') }}" class="site-logo" aria-label="{{ $siteName }} home">
                <img src="{{ logo_url() }}" alt="{{ $siteName }} logo" />
            </a>

            <ul class="main-nav mb-0 ps-0">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="dropdown">
                    <a href="{{ route('shop') }}">Shop <i class="fa-solid fa-angle-down"></i></a>
                    <div class="dropdown-menu">
                        <a href="{{ route('shop') }}">All Products</a>
                        @foreach($categories as $cat)
                            <a href="{{ route('shops_filter', $cat->slug) }}">{{ $cat->name }}</a>
                        @endforeach
                    </div>
                </li>
                <li><a href="{{ url('about-us') }}">About Us</a></li>
                <li><a href="{{ url('contact-us') }}">Contact</a></li>
            </ul>

            <div class="header-actions">
                <form class="search-form" method="GET" action="{{ route('shop') }}" role="search">
                    <input type="text" name="q" placeholder="Search products..." value="{{ request('q') }}" aria-label="Search products">
                    <button type="submit" aria-label="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                <a class="cart-link" href="{{ route('shop') }}" aria-label="Shop"><i class="fa-solid fa-cart-shopping"></i></a>
                <button class="nav-toggle" id="navToggle" aria-label="Open menu"><i class="fa-solid fa-bars"></i></button>
            </div>
        </div>

        <nav class="mobile-nav" id="mobileNav" aria-label="Mobile menu">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('shop') }}">Shop</a>
            @foreach($categories as $cat)
                <a href="{{ route('shops_filter', $cat->slug) }}">{{ $cat->name }}</a>
            @endforeach
            <a href="{{ url('about-us') }}">About Us</a>
            <a href="{{ url('contact-us') }}">Contact</a>
        </nav>
    </div>
</header>

@php
    $placeholder = 'data:image/svg+xml;charset=UTF-8,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="600" height="600" viewBox="0 0 600 600"><rect width="600" height="600" fill="#eef1f4"/><g fill="#b7c0ca" font-family="Arial" font-size="30" text-anchor="middle"><text x="300" y="295">No image</text></g></svg>');
@endphp

@if(isset($currentCategory) && $currentCategory)
    {{-- Single category view --}}
    <div class="breadcrumb-bar">
        <div class="container">
            <a href="{{ route('home') }}">Home</a> <span>/</span> <a href="{{ route('shop') }}">Shop</a> <span>/</span> {{ $currentCategory->name }}
        </div>
    </div>
    <div class="hero-banner" style="padding: 46px 0;">
        <div class="container">
            <div class="hero-banner__inner">
                <h1 style="font-size:30px;">{{ $currentCategory->name }}</h1>
                <p>{{ $currentCategory->meta_description ?: 'Browse our range of ' . $currentCategory->name . ' at the best prices in Kenya.' }}</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="section-heading">
            <h2>{{ $currentCategory->name }}</h2>
        </div>
        <div class="products-grid">
            @forelse($posts as $post)
                @include('theme.marketi.partials.product-card', ['post' => $post])
            @empty
                <div class="empty-state">No products found in this category.</div>
            @endforelse
        </div>
        @if($posts->hasPages())
            <div class="d-flex justify-content-center my-4">
                {{ $posts->links() }}
            </div>
        @endif
    </div>

@elseif(isset($sections) && $sections->isNotEmpty())
    {{-- Homepage-style marketplace: hero + category sections --}}
    <section class="hero-banner">
        <div class="container">
            <div class="hero-banner__inner">
                <span class="kicker">Networking · CCTV · POS · Electronics</span>
                <h1>Networking Equipment &amp; CCTV Cameras in Kenya</h1>
                <p>Shop genuine networking devices, security cameras, POS systems, laptops and more — all at the best prices with fast delivery across Kenya.</p>
                <a href="{{ route('shop') }}#shop" class="hero-cta">Shop Now</a>
            </div>
        </div>
    </section>

    <div class="container" id="shop">
        @foreach($sections as $cat)
            <section class="product-section">
                <div class="product-list-top">
                    <div class="title-block"><h2>{{ $cat->name }}</h2></div>
                    <a href="{{ route('shops_filter', $cat->slug) }}" class="view-all">View All <i class="fa-solid fa-angle-right"></i></a>
                </div>
                <div class="products-grid">
                    @foreach($cat->products as $post)
                        @include('theme.marketi.partials.product-card', ['post' => $post])
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>

@else
    {{-- Search results / fallback grid --}}
    <div class="hero-banner" style="padding: 46px 0;">
        <div class="container">
            <div class="hero-banner__inner">
                <h1 style="font-size:30px;">@if(request('q')) Search results for "{{ request('q') }}" @else Latest Products @endif</h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="products-grid" style="margin-top: 28px;">
            @forelse($posts as $post)
                @include('theme.marketi.partials.product-card', ['post' => $post])
            @empty
                <div class="empty-state">No products found. Please try a different search.</div>
            @endforelse
        </div>
        @if($posts->hasPages())
            <div class="d-flex justify-content-center my-4">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endif

{{-- Footer --}}
<footer class="site-footer">
    <div class="container">
        <div class="site-footer__top">
            <div>
                <img src="{{ logo_url() }}" alt="{{ $siteName }} logo" style="max-height:48px; margin-bottom:16px;">
                <p class="about-text">{{ $siteName }} is your trusted supplier of networking equipment, CCTV security cameras, POS systems and electronics in Kenya — genuine products at the best prices.</p>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                </div>
            </div>
            <div>
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('shop') }}">Shop</a></li>
                    <li><a href="{{ url('about-us') }}">About Us</a></li>
                    <li><a href="{{ url('contact-us') }}">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4>Categories</h4>
                <ul>
                    @foreach($categories->take(8) as $cat)
                        <li><a href="{{ route('shops_filter', $cat->slug) }}">{{ $cat->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4>Contact Us</h4>
                <ul>
                    <li><i class="fa-solid fa-location-dot me-2"></i> Nairobi, Kijabe Street, Norfolk Towers, Kenya</li>
                    <li><i class="fa-solid fa-phone me-2"></i> <a href="tel:+254714804532">+254 714 804 532</a></li>
                    <li><i class="fa-solid fa-envelope me-2"></i> <a href="mailto:info@reisenseo.com">info@reisenseo.com</a></li>
                </ul>
            </div>
        </div>
        <div class="site-footer__bottom">
            &copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.
        </div>
    </div>
</footer>

<script>
    (function(){
        var toggle = document.getElementById('navToggle');
        var nav = document.getElementById('mobileNav');
        if (toggle && nav) {
            toggle.addEventListener('click', function () {
                nav.classList.toggle('open');
            });
        }
    })();
</script>

</body>
</html>
