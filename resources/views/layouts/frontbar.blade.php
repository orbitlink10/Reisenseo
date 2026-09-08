<!doctype html>
<html lang="en" dir="ltr">

<head>

  <!-- META DATA -->
  <meta charset="UTF-8">
  <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="@section('description'){{ get_option(site_id().'_meta_description') }} @show">
  <meta name="author" content="Awasam Online Experts">
  <meta name="keywords"
  content="Hire expert writer, Pay for essay">

  <!-- FAVICON -->
  <link rel="shortcut icon" type="image/x-icon" href="{{ favicon_url() }}" />

  <!-- TITLE -->
  <title>@section('title') {{ get_option(site_id().'_site_title') }} @show</title>

  @section('social-meta')
  <meta property="og:title" content="{{ get_option(site_id().'_site_title') }}">
  <meta property="og:description" content="{{ get_option(site_id().'_meta_description') }}">
  <meta property="og:url" content="{{ url('/') }}">
  <meta name="twitter:card" content="summary_large_image">
  <!--  Non-Essential, But Recommended -->
  <meta name="og:site_name" content="{{ get_option(site_id().'_site_name') }}">
  @show

  <!-- BOOTSTRAP CSS -->
  <link id="style" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />

  <!-- STYLE CSS -->
  <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet" />
  <link href="{{ asset('assets/css/dark-style.css')}}" rel="stylesheet" />

  <!--- FONT-ICONS CSS -->
  <link href="{{ asset('assets/css/icons.css')}}" rel="stylesheet" />

  <!-- COLOR SKIN CSS -->
  <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/colors/color1.css')}}" />
  @yield('page-css')

  <style type="text/css">
    /*  Sales Notification
    -------------------------------------------------------------------------------------------*/
    .alert-minimalist {
      background-color : #244DDC;
      border-radius : 5px;
      -webkit-box-shadow : 0 5px 40px rgba(14, 42, 76, 0.2);
      box-shadow : 0 5px 40px rgba(14, 42, 76, 0.2);
      padding : 10px;
      margin-left: 50%;
      width : 350px;
      z-index : 2147483648 !important;
    }
    .alert-minimalist [data-notify='dismiss'] {
      color : #ffffff;
    }
    .alert-minimalist #image {
      float : left;
    }
    .alert-minimalist #image [data-notify='icon'] {
      height : 60px;
      margin-right : 12px;
    }
    .alert-minimalist #text {
      float : left;
      margin-top : 2px;
    }
    .alert-minimalist #text [data-notify='title'] {
      color : #ffffff;
      line-height : 1rem;
      display : block;
      font-size : 85%;
      font-weight : 700;
    }
    .alert-minimalist #text [data-notify='message'] {
      font-size : 80%;
      color : #E9A447;
    }
    .alert-minimalist #text [data-notify='message'] span.blue {
      color : #ffffff;
      font-weight : 700;
    }
    .alert-minimalist #text [data-notify='time'] {
      display : block;
      font-size : 70%;
      color : #ffffff;
      margin-top : 4px;
    }
  </style>



  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-824XG936Z9"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-824XG936Z9');
  </script>

<!-- 
<script type="text/javascript">window.SB_USER_ID="Mg7sA1AkHxdvu1p8jAntRKYcJYv1";window.SB_PROJECT_ID="b64e2dce-b8be-4d6e-a341-bd4320986730";(function(){const d=document;const s=d.createElement("script");s.src="https://cdn.superbutton.app/widget.js";s["async"]=true;d.getElementsByTagName("head")[0].appendChild(s)})();
</script>
-->



@livewireStyles

</head>

