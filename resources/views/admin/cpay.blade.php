@extends('layouts.appbar')
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
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
        <h3 class="card-title">Payment Methods</h3>
      </div>
      <div class="card-body">
        <div class="card-pay">
          <ul class="tabs-menu nav">
            @if(Auth::user()->is_student())
            <li><a href="#tab21" data-bs-toggle="tab" class="payment-icon active"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M19.6542969,7.5869141c-0.2009888-0.2196655-0.4307251-0.4111938-0.6829224-0.569397c0.2329712-1.2444458-0.1186523-2.5269165-0.9537964-3.4784546c-0.9375-1.0605469-2.5751953-1.5986328-4.8681641-1.5986328H7.2646484c-0.6590576,0.0014038-1.2197266,0.480957-1.3232422,1.1318359l-2.453125,15.5898438c-0.0911865,0.5485229,0.279541,1.0670776,0.828064,1.1582642c0.0548706,0.0090942,0.1104126,0.0136719,0.1660767,0.0136108h3.0460815l-0.1593628,1.0136719c-0.0817261,0.5153809,0.2698364,0.9993896,0.7852173,1.0811157c0.0480957,0.0076294,0.0967407,0.0115356,0.1454468,0.0116577h3.0634766c0.6047363,0.0022583,1.12146-0.4353638,1.218689-1.0322266l0.6065063-3.8271484l0.0409546-0.2167969c0.0169067-0.1159668,0.116272-0.2019653,0.2333984-0.2021484h0.4580078c3.6289062,0,5.8027344-1.7197266,6.4619141-5.1123047C20.7811279,10.1879883,20.5109253,8.7180176,19.6542969,7.5869141z M7.8912964,17.5264893l-0.2067261,1.3065186l-3.2089844-0.0107422L6.9296875,3.2236328c0.0270996-0.1637573,0.1690063-0.2837524,0.335022-0.2832031h5.8847656c1.9941406,0,3.3798828,0.4238281,4.1162109,1.2587891c0.7022095,0.8255005,0.9553833,1.942627,0.6777344,2.9902344l0.0020752,0.0003052l-0.0001221,0.0006714c-0.0166016,0.1054688-0.0351562,0.2138672-0.0566406,0.3251953l-0.0010376,0.0029297c-0.6494141,3.3476562-2.7207031,4.9755859-6.3330078,4.9755859H9.8271484c-0.661499-0.0014648-1.2243652,0.4816284-1.3232422,1.1357422L7.8912964,17.5264893z M19.4003906,11.359375c-0.5625,2.8955078-2.3544922,4.3027344-5.4794922,4.3027344h-0.4580078c-0.6051636-0.0033569-1.1224976,0.4347534-1.21875,1.0322266l-0.6152344,3.8729858l-0.0322266,0.1708984c-0.017334,0.1160889-0.1170044,0.2020874-0.234375,0.2021484l-3.0048828,0.0644531l0.6048584-3.8487549l0.5338135-3.3699951l-0.0040894-0.0006104l0.0001831-0.0012817c0.024353-0.1663208,0.1668701-0.2897339,0.335022-0.289978h1.7275391c3.9599609,0,6.3896484-1.8076172,7.2275391-5.375c0.0419922,0.0410156,0.0820312,0.0830078,0.1201172,0.1259766C19.5513916,9.1461182,19.7360229,10.3009644,19.4003906,11.359375z"/></svg> Paypal</a>
            </li>
            @else
            <li class="" style="display: {{ get_option(site_id().'_enable_mpesa') == 1 ? 'block' : 'none' }}"><a href="#tab20" class="payment-icon active" data-bs-toggle="tab">Lipa Na <img src="{{ asset('assets/images/payments/mpesa.png')}}" height="30"></a>
            </li>

            <li style="display: {{ get_option(site_id().'_enable_paypal') == 1 ? 'block' : 'none' }}"><a href="#tab21" data-bs-toggle="tab" class="payment-icon active"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M19.6542969,7.5869141c-0.2009888-0.2196655-0.4307251-0.4111938-0.6829224-0.569397c0.2329712-1.2444458-0.1186523-2.5269165-0.9537964-3.4784546c-0.9375-1.0605469-2.5751953-1.5986328-4.8681641-1.5986328H7.2646484c-0.6590576,0.0014038-1.2197266,0.480957-1.3232422,1.1318359l-2.453125,15.5898438c-0.0911865,0.5485229,0.279541,1.0670776,0.828064,1.1582642c0.0548706,0.0090942,0.1104126,0.0136719,0.1660767,0.0136108h3.0460815l-0.1593628,1.0136719c-0.0817261,0.5153809,0.2698364,0.9993896,0.7852173,1.0811157c0.0480957,0.0076294,0.0967407,0.0115356,0.1454468,0.0116577h3.0634766c0.6047363,0.0022583,1.12146-0.4353638,1.218689-1.0322266l0.6065063-3.8271484l0.0409546-0.2167969c0.0169067-0.1159668,0.116272-0.2019653,0.2333984-0.2021484h0.4580078c3.6289062,0,5.8027344-1.7197266,6.4619141-5.1123047C20.7811279,10.1879883,20.5109253,8.7180176,19.6542969,7.5869141z M7.8912964,17.5264893l-0.2067261,1.3065186l-3.2089844-0.0107422L6.9296875,3.2236328c0.0270996-0.1637573,0.1690063-0.2837524,0.335022-0.2832031h5.8847656c1.9941406,0,3.3798828,0.4238281,4.1162109,1.2587891c0.7022095,0.8255005,0.9553833,1.942627,0.6777344,2.9902344l0.0020752,0.0003052l-0.0001221,0.0006714c-0.0166016,0.1054688-0.0351562,0.2138672-0.0566406,0.3251953l-0.0010376,0.0029297c-0.6494141,3.3476562-2.7207031,4.9755859-6.3330078,4.9755859H9.8271484c-0.661499-0.0014648-1.2243652,0.4816284-1.3232422,1.1357422L7.8912964,17.5264893z M19.4003906,11.359375c-0.5625,2.8955078-2.3544922,4.3027344-5.4794922,4.3027344h-0.4580078c-0.6051636-0.0033569-1.1224976,0.4347534-1.21875,1.0322266l-0.6152344,3.8729858l-0.0322266,0.1708984c-0.017334,0.1160889-0.1170044,0.2020874-0.234375,0.2021484l-3.0048828,0.0644531l0.6048584-3.8487549l0.5338135-3.3699951l-0.0040894-0.0006104l0.0001831-0.0012817c0.024353-0.1663208,0.1668701-0.2897339,0.335022-0.289978h1.7275391c3.9599609,0,6.3896484-1.8076172,7.2275391-5.375c0.0419922,0.0410156,0.0820312,0.0830078,0.1201172,0.1259766C19.5513916,9.1461182,19.7360229,10.3009644,19.4003906,11.359375z"/></svg> Paypal</a>
            </li>


            @endif
          </ul>
          @if(Auth::user()->is_student())
          <div class="tab-content">
            <div style="">
              <div class="tab-pane active show" id="tab21">

                <div id="smart-button-container">
                  <div style="text-align: center;">
                    <div id="paypal-button-container"></div>
                  </div>
                </div>
                <script src="https://www.paypal.com/sdk/js?client-id={{ get_option(site_id().'_paypal_client_id') }}&enable-funding=venmo&currency={{ get_currency() }}" data-sdk-integration-source="button-factory"></script>
                <script>
                  function initPayPalButton() {
                    paypal.Buttons({
                      style: {
                        shape: 'rect',
                        color: 'gold',
                        layout: 'vertical',
                        label: 'paypal',

                      },

                      createOrder: function(data, actions) {
                        return actions.order.create({
                          purchase_units: [{"amount":{"currency_code":"USD","value":{{ $order->amount }}}}]
                        });
                      },

                      onApprove: function(data, actions) {
                        return actions.order.capture().then(function(orderData) {

            // Full available details
                          console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

            // Show a success message within this page, e.g.
                          const element = document.getElementById('paypal-button-container');
                          element.innerHTML = '';
                          element.innerHTML = '<h3>Thank you for your payment!</h3>';
                          window.location = "{{ route('success_deposit', $order->id) }}";

            // Or go to another URL:  actions.redirect('thank_you.html');

                        });
                      },

                      onError: function(err) {
                        console.log(err);
                      }
                    }).render('#paypal-button-container');
                  }
                  initPayPalButton();
                </script>
              </div>
            </div>

          </div>
          @else
          <div class="tab-content">
            <div style="display: {{ get_option(site_id().'_enable_mpesa') == 1 ? 'block' : 'none' }}">
              <div class="tab-pane active show" id="tab20">



            <div class="form-group" style="padding: 10px;">
              <label  class="col-sm-12 control-label">Mpesa No:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control"  id="phone" placeholder="Mobile Number (2547XXXXXXXX)"  required="">

                <input type="hidden" id="amount" placeholder="amt" value="{{ (int) $order->amount }}">
                <input type="hidden" id="pay_type" placeholder="amt" value="checkout">

                <input type="hidden" id="account" placeholder="account" value="{{ $order->id }}">
              </div>

              <div class="col-sm-4">
                <label class="control-label"><p>&nbsp;</p></label>
                <button id="makePayment" class="btn btn-sm btn-primary">Make Payment</button>
                <button id="makePaymentDisabled" style="display:none;" class="btn btn-sm btn-success" disabled>Processing...
                </button>
              </div>
            </div>


            <p id="result" style="color:#000000;"><strong></strong> </p>








                <div id="modal-loader3" style="display: none; text-align: center;">
                  <img src="{{asset('uploads')}}/loader.gif">
                </div>

                <!-- content will be load here -->                          
                <div id="dynamic-content3" style="padding: 10px; color: #000000;"></div><br/>




