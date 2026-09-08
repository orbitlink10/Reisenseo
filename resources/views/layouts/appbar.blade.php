<!doctype html>
<html lang="en" dir="ltr">

<head>

  <!-- META DATA -->
  <meta charset="UTF-8">
  <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="@lang('app.site_name') invoice software saves you time, gets you paid, and makes managing customer information stress-free.">
  <meta name="author" content="Awasam Online Experts">
  <meta name="keywords"
  content="@lang('app.site_name') saves you time">

  <!-- FAVICON -->
  <link rel="shortcut icon" type="image/x-icon" href="{{ favicon_url() }}" />

  <!-- TITLE -->
  <title>{{ domain_name() }} Order Management Platform </title>

  <!-- BOOTSTRAP CSS -->
  <link id="style" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />

  <!-- STYLE CSS -->
  <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet" />
  <link href="{{ asset('assets/css/dark-style.css')}}" rel="stylesheet" />
  <link href="{{ asset('assets/css/transparent-style.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/css/skin-modes.css')}}" rel="stylesheet" />

  <!--- FONT-ICONS CSS -->
  <link href="{{ asset('assets/css/icons.css')}}" rel="stylesheet" />




  <!-- COLOR SKIN CSS -->
  <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/colors/color1.css')}}" />

  <!-- INTERNAL Switcher css -->
  <link href="{{ asset('assets/switcher/css/switcher.css')}}" rel="stylesheet" />
  <link href="{{ asset('assets/switcher/demo.css')}}" rel="stylesheet" />

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-824XG936Z9"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-824XG936Z9');
</script>


  <script>
// Set the date we're counting down to
var countDownDate = new Date("{{ Auth::user()->subscribe_end }}").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Output the result in an element with id="demo2"
  document.getElementById("demo2").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";

  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo2").innerHTML = "EXPIRED";
  }
}, 1000);
</script>

<script type="text/javascript">window.SB_USER_ID="Mg7sA1AkHxdvu1p8jAntRKYcJYv1";window.SB_PROJECT_ID="b64e2dce-b8be-4d6e-a341-bd4320986730";(function(){const d=document;const s=d.createElement("script");s.src="https://cdn.superbutton.app/widget.js";s["async"]=true;d.getElementsByTagName("head")[0].appendChild(s)})();
</script>

@yield('page-css')
@livewireStyles
</head>

