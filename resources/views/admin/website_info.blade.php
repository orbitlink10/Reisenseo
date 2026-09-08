@extends('layouts.appbar')
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js"></script>
@section('content')      <!--app-content open-->
<!--app-content open-->
<div class="main-content app-content mt-0">
  <div class="side-app">

    <!-- CONTAINER -->
    <div class="main-container container-fluid">

      <!-- PAGE-HEADER -->
      <div class="page-header">
        <h1 class="page-title">Awasam Theme Options
        </h1>
        <div>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('websites')}}">Websites</a></li>
            <li class="breadcrumb-item active" aria-current="page">Website Settings</li>
          </ol>
        </div>

      </div>
      <!-- PAGE-HEADER END -->

      <script type="text/javascript">
        function paymentMethod() {
         document.getElementById('manageMenu').style.display = "none";
         document.getElementById('paymentMethod').style.display = "block";
         document.getElementById('showAccount').style.display = "none";
         document.getElementById('options').style.display = "none";
         document.getElementById('fileStorage').style.display = "none";
         document.getElementById('customerRules').style.display = "none";
         document.getElementById('homepageContent').style.display = "none";
         document.getElementById('websiteContent').style.display = "none";
         document.getElementById('messagesConfiguration').style.display = "none";
       }

       function showAccount() {
         document.getElementById('manageMenu').style.display = "none";
         document.getElementById('showAccount').style.display = "block";
         document.getElementById('options').style.display = "none";
         document.getElementById('paymentMethod').style.display = "none";
         document.getElementById('fileStorage').style.display = "none";
         document.getElementById('customerRules').style.display = "none";
         document.getElementById('homepageContent').style.display = "none";
         document.getElementById('websiteContent').style.display = "none";
         document.getElementById('messagesConfiguration').style.display = "none";
       }

       function showOptions() {
         document.getElementById('manageMenu').style.display = "none";
         document.getElementById('options').style.display  = "block";
         document.getElementById('showAccount').style.display = "none";
         document.getElementById('paymentMethod').style.display = "none";
         document.getElementById('fileStorage').style.display = "none";
         document.getElementById('customerRules').style.display = "none";
         document.getElementById('homepageContent').style.display = "none";
         document.getElementById('websiteContent').style.display = "none";
         document.getElementById('messagesConfiguration').style.display = "none";
       }

       function fileStorage() {
        document.getElementById('manageMenu').style.display = "none";
        document.getElementById('fileStorage').style.display = "block";
        document.getElementById('options').style.display = "none";
        document.getElementById('showAccount').style.display = "none";
        document.getElementById('paymentMethod').style.display = "none";
        document.getElementById('customerRules').style.display = "none";
        document.getElementById('homepageContent').style.display = "none";
        document.getElementById('websiteContent').style.display = "none";
        document.getElementById('messagesConfiguration').style.display = "none";
      }


      function customerRules() {
        document.getElementById('manageMenu').style.display = "none";
        document.getElementById('customerRules').style.display = "block";
        document.getElementById('fileStorage').style.display = "none";
        document.getElementById('options').style.display = "none";
        document.getElementById('showAccount').style.display = "none";
        document.getElementById('paymentMethod').style.display = "none";
        document.getElementById('homepageContent').style.display = "none";
        document.getElementById('websiteContent').style.display = "none";
        document.getElementById('messagesConfiguration').style.display = "none";
      }


      function homepageContent() {
        document.getElementById('manageMenu').style.display = "none";
        document.getElementById('homepageContent').style.display = "block";
        document.getElementById('customerRules').style.display = "none";
        document.getElementById('fileStorage').style.display = "none";
        document.getElementById('options').style.display = "none";
        document.getElementById('showAccount').style.display = "none";
        document.getElementById('paymentMethod').style.display = "none";
        document.getElementById('websiteContent').style.display = "none";
        document.getElementById('messagesConfiguration').style.display = "none";
      }


      function websiteContent() {
       document.getElementById('manageMenu').style.display = "none";
       document.getElementById('websiteContent').style.display = "block";
       document.getElementById('homepageContent').style.display = "none";
       document.getElementById('customerRules').style.display = "none";
       document.getElementById('fileStorage').style.display = "none";
       document.getElementById('options').style.display = "none";
       document.getElementById('showAccount').style.display = "none";
       document.getElementById('paymentMethod').style.display = "none";
       document.getElementById('messagesConfiguration').style.display = "none";
     }

     function messagesConfiguration() {
       document.getElementById('manageMenu').style.display = "none";

       document.getElementById('messagesConfiguration').style.display = "block";
       document.getElementById('websiteContent').style.display = "none";
       document.getElementById('homepageContent').style.display = "none";
       document.getElementById('customerRules').style.display = "none";
       document.getElementById('fileStorage').style.display = "none";
       document.getElementById('options').style.display = "none";
       document.getElementById('showAccount').style.display = "none";
       document.getElementById('paymentMethod').style.display = "none";
     }


     function manageMenu() {

       document.getElementById('manageMenu').style.display = "block";
       document.getElementById('messagesConfiguration').style.display = "none";
       document.getElementById('websiteContent').style.display = "none";
       document.getElementById('homepageContent').style.display = "none";
       document.getElementById('customerRules').style.display = "none";
       document.getElementById('fileStorage').style.display = "none";
       document.getElementById('options').style.display = "none";
       document.getElementById('showAccount').style.display = "none";
       document.getElementById('paymentMethod').style.display = "none";

     }
   </script>

   <!-- Row -->
   <div class="row ">
    <div class="col-lg-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="list-group list-group-transparent mb-0 file-manager file-manager-border">
            <h4>General</h4>

            <div>
              <a href="javascript:void(0);" onclick="showOptions()" class="list-group-item  d-flex align-items-center px-0 border-top">
                <i class="fe fe-settings fs-18 me-2 text-success p-2"></i>Theme Options
              </a>
            </div>

            <div>
              <a href="javascript:void(0);" onclick="showAccount()" class="list-group-item  d-flex align-items-center px-0">
                <i class="fe fe-user fs-18 me-2 text-secondary p-2"></i>Account Settings
              </a>
            </div>

            <div>
              <a href="javascript:void(0);" onclick="paymentMethod()" class="list-group-item  d-flex align-items-center px-0">
                <i class="fa fa-credit-card fs-18 me-2 text-primary p-2"></i> Payment Method
              </a>
            </div>

            <div>
              <a href="javascript:void(0);" onclick="messagesConfiguration()" class="list-group-item  d-flex align-items-center px-0">
                <i class="fa fa-comment fs-18 me-2 text-primary p-2"></i> Messages Configuration
              </a>
            </div>

            <div>
              <a href="javascript:void(0);" onclick="fileStorage()" class="list-group-item  d-flex align-items-center px-0">
                <i class="fe fe-file fs-18 me-2 text-warning p-2"></i> File Storage
              </a>
            </div>

            <div>
              <a href="javascript:void(0);" onclick="customerRules()" class="list-group-item  d-flex align-items-center px-0">
                <i class="fa fa-file-o fs-18 me-2 text-info p-2"></i> Customers Rules
              </a>
            </div>

            <div>
              <a href="javascript:void(0);" onclick="homepageContent()" class="list-group-item  d-flex align-items-center px-0">
                <i class="fe fe-database fs-18 me-2 text-pink p-2"></i> Homepage Content
              </a>
            </div>

            <div>
              <a href="#content" onclick="websiteContent()" class="list-group-item  d-flex align-items-center px-0">
                <i class="fe fe-battery-charging fs-18 me-2 text-green p-2"></i> Website Content
              </a>
            </div>

            <div>
              <a href="#content" onclick="manageMenu()" class="list-group-item  d-flex align-items-center px-0">
                <i class="fe fe-battery-charging fs-18 me-2 text-green p-2"></i> Manage Menu
              </a>
            </div>


 




          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-xl-9">
      <div class="row row-sm">
        <div class="col-xl-12 col-xxl-12">
          <div class="card">
            <div class="card-body">


             <div id="manageMenu" style="display: none;">

              <h3>Check Menu to display at header</h3>
              <?php
              $pages = \App\Models\Page::all();
              ?>

              <form id="fileUploadForm" class="form-horizontal" action="{{ route('save_settings')}}" method="POST" enctype="multipart/form-data">

                @csrf
                <input type="hidden" name="site_id" value="{{ $user->id }}">



                @foreach($pages as $page)




                <div class=" row mb-4">

                 <label for="_show_features" class="checkbox-inline col-md-4 form-label">
                  <input type="checkbox" value="1" id="_show_{{ $page->id }}" name="{{ $user->id }}_show_{{ $page->id }}" {{ get_option($user->id.'_show_'.$page->id) == 1 ? 'checked="checked"': '' }}>
                  {!! $page->name !!}
                </label>
                
                <div class="col-md-8">


                         <input type="text" class="form-control" name="{{ $user->id }}_show_{{ $page->id }}_keyword" value="{{ get_option($user->id.'_show_'.$page->id.'_keyword') }}">

                  <textarea type="text"  class="form-control" name="{{ $user->id }}_show_{{ $page->id }}_meta" placeholder="Meta description">{{ get_option($user->id.'_show_'.$page->id.'_meta') }}
                  </textarea>


                  <textarea  id="summernote{{ $page->id }}" name="{{ $user->id }}_show_{{ $page->id }}_content">
                     {{ get_option($user->id.'_show_'.$page->id.'_content') }}
                   </textarea>
                   <script>
                    $('#summernote{{ $page->id }}').summernote({
                      placeholder: 'Type your content here',
                      tabsize: 2,
                      height: 300,
                      toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                        ]
                    });
                  </script>




                </div>
              </div>


              @endforeach

              <div class=" row mb-4">

                <div class="col-md-9">

                </div>


              </div>



            </div>
            <div id="messagesConfiguration" style="display: none;">

             <div class="col-lg-8 col-xl-12">
              <div class="card">

                <div class="card-body">






                  <div class=" row mb-4">
                   <label class="col-md-4 form-label">Chat Api </label>
                   <div class="col-md-8">

                    <input type="text"  class="form-control" name="{{ $user->id }}_chat_api" value="{{ get_option($user->id.'_chat_api') }}">
                  </div>
                </div>



                <div class=" row mb-4">
                  <label class="col-md-4 form-label">Afrs Username</label>
                  <div class="col-md-8">
                    <input type="text" name="{{ get_option($user->id.'_afrs_username') }}" value="{{ get_option($user->id.'_afrs_username') }}" class="form-control">
                  </div>
                </div>


                <div class=" row mb-4">
                  <label class="col-md-4 form-label">Afrs Api Key</label>
                  <div class="col-md-8">
                    <input type="text" name="{{ get_option($user->id.'_afrs_apikey') }}" value="{{ get_option($user->id.'_afrs_apikey') }}" class="form-control">
                  </div>
                </div>


                <div class=" row mb-4">
                  <label class="col-md-4 form-label">Afrs From</label>
                  <div class="col-md-8">
                    <input type="text" name="{{ get_option($user->id.'_afrs_from') }}" value="{{ get_option($user->id.'_afrs_from') }}" class="form-control">
                  </div>
                </div>








                <div class=" row mb-4">

                  <div class="col-md-9">

                  </div>


                </div>















              </div>
            </div>
          </div>

        </div>


        <div id="websiteContent" style="display: none;">
          <!-- ROW OPEN -->
          <div class="row row-cards" style="padding-top: 20px;">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Website Content </h3>
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
                    <div class="col-lg-12 col-xl-12">
                      <div class="card">

                        <div class="card-body">



                          <input type="hidden" name="{{ $user->id }}_site_id" value="{{ $user->id }}">





                          <div class=" row mb-4">
                           <label class="col-md-4 form-label">Tagline </label>
                           <div class="col-md-8">

                            <input type="text"  class="form-control" name="{{ $user->id }}_tagline" value="{{ get_option($user->id.'_tagline') }}">
                          </div>
                        </div>


                        <div class=" row mb-4">
                          <label class="col-md-4 form-label">Hero Header </label>
                          <div class="col-md-8">

                            <input type="text"  class="form-control" name="{{ $user->id }}_hero_header" value="{{ get_option($user->id.'_hero_header') }}">
                          </div>
                        </div>

                        <div class=" row mb-4">
                          <label class="col-md-4 form-label">Hero description</label>
                          <div class="col-md-8">

                            <textarea class="form-control" name="{{ $user->id }}_hero_description">{{ get_option($user->id.'_hero_description') }}</textarea> 
                          </div>
                        </div>


                        <div class=" row mb-4">
                         <div class="col-md-4">

                          <input type="text"  class="form-control" name="{{ $user->id }}_hero_button_text1" value="{{ get_option($user->id.'_hero_button_text1') }}">
                        </div>
                        <div class="col-md-8">

                          <textarea class="form-control" name="{{ $user->id }}_hero_button_url1">{{ get_option($user->id.'_hero_button_url1') }}</textarea> 
                        </div>
                      </div>

                      <div class=" row mb-4">
                       <div class="col-md-4">

                        <input type="text"  class="form-control" name="{{ $user->id }}_hero_button_text2" value="{{ get_option($user->id.'_hero_button_text2') }}">
                      </div>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_hero_button_url2">{{ get_option($user->id.'_hero_button_url2') }}</textarea> 
                      </div>
                    </div>



                    <hr style="border-top: 1px solid #000000;">
                    <label for="_show_features" class="checkbox-inline">
                      <input type="checkbox" value="1" id="_show_features" name="{{ $user->id }}_show_features" {{ get_option($user->id.'_show_features') == 1 ? 'checked="checked"': '' }}>
                      Show features
                    </label>

                    <br>

                    <label for="_show_reviews" class="checkbox-inline">
                      <input type="checkbox" value="1" id="_show_reviews" name="{{ $user->id }}_show_reviews" {{ get_option($user->id.'_show_reviews') == 1 ? 'checked="checked"': '' }}>
                      Show reviews
                    </label>
                    <br>


                    <label for="_show_why_us" class="checkbox-inline">
                      <input type="checkbox" value="1" id="_show_why_us" name="{{ $user->id }}_show_why_us" {{ get_option($user->id.'_show_why_us') == 1 ? 'checked="checked"': '' }}>
                      Show why us
                    </label>
                    <br>
                    <label for="_show_pricing" class="checkbox-inline">
                      <input type="checkbox" value="1" id="_show_pricing" name="{{ $user->id }}_show_pricing" {{ get_option($user->id.'_show_pricing') == 1 ? 'checked="checked"': '' }}>
                      Show pricing
                    </label>
                    <br>
                    <label for="_show_services" class="checkbox-inline">
                      <input type="checkbox" value="1" id="_show_services" name="{{ $user->id }}_show_services" {{ get_option($user->id.'_show_services') == 1 ? 'checked="checked"': '' }}>
                      Show services
                    </label>
                    <br>
                    <label for="_show_faqs" class="checkbox-inline">
                      <input type="checkbox" value="1" id="_show_faqs" name="{{ $user->id }}_show_faqs" {{ get_option($user->id.'_show_faqs') == 1 ? 'checked="checked"': '' }}>
                      Show FAQs
                    </label>
                    <br>
                    <label for="_show_testimonials" class="checkbox-inline">
                      <input type="checkbox" value="1" id="_show_testimonials" name="{{ $user->id }}_show_testimonials" {{ get_option($user->id.'_show_testimonials') == 1 ? 'checked="checked"': '' }}>
                      Show Testimonials
                    </label>
                    <br>

                    <label for="_show_cta" class="checkbox-inline">
                      <input type="checkbox" value="1" id="_show_cta" name="{{ $user->id }}_show_cta" {{ get_option($user->id.'_show_cta') == 1 ? 'checked="checked"': '' }}>
                      Show CTA
                    </label>
                    <br>
                    <label for="_show_popup" class="checkbox-inline">
                      <input type="checkbox" value="1" id="_show_popup" name="{{ $user->id }}_show_popup" {{ get_option($user->id.'_show_popup') == 1 ? 'checked="checked"': '' }}>
                      Show Popup
                    </label>
                    <br>
                    <label for="_show_homepage_content" class="checkbox-inline">
                      <input type="checkbox" value="1" id="_show_homepage_content" name="{{ $user->id }}_show_homepage_content" {{ get_option($user->id.'_show_homepage_content') == 1 ? 'checked="checked"': '' }}>
                      Show homepage content
                    </label>
                    <br>
                    <label for="_show_homepage_expert" class="checkbox-inline">
                      <input type="checkbox" value="1" id="_show_homepage_expert" name="{{ $user->id }}_show_homepage_expert" {{ get_option($user->id.'_show_homepage_expert') == 1 ? 'checked="checked"': '' }}>
                      Show homepage expert
                    </label>


                    <br>
                    <label for="_show_homepage_sample" class="checkbox-inline">
                      <input type="checkbox" value="1" id="_show_homepage_sample" name="{{ $user->id }}_show_homepage_sample" {{ get_option($user->id.'_show_homepage_sample') == 1 ? 'checked="checked"': '' }}>
                      Show homepage samples
                    </label>

                    <hr>


                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Experts  Header </label>
                      <div class="col-md-8">

                        <input type="text"  class="form-control" name="{{ $user->id }}_expert_header" value="{{ get_option($user->id.'_expert_header') }}">
                      </div>
                    </div>

                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Experts subheading</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_expert_subheading">{{ get_option($user->id.'_expert_subheading') }}</textarea> 
                      </div>
                    </div>

                    <hr>

                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Features  Header </label>
                      <div class="col-md-8">

                        <input type="text"  class="form-control" name="{{ $user->id }}_feature_header" value="{{ get_option($user->id.'_feature_header') }}">
                      </div>
                    </div>

                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Feature subheading</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_feature_subheading">{{ get_option($user->id.'_feature_subheading') }}</textarea> 
                      </div>
                    </div>


                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Features  Header 1 </label>
                      <div class="col-md-8">

                        <input type="text"  class="form-control" name="{{ $user->id }}_feature_header1" value="{{ get_option($user->id.'_feature_header1') }}">
                      </div>
                    </div>

                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Feature description1</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_feature_description1">{{ get_option($user->id.'_feature_description1') }}</textarea> 
                      </div>
                    </div>


                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Features  Header 2 </label>
                      <div class="col-md-8">

                        <input type="text"  class="form-control" name="{{ $user->id }}_feature_header2" value="{{ get_option($user->id.'_feature_header2') }}">
                      </div>
                    </div>

                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Feature description2</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_feature_description2">{{ get_option($user->id.'_feature_description2') }}</textarea> 
                      </div>
                    </div>


                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Features  Header 3 </label>
                      <div class="col-md-8">

                        <input type="text"  class="form-control" name="{{ $user->id }}_feature_header3" value="{{ get_option($user->id.'_feature_header3') }}">
                      </div>
                    </div>

                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Feature description3</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_feature_description3">{{ get_option($user->id.'_feature_description3') }}</textarea> 
                      </div>
                    </div>


                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Features  Header 4 </label>
                      <div class="col-md-8">

                        <input type="text"  class="form-control" name="{{ $user->id }}_feature_header4" value="{{ get_option($user->id.'_feature_header4') }}">
                      </div>
                    </div>

                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Feature description 4</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_feature_description4">{{ get_option($user->id.'_feature_description4') }}</textarea> 
                      </div>
                    </div>


                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Features  Header 5 </label>
                      <div class="col-md-8">

                        <input type="text"  class="form-control" name="{{ $user->id }}_feature_header5" value="{{ get_option($user->id.'_feature_header5') }}">
                      </div>
                    </div>

                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Feature description 5</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_feature_description5">{{ get_option($user->id.'_feature_description5') }}</textarea> 
                      </div>
                    </div>


                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Features  Header 6 </label>
                      <div class="col-md-8">

                        <input type="text"  class="form-control" name="{{ $user->id }}_feature_header6" value="{{ get_option($user->id.'_feature_header6') }}">
                      </div>
                    </div>

                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Feature description 6</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_feature_description6">{{ get_option($user->id.'_feature_description6') }}</textarea> 
                      </div>
                    </div>


                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Features  Header 7 </label>
                      <div class="col-md-8">

                        <input type="text"  class="form-control" name="{{ $user->id }}_feature_header7" value="{{ get_option($user->id.'_feature_header7') }}">
                      </div>
                    </div>

                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Feature description 7</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_feature_description7">{{ get_option($user->id.'_feature_description7') }}</textarea> 
                      </div>
                    </div>



                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Features  Header 8 </label>
                      <div class="col-md-8">

                        <input type="text"  class="form-control" name="{{ $user->id }}_feature_header8" value="{{ get_option($user->id.'_feature_header8') }}">
                      </div>
                    </div>

                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Feature description 8</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_feature_description8">{{ get_option($user->id.'_feature_description8') }}</textarea> 
                      </div>
                    </div>



                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">
                        Why use our writing platform?
                      </label>
                      <div class="col-md-8">

                        <input type="text"  class="form-control" name="{{ $user->id }}_why_header" value="{{ get_option($user->id.'_why_header') }}">
                      </div>
                    </div>

                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Why subheading</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_why_description">{{ get_option($user->id.'_why_description') }}</textarea> 
                      </div>
                    </div>


                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Best Customer Support </label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_support">{{ get_option($user->id.'_support') }}</textarea> 
                      </div>
                    </div>

                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Description</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_support_description">{{ get_option($user->id.'_support_description') }}</textarea> 
                      </div>
                    </div>


                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Customer Satisfaction Guaranteed</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_satisfaction">{{ get_option($user->id.'_satisfaction') }}</textarea> 
                      </div>
                    </div>


                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Description</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_satisfaction_description">{{ get_option($user->id.'_satisfaction_description') }}</textarea> 
                      </div>
                    </div>


                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Service Header</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_service">{{ get_option($user->id.'_service') }}</textarea> 
                      </div>
                    </div>


                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Description</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_service_description">{{ get_option($user->id.'_service_description') }}</textarea> 
                      </div>
                    </div>


                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Service Box 1</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_service_box1">{{ get_option($user->id.'_service_box1') }}</textarea> 
                      </div>
                    </div>

                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Service Box 2</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_service_box2">{{ get_option($user->id.'_service_box2') }}</textarea> 
                      </div>
                    </div>


                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Service Box 3</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_service_box3">{{ get_option($user->id.'_service_box3') }}</textarea> 
                      </div>
                    </div>

                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Service Box 4</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_service_box4">{{ get_option($user->id.'_service_box4') }}</textarea> 
                      </div>
                    </div>



                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Call to Action Header</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_ctah">{{ get_option($user->id.'_ctah') }}</textarea> 
                      </div>
                    </div>


                    <div class=" row mb-4">
                      <label class="col-md-4 form-label">Call to Action Description</label>
                      <div class="col-md-8">

                        <textarea class="form-control" name="{{ $user->id }}_ctad">{{ get_option($user->id.'_ctad') }}</textarea> 
                      </div>
                    </div>











                    <div class=" row mb-4">

                      <div class="col-md-9">

                      </div>


                    </div>

















                  </div>
                </div>
              </div>

            </div>
            <div class="tab-pane" id="tab21">

              <div class="col-lg-8 col-xl-12">
                <div class="card">

                  <div class="card-body">




                    <label for="enable_professional_service" class="checkbox-inline">
                      <input type="checkbox" value="1" id="show_it_works" name="{{ $user->id }}_show_it_works" {{ get_option($user->id.'_show_it_works') == 1 ? 'checked="checked"': '' }}>
                      Show How It works
                    </label>

                    <div class=" row mb-4">
                     <label class="col-md-4 form-label">How header </label>
                     <div class="col-md-8">

                      <input type="text"  class="form-control" name="{{ $user->id }}_how_header" value="{{ get_option($user->id.'_how_header') }}">
                    </div>
                  </div>




                  <div class=" row mb-4">
                    <label class="col-md-4 form-label">How description</label>
                    <div class="col-md-8">

                      <textarea class="form-control" name="{{ $user->id }}_how_description">{{ get_option($user->id.'_how_description') }}</textarea> 
                    </div>
                  </div>

                  <div class=" row mb-4">
                   <div class="col-md-4">

                    <input type="text"  class="form-control" name="{{ $user->id }}_post_order_header" value="{{ get_option($user->id.'_post_order_header') }}">
                  </div>
                  <div class="col-md-8">

                    <textarea class="form-control" name="{{ $user->id }}_post_order">{{ get_option($user->id.'_post_order') }}</textarea> 
                  </div>
                </div>

                <div class=" row mb-4">
                 <div class="col-md-4">

                  <input type="text"  class="form-control" name="{{ $user->id }}_top_wallet_header" value="{{ get_option($user->id.'_top_wallet_header') }}">
                </div>
                <div class="col-md-8">

                  <textarea class="form-control" name="{{ $user->id }}_top_wallet">{{ get_option($user->id.'_top_wallet') }}</textarea> 
                </div>
              </div>

              <div class=" row mb-4">
               <div class="col-md-4">

                <input type="text"  class="form-control" name="{{ $user->id }}_writer_assigned_header" value="{{ get_option($user->id.'_writer_assigned_header') }}">
              </div>
              <div class="col-md-8">

                <textarea class="form-control" name="{{ $user->id }}_writer_assigned">{{ get_option($user->id.'_writer_assigned') }}</textarea> 
              </div>
            </div>

            <div class=" row mb-4">
             <div class="col-md-4">

              <input type="text"  class="form-control" name="{{ $user->id }}_get_paper_header" value="{{ get_option($user->id.'_get_paper_header') }}">
            </div>
            <div class="col-md-8">

              <textarea class="form-control" name="{{ $user->id }}_get_paper">{{ get_option($user->id.'_get_paper') }}</textarea> 
            </div>
          </div>


          <div class=" row mb-4">
           <div class="col-md-4">

            <input type="text"  class="form-control" name="{{ $user->id }}_how_button_text" value="{{ get_option($user->id.'_how_button_text') }}">
          </div>
          <div class="col-md-8">

            <textarea class="form-control" name="{{ $user->id }}_how_button_url">{{ get_option($user->id.'_how_button_url') }}</textarea> 
          </div>
        </div>






        <div class=" row mb-4">

          <div class="col-md-9">

          </div>


        </div>















      </div>
    </div>
  </div>

