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
                        <form class="login100-form validate-form" id='demo-form' method="POST" action="{{ route('cregister') }}">
                         @csrf

                         <h1><span class="login100-form-title pb-5">
                           @lang('app.registration')
                       </span></h1>
                       

                       <input type="hidden" name="referer" value="{{ referer() }}">
                       <div class="panel panel-primary">
                        <div class="tab-menu-heading">
                            <div class="tabs-menu1">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs">
                                    <li class="mx-0"><a href="#tab5" class="active" data-bs-toggle="tab">Sign Up</a></li>
                                    <li class="mx-0"><a href="{{ route('clogin')}}" >Sign In</a></li>
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


              <!--       <div class="wrap-login100 p-6">
                         <img src="{{ asset('assets/images/saseni-connect.jpeg')}}" width="485px;">
                
</div> -->
</div>
<!-- CONTAINER CLOSED -->
</div>
</div>
<!-- End PAGE -->

</div>
<!-- BACKGROUND-IMAGE CLOSED -->





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