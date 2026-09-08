@extends('theme.perfectwriter.header')
@section('title')@if( ! empty($title)){{$title}} |@endif @parent @endsection
@section('description') @if( ! empty(get_option(site_id().'_show_14_meta'))){{ substr(trim(preg_replace('/\s\s+/', ' ',strip_tags(get_option(site_id().'_show_14_meta')))),0,160) }}@endif @endsection
@section('content')

<link rel="preload stylesheet" as="style" href="{{ asset('perfectwriter/new-land/css/reviews.css')}}">


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

<!-- <div class="sticky-new-m float-left w-10">

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

</div>
 -->

<script>
  setTimeout(function () {
    console.log("working");
    $('.second-span').addClass('blink');
  } ,10000)
</script><link rel="stylesheet" href="{{ asset('perfectwriter/new-land/css/reviews.css')}}">
<section class="pricingPage reviews">
  <div class="container">
    <div class="navPagesWrapper">
      <div class="pricingWraper">
        <div class="pricingContent">
          <h1>Reviews</h1>

          <div class="reviewWraper">

            @if($reviews->count()>0)
            @foreach($reviews as $rate)
            <?php 
            $ratings_count = \App\Models\Review_rating::whereWriterId($rate->id)->count();

            $ratings = \App\Models\Review_rating::whereWriterId($rate->id)->orderBy('id', 'desc')->paginate(20);
            $order = \App\Models\Order::find($rate->order_id); 
            $order_count = \App\Models\Order::whereId($rate->order_id)->count(); 
            ?> 

            @if($order_count > 0)
            <?php  
            $writer = \App\Models\User::find($rate->writer_id);
            $writer_count = \App\Models\User::whereId($rate->writer_id)->count();

            ?>  
            <div class="reviewBox">
              <div class="user__info">

                <div class="user-desc">
                  <p class="user-name">{{ $writer->nickname ?? 'none' }}</p>
                  <p class="user-city">{!! $rate->created_at->diffForHumans() !!}</p>
                </div>
                
                <svg width="99" height="19" viewbox="0 0 99 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9.66699 0.625L11.6876 6.84385H18.2265L12.9364 10.6873L14.9571 16.9062L9.66699 13.0627L4.37692 16.9062L6.39755 10.6873L1.10748 6.84385H7.64637L9.66699 0.625Z" fill="#2D96EE"></path>
                  <path d="M29.667 0.625L31.6876 6.84385H38.2265L32.9364 10.6873L34.9571 16.9062L29.667 13.0627L24.3769 16.9062L26.3976 10.6873L21.1075 6.84385H27.6464L29.667 0.625Z" fill="#2D96EE"></path>
                  <path d="M49.667 0.625L51.6876 6.84385H58.2265L52.9364 10.6873L54.9571 16.9062L49.667 13.0627L44.3769 16.9062L46.3976 10.6873L41.1075 6.84385H47.6464L49.667 0.625Z" fill="#2D96EE"></path>
                  <path d="M69.667 0.625L71.6876 6.84385H78.2265L72.9364 10.6873L74.9571 16.9062L69.667 13.0627L64.3769 16.9062L66.3976 10.6873L61.1075 6.84385H67.6464L69.667 0.625Z" fill="#2D96EE"></path>
                  <path d="M89.667 0.625L91.6876 6.84385H98.2265L92.9364 10.6873L94.9571 16.9062L89.667 13.0627L84.3769 16.9062L86.3976 10.6873L81.1075 6.84385H87.6464L89.667 0.625Z" fill="#2D96EE"></path>
                </svg>
              </div>
              <p class="rev-title">{{ $order->title }}</p>
              <p class="rev-desc">  {{ $rate->comments }}</p>
            </div>

            @endif


            @endforeach
            @else
            <tr>No order reviews</tr>
            @endif
          </div>

        </div>
      </div>

    </div>
  </div>
</section>





@endsection