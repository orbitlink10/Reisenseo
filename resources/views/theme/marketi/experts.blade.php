@extends('theme.perfectwriter.header')
@section('title')@if( ! empty($title)){{$title}} |@endif @parent @endsection
@section('description') @if( ! empty(get_option(site_id().'_show_6_meta'))){{ substr(trim(preg_replace('/\s\s+/', ' ',strip_tags(get_option(site_id().'_show_6_meta')))),0,160) }}@endif @endsection

@section('social-meta')
<link rel="canonical" href="{{ route('experts') }}" />
@endsection
@section('content')
<style>
  .sticky-new-m {
    background-color: #CE0D19;
    padding: 19px 0;
    width: 100%;
    display: flex;
    align-items: center;
  }

  /*position: sticky;top: 71px;z-index: 4;*/

  .sticky-new {
    float: left;
    width: 100%;
  }
  p.for_mob{
    display: none;
  }
  .sticky-new ul {
    display: flex;
    flex-direction: row;
    justify-content: center;
    margin: 0;
    padding: 0;
    column-gap: 50px;
  }

  .sticky-new ul li {
    align-items: center;
    display: flex;
    position: relative;
  }


  .sticky-content {
    display: flex;
    align-items: center;
    column-gap: 20px;
  }

  .first-span p {
    font-weight: 500;
    font-size: 30px;
    line-height: 38px;
  }

  .first-span {
    font-size: 30px;
    line-height: 38px;
    color: #fff;
    text-align: left;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .second-span {
    color: #fff;
    font-weight: 500;
    font-size: 30px;
    line-height: 38px;
  }
  .second-span.blink {
    animation: blink 1s linear infinite;
  }

  .first-span h4 {
    font-size: 20px;
    color: #fff;
    margin: 0;
    display: inline-block;
  }

  .sticky-new #time_12 {
    color: #fff;
  }

  .sticky-new a {
    text-decoration: none;
    width: 216px;
    background-color: #01305c;
    border-radius: 28px;
    font-size: 24px;
    text-align: center;
    padding: 6px 15px;
    color: #fff;

    -webkit-box-shadow: 0px 6px 0px rgba(1, 48, 92, 58%), 0px 3px 15px rgba(0, 0, 0, .4);

    -moz-box-shadow: 0px 6px 0px rgba(1, 48, 92, 58%), 0px 3px 15px rgba(0, 0, 0, .4);

    box-shadow: 0px 6px 0px rgba(1, 48, 92, 58%), 0px 3px 15px rgba(0, 0, 0, .4);

    transition: 0.2s all ease;

    transform: translate(0px, 0px);

  }

  .sticky-new a:hover {

    box-shadow: 0px 3px 0px rgba(1, 48, 92, 58%), 0px 3px 15px rgba(0, 0, 0, .4);

    transform: translate(0px, 3px);

  }

  span#time_13 {

    display: flex;

    justify-content: center;

    align-items: center;

  }



  span#time_13 p span {

    display: block;

    text-align: center;



  }



  span#time_13 .af_values {

    color: #fff;

    font-size: 17px;

    font-family: 'GT-Walsheim-Pro-Medium';

    border: 1px solid #fff;
    display: inline-block;
    padding: 4px 10px;
    border-radius: 3px;
    margin-bottom: 5px;
    width: 32px;
  }



  span#time_13 .af_title {

    font-weight: 500;
    font-size: 15px;
    line-height: 19px;

    color: #FFFFFF;

  }



  span#time_13 p {

    margin: 0;

    position: relative;

    padding: 0 15px;


  }



  span#time_13 p:after {
    content: ":";
    position: absolute;
    top: 5px;
    right: -5px;
    top: -5px;
    color: #fff;
    font-size: 30px;
  }



  span#time_13 p:last-child:after {

    display: none;

  }

  .row {
    display: flex;
    flex-wrap: wrap;
    text-align: center;
    align-items: center;
    justify-content: center;
  }
  @keyframes blink {
    0% {
      opacity: 0
    }
    50% {
      opacity: .5
    }
    100% {
      opacity: 1
    }
  }

  @media(max-width:1200px) {

    .sticky-new-m {

      top: 61px;

    }

  }

  @media (max-width:991px) {

    .sticky-new-m {

      top: 125px;

    }

    .first-span h4 {

      font-size: 18px;

    }

    span.second-span {

      font-size: 18px;

    }

    .first-span {

      font-size: 18px;

    }

    span#time_13 p {

      padding: 0 15px;

    }

    .sticky-new a {

      width: 158px;

      font-size: 20px;

    }

  }

  @media(max-width:767px) {



    .sticky-new-m {

      top: 57px;

    }

    .col-12 {
      width: 100%;
    }



    span.second-span {
      font-size: 15px;
      line-height: 18px;
    }



    .first-span {

      font-size: 16px;

      display: unset;

    }



    .first-span h4 {

      font-size: 16px;

    }



    .sticky-new a {

      width: 140px;

      font-size: 18px;

    }



    .sticky-new ul {
      position: relative;
      column-gap: 30px;
    }



    .sticky-new-m {

      padding: 8px 15px;


    }

  }

  @media (max-width: 575px) {

    .sticky-new a {
      width: 95px;
      font-size: 14px;
    }
    .first-span p {
      font-size: 16px;
      line-height: 18px;
    }

    .sticky-content {
      align-items: centerc;
      column-gap: 10px;
    }
    .sticky-content svg {
      width: 17px;
      height: 17px;
    }
    span#time_13 .af_values {
      font-size: 14px;
      padding: 5px;
    }
    span#time_13 p {
      padding: 0 8px;
    }
    span#time_13 p:after {
      font-size: 25px;
      right: -3px;
      top: -3px;
    }
    .sticky-new ul {
      position: relative;
      column-gap: 0px;
      justify-content: center;
    }
    .sticky-new-m {
      padding: 18px 0px;
    }
  }


  @media(max-width:520px) {
    span#time_13 .af_values {
      width: 21px;
    }
    .sticky-new-m {
      top: 57px;
    }

    .first-span h4 {
      display: none;
    }



    span#time_13 {
      left: 74px;
      bottom: 20px;
      margin: 0 auto;
    }



    span#time_13 .af_values {
      font-size: 15px;
    }

    span#time_13 .af_title {
      font-size: 10px;
    }

  }

  @media(max-width:420px) {
    .sticky-new ul {
      column-gap: 0;
      justify-content: center;
    }


  }

  @media(max-width:400px) {

    .sticky-new-m {

      top: 67px;

    }

  }

