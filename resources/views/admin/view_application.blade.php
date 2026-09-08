@extends('layouts.appbar')
<script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js"></script>

@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
 <div class="side-app">

  <!-- CONTAINER -->
  <div class="main-container container-fluid">

    @include('chat_count')




<!-- ROW OPEN -->
<div class="row row-cards">


  <div class="col-lg-8 col-xl-8">


    <div class="card">
     <div class="card-header">


      <h4 class="card-title">
        <span class="badge bg-secondary fs-14 me-2">


          <?php
          if($order->status =='0') {
            echo 'Pending';
          }

          if($order->status =='1') {
            echo 'Approved';
          }

          if($order->status =='2') {
            echo 'Rejected';
          }



          ?>
        </span><strong>Application ID: {{$order->id }}</strong>



      </h4>

      <div class="page-options ms-auto">

  






</div>



</div>

<div class="card-body">
@if($order->order_cancelreason)
 <div class="row" style="background-color: #E9E9EA; padding: 20px; margin-bottom: 20px;">
  <p>This order has been cancelled </p><br>
 {{ $order->order_cancelreason  }}
</div>
@endif


 @if(Auth::user()->is_admin() or Auth::user()->is_writer() or Auth::user()->is_subadmin())
 @if($order->order_fine>0)
 <div class="row" style="background-color: #E9E9EA; padding: 20px; margin-bottom: 20px;">
  <p>This order was fined {{ price($order->order_fine ) }}</p><br>
  {!! $order->order_finereason !!}
</div>
@endif
@endif

@if($order->dispute_option>0)
<div class="row" style="background-color: #E9E9EA; padding: 20px; margin-bottom: 20px;">
  <p>Dispute has been solved ({{ dispute($order->dispute_option ) }})</p><br>
  {!! $order->dispute_comment !!}
</div>
@endif

<?php
$revisions = \App\Models\Dispute::whereOrderId($order->id)->orderBy('id', 'desc')->get();
?>
@if($revisions->count()>0)
<div class="row" style="background-color: #FFEAE9; padding: 20px; margin-bottom: 20px;">


  <h4 style="color: #000000;">Issue</h4>


  @foreach($revisions as $revision)
  <div class="col-md-12" style="color: #000000;">
    {!! $revision->issues !!}


    @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
    <a style="color: #ffffff;" class="btn btn-sm btn-info" data-bs-target="#update-revision{{ $revision->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Update
    </a>

    <a style="color: #ffffff;" class="btn btn-sm btn-danger" data-bs-target="#delete-revision{{ $revision->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Delete
    </a>

    <!-- update modal-->
    <div class="modal fade" id="update-revision{{ $revision->id }}">
     <div class="modal-dialog modal-dialog-centered" role="document">
       <div class="modal-content country-select-modal">
         <div class="modal-header">
           <h6 class="modal-title">Confirm you want to update #{{ $revision->id }} revision</h6><button aria-label="Close" class="btn-close"
           data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
         </div>
         <div class="modal-body">
           <form class="form-horizontal" action="{{ route('update_revision')}}" method="POST">
             @csrf
             <input type="hidden" name="id" value="{{ $revision->id }}">


             <div class=" row mb-4">
              <label class="col-md-4 form-label">Instructions</label>
              <div class="col-md-12">
                <textarea rows="5" name="instructions" id="editor{{ $revision->id }}" placeholder="">{!! $revision->instructions !!}</textarea>
                <script>
                  ClassicEditor
                  .create( document.querySelector( '#editor{{ $revision->id }}' ) )
                  .catch( error => {
                    console.error( error );
                  } );
                </script>

              </div>
            </div>
            <div class=" row mb-4">
              <div class="col-md-9">
                <input type="submit" value="Yes Proceed" class="btn btn-danger">
              </div>


            </div>



          </form>
        </div>
      </div>
    </div>
  </div>


  <!-- delete modal-->
  <div class="modal fade" id="delete-revision{{ $revision->id }}">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content country-select-modal">
       <div class="modal-header">
         <h6 class="modal-title">Confirm you want to delete #{{ $revision->id }} revision</h6><button aria-label="Close" class="btn-close"
         data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
       </div>
       <div class="modal-body">
         <form class="form-horizontal" action="{{ route('delete_revision')}}" method="POST">
           @csrf
           <input type="hidden" name="id" value="{{ $revision->id }}">


           <div class=" row mb-4">


            <p>Are you sure you want to delete this revision?</p>
          </div>
          <div class=" row mb-4">
            <div class="col-md-9">
              <input type="submit" value="Yes Proceed" class="btn btn-danger">
            </div>


          </div>



        </form>
      </div>
    </div>
  </div>