</div>
<div class="tab-pane" id="tab22">

  <div class="col-lg-8 col-xl-8">
    <div class="card">

      <div class="card-body">



        <div class=" row mb-4">
         <label class="col-md-4 form-label">FAQ header </label>
         <div class="col-md-8">

          <input type="text"  class="form-control" name="{{ $user->id }}_faq_header" value="{{ get_option($user->id.'_faq_header') }}">
        </div>
      </div>




      <div class=" row mb-4">
        <label class="col-md-4 form-label">Faq description</label>
        <div class="col-md-8">

          <textarea class="form-control" name="{{ $user->id }}_faq_description">{{ get_option($user->id.'_faq_description') }}</textarea> 
        </div>
      </div>
      <hr style="border-top: 1px solid #000000;">
      <h3>General</h3>
      <div class=" row mb-4">
        <div class="col-md-4">
         1. <input type="text"  class="form-control" name="{{ $user->id }}_faq_header1" value="{{ get_option($user->id.'_faq_header1') }}">
       </div>
       <div class="col-md-8">

        <textarea class="form-control" name="{{ $user->id }}_faq_description1">{{ get_option($user->id.'_faq_description1') }}</textarea> 
      </div>
    </div>

    <div class=" row mb-4">
      <div class="col-md-4">
       2. <input type="text"  class="form-control" name="{{ $user->id }}_faq_header2" value="{{ get_option($user->id.'_faq_header2') }}">
     </div>
     <div class="col-md-8">

      <textarea class="form-control" name="{{ $user->id }}_faq_description2">{{ get_option($user->id.'_faq_description2') }}</textarea> 
    </div>
  </div>

  <div class=" row mb-4">
    <div class="col-md-4">
     3. <input type="text"  class="form-control" name="{{ $user->id }}_faq_header3" value="{{ get_option($user->id.'_faq_header3') }}">
   </div>
   <div class="col-md-8">

    <textarea class="form-control" name="{{ $user->id }}_faq_description3">{{ get_option($user->id.'_faq_description3') }}</textarea> 
  </div>
