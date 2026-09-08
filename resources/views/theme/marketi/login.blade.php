@extends('theme.perfectwriter.header')
@section('title')@if( ! empty($title)){{$title}} |@endif @parent @endsection
@section('description')Login to your account and Let us help you work on your paper and maintain quality within the specified deadline. 
 @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('perfectwriter/new-land/css/login-new.css')}}">
<link rel="stylesheet" href="{{ asset('perfectwriter/new-land/css/order-new.css')}}">
<style>
  /* Custom alerts */
  .custom-alert {
    position: relative;
    padding: 0.75rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: 0.25rem;
  }
  .custom-alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
  }
  .custom-alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
  }
  .padding-zero{
    padding:0;
  }
</style>
<section class="login">
  <div class="pageWrapper">
    <div class="leftMob">
      <img src="{{ asset('perfectwriter/new-land/images/log-in-mob.png')}}" alt="MyPerfectPaper.net">
    </div>

    <div class="divRight">
      <div class="allForms">
    <form class="signin active" method="POST" action="{{ route('login') }}">
          <h1 class="pageHead" >Login</h1>

             @error('email')
                                    <span class="custom-alert custom-alert-danger" id="errorSigninAlert">
                                        <strong>{{ $message }}</strong>
                                        <br>
                                    </span>
                                @enderror

          <div id="successSigninAlert" class="custom-alert custom-alert-success" style="display:none;"></div>
          <div id="errorSigninAlert" class="custom-alert custom-alert-danger" style="display:none;"></div>


          <div class="inputGroup signupGroup">
            <input type="email" id="user_id" name="email" value="" >
            <label class="focused" for="user_id" >Email</label>


          </div>

          <div class="inputGroup signupGroup">
            <input type="password" id="user_id" name="password" value="" >
            <label class="focused" for="user_id" >Password</label>
          
          </div>


         <div class="flexInput ">
          <p> <a href="{{ route('password.request') }}">Forgot Password?</a> </p>
        </div>

  <button class="getStarted" type="submit" class="login100-form-btn btn-primary">
                                   Sign In
                    </button>
  

        <p class="loginRedirect" >Not a member?<a class="loginModelButton signUpBTn" href="{{ url('order') }}"> Sign Up</a> </p>
      </form>

    </div>
  </div>
</div>
</section>
<section class="recoverMsg">
  <div class="recoverOverlay"> </div>
  <div class="msgBox">
    <div class="gifBox">
      <img class="msgGif" src="https://www.myperfectpaper.net/new-land/images/emailSentGif.gif" alt="Email Gif">
    </div>
    <p>Your password has been sent to <br> <span id="emailSpan"></span> </p>
    <button id="passSentBtn" class="getStarted" type="continue" name="continue">Continue</button>
  </div>
</section>









<link rel="stylesheet" href="{{asset('perfectwriter/new-land/css/loginModal.css')}}">
<div class="signUpModel">
  <div class="signUpoverlay"></div>
  <div class="signUpForm">
    <p class="signuphead">Please create an account to continue</p>
    <form id="register_form" class="signup" action="order-review" method="post" >

      <div id="successRegisterAlert" class="custom-alert custom-alert-success" style="display:none;"></div>
      <div id="errorRegisterAlert" class="custom-alert custom-alert-danger" style="display:none;"></div>

      <div class="inputGroup signupGroup">
        <input type="text" id="r_name" name="r_name" value="" >
        <label for="r_name">Name</label>
      </div>
      <div class="inputGroup signupGroup" >
        <input type="text" id="r_email" name="r_email" value="" >
        <label for="r_email" class="focused">Email</label>
      </div>
      <div class="inputGroup signupGroup" >
        <!-- <input type="number" id="r_phone" name="r_phone" value="" maxlength="15"> -->
        <input type="text" id="r_phone" name="r_phone" value="" maxLength="16" onkeypress="return isNumberValidate(event)">
        <label for="r_phone" class="focused">Phone Number</label>
      </div>

      <div class="flexInput">
        <div class="inputGroup signupGroup ">
          <input type="password" id="account_password" name="account_password" value="">
          <label for="account_password">Password</label>
        </div>
        <div class="inputGroup signupGroup" >
          <input type="password" id="re_account_password" name="re_account_password" value="">
          <label for="re_account_password">Confirm Password</label>
        </div>
      </div>
      <div class="flexInput" >
        <div class="showPassCheck">
          <input onclick="passToText('#account_password')" class="showPass" type="checkbox" id="showPass" name="showPass" value="">
          <p class="showPassTxt">Show Password</p>
        </div>
        <div class="showPassCheck">
          <input onclick="passToText('#re_account_password')" class="showPassConfirm" type="checkbox" id="showPassConfirm" name="showPassConfirm" value="">
          <p class="showPassTxt">Show Password</p>
        </div>
      </div>
      <button type="button" id="siGnUpProcessingBtn" class="getStarted" style="background-color: rgb(158, 158, 158);display: none">Processing...</button>
      <button type="button" id="signUpBtn" class="getStarted" name="getStarted">Get Started</button>
      <p class="loginRedirect">Already have an account? <a onclick="showLoginModel()" class="loginModelButton" href="javascript:;">Login Instead</a> </p>
    </form>
  </div>
  <div class="loginForm" >
    <p class="signuphead">Please login to continue</p>
    <form class="signin" id="login_form" action="order-review" method="post">

      <div id="successSigninAlert" class="custom-alert custom-alert-success" style="display:none;"></div>
      <div id="errorSigninAlert" class="custom-alert custom-alert-danger" style="display:none;"></div>

      <div class="inputGroup signupGroup" >
        <input type="text" id="user_id" name="user_id" value="">
        <label for="user_id" class="focused">Email</label>
      </div>
      <div class="inputGroup signupGroup">
        <input type="password" id="password" name="password" value="">
        <label for="password">Password</label>
      </div>
      <div class="flexInput">
        <div class="showPassCheck">
          <input onclick="passToText('#password')" class="showPass" type="checkbox" id="showPassLi" name="showPassLi" value="">
          <p class="showPassTxt">Show Password</p>
        </div>
        <p> <a target="_blank" class="forgotPass loginModelButton" onclick="1" href="{{ route('clogin')}}">Forgot Password?</a> </p>
      </div>
      <button type="button" id="loginBtn" class="getStarted" name="login">Log In</button>
      <button type="button" id="loginProcessingBtn" class="getStarted" style="background-color: rgb(158, 158, 158);display: none">Processing...</button>
      <p class="loginRedirect">Don’t have an account? <a onclick="hideLoginModel()" class="loginModelButton" href="javascript::">Sign Up</a> </p>
    </form>
  </div>
</div>
<script type="text/javascript" src="{{ asset('perfectwriter/new-land/js/models.js')}}"></script>








  @endsection