<body class="app ltr landing-page horizontal light-mode">
  
  
  <script>
    (function(d,t) {
      var BASE_URL="https://CHANGE.herokuapp.com";
      var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
      g.src=BASE_URL+"/packs/js/sdk.js";
      g.defer = true;
      g.async = true;
      s.parentNode.insertBefore(g,s);
      g.onload=function(){
        window.chatwootSDK.run({
          websiteToken: 'X9q3Q8GNCJqTi5MLzpmgVpog',
          baseUrl: BASE_URL
        })
      }
    })(document,"script");
  </script>
  

  <!-- GLOBAL-LOADER -->
 <!--    <div id="global-loader">
        <img src="{{ asset('assets/images/loader.svg')}}" class="loader-img" alt="Loader">
      </div> -->
      <!-- /GLOBAL-LOADER -->

      <!-- PAGE -->
      <div class="page">
        <div class="page-main">

          <!-- app-Header -->
          <div class="hor-header header">
            <div class="container main-container">
              <div class="d-flex">
                <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar"
                href="javascript:void(0)"></a>
                <!-- sidebar-toggle-->
                <a class="logo-horizontal " href="{{ url('/')}}">
                  <img src="{{ logo_url() }}" idth="150" class="header-brand-img desktop-logo" alt="logo">
                  <img src="{{ logo_url() }}" width="150" class="header-brand-img light-logo1"
                  alt="logo">
                </a>
                <!-- LOGO -->
                <div class="d-flex order-lg-2 ms-auto header-right-icons">
                  <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button"
                  data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                  aria-controls="navbarSupportedContent-4" aria-expanded="false"
                  aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon fe fe-more-vertical"></span>
                </button>
                <div class="navbar navbar-collapse responsive-navbar p-0">
                  <div class="collapse navbar-collapse bg-white px-0" id="navbarSupportedContent-4">
                    <!-- SEARCH -->
                    <div class="header-nav-right p-5">
                      <a href="{{ route('register')}}" class="btn ripple btn-min w-sm btn-outline-primary me-2 my-auto"
                      target="_blank">New User
                    </a>
                    <a href="{{ route('login')}}" class="btn ripple btn-min w-sm btn-primary me-2 my-auto"
                    >Login
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /app-Header -->

    <div class="landing-top-header overflow-hidden">
      <div class="top sticky overflow-hidden">
        <!--APP-SIDEBAR-->
        <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
        <div class="app-sidebar bg-transparent horizontal-main">
          <div class="container">
            <div class="row">
              <div class="main-sidemenu navbar px-0">
                <a class="navbar-brand ps-0 d-none d-lg-block" href="{{ url('/')}}">
                  <img alt="" class="logo-2" src="{{ logo_url() }}" width="150">
                  <img src="{{ logo_url() }}" class="logo-3" alt="logo" width="150">
                </a>
                <ul class="side-menu">


                  <?php
                  $pages = \App\Models\Page::all();
                  ?>


                  @foreach($pages as $page)

                  @if(get_option(site_id().'_show_'.$page->id) == '1')
                  <li class="slide">
                    <a  data-bs-toggle="slide" href="{{ $page->path }}"><span
                      class="side-menu__label">{!! $page->name !!}</span></a>
                    </li>
                    @endif
                    @endforeach

                  </ul>



                  @if(domain_name() == "gondana.com"  or domain_name() == "localhost" or domain_name() == "writingtailor.com")

                  <div class="header-nav-right d-none d-lg-flex">
                   
                    <a href="{{ get_option(site_id().'_hero_button_url1') }}" target="_blank" 
                    class="btn ripple btn-min w-sm btn-outline-primary me-2 my-auto d-lg-none d-xl-block d-block"
                    >Live Preview
                  </a>
                  <a href="/pricing" class="btn ripple btn-min w-sm btn-primary me-2 my-auto d-lg-none d-xl-block d-block"
                  >Purchase
                </a>



              </div>

              @else
              <div class="header-nav-right d-none d-lg-flex">
                @guest
                
                <a href="{{ route('clogin')}}"
                class="btn ripple btn-min w-sm btn-outline-primary me-2 my-auto d-lg-none d-xl-block d-block"
                >Login
              </a>


              <a href="{{ route('cregister')}}" class="btn ripple btn-min w-sm btn-primary me-2 my-auto d-lg-none d-xl-block d-block"
              >Get Started
            </a>




            @else
            <a href="{{ route('register')}}"
            class="btn ripple btn-min w-sm btn-outline-primary me-2 my-auto d-lg-none d-xl-block d-block"
            >My Account
          </a>
          @endguest


        </div>

        @endif


      </div>
    </div>
  </div>