</div>

<div class=" row mb-4">
  <div class="col-md-4">
   4. <input type="text"  class="form-control" name="{{ $user->id }}_faq_header4" value="{{ get_option($user->id.'_faq_header4') }}">
 </div>
 <div class="col-md-8">

  <textarea class="form-control" name="{{ $user->id }}_faq_description4">{{ get_option($user->id.'_faq_description4') }}</textarea> 
</div>
</div>

<div class=" row mb-4">
  <div class="col-md-4">
   5. <input type="text"  class="form-control" name="{{ $user->id }}_faq_header5" value="{{ get_option($user->id.'_faq_header5') }}">
 </div>
 <div class="col-md-8">

  <textarea class="form-control" name="{{ $user->id }}_faq_description5">{{ get_option($user->id.'_faq_description5') }}</textarea> 
</div>
</div>






<div class=" row mb-4">

  <div class="col-md-9">

  </div>


</div>





<hr style="border-top: 1px solid #000000;">







<hr style="border-top: 1px solid #000000;">
<h3>Process </h3>
<div class=" row mb-4">
  <div class="col-md-4">
   1. <input type="text"  class="form-control" name="{{ $user->id }}_cfaq_header1" value="{{ get_option($user->id.'_cfaq_header1') }}">
 </div>
 <div class="col-md-8">

  <textarea class="form-control" name="{{ $user->id }}_cfaq_description1">{{ get_option($user->id.'_cfaq_description1') }}</textarea> 
