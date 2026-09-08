<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\EcommerceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/








//reisen seo
Route::get('/about-us', function () {
    return view('theme.marketi.contents.about_us');
});

Route::get('/contact-us', function () {
    return view('theme.marketi.contents.contact_us');
});







Route::get('/send-notification', [NotificationController::class, 'sendOfferNotification']);
Route::get('/', [EcommerceController::class, 'home'])->name('home');
Route::get('order', ['as'=>'order', 'uses' => 'WelcomeController@order']);
Route::get('projects', ['as'=>'projects', 'uses' => 'WelcomeController@projects']);
Route::get('order', '\App\Http\Controllers\WelcomeController@order');
Route::get('buy-paper', ['as'=>'buy_paper', 'uses' => 'WelcomeController@buyPaper']);
Route::get('view-answer/{id}', ['as'=>'view_answer', 'uses' => 'WelcomeController@viewAnswer']);
Route::get('buy-script/{id}', ['as'=>'buy_script', 'uses' => 'WelcomeController@buyScript']);
Route::get('services/{slug}', ['as' => 'blog_single', 'uses'=>'App\Http\Controllers\WelcomeController@blogSingle']);
Route::get('buy-website/{id}', ['as'=>'buy_website', 'uses' => 'WelcomeController@buyWebsite']);
Route::get('buy-product/{id}', ['as'=>'buy_product', 'uses' => 'WelcomeController@buyProduct']);
Route::get('success-buy/{id}', ['as'=>'success_buy', 'uses' => 'WelcomeController@successBuy']);
Route::get('success-script/{id}', ['as'=>'success_script', 'uses' => 'WelcomeController@successScript']);
Route::get('success-website/{id}', ['as'=>'success_website', 'uses' => 'WelcomeController@successWebsite']);
Route::get('testpay', ['as'=>'testpay', 'uses' => 'WelcomeController@testpay']);
Route::get('logout', '\App\Http\Controllers\DashboardController@logout');
Route::get('alogout', '\App\Http\Controllers\DashboardController@alogout');
Route::get('latest-reviews', ['as'=>'latest_reviews', 'uses' => 'WelcomeController@latestReviews']);
Route::get('/sitemap.xml', ['as'=>'sitemap', 'uses' => 'WelcomeController@sitemap']);

Route::controller(StripePaymentController::class)->group(function(){
  Route::get('stripe', 'stripe');
  Route::post('stripe', 'stripePost')->name('stripe.post');

});

Route::get('add-to-log', 'HomeController@myTestAddToLog');


Route::get('writer', ['as'=>'writer', 'uses' => 'WelcomeController@writer']);
Route::get('connect', ['as'=>'connect', 'uses' => 'WelcomeController@connect']);


//posts
Route::get('posts', ['as'=>'qpost', 'uses' => 'WelcomeController@qpost']);
Route::post('contact-post', ['as'=>'contact_post', 'uses' => 'WelcomeController@contactPost']);
Route::post('go', ['as'=>'go', 'uses' => 'WelcomeController@go']);
Route::post('gobuy', ['as'=>'gobuy', 'uses' => 'WelcomeController@gobuy']);
Route::get('services', ['as'=>'services', 'uses' => 'WelcomeController@services']);
Route::get('service/{id}', ['as'=>'service_single', 'uses' => 'WelcomeController@serviceSingle']);
Route::get('blog', ['as'=>'blog', 'uses' => 'WelcomeController@blog']);
Route::get('q', ['as'=>'q', 'uses' => 'WelcomeController@blog']);
Route::get('questions', ['as'=>'questions', 'uses' => 'WelcomeController@questions']);
Route::get('programming', ['as'=>'programming', 'uses' => 'WelcomeController@programming']);

Route::get('faqs', ['as'=>'faqs', 'uses' => 'WelcomeController@faqs']);
Route::get('news', ['as'=>'news', 'uses' => 'WelcomeController@news']);
Route::get('writer-rules', ['as'=>'writer_rules', 'uses' => 'WelcomeController@writerRules']);
Route::get('client-rules', ['as'=>'client_rules', 'uses' => 'WelcomeController@clientRules']);
Route::get('samples', ['as'=>'samples', 'uses' => 'WelcomeController@samples']);
Route::get('mathematics', ['as'=>'mathematics', 'uses' => 'WelcomeController@mathematics']);
Route::get('training', ['as'=>'training', 'uses' => 'WelcomeController@training']);
Route::get('marketplace', ['as'=>'marketplace', 'uses' => 'WelcomeController@marketplace']);
Route::get('hire', ['as'=>'hire', 'uses' => 'WelcomeController@hire']);