</div>

@endif

</div>


<hr style="border-top: 1px solid #000000;">
@endforeach


</div>
@endif




<?php
$revisions = \App\Models\Revision::whereOrderId($order->id)->orderBy('id', 'desc')->get();
?>
@if($revisions->count()>0)
<div class="row" style="background-color: #FFEAE9; padding: 20px; margin-bottom: 20px;">


  <h4 style="color: #000000;">Revisions Instructions</h4>


  @foreach($revisions as $revision)
  <div class="col-md-12" style="color: #000000;">
    {!! $revision->instructions !!}
    @if(Auth::user()->is_writer())
    <div class="alert alert-info">Dear Writer, <br>When revising a paper, always use the edited copy that was sent to the client (Check the latest date). DO NOT use the paper you had sent to the system as a number of edits were done to improve the paper.</div>
    @endif
    Due at: {!! remainingtime($revision->due_at) !!}
    @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
    <a style="color: #ffffff;" class="btn btn-sm btn-info" data-bs-target="#update-revision{{ $revision->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Update
    </a>

    <a style="color: #ffffff;" class="btn btn-sm btn-danger" data-bs-target="#delete-revision{{ $revision->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Delete
    </a>

    <!-- update modal-->
    <div class="modal fade" id="update-revision{{ $revision->id }}">
     <div class="modal-dialog modal-dialog-centered" role="document">
       <div class="modal-content country-select-modal">
         <div class="modal-header">
           <h6 class="modal-title">Confirm you want to update #{{ $revision->id }} revision</h6><button aria-label="Close" class="btn-close"
           data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
         </div>
         <div class="modal-body">
           <form class="form-horizontal" action="{{ route('update_revision')}}" method="POST">
             @csrf
             <input type="hidden" name="id" value="{{ $revision->id }}">


             <div class=" row mb-4">
              <label class="col-md-4 form-label">Instructions</label>
              <div class="col-md-12">
                <textarea rows="5" name="instructions" id="editor{{ $revision->id }}" placeholder="">{!! $revision->instructions !!}</textarea>
                <script>
                  ClassicEditor
                  .create( document.querySelector( '#editor{{ $revision->id }}' ) )
                  .catch( error => {
                    console.error( error );
                  } );
                </script>

              </div>
            </div>
            <div class=" row mb-4">
              <div class="col-md-9">
                <input type="submit" value="Yes Proceed" class="btn btn-danger">
              </div>


            </div>



          </form>
        </div>
      </div>
    </div>
  </div>


  <!-- delete modal-->
  <div class="modal fade" id="delete-revision{{ $revision->id }}">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content country-select-modal">
       <div class="modal-header">
         <h6 class="modal-title">Confirm you want to delete #{{ $revision->id }} revision</h6><button aria-label="Close" class="btn-close"
         data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
       </div>
       <div class="modal-body">
         <form class="form-horizontal" action="{{ route('delete_revision')}}" method="POST">
           @csrf
           <input type="hidden" name="id" value="{{ $revision->id }}">


           <div class=" row mb-4">


            <p>Are you sure you want to delete this revision?</p>
          </div>
          <div class=" row mb-4">
            <div class="col-md-9">
              <input type="submit" value="Yes Proceed" class="btn btn-danger">
            </div>


          </div>



        </form>
      </div>
    </div>
  </div>
</div>

@endif

</div>


<hr style="border-top: 1px solid #000000;">
@endforeach


</div>


@if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
@if($order->ccost < 1)
<div class="alert alert-warning"><p>Client is waiting you evaluate this order</p></div>

<a class="btn btn-sm btn-warning badge" data-bs-target="#cost-order{{ $order->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Update order cost
</a> 

<!-- edit modal-->
<div class="modal fade" id="cost-order{{ $order->id }}">
 <div class="modal-dialog modal-dialog-centered" role="document">
   <div class="modal-content country-select-modal">
     <div class="modal-header">
       <h6 class="modal-title">Update cost of order #{{ $order->id }}</h6><button aria-label="Close" class="btn-close"
       data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
     </div>
     <div class="modal-body">
       <form class="form-horizontal" action="{{ route('cost_order')}}" method="POST">
         @csrf
         <input type="hidden" name="order_id" value="{{ $order->id }}">


         <div class=" row mb-4">
           <label class="col-md-3 form-label">Amount ({{Auth::user()->currency_sign}})</label>
           <div class="col-md-9">
             <input type="text"  class="form-control" name="amount" value="{{ $order->ccost }}">
           </div>


         </div>


         <div class=" row mb-4">

           <div class="col-md-9">


            <input type="submit" value="Submit" class="btn btn-primary">


          </div>


        </div>



      </form>
    </div>
  </div>