</div>
</div>

<div class=" row mb-4">
  <div class="col-md-4">
   2. <input type="text"  class="form-control" name="{{ $user->id }}_cfaq_header2" value="{{ get_option($user->id.'_cfaq_header2') }}">
 </div>
 <div class="col-md-8">

  <textarea class="form-control" name="{{ $user->id }}_cfaq_description2">{{ get_option($user->id.'_cfaq_description2') }}</textarea> 
</div>
</div>

<div class=" row mb-4">
  <div class="col-md-4">
   3. <input type="text"  class="form-control" name="{{ $user->id }}_cfaq_header3" value="{{ get_option($user->id.'_cfaq_header3') }}">
 </div>
 <div class="col-md-8">

  <textarea class="form-control" name="{{ $user->id }}_cfaq_description3">{{ get_option($user->id.'_cfaq_description3') }}</textarea> 
</div>
</div>

<div class=" row mb-4">
  <div class="col-md-4">
   4. <input type="text"  class="form-control" name="{{ $user->id }}_cfaq_header4" value="{{ get_option($user->id.'_cfaq_header4') }}">
 </div>
 <div class="col-md-8">

  <textarea class="form-control" name="{{ $user->id }}_cfaq_description4">{{ get_option($user->id.'_cfaq_description4') }}</textarea> 
