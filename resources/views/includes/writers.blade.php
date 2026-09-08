<!-- Script --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<div class="row">
  <span class="landing-title"></span>
  <h1 class="fw-semibold text-center">{{ domain_name() }} 's Top {{ get_option(site_id().'_expert_name') }}s</h1>

  <p class="text-default mb-5 text-center">All {{ get_option(site_id().'_expert_name') }}s who apply to work with us pass our strict review policy. Detailed document check, only after these steps {{ get_option(site_id().'_expert_name') }} gets an opportunity to work with your task. And even after this, our Quality Control constatly check our {{ get_option(site_id().'_expert_name') }}s to keep our quality high. </p>
</div>




<?php
$w_count = \App\Models\User::whereUserType('writer')->whereAccountStatus(1)->count();
?>

<?php
$w_count = \App\Models\User::whereUserType('writer')->whereAccountStatus(1)->count();
$o_count = \App\Models\Order::count();
$o_progress = \App\Models\Order::whereStatus(2)->distinct('writer_id')->count();
?>                        
<div class="row">
 <!-- COL END -->
 <div class="col-sm-6 col-lg-6 col-md-12 col-xl-3">
  <div class="card">
    <div class="row">
      <div class="col-4">
        <div class="card-img-absolute circle-icon bg-primary text-center align-self-center box-primary-shadow bradius">
          <img src="{{ asset('assets/images/svgs/circle.svg')}}" alt="img" class="card-img-absolute">
          <i class="lnr lnr-user fs-30  text-white mt-4"></i>
        </div>
      </div>
      <div class="col-8">
        <div class="card-body p-4">
          <h2 class="mb-2 fw-normal mt-2">{{ $w_count }}</h2>
          <h5 class="fw-normal mb-0">{{ get_option(site_id().'_expert_name') }}s active</h5>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- COL END -->
<div class="col-sm-6 col-lg-6 col-md-12 col-xl-3">
  <div class="card">
    <div class="row">
      <div class="col-4">
        <div class="card-img-absolute circle-icon bg-secondary align-items-center text-center box-secondary-shadow bradius">
          <img src="{{ asset('assets/images/svgs/circle.svg')}}" alt="img" class="card-img-absolute">
          <i class="lnr lnr-users fs-30  text-white mt-4"></i>
        </div>
      </div>
      <div class="col-8">
        <div class="card-body p-4">
          <h2 class="mb-2 fw-normal mt-2">{{ $w_count-$o_progress }}</h2>
          <h5 class="fw-normal mb-0">Online now</h5>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- COL END -->
<div class="col-sm-6 col-lg-6 col-md-12 col-xl-3">
  <div class="card">
    <div class="row">
      <div class="col-4">
        <div class="card-img-absolute  circle-icon bg-success align-items-center text-center box-success-shadow bradius">
          <img src="{{ asset('assets/images/svgs/circle.svg')}}" alt="img" class="card-img-absolute">
          <i class="fa fa-star fs-30 text-white mt-4"></i>
        </div>
      </div>
      <div class="col-8">
        <div class="card-body p-4">
          <h2 class="mb-2 fw-normal mt-2">9/10</h2>
          <h5 class="fw-normal mb-0">Average quality score</h5>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- COL END -->
<div class="col-sm-6 col-lg-6 col-md-12 col-xl-3">
  <div class="card">
    <div class="row">
      <div class="col-4">
        <div class="card-img-absolute circle-icon bg-danger align-items-center text-center box-danger-shadow bradius">
          <img src="{{ asset('assets/images/svgs/circle.svg')}}" alt="img" class="card-img-absolute">
          <i class=" lnr lnr-cart fs-30 text-white mt-4"></i>
        </div>
      </div>
      <div class="col-8">
        <div class="card-body p-4">
          <h2 class="mb-2 fw-normal mt-2">{{ $o_count }}</h2>
          <h5 class="fw-normal mb-0">Total Orders</h5>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- COL END -->
</div>
<!-- ROW CLOSED -->
<!-- <h3>All reviews are placed in real-time. No moderation applied. </h3> -->
<!-- ROW-4 -->
<div><br></div>
<div class="row" style="padding-top: 20px;">
  <div class="col-12 col-sm-12">
    <div>
      <div>

        <div class="page-options ms-auto">

          <div class="tab-menu-heading border-0 p-0">
           <div class="tabs-menu1">
            <!-- Tabs -->
            <ul class="nav panel-tabs product-sale">


             <li>


              <form method='get'  id='myform2' action="{{ route('experts') }}">

               <select name='user' id='lang2' class="form-control" onchange ="calculate(this.form);"> 


                 <option value="0" selected="">Search by username or id </option>

                 <?php

                 $writers = \App\Models\User::whereAccountStatus(1)->whereUserType('writer')->orderBy('id', 'desc')->get();

                 ?>

                 @foreach($writers as $user)


                 <option value="{{ $user->id }}" selected=""> {{ username($user->id)->nickname ?? 'none' }} (<span >ID:{{ $user->id }}</span> ) 
                 </option>


                 @endforeach
                 
               </select> 
               
             </form>




             <script type='text/javascript'> 
              $(document).ready(function(){
                $('#lang2').change(function(){
                        // Call submit() method on <form id='myform'>
                  $('#myform2').submit();
                });
              });
            </script>




          </li>


          <li>


            <form method='get'  id='myform1' action="{{ route('experts') }}">

             <select name='orders' id='lang' class="form-control" onchange ="calculate(this.form);"> 
               <option value="0" selected="">Filter by approved orders</option>
               <option value="10">10+ orders</option>
               <option value="30">30+ orders</option>
               <option value="50">50+ orders</option>
               <option value="100">100+ orders</option>
               <option value="200">200+ orders</option>
             </select> 
             
           </form>




           <script type='text/javascript'> 
            $(document).ready(function(){
              $('#lang').change(function(){
                        // Call submit() method on <form id='myform'>
                $('#myform1').submit();
              });
            });
          </script>




        </li>


        <li>



          <form method='get'  id='myform' action="{{ route('experts') }}">

           <select name='subject' id='lang1' class="form-control" onchange ="calculate(this.form);"> 
             <option value="0" selected="">Filter by subject</option>
             <option value="1">General</option>
             <?php foreach ($categories as $pptype): ?>
              <option value="<?php echo $pptype['id']; ?>"> <?php echo $pptype['name']; ?>  </option>
            <?php endforeach; ?>
          </select> 
        </form>


        <script type='text/javascript'> 
          $(document).ready(function(){
            $('#lang1').change(function(){
                        // Call submit() method on <form id='myform'>
              $('#myform').submit();
            });
          });
        </script>
      </li>




      
    </ul>
  </div>
