@extends('layouts.appbar')



@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
 <div class="side-app">

   <!-- CONTAINER -->
   <div class="main-container container-fluid">



    <!-- Row -->
    <div class="row" style="padding-top: 20px;">

      <div class="col-xl-9">

        <div class="card">
        <h1>Log Activity Lists</h1>

  <table class="table table-bordered">

    <tr>

      <th>No</th>

      <th>Subject</th>

      <th>URL</th>

      <th>Method</th>

      <th>Ip</th>

      <th width="300px">User Agent</th>

      <th>User Id</th>

   

    </tr>

    @if($logs->count())

      @foreach($logs as $key => $log)

      <tr>

        <td>{{ ++$key }}</td>

        <td>{!! $log->subject !!}<br><span style="font-size: 11px;">{{ $log->created_at->diffForHumans() }}</span>

        </td>

        <td class="text-success"><span style="font-size: 11px;">{{ $log->url }}</span>
          <br><span style="font-size: 11px;">{{ $log->referer }}</span></td>

        <td><label class="label label-info">{{ $log->method }}</label></td>

        <td class="text-warning">{{ $log->ip }}</td>

        <td class="text-danger">{{ $log->agent }}</td>

        <td>{{ username($log->user_id)->name }}</td>



      </tr>

      @endforeach

    @endif

  </table>


   
</div>
</div>
<!--End  Row -->


</div>
</div>
</div>





@endsection

@section('page-js')



@endsection