<script>
 $(document).ready(function(){
 $(document).on('click', '#makePayment', function(e){

                e.preventDefault();

            var phone    = document.getElementById('phone').value;   // it will get id of clicked row
            var amount   = document.getElementById('amount').value;
            var account  = document.getElementById('account').value;
            var pay_type = document.getElementById('pay_type').value;

            $('#dynamic-content3').html('<p align="center" style="color:#000000;"><strong>Heads up!</strong> Request sent to your mobile Phone. Proceed by paying from your mobile phone.</p>'); // leave it blank before ajax call
            $('#modal-loader3').show();      // load ajax loader
            $('#makePayment').hide();
            $('#makePaymentDisabled').show();


            $.ajax({
              type: 'get',
              url:"{{ url('bmpesa')}}",
              data: 'phone='+phone+'&amount='+amount+'&account='+account+'&pay_type='+pay_type,
              success: function(data) {

                console.log('File has uploaded');
                console.log(data.success);

                var ajaxCall = function() {
                  $.ajax({
                    type: 'get',
                    url:"{{ url('bconfirm-payment') }}/"+data.transactionId,
                    data: $("#myForm").serialize(),
                    success: function(data) {

                      document.getElementById("result").innerHTML = data.msg;

                      if (data.msg == "The service request is processed successfully."){
               
                      window.location = "{{ route('success_deposit', $order->id) }}";

                      }
                      if(data.msg =="DS timeout user cannot be reached" || data.msg == "The initiator information is invalid." || data.msg =="The balance is insufficient for the transaction."){
                        document.getElementById("result").innerHTML = '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong with your payment, Please try again... and check your phone to input mpesa pin <br> <a href="{{ url("cpay/".$order->id)}}" class="btn btn-info">Try Again</a>';
                        $('#modal-loader3').hide();
                        $('#mpesa').hide();
                      }

                    }
                  });
                }

                setInterval(ajaxCall, 1000);

              }
            });

            
          });



            });


          </script>




              </div>

            </div>
            <div style="display: {{ get_option(site_id().'_enable_paypal') == 1 ? 'block' : 'none' }}">
              <div class="tab-pane active" id="tab21">

                <div id="smart-button-container">
                  <div style="text-align: center;">
                    <div id="paypal-button-container"></div>
                  </div>
                </div>
                <script src="https://www.paypal.com/sdk/js?client-id={{ get_option(site_id().'_paypal_client_id') }}&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
                <script>
                  function initPayPalButton() {
                    paypal.Buttons({
                      style: {
                        shape: 'rect',
                        color: 'gold',
                        layout: 'vertical',
                        label: 'paypal',

                      },

                      createOrder: function(data, actions) {
                        return actions.order.create({
                          purchase_units: [{"amount":{"currency_code":"USD","value":"{{ $order->amount }}"}}]
                        });
                      },

                      onApprove: function(data, actions) {
                        return actions.order.capture().then(function(orderData) {

            // Full available details
                          console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

            // Show a success message within this page, e.g.
                          const element = document.getElementById('paypal-button-container');
                          element.innerHTML = '';
                          element.innerHTML = '<h3>Thank you for your payment!</h3>';
                          window.location = "{{ route('success_deposit', $order->id) }}";

            // Or go to another URL:  actions.redirect('thank_you.html');

                        });
                      },

                      onError: function(err) {
                        console.log(err);
                      }
                    }).render('#paypal-button-container');
                  }
                  initPayPalButton();
                </script>
              </div>
            </div>
            <div class="tab-pane" id="tab22">
             <p class="mb-0"><strong>Note:</strong> Currently we are not accepting payments made via Bank </p>
           </div>
         </div>

         @endif
       </div>
     </div>
   </div>


 </div>
 <!-- COL-END -->


 <div class="col-xl-4 col-md-12">

  <div class="card cart">

    <div class="card-body">
      <h3 class="card-title">{{ $order->payment_source }}</h3>

      <ul class="list-group border br-7 mt-5">

         <li class="list-group-item border-0">
         Wallet Balance
          <span class="h6 fw-bold mb-0 float-end">{{ price(wallet($order->user_id)) }}</span>
        </li>


        <li class="list-group-item border-0">
          Top Up Amount
          <span class="h6 fw-bold mb-0 float-end">{{ price((int) $order->amount) }}</span>
        </li>
        <li class="list-group-item border-0">
          Discount
          <span class="h6 fw-bold mb-0 float-end">0%</span>
        </li>

        <li class="list-group-item border-0">
          Total
          <span class="h4 fw-bold mb-0 float-end">{{ price((int) $order->amount) }}</span>
        </li>
      </ul>
    </div>

  </div>