</div>
<!--/APP-SIDEBAR-->
</div>

@yield('content')


</div>
</div>
<!-- CONTAINER CLOSED-->
</div>
</div>
<!--app-content closed-->
</div>




<!-- FOOTER OPEN -->
<div class="demo-footer">
  <div class="container">

    @include('includes.subjects')
    <div class="row">
      <div class="card">
        <div class="card-body">
          <div class="top-footer">
            <div class="row">
              <div class="col-lg-3 col-sm-12 col-md-12 reveal revealleft">
                <h6>About</h6>
                <p>{!! get_option(site_id().'_footer_about') !!}
                </p>

              </div>
              
              <div class="col-lg-3 col-sm-6 col-md-4 reveal revealleft">
                <h6>Services</h6>

                <?php

                $services = \App\Models\Service::limit(6)->get();

                ?>
                <ul class="list-unstyled mb-5 mb-lg-0">
                  @foreach($services as $post)
                  <li><a href="{{ route('page_single', $post->slug)}}">{{ $post->name }}</a></li>
                  @endforeach
                </ul>

              </div>

              <div class="col-lg-3 col-sm-6 col-md-4 reveal revealleft">
                <h6>Quick Links</h6>
                <ul class="list-unstyled mb-5 mb-lg-0">
                  <?php
                  $pages = \App\Models\Page::where('show_in_footer_menu', 1)->get();
                  ?>


                  @foreach($pages as $page)

                  @if(get_option(site_id().'_show_'.$page->id) == '1')
                  <li class="slide">
                    <a  data-bs-toggle="slide" href="{{ $page->path }}"><span
                      class="side-menu__label">{{ $page->name }}</span></a>
                    </li>
                    @endif
                    @endforeach
                  </ul>
                </div>

                <div class="col-lg-3 col-sm-12 col-md-4 reveal revealleft">
                  <div class="card">
                    <div class="card-body p-0">
                      <div class="counter-status">
                        <div
                        class="counter-icon bg-secondary-transparent box-shadow-secondary">
                        <i
                        class="fe fe-headphones text-secondary fs-23"></i>
                      </div>
                      <h4
                      class="mb-2 fw-semibold">
                    Phone & Email</h4>
                    <p class="mb-0">{{ get_option(site_id().'_admin_phone') }} </p>
                    <p>{{ get_option(site_id().'_admin_email') }}</p>
                  </div>

                  <div class="btn-list mt-6">
                    <a href="{{ get_option(site_id().'_facebook') }}" target="_blank" class="btn btn-icon rounded-pill"><i class="fa fa-facebook"></i></a>
                    <a href="{{ get_option(site_id().'_linkedin') }}" target="_blank" class="btn btn-icon rounded-pill"><i class="fa fa-linkedin"></i></a>
                    <a href="{{ get_option(site_id().'_instagram') }}" target="_blank" class="btn btn-icon rounded-pill"><i class="fa fa-instagram"></i></a>
                    <a href="{{ get_option(site_id().'_twitter') }}" target="_blank" class="btn btn-icon rounded-pill"><i class="fa fa-twitter"></i></a>
                  </div>
                 </div>
              </div>                                                        
            </div>

          </div>
        </div>
        <footer class="main-footer px-0 pb-0 text-center">
          <div class="row ">
            <div class="col-md-12 col-sm-12">
              Copyright © <span id="year"></span> <a href="javascript:void(0)">{{ domain_name() }}</a>. All rights reserved.
            </div>
          </div>
        </footer>
      </div>
    </div>
  </div>
</div>
</div>
<!-- FOOTER CLOSED -->
</div>

<!-- BACK-TO-TOP -->
<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