Route::post('request-writer', ['as'=>'request_writer', 'uses' => 'WelcomeController@requestWriter']);
Route::get('request-writer', ['as'=>'request_writer', 'uses' => 'WelcomeController@requestWriter']);
Route::get('profile/{id}', ['as'=>'profile', 'uses' => 'WelcomeController@profile']);
Route::get('blog/{slug}', ['as' => 'blog_single', 'uses'=>'App\Http\Controllers\WelcomeController@blogSingle']);
Route::get('questions/{slug}', ['as' => 'question_single', 'uses'=>'App\Http\Controllers\WelcomeController@blogSingle']);
Route::get('samples/{slug}', ['as' => 'sample_single', 'uses'=>'App\Http\Controllers\WelcomeController@blogSingle']);
Route::get('programming/{slug}', ['as' => 'programming_single', 'uses'=>'App\Http\Controllers\WelcomeController@blogSingle']);
Route::get('upload-ui', [FileUploadController::class, 'dropzoneUi' ]);
Route::post('file-upload', [FileUploadController::class, 'dropzoneFileUpload' ])->name('dropzoneFileUpload');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::get('cview-invoice/{id}', 'App\Http\Controllers\WelcomeController@cviewInvoice');
Route::get('view-invoice/{id}', 'App\Http\Controllers\WelcomeController@viewInvoice');
Route::get('ipaid/{id}', 'App\Http\Controllers\WelcomeController@iPaid');
Route::post('premotely', 'App\Http\Controllers\WelcomeController@premotely')->name('pay');
Route::post('premotely2', 'App\Http\Controllers\WelcomeController@premotely2')->name('pay');
Route::get('cpay/{id}', 'App\Http\Controllers\WelcomeController@cPay');
Route::get('spay', 'App\Http\Controllers\WelcomeController@sPay');
Route::get('cpaid/{id}', 'App\Http\Controllers\WelcomeController@cPaid');
Route::get('getchat', 'App\Http\Controllers\WelcomeController@getchat')->name('getchat');
Route::get('cmpesa', 'App\Http\Controllers\WelcomeController@cmpesa')->name('cmpesa');
Route::post('cmpesa', 'App\Http\Controllers\WelcomeController@cmpesa')->name('cmpesa');
Route::get('bmpesa', 'App\Http\Controllers\WelcomeController@bmpesa')->name('bmpesa');
Route::get('bconfirm-payment/{id}', 'App\Http\Controllers\WelcomeController@bconfirmPayment')->name('bconfirmPayment');
Route::get('confirm-payment', ['as'=>'confirm_payment', 'uses' => 'WelcomeController@confirmPayment']);
Route::get('experts', 'App\Http\Controllers\WelcomeController@experts')->name('experts');
Route::get('editors', 'App\Http\Controllers\WelcomeController@editors')->name('editors');

Route::get('themes', 'App\Http\Controllers\WelcomeController@themes')->name('themes');
Route::get('paypackage/{id}', 'App\Http\Controllers\WelcomeController@payPackage');
Route::post('/api/callback', 'App\Http\Controllers\WelcomeController@callback')->name('callback');
Route::post('/api/sendsms', 'App\Http\Controllers\WelcomeController@sendsms')->name('sendsms');
Route::get('pricing', ['as'=>'pricing', 'uses' => 'WelcomeController@pricing']);
Route::get('how', ['as'=>'pricing', 'uses' => 'WelcomeController@how']);
Route::get('shop', ['as' => 'shop', 'uses' => 'WelcomeController@shop']);
Route::get('shop/category/{slug?}', ['as' => 'shops_filter', 'uses' => 'WelcomeController@filterShop']);
Route::get('shop/{slug}', ['as'=>'shop_description', 'uses' => 'WelcomeController@shopDescription']);
Route::get('training/{id}', ['as'=>'training_description', 'uses' => 'WelcomeController@trainingDescription']);




