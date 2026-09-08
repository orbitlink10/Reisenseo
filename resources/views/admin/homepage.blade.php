     @extends('layouts.appbar')

     @section('content')      <!--app-content open-->
     <div class="main-content app-content mt-0">
        <div class="side-app">

            <!-- CONTAINER -->
            <div class="main-container container-fluid">



             <!-- ROW OPEN -->
             <div class="row row-cards" style="padding-top: 20px;">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">System Content </h3>
                    </div>
                    <div class="card-body">
                        <div class="card-pay">
                            <ul class="tabs-menu nav">
                             <li class=""><a href="#tab20" class="payment-icon active" data-bs-toggle="tab">Headers and Descriptions</a></li>
                             <li><a href="#tab21" data-bs-toggle="tab" class="payment-icon">How it works</a></li>
                             <li><a href="#tab22" data-bs-toggle="tab" class="payment-icon">  FAQS</a></li>
                         </ul>

                         <div class="tab-content">
                            <div class="tab-pane active show" id="tab20">
                                    <div class="col-lg-8 col-xl-8">
                  <div class="card">

                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('save_settings')}}" method="POST">
                            @csrf

                                                        <div class=" row mb-4">
                               <label class="col-md-4 form-label">Tagline </label>
                               <div class="col-md-8">

                                  <input type="text"  class="form-control" name="tagline" value="{{ get_option(site_id().'_tagline') }}">
                              </div>
                          </div>


                            <div class=" row mb-4">
                                <label class="col-md-4 form-label">Hero Header </label>
                                <div class="col-md-8">

                                    <input type="text"  class="form-control" name="hero_header" value="{{ get_option(site_id().'_hero_header') }}">
                                </div>
                            </div>

                             <div class=" row mb-4">
                                <label class="col-md-4 form-label">Hero description</label>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="hero_description">{{ get_option(site_id().'_hero_description') }}</textarea> 
                                </div>
                            </div>

         <hr style="border-top: 1px solid #000000;">


                            <div class=" row mb-4">
                                <label class="col-md-4 form-label">Features  Header </label>
                                <div class="col-md-8">

                                    <input type="text"  class="form-control" name="feature_header" value="{{ get_option(site_id().'_feature_header') }}">
                                </div>
                            </div>

                             <div class=" row mb-4">
                                <label class="col-md-4 form-label">Feature subheading</label>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="feature_subheading">{{ get_option(site_id().'_feature_subheading') }}</textarea> 
                                </div>
                            </div>


                            <div class=" row mb-4">
                                <label class="col-md-4 form-label">Features  Header 1 </label>
                                <div class="col-md-8">

                                    <input type="text"  class="form-control" name="feature_header1" value="{{ get_option(site_id().'_feature_header1') }}">
                                </div>
                            </div>

                             <div class=" row mb-4">
                                <label class="col-md-4 form-label">Feature description1</label>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="feature_description1">{{ get_option(site_id().'_feature_description1') }}</textarea> 
                                </div>
                            </div>


                                                        <div class=" row mb-4">
                                <label class="col-md-4 form-label">Features  Header 2 </label>
                                <div class="col-md-8">

                                    <input type="text"  class="form-control" name="feature_header2" value="{{ get_option(site_id().'_feature_header2') }}">
                                </div>
                            </div>

                             <div class=" row mb-4">
                                <label class="col-md-4 form-label">Feature description2</label>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="feature_description2">{{ get_option(site_id().'_feature_description2') }}</textarea> 
                                </div>
                            </div>


                                                        <div class=" row mb-4">
                                <label class="col-md-4 form-label">Features  Header 3 </label>
                                <div class="col-md-8">

                                    <input type="text"  class="form-control" name="feature_header3" value="{{ get_option(site_id().'_feature_header3') }}">
                                </div>
                            </div>

                             <div class=" row mb-4">
                                <label class="col-md-4 form-label">Feature description3</label>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="feature_description3">{{ get_option(site_id().'_feature_description3') }}</textarea> 
                                </div>
                            </div>


                                                        <div class=" row mb-4">
                                <label class="col-md-4 form-label">Features  Header 4 </label>
                                <div class="col-md-8">

                                    <input type="text"  class="form-control" name="feature_header4" value="{{ get_option(site_id().'_feature_header4') }}">
                                </div>
                            </div>

                             <div class=" row mb-4">
                                <label class="col-md-4 form-label">Feature description1</label>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="feature_description4">{{ get_option(site_id().'_feature_description4') }}</textarea> 
                                </div>
                            </div>

                            





                          <div class=" row mb-4">

                            <div class="col-md-9">
                               <button type="submit" id="settings_save_btn" class="btn btn-primary">Save settings</button>
                           </div>


                       </div>



                   </form>













               </div>
           </div>
       </div>
                                     
                        </div>
                        <div class="tab-pane" id="tab21">

                                <div class="col-lg-8 col-xl-8">
                  <div class="card">

                    <div class="card-body">
                          <form class="form-horizontal" action="{{ route('save_settings')}}" method="POST">
                            @csrf

                                                        <div class=" row mb-4">
                               <label class="col-md-4 form-label">How header </label>
                               <div class="col-md-8">

                                  <input type="text"  class="form-control" name="how_header" value="{{ get_option(site_id().'_how_header') }}">
                              </div>
                          </div>


                         

                             <div class=" row mb-4">
                                <label class="col-md-4 form-label">How description</label>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="how_description">{{ get_option(site_id().'_how_description') }}</textarea> 
                                </div>
                            </div>

                              <div class=" row mb-4">
                                 <div class="col-md-4">

                                  <input type="text"  class="form-control" name="post_order_header" value="{{ get_option(site_id().'_post_order_header') }}">
                              </div>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="post_order">{{ get_option(site_id().'_post_order') }}</textarea> 
                                </div>
                            </div>

                              <div class=" row mb-4">
                                <label class="col-md-4 form-label">Top up your wallet</label>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="top_wallet">{{ get_option(site_id().'_top_wallet') }}</textarea> 
                                </div>
                            </div>

                              <div class=" row mb-4">
                                <label class="col-md-4 form-label">Writer Assigned</label>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="writer_assigned">{{ get_option(site_id().'_writer_assigned') }}</textarea> 
                                </div>
                            </div>

                              <div class=" row mb-4">
                                <label class="col-md-4 form-label">Get the completed paper </label>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="get_paper">{{ get_option(site_id().'_get_paper') }}</textarea> 
                                </div>
                            </div>






                          <div class=" row mb-4">

                            <div class="col-md-9">
                               <button type="submit" id="settings_save_btn" class="btn btn-primary">Save settings</button>
                           </div>


                       </div>



                   </form>











               </div>
           </div>
       </div>
                         
           </div>
           <div class="tab-pane" id="tab22">

              <div class="col-lg-8 col-xl-8">
                  <div class="card">

                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('save_settings')}}" method="POST">
                            @csrf

                                                        <div class=" row mb-4">
                               <label class="col-md-4 form-label">FAQ header </label>
                               <div class="col-md-8">

                                  <input type="text"  class="form-control" name="faq_header" value="{{ get_option(site_id().'_faq_header') }}">
                              </div>
                          </div>


                         

                             <div class=" row mb-4">
                                <label class="col-md-4 form-label">Faq description</label>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="faq_description">{{ get_option(site_id().'_faq_description') }}</textarea> 
                                </div>
                            </div>
   <hr style="border-top: 1px solid #000000;">
   <h3>For Writers</h3>
                              <div class=" row mb-4">
                                <div class="col-md-4">
                                     1. <input type="text"  class="form-control" name="faq_header1" value="{{ get_option(site_id().'_faq_header1') }}">
                                </div>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="faq_description1">{{ get_option(site_id().'_faq_description1') }}</textarea> 
                                </div>
                            </div>

                                <div class=" row mb-4">
                                <div class="col-md-4">
                                     2. <input type="text"  class="form-control" name="faq_header2" value="{{ get_option(site_id().'_faq_header2') }}">
                                </div>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="faq_description2">{{ get_option(site_id().'_faq_description2') }}</textarea> 
                                </div>
                            </div>

                                <div class=" row mb-4">
                                <div class="col-md-4">
                                     3. <input type="text"  class="form-control" name="faq_header3" value="{{ get_option(site_id().'_faq_header3') }}">
                                </div>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="faq_description3">{{ get_option(site_id().'_faq_description3') }}</textarea> 
                                </div>
                            </div>

                                <div class=" row mb-4">
                                <div class="col-md-4">
                                     4. <input type="text"  class="form-control" name="faq_header4" value="{{ get_option(site_id().'_faq_header4') }}">
                                </div>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="faq_description4">{{ get_option(site_id().'_faq_description4') }}</textarea> 
                                </div>
                            </div>

                                <div class=" row mb-4">
                                <div class="col-md-4">
                                     5. <input type="text"  class="form-control" name="faq_header5" value="{{ get_option(site_id().'_faq_header5') }}">
                                </div>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="faq_description5">{{ get_option(site_id().'_faq_description5') }}</textarea> 
                                </div>
                            </div>

                              




                          <div class=" row mb-4">

                            <div class="col-md-9">
                               <button type="submit" id="settings_save_btn" class="btn btn-primary">Save settings</button>
                           </div>


                       </div>



                   </form>

                   <hr style="border-top: 1px solid #000000;">



   <form class="form-horizontal" action="{{ route('save_settings')}}" method="POST">
                            @csrf

                                             
   <hr style="border-top: 1px solid #000000;">
   <h3>Clients/Employers </h3>
                              <div class=" row mb-4">
                                <div class="col-md-4">
                                     1. <input type="text"  class="form-control" name="cfaq_header1" value="{{ get_option(site_id().'_cfaq_header1') }}">
                                </div>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="cfaq_description1">{{ get_option(site_id().'_cfaq_description1') }}</textarea> 
                                </div>
                            </div>

                                <div class=" row mb-4">
                                <div class="col-md-4">
                                     2. <input type="text"  class="form-control" name="cfaq_header2" value="{{ get_option(site_id().'_cfaq_header2') }}">
                                </div>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="cfaq_description2">{{ get_option(site_id().'_cfaq_description2') }}</textarea> 
                                </div>
                            </div>

                                <div class=" row mb-4">
                                <div class="col-md-4">
                                     3. <input type="text"  class="form-control" name="cfaq_header3" value="{{ get_option(site_id().'_cfaq_header3') }}">
                                </div>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="cfaq_description3">{{ get_option(site_id().'_cfaq_description3') }}</textarea> 
                                </div>
                            </div>

                                <div class=" row mb-4">
                                <div class="col-md-4">
                                     4. <input type="text"  class="form-control" name="cfaq_header4" value="{{ get_option(site_id().'_cfaq_header4') }}">
                                </div>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="cfaq_description4">{{ get_option(site_id().'_cfaq_description4') }}</textarea> 
                                </div>
                            </div>

                                <div class=" row mb-4">
                                <div class="col-md-4">
                                     5. <input type="text"  class="form-control" name="cfaq_header5" value="{{ get_option(site_id().'_cfaq_header5') }}">
                                </div>
                                <div class="col-md-8">

                                    <textarea class="form-control" name="cfaq_description5">{{ get_option(site_id().'_cfaq_description5') }}</textarea> 
                                </div>
                            </div>

                              




                          <div class=" row mb-4">

                            <div class="col-md-9">
                               <button type="submit" id="settings_save_btn" class="btn btn-primary">Save settings</button>
                           </div>


                       </div>



                   </form>







               </div>
           </div>
       </div> 
   </div>
</div>
</div>
</div>
</div>







</div>
<!-- ROW CLOSED -->


</div>
</div>
</div>




<script>
    $(document).ready(function(){


  /**
             * Send settings option value to server
             */
             $('#settings_save_btn').click(function(e){
                e.preventDefault();

                var this_btn = $(this);
                this_btn.attr('disabled', 'disabled');

                var form_data = this_btn.closest('form').serialize();
                $.ajax({
                    url : '{{ route('save_settings') }}',
                    type: "POST",
                    data: form_data,
                    success : function (data) {
                        if (data.success == 1){
                            this_btn.removeAttr('disabled');
                            toastr.success(data.msg, '@lang('app.success')', toastr_options);
                        }
                    }
                });
            });

         });
     </script>

     @endsection