<!-- JQUERY JS -->
<script src="{{ asset('assets/js/jquery.min.js')}}"></script>

<!-- BOOTSTRAP JS -->
<script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js')}}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

<!-- COUNTERS JS-->
<script src="{{ asset('assets/plugins/counters/counterup.min.js')}}"></script>
<script src="{{ asset('assets/plugins/counters/waypoints.min.js')}}"></script>
<script src="{{ asset('assets/plugins/counters/counters-1.js')}}"></script>

<!-- Perfect SCROLLBAR JS-->
<script src="{{ asset('assets/plugins/owl-carousel/owl.carousel.js')}}"></script>
<script src="{{ asset('assets/plugins/company-slider/slider.js')}}"></script>

<!-- Star Rating Js-->
<script src="{{ asset('assets/plugins/rating/jquery-rate-picker.js')}}"></script>
<script src="{{ asset('assets/plugins/rating/rating-picker.js')}}"></script>

<!-- Star Rating-1 Js-->
<script src="{{ asset('assets/plugins/ratings-2/jquery.star-rating.js')}}"></script>
<script src="{{ asset('assets/plugins/ratings-2/star-rating.js')}}"></script>

<!-- Perfect SCROLLBAR JS-->
<script src="{{ asset('assets/plugins/p-scroll/perfect-scrollbar.js')}}"></script>
<script src="{{ asset('assets/plugins/p-scroll/pscroll.js')}}"></script>
<script src="{{ asset('assets/plugins/p-scroll/pscroll-1.js')}}"></script>
<script src="{{ asset('assets/plugins/p-scroll/pscroll-2.js')}}"></script>

<!-- Sticky js -->
<script src="{{ asset('assets/js/sticky.js')}}"></script>

<script src="{{ asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
<!-- CUSTOM JS -->
<script src="{{ asset('assets/js/landing.js')}}"></script>

@if(Auth::check())
<!-- Smartsupp Live Chat script -->
<script type="text/javascript">
  var _smartsupp = _smartsupp || {};
  _smartsupp.key = '{{ get_option(site_id().'_chat_api') }}';
  window.smartsupp||(function(d) {
    var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
    s=d.getElementsByTagName('script')[0];c=d.createElement('script');
    c.type='text/javascript';c.charset='utf-8';c.async=true;
    c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
  })(document);

  smartsupp('name', '{{ Auth::user()->name }}');
  smartsupp('email', '{{ Auth::user()->email }}');
  smartsupp('phone', '{{ Auth::user()->phone }}');

  smartsupp('chat:show');
</script>
@endif
@if(!Auth::check())
<!-- Smartsupp Live Chat script -->
<script type="text/javascript">
  var _smartsupp = _smartsupp || {};
  _smartsupp.key = '{{ get_option(site_id().'_chat_api') }}';
  window.smartsupp||(function(d) {
    var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
    s=d.getElementsByTagName('script')[0];c=d.createElement('script');
    c.type='text/javascript';c.charset='utf-8';c.async=true;
    c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
  })(document);
</script>

@endif
<script src="{{ asset('assets/js/vendors.min.js')}}"></script>
<?php 
$date0 = \Carbon\Carbon::today();
$date1 = \Carbon\Carbon::today()->subDays(1);
$date2 = \Carbon\Carbon::today()->subDays(2);
$date3 = \Carbon\Carbon::today()->subDays(3);
$date4 = \Carbon\Carbon::today()->subDays(4);
$date5 = \Carbon\Carbon::today()->subDays(5);
$date6 = \Carbon\Carbon::today()->subDays(6);
$date7 = \Carbon\Carbon::today()->subDays(7);
$pcount0 = \App\Models\Order::where(DB::raw('date(created_at)'), $date0)->sum('word_count');
$pcount1 = \App\Models\Order::where(DB::raw('date(created_at)'), $date1)->sum('word_count');
$pcount2 = \App\Models\Order::where(DB::raw('date(created_at)'), $date2)->sum('word_count');

