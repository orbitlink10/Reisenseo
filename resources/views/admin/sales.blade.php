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
           <h2 class="card-title">Sales list</h2>



         </div>


         @if($sales->count()>0)


         <div class="card-body">
          <div class="row">
           <hr style="border-top: 1px solid #000000;">
           @foreach($sales as $user)

           <div class="col-sm-4">

            <a target="_blank" href="https://{{ $user->domain_name }}">{{ $user->name }}</a>
          </div>

          <div class="col-sm-2">

            USD {{ $user->amount }}
          </div>




          <div class="col-sm-2"> 
            @if($user->status==0)                                                                                 
            <span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">Pending</span>
            @elseif($user->status==1)
            <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">
            Paid</span>
            @else($user->status==2)
            <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">Cancelled</span>
            @endif
          </div>




          <div class="col-sm-4">
            <div class="btn-group align-top">

              @if(Auth::user()->is_admin())


              <a class="btn btn-sm btn-success badge" data-bs-target="#edit{{ $user->id }}" 
                data-bs-toggle="modal"><i class="fa fa-edit"></i> 
              </a>


                <a class="btn btn-sm btn-warning badge" data-bs-target="#delete-site{{ $user->id }}" data-bs-toggle="modal"><i class="fa fa-trash"></i>
                </a> 


                <div class="modal fade" id="delete-site{{ $user->id }}">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                   <div class="modal-content country-select-modal">
                     <div class="modal-header">
                       <h6 class="modal-title">Delete sales #{{ $user->id }}</h6><button aria-label="Close" class="btn-close"
                       data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                     </div>
                     <div class="modal-body">
                       <form class="form-horizontal" action="{{ route('delete_sales')}}" method="POST">
                         @csrf

                         <input type="hidden" name="id" value="{{ $user->id }}">

                         <p>Are you sure want to delete this site?</p>


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




              @endif


            </div>
          </div>

          <div class="modal fade" id="edit{{ $user->id }}">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content country-select-modal">
                <div class="modal-header">
                  <h6 class="modal-title">Update site #{{ $user->id }}</h6><button aria-label="Close" class="btn-close"
                  data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                </div>

                <div class="modal-body">
                  <form class="form-horizontal" action="{{ route('update_site')}}" method="POST">
                    @csrf

                    <input type="hidden" name="id" value="{{ $user->id }}">


                    <div class=" row mb-4">
                      <label class="col-md-3 form-label">Domain Name</label>

                      <div class="col-md-9">
                        <input type="text" class="form-control" name="domain_name" value="{{ $user->domain_name }}">
                      </div>

                    </div>




                    <div class=" row mb-4">
                      <label class="col-md-3 form-label">Status</label>
                      <div class="col-md-9">
                        <select class="form-control" name="status">
                          <option value="{{ $user->status }}">
                            @if($user->status==0)                                                                                 
                            <span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">Pending</span>
                            @elseif($user->status==1)
                            <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">
                            active</span>
                            @else($user->status==2)
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






         <hr style="border-top: 1px solid #000000;">
         @endforeach
       </div>

     </div>

     @else
     <tr>No website</tr>
     @endif
   </div>

   <div class="mb-5">

     <div class="float-end">


       {{$sales->links("pagination::bootstrap-4")}}

     </div>
   </div>
 </div>
 <!-- COL-END -->
 @if(Auth::user()->is_admin())
 <div class="col-lg-4 col-xl-4">
  <div class="card">

    <div class="card-header">
     <h4 class="card-title">Add a new website</h4>
   </div>



   <div class="card-body">


     <form class="form-horizontal" action="{{ route('add_site')}}" method="POST">
       @csrf

       <div class=" row mb-4">
         <label class="col-md-4 form-label">Domain Name</label>
         <div class="col-md-8">

          <input type="text" name="domain_name" class="form-control" placeholder="eg. gondana.com">


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