<body class="app sidebar-mini ltr light-mode">

  <!-- GLOBAL-LOADER -->
   <!--  <div id="global-loader">
        <img src="{{ asset('assets/images/loader.svg')}}" class="loader-img" alt="Loader">
      </div> -->
      <!-- /GLOBAL-LOADER -->

      <!-- PAGE -->
      <div class="page">
        <div class="page-main">

          <!-- app-Header -->
          <div class="app-header header sticky">
            <div class="container-fluid main-container">
              <div class="d-flex">
                <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)"></a>
                
                <!-- sidebar-toggle-->
                <a class="logo-horizontal " href="{{ url('/')}}">
                 <img src="{{ logo_url() }}" width="150" class="header-brand-img desktop-logo" alt="logo">
                 <img src="{{ logo_url() }}" width="150" class="header-brand-img light-logo1"
                 alt="logo">

               </a>
               @if(!Auth::user()->is_author())
               <!-- LOGO -->
               <div class="main-header-center ms-3 d-none d-lg-block">
                 <form action="{{ route('order')}}" method="GET">
                  <input type="text" class="form-control" name="search" id="typehead" placeholder="Search for order via id or title" autocomplete="off">
                  <button class="btn px-0 pt-2"><i class="fe fe-search" aria-hidden="true"></i></button>
                </form>
              </div>
              @endif
              @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
              <div class="main-header-center ms-3 d-none d-lg-block">
               <form action="{{ route('users')}}" method="GET">
                <input type="text" class="form-control" name="search" id="typehead" placeholder="Search for user via id, name, or email" autocomplete="off">
                <button class="btn px-0 pt-2"><i class="fe fe-search" aria-hidden="true"></i></button>
              </form>
            </div>
            @endif




            <div class="d-flex order-lg-2 ms-auto header-right-icons">
              <!-- SEARCH -->
              <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button"
              data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
              aria-controls="navbarSupportedContent-4" aria-expanded="false"
              aria-label="Toggle navigation">
              <span class="navbar-toggler-icon fe fe-more-vertical"></span>
            </button>
            <div class="navbar navbar-collapse responsive-navbar p-0">
              <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                <div class="d-flex order-lg-2">
                  <div class="dropdown d-lg-none d-flex">
                    <a href="javascript:void(0)" class="nav-link icon" data-bs-toggle="dropdown">
                      <i class="fe fe-search"></i>
                    </a>
                    <div class="dropdown-menu header-search dropdown-menu-start">
                      <div class="input-group w-100 p-2">
                        <input type="text" class="form-control" placeholder="Search....">
                        <div class="input-group-text btn btn-primary">
                          <i class="fa fa-search" aria-hidden="true"></i>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- COUNTRY -->

                  <div class="dropdown d-flex">

                    @if(Auth::user()->is_client() or Auth::user()->is_student()) 

                    <a href="{{ route('add_order')}}" class="btn btn-primary mt-1 mb-1 me-3">
                      <span>Place New Order</span>
                    </a>

                    <a href="{{ route('deposit')}}" class="btn btn-success mt-1 mb-1 me-3">
                      <span>Top Up Wallet</span>
                    </a>



                    @endif

                    @if(Auth::user()->is_writer())
                    <a href="{{ route('wpayments') }}" class="nav-link icon full-screen-link nav-link-bg">
                     <h5 class="text-dark mb-0 fs-14 fw-semibold">    Wallet Balance: {{ get_option('currency_sign') }} {{ (int) writer_balance(Auth::user()->id) }} </h5>
                   </a>
                   @endif

                   @if(Auth::user()->is_editor())
                   <a href="{{ route('epayments') }}" class="nav-link icon full-screen-link nav-link-bg">
                     <h5 class="text-dark mb-0 fs-14 fw-semibold">    Wallet Balance: {{ get_option('currency_sign') }} {{ (int) editor_balance(Auth::user()->id) }} </h5>
                   </a>
                   @endif

                   @if(Auth::user()->is_admin() or Auth::user()->is_author() or Auth::user()->is_subadmin() or Auth::user()->is_writer())



                   <a href="{{ route('logActivity')}}" class="nav-link icon full-screen-link nav-link-bg">
                     <h5 class="text-dark mb-0 fs-14 fw-semibold"> logActivity </h5>
                   </a>

                   <div class="dropdown d-flex profile-1">
                    <a href="javascript:void(0)" data-bs-toggle="dropdown" class="nav-link leading-none d-flex btn btn-primary mt-1 mb-1 me-3">
                     Add New
                   </a>
                   <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">

                    <div class="dropdown-divider m-0"></div>
                    @if(Auth::user()->is_admin())
                    <a href="{{ route('add_order') }}" class="dropdown-item"><i class="dropdown-icon fa fa-first-order"></i>New Order</a>
                    @endif

                    <a href="{{ route('posts') }}" class="dropdown-item"><i class="dropdown-icon fa fa-sticky-note-o"></i>New Post</a>

                    <a href="{{ route('post_page') }}" class="dropdown-item"><i class="dropdown-icon fa fa-sticky-note-o"></i>New Page</a>

                    <a href="{{ route('products') }}" class="dropdown-item"><i class="dropdown-icon fa fa-sticky-note-o"></i>New Product</a>
                    <a href="{{ route('trainings') }}" class="dropdown-item"><i class="dropdown-icon fa fa-sticky-note-o"></i>New Training</a>
                    @if(Auth::user()->is_admin())
                    <a href="{{ route('add_user') }}" class="dropdown-item"><i class="dropdown-icon fa fa-user"></i>New User</a>

                    <a href="{{ route('issues') }}" class="dropdown-item"><i class="dropdown-icon fa fa-user"></i>New Issue</a>
                    @endif
                  </div>
                </div>
                <?php

                             //user count 
                $c_count = \App\Models\User::whereUserType('client')->count();
                $w_count = \App\Models\User::whereUserType('writer')->count();
                $e_count = \App\Models\User::whereUserType('editor')->count();
                $s_count = \App\Models\User::whereUserType('student')->count();
                $web_count = \App\Models\Website::count();
                $site_count = \App\Models\Site::count();
                $sales_count = \App\Models\Sale::count();
                $websites = \App\Models\Website::all();
                ?>
                <div class="dropdown d-flex profile-1">
                  <a href="javascript:void(0)" data-bs-toggle="dropdown" class="nav-link leading-none d-flex btn btn-info mt-1 mb-1 me-3">
                   Quick Links
                 </a>
                 <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">

                  <div class="dropdown-divider m-0"></div>
                  <a href="{{ route('writers', ['users' => 'writer'])}}" class="dropdown-item"><i class="dropdown-icon fa fa-first-order"></i>Writers ( {{ $w_count }})</a>

                  <a href="{{ route('users', ['users' => 'client'])}}" class="dropdown-item"><i class="dropdown-icon fa fa-users"></i>Clients ( {{ $c_count }})</a>

                  <a href="{{ route('editors', ['users' => 'editor'])}}" class="dropdown-item"><i class="dropdown-icon fa fa-user"></i>Editors ( {{ $e_count }})</a>

                  <a href="{{ route('users', ['users' => 'student'])}}" class="dropdown-item"><i class="dropdown-icon fa fa-user"></i>Students ( {{ $s_count }})</a>

                  <a href="{{ route('payments')}}" class="dropdown-item"><i class="dropdown-icon fa fa fa-cc-amex"></i>Payments</a>


                  <a href="{{ route('websites')}}" class="dropdown-item"><i class="dropdown-icon fa fa-globe"></i>Websites ( {{ $web_count }})</a>

                  <a href="{{ route('sites')}}" class="dropdown-item"><i class="dropdown-icon fa fa-globe"></i>Sites ( {{ $site_count }})</a>


                  <a href="{{ route('sales')}}" class="dropdown-item"><i class="dropdown-icon fa fa-globe"></i>Sales ( {{ $sales_count }})</a>


                  
                </div>
              </div>

                               <div class="dropdown d-flex profile-1">
                  <a href="javascript:void(0)" data-bs-toggle="dropdown" class="nav-link leading-none d-flex btn btn-info btn-sm mt-1 mb-1 me-3">
                   My Sites
                  </a>
                  <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">

                    <div class="dropdown-divider m-0"></div>

                    @foreach($websites as $website)

                    <a href="{{ route('website_info', $website->id )}}" class="dropdown-item">{{ $website->domain_name }}
                    </a>

               @endforeach


                  </div>
                </div>


              @endif



            </div>


            <!-- SIDE-MENU -->

            <!-- SIDE-MENU -->
            <div class="dropdown d-flex profile-1">
              <a href="javascript:void(0)" data-bs-toggle="dropdown" class="nav-link leading-none d-flex">
               <img src="{{ Auth::user()->get_gravatar(150) }}" alt="profile-user"
               class="avatar  profile-user brround cover-image">
             </a>
             <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <div class="drop-heading">
                <div class="text-center">
                  <h5 class="text-dark mb-0 fs-14 fw-semibold">    
                    {{ Auth::user()->name }} </h5>
                    <h5 class="text-dark mb-0 fs-14 fw-semibold"> 
                      Merchant ID:    
                      {{ Auth::user()->id }} </h5>

                    </div>
                  </div>
                  <div class="dropdown-divider m-0"></div>
                  <a href="{{ route('account') }}" class="dropdown-item"><i class="dropdown-icon fa fa-user"></i>Profile</a>
                  @if(Auth::user()->is_client())
                  @if(domain_name() == 'saseni.com')

                  <a style="display: {{ get_option('enable_dc') == 1 ? 'block' : 'none' }}" href="{{ route('subscribe')}}" class="dropdown-item"><i class="dropdown-icon fa fa-sign-in"></i> Subscriptions</a>
                  @endif
                  @endif

                  <!--        <a href="{{ route('switcher') }}" class="dropdown-item"><i class="dropdown-icon fa fa-user"></i>Switcher </a> -->

                  

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /app-Header -->
<div class="row">
  <div class="col-12">



    <div class="pull-right">  @include('flash_msg')


      @if(Auth::user()->is_writer())