$pcount3 = \App\Models\Order::where(DB::raw('date(created_at)'), $date3)->sum('word_count');
?>

@if(get_option(site_id().'_show_popup') =='1')
<script type="text/javascript">

  $(window).on('load', function() {




    // Notification 1
    setTimeout(function() {
      var time = "Today";
      $.notify({
        title: 'Orders placed',
        message: '<span class="blue">{{ $pcount0 }}</span> pages has been ordered'
      },{
        type: 'minimalist',
        placement: {
          from: "bottom",
          align: "left"
        },
        animate: {
          enter: 'animated fadeInLeftBig',
          exit: 'animated fadeOutLeftBig'
        },
        icon_type: 'image',
        template: '<div data-notify="container" class="alert alert-{0}" role="alert">' +
        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
        '<div id="image">' +
        '<img data-notify="icon" class="rounded-circle float-left">' +
        '</div><div id="text">' +
        '<span data-notify="title">{1}</span>' +
        '<span data-notify="message">{2}</span>' +
        '<span data-notify="time">'+time+'</span>' +
        '</div>'+
        '</div>'
      });
    }, 3000);


      // Notification 1
    setTimeout(function() {
      var time = "Yesterday";
      $.notify({
        title: 'Orders placed',
        message: '<span class="blue">{{ $pcount1 }}</span> pages had been ordered'
      },{
        type: 'minimalist',
        placement: {
          from: "bottom",
          align: "left"
        },
        animate: {
          enter: 'animated fadeInLeftBig',
          exit: 'animated fadeOutLeftBig'
        },
        icon_type: 'image',
        template: '<div data-notify="container" class="alert alert-{0}" role="alert">' +
        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
        '<div id="image">' +
        '<img data-notify="icon" class="rounded-circle float-left">' +
        '</div><div id="text">' +
        '<span data-notify="title">{1}</span>' +
        '<span data-notify="message">{2}</span>' +
        '<span data-notify="time">'+time+'</span>' +
        '</div>'+
        '</div>'
      });
    }, 10000);


          // Notification 1
    setTimeout(function() {
      var time = "2 days ago";
      $.notify({
        title: 'Orders placed',
        message: '<span class="blue">{{ $pcount2 }}</span> pages had been ordered'
      },{
        type: 'minimalist',
        placement: {
          from: "bottom",
          align: "left"
        },
        animate: {
          enter: 'animated fadeInLeftBig',
          exit: 'animated fadeOutLeftBig'
        },
        icon_type: 'image',
        template: '<div data-notify="container" class="alert alert-{0}" role="alert">' +
        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
        '<div id="image">' +
        '<img data-notify="icon" class="rounded-circle float-left">' +
        '</div><div id="text">' +
        '<span data-notify="title">{1}</span>' +
        '<span data-notify="message">{2}</span>' +
        '<span data-notify="time">'+time+'</span>' +
        '</div>'+
        '</div>'
      });
    }, 15000);


              // Notification 1
    setTimeout(function() {
      var time = "3 days ago";
      $.notify({
        title: 'Orders placed',
        message: '<span class="blue">{{ $pcount3 }}</span> pages had been ordered'
      },{
        type: 'minimalist',
        placement: {
          from: "bottom",
          align: "left"
        },
        animate: {
          enter: 'animated fadeInLeftBig',
          exit: 'animated fadeOutLeftBig'
        },
        icon_type: 'image',
        template: '<div data-notify="container" class="alert alert-{0}" role="alert">' +
        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
        '<div id="image">' +
        '<img data-notify="icon" class="rounded-circle float-left">' +
        '</div><div id="text">' +
        '<span data-notify="title">{1}</span>' +
        '<span data-notify="message">{2}</span>' +
        '<span data-notify="time">'+time+'</span>' +
        '</div>'+
        '</div>'
      });
    }, 20000);

  });
</script>

@endif

@livewireScripts

<!-- <script src="https://localhost/awasam/chat-widget.js"></script> -->
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/651c38ebe6bed319d005803f/1hbr3smtj';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>

</html>