Route::get('cregister', 'App\Http\Controllers\WelcomeController@cregister')->name('cregister');
Route::post('wregister', 'App\Http\Controllers\WelcomeController@wregister')->name('wregister');
Route::post('cregister', 'App\Http\Controllers\WelcomeController@register')->name('cregister');
Route::get('bregister', 'App\Http\Controllers\WelcomeController@bregister')->name('bregister');
Route::post('bregister', 'App\Http\Controllers\WelcomeController@bregisterPost')->name('bregister');
Route::get('pregister', 'App\Http\Controllers\WelcomeController@pregister')->name('pregister');
Route::post('pregister', 'App\Http\Controllers\WelcomeController@pregisterPost')->name('pregister');


Route::get('clogin', 'App\Http\Controllers\WelcomeController@clogin')->name('clogin');
Route::get('activate-code', ['as'=>'activate_code', 'uses' => 'WelcomeController@activateCode']);
Route::post('activate-code', ['as'=>'activate_code', 'uses' => 'WelcomeController@activateCodePost']);



Route::post('alogin', ['as'=>'alogin', 'uses' => 'WelcomeController@aloginPost']);
Route::post('loginPost', ['as'=>'login_post', 'uses' => 'WelcomeController@loginPost']);
Route::get('admin', ['as'=>'admin_login', 'uses' => 'WelcomeController@alogin']);



Auth::routes();




