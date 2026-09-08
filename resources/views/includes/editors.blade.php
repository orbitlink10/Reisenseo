<!-- Script --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<div class="row">
  <span class="landing-title"></span>
  <h1 class="fw-semibold text-center">{{ domain_name() }} 's Editors</h1>

  <p class="text-default mb-5 text-center">Looking to hire an assignment editor? Saseni.com offers a vast selection of talented assignment editors to meet your specific needs. Follow this step-by-step guide to find and hire the perfect editor for your project, ensuring a smooth and successful collaboration.</p>
</div>




                        





	

<div class="row" style="padding-top: 20px;">
  <div class="col-12 col-sm-12">
    <div>
     

<div >
  <div>
    <div class="">
      <div>


        <div>


          @if($users->count()>0)


          <div class="row">


            @foreach($users as $user)




   

 
    <div class="col-sm-4">

            <div class="card">
              <div class="card-body">
                <div class="row">



                  <div class="col-sm-4">


                    <div class="avatar avatar-xxl chat-profile mb-3 brround pull-right ">
                      <a  href=""> <img alt="avatar" src="{{ $user->get_gravatar(150) }}" class="brround"> <span class="dot-label bg-success"></span></a>
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
                    In progress<span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">{{ editor_counter($user->id, 3)}}</span><br>

                    Completed<span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">{{ editor_counter($user->id, 4) }}</span><br>



                    </div>



                  </div>

                      <div class="col-sm-6">
                  <div class="mt-sm-1 d-block">
        

                    Approved<span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">
                      {{ editor_counter($user->id, 5) }}</span><br>

                           Cancelled <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">
                      {{ editor_counter($user->id, 7) }}</span><br>


                    </div>



                  </div>

                  <div class="col-sm-6">
                    <br>
                    <?php 
                    $ratings   = \App\Models\Review_rating::whereWriterId($user->id)->count();
                    $eratings = \App\Models\Order::whereWriterId($user->id)->where('eorder_rating', '!=', '')->count();
                    ?> 
                    <a href="{{ route('profile', $user->slug )}}" class="me-4 d-inline-block"> {{ $ratings }} Client Reviews
                    </a> 
                   
                  </div>

                       <div class="col-sm-6">
                    <br>
                  
                    <a href="/profile/{{ $user->slug }}/#editors-review" style="color: green;" class="me-4 d-inline-block" style=""> {{ $eratings }} Editor Reviews
                    </a> 
                  </div>


                  <div class="col-sm-12">
                    <br>
                    <center>
                       <form action="{{ route('request_writer')}}" method="POST"> 
                      @csrf
                      <input type="hidden" name="writer_id" value="{{ $user->id }}">

                      <button
                      class="btn ripple btn-min w-sm btn-outline-primary me-2 my-auto d-lg-none d-xl-block d-block">
                      <span class="ms-4 me-4">Request Editor</span>
                    </button>
                  </form>
                    </center>
                        

                    </div>
                 
                </div>





              </div>
            </div>
          </div>
 
  


   
          @endforeach
    </div>


        </div>


        <div class="row">
 <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
     <div class="card p-3 pricing-card reveal revealrotate">
        <div class="card-body">
          {!! get_option(site_id().'_show_31_content') !!}  
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




