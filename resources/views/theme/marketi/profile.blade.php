@extends('theme.marketi.header')
@section('title')@if( ! empty($title)){{$title}} |@endif @parent @endsection

@section('description') @if( ! empty($user->about)){{ substr(trim(preg_replace('/\s\s+/', ' ',strip_tags($user->about) )),0,160) }}@endif  @endsection
@section('content')
<link rel="stylesheet" href="{{ asset('perfectwriter/new-land/css/mpw-writers-bio.css')}}">


<?php
$w_count = \App\Models\Order::whereWriterId($user->id)->where('plagiarism_score', '>', '0')->whereStatus(5)->count();
$w_count_plagiarism = \App\Models\Order::whereWriterId($user->id)->whereStatus(5)->where('plagiarism_score', '>', '0')->sum('plagiarism_score');
if ($w_count>0) {
  $p_score = $w_count_plagiarism/$w_count;
}
else{

   $p_score = '0';
}





$o_count = \App\Models\Order::whereWriterId($user->id)->count();

$o_progress = \App\Models\Order::whereStatus(2)->distinct('writer_id')->count();

?>  

<?php
$count_star_rating = \App\Models\Review_rating::whereWriterId($user->id)->count();
$sum_star_rating = \App\Models\Review_rating::whereWriterId($user->id)->sum('star_rating');
if ($count_star_rating!=0) {
   $star_rating = $sum_star_rating/$count_star_rating*100;
} else{
    $star_rating = 0;
}

?>

