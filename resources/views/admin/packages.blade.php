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
           <h2 class="card-title">Pricing Plans</h2>

         </div>
         <div class="e-table px-5 pb-5">
           <div class="table-responsive table-lg">
             <table class="table border-top table-bordered mb-0">
               <thead>
                 <tr>
                   <th class="text-center">
                     ID
                   </th>

                   <th>Name</th>
                   <th>Amount</th>
                   <th>Plan</th>
                   <th>Days</th>
                   <th>CPP</th>
                   <th class="text-center">Actions</th>
                 </tr>
               </thead>
               <tbody>

                @if($packages->count()>0)
                @foreach($packages as $property)
                <tr>
                 <td class="align-middle text-center">

                   #{{ $property->id }}
                 </td>

                 <td class="text-nowrap align-middle">{{ $property->name }}</td>
                 <td class="text-nowrap align-middle"><span>{{price($property->amount)}}</span></td>
                 <td class="text-nowrap align-middle"><span>{{ $property->max_units }}</span>
                 </td>

                 <td class="text-nowrap align-middle">
                  <span>{{ $property->days }}</span>
                </td>

                <td class="text-nowrap align-middle">
                  <span>{{ $property->cpp }}</span>
                </td>

                <td class="text-center align-middle">
                 <div class="btn-group align-top">

                   <a class="btn btn-sm btn-primary badge" data-bs-target="#edit-property{{ $property->id }}" data-bs-toggle="modal"><i class="fa fa-edit"></i> Edit</a> 



                 </div>
               </td>
             </tr>


             <!-- edit modal-->
             <div class="modal fade" id="edit-property{{ $property->id }}">
               <div class="modal-dialog modal-dialog-centered" role="document">
                 <div class="modal-content country-select-modal">
                   <div class="modal-header">
                     <h6 class="modal-title">Edit Package #{{ $property->id }}</h6><button aria-label="Close" class="btn-close"
                     data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                   </div>
                   <div class="modal-body">
                     <form class="form-horizontal" action="{{ route('update_package')}}" method="POST">
                       @csrf
                       <input type="hidden" name="id" value="{{ $property->id }}">
                       <div class=" row mb-4">
                         <label class="col-md-3 form-label">Name</label>
                         <div class="col-md-9">
                           <input type="text" class="form-control" name="name" value="{{ $property->name }}">
                         </div>
                       </div>

                       <div class=" row mb-4">
                         <label class="col-md-3 form-label">Amount ({{Auth::user()->currency_sign}})</label>
                         <div class="col-md-9">
                           <input type="text" class="form-control" name="amount" value="{{ $property->amount }}">
                         </div>


                       </div>
                       <div class=" row mb-4">
                         <label class="col-md-3 form-label">Plan name</label>
                         <div class="col-md-9">
                           <input type="text" class="form-control" name="max_units" value="{{ $property->max_units }}">
                         </div>


                       </div>
                       <div class=" row mb-4">
                         <label class="col-md-3 form-label">Days</label>
                         <div class="col-md-9">
                          <input type="text" class="form-control" name="days" value="{{ $property->days }}">
                        </div>


                      </div>

                      <div class=" row mb-4">
                       <label class="col-md-3 form-label">CPP</label>
                       <div class="col-md-9">
                        <input type="text" class="form-control" name="cpp" value="{{ $property->cpp }}">
                      </div>
                     </div>

                       <div class=" row mb-4">
                       <label class="col-md-3 form-label">List1</label>
                       <div class="col-md-9">
                        <input type="text" class="form-control" name="list1" value="{{ $property->list1 }}">
                      </div>
                     </div>

                       <div class=" row mb-4">
                       <label class="col-md-3 form-label">List2</label>
                       <div class="col-md-9">
                        <input type="text" class="form-control" name="list2" value="{{ $property->list2 }}">
                      </div>
                     </div>

                       <div class=" row mb-4">
                       <label class="col-md-3 form-label">List3</label>
                       <div class="col-md-9">
                        <input type="text" class="form-control" name="list3" value="{{ $property->list3 }}">
                      </div>
                     </div>

                       <div class=" row mb-4">
                       <label class="col-md-3 form-label">List4</label>
                       <div class="col-md-9">
                        <input type="text" class="form-control" name="list4" value="{{ $property->list4 }}">
                      </div>
                     </div>

                       <div class=" row mb-4">
                       <label class="col-md-3 form-label">List5</label>
                       <div class="col-md-9">
                        <input type="text" class="form-control" name="list5" value="{{ $property->list5 }}">
                      </div>
                     </div>

                       <div class=" row mb-4">
                       <label class="col-md-3 form-label">List6</label>
                       <div class="col-md-9">
                        <input type="text" class="form-control" name="list6" value="{{ $property->list6 }}">
                      </div>
                     </div>

                                            <div class=" row mb-4">
                       <label class="col-md-3 form-label">List7</label>
                       <div class="col-md-9">
                        <input type="text" class="form-control" name="list7" value="{{ $property->list7 }}">
                      </div>
                     </div>

                           <div class=" row mb-4">
                       <label class="col-md-3 form-label">List8</label>
                       <div class="col-md-9">
                        <input type="text" class="form-control" name="list8" value="{{ $property->list8 }}">
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
        @else
        <tr>No property added</tr>
        @endif



      </tbody>
    </table>
  </div>
</div>
</div>
<div class="mb-5">

 <div class="float-end">

  {!! $packages->links() !!}

</div>
</div>
</div>
<!-- COL-END -->

<div class="col-lg-4 col-xl-4">
 <div class="card">
   <div class="card-header">
     <h4 class="card-title">Add Pricing Plan</h4>
   </div>
   <div class="card-body">
     <form class="form-horizontal" action="{{ route('save_package')}}" method="POST">
       @csrf
       <div class=" row mb-4">
         <label class="col-md-3 form-label">Name</label>
         <div class="col-md-9">
           <input type="text" class="form-control" name="name" placeholder="Typing name.....">
         </div>
       </div>

       <div class=" row mb-4">
         <label class="col-md-3 form-label">Amount ({{Auth::user()->currency_sign}})</label>
         <div class="col-md-9">
           <input type="text" class="form-control" name="amount" placeholder="Package amount">
         </div>


       </div>

       <div class=" row mb-4">
         <label class="col-md-3 form-label">Maximum units</label>
         <div class="col-md-9">
           <input type="text" class="form-control" name="max_units" placeholder="Enter maximum units">
         </div>


       </div>


      <div class=" row mb-4">
         <label class="col-md-3 form-label">Type</label>
         <div class="col-md-9">
<select class="form-control" name="type">
    <option value="plan">Plan</option>
    <option value="product">Product</option>
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
<!-- ROW CLOSED -->


</div>
</div>
</div>





@endsection