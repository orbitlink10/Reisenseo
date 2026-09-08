@extends('layouts.appbar')

@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
   <div class="side-app">

     <!-- CONTAINER -->
     <div class="main-container container-fluid">

        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $title }}</h3>
                    </div>

                    @if($news->count()>0)
                    <div class="card-body">
                        <div class="accordion" id="accordionExample">

                          @foreach($news as $new)
                          


                          <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree{{ $new->id }}" aria-expanded="false" aria-controls="collapseThree">
                                  {{ $new->title }}
                              </button>
                          </h2>
                          <div id="collapseThree{{ $new->id }}" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body" style="background-color: #CACBCC;">
                                {!! $new->description !!}
                            </div>
                        </div>
                    </div>

                    @endforeach


                    
                </div>

                @else
                No note added
                @endif
            </div>
            {{$news->links("pagination::bootstrap-4")}}

        </div>


        
    </div>
</div>


</div>
</div>
</div>





@endsection