</style>



<script>
  function startTimer(duration, display) {

    var start = Date.now(),

    diff,

    minutes,

    seconds, hours;

    function timer() {

    // get the number of seconds that have elapsed since

    // startTimer() was called

    diff = duration - (((Date.now() - start) / 1000) | 0);



    // does the same job as parseInt truncates the float

    hours = (diff / (60 * 60)) | 0;

    minutes = (diff / 60) - (hours * 60) | 0;

    seconds = (diff % 60) | 0;



    hours = hours < 10 ? "0" + hours : hours;

    minutes = minutes < 10 ? "0" + minutes : minutes;

    seconds = seconds < 10 ? "0" + seconds : seconds;

    hoursArr = [parseInt(hours / 10), hours % 10];
    minsArr = [parseInt(minutes / 10), minutes % 10];
    secArr = [parseInt(seconds / 10), seconds % 10];

    //display.textContent = hours +":"+minutes + ":" + seconds;

    // display.textContent = "<span>0</span> <span>Days</span> <span>"+ hours +"</span> <span>Hours</span> <span>"+minutes+"</span> <span>Minutes</span> <span>"+seconds+"</span><span>Seconds</span>";

    var timerHtml = " <p><span class='af_values'>" + hoursArr[0] + "</span> <span class='af_values'>" + hoursArr[1] +
    "</span> <span class='af_title'>Hours</span></p> <p><span class='af_values'>" + minsArr[0] +
    "</span> <span class='af_values'>" + minsArr[1] +
    "</span> <span class='af_title'>Minutes</span></p> <p><span class='af_values'>" + secArr[0] +
    "</span> <span class='af_values'>" + secArr[1] + "</span> <span class='af_title'>Seconds</span></p>";

    display.innerHTML = timerHtml;

    if (diff <= 0) {

      // add one second so that the count down starts at the full duration

      // example 05:00 not 04:59

      start = Date.now() + 1000;

    }

  };

  // we don't want to wait a full second before the timer starts

  timer();

  setInterval(timer, 1000);

}
</script>


