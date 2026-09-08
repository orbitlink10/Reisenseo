@extends('layouts.frontbar')
<script src="{{ asset('js/app.js') }}" defer></script>
@section('content') 
<div class="demo-screen-headline main-demo main-demo-1 spacing-top overflow-hidden reveal bg-landing pb-0 bg-image-style" id="home">

    <div class="container px-sm-0">
        <div class="row">
            <div class="col-xl-7 col-lg-7 mb-5 pb-5 animation-zidex pos-relative">
                <h4 class="fw-semibold mt-7">{{ get_option('tagline') }}</h4>
                <h1 class="text-start fw-bold">{{ get_option('hero_header') }}</h1>
                <h6 class="pb-3">
                   {{ get_option('hero_description') }}

                   <div id="hello-react"></div>
               </h6>

               <a href="{{ route('register')}}"
               class="btn ripple btn-min w-lg mb-3 me-2 btn-primary"><i
               class="fe fe-play me-2"></i> Sign Up
           </a>
           <a href="{{ route('login')}}"
           class="btn ripple btn-min w-lg btn-outline-primary mb-3 me-2" target="_blank"><i
           class="fa fa-sign-in me-2"></i>Log In
       </a>
   </div>
   <div class="col-xl-5 col-lg-5 my-auto">
    <img src="assets/images/landing/market4.png" alt="">
</div>
</div>
</div>
</div>
</div>