</div>
</div>
@endif


@endif
@endif

<hr style="border-top: 1px solid #000000;">

Applying to work on <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3"> {{ $order->applying_for }}</span>

<div class=" row mb-4">
  <label class="col-md-3 form-label">Full Name</label>
  <div class="col-md-9">
    <p>{{ $order->name }}</p>
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">





<div class=" row mb-4">
  <label class="col-md-3 form-label">Url for companies worked for: </label>
  <div class="col-md-9">
    <p>{{ $order->url_companies }} </p>
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">


<div class=" row mb-4">
  <label class="col-md-3 form-label">Url for your writer profile: </label>
  <div class="col-md-9">
    <p>{{ $order->url_profiles }} </p>
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">



@if($order->user_id != '0')
<div class=" row mb-4">
  <label class="col-md-3 form-label">Writer ID:</label>
  <div class="col-md-9">
    @if($order->user_id)
    <p><a target="_blank" href="{{ route('profile', userslug($order->user_id) )}}">{{ username($order->user_id)->nickname ?? 'none' }}: #{{ $order->user_id }}</a></p>
    @endif
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif


@if($order->preferred_writer)
<div class=" row mb-4">
  <label class="col-md-3 form-label">Preferred Writer ID:</label>
  <div class="col-md-9">

    <p style="color: green;"><a target="_blank" href="{{ route('profile', userslug($order->preferred_writer) )}}"> {{ username($order->preferred_writer)->nickname ?? 'none' }} #{{ $order->preferred_writer }}</a> 



    </p>


    @if($order->preferred_writer_only == '1')
    <p style="color: red;">Work with preffered writer only</p> 
    @endif
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif




@if($order->category_id)
<div class=" row mb-4">
  <label class="col-md-3 form-label">Discipline:</label>
  <div class="col-md-9">

    <p>{{ subject($order->category_id) }}</p>
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif


@if($order->word_count)
<div class=" row mb-4">
  <label class="col-md-3 form-label">Number of pages:</label>
  <div class="col-md-9">
    {{ $order->word_count }} @if($order->word_count == 1) page @else pages @endif 
    (@if($order->order_style==1){{ $order->word_count*275 }}@else {{ $order->word_count*275*2 }} @endif words)<br>
    @if($order->order_style==2)
    Single
    @else
    Double 
    @endif
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif

@if($order->slide)
<div class=" row mb-4">
  <label class="col-md-3 form-label">PowerPoint Slides:</label>
  <div class="col-md-9">
    {{ $order->slide }} slide
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif

@if($order->sources)
<div class=" row mb-4">
  <label class="col-md-3 form-label">Sources to be cited:</label>
  <div class="col-md-9">
    {{ $order->sources }}
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif

@if($order->order_citation)
<div class=" row mb-4">
  <label class="col-md-3 form-label">Paper format:</label>
  <div class="col-md-9">
    {{ $order->order_citation }}
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif


@if($order->completed_at)
<div class=" row mb-12">
  <label class="col-md-3 form-label">Order was completed:</label>
  <div class="col-md-9">
  {!! remainingtime($order->completed_at) !!}
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif



@if(Auth::user()->is_editor() or Auth::user()->is_client() or Auth::user()->is_student())

@if($order->created_at)
<div class=" row mb-12">
  <label class="col-md-3 form-label">Order was posted:</label>
  <div class="col-md-9">
    {!! $order->created_at->diffForHumans() !!}
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif

@if($order->plagiarism_report)

<div class=" row mb-4">
  <label class="col-md-3 form-label">Plagiarism Report:</label>
  <div class="col-md-9">
    <span style="color: red;">{{ plagiarism_report($order->plagiarism_report) }}</span>
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif
@endif

@if(Auth::user()->is_client() or Auth::user()->is_student())
@if($order->personal_note)
<div class=" row mb-4">
  <label class="col-md-3 form-label">Personal Note:</label>
  <div class="col-md-9">
    <div class="col-sm-12 alert alert-info">
      <p>{{ $order->personal_note }}</p>
    </div>
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif
@endif

