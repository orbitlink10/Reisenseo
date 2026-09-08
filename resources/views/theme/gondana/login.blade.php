@extends('layouts.frontbar')
@section('title')@if( ! empty($title)){{$title}} |@endif @parent @endsection
@section('content')

        <div class="page">
            <div class="">
 <div class="container-login100">
                    <div class="wrap-login100 p-6">
                        <form class="login100-form validate-form" method="POST" action="{{ route('login_post') }}">

                             @csrf

                             <h1> <span class="login100-form-title pb-5">
                                Delegate Your Tasks to Professionals 
                            </span></h1>
                           
                            <div class="panel panel-primary">
                                <div class="tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs">
                                            <li class="mx-0"><a href="#tab5" class="active" data-bs-toggle="tab">Sign In</a></li>
                                            <li class="mx-0"><a href="{{ route('cregister')}}" >Sign Up</a></li>
                                        </ul>
                                    </div>
                                </div>

                                               @include('flash_msg')

                                <div class="panel-body tabs-menu-body p-0 pt-5">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab5">
                                            <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid email is required: ex@abc.xyz">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
      
                                                    <i class="zmdi zmdi-email text-muted" aria-hidden="true"></i>
                                                </a>
<input id="email" type="email" class="input100 border-start-0 form-control ms-0 @error('email') is-invalid @enderror" name="email" placeholder="Email" required autocomplete="email" autofocus>
                                                 @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                            </div>
                                            <div class="wrap-input100 validate-input input-group" id="Password-toggle">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                    <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                                </a>
 <input id='password' name="password" class="form-control @error('password') is-invalid @enderror" type="password" placeholder="Password">

                                                   @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                            </div>
                                            <div class="text-end pt-4">
                                                <p class="mb-0"><a href="{{ route('password.request') }}" class="text-primary ms-1">Forgot Password?</a></p>
                                            </div>
                                            <div class="container-login100-form-btn">
                                               

                                                <button type="submit" class="login100-form-btn btn-primary">
                                   SIGN IN
                    </button>
                                            </div>
                                            <div class="text-center pt-3">
                                                <p class="text-dark mb-0">Not a member?<a href="{{ route('register')}}" class="text-primary ms-1">Sign Up</a></p>
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


@endsection

@section('page-js')

    <!-- JQUERY JS -->
    <script src="assets/js/jquery.min.js"></script>

    <!-- BOOTSTRAP JS -->
    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- SHOW PASSWORD JS -->
    <script src="{{ asset('assets/js/show-password.min.js')"></script>

    <!-- GENERATE OTP JS -->
    <script src="assets/js/generate-otp.js"></script>

    <!-- Perfect SCROLLBAR JS-->
    <script src="assets/plugins/p-scroll/perfect-scrollbar.js"></script>

    <!-- Color Theme js -->
    <script src="assets/js/themeColors.js"></script>

    <!-- CUSTOM JS -->
    <script src="assets/js/custom.js"></script>

@endsection