<div class="row">
  <div class="col-3">
  </div>

    <div class="col-8">

      <div class="alert alert-success" role="alert">
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">×</button>
                                                    <i class="fa fa-check-circle-o me-2" aria-hidden="true"></i> Hi {{ Auth::user()->name }}, I want to take a moment to remind you of the value and importance of the work we do for our clients. If you do a good job for the client, he or she will come back and request you again.

Our clients entrust us with their projects, expecting nothing short of excellence. Your dedication, attention to detail, and commitment to meeting their needs not only strengthen our relationship with them but also enhance our reputation as a reliable platform.
                                                </div>
  </div>
    <div class="col-1">
  </div>

           


    </div>
    @endif


    </div>
  </div>
</div>

<!--APP-SIDEBAR-->
<div class="sticky">
  <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
  <div class="app-sidebar">
    <div class="side-header">
      <a class="header-brand1" href="{{ url('/')}}">
        <img src="{{ logo_url() }}" width="150" class="header-brand-img desktop-logo" alt="logo">
        <img src="{{ favicon_url() }}" width="150" class="header-brand-img toggle-logo"
        alt="logo">
        <img src="{{ favicon_url() }}" width="150" class="header-brand-img light-logo" alt="logo">
        <img src="{{ logo_url() }}" width="150" class="header-brand-img light-logo1"
        alt="logo"> 

        
      </a>
      <!-- LOGO -->
    </div>


    <div class="main-sidemenu">
      <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg"
        fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
        <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
      </svg></div>
      <ul class="side-menu">
        <li class="sub-category">

          @if(Auth::user()->is_admin())

          <span class="badge bg-secondary fs-14 me-2">Super Admin Account</span>


          @endif

          @if(Auth::user()->is_subadmin())
          <span class="badge bg-secondary fs-14 me-2">Sub Admin Account</span>
          @endif

          @if(Auth::user()->is_editor())
          <span class="badge bg-secondary fs-14 me-2">Editor Account</span>
          @endif

          @if(Auth::user()->is_client())
        <!--   @if(Auth::user()->account_status == '1')
          <a href="{{ route('subscribe')}}" style="display: {{ get_option('enable_dc') == 1 ? 'block' : 'none' }}">
           <span class="badge bg-secondary fs-14 me-2">{{ package(Auth::user()->package)->name ?? 'none' }}</span>
           <span><p style="color: green;" id="demo2"></p> </span>
         </a>
         @else

         <a style="display: {{ get_option('enable_dc') == 1 ? 'block' : 'none' }}" href="{{ route('subscribe')}}" class="btn btn-warning btn-sm"> <span>Get a Premium account</span></a>
         @endif -->

         <span class="badge bg-secondary fs-14 me-2">Client Account</span>
         @endif

         @if(Auth::user()->is_writer())

         @if(Auth::user()->account_status == '1')
 @if(Auth::user()->added_by == 'client')
       
         @else
           <a href="{{ route('subscribe')}}">
           <span class="badge bg-secondary fs-14 me-2">{{ package(Auth::user()->package)->name ?? 'none' }}</span>
           <span><p style="color: green;" id="demo2"></p> </span>
         </a>
         @endif
         @elseif(Auth::user()->account_status == '2')
          <span class="badge bg-secondary fs-14 me-2">Account Suspended</span>
         @else

         @if(Auth::user()->applicant == '0')
         <form action="{{ route('subscribe_data')}}" method="POST"> 
          @csrf
          <input type="hidden" name="package" value="9">
          <span> Expired  </span>
          <button class="btn btn-success">Subscribe Now </button>
        </form>
        @endif

        @endif 

        <!--       <span class="badge bg-secondary fs-14 me-2">Writer Account</span> -->
        @endif

      </li>

      <li class="slide">
        <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ url('dashboard')}}"><i
          class="side-menu__icon fa fa-dashboard"></i><span
          class="side-menu__label">Dashboard</span></a>
        </li>