@if(Auth::user()->is_client())
<div class=" row mb-4">

  <div class="col-md-12">
    <div id="accordion">


      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Add Personal Note (eg. I downloaded and submitted the order)
        </button>
      </h5>

      <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
        <div class="card-body">
          <form role="form" name="form" id="myform" action="{{ route('order_clientnote')}}" method="POST">
            <input type="hidden" name="order_id" value="{{ $order->id}}">
            <textarea class="form-control border-default" name="order_clientnote" id="note1" >{{ $order->order_clientnote }} </textarea>

            <script>
              ClassicEditor
              .create( document.querySelector( '#note1' ) )
              .catch( error => {
                console.error( error );
              } );
            </script>
            <br/>
            <button type="submit" class="btn btn-info">Add Note</button>
          </form>

        </div>
      </div>

    </div>
    @if($order->order_clientnote)
    <div class="alert alert-success ops-sm-12">            
      <p> My's Note </p>
      <?php echo $order->order_clientnote; ?> 
    </div>
    @endif
  </div>
</div>

@endif


@if($order->description)
<div class=" row mb-4">
  <hr style="border: 2px;">
  <label class="col-md-3 form-label"><strong>Instructions</strong></label>
  <div class="col-md-12">
    <main> {!! $order->description !!}</main>

  </div>
</div>
@endif

@if(Auth::user()->is_client() or Auth::user()->is_admin())
<div class=" row mb-4">

  <div class="col-md-12">
    <div id="accordion">


      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree1" aria-expanded="false" aria-controls="collapseThree">
          Add Comment
        </button>
      </h5>

      <div id="collapseThree1" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
        <div class="card-body">
          <form role="form" name="form" id="myform" action="{{ route('order_clientnotewriter')}}" method="POST">
            <input type="hidden" name="order_id" value="{{ $order->id}}">
            <textarea class="form-control border-default" name="order_clientnotewriter" id="note2" >{{ $order->order_clientnotewriter }} </textarea>

            <script>
              ClassicEditor
              .create( document.querySelector( '#note2' ) )
              .catch( error => {
                console.error( error );
              } );
            </script>
            <br/>
            <button type="submit" class="btn btn-info">Add Comment</button>
          </form>

        </div>
      </div>

    </div>

  </div>
</div>

@endif

@if($order->order_clientnotewriter)
<div class="alert alert-info ops-sm-12">            
  <p> Order Comment </p>

  <span style="font-size: 12px;">  <?php echo $order->order_clientnotewriter; ?> </span>

</div>
@endif

@if(Auth::user()->is_client() or Auth::user()->is_student())
@if($order->status==0)  
@if($order->order_level == 'normal' or $order->ccost > 0)  
<form class="form-horizontal" action="{{ route('confirm_order')}}" method="POST">
 @csrf
 <input type="hidden" name="id" value="{{ $order->id }}">



 <div class=" row mb-4">
  @if($order->urgency_id)
  <div class="col-md-9">
    <?php 

    $pricing = \App\Models\Pricing::find($order->urgency_id);
    ?>                                          
    @if($order->word_count <= $pricing->max_page)
    @if(wallet(Auth::user()->id)<$order->ccost)
    <input type="submit" value="Proceed to make payment for {{ get_currency() }} {{ $order->ccost - wallet(Auth::user()->id) }}" class="btn btn-success">
    @else

    <input type="submit" value="Submit" class="btn btn-primary">

    @endif

    @else

    <p class="alert alert-danger"><strong>{!! remainingtime($order->order_due) !!}</strong> <br>Sorry, we can not deliver the task with specified deadline, kindly adjust it if posible</p>

    <a href="{{ route('edit_order', $order->id )}}" class="btn btn-sm btn-primary badge"><i class="fa fa-edit"></i> Edit</a>

    @endif
  </div>

  @else

  <p class="alert alert-danger"><strong>{!! remainingtime($order->order_due) !!}</strong> <br>Sorry, we can not deliver this task within specified deadline, kindly adjust it if posible</p>
  <input type="submit" value="Just Work On It" class="btn btn-primary">

  @endif


</div>



</form>
@endif
@endif
@endif


</div>
</div>







<div class="card">
 <div class="card-header border-bottom-0">


 </div>
 <div class="e-table px-5 pb-5">
   <div class="table-responsive table-lg">
     @if($uploads->count()>0)
     <table class="table border-top table-bordered mb-0">
       <tbody>
        <tr>
          <h3>Order samples</h3>
        </tr>

        @foreach($uploads as $upload)
        <?php
        $user = \App\Models\User::whereId($upload->user_id)->first();
        ?>
        <tr>
          <td>{{ $upload->name}}
          </td>
          <td>   <span style="color: green; font-size: 11px;" > Uploaded by {{ $user->user_type }} {{ $upload->created_at->diffForHumans() }}</span></td>

          <td>
            <!-- {{ $upload->file_path }} -->
            <!-- {{ get_option(site_id().'_main_site_url') }}/storage/uploads/{{ $upload->name }} -->
            <a href="{{ $upload->file_path }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-download"></i> Download</a>
     

      </td>

    </tr>
    @endforeach



  </tbody>

