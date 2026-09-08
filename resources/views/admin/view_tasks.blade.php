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
        
         <div class="card-header border-bottom-0">
           <h2 class="card-title">System Issues</h2>
           <div class="page-options ms-auto">

 <?php
              $inprogress = \App\Models\Task::whereStatus('2')->count();
              $issues = \App\Models\Task::whereStatus('0')->count();
              $completed = \App\Models\Task::whereStatus('1')->count();
              $tested = \App\Models\Task::whereStatus('3')->count();
              $notworking = \App\Models\Task::whereStatus('4')->count();
 ?>

               <a href="{{ route('issues', ['label'=>'2']) }}"  class="btn btn-danger btn-sm">In progress ({{ $inprogress }})</a>
               <a href="{{ route('issues', ['label'=>'pending']) }}"  class="btn btn-warning btn-sm">New issues ({{ $issues }})</a>
               <a href="{{ route('issues', ['label'=>'1']) }}"  class="btn btn-primary btn-sm"> Completed ({{ $completed }})</a>
               <a href="{{ route('issues', ['label'=>'3']) }}"  class="btn btn-success btn-sm">Tested ({{ $tested }})</a>
                <a href="{{ route('issues', ['label'=>'4']) }}"  class="btn btn-danger btn-sm">Not working ({{ $notworking }})</a>

          </div>


        </div>


             @if($tasks->count()>0)

  
   <div class="card-body">
    <div class="row">
       <hr style="border-top: 1px solid #000000;">
            @foreach($tasks as $user)
          <div class="col-sm-6">
              {{ $user->description }}<br>
              <span style="font-size: 11px; background-color: green; color: white; padding: 3px; border-radius: 3px;">{{ $user->name }}</span>
<span style="font-size: 11px; background-color: black; color: white; padding: 3px; border-radius: 3px;">{{ $user->label }}</span>
<span style="font-size: 11px; background-color: black; color: white; padding: 3px; border-radius: 3px;">{{ price($user->cost) }}</span>
<span style="font-size: 11px; background-color: black; color: white; padding: 3px; border-radius: 3px;">{{ $user->created_at->diffForHumans() }}</span>





          </div>
           <div class="col-sm-3"> 
            <span>
                 <div class="mt-sm-1 d-block">
                   @if($user->status==0)                                                                                 
                   <span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">Pending</span>
                   @elseif($user->status==1)
                   <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Completed</span>

                   @elseif($user->status==2)
                <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">Working on it</span>

                 @elseif($user->status==3)
                <span class="badge bg-info-transparent rounded-pill text-info p-2 px-3">Working perfect</span>
                @elseif($user->status==4)
                <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">Not Working</span>
                   @endif
                 </div>
               </span>
             </div>
            <div class="col-sm-3">
                <div class="btn-group align-top">

@if(Auth::user()->is_admin())
                   <a class="btn btn-sm btn-primary badge" data-bs-target="#edit-property{{ $user->id }}" data-bs-toggle="modal"><i class="fa fa-edit"></i> update</a> 
                   @endif

                  

    <!-- edit modal-->
             <div class="modal fade" id="edit-property{{ $user->id }}">
               <div class="modal-dialog modal-dialog-centered" role="document">
                 <div class="modal-content country-select-modal">
                   <div class="modal-header">
                     <h6 class="modal-title">Edit Task #{{ $user->id }}</h6><button aria-label="Close" class="btn-close"
                     data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                   </div>
                   <div class="modal-body">
                     <form class="form-horizontal" action="{{ route('update_task')}}" method="POST">
                       @csrf
                       <input type="hidden" name="id" value="{{ $user->id }}">
                       

                       

                        <div class=" row mb-4">
                         <label class="col-md-4 form-label">Description</label>
                         <div class="col-md-8">
                           
                           <textarea class="form-control" name="description">{{ $user->description }}</textarea>
                         </div>


                       </div>

                       <div class=" row mb-4">
                         <label class="col-md-4 form-label">Label</label>
                         <div class="col-md-8">
                      <select name="label"  class="form-control">
                            <option value="{{ $user->label }}">{{ $user->label }} </option>
                            <option value="issue">issue</option>
                            <option value="order">order</option>
                            <option value="project">project</option>
                            <option value="reading">reading</option>
                      </select>
                         </div>


                       </div>



                       <div class=" row mb-4">
                         <label class="col-md-4 form-label">Status</label>
                         <div class="col-md-8">
                          <select name="status" class="form-control">
                            <option value="{{ $user->status }}">
                              @if($user->status==0)
                              pending
                              @elseif($user->status==2)
                              Working on it
                              @else
                              Done
                              @endif
                            </option>
                            <option value="1">Done</option>
                             <option value="2"> Working on it</option>
                             <option value="3"> Working perfect</option>
                              <option value="4"> Not Working</option>
                          </select>
                         </div>


                       </div>


                       
                       <div class=" row mb-4">
                         <label class="col-md-4 form-label">Cost</label>
                         <div class="col-md-8">
<input type="text" class="form-control" placeholder="" id="task" name="cost" value="<?php echo $user->cost; ?>" autocomplete="off">
                         </div>


                       </div>

                                              
                       <div class=" row mb-4">
                         <label class="col-md-4 form-label"> Name</label>
                         <div class="col-md-8">
<input type="text" class="form-control" placeholder="" id="task" name="name" value="<?php echo $user->name; ?>" autocomplete="off">
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

                 </div>
            </div>
            <hr style="border-top: 1px solid #000000;">
            @endforeach
          </div>
          
        </div>
    
   @else
        <tr>No users</tr>
        @endif
</div>

<div class="mb-5">

 <div class="float-end">

 
   {{$tasks->links("pagination::bootstrap-4")}}

</div>
</div>
</div>
<!-- COL-END -->
  @if(Auth::user()->is_admin())
<div class="col-lg-4 col-xl-4">
  <div class="card">
    <div class="card-header">
     <h4 class="card-title">Add a new issue</h4>
   </div>
   <div class="card-body">
     <form class="form-horizontal" action="{{ route('add_task')}}" method="POST">
       @csrf

         <div class=" row mb-4">
                         <label class="col-md-4 form-label">Label</label>
                         <div class="col-md-8">

                           <select class="form-control" name="label" required="">
                         


                     <option value="issue" selected>Select label</option>
            <option value="issue">issue</option>
            <option value="order">order</option>
            <option value="project">project</option>
            <option value="reading">reading</option>


                          </select>
                        </div>
                      </div>




      <div class=" row mb-4">
       <label class="col-md-4 form-label">Issue</label>
       <div class="col-md-8">
        <textarea class="form-control" name="description" required=""></textarea>
       </div>


     </div>


     
     <div class=" row mb-4">
       <label class="col-md-4 form-label">Name</label>
       <div class="col-md-8">
        <input type="text" name="name" class="form-control" placeholder="Enter Name"></input>

       </div>


     </div>


     <div class=" row mb-4">
       <label class="col-md-4 form-label">Cost</label>
       <div class="col-md-8">
        <input type="text" name="cost" class="form-control" placeholder="Enter Cost"></input>

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
@endif
</div>
<!-- ROW CLOSED -->


</div>
</div>
</div>





@endsection