</div>
</div>

<div class=" row mb-4">
  <div class="col-md-4">
   5. <input type="text"  class="form-control" name="{{ $user->id }}_cfaq_header5" value="{{ get_option($user->id.'_cfaq_header5') }}">
 </div>
 <div class="col-md-8">

  <textarea class="form-control" name="{{ $user->id }}_cfaq_description5">{{ get_option($user->id.'_cfaq_description5') }}</textarea> 
</div>
</div>






<div class=" row mb-4">

  <div class="col-md-9">

  </div>


</div>






<hr style="border-top: 1px solid #000000;">


<hr style="border-top: 1px solid #000000;">
<h3>Payments </h3>
<div class=" row mb-4">
  <div class="col-md-4">
   1. <input type="text"  class="form-control" name="{{ $user->id }}_pfaq_header1" value="{{ get_option($user->id.'_pfaq_header1') }}">
 </div>
 <div class="col-md-8">

  <textarea class="form-control" name="{{ $user->id }}_pfaq_description1">{{ get_option($user->id.'_pfaq_description1') }}</textarea> 
</div>
</div>

<div class=" row mb-4">
  <div class="col-md-4">
   2. <input type="text"  class="form-control" name="{{ $user->id }}_pfaq_header2" value="{{ get_option($user->id.'_pfaq_header2') }}">
 </div>
 <div class="col-md-8">

  <textarea class="form-control" name="{{ $user->id }}_pfaq_description2">{{ get_option($user->id.'_pfaq_description2') }}</textarea> 
</div>
</div>

<div class=" row mb-4">
  <div class="col-md-4">
   3. <input type="text"  class="form-control" name="{{ $user->id }}_pfaq_header3" value="{{ get_option($user->id.'_pfaq_header3') }}">
 </div>
 <div class="col-md-8">

  <textarea class="form-control" name="{{ $user->id }}_pfaq_description3">{{ get_option($user->id.'_pfaq_description3') }}</textarea> 
</div>
</div>

<div class=" row mb-4">
  <div class="col-md-4">
   4. <input type="text"  class="form-control" name="{{ $user->id }}_pfaq_header4" value="{{ get_option($user->id.'_pfaq_header4') }}">
 </div>
 <div class="col-md-8">

  <textarea class="form-control" name="{{ $user->id }}_pfaq_description4">{{ get_option($user->id.'_pfaq_description4') }}</textarea> 
</div>
</div>

<div class=" row mb-4">
  <div class="col-md-4">
   5. <input type="text"  class="form-control" name="{{ $user->id }}_pfaq_header5" value="{{ get_option($user->id.'_pfaq_header5') }}">
 </div>
 <div class="col-md-8">

  <textarea class="form-control" name="{{ $user->id }}_pfaq_description5">{{ get_option($user->id.'_pfaq_description5') }}</textarea> 
</div>
</div>






<div class=" row mb-4">

  <div class="col-md-9">

  </div>


</div>












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

<div id="homepageContent" style="display: none;">


  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Homepage Content <a class="btn btn-sm btn-primary" href="{{ route('home')}}" target="_blank">Preview</a></h3>
    </div>
    <div class="card-body">










      <div class="form-group">
        <label>Column 1</label>
        <div class="col-sm-12">
          <textarea id="post_content1" class="form-control" name="{{ $user->id }}_homepage_content">{!! get_option($user->id.'_homepage_content') !!}</textarea>
        </div>
      </div>


      <script>
        ClassicEditor
        .create( document.querySelector( '#post_content1' ) );
      </script>





      <div class="form-group">
        <label>Column 2</label>
        <div class="col-sm-12">
          <textarea id="post_content2" class="form-control" name="{{ $user->id }}_homepage_content2">{!! get_option($user->id.'_homepage_content2') !!}</textarea>
        </div>
      </div>


      <script>
        ClassicEditor
        .create( document.querySelector( '#post_content2' ) );
      </script>








      <hr />

      <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8">

        </div>
      </div>


    </div>

  </div>
</div>

<div id="customerRules" style="display: none;">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Customers Rules <a class="btn btn-sm btn-primary" href="{{ route('customer_rules')}}" target="_blank">Preview</a></h3>
    </div>
    <div class="card-body">












      <div class="form-group">
        <div class="col-sm-12">
          <textarea id="post_content" class="form-control" name="{{ $user->id }}_customer_rule">{!! get_option($user->id.'_customer_rule') !!}</textarea>
        </div>
      </div>







      <hr />

      <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8">

        </div>
      </div>


    </div>

  </div>
</div>

<div id="fileStorage" style="display: none;">


  <div class="card">
    <div class="card-header">
      <h3 class="card-title">File Storage</h3>
    </div>
    <div class="card-body">


      <div class="form-group {{ $errors->has('default_storage')? 'has-error':'' }}">
        <label for="default_storage" class="col-sm-4 control-label">@lang('app.default_storage')</label>
        <div class="col-sm-8">
          <label>
            <input type="radio" name="{{ $user->id }}_default_storage" value="public" {{ get_option($user->id.'_default_storage') == 'public'? 'checked' :'' }} /> @lang('app.local_server') <small class="text-info"> (@lang('app.local_server_help_text')) </small>
          </label> <br />
          <label>
            <input type="radio" name="{{ $user->id }}_default_storage" value="s3" {{ get_option($user->id.'_default_storage') == 's3'? 'checked' :'' }} /> @lang('app.amazon_s3') <small class="text-info"> (@lang('app.amazon_s3_help_text')) </small>
          </label>

        </div>
      </div>


      <div class="amazon_s3_settings_wrap" style="display: {{ get_option($user->id.'_default_storage') == 's3' ? 'block':'none' }};">

        <hr />
        <div class="form-group">
          <label for="amazon_key" class="col-sm-4 control-label">@lang('app.amazon_key')</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="amazon_key" value="{{ get_option($user->id.'_amazon_key') }}" name="{{ $user->id }}_amazon_key" placeholder="@lang('app.amazon_key')">
          </div>
        </div>

        <div class="form-group">
          <label for="amazon_secret" class="col-sm-4 control-label">@lang('app.amazon_secret')</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="amazon_secret" value="{{ get_option($user->id.'_amazon_secret') }}" name="{{ $user->id }}_amazon_secret" placeholder="@lang('app.amazon_secret')">
          </div>
        </div>

        <div class="form-group">
          <label for="amazon_region" class="col-sm-4 control-label">@lang('app.amazon_region')</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="amazon_region" value="{{ get_option($user->id.'_amazon_region') }}" name="{{ $user->id }}_amazon_region" placeholder="@lang('app.amazon_region')">
            <a href="http://docs.aws.amazon.com/general/latest/gr/rande.html" target="_blank">@lang('app.amazon_region_help')</a>
          </div>
        </div>

        <div class="form-group">
          <label for="bucket" class="col-sm-4 control-label">@lang('app.bucket')</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="bucket" value="{{ get_option($user->id.'_bucket') }}" name="{{ $user->id }}_bucket" placeholder="@lang('app.bucket')">
          </div>
        </div>


      </div>


      <hr />

      <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8">

        </div>
      </div>


    </div>

  </div>
</div>

<div id="paymentMethod" style="display: none;">
 <div class="card">
  <div class="card-header">
    <h3 class="card-title">Accept Payments Via</h3>
  </div>
  <div class="card-body">




    <input type="hidden" name="{{ $user->id }}_site_id" value="{{ $user->id }}">

    <div class=" row mb-4">
      <label class="col-md-4 form-label">Payment Option </label>
      <div class="col-md-8">
       <select name="{{ $user->id }}_payment_option" class="form-control">
        <option value="{{ get_option($user->id.'_payment_option') }}" selected="">{{ get_option($user->id.'_payment_option') }}</option>

        <option value="system">System</option>
        <option value="external">External</option>

      </select>
    </div>
  </div>

  <div class=" row mb-4">
   <label class="col-md-4 form-label">
   AwasPay User ID  </label>
   <div class="col-md-8">
    <input type="text"  class="form-control" name="{{ $user->id }}_awaspay_id" value="{{ get_option($user->id.'_awaspay_id') }}">
  </div>
