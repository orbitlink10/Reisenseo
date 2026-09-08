@extends('theme.perfectwriter.header')
@section('title') Create an account and place an order @endsection
@section('description')Let us help you work on your paper and maintain quality within the specified deadline. Once you post the order, the rest is on us.
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
      <img src="{{ asset('perfectwriter/new-land/images/log-in-mob.png')}}" alt="{{ get_option(site_id().'_site_name') }}">
    </div>
    <div class="divRight">
      <div class="allForms">



        <form class="signin active" method="POST" action="{{ route('cregister') }}">
          <h1 class="pageHead" >@lang('app.registration')</h1>

          @error('email')
          <span class="custom-alert custom-alert-danger" id="errorSigninAlert">
            <strong>{{ $message }}</strong>
            <br>
          </span>
          @enderror
          <div id="successSigninAlert" class="custom-alert custom-alert-success" style="display:none;"></div>
          <div id="errorSigninAlert" class="custom-alert custom-alert-danger" style="display:none;"></div>


          <div class="inputGroup signupGroup">
            <input type="text" id="name" name="name" value="" >
            <label class="focused" for="user_id" >Name</label>
            
          </div>

          <div class="inputGroup signupGroup">
            <input type="text" id="name" name="phone" value="" >
            <label class="focused" for="user_id" >Phone</label>
          </div>

          <div class="inputGroup signupGroup">
            <input type="email" id="user_id" name="email" value="" >
            <label class="focused" for="user_id" >Email</label>
          </div>

          <div class="inputGroup signupGroup">
            <input type="password" id="user_id" name="password" value="" >
            <label class="focused" for="user_id" >Password</label>
          </div>

          <div class="inputGroup signupGroup">
            <input list="browsers" placeholder="Search and Choose Country" name="country" required="">
            <datalist id="browsers">
             <?php
             $orders = \App\Models\Country::orderBy('cntry_phonecode', 'asc')->get();
             ?>
             @foreach($orders as $order)
             <option value="{{ $order->cntry_nicename }}">(+{{ $order->cntry_phonecode }}) {{ $order->cntry_nicename }}</option>
             @endforeach
           </datalist>

           <label class="focused" for="user_id" >Country</label>
         </div>

         <div class="flexInput ">
          <div class="showPassCheck">
            <input class="showPass" checked="" type="checkbox"  name="showPassLi" value="">
            <p class="showPassTxt" >Agree terms and policy</p>
          </div>
          <p> <a class="forgotPass loginModelButton" href="javascript:;" onclick="showOther('#login_form','#forgetPassForm')">Forgot Password?</a> </p>
        </div>

        <button class="getStarted" type="submit" class="login100-form-btn btn-primary">
         REGISTER
       </button>
       

       <p class="loginRedirect" >Already have account?? <a class="loginModelButton signUpBTn" href="{{ route('clogin') }}">Sign In</a> </p>
     </form>
   </div>
 </div>
</div>
</section>

<link rel="stylesheet" href="{{ asset('perfectwriter/new-land/css/loginModal.css')}}">
<script type="text/javascript" src="{{ asset('perfectwriter/new-land/js/models.js')}}"></script>

@endsection