<section class="writerBio">
    <div class="container">
        <div class="writerBioWrapper">
            <div class="aboutWriterWrapper">
                <div class="aboutWriterHead">
                    <div class="writerImage">
                        <img src="{{ $user->get_gravatar(150) }}" alt="Caleb S">
                    </div>
                    <h3>{{ $user->nickname }} (Id: {{ $user->id }})</h3>
                    <div class="rating">
                        <p>{{ number_format((float)$star_rating, 2, '.', '')  }}%</p>
                        <svg width="81" height="13" viewbox="0 0 81 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.91991 0.251285C7.84306 0.097415 7.68445 0 7.51079 0C7.33713 0 7.17852 0.097415 7.10167 0.251285L5.23394 3.99054L1.05792 4.58972C0.886053 4.61438 0.74326 4.73331 0.689586 4.89651C0.635911 5.0597 0.680664 5.23885 0.805027 5.35863L3.82692 8.26907L3.11335 12.3791C3.08399 12.5482 3.15435 12.7192 3.29485 12.82C3.43535 12.9209 3.62162 12.9342 3.77533 12.8543L7.51079 10.9138L11.2462 12.8543C11.4 12.9342 11.5862 12.9209 11.7267 12.82C11.8672 12.7192 11.9376 12.5482 11.9082 12.3791L11.1947 8.26907L14.2166 5.35863C14.3409 5.23885 14.3857 5.0597 14.332 4.89651C14.2783 4.73331 14.1355 4.61438 13.9637 4.58972L9.78763 3.99054L7.91991 0.251285Z" fill="#117BD4"></path>
                            <path d="M24.3923 0.251285C24.3155 0.097415 24.1569 0 23.9832 0C23.8095 0 23.6509 0.097415 23.5741 0.251285L21.7064 3.99054L17.5303 4.58972C17.3585 4.61438 17.2157 4.73331 17.162 4.89651C17.1083 5.0597 17.1531 5.23885 17.2774 5.35863L20.2993 8.26907L19.5858 12.3791C19.5564 12.5482 19.6268 12.7192 19.7673 12.82C19.9078 12.9209 20.094 12.9342 20.2477 12.8543L23.9832 10.9138L27.7187 12.8543C27.8724 12.9342 28.0586 12.9209 28.1991 12.82C28.3396 12.7192 28.41 12.5482 28.3806 12.3791L27.6671 8.26907L30.689 5.35863C30.8133 5.23885 30.8581 5.0597 30.8044 4.89651C30.7507 4.73331 30.6079 4.61438 30.4361 4.58972L26.26 3.99054L24.3923 0.251285Z" fill="#117BD4"></path>
                            <path d="M40.8647 0.251285C40.7879 0.097415 40.6293 0 40.4556 0C40.2819 0 40.1233 0.097415 40.0465 0.251285L38.1788 3.99054L34.0027 4.58972C33.8309 4.61438 33.6881 4.73331 33.6344 4.89651C33.5807 5.0597 33.6255 5.23885 33.7499 5.35863L36.7717 8.26907L36.0582 12.3791C36.0288 12.5482 36.0992 12.7192 36.2397 12.82C36.3802 12.9209 36.5664 12.9342 36.7202 12.8543L40.4556 10.9138L44.1911 12.8543C44.3448 12.9342 44.5311 12.9209 44.6716 12.82C44.8121 12.7192 44.8824 12.5482 44.8531 12.3791L44.1395 8.26907L47.1614 5.35863C47.2857 5.23885 47.3305 5.0597 47.2768 4.89651C47.2231 4.73331 47.0803 4.61438 46.9085 4.58972L42.7325 3.99054L40.8647 0.251285Z" fill="#117BD4"></path>
                            <path d="M57.3374 0.251285C57.2605 0.097415 57.1019 0 56.9283 0C56.7546 0 56.596 0.097415 56.5191 0.251285L54.6514 3.99054L50.4754 4.58972C50.3035 4.61438 50.1607 4.73331 50.1071 4.89651C50.0534 5.0597 50.0981 5.23885 50.2225 5.35863L53.2444 8.26907L52.5308 12.3791C52.5015 12.5482 52.5718 12.7192 52.7123 12.82C52.8528 12.9209 53.0391 12.9342 53.1928 12.8543L56.9283 10.9138L60.6637 12.8543C60.8174 12.9342 61.0037 12.9209 61.1442 12.82C61.2847 12.7192 61.3551 12.5482 61.3257 12.3791L60.6121 8.26907L63.634 5.35863C63.7584 5.23885 63.8031 5.0597 63.7495 4.89651C63.6958 4.73331 63.553 4.61438 63.3811 4.58972L59.2051 3.99054L57.3374 0.251285Z" fill="#117BD4"></path>
                            <path d="M73.8099 0.251285C73.7331 0.097415 73.5745 0 73.4008 0C73.2271 0 73.0685 0.097415 72.9917 0.251285L71.124 3.99054L66.9479 4.58972C66.7761 4.61438 66.6333 4.73331 66.5796 4.89651C66.5259 5.0597 66.5707 5.23885 66.695 5.35863L69.7169 8.26907L69.0034 12.3791C68.974 12.5482 69.0444 12.7192 69.1849 12.82C69.3254 12.9209 69.5116 12.9342 69.6653 12.8543L73.4008 10.9138L77.1363 12.8543C77.29 12.9342 77.4762 12.9209 77.6167 12.82C77.7572 12.7192 77.8276 12.5482 77.7982 12.3791L77.0847 8.26907L80.1066 5.35863C80.2309 5.23885 80.2757 5.0597 80.222 4.89651C80.1683 4.73331 80.0255 4.61438 79.8537 4.58972L75.6776 3.99054L73.8099 0.251285Z" fill="#E3E3E3"></path>
                            <g clip-path="url(#clip0_1171_5743)">
                                <path d="M73.8317 0.253113C73.7548 0.0981237 73.5962 0 73.4225 0C73.2489 0 73.0903 0.0981237 73.0134 0.253113L71.1457 4.01957L66.9697 4.62311C66.7978 4.64795 66.655 4.76775 66.6013 4.93213C66.5477 5.09651 66.5924 5.27697 66.7168 5.39761L69.7387 8.32922L69.0251 12.4692C68.9957 12.6395 69.0661 12.8117 69.2066 12.9133C69.3471 13.0149 69.5334 13.0283 69.6871 12.9478L73.4225 10.9932L77.158 12.9478C77.3117 13.0283 77.498 13.0149 77.6385 12.9133C77.779 12.8117 77.8493 12.6395 77.82 12.4692L77.1064 8.32922L80.1283 5.39761C80.2527 5.27697 80.2974 5.09651 80.2437 4.93213C80.1901 4.76775 80.0473 4.64795 79.8754 4.62311L75.6994 4.01957L73.8317 0.253113Z" fill="#117BD4"></path>
                            </g>
                            <defs>
                                <clippath id="clip0_1171_5743">
                                    <rect width="12" height="13" fill="white" transform="translate(66.1222)"></rect>
                                </clippath>
                            </defs>
                        </svg>
                    </div>

                    <?php 
                    $ratings_count = \App\Models\Review_rating::whereWriterId($user->id)->count();

                    $ratings = \App\Models\Review_rating::whereWriterId($user->id)->orderBy('id', 'desc')->paginate(10, ['*'], 'client');
                    ?> 


                    <p class="totalReviews">({{ $ratings_count }} Reviews)</p>
                </div>
                <div class="aboutWriterFoot">
                    <div class="totalOrders">
                        <span>Total orders</span>
                        <span>{{ writertotals($user->id) }}</span>
                    </div>
                    <a class="hireWriter" rel="nofollow" href="{{ route('request_writer', ['writer_id' => $user->id ])}}">Hire Writer</a>
                </div>
            </div>
            <div class="writerInfoWrapper">
                <h1>Writer’s Bio</h1>
                <p class="desc"> {{ $user->about }}</p>

                <div class="ordersBYSubject">
                    <h2>Orders by Subject</h2>
                    <div class="ordersHistory">
                        <ul>


                                          <?php 