</div>

<div class="form-group {{ $errors->has('enable_paypal')? 'has-error':'' }}">
  <label class="col-md-4 control-label">@lang('app.enable_disable') </label>
  <div class="col-md-8">
    <label for="enable_paypal" class="checkbox-inline">
      <input type="checkbox" value="1" id="enable_paypal" name="{{ $user->id }}_enable_paypal" {{ get_option($user->id.'_enable_paypal') == 1 ? 'checked="checked"': '' }}>
      @lang('app.enable_paypal')
    </label>

    {!! $errors->has('type')? '<p class="help-block">'.$errors->first('type').'</p>':'' !!}
  </div>
</div>


<div class="form-group {{ $errors->has('enable_mpesa')? 'has-error':'' }}">
  <label class="col-md-4 control-label">@lang('app.enable_disable') </label>
  <div class="col-md-8">
    <label for="enable_mpesa" class="checkbox-inline">
      <input type="checkbox" value="1" id="enable_mpesa" name="{{ $user->id }}_enable_mpesa" {{ get_option($user->id.'_enable_mpesa') == 1 ? 'checked="checked"': '' }}>
      @lang('app.enable_mpesa')
    </label>

    {!! $errors->has('type')? '<p class="help-block">'.$errors->first('type').'</p>':'' !!}
  </div>
</div>


<div class="form-group {{ $errors->has('enable_stripe')? 'has-error':'' }}">
  <label class="col-md-4 control-label">@lang('app.enable_disable') </label>
  <div class="col-md-8">
    <label for="enable_stripe" class="checkbox-inline">
      <input type="checkbox" value="1" id="enable_stripe" name="{{ $user->id }}_enable_stripe" {{ get_option($user->id.'_enable_stripe') == 1 ? 'checked="checked"': '' }}>
      Enable Stripe payment 
    </label>

    {!! $errors->has('type')? '<p class="help-block">'.$errors->first('type').'</p>':'' !!}
  </div>
</div>




<div id="paypal_settings_wrap" style="display: {{ get_option($user->id.'_enable_paypal') == 1 ? 'block' : 'none' }}">
  <hr />

  <legend>@lang('app.paypal_settings')</legend>



  <div class=" row mb-4">
    <label class="col-md-4 form-label">Paypal client id </label>
    <div class="col-md-8">
      <input type="text" class="form-control" name="{{ $user->id }}_paypal_client_id" value="{{ get_option($user->id.'_paypal_client_id') }}">
    </div>


  </div>



</div>





<div id="mpesa_settings_wrap" style="display: {{ get_option($user->id.'_enable_mpesa') == 1 ? 'block' : 'none' }}">
  <hr />

  <legend>@lang('app.mpesa_settings')</legend>
  <div class=" row mb-4">
    <label class="col-md-4 form-label">Mpesa Paybill Number </label>
    <div class="col-md-8">
      <input type="text" class="form-control" name="{{ $user->id }}_BusinessShortCode" value="{{ get_option($user->id.'_BusinessShortCode') }}">
    </div>


  </div>


  <div class=" row mb-4">
    <label class="col-md-4 form-label">Lipa Na Mpesa Pass key </label>
    <div class="col-md-8">
      <input type="text" class="form-control" name="{{ $user->id }}_LipaNaMpesaPasskey" value="{{ get_option($user->id.'_LipaNaMpesaPasskey') }}">
    </div>


  </div>

  <div class=" row mb-4">
    <label class="col-md-4 form-label">MPESA CONSUMER KEY </label>
    <div class="col-md-8">
      <input type="text" class="form-control" name="{{ $user->id }}_MPESA_CONSUMER_KEY" value="{{ get_option($user->id.'_MPESA_CONSUMER_KEY') }}">
    </div>


  </div>

  <div class=" row mb-4">
    <label class="col-md-4 form-label">MPESA CONSUMER SECRET </label>
    <div class="col-md-8">
     <input type="text" class="form-control" name="{{ $user->id }}_MPESA_CONSUMER_SECRET" value="{{ get_option($user->id.'_MPESA_CONSUMER_SECRET') }}">
   </div>


 </div>



</div>


<div id="stripe_settings_wrap" style="display: {{ get_option($user->id.'_enable_stripe') == 1 ? 'block' : 'none' }}">
  <hr />

  <legend>Stripe Setting</legend>
  <div class=" row mb-4">
    <label class="col-md-4 form-label">Publishable key </label>
    <div class="col-md-8">
      <input type="text" class="form-control" name="{{ $user->id }}_publishable_key" value="{{ get_option($user->id.'_publishable_key') }}">
    </div>


  </div>


  <div class=" row mb-4">
    <label class="col-md-4 form-label">Secret key </label>
    <div class="col-md-8">
      <input type="text" class="form-control" name="{{ $user->id }}_secret_key" value="{{ get_option($user->id.'_secret_key') }}">
    </div>
  </div>

  <div class=" row mb-4">
    <label class="col-md-4 form-label">Payment Site URL </label>
    <div class="col-md-8">
      <input type="text" class="form-control" name="{{ $user->id }}_pay_site" value="{{ get_option($user->id.'_pay_site') }}">
    </div>
  </div>





</div>





<div class=" row mb-4">

  <div class="col-md-9">

  </div>


</div>






</div>

</div>



</div>


<div id="showAccount" style="display: none;">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Account Settings</h3>
      </div>
      <div class="card-body">


        <div class="form-group {{ $errors->has('enable_dc')? 'has-error':'' }}">
          <label class="col-md-4 control-label">@lang('app.enable_disable') </label>
          <div class="col-md-8">
            <label for="enable_dc" class="checkbox-inline">
              <input type="checkbox" value="1" id="enable_dc" name="{{ $user->id }}_enable_dc" {{ get_option($user->id.'_enable_dc') == 1 ? 'checked="checked"': '' }}>
              @lang('app.enable_dc')
            </label>
            <br>

            <label for="enable_academic_writing" class="checkbox-inline">
              <input type="checkbox" value="1" id="enable_academic_writing" name="{{ $user->id }}_enable_academic_writing" {{ get_option($user->id.'_enable_academic_writing') == 1 ? 'checked="checked"': '' }}>
              Enable Academic Writing
            </label>
            <br>

            <label for="enable_professional_service" class="checkbox-inline">
              <input type="checkbox" value="1" id="enable_professional_service" name="{{ $user->id }}_enable_professional_service" {{ get_option($user->id.'_enable_professional_service') == 1 ? 'checked="checked"': '' }}>
              Enable Professional Services
            </label>


            {!! $errors->has('type')? '<p class="help-block">'.$errors->first('type').'</p>':'' !!}
          </div>
        </div>


        <div class=" row mb-4">
         <label class="col-md-4 form-label">Site Name </label>
         <div class="col-md-8">

          <input type="text"  class="form-control" name="{{ $user->id }}_site_name" value="{{ get_option($user->id.'_site_name') }}">
        </div>
      </div>

      <div class=" row mb-4">
       <label class="col-md-4 form-label">Saseni Merchant ID </label>
       <div class="col-md-8">

        <input type="text"  class="form-control" name="{{ $user->id }}_saseni_id" value="{{ get_option($user->id.'_saseni_id') }}">
      </div>
    </div>

    <div class=" row mb-4">
     <label class="col-md-4 form-label">Landing Page </label>
     <div class="col-md-8">
       <select name="{{ $user->id }}_landing_page" class="form-control">
        <option value="{{ get_option($user->id.'_landing_page') }}" selected="">{{ get_option($user->id.'_landing_page') }}</option>
        <option value="homepage">homepage</option>
        <option value="register">register</option>

      </select>
    </div>
  </div>


  <?php

  $path = base_path();
  $path = $path.'/resources/views/theme';

  $dirs = array();

