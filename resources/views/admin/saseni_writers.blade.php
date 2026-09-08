@extends('layouts.appbar')



@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
 <div class="side-app">

   <!-- CONTAINER -->
   <div class="main-container container-fluid">




<!-- Script --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<div class="row">
  <span class="landing-title"></span>
  <h2 class="fw-semibold text-center">Writers who have worked on my previous orders</h2>

</div>

@if(get_option(site_id().'_enable_dc') == 1)


                     

<!-- ROW CLOSED -->
<!-- <h3>All reviews are placed in real-time. No moderation applied. </h3> -->
<!-- ROW-4 -->
<div><br></div>
<div class="row" style="padding-top: 20px;">
  <div class="col-12 col-sm-12">
    <div class="card">
      <div class="card-header">

        <div class="page-options ms-auto">

          <div class="tab-menu-heading border-0 p-0">
           <div class="tabs-menu1">
            <!-- Tabs -->
            <ul class="nav panel-tabs product-sale">


             <li>

  <form style="display: none;" id="form" action="" method="post">
                                  <select  class="form-control select2 w-100" onchange ="calculate(this.form);">
                                    <option>Select Building</option>
                                  


                                </select>

                            </form>


              <form method='get'  id='myform2' action="{{ route('my_writers') }}">

               <select name='user' id='lang2' class="form-control" onchange ="calculate(this.form);"> 
                 <option value="0" selected="">Search by username or id </option>

                 @foreach($worders as $worder)

                 <?php 
                 $user = \App\Models\User::find($worder->writer_id);
                 $user_count = \App\Models\User::whereId($worder->writer_id)->count();

                 ?>
@if( $user_count > 0)
                 <option value="{{ $user->id }}" selected=""> {{ username($user->id)->nickname ?? 'none' }} (<span >ID:{{ $user->id }}</span> ) </option>
@endif

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


            <form method='get'  id='myform1' action="{{ route('my_writers') }}">

             <select name='orders' id='lang' class="form-control" onchange ="calculate(this.form);"> 
               <option value="0" selected="">Filter by approved orders</option>
               <option value="10">10+ orders</option>
               <option value="30">30+ orders</option>
               <option value="50">50+ orders</option>
               <option value="100">100+ orders</option>
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



          <form method='get'  id='myform' action="{{ route('my_writers') }}">

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

<div class="card-body pt-4">
  <div class="grid-margin">
    <div class="">
      <div class="panel panel-primary">
        <div class="tab-menu-heading border-0 p-0">
          <div class="tabs-menu1">

          </div>
        </div>

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
            $writer = \App\Models\User::find($worder->writer_id);
            $writer_count = \App\Models\User::whereId($worder->writer_id)->count();
            $user = \App\Models\User::find($worder->writer_id);

            ?>

            @if($writer_count>0)



            <div class="col-sm-1">


              <div class="avatar avatar-xxl chat-profile mb-3 brround pull-right ">
                <a  href=""> <img alt="avatar" src="{{ $writer->get_gravatar(150) }}" class="brround"> <span class="dot-label bg-success"></span></a>

              </div>
              







            </div>

            <div class="col-sm-3">
              <h3>    
                <a href="{{ route('profile', $user->slug )}}">
                  {{ username($user->id)->nickname ?? 'none' }} (<span >ID:{{ $user->id }}</span> )
                </a>
              </h3>

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





          <div class="col-sm-3">
            <div class="mt-sm-1 d-block">
              In progress orders<span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">{{ writer_counter($user->id, 2)}}</span><br>

              Completed orders<span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">{{ writer_counter($user->id, 4) }}</span><br>

              Approved orders<span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">
                {{ writer_counter($user->id, 5) }}</span><br>


              </div>



            </div>

            <div class="col-sm-2">
              <br>
              <?php 

              $ratings   = \App\Models\Review_rating::whereWriterId($user->id)->count();
              $eratings = \App\Models\Order::whereWriterId($user->id)->where('eorder_rating', '!=', '')->count();
$myorders = \App\Models\Order::whereWriterId($user->id)->whereUserId(Auth::user()->id)->count();
              ?> 

               <a href="{{ route('order', ['writer' => $user->id] )}}" style="color: green;" class="me-4 d-inline-block"> {{ $myorders }} of my orders done
              </a>


              <a href="{{ route('profile', $user->slug )}}" class="me-4 d-inline-block"> {{ $ratings }} Client Reviews
              </a> 
              <a href="/profile/{{ $user->slug }}/#editors-review" style="color: green;" class="me-4 d-inline-block" style=""> {{ $eratings }} Editor Reviews
              </a> 
            </div>


            <div class="col-sm-2">
              <br>
              <form action="{{ route('request_writer')}}" method="POST"> 
                @csrf
                <input type="hidden" name="writer_id" value="{{ $user->id }}">

                <button
                class="btn ripple btn-min w-sm btn-outline-primary me-2 my-auto d-lg-none d-xl-block d-block">
                <span class="ms-4 me-4">Request Writer</span>
              </button>
            </form>

          </div>



          <hr style="border-top: 1px solid #000000;">

          @endif
          @endif
          @endforeach



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

@endif

@if(get_option(site_id().'_enable_dc') == 0)
<div class="row">
  <?php 
  $u = 0;

  $json = file_get_contents('https://saseni.com/api/v1/experts');

  ?>
  @foreach(json_decode($json, true) as $user)




  <div class="col-sm-1">


    <div class="avatar avatar-xxl chat-profile mb-3 brround pull-right ">
      <a  href=""> <img alt="avatar" src="https://saseni.com/storage/uploads/avatar/{{ $user['photo']}}" class="brround"> <span class="dot-label bg-success"></span></a>

    </div>







  </div>

  <div class="col-sm-3">
    <h3>    
      <a href="{{ route('profile', userslug($user['id']) )}}">
        {{ $user['nickname'] }} (<span >ID:{{ $user['id'] }}</span> )
      </a>
    </h3>



  </div>


  <div class="col-sm-2">
    <br>
    <form action="{{ route('request_writer')}}" method="POST"> 
      @csrf
      <input type="hidden" name="writer_id" value="{{ $user['id'] }}">

      <button
      class="btn ripple btn-min w-sm btn-outline-primary me-2 my-auto d-lg-none d-xl-block d-block">
      <span class="ms-4 me-4">Request Writer</span>
    </button>
  </form>

</div>



<hr style="border-top: 1px solid #000000;">


@endforeach



</div>
@endif



</div>
</div>
</div>





@endsection