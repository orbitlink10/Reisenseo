@extends('theme.marketi.header')
@section('title', 'Networking Equipment & CCTV Cameras in Kenya | Reisen SEO')
@section('meta_description', 'Buy networking equipment and CCTV security systems in Kenya. Reisen SEO stocks routers, switches, wireless access points, network cables, IP cameras, NVRs, DVRs and accessories at competitive prices with fast delivery.')
@section('canonical', url('/'))
@section('content')

<main>
  <!-- Banner area start here -->
  <section
    class="banner-area bg-image paralax__animation"
    data-background="{{ asset('resources/views/theme/marketi/assets/images/banner/banner-bg.png') }}"
  >
    <div class="banner__hero">
      <img
        class="sway__animation"
        src="{{ asset('resources/views/theme/marketi/assets/images/banner/hero-image.png') }}"
        alt="Networking equipment and CCTV cameras in Kenya"
      />
    </div>
    <div class="banner__hero-info">
      <img
        data-depth="0.03"
        src="{{ asset('resources/views/theme/marketi/assets/images/banner/banner-info.png') }}"
        alt="Network installation and CCTV setup"
      />
    </div>
    <div class="container">
      <div class="banner__content">
        <h4 class="mb-10 wow fadeInRight">Networking Equipment &amp; CCTV Security in Kenya</h4>
        <h1 class="wow fadeInUp">
          Routers, Switches, Access Points &amp; CCTV Cameras
        </h1>
        <p class="mt-50 wow fadeInUp">
          Genuine networking equipment and CCTV security systems for homes and businesses—sourced, delivered and supported across Kenya.
        </p>
        <div class="d-flex align-items-center gap-4 mt-40">
          <a href="{{ route('shop') }}" class="btn-one wow fadeInDown">Shop Equipment<i class="fa-regular fa-circle-arrow-right ml-10"></i></a>
          <a href="{{ url('contact-us') }}" class="explore-btn wow fadeInDown"><span>Get a Quote</span><i class="fa-regular fa-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </section>
  <!-- Banner area end here -->

  <!-- Product area start here -->
  <section class="product-area pt-120 pb-120">
    <div class="container">
      <div class="section-header__wrp mb-60">
        <div class="section-header">
          <h5 class="wow fadeInUp">Latest Products</h5>
          <h2 class="wow fadeInUp">Shop Now</h2>
        </div>
      </div>
      <div class="row g-4">
        @foreach($products as $product)
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card h-100 text-center p-3">
              <?php $image = \App\Models\Upload::wherePostId($product->id)->whereStatus('1')->first(); ?>
              @if($image)
                <a href="{{ route('shop_description', $product->slug) }}" class="d-block mb-3">
                  <img src="{{ url($image->file_path) }}" class="img-fluid" alt="{{ $product->title }}">
                </a>
              @endif
              <h6 class="mb-1">
                <a href="{{ route('shop_description', $product->slug) }}">{{ $product->title }}</a>
              </h6>
              <p class="text-primary fw-bold">{{ price($product->cost) }}</p>
            </div>
          </div>
        @endforeach
      </div>
      <div class="text-center mt-40">
        <a href="{{ route('shop') }}" class="btn-one wow fadeInDown">View All Products<i class="fa-regular fa-circle-arrow-right ml-10"></i></a>
      </div>
    </div>
  </section>
  <!-- Product area end here -->

  <!-- Offer area start here -->
  <section class="offer-area pt-140 pb-140 primary-bg" id="services">
    <div class="container">
      <div class="section-header__wrp mb-60">
        <div class="section-header">
          <h5 class="text-white wow fadeInUp">What We Supply</h5>
          <h2 class="text-white wow fadeInUp"><span class="light-underline">Networking &amp; CCTV</span> equipment</h2>
        </div>
        <p class="para-light-color wow fadeInUp">
          From a single router to a full CCTV installation, we supply genuine equipment with delivery and after-sales support across Kenya.
        </p>
      </div>

      <div class="offer__item">
        <ul>
          <li class="wow fadeInDown">
            <a class="offer-title" href="{{ route('shops_filter', 'networking-tools-accessories-routers') }}">Routers &amp; Switches</a><i class="fa-light offer-icon fa-arrow-right"></i>
            <div class="offer__image-wrp">
              <a class="offer__image d-block image" href="{{ route('shops_filter', 'networking-tools-accessories-routers') }}">
                <img src="{{ asset('resources/views/theme/marketi/assets/images/offer/offer-image1.png') }}" alt="Routers and network switches" />
              </a>
            </div>
            <p>Home and enterprise routers, managed and unmanaged switches from leading brands.</p>
          </li>
          <li class="wow fadeInDown">
            <a class="offer-title" href="{{ route('shops_filter', 'cameras') }}">CCTV Cameras &amp; Recorders</a><i class="fa-light offer-icon fa-arrow-right"></i>
            <div class="offer__image-wrp">
              <a class="offer__image d-block image" href="{{ route('shops_filter', 'cameras') }}">
                <img src="{{ asset('resources/views/theme/marketi/assets/images/offer/offer-image2.png') }}" alt="CCTV cameras and NVR recorders" />
              </a>
            </div>
            <p>IP cameras, NVRs and DVRs for homes, offices and commercial sites.</p>
          </li>
          <li class="wow fadeInDown">
            <a class="offer-title" href="{{ route('shops_filter', 'networking-tools-accessories-access-points') }}">Access Points &amp; Cabling</a><i class="fa-light offer-icon fa-arrow-right"></i>
            <div class="offer__image-wrp">
              <a class="offer__image d-block image" href="{{ route('shops_filter', 'networking-tools-accessories-access-points') }}">
                <img src="{{ asset('resources/views/theme/marketi/assets/images/offer/offer-image3.png') }}" alt="Wireless access points and network cables" />
              </a>
            </div>
            <p>Wireless access points, outdoor CPE and structured cabling for reliable networks.</p>
          </li>
        </ul>
      </div>
    </div>
  </section>
  <!-- Offer area end here -->

  <!-- Category links area start here -->
  <div class="brand-area pt-70">
    <div class="container">
      <h5 class="brand__title mb-40">Browse Networking &amp; CCTV Categories</h5>
      <div class="d-flex flex-wrap justify-content-center gap-3">
        <a class="btn-one" href="{{ route('shops_filter', 'networking-tools-accessories-routers') }}">Routers</a>
        <a class="btn-one" href="{{ route('shops_filter', 'networking-tools-accessories-switches') }}">Switches</a>
        <a class="btn-one" href="{{ route('shops_filter', 'networking-tools-accessories-access-points') }}">Access Points</a>
        <a class="btn-one" href="{{ route('shops_filter', 'networking-tools-accessories-wireless-radios') }}">Outdoor CPE</a>
        <a class="btn-one" href="{{ route('shops_filter', 'networking-tools-accessories-ethernet-cables') }}">Network Cables</a>
        <a class="btn-one" href="{{ route('shops_filter', 'cameras') }}">CCTV Cameras</a>
        <a class="btn-one" href="{{ route('shops_filter', 'nvr') }}">NVRs</a>
        <a class="btn-one" href="{{ route('shops_filter', 'dvr') }}">DVRs</a>
      </div>
    </div>
  </div>
  <!-- Category links area end here -->

  <!-- Choose area start here -->
  <section class="choose-area pt-120 pb-120" id="why">
    <div class="container">
      <div class="section-header__wrp mb-80">
        <div class="section-header-two">
          <h5 class="wow fadeInUp">Why Choose Us?</h5>
          <h2 class="wow fadeInUp">Genuine Equipment &amp; Local Support<br>for Every Kenyan Business</h2>
        </div>
        <p class="wow fadeInUp">
          We supply authentic networking and CCTV equipment with nationwide delivery, warranty-backed products and local technical support.
        </p>
      </div>
      <div class="row g-5">
        <div class="col-lg-6">
          <div class="choose__item wow fadeInUp">
            <div class="choose__content">
              <h3>Genuine Products</h3>
              <p>Routers, switches, cameras and recorders sourced from authorised distribution channels.</p>
              <a href="{{ route('shop') }}" class="explore-btn"><span>Browse Products</span> <i class="fa-regular fa-arrow-right"></i></a>
            </div>
            <div class="choose__image image">
              <img src="{{ asset('resources/views/theme/marketi/assets/images/choose/choose-image1.png') }}" alt="Genuine networking equipment">
            </div>
          </div>
          <div class="choose__item mt-40 wow fadeInUp">
            <div class="choose__content">
              <h3>Expert Installation &amp; Setup</h3>
              <p>Our technicians configure routers, mount access points and install CCTV systems correctly.</p>
              <a href="{{ url('contact-us') }}" class="explore-btn"><span>Request Installation</span> <i class="fa-regular fa-arrow-right"></i></a>
            </div>
            <div class="choose__image image">
              <img src="{{ asset('resources/views/theme/marketi/assets/images/choose/choose-image2.png') }}" alt="Network and CCTV installation">
            </div>
          </div>
        </div>
        <div class="col-lg-6 wow fadeInLeft">
          <div class="choose__item grid-item">
            <div class="choose__content">
              <h3>Nationwide Delivery</h3>
              <p>We deliver networking and security equipment across Nairobi and the whole of Kenya.</p>
              <a href="{{ url('contact-us') }}" class="explore-btn"><span>Ask About Delivery</span> <i class="fa-regular fa-arrow-right"></i></a>
            </div>
            <div class="image">
              <img src="{{ asset('resources/views/theme/marketi/assets/images/choose/choose-image3.png') }}" alt="Nationwide delivery in Kenya">
            </div>
          </div>
        </div>
        <div class="col-lg-12 wow fadeInDown">
          <div class="choose__item list-item">
            <div class="choose__image image">
              <img src="{{ asset('resources/views/theme/marketi/assets/images/choose/choose-image4.png') }}" alt="Local technical support">
            </div>
            <div class="choose__content">
              <h3>Local Technical Support</h3>
              <p>Our support team helps you choose the right equipment and assists with after-sales queries.</p>
              <a href="{{ url('contact-us') }}" class="explore-btn"><span>Contact Support</span> <i class="fa-regular fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Choose area end here -->

  <!-- About area start here -->
  <section class="about-area pt-140 pb-140">
    <div class="container">
      <div class="row g-4 align-items-center">
        <div class="col-xl-6 wow fadeInRight">
          <div class="image about__image">
            <img src="{{ asset('resources/views/theme/marketi/assets/images/about/about-image.png') }}" alt="Networking equipment and CCTV supplier in Kenya" />
            <div class="about__shape1"><img src="{{ asset('resources/views/theme/marketi/assets/images/shape/about-shape1.png') }}" alt="shape" /></div>
            <div class="about__shape2"><img src="{{ asset('resources/views/theme/marketi/assets/images/shape/about-shape2.png') }}" alt="shape" /></div>
          </div>
        </div>
        <div class="col-xl-6">
          <div class="about__right-item">
            <div class="section-header">
              <h5 class="wow fadeInUp">About {{ get_option(site_id().'_site_name') }}</h5>
              <h2 class="wow fadeInUp">Your Partner for Networking<br>&amp; CCTV Security in Kenya</h2>
              <p class="wow fadeInUp">
                {{ get_option(site_id().'_site_name') }} helps homes and businesses in Kenya stay connected and secure. We supply routers, switches, access points, network cables and CCTV systems, and provide installation and after-sales support.
                <a href="{{ url('about-us') }}" class="secondary-color fw-700 primary-hover">Learn More</a>
              </p>
            </div>
            <div class="about__counter mt-40">
              <div class="coun-item wow fadeInDown"><h3><span class="count">Wide</span></h3><p>Product Range</p></div>
              <div class="coun-item wow fadeInDown"><h3><span class="count">Kenya</span></h3><p>Delivery Coverage</p></div>
              <div class="coun-item wow fadeInDown"><h3><span class="count">Support</span></h3><p>Local Assistance</p></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- About area end here -->

  <!-- Service area start here -->
  <section class="service-area pb-140">
    <div class="container">
      <div class="custom-row service__wrp">
        <div class="service__item wow fadeInUp">
          <div class="service__icon mb-25"><img src="{{ asset('resources/views/theme/marketi/assets/images/icon/service-icon1.png') }}" alt="Networking equipment" /></div>
          <h3>Networking Equipment</h3>
          <p>Routers, switches, access points and outdoor CPE for reliable wired and wireless networks.</p>
          <a href="{{ route('shops_filter', 'networking-tools-accessories-routers') }}" class="explore-btn mt-15"><span>Shop Networking</span> <i class="fa-regular fa-arrow-right"></i></a>
        </div>
        <div class="service__item wow fadeInUp">
          <div class="service__icon mb-25"><img src="{{ asset('resources/views/theme/marketi/assets/images/icon/service-icon2.png') }}" alt="CCTV security systems" /></div>
          <h3>CCTV Security Systems</h3>
          <p>IP cameras, NVRs, DVRs and accessories to monitor and protect your property.</p>
          <a href="{{ route('shops_filter', 'cameras') }}" class="explore-btn mt-15"><span>Shop CCTV</span> <i class="fa-regular fa-arrow-right"></i></a>
        </div>
        <div class="service__item wow fadeInUp">
          <div class="service__icon mb-25"><img src="{{ asset('resources/views/theme/marketi/assets/images/icon/service-icon3.png') }}" alt="Installation and support" /></div>
          <h3>Installation &amp; Support</h3>
          <p>Professional setup, configuration and after-sales support for your equipment.</p>
          <a href="{{ url('contact-us') }}" class="explore-btn mt-15"><span>Contact Us</span> <i class="fa-regular fa-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </section>
  <!-- Service area end here -->

  <!-- Process area start here -->
  <section class="process-area pt-140 pb-140">
    <div class="container">
      <div class="section-header__wrp mb-90">
        <div class="section-header">
          <h5 class="wow fadeInUp">How It Works</h5>
          <h2 class="wow fadeInUp">Our Simple 4-Step Process</h2>
        </div>
        <p class="wow fadeInUp">
          From placing your order to delivery and installation across Kenya.
        </p>
      </div>
      <div class="custom-row process__wrp">
        <div class="process__line"><img src="{{ asset('resources/views/theme/marketi/assets/images/shape/process-line.png') }}" alt="line" /></div>
        <div class="process__item">
          <div class="process__icon"><img src="{{ asset('resources/views/theme/marketi/assets/images/icon/process-icon1.png') }}" alt="icon" /></div>
          <h3 class="mt-20">1. Choose Equipment</h3>
          <p>Browse our shop and pick the networking or CCTV products you need.</p>
        </div>
        <div class="process__item">
          <div class="process__icon"><img src="{{ asset('resources/views/theme/marketi/assets/images/icon/process-icon2.png') }}" alt="icon" /></div>
          <h3 class="mt-20">2. Place Your Order</h3>
          <p>Order online or contact us for a quote and availability confirmation.</p>
        </div>
        <div class="process__item">
          <div class="process__icon"><img src="{{ asset('resources/views/theme/marketi/assets/images/icon/process-icon3.png') }}" alt="icon" /></div>
          <h3 class="mt-20">3. Delivery &amp; Installation</h3>
          <p>We deliver across Kenya and can install and configure your equipment.</p>
        </div>
        <div class="process__item">
          <div class="process__icon"><img src="{{ asset('resources/views/theme/marketi/assets/images/icon/process-icon4.png') }}" alt="icon" /></div>
          <h3 class="mt-20">4. After-Sales Support</h3>
          <p>Get local technical support for warranty, setup and troubleshooting.</p>
        </div>
      </div>
    </div>
  </section>
  <!-- Process area end here -->

  <!-- Talk area start here -->
  <section
    class="talk-area pt-140 pb-140 primary-bg bg-image"
    data-background="{{ asset('resources/views/theme/marketi/assets/images/bg/talk-bg.png') }}"
  >
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-12">
          <div class="section-header">
            <h5 class="text-white text-center wow fadeInUp">Need Networking or CCTV Equipment?</h5>
            <h2 class="text-white text-center wow fadeInUp">
              Get a Quote or Order Online Today
            </h2>
            <p class="para-light-color text-center wow fadeInUp">
              Contact us for pricing, availability and installation across Kenya.
            </p>
            <div class="btn__group text-center wow fadeInDown">
              <a href="{{ route('shop') }}" class="btn-two">Shop Now<i class="fa-regular fa-arrow-right ml-10"></i></a>
              <a href="{{ url('contact-us') }}" class="btn-three ms-4">Contact Us<i class="fa-regular fa-arrow-right ml-10"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Talk area end here -->
</main>

@endsection
