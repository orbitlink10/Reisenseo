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
       <div class="card-header">
        <h3 class="card-title">Payment Confirmation</h3>
      </div>
      <div class="card-body">
        <div class="card-pay">

          <p id="mpesa" style="color:#000000;"><strong>Heads up!</strong> Request sent to your mobile Phone. Check your phone and put your mpesa pin.</p><br>
          <div id="modal-loader3">
                  <img src="{{asset('uploads')}}/loader.gif">
                </div>
         <p id="result" style="color:#000000;"><strong>{{ $ResultDesc }}</strong> </p>

         <form id="myForm" class="form-horizontal" action="{{ route('confirm_payment')}}" method="GET">
          @csrf 
          <input type="hidden" name="id" value="{{ $transactionId }}"> 
          <input type="hidden" name="payment_id" value="{{ $payment_id }}">  
          <!-- <button class="btn btn-success">Proceed</button> -->
        </form>
        </div>
      </div>


    </div>
    <!-- COL-END -->





  </div>
  <!-- ROW CLOSED -->


</div>
</div>
</div>


@endsection
@section('page-js')



<script type="text/javascript">

  $(document).ready(function() {
  var ajaxCall = function() {
      $.ajax({
        type: 'get',
        url:"{{ route('confirm_payment')}}",
        data: $("#myForm").serialize(),
        success: function(data) {
          document.getElementById("result").innerHTML = data.msg;
            if (data.msg == "The service request is processed successfully."){
              window.location = "{{ route('success_deposit', $payment_id) }}";
            }
            if(data.msg =="DS timeout user cannot be reached" || data.msg == "The initiator information is invalid."){
              document.getElementById("result").innerHTML = '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong with your payment, Please try again... and check your phone to input mpesa pin <br> <a href="{{ url("cpay/".$payment_id)}}" class="btn btn-info">Try Again</a>';
              $('#modal-loader3').hide();
              $('#mpesa').hide();
            }
        }
      });
  }
  setInterval(ajaxCall, 1000);
});

</script>





@endsection

