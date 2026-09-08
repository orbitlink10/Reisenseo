<!DOCTYPE html>
<html lang="en">
<head>
    {{-- Core meta --}}
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO meta (page may override via @section/@yield) --}}
    <title>@yield('title', get_option(site_id().'_site_title'))</title>
    <meta name="description" content="@yield('meta_description', get_option(site_id().'_meta_description'))">
    <meta name="keywords" content="@yield('meta_keywords', get_option(site_id().'_meta_keywords'))">
    <meta name="robots" content="@yield('meta_robots', 'index,follow')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- Open Graph / Twitter (safe defaults, override per page if needed) --}}
    @php
        $ogTitle   = trim($__env->yieldContent('og_title')) ?: (get_option(site_id().'_site_title'));
        $ogDesc    = trim($__env->yieldContent('og_description')) ?: (get_option(site_id().'_meta_description'));
        $ogImage   = trim($__env->yieldContent('og_image')) ?: (logo_url());
        $siteName  = get_option(site_id().'_site_title');
    @endphp
    <meta property="og:type" content="@yield('og_type','website')">
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDesc }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:locale" content="@yield('og_locale','en_US')">
    <meta name="twitter:card" content="@yield('twitter_card','summary_large_image')">
    <meta name="twitter:title" content="@yield('twitter_title', $ogTitle)">
    <meta name="twitter:description" content="@yield('twitter_description', $ogDesc)">
    <meta name="twitter:image" content="@yield('twitter_image', $ogImage)">

    {{-- Favicons --}}
    <link rel="icon" href="{{ asset('resources/views/theme/marketi/assets/images/favicon.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('resources/views/theme/marketi/assets/images/favicon.png') }}">

    {{-- Styles --}}
    <link rel="stylesheet" href="{{ asset('resources/views/theme/marketi/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('resources/views/theme/marketi/assets/css/meanmenu.css') }}" />
    <link rel="stylesheet" href="{{ asset('resources/views/theme/marketi/assets/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('resources/views/theme/marketi/assets/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('resources/views/theme/marketi/assets/css/magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('resources/views/theme/marketi/assets/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('resources/views/theme/marketi/assets/css/nice-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('resources/views/theme/marketi/assets/css/style.css') }}" />

    {{-- Page-specific head injections --}}
    @stack('styles')
    @yield('head')

    {{-- Small a11y helper styles (safe inline) --}}
    <style>
      .skip-link{position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden;}
      .skip-link:focus{position:static;width:auto;height:auto;padding:.5rem;background:#000;color:#fff;z-index:10000}
      .header-top .info a, .header-top .link-info a { text-decoration: none; }
      .main-menu nav ul li a.active { color: var(--primary, #00a86b); }
      .offcanvas-backdrop { display:none; }
      .offcanvas-open .offcanvas-backdrop { display:block; position:fixed; inset:0; background:rgba(0,0,0,.4); z-index:998;}
      .mobile-menu { position:fixed; inset:0 0 0 auto; width:300px; max-width:85%; background:#fff; z-index:999; transform:translateX(100%); transition:transform .25s ease; padding:20px; overflow-y:auto; }
      .offcanvas-open .mobile-menu { transform:translateX(0); }
      .mobile-menu .close-btn { border:none; background:transparent; font-size:1.5rem; line-height:1; }
      @media (min-width: 992px){ .mobile-menu, .offcanvas-backdrop { display:none !important; } }
    </style>
</head>

<body>
    <a class="skip-link" href="#main-content">Skip to content</a>

    {{-- Top header --}}
    <div class="header-top d-none d-lg-block" aria-label="Top Bar">
      <div class="container">
        <div class="header-top-wrp d-flex align-items-center justify-content-between">
          <ul class="info list-unstyled d-flex flex-wrap mb-0">
            <li class="me-4">
              <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
              <a href="mailto:info@reisenseo.com">info@reisenseo.com</a>
            </li>
            <li class="bor-left ms-4 ps-4">
              <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
              <span aria-label="Our address">Nairobi, Kijabe Street, Norfolk Towers, Kenya</span>
            </li>
          </ul>
          <ul class="link-info list-unstyled d-flex align-items-center mb-0">
            <li class="bor-right me-3 pe-3">
              <a href="tel:+254714804532" aria-label="Call us">+254 714 804 532</a>
            </li>
            <li>
              <a href="{{ url('shop') }}" aria-label="Shop networking and CCTV equipment">Shop Equipment</a>
            </li>
          </ul>
        </div>
      </div>
    </div>

    {{-- Header / Navigation --}}
    <header class="header-area" role="banner">
      <div class="container">
        <div class="header__main d-flex align-items-center justify-content-between py-2">
          <a href="{{ route('home') }}" class="logo" aria-label="Go to homepage">
            <img src="{{ logo_url() }}" alt="{{ get_option(site_id().'_site_title') }} logo" />
          </a>
          <a href="{{ route('home') }}" class="logo logo-light d-none" aria-hidden="true" tabindex="-1">
            <img src="{{ logo_url() }}" alt="{{ get_option(site_id().'_site_title') }} logo" />
          </a>

          {{-- Desktop menu --}}
          <div class="main-menu d-none d-lg-block" role="navigation" aria-label="Primary">
            @php
              $navCategories = [
                ['label' => 'Routers', 'slug' => 'networking-tools-accessories-routers'],
                ['label' => 'Network Switches', 'slug' => 'networking-tools-accessories-switches'],
                ['label' => 'Wireless Access Points', 'slug' => 'networking-tools-accessories-access-points'],
                ['label' => 'Wireless Outdoor CPE', 'slug' => 'networking-tools-accessories-wireless-radios'],
                ['label' => 'Ethernet Cables', 'slug' => 'networking-tools-accessories-ethernet-cables'],
                ['label' => 'CCTV Security Cameras', 'slug' => 'cameras'],
                ['label' => 'Network Video Recorders (NVR)', 'slug' => 'nvr'],
                ['label' => 'Digital Video Recorders (DVR)', 'slug' => 'dvr'],
                ['label' => 'Ubiquiti Network Devices', 'slug' => 'ubiquiti-network-devices-for-sale-in-kenya'],
                ['label' => 'Dahua CCTV Cameras', 'slug' => 'dahua-cctv-security-cameras'],
              ];
            @endphp
            <nav>
              <ul class="list-unstyled d-flex align-items-center mb-0">
                <li class="me-3">
                  <a class="{{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                </li>

                <li class="me-3 position-relative">
                  <a href="{{ route('shop') }}">Categories <i class="fa-solid fa-angle-down" aria-hidden="true"></i></a>
                  <ul class="sub-menu list-unstyled">
                    @foreach($navCategories as $navCat)
                      <li><a href="{{ route('shops_filter', $navCat['slug']) }}">{{ $navCat['label'] }}</a></li>
                    @endforeach
                    <li><a href="{{ route('shop') }}">All Products</a></li>
                  </ul>
                </li>

                <li class="me-3">
                  <a class="{{ request()->is('shop') ? 'active' : '' }}" href="{{ route('shop') }}">Shop</a>
                </li>

                <li class="me-3">
                  <a class="{{ request()->is('about-us') ? 'active' : '' }}" href="{{ url('about-us') }}">About Us</a>
                </li>

                <li>
                  <a class="{{ request()->is('contact-us') ? 'active' : '' }}" href="{{ url('contact-us') }}">Contact</a>
                </li>
              </ul>
            </nav>
          </div>

          <a href="{{ url('contact-us') }}" class="btn-menu d-none d-lg-inline-block">
            Get in Touch <i class="fa-regular fa-circle-arrow-right ms-2"></i>
          </a>

          {{-- Mobile menu toggle --}}
          <button class="bars d-lg-none btn btn-link p-0" id="openMenu" aria-label="Open menu">
            <i class="fa-solid fa-bars"></i>
          </button>
        </div>
      </div>

      {{-- Mobile offcanvas menu --}}
      <div class="offcanvas-backdrop" id="offcanvasBackdrop" aria-hidden="true"></div>
      <aside class="mobile-menu" id="mobileMenu" aria-label="Mobile Menu" aria-hidden="true">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <a href="{{ route('home') }}" class="logo" aria-label="Go to homepage">
            <img src="{{ logo_url() }}" alt="{{ get_option(site_id().'_site_title') }} logo" style="max-height:40px" />
          </a>
          <button class="close-btn" id="closeMenu" aria-label="Close menu">&times;</button>
        </div>

        <nav>
          <ul class="list-unstyled">
            <li class="mb-2">
              <a class="{{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
            </li>
            <li class="mb-2">
              <a class="{{ request()->is('shop') ? 'active' : '' }}" href="{{ route('shop') }}">Shop</a>
            </li>

            <li class="mb-2">
              <span class="d-block fw-semibold mb-1">Categories</span>
              <ul class="list-unstyled ms-3">
                @foreach($navCategories as $navCat)
                  <li class="mb-1"><a href="{{ route('shops_filter', $navCat['slug']) }}">{{ $navCat['label'] }}</a></li>
                @endforeach
                <li class="mb-1"><a href="{{ route('shop') }}">All Products</a></li>
              </ul>
            </li>

            <li class="mb-2">
              <a class="{{ request()->is('about-us') ? 'active' : '' }}" href="{{ url('about-us') }}">About Us</a>
            </li>
            <li class="mb-2">
              <a class="{{ request()->is('contact-us') ? 'active' : '' }}" href="{{ url('contact-us') }}">Contact</a>
            </li>
            <li class="mt-3">
              <a class="btn btn-primary w-100" href="{{ url('contact-us') }}">
                Get in Touch <i class="fa-regular fa-circle-arrow-right ms-2"></i>
              </a>
            </li>
          </ul>
        </nav>
      </aside>
    </header>

    {{-- Main content --}}
    <main id="main-content" tabindex="-1">
      @yield('content')
    </main>

    {{-- Footer include --}}
    @include('theme.marketi.footer')

    {{-- Theme scripts are loaded once by the footer. --}}

    {{-- Mobile off-canvas toggling (no dependencies) --}}
    <script>
      (function(){
        const body = document.body;
        const openBtn = document.getElementById('openMenu');
        const closeBtn = document.getElementById('closeMenu');
        const backdrop = document.getElementById('offcanvasBackdrop');
        const panel = document.getElementById('mobileMenu');

        function open() {
          body.classList.add('offcanvas-open');
          panel.setAttribute('aria-hidden', 'false');
          backdrop.setAttribute('aria-hidden', 'false');
        }
        function close() {
          body.classList.remove('offcanvas-open');
          panel.setAttribute('aria-hidden', 'true');
          backdrop.setAttribute('aria-hidden', 'true');
        }

        openBtn && openBtn.addEventListener('click', open);
        closeBtn && closeBtn.addEventListener('click', close);
        backdrop && backdrop.addEventListener('click', close);
        document.addEventListener('keydown', function(e){ if(e.key === 'Escape') close(); });
      })();
    </script>

    {{-- Page-specific scripts --}}
    @stack('scripts')

    {{-- JSON-LD LocalBusiness (genuine details only) --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Store",
      "name": "{{ addslashes(get_option(site_id().'_site_name')) }}",
      "url": "{{ url('/') }}",
      "logo": "{{ logo_url() }}",
      "email": "info@reisenseo.com",
      "telephone": "+254714804532",
      "priceRange": "KES",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Nairobi",
        "streetAddress": "Kijabe Street, Norfolk Towers",
        "addressCountry": "KE"
      }
    }
    </script>
</body>
</html>
