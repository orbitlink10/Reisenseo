@extends('layouts.frontbar')
@section('title')@if( ! empty($title)){{$title}} |@endif @parent @endsection






@section('content')

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

          

                <div class="container-login100">
                    <div class="wrap-login100 p-6">
                        <form class="login100-form validate-form" id='demo-form' method="POST" action="{{ route('bregister') }}">
                             @csrf
                            <span class="login100-form-title pb-5">
                            Fill below info and proceed to buy our product 
                            </span>
                            <div class="panel panel-primary">
                            
                                <div class="panel-body tabs-menu-body p-0 pt-5">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab5">



                                        @include('flash_msg')

                  

<input type="hidden" name="package" value="{{ $package }}">
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
        <i class="zmdi zmdi-globe" aria-hidden="true"></i>
    </a>
  <input list="browsers" placeholder="Search and Choose Country" name="country" class="form-control" required="">
  <datalist id="browsers">
   <?php
    $orders = \App\Models\Country::orderBy('cntry_phonecode', 'asc')->get();
    ?>
    @foreach($orders as $order)
    <option value="{{ $order->cntry_nicename }}">(+{{ $order->cntry_phonecode }}) {{ $order->cntry_nicename }}</option>
    @endforeach
  </datalist>





  
</div>

<!-- <div class="wrap-input100 validate-input input-group" id="Password-toggle">
    <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
        <i class="zmdi zmdi-eye" aria-hidden="true"></i>
    </a>
    <input class="input100 border-start-0 ms-0 form-control" name="password_confirmation" type="password" value="{{ old('password_confirmation') }}" placeholder="Password Confirmation" required autocomplete="new-password">
</div> -->







<div class="container-login100-form-btn">
    <button href="index.html" class="g-recaptcha login100-form-btn btn-primary" data-sitekey=" {{ get_option(site_id().'_sitekey') }}" data-callback='onSubmit'>
        Proceed
    </button>
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




@endsection

@section('page-js')

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

@endsection