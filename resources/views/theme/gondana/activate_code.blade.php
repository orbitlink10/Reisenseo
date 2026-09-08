@extends('layouts.frontbar')
@section('title')@if( ! empty($title)){{$title}} |@endif @parent @endsection
@section('content')

        <div class="page">
            <div class="">
 <div class="container-login100">
                    <div class="wrap-login100 p-6">
                        <form class="login100-form validate-form" method="POST" action="{{ route('activate_code') }}">
                             @csrf

                             <h1> <span class="login100-form-title pb-5">
                              Activate Account
                            </span></h1>
                            <p>Account verification code has been email to you</p>
                           
                            <div class="panel panel-primary">
                             
                                <div class="panel-body tabs-menu-body p-0 pt-5">
                                    <div class="tab-content">

                                        @include('flash_msg')
                                        <div class="tab-pane active" id="tab5">
                                            <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid email is required: ex@abc.xyz">
                                            
<input id="text" type="text" class="input100 border-start-0 form-control ms-0 @error('email') is-invalid @enderror" name="code" placeholder="Enter Activation Code" required autocomplete="email" autofocus>
                                                
                                            </div>


                                            <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid email is required: ex@abc.xyz">
                                              
<input id="password" type="password" class="input100 border-start-0 form-control ms-0 @error('email') is-invalid @enderror" name="pin" placeholder="Enter pin" required autocomplete="email" required="" autofocus>
                                                
                                            </div>
                                    
                                    
                                      
                                            <div class="container-login100-form-btn">
                                               

                                                <button type="submit" class="login100-form-btn btn-primary">
                               Continue
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