$worders = \App\Models\Order::whereWriterId($user->id)->select('category_id')->distinct()->get(); 
?>  
                         @if($worders->count()>0)    
                         
                         @foreach($worders as $subject)                                                 
 <?php 
 $worder_count = \App\Models\Order::whereWriterId($user->id)->whereCategoryId($subject->category_id)->count(); 
?>
                         <li>
                            <span>{{ subject($subject->category_id) }}</span>
                            <span>{{ $worder_count }}</span>
                            <span class="filled" style="width:10.085%"></span>
                        </li>
                        @endforeach




                        @else
                        No subject selected
                        @endif





                    </ul>
                </div>
            </div>

            <div class="ordersByType">
                <h2>Orders by Type</h2>
                <div class="ordersHistory">
                    <ul>


                       <?php 
$worders = \App\Models\Order::whereWriterId($user->id)->select('paper_id')->distinct()->get(); 
?>  
                         @if($worders->count()>0)    
                         
                         @foreach($worders as $subject)                                                 

                         <?php 


                         $worder_count = \App\Models\Order::whereWriterId($user->id)->wherePaperId($subject->paper_id)->count(); 
                         ?>

                         @if($worder_count>0)
                         <li>
                            <span>{{ paper($subject->paper_id) }}</span>
                            <span>{{ $worder_count }}</span>
                            <span class="filled" style="width:4.876%"></span>
                        </li>
                        @endif
                        @endforeach




                        @else
                        No subject selected
                        @endif


                      

                    </ul>
                </div>
            </div>
<?php 
$ratings_count = \App\Models\Review_rating::whereWriterId($user->id)->count();

