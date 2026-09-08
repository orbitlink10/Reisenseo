@extends('layouts.frontbar')
@section('title')@if( ! empty($title)){{$title}} |@endif @parent @endsection
@section('description')Join us at {{ domain_name() }} and let's channel your remarkable gift for writing into a meaningful and fulfilling endeavor. Together, we can empower international students, foster academic excellence, and create a brighter future for all @endsection





@section('content')


    <div style="margin-top: 150px;" class="container px-sm-0">
        <div class="row">
            <div class="col-xl-6 col-lg-6 mb-5 pb-5 animation-zidex pos-relative">
              <!--[shortcode_hello]-->

                <h1 class="text-start fw-bold">Become {{ domain_name() }} Writer</h1>
              
              
                      At Saseni, we recognize and appreciate the immense value of your talent. We understand that essay writing can often pose a significant challenge for international students, given the cultural barriers they face. That's why we are dedicated to providing a platform where your skills as a professional essay writer can make a real difference.<br><br>

By joining us as an essay writer, you will play a vital role in helping these students achieve academic success and surpass their important goals. Your expertise and guidance will enable them to excel in their studies and overcome the obstacles that stand in their way.<br><br>

Not only will you be making a positive impact on the lives of these students, but you will also be rewarded financially for your efforts. At Saseni, we believe in recognizing and compensating talent accordingly. As you help students succeed, you'll earn good money that reflects the value of your powerful gift.<br><br>

We understand that essay writing requires a unique blend of skills, including research, critical thinking, and effective communication. That's why we strive to create a supportive and collaborative environment where you can thrive as an essay writer. You'll have the opportunity to work on diverse topics, expand your knowledge, and enhance your writing abilities.<br><br>

Join us at Saseni and let's channel your remarkable gift for writing into a meaningful and fulfilling endeavor. Together, we can empower international students, foster academic excellence, and create a brighter future for all
          


   </div>
   <div class="col-xl-6 col-lg-6 my-auto">
       <div class="wrap-login100 p-6">
                        <form class="login100-form validate-form" id='demo-form' method="POST" action="{{ route('wregister') }}">
                           @csrf

                           <h1><span class="login100-form-title pb-5">
                     Create an account and get paid to write
                         </span></h1>
                         

                         <input type="hidden" name="referer" value="{{ referer() }}">
                         <div class="panel panel-primary">
                          
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


</div>
</div>
</div>

</form>
</div>
</div>
</div>
</div>
              








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