<!--app-content open-->
<div class="main-content mt-0">
    <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container">
            <div class="">

                <!-- ROW-1 OPEN -->
                <div class="section pb-0" id="how">
                    <div class="container">
                        <div class="row">

                            <span class="landing-title"></span>
                            <h2 class="fw-semibold text-center">{{ get_option('how_header') }}</h2>

                            <p class="text-default mb-5 text-center">{{ get_option('how_description') }}</p>
                        </div>
                        <div class="row text-center services-statistics landing-statistics">
                            <div class="col-xl-3 col-md-6 col-lg-6">
                                <div class="card">
                                    <div class="card-body bg-primary-transparent">
                                        <div class="counter-status">
                                            <div
                                            class="counter-icon bg-primary-transparent box-shadow-primary">
                                            <i class="fe fe-layers text-primary fs-23"></i>
                                        </div>
                                        <div class="test-body text-center">

                                         <h4 class="fw-bold">Post order</h4>
                                         <div class="counter-text">
                                            <h5 class="font-weight-normal mb-0 ">{{ get_option('post_order') }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-body bg-secondary-transparent">
                                <div class="counter-status">
                                    <div
                                    class="counter-icon bg-secondary-transparent box-shadow-secondary">
                                    <i class="fe fe-wind text-secondary fs-23"></i>
                                </div>
                                <div class="text-body text-center">
                                    <h4 class="fw-bold">Top up your wallet</h4>
                                    <div class="counter-text">
                                        <h5 class="font-weight-normal mb-0 ">{{ get_option('top_wallet') }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body bg-success-transparent">
                            <div class="counter-status">
                                <div
                                class="counter-icon bg-success-transparent box-shadow-success">
                                <i class="fe fe-user text-success fs-23"></i>
                            </div>
                            <div class="text-body text-center">
                               <h4 class="fw-bold">Writer Assigned</h4>
                               <div class="counter-text">
                                <h5 class="font-weight-normal mb-0 ">{{ get_option('writer_assigned') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-lg-6">
            <div class="card">
                <div class="card-body bg-danger-transparent">
                    <div class="counter-status">
                        <div
                        class="counter-icon bg-danger-transparent box-shadow-danger">
                        <i class="fe fe-grid text-danger fs-23"></i>
                    </div>
                    <div class="text-body text-center">
                      <h4 class="fw-bold">Get the completed paper
                      </h4>
                      <div class="counter-text">
                        <h5 class="font-weight-normal mb-0 ">{{ get_option('get_paper') }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<!-- ROW-1 CLOSED -->

<!-- ROW-2 OPEN -->
<div class="sptb section bg-white" id="Features">
    <div class="container">
        <div class="row">

            <span class="landing-title"></span>
            <h2 class="fw-semibold text-center">{{ get_option('feature_header') }}
            </h2>
            <p class="text-default mb-5 text-center">{{ get_option('feature_subheading') }}</p>
            <div class="row mt-7">
                <div class="col-lg-6 col-md-12">
                    <div class="card features main-features main-features-1 wow fadeInUp reveal revealleft"
                    data-wow-delay="0.1s">
                    <div class="bg-img mb-2 text-left">
                        <svg width="50" height="50" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 128 128">
                        <circle cx="64" cy="64" r="64" fill="#42A3DB" />
                        <path fill="#347CBE"
                        d="M85.5 26.6L66.1 61 33.3 98.6 62.6 128H64c33.7 0 61.3-26 63.8-59.1L85.5 26.6z" />
                        <path fill="#CD2F30"
                        d="M73.1 57.7h-16c3.6 18.7 11.1 36.6 22.1 52.5.3-5 1-9.8 1.8-14.5 4.6 1.3 9.2 2.3 13.7 3-9.7-12.2-17-26.1-21.6-41z" />
                        <path fill="#F04D45"
                        d="M54.9 57.7c-4.6 15-11.9 28.9-21.6 40.9 4.5-.7 9.1-1.7 13.7-3 .9 4.7 1.5 9.5 1.8 14.5 11-15.9 18.4-33.8 22.1-52.5h-16z" />
                        <path fill="#FFF"
                        d="M93.5 52c1.8-1.8 1.8-4.7 0-6.5-1.3-1.3-1.7-3.3-1-5 1-2.4-.1-5-2.5-6-1.7-.7-2.8-2.4-2.8-4.3 0-2.5-2.1-4.6-4.6-4.6-1.9 0-3.5-1.1-4.3-2.8-1-2.4-3.7-3.5-6-2.5-1.7.7-3.7.3-5-1-1.8-1.8-4.7-1.8-6.5 0-1.3 1.3-3.3 1.7-5 1-2.4-1-5 .1-6 2.5-.7 1.7-2.4 2.8-4.3 2.8-2.5 0-4.6 2.1-4.6 4.6 0 1.9-1.1 3.5-2.8 4.3-2.4 1-3.5 3.7-2.5 6 .7 1.7.3 3.7-1 5-1.8 1.8-1.8 4.7 0 6.5 1.3 1.3 1.7 3.3 1 5-1 2.4.1 5 2.5 6 1.7.7 2.8 2.4 2.8 4.3 0 2.5 2.1 4.6 4.6 4.6 1.9 0 3.5 1.1 4.3 2.8 1 2.4 3.7 3.5 6 2.5 1.7-.7 3.7-.3 5 1 1.8 1.8 4.7 1.8 6.5 0 1.3-1.3 3.3-1.7 5-1 2.4 1 5-.1 6-2.5.7-1.7 2.4-2.8 4.3-2.8 2.5 0 4.6-2.1 4.6-4.6 0-1.9 1.1-3.5 2.8-4.3 2.4-1 3.5-3.7 2.5-6-.7-1.7-.3-3.7 1-5z" />
                        <path fill="#FFCD0A"
                        d="M64 70.8c-12.2 0-22.1-9.9-22.1-22.1 0-12.2 9.9-22.1 22.1-22.1 12.2 0 22.1 9.9 22.1 22.1 0 12.2-9.9 22.1-22.1 22.1z" />
                        <path fill="#FFF"
                        d="M59.9 61c-.6 0-1.1-.2-1.5-.7l-8.3-9.2c-.7-.8-.7-2.1.1-2.8.8-.7 2.1-.7 2.8.1l6.7 7.5 15.1-18.8c.7-.9 2-1 2.8-.3.9.7 1 2 .3 2.8L61.4 60.2c-.3.5-.9.8-1.5.8z" />
                    </svg>
                </div>
                <div class="text-left">
                    <h4 class="fw-bold">{{ get_option('feature_header1') }}</h4>
                    <p class="mb-0">{{ get_option('feature_description1') }} </p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card  features main-features main-features-2 wow fadeInUp reveal revealleft"
            data-wow-delay="0.1s">
            <div class="bg-img mb-2 text-left">
                <!-- <img src="../assets/landing/images/features/demo.png" alt=""> -->
                <svg width="50" height="50" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 128 128">
                <circle cx="64" cy="64" r="64" fill="#FFCD0A" />
                <path fill="#F6AF1A"
                d="M127.7 57.7l-26.4-26.4-74.7 58.8L64.5 128c35.1-.3 63.5-28.8 63.5-64 0-2.1-.1-4.2-.3-6.3z" />
                <path fill="#CFD5DF" d="M76.2 102.9H51.8l2-13.6h20.4z" />
                <path fill="#545E70"
                d="M97.1 91.7H30.9c-3.5 0-6.4-2.9-6.4-6.4V36.1c0-3.5 2.9-6.4 6.4-6.4h66.2c3.5 0 6.4 2.9 6.4 6.4v49.3c0 3.5-2.9 6.3-6.4 6.3z" />
                <path fill="#E6E8EB"
                d="M24.5 81.4v4c0 3.5 2.9 6.4 6.4 6.4h66.2c3.5 0 6.4-2.9 6.4-6.4v-4h-79z" />
                <path fill="#49C7EF"
                d="M30.9 74.3c-1 0-1.8-.8-1.8-1.8V36.1c0-1 .8-1.8 1.8-1.8h66.2c1 0 1.8.8 1.8 1.8v36.4c0 1-.8 1.8-1.8 1.8H30.9z" />
                <path fill="#17B6EA" d="M37.8 34.3h52.5v40H37.8z" />
                <path fill="#E6E8EB"
                d="M76.7 105.3H51.3c-1.3 0-2.4-1.1-2.4-2.4 0-1.3 1.1-2.4 2.4-2.4h25.4c1.3 0 2.4 1.1 2.4 2.4-.1 1.3-1.1 2.4-2.4 2.4z" />
                <path fill="#ACB2B9" d="M53.2 91.7l22.7 8.8-1.3-8.8z" />
                <path fill="#FFF"
                d="M75.7 47.8H52.3c-.6 0-1.1-.5-1.1-1.1v-2.9c0-.6.5-1.1 1.1-1.1h23.3c.6 0 1.1.5 1.1 1.1v2.9c0 .6-.4 1.1-1 1.1zM75.7 57.1H52.3c-.6 0-1.1-.5-1.1-1.1v-2.9c0-.6.5-1.1 1.1-1.1h23.3c.6 0 1.1.5 1.1 1.1V56c0 .6-.4 1.1-1 1.1z" />
                <path fill="#FFCD0A"
                d="M62.8 65.9H52.3c-.6 0-1.1-.5-1.1-1.1v-2.9c0-.6.5-1.1 1.1-1.1h10.4c.6 0 1.1.5 1.1 1.1v2.9c0 .6-.4 1.1-1 1.1z" />
                <g fill="#CFD5DF">
                    <circle cx="54.1" cy="45.3" r="1.2" />
                    <circle cx="57.6" cy="45.3" r="1.2" />
                    <circle cx="61" cy="45.3" r="1.2" />
                    <circle cx="64.5" cy="45.3" r="1.2" />
                    <circle cx="67.9" cy="45.3" r="1.2" />
                </g>
                <g fill="#CFD5DF">
                    <circle cx="54.1" cy="54.6" r="1.2" />
                    <circle cx="57.6" cy="54.6" r="1.2" />
                    <circle cx="61" cy="54.6" r="1.2" />
                    <circle cx="64.5" cy="54.6" r="1.2" />
                    <circle cx="67.9" cy="54.6" r="1.2" />
                </g>
                <g fill="#FFF">
                    <path
                    d="M56.9 64.4c-.3.3-.6.4-1 .4s-.8-.1-1-.4c-.3-.3-.4-.6-.4-1s.1-.7.4-1c.3-.3.6-.4 1-.4s.8.1 1 .4c.3.3.4.6.4 1s-.1.7-.4 1zm-.2-1c0-.2-.1-.5-.2-.6-.2-.2-.4-.3-.6-.3s-.4.1-.6.3c-.2.2-.2.4-.2.6 0 .2.1.5.2.6.2.2.4.3.6.3s.4-.1.6-.3c.1-.2.2-.4.2-.6zM58.3 62h.6v1.1l1-1.1h.8l-1.1 1.2c.1.1.3.4.5.7s.4.6.6.8H60l-.8-1.1-.3.4v.8h-.6V62z" />
                </g>
                <circle cx="64" cy="86.6" r="2.8" fill="#545E70" />
                <g fill="#E6E8EB">
                    <path
                    d="M92.6 49.7v9.2c0 1.2 1.6 1.6 2.2.5l2.3-4.6c.2-.3.2-.7 0-1l-2.3-4.6c-.6-1.1-2.2-.7-2.2.5zM36.1 58.9v-9.2c0-1.2-1.6-1.6-2.2-.5l-2.3 4.6c-.2.3-.2.7 0 1l2.3 4.6c.6 1.1 2.2.7 2.2-.5z" />
                </g>
            </svg>
        </div>
        <div class="text-left">
            <h4 class="fw-bold">{{ get_option('feature_header2') }} </h4>
            <p class="mb-0">
             {{ get_option('feature_description2') }}
         </p>
     </div>
 </div>
</div>
<div class="col-lg-6 col-md-12">
    <div class="card features main-features main-features-11 wow fadeInUp reveal revealleft"
    data-wow-delay="0.1s">
    <div class="bg-img mb-2 text-left">
        <svg id="SvgjsSvg1001" width="50" height="50"
        xmlns="http://www.w3.org/2000/svg" version="1.1"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        xmlns:svgjs="http://svgjs.com/svgjs">
        <defs id="SvgjsDefs1002"></defs>
        <g id="SvgjsG1008"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 128 128" width="50" height="50">
            <circle cx="64" cy="64" r="64" fill="#bed530"
            class="colorBED530 svgShape"></circle>
            <path fill="#acc437"
            d="M112.8 53.7l-4.6-3.7L85 27l-.9 6.9H77L70 27l-1.3 3.7-6 5.7-9.4-9.4-.9 3.7-8.9 2.3-6-6-5 8.2-3.9 63.7 28.9 28.8c2.2.2 4.4.3 6.6.3 33.7 0 61.4-26.2 63.8-59.3l-15.1-15z"
            class="colorACC437 svgShape"></path>
            <path fill="#ffffff"
            d="M86.5 101.8H34.2c-3.6 0-6.5-2.9-6.5-6.5v-58c0-3.6 2.9-6.5 6.5-6.5h52.3c3.6 0 6.5 2.9 6.5 6.5v58c0 3.6-2.9 6.5-6.5 6.5z"
            class="colorFFF svgShape"></path>
            <path fill="#e6e8eb"
            d="M75.6 78l-9.5 12.3 11.5 11.5h8.8c3.6 0 6.5-2.9 6.5-6.5V67.7L75.6 78z"
            class="colorE6E8EB svgShape"></path>
            <path fill="#e2247e" d="M88.5 58.8h8v31.9h-8z"
            transform="rotate(-135.032 92.483 74.797)"
            class="colorE2247E svgShape"></path>
            <path fill="#ee3e88" d="M82.9 53.2h8v31.9h-8z"
            transform="rotate(-135.032 86.846 69.166)"
            class="colorEE3E88 svgShape"></path>
            <path fill="#f06197" d="M77.2 47.6h8v31.9h-8z"
            transform="rotate(-135.032 81.209 63.535)"
            class="colorF06197 svgShape"></path>
            <path fill="#cfd5df" d="M87 56h23.9v2.2H87z"
            transform="rotate(-135.032 98.922 57.076)"
            class="colorCFD5DF svgShape"></path>
            <path fill="#545e70"
            d="M102.2 43.2l10.5 10.5c1.8 1.8 1.8 4.6 0 6.4l-4.6 4.6-16.8-16.9 4.6-4.6c1.7-1.7 4.6-1.7 6.3 0z"
            class="color545E70 svgShape"></path>
            <path fill="#fcd65e"
            d="M67.1 72l-1.7 16.7c-.1 1.1.8 2 1.9 1.9L84 88.9 67.1 72z"
            class="colorFCD65E svgShape"></path>
            <path fill="#f6af1a"
            d="M65.4 88.7c-.1.6.2 1.1.5 1.5l9.6-9.6-8.4-8.6-1.7 16.7z"
            class="colorF6AF1A svgShape"></path>
            <path fill="#ffcd0a"
            d="M66.1 90.3l12.2-7-5.6-5.6-7 12.2c.2.1.3.3.4.4z"
            class="colorFFCD0A svgShape"></path>
            <path fill="#7d6c7c"
            d="M65.9 83.9l-.5 4.8c-.1 1.1.8 2 1.9 1.9l4.8-.5-6.2-6.2z"
            class="color7D6C7C svgShape"></path>
            <path fill="#5b4b57"
            d="M65.9 83.9l-.5 4.8c-.1.6.2 1.1.5 1.5l3.1-3.1-3.1-3.2z"
            class="color5B4B57 svgShape"></path>
            <path fill="#6b5969"
            d="M68 86l-2.2 3.9c.1.2.2.3.4.4l3.9-2.3-2.1-2z"
            class="color6B5969 svgShape"></path>
            <circle cx="84.1" cy="39.6" r="4.1" fill="#bed530"
            class="colorBED530 svgShape"></circle>
            <circle cx="68.2" cy="39.6" r="4.1" fill="#bed530"
            class="colorBED530 svgShape"></circle>
            <circle cx="52.4" cy="39.6" r="4.1" fill="#bed530"
            class="colorBED530 svgShape"></circle>
            <circle cx="36.5" cy="39.6" r="4.1" fill="#bed530"
            class="colorBED530 svgShape"></circle>
            <path fill="#545e70"
            d="M84.1 40.5c-1.1 0-1.9-.9-1.9-1.9v-10c0-1.1.9-1.9 1.9-1.9 1.1 0 1.9.9 1.9 1.9v10c.1 1.1-.8 1.9-1.9 1.9zM68.3 40.5c-1.1 0-1.9-.9-1.9-1.9v-10c0-1.1.9-1.9 1.9-1.9 1.1 0 1.9.9 1.9 1.9v10c0 1.1-.9 1.9-1.9 1.9zM52.4 40.6c-1.1 0-1.9-.9-1.9-1.9v-10c0-1.1.9-1.9 1.9-1.9 1.1 0 1.9.9 1.9 1.9v10c0 1-.9 1.9-1.9 1.9zM36.5 40.6c-1.1 0-1.9-.9-1.9-1.9v-10c0-1.1.9-1.9 1.9-1.9 1.1 0 1.9.9 1.9 1.9v10c0 1-.8 1.9-1.9 1.9z"
            class="color545E70 svgShape"></path>
        </svg></g>
    </svg>
</div>
<div class="text-left">
    <h4 class="fw-bold">{{ get_option('feature_header3') }}</h4>
    <p class="mb-0">
     {{ get_option('feature_description3') }}
 </p>
</div>
</div>
</div>
<div class="col-lg-6 col-md-12">
    <div class="card features main-features main-features-10 wow fadeInUp reveal revealleft"
    data-wow-delay="0.1s">
    <div class="bg-img mb-2 text-left">
        <svg width="50" height="50" xmlns="http://www.w3.org/2000/svg"
        version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
        xmlns:svgjs="http://svgjs.com/svgjs">
        <defs id="SvgjsDefs1055"></defs>
        <g id="SvgjsG1056"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 128 128" width="50" height="50">
            <circle cx="64" cy="64" r="64" fill="#58e1ef"
            class="colorD9B9A9 svgShape"></circle>
            <path fill="#47d4e4"
            d="M71.4 127.6c29.4-3.4 52.7-26.7 56.1-56.1L74.8 18.6 51.9 31.2 31.2 47.4 18.6 74.8l52.8 52.8z"
            class="colorD6AB9A svgShape"></path>
            <path fill="#6b5969"
            d="M64 101.5c-20.7 0-37.5-16.8-37.5-37.5S43.3 26.5 64 26.5s37.5 16.8 37.5 37.5-16.8 37.5-37.5 37.5zm0-70.3c-18.1 0-32.8 14.7-32.8 32.8S45.9 96.8 64 96.8 96.8 82.1 96.8 64 82.1 31.2 64 31.2z"
            class="color6B5969 svgShape"></path>
            <circle cx="64" cy="28.8" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#8663a7"
            d="M64 39.1c-5.6 0-10.2-4.6-10.2-10.2S58.4 18.7 64 18.7s10.2 4.6 10.2 10.2S69.6 39.1 64 39.1z"
            class="color8663A7 svgShape"></path>
            <circle cx="64" cy="99.2" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#3d9c46"
            d="M64 109.4c-5.6 0-10.2-4.6-10.2-10.2S58.4 89 64 89s10.2 4.6 10.2 10.2-4.6 10.2-10.2 10.2z"
            class="color3D9C46 svgShape"></path>
            <circle cx="99.2" cy="64" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#ee3e88"
            d="M99.2 74.2C93.6 74.2 89 69.6 89 64s4.6-10.2 10.2-10.2 10.2 4.6 10.2 10.2-4.6 10.2-10.2 10.2z"
            class="colorEE3E88 svgShape"></path>
            <circle cx="28.8" cy="64" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#ffcd0a"
            d="M28.8 74.2c-5.6 0-10.2-4.6-10.2-10.2s4.6-10.2 10.2-10.2S39.1 58.4 39.1 64s-4.6 10.2-10.3 10.2z"
            class="colorFFCD0A svgShape"></path>
            <path fill="#ffffff"
            d="M98.4 61.8v1.9h2.5v1.5h-2.5v2.7h4.4v1.6h-7.4v-1.6h1.2v-2.7h-1.3v-1.5h1.3v-1.9c0-1.2.3-2.1.9-2.6.6-.5 1.4-.8 2.4-.8 1.3 0 2.3.6 2.9 1.7l-1.2 1c-.4-.7-.9-1-1.6-1-.5 0-.9.1-1.2.4s-.4.7-.4 1.3z"
            class="colorFFF svgShape"></path>
        </svg></g>
    </svg>
</div>
<div class="text-left">
    <h4 class="fw-bold">{{ get_option('feature_header4') }}</h4>
    <p class="mb-0">
      {{ get_option('feature_description4') }}
  </p>
</div>
</div>
</div>


</div>
</div>
</div>
</div>
<!-- ROW-2 CLOSED -->

<!-- ROW-3 OPEN -->
<div class="section bg-landing pb-0 bg-image-style" id="About">
    <div class="container">
        <div class="row">

            <span class="landing-title"></span>
            <div class="text-center">
                <h2 class="text-center fw-semibold">Why use our writing platform?
                </h2>
            </div>
            <div class="col-lg-12">
                <div class="card bg-transparent">
                    <div class="card-body text-dark">
                        <div class="statistics-info">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 ps-0">
                                    <div class="text-center reveal revealleft mb-3">
                                        <img src="assets/images/landing/business-team-working-on-business-plan.png"
                                        alt="" class="br-5">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 pe-0 my-auto">

                                    <div class="ps-5 reveal revealright">
                                        <h2 class="text-start fw-semibold fs-25 mb-6">We are a great group of people to work alongside!
                                        </h2>
                                        <div class="d-flex">
                                            <span><svg style="width:20px;height:20px"
                                                viewBox="0 0 24 24">
                                                <path fill="#6c5ffc"
                                                d="M23,12L20.56,9.22L20.9,5.54L17.29,4.72L15.4,1.54L12,3L8.6,1.54L6.71,4.72L3.1,5.53L3.44,9.21L1,12L3.44,14.78L3.1,18.47L6.71,19.29L8.6,22.47L12,21L15.4,22.46L17.29,19.28L20.9,18.46L20.56,14.78L23,12M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z" />
                                            </svg></span>
                                            <div class="ms-5 mb-4">
                                                <h5 class="fw-bold">@lang('app.best_customer_support')
                                                </h5>
                                                <p>@lang('app.best_customer_support_info')</p>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <span><svg style="width:20px;height:20px"
                                                viewBox="0 0 24 24">
                                                <path fill="#6c5ffc"
                                                d="M23,12L20.56,9.22L20.9,5.54L17.29,4.72L15.4,1.54L12,3L8.6,1.54L6.71,4.72L3.1,5.53L3.44,9.21L1,12L3.44,14.78L3.1,18.47L6.71,19.29L8.6,22.47L12,21L15.4,22.46L17.29,19.28L20.9,18.46L20.56,14.78L23,12M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z" />
                                            </svg></span>
                                            <div class="ms-5 mb-4">
                                                <h5 class="fw-bold">@lang('app.customer_satisfaction')</h5>
                                                <p>
                                                   @lang('app.customer_satisfaction_info') 
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ROW-3 CLOSED -->

<!-- ROW-4 OPEN -->
<div class="section testimonial-owl-landing">
    <div class="container">
        <div class="row">
            <div class="card bg-transparent mb-0">
                <span class="landing-title"></span>
                <div class="demo-screen-skin code-quality" id="dependencies">
                    <div class="text-center p-0">
                        <h2 class="text-center fw-semibold text-white">With @lang('app.site_name') You Can get Help With Below</h2>
                        <div class="row justify-content-center">
                            <div class="col-lg-12 px-0">
                                <div class="feature-logos mt-5">
                                    <div class="slide">
                                      <i class="fe fe-layers text-primary fs-23"></i>
                                      <h5 class="mt-3 text-white">
                                      Essay Writings</h5>
                                  </div>
                                  <div class="slide">
                                    <i class="fe fe-layers text-primary fs-23"></i>
                                    <h5 class="mt-3 text-white">Assignment Help</h5>
                                </div>

                                <div class="slide">
                                    <i class="fe fe-layers text-primary fs-23"></i>
                                    <h5 class="mt-3 text-white">Dissertation Help</h5>
                                </div>

                                <div class="slide">
                                    <i class="fe fe-layers text-primary fs-23"></i>
                                    <h5 class="mt-3 text-white">Coursework Help</h5>
                                </div>

                                <div class="slide">
                                    <i class="fe fe-layers text-primary fs-23"></i>
                                    <h5 class="mt-3 text-white">Programming Help</h5>
                                </div>

                                <div class="slide">
                                  <i class="fe fe-layers text-primary fs-23"></i>
                                  <h5 class="mt-3 text-white">Mathematics Help</h5>
                              </div>

                              <div class="slide">
                                <i class="fe fe-layers text-primary fs-23"></i>
                                <h5 class="mt-3 text-white">Exam Help</h5>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- ROW-4 CLOSED -->

 @if(get_country() == 'Kenya')

<!-- ROW-6 OPEN -->
@include('pricing')
<!-- ROW-6 CLOSED -->
@endif

<!-- ROW-7 OPEN -->
<div class="section" id="Faqs">
   <div class="container">
    <div class="row">
        <h4 class="text-center fw-semibold">FAQ'S ?</h4>
        <span class="landing-title"></span>
        <h2 class="text-center fw-semibold">{{ get_option('faq_header') }}</h2>
        <div class="row justify-content-center">
            <p class="col-xl-9 wow fadeInUp text-default sub-text mb-7"
            data-wow-delay="0s">
            {{ get_option('faq_description') }}
        </p>
    </div>
    <section class="sptb demo-screen-demo" id="faqs">
        <div class="row align-items-center">
            <div class="col-md-12 col-lg-6">
                <h2 class="text-start fw-semibold fs-25 mb-6">@lang('app.faq_subtitle1') 
                </h2>
                <div class="col-md-12 grid-item  px-0">
                    <div
                    class="card card-collapsed bg-primary-transparent p-0 reveal">
                    <div class="card-header grid-link"
                    data-bs-toggle="card-collapse">
                    <a href="#"
                    class="card-options-collapse h5 fw-bold card-title mb-0"><span
                    class="me-3 fs-18 fw-bold text-primary">01.</span>{{ get_option('faq_header1') }}</a>
                </div>
                <div class="card-body pt-0">
                    <p>

                     {{ get_option('faq_description1') }}
                 </p>
                 <p class="mt-2 mb-3">
                    <span class="fw-bold">Note: </span>Please Refer
                    support section for more information.
                </p>
                <img onclick="smartsupp('chat:open');">
                <a class="btn btn-outline-warning tx-13" href="#" onclick="smartsupp('chat:open'); return false;">Chat with us</a>
            </div>
        </div>
    </div>
    <div class="col-md-12 grid-item  px-0">
        <div
        class="card card-collapsed bg-success-transparent p-0 reveal">
        <div class="card-header grid-link"
        data-bs-toggle="card-collapse">
        <a href="#"
        class="card-options-collapse  h5 fw-bold card-title mb-0"><span
        class="me-3 fs-18 fw-bold text-success">02.</span>{{ get_option('faq_header2') }} </a>
    </div>
    <div class="card-body pt-0">
        <p>
          {{ get_option('faq_description2') }} 
      </p>
      <p class="mt-2 mb-3">
        <span class="fw-bold">Note: </span>Please Refer
        support section for more information.
    </p>
    <img onclick="smartsupp('chat:open');">
    <a class="btn btn-outline-warning tx-13" href="#" onclick="smartsupp('chat:open'); return false;">Chat with us</a>
</div>
</div>
</div>
<div class="col-md-12 grid-item  px-0">
    <div
    class="card card-collapsed bg-secondary-transparent p-0 reveal">
    <div class="card-header grid-link"
    data-bs-toggle="card-collapse">
    <a href="#"
    class="card-options-collapse  h5 fw-bold card-title mb-0"><span
    class="me-3 fs-18 fw-bold text-secondary">03.</span>{{ get_option('faq_header3') }} </a>
</div>
<div class="card-body pt-0">
    <p>
       {{ get_option('faq_description3') }}
   </p>
   <p class="mt-2 mb-3">
    <span class="fw-bold">Note: </span>Please Refer
    support section for more information.
</p>
<img onclick="smartsupp('chat:open');">
<a class="btn btn-outline-warning tx-13" href="#" onclick="smartsupp('chat:open'); return false;">Chat with us</a>
</div>
</div>
</div>
<div class="col-md-12 grid-item  px-0">
    <div
    class="card card-collapsed bg-warning-transparent p-0 reveal">
    <div class="card-header grid-link"
    data-bs-toggle="card-collapse">
    <a href="#"
    class="card-options-collapse  h5 fw-bold card-title mb-0"><span
    class="me-3 fs-18 fw-bold text-warning">04.</span>{{ get_option('faq_header4') }}</a>
</div>
<div class="card-body pt-0">
    <p>
     {{ get_option('faq_description4') }}
 </p>
 <p class="mt-2 mb-3">
    <span class="fw-bold">Note: </span>Please Refer
    support section for more information.
</p>
<img onclick="smartsupp('chat:open');">
<a class="btn btn-outline-warning tx-13" href="#" onclick="smartsupp('chat:open'); return false;">Chat with us</a>
</div>
</div>
</div>
<div class="col-md-12 grid-item  px-0">
    <div
    class="card card-collapsed bg-danger-transparent p-0 reveal">
    <div class="card-header grid-link"
    data-bs-toggle="card-collapse">
    <a href="#"
    class="card-options-collapse  h5 fw-bold card-title mb-0"><span
    class="me-3 fs-18 fw-bold text-danger">05.</span>{{ get_option('faq_header5') }}</a>
</div>
<div class="card-body pt-0">
    <p>
     {{ get_option('faq_description5') }}
 </p>
 <p class="mt-2 mb-3">
    <span class="fw-bold">Note: </span>Please Refer
    support section for more information.
</p>
<img onclick="smartsupp('chat:open');">
<a class="btn btn-outline-warning tx-13" href="#" onclick="smartsupp('chat:open'); return false;">Chat with us</a>
</div>
</div>

</div>
</div>



           <div class="col-md-12 col-lg-6">
                <h2 class="text-start fw-semibold fs-25 mb-6">@lang('app.faq_subtitle2') 
                </h2>
                <div class="col-md-12 grid-item  px-0">
                    <div
                    class="card card-collapsed bg-primary-transparent p-0 reveal">
                    <div class="card-header grid-link"
                    data-bs-toggle="card-collapse">
                    <a href="#"
                    class="card-options-collapse h5 fw-bold card-title mb-0"><span
                    class="me-3 fs-18 fw-bold text-primary">01.</span>{{ get_option('cfaq_header1') }}</a>
                </div>
                <div class="card-body pt-0">
                    <p>
                     {{ get_option('cfaq_description1') }}
                 </p>
                 <p class="mt-2 mb-3">
                    <span class="fw-bold">Note: </span>Please Refer
                    support section for more information.
                </p>
                <img onclick="smartsupp('chat:open');">
                <a class="btn btn-outline-warning tx-13" href="#" onclick="smartsupp('chat:open'); return false;">Chat with us</a>
            </div>
        </div>
    </div>
    <div class="col-md-12 grid-item  px-0">
        <div
        class="card card-collapsed bg-success-transparent p-0 reveal">
        <div class="card-header grid-link"
        data-bs-toggle="card-collapse">
        <a href="#"
        class="card-options-collapse  h5 fw-bold card-title mb-0"><span
        class="me-3 fs-18 fw-bold text-success">02.</span>{{ get_option('cfaq_header2') }} </a>
    </div>
    <div class="card-body pt-0">
        <p>
          {{ get_option('cfaq_description2') }} 
      </p>
      <p class="mt-2 mb-3">
        <span class="fw-bold">Note: </span>Please Refer
        support section for more information.
    </p>
    <img onclick="smartsupp('chat:open');">
    <a class="btn btn-outline-warning tx-13" href="#" onclick="smartsupp('chat:open'); return false;">Chat with us</a>
</div>
</div>
</div>
<div class="col-md-12 grid-item  px-0">
    <div
    class="card card-collapsed bg-secondary-transparent p-0 reveal">
    <div class="card-header grid-link"
    data-bs-toggle="card-collapse">
    <a href="#"
    class="card-options-collapse  h5 fw-bold card-title mb-0"><span
    class="me-3 fs-18 fw-bold text-secondary">03.</span>{{ get_option('cfaq_header3') }} </a>
</div>
<div class="card-body pt-0">
    <p>
       {{ get_option('cfaq_description3') }}
   </p>
   <p class="mt-2 mb-3">
    <span class="fw-bold">Note: </span>Please Refer
    support section for more information.
</p>
<img onclick="smartsupp('chat:open');">
<a class="btn btn-outline-warning tx-13" href="#" onclick="smartsupp('chat:open'); return false;">Chat with us</a>
</div>
</div>
</div>
<div class="col-md-12 grid-item  px-0">
    <div
    class="card card-collapsed bg-warning-transparent p-0 reveal">
    <div class="card-header grid-link"
    data-bs-toggle="card-collapse">
    <a href="#"
    class="card-options-collapse  h5 fw-bold card-title mb-0"><span
    class="me-3 fs-18 fw-bold text-warning">04.</span>{{ get_option('cfaq_header4') }}</a>
</div>
<div class="card-body pt-0">
    <p>
     {{ get_option('cfaq_description4') }}
 </p>
 <p class="mt-2 mb-3">
    <span class="fw-bold">Note: </span>Please Refer
    support section for more information.
</p>
<img onclick="smartsupp('chat:open');">
<a class="btn btn-outline-warning tx-13" href="#" onclick="smartsupp('chat:open'); return false;">Chat with us</a>
</div>
</div>
</div>
<div class="col-md-12 grid-item  px-0">
    <div
    class="card card-collapsed bg-danger-transparent p-0 reveal">
    <div class="card-header grid-link"
    data-bs-toggle="card-collapse">
    <a href="#"
    class="card-options-collapse  h5 fw-bold card-title mb-0"><span
    class="me-3 fs-18 fw-bold text-danger">05.</span>{{ get_option('cfaq_header5') }}</a>
</div>
<div class="card-body pt-0">
    <p>
     {{ get_option('cfaq_description5') }}
 </p>
 <p class="mt-2 mb-3">
    <span class="fw-bold">Note: </span>Please Refer
    support section for more information.
</p>
<img onclick="smartsupp('chat:open');">
<a class="btn btn-outline-warning tx-13" href="#" onclick="smartsupp('chat:open'); return false;">Chat with us</a>
</div>
</div>

</div>
</div>
</div>
</section>
</div>
</div>
</div>
<!-- ROW-7 CLOSED -->




<!-- ROW-9 OPEN -->
<div class="testimonial-owl-landing section pb-0" id="Clients" style="display: none;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card bg-transparent">
                    <div class="card-body pt-5">
                        <h4 class="text-center fw-semibold text-white-80">Testimonials </h4>
                        <span class="landing-title"></span>
                        <h2 class="text-center fw-semibold text-white mb-7">What People Are
                        Saying About Our Product.</h2>
                        <div class="testimonial-carousel">
                            <div class="slide text-center">
                                <div class="row">
                                    <div class="col-xl-8 col-md-12 d-block mx-auto">
                                        <div class="testimonia">
                                            <p class="text-white-80">
                                                <i
                                                class="fa fa-quote-left fs-20 text-white-80"></i>
                                                You promised us and you did exactly that! We post orders let your team do their job and be an helicopter watching over them. This makes me feel like taking all sorts of orders 😂. 
                                            </p>
                                            <h3 class="title">Boniface Muindi</h3>
                                            <span class="post">Academic Writer</span>
                                            <div class="rating-stars block my-rating-5 mb-5"
                                            data-rating="4"></div>
                                            <div class="owl-controls clickable">
                                                <div class="owl-pagination">
                                                    <div class="owl-page active">
                                                        <span class=""></span>
                                                    </div>
                                                    <div class="owl-page ">
                                                        <span class=""></span>
                                                    </div>
                                                    <div class="owl-page">
                                                        <span class=""></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="slide text-center">
                                <div class="row">
                                    <div class="col-xl-8 col-md-12 d-block mx-auto">
                                        <div class="testimonia">
                                            <p class="text-white-80"><i
                                                class="fa fa-quote-left fs-20"></i> 
                                                Saseni offers value for money. A dedicated team that is open to stretching when necessary. 
                                                From the first day, get into action. We look forward to quick responses from Saseni's next-level 
                                                managers in situations that are beyond the capabilities of the ground team. 
                                                The operations team should be further trained to adhere to the systems and procedures 
                                                in writing that believe professional management. 
                                            </p>
                                            <div class="testimonia-data">
                                                <h3 class="title">williamson</h3>
                                                <span class="post">Developer</span>
                                                <div class="rating-stars">
                                                    <div class="rating-stars block my-rating-5 mb-5"
                                                    data-rating="5"></div>
                                                    <div class="owl-controls clickable">
                                                        <div class="owl-pagination">
                                                            <div class="owl-page ">
                                                                <span class=""></span>
                                                            </div>
                                                            <div class="owl-page active">
                                                                <span class=""></span>
                                                            </div>
                                                            <div class="owl-page">
                                                                <span class=""></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="slide text-center">
                                <div class="row">
                                    <div class="col-xl-8 col-md-12 d-block mx-auto">
                                        <div class="testimonia">
                                            <p class="text-white-80"><i
                                                class="fa fa-quote-left fs-20"></i> After migrating to Saseni,
                                                the hours I spent managing my writers
                                            took a nosedive.</p>
                                            <div class="testimonia-data">
                                                <h3 class="title">Sophie Carr</h3>
                                                <span class="post">Writing Expert</span>
                                                <div class="rating-stars">
                                                    <div class="rating-stars block my-rating-5 mb-5"
                                                    data-rating="5"></div>
                                                    <div class="owl-controls clickable">
                                                        <div class="owl-pagination">
                                                            <div class="owl-page ">
                                                                <span class=""></span>
                                                            </div>
                                                            <div class="owl-page">
                                                                <span class=""></span>
                                                            </div>
                                                            <div class="owl-page active">
                                                                <span class=""></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ROW-9 CLOSED -->



<!-- ROW-11 OPEN -->
<div class="">
    <div class="container">
        <div class="testimonial-owl-landing buynow-landing reveal revealrotate">
            <div class="row pt-6">
                <div class="col-md-12">
                    <div class="card bg-transparent">
                        <div class="card-body pt-5 px-7">
                            <div class="row">
                                <div class="col-lg-9">
                                    <h2 class="fw-semibold text-white">On-time Delivery Guarantee
                                    </h2>
                                    <p class="text-white">
                                        @lang('app.site_name') guartantees you High quality work, on-time delivery, and plagiarism free papers. Start working with us today. 
                                    </div>
                                    <div class="col-lg-3 text-end my-auto">
                                        <a href="{{ route('register')}}"
                                        target="_blank"
                                        class="btn btn-pink w-lg pt-2 pb-2">Get Started
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ROW-11 CLOSED -->
@endsection