// directory handle
  $dir = dir($path);

  while (false !== ($entry = $dir->read())) {
    if ($entry != '.' && $entry != '..') {
     if (is_dir($path . '/' .$entry)) {
      $dirs[] = $entry; 
    }
  }
}



?>
<div class=" row mb-4">
 <label class="col-md-4 form-label">Select Theme</label>
 <div class="col-md-8">

   <select name="{{ $user->id }}_theme" class="form-control">
    <option value="{{ get_option($user->id.'_theme') }}" selected="">{{ get_option($user->id.'_theme') }}</option>
    @foreach ($dirs as $path => $value) 
    <option value="{{ $value }}">{{ $value }}</option>
    @endforeach


  </select>
</div>
</div>


<div class=" row mb-4">
 <label class="col-md-4 form-label">Default Ordering Page </label>
 <div class="col-md-8">
   <select name="{{ $user->id }}_default_order_page" class="form-control">
    <option value="{{ get_option($user->id.'_default_order_page') }}" selected="">{{ get_option($user->id.'_default_order_page') }}</option>
    <option value="academic">Academic</option>
    <option value="technical">Technical</option>
    <option value="professional">Professional</option>

  </select>
</div>
</div>

<div class=" row mb-4">
  <label class="col-md-4 form-label">Default Currency</label>
  <div class="col-md-8">

    <?php $current_currency = Auth::user()->currency_sign; ?>

    <select name="{{ $user->id }}_currency_sign" class="form-control">
     @foreach(currencies() as $code => $name)
     <option value="{{ $code }}"  {{ get_option($user->id.'_currency_sign') == $code? 'selected':'' }}> {{ $code }} 
     </option>
     @endforeach
   </select>
 </div>
</div>


<div class=" row mb-4">
 <label class="col-md-4 form-label">Site Title </label>
 <div class="col-md-8">

  <input type="text"  class="form-control" name="{{ $user->id }}_site_title" value="{{ get_option($user->id.'_site_title') }}">
</div>
</div>

<div class=" row mb-4">
 <label class="col-md-4 form-label">Meta description </label>
 <div class="col-md-8">
  <textarea name="{{ $user->id }}_meta_description" class="form-control">{{ get_option($user->id.'_meta_description') }}</textarea>


</div>
</div>

<div class=" row mb-4">
 <label class="col-md-4 form-label">Footer About </label>
 <div class="col-md-8">
  <textarea name="{{ $user->id }}_footer_about" class="form-control">{{ get_option($user->id.'_footer_about') }}</textarea>


</div>
</div>

<div class=" row mb-4">
 <label class="col-md-4 form-label">Admin Phone </label>
 <div class="col-md-8">

  <input type="text"  class="form-control" name="{{ $user->id }}_admin_phone" value="{{ get_option($user->id.'_admin_phone') }}">
</div>
</div>

<div class=" row mb-4">
 <label class="col-md-4 form-label">Admin Email </label>
 <div class="col-md-8">

  <input type="text"  class="form-control" name="{{ $user->id }}_admin_email" value="{{ get_option($user->id.'_admin_email') }}">
</div>
</div>


<div class=" row mb-4">
 <label class="col-md-4 form-label">Main site url </label>
 <div class="col-md-8">

  <input type="text"  class="form-control" name="{{ $user->id }}_main_site_url" value="{{ get_option($user->id.'_main_site_url') }}">
</div>
</div>


<div class=" row mb-4">
 <label class="col-md-4 form-label">Facebook url </label>
 <div class="col-md-8">

  <input type="text"  class="form-control" name="{{ $user->id }}_facebook" value="{{ get_option($user->id.'_facebook') }}">
</div>
</div>

<div class=" row mb-4">
 <label class="col-md-4 form-label">Instagram url </label>
 <div class="col-md-8">

  <input type="text"  class="form-control" name="{{ $user->id }}_instagram" value="{{ get_option($user->id.'_instagram') }}">
</div>
</div>


<div class=" row mb-4">
 <label class="col-md-4 form-label">Twitter url </label>
 <div class="col-md-8">

  <input type="text"  class="form-control" name="{{ $user->id }}_twitter" value="{{ get_option($user->id.'_twitter') }}">
</div>
</div>



<div class=" row mb-4">
 <label class="col-md-4 form-label">LinkedIn url </label>
 <div class="col-md-8">

  <input type="text"  class="form-control" name="{{ $user->id }}_linkedin" value="{{ get_option($user->id.'_linkedin') }}">
</div>
</div>


<div class=" row mb-4">
 <label class="col-md-4 form-label">Expert Name </label>
 <div class="col-md-8">

  <input type="text"  class="form-control" name="{{ $user->id }}_expert_name" value="{{ get_option($user->id.'_expert_name') }}">
</div>
</div>





<div class=" row mb-4">
  <label class="col-md-4 form-label">Pay order After(Days) </label>
  <div class="col-md-8">

    <input type="text"  class="form-control" name="{{ $user->id }}_pay_after" value="{{ get_option($user->id.'_pay_after') }}">
  </div>
</div>

<div class=" row mb-4">
  <label class="col-md-4 form-label">Cost per page</label>
  <div class="col-md-8">

    <input type="text"  class="form-control" name="{{ $user->id }}_cpp" value="{{ get_option($user->id.'_cpp') }}">
  </div>
</div>


<div class=" row mb-4">
 <label class="col-md-4 form-label">Editor % </label>
 <div class="col-md-8">

  <input type="text"  class="form-control" name="{{ $user->id }}_editor_share" value="{{ get_option($user->id.'_editor_share') }}">
</div>
</div>

<div class=" row mb-4">
 <label class="col-md-4 form-label">Writer % </label>
 <div class="col-md-8">

  <input type="text"  class="form-control" name="{{ $user->id }}_writer_share" value="{{ get_option($user->id.'_writer_share') }}">
</div>
</div>

<div class=" row mb-4">
 <label class="col-md-4 form-label">Order Admin % </label>
 <div class="col-md-8">

  <input type="text"  class="form-control" name="{{ $user->id }}_order_admin_share" value="{{ get_option($user->id.'_order_admin_share') }}">
</div>
</div>

<div class=" row mb-4">
 <label class="col-md-4 form-label">System Admin % </label>
 <div class="col-md-8">

  <input type="text"  class="form-control" name="{{ $user->id }}_admin_share" value="{{ get_option($user->id.'_admin_share') }}">
</div>
</div>

<div class=" row mb-4">
 <label class="col-md-4 form-label">PPT slide cost  </label>
 <div class="col-md-8">

  <input type="text"  class="form-control" name="{{ $user->id }}_ppt_slide_cost" value="{{ get_option($user->id.'_ppt_slide_cost') }}">
</div>
</div>

<div class=" row mb-4">
 <label class="col-md-4 form-label">
 Writer time  </label>
 <div class="col-md-8">

  <input type="text"  class="form-control" name="{{ $user->id }}_writer_time" value="{{ get_option($user->id.'_writer_time') }}">
</div>
</div>

<div class=" row mb-4">
 <label class="col-md-4 form-label">
 Editor time  </label>
 <div class="col-md-8">

  <input type="text"  class="form-control" name="{{ $user->id }}_editor_time" value="{{ get_option($user->id.'_editor_time') }}">
</div>
</div>


<div class=" row mb-4">
 <label class="col-md-4 form-label">
 Conversion rate (USD)  </label>
 <div class="col-md-8">

  <input type="text"  class="form-control" name="{{ $user->id }}_conversion_rate" value="{{ get_option($user->id.'_conversion_rate') }}">
</div>
</div>

