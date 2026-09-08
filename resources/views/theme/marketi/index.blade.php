@extends('theme.marketi.header')
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
        alt="Starlink Kit"
      />
    </div>
    <div class="banner__hero-info">
      <img
        data-depth="0.03"
        src="{{ asset('resources/views/theme/marketi/assets/images/banner/banner-info.png') }}"
        alt="Starlink Installation"
      />
    </div>
    <div class="container">
      <div class="banner__content">
         <h4 class="mb-10 wow fadeInRight">Fast, Reliable Internet Anywhere in Kenya</h4>
        <h1 class="wow fadeInUp">
          Starlink Satellite Internet Kits & Professional Installation
        </h1>
        <p class="mt-50 wow fadeInUp">
          Get genuine Starlink hardware plus expert setup for seamless high‑speed connectivity—even in remote areas.
        </p>
        <div class="d-flex align-items-center gap-4 mt-40">
          <a href="{{ url('contact-us') }}" class="btn-one wow fadeInDown">Order Your Kit<i class="fa-regular fa-circle-arrow-right ml-10"></i></a>
          <a href="{{ url('contact-us') }}" class="explore-btn wow fadeInDown"><span>Learn More</span><i class="fa-regular fa-arrow-right"></i></a>
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
    </div>
  </section>
  <!-- Product area end here -->

  <!-- Offer area start here -->
  <section class="offer-area pt-140 pb-140 primary-bg" id="services">
    <div class="container">
      <div class="section-header__wrp mb-60">
        <div class="section-header">
          <h5 class="text-white wow fadeInUp">Our Complete Solutions</h5>
          <h2 class="text-white wow fadeInUp"><span class="light-underline">Services</span> we provide</h2>
        </div>
        <p class="para-light-color wow fadeInUp">
          From hardware sales to installation and ongoing support, we deliver end‑to‑end Starlink connectivity across Kenya.
        </p>
      </div>

      <div class="offer__item">
        <ul>
          <li class="wow fadeInDown">
            <a class="offer-title" href="{{ url('contact-us') }}">Equipment Supply</a><i class="fa-light offer-icon fa-arrow-right"></i>
            <div class="offer__image-wrp">
              <a class="offer__image d-block image" href="{{ url('contact-us') }}">
                <img src="{{ asset('resources/views/theme/marketi/assets/images/offer/offer-image1.png') }}" alt="Equipment Supply" />
              </a>
            </div>
            <p>Official Starlink kits including user terminal, mount, router and cables.</p>
          </li>
          <li class="wow fadeInDown">
            <a class="offer-title" href="{{ url('contact-us') }}">Installation & Setup</a><i class="fa-light offer-icon fa-arrow-right"></i>
            <div class="offer__image-wrp">
              <a class="offer__image d-block image" href="{{ url('contact-us') }}">
                <img src="{{ asset('resources/views/theme/marketi/assets/images/offer/offer-image2.png') }}" alt="Installation" />
              </a>
            </div>
            <p>Certified technicians ensure correct dish alignment and network activation.</p>
          </li>
          <li class="wow fadeInDown">
            <a class="offer-title" href="{{ url('contact-us') }}">Support Plans</a><i class="fa-light offer-icon fa-arrow-right"></i>
            <div class="offer__image-wrp">
              <a class="offer__image d-block image" href="{{ url('contact-us') }}">
                <img src="{{ asset('resources/views/theme/marketi/assets/images/offer/offer-image3.png') }}" alt="Support Plans" />
              </a>
            </div>
            <p>Flexible maintenance and support packages tailored to your needs.</p>
          </li>
        </ul>
      </div>
    </div>
  </section>
  <!-- Offer area end here -->


  <!-- Brand area start here -->
  <div class="brand-area pt-70">
    <div class="container">
      <h5 class="brand__title mb-40">Trusted by Customers Across Kenya</h5>
      <div class="swiper brand__slider">
        <div class="swiper-wrapper">
          <?php $sites = \App\Models\Site::whereStatus(1)->get(); ?>
          @foreach($sites as $site)
            <div class="swiper-slide">
              <a href="https://{{ $site->domain_name }}" target="_blank">
                <img src="{{ $site->logo_url }}" width="250" alt="{{ $site->domain_name }}" />
              </a>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  <!-- Brand area end here -->

  <!-- Choose area start here -->
  <section class="choose-area pt-120 pb-120" id="why">
    <div class="container">
      <div class="section-header__wrp mb-80">
        <div class="section-header-two">
          <h5 class="wow fadeInUp">Why Starlink?</h5>
          <h2 class="wow fadeInUp">High‑Performance Satellite Internet<br>for Every Corner of Kenya</h2>
        </div>
        <p class="wow fadeInUp">
          Enjoy low-latency, high-speed connectivity with genuine Starlink kits and professional installation—no matter how remote your location.
        </p>
      </div>
      <div class="row g-5">
        <div class="col-lg-6">
          <div class="choose__item wow fadeInUp">
            <div class="choose__content">
              <h3>Authentic Equipment</h3>
              <p>We supply official Starlink hardware to guarantee peak performance and reliability.</p>
              <a href="{{ url('contact-us') }}" class="explore-btn"><span>Order Now</span> <i class="fa-regular fa-arrow-right"></i></a>
            </div>
            <div class="choose__image image">
              <img src="{{ asset('resources/views/theme/marketi/assets/images/choose/choose-image1.png') }}" alt="Starlink Kit">
            </div>
          </div>
          <div class="choose__item mt-40 wow fadeInUp">
            <div class="choose__content">
              <h3>Professional Installation</h3>
              <p>Our certified technicians handle everything—mounting, alignment, configuration—for optimal signal.</p>
              <a href="{{ url('contact-us') }}" class="explore-btn"><span>Book Installation</span> <i class="fa-regular fa-arrow-right"></i></a>
            </div>
            <div class="choose__image image">
              <img src="{{ asset('resources/views/theme/marketi/assets/images/choose/choose-image2.png') }}" alt="Installation">
            </div>
          </div>
        </div>
        <div class="col-lg-6 wow fadeInLeft">
          <div class="choose__item grid-item">
            <div class="choose__content">
              <h3>Nationwide Coverage</h3>
              <p>Starlink’s network reaches remote and rural regions where traditional ISPs can’t.</p>
              <a href="{{ url('contact-us') }}" class="explore-btn"><span>Check Coverage</span> <i class="fa-regular fa-arrow-right"></i></a>
            </div>
            <div class="image">
              <img src="{{ asset('resources/views/theme/marketi/assets/images/choose/choose-image3.png') }}" alt="Coverage Map">
            </div>
          </div>
        </div>
        <div class="col-lg-12 wow fadeInDown">
          <div class="choose__item list-item">
            <div class="choose__image image">
              <img src="{{ asset('resources/views/theme/marketi/assets/images/choose/choose-image4.png') }}" alt="Support">
            </div>
            <div class="choose__content">
              <h3>24/7 Support</h3>
              <p>Our local support team is available around the clock to keep you online without interruption.</p>
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
            <img src="{{ asset('resources/views/theme/marketi/assets/images/about/about-image.png') }}" alt="About Starlink" />
            <div class="about__shape1"><img src="{{ asset('resources/views/theme/marketi/assets/images/shape/about-shape1.png') }}" alt="shape" /></div>
            <div class="about__shape2"><img src="{{ asset('resources/views/theme/marketi/assets/images/shape/about-shape2.png') }}" alt="shape" /></div>
          </div>
        </div>
        <div class="col-xl-6">
          <div class="about__right-item">
            <div class="section-header">
              <h5 class="wow fadeInUp">About Starlink Kenya</h5>
              <h2 class="wow fadeInUp">Revolutionizing Internet Access<br>for Every Kenyan Home</h2>
              <p class="wow fadeInUp">
                Starlink delivers high‑speed satellite broadband that works where no other provider can. We handle supply, installation, activation, and ongoing maintenance—so you stay connected, always.
                <a href="{{ url('contact-us') }}" class="secondary-color fw-700 primary-hover">Get Started</a>
              </p>
            </div>
            <div class="about__counter mt-40">
              <div class="coun-item wow fadeInDown"><h3><span class="count">150+</span></h3><p>Kits Deployed</p></div>
              <div class="coun-item wow fadeInDown"><h3><span class="count">75+</span></h3><p>Installers Trained</p></div>
              <div class="coun-item wow fadeInDown"><h3><span class="count">24/7</span></h3><p>Local Support</p></div>
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
          <div class="service__icon mb-25"><img src="{{ asset('resources/views/theme/marketi/assets/images/icon/service-icon1.png') }}" alt="Kit Sale" /></div>
          <h3>Starlink Kit Sales</h3>
          <p>Order your complete Starlink hardware bundle—dish, router, mounts and cables—delivered to your door.</p>
          <a href="{{ url('contact-us') }}" class="explore-btn mt-15"><span>Order Now</span> <i class="fa-regular fa-arrow-right"></i></a>
        </div>
        <div class="service__item wow fadeInUp">
          <div class="service__icon mb-25"><img src="{{ asset('resources/views/theme/marketi/assets/images/icon/service-icon2.png') }}" alt="Installation" /></div>
          <h3>Expert Installation</h3>
          <p>Schedule a visit from our certified team—they’ll mount, align, and configure your kit for peak performance.</p>
          <a href="{{ url('contact-us') }}" class="explore-btn mt-15"><span>Book Installation</span> <i class="fa-regular fa-arrow-right"></i></a>
        </div>
        <div class="service__item wow fadeInUp">
          <div class="service__icon mb-25"><img src="{{ asset('resources/views/theme/marketi/assets/images/icon/service-icon3.png') }}" alt="Support" /></div>
          <h3>Maintenance & Support</h3>
          <p>Access round‑the‑clock technical assistance and routine maintenance plans to keep your link always online.</p>
          <a href="{{ url('contact-us') }}" class="explore-btn mt-15"><span>Contact Support</span> <i class="fa-regular fa-arrow-right"></i></a>
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
          <h2 class="wow fadeInUp">Our Simple 4‑Step Process</h2>
        </div>
        <p class="wow fadeInUp">
          From placing your order to enjoying seamless connectivity with 24/7 support.
        </p>
      </div>
      <div class="custom-row process__wrp">
        <div class="process__line"><img src="{{ asset('resources/views/theme/marketi/assets/images/shape/process-line.png') }}" alt="line" /></div>
        <div class="process__item">
          <div class="process__icon"><img src="{{ asset('resources/views/theme/marketi/assets/images/icon/process-icon1.png') }}" alt="icon" /></div>
          <h3 class="mt-20">1. Order Kit</h3>
          <p>Submit your requirements and we dispatch your genuine Starlink hardware.</p>
        </div>
        <div class="process__item">
          <div class="process__icon"><img src="{{ asset('resources/views/theme/marketi/assets/images/icon/process-icon2.png') }}" alt="icon" /></div>
          <h3 class="mt-20">2. Schedule Installation</h3>
          <p>Pick a convenient date and our team will handle the full setup.</p>
        </div>
        <div class="process__item">
          <div class="process__icon"><img src="{{ asset('resources/views/theme/marketi/assets/images/icon/process-icon3.png') }}" alt="icon" /></div>
          <h3 class="mt-20">3. Activate & Test</h3>
          <p>We ensure your link is live, tested and performing at top speeds.</p>
        </div>
        <div class="process__item">
          <div class="process__icon"><img src="{{ asset('resources/views/theme/marketi/assets/images/icon/process-icon4.png') }}" alt="icon" /></div>
          <h3 class="mt-20">4. Support & Maintenance</h3>
          <p>Enjoy ongoing local support and optional maintenance plans.</p>
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
            <h5 class="text-white text-center wow fadeInUp">Get Connected Today</h5>
            <h2 class="text-white text-center wow fadeInUp">
              Secure Your Starlink Kit & Installation Now!
            </h2>
            <p class="para-light-color text-center wow fadeInUp">
              Contact us for pricing, availability, and personalized setup plans.
            </p>
            <div class="btn__group text-center wow fadeInDown">
              <a href="{{ url('contact-us') }}" class="btn-two">Order Now<i class="fa-regular fa-arrow-right ml-10"></i></a>
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
