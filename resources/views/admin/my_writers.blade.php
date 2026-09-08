@extends('layouts.appbar')

@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
  <div class="side-app">

   <!-- CONTAINER -->
   <div class="main-container container-fluid">



    <!-- ROW OPEN -->
    <div class="row row-cards" style="padding-top: 20px;">
     <div class="col-lg-8 col-xl-8">


       <div class="card">

            <div class="card-header">
     <h4 class="card-title">List of your writers</h4>
   </div>

         @if($users->count()>0)

        <div class="e-table px-5 pb-5">
         <div class="table-responsive table-lg">
           <table class="table border-top table-bordered mb-0">

             <tbody>

<?php
$i= 0;
?>
              @foreach($users as $user)
              <tr>
<?php
$i= $i + 1;
?>


  

               <td class="text-nowrap align-middle"> {{ $i}}. 
                <a href="{{ route('user_info', $user->id )}}">#{{ $user->id }} {{ $user->name }}</a><br>{{ $user->email }}<br>
                <a href="https://api.whatsapp.com/send?phone='<?php echo $user->phone; ?>'&text=Hi%2C%20need%20Assignment%20Help?" target="_blank"><?php echo $user->phone; ?></a>
              <br>
                @if($user->is_writer())
                @if($user->writer_levels == '0')
                <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Standard</span> 
                @elseif($user->writer_levels == '1')
                <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Premium</span> 
                @endif
                @endif

                <span style="color: green; font-size: 10px;">Account was created {!! $user->created_at->diffForHumans() !!}</span>

              </td>
   @if($user->is_client())
              <td>
<!--            Wallet:     {{ price($user->wallet) }}<br> -->
           Balance:    {{ price(wallet($user->id)) }}
              </td>

              @endif

              @if($user->is_writer())
              @if($user->editor_id)
              <td class="text-nowrap align-middle">
               <strong>Editor:</strong> {{ $user->editor_id }}<br>
               @if($user->expert_in == '1')
               <strong>Normal Orders</strong> 
               @elseif($user->expert_in == '2')
               <strong>Technical Orders </strong>
               @endif<br>


             </td>
             @endif
             @endif

             @if($user->is_writer())
             <td class="text-nowrap align-middle"><span>
               <div class="mt-sm-1 d-block">
                In progress <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">{{ writer_counter($user->id, 2)}}</span><br>
                Revision <span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">{{ writer_counter($user->id, 6)}}</span><br>
                Completed <span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">{{ writer_counter($user->id, 4)}}</span><br>
                Approved <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">{{ writer_counter($user->id, 5)}}</span><br>
              </div>
            </span>
          </td>
          @endif

          @if($user->is_client())
          <td class="text-nowrap align-middle"><span>
           <div class="mt-sm-1 d-block">

            Available <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">{{ client_counter($user->id, 1)}}</span><br>
            In progress <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">{{ client_counter($user->id, 2) + client_counter($user->id, 3)  + client_counter($user->id, 6) + client_counter($user->id, 8)  }}</span><br>
            Revision <span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">{{ client_counter($user->id, 6)}}</span><br>
            Completed <span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">{{ client_counter($user->id, 4)}}</span><br>
            Approved <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">{{ client_counter($user->id, 5)}}</span><br>
          </div>
        </span>
      </td>
      @endif


      @if($user->is_editor())
      <td class="text-nowrap align-middle"><span>
       <div class="mt-sm-1 d-block">
        In progress <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">{{ editor_counter($user->id, 2)}}</span><br>
        Revision <span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">{{ editor_counter($user->id, 6)}}</span><br>
        Completed <span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">{{ editor_counter($user->id, 4)}}</span><br>
        Approved <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">{{ editor_counter($user->id, 5)}}</span><br>
      </div>
    </span>
  </td>
  @endif


  <td class="text-nowrap align-middle"><span>
   <div class="mt-sm-1 d-block">

     @if($user->account_status==0)                                                                                 
     <span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">Pending</span>
     @elseif($user->account_status==1)
     <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">active</span>
     @else($user->account_status==2)
     <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">blocked</span>
     @endif



   </div>
 </span>
</td>

<td class="text-center align-middle">
  <div class="btn-group align-top">

    @if(Auth::user()->is_admin())

    <a href="{{ route('login_as', $user->id )}}" class="btn btn-sm btn-success badge"><i class="fa fa-sign-in"></i> Login
    </a> 

    <a class="btn btn-sm btn-primary badge" data-bs-target="#edit-property{{ $user->id }}" data-bs-toggle="modal"><i class="fa fa-edit"></i> Edit</a> 