<div class=" row mb-4">
 <label class="col-md-4 form-label">
 Plagiarism Report  </label>
 <div class="col-md-8">
  <input type="text"  class="form-control" name="{{ $user->id }}_plagiarism_report" value="{{ get_option($user->id.'_plagiarism_report') }}">
</div>
</div>


<div class=" row mb-4">
 <label class="col-md-4 form-label">
 Top 10 writers  </label>
 <div class="col-md-8">
  <input type="text"  class="form-control" name="{{ $user->id }}_top_ten" value="{{ get_option($user->id.'_top_ten') }}">
</div>
</div>


<div class=" row mb-4">
 <label class="col-md-4 form-label">
 Preferred writer only  </label>
 <div class="col-md-8">
  <input type="text"  class="form-control" name="{{ $user->id }}_preferred_writer_only" value="{{ get_option($user->id.'_preferred_writer_only') }}">
</div>
</div>


<div class=" row mb-4">
 <label class="col-md-4 form-label">
 Technical order default  </label>
 <div class="col-md-8">
  <input type="text"  class="form-control" name="{{ $user->id }}_technical_order_default" value="{{ get_option($user->id.'_technical_order_default') }}">
</div>
</div>


<div class=" row mb-4">
 <label class="col-md-4 form-label">
 Google sitekey  </label>
 <div class="col-md-8">
  <input type="text"  class="form-control" name="{{ $user->id }}_sitekey" value="{{ get_option($user->id.'_sitekey') }}">
</div>
</div>


<div class=" row mb-4">
 <label class="col-md-4 form-label">
 Max Pages  </label>
 <div class="col-md-8">
  <input type="text"  class="form-control" name="{{ $user->id }}_max_pages" value="{{ get_option($user->id.'_max_pages') }}">
</div>
</div>


<div class=" row mb-4">
 <label class="col-md-4 form-label">
 USD TO KES  </label>
 <div class="col-md-8">
  <input type="text"  class="form-control" name="{{ $user->id }}_usd_kes" value="{{ get_option($user->id.'_usd_kes') }}">
</div>
</div>



<div class=" row mb-4">

  <div class="col-md-9">

  </div>


</div>





</div>

</div>




</div>


</div>



<button type="submit" class="btn btn-primary">Save settings</button>

</form>



<div id="options">

  <div class="col-xl-12">
    <div class="card">

      <div class="card-header">

       <div class="text-center chat-image mb-5">
        <div class="chat-profile mb-3">
          <a class="" href=""><img alt="avatar" src="{{ $user->logo_url }}" ></a>
        </div>
        <div class="main-chat-msg-name">
          <a href="profile.html">
            <h5 class="mb-1 text-dark fw-semibold">{{ $user->domain_name }}</h5>
          </a>

        </div>
      </div>
    </div>

    <div class="card-body">

      <h3 class="card-title">Website Email Setup</h3>
      <hr>
      <form action="{{ route('edit_website')}}" method="POST" enctype="multipart/form-data">
       @csrf
       <input type="hidden" name="website_id" value="{{ $user->id }}">
       <div class="row" style="display: none;">
        <div class="col-lg-6 col-md-12">
          <div class="form-group">
            <label for="exampleInputname">Domain Name</label>
            <input type="text" class="form-control" name="domain_name" id="exampleInputname" placeholder="Domain Name" value="{{ $user->domain_name  }}">
          </div>
        </div>

      </div>

      <div class="form-group">
        <label for="exampleInputnumber">Support Phone</label>
        <input type="text" name="phone" class="form-control" id="exampleInputnumber" placeholder="Contact number" value="{{ $user->phone  }}">
      </div>

      <div class="form-group">
        <label for="exampleInputnumber">Email</label>
        <input type="email" name="email" class="form-control" id="exampleInputnumber" placeholder="Email" value="{{ $user->email  }}">
      </div>


      <div class="form-group">
        <label for="exampleInputnumber">Mail Host</label>
        <input type="text" name="mail_host" class="form-control" id="exampleInputnumber" placeholder="mail_host" value="{{ $user->mail_host  }}">
      </div>

      <div class="form-group">
        <label for="exampleInputnumber">Mail Username</label>
        <input type="text" name="mail_username" class="form-control" id="exampleInputnumber" placeholder="mail username" value="{{ $user->mail_username  }}">
      </div>

      <div class="form-group">
        <label for="exampleInputnumber">Mail Password</label>
        <input type="password" name="mail_password" class="form-control" id="exampleInputnumber" placeholder="mail password" value="{{ $user->mail_password  }}">
      </div>


      <div class="form-group">
        <label for="exampleInputnumber">Mail Port</label>
        <input type="text" name="mail_port" class="form-control" id="exampleInputnumber" placeholder="Mail port" value="{{ $user->mail_port  }}">
      </div>

      <div class="form-group">
        <label for="exampleInputnumber">Reply To</label>
        <input type="text" name="reply_to" class="form-control" id="exampleInputnumber" placeholder="Reply to" value="{{ $user->reply_to  }}">
      </div>




      <div class="form-group  {{ $errors->has('photo')? 'has-error':'' }}">
        <label class="col-sm-4 control-label">Logo</label>
        <div class="col-sm-8">
          <input type="file" id="photo" name="photo" class="filestyle" >
          {!! $errors->has('photo')? '<p class="help-block">'.$errors->first('photo').'</p>':'' !!}
        </div>
      </div>

      <div class="form-group  {{ $errors->has('photo')? 'has-error':'' }}">
        <label class="col-sm-4 control-label">Favicon</label>
        <div class="col-sm-8">
          <input type="file" id="photo" name="favicon" class="filestyle" >
          {!! $errors->has('favicon')? '<p class="help-block">'.$errors->first('favicon').'</p>':'' !!}
        </div>
      </div>


      <button href="javascript:void(0)" class="btn btn-success my-1">Save</button>

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
</div>
<!-- /Row -->












</div>
<!--CONTAINER CLOSED -->

</div>
</div>
<!--app-content open-->



@endsection



@section('page-js')

<script>
  $(document).ready(function(){

    $('input[type="checkbox"], input[type="radio"]').click(function(){
      var input_name = $(this).attr('name');
      var input_value = 0;
      if ($(this).prop('checked')){
        input_value = $(this).val();
      }
      $.ajax({
        url : '{{ route('save_settings') }}',
        type: "POST",
        data: { [input_name]: input_value, '_token': '{{ csrf_token() }}' },
      });
    });

            /**
             * show or hide mpesa and paypal settings wrap
             */
    $('#enable_paypal').click(function(){
      if ($(this).prop('checked')){
        $('#paypal_settings_wrap').slideDown();
      }else{
        $('#paypal_settings_wrap').slideUp();
      }
    });
    $('#enable_mpesa').click(function(){
      if ($(this).prop('checked')){
        $('#mpesa_settings_wrap').slideDown();
      }else{
        $('#mpesa_settings_wrap').slideUp();
      }
    });
    $('#enable_stripe').click(function(){
      if ($(this).prop('checked')){
        $('#stripe_settings_wrap').slideDown();
      }else{
        $('#stripe_settings_wrap').slideUp();
      }
    });

  });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>


<script>
  $(function () {
    $(document).ready(function () {
      $('#fileUploadForm').ajaxForm({
        complete: function (xhr) {

         var err = JSON.parse(xhr.responseText);

         console.log(err.msg);;


         swal(err.msg);

       },
     });
    });
  });
</script>




<!--         <script>
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
                    swal('Hi {{ username(Auth::user())->name}}', data.msg, 'success');
                  }
                }
              });
            });

           });

         </script> -->





         <!-- INTERNAL WYSIWYG Editor JS -->
         <script src="{{ asset('assets/plugins/wysiwyag/jquery.richtext.js')}}"></script>
         <script src="{{ asset('assets/plugins/wysiwyag/wysiwyag.js')}}"></script>
         @endsection