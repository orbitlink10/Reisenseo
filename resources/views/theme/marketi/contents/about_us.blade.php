@extends('theme.marketi.header')
@section('title', 'About Us | Networking & CCTV Equipment in Kenya')
@section('meta_description', 'Learn about Reisen SEO, a supplier of networking equipment and CCTV security systems in Kenya. We stock routers, switches, access points, network cables, IP cameras, NVRs and DVRs.')
@section('canonical', url('about-us'))
@section('content')

        <!-- About area start here -->
        <section class="about-two-area pt-120">
            <div class="container">
                <div class="section-header-two mb-40">
                    <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1000ms">About us</h5>
                    <h1 class="wow fadeInUp" data-wow-delay="150ms" data-wow-duration="1000ms">Networking Equipment &amp; CCTV Security in Kenya</h1>
                    <p class="about-two__text wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1000ms">At
                        {{ get_option(site_id().'_site_name') }}, we supply genuine networking equipment and CCTV
                        security systems to homes and businesses across Kenya — from routers and switches to
                        IP cameras and video recorders.</p>
                </div>
                <div class="row g-5">
                    <div class="col-lg-6 wow fadeInLeft" data-wow-delay="00ms" data-wow-duration="1000ms">
                        <div class="about-two__item">
                            <h3 class="mb-10">Our Mission</h3>
                            <p>To help Kenyan homes and businesses stay connected and secure by supplying reliable,
                                genuine networking and CCTV equipment with fast delivery and local support.</p>
                            <a href="{{ route('shop') }}" class="explore-btn mt-20"><span>Shop Equipment</span> <i
                                    class="fa-regular fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInLeft" data-wow-delay="200ms" data-wow-duration="1000ms">
                        <div class="about-two__item">
                            <h3 class="mb-10">What We Supply</h3>
                            <p>Routers, network switches, wireless access points, outdoor CPE, network cables, IP
                                cameras, NVRs, DVRs and a wide range of accessories for every budget.</p>
                            <a href="{{ url('contact-us') }}" class="explore-btn mt-20"><span>Contact Us</span> <i
                                    class="fa-regular fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About area end here -->



@endsection
@section('page-js')

@endsection
