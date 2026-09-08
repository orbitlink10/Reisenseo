@extends('theme.marketi.header')
@section('title', 'About Reisen SEO | Expert Search Engine Optimization Services in Kenya')
@section('description', 'Learn about Reisen SEO, a leading provider of search engine optimization services in Kenya. Discover how our expert team can boost your online visibility and drive traffic to your website.')
{{-- @section('description') @if( ! empty(get_option(site_id().'_show_1_meta'))){{ substr(trim(preg_replace('/\s\s+/', ' ',strip_tags(get_option(site_id().'_show_1_meta')))),0,160) }}@endif @endsection --}}
@section('content') 



        <!-- About area start here -->
        <section class="about-two-area pt-120">
            <div class="container">
                <div class="section-header-two mb-40">
                    <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1000ms">About us</h5>
                    <p class="about-two__text wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1000ms">At
                        Reisen SEO, we understand the critical role that search engine
                        optimization plays in driving
                        online success for
                        businesses of all sizes.</p>
                </div>
                <div class="row g-5">
                    <div class="col-lg-6 wow fadeInLeft" data-wow-delay="00ms" data-wow-duration="1000ms">
                        <div class="about-two__item">
                            <h3 class="mb-10">Our Mission</h3>
                            <p>Our goal is to boost your online visibility and engagement, drive organic <br> traffic,
                                and
                                ultimately, maximize your digital
                                success.</p>
                            <a href="#0" class="explore-btn mt-20"><span>Learn More</span> <i
                                    class="fa-regular fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInLeft" data-wow-delay="200ms" data-wow-duration="1000ms">
                        <div class="about-two__item">
                            <h3 class="mb-10">Our Story</h3>
                            <p>Reisen SEO was founded on the principle that every business, regardless of size or industry,
                                deserves a tailored approach
                                to marketing.</p>
                            <a href="about.html" class="explore-btn mt-20"><span>Learn More</span> <i
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