<!--     <a class="btn btn-sm btn-warning badge" data-bs-target="#delete-property{{ $user->id }}" data-bs-toggle="modal"><i class="fa fa-edit"></i> Delete</a> --> 
    @endif

    <a class="btn btn-sm btn-success badge" href="{{ route('user_info', $user->id )}}">View</a>

       <?php 
     $application_count = \App\Models\Application::whereUserId($user->id)->count();
  ?> 

@if( $application_count > 0)
@if($user->applicant == 1)

   <?php 
     $application = \App\Models\Application::whereUserId($user->id)->first();
  ?> 
        <a class="btn btn-sm btn-danger badge" href="{{ route('view_application', $application->id )}}">Applicant</a>
        @endif
   @endif


  </div>
</td>
</tr>

<!-- edit modal-->
<div class="modal fade" id="delete-property{{ $user->id }}">
  <div class="modal-dialog modal-dialog-centered" role="document">
   <div class="modal-content country-select-modal">
     <div class="modal-header">
       <h6 class="modal-title">Edit user #{{ $user->id }}</h6><button aria-label="Close" class="btn-close"
       data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
     </div>
     <div class="modal-body">
       <form class="form-horizontal" action="{{ route('delete_user_admin')}}" method="POST">
         @csrf
         <input type="hidden" name="id" value="{{ $user->id }}">

         <p>Are you sure want this user?</p>


         <div class=" row mb-4">

           <div class="col-md-9">
            <input type="submit" value="Yes" class="btn btn-danger">
          </div>


        </div>



      </form>
    </div>
  </div>
</div>
</div>
<!-- Country-selector modal-->


<!-- edit modal-->
<div class="modal fade" id="edit-property{{ $user->id }}">
  <div class="modal-dialog modal-dialog-centered" role="document">
   <div class="modal-content country-select-modal">
     <div class="modal-header">
       <h6 class="modal-title">Edit user #{{ $user->id }}</h6><button aria-label="Close" class="btn-close"
       data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
     </div>
     <div class="modal-body">
       <form class="form-horizontal" action="{{ route('update_user_admin')}}" method="POST">
         @csrf
         <input type="hidden" name="id" value="{{ $user->id }}">



         <div class=" row mb-4">
           <label class="col-md-4 form-label">Name</label>
           <div class="col-md-8">
             <input type="text" class="form-control" name="name" value="{{ $user->name }}" required="">
           </div>


         </div>

         <div class=" row mb-4">
           <label class="col-md-4 form-label">Nick Name</label>
           <div class="col-md-8">
            <input type="text" class="form-control" name="nickname" value="{{ $user->nickname }}">
          </div>


        </div>

        <div class=" row mb-4">
         <label class="col-md-4 form-label">Email</label>
         <div class="col-md-8">
           <input type="email" class="form-control" name="email" value="{{ $user->email }}" required="">
         </div>


       </div>

       <div class=" row mb-4">
         <label class="col-md-4 form-label">Order completed</label>
         <div class="col-md-8">
           <input type="text" class="form-control" name="orders" value="{{ $user->orders }}">
         </div>
       </div>

       <div class=" row mb-4">
         <label class="col-md-4 form-label">User Site</label>
         <div class="col-md-8">

           <select class="form-control" name="site_id">

            <?php
            $websites = \App\Models\Website::all();
            ?>
            <option value="{{ $user->site_id }}">{{ client_site($user->site_id) ?? 'No site' }}</option>
            @foreach($websites as $website)

            <option value="{{ $website->id }}">{{ $website->domain_name }}</option>

            @endforeach


          </select>
        </div>
      </div>

      <div class=" row mb-4">
       <label class="col-md-4 form-label">Writer Level</label>
       <div class="col-md-8">

         <select class="form-control" name="writer_levels">
          <option value="{{ $user->writer_levels }}" selected="">

            @if($user->writer_levels == '0')
            Standard
            @elseif($user->writer_levels == '1')
            Premium
            @endif



          </option>


          <option value="0">Standard</option>
          <option value="1">Premium</option>


        </select>
      </div>
    </div>


     <div class=" row mb-4">
       <label class="col-md-4 form-label">Clent View Bids</label>
       <div class="col-md-8">

         <select class="form-control" name="view_bids">
          <option value="{{ $user->view_bids }}" selected="">

         
{{ $user->view_bids }}


          </option>


          <option value="YES">YES</option>
          <option value="NO">NO</option>


        </select>
      </div>
    </div>


    <div class=" row mb-4">
     <label class="col-md-4 form-label">Phone</label>
     <div class="col-md-8">
       <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
     </div>
   </div>

   <div class=" row mb-4">
     <label class="col-md-4 form-label">Assign Editor</label>
     <div class="col-md-8">

       <select class="form-control" name="editor_id">
        <option value="{{ $user->editor_id }}" selected="">
          @if($user->editor_id>0)
       {{ $user->editor_id }}
          @else
          not assigned
          @endif
        </option>

        <?php 
        $editors = \App\Models\User::whereUserType('editor')->get();
        ?>
        @foreach($editors as $editor)
        <option value="{{ $editor->id }}">{{ $editor->name }}</option>
        @endforeach


      </select>
    </div>
  </div>


  <div class=" row mb-4">
   <label class="col-md-4 form-label">Expert In</label>
   <div class="col-md-8">

     <select class="form-control" name="expert_in"
     >
     <option value="{{ $user->expert_in }}" selected="">

      @if($user->expert_in == '1')
      Normal Orders
      @elseif($user->expert_in == '2')
      Technical Orders 
      @endif



    </option>


    <option value="1">Normal orders</option>
    <option value="2">Technical orders</option>


  </select>
