<!doctype html>
<html lang="en" dir="ltr">

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content=" Create an account {{ get_option(site_id().'_site_name') }}">
    <meta name="author" content="Gondana">
    <meta name="keywords" content="{{ get_option(site_id().'_site_name') }}">

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/brand/favicon.ico" />

    <!-- TITLE -->
    <title>Create {{ domain_name() }} Account</title>

    <!-- BOOTSTRAP CSS -->
    <link id="style" href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/dark-style.css" rel="stylesheet" />
    <link href="assets/css/transparent-style.css" rel="stylesheet">
    <link href="assets/css/skin-modes.css" rel="stylesheet" />

    <!--- FONT-ICONS CSS -->
    <link href="assets/css/icons.css" rel="stylesheet" />

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="assets/colors/color1.css" />

    <!------ Include the above in your HEAD tag ---------->
     <script src="https://www.google.com/recaptcha/api.js" async defer></script>
     <script>
       function onSubmit(token) {
         document.getElementById("demo-form").submit();
       }
     </script>

</head>

<body class="app sidebar-mini ltr login-img">

    <!-- BACKGROUND-IMAGE -->
    <div class="">

        <!-- GLOABAL LOADER -->
    <!--     <div id="global-loader">
            <img src="assets/images/loader.svg" class="loader-img" alt="Loader">
        </div> -->
        <!-- /GLOABAL LOADER -->

        <!-- PAGE -->
        <div class="page">
            <div class="">

                <!-- CONTAINER OPEN -->
             <div class="col col-login mx-auto mt-7">
                    <div class="text-center">
                        <a href="/">
                        <!--     <img src="assets/images/brand/logo-white.png" class="header-brand-img" alt=""> -->
                          <h1 style="color: #ffffff;"><strong>{{ domain_name() }}</strong></h1>
                        </a>
                    </div>
                </div>

                <div class="container-login100">
                    <div class="wrap-login100 p-6">
                        <form class="login100-form validate-form" id='demo-form' method="POST" action="{{ route('cregister') }}">
                             @csrf
                            <span class="login100-form-title pb-5">
                                   @lang('app.registration')
                            </span>
                            <div class="panel panel-primary">
                                <div class="tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs">
                                            <li class="mx-0"><a href="#tab5" class="active" data-bs-toggle="tab">Sign Up</a></li>
                                            <li class="mx-0"><a href="{{ route('login')}}" >Sign In</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body p-0 pt-5">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab5">



                                        @include('flash_msg')

                  


   <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid name is required: name">
    <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
        <i class="mdi mdi-account" aria-hidden="true"></i>
    </a>
    <input class="input100 border-start-0 ms-0 form-control @error('name') is-invalid @enderror" name="name" type="text" placeholder="Name" value="{{ old('name') }}" required autocomplete="name" autofocus>

    @error('name')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>


<div class="wrap-input100 validate-input input-group" data-bs-validate="Valid phone is required: 0725000000">
    <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
        <i class="mdi mdi-phone" aria-hidden="true"></i>
    </a>
    <input  class="input100 border-start-0 ms-0 form-control @error('phone') is-invalid @enderror" name="phone" type="text" placeholder="Phone" value="{{ old('phone') }}">

    @error('phone')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
<div class="wrap-input100 validate-input input-group" data-bs-validate="Valid email is required: ex@abc.xyz">
    <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
        <i class="zmdi zmdi-email" aria-hidden="true"></i>
    </a>
    <input class="input100 border-start-0 ms-0 form-control @error('email') is-invalid @enderror" name="email" type="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email">
    @error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
<div class="wrap-input100 validate-input input-group" id="Password-toggle">
    <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
        <i class="zmdi zmdi-eye" aria-hidden="true"></i>
    </a>
    <input class="input100 border-start-0 ms-0 form-control @error('password') is-invalid @enderror" name="password" type="password" value="{{ old('password') }}" placeholder="Password" required autocomplete="new-password">

    @error('password')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>





<!-- <div class="wrap-input100 validate-input input-group" id="Password-toggle">
    <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
        <i class="zmdi zmdi-eye" aria-hidden="true"></i>
    </a>
    <input class="input100 border-start-0 ms-0 form-control" name="password_confirmation" type="password" value="{{ old('password_confirmation') }}" placeholder="Password Confirmation" required autocomplete="new-password">
</div> -->






<label class="custom-control custom-checkbox mt-4">
    <input type="checkbox" class="custom-control-input" checked="">
    <span class="custom-control-label">Agree the <a href="/terms-and-conditions/">terms and policy</a></span>
</label>
<div class="container-login100-form-btn">
    <button href="index.html" class="g-recaptcha login100-form-btn btn-primary" data-sitekey=" {{ get_option(site_id().'_sitekey') }}" data-callback='onSubmit'>
        Register
    </button>
</div>
<div class="text-center pt-3">
    <p class="text-dark mb-0">Already have account?<a href="{{ route('login')}}" class="text-primary ms-1">Sign In</a></p>
</div>


                                      
                                        </div>

                                        <div class="tab-pane" id="tab6">
                                            <div id="mobile-num" class="wrap-input100 validate-input input-group mb-4">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                    <span>+254</span>
                                                </a>
                                                <input class="input100 border-start-0 form-control ms-0">
                                            </div>
                                            <div id="login-otp" class="justify-content-around mb-5">
                                                <input class="form-control text-center w-15" id="txt1" maxlength="1">
                                                <input class="form-control text-center w-15" id="txt2" maxlength="1">
                                                <input class="form-control text-center w-15" id="txt3" maxlength="1">
                                                <input class="form-control text-center w-15" id="txt4" maxlength="1">
                                            </div>
                                            <span>Note : Login with registered mobile number to generate OTP.</span>
                                            <div class="container-login100-form-btn ">
                                               

                                                  <button type="submit" class="login100-form-btn btn-primary">
                                   SIGN IN
                    </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- CONTAINER CLOSED -->
            </div>
        </div>
        <!-- End PAGE -->

    </div>
    <!-- BACKGROUND-IMAGE CLOSED -->

    
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

    <!-- JQUERY JS -->
    <script src="assets/js/jquery.min.js"></script>

    <!-- BOOTSTRAP JS -->
    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- SHOW PASSWORD JS -->
    <script src="assets/js/show-password.min.js"></script>

    <!-- GENERATE OTP JS -->
    <script src="assets/js/generate-otp.js"></script>

    <!-- Perfect SCROLLBAR JS-->
    <script src="assets/plugins/p-scroll/perfect-scrollbar.js"></script>

    <!-- Color Theme js -->
    <script src="assets/js/themeColors.js"></script>

    <!-- CUSTOM JS -->
    <script src="assets/js/custom.js"></script>


</body>

</html>