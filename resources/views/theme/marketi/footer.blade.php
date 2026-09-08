    <!-- Footer area start here -->
    <footer
      class="footer-area footer-bg bg-image"
      data-background="assets/images/bg/footer-bg.png"
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
                  <a href="index-2.html" class="logo mb-20">
                    <img src="{{ logo_url() }}" alt="image" />
                  </a>
                  <p>
                    Optimize your success with our ROI-driven digital marketing
                    agency.
                  </p>
                  <div class="social-icon mt-20">
                    <a href="#0"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#0"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="#0"><i class="fa-brands fa-skype"></i></a>
                    <a href="#0"><i class="fa-brands fa-whatsapp"></i></a>
                  </div>
                </div>
              </div>
              <div
                class="col-lg-2 col-sm-6 wow fadeInUp"
                data-wow-delay="200ms"
                data-wow-duration="1000ms"
              >
                <div class="footer__item">
                  <h4 class="title mb-20 text-white">Company</h4>
                  <ul class="link">
                    <li>
                      <a href="{{ url('about-us') }}">About Us</a>
                    </li>
                    <li>
                      <a href="{{ url('about-us') }}">Services</a>
                    </li>
                    <li>
                      <a href="{{ url('contact-us') }}">Blog</a>
                    </li>
                    <li>
                      <a href="{{ url('contact-us') }}">Pricing</a>
                    </li>
                  </ul>
                </div>
              </div>
              <div
                class="col-lg-2 col-sm-6 wow fadeInUp"
                data-wow-delay="400ms"
                data-wow-duration="1000ms"
              >
                <div class="footer__item">
                  <h4 class="title mb-20 text-white">Support</h4>
                  <ul class="link">
                    <li>
                      <a href="{{ url('contact-us') }}">Contact Us</a>
                    </li>
                   
                    <li>
                      <a href="{{ url('contact-us') }}">Privacy Policy</a>
                    </li>
                    <li>
                      <a href="{{ url('contact-us') }}">Terms Conditions</a>
                    </li>
                    <li>
                      <a href="{{ url('contact-us') }}">Cookies</a>
                    </li>
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
                 info@reisenseo.com<br>
                 Phone:<br>
                +254 714 804 532
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
          &copy; All Copyright 2024 by
          <a href="#0" class="primary-hover">{{ domain_name() }}</a>
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

    <!-- <script>
      // Register the plugin
      gsap.registerPlugin(MotionPathPlugin);

      // Create the animation for moving the object
      var tl = gsap.timeline();
      tl.to("#movingObject", {
        duration: 10,
        ease: "none",
        motionPath: {
          path: "#motionPath",
          align: "self",
          autoRotate: false,
          alignOrigin: [0.5, 0.5],
        },
      }).to("#movingObject", {
        // Chain another animation to make the object disappear
        duration: 0.5, // Duration of the disappearance
        opacity: 0,
        onComplete: function () {
          // Set the display to 'none' after the opacity animation completes
          document.getElementById("movingObject").style.display = "none";
        },
      });
    </script> -->
  </body>

<!-- Mirrored from marketi-html.vercel.app/marketi-demo/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 07 Mar 2024 15:55:49 GMT -->
</html>