</div>



</div>

</div>

<div >
  <div>
    <div class="">
      <div>


        <div>


          @if($worders->count()>0)


          <div class="row">
            <?php 

            $u = 0;
            ?>
            @foreach($worders as $worder)

            @if($worder->writer_id != $u)

            <?php 
            
            $u      = $worder->writer_id;
            
            $writer_count = \App\Models\User::whereId($worder->writer_id)->count();
            if($writer_count > 0){
             $writer = \App\Models\User::find($worder->writer_id);
             $user = \App\Models\User::find($worder->writer_id);
           }



           ?>

           @if($writer_count>0)


           <div class="col-sm-4">



            <div class="card">
              <div class="card-body">
@if($writer->top_ten == 1)
                              <span class="badge bg-primary text-white" style="position: absolute; top: 0; right: 0;">Top</span>
                              @endif

                <div class="row">



                  <div class="col-sm-4">


                    <div class="avatar avatar-xxl chat-profile mb-3 brround pull-right ">
                      <a  href=""> <img alt="avatar" src="{{ $writer->get_gravatar(150) }}" class="brround"> <span class="dot-label bg-success"></span></a>
                    </div>  
                  </div>

                  <div class="col-sm-8">
                    <h4>    
                      <a href="{{ route('profile', $user->slug )}}">
                        {{ username($user->id)->nickname ?? 'none' }} (<span >ID:{{ $user->id }}</span> )
                      </a>
                    </h4>

                    <div>
                      <?php
                      $count_star_rating = \App\Models\Review_rating::whereWriterId($user->id)->count();
                      $sum_star_rating = \App\Models\Review_rating::whereWriterId($user->id)->sum('star_rating');
                      if ($count_star_rating!=0) {
                       $star_rating = $sum_star_rating/$count_star_rating*100;
                     } else{
                      $star_rating = 0;
                    }

                    ?>

                    <a href="javascript:void(0)" class="fw-semibold">Average quality score {{ number_format((float)$star_rating, 2, '.', '')  }}%</a><br>


                    <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
                    <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
                    <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
                    <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
                    <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>


                  </div>

                </div>






                <div class="col-sm-6">
                  <div class="mt-sm-1 d-block">
                    In progress<span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">{{ writer_counter($user->id, 2)}}</span><br>

                    Completed<span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">{{ writer_counter($user->id, 4) }}</span><br>



                  </div>



                </div>

                <div class="col-sm-6">
                  <div class="mt-sm-1 d-block">


                    Approved<span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">
                      {{ writer_counter($user->id, 5) }}</span><br>

                      Cancelled <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">
                        {{ writer_counter($user->id, 7) }}</span><br>


                      </div>



                    </div>

                      <?php 
                     $ratings   = \App\Models\Review_rating::whereWriterId($user->id)->count();
                      $eratings = \App\Models\Order::whereWriterId($user->id)->where('eorder_rating', '!=', '')->count();
                      ?> 

                      

 <!--                    <div class="col-sm-6">
                      <br>
                    
                      <a href="{{ route('profile', $user->slug )}}" class="me-4 d-inline-block"> {{ $ratings }} Client Reviews
                      </a> 

                    </div>

                    <div class="col-sm-6">
                      <br>

                      <a href="/profile/{{ $user->slug }}/#editors-review" style="color: green;" class="me-4 d-inline-block" style=""> {{ $eratings }} Editor Reviews
                      </a> 
                    </div> -->


                    <div class="col-sm-12">
                      <br>
                      <center>
                       <form action="{{ route('request_writer')}}" method="POST"> 
                        @csrf
                        <input type="hidden" name="writer_id" value="{{ $user->id }}">

                        <button
                        class="btn ripple btn-min w-sm btn-outline-primary me-2 my-auto d-lg-none d-xl-block d-block">
                        <span class="ms-4 me-4">Request {{ get_option(site_id().'_expert_name') }}</span>
                      </button>
                    </form>
                  </center>


                </div>

              </div>





            </div>
          </div>
        </div>



        @endif
        @endif
        @endforeach
      </div>


    </div>


    <div class="row">
     <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
       <div class="card p-3 pricing-card reveal revealrotate">
        <div class="card-body">
          {!! get_option(site_id().'_show_6_content') !!}  
        </div>
      </div>
    </div>

  </div>




  @else
  <tr>No expert available</tr>
  @endif
</div>

</div>
</div>
</div>
</div>
</div>
</div>

</div>