//Dashboard Route
Route::group(['prefix'=>'dashboard', 'middleware' => 'dashboard'], function(){


  Route::get('/', ['as'=>'dashboard', 'uses' => 'DashboardController@dashboard']);




  //client routes
  Route::get('my-writers', ['as'=>'my_writers', 'uses' => 'DashboardController@myWriters']);
  Route::get('saseni-writers', ['as'=>'saseni_writers', 'uses' => 'DashboardController@saseniWriters']);
  Route::get('success-deposit/{id}', ['as'=>'success_deposit', 'uses' => 'DashboardController@successDeposit']);


  //writer route
  Route::get('application', ['as'=>'application', 'uses' => 'DashboardController@application']);
  Route::post('updatesingle-service', ['as'=>'updatesingle_service', 'uses' => 'DashboardController@updatesingleService']);
  //editor route



//all authenticated
  Route::get('inbox', ['as'=>'inbox', 'uses' => 'InboxController@index']);
  Route::get('inbox/{id}', ['as'=>'inbox.show', 'uses' => 'InboxController@show']);
  Route::get('chat-lists', ['as'=>'chat_lists', 'uses' => 'DashboardController@chatLists']);
  Route::get('order', ['as'=>'order', 'uses' => 'DashboardController@order']);
  Route::get('payment-way', ['as'=>'payment_way', 'uses' => 'DashboardController@paymentWay']);
  Route::get('order-fined', ['as'=>'order_fined', 'uses' => 'DashboardController@orderFined']);
  Route::get('order-available', ['as'=>'order_available', 'uses' => 'DashboardController@orderAvailable']);
  Route::get('order-inprogress', ['as'=>'order_inprogress', 'uses' => 'DashboardController@orderInprogress']);
  Route::get('order-completed', ['as'=>'order_completed', 'uses' => 'DashboardController@orderCompleted']);
  Route::get('order-editing', ['as'=>'order_editing', 'uses' => 'DashboardController@orderEditing']);
  Route::get('order-uediting', ['as'=>'order_uediting', 'uses' => 'DashboardController@orderuEditing']);
  Route::get('order-approved', ['as'=>'order_approved', 'uses' => 'DashboardController@orderApproved']);
  Route::post('update-order', ['as'=>'update_order', 'uses' => 'DashboardController@updateOrder']);
  Route::post('cost-order', ['as'=>'cost_order', 'uses' => 'DashboardController@costOrder']);
  Route::post('cnew-order', ['as'=>'cnew_order', 'uses' => 'DashboardController@cnewOrder']);
  Route::post('new-applicant', ['as'=>'new_applicant', 'uses' => 'DashboardController@newApplicant']);
  Route::get('new-technical-order', ['as'=>'new_technical_order', 'uses' => 'DashboardController@newTechnicalOrder']);
  Route::get('new-professional-service', ['as'=>'new_professional_service', 'uses' => 'DashboardController@professionalService']);
  Route::post('technical-order', ['as'=>'technical_order', 'uses' => 'DashboardController@technicalOrder']);
  Route::post('professional-order', ['as'=>'professional_order', 'uses' => 'DashboardController@professionalOrder']);
  Route::post('update-order', ['as'=>'update_order', 'uses' => 'DashboardController@updateOrder']);
  Route::post('save-service', ['as'=>'save_service', 'uses' => 'DashboardController@saveService']);
      Route::get('edit-page/{id}', ['as'=>'edit_page', 'uses' => 'App\Http\Controllers\DashboardController@editPage']);

      Route::get('edit-post/{id}', ['as'=>'edit_post', 'uses' => 'App\Http\Controllers\DashboardController@editPost']);
      Route::get('edit-product/{id}', ['as'=>'edit_product', 'uses' => 'App\Http\Controllers\DashboardController@editProduct']);
      Route::get('edit-training/{id}', ['as'=>'edit_training', 'uses' => 'App\Http\Controllers\DashboardController@editTraining']);
  Route::post('acancel-order', ['as'=>'acancel_order', 'uses' => 'DashboardController@acancelOrder']);
  Route::post('sms-writer', ['as'=>'sms_writer', 'uses' => 'DashboardController@smsWriter']);
  Route::post('approve-order', ['as'=>'approve_order', 'uses' => 'DashboardController@approveOrder']);
  Route::post('accept-order', ['as'=>'accept_order', 'uses' => 'DashboardController@acceptOrder']);
  Route::post('bid-order', ['as'=>'bid_order', 'uses' => 'DashboardController@bidOrder']);
  Route::post('pick-order', ['as'=>'pick_order', 'uses' => 'DashboardController@pickOrder']);
  Route::post('epick-order', ['as'=>'epick_order', 'uses' => 'DashboardController@epickOrder']);
  Route::post('reject-order', ['as'=>'reject_order', 'uses' => 'DashboardController@rejectOrder']);
  Route::post('answer-order', ['as'=>'answer_order', 'uses' => 'DashboardController@answerOrder']);
  Route::get('add-order', ['as'=>'add_order', 'uses' => 'DashboardController@addOrder']);
  Route::post('update-page', ['as'=>'update_page', 'uses' => 'DashboardController@updatePage']);
    Route::post('add-content', ['as'=>'add_content', 'uses' => 'DashboardController@addContent']);
    Route::post('update-content', ['as'=>'update_content', 'uses' => 'DashboardController@updateContent']);
  Route::post('updatesingle-post', ['as'=>'updatesingle_post', 'uses' => 'DashboardController@updatesinglePost']);
  Route::post('updatesingle-product', ['as'=>'updatesingle_product', 'uses' => 'DashboardController@updatesingleProduct']);
  Route::post('update_default', ['as' => 'update_default', 'uses'=>'App\Http\Controllers\DashboardController@updateUserPost']);
  Route::get('edit-order/{id}', ['as'=>'edit_order', 'uses' => 'DashboardController@editOrder']);
  Route::post('anew-service', ['as'=>'anew_service', 'uses' => 'DashboardController@aaddService']);
  Route::post('anew-post', ['as'=>'anew_post', 'uses' => 'DashboardController@addPost']);
  Route::post('anew-product', ['as'=>'anew_product', 'uses' => 'DashboardController@addProduct']);
  Route::post('anew-training', ['as'=>'anew_training', 'uses' => 'DashboardController@addTraining']);
  Route::post('anew-page', ['as'=>'anew_page', 'uses' => 'DashboardController@addPage']);
  Route::post('upload-pmedia', ['as'=>'upload_pmedia', 'uses' => 'DashboardController@uploadpMedia']);
  Route::get('view-bids/{id}', ['as'=>'view_bids', 'uses' => 'DashboardController@viewBids']);
  Route::post('update-expense', ['as'=>'update_expense', 'uses' => 'DashboardController@updateExpense']);
  Route::get('view-order/{id}', ['as'=>'view_order', 'uses' => 'DashboardController@viewOrder']);
  Route::get('view-application/{id}', ['as'=>'view_application', 'uses' => 'DashboardController@viewApplication']);
  Route::get('view-message-unread/{id}', ['as'=>'view_message_unread', 'uses' => 'DashboardController@viewMessageUnread']);
  Route::post('file_upload', ['as'=>'fileUpload', 'uses' => 'DashboardController@fileUpload']);
  Route::post('change-status', ['as'=>'change_status', 'uses' => 'DashboardController@changeStatus']);
  Route::post('change-status-application', ['as'=>'change_status_application', 'uses' => 'DashboardController@changeStatusApplication']);
  Route::post('change-payment-way', ['as'=>'change_payment_way', 'uses' => 'DashboardController@changePaymentWay']);
  Route::post('change-status-assign', ['as'=>'change_status_assign', 'uses' => 'DashboardController@changeStatusAssign']);
  Route::get('change-user-feature', ['as'=>'change_user_feature', 'uses' => 'DashboardController@changeFeature']);
  Route::post('send-sms', ['as'=>'send_sms', 'uses' => 'DashboardController@sendSms']);
  Route::get('custom-invoices', ['as'=>'custom_invoices', 'uses' => 'DashboardController@customInvoices']);
  Route::post('cinvoice', ['as'=>'cinvoice', 'uses' => 'DashboardController@cinvoice']);
  Route::post('erate_save', ['as'=>'erate_save', 'uses' => 'DashboardController@erateSave']);
  Route::get('epayments', ['as'=>'epayments', 'uses' => 'DashboardController@epayments']);
  Route::get('wpayments', ['as'=>'wpayments', 'uses' => 'DashboardController@wpayments']);
  Route::post('add-fund', ['as'=>'add_fund', 'uses' => 'DashboardController@addFund']);
  Route::post('confirm-order', ['as'=>'confirm_order', 'uses' => 'DashboardController@confirmOrder']);
  Route::post('confirm-invoice', ['as'=>'confirm_invoice', 'uses' => 'DashboardController@confirmInvoice']);
  Route::post('duplicate-order', ['as'=>'duplicate_order', 'uses' => 'DashboardController@duplicateOrder']);
  Route::post('order-clientnote', ['as'=>'order_clientnote', 'uses' => 'DashboardController@orderClientnote']);
  Route::post('order-clientnotewriter', ['as'=>'order_clientnotewriter', 'uses' => 'DashboardController@orderClientnotewriter']);
  Route::post('mark-read', ['as'=>'mark_read', 'uses' => 'DashboardController@markRead']);
  Route::get('deposit', ['as'=>'deposit', 'uses' => 'DashboardController@deposit']);
  Route::get('account', ['as'=>'account', 'uses' => 'DashboardController@account']);


  Route::get('logActivity', ['as'=>'logActivity', 'uses' => 'DashboardController@logActivity']);


  Route::post('make-deposit', ['as'=>'make_deposit', 'uses' => 'DashboardController@makeDeposit']);
  Route::get('subscribe', ['as'=>'subscribe', 'uses' => 'DashboardController@subscribe']);
  Route::get('switcher', ['as'=>'switcher', 'uses' => 'DashboardController@switcher']);
  Route::get('customer-rules', ['as'=>'customer_rules', 'uses' => 'DashboardController@customerRules']);
  Route::post('subscribe-data', ['as'=>'subscribe_data', 'uses' => 'DashboardController@subscribeData']);
  Route::post('send-revision', ['as'=>'send_revision', 'uses' => 'DashboardController@sendRevision']);
  Route::post('send-message', ['as'=>'send_message', 'uses' => 'DashboardController@sendMessage']);
  Route::get('invoices', ['as'=>'invoices', 'uses' => 'DashboardController@invoices']);
  Route::get('order-payments', ['as'=>'order_payments', 'uses' => 'DashboardController@orderPayments']);
  Route::get('einvoices', ['as'=>'einvoices', 'uses' => 'DashboardController@einvoices']);
  Route::get('invoices-pending', ['as'=>'invoices_pending', 'uses' => 'DashboardController@invoicesPending']);
  Route::get('invoices-paid', ['as'=>'invoices_paid', 'uses' => 'DashboardController@invoicesPaid']);

  

  Route::get('messages', ['as'=>'messages', 'uses' => 'DashboardController@messages']);
  Route::get('sms', ['as'=>'sms', 'uses' => 'DashboardController@sms']);
  Route::get('news', ['as'=>'news', 'uses' => 'DashboardController@news']);
  Route::get('samples', ['as'=>'samples', 'uses' => 'DashboardController@samples']);
  Route::get('wrules', ['as'=>'wrules', 'uses' => 'DashboardController@wrules']);
  Route::get('wreviews', ['as'=>'wreviews', 'uses' => 'DashboardController@wreviews']);

  Route::get('chat-read/{id}', ['as'=>'chat_read', 'uses' => 'DashboardController@chatRead']);
  Route::get('view-messages/{id}', ['as'=>'view_messages', 'uses' => 'DashboardController@viewMessages']);
  Route::post('reply-message', ['as'=>'reply_message', 'uses' => 'DashboardController@replyMessage']);
  Route::post('write-note', ['as'=>'write_note', 'uses' => 'DashboardController@writeNote']);
  Route::post('reviewstore', ['as'=>'reviewstore', 'uses' => 'DashboardController@reviewstore']);

  Route::post('assign_editor', ['as'=>'assign_editor', 'uses' => 'DashboardController@assignEditor']);


  Route::get('payments', ['as'=>'payments', 'uses' => 'DashboardController@payments']);
  
  Route::post('save-writer', ['as'=>'save_writer', 'uses' => 'DashboardController@saveWriter']);
  Route::post('edit-profile', ['as'=>'edit_profile', 'uses' => 'DashboardController@editProfile']);


        Route::get('packages', ['as'=>'packages', 'uses' => 'DashboardController@packages']);
      Route::get('keywords', ['as'=>'keywords', 'uses' => 'DashboardController@keywords']);
      
      Route::get('posts', ['as'=>'posts', 'uses' => 'DashboardController@posts']);
      Route::get('products', ['as'=>'products', 'uses' => 'DashboardController@products']);
      Route::get('trainings', ['as'=>'trainings', 'uses' => 'DashboardController@trainings']);
      Route::get('post-page', ['as'=>'post_page', 'uses' => 'DashboardController@postPage']);
    Route::get('categories', ['as'=>'categories', 'uses' => 'DashboardController@categories']);

          Route::post('new-category', ['as'=>'new_category', 'uses' => 'DashboardController@newCategory']);
            Route::post('new-sub-category', ['as'=>'new_sub_category', 'uses' => 'DashboardController@newSubCategory']);

//admin access
  Route::group(['middleware'=>'only_admin_access'], function(){
    Route::group(['prefix'=>'settings'], function(){
      Route::get('/', ['as'=>'settings', 'uses' => 'DashboardController@settings']);
      Route::get('homepage', ['as'=>'homepage', 'uses' => 'DashboardController@homepage']);
      Route::get('accounting', ['as'=>'accounting', 'uses' => 'DashboardController@accounting']);
      Route::post('top-wallet', ['as'=>'top_wallet', 'uses' => 'DashboardController@topWallet']);
      Route::get('update-post', ['as'=>'update_post', 'uses' => 'DashboardController@updatepost']);

      Route::post('aprove_payment', ['as'=>'approve_payment', 'uses' => 'DashboardController@approvePayment']);
      Route::get('media', ['as'=>'media', 'uses' => 'DashboardController@media']);
      Route::get('order-settings', ['as'=>'order_settings', 'uses' => 'DashboardController@orderSettings']);
      Route::post('delete-user-admin', ['as'=>'delete_user_admin', 'uses' => 'DashboardController@deleteAdminUser']);
      Route::get('websites', ['as'=>'websites', 'uses' => 'DashboardController@websites']);
      Route::post('add-website', ['as'=>'add_website', 'uses' => 'DashboardController@addWebsite']);
      Route::post('add-site', ['as'=>'add_site', 'uses' => 'DashboardController@addSite']);
      Route::get('sites', ['as'=>'sites', 'uses' => 'DashboardController@sites']);
      Route::get('users', ['as'=>'users', 'uses' => 'DashboardController@users']);
      Route::get('add-user', ['as'=>'add_user', 'uses' => 'DashboardController@addUsers']);
      Route::get('writers', ['as'=>'writers', 'uses' => 'DashboardController@writers']);
      Route::get('clients', ['as'=>'clients', 'uses' => 'DashboardController@clients']);
      Route::get('editors', ['as'=>'editors', 'uses' => 'DashboardController@editors']);
      Route::post('update-user-admin', ['as'=>'update_user_admin', 'uses' => 'DashboardController@updateAdminUser']);


      Route::post('save-package', ['as'=>'save_package', 'uses' => 'DashboardController@savePackage']);
      Route::post('save-keyword', ['as'=>'save_keyword', 'uses' => 'DashboardController@saveKeyword']);
      Route::post('update-package', ['as'=>'update_package', 'uses' => 'DashboardController@updatePackage']);
      Route::post('update-keyword', ['as'=>'update_keyword', 'uses' => 'DashboardController@updateKeyword']);
      Route::post('create-expense', ['as'=>'create_expense', 'uses' => 'DashboardController@createExpense']);
      Route::post('create-withdraw', ['as'=>'create_withdraw', 'uses' => 'DashboardController@createWithdraw']);

      Route::get('emails', ['as'=>'emails', 'uses' => 'DashboardController@emails']);
      Route::get('sales', ['as'=>'sales', 'uses' => 'DashboardController@sales']);
      Route::post('delete-keyword', ['as'=>'delete_keyword', 'uses' => 'DashboardController@deleteKeyword']);
            Route::post('delete-content', ['as'=>'delete_content', 'uses' => 'DashboardController@deleteContent']);

      Route::post('update-link', ['as'=>'generate_link', 'uses' => 'DashboardController@generateLink']);
      Route::post('save-user', ['as'=>'save_user', 'uses' => 'DashboardController@saveUser']);
      Route::get('users-info/{id}', ['as'=>'user_info', 'uses' => 'DashboardController@userInfo']);
      Route::get('website-info/{id}', ['as'=>'website_info', 'uses' => 'DashboardController@websiteInfo']);
      Route::get('login-as/{id}', ['as'=>'login_as', 'uses' => 'DashboardController@loginAs']);
      Route::post('adjust-time', ['as'=>'adjust_time', 'uses' => 'DashboardController@adjustTime']);
      Route::post('cancel-order', ['as'=>'cancel_order', 'uses' => 'DashboardController@cancelOrder']);
      Route::get('mpesa-transactions', ['as'=>'mpesa_transactions', 'uses' => 'DashboardController@mpesaTransactions']);
      Route::post('email-clients', ['as'=>'email_clients', 'uses' => 'DashboardController@emailClients']);
      Route::post('email-website', ['as'=>'email_website', 'uses' => 'DashboardController@emailWebsite']);
      Route::post('email-client', ['as'=>'email_client', 'uses' => 'DashboardController@emailClient']);

                    //Save settings / options
      Route::post('save-settings', ['as'=>'save_settings', 'uses' => 'DashboardController@updateOptions']);
      Route::get('create-pdf', ['as'=>'create_pdf', 'uses' => 'DashboardController@createPDF']);
      Route::post('new-pricing', ['as'=>'new_pricing', 'uses' => 'DashboardController@newPricing']);

      Route::post('update-pricing', ['as'=>'update_pricing', 'uses' => 'DashboardController@updatePricing']);
      Route::post('new-paper-type', ['as'=>'new_paper_type', 'uses' => 'DashboardController@newPaperType']);
      Route::post('new-charges', ['as'=>'new_charges', 'uses' => 'DashboardController@newCharges']);
      Route::post('update-cat', ['as'=>'update_cat', 'uses' => 'DashboardController@updateCat']);
            Route::post('update-category', ['as'=>'update_category', 'uses' => 'DashboardController@updateCategory']);
            Route::get('edit-category/{id}', ['as'=>'edit_category', 'uses' => 'DashboardController@editCategory']);
      Route::post('update-paper', ['as'=>'update_paper', 'uses' => 'DashboardController@updatePaper']);
      Route::post('update-charges', ['as'=>'update_charges', 'uses' => 'DashboardController@updateCharges']);
      Route::post('delete-paper', ['as'=>'delete_paper', 'uses' => 'DashboardController@deletePaper']);
      Route::post('delete-cat', ['as'=>'delete_cat', 'uses' => 'DashboardController@deleteCat']);
      Route::post('delete-product', ['as'=>'delete_product', 'uses' => 'DashboardController@deleteProduct']);
        
      Route::get('tasks', ['as'=>'issues', 'uses' => 'DashboardController@issues']);
      Route::get('subscriptions', ['as'=>'subscriptions', 'uses' => 'DashboardController@subscriptions']);
      Route::post('add-task', ['as'=>'add_task', 'uses' => 'DashboardController@addTask']);
      Route::get('balance_account', ['as'=>'balance_account', 'uses' => 'DashboardController@balanceAccount']);
      Route::post('update-task', ['as'=>'update_task', 'uses' => 'DashboardController@updateTask']);

      Route::post('delete-post', ['as'=>'delete_post', 'uses' => 'DashboardController@deletePost']);
      Route::post('delete-site', ['as'=>'delete_site', 'uses' => 'DashboardController@deleteSite']);
      Route::post('delete-sales', ['as'=>'delete_sales', 'uses' => 'DashboardController@deleteSales']);
      Route::get('pages-setting', ['as'=>'pages_setting', 'uses' => 'DashboardController@pagesSetting']);



      Route::get('sms-success', ['as'=>'sms_success', 'uses' => 'DashboardController@smsSuccess']);
      Route::post('upload-media', ['as'=>'upload_media', 'uses' => 'DashboardController@uploadMedia']);

      Route::get('update-post', ['as'=>'update_post', 'uses' => 'DashboardController@updatepost']);
      Route::post('delete-message', ['as'=>'delete_message', 'uses' => 'DashboardController@deleteMessage']);
      Route::post('delete-bid', ['as'=>'delete_bid', 'uses' => 'DashboardController@deleteBid']);
      Route::post('delete-file', ['as'=>'delete_file', 'uses' => 'DashboardController@deleteFile']);
      Route::post('delete-revision', ['as'=>'delete_revision', 'uses' => 'DashboardController@deleteRevision']);
      Route::post('update-revision', ['as'=>'update_revision', 'uses' => 'DashboardController@updateRevision']);

      Route::post('change-password2', ['as'=>'change_password2', 'uses' => 'DashboardController@changePassword']);

      Route::get('finance', ['as'=>'finance', 'uses' => 'DashboardController@finance']);
      Route::post('update-user', ['as'=>'update_user', 'uses' => 'DashboardController@updateUser']);
      Route::post('update-user-info', ['as'=>'update_user_info', 'uses' => 'DashboardController@updateUserInfo']);

      Route::post('fine-order', ['as'=>'fine_order', 'uses' => 'DashboardController@fineOrder']);
      Route::post('change-password', ['as'=>'change_password', 'uses' => 'DashboardController@changePasswordPost']);


      Route::post('edit-website', ['as'=>'edit_website', 'uses' => 'DashboardController@editWebsite']);
      Route::post('aedit-profile', ['as'=>'aedit_profile', 'uses' => 'DashboardController@aeditProfile']);
      Route::post('suspend-user', ['as'=>'suspend_user', 'uses' => 'DashboardController@suspendUser']);


      Route::post('send-dispute', ['as'=>'send_dispute', 'uses' => 'DashboardController@sendDispute']);
      Route::post('solve-dispute', ['as'=>'solve_dispute', 'uses' => 'DashboardController@solveDispute']);

      Route::post('send-invoice', ['as'=>'send_invoice', 'uses' => 'DashboardController@sendInvoice']);
      Route::post('admin_send-invoice', ['as'=>'admin_generate_invoices', 'uses' => 'DashboardController@adminSendInvoice']);

      Route::post('update-invoice', ['as'=>'update_invoice', 'uses' => 'DashboardController@updateInvoice']);
      Route::post('update-site', ['as'=>'update_site', 'uses' => 'DashboardController@updateSite']);

      Route::post('adjust-prices', ['as'=>'adjust_prices', 'uses' => 'DashboardController@adjustPrices']);

      Route::post('delete-order', ['as'=>'delete_order', 'uses' => 'DashboardController@deleteOrder']);

      Route::post('add-service', ['as'=>'add_service', 'uses' => 'DashboardController@addServiceCat']);

      Route::post('add-task', ['as'=>'add_task', 'uses' => 'DashboardController@addTask']);



      Route::post('asave-service', ['as'=>'asave_service', 'uses' => 'DashboardController@asaveService']);

    });

});
});

Route::get('{slug}', ['as' => 'page_single', 'uses'=>'App\Http\Controllers\WelcomeController@sitemaps']);
