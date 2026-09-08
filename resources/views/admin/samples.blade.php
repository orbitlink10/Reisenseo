@extends('layouts.appbar')

@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
 <div class="side-app">

   <!-- CONTAINER -->
   <div class="main-container container-fluid">

                <h1>{{ $title }}</h1>


                           <!-- ROW-2 OPEN -->
                        <div class="row">
                             @if($samples->count()>0)
                                    @foreach($samples as $new)
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                           
                                            
                                            <div class="col-xl-10 col-lg-9">
                                                <div class="mt-1">
                                                    <h4 class="fw-semibold">   {{ $new->title }}</h4>
                                                    <p class="mb-0">
{!! $new->description !!}
                                                       </p>
                                                         <?php
     $logo =\App\Models\Upload::wherePostId($new->id)->whereStatus('1')->first();
      $logos =\App\Models\Upload::wherePostId($new->id)->whereStatus('1')->count();
     ?>
   
@if($logos>0)
<a target="_blank" href="{{ url('/') }}{{ $logo->file_path }}" class="btn btn-success"> Download</a>
@endif
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
      @endforeach
                     @else
                                    No note added
                                    @endif

                                    {{$samples->links("pagination::bootstrap-4")}}
                        
                        </div>
                        <!-- ROW-2 CLOSE -->


</div>
</div>
</div>





@endsection