@if (Auth::user()->is_admin()) 
        <li class="slide">
        <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('issues')}}"><i
          class="side-menu__icon fa fa-dashboard"></i><span
          class="side-menu__label">My Tasks</span></a>
        </li>
        <li class="slide">
        <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('categories')}}"><i
          class="side-menu__icon fa fa-dashboard"></i><span
          class="side-menu__label">Categories</span></a>
        </li>
        <li class="slide">
        <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('products')}}"><i
          class="side-menu__icon fa fa-dashboard"></i><span
          class="side-menu__label">Products</span></a>
        </li>
        @endif

        <?php

        if (Auth::user()->is_admin()) {
          $allorders = \App\Models\Order::count();
          $porders = \App\Models\Order::whereStatus(0)->count();
          $asorders = \App\Models\Order::whereWriterConfirm(0)->whereStatus(2)->count();
          $tporders   = \App\Models\Order::whereStatus(0)->whereOrderLevel('technical')->count();
          $aorders = \App\Models\Order::whereStatus(1)->count();
          $arorders = \App\Models\Order::whereStatus(1)->where('preferred_writer', '>', '0')->count();
          $iorders = \App\Models\Order::whereWriterConfirm(2)->whereStatus(2)->count();
          $eorders = \App\Models\Order::whereStatus(3)->count();
          $corders = \App\Models\Order::whereStatus(4)->count();
          $aporders = \App\Models\Order::whereStatus(5)->count();
          $rorders = \App\Models\Order::whereStatus(6)->count();
          $erorders = \App\Models\Order::whereStatus(8)->count();
          $dorders = \App\Models\Order::whereStatus(9)->count();
          $caorders = \App\Models\Order::whereStatus(7)->count();
          $uorders = \App\Models\Order::whereEcost(0)->whereStatus(3)->count();
          $plorders = \App\Models\Order::wherePaymentWay(1)->count();
          $invoice_count = \App\Models\Invoice::whereStatus(0)->whereInvoiceType('custom')->count();
          $finedorders = \App\Models\Order::where('order_fine', '>', 0)->count();



          $chat_count = \App\Models\Chat::whereFeature('0')->count();

          $wnews_count = \App\Models\Post::whereParentPage(8)->count();
          $aplorders =   \App\Models\Order::whereUserId(5)->wherePaymentWay(1)->count();
          $lplorders = \App\Models\Order::whereUserId(3)->wherePaymentWay(1)->count();
        }

        if (Auth::user()->is_subadmin()) {
          $allorders = \App\Models\Order::count();
          $porders = \App\Models\Order::whereStatus(0)->count();
          $asorders = \App\Models\Order::whereWriterConfirm(0)->whereStatus(2)->count();
          $tporders   = \App\Models\Order::whereStatus(0)->whereOrderLevel('technical')->count();
          $aorders = \App\Models\Order::whereStatus(1)->count();
          $arorders = \App\Models\Order::whereStatus(1)->count();
          $iorders = \App\Models\Order::whereWriterConfirm(2)->whereStatus(2)->count();
          $eorders = \App\Models\Order::whereStatus(3)->count();
          $corders = \App\Models\Order::whereStatus(4)->count();
          $aporders = \App\Models\Order::whereStatus(5)->count();
          $rorders = \App\Models\Order::whereStatus(6)->count();
          $erorders = \App\Models\Order::whereStatus(8)->count();
          $dorders = \App\Models\Order::whereStatus(9)->count();
          $caorders = \App\Models\Order::whereStatus(7)->count();
          $uorders = \App\Models\Order::whereEcost(0)->whereStatus(3)->count();
          $invoice_count = \App\Models\Invoice::whereStatus(0)->whereInvoiceType('custom')->count();
          $finedorders = \App\Models\Order::where('order_fine', '>', 0)->count();

                             //user count 
          $c_count = \App\Models\User::whereUserType('client')->count();
          $w_count = \App\Models\User::whereUserType('writer')->count();
          $e_count = \App\Models\User::whereUserType('editor')->count();
          $chat_count = \App\Models\Chat::whereFeature('0')->count();
        }

        if (Auth::user()->is_editor()) {
          $allorders = \App\Models\Order::whereEditorId(Auth::user()->id)->count();
          $asorders = \App\Models\Order::whereWriterConfirm(0)->whereStatus(2)->count();
          $aaorders = \App\Models\Order::whereStatus(1)->whereOrderLevel('normal')->count();
          $porders = \App\Models\Order::whereEditorId(Auth::user()->id)->whereStatus(0)->count();
          $aorders = \App\Models\Order::whereStatus(3)->where('ecost', '>', 0)->where('editor_id', '==', 0)->count();
          $iorders = \App\Models\Order::whereWriterConfirm(2)->whereEditorId(Auth::user()->id)->whereStatus(2)->count();
          $eorders = \App\Models\Order::whereEditorId(Auth::user()->id)->whereStatus(3)->count();
          $uorders = \App\Models\Order::whereEcost(0)->whereStatus(3)->count();
          $corders = \App\Models\Order::whereEditorId(Auth::user()->id)->whereStatus(4)->count();
          $aporders = \App\Models\Order::whereEditorId(Auth::user()->id)->whereStatus(5)->count();
          $rorders = \App\Models\Order::whereEditorId(Auth::user()->id)->whereStatus(6)->count();
          $erorders = \App\Models\Order::whereEditorId(Auth::user()->id)->whereStatus(8)->count();
          $dorders = \App\Models\Order::whereEditorId(Auth::user()->id)->whereStatus(9)->count();
          $caorders = \App\Models\Order::whereEditorId(Auth::user()->id)->whereStatus(7)->count();
          $chat_count = \App\Models\Chat::whereMessageTo(Auth::user()->id)->count();
        }

        if (Auth::user()->is_client() or Auth::user()->is_student()) {
          $allorders = \App\Models\Order::whereUserId(Auth::user()->id)->count();
          $porders = \App\Models\Order::whereUserId(Auth::user()->id)->whereStatus(0)->count();
          $aorders = \App\Models\Order::whereUserId(Auth::user()->id)->whereStatus(1)->count();
          $iorders = \App\Models\Order::whereUserId(Auth::user()->id)->whereStatus(2)->count();
          $eorders = \App\Models\Order::whereUserId(Auth::user()->id)->whereStatus(3)->count();
          $corders = \App\Models\Order::whereUserId(Auth::user()->id)->whereStatus(4)->count();
          $aporders = \App\Models\Order::whereUserId(Auth::user()->id)->whereStatus(5)->count();
          $rorders = \App\Models\Order::whereUserId(Auth::user()->id)->whereStatus(6)->count();
          $erorders = \App\Models\Order::whereUserId(Auth::user()->id)->whereStatus(8)->count();
          $dorders = \App\Models\Order::whereUserId(Auth::user()->id)->whereStatus(9)->count();
          $caorders = \App\Models\Order::whereUserId(Auth::user()->id)->whereStatus(7)->count();
          $chat_count = \App\Models\Chat::whereMessageTo(Auth::user()->id)->count();

          $aplorders = \App\Models\Order::whereUserId(5)->wherePaymentWay(1)->count();
          $lplorders = \App\Models\Order::whereUserId(3)->wherePaymentWay(1)->count();
          $invoice_count = \App\Models\Invoice::whereUserId(Auth::user()->id)->whereInvoiceType('custom')->whereStatus(0)->count();
        }

        if (Auth::user()->is_writer()) {

          $allorders = \App\Models\Order::whereWriterId(Auth::user()->id)->count();
          $porders   = \App\Models\Order::whereWriterId(Auth::user()->id)->whereStatus(0)->count();
          $tporders   = \App\Models\Order::whereStatus(0)->whereOrderLevel('technical')->count();
                     if(Auth::user()->added_by == 'client'){
 $tporders = \App\Models\Order::whereStatus(0)->whereUserId(Auth::user()->user_id)->whereOrderLevel('technical')->count();
  }

          $aorders = \App\Models\Order::whereStatus(1)->count();
   

          $arorders = \App\Models\Order::whereStatus(1)->wherePreferredWriter(Auth::user()->id)->count();
          $asorders = \App\Models\Order::whereWriterId(Auth::user()->id)->whereWriterConfirm(0)->whereStatus(2)->count();
          $iorders = \App\Models\Order::whereWriterConfirm(2)->whereWriterId(Auth::user()->id)->whereWriterConfirm(2)->whereStatus(2)->count();
          $eorders = \App\Models\Order::whereWriterId(Auth::user()->id)->whereStatus(3)->count();
          $corders = \App\Models\Order::whereWriterId(Auth::user()->id)->whereStatus(4)->count();
          $aporders = \App\Models\Order::whereWriterId(Auth::user()->id)->whereStatus(5)->count();
          $rorders = \App\Models\Order::whereWriterId(Auth::user()->id)->whereStatus(6)->count();
          $erorders = \App\Models\Order::whereWriterId(Auth::user()->id)->whereStatus(8)->count();
          $dorders = \App\Models\Order::whereWriterId(Auth::user()->id)->whereStatus(9)->count();
          $caorders = \App\Models\Order::whereWriterId(Auth::user()->id)->whereStatus(7)->count();
          $chat_count = \App\Models\Chat::whereMessageTo(Auth::user()->id)->count();

          $wnews_count = \App\Models\Post::whereParentPage(8)->count();
          $wreview_count = \App\Models\Review_rating::whereWriterId(Auth::user()->id)->count();
        }


        ?>
        @if(!Auth::user()->is_author())
        @if(Auth::user()->is_admin())
        <li class="slide">
          <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('sms')}}"><i
            class="side-menu__icon fa fa-comment"></i><span
            class="side-menu__label">SMS Balance ({{ sms_balance() }})</span></a>
          </li> 
          @endif

          @if(Auth::user()->is_client())

          <li class="slide">
            <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('payments')}}"><i
              class="side-menu__icon fa fa-money"></i><span
              class="side-menu__label"> Balance {{ price(wallet(Auth::user()->id))}} </span></a>
            </li>



            @endif


            @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
            <?php
            $messages      = \App\Models\Chat::whereAdminMessageRead(0)->orderBy('id', 'desc')->limit(50)->get();
            $messages_count  = \App\Models\Chat::whereAdminMessageRead(0)->count();
            ?>
            @else

            <?php
            $messages = \App\Models\Chat::whereMessageRead(0)->whereMessageTo(Auth::user()->id)->orderBy('id', 'desc')->limit(50)->get();
            $messages_count = \App\Models\Chat::whereMessageRead(0)->whereMessageTo(Auth::user()->id)->count();
            ?>
            @endif


            <li class="slide">   


              <a href="javascript:void(0);" class="side-menu__item has-link"
              data-bs-toggle="sidebar-right" data-target=".sidebar-right">
              <i class="side-menu__icon fe fe-message-square"></i>
              <span class="pulse-danger "></span>
              <span class="side-menu__label"> Notifications </span>
              <span class="badge bg-pink side-badge">{{ $messages_count }}</span>

            </a>


          </li>


          <li class="slide">
            <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('order')}}"><i class="side-menu__icon fe fe-folder"></i><span class="side-menu__label">My Orders</span><span class="badge bg-pink side-badge">{{ $allorders }}</span><i class="angle fe fe-chevron-right hor-angle"></i></a>

          </li>

          <div style="margin-left: 80px;">
           @if(Auth::user()->is_admin() or Auth::user()->is_client() or Auth::user()->is_subadmin() or Auth::user()->is_student())
           @if($porders>0)
           <li><a href="{{ route('order', ['q' => 'pending'])}}" class="slide-item"> Pending    ({{ $porders }})</a></li>
           @endif
           @endif

           @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
           @if($tporders>0)
           <li><a href="{{ route('order', ['level' => 'technical'])}}" class="slide-item"> Pending Technical  ({{ $tporders }})</a></li>
           @endif
           @endif

           @if(Auth::user()->is_editor())

           <!--     <li><a href="{{ route('order', ['aa' => '1'])}}" class="slide-item"> Assign Writers  ({{ $aaorders }})</a></li> -->

           @endif

           @if(Auth::user()->is_writer())

           <li><a href="{{ route('order', ['wa' => '1'])}}" class="slide-item"> Available  ({{ $aorders + $tporders }})</a></li>
           @if($arorders>0)
           <li><a href="{{ route('order', ['or' => '1'])}}" class="slide-item"> Client Requests  ({{ $arorders }})</a></li>
           @endif
