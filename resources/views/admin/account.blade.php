@extends('layouts.appbar')

@section('content')      <!--app-content open-->
<!--app-content open-->
<div class="main-content app-content mt-0">
    <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">

            <!-- PAGE-HEADER -->
            <div class="page-header">

                <h1 class="page-title">#{{ $user->id }} {{ $user->name }} 
                    <span class="badge bg-secondary fs-14 me-2">
                        {{ accountStatus($user->account_status) }}</span>
                    </h1>
                    @if(Auth::user()->is_writer())


                    <div class="card">

                      


                              <?php
                        $package = \App\Models\Package::where('type', 'writer')->first();
                        ?>
                        @if(Auth::user()->account_status=='0')
                        <br>
                        <div class="border border-secondary p-5 br-5">
                         
                            <form action="{{ route('subscribe_data')}}" method="POST"> 
                                @csrf
                                <input type="hidden" name="package" value="{{ $package->id }}">

                                   <span class="badge bg-secondary fs-14 me-2">Note:</span>
                            <span> You have not subscribed to our monthly subscription. </span><button class="btn btn-success">Subscribe Now
                            </button>
                           </form>
                    </div>
                       @elseif(Auth::user()->account_status=='1')

                    <div class="border border-secondary p-5 br-5">
                    <p>Your account has an active subscription</p>
                    <p> Account expires after  {{ days(Auth::user()->subscribe_end, Auth::user()->subscribe_start)}} days</p>    
                    </div>
                    @else
                    
                 
            

                    @endif



                    </div>


                    <?php 

                    $warnings       = \App\Models\Warning::whereUserId($user->id)->get();

                    ?> 

                    @if($warnings->count()>0) 


                    <div class="card alert alert-danger" >


                        <div class="card-header">
                          <div class="card-title">Writer Warning</div>
                      </div>
                      <div class="card-body">




                         <div>
                           @foreach($warnings as $warning)  

                           <p> Suspension ends after  
                              <span><p style="color: green;" id="demo1"></p> </span>
                              <?php

                              $created_at = \Carbon\Carbon::parse($warning->suspend_end);
                              $current_time = \Carbon\Carbon::now();

                              ?>

                              {{ \Carbon\Carbon::parse($current_time)->diffInHours($created_at,false) }} hours
                          </p>
                          <br>                                               
                          <a href="javascript:void(0)">{!! $warning->message !!}</a> <br>
                          saved {!! $warning->created_at->diffForHumans() !!}

                          <hr style="border-top: 1px solid #000000;">
                          @endforeach
                      </div>


                      @endif
                  </div>

              </div>
              @endif
          </div>
          <!-- PAGE-HEADER END -->

          <!-- ROW-1 OPEN -->
          <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Edit Password</div>
                    </div>
                    <div class="card-body">
                        <div class="text-center chat-image mb-5">
                            <div class="avatar avatar-xxl chat-profile mb-3 brround">
                                <a class="" href=""><img alt="avatar" src="{{ $user->get_gravatar(150) }}" class="brround"></a>
                            </div>
                            <div class="main-chat-msg-name">
                                <a href="#">
                                    <h5 class="mb-1 text-dark fw-semibold">{{ $user->name }}</h5>
                                    <span>{{ $user->country }}</span>
                                </a>

                            </div>
                        </div>
                        <form action="{{ route('change_password')}}" method="POST">
                            <div class="form-group">
                                <label class="form-label">Current Password</label>
                                <div class="wrap-input100 validate-input input-group" id="Password-toggle">
                                    <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                        <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                    </a>
                                    <input class="input100 form-control" type="password"  autocomplete="current-password" name="old_password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">New Password</label>
                                <div class="wrap-input100 validate-input input-group" id="Password-toggle1">
                                    <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                        <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                    </a>
                                    <input class="input100 form-control" type="password" autocomplete="new-password" name="new_password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Confirm Password</label>
                                <div class="wrap-input100 validate-input input-group" id="Password-toggle2">
                                    <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                        <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                    </a>
                                    <input class="input100 form-control" type="password"  autocomplete="new-password" name="new_password_confirmation">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">

                            <input type="submit" class="btn btn-primary" value="Update">

                        </div>

                    </form>
                </div>
                <div class="card panel-theme">
                    <div class="card-header">
                        <div class="float-start">
                            <h3 class="card-title">My Subjects</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="card-body no-padding">
                        <ul class="list-group no-margin">
                            @foreach($user_subjects as $mysubject)
                            <li class="list-group-item d-flex ps-3">
                                <div class="social social-profile-buttons me-2">
                                    <a class="social-icon text-primary" href="javascript:void(0)"><i class="fe fe-check"></i></a>
                                </div>
                                <a href="javascript:void(0)" class="my-auto">{{ $mysubject->subject_name }}</a>
                            </li>
                            @endforeach


                        </ul>
                    </div>
                </div>
            </div>
            @if(Auth::user()->is_admin() or Auth::user()->is_writer() or Auth::user()->is_editor())
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Profile</h3>
                    </div>
                    <div class="card-body">
                       <form action="{{ route('edit_profile')}}" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputname">Nick Name</label>
                                    <input type="text" class="form-control" name="nickname" id="exampleInputname" placeholder="Nick Name" value="{{ $user->nickname  }}">
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="exampleInputnumber">Mpesa Number</label>
                            <input type="number" name="phone" class="form-control" id="exampleInputnumber" placeholder="Contact number" value="{{ $user->phone  }}">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputnumber">Equity Bank Account</label>
                            <input type="number" name="equity_bank" class="form-control" id="exampleInputnumber" placeholder="Equity Bank Account" value="{{ $user->equity_bank  }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">About Me</label>
                            <textarea class="form-control" name="about" rows="6">{{ $user->about  }}</textarea>
                        </div>

                        <div class="form-group  {{ $errors->has('photo')? 'has-error':'' }}">
                            <label class="col-sm-4 control-label">Profile Photo</label>
                            <div class="col-sm-8">
                                <input type="file" id="photo" name="photo" class="filestyle" >
                                {!! $errors->has('photo')? '<p class="help-block">'.$errors->first('photo').'</p>':'' !!}
                            </div>
                        </div>


                        <button href="javascript:void(0)" class="btn btn-success my-1">Save</button>


                    </form>


                </div>

            </div>





            <div class="card" style="display: none;">
                <div class="card-header">Select subject you do offer</div>

                <div class="card-body">



                 <form method="POST" action="{{ route('save_service') }}">
                    @csrf



                    <div class="row mb-3">
                        <div class="col-md-6">
                           @if($categories->count() > 0)
                           @foreach($categories as $category)
                           <?php
                           $s_count = \App\Models\User_subject::whereSubjectId($category->id)->count();
                           ?>

                           @if($s_count>0)
                           @else

                           <label> <input type="checkbox" value="{{ $category->id }}" name="amenities[{{$category->id}}]"> {{ $category->name }} </label><br>

                           @endif


                           @endforeach
                           @endif

                       </div>
                   </div>








                   <div class="row">
                    <div class="col-md-8">
                        <button type="submit" class="btn btn-primary">
                         Add Selected
                     </button>


                 </div>
             </div>
         </form>
     </div>
 </div>


</div>

@endif
</div>
<!-- ROW-1 CLOSED -->

</div>
<!--CONTAINER CLOSED -->

</div>
</div>
<!--app-content open-->



@endsection