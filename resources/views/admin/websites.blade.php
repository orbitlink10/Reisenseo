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
           <h2 class="card-title">Websites list</h2>



         </div>


         @if($websites->count()>0)


         <div class="card-body">
          <div class="row">
           <hr style="border-top: 1px solid #000000;">
           @foreach($websites as $user)

           <div class="col-sm-6">
            <a href="{{ route('website_info', $user->id )}}">{{ $user->domain_name }}</a> {{ $user->label }}
          </div>

           <?php
          $posts_count   = \App\Models\Post::whereSiteId($user->id)->whereType('post')->count();
          $pages_count   = \App\Models\Post::whereSiteId($user->id)->whereType('page')->count();
          ?>

          <div class="col-sm-2"> 
          <a href="{{ route('posts', ['site_id' => $user->id ]) }}">Posts ({{ $posts_count }})</a> 
         </div>


           <div class="col-sm-2"> 
           <a href="{{ route('post_page', ['site_id' => $user->id ]) }}">Pages ({{ $pages_count }})</a> 
         </div>


         <div class="col-sm-2">
          <div class="btn-group align-top">

            @if(Auth::user()->is_admin())
            <a href="{{ route('website_info', $user->id )}}" class="btn btn-sm btn-primary badge"><i class="fa fa-edit"></i> Manage</a> 
            @endif



            <!-- edit modal-->
            <div class="modal fade" id="edit-property{{ $user->id }}">
             <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content country-select-modal">
                 <div class="modal-header">
                   <h6 class="modal-title">Edit user #{{ $user->id }}</h6><button aria-label="Close" class="btn-close"
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
<tr>No website</tr>
@endif
</div>

<div class="mb-5">

 <div class="float-end">


   {{$websites->links("pagination::bootstrap-4")}}

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


     <form class="form-horizontal" action="{{ route('add_website')}}" method="POST">
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