</div>


</div>
<!-- ROW CLOSED -->


</div>
</div>
</div>


@endsection
@section('page-js')


<script>
  $(document).ready(function(){

            /**
             * Send order data to server
             */
   $('#settings_save_btn').click(function(e){
    e.preventDefault();

    var this_btn = $(this);
    this_btn.attr('disabled', 'disabled');

    var form_data = this_btn.closest('form').serialize();
    $.ajax({

      url : '{{ route('cmpesa') }}',
      "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
      type: "POST",
      data: form_data,
      success : function (data) {
        var order_id = 14;
        if (data.success == 1){

          this_btn.removeAttr('disabled');

          swal({
            showConfirmButton: false,
            html:true, 
            title: data.msg, 
            text:'<p align="center" style="color:#000000;"><strong>Heads up!</strong> Request sent to your mobile Phone. Check your phone and put your mpesa pin.</p><br> After you have made the payment click below button to proceed <br><form class="form-horizontal" action="{{ route("confirm_payment")}}" method="POST"> @csrf <input type="hidden" name="id" value="'+data.transactionId+'"> <input type="hidden" name="payment_id" value="{{ $order->id }}">  <button  class="btn btn-success">Proceed</button></form>'
        });
        }
      }
    });
  });



 });
</script>






@endsection