$ratings = \App\Models\Review_rating::whereWriterId($user->id)->orderBy('id', 'desc')->paginate(10, ['*'], 'client');
?> 
            <div class="customerReviews">
                <h2>Customers Reviews ({{ $ratings_count }})</h2>
                <div class="customReviewsWrapper">

    @if($ratings->count()>0)





    @foreach($ratings as $rate)


    <?php 
        $order = \App\Models\Order::find($rate->order_id);
        $order_count = \App\Models\Order::whereId($rate->order_id)->count(); 
        ?> 
        @if($order_count > 0)

                    <div class="reviewCard">
                        <p class="cust_id">Customer ID: {{ $rate->user_id }}</p>
                        <svg width="97" height="16" viewbox="0 0 97 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.76139 0.309696C8.66855 0.120059 8.47695 0 8.26716 0C8.05737 0 7.86577 0.120059 7.77293 0.309696L5.51668 4.91813L0.471954 5.65659C0.264335 5.68699 0.0918388 5.83356 0.0269988 6.03469C-0.0378413 6.23582 0.0162214 6.45661 0.166454 6.60423L3.81696 10.1912L2.95496 15.2566C2.91949 15.465 3.00449 15.6757 3.17421 15.8C3.34394 15.9243 3.56896 15.9407 3.75465 15.8423L8.26716 13.4507L12.7797 15.8423C12.9654 15.9407 13.1904 15.9243 13.3601 15.8C13.5298 15.6757 13.6148 15.465 13.5794 15.2566L12.7174 10.1912L16.3679 6.60423C16.5181 6.45661 16.5722 6.23582 16.5073 6.03469C16.4425 5.83356 16.27 5.68699 16.0624 5.65659L11.0176 4.91813L8.76139 0.309696Z" fill="#117BD4"></path>
                            <path d="M28.6604 0.309696C28.5676 0.120059 28.376 0 28.1662 0C27.9564 0 27.7648 0.120059 27.672 0.309696L25.4157 4.91813L20.371 5.65659C20.1634 5.68699 19.9909 5.83356 19.926 6.03469C19.8612 6.23582 19.9153 6.45661 20.0655 6.60423L23.716 10.1912L22.854 15.2566C22.8185 15.465 22.9035 15.6757 23.0733 15.8C23.243 15.9243 23.468 15.9407 23.6537 15.8423L28.1662 13.4507L32.6787 15.8423C32.8644 15.9407 33.0894 15.9243 33.2592 15.8C33.4289 15.6757 33.5139 15.465 33.4784 15.2566L32.6164 10.1912L36.2669 6.60423C36.4171 6.45661 36.4712 6.23582 36.4064 6.03469C36.3415 5.83356 36.169 5.68699 35.9614 5.65659L30.9167 4.91813L28.6604 0.309696Z" fill="#117BD4"></path>
                            <path d="M48.5595 0.309696C48.4666 0.120059 48.275 0 48.0653 0C47.8555 0 47.6639 0.120059 47.571 0.309696L45.3148 4.91813L40.27 5.65659C40.0624 5.68699 39.8899 5.83356 39.8251 6.03469C39.7603 6.23582 39.8143 6.45661 39.9645 6.60423L43.6151 10.1912L42.7531 15.2566C42.7176 15.465 42.8026 15.6757 42.9723 15.8C43.142 15.9243 43.3671 15.9407 43.5527 15.8423L48.0653 13.4507L52.5778 15.8423C52.7635 15.9407 52.9885 15.9243 53.1582 15.8C53.3279 15.6757 53.4129 15.465 53.3775 15.2566L52.5155 10.1912L56.166 6.60423C56.3162 6.45661 56.3703 6.23582 56.3054 6.03469C56.2406 5.83356 56.0681 5.68699 55.8605 5.65659L50.8157 4.91813L48.5595 0.309696Z" fill="#117BD4"></path>
                            <path d="M68.4589 0.309696C68.3661 0.120059 68.1745 0 67.9647 0C67.7549 0 67.5633 0.120059 67.4704 0.309696L65.2142 4.91813L60.1695 5.65659C59.9618 5.68699 59.7893 5.83356 59.7245 6.03469C59.6597 6.23582 59.7137 6.45661 59.864 6.60423L63.5145 10.1912L62.6525 15.2566C62.617 15.465 62.702 15.6757 62.8717 15.8C63.0414 15.9243 63.2665 15.9407 63.4522 15.8423L67.9647 13.4507L72.4772 15.8423C72.6629 15.9407 72.8879 15.9243 73.0576 15.8C73.2273 15.6757 73.3123 15.465 73.2769 15.2566L72.4149 10.1912L76.0654 6.60423C76.2156 6.45661 76.2697 6.23582 76.2048 6.03469C76.14 5.83356 75.9675 5.68699 75.7599 5.65659L70.7151 4.91813L68.4589 0.309696Z" fill="#117BD4"></path>
                            <path d="M88.3579 0.309696C88.2651 0.120059 88.0735 0 87.8637 0C87.6539 0 87.4623 0.120059 87.3695 0.309696L85.1132 4.91813L80.0685 5.65659C79.8609 5.68699 79.6884 5.83356 79.6236 6.03469C79.5587 6.23582 79.6128 6.45661 79.763 6.60423L83.4135 10.1912L82.5515 15.2566C82.516 15.465 82.601 15.6757 82.7708 15.8C82.9405 15.9243 83.1655 15.9407 83.3512 15.8423L87.8637 13.4507L92.3762 15.8423C92.5619 15.9407 92.7869 15.9243 92.9567 15.8C93.1264 15.6757 93.2114 15.465 93.1759 15.2566L92.3139 10.1912L95.9644 6.60423C96.1147 6.45661 96.1687 6.23582 96.1039 6.03469C96.039 5.83356 95.8665 5.68699 95.6589 5.65659L90.6142 4.91813L88.3579 0.309696Z" fill="#117BD4"></path>
                        </svg>
                        <p class="category">{{ $rate->comments }}</p>
                        <p class="date">{!! $rate->created_at->diffForHumans() !!}</p>
                    </div>

                            @endif  


                      @endforeach

    @else
    <tr>No order reviews</tr>
    @endif


                </div>
                <button id="loadReviews" class="showReviews">Show More</button>
            </div>
        </div>
    </div>
</div>
</section>


  @endsection