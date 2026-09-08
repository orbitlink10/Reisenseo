@extends('layouts.appbar')

@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
  <div class="side-app">

   <!-- CONTAINER -->
   <div class="main-container container-fluid">



    <!-- ROW OPEN -->
    <div class="row row-cards" style="padding-top: 20px;">
     <div class="col-lg-12 col-xl-12">


       <div class="card">
         @if($users->count()>0)
         <div class="card-header border-bottom-0">
           <h2 class="card-title">System Users</h2>
           <div class="page-options ms-auto">

            <?php

                           //user count 
            $c_count = \App\Models\User::whereUserType('client')->count();
            $w_count = \App\Models\User::whereUserType('writer')->count();
            $e_count = \App\Models\User::whereUserType('editor')->count();
            $s_count = \App\Models\User::whereUserType('student')->count();
            $a_count = \App\Models\User::whereApplicant('1')->count();
            ?>


            <a href="{{ route('writers', ['users' => 'writer'])}}" class="btn btn-primary"> Writers ({{ $w_count}})</a>

            @if(Auth::user()->is_admin())
            <a href="{{ route('clients', ['users' => 'client'])}}" class="btn btn-primary"> Clients ({{ $c_count}})</a>

            <a href="{{ route('editors', ['users' => 'editor'])}}" class="btn btn-primary"> Editors ({{ $e_count}})</a>


            <a href="{{ route('users', ['users' => 'student'])}}" class="btn btn-primary"> Students ({{ $s_count}})</a>


            <a href="{{ route('users', ['status'=>'1']) }}" class="btn btn-primary">Active ({{ $active_count}})</a>
            <a href="{{ route('users', ['applicant'=>'1']) }}" class="btn btn-primary">Writers Application ({{ $a_count}})</a>
            <a href="{{ route('users', ['status'=>'2']) }}" class="btn btn-primary"> Blocked ({{ $blocked_count}})</a>

            @endif


          </div>


        </div>
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
             <?php echo $user->phone; ?>

                <a href="https://api.whatsapp.com/send/?phone=<?php echo $user->whatsapp; ?>&text&type=phone_number&app_absent=0" class="btn btn-sm btn-success" target="_blank">Whatsapp</a>

                
                <br>
                <a target="_blank" href="https://{{ client_site($user->site_id)->domain_name ?? 'no site' }}"> {{ client_site($user->site_id)->domain_name ?? 'no site' }}</a><br>
                @if($user->is_writer())
                @if($user->writer_levels == '0')
                <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Standard</span> 
                @elseif($user->writer_levels == '1')
                <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Premium</span> 
                @endif
                @endif

                <span style="color: green; font-size: 10px;">Account was created {!! $user->created_at->diffForHumans() !!}</span><br>

                  <span style="color: blue; font-size: 10px;">Refered {{ \Illuminate\Support\Str::limit($user->referer, 50, '...') }}  </span><br>


              </td>
   @if($user->is_client())
              <td>
           <!-- Wallet:     {{ price($user->wallet) }}<br> -->
           Balance:    {{ price(wallet($user->id)) }}
              </td>

              @endif

              @if($user->is_writer())
              @if($user->editor_id)
              <td class="text-nowrap align-middle">
               <strong>Editor:</strong> {{ username($user->editor_id)->name }}<br>
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

    <a href="{{ route('login_as', $user->id )}}" target="_blank" class="btn btn-sm btn-success badge"><i class="fa fa-sign-in"></i> Login
    </a> 

    <a class="btn btn-sm btn-primary badge" data-bs-target="#edit-property{{ $user->id }}" data-bs-toggle="modal"><i class="fa fa-edit"></i> Edit</a> 

    <a class="btn btn-sm btn-warning badge" data-bs-target="#delete-property{{ $user->id }}" data-bs-toggle="modal"><i class="fa fa-edit"></i> Delete</a> 
@if($user->application_id)
@if($user->applicant == 1)

    <a href="{{ route('view_application', $user->application_id )}}" target="_blank" class="btn btn-sm btn-danger badge"><i class="fa fa-sign-in"></i> Applicant
    </a> 

    @endif
    @endif


    @endif

    <a class="btn btn-sm btn-success badge" href="{{ route('user_info', $user->id )}}">View</a>



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
            <option value="{{ $user->site_id }}">{{ client_site($user->site_id)->domain_name ?? 'No site' }}</option>
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
       <label class="col-md-4 form-label">Top Ten</label>
       <div class="col-md-8">

         <select class="form-control" name="top_ten">
          <option value="{{ $user->top_ten }}" selected="">

            @if($user->top_ten == '0')
            Not yet
            @elseif($user->top_ten == '1')
            Virtuoso
            @endif



          </option>


          <option value="0">Not yet</option>
          <option value="1">Virtuoso</option>


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
     <label class="col-md-4 form-label">WhatApp</label>
     <div class="col-md-8">
       <input type="text" class="form-control" name="whatsapp" value="{{ $user->whatsapp }}">
     </div>
   </div>



  <div class=" row mb-4">
     <label class="col-md-4 form-label">Designation</label>
     <div class="col-md-8">
       <input type="text" class="form-control" name="designation" value="{{ $user->designation }}">
     </div>
   </div>


  <div class=" row mb-4">
     <label class="col-md-4 form-label">Location</label>
     <div class="col-md-8">
       <input type="text" class="form-control" name="location" value="{{ $user->location }}">
     </div>
   </div>

   <div class=" row mb-4">
     <label class="col-md-4 form-label">Assign Editor</label>
     <div class="col-md-8">

       <select class="form-control" name="editor_id">
        <option value="{{ $user->editor_id }}" selected="">
          @if($user->editor_id>0)
          {{ username($user->editor_id)->name }}
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
       <label class="col-md-4 form-label">Admin Note</label>
       <div class="col-md-8">

         <select class="form-control" name="admin_note">
          <option value="{{ $user->admin_note }}" selected="">

         
{{ $user->admin_note }}


          </option>


          <option value="testing">testing</option>
          <option value="client">client</option>
                <option value="writer">writer</option>


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
<!-- COL-END -->

</div>
<!-- ROW CLOSED -->


</div>
</div>
</div>





@endsection