</div>
</div>

<div class=" row mb-4">
  <label class="col-md-4 form-label">About</label>
  <div class="col-md-8">
   <textarea name="about" class="form-control">{!! $user->about !!}</textarea>
 </div>
</div>



<div class=" row mb-4">
  <label class="col-md-4 form-label">User Type</label>
  <div class="col-md-8">

   <select class="form-control" name="user_type" required="">
    <option value="{{ $user->user_type }}" selected="">{{ $user->user_type }}</option>


    <option value="client">client</option>
    <option value="writer">writer</option>
    <option value="editor">Editor</option>
    <option value="student">student</option>


  </select>
</div>
</div>




<div class=" row mb-4">
  <label class="col-md-4 form-label">Status</label>
  <div class="col-md-8">

   <select class="form-control" name="status" required="">
    <option value="{{ $user->account_status }}" selected="">

      @if($user->account_status==0)                                                                                 
      <span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">Pending</span>
      @elseif($user->account_status==1)
      <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">active</span>
      @else($user->account_status==2)
      <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">blocked</span>
      @endif



    </option>
    <option value="0">Pending</option>
    <option value="1">Active</option>
    <option value="2">Blocked</option>


  </select>
</div>
</div>












<div class=" row mb-4">

  <div class="col-md-9">
    <input type="submit" value="Save" class="btn btn-primary">
  </div>


</div>



</form>
</div>
</div>
</div>
</div>
<!-- Country-selector modal-->

@endforeach




</tbody>
</table>
</div>
</div>
@else
<tr>No users</tr>
@endif
</div>

<div class="mb-5">

  <div class="float-end">


   {{$users->links("pagination::bootstrap-4")}}

 </div>
</div>
</div>


<div class="col-lg-4 col-xl-4">


@if(Auth::user()->account_status == '1')

  <div class="card">
    <div class="card-header">
     <h4 class="card-title">Add your writer</h4>
   </div>
   <div class="card-body">

     <form class="form-horizontal" action="{{ route('save_writer')}}" method="POST">
       @csrf

       <input type="hidden" name="user_type" value="writer">

      <div class=" row mb-4">
       <label class="col-md-4 form-label">Name</label>
       <div class="col-md-8">
         <input type="text" class="form-control" name="name" placeholder="Enter name" required="">
       </div>


     </div>

     <div class=" row mb-4">
       <label class="col-md-4 form-label">Email</label>
       <div class="col-md-8">
         <input type="text" class="form-control" name="email" placeholder="Enter email" required="">
       </div>
     </div>

     <div class=" row mb-4">
       <label class="col-md-4 form-label">Phone</label>
       <div class="col-md-8">
         <input type="text" class="form-control" name="phone" placeholder="Enter Phone Number" required="">
       </div>
     </div>



     <div class=" row mb-4">
       <label class="col-md-4 form-label">Password</label>
       <div class="col-md-8">
         <input type="password" class="form-control" name="password" placeholder="Enter password">
       </div>
     </div>









     <div class=" row mb-4">

       <div class="col-md-9">
        <input type="submit" value="Save" class="btn btn-primary">
      </div>


    </div>



  </form>
</div>
</div>
@else


  <div class="card">
    <div class="card-header">
     <h4 class="card-title">To add your Writers </h4>
   </div>
   <div class="card-body">

<p>You need to have an active subscription</p>
  <a href="{{ route('subscribe')}}" class="btn btn-success">Subscribe Now </a>
</div>
</div>

@endif


</div>


<!-- COL-END -->

</div>
<!-- ROW CLOSED -->


</div>
</div>
</div>





@endsection