</table>

@endif


</div>
</div>
</div>
</div>

<div class="col-lg-4 col-xl-4">







  @if(Auth::user()->is_admin())

<div class="card">

  <div class="card-body">


  
    <form class="form-horizontal" method="POST" action="{{ route('change_status_application') }}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="order_id" value="{{ $order->id }}">

      <div class=" row mb-4">
        <div class="col-md-4">Status</div>
        <div class="col-md-8">
          <select class="form-control" name="status">
            <option value="{{ $order->status }}" selected>
              <?php
              if($order->status =='0') {
                echo 'Pending';
              }

              if($order->status =='1') {
                echo 'Approved';
              }

              if($order->status =='2') {
                echo 'Rejected';
              }

            

              ?>

            </option>
            <option value="0">Pending</option>
            <option value="1">Approved</option>
            <option value="2">Rejected</option>>
          </select>
        </div>
      </div>

      <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
          <button type="submit" class="btn btn-primary btn-sm">
            Update
          </button>
        </div>
      </div>
    </form>
























</div>




</div>

@endif


</div>
<!-- ROW CLOSED -->


</div>
</div>
</div>




@endsection
@section('page-js')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="{{ asset('assets/js/chat.js')}}"></script>

<!-- FILE UPLOADES JS -->
<script src="{{ asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
<script src="{{ asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>

<!-- INTERNAL File-Uploads Js-->
<script src="{{ asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>

<!-- Star Rating-1 Js-->
<script src="{{ asset('assets/plugins/ratings-2/jquery.star-rating.js')}}"></script>
<script src="{{ asset('assets/plugins/ratings-2/star-rating.js')}}"></script>



<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script>
 $(document).ready(function(){
  $(document).on('click', '#makePayment', function(e){

    e.preventDefault();

            var order_id    = document.getElementById('order_id').value;   // it will get id of clicked row
            var message_to   = document.getElementById('message_to').value;
            var message  = document.getElementById('message').value;

            // leave it blank before ajax call
            $('#modal-loader3').show();      // load ajax loader
            $('#makePayment').hide();
            $('#makePaymentDisabled').show();
            
            $.ajax({
              url: '{{ route('send_message') }}',
              type: 'post',
              data: 'order_id='+order_id+'&message_to='+message_to+'&message='+message,
              dataType: 'html'
            })
            .done(function(data){
               $('#dynamic-content3').html(data); // load response 
              //window.location = "{{ route('success_deposit', $order->id) }}";
              $('#makePaymentDisabled').hide();
              $('#modal-loader3').hide(); 
              $('#makePayment').show();


              $('body').addClass('timer-alert');
              var message = $("#message").val();
              var title = $("#title").val();
              if (message == "") {
                message = "Your message";
              }
              if (title == "") {
                title = "Your message";
              }
              message += "(close after 2 seconds)";

              swal({
                title: title,
                text: message,
                timer: 3000,
                showConfirmButton: false,
                html:true, 
                title:' Hi {{ username(Auth::user())->name }},', 
                text:'<b>Your message has been sent</b><br><br><br>(closes after 1 seconds)'
              });

            })
            .fail(function(){
              $('#dynamic-content3').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
              $('#modal-loader3').hide();
              $('#makePaymentDisabled').hide();
              $('#makePayment').show();
            });
            
          });



});

</script>

@if($order->status == 4 or $order->status == 5)
<script>
  $(document).ready(function(){
    $("button").click(function(){
      $("#box").load("{{ route('chat_lists', ['order_id' =>$order->id]) }}");
    });
  });
</script>



<script type="text/javascript">
  function loadlink(){

    // $('#reload').load("{{ route('chat_lists', ['order_id' =>$order->id]) }}");
    $("#box").load("{{ route('chat_lists', ['order_id' =>$order->id]) }}");
//         $('button').click(function() {
//   const audio = new Audio("{{ asset('assets/sound/mix1.wav')}}");
//   audio.play();
// });

}

loadlink();
setInterval(function(){
  loadlink()
}, 1000);
</script>
@endif

@endsection