<!-- 
<div class="sticky-new-m float-left w-10">

  <div class="container">

    <div class="row">

      <div class="col-12">

        <div class="sticky-new">

          <ul>

            <li>

              <div class="sticky-content">

                <svg width="35" height="35" viewbox="0 0 43 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <g clip-path="url(#clip0_3054_2794)">
                    <path d="M29.1607 25.297L23.1653 20.8005V11.641C23.1653 10.72 22.4209 9.97559 21.4999 9.97559C20.5789 9.97559 19.8345 10.72 19.8345 11.641V21.6333C19.8345 22.1579 20.081 22.6525 20.5006 22.9656L27.1621 27.9618C27.4618 28.1866 27.8116 28.2948 28.1597 28.2948C28.6676 28.2948 29.1672 28.0667 29.4937 27.627C30.0467 26.8925 29.8968 25.8483 29.1607 25.297Z" fill="white" stroke="#DB212D" stroke-width="1.075"></path>
                    <path d="M21.5 0C9.64418 0 0 9.64418 0 21.5C0 33.3558 9.64418 43 21.5 43C33.3558 43 43 33.3558 43 21.5C43 9.64418 33.3558 0 21.5 0ZM21.5 39.6693C11.4828 39.6693 3.33074 31.5172 3.33074 21.5C3.33074 11.4828 11.4828 3.33074 21.5 3.33074C31.5189 3.33074 39.6693 11.4828 39.6693 21.5C39.6693 31.5172 31.5172 39.6693 21.5 39.6693Z" fill="white" stroke="#DB212D" stroke-width="1.075"></path>
                  </g>
                  <defs>
                    <clippath id="clip0_3054_2794">
                      <rect width="43" height="43" fill="white"></rect>
                    </clippath>
                  </defs>
                </svg>



                <span class="first-span">
                  <p class="for_desk">50% off on all orders<span class="second-span"> (Limited time only)</span></p>
                  <p class="for_mob"><strong>50% off </strong><span class="second-span"><br> (Limited time only)</span></p>




                </span>

              </div>

            </li>




          </ul>

        </div>

      </div>

    </div>

  </div>

</div> -->



<link rel="stylesheet" href="{{ asset('perfectwriter/new-land/css/mpw-writers.css')}}">








<section class="writer__profiles">
  <div class="container">
    <h2>Here’s a quick look at some writers we have standing by ready
    to help you achieve your academic success:</h2>
    <div class="writers__wrapper">


      @if($worders->count()>0)

      <?php 

      $u = 0;
      ?>
      @foreach($worders as $worder)

      @if($worder->writer_id != $u)

      <?php 

      $u      = $worder->writer_id;
      $writer = \App\Models\User::find($worder->writer_id);
      $writer_count = \App\Models\User::whereId($worder->writer_id)->count();
      $user = \App\Models\User::find($worder->writer_id);

      ?>

      @if($writer_count>0)
      <div class="writerCard">
            <div class="writer_card_head">
              <div class="writer_image">
                                <div class="writerskelton"></div>
                <img src="" data-src="{{ $writer->get_gravatar(150) }}" alt="Dorothy M">
              </div>
              <div class="writer_info">
                <p>{{ $writer->nickname }}</p>

                     <?php
                      $count_star_rating = \App\Models\Review_rating::whereWriterId($user->id)->count();
                      $sum_star_rating = \App\Models\Review_rating::whereWriterId($user->id)->sum('star_rating');
                      if ($count_star_rating!=0) {
                       $star_rating = $sum_star_rating/$count_star_rating*100;
                     } else{
                      $star_rating = 0;
                    }

                    ?>

                <p class="writer_rating">
                  <span>Average quality score {{ number_format((float)$star_rating, 2, '.', '')  }}%</span>
                 

                </p>
        
              </div>
            </div>
            <div class="writer_card_foot">
              <div class="totalOrders">
                <p>Total orders</p>
                <p>{{ writertotals($user->id) }}</p>
              </div>
              <div class="writer_card_btns">
                <a class="aboutBtn" href="{{ route('profile', $user->id )}}">About Writer</a>
                <a rel="nofollow" class="hireBtn" href="{{ route('request_writer', ['writer_id' => $user->id ])}}">Hire Writer</a>
              </div>
            </div>
          </div>


      @endif
      @endif
      @endforeach


      @else
      <tr>No expert available</tr>
      @endif


    </div>
    <button id="loadWriters" class="showWriters">Show more</button>

  </div>
</section>

<section class="paper">
  <div class="container">
    <div class="paper-wraper">
      <div class="paper-text">
        <p class="paper-head">If your paper matters, we own all the good words</p>
      </div>
      <div class="started-btn">
        <a href="{{ url('order')}}">Order Now
          <span class="pulseanim"></span>
        </a>
      </div>
      <span class="ornament">
        <svg width="90" height="90" viewbox="0 0 90 90" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M2.32759 4.65517C3.61307 4.65517 4.65517 3.61307 4.65517 2.32759C4.65517 1.0421 3.61307 0 2.32759 0C1.0421 0 0 1.0421 0 2.32759C0 3.61307 1.0421 4.65517 2.32759 4.65517ZM2.32759 38.7931C3.61307 38.7931 4.65517 37.751 4.65517 36.4655C4.65517 35.18 3.61307 34.1379 2.32759 34.1379C1.0421 34.1379 0 35.18 0 36.4655C0 37.751 1.0421 38.7931 2.32759 38.7931ZM4.65517 70.6035C4.65517 71.889 3.61307 72.931 2.32759 72.931C1.0421 72.931 0 71.889 0 70.6035C0 69.3179 1.0421 68.2759 2.32759 68.2759C3.61307 68.2759 4.65517 69.3179 4.65517 70.6035ZM2.32759 21.7241C3.61307 21.7241 4.65517 20.6821 4.65517 19.3966C4.65517 18.111 3.61307 17.069 2.32759 17.069C1.0421 17.069 0 18.111 0 19.3966C0 20.6821 1.0421 21.7241 2.32759 21.7241ZM4.65517 53.5345C4.65517 54.82 3.61307 55.8621 2.32759 55.8621C1.0421 55.8621 0 54.82 0 53.5345C0 52.249 1.0421 51.2069 2.32759 51.2069C3.61307 51.2069 4.65517 52.249 4.65517 53.5345ZM2.32759 90C3.61307 90 4.65517 88.958 4.65517 87.6724C4.65517 86.3868 3.61307 85.3448 2.32759 85.3448C1.0421 85.3448 0 86.3868 0 87.6724C0 88.958 1.0421 90 2.32759 90ZM72.931 2.32759C72.931 3.61307 71.889 4.65517 70.6035 4.65517C69.3179 4.65517 68.2759 3.61307 68.2759 2.32759C68.2759 1.0421 69.3179 0 70.6035 0C71.889 0 72.931 1.0421 72.931 2.32759ZM70.6035 38.7931C71.889 38.7931 72.931 37.751 72.931 36.4655C72.931 35.18 71.889 34.1379 70.6035 34.1379C69.3179 34.1379 68.2759 35.18 68.2759 36.4655C68.2759 37.751 69.3179 38.7931 70.6035 38.7931ZM72.931 70.6035C72.931 71.889 71.889 72.931 70.6035 72.931C69.3179 72.931 68.2759 71.889 68.2759 70.6035C68.2759 69.3179 69.3179 68.2759 70.6035 68.2759C71.889 68.2759 72.931 69.3179 72.931 70.6035ZM70.6035 21.7241C71.889 21.7241 72.931 20.6821 72.931 19.3966C72.931 18.111 71.889 17.069 70.6035 17.069C69.3179 17.069 68.2759 18.111 68.2759 19.3966C68.2759 20.6821 69.3179 21.7241 70.6035 21.7241ZM72.931 53.5345C72.931 54.82 71.889 55.8621 70.6035 55.8621C69.3179 55.8621 68.2759 54.82 68.2759 53.5345C68.2759 52.249 69.3179 51.2069 70.6035 51.2069C71.889 51.2069 72.931 52.249 72.931 53.5345ZM70.6035 90C71.889 90 72.931 88.958 72.931 87.6724C72.931 86.3868 71.889 85.3448 70.6035 85.3448C69.3179 85.3448 68.2759 86.3868 68.2759 87.6724C68.2759 88.958 69.3179 90 70.6035 90ZM38.7931 2.32759C38.7931 3.61307 37.751 4.65517 36.4655 4.65517C35.18 4.65517 34.1379 3.61307 34.1379 2.32759C34.1379 1.0421 35.18 0 36.4655 0C37.751 0 38.7931 1.0421 38.7931 2.32759ZM36.4655 38.7931C37.751 38.7931 38.7931 37.751 38.7931 36.4655C38.7931 35.18 37.751 34.1379 36.4655 34.1379C35.18 34.1379 34.1379 35.18 34.1379 36.4655C34.1379 37.751 35.18 38.7931 36.4655 38.7931ZM38.7931 70.6035C38.7931 71.889 37.751 72.931 36.4655 72.931C35.18 72.931 34.1379 71.889 34.1379 70.6035C34.1379 69.3179 35.18 68.2759 36.4655 68.2759C37.751 68.2759 38.7931 69.3179 38.7931 70.6035ZM36.4655 21.7241C37.751 21.7241 38.7931 20.6821 38.7931 19.3966C38.7931 18.111 37.751 17.069 36.4655 17.069C35.18 17.069 34.1379 18.111 34.1379 19.3966C34.1379 20.6821 35.18 21.7241 36.4655 21.7241ZM38.7931 53.5345C38.7931 54.82 37.751 55.8621 36.4655 55.8621C35.18 55.8621 34.1379 54.82 34.1379 53.5345C34.1379 52.249 35.18 51.2069 36.4655 51.2069C37.751 51.2069 38.7931 52.249 38.7931 53.5345ZM36.4655 90C37.751 90 38.7931 88.958 38.7931 87.6724C38.7931 86.3868 37.751 85.3448 36.4655 85.3448C35.18 85.3448 34.1379 86.3868 34.1379 87.6724C34.1379 88.958 35.18 90 36.4655 90ZM21.7241 2.32759C21.7241 3.61307 20.6821 4.65517 19.3966 4.65517C18.111 4.65517 17.069 3.61307 17.069 2.32759C17.069 1.0421 18.111 0 19.3966 0C20.6821 0 21.7241 1.0421 21.7241 2.32759ZM19.3966 38.7931C20.6821 38.7931 21.7241 37.751 21.7241 36.4655C21.7241 35.18 20.6821 34.1379 19.3966 34.1379C18.111 34.1379 17.069 35.18 17.069 36.4655C17.069 37.751 18.111 38.7931 19.3966 38.7931ZM21.7241 70.6035C21.7241 71.889 20.6821 72.931 19.3966 72.931C18.111 72.931 17.069 71.889 17.069 70.6035C17.069 69.3179 18.111 68.2759 19.3966 68.2759C20.6821 68.2759 21.7241 69.3179 21.7241 70.6035ZM19.3966 21.7241C20.6821 21.7241 21.7241 20.6821 21.7241 19.3966C21.7241 18.111 20.6821 17.069 19.3966 17.069C18.111 17.069 17.069 18.111 17.069 19.3966C17.069 20.6821 18.111 21.7241 19.3966 21.7241ZM21.7241 53.5345C21.7241 54.82 20.6821 55.8621 19.3966 55.8621C18.111 55.8621 17.069 54.82 17.069 53.5345C17.069 52.249 18.111 51.2069 19.3966 51.2069C20.6821 51.2069 21.7241 52.249 21.7241 53.5345ZM19.3966 90C20.6821 90 21.7241 88.958 21.7241 87.6724C21.7241 86.3868 20.6821 85.3448 19.3966 85.3448C18.111 85.3448 17.069 86.3868 17.069 87.6724C17.069 88.958 18.111 90 19.3966 90ZM90 2.32759C90 3.61307 88.958 4.65517 87.6724 4.65517C86.3868 4.65517 85.3448 3.61307 85.3448 2.32759C85.3448 1.0421 86.3868 0 87.6724 0C88.958 0 90 1.0421 90 2.32759ZM87.6724 38.7931C88.958 38.7931 90 37.751 90 36.4655C90 35.18 88.958 34.1379 87.6724 34.1379C86.3868 34.1379 85.3448 35.18 85.3448 36.4655C85.3448 37.751 86.3868 38.7931 87.6724 38.7931ZM90 70.6035C90 71.889 88.958 72.931 87.6724 72.931C86.3868 72.931 85.3448 71.889 85.3448 70.6035C85.3448 69.3179 86.3868 68.2759 87.6724 68.2759C88.958 68.2759 90 69.3179 90 70.6035ZM87.6724 21.7241C88.958 21.7241 90 20.6821 90 19.3966C90 18.111 88.958 17.069 87.6724 17.069C86.3868 17.069 85.3448 18.111 85.3448 19.3966C85.3448 20.6821 86.3868 21.7241 87.6724 21.7241ZM90 53.5345C90 54.82 88.958 55.8621 87.6724 55.8621C86.3868 55.8621 85.3448 54.82 85.3448 53.5345C85.3448 52.249 86.3868 51.2069 87.6724 51.2069C88.958 51.2069 90 52.249 90 53.5345ZM87.6724 90C88.958 90 90 88.958 90 87.6724C90 86.3868 88.958 85.3448 87.6724 85.3448C86.3868 85.3448 85.3448 86.3868 85.3448 87.6724C85.3448 88.958 86.3868 90 87.6724 90ZM55.8621 2.32759C55.8621 3.61307 54.82 4.65517 53.5345 4.65517C52.249 4.65517 51.2069 3.61307 51.2069 2.32759C51.2069 1.0421 52.249 0 53.5345 0C54.82 0 55.8621 1.0421 55.8621 2.32759ZM53.5345 38.7931C54.82 38.7931 55.8621 37.751 55.8621 36.4655C55.8621 35.18 54.82 34.1379 53.5345 34.1379C52.249 34.1379 51.2069 35.18 51.2069 36.4655C51.2069 37.751 52.249 38.7931 53.5345 38.7931ZM55.8621 70.6035C55.8621 71.889 54.82 72.931 53.5345 72.931C52.249 72.931 51.2069 71.889 51.2069 70.6035C51.2069 69.3179 52.249 68.2759 53.5345 68.2759C54.82 68.2759 55.8621 69.3179 55.8621 70.6035ZM53.5345 21.7241C54.82 21.7241 55.8621 20.6821 55.8621 19.3966C55.8621 18.111 54.82 17.069 53.5345 17.069C52.249 17.069 51.2069 18.111 51.2069 19.3966C51.2069 20.6821 52.249 21.7241 53.5345 21.7241ZM55.8621 53.5345C55.8621 54.82 54.82 55.8621 53.5345 55.8621C52.249 55.8621 51.2069 54.82 51.2069 53.5345C51.2069 52.249 52.249 51.2069 53.5345 51.2069C54.82 51.2069 55.8621 52.249 55.8621 53.5345ZM53.5345 90C54.82 90 55.8621 88.958 55.8621 87.6724C55.8621 86.3868 54.82 85.3448 53.5345 85.3448C52.249 85.3448 51.2069 86.3868 51.2069 87.6724C51.2069 88.958 52.249 90 53.5345 90Z" fill="#99D3FF"></path>
        </svg>

      </span>
    </div>
  </div>
</section>
  @endsection