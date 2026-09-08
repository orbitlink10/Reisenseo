@extends('layouts.appbar')

@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
   <div class="side-app">


       <!-- CONTAINER -->
       <div class="main-container container-fluid">

           <!-- ROW-4 -->
           <div class="row" style="padding-top: 20px;">
             




<h3>Pages setting</h3>

<div class="col-12 col-sm-12">

<h3>Check Menu to display at header</h3>
              <?php
              $pages = \App\Models\Page::all();
              ?>

              <form id="fileUploadForm" class="form-horizontal" action="{{ route('save_settings')}}" method="POST" enctype="multipart/form-data">

                @csrf
                <input type="hidden" name="site_id" value="{{ $site_id }}">



                @foreach($pages as $page)




                <div class=" row mb-4">


                <div class="col-md-8">

                  <textarea type="text"  class="form-control" name="meta_description" placeholder="Meta description">{{ get_option($user->id.'_show_'.$page->id.'_meta') }}
                  </textarea>


                  <textarea  id="summernote{{ $page->id }}" name="description">

                  </textarea>



                  <script>
                    ClassicEditor
                    .create( document.querySelector( '#summernote{{ $page->id }}' ) );
                  </script>




                </div>
              </div>


              @endforeach
</div>
<!-- CONTAINER END -->
</div>
</div>
<!-- CHART-CIRCLE JS-->
<script src="{{ asset('assets/js/circle-progress.min.js')}}"></script>
<!--app-content close-->
<script src="{{ asset('assets/plugins/peitychart/jquery.peity.min.js')}}"></script>
<script src="{{ asset('assets/plugins/peitychart/peitychart.init.js')}}"></script>
<!-- INTERNAL CHARTJS CHART JS-->
<script src="{{ asset('assets/plugins/chart/Chart.bundle.js')}}"></script>
<script src="{{ asset('assets/plugins/chart/rounded-barchart.js')}}"></script>
<script src="{{ asset('assets/plugins/chart/utils.js')}}"></script>

<!-- INTERNAL APEXCHART JS -->
<script src="{{ asset('assets/js/apexcharts.js')}}"></script>
<script src="{{ asset('assets/plugins/apexchart/irregular-data-series.js')}}"></script>

<!-- INTERNAL Vector js -->
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>

<!-- SPARKLINE JS-->
<script src="{{ asset('assets/js/jquery.sparkline.min.js')}}"></script>



@endsection