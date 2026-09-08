    <!-- Footer area start here -->
    <footer
      class="footer-area footer-bg bg-image"
      data-background="{{ asset('resources/views/theme/marketi/assets/images/bg/footer-bg.png') }}"
    >
      <div class="footer__main-wrp">
        <div class="container">
          <div class="footer__wrp pt-140 pb-90">
            <div class="row g-4 justify-content-between">
              <div
                class="col-lg-4 col-sm-6 wow fadeInUp"
                data-wow-delay="00ms"
                data-wow-duration="1000ms"
              >
                <div class="footer__item">
                  <a href="{{ route('home') }}" class="logo mb-20">
                    <img src="{{ logo_url() }}" alt="{{ get_option(site_id().'_site_name') }} logo" />
                  </a>
                  <p>
                    {{ get_option(site_id().'_site_name') }} supplies networking equipment and CCTV security
                    systems in Kenya — routers, switches, access points, network cables, IP cameras, NVRs, DVRs
                    and accessories.
                  </p>
                </div>
              </div>
              <div
                class="col-lg-2 col-sm-6 wow fadeInUp"
                data-wow-delay="200ms"
                data-wow-duration="1000ms"
              >
                <div class="footer__item">
                  <h4 class="title mb-20 text-white">Products</h4>
                  <ul class="link">
                    <li><a href="{{ route('shops_filter', 'networking-tools-accessories-routers') }}">Routers</a></li>
                    <li><a href="{{ route('shops_filter', 'networking-tools-accessories-switches') }}">Network Switches</a></li>
                    <li><a href="{{ route('shops_filter', 'networking-tools-accessories-access-points') }}">Access Points</a></li>
                    <li><a href="{{ route('shops_filter', 'cameras') }}">CCTV Cameras</a></li>
                    <li><a href="{{ route('shops_filter', 'networking-tools-accessories-ethernet-cables') }}">Network Cables</a></li>
                  </ul>
                </div>
              </div>
              <div
                class="col-lg-2 col-sm-6 wow fadeInUp"
                data-wow-delay="400ms"
                data-wow-duration="1000ms"
              >
                <div class="footer__item">
                  <h4 class="title mb-20 text-white">Company</h4>
                  <ul class="link">
                    <li><a href="{{ url('about-us') }}">About Us</a></li>
                    <li><a href="{{ route('shop') }}">Shop</a></li>
                    <li><a href="{{ url('blog') }}">Blog</a></li>
                    <li><a href="{{ url('contact-us') }}">Contact Us</a></li>
                  </ul>
                </div>
              </div>
              <div
                class="col-lg-3 col-sm-6 wow fadeInUp"
                data-wow-delay="600ms"
                data-wow-duration="1000ms"
              >
                <div class="footer__item">
                  <h4 class="title mb-20 text-white">Contact Info</h4>
                  <p class="mt-4">
                    Email:<br>
                    <a href="mailto:info@reisenseo.com">info@reisenseo.com</a><br><br>
                    Phone:<br>
                    <a href="tel:+254714804532">+254 714 804 532</a><br><br>
                    Address:<br>
                    Nairobi, Kijabe Street, Norfolk Towers, Kenya
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="footer__copytext">
        <p
          class="wow fadeInDown"
          data-wow-delay="400ms"
          data-wow-duration="1000ms"
        >
          &copy; {{ date('Y') }} {{ domain_name() }}. All rights reserved.
        </p>
      </div>
    </footer>
    <!-- Footer area end here -->

    <!-- Back to top btn area start here -->
    <button class="btn-backToTop">
      <i class="fa-solid fa-chevron-up"></i>
    </button>
    <!-- Back to top btn area end here -->

    <!-- Jquery 3. 7. 1 Min Js -->
    <script src="{{ asset('resources/views/theme/marketi/assets/js/jquery-3.7.1.min.js')}}"></script>
    <!-- Bootstrap min Js -->
    <script src="{{ asset('resources/views/theme/marketi/assets/js/bootstrap.min.js')}}"></script>
    <!-- Mean menu Js -->
    <script src="{{ asset('resources/views/theme/marketi/assets/js/meanmenu.js')}}"></script>
    <!-- Swiper bundle min Js -->
    <script src="{{ asset('resources/views/theme/marketi/assets/js/swiper-bundle.min.js')}}"></script>
    <!-- Counterup min Js -->
    <script src="{{ asset('resources/views/theme/marketi/assets/js/jquery.counterup.min.js')}}"></script>
    <!-- Wow min Js -->
    <script src="{{ asset('resources/views/theme/marketi/assets/js/wow.min.js')}}"></script>
    <!-- Magnific popup min Js -->
    <script src="{{ asset('resources/views/theme/marketi/assets/js/magnific-popup.min.js')}}"></script>
    <!-- Nice select min Js -->
    <script src="{{ asset('resources/views/theme/marketi/assets/js/nice-select.min.js')}}"></script>
    <!-- Parallax Js -->
    <script src="{{ asset('resources/views/theme/marketi/assets/js/parallax.js')}}"></script>
    <!-- Waypoints Js -->
    <script src="{{ asset('resources/views/theme/marketi/assets/js/jquery.waypoints.js')}}"></script>
    <!-- Script Js -->
    <script src="{{ asset('resources/views/theme/marketi/assets/js/script.js')}}"></script>
  </body>
</html>
