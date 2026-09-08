@extends('layouts.appbar')

@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
 <div class="side-app">

<!-- CONTAINER -->
<div class="main-container container-fluid">
<!-- ROW OPEN -->
<div class="row row-cards" style="padding-top: 20px;">

<!-- COL-END -->
  @if(Auth::user()->is_admin())
<div class="col-lg-4 col-xl-4">
  <div class="card">
    <div class="card-header">
     <h4 class="card-title">Add an User</h4>
   </div>
   <div class="card-body">
     <form class="form-horizontal" action="{{ route('save_user')}}" method="POST">
       @csrf

         <div class=" row mb-4">
                         <label class="col-md-4 form-label">User Type</label>
                         <div class="col-md-8">

                           <select class="form-control" name="user_type" required="">
                         


                            <option value="client">Client</option>
                            <option value="writer">writer</option>
                            <option value="editor">Editor</option>
                            <option value="subadmin">Sub Admin</option>
                            <option value="author">Author</option>


                          </select>
                        </div>
                      </div>


       <div class=" row mb-4">
         <label class="col-md-4 form-label">Package</label>
         <div class="col-md-8">
           <?php
           $packages = \App\Models\Package::all();
           ?>
           <select class="form-control" name="package_id">
            <option value="" selected="">No package</option>
            @foreach($packages as $package)
            <option value="{{ $package->id }}">{{ $package->name }}</option>
            @endforeach
          </select>
        </div>
      </div>

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
</div>
@endif
</div>
<!-- ROW CLOSED -->


</div>
</div>
</div>





@endsection