<!--          @if(Auth::user()->expert_in == '2')
         <li><a href="{{ route('order', ['level' => 'technical'])}}" class="slide-item"> Available Technical  ({{ $tporders }})</a></li>
         @endif -->

         @else
         @if($aorders>0)
         <li><a href="{{ route('order_available') }}" class="slide-item"> Available  ({{ $aorders }})</a></li>
         @endif

         @endif
         @if(Auth::user()->is_writer() or Auth::user()->is_admin() or Auth::user()->is_subadmin() or Auth::user()->is_editor())
         @if($asorders>0)
         <li><a href="{{ route('order', ['c' => 'unconfirmed'])}}" class="slide-item"> Unconfirmed  ({{ $asorders }})</a></li>
         @endif
         @endif

         @if($iorders>0)
         <li><a href="{{ route('order_inprogress')}}" class="slide-item"> In progress ({{ $iorders }})</a></li>
         @endif

         @if($eorders>0)
         <li><a href="{{ route('order_editing')}}" class="slide-item">  Editing ({{ $eorders }})</a></li>
         @endif

         @if(Auth::user()->is_editor() or Auth::user()->is_admin() or Auth::user()->is_subadmin())
         <li><a href="{{ route('order_uediting')}}" class="slide-item"> Upload to client ({{ $uorders }})</a></li>
         @endif


         @if($erorders>0)
         <li><a href="{{ route('order', ['q' => '8'])}}" class="slide-item"> Editor Revision ({{ $erorders }})</a></li>
         @endif

         @if($corders>0)
         <li><a href="{{ route('order_completed')}}" class="slide-item"> Completed ({{ $corders }})</a>
         </li>
         @endif
         @if($rorders>0)
         <li><a href="{{ route('order', ['q' => '6'])}}" class="slide-item"> Client Revision ({{ $rorders }})</a></li>
         @endif

         @if($aporders>0)
         <li><a href="{{ route('order_approved')}}" class="slide-item"> Approved ({{ $aporders }})</a></li>
         @endif

         @if($dorders>0)
         <li>
          <a href="{{ route('order', ['q' => '9'])}}" class="slide-item"> Disputes ({{ $dorders }})</a>
        </li>
        @endif


        @if($caorders>0)
        <li><a href="{{ route('order', ['q' => '7'])}}" class="slide-item"> Cancelled ({{ $caorders }})</a></li>
        @endif

        @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
        
        @if($finedorders>0)
        <li><a href="{{ route('order_fined')}}" class="slide-item"> Fined  ({{ $finedorders }})</a></li>
        @endif
        @endif

        
        @if(Auth::user()->is_admin())

        <li><a href="{{ route('payment_way')}}" class="slide-item"> Pay Later ({{ $plorders }})</a></li>
        @endif

        @if(Auth::user()->id == 3)
        <li><a href="{{ route('payment_way')}}" class="slide-item"> Pay Later ({{ $lplorders }})</a></li>
        @endif

        @if(Auth::user()->id == 5)
        <li><a href="{{ route('payment_way')}}" class="slide-item"> Pay Later ({{ $aplorders }})</a></li>
        @endif

      </div> 

      @if(domain_name() == 'saseni.com' or domain_name() == 'localhost')
      @if(Auth::user()->is_client() or Auth::user()->is_student())
      <li class="slide">
        <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('saseni_writers')}}"><i
          class="side-menu__icon fa fa-users"></i><span
          class="side-menu__label">Saseni Writers</span></a>
        </li>

          <li class="slide">
        <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('my_writers')}}"><i
          class="side-menu__icon fa fa-users"></i><span
          class="side-menu__label">My Writers</span></a>
        </li>
        @endif
        @endif

        @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
        <?php
        $messages      = \App\Models\Chat::whereAdminMessageRead(0)->orderBy('id', 'desc')->limit(50)->get();
        $messages_count  = \App\Models\Chat::whereAdminMessageRead(0)->count();
        ?>
        @else

        <?php
        $messages = \App\Models\Chat::whereMessageRead(0)->whereMessageTo(Auth::user()->id)->orderBy('id', 'desc')->limit(50)->get();
        $messages_count = \App\Models\Chat::whereMessageRead(0)->whereMessageTo(Auth::user()->id)->count();
        ?>
        @endif

        <li class="slide">
          <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('messages')}}"><i
            class="side-menu__icon fa fa-comment"></i><span
            class="side-menu__label">Chats ( {{ $messages_count }} unread)</span></a>
          </li> 

     <!--     <li class="slide">
            <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('inbox')}}"><i
              class="side-menu__icon fa fa-comment"></i><span
              class="side-menu__label">Messages</span></a>
            </li>   -->

            @if(Auth::user()->is_admin() or Auth::user()->is_writer())

            <li class="slide">
              <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('news')}}"><i
                class="side-menu__icon fa fa-newspaper-o"></i><span
                class="side-menu__label">NEWS ({{ $wnews_count }})</span></a>
              </li>

              <li class="slide">
                <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('wrules')}}"><i
                  class="side-menu__icon fa fa-newspaper-o"></i><span
                  class="side-menu__label">Rules & Regulations</span></a>
                </li>

                <li class="slide">
                  <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('samples')}}"><i
                    class="side-menu__icon fa fa-newspaper-o"></i><span
                    class="side-menu__label">Samples</span></a>
                  </li>
                  @endif

                  @if(Auth::user()->is_writer())
                  <li class="slide">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('wreviews')}}"><i
                      class="side-menu__icon fa fa-star"></i><span
                      class="side-menu__label">My Reviews ({{ $wreview_count }})</span></a>
                    </li>



                    <li class="slide">
                      <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('invoices')}}"><i
                        class="side-menu__icon fa fa-exchange"></i><span
                        class="side-menu__label">Invoices</span></a>
                      </li>




                      @endif






                      @if(Auth::user()->is_client() or Auth::user()->is_student() or Auth::user()->is_admin())
                      <li class="slide">
                        <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('custom_invoices')}}"><i
                          class="side-menu__icon fa fa-exchange"></i><span
                          class="side-menu__label">Custom Invoices ({{ $invoice_count }})</span></a>
                        </li>



                        @if(Auth::user()->is_client())

                        <li class="slide">
                          <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('customer_rules')}}"><i
                            class="side-menu__icon fa fa-star"></i><span
                            class="side-menu__label">Recommendations</span></a>
                          </li> 

                          @endif

                          @if(Auth::user()->is_admin())
                          <li class="slide" style="display: {{ get_option('enable_dc') == 1 ? 'block' : 'none' }}">
                            <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('subscriptions')}}"><i
                              class="side-menu__icon fa fa-sign-in"></i><span
                              class="side-menu__label">Subscriptions</span></a>
                            </li>
                            @endif

                            @endif

                            @if(Auth::user()->is_editor())



                            <li class="slide">
                              <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('writers')}}"><i
                                class="side-menu__icon fa fa-users"></i><span
                                class="side-menu__label">My Writers</span></a>
                              </li>

                              <li class="slide">
                                <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('epayments')}}"><i
                                  class="side-menu__icon fa fa-exchange"></i><span
                                  class="side-menu__label">Payments</span></a>
                                </li>

                                <li class="slide">
                                  <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('invoices')}}"><i
                                    class="side-menu__icon fa fa-exchange"></i><span
                                    class="side-menu__label">Invoices</span></a>
                                  </li>

                                  @endif

                                  

                                  <li class="slide">


                                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="#" onclick="smartsupp('chat:open'); return false;"><i
                                      class="side-menu__icon fa fa-info-circle"></i> Help Center</a>


                                    </li>









                                    @if(Auth::user()->is_admin())

                                    <li class="slide">
                                      <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('media')}}"><i
                                        class="side-menu__icon fa fa-file"></i><span
                                        class="side-menu__label">File Manager</span></a>
                                      </li> 



                                      @if(domain_name() == 'saseni.com' or domain_name() == 'localhost')
                                      <li class="slide">
                                        <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('finance')}}"><i
                                          class="side-menu__icon fa fa-money"></i><span
                                          class="side-menu__label">Finance</span></a>
                                        </li>

                                        @endif

                                        <li class="slide">
                                          <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('emails')}}"><i
                                            class="side-menu__icon fa fa-envelope"></i><span
                                            class="side-menu__label">Communication</span></a>
                                          </li>




                                          


                                          <li class="slide">
                                            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="side-menu__icon fe fe-user"></i><span class="side-menu__label">Manage Invoices</span><span class="badge bg-pink side-badge">></span><i class="angle fe fe-chevron-right hor-angle"></i></a>
                                            <ul class="slide-menu">
                                              <li class="side-menu-label1"><a href="{{ route('invoices')}}">Writer Invoices</a></li>

                                              <li><a href="{{ route('invoices')}}" class="slide-item"> Writer Invoices</a></li>

                                              <li><a href="{{ route('einvoices')}}" class="slide-item"> Editor Invoices</a></li>



                                            </ul>
                                          </li>



            <li class="slide">
                                            <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('categories')}}"><i class="side-menu__icon fa fa-exchange">

                                            </i><span class="side-menu__label">Categories Settings</span></a>
                                          </li>


                                          <li class="slide">
                                            <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('issues')}}"><i class="side-menu__icon fa fa-exchange">

                                            </i><span class="side-menu__label">System Issues</span></a>
                                          </li>

                                          <li class="slide">
                                            <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('websites')}}"><i class="side-menu__icon fa fa-globe">

                                            </i><span class="side-menu__label">Manage Websites</span></a>
                                          </li>

                                          <li class="slide">
                                            <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('order_settings')}}"><i
                                              class="side-menu__icon fe fe-settings"></i><span
                                              class="side-menu__label">Order Settings</span></a>
                                            </li>

                                            <li class="slide">
                                              <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('settings')}}"><i
                                                class="side-menu__icon fe fe-settings"></i><span
                                                class="side-menu__label">System Settings</span></a>
                                              </li>

                                              @else
                                              @endif
                                              @endif

                                              @if(Auth::user()->is_admin() or Auth::user()->is_author())

                                                  <li class="slide">
                                            <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('categories')}}"><i class="side-menu__icon fa fa-exchange">

                                            </i><span class="side-menu__label">Categories Settings</span></a>
                                          </li>

                                          
                                              <li class="slide">
                                                <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="side-menu__icon fe fe-user"></i><span class="side-menu__label">Manage Content</span><span class="badge bg-pink side-badge">></span><i class="angle fe fe-chevron-right hor-angle"></i></a>
                                                <ul class="slide-menu">
                                                  <li class="side-menu-label1"><a href="{{ route('dashboard', '0')}}">Users</a></li>

                                                  <li><a href="{{ route('posts')}}" class="slide-item"> Posts</a></li>

                                                  <li><a href="{{ route('packages')}}" class="slide-item"> Pricing Plan</a></li>

                                                  <li><a href="{{ route('products')}}" class="slide-item"> Products</a></li>

                                                  <li><a href="{{ route('keywords')}}" class="slide-item"> Internal Link Manager</a></li>
                                                  


                                                  


                                                </ul>
                                              </li>

                                              @endif
                                              <li class="slide">

                                                <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ url('logout') }}">
                                                  <i class="side-menu__icon fe fe-alert-circle"></i>
                                                  <span class="side-menu__label">Sign Out</span></a>
                                                  
                                                </li>

                                                <hr style="background-color: grey;">
                                                <a class="nav-link icon theme-layout nav-link-bg layout-setting">
                                                  <span class="dark-layout"> Dark Mode <i class="fe fe-moon"></i></span>
                                                  <span class="light-layout"> Light Mode <i class="fe fe-sun"></i></span>
                                                </a>





                                              </ul>
                                              <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" /></svg>
                                              </div>
                                            </div>
                                          </div>
                                          <!--/APP-SIDEBAR-->
                                        </div>



                                        @yield('content')

                                      </div>


                                      @include('includes.notifications')




                                      <!-- Country-selector modal-->
                                      <div class="modal fade" id="country-selector">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                          <div class="modal-content country-select-modal">
                                            <div class="modal-header">
                                              <h6 class="modal-title">Choose Country</h6><button aria-label="Close" class="btn-close"
                                              data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">
                                              <ul class="row p-3">
                                                <li class="col-lg-6 mb-2">
                                                  <a href="javascript:void(0)" class="btn btn-country btn-lg btn-block active">
                                                    <span class="country-selector"><img alt="" src="assets/images/flags/us_flag.jpg"
                                                      class="me-3 language"></span>USA
                                                    </a>
                                                  </li>
                                                  <li class="col-lg-6 mb-2">
                                                    <a href="javascript:void(0)" class="btn btn-country btn-lg btn-block">
                                                      <span class="country-selector"><img alt=""
                                                        src="assets/images/flags/italy_flag.jpg"
                                                        class="me-3 language"></span>Italy
                                                      </a>
                                                    </li>
                                                    <li class="col-lg-6 mb-2">
                                                      <a href="javascript:void(0)" class="btn btn-country btn-lg btn-block">
                                                        <span class="country-selector"><img alt=""
                                                          src="assets/images/flags/spain_flag.jpg"
                                                          class="me-3 language"></span>Spain
                                                        </a>
                                                      </li>
                                                      <li class="col-lg-6 mb-2">
                                                        <a href="javascript:void(0)" class="btn btn-country btn-lg btn-block">
                                                          <span class="country-selector"><img alt=""
                                                            src="assets/images/flags/india_flag.jpg"
                                                            class="me-3 language"></span>India
                                                          </a>
                                                        </li>
                                                        <li class="col-lg-6 mb-2">
                                                          <a href="javascript:void(0)" class="btn btn-country btn-lg btn-block">
                                                            <span class="country-selector"><img alt=""
                                                              src="assets/images/flags/french_flag.jpg"
                                                              class="me-3 language"></span>French
                                                            </a>
                                                          </li>
                                                          <li class="col-lg-6 mb-2">
                                                            <a href="javascript:void(0)" class="btn btn-country btn-lg btn-block">
                                                              <span class="country-selector"><img alt=""
                                                                src="assets/images/flags/russia_flag.jpg"
                                                                class="me-3 language"></span>Russia
                                                              </a>
                                                            </li>
                                                            <li class="col-lg-6 mb-2">
                                                              <a href="javascript:void(0)" class="btn btn-country btn-lg btn-block">
                                                                <span class="country-selector"><img alt=""
                                                                  src="assets/images/flags/germany_flag.jpg"
                                                                  class="me-3 language"></span>Germany
                                                                </a>
                                                              </li>
                                                              <li class="col-lg-6 mb-2">
                                                                <a href="javascript:void(0)" class="btn btn-country btn-lg btn-block">
                                                                  <span class="country-selector"><img alt=""
                                                                    src="assets/images/flags/argentina.jpg"
                                                                    class="me-3 language"></span>Argentina
                                                                  </a>
                                                                </li>
                                                                <li class="col-lg-6 mb-2">
                                                                  <a href="javascript:void(0)" class="btn btn-country btn-lg btn-block">
                                                                    <span class="country-selector"><img alt="" src="assets/images/flags/malaysia.jpg"
                                                                      class="me-3 language"></span>Malaysia
                                                                    </a>
                                                                  </li>
                                                                  <li class="col-lg-6 mb-2">
                                                                    <a href="javascript:void(0)" class="btn btn-country btn-lg btn-block">
                                                                      <span class="country-selector"><img alt="" src="assets/images/flags/turkey.jpg"
                                                                        class="me-3 language"></span>Turkey
                                                                      </a>
                                                                    </li>
                                                                  </ul>
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                          <!-- Country-selector modal-->



                                                          <!-- FOOTER -->
                                                          <footer class="footer">
                                                            <div class="container">

                                                              <div class="row align-items-center flex-row-reverse">
                                                                <div class="col-md-12 col-sm-12 text-center">
                                                                  Copyright © <span id="year"></span> <a href="javascript:void(0)">{{ domain_name() }}</a>. All rights reserved.
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </footer>
                                                          <!-- FOOTER END -->

                                                        </div>

                                                        <!-- BACK-TO-TOP -->
                                                        <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

                                                        <!-- JQUERY JS -->
                                                        <script src="{{ asset('assets/js/jquery.min.js')}}"></script>

                                                        <!-- BOOTSTRAP JS -->
                                                        <script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js')}}"></script>
                                                        <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

                                                        <!-- SPARKLINE JS-->
                                                        <script src="{{ asset('assets/js/jquery.sparkline.min.js')}}"></script>

                                                        <!-- Sticky js -->
                                                        <script src="{{ asset('assets/js/sticky.js')}}"></script>

                                                        <!-- CHART-CIRCLE JS-->
                                                        <script src="{{ asset('assets/js/circle-progress.min.js')}}"></script>

                                                        <!-- PIETY CHART JS-->
                                                        <script src="{{ asset('assets/plugins/peitychart/jquery.peity.min.js')}}"></script>
                                                        <script src="{{ asset('assets/plugins/peitychart/peitychart.init.js')}}"></script>

                                                        <!-- SIDEBAR JS -->
                                                        <script src="{{ asset('assets/plugins/sidebar/sidebar.js')}}"></script>

                                                        <!-- Perfect SCROLLBAR JS-->
                                                        <script src="{{ asset('assets/plugins/p-scroll/perfect-scrollbar.js')}}"></script>
                                                        <script src="{{ asset('assets/plugins/p-scroll/pscroll.js')}}"></script>
                                                        <script src="{{ asset('assets/plugins/p-scroll/pscroll-1.js')}}"></script>

                                                        <!-- INTERNAL CHARTJS CHART JS-->
                                                        <script src="{{ asset('assets/plugins/chart/Chart.bundle.js')}}"></script>
                                                        <script src="{{ asset('assets/plugins/chart/rounded-barchart.js')}}"></script>
                                                        <script src="{{ asset('assets/plugins/chart/utils.js')}}"></script>

                                                        <!-- INTERNAL SELECT2 JS -->
                                                        <script src="{{ asset('assets/plugins/select2/select2.full.min.js')}}"></script>

                                                        <!-- INTERNAL Data tables js-->
                                                        <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
                                                        <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
                                                        <script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>

                                                        <!-- INTERNAL APEXCHART JS -->
                                                        <script src="{{ asset('assets/js/apexcharts.js')}}"></script>
                                                        <script src="{{ asset('assets/plugins/apexchart/irregular-data-series.js')}}"></script>

                                                        <!-- INTERNAL Flot JS -->
                                                        <script src="{{ asset('assets/plugins/flot/jquery.flot.js')}}"></script>
                                                        <script src="{{ asset('assets/plugins/flot/jquery.flot.fillbetween.js')}}"></script>
                                                        <script src="{{ asset('assets/plugins/flot/chart.flot.sampledata.js')}}"></script>
                                                        <script src="{{ asset('assets/plugins/flot/dashboard.sampledata.js')}}"></script>

                                                        <!-- INTERNAL Vector js -->
                                                        <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
                                                        <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>

                                                        <!-- SIDE-MENU JS-->
                                                        <script src="{{ asset('assets/plugins/sidemenu/sidemenu.js')}}"></script>

                                                        <!-- TypeHead js -->
                                                        <script src="{{ asset('assets/plugins/bootstrap5-typehead/autocomplete.js')}}"></script>
                                                        <script src="{{ asset('assets/js/typehead.js')}}"></script>

                                                        <!-- INTERNAL INDEX JS -->
                                                        <script src="{{ asset('assets/js/index1.js')}}"></script>

                                                        <!-- Color Theme js -->
                                                        <script src="{{ asset('assets/js/themeColors.js')}}"></script>

                                                        <!-- CUSTOM JS -->
                                                        <script src="{{ asset('assets/js/custom.js')}}"></script>

                                                        <script src="{{ asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>

                                                        <!-- INTERNAL Notifications js -->
                                                       <!--    <script src="{{ asset('assets/plugins/notify/js/rainbow.js')}}"></script>
                                                          <script src="{{ asset('assets/plugins/notify/js/sample.js')}}"></script>
                                                          <script src="{{ asset('assets/plugins/notify/js/jquery.growl.js')}}"></script>
                                                          <script src="{{ asset('assets/plugins/notify/js/notifIt.js')}}"></script> -->


                                                          <!-- CHARTJS JS -->
                                                          <script src="{{ asset('assets/plugins/chart/Chart.bundle.js') }}"></script>
                                                          <script src="{{ asset('assets/js/chart.js') }}"></script>


                                                          <script src="{{ asset('assets/switcher/js/switcher.js') }}"></script>

                                          
                                                         <script type="text/javascript">

                                                            var count_cases = -1;
                                                            setInterval(function(){    



                                                              $.ajax({
                                                                type : "GET",
                                                                url : "{{ url('getchat') }}",
                                                                success : function(response){
                                                                  if (count_cases == -1 && response.messages_count > 0)

                                                                    var audio = new Audio("{{ asset('assets/sound/mix1.wav')}}");
                                                                  audio.play();
                                                                  count_cases = response.messages_count;
                                                                }
                                                              });
                                                            },60000);

                                                          </script>  
                                                          
                                                          @yield('page-js')
                                                          @livewireScripts






                                                        </body>

                                                        </html>