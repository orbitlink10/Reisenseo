<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Template;
use App\Models\Sub_category;
use App\Models\Reject;
use App\Models\Answer;
use App\Models\Admin;
use App\Models\Application;
use App\Models\Product;
use App\Models\Site;
use App\Models\Sale;
use App\Models\Link;
use App\Models\Keyword;
use App\Models\Sms;
use App\Models\Message;
use App\Models\Warning;
use App\Models\User_subject;
use App\Models\Website;
use App\Models\Level;
use App\Models\Post;
use App\Models\Upsell;
use App\Models\Comment;
use App\Models\Bid;
use App\Models\Task;
use App\Models\Expense;
use App\Models\Paper;
use App\Models\Page;
use App\Models\Review_rating;
use App\Models\Option;
use App\Models\Chat;
use App\Models\Transaction;
use App\Models\Invoice;
use App\Models\Upload;
use App\Models\Revision;
use App\Models\Dispute;
use App\Models\Order;
use App\Models\Package;
use App\Models\Pricing;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Charge;
use App\Models\Iservice;
use App\Models\Service;
use PDF;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use SmoDav\Mpesa\Laravel\Facades\STK;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function dashboard(Request $request)
    {
      $user = Auth::user();

      if ($user->account_status === '0') {
        // Redirect to the account activation/subscription page with a message.
        //return redirect()->route('admin.subscribe')->with('success', trans('Your account is currently inactive. Please select your suitable package.'));
      }

      $user_id = $user->id;
      $orders = Order::query()->orderBy('id', 'desc');

      if ($user->is_author()) {
        if ($request->has('q')) {
          $orders->whereStatus($request->q);
        }
      } elseif ($user->is_admin()) {
        if ($request->has('q')) {
          $orders->whereStatus($request->q);

          
        }

        $user = User::find($user->id);

        if ($user->active_status == 0) {
          $data = [
            'name' => $user->name,
            'email' => $user->email,
            'sname' => 'Here is your activation code ' . $user->activation_code,
            'description' => 'Find your activation code ' . $user->activation_code,
          ];

            // Send email to agent
          Mail::send('email.index', $data, function ($message) use ($data) {
            $message->to($data['email']);
            $message->subject($data['sname']);
          });

          \LogActivity::addToLog('Activation code request');
          return redirect()->route('activate_code')->with('error', trans('verify your account'));
        }
      } elseif ($user->is_subadmin()) {
        if ($request->has('q')) {
          $orders->whereStatus($request->q);
        }
      } elseif ($user->is_editor()) {
        $orders->whereEditorId($user_id);
        if ($request->has('q')) {
          $orders->whereStatus($request->q);
        }

        if ($user->account_status == '0') {
          return redirect()->route('account')->with('error', 'Your account is not yet active');
        }

        if ($user->account_status == '2') {
          return redirect()->route('account')->with('error', 'Your account has been suspended');
        }
      } elseif ($user->is_client() || $user->is_student()) {
        $orders->whereUserId($user_id)->whereCrating(0)->whereStatus(5);
        if ($request->has('q')) {
          $orders->whereStatus($request->q);
        }
      } elseif ($user->is_writer()) {
        $orders->whereWriterId($user_id);
        if ($request->has('q')) {
          $orders->whereStatus($request->q);
        }

        if ($user->account_status == '0') {
          return redirect()->route('account')->with('error', 'Your account is not yet active');
        }

        if ($user->account_status == '2') {
          return redirect()->route('account')->with('error', 'Your account has been suspended');
        }
      }

      if ($user->is_admin()) {
        $catalog = Post::whereNotNull('slug')->whereType('product');
        $recentOrders = (clone $orders)->limit(8)->get();
        $customers = User::whereIn('id', $recentOrders->pluck('user_id'))->pluck('name', 'id');
        $recentProducts = (clone $catalog)->latest('id')->limit(12)->get();
        $categoryNames = Category::whereIn('id', $recentProducts->pluck('category_id'))->pluck('name', 'id');
        $pendingAccounts = User::where('active_status', 0)->latest('id')->limit(5)->get();
        $stats = [
          'orders' => Order::count(),
          'pending' => Order::whereStatus(0)->count(),
          'products' => (clone $catalog)->count(),
          'users' => User::count(),
          'approvals' => User::where('active_status', 0)->count(),
          'recentOrders' => Order::where('created_at', '>=', now()->subDays(7))->count(),
          'newUsers' => User::where('created_at', '>=', now()->subDays(30))->count(),
          'revenue' => Payment::whereStatus(1)->wherePaymentSource('Order paid')->sum('amount'),
          'activeUsers' => User::where('last_activity', '>=', now()->subDay())->count(),
          'completed' => Order::whereStatus(4)->count(),
          'categories' => Category::where('cat_type', 4)->count(),
        ];
        return view('admin.overview', compact('stats', 'recentOrders', 'customers', 'recentProducts', 'categoryNames', 'pendingAccounts'));
      }

      $orders = $orders->paginate(20);

      $date0 = Carbon::today();
      $date1 = Carbon::today()->subDays(1);
      $date2 = Carbon::today()->subDays(2);
      $date3 = Carbon::today()->subDays(3);
      $date4 = Carbon::today()->subDays(4);
      $date5 = Carbon::today()->subDays(5);
      $date6 = Carbon::today()->subDays(6);
      $date7 = Carbon::today()->subDays(7);

      return view('admin.dashboard', compact('orders', 'date0', 'date1', 'date2', 'date3', 'date4', 'date5', 'date6', 'date7'));



    }

    

   //view application
    public function application(){
      
      $user = Auth::user();
      $duplicate = Application::whereUserId($user->id)->count();
      if ($duplicate > 0){
        $order = Application::whereUserId($user->id)->first();
        return redirect(route('view_application', $order->id ));
      }else{
        return view('admin.application');
      }
      
    }


           //view application
    public function accounting(){
      
     return view('admin.accounting');
      
    }

    public function updatepost(){
     $orders = Order::where('status', '>', '4')->get();
     $order_count = 0;

     foreach ($orders as $key => $value) {

      $user         = User::find($value->writer_id);
      $order_count  = $user->orders;
      $user->orders = $order_count+1;
      $user->save();
    }

    echo "updated";
  }

  public function editPage($id)
  {

   $post  = Post::whereId($id)->first();
   $templates = Template::wherePostId($post->id)->get();
   $categories = Category::all();
   $sites = Website::all();
   return view('admin.edit_page', compact('post', 'categories', 'sites', 'templates'));
 }

 public function editPost($id)
 {

   $post  = Post::whereId($id)->first();
   $cat = Category::where('cat_type',4)->get();
   $sites = Website::all();
   
   return view('admin.edit_post', compact('post', 'cat', 'sites'));
 }


 public function editProduct($id)
 {

   $post  = Post::whereId($id)->first();
   $categories = Category::all();
   $sites = Website::all();
   return view('admin.edit_product', compact('post', 'categories', 'sites'));
 }


 public function editTraining($id)
 {

   $post  = Post::whereId($id)->first();
   $categories = Category::all();
   $sites = Website::all();
   return view('admin.edit_training', compact('post', 'categories', 'sites'));
 }

 


 public function loginAs($id)
 {

  if(Auth::user()->is_admin()){

   $admin = Auth::user()->id;
   $user = User::find($id);
   Auth::login($user);
 //  session()->put('admin_id', $admin);
   
 }
 return redirect(route('dashboard'))->with('success', 'login success');

}

public function logout(){
 //  $admin = session()->get('admin_id');
 //  if($admin){
 //    $user = User::find($admin);
 //    Auth::login($user);
 //    Session::pull('admin_id');
 //    return redirect(route('dashboard'))->with('success', 'login as admin success');
 //  }
 //  else{

 //   Auth::logout();
 //   Session::flush();
 //   return redirect(route('clogin'));

 // }

  Auth::logout();
  Session::flush();
  return redirect(route('clogin'));

}


public function alogout(){
  if (Auth::check()){
    Auth::logout();
  }
  return redirect(route('admin_login'));
}


//upload page media
public function uploadpMedia(Request $req){

  $deletesite  = Upload::whereSiteId($req->site_id)->whereImageType('logo')->delete();
  $upload_count = Upload::whereContentId($req->content_id)->count();
  if($upload_count>0){
    $uploads = Upload::whereContentId($req->content_id)->get();
    foreach ($uploads as $key => $upload) {
       $upload->status = 0;
    $upload->save();
    }


  
  }
  $user_id  = Auth::user()->id;
  $req->validate([
    'file' => 'required|mimes:png,jpeg,docx,pdf,webp|max:2048'
  ]);
  $fileModel = new Upload;
  if($req->file()) {
    $fileName = time().'_'.$req->file->getClientOriginalName();
    $filePath = $req->file('file')->storeAs('media', $fileName, 'public');
    $fileModel->name = time().'_'.$req->file->getClientOriginalName();
    $fileModel->post_id = $req->post_id;
    $fileModel->image_type = 'media';
    $fileModel->content_id = $req->content_id;
    $fileModel->status = '1';
    $fileModel->user_id = $user_id;
    $fileModel->file_path = '/storage/' . $filePath;
    $fileModel->save();
    return back()
    ->with('success','File has been uploaded.')
    ->with('file', $fileName);
  }
}

public function updatePage(Request $request)
{

  $slug = unique_slugu($request->title);

  $page = Post::find($request->page_id);
  $page->title = $request->title;
  $page->slug =$slug;
  $page->description = $request->description;
  $page->show_in_header_menu = $request->show_in_header_menu;
  $page->show_in_footer_menu = $request->show_in_footer_menu;
  $page->type = $request->post_type;
  $page->keywords = $request->keywords;
  $page->parent_page = $request->parent_page;
  $page->site_id = $request->site_id;
  $page->ti_icon = $request->ti_icon;
  $page->meta_description = $request->meta_description;
    $page->header1     = $request->header1;
    $page->description1     = $request->description1;
    $page->description2 = $request->description2;
    $page->feature1 = $request->feature1;
    $page->feature2 = $request->feature2;
    $page->feature3 = $request->feature3;




  $page->updated_at = Carbon::now();
  $page->save();


  return back()->withInput()->with('success', trans('User updated'));
}



public function addContent(Request $request)
{

$data = [
 'post_id' => $request->post_id,
 'description' => $request->description,
];

Template::create($data);


  return back()->withInput()->with('success', trans('Add Content success'));
}





     //update user data
public function deletePost(Request $request){

  $user = Post::find($request->id);
  $user->delete();
  return back()->withInput()->with('success', trans('Delete success'));

}


     //update user data
public function deleteSite(Request $request){

  $user = Site::find($request->id);
  $user->delete();
  return back()->withInput()->with('success', trans('Delete success'));

}

     //update user data
public function deleteSales(Request $request){

  $user = Sale::find($request->id);
  $user->delete();
  
  return back()->withInput()->with('success', trans('Delete success'));

}


public function updatesingleProduct(Request $request)
{

  $page = Post::find($request->page_id);
  $page->title       = $request->title;
  $page->category_id = $request->category_id ;
  $page->description = $request->description;
  $page->cost        = $request->cost;
  $page->show_in_header_menu = $request->show_in_header_menu;
  $page->show_in_footer_menu = $request->show_in_footer_menu;
  $page->type = $request->post_type;
  $page->keywords = $request->keywords;
  $page->parent_page = $request->parent_page;
  $page->site_id = $request->site_id;
  $page->ti_icon = $request->ti_icon;
  $page->demo_url = $request->demo_url;
  $page->meta_description = $request->meta_description;
  $page->updated_at = Carbon::now();
  $page->save();


  return back()->withInput()->with('success', trans('User updated'));
}


public function updatesinglePost(Request $request)
{

  $page = Post::find($request->page_id);
  

  $page->title = $request->title;
  $page->category_id = $request->category_id;
  $page->description = $request->description;
  $page->cost = $request->cost;
  $page->type = $request->post_type;
  $page->keywords = $request->keywords;
  $page->parent_page = $request->parent_page;
  $page->site_id = $request->site_id;
  $page->ti_icon = $request->ti_icon;
  $page->meta_description = $request->meta_description;
  $page->sub_category = $request->sub_category;
  $page->category_id = $request->category_id;
  $page->updated_at = Carbon::now();
  $page->save();


  return back()->withInput()->with('success', trans('Product updated'));
}

public function updateUserPost(Request $request)
{
  $user_id     = Auth::user()->id;
  $user        = User::whereId($user_id)->first();
  $user->post_category = $request->post_cat;
  $user->site_id = $request->site_id;
  $user->page_id = $request->page_id;
  $user->save();
  return back()->withInput()->with('success', trans('update saved'));
}


//             //email client
// public function emailClient(Request $request)
// {

// $client = User::find($request->client_id);
// $data=array(
//     'name' =>$client->name,
//     'email'=>$client->email,
//     'sname'=>$request->topic,
//     'description'=>$request->message,

//   );

//   //send email to client
//   Mail::send('email.index',$data, function($message) use ($data){
//     $message->to($data['email']);
//     $message->subject($data['sname']);

//   }); 


//   $data = [
//     'message'    => $request->message,
//     'topic'      => $request->topic,
//     'client_id'  => $request->client_id,
//   ];

//   Message::create($data);
//   return back()->withInput()->with('success', trans('Email sent successfully'));
// }


        //email client
public function emailClient(Request $request)
{

  $client = User::find($request->client_id);
  $site = Website::find($client->site_id);

  $data=array(
    'name' =>$client->name,
    'email'=>$client->email,
    'sname'=>$request->topic,
    'description'=>$request->message,
    'domain_name' =>$site->domain_name,

  );


    // //send email to client
    // Mail::send('email.index',$data, function($message) use ($data){
    //   $message->to($data['email']);
    //   $message->subject($data['sname']);

    // });

  send_email($data, $site);


  $data = [
    'message'    => $request->message,
    'topic'      => $request->topic,
    'client_id'  => $request->client_id,
  ];

  Message::create($data);



  return back()->withInput()->with('success', trans('Email sent successfully'));




}


                  //email clients
public function emailClients(Request $request)
{


  $clients = User::whereUserType($request->user_type)->get();


  foreach($clients as $client){
   $site = Website::find($client->site_id);

   $data=array(
    'name' =>$client->name,
    'email'=>$client->email,
    'sname'=>$request->topic,
    'description'=>$request->message,
    'domain_name' =>$site->domain_name,

  );


                     //send email to client
   Mail::send('email.index',$data, function($message) use ($data){
     $message->to($data['email']);
     $message->subject($data['sname']);

   }); 

   // send_email($data, $site);


   $data = [
    'message' => $request->message,
    'topic'   => $request->topic,
    'client_id'  => $client->id,
  ];

  Message::create($data);

}





return back()->withInput()->with('success', trans('Email sent successfully'));
}


                //email website
public function emailWebsite(Request $request)
{


  $clients = User::whereSiteId($request->site_id)->get();


  foreach($clients as $client){
   $site = Website::find($client->site_id);

   $data=array(
    'name' =>$client->name,
    'email'=>$client->email,
    'sname'=>$request->topic,
    'description'=>$request->message,
    'domain_name' =>$site->domain_name,

  );


    //                 //send email to client
    // Mail::send('email.index',$data, function($message) use ($data){
    //   $message->to($data['email']);
    //   $message->subject($data['sname']);

    // }); 

   send_email($data, $site);


   $data = [
    'message' => $request->message,
    'topic'   => $request->topic,
    'client_id'  => $client->id,
  ];

  Message::create($data);

}





return back()->withInput()->with('success', trans('Email sent successfully'));
}


public function posts(Request $request)
{
  $posts  = Post::whereNotNull('slug')->whereType('post')->orderBy('id', 'desc')->paginate(20);
  $categories = Category::all();
  $sites = Website::all();

  if($request->site_id){
   $posts  = Post::whereNotNull('slug')->whereType('post')->whereSiteId($request->site_id)->orderBy('id', 'desc')->paginate(20);
 }
 return view('admin.posts', compact('posts', 'categories', 'sites'));
}


public function products(Request $request)
{
  $posts  = Post::whereNotNull('slug')->whereType('product')->orderBy('id', 'desc')->paginate(20);
  $categories = Category::where('cat_type',4)->get();
  $sites = Website::all();

  if($request->site_id){
   $posts  = Post::whereNotNull('slug')->whereType('product')->whereSiteId($request->site_id)->orderBy('id', 'desc')->paginate(20);
 }
 return view('admin.products', compact('posts', 'categories', 'sites'));
}


public function trainings(Request $request)
{
  $posts  = Post::whereNotNull('slug')->whereType('training')->orderBy('id', 'desc')->paginate(20);
  $categories = Category::all();
  $sites = Website::all();

  if($request->site_id){
   $posts  = Post::whereNotNull('slug')->whereType('training')->whereSiteId($request->site_id)->orderBy('id', 'desc')->paginate(20);
 }
 return view('admin.trainings', compact('posts', 'categories', 'sites'));
}



public function postPage(Request $request)
{
  $posts  = Post::whereNotNull('slug')->whereType('page')->orderBy('id', 'desc')->paginate(20);
  $categories = Category::all();
  $sites = Website::all();
  if($request->site_id){
   $posts  = Post::whereNotNull('slug')->whereType('page')->whereSiteId($request->site_id)->orderBy('id', 'desc')->paginate(20);
 }
 
 return view('admin.post_page', compact('posts', 'categories', 'sites'));
}


public function mpesaTransactions()
{
  $transactions  = Transaction::where('Amount', '>', 0)->orderBy('id', 'desc')->paginate(20);
  return view('admin.transactions', compact('transactions'));
}

public function addPost(Request $request)
{
  $user_id  = Auth::user()->id;

  $data = [
    'title'          => $request->title,
    'category_id'    => $request->category_id,
    'description'    => $request->description,
    'cost'           => $request->cost,
    'site_id'        => $request->site_id,
    'parent_page'    => 2,
    'ti_icon'        => $request->ti_icon,
    'writer_id'      => $user_id,
    'type'           => 'post',

  ];

  Post::create($data);

  
  return back()->withInput()->with('success', trans('post added'));
}


public function addTraining(Request $request)
{
  $user_id  = Auth::user()->id;

  $data = [
    'title'          => $request->title,
    'category_id'    => $request->category_id,
    'description'    => $request->description,
    'site_id'        => $request->site_id,
    'parent_page'    => $request->parent_page,
    'ti_icon'        => $request->ti_icon,
    'cost'           => $request->cost,
    'writer_id'      => $user_id,
    'type'           => 'training',

  ];

  Post::create($data);

  
  return back()->withInput()->with('success', trans('post added'));
}


public function addProduct(Request $request)
{
  $validated = Validator::make($request->all(), [
        'title' => 'bail|required|string',
        'category_id' => 'bail|required',
        'site_id' => 'bail|required',
        'cost' => 'bail|required',
    ]);

    if ($validated->fails()) {
        return back()->withErrors($validated)->withInput();
    }


  $user_id  = Auth::user()->id;

  $data = [
    'title'          => $request->title,
    'category_id'    => $request->category_id,
    'description'    => $request->description,
    'site_id'        => $request->site_id,
    'parent_page'    => $request->parent_page,
    'ti_icon'        => $request->ti_icon,
    'cost'           => $request->cost,
    'writer_id'      => $user_id,
    'type'           => 'product',

  ];


  Post::create($data);

  
  return back()->withInput()->with('success', trans('Product Created Successfully'));
}


public function addPage(Request $request)
{
  $user_id  = Auth::user()->id;

  $data = [
    'title'          => $request->title,
    'category_id'    => $request->category_id,
    'description'    => $request->description,
    'site_id'        => $request->site_id,
    'parent_page'    => $request->parent_page,
    'ti_icon'        => $request->ti_icon,
    'writer_id'      => $user_id,
    'type'           => 'page',

  ];

  Post::create($data);

  
  return back()->withInput()->with('success', trans('post added'));
}

  //add task
public function addWebsite(Request $request){
  $data = [
    'domain_name'   => $request->domain_name,
  ];

  $task_created= Website::create($data);
  return back()->withInput()->with('success', trans('Website added successfully'));


}

  //add task
public function addSite(Request $request){
  $data = [
    'domain_name'   => $request->domain_name,
  ];

  $task_created= Site::create($data);
  return back()->withInput()->with('success', trans('Website added successfully'));


}



  //add task
public function addServiceCat(Request $request){
$slug = unique_slugu($request->name);
  $data = [

     'slug'       => $slug,
     'name'      => $request->name,
  ];

  $task_created= Service::create($data);
  return back()->withInput()->with('success', trans('Service created successfully'));


}




  //add task
public function addTask(Request $request){
  $user_id  = Auth::user()->id;
  $data = [
    'user_id'     => $user_id,
    'label'       => $request->label,
    'description' => $request->description,
    'name'        => $request->name,
    'cost'        => $request->cost,
    'status' => 2,
  ];
  $task_created= Task::create($data);
  return back()->withInput()->with('success', trans('Task created successfully'));

}

     //add task
public function emails(Request $request){
 $clients = User::orderBy('email', 'asc')->get();
 return view('admin.emails', compact('clients'));

}

           //update expense
public function updateTask(Request $request){
  $property = Task::find($request->id);
  $property->label        = $request->label;
  $property->description  = $request->description;
  $property->status       = $request->status;
  $property->cost          = $request->cost;
  $property->name          = $request->name;
  $property->save();
  return back()->withInput()->with('success', trans('Update success'));
}


       //update expense
public function updateExpense(Request $request){
  $property = Expense::find($request->id);
  $property->amount      = $request->amount;
  $property->save();
  return back()->withInput()->with('success', trans('Update success'));
}

    //to do lists

public function news(Request $request){
  $news = Post::whereParentPage(8)->orderBy('id', 'desc')->paginate(20);
  $title = 'News';
  return view('admin.news', compact('news','title'));


}

public function wrules(Request $request){
  $news = Post::whereParentPage(9)->orderBy('id', 'desc')->paginate(20);
  $title = 'Rules and Regulations';
  return view('admin.news', compact('news', 'title'));


}

public function samples(Request $request){

  $samples = Post::whereParentPage(10)->orderBy('id', 'desc')->paginate(20);
  $title = 'Samples';
  return view('admin.samples', compact('samples', 'title'));


}

        //to do lists

public function wreviews(Request $request){

  $user_id  = Auth::user()->id;
  $reviews     = Review_rating::whereWriterId($user_id)->orderBy('id', 'desc')->paginate(20);

  return view('admin.wreviews', compact('reviews'));


}

    //to do lists

public function issues(Request $request){
  $user_id  = Auth::user()->id;
  $tasks    = Task::orderBy('id', 'desc')->whereStatus(2)->paginate(20);
  if($request->label){
    $tasks = Task::whereStatus($request->label)->orderBy('id', 'desc')->paginate(20);
  }

  return view('admin.view_tasks', compact('tasks'));


}


public function categories(Request $request){

  $user_id  = Auth::user()->id;
  $tasks    = Service::orderBy('id', 'desc')->paginate(200);
  $categories = Category::where('cat_type',4)->orderBy('id', 'desc')->paginate(200);
  

  $sub_categories = Sub_category::orderBy('id', 'desc')->paginate(200);

  if($request->label){
    $tasks = Service::whereStatus($request->label)->orderBy('id', 'desc')->paginate(20);
  }

  return view('admin.categories', compact('tasks', 'categories', 'sub_categories'));


}

           //adjust prices
public function adjustPrices(Request $request){
  $order = Order::find($request->order_id);
  $order->ccost              = $request->ccost;
  $order->slug              = $request->slug;
  $order->writer_id              = $request->writer_id;
  $order->user_id              = $request->user_id;
  $order->ecost              = $request->ecost;
  $order->order_admin_share  = $request->order_admin_share;
  $order->subscription_fee   = $request->subscription_fee;
  $order->wcost              = $request->wcost;
  $order->payments           = $request->payments;
  $order->invoice_id          = $request->invoice_id;
  $order->einvoice_id          = $request->einvoice_id;
  $order->epayments          = $request->epayments;
  $order->order_fine          = $request->order_fine;
  $order->order_finereason    = $request->order_finereason;
  $order->order_cancelreason    = $request->order_cancelreason;
  $order->writer_confirm          = $request->writer_confirm;
  $order->preferred_writer_only_total          = $request->preferred_writer_only_total;
  $order->save();
  return back()->withInput()->with('success', trans('Update success'));
}


       //adjust time
public function adjustTime(Request $request){
  $property = Order::find($request->order_id);
  $property->order_wrdeadline      = $request->order_wrdeadline;
  $property->order_eddeadline      = $request->order_eddeadline;
  $property->order_due             = $request->order_deadline;
  $property->save();
  return back()->withInput()->with('success', trans('Update success'));
}


       //adjust time
public function cancelOrder(Request $request){

  $order = Order::find($request->order_id);

  if($order->payment_way == 0){

    if($order->status == 0){

      $order->status = 7;
      $order->order_cancelreason = $request->order_cancelreason;
      $order->save();

    }

    if($order->status > 0 ){

      $order->status = 7;
      $order->cancelled_by       = Auth::user()->name.'('.Auth::user()->user_type.')';
      $order->order_cancelreason = $request->order_cancelreason;
      $order->save();


      $data = [

        'order_id'             => $order->order_id,
        'amount'               => $order->ccost,
        'user_id'              => $order->user_id,
        'payment_source'       => 'Order Refund',
        'pay_reason'           => 'checkout',
        'currency'             => '2',
        'status'               => '1',

      ];

      $pay_created = Payment::create($data);

    }



  }




  return back()->withInput()->with('success', trans('Update success'));

}



  //create expense
public function createExpense(Request $request){
  $user_id = Auth::user()->id;
  $savings_count = Option::find(1)->saseni_savings;
  $now = Carbon::now();
  $year  =  $now->year;
  $data = [
    'month'          => $request->current_month,
    'year'           => $year,
    'amount'         => $request->amount,
    'name'           => $request->name,
    'user_id'        => $user_id,
    'transaction_type' => $request->transaction_type,

  ];

  $service1_created = Expense::create($data);

  if($request->transaction_type == '2'){
   $sms_count = Option::find(1);
   $sms_count->sms_count = 0;
   $sms_count->save(); 
 }

 return redirect(route('finance'))->with('success', trans('Expense added'));

}


  //create expense
public function createWithdraw(Request $request){
  $user_id = Auth::user()->id;
  $savings_count = Option::find(1);
  $amount        = $request->amount;
  $saving_amount = $amount*0.10;
  $amount = $amount- $saving_amount;

  $saving_bal = $savings_count->saseni_savings;
  $savings_count->saseni_savings =  $saving_bal + $saving_amount;
  $savings_count->save();

  $now = Carbon::now();
  $year  =  $now->year;

  $data = [
    'month'          => $request->current_month,
    'year'           => $year,
    'amount'         => $amount,
    'name'           => $request->name,
    'user_id'        => $user_id,
    'transaction_type' => $request->transaction_type,

  ];

  $service1_created = Expense::create($data);


  $data2 = [
    'month'          => $request->current_month,
    'year'           => $year,
    'amount'         => $saving_amount,
    'name'           => 'Savings',
    'user_id'        => $user_id,
    'transaction_type' => $request->transaction_type,

  ];

  $service2_created = Expense::create($data2);

  return redirect(route('finance'))->with('success', trans('Expense added'));

}



public function order(Request $request){
  $user = Auth::user();

//verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$show_inquiry = 0;
$user_id = $user->id;
$title = "Recent orders";
if($user->account_status == '0'){

       //return view('admin.subscribe')->with('success', trans('Your account is currently inactive. Please select your suitable package.'));

}



if ($user->is_admin()){
  $orders = Order::orderBy('id', 'desc')->paginate(20); 

  if($request->q){
    $orders = Order::where('status', $request->q)->orderBy('id', 'desc')->paginate(50);

    if($request->q == '11'){

      $orders = Order::whereStatus('5')->where('preferred_writer_only_total', '>', '0')->orderBy('id', 'desc')->paginate(500);

    } 

    if($request->q == '12'){

      $orders = Order::whereStatus('5')->where('top_ten_total', '>', '0')->orderBy('id', 'desc')->paginate(500);

    } 
  }

  if($request->or){
    $orders = Order::where('status', '1')->where('preferred_writer', '>', '0')->orderBy('id', 'desc')->paginate(50); 
  }

  if($request->c){
   $orders = Order::whereWriterConfirm('0')->whereStatus(2)->orderBy('id', 'desc')->paginate(20); 

 }

 if($request->payment_way){
   $orders = Order::wherePaymentWay('1')->orderBy('id', 'desc')->paginate(20); 

 }

 if($request->level){

   $orders = Order::whereStatus(0)->whereOrderLevel($request->level)->orderBy('id', 'desc')->paginate(20); 

 }

 if($request->pay){
   $orders = Order::wherePaymentWay('1')->whereUserId($request->pay)->orderBy('id', 'desc')->paginate(20); 

 }

 if ($request->search) {
  $orders  = Order::where('id','like', "%{$request->search}%")->orWhere('title','like', "%{$request->search}%")->orderBy('id', 'desc')->paginate(20);

}

}

if ($user->is_subadmin()){
  $orders = Order::orderBy('id', 'desc')->paginate(20); 

  if($request->q){
    $orders = Order::where('status', $request->q)->orderBy('id', 'desc')->paginate(20); 
  }

  if($request->c){
   $orders = Order::whereWriterConfirm('0')->whereStatus(2)->orderBy('id', 'desc')->paginate(20); 

 }

 if($request->level){

   $orders = Order::whereStatus(0)->whereOrderLevel($request->level)->orderBy('id', 'desc')->paginate(20); 

 }

 if ($request->search) {
  $orders  = Order::where('id','like', "%{$request->search}%")->orWhere('title','like', "%{$request->search}%")->orderBy('id', 'desc')->paginate(20);

}

}

if ($user->is_editor()){
  $orders = Order::whereEditorId($user_id)->orderBy('id', 'desc')->paginate(20); 

  if($request->q){
    $orders = Order::whereEditorId($user_id)->whereStatus($request->q)->orderBy('id', 'desc')->paginate(20); 
  }

  if($request->c){
   $orders = Order::whereWriterConfirm(0)->whereStatus(2)->orderBy('id', 'desc')->paginate(20); 

 }

 if($request->aa){
   $orders = Order::whereStatus($request->aa)->whereOrderLevel('normal')->orderBy('id', 'desc')->paginate(20); 

 }

 if ($request->search) {
  $orders  = Order::whereEditorId($user_id)->where('id','like', "%{$request->search}%")->orWhere('title','like', "%{$request->search}%")->orderBy('id', 'desc')->paginate(20);

}

}


if ($user->is_client() or $user->is_student()){
  $orders = Order::whereUserId($user_id)->orderBy('id', 'desc')->paginate(20); 

  if($request->q){
    $orders = Order::whereUserId($user_id)->whereStatus($request->q)->orderBy('id', 'desc')->paginate(20); 
  }

  if($request->payment_way){
   $orders = Order::whereUserId($user_id)->wherePaymentWay('1')->orderBy('id', 'desc')->paginate(20); 

 }

 if($request->writer){
   $title = 'Orders done by '.username($request->writer)->nickname;
   $orders = Order::whereUserId($user_id)->whereWriterId($request->writer)->orderBy('id', 'desc')->paginate(20); 

 }

 if($request->editor){
   $title = 'Orders edited by '.username($request->editor)->name;
   $orders = Order::whereUserId($user_id)->whereEditorId($request->editor)->orderBy('id', 'desc')->paginate(20); 

 }


 if ($request->search) {



  $orders  = Order::whereUserId($user_id)->where('id','like', "%{$request->search}%")->orderBy('id', 'desc')->paginate(20);

  $orders_count1  = Order::whereUserId($user_id)->where('id','like', "%{$request->search}%")->orderBy('id', 'desc')->count();

  if($orders_count1 <= 0){
    $orders  = Order::whereUserId($user_id)->where('title','like', "%{$request->search}%")->orderBy('id', 'desc')->paginate(20);
  }



}

}
if ($user->is_writer()){

  $orders = Order::whereWriterId($user_id)->orderBy('id', 'desc')->paginate(20); 

  if($request->q){

   $orders = Order::whereWriterId($user_id)->whereStatus($request->q)->orderBy('id', 'desc')->paginate(20); 

 }

 if($request->or){
  $orders = Order::wherePreferredWriter($user_id)->where('status', '1')->orderBy('id', 'desc')->paginate(50); 
}

if ($request->search) {
  $orders  = Order::whereWriterId($user_id)->where('id','like', "%{$request->search}%")->orWhere('title','like', "%{$request->search}%")->orderBy('id', 'desc')->paginate(20);

}

if($request->wa){

  $title = "Orders Available";
  $orders = Order::whereStatus($request->wa)->orderBy('id', 'desc')->paginate(20); 
  $show_inquiry = 1;

  $user = Auth::user();
  if($user->added_by == 'client'){

    $orders = Order::whereStatus($request->wa)->whereUserId($user->user_id)->orderBy('id', 'desc')->paginate(20); 
  }


}

if($request->level){

 $orders = Order::whereStatus(0)->whereOrderLevel($request->level)->orderBy('id', 'desc')->paginate(20); 

}

if($request->history){
  $title = "These are the recent orders done by you for this customer";
  $orders = Order::whereWriterId($user_id)->whereUserId($request->history)->orderBy('id', 'desc')->paginate(20); 

}

if($request->c){
 $orders = Order::whereWriterId($user_id)->whereWriterConfirm(0)->orderBy('id', 'desc')->paginate(20); 

}

if($user->account_status == '0'){

 return redirect(route('account'))->with('error', 'Your account is not yet active');

}

if($user->account_status == '2'){

  if($request->q == 6){

  }

  else{
   return redirect(route('account'))->with('error', 'Your account has been suspended');  
 }



}

}



return view('admin.orders', compact('orders', 'show_inquiry', 'title'));







}

public function media()
{
  $user_id  = Auth::user()->id;
  $orders  = Upload::where('image_type', '!=' ,'order')->whereUserId($user_id)->orderBy('id', 'desc')->paginate(20);

  return view('admin.media', compact('orders'));
}

//upload media
public function uploadMedia(Request $req){

  $deletesite  = Upload::whereSiteId($req->site_id)->whereImageType('logo')->delete();
  $user_id  = Auth::user()->id;
  $req->validate([
   'file' => 'required|mimes:csv,txt,xlx,xls,pdf,docx,doc,png,jpeg,pptx,zip,rar,xlsx,ogg,mp4|max:100048'
 ]);
  $fileModel = new Upload;
  if($req->file()) {
    $fileName = time().'_'.$req->file->getClientOriginalName();
    $filePath = $req->file('file')->storeAs('media', $fileName, 'public');
    $fileModel->name = time().'_'.$req->file->getClientOriginalName();
    $fileModel->site_id = $req->site_id;
    $fileModel->image_type = 'media';
    $fileModel->status = '1';
    $fileModel->user_id = $user_id;
    $fileModel->file_path = '/storage/' . $filePath;
    $fileModel->save();
    return back()
    ->with('success','File has been uploaded.')
    ->with('file', $fileName);
  }
}


public function orderFined(Request $request){
  $user = Auth::user();

//verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$user_id = $user->id;
if($user->account_status == '0'){

       //return view('admin.subscribe')->with('success', trans('Your account is currently inactive. Please select your suitable package.'));

}



if ($user->is_admin() or $user->is_subadmin()){
 $orders = Order::where('order_fine', '>', 0)->orderBy('id', 'desc')->paginate(50); 
}



if ($user->is_client()){
  $orders = Order::whereUserId($user_id)->orderBy('id', 'desc')->paginate(20); 

  $orders = Order::wherePaymentWay(1)->whereUserId($user_id)->orderBy('id', 'desc')->paginate(20); 

}



return view('admin.orders', compact('orders'));
}

  //in pay way

public function paymentWay(Request $request){
  $user = Auth::user();
  $user_id = $user->id;


  //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


if($user->account_status == '0'){

       //return view('admin.subscribe')->with('success', trans('Your account is currently inactive. Please select your suitable package.'));

}



if ($user->is_admin()){
 $orders = Order::orderBy('id', 'desc')->paginate(20); 
 $orders = Order::wherePaymentWay(1)->orderBy('id', 'desc')->paginate(50); 
}



if ($user->is_client()){
  $orders = Order::whereUserId($user_id)->orderBy('id', 'desc')->paginate(20); 

  $orders = Order::wherePaymentWay(1)->whereUserId($user_id)->orderBy('id', 'desc')->paginate(20); 

}



return view('admin.orders', compact('orders'));
}


public function orderAvailable(Request $request){
  $user = Auth::user();
  $title = "Orders Available";
  $user_id = $user->id;
  if($user->account_status == '0'){

       //return view('admin.subscribe')->with('success', trans('Your account is currently inactive. Please select your suitable package.'));

  }



  if ($user->is_admin()){
   $orders = Order::orderBy('id', 'desc')->paginate(20); 
   $orders = Order::where('status', 1)->orderBy('id', 'desc')->paginate(50); 
 }

 if ($user->is_subadmin()){
  $orders = Order::orderBy('id', 'desc')->paginate(20); 

  $orders = Order::where('status', 1)->orderBy('id', 'desc')->paginate(20); 



}

if ($user->is_editor()){

  $orders = Order::whereEditorId($user_id)->orderBy('id', 'desc')->paginate(20); 

  $orders = Order::where('ecost', '>', 0)->whereStatus(3)->where('editor_id', '==', 0)->orderBy('id', 'desc')->paginate(20); 

}


if ($user->is_client() or $user->is_student()){
  $orders = Order::whereUserId($user_id)->orderBy('id', 'desc')->paginate(20); 

  $orders = Order::whereUserId($user_id)->whereStatus(1)->orderBy('id', 'desc')->paginate(20); 



}
if ($user->is_writer()){
  $orders = Order::whereWriterId($user_id)->orderBy('id', 'desc')->paginate(20); 

  $orders = Order::whereWriterId($user_id)->whereStatus(1)->orderBy('id', 'desc')->paginate(20); 
}

return view('admin.orders', compact('orders'));
}

  //in progress

public function orderInprogress(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$title = 'Orders in progress';
$user_id = $user->id;
if($user->account_status == '0'){

       //return view('admin.subscribe')->with('success', trans('Your account is currently inactive. Please select your suitable package.'));

}



if ($user->is_admin()){
 $orders = Order::orderBy('id', 'desc')->paginate(20); 
 $orders = Order::where('status', 2)->orderBy('id', 'desc')->paginate(50); 
}

if ($user->is_subadmin()){
  $orders = Order::orderBy('id', 'desc')->paginate(20); 

  $orders = Order::where('status', 2)->orderBy('id', 'desc')->paginate(20); 



}

if ($user->is_editor()){
  $orders = Order::whereEditorId($user_id)->orderBy('id', 'desc')->paginate(20); 

  $orders = Order::whereEditorId($user_id)->whereStatus(2)->orderBy('id', 'desc')->paginate(20); 

}


if ($user->is_client() or $user->is_student()){
  $orders = Order::whereUserId($user_id)->orderBy('id', 'desc')->paginate(20); 

  $orders = Order::whereUserId($user_id)->whereStatus(2)->orderBy('id', 'desc')->paginate(20); 



}
if ($user->is_writer()){
  $orders = Order::whereWriterId($user_id)->orderBy('id', 'desc')->paginate(20); 

  $orders = Order::whereWriterId($user_id)->whereStatus(2)->orderBy('id', 'desc')->paginate(20); 
}

return view('admin.orders', compact('orders', 'title'));
}

public function orderEditing(Request $request){
  $user = Auth::user();
  $title = "Orders in editing";
  $user_id = $user->id;
  if($user->account_status == '0'){

       //return view('admin.subscribe')->with('success', trans('Your account is currently inactive. Please select your suitable package.'));

  }



  if ($user->is_admin()){
   $orders = Order::orderBy('id', 'desc')->paginate(20); 
   $orders = Order::where('status', 3)->orderBy('id', 'desc')->paginate(50); 
 }

 if ($user->is_subadmin()){
  $orders = Order::orderBy('id', 'desc')->paginate(20); 

  $orders = Order::where('status', 3)->orderBy('id', 'desc')->paginate(20); 



}

if ($user->is_editor()){
  $orders = Order::whereEditorId($user_id)->orderBy('id', 'desc')->paginate(20); 

  $orders = Order::whereEditorId($user_id)->whereStatus(3)->orderBy('id', 'desc')->paginate(20); 



}


if ($user->is_client() or $user->is_student()){
  $orders = Order::whereUserId($user_id)->orderBy('id', 'desc')->paginate(20); 

  $orders = Order::whereUserId($user_id)->whereStatus(3)->orderBy('id', 'desc')->paginate(20); 



}
if ($user->is_writer()){
  $orders = Order::whereWriterId($user_id)->orderBy('id', 'desc')->paginate(20); 

  $orders = Order::whereWriterId($user_id)->whereStatus(3)->orderBy('id', 'desc')->paginate(20); 



}



return view('admin.orders', compact('orders', 'title'));







}


public function orderuEditing(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$title = "Orders in editing";
$user_id = $user->id;
if($user->account_status == '0'){

       //return view('admin.subscribe')->with('success', trans('Your account is currently inactive. Please select your suitable package.'));

}

if ($user->is_admin()){
 $orders = Order::whereEcost(0)->where('status', 3)->orderBy('id', 'desc')->paginate(50); 
}

if ($user->is_subadmin()){

  $orders = Order::whereEcost(0)->where('status', 3)->orderBy('id', 'desc')->paginate(20); 
}

if ($user->is_editor()){ 
  $orders = Order::whereEcost(0)->whereStatus(3)->orderBy('id', 'desc')->paginate(20); 
}






return view('admin.orders', compact('orders', 'title'));







}

public function orderCompleted(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$user_id = $user->id;
$title = "Orders Completed";
if($user->account_status == '0'){

       //return view('admin.subscribe')->with('success', trans('Your account is currently inactive. Please select your suitable package.'));

}



if ($user->is_admin()){
 $orders = Order::orderBy('id', 'desc')->paginate(20); 
 $orders = Order::where('status', 4)->orderBy('updated_at', 'desc')->paginate(50); 
}

if ($user->is_subadmin()){
  $orders = Order::orderBy('id', 'desc')->paginate(20); 

  $orders = Order::where('status', 4)->orderBy('updated_at', 'desc')->paginate(20); 



}

if ($user->is_editor()){
  $orders = Order::whereEditorId($user_id)->orderBy('id', 'desc')->paginate(20); 

  $orders = Order::whereEditorId($user_id)->whereStatus(4)->orderBy('id', 'desc')->paginate(20); 



}


if ($user->is_client() or $user->is_student()){
  $orders = Order::whereUserId($user_id)->orderBy('id', 'desc')->paginate(20); 

  $orders = Order::whereUserId($user_id)->whereStatus(4)->orderBy('id', 'desc')->paginate(20); 



}
if ($user->is_writer()){
  $orders = Order::whereWriterId($user_id)->orderBy('id', 'desc')->paginate(20); 

  $orders = Order::whereWriterId($user_id)->whereStatus(4)->orderBy('id', 'desc')->paginate(20); 


  if($user->account_status == '2'){

   return redirect(route('account'))->with('error', 'Your account has been suspended');

 }


}



return view('admin.orders', compact('orders', 'title'));







}

  //approved orders

public function orderApproved(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$user_id = $user->id;
$title = "Orders Approved";
if($user->account_status == '0'){

       //return view('admin.subscribe')->with('success', trans('Your account is currently inactive. Please select your suitable package.'));

}



if ($user->is_admin()){
 $orders = Order::orderBy('id', 'desc')->paginate(20); 
 $orders = Order::where('status', 5)->orderBy('updated_at', 'desc')->paginate(50); 
}

if ($user->is_subadmin()){
  $orders = Order::orderBy('updated_at', 'desc')->paginate(20); 

  $orders = Order::where('status', 5)->orderBy('updated_at', 'desc')->paginate(20); 



}

if ($user->is_editor()){
  $orders = Order::whereEditorId($user_id)->orderBy('id', 'desc')->paginate(20); 

  $orders = Order::whereEditorId($user_id)->whereStatus(5)->orderBy('id', 'desc')->paginate(20); 



}


if ($user->is_client() or $user->is_student()){
  $orders = Order::whereUserId($user_id)->orderBy('id', 'desc')->paginate(20); 

  $orders = Order::whereUserId($user_id)->whereStatus(5)->orderBy('id', 'desc')->paginate(20); 



}
if ($user->is_writer()){
  $orders = Order::whereWriterId($user_id)->orderBy('id', 'desc')->paginate(20); 

  $orders = Order::whereWriterId($user_id)->whereStatus(5)->orderBy('id', 'desc')->paginate(20); 

  if($user->account_status == '2'){

   return redirect(route('account'))->with('error', 'Your account has been suspended');

 }


}



return view('admin.orders', compact('orders', 'title'));

}


    //display finance

public function finance(Request $request){
 $user           = Auth::user();
 $user_id        = $user->id;

  //verify admin
 if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$invoices = Payment::wherePaymentSource('subscription')->orderBy('id', 'desc')->paginate(20);
$expenses = Expense::orderBy('id', 'desc')->paginate(20);
$properties = User::whereUserId($user_id)->get(); 
$total_payments_amount = Payment::whereStatus('1')->wherePaymentSource('subscription')->sum('amount');
$total_payments_amount_pending = Payment::whereStatus('1')->wherePaymentSource('subscription')->sum('amount');
$total_expense = Expense::sum('amount');

$total_order_fee             = Order::whereStatus(5)->where('subscription_fee', '>', '0')->sum('subscription_fee');
$total_admin_share           = Order::whereStatus(5)->where('order_admin_share', '>', '0')->sum('order_admin_share');
$plagiarism_report_fee       = Order::whereStatus(5)->sum('plagiarism_report_fee');
$preferred_writer_only_total = Order::whereStatus(5)->sum('preferred_writer_only_total');
$top_ten_total               = Order::whereStatus(5)->sum('top_ten_total');

$unpaid_available    = Order::whereStatus(1)->wherePayments(0)->whereWriterPaid('unpaid')->sum('wcost');
$unpaid_inprogress   = Order::whereStatus(2)->wherePayments(0)->whereWriterPaid('unpaid')->sum('wcost');
$unpaid_editing     = Order::whereStatus(3)->wherePayments(0)->whereWriterPaid('unpaid')->sum('wcost');
$unpaid_revision    = Order::whereStatus(6)->wherePayments(0)->whereWriterPaid('unpaid')->sum('wcost');
$unpaid_completed     = Order::whereStatus(4)->wherePayments(0)->whereWriterPaid('unpaid')->sum('wcost');
$unpaid_approved      = Order::whereStatus(5)->wherePayments(1)->whereWriterPaid('unpaid')->sum('wcost');



$total_unpaid = $unpaid_available + $unpaid_inprogress + $unpaid_editing + $unpaid_revision + $unpaid_completed + $unpaid_available;

$unpaid_inprogress = $unpaid_available + $unpaid_inprogress + $unpaid_editing + $unpaid_revision;

$pay_later_available  = Order::whereStatus(1)->wherePaymentWay(1)->sum('ccost');
$pay_later_inprogress = Order::whereStatus(2)->wherePaymentWay(1)->sum('ccost');
$pay_later_editing    = Order::whereStatus(3)->wherePaymentWay(1)->sum('ccost');
$pay_later_revision   = Order::whereStatus(6)->wherePaymentWay(1)->sum('ccost');

$pay_later_completed  = Order::whereStatus(4)->wherePaymentWay(1)->sum('ccost');
$pay_later_approved   = Order::whereStatus(5)->wherePaymentWay(1)->sum('ccost');

$total_pay_later = $pay_later_available + $pay_later_inprogress + $pay_later_editing +$pay_later_revision+ $pay_later_completed + $pay_later_approved;

$total_paid_writer     = Order::wherePayments(2)->sum('wcost');
$total_paid_editor     = Order::whereEpayments(2)->sum('ecost');



if ($request->invoicemonth) {

 $invoices = Payment::wherePaymentSource('subscription')->where('month', $request->invoicemonth)->orderBy('id', 'desc')->paginate(20);

 $total_payments_amount = Payment::wherePaymentSource('subscription')->whereStatus('1')->where('month', $request->invoicemonth)->sum('amount');

 $total_payments_amount_pending = Payment::wherePaymentSource('subscription')->whereStatus('0')->where('month', $request->invoicemonth)->sum('amount');

 $total_expense = Expense::where('month', $request->invoicemonth)->sum('amount');

 $expenses = Expense::where('month', $request->invoicemonth)->orderBy('id', 'desc')->paginate(20);

 $total_order_fee = Order::where('subscription_fee', '>', '0')->sum('subscription_fee');
 $total_admin_share = Order::where('order_admin_share', '>', '0')->sum('order_admin_share');

}

return view('admin.finance', compact('invoices', 'properties','total_payments_amount', 'total_payments_amount_pending', 'expenses', 'total_expense', 'total_order_fee', 'total_admin_share', 'plagiarism_report_fee', 'preferred_writer_only_total', 'top_ten_total', 'unpaid_completed', 'unpaid_approved', 'pay_later_completed', 'pay_later_approved', 'unpaid_inprogress' ,'total_unpaid', 'total_pay_later', 'total_paid_writer', 'total_paid_editor'));



}




    //display subscriptions

public function subscriptions(Request $request){
 $user           = Auth::user();
 $user_id        = $user->id;
  //verify admin
 if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$invoices = Payment::wherePaymentSource('subscription')->whereStatus(1)->orderBy('id', 'desc')->paginate(20);


return view('admin.subscriptions', compact('invoices'));



}

public function changeFeature(Request $request){
  $user_id = $request->id;
  $user = Chat::find($user_id);
  $current_feature = $user->feature;
  $user->feature = ($current_feature == 0) ? 1 : 0;
  $user->save();

  return back()->withInput()->with('success', trans('message approved'));
}


   //my writers
public function myWriters(Request $request){
 $user = Auth::user();

 $users = User::whereUserType('writer')->whereUserId($user->id)->orderBy('id', 'desc')->paginate(200); 

 return view('admin.my_writers', compact('users')); 

}

   //my writers
public function saseniWriters(Request $request){

  $user = Auth::user();
  $categories = Category::orderBy('name', 'asc')->get();

  $worders = \App\Models\Order::select('writer_id')->distinct()->whereUserId($user->id)->get(); 



  if ($request->subject) {

    $worders = \App\Models\Order::whereCategoryId($request->subject)->select('writer_id')->distinct()->get();

  }

  if ($request->orders) {

   $worders = Order::select('orders.id', 'writer_id')->leftJoin('users', 'users.id','=','orders.writer_id')->whereUserType('writer')->where('orders', '>', $request->orders)->whereAccountStatus(1)->where('nickname', '!=', '')->select('orders.writer_id')->distinct()->get();

 }

 if ($request->user) {

  $worders = Order::select('orders.id', 'writer_id')->leftJoin('users', 'users.id','=','orders.writer_id')->orderBy('orders', 'desc')->whereUserType('writer')->where('users.id', '>', $request->user)->whereAccountStatus(1)->where('nickname', '!=', '')->select('orders.writer_id')->distinct()->get();

}


return view('admin.saseni_writers', compact('worders', 'categories'));


}

  //sms
public function sms(Request $request){

 $chats = Sms::orderBy('id', 'desc')->paginate(20);


 return view('admin.sms', compact('chats'));


}

  //messges
public function messages(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


if ($user->is_admin() or $user->is_subadmin()){
  $in_count = Chat::whereMessageTo($user->id)->count();
  $out_count = Chat::whereUserId($user->id)->count();
  $chats = Chat::orderBy('id', 'desc')->paginate(20);
} 
else{

 $in_count = Chat::where('message_thread', '>' , 0)->whereMessageTo($user->id)->whereFeature('1')->count();
 $out_count = Chat::where('message_thread', '>' , 0)->whereUserId($user->id)->whereFeature('1')->count();
 $chats = Chat::whereMessageTo($user->id)->orderBy('id', 'desc')->paginate(20);

 if ($request->status == 'inbox') {
   $chats = Chat::where('message_thread', '>' , 0)->whereMessageTo($user->id)->whereFeature('1')->orderBy('id', 'desc')->paginate(20);
 }

 if ($request->status == 'sent') {
   $chats = Chat::where('message_thread', '>' , 0)->whereUserId($user->id)->whereFeature('1')->orderBy('id', 'desc')->paginate(20);
 }

}



return view('admin.messages', compact('chats', 'in_count', 'out_count'));


}

  //reply message
public function replyMessage(Request $request){
 $user_id = Auth::user()->id;
 $chat = Chat::find($request->chat_id);

 $data = [
  'message_to'    => $chat->message_from,
  'message_from'  => $user_id,
  'messages'      => $request->message,
  'user_id'       => $user_id,
  'order_id'      => $chat->order_id,
  'message_thread' => $request->chat_id,

];


$chat_created = Chat::create($data);

return back()->withInput()->with('success', trans('message sent'));
}

  //reply message
public function writeNote(Request $request){
 $user_id = Auth::user()->id;
 $order = Order::find($request->order_id);
 $data = [
  'order_id'    => $request->order_id,
  'message'      => $request->message,
  'user_id'       => $user_id,

];


$chat_created =  Comment::create($data);
if($chat_created){

 if (Auth::user()->is_writer()){

  $user = User::find($order->editor_id);

  $data=array(
    'name' =>$user->name,
    'email'=>$user->email,
    'sname'=>'Hi '.$user->name.', you have message for order #'.$request->order_id. ' Login your '.domain_name().' account for more info',
    'description'=>'Hi '.$user->name.', here is your message for order #'.$request->order_id. ' >>'.$chat_created->message,

  );
}
else{
  $user = User::find($order->writer_id); 
  $data=array(
    'name' =>$user->name,
    'email'=>$user->email,
    'sname'=>'Hi '.$user->name.', you have editor comment for order #'.$request->order_id. ' Login your '.domain_name().' account for more info',
    'description'=>'Hi '.$user->name.', here is your editor comment for order #'.$request->order_id. ' >>'.$chat_created->message,

  );     
}







      //send email to editor
Mail::send('email.index',$data, function($message) use ($data){
  $message->to($data['email']);
  $message->subject($data['sname']);

}); 
}

return back()->withInput()->with('success', trans('message sent'));
}

//send message
public function sendMessage(Request $request){

 $user = Auth::user();
 $order = Order::find($request->order_id);
 $user_id = $user->id;
 if ($request->message_to == 'support') {
  $message_to = 'support'; 
}

if ($request->message_to == 'editor') {
  $editor = User::find($order->editor_id);
  $message_to = $editor->id; 
}

if ($request->message_to == 'client') {
  $client = User::find($order->user_id);
  $message_to = $client->id; 
}

if ($request->message_to == 'writer') {
  $writer = User::find($order->writer_id);
  $message_to = $writer->id; 
}

$message = $request->message;
$message = preg_replace('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6})/', '[blocked]', $message);
$message = preg_replace('/\+?[0-9][0-9()\-\s+]{4,20}[0-9]/', '[blocked]', $message);
$data = [
  'message_to'    => $message_to,
  'message_from'  => $user_id,
  'messages'      => $message,
  'user_id'       => $user_id,
  'order_id'      => $request->order_id,

];


$chat_created = Chat::create($data);
if($chat_created){
  if ($request->message_to == 'editor') {

    $user = User::find($order->editor_id);
      //send email
    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'You have a message for order #'.$order->id,
      'description'=>'You have a message for order #'.$order->id.' login to your account and check the message',

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 


  }


  if ($request->message_to == 'client') {

    $user = User::find($order->user_id);
      //send email
    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'You have a message for order #'.$order->id,
      'description'=>'You have a message for order #'.$order->id.' login to your account and check the message',

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 


  }


  if ($request->message_to == 'writer') {
    $user = User::find($order->writer_id);
      //send email
    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'You have a message for order #'.$order->id,
      'description'=>'You have a message for order #'.$order->id.' login to your account and check the message',

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 


  }


}

//return back()->withInput()->with('success', trans('message sent'));

echo "<span style='color: green;'>message sent</span>";


}

  //read messages

public function chatRead($id){

  $chat  = Chat::find($id);
  $chats = Chat::whereOrderId($chat->order_id)->orderBy('id', 'asc')->get();
  return view('admin.chat_details', compact('chat', 'chats'));

}

  //read messages

public function viewMessages($id){

  $chat  = Chat::whereOrderId($id)->first();
  $chats = Chat::whereOrderId($id)->whereFeature('1')->orderBy('id', 'asc')->get();
  return view('admin.chat_details', compact('chat', 'chats'));

}


     //display editor invoices

public function einvoices(Request $request){
 $user = Auth::user();
 $user_id = $user->id;
 $all_invoices = 0;
 $pending_invoice = 0;
 $paid_invoice = 0;
 $cancelled_invoice = 0;

 if ($user->is_admin()){

  $pending_invoice   = Invoice::whereUserId(38)->orwhere('user_id', '8')->whereStatus(0)->where('total', '>', '0')->whereInvoiceType('system')->count();
  $paid_invoice      = Invoice::whereUserId(38)->orwhere('user_id', '8')->whereStatus(1)->where('total', '>', '0')->whereInvoiceType('system')->count();
  $cancelled_invoice = Invoice::whereUserId(38)->orwhere('user_id', '8')->whereStatus(2)->where('total', '>', '0')->whereInvoiceType('system')->count();


  $invoices        = Invoice::whereUserId(38)->orwhere('user_id', '8')->orderBy('id', 'desc')->where('total', '>', '0')->whereInvoiceType('system')->paginate(100);
  $properties = Order::all(); 

  $sum_invoices  = Invoice::whereUserId(38)->orwhere('user_id', '8')->where('total', '>', '0')->whereInvoiceType('system')->whereStatus(1)->sum('total');
  $sum_sinvoices = Order::whereEditorPaid('paid')->sum('ecost');
  $sum_pinvoices = Invoice::whereUserId(38)->orwhere('user_id', '8')->where('total', '>', '0')->whereStatus(0)->whereInvoiceType('system')->sum('total');

  if ($request->status) {

   $invoices = Invoice::whereUserId(38)->orwhere('user_id', '8')->whereStatus($request->status)->whereInvoiceType('system')->where('total', '>', '0')->orderBy('id', 'desc')->paginate(100);
   $sum_invoices  = Invoice::whereUserId(38)->orwhere('user_id', '8')->where('total', '>', '0')->whereInvoiceType('system')->whereStatus(1)->sum('total');
   $sum_sinvoices = Order::whereEditorPaid('paid')->sum('ecost');
   $sum_pinvoices = Invoice::whereUserId(38)->orwhere('user_id', '8')->where('total', '>', '0')->whereStatus(0)->whereInvoiceType('system')->sum('total');

 }


 if ($request->user_id) {
   $invoices = Invoice::whereUserId($request->user_id)->whereInvoiceType('system')->where('total', '>', '0')->orderBy('id', 'desc')->paginate(100);
   $sum_invoices = Invoice::whereUserId($request->user_id)->where('total', '>', '0')->whereStatus(1)->whereInvoiceType('system')->sum('total');
   $sum_sinvoices = Order::whereEditorPaid('paid')->whereEditorId($request->user_id)->sum('ecost');
   $sum_pinvoices = Invoice::whereUserId($request->user_id)->where('total', '>', '0')->whereStatus(0)->whereInvoiceType('system')->sum('total');
   
 }

}else{

  $invoices = Invoice::whereUserId($user_id)->whereInvoiceType('system')->orderBy('id', 'desc')->where('total', '>', '0')->paginate(20);

  $sum_invoices = Invoice::whereUserId($user_id)->where('total', '>', '0')->whereStatus(1)->whereInvoiceType('system')->sum('total');
  $sum_pinvoices = Invoice::whereUserId($user_id)->where('total', '>', '0')->whereStatus(0)->whereInvoiceType('system')->sum('total');
  $sum_sinvoices = Order::whereWriterId($user_id)->whereWriterPaid('paid')->sum('wcost');

  if ($request->status) {
   $invoices = Invoice::whereUserId($user_id)->whereInvoiceType('system')->whereStatus($request->status)->where('total', '>', '0')->orderBy('id', 'desc')->paginate(20);

 }

 if ($request->invoicemonth) {

   $invoices = Invoice::whereUserId($user_id)->where('month', $request->invoicemonth)->whereInvoiceType('system')->where('total', '>', '0')->orderBy('id', 'desc')->paginate(20);

 }

 $paid_invoice = Invoice::whereStatus(1)->where('total', '>', '0')->whereInvoiceType('system')->whereUserId($user_id)->count();
 $pending_invoice = Invoice::whereStatus(0)->where('total', '>', '0')->whereInvoiceType('system')->whereUserId($user_id)->count();
 $cancelled_invoice = Invoice::whereStatus(2)->where('total', '>', '0')->whereInvoiceType('system')->whereUserId($user_id)->count();
 

}

return view('admin.invoices', compact('paid_invoice', 'pending_invoice', 'cancelled_invoice', 'invoices', 'sum_invoices', 'sum_sinvoices', 'sum_pinvoices'));



}


     //display order payment

public function orderPayments(Request $request){

  $pay_day = $request->day.' '.$request->month.' '.$request->year;
  $orders = Order::whereWriterPaidDate($pay_day )->orderBy('id', 'desc')->get();


  return view('admin.order_payments', compact('orders'));


}



     //display invoices

public function invoices(Request $request){
 $user = Auth::user();

   //verify admin
 if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$user_id = $user->id;
$all_invoices = 0;
$pending_invoice = 0;
$paid_invoice = 0;
$cancelled_invoice = 0;

if ($user->is_admin()){

  $pending_invoice   = Invoice::whereStatus(0)->where('total', '>', '0')->whereInvoiceType('system')->count();
  $paid_invoice      = Invoice::whereStatus(1)->where('total', '>', '0')->whereInvoiceType('system')->count();
  $cancelled_invoice = Invoice::whereStatus(2)->where('total', '>', '0')->whereInvoiceType('system')->count();


  $invoices        = Invoice::orderBy('id', 'desc')->where('total', '>', '0')->whereInvoiceType('system')->paginate(100);
  $properties = Order::all(); 

  $sum_invoices  = Invoice::where('total', '>', '0')->whereInvoiceType('system')->whereStatus(1)->sum('total');
  $sum_sinvoices = Order::whereWriterPaid('paid')->sum('wcost');
  $sum_pinvoices = Invoice::where('total', '>', '0')->whereStatus(0)->whereInvoiceType('system')->sum('total');

  if ($request->status) {

   $invoices = Invoice::whereStatus($request->status)->whereInvoiceType('system')->where('total', '>', '0')->orderBy('id', 'desc')->paginate(100);

 }


 if ($request->user_id) {
   $invoices = Invoice::whereUserId($request->user_id)->whereInvoiceType('system')->where('total', '>', '0')->orderBy('id', 'desc')->paginate(100);
   $sum_invoices = Invoice::whereUserId($request->user_id)->where('total', '>', '0')->whereStatus(1)->whereInvoiceType('system')->sum('total');
   $sum_sinvoices = Order::whereWriterPaid('paid')->whereWriterId($request->user_id)->sum('wcost');
   $sum_pinvoices = Invoice::whereUserId($request->user_id)->where('total', '>', '0')->whereStatus(0)->whereInvoiceType('system')->sum('total');
   
 }


 if ($request->filter) {
   $invoices = Invoice::where('day', $request->day)->where('month', $request->month)->where('year', $request->year)->whereInvoiceType('system')->where('total', '>', '0')->orderBy('id', 'desc')->paginate(100);
   $sum_invoices = Invoice::whereUserId($request->user_id)->where('total', '>', '0')->whereStatus(1)->whereInvoiceType('system')->sum('total');
   $sum_sinvoices = Order::whereWriterPaid('paid')->whereWriterId($request->user_id)->sum('wcost');
   $sum_pinvoices = Invoice::whereUserId($request->user_id)->where('total', '>', '0')->whereStatus(0)->whereInvoiceType('system')->sum('total');


   
 }








}else{

  $invoices = Invoice::whereUserId($user_id)->whereInvoiceType('system')->orderBy('id', 'desc')->where('total', '>', '0')->paginate(20);
  $properties = Order::whereUserId($user_id)->get(); 

  $sum_invoices = Invoice::whereUserId($user_id)->where('total', '>', '0')->whereStatus(1)->whereInvoiceType('system')->sum('total');
  $sum_pinvoices = Invoice::whereUserId($user_id)->where('total', '>', '0')->whereStatus(0)->whereInvoiceType('system')->sum('total');
  $sum_sinvoices = Order::whereWriterId($user_id)->whereWriterPaid('paid')->sum('wcost');

  if ($request->status) {
   $invoices = Invoice::whereUserId($user_id)->whereInvoiceType('system')->whereStatus($request->status)->where('total', '>', '0')->orderBy('id', 'desc')->paginate(20);

 }

 if ($request->invoicemonth) {

   $invoices = Invoice::whereUserId($user_id)->where('month', $request->invoicemonth)->whereInvoiceType('system')->where('total', '>', '0')->orderBy('id', 'desc')->paginate(20);

 }

 $paid_invoice = Invoice::whereStatus(1)->where('total', '>', '0')->whereInvoiceType('system')->whereUserId($user_id)->count();
 $pending_invoice = Invoice::whereStatus(0)->where('total', '>', '0')->whereInvoiceType('system')->whereUserId($user_id)->count();
 $cancelled_invoice = Invoice::whereStatus(2)->where('total', '>', '0')->whereInvoiceType('system')->whereUserId($user_id)->count();
 

}

return view('admin.invoices', compact('paid_invoice', 'pending_invoice', 'cancelled_invoice', 'invoices', 'properties', 'sum_invoices', 'sum_sinvoices', 'sum_pinvoices'));



}

     //display invoices

public function invoicesPending(Request $request){
 $user = Auth::user();


   //verify admin
 if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$user_id = $user->id;
$all_invoices = 0;
$pending_invoice = 0;
$paid_invoice = 0;
$cancelled_invoice = 0;

if ($user->is_admin()){

  $pending_invoice   = Invoice::whereStatus(0)->whereInvoiceType('system')->where('total', '>', '0')->count();
  $paid_invoice      = Invoice::whereStatus(1)->whereInvoiceType('system')->count();
  $cancelled_invoice = Invoice::whereStatus(2)->whereInvoiceType('system')->count();
  $invoices          = Invoice::whereStatus(0)->orderBy('id', 'desc')->where('total', '>', '0')->whereInvoiceType('system')->paginate(100);
  $properties = Order::all(); 

  if ($request->status) {
   $invoices = Invoice::whereStatus($request->status)->orderBy('id', 'desc')->paginate(100);
 }

 $sum_invoices = Invoice::whereStatus(0)->where('total', '>', '0')->whereInvoiceType('system')->sum('total');
 $sum_sinvoices = Order::whereWriterPaid('paid')->sum('wcost');
 $sum_pinvoices = Invoice::where('total', '>', '0')->whereStatus(0)->whereInvoiceType('system')->sum('total');

}else{

  $invoices = Invoice::whereStatus(0)->whereUserId($user_id)->orderBy('id', 'desc')->paginate(20);
  $properties = Order::whereUserId($user_id)->get(); 

  if ($request->status) {
   $invoices = Invoice::whereUserId($user_id)->whereStatus($request->status)->orderBy('id', 'desc')->paginate(20);
 }

 if ($request->invoicemonth) {

   $invoices = Invoice::whereUserId($user_id)->where('month', $request->invoicemonth)->orderBy('id', 'desc')->paginate(20);

 }

 $sum_invoices = Invoice::whereStatus(0)->whereUserId($user_id)->where('total', '>', '0')->whereInvoiceType('system')->sum('total');

 $sum_sinvoices = Order::whereWriterId($user_id)->whereWriterPaid('paid')->sum('wcost');


 $paid_invoice = Invoice::whereStatus(1)->whereUserId($user_id)->count();
 $pending_invoice = Invoice::whereStatus(0)->whereUserId($user_id)->count();
 $cancelled_invoice = Invoice::whereStatus(2)->whereUserId($user_id)->count();
 

}

return view('admin.invoices', compact('paid_invoice', 'pending_invoice', 'cancelled_invoice', 'invoices', 'properties', 'sum_invoices', 'sum_sinvoices', 'sum_pinvoices'));



}


    //display invoices paid

public function invoicesPaid(Request $request){
 $user = Auth::user();

   //verify admin
 if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$user_id = $user->id;
$all_invoices = 0;
$pending_invoice = 0;
$paid_invoice = 0;
$cancelled_invoice = 0;

if ($user->is_admin()){

  $pending_invoice   = Invoice::whereStatus(0)->whereInvoiceType('system')->where('total', '>', '0')->count();
  $paid_invoice      = Invoice::whereStatus(1)->whereInvoiceType('system')->where('total', '>', '0')->count();
  $cancelled_invoice = Invoice::whereStatus(2)->whereInvoiceType('system')->where('total', '>', '0')->count();
  $invoices          = Invoice::whereStatus(1)->orderBy('id', 'desc')->whereInvoiceType('system')->where('total', '>', '0')->paginate(100);

  $properties = Order::all(); 
  if ($request->status) {
   $invoices = Invoice::whereStatus($request->status)->whereInvoiceType('system')->orderBy('id', 'desc')->where('total', '>', '0')->paginate(100);
 }

 $sum_invoices = Invoice::whereStatus(1)->where('total', '>', '0')->whereInvoiceType('system')->sum('total');
 $sum_sinvoices = Order::whereWriterPaid('paid')->sum('wcost');
 $sum_pinvoices = Invoice::where('total', '>', '0')->whereStatus(1)->whereInvoiceType('system')->sum('total');

}else{

  $invoices = Invoice::whereStatus(1)->whereUserId($user_id)->orderBy('id', 'desc')->where('total', '>', '0')->paginate(20);
  $properties = Order::whereUserId($user_id)->get(); 

  if ($request->status) {
   $invoices = Invoice::whereUserId($user_id)->whereStatus($request->status)->orderBy('id', 'desc')->where('total', '>', '0')->paginate(20);
 }

 if ($request->invoicemonth) {

   $invoices = Invoice::whereUserId($user_id)->where('month', $request->invoicemonth)->orderBy('id', 'desc')->whereInvoiceType('system')->where('total', '>', '0')->paginate(20);

 }

 $paid_invoice = Invoice::whereStatus(1)->whereUserId($user_id)->whereInvoiceType('system')->where('total', '>', '0')->count();
 $pending_invoice = Invoice::whereStatus(0)->whereUserId($user_id)->whereInvoiceType('system')->where('total', '>', '0')->count();
 $cancelled_invoice = Invoice::whereStatus(2)->whereUserId($user_id)->whereInvoiceType('system')->where('total', '>', '0')->count();
 $sum_invoices = Invoice::whereStatus(1)->whereUserId($user_id)->where('total', '>', '0')->whereInvoiceType('system')->sum('total');

}

return view('admin.invoices', compact('paid_invoice', 'pending_invoice', 'cancelled_invoice', 'invoices', 'properties', 'sum_invoices', 'sum_sinvoices', 'sum_pinvoices'));



}






public function account(){

  $user_id = Auth::user()->id;
  $user = User::find($user_id);
  $categories = Category::all();
  $user_subjects = User_subject::whereUserId($user_id)->get();

  if($user->applicant == 1){ 

    return redirect(route('application'))->with('error', trans('Your application is still pending'));

  }

  else{
    return view('admin.account', compact('user', 'categories', 'user_subjects'));
  }

}

public function websiteInfo($id){
  $user = Website::find($id);


  return view('admin.website_info', compact('user'));

}



public function asaveService(Request $request){

  $user_id = $request->user_id;
  $amenities = serialize($request->amenities);
  $amenities = unserialize($amenities); 
  $indore_ammenties = Category::all();
  foreach($indore_ammenties as $in_ammenty){
    if(array_key_exists($in_ammenty->id, $amenities)){

      $duplicate = User_subject::whereSubjectId($in_ammenty->id)->whereUserId($request->user_id)->count();
      if ($duplicate > 0){

      }
      else{

        $data = [
          'subject_id'   => $in_ammenty->id,
          'user_id'      => $user_id,
          'subject_name' => $in_ammenty->name,

        ];

        User_subject::create($data);

      }




    }
  }



  

  return back()->withInput()->with('success', trans('updated successfully'));

}



public function saveService(Request $request){

  $user_id = Auth::user()->id;
  $amenities = serialize($request->amenities);
  $amenities = unserialize($amenities); 
  $indore_ammenties = Category::all();
  foreach($indore_ammenties as $in_ammenty){
    if(array_key_exists($in_ammenty->id, $amenities)){

      $duplicate = User_subject::whereSubjectId($in_ammenty->id)->count();
      if ($duplicate > 0){

      }
      else{

        $data = [
          'subject_id'   => $in_ammenty->id,
          'user_id'      => $user_id,
          'subject_name' => $in_ammenty->name,

        ];

        User_subject::create($data);

      }




    }
  }



  

  return back()->withInput()->with('success', trans('updated successfully'));

}

public function aeditProfile(Request $request){
  $user = User::find($request->user_id);
  $user->about    = $request->about;
  $user->account_status    = $request->account_status;
  $user->nickname = $request->nickname;
  $user->phone = $request->phone;
  $user->save();


  if ($request->hasFile('photo')){
    $rules = ['photo'=>'mimes:jpeg,jpg,png'];
    $this->validate($request, $rules);

    $image = $request->file('photo');
    $file_base_name = str_replace('.'.$image->getClientOriginalExtension(), '', $image->getClientOriginalName());
    $resized_thumb = Image::make($image)->resize(300, 300)->stream();

    $image_name = strtolower(time().Str::random(5).'-'.Str::slug($file_base_name)).'.' . $image->getClientOriginalExtension();

    $imageFileName = 'uploads/avatar/'.$image_name;

            //Upload original image
    $is_uploaded = current_disk()->put($imageFileName, $resized_thumb->__toString(), 'public');


    if ($is_uploaded){
      $previous_photo= $user->photo;
      $previous_photo_storage= $user->photo_storage;

      $user->photo = $image_name;
      $user->photo_storage = 'public';
      $user->save();

      if ($previous_photo){
        $previous_photo_path = 'uploads/avatar/'.$previous_photo;
        $storage = Storage::disk($previous_photo_storage);
        if ($storage->has($previous_photo_path)){
          $storage->delete($previous_photo_path);
        }
      }
    }
  }

  return back()->withInput()->with('success', 'profile update success');
}

public function editProfile(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$user->about    = $request->about;
$user->nickname = $request->nickname;
$user->phone = $request->phone;
$user->equity_bank = $request->equity_bank;
$user->save();


if ($request->hasFile('photo')){
  $rules = ['photo'=>'mimes:jpeg,jpg,png'];
  $this->validate($request, $rules);

  $image = $request->file('photo');
  $file_base_name = str_replace('.'.$image->getClientOriginalExtension(), '', $image->getClientOriginalName());
  $resized_thumb = Image::make($image)->resize(300, 300)->stream();

  $image_name = strtolower(time().Str::random(5).'-'.Str::slug($file_base_name)).'.' . $image->getClientOriginalExtension();

  $imageFileName = 'uploads/avatar/'.$image_name;

            //Upload original image
  $is_uploaded = current_disk()->put($imageFileName, $resized_thumb->__toString(), 'public');


  if ($is_uploaded){
    $previous_photo= $user->photo;
    $previous_photo_storage= $user->photo_storage;

    $user->photo = $image_name;
    $user->photo_storage = 'public';
    $user->save();

    if ($previous_photo){
      $previous_photo_path = 'uploads/avatar/'.$previous_photo;
      $storage = Storage::disk($previous_photo_storage);
      if ($storage->has($previous_photo_path)){
        $storage->delete($previous_photo_path);
      }
    }
  }
}

return back()->withInput()->with('success', 'profile update success');
}


public function editWebsite(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

if(Auth::user()->is_admin()){

  $user = Website::find($request->website_id);
  $user->email    = $request->email;
  $user->phone = $request->phone;
  $user->domain_name = $request->domain_name;

  $user->mail_host = $request->mail_host;
  $user->mail_username = $request->mail_username;
  $user->mail_password = $request->mail_password;
  $user->mail_port = $request->mail_port;
  $user->reply_to = $request->reply_to;
  $user->save();


  if($request->hasFile('photo')){
    
    $file = $request->file('photo');

    $fileName = $user->id.'_'.$file->getClientOriginalName();
    $filePath = 'uploads/logo/'.$fileName;
    $is_uploaded = current_disk()->put($filePath, file_get_contents($file));
    if($is_uploaded){



      if(get_option(site_id().'_default_storage') == 'public') {
        $user->logo_url = get_option(site_id().'_main_site_url').'/storage/' . $filePath;
      } else{
       $is_uploaded = Storage::disk('public')->put($filePath, file_get_contents($file));
       $user->logo_url = 'https://awasam.s3.amazonaws.com/'.$filePath;
     }

     $user->save();
   }

 }


 if($request->hasFile('favicon')){
  $file = $request->file('favicon');

  $fileName = $user->id.'_'.$file->getClientOriginalName();
  $filePath = 'uploads/logo/'.$fileName;
  $is_uploaded = current_disk()->put($filePath, file_get_contents($file));
  if($is_uploaded){



    if(get_option(site_id().'_default_storage') == 'public') {
      $user->favicon_url = get_option(site_id().'_main_site_url').'/storage/' . $filePath;
    } else{
     $is_uploaded = Storage::disk('public')->put($filePath, file_get_contents($file));
     $user->favicon_url = 'https://awasam.s3.amazonaws.com/'.$filePath;
   }

   $user->save();
 }

}

\LogActivity::addToLog('Theme option update');

return back()->withInput()->with('success', 'profile update success');

}
else{
  return back()->withInput()->with('error', 'Access restricted');
}
}

public function changePasswordPost(Request $request)
{
  $rules = [
    'old_password'  => 'required',
    'new_password'  => 'required|confirmed',
    'new_password_confirmation'  => 'required',
  ];
  $this->validate($request, $rules);

  $old_password = $request->old_password;
  $new_password = $request->new_password;
        //$new_password_confirmation = $request->new_password_confirmation;

  if(Auth::check())
  {
    $logged_user = Auth::user();

    if(Hash::check($old_password, $logged_user->password))
    {
      
      $logged_user->password = Hash::make($new_password);
      $logged_user->save();

      return back()->withInput()->with('success', 'password has been changed');
    }
    return back()->withInput()->with('error', 'wrong old password');
  }

}

public function userInfo($id){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


if(Auth::user()->is_admin()){
  $user = User::find($id);
  if ($user->user_type == 'writer') {
    $orders = Order::whereWriterId($id)->orderBy('id', 'desc')->paginate(20);
  }
  else{
    $orders = Order::whereUserId($id)->orderBy('id', 'desc')->paginate(20);
  }

  $categories = Category::all();


  return view('admin.user_info', compact('user', 'orders', 'categories'));
} else{
  return back()->withInput()->with('error', 'Access restricted');
}



}

//suspend writer
public function suspendUser(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$suspend_end = date("Y-m-d H:i:s", strtotime('+'.$request->suspension_days.' days'));

$user_id    = $request->user_id;
$now = Carbon::now();

$data = [
  'message'        => $request->message,
  'suspend_start'  => $now,
  'suspend_end'    => $suspend_end,
  'user_id'    => $user_id,

];


$warning_created = Warning::create($data);

if($warning_created){
  $user = User::find($user_id);
  if ($request->suspension_days!='0') {
    $user->account_status = 2;
    $user->subscribe_start = $now;
    $user->subscribe_end = $suspend_end;
    $user->save();
  }



  //get writer



//send sms
  $data=array(
    'name'          =>$user->name,
    'email'         =>$user->email,
    'sname'         =>'Hi '.$user->name.', you got a warning from '.domain_name().'',
    'description'    =>$request->message,

  );
  
  
      //send email to writer
  Mail::send('email.index',$data, function($message) use ($data){
    $message->to($data['email']);
    $message->subject($data['sname']);

  }); 
  
  
}

return back()->withInput()->with('success', trans('warning submitted'));

}



//solve dispute
public function solveDispute(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$order = Order::find($request->order_id);
$order->dispute_option  = $request->dispute_option;
$order->dispute_comment = $request->dispute_comment;
$order->save();

return back()->withInput()->with('success', trans('Dispute has been solved'));

}


//send revision
public function sendDispute(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$order = Order::find($request->order_id);
$activity = "Order ".$order->id." has been disputed by ".Auth::user()->id;
\LogActivity::addToLog($activity);

//  $user       = Auth::user();
//  $user_id    = $user->id;

//  $data = [
//   'issues'  => $request->instructions,
//   'order_id'  => $request->order_id,

// ];


//$revision_created = Dispute::create($data);

// if($revision_created){



//   $order->status             = 9;
//   $order->save();






//   //get writer

//   $user = User::find($order->writer_id);

// //send sms
//   $data=array(
//     'name' =>$user->name,
//     'email'=>$user->email,
//     'sname'=>'Hi '.$user->name.', order #'.$request->order_id. ' has a dispute',
//     'description'=>'Hi '.$user->name.', order #'.$request->order_id. ' has a dispute',

//   );


//       //send email to writer
//   Mail::send('email.index',$data, function($message) use ($data){
//     $message->to($data['email']);
//     $message->subject($data['sname']);

//   }); 


//   //send sms
//   // $recipients = $user->phone;
//   // $message    = 'Hi '.$user->name.', order #'.$request->order_id. ' has been returned for revision';
//   // sendsms($recipients,$message);



// }

return back()->withInput()->with('success', trans('Dispute has been raised'));

}

public function smsWriter(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$user = User::find($request->writer_id);
  //send sms
$recipients = $user->phone;
$message    = $request->message;


$return = sendsms($recipients,$message);

return back()->withInput()->with('success', $return);

}


//send revision
public function sendRevision(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$order_due = date("Y-m-d H:i:s", strtotime('+'.$request->due_in.' hours'));
$user       = Auth::user();
$user_id    = $user->id;

$data = [
  'instructions'  => $request->instructions,
  'order_id'  => $request->order_id,
  'due_at'  => $order_due,

];


$revision_created = Revision::create($data);

if($revision_created){
  $order = Order::find($request->order_id);
  $order->status             = 6;
  $order->save();


  $activity = "Order ".$order->id." has been returned for revision by ".Auth::user()->id;
  \LogActivity::addToLog($activity);

//get editor
  if ($order->editor_id) {
  # code...

    $user = User::find($order->editor_id);

//send sms
    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Hi '.$user->name.', order #'.$request->order_id. ' has been returned for revision',
      'description'=>'Hi '.$user->name.', order #'.$request->order_id. ' has been returned for revision',

    );


      //send email to editor
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 


  //send sms
    $recipients = $user->phone;
    $message    = 'Hi '.$user->name.', order #'.$request->order_id. ' has been returned for revision';
    sendsms($recipients,$message);
  }

  //get writer

  $user = User::find($order->writer_id);

//send sms
  $data=array(
    'name' =>$user->name,
    'email'=>$user->email,
    'sname'=>'Hi '.$user->name.', order #'.$request->order_id. ' has been returned for revision',
    'description'=>'Hi '.$user->name.', order #'.$request->order_id. ' has been returned for revision',

  );
  
  
      //send email to writer
  Mail::send('email.index',$data, function($message) use ($data){
    $message->to($data['email']);
    $message->subject($data['sname']);

  }); 
  
  
  //send sms
  $recipients = $user->phone;
  $message    = 'Hi '.$user->name.', order #'.$request->order_id. ' has been returned for revision';
  sendsms($recipients,$message);



}

return back()->withInput()->with('success', trans('order revision instructions submitted'));

}

//subscription
public function subscribe(){
  return view('admin.subscribe');
}



//switcher
public function switcher(){
  return view('admin.switcher');
}

//customer Rules
public function customerRules(){
  return view('admin.customer_rules');
}




public function subscribeData(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$package = Package::find($request->package);
session()->put('package', $request->package);

$user       = Auth::user();
$user_id    = $user->id;

$now = Carbon::now();
$year  =  $now->year;
$month  =  $now->month;

$data = [
  'callback_url'         => url('/'),
  'order_id'             => $package->id,
  'amount'               => $package->amount,
  'user_id'              => $user_id,
  'payment_source'       => 'subscription',
  'pay_reason'           => 'checkout',
  'currency'             => '2',
  'year'                 => $year,
  'month'                => $month,

];


$pay_created = Payment::create($data);

if($pay_created){

  return redirect(url('cpay/'.$pay_created->id))->with('success', 'created successfully');

}
else{

  return back()->withInput()->with('error', trans('something went wrong'));

}




}


public function reviewstore(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$review = new Review_rating();
$rating = $request->grating + $request->frating+$request->krating;
$rating = $rating/15;
$rating = $rating;
$review->order_id = $request->order_id;
$review->comments= $request->comment;
$review->star_rating = $rating;
$review->gstar_rating = $request->grating;
$review->fstar_rating = $request->frating;
$review->kstar_rating = $request->krating;
$review->user_id = Auth::user()->id;
$review->writer_id = $request->writer_id;
$review->save();

$order = Order::find($request->order_id);
$order->crating = 1;
$order->save();
return redirect()->back()->with('success','Your review has been submitted Successfully,');
}


//create invoice
public function sendInvoice(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$user = Auth::user();
if ($user->is_writer()){
  $total = writer_balance(Auth::user()->id);
}

if ($user->is_editor()){
  $total = editor_balance(Auth::user()->id);
}

$user_id = Auth::user()->id;
$now = Carbon::now();
$day  =  $now->day;
$year  =  $now->year;
$month  =  $now->month;
$slug = 'in-'.time().Str::random(6);

if ($day > 15 and $day < 20 ) {
 $day  =  20;
 $month  =  $now->month;

 $data = [

  'slug'     => $slug,
  'status'   => '0',
  'user_id'  => $user_id,
  'day'      => $day,
  'year'     => $year,
  'month'    => $month,
  'total'    => $total,
];


$pay_created = Invoice::Create($data);
}

if ($day > 0 and $day < 5 ) {
 $day  =  5;
 $month  =  $now->month;

 $data = [

  'slug'     => $slug,
  'status'   => '0',
  'user_id'  => $user_id,
  'day'      => $day,
  'year'     => $year,
  'month'    => $month,
  'total'    => $total,
];


$pay_created = Invoice::Create($data);
}

if ($user->is_writer()){
  $orders = Order::whereWriterId($user_id)->wherePayments('1')->get();
  foreach ($orders  as $key => $value) {
    $order  = Order::find($value->id);
    $order->invoice_id = $pay_created->id;
    $order->payments = 2;
    $order->save();

  }
}

if ($user->is_editor()){
  $orders = Order::whereEditorId($user_id)->wherePayments('1')->get();
  foreach ($orders  as $key => $value) {
    $order  = Order::find($value->id);
    $order->einvoice_id = $pay_created->id;
    $order->epayments = 2;
    $order->save();

  }
}



return back()->withInput()->with('success', trans('Invoice sent successfully'));


}

//create invoice
public function adminSendInvoice(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$now = Carbon::now();
$day     =  $now->day;
$year    =  $now->year;
$month   =  $now->month;
$users = User::whereUserType($request->user_type)->get();

foreach ($users as $key => $user) {
 $user_id = $user->id;
 $slug = 'in-'.time().Str::random(6);

 $data = [
  'slug'     => $slug,
  'status'   => '0',
  'user_id'  => $user_id,
  'day'      => $day,
  'year'     => $year,
  'month'    => $month,
  'total'    => 0,
];

$pay_created = Invoice::Create($data);

//update orders
$total = 0;
if ($user->is_writer()){

  $orders = Order::whereWriterId($user_id)->whereStatus(5)->whereWriterPaid('unpaid')->get();
  foreach ($orders  as $key => $value) {
    $order  = Order::find($value->id);
    $order->invoice_id = $pay_created->id;
    $order->payments   = 2;
    $order->writer_paid_date   = $pay_created->day.' '.$pay_created->month.' '.$pay_created->year;
    $order->save();

    $total              = $total + $order->wcost;
    $pay_created->total = $total;
    $pay_created->save();

  }
}

if ($user->is_editor()){
  $orders = Order::whereEditorId($user_id)->whereEditorPaid('unpaid')->whereStatus(5)->get();
  foreach ($orders  as $key => $value) {
    $order  = Order::find($value->id);
    $order->einvoice_id = $pay_created->id;
    $order->epayments = 2;
    $order->editor_paid_date   = $pay_created->day.' '.$pay_created->month.' '.$pay_created->year;
    $order->save();

    $total              = $total + $order->ecost;
    $pay_created->total = $total;
    $pay_created->save();

  }
}


}

return back()->withInput()->with('success', trans('Invoice generated successfully'));


}

//user settings
public function settings(){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$user =  $user_id = Auth::user();
return view('admin.settings', compact('user'));
}

//user settings
public function homepage(){
  $user =  $user_id = Auth::user();
  return view('admin.homepage', compact('user'));
}

//create new pricing
public function newPricing(Request $request)
{


  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$data = [
  'pricing_value'          => $request->pricing_value,
  'site_type'              => $request->site_type,
  'pricing_duration'          => $request->pricing_duration,
  'pricing_urgency'          => $request->pricing_urgency,

];

Pricing::create($data);
return back()->withInput()->with('success', trans('pricing added'));
}

public function newCategory(Request $request)
{

  $user = Auth::user();

$slug = unique_slugu($request->name);

$data = [
  'name'          => $request->name,
  'cat_type'          => $request->cat_type,
   'slug'          => $slug,
   'category_slug'          => $slug,

];

Category::create($data);


return back()->withInput()->with('success', trans('category added'));
}


public function newSubCategory(Request $request)
{

  $user = Auth::user();

$slug = unique_slugu($request->name);

$data = [
  'name'          => $request->name,
  'cat_id'          => $request->cat_type,
   'slug'          => $slug,

];

Sub_category::create($data);


return back()->withInput()->with('success', trans('category added'));
}

//new charges

public function newCharges(Request $request)
{

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$data = [
  'amount_from'      => $request->amount_from,
  'charges'        => $request->charges,
  'max'        => $request->max,
  'amount_to'      => $request->amount_to,

];

Charge::create($data);
return back()->withInput()->with('success', trans('Charges added'));

}


//new paper type

public function newPaperType(Request $request)
{

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$data = [
  'pptype_name'          => $request->name,
  'cat_type'      => $request->cat_type,
  'pptype_pvalue'      => $request->pptype_pvalue,

];

Paper::create($data);


return back()->withInput()->with('success', trans('paper type added added'));
}


public function editCategory($id){
  
  $user_id  = Auth::user()->id;
  $tasks    = Service::orderBy('id', 'desc')->paginate(200);
  $categories = Category::where('cat_type',4)->orderBy('id', 'desc')->paginate(200);
  

  $sub_categories = Sub_category::orderBy('id', 'desc')->paginate(200);
  $category = Category::findOrFail($id);
  // dd($category->description);
  return view('admin.edit_category', compact('category','tasks','sub_categories'));
}



//update category

public function updateCategory(Request $request)
{
  
$slug = unique_slugu($request->input('name'));

$user = Auth::user();

$cat = Category::find($request->cat_id);

$cat->name = $request->input('name');
$cat->display_name = $request->display_name;
$cat->description  = $request->description;
$cat->meta_description  = $request->meta_description;
$cat->category_slug  = $slug;
$cat->pvalue = $request->pvalue;
$cat->cat_type =$request->input('cat_type');

// dd($cat);
$cat->save();


  if($request->hasFile('photo')){
    
    $file = $request->file('photo');

    $fileName = $cat->id.'_'.$file->getClientOriginalName();
    $filePath = 'uploads/logo/'.$fileName;
    $is_uploaded = current_disk()->put($filePath, file_get_contents($file));
    if($is_uploaded){



      if(get_option(site_id().'_default_storage') == 'public') {
        $cat->photo_url = get_option(site_id().'_main_site_url').'/storage/' . $filePath;
      } else{
       $is_uploaded = Storage::disk('public')->put($filePath, file_get_contents($file));
       $cat->photo_url = 'https://awasam.s3.amazonaws.com/'.$filePath;
     }

     $cat->save();
   }

 }


return redirect()->route("categories")->withInput()->with('success', trans('Catgory updated'));
}




public function updateContent(Request $request)
{
  

$template = Template::find($request->id);
$template->description = $request->description; 


$template->save();




return back()->withInput()->with('success', trans('Content updated'));
}





//update category

public function updateCat(Request $request)
{
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$cat = Category::find($request->cat_id);
$cat->name = $request->name;
$cat->pvalue = $request->pvalue;
$cat->cat_type = $request->cat_type; 
$cat->save();


return back()->withInput()->with('success', trans('Catgory updated'));
}

//update paper type

public function updatePaper(Request $request)
{
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$cat = Paper::find($request->cat_id);
$cat->pptype_name = $request->name;
$cat->pptype_pvalue = $request->pvalue;
$cat->cat_type = $request->cat_type; 
$cat->save();


return back()->withInput()->with('success', trans('paper type updated'));
}


//update paper type

public function updateCharges(Request $request)
{
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$cat = Charge::find($request->cat_id);
$cat->amount_from = $request->amount_from;
$cat->charges = $request->charges;
$cat->max = $request->max;
$cat->amount_to = $request->amount_to; 
$cat->save();


return back()->withInput()->with('success', trans('update charges'));
}


//delete paper type

public function deletePaper(Request $request)
{
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$cat = Paper::find($request->cat_id); 
$cat->delete();


return back()->withInput()->with('success', trans('paper type deleted'));
}

//delete cat

public function deleteCat(Request $request)
{
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$cat = Category::find($request->cat_id); 
$cat->delete();


return back()->withInput()->with('success', trans('subject deleted'));
}
public function deleteProduct(Request $request)
{
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$cat = Post::find($request->cat_id); 
$cat->delete();


return back()->withInput()->with('success', trans('subject deleted'));
}

//upadet prices

public function updatePricing(Request $request)
{
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$price = Pricing::find($request->pricing_id);
$price->pricing_value = $request->pricing_value;
$price->max_page = $request->max_page;
$price->pricing_urgency = $request->pricing_urgency;
$price->pricing_duration = $request->pricing_duration;
$price->site_type = $request->site_type; 
$price->status = $request->status; 
$price->save();


return back()->withInput()->with('success', trans('price updated'));
}


//user settings
public function orderSettings(){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$user =  $user_id = Auth::user();
$categories = Category::orderBy('name', 'asc')->get();
$pricing   = Pricing::all();
$papers   = Paper::orderBy('pptype_name', 'asc')->get();
$charges   = Charge::orderBy('id', 'asc')->get();
return view('admin.order_settings', compact('user', 'categories', 'pricing', 'papers', 'charges'));
}


public function logActivity()

{


  $user = Auth::user();



  $logs = \LogActivity::logActivityLists();

  return view('admin.logActivity',compact('logs'));

}

//update options
public function updateOptions(Request $request) {

$user = Auth::user();
$inputs = Arr::except($request->input(), ['_token']);
foreach($inputs as $key => $value) {
      $option = Option::firstOrCreate(['option_key' => $key]);
      $option ->option_value = $value;
      $option->save();
    }

    \LogActivity::addToLog('Save setting');
        //check is request comes via ajax?
    if ($request->ajax()){
      return ['success'=>1, 'msg'=>'update made successfully'];
    } 


}





 //update settings

public function updateUser(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$user = Auth::user();
$user->currency_sign         = $request->currency_sign;
$user->paypal_client_id      = $request->paypal_client_id;
$user->BusinessShortCode     = $request->BusinessShortCode;
$user->LipaNaMpesaPasskey    = $request->LipaNaMpesaPasskey;
$user->MPESA_CONSUMER_KEY    = $request->MPESA_CONSUMER_KEY;
$user->MPESA_CONSUMER_SECRET = $request->MPESA_CONSUMER_SECRET;
$user->save();
return back()->withInput()->with('success', trans('Update success'));
}


 //update user info

public function updateUserInfo(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$user = User::find($request->id);
$user->account_status         = $request->account_status;
$user->package                = $request->package;
$user->subscribe_start         = $request->subscribe_start;
$user->subscribe_end           = $request->subscribe_end;
$user->save();

if($request->package_payment == 'YES'){


 $now = Carbon::now();
 $year  =  $now->year;
 $month  =  $now->month;

 $package = Package::find($request->package);

 $data = [
  'callback_url'         => url('/'),
  'order_id'             => $package->id,
  'amount'               => $package->amount,
  'user_id'              => $user->id,
  'payment_source'       => 'subscription',
  'pay_reason'           => 'checkout',
  'currency'             => '2',
  'year'                 => $year,
  'month'                => $month,
  'status'               => '1',

];


$pay_created = Payment::create($data);

}

return back()->withInput()->with('success', trans('Update success'));



}



 //update settings

public function updateSite(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$site = Site::find($request->id);
$site->domain_name         = $request->domain_name;
$site->status         = $request->status;
$site->save();


if($request->hasFile('file')){
  $file = $request->file('file');

  $fileName = $site->id.'_'.$file->getClientOriginalName();
  $filePath = 'uploads/sites/'.$fileName;
  $is_uploaded = current_disk()->put($filePath, file_get_contents($file));
  if($is_uploaded){
    if(get_option(site_id().'_default_storage') == 'public') {
      $site->image_url = get_option(site_id().'_main_site_url').'/storage/' . $filePath;
    } else{
     $is_uploaded = Storage::disk('public')->put($filePath, file_get_contents($file));
     $site->image_url = 'https://awasam.s3.amazonaws.com/'.$filePath;
   }

   $site->save();
 }

}

//add logo

if($request->hasFile('logo')){
  $file = $request->file('logo');

  $fileName = $site->id.'_'.$file->getClientOriginalName();
  $filePath = 'uploads/sites/'.$fileName;
  $is_uploaded = current_disk()->put($filePath, file_get_contents($file));
  if($is_uploaded){
    if(get_option(site_id().'_default_storage') == 'public') {
      $site->logo_url = get_option(site_id().'_main_site_url').'/storage/' . $filePath;
    } else{
     $is_uploaded = Storage::disk('public')->put($filePath, file_get_contents($file));
     $site->logo_url = 'https://awasam.s3.amazonaws.com/'.$filePath;
   }

   $site->save();
 }

}

return back()->withInput()->with('success', trans('Update success'));
}



 //update settings

public function updateInvoice(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$invoice = Invoice::find($request->invoice_id);
$invoice->total         = $request->amount;
$invoice->status        = $request->status;
$invoice->total_paid    = $request->total_paid;
$invoice->comment       = $request->comment;
$invoice->confirmed     = 'checked';
$invoice->save();

$user = User::find($invoice->user_id);

if($user->is_editor()){
  $orders = Order::whereEinvoiceId($invoice->id)->get();
}

if($user->is_writer()){

  $orders = Order::whereInvoiceId($invoice->id)->get();

}


  //get status if is paid
if ($request->status == '1') {

  foreach ($orders as $key => $order) {
    // update writer payment status


    if($user->is_editor()){
      $order->editor_paid = 'paid';
      $order->editor_paid_date = $invoice->day.' '.$invoice->month.' '.$invoice->year;
    }

    if($user->is_writer()){
      $order->writer_paid = 'paid';
      $order->writer_paid_date = $invoice->day.' '.$invoice->month.' '.$invoice->year;

    }

    $order->save();

  }
}
return back()->withInput()->with('success', trans('Update success'));
}


//get all users

public function websites(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$websites = Website::orderBy('id', 'desc')->paginate(100); 

return view('admin.websites', compact('websites'));   
}


//get all users

public function sites(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$websites = Site::orderBy('id', 'desc')->paginate(100); 

return view('admin.sites', compact('websites'));   
}

//get all users

public function sales(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$sales = Sale::orderBy('id', 'desc')->paginate(100); 

return view('admin.sales', compact('sales'));   
}



//get all users

public function users(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$users = User::whereUserType($request->users)->orderBy('id', 'desc')->paginate(150, ['*'], $request->users); 
$pending_count = User::whereAccountStatus(0)->whereUserType('client')->count();
$active_count = User::whereAccountStatus(1)->whereUserType('client')->count();
$blocked_count = User::whereAccountStatus(2)->count();

if($request->status){

  $users = User::whereAccountStatus($request->status)->orderBy('id', 'desc')->paginate(50, ['*'], $request->status);
}

if($request->applicant){

  $users = User::whereApplicant($request->applicant)->orderBy('id', 'desc')->paginate(50, ['*'], $request->status);
}


if ($request->search) {
  $users  = User::where('id','like', "%{$request->search}%")->orWhere('name','like', "%{$request->search}%")->orWhere('email','like', "%{$request->search}%")->orWhere('nickname','like', "%{$request->search}%")->orderBy('id', 'desc')->paginate(200);

}
return view('admin.users', compact('users', 'pending_count', 'blocked_count', 'active_count'));   
}

public function addUsers(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
return view('admin.add_user');   
}


//get all writers

public function writers(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$users = User::whereUserType('writer')->orderBy('id', 'desc')->paginate(200); 
$pending_count = User::whereAccountStatus(0)->whereUserType('writer')->count();
$active_count = User::whereAccountStatus(1)->whereUserType('writer')->count();
$blocked_count = User::whereAccountStatus(2)->whereUserType('writer')->count();

if($request->status){

 $users = User::whereUserType('writer')->whereAccountStatus($request->status)->orderBy('id', 'desc')->paginate(20); 
 $pending_count = User::whereAccountStatus(0)->whereUserType('writer')->count();
 $active_count = User::whereAccountStatus(1)->whereUserType('writer')->count();
 $blocked_count = User::whereAccountStatus(2)->whereUserType('writer')->count();
}

$editor = Auth::user()->id;
if (Auth::user()->is_editor()) {
  $users = User::whereUserType('writer')->orderBy('id', 'desc')->paginate(20); 
}


return view('admin.users', compact('users', 'pending_count', 'blocked_count', 'active_count'));   

}


public function clients(Request $request) {


  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$users = User::whereUserType('client')->orderBy('wallet', 'desc')->paginate(200); 
$pending_count = User::whereAccountStatus(0)->whereUserType('client')->count();
$active_count = User::whereAccountStatus(1)->whereUserType('client')->count();
$blocked_count = User::whereAccountStatus(2)->whereUserType('client')->count();

if($request->status){

 $users = User::whereUserType('client')->whereAccountStatus($request->status)->orderBy('id', 'desc')->paginate(20); 
 $pending_count = User::whereAccountStatus(0)->whereUserType('client')->count();
 $active_count = User::whereAccountStatus(1)->whereUserType('client')->count();
 $blocked_count = User::whereAccountStatus(2)->whereUserType('client')->count();
}




return view('admin.users', compact('users', 'pending_count', 'blocked_count', 'active_count'));   

}

//get all editors

public function editors(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$users = User::whereUserType('editor')->orderBy('id', 'desc')->paginate(20); 
$pending_count = User::whereAccountStatus(0)->whereUserType('editor')->count();
$active_count = User::whereAccountStatus(1)->whereUserType('editor')->count();
$blocked_count = User::whereAccountStatus(2)->whereUserType('editor')->count();

if($request->status){

 $users = User::whereUserType('editor')->whereAccountStatus($request->status)->orderBy('id', 'desc')->paginate(20); 
 $pending_count = User::whereAccountStatus(0)->whereUserType('editor')->count();
 $active_count = User::whereAccountStatus(1)->whereUserType('editor')->count();
 $blocked_count = User::whereAccountStatus(2)->whereUserType('editor')->count();
}
return view('admin.users', compact('users', 'pending_count', 'blocked_count', 'active_count'));   
}

     //update user data
public function updateAdminUser(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$user = User::find($request->id);
$user->name = $request->name;
$user->site_id = $request->site_id;
$user->view_bids = $request->view_bids;
$user->nickname = $request->nickname;
$user->phone = $request->phone;
$user->email = $request->email;
$user->expert_in = $request->expert_in;
$user->about = $request->about;
$user->orders = $request->orders;
$user->editor_id = $request->editor_id;
$user->user_type = $request->user_type;
$user->account_status = $request->status;
$user->writer_levels = $request->writer_levels;
$user->top_ten = $request->top_ten;
$user->designation = $request->designation;
$user->location = $request->location;
$user->save();


return back()->withInput()->with('success', trans('Update success'));

}


     //update user data
public function deleteAdminUser(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$user = User::find($request->id);
$orders = Order::whereUserId($user->id)->get();
if($orders->count()>0){
 return back()->withInput()->with('error', trans('User has existing orders')); 
}
else{

 $user->delete();

}



return back()->withInput()->with('success', trans('Delete success'));

}

     //get all keywords

public function keywords(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$keywords = Keyword::orderBy('id', 'desc')->paginate(20);
return view('admin.keywords', compact('keywords')); 

}


     //get all packages

public function packages(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$packages = Package::orderBy('id', 'desc')->paginate(20);


return view('admin.packages', compact('packages'));   
}

//save a package
public function savePackage(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$data = [
  'name' => $request->name,
  'amount' => $request->amount,
  'max_units' => $request->max_units,
  'type' => $request->type,
];
Package::create($data);


return back()->withInput()->with('success', trans('Add success'));

}


//save a package
public function saveKeyword(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$data = [
  'keyword' => $request->keyword,
  'page_url' => $request->page_url,
];
Keyword::create($data);


return back()->withInput()->with('success', trans('Add success'));

}


      //update package
public function updatePackage(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$user = Package::find($request->id);
$user->name      = $request->name;
$user->amount    = $request->amount;
$user->max_units = $request->max_units;
$user->days      = $request->days;
$user->cpp      = $request->cpp;
$user->list1      = $request->list1;
$user->list2      = $request->list2;
$user->list3      = $request->list3;
$user->list4      = $request->list4;
$user->list5      = $request->list5;
$user->list6      = $request->list6;
$user->list7      = $request->list7;
$user->list8      = $request->list8;
$user->save();


return back()->withInput()->with('success', trans('Update success'));

}


      //update package
public function updateKeyword(Request $request){

  $user = Keyword::find($request->id);
  $user->keyword      = $request->keyword;
  $user->page_url    = $request->page_url;
  $user->save();


  return back()->withInput()->with('success', trans('Update success'));

}


      //update package
public function deleteContent(Request $request){

  $user = Template::find($request->id);
  $user->delete();
  return back()->withInput()->with('success', trans('Delete success'));

}



      //update package
public function deleteKeyword(Request $request){

  $user              = Keyword::find($request->id);
  $user->delete();


  $delete_links = Link::whereKeywordId($request->id)->delete();




  return back()->withInput()->with('success', trans('Delete success'));

}




public function generateLink(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$keywords = Keyword::find($request->id);
$keyword      = $request->keyword;
$page_url     = $request->page_url;
$replace_with = '<a href="'.$page_url.'">'.$keyword.'</a>';
$x = 0;

if($request->content == 1 ){



  $posts = Post::whereSiteId($request->site_id)->get();
  foreach ($posts as $key => $post) {
    $content =  $post->description;
    $content = str_replace($keyword, $replace_with, $content, $i);
    $post->description = $content;
    $post->save();

    if($i>0){
      $data = [
       'keyword_id' => $request->id,
       'post_id'    => $post->id,
     ];

     Link::create($data);
   }

   $x = $x + $i;


 }

} 

if($request->content == 0 ){

  $opt = $request->site_id.'_homepage_content';
  $content = get_option($request->site_id.'_homepage_content');
  $content = str_replace($keyword, $replace_with, $content, $i);
  Option::where('option_key',$opt)->update(['option_value'=>  $content]);

  $data = [
   'keyword_id' => $request->id,
   'post_id'    => 0,
 ];

 Link::create($data);

 $x = $x + $i;

 $opt = $request->site_id.'_homepage_content2';
 $content = get_option($request->site_id.'_homepage_content2');
 $content = str_replace($keyword, $replace_with, $content, $i);
 Option::where('option_key',$opt)->update(['option_value'=>  $content]);


 $data = [
   'keyword_id' => $request->id,
   'post_id'    => 0,
 ];

 Link::create($data);

 $x = $x + $i;

}

$keywords->internal_links = $x;
$keywords ->save();


return back()->withInput()->with('success', trans('Links generated'));

}


       //save a package
public function saveUser(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$slug = unique_slugu($request->name);
$data = [
  'name'       => $request->name,
  'email'      => $request->email,
  'phone'      => $request->phone,
  'user_type'  => $request->user_type,
  'package'    => $request->package_id,
  'slug'       => $slug,
  'referer'    => "Admin",
  'password'   => Hash::make($request->password),
];
User::create($data);


return back()->withInput()->with('success', trans('Add success'));

}

       //save a package
public function saveWriter(Request $request){

  $user = Auth::user();
  $slug = unique_slugu($request->name);
  $data = [
    'name'       => $request->name,
    'email'      => $request->email,
    'phone'      => $request->phone,
    'user_type'  => $request->user_type,
    'user_id'    => $user->id,
    'slug'       => $slug,
    'referer'    => "Client",
    'added_by'    => "client",
    'account_status'    => "1",
    'password'   => Hash::make($request->password),
  ];
  User::create($data);


  return back()->withInput()->with('success', trans('Add success'));

}

 //add new order

public function addOrder(){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$prices     = Pricing::whereStatus(1)->orderBy('id', 'desc')->get();
$categories = Category::orderBy('name', 'asc')->get();
$levels = Level::all();
$upsells = Upsell::all();
$papers      = Paper::wherecatType(0)->orderBy('pptype_name', 'asc')->get();

if( get_option(site_id().'_default_order_page') == 'academic' ){
 return view('admin.new_order', compact('prices', 'categories', 'papers', 'levels', 'upsells')); 
}


if(get_option(site_id().'_default_order_page') == 'technical'){
 return view('admin.new_technical_order', compact('prices', 'categories', 'papers', 'levels', 'upsells')); 
}



if(get_option(site_id().'_default_order_page') == 'professional'){
  $papers      = Category::orderBy('name', 'asc')->get();
  return view('admin.new_professional_service', compact('prices', 'categories', 'papers', 'levels', 'upsells')); 
}



}

 //add new order

public function newTechnicalOrder(){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$prices     = Pricing::whereStatus(1)->orderBy('id', 'desc')->get();
$categories = Category::all();
$papers      = Paper::wherecatType(0)->orderBy('pptype_name', 'asc')->get();

return view('admin.new_technical_order', compact('prices', 'categories', 'papers'));  

}


 //add new order

public function professionalService(){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$prices     = Pricing::whereStatus(1)->orderBy('id', 'desc')->get();
$categories = Category::all();
$papers      = Paper::wherecatType(4)->orderBy('pptype_name', 'asc')->get();

return view('admin.new_professional_service', compact('prices', 'categories', 'papers'));  

}

  //edit order

public function editOrder($id){
 $user = Auth::user();
 if($user->is_admin() or $user->is_client()){

   

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$order = Order::find($id);

$prices     = Pricing::whereStatus(1)->orderBy('id', 'desc')->get();
$categories = Category::orderBy('name', 'asc')->get();
$papers     = Paper::orderBy('pptype_name', 'asc')->get();
$uploads = Upload::whereOrderId($id)->whereUserId($order->user_id)->get();
$levels = Level::all();


if(Auth::user()->is_client()){

  if ($order->user_id == $user->id) {
    return view('admin.edit_order', compact('prices', 'categories','order', 'papers', 'uploads', 'levels')); 
  } 
  else{
   return redirect(route('dashboard'))->with('success', 'Access restricted');
 }

}


if(Auth::user()->is_writer()){

  return redirect(route('dashboard'))->with('success', 'Access restricted');

}

\LogActivity::addToLog('Order edited');
return view('admin.edit_order', compact('prices', 'categories','order', 'papers', 'uploads', 'levels'));  


}

}  



 //edit order

public function viewBids($id){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$bids  = Bid::whereOrderId($id)->get();
$order = Order::find($id);

if(Auth::user()->is_admin() or Auth::user()->is_subadmin()){
  
 return view('admin.bids', compact('bids', 'order'));  
}

if(Auth::user()->id == $order->user_id){
  return view('admin.bids', compact('bids', 'order')); 
}


return redirect(route('dashboard'));



}

   //deposit funds

public function deposit(){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
return view('admin.deposit');  

}


public function makeDeposit(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$user       = Auth::user();
$user_id    = $user->id;

$data = [
  'callback_url'         => url('/'),
  'order_id'             => $user_id,
  'amount'               => $request->amount,
  'user_id'              => $user_id,
  'payment_source'       => 'TopUp Wallet',
  'pay_reason'           => 'checkout',
  'currency'             => '2',

];


$pay_created = Payment::create($data);

if($pay_created){


  if(get_option(site_id().'_payment_option') == 'external'){

    //send payment data

           //API URL
    $pay_site = get_option(site_id().'_pay_site');
    $url=$pay_site."/spay?payment_id=".$pay_created->id."&amount=".$pay_created->amount."&domain_name=".domain_name()."&scallback_url=".route('success_deposit', $pay_created->id)."&ccallback_url=".route('deposit');

    return redirect($url);


  } else{
   return redirect(url('cpay/'.$pay_created->id))->with('success', 'created successfully');
 }


 

}
else{

  return back()->withInput()->with('error', trans('something went wrong'));

}

}


     //approve failed payment

public function approvePayment(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$payment = Payment::find($request->id);
$user_id = $payment->user_id;
$amount  = $payment->amount;
$payment_source = $payment->payment_source;

if($payment_source=='subscription'){


 $plan = Package::find($payment->order_id);
 $now = date('Y-m-d H:i:s');
 $days = $plan->days;
 $order_due = date("Y-m-d H:i:s", strtotime('+'.$days.' days'));


 $user = User::find($user_id);
 $user->subscribe_start = $now; 
 $user->subscribe_end = $order_due;
 $user->account_status = '1';
 $user->package = $payment->order_id;

 $user->save();

 $payment->status = 1;
 $payment->save();


 $data=array(
  'name' =>$user->name,
  'email'=>$user->email,
  'sname'=>'Hi '.$user->name. ', your '.domain_name().' account is now active',
  'description'=>'Hi '.$user->name. ', your '.domain_name().' account is now active',

);


        //send email to agent
 Mail::send('email.index',$data, function($message) use ($data){
  $message->to($data['email']);
  $message->subject($data['sname']);

}); 

   //send sms
   // $recipients = $user->phone;
   // $message    = 'Hi '.$user->name. ', your '.domain_name().' account is now active';
   // sendsms($recipients,$message);

 return back()->withInput()->with('success', trans('Payment approved successfully'));
}
else{
 $user = User::find($user_id);
 $wallet_bal = $user->wallet;
 $wallet_bal = $wallet_bal+$amount;
 $user->wallet = $wallet_bal;
 $user->save();

 return back()->withInput()->with('success', trans('Payment approved successfully')); 
}



}

public function sendSms(Request $request){
 $user_id  = Auth::user()->id;
 $message = $request->message;
 $user = Auth::user();

    //verify admin
 if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$invoices = Invoice::whereMonth($request->month)->whereDay($request->day)->whereYear($request->year)->whereStatus(1)->get();

foreach ($invoices as $key => $value) {

  $message = $request->message." ".$value->comment." Payment for Invoice ".$value->id." website www.".domain_name(); 
  $user    = User::find($value->user_id);
  sendsms($user->phone, $message);

}

return back()->withInput()->with('success', trans('sms sent'));

}


     //add deposit amount

public function successDeposit($id){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$payment = Payment::find($id);
$payment->status = 1;
$payment->save();

$user = User::find($payment->user_id);
$user_id = $payment->user_id;
$amount  = $payment->amount;
$payment_source = $payment->payment_source;


if($payment_source=='subscription'){

 $package = session()->get('package');
 $plan    = Package::find($package);


 $now = date('Y-m-d H:i:s');
 if(Auth::user()->is_writer())
   $days = 30;
 else{
   $days = $plan->days;
 }
 $order_due = date("Y-m-d H:i:s", strtotime('+'.$days.' days'));


 $user = User::find($user_id);
 $user->subscribe_start = $now; 
 $user->subscribe_end = $order_due;
 $user->account_status = '1';
 $user->package = $package;

 $user->save();

 Session::pull('package');


  //  $data=array(
  //   'name' =>$user->name,
  //   'email'=>$user->email,
  //   'sname'=>'Hi '.$user->name. ', your '.domain_name().' account is now active',
  //   'description'=>'Hi '.$user->name. ', your '.domain_name().' account is now active',

  // );


  //       //send email to agent
  //  Mail::send('email.index',$data, function($message) use ($data){
  //   $message->to($data['email']);
  //   $message->subject($data['sname']);

  // }); 

   //send sms
   // $recipients = $user->phone;
   // $message    = 'Hi '.$user->name. ', your '.domain_name().' account is now active';
   // sendsms($recipients,$message);

 return redirect(url('dashboard'))->with('success', trans('your account has been activated')); 


}





if($payment_source=='Wallet TopUp'){

 $wallet_bal = wallet($user_id);
 $wallet_bal = $wallet_bal+$amount;
 $payment->balance = $wallet_bal;
 $payment->save();



 $order_id = session()->get('order_id');
 if($order_id){

  $order = Order::find($order_id);

  if($order->status == '0'){


      //deduct amount from wallet

    $wallet_bal      = $wallet_bal-$order->ccost;


      //change status
    $order->status = 1;
    $order->save();

    $data = [

      'callback_url'         => url('/'),
      'order_id'             => $order->id,
      'amount'               => $order->ccost,
      'user_id'              => $user->id,
      'payment_source'       => 'Order paid',
      'pay_reason'           => 'checkout',
      'balance'              => $wallet_bal,
      'currency'             => 2,
      'status'               => 1,

    ];

    $pay_created = Payment::create($data);


    if($pay_created){

      $user->wallet = $wallet_bal;
      $user->save();
      
    }




    if($order->preferred_writer > 0){
//change status
      $order->status         = 2;
      $order->writer_id      = $order->preferred_writer;
      $order->save();

      $user = User::find($order->preferred_writer);
         //send email
      $data=array(
        'name' =>$user->name,
        'email'=>$user->email,
        'sname'=>'Hi '.$user->name.', client has made a request you work on order #'.$order->id,
        'description'=>'Hi '.$user->name.', client has made a request you work on order #'.$order->id. '  if you are available login to your www.'.domain_name().' account and accept the order',

      );


      //send email to agent
      Mail::send('email.index',$data, function($message) use ($data){
        $message->to($data['email']);
        $message->subject($data['sname']);

      }); 

    } else{
     $users = User::whereUserType('writer')->whereAccountStatus(1)->get();
     foreach ($users as $key => $user) {
 //send email
      $data=array(
        'name' =>$user->name,
        'email'=>$user->email,
        'sname'=>'Hi '.$user->name.', New order #'.$order->id. ' has been posted',
        'description'=>'Hi '.$user->name.', New order #'.$order->id. ' has been posted, login to your www.'.domain_name().' account and place a bid',

      );


      //send email to agent
      Mail::send('email.index',$data, function($message) use ($data){
        $message->to($data['email']);
        $message->subject($data['sname']);

      }); 
    }
  }

  Session::pull('order_id');
  return redirect(route('view_order', $order->slug ))->with('success', 'payment made successfully');
}

}



return redirect(url('dashboard'))->with('success', trans('your account has been funded')); 
}

if($payment_source=='TopUp Wallet'){




   //update payment status

 $wallet_bal = wallet($user_id);
 $payment->status = 1;
 $payment->balance = $wallet_bal;
 $payment->save();

 $order_id = session()->get('order_id');
 if($order_id){

  $order = Order::find($order_id);

  if($order->status == '0'){

//deduct amount from wallet


    $wallet_bal      = $wallet_bal-$order->ccost;

      //change status
    $order->status = 1;
    $order->save();

    $wallet_bal      = $user->wallet;

    $data = [
      'callback_url'         => url('/'),
      'order_id'             => $order->id,
      'amount'               => $order->ccost,
      'user_id'              => $user->id,
      'payment_source'       => 'Order paid',
      'pay_reason'           => 'checkout',
      'balance'              => $wallet_bal,
      'currency'             => 2,
      'status'               => 1,

    ];



    $pay_created = Payment::create($data);


    if($order->preferred_writer > 0){
//change status
      $order->status         = 2;
      $order->writer_id      = $order->preferred_writer;
      $order->save();

      $user = User::find($order->preferred_writer);
         //send email
      $data=array(
        'name' =>$user->name,
        'email'=>$user->email,
        'sname'=>'Hi '.$user->name.', client has made a request you work on order #'.$order->id,
        'description'=>'Hi '.$user->name.', client has made a request you work on order #'.$order->id. '  if you are available login to your www.'.domain_name().' account and accept the order',

      );


      //send email to agent
      Mail::send('email.index',$data, function($message) use ($data){
        $message->to($data['email']);
        $message->subject($data['sname']);

      }); 

    } else{
     $users = User::whereUserType('writer')->whereAccountStatus(1)->get();
     foreach ($users as $key => $user) {
 //send email
      $data=array(
        'name' =>$user->name,
        'email'=>$user->email,
        'sname'=>'Hi '.$user->name.', New order #'.$order->id. ' has been posted',
        'description'=>'Hi '.$user->name.', New order #'.$order->id. ' has been posted, login to your www.'.domain_name().' account and place a bid',

      );


      //send email to agent
      Mail::send('email.index',$data, function($message) use ($data){
        $message->to($data['email']);
        $message->subject($data['sname']);

      }); 
    }
  }

  Session::pull('order_id');
  return redirect(route('view_order', $order->slug ))->with('success', 'payment made successfully');
}



}



return redirect(url('dashboard'))->with('success', trans('your account has been funded')); 
}


if($payment_source=='custom invoice'){

  $invoice = Invoice::find($payment->invoice_id);

  $wallet_bal = wallet($user_id);
  $payment->status = 1;
  $payment->balance = $wallet_bal;
  $payment->save();

  if($invoice->status == '0'){
    $data = [

      'callback_url'         => url('/'),
      'order_id'             => $invoice->id,
      'amount'               => $invoice->total,
      'user_id'              => $user->id,
      'payment_source'       => 'invoice paid',
      'pay_reason'           => 'checkout',
      'balance'              => $wallet_bal,
      'currency'             => 2,
      'status'               => 1,

    ];



    $pay_created = Payment::create($data);

    if($pay_created){
     $invoice->status = 1;
     $invoice->save();
   }
 }


 return redirect(route('custom_invoices'))->with('success', trans('Payment recived')); 

}





}


//view application

public function viewApplication($id){

  $user = Auth::user();
  $user_id    = Auth::user()->id;
  $order      = Application::whereId($id)->first();
  $uploads    = Upload::whereApplicantId($order->id)->whereUserId($order->user_id)->get();




  if(Auth::user()->is_writer()){

    if ($order->user_id == $user_id) {
      return view('admin.view_application', compact('order', 'uploads')); 
    } 
    else{
      return redirect(route('dashboard'))->with('success', 'Access restricted');
    }

  } 

  if(Auth::user()->is_admin()){

    return view('admin.view_application', compact('order', 'uploads'));

  }








  

}

     //view order

public function viewOrder($id){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$user_id  = Auth::user()->id;
$order   = Order::whereSlug($id)->first();
$uploads = Upload::whereOrderId($order->id)->whereUserId($order->user_id)->get();
$prices     = Pricing::all();
$categories = Category::all();



if(Auth::user()->is_writer()){

  if ($order->writer_id == $user_id or $order->status == '1' or $order->order_level == 'technical') {
    return view('admin.view_order', compact('prices', 'categories','order', 'uploads')); 
  } 
  else{
    return redirect(route('order_available'))->with('success', 'Order has already been assigned to another writer');
  }

} 


if(Auth::user()->is_client()){

  if ($order->user_id == $user_id) {
    return view('admin.view_order', compact('prices', 'categories','order', 'uploads')); 
  } 
  else{
    return redirect(route('dashboard'))->with('success', 'Access restricted');
  }

} 



else{
  return view('admin.view_order', compact('prices', 'categories','order', 'uploads'));  
}



}


   //view order

public function markRead(Request $request){

  $user_id  = Auth::user()->id;
  $user = User::find($user_id);
  if ($user->is_admin() or $user->is_subadmin()) {
    $chats = Chat::all();
    foreach ($chats as $key => $message) {
     $message->admin_message_read = 1;
     $message->save();
   }



 } else{
  $chats = Chat::whereMessageTo($user_id)->get();
  foreach ($chats as $key => $message) {
    $message->message_read = 1;
    $message->save();
  }

}



return back()->withInput()->with('success', trans('chats updated'));

}

     //view order

public function viewMessageUnread($id){

  $message = Chat::find($id);
  $user_id  = Auth::user()->id;
  $user = User::find($user_id);
  if ($user->is_admin()) {
   $message->admin_message_read = 1;

 } else{
  $message->message_read = 1;
}

$message->save();


$order      = Order::find($message->order_id);
$uploads    = Upload::whereOrderId($id)->whereUserId($order->user_id)->get();
$prices     = Pricing::all();
$categories = Category::all();

//return view('admin.view_order', compact('prices', 'categories','order', 'uploads'));  

return redirect(route('view_order', $order->slug ));

}


public function smsSuccess(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$amount = $request->amount;
$option              = Option::find(1);
$sms_balance         = $option->sms_balance;
$option->sms_balance = $sms_balance+$amount;
$option->save();

$now = Carbon::now();
$month  =  $now->month;
$year  =  $now->year;
$data = [
  'month'          => $month,
  'year'           => $year,
  'amount'         => $request->amount,
  'name'           => 'Sms Payment',
  'user_id'        => Auth::user()->id,
  'transaction_type' => 0,

];

$service1_created = Expense::create($data);

return redirect(url('dashboard'))->with('success', trans('Sms funded')); 

}



public function chatLists(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$order_id = $request->order_id;
$corder = Order::find($order_id);
$url = url()->previous();
$current_url = url('/')."/dashboard/view-order/".$corder->slug;
$current_url2 = url('/')."/dashboard/view-message-unread/".$corder->id."#chat";

if($url == $current_url or $url == $current_url2){


 $chats = \App\Models\Chat::whereOrderId($order_id)->orderBy('id', 'asc')->get();

 

 return view('includes.chats', compact('order_id')); 
}
else{
  return redirect(route('view_order', $corder->slug ));
}





}

 //create new professional service

public function professionalOrder(Request $request)
{
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$user_id  = Auth::user()->id;
$user     = User::find($user_id);




$data = [
  'title'          => $request->title,
  'order_level'    => $request->order_level,
  'order_budget'   => $request->order_budget,
  'description'    => $request->description,
  'user_id'        => $user_id,
  'paper_id'       => $request->paper_id,

];



$order_created = Order::create($data);



if($request->hasFile('photos')){
  $files = $request->file('photos');
  foreach($files as $file){

    $user_id  = Auth::user()->id;
    $fileModel = new Upload;

    $fileName = $order_created->id.'_'.$file->getClientOriginalName();
    $filePath = $file->storeAs('uploads', $fileName, 'public');
    $fileModel->name = $order_created->id.'_'.$file->getClientOriginalName();
    $fileModel->order_id = $order_created->id;
    $fileModel->user_id = $user_id;
    $fileModel->file_path = url('/').'/storage/' . $filePath;
    $fileModel->save();



  }


}


if($order_created){

  $users = User::whereExpertIn(3)->whereAccountStatus(1)->get();
  foreach ($users as $key => $user) {
  //send email
    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'We have a technical order #'.$order_created->id.' for you',
      'description'=>'We have a technical order #'.$order_created->id.' for you, would you place a bid for it and suggest how much the client should pay you.',

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

  }



}

return redirect(route('view_order', $order_created->slug ))->with('success', 'created successfully');
}


 //create new technical

public function technicalOrder(Request $request)
{
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$user_id  = Auth::user()->id;
$user     = User::find($user_id);
$count    = $request->page;


$due_in = $request->due_in1;
$delimiter = ' ';
$words = explode($delimiter, $due_in);
$pricing_urgency  = $words[0];
$pricing_duration = $words[1];
$now = date('Y-m-d H:i:s');

if($pricing_duration == 'Hours'){
  $pricing_urgency1 = (int)$pricing_urgency*get_option(site_id().'_writer_time');
  $pricing_urgency2 = (int)$pricing_urgency**get_option(site_id().'_editor_time');
  $order_due        = date("Y-m-d H:i:s", strtotime('+'.$pricing_urgency.' hours'));
  $order_wrdeadline = Carbon::now()->addHour($pricing_urgency1);
  $order_eddeadline = Carbon::now()->addHour($pricing_urgency2);
} else{
 $pricing_urgency1 = (int)$pricing_urgency*get_option(site_id().'_writer_time');
 $pricing_urgency2 = (int)$pricing_urgency*get_option(site_id().'_editor_time');
 $order_due        = date("Y-m-d H:i:s", strtotime('+'.$pricing_urgency.' days'));
 $order_wrdeadline = Carbon::now()->addDay($pricing_urgency1);
 $order_eddeadline = Carbon::now()->addDay($pricing_urgency2);
}
$cost = $request->total;
$cost = (int) $cost;

if ($user->account_status == '0') {
  $cost = $cost;
  $cost = $cost/get_option(site_id().'_admin_share');
  $editor_share = $cost * get_option(site_id().'_editor_share');
  $writer_share = $cost * get_option(site_id().'_writer_share');
  $admin_share  = $request->total - $cost;
  $order_admin_share  = $cost * get_option(site_id().'_order_admin_share');
}
else{

  $cost = $cost;
  $editor_share = $cost * get_option(site_id().'_editor_share');
  $writer_share = $cost * get_option(site_id().'_writer_share');
  $admin_share  = 0;
  $order_admin_share  = $cost * get_option(site_id().'_order_admin_share');

}



$data = [
  'title'          => $request->title,
  'order_level'    => $request->order_level,
  'order_budget'   => $request->order_budget,
  'description'    => $request->description,
  'user_id'        => $user_id,
  'category_id'    => $request->order_type,
  'word_count'     => $count,
  'ccost'          => $cost,
  'order_style'    => $request->price,
  'slide'         => $request->slide,
  'paper_id'       => $request->paper_id,
  'sources'        => $request->sources,
  'personal_note'  => $request->personal_note,
  'order_citation' => $request->order_citation,
  'order_due'      => $order_due,
  'order_wrdeadline'      => $order_wrdeadline,
  'order_eddeadline'      => $order_eddeadline,
  'ecost'                 => $editor_share,
  'order_admin_share'     => $order_admin_share,
  'subscription_fee'      => $admin_share,
  'wcost'      => $writer_share,

];



$order_created = Order::create($data);



if($request->hasFile('photos')){
  $files = $request->file('photos');
  foreach($files as $file){

    $user_id  = Auth::user()->id;
    $fileModel = new Upload;

    $fileName = $order_created->id.'_'.$file->getClientOriginalName();
    $filePath = $file->storeAs('uploads', $fileName, 'public');
    $fileModel->name = $order_created->id.'_'.$file->getClientOriginalName();
    $fileModel->order_id = $order_created->id;
    $fileModel->user_id = $user_id;
    $fileModel->file_path = url('/').'/storage/' . $filePath;
    $fileModel->save();



  }


}


if($order_created){

  $users = User::whereExpertIn(2)->whereAccountStatus(1)->get();
  foreach ($users as $key => $user) {
  //send email
    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'We have a technical order #'.$order_created->id.' for you',
      'description'=>'We have a technical order #'.$order_created->id.' for you, would you place a bid for it and suggest how much the client should pay you.',

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

  }



}

return redirect(route('view_order', $order_created->slug ))->with('success', 'created successfully');
}


public function newApplicant(Request $request)
{


  $user = Auth::user();

  
  $data = [
    'name'              => $request->name,
    'applying_for'      => $request->applying_for,
    'description'       => $request->description,
    'url_companies'     => $request->url_companies,
    'url_profiles'      => $request->url_profiles,
    'user_id'           => $user->id,

  ];



  $order_created = Application::create($data);

  if($request->hasFile('photos')){
    $files = $request->file('photos');
    foreach($files as $file){

      $user_id  = Auth::user()->id;
      $fileModel = new Upload;

      $fileName = $order_created->id.'_'.$file->getClientOriginalName();
      $filePath = 'uploads/'.$fileName;
      $is_uploaded = current_disk()->put($filePath, file_get_contents($file));
      if($is_uploaded){

        $fileModel->name = $order_created->id.'_'.$file->getClientOriginalName();
        $fileModel->applicant_id = $order_created->id;
        $fileModel->user_id = $user_id;

        if(get_option(site_id().'_default_storage') == 'public') {
          $fileModel->file_path = get_option(site_id().'_main_site_url').'/storage/' . $filePath;
        } else{
         $is_uploaded = Storage::disk('public')->put($filePath, file_get_contents($file));
         $fileModel->file_path = 'https://awasam.s3.amazonaws.com/'.$filePath;
       }

       $fileModel->save();
     }
   }



 }

 $user->application_id = $order_created->id; 
 $user->save();



 return redirect(route('view_application', $order_created->id ))->with('success', 'created successfully');

}

 //create new order

public function cnewOrder(Request $request)
{


  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$user_id  = Auth::user()->id;
$user = User::find($user_id);
$count = $request->page;
$slide = $request->slide;
$plagiarism_report     = $request->plagiarism_report;

$preferred_writer_only_total = 0;
$preferred_writer_only = 0;
if($request->preferred_writer_only){
  $preferred_writer_only = $request->preferred_writer_only;
  $preferred_writer_only_total = $preferred_writer_only*get_option(site_id().'_preferred_writer_only')*$count;
}


$top_ten_total = 0;
$top_ten = 0;
if($request->top_ten){

  $top_ten = $request->top_ten;
  $top_ten_total = $top_ten*get_option(site_id().'_top_ten')*$count;

}

//get paper type id 

$paperName = $request->paper;
$paper = Paper::wherePptypeName($paperName)->first();

if ($paper === null) {
    // Return an error response or handle this situation
  return response()->json([
    'error' => 'No paper found with the name: ' . $paperName
  ], 404);
}

$paper_id = $paper->id;
$pptype_pvalue = $paper->pptype_pvalue;

  //get level id
$level_value = $request->aclevel;
$level = Level::whereAclevelValue($level_value)->first();

if ($level === null) {
    // Return an error response or handle this situation
  return response()->json([
    'error' => 'No level found with the value: ' . $level_value
  ], 404);
}

$level_id = $level->id;



$due_in = $request->due_in;
$delimiter = ' ';
$words = explode($delimiter, $due_in);
$pricing_urgency  = $words[0];
$pricing_duration = $words[1];
$price = Pricing::wherePricingUrgency($pricing_urgency)->wherePricingDuration($pricing_duration)->first();
$now = date('Y-m-d H:i:s');

$pcost = $price->pricing_value*$count;
$scost = $slide*get_option(site_id().'_ppt_slide_cost');
$plagiarism_report_fee = $plagiarism_report*get_option(site_id().'_plagiarism_report');
$cost  = $pcost + $scost;
$editor_cost = get_option(site_id().'_editor_share')*$count + get_option(site_id().'_editor_share')*0.5*$slide;

$order_style = $request->price;
if($order_style == '2'){

  $cost = $cost*2;

}



if($pricing_duration == 'Hours'){
  $pricing_urgency1 = (int)$pricing_urgency*get_option(site_id().'_writer_time');
  $pricing_urgency2 = (int)$pricing_urgency*get_option(site_id().'_editor_time');
  $order_due        = date("Y-m-d H:i:s", strtotime('+'.$pricing_urgency.' hours'));
  $order_wrdeadline = Carbon::now()->addHour($pricing_urgency1);
  $order_eddeadline = Carbon::now()->addHour($pricing_urgency2);
} else{
 $pricing_urgency1 = (int)$pricing_urgency*get_option(site_id().'_writer_time');
 $pricing_urgency2 = (int)$pricing_urgency*get_option(site_id().'_editor_time');
 $order_due        = date("Y-m-d H:i:s", strtotime('+'.$pricing_urgency.' days'));
 $order_wrdeadline = Carbon::now()->addDay($pricing_urgency1);
 $order_eddeadline = Carbon::now()->addDay($pricing_urgency2);
}

$cost = $cost*$pptype_pvalue*$level_value;

if ($user->account_status == '0') {

  $total_cost   = $cost*get_option(site_id().'_admin_share');
  $editor_share = $editor_cost;
  $writer_share = $cost * get_option(site_id().'_writer_share');
  $admin_share  = $total_cost - $cost;
  $order_admin_share  = $cost * get_option(site_id().'_order_admin_share')-$editor_share;


  if ($request->editor_involved == '0.875') {
    $total_cost = $cost*0.875;
    $editor_share = 0;
    $writer_share = $total_cost * 0.857142857143;
    $admin_share  = 0;
    $order_admin_share  = $total_cost * 0.14285714285;

  }

}


if ($user->account_status == '1') {

  $total_cost   = $cost;
  $editor_share = $editor_cost;
  $writer_share = $cost * get_option(site_id().'_writer_share');
  $admin_share  = 0;
  $order_admin_share  = $cost * get_option(site_id().'_order_admin_share')-$editor_share;

  if ($request->editor_involved == '0.8') {
    $total_cost = $cost*0.8;
    $editor_share = 0;
    $writer_share = $total_cost * 0.9375;
    $admin_share  = 0;
    $order_admin_share  = $total_cost * 0.0625;

  }


}


if ($user->is_student()) {

  $total_cost   = $cost*get_option(site_id().'_conversion_rate');
  $editor_share = $editor_cost;
  $writer_share = $cost * get_option(site_id().'_writer_share');
  $admin_share  = 0;
  $order_admin_share  = $cost * get_option(site_id().'_order_admin_share')-$editor_share;

}

$total_cost = (int) $total_cost + $plagiarism_report_fee + $preferred_writer_only_total + $top_ten_total;
$data = [
  'aclevel'        => $level_id,
  'title'          => $request->title,
  'order_continuation' => $request->order_continuation,
  'description'    => $request->description,
  'user_id'        => $user_id,
  'category_id'    => $request->order_type,
  'word_count'     => $count,
  'ccost'          => $total_cost,
  'order_style'    => $request->price,
  'slide'          => $request->slide,
  'paper_id'       => $paper_id,
  'sources'        => $request->sources,
  'personal_note'  => $request->personal_note,
  'order_citation' => $request->order_citation,
  'editor_involved' => $request->editor_involved,
  'preferred_writer' => $request->preferred_writer,
  'plagiarism_report' => $request->plagiarism_report,
  'plagiarism_report_fee' => $plagiarism_report_fee,
  'language'              => $request->language,
  'urgency'              => $request->due_in,
  'order_due'      => $order_due,
  'order_wrdeadline'      => $order_wrdeadline,
  'order_eddeadline'      => $order_eddeadline,
  'ecost'      => $editor_share,
  'order_admin_share'      => $order_admin_share,
  'subscription_fee'      => $admin_share,
  'preferred_writer_only'      => $preferred_writer_only,
  'preferred_writer_only_total'      => $preferred_writer_only_total,
  'top_ten'              => $top_ten,
  'top_ten_total'        => $top_ten_total,
  'wcost'           => $writer_share,
  'urgency_id'      => $price->id,
  'question_id'      => $request->question_id,

];



$order_created = Order::create($data);

if($request->hasFile('photos')){
  $files = $request->file('photos');
  foreach($files as $file){

    $user_id  = Auth::user()->id;
    $fileModel = new Upload;

    $fileName = $order_created->id.'_'.$file->getClientOriginalName();
    $filePath = 'uploads/'.$fileName;
    $is_uploaded = current_disk()->put($filePath, file_get_contents($file));
    if($is_uploaded){

      $fileModel->name = $order_created->id.'_'.$file->getClientOriginalName();
      $fileModel->order_id = $order_created->id;
      $fileModel->user_id = $user_id;

      if(get_option(site_id().'_default_storage') == 'public') {
        $fileModel->file_path = get_option(site_id().'_main_site_url').'/storage/' . $filePath;
      } else{
       $is_uploaded = Storage::disk('public')->put($filePath, file_get_contents($file));
       $fileModel->file_path = 'https://awasam.s3.amazonaws.com/'.$filePath;
     }

     $fileModel->save();
   }
 }

  //check is request comes via ajax?
 if ($request->ajax()){
  return ['success'=>1, 'msg'=>'Great, your order has been created,', 'order_id'=>$order_created->id, 'slug'=>$order_created->slug,  ];
}

} else{
   //check is request comes via ajax?
  if ($request->ajax()){
    return ['success'=>1, 'msg'=>'Great, your order has been created,', 'order_id'=>$order_created->id, 'slug'=>$order_created->slug,  ];
  }
}


Session::pull('writer_id');




return redirect(route('view_order', $order_created->slug ))->with('success', 'created successfully');
}


//approve order

public function approveOrder(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$order = Order::find($request->order_id);
$order->status      = $request->status;
$order->payments      = 1; 
$order->epayments     = 1;
$order->save();

return back()->withInput()->with('success', trans('Order approved successfully'));

}


//fine order

public function fineOrder(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$order = Order::find($request->order_id);
$order->order_fine      = $request->order_fine;
$order->order_finereason      = $request->order_finereason;
$order->save();

return back()->withInput()->with('success', trans('Writer has been fined successfully'));

}

public function bidOrder(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$user_id  = Auth::user()->id;
$data = [
  'order_id'          => $request->order_id,
  'writer_budget'          => $request->writer_budget + get_option(site_id().'_technical_order_default'),
  'user_id'           => $user_id,

];

$bid_created = Bid::create($data);

return back()->withInput()->with('success', trans('Your request has been sent successfully'));

}


public function pickOrder(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$user_id                = Auth::user()->id;
$order                  = Order::find($request->order_id);
$order->writer_confirm  = 2;
$order->writer_id       = $user_id; 
$order->status          = 2; 
$order->save();

if($order->editor_id){
  $user = User::find(1);

//send sms
  $data=array(
    'name' =>$user->name,
    'email'=>$user->email,
    'sname'=>'The writer has picked order #'.$request->order_id,
    'description'=>'The writer has picked order #'.$request->order_id,

  );


      //send email to agent
  Mail::send('email.index',$data, function($message) use ($data){
    $message->to($data['email']);
    $message->subject($data['sname']);

  }); 


  //send sms
    // $recipients = $user->phone;
    // $message    = 'The writer has accepted the assigned order #'.$request->order_id;
    // sendsms($recipients,$message);
}




return back()->withInput()->with('success', trans('Order has been assigned to you successfully'));

}


public function epickOrder(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$user_id                = Auth::user()->id;
$order                  = Order::find($request->order_id);
$order->editor_id       = $user_id; 
$order->save();

return back()->withInput()->with('success', trans('Order has been assigned to you successfully'));

}

public function acceptOrder(Request $request){


  $order = Order::find($request->order_id);

  if(Auth::user()->is_writer()){
    $user_id = Auth::user()->id;  
  } else{
   $user_id = $order->writer_id;  
 }

 $order->writer_id  = $user_id; 
 $order->writer_confirm  = 2; 
 $order->status  = 2; 
 $order->save();

 if($order->editor_id){

  $user = User::find($order->editor_id);

//send sms
  $data=array(
    'name' =>$user->name,
    'email'=>$user->email,
    'sname'=>'The writer has accepted the assigned order #'.$request->order_id,
    'description'=>'The writer has accepted the assigned order #'.$request->order_id,

  );


      //send email to agent
  Mail::send('email.index',$data, function($message) use ($data){
    $message->to($data['email']);
    $message->subject($data['sname']);

  }); 


  //send sms
    // $recipients = $user->phone;
    // $message    = 'The writer has accepted the assigned order #'.$request->order_id;
    // sendsms($recipients,$message);
}




return back()->withInput()->with('success', trans('Message sent successfully'));

}




//answer
public function answerOrder(Request $request){

  $user = Auth::user();
  $order = Order::find($request->order_id);

  $data = [
    'description'       => $request->description,
    'user_id'        => $user->id,
    'order_id'       => $request->order_id,

  ];

  $pay_created = Answer::create($data);

  return redirect(route('view_order', $order->slug ))->with('success', 'Your query has been submitted successfully');
}




//reject
public function rejectOrder(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$order = Order::find($request->order_id);
$order->writer_id  = 0; 
$order->status  = 1; 
$order->save();

if($order->editor_id){
  $user = User::find($order->editor_id);

//send sms
  $data=array(
    'name' =>$user->name,
    'email'=>$user->email,
    'sname'=>'The writer has rejected the assigned order #'.$request->order_id,
    'description'=>'The writer has rejected the assigned order #'.$request->order_id,

  );


      //send email to agent
  Mail::send('email.index',$data, function($message) use ($data){
    $message->to($data['email']);
    $message->subject($data['sname']);

  }); 


  //send sms
  $recipients = $user->phone;
  $message    = 'The writer has rejected the assigned order #'.$request->order_id;
  sendsms($recipients,$message);
}



$data = [
  'reject_reseason'       => $request->reject_reseason,
  'user_id'        => $user->id,
  'order_id'       => $request->order_id,

];

$pay_created = Reject::create($data);



return redirect(route('view_order', $order->slug ))->with('success', 'Order has been reassigned successfully');
}


//update order

public function costOrder(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$order = Order::find($request->order_id);
$order->ccost  = $request->amount;
$order->save();

$user = User::find($order->user_id);

//send sms
$data=array(
  'name' =>$user->name,
  'email'=>$user->email,
  'sname'=>'Your order #'.$request->order_id. ' price updated',
  'description'=>'Your order #'.$request->order_id. ' price has been updated, login to your www.'.domain_name().'.com account and proceed on making the payment',

);


      //send email to agent
Mail::send('email.index',$data, function($message) use ($data){
  $message->to($data['email']);
  $message->subject($data['sname']);

}); 


  //send sms
$recipients = $user->phone;
$message    = 'Your order #'.$request->order_id. ' price has been updated, login to your www.'.domain_name().'.com account and proceed on making the payment';
sendsms($recipients,$message);

return back()->withInput()->with('success', trans('Updated successfully'));

}


//update order

public function updateOrder(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$order    = Order::find($request->order_id);
$user_id  = $order->user_id;
$user     = User::find($user_id);

//get paper type value
$paper_id = $request->paper_id;
$paper = Paper::find($paper_id);
$paper_pvalue = $paper->pptype_pvalue;

    //get level id
$level_value = $request->aclevel;
$level = Level::whereAclevelValue($level_value)->first();
$level_id = $level->id;



$count = $request->page;
$slide = $request->slide;
$due_in = $request->due_in;
$client_deadline = $request->client_deadline;
$plagiarism_report = $request->plagiarism_report;
$plagiarism_report_fee = $plagiarism_report*get_option(site_id().'_plagiarism_report');

$preferred_writer_only_total = 0;
$preferred_writer_only = 0;
if($request->preferred_writer_only){
  $preferred_writer_only = $request->preferred_writer_only;
  $preferred_writer_only_total = $preferred_writer_only*get_option(site_id().'_preferred_writer_only')*$count;
}


$top_ten_total = 0;
$top_ten = 0;
if($request->top_ten){
  $top_ten = $request->top_ten;
  $top_ten_total = $top_ten*get_option(site_id().'_top_ten')*$count;
}

if ($due_in == $order->order_due) {

  $order_due        = $order->order_due;
  $order_wrdeadline = $order->order_wrdeadline;
  $order_eddeadline = $order->order_eddeadline;

  $urgency = $order->urgency;

  $urgency_id = $order->urgency_id;
  $price = Pricing::find($urgency_id);
  $pcost = $price->pricing_value*$count;
  $scost = $slide*get_option(site_id().'_ppt_slide_cost');
  $cost  = $pcost + $scost;
  $editor_cost = get_option(site_id().'_editor_share')*$count + get_option(site_id().'_editor_share')*0.5*$slide;

}
else{
 $urgency = $request->due_in;;
 $delimiter = ' ';
 $words = explode($delimiter, $due_in);
 $pricing_urgency  = $words[0];
 $pricing_duration = $words[1];
 $price = Pricing::wherePricingUrgency($pricing_urgency)->wherePricingDuration($pricing_duration)->first();
 $urgency_id = $price->id;
 $now = date('Y-m-d H:i:s');
 $pcost = $price->pricing_value*$count;
 $scost = $slide*get_option(site_id().'_ppt_slide_cost');
 $cost  = $pcost + $scost;
 $editor_cost = get_option(site_id().'_editor_share')*$count + get_option(site_id().'_editor_share')*0.5*$slide;

 if($pricing_duration == 'Hours'){
  $pricing_urgency1 = (int)$pricing_urgency*get_option(site_id().'_writer_time');
  $pricing_urgency2 = (int)$pricing_urgency*get_option(site_id().'_editor_time');
  $order_due        = date("Y-m-d H:i:s", strtotime('+'.$pricing_urgency.' hours'));
  $order_wrdeadline = Carbon::now()->addHour($pricing_urgency1);
  $order_eddeadline = Carbon::now()->addHour($pricing_urgency2);
} else{
 $pricing_urgency1 = (int)$pricing_urgency*get_option(site_id().'_writer_time');
 $pricing_urgency2 = (int)$pricing_urgency*get_option(site_id().'_editor_time');
 $order_due        = date("Y-m-d H:i:s", strtotime('+'.$pricing_urgency.' days'));
 $order_wrdeadline = Carbon::now()->addDay($pricing_urgency1);
 $order_eddeadline = Carbon::now()->addDay($pricing_urgency2);
}



}

$cost = $cost*$paper_pvalue*$level_value;


if ($user->account_status == '0') {

  $total_cost = $cost*get_option(site_id().'_admin_share');
  $editor_share = $editor_cost;
  $writer_share = $cost * get_option(site_id().'_writer_share');
  $admin_share  = $total_cost - $cost;
  $order_admin_share  = $cost * get_option(site_id().'_order_admin_share')-$editor_cost;

}
else{

  $total_cost = $cost;
  $editor_share = $editor_cost;
  $writer_share = $cost * get_option(site_id().'_writer_share');
  $admin_share  = 0;
  $order_admin_share  = $cost * get_option(site_id().'_order_admin_share')-$editor_cost;

}

if ($request->editor_involved == '0.8') {
  $total_cost = $cost*0.8;
  $editor_share = 0;
  $writer_share = $total_cost * 0.9375;
  $admin_share  = 0;
  $order_admin_share  = $total_cost * 0.0625;

}

if ($request->editor_involved == '0.875') {
  $total_cost = $cost*0.875;
  $editor_share = 0;
  $writer_share = $total_cost * 0.857142857143;
  $admin_share  = 0;
  $order_admin_share  = $total_cost * 0.14285714285;

}


$total_cost = (int) $total_cost + $plagiarism_report_fee + $preferred_writer_only_total + $top_ten_total;

$order->aclevel            = $level_id;
$order->title              = $request->title;
$order->description        = $request->description;
$order->category_id        = $request->order_type;
$order->ecost              = $editor_share;
$order->order_admin_share  = $order_admin_share;
$order->subscription_fee   = $admin_share;
$order->wcost              = $writer_share;
$order->plagiarism_report  = $request->plagiarism_report;
$order->plagiarism_report_fee = $plagiarism_report_fee;
$order->word_count         = $count;
$order->ccost              = $total_cost;
$order->order_style        = $request->price;
$order->paper_id           = $request->paper_id;
$order->personal_note      = $request->personal_note;
$order->order_citation     = $request->order_citation;
$order->editor_involved    = $request->editor_involved;
$order->language    = $request->language;
$order->order_due          = $order_due;
$order->order_wrdeadline   = $order_wrdeadline;
$order->urgency   = $urgency;
$order->sources            = $request->sources;
$order->slide              = $request->slide;
$order->order_eddeadline   = $order_eddeadline;
$order->urgency_id         = $urgency_id;
$order->preferred_writer   = $request->preferred_writer;
$order->preferred_writer_only_total   = $preferred_writer_only_total;
$order->preferred_writer_only   = $preferred_writer_only;
$order->top_ten_total   = $top_ten_total;
$order->top_ten   = $top_ten;
$order->save();


return redirect(route('view_order', $order->slug ))->with('success', 'order updated successfully');

}

//wallet top up by admin
public function topWallet(Request $request){

//   $user = Auth::user();

//     //verify admin
//   if($user->is_admin()){
//    if($user->active_status == 0){

//     $data=array(
//       'name' =>$user->name,
//       'email'=>$user->email,
//       'sname'=>'Here is your activation code '.$user->activation_code,
//       'description'=>'Find your activation code '.$user->activation_code,

//     );


//       //send email to agent
//     Mail::send('email.index',$data, function($message) use ($data){
//       $message->to($data['email']);
//       $message->subject($data['sname']);

//     }); 

//     \LogActivity::addToLog('Activation code request');
//     return redirect(route('activate_code'))->with('error', trans('verify your account'));
//   }
  
// }


// $pin        = $request->pin;
// $hash_val   = md5($pin);
// $admin = Admin::where('password', $hash_val)->first();
// $admin_count = Admin::where('password', $hash_val)->count();

// if (empty($admin->id)) {

//  return back()->withInput()->with('error', trans('wrong pin'));

// }


// if($admin_count > 0){

//  \LogActivity::addToLog('Update wallet');
//  if(Auth::user()->is_admin()){

//   $user  = User::find($request->id);
//   $wallet_bal = $user->wallet;
//   $amount = $request->amount;
//   $wallet_bal      = $wallet_bal+$amount;
//   $user->wallet    = $wallet_bal;
//   $user->save();
//   $wallet_bal = $user->wallet;
//   $data = [
//     'callback_url'         => url('/'),
//     'amount'               => $amount,
//     'user_id'              => $request->id,
//     'comments'              => $request->comments,
//     'payment_source'       => 'Admin Wallet TopUp',
//     'pay_reason'           => 'Admin Wallet TopUp',
//     'balance'             => $wallet_bal,
//     'currency'             => 2,
//     'status'              => 1,
//     'added_by'            => Auth::user()->id,

//   ];

//   $pay_created = Payment::create($data);



//   return back()->withInput()->with('success', trans('Topup made successfully'));
// }

// else{
//  return back()->withInput()->with('error', trans('Access restricted'));
// }

// }
// else{
//  return back()->withInput()->with('error', trans('wrong pin'));
// }



return back()->withInput()->with('error', trans('Access restricted'));


}

//change password
public function changePassword(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$user  = User::find($request->id);
if($request->password != $request->password_confirmation){
  return back()->withInput()->with('error', trans('Password do not match'));
}
else{
 $user->password = bcrypt($request->password);
 $user->save();
 return back()->withInput()->with('success', trans('Password updated successfully'));
}

}


//delete order
public function deleteMessage(Request $request){


  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$order = Chat::find($request->chat_id);
$order->delete();
return back()->withInput()->with('success', trans('Message has been deleted'));


}

//delete order
public function deleteBid(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$order = Bid::find($request->id);
$order->delete();
return back()->withInput()->with('success', trans('Bid has been deleted'));


}

//save editor rating order
public function erateSave(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$order = Order::find($request->order_id);
$order->eorder_rating = $request->order_rating;
$order->eorder_ratecomment = $request->order_ratecomment;
$order->save();
return back()->withInput()->with('success', trans('Comment has been submitted'));


}

//delete order
public function deleteOrder(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$order = Order::find($request->id);
$order->delete();
return back()->withInput()->with('success', trans('Order has been deleted'));


}


//delete order
public function acancelOrder(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$order = Order::find($request->id);
$order->order_cancelreason = "Time Expired";
$order->status = 7;
$order->save();
return back()->withInput()->with('success', trans('Order has been cancelled'));


}

//create pdf

public function createPDF() {
      // retreive all records from db
  $data = User::all();
      // share data to view
  view()->share('invoice',$data);

  $pdf = PDF::loadView('admin.invoice_pdf', $data->toArray());
      // download PDF file with download method
  return $pdf->download('pdf_file.pdf');
}

//delete order
public function duplicateOrder(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$order = Order::find($request->id);
$newPost = $order->replicate();
$slug = unique_slug($newPost->title);
$newPost->status = 0;
$newPost->invoice_id = 0;
$newPost->einvoice_id = 0;
$newPost->order_fine = 0;
$newPost->order_finereason = "";
$newPost->writer_id = 0;
$newPost->editor_id = 0;
$newPost->preferred_writer = 0;
$newPost->writer_paid = 'unpaid';
$newPost->editor_id = 0;
$newPost->slug = $slug;
$newPost->save();

$order_id = $newPost->id;
$user_id  = $newPost->user_id;



$uploads    = Upload::whereOrderId($request->id)->whereUserId($order->user_id)->get();

foreach ($uploads as $key => $upload) {


 $newPost = $upload->replicate();
 $newPost->order_id = $order_id;
 $newPost->user_id =  $user_id;
 $newPost->save();




}


return back()->withInput()->with('success', trans('Order has been deleted'));


}

//add orderClientnotewriter
public function orderClientnotewriter(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$order = Order::find($request->order_id);
$order->order_clientnotewriter = $request->order_clientnotewriter;
$order->save();
return back()->withInput()->with('success', trans('Order comment updated'));


}


//add client note
public function orderClientnote(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$order = Order::find($request->order_id);
$order->order_clientnote = $request->order_clientnote;
$order->save();
return back()->withInput()->with('success', trans('Order note added'));


}


//delete order
public function deleteFile(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$order = Upload::find($request->id);
$order->delete();
return back()->withInput()->with('success', trans('Order files has been deleted'));


}

//delete revision
public function deleteRevision(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$order = Revision::find($request->id);
$order->delete();
return back()->withInput()->with('success', trans('revision has been deleted'));


}

//delete revision
public function updateRevision(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$order = Revision::find($request->id);
$order->instructions =$request->instructions; 
$order->save();
return back()->withInput()->with('success', trans('revision has been updated'));


}

//confirm order
public function confirmOrder(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$order = Order::find($request->id);
$amount = $order->ccost;
if($amount <= 0){

  return back()->with('error', 'order price not correct contact support for the quote');

}

$user  = User::find($order->user_id);
$wallet_bal = wallet($order->user_id);

if($wallet_bal< $amount){

  $amount = $amount - $wallet_bal;

  $data = [
    'callback_url'         => url('/'),
    'order_id'             => $request->id,
    'amount'               => $amount,
    'user_id'              => $user->id,
    'payment_source'       => 'Wallet TopUp',
    'pay_reason'           => 'checkout',
    'currency'             => 2,

  ];

  $pay_created = Payment::create($data);
  session()->put('order_id', $order->id);

  if(get_option(site_id().'_payment_option') == 'external'){

    //send payment data

    $order = Order::find($pay_created->order_id);
           //API URL
    $pay_site = get_option(site_id().'_pay_site');
    $url=$pay_site."/spay?payment_id=".$pay_created->id."&amount=".$pay_created->amount."&domain_name=".domain_name()."&scallback_url=".route('success_deposit', $pay_created->id)."&ccallback_url=".route('view_order', $order->slug );

    return redirect($url);


  } else{
    return redirect(url('cpay/'.$pay_created->id))->with('success', 'Insufficient funds, topup your account');
  }


}

else{

  if($order->status == '0'){


      //deduct amount from wallet

    $wallet_bal      = $wallet_bal-$amount;

      //change status
    $order->status         = 1;
    $order->save();



    //record trasaction

    $data = [
      'callback_url'         => url('/'),
      'order_id'             => $order->id,
      'amount'               => $amount,
      'balance'              => $wallet_bal,
      'user_id'              => $user->id,
      'user_id'              => $user->id,
      'payment_source'       => 'Wallet Deduction',
      'pay_reason'           => 'checkout',
      'currency'             => 2,
      'status'             => 1,

    ];

    $pay_created = Payment::create($data);




    $users = User::whereUserType('writer')->whereAccountStatus(1)->get();
    foreach ($users as $key => $user) {
 //send email
      $data=array(
        'name' =>$user->name,
        'email'=>$user->email,
        'sname'=>'Hi '.$user->name.', New order #'.$order->id. ' has been posted',
        'description'=>'Hi '.$user->name.', New order #'.$order->id. ' has been posted, login to your www.'.domain_name().'.com account and place a bid',

      );


      //send email to agent
      Mail::send('email.index',$data, function($message) use ($data){
        $message->to($data['email']);
        $message->subject($data['sname']);

      }); 
    }

    if($order->preferred_writer > 0){
      $user = User::find($order->preferred_writer);
         //send email
      $data=array(
        'name' =>$user->name,
        'email'=>$user->email,
        'sname'=>'Hi '.$user->name.', client has made a request you work on order #'.$order->id,
        'description'=>'Hi '.$user->name.', client has made a request you work on order #'.$order->id. '  if you are available login to your www.'.domain_name().' account and accept the order',

      );


      //send email to agent
      Mail::send('email.index',$data, function($message) use ($data){
        $message->to($data['email']);
        $message->subject($data['sname']);

      }); 

    }


    return back()->withInput()->with('success', trans('Updated successfully'));

  }

  else{


    if(Auth::user()->id == 3 or Auth::user()->id == 5){


    //deduct amount from wallet

      $wallet_bal      = $wallet_bal-$amount;

      //change status
      $order->payment_way         = 0;
      $order->save();

      $data = [
        'callback_url'         => url('/'),
        'order_id'             => $order->id,
        'amount'               => $order->ccost,
        'user_id'              => $user->id,
        'payment_source'       => 'Pay Later',
        'pay_reason'           => 'checkout',
        'balance'           => $wallet_bal,
        'currency'             => 2,
        'status'             => 1,

      ];

      $pay_created = Payment::create($data);

    // if($order->preferred_writer > 0){

    //   $user = User::find($order->preferred_writer);
    //      //send email
    //   $data=array(
    //     'name' =>$user->name,
    //     'email'=>$user->email,
    //     'sname'=>'Hi '.$user->name.', client has made a request you work on order #'.$order->id,
    //     'description'=>'Hi '.$user->name.', client has made a request you work on order #'.$order->id. '  if you are available login to your www.'.domain_name().' account and accept the order',

    //   );


    //   //send email to agent
    //   Mail::send('email.index',$data, function($message) use ($data){
    //     $message->to($data['email']);
    //     $message->subject($data['sname']);

    //   }); 
      

    // }

      return back()->withInput()->with('success', trans('Payment made successfully'));

    }



  }


}

}


//confirm order
public function confirmInvoice(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$order = Invoice::find($request->id);
$amount = $order->total;
if($amount <= 0){
  return back()->with('error', 'invoice price not correct contact support for the quote');
}
$user  = User::find($order->user_id);
$wallet_bal = wallet($order->user_id);
if($wallet_bal< $amount){

  $amount = $amount - $wallet_bal;

  $data = [
    'callback_url'         => url('/'),
    'order_id'             => $request->id,
    'invoice_id'           => $order->id,
    'amount'               => $amount,
    'user_id'              => $user->id,
    'payment_source'       => 'custom invoice',
    'pay_reason'           => 'invoice',
    'currency'             => 2,

  ];

  $pay_created = Payment::create($data);
  return redirect(url('cpay/'.$pay_created->id))->with('success', 'Insufficient funds, topup your account');

}

else{
      //deduct amount from wallet

  $wallet_bal      = $wallet_bal-$amount;
  $user->wallet    = $wallet_bal;
  $user->save();

      //change status
  $order->status         = 1;
  $order->save();





  $data = [

    'callback_url'         => url('/'),
    'order_id'             => $request->id,
    'invoice_id'           => $order->id,
    'amount'               => $amount,
    'user_id'              => $user->id,
    'balance'              => $wallet_bal,
    'payment_source'       => 'custom invoice wallet deduction',
    'pay_reason'           => 'invoice',
    'status'               => 1,
    'currency'             => 2,

  ];

  $pay_created = Payment::create($data);



  return back()->withInput()->with('success', trans('Payment made successfully'));


}

}


//update order status

public function changeStatusApplication(Request $request){
 $application = Application::find($request->order_id);
 $application->status = $request->status;
 $application->save();

 $user = User::find($application->user_id);
 if($request->status == 1) {
   $user->applicant = 2;
   $user->save();
 }

  if($request->status == 2) {

   $user->applicant = 2;
   $user->save();

 }


 return back()->withInput()->with('success', trans('Updated successfully'));

}



//update order status

public function changeStatus(Request $request){


  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


if(Auth::user()->is_admin() or Auth::user()->is_client() or Auth::user()->is_editor() or Auth::user()->is_writer() or Auth::user()->is_subadmin()){



  $order = Order::find($request->order_id);
  $order->status     = $request->status;
  if ($request->status=='4') {
    $mytime = Carbon::now();
    $completed_at =  $mytime->toDateTimeString();
    $order->completed_at     = $completed_at; 
  }

  if ($request->status=='5') {
    $order->payments      = 1; 
    $order->epayments     = 1;

    $activity = "Order ".$order->id." has been approved by ".Auth::user()->id;
    \LogActivity::addToLog($activity);

  }

  if ($request->status=='1') {
    $order->writer_id  = 0; 
    $order->writer_confirm= 0;
  }


  $order->save();

  if ($request->status=='4') {
    $user = User::find($order->user_id);


    $activity = "Order ".$order->id." has been marked completed by ".Auth::user()->id;
    \LogActivity::addToLog($activity);

//send sms
    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Your order #'.$request->order_id. ' has been completed',
      'description'=>'New order #'.$request->order_id. ' has been completed, login to your www.'.domain_name().' account to download the files',

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 


  //send sms
    $recipients = $user->phone;
    $message    = 'Your order #'.$request->order_id. ' has been completed, login to your www.'.domain_name().' account to download the files';
    sendsms($recipients,$message);
  }


  if ($request->status=='8') {
    $user = User::find($order->writer_id);

//send sms
    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Hi '.$user->name.', order #'.$request->order_id. ' need correction',
      'description'=>'Hi '.$user->name.', order #'.$request->order_id. ' need correction, login to your www.'.domain_name().'.com account for more info',

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 


  //send sms
    $recipients = $user->phone;
    $message    = 'Hi '.$user->name.', order #'.$request->order_id. ' need correction, login to your www.'.domain_name().'.com account for more info';
    sendsms($recipients,$message);
  }

  if ($request->status=='1') {

    $users = User::whereUserType('writer')->whereAccountStatus(0)->get();
    foreach ($users as $key => $user) {
 //send email
      $data=array(
        'name' =>$user->name,
        'email'=>$user->email,
        'sname'=>'Hi '.$user->name.', New order has been posted',
        'description'=>'Hi '.$user->name.', New order #'.$request->order_id. ' has been posted, login to your www.'.domain_name().'.com account and place a bid',

      );


      //send email to agent
      Mail::send('email.index',$data, function($message) use ($data){
        $message->to($data['email']);
        $message->subject($data['sname']);

      }); 
    }

    if($order->preferred_writer > 0){
      $user = User::find($order->preferred_writer);
         //send email
      $data=array(
        'name' =>$user->name,
        'email'=>$user->email,
        'sname'=>'Hi '.$user->name.', client has made a request you work on order #'.$order->id,
        'description'=>'Hi '.$user->name.', client has made a request you work on order #'.$order->id. '  if you are available login to your www.'.domain_name().' account and accept the order',

      );


      //send email to agent
      Mail::send('email.index',$data, function($message) use ($data){
        $message->to($data['email']);
        $message->subject($data['sname']);

      }); 

    }


  }


  if ($request->status=='3') {
    if ($order->editor_id) {
     $user = User::find($order->editor_id);
     $activity = "Order ".$order->id." has been submitted for editing by ".Auth::user()->id;
     \LogActivity::addToLog($activity);
//send sms
     $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Hi '.$user->name.', order #'.$request->order_id. ' has been submitted for editing',
      'description'=>'Hi '.$user->name.', order #'.$request->order_id. ' has been submitted for editing, login to your www.'.domain_name().'.com account to review it',

    );


      //send email to agent
     Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 


  //send sms
     $recipients = $user->phone;
     $message    = 'Hi '.$user->name.', order #'.$request->order_id. ' has been submitted for editing, login to your www.'.domain_name().'.com account to review it';
     sendsms($recipients,$message);
   }

   else{
    if($order->ecost > '0'){
      $users = User::whereUserType('editor')->get(); 
      foreach ($users as $key => $user) {


       $data=array(
        'name' =>$user->name,
        'email'=>$user->email,
        'sname'=>'Hi '.$user->name.', order #'.$request->order_id. ' has been submitted for editing',
        'description'=>'Hi '.$user->name.', order #'.$request->order_id. ' has been submitted for editing, if you are available now login to your www.'.domain_name().'.com account to pick and review it',

      );

      //send email to editors
       Mail::send('email.index',$data, function($message) use ($data){
        $message->to($data['email']);
        $message->subject($data['sname']);

      }); 




     }

   }
 }



}

return back()->withInput()->with('success', trans('Updated successfully'));
} else{
  return back()->withInput()->with('error', trans('Access restricted'));
}

}

//update order status

public function changePaymentWay(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$order = Order::find($request->order_id);
$order->payment_way     = $request->payment_way;
$order->status     = 1;
$order->save();



$users = User::whereUserType('writer')->whereAccountStatus(1)->get();
foreach ($users as $key => $user) {
 //send email
  $data=array(
    'name' =>$user->name,
    'email'=>$user->email,
    'sname'=>'Hi '.$user->name.', New order has been posted',
    'description'=>'Hi '.$user->name.', New order #'.$request->order_id. ' has been posted, login to your www.'.domain_name().' account and place a bid',

  );


      //send email to agent
  Mail::send('email.index',$data, function($message) use ($data){
    $message->to($data['email']);
    $message->subject($data['sname']);

  }); 
}

if($order->preferred_writer > 0){
  $user = User::find($order->preferred_writer);
         //send email
  $data=array(
    'name' =>$user->name,
    'email'=>$user->email,
    'sname'=>'Hi '.$user->name.', client has made a request you work on order #'.$order->id,
    'description'=>'Hi '.$user->name.', client has made a request you work on order #'.$order->id. '  if you are available login to your www.'.domain_name().' account and accept the order',

  );


      //send email to agent
  Mail::send('email.index',$data, function($message) use ($data){
    $message->to($data['email']);
    $message->subject($data['sname']);

  }); 

}




return back()->withInput()->with('success', trans('Updated successfully'));

}

//assign editor

public function assignEditor(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$order = Order::find($request->order_id);
$order->editor_id             = $request->editor_id;
$order->save();



  //get writer

$user = User::find($request->editor_id);

//send sms
$data=array(
  'name' =>$user->name,
  'email'=>$user->email,
  'sname'=>'New order #'.$request->order_id. ' has been assigned to you to assign the writer',
  'description'=>'New order #'.$request->order_id. ' has been assigned to you to assign the writer',

);


      //send email to agent
Mail::send('email.index',$data, function($message) use ($data){
  $message->to($data['email']);
  $message->subject($data['sname']);

}); 


  //send sms
$recipients = $user->phone;
$message    = 'New order #'.$request->order_id. ' has been assigned to you to assign the writer, login to your account for more info www.'.domain_name().'.com';
sendsms($recipients,$message);

return back()->withInput()->with('success', trans('Order assigned to editor successfully'));

}

//update order status

public function changeStatusAssign(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$order = Order::find($request->order_id);


if($order->order_level == 'technical'){

  $order->preferred_writer = $request->writer_id;
  $order->ccost = $request->amount;
  $order->save();

  $amount = $request->amount;
      //start

  $user  = User::find($order->user_id);
  $wallet_bal = wallet($user->id);

  if($wallet_bal< $amount){

    $amount = $amount - $wallet_bal;

    $data = [
      'callback_url'         => url('/'),
      'order_id'             => $request->id,
      'amount'               => $amount,
      'user_id'              => $user->id,
      'payment_source'       => 'Wallet TopUp',
      'pay_reason'           => 'checkout',
      'currency'             => 2,

    ];

    $pay_created = Payment::create($data);
    session()->put('order_id', $order->id);
    return redirect(url('cpay/'.$pay_created->id))->with('success', 'Insufficient funds, topup your account');

  }

  else{





      //deduct amount from wallet

    $data = [
      'order_id'             => $order->id,
      'amount'               => $amount,
      'user_id'              => $user->id,
      'payment_source'       => 'Order paid',
      'pay_reason'           => 'checkout',
      'currency'             => 2,
      'status'                 =>1,

    ];
    $pay_created = Payment::create($data);



    if($pay_created){
         //change status
      $order->status         = 2;
      $order->writer_id  = $request->writer_id;
      $order->save();


      $activity = "client assigned ".$order->id." to ".$request->writer_id;
      \LogActivity::addToLog($activity);



      $user = User::find($request->writer_id);
         //send email
      $data=array(
        'name' =>$user->name,
        'email'=>$user->email,
        'sname'=>'Hi '.$user->name.', client has accepted your bid for Order No. '.$order->id,
        'description'=>'Hi '.$user->name.', client has accepted your bid for Order No. '.$order->id. ' please login to your www.'.domain_name().' account and accept the order',

      );


      //send email to agent
      Mail::send('email.index',$data, function($message) use ($data){
        $message->to($data['email']);
        $message->subject($data['sname']);

      }); 




      return back()->withInput()->with('success', trans('Payment made successfully'));
    }


  }



}




else{

  $order->status       = 2;
  $order->writer_id    = $request->writer_id;
  $order->assigned_by  = Auth::user()->name.'('.Auth::user()->user_type.')';
  $order->save();

  $activity = "Admin assigned ".$order->id." to ".$request->writer_id;
  \LogActivity::addToLog($activity);

  //get writer
  if($request->writer_id){

    $user = User::find($order->writer_id);

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'New order #'.$request->order_id. ' has been assigned to you',
      'description'=>'New order #'.$request->order_id. ' has been assigned to you',

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 


  //send sms
    $recipients = $user->phone;
    $message    = 'New order #'.$request->order_id. ' has been assigned to you, login to your account for more info www.'.domain_name();
    sendsms($recipients,$message);

  }



  return back()->withInput()->with('success', trans('Order assigned successfully'));
}



}




//upload order file
public function fileUpload(Request $req){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$user_id  = Auth::user()->id;
$req->validate([
 'file' => 'required|mimes:csv,txt,xlx,xls,pdf,docx,doc,png,jpeg,pptx,zip,rar,xlsx|max:100048'
]);

if($req->file()) {


$timestamp = date('Y-m-d_H-i-s'); 
$fileName = $req->order_id . '_' . $timestamp . '_' . $req->file->getClientOriginalName();


 $file =  $req->file('file');
 $filePath = 'uploads/'.$fileName;
 $is_uploaded = current_disk()->put($filePath, file_get_contents($file));

 if ($is_uploaded) {

   $fileModel = new Upload;
   $fileModel->name = $req->order_id.'_'.$req->file->getClientOriginalName();
   $fileModel->upload_storage = get_option(site_id().'_default_storage');
   $fileModel->order_id = $req->order_id;

   if($req->upload_type==5){
     $order = Order::find($req->order_id);
     $user_id = User::find($order->user_id)->id;
     $fileModel->user_id = $user_id;
   }

   else{
     $fileModel->user_id = $user_id;
     $fileModel->upload_type = $req->upload_type;
   }

   if(get_option(site_id().'_default_storage') == 'public') {
    $fileModel->file_path = get_option(site_id().'_main_site_url').'/storage/' . $filePath;
  } else{
   $is_uploaded = Storage::disk('public')->put($filePath, file_get_contents($file));
   $fileModel->file_path = 'https://awasam.s3.amazonaws.com/'.$filePath;
 }
 


 $fileModel->save();

 $order = Order::find($req->order_id);
 $order->plagiarism_score = $req->plagiarism_score;
 $order->save();
 return back()
 ->with('success','File has been uploaded.')
 ->with('file', $fileName);
}
else{
  return back()->withInput()->with('error', trans('file has not been uploaded'));
}



}
}

public function payments(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$user  = Auth::user();

if ($user->is_admin() or $user->is_subadmin()){
  $payments = Payment::orderBy('id', 'desc')->whereStatus(1)->paginate(500);

  if ($request->user_id){
    $payments = Payment::whereUserId($request->user_id)->orderBy('id', 'desc')->whereStatus(1)->paginate(500);

  }


}

if ($user->is_client()){
  $payments = Payment::whereUserId($user->id)->whereStatus(1)->orderBy('id', 'desc')->paginate(1000);

}

if ($user->is_student()){
  $payments = Payment::whereUserId($user->id)->whereStatus(1)->orderBy('id', 'desc')->paginate(50);

}

return view('admin.payments', compact('payments')); 


}


public function customInvoices(Request $request){
  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}
$user  = Auth::user();

if ($user->is_admin()){

  $invoices = Invoice::orderBy('id', 'desc')->whereInvoiceType('custom')->paginate(20);

}
if ($user->is_client()){
  $invoices = Invoice::whereUserId($user->id)->whereInvoiceType('custom')->orderBy('id', 'desc')->paginate(20);

}

if ($user->is_student()){
  $invoices = Invoice::whereUserId($user->id)->whereInvoiceType('custom')->orderBy('id', 'desc')->paginate(20);

}

return view('admin.custom_invoices', compact('invoices')); 


}

      //create custom invoice
public function cinvoice(Request $request)
{

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$order = Order::find($request->order_id);
$user_id  = $order->user_id;
$slug = 'in-'.time().Str::random(6);

$data = [

  'slug'            => $slug,
  'total'           => $request->amount,
  'order_id'        => $request->order_id,
  'comments'        => $request->item_name,
  'user_id'         => $user_id,
  'invoice_type'    => 'custom',
  'currency'    => $request->currency,

];



$pay_created = Invoice::create($data);

if($pay_created){

  $data = [
    'invoice_id'  => $pay_created->id,
    'service_name'      => $request->item_name,
    'amount'        => $request->amount,
    'currency'       => Auth::user()->currency_sign,
    'user_id'       => $user_id,

  ];

  $pay_created = Iservice::create($data);


  return redirect(route('custom_invoices'))->with('success', trans('invoice created'));
}
else{
  return back()->withInput()->with('error', trans('something went wrong'));
}




}


      //create service
public function addService(Request $request)
{

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$user_id  = Auth::user()->id;
$data = [
  'invoice_id'     => $request->invoice_id,
  'service_name'  => $request->service_name,
  'amount'        => $request->amount,
  'currency'      => $request->currency,
  'user_id'       => $user_id,
  
];

$pay_created = Iservice::create($data);

return back()->withInput()->with('success', trans('invoice created'));


}


      //create service
public function aaddService(Request $request)
{

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$user_id  = Auth::user()->id;
$data = [
  'post_id'     => $request->post_id,
  'name'       => $request->name,
  'description' => $request->description,
  
];

$pay_created = Service::create($data);

return back()->withInput()->with('success', trans('service created'));


}





//editor payments
public function epayments(Request $request){


  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$editor_id  = Auth::user()->id;
$payments = Order::whereEditorId($editor_id)->whereEpayments('1')->whereEditorPaid('unpaid')->orderBy('id', 'desc')->paginate(20);


if($request->status){
 $payments = Order::whereEditorId($editor_id)->whereEpayments($request->status)->whereEditorPaid('unpaid')->orderBy('id', 'desc')->paginate(20);
}

return view('admin.epayments', compact('payments')); 


}

//writer payments
public function wpayments(Request $request){


  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$writer_id  = Auth::user()->id;
$payments = Order::whereWriterId($writer_id)->whereStatus('5')->whereWriterPaid('unpaid')->wherePayments('1')->orderBy('id', 'desc')->paginate(20);


if($request->status){

 $payments = Order::whereWriterId($writer_id)->whereStatus('5')->whereWriterPaid('unpaid')->wherePayments($request->status)->orderBy('id', 'desc')->paginate(20, ['*'], 'status');
}

return view('admin.wpayments', compact('payments')); 


}



 //add funds
public function addFund(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}


$user_id  = Auth::user()->id;

$data = [
  'callback_url'         => url('/'),
  'amount'               => $request->amount,
  'user_id'              => $user_id,
  'payment_source'       => 'wallet topup',
  'pay_reason'           => 'wallet topup',
  'currency'             => 2,

];

$pay_created = Payment::create($data);
return redirect(url('cpay/'.$pay_created->id))->with('success', 'order submitted successfully');

}

public function pagesSetting(Request $request){
  $pages = Page::all();
  $site_id = $request->site_id;

  return view('admin.pages_setting', compact('pages', 'site_id')); 


}


 //add funds
public function balanceAccount(Request $request){

  $user = Auth::user();

    //verify admin
  if($user->is_admin()){
   if($user->active_status == 0){

    $data=array(
      'name' =>$user->name,
      'email'=>$user->email,
      'sname'=>'Here is your activation code '.$user->activation_code,
      'description'=>'Find your activation code '.$user->activation_code,

    );


      //send email to agent
    Mail::send('email.index',$data, function($message) use ($data){
      $message->to($data['email']);
      $message->subject($data['sname']);

    }); 

    \LogActivity::addToLog('Activation code request');
    return redirect(route('activate_code'))->with('error', trans('verify your account'));
  }
  
}

$users = User::whereUserType('client')->get();
$debit_total = 0;
$credit_total = 0;
$total = 0;

foreach ($users as $key => $user) {

  $user_id       = $user->id;
  $wallet_bal    = $user->wallet;


  $debit_total1 = Payment::whereUserId($user_id)->whereStatus('1')->wherePaymentSource('Order paid')->sum('amount');
  $debit_total2 = Payment::whereUserId($user_id)->whereStatus('1')->wherePaymentSource('Pay Later')->sum('amount');
  $debit_total3 = Payment::whereUserId($user_id)->whereStatus('1')->wherePaymentSource('custom invoice')->sum('amount');
  $debit_total4 = Payment::whereUserId($user_id)->whereStatus('1')->wherePaymentSource('Wallet Deduction')->sum('amount');


  $debit_total =  $debit_total1 +  $debit_total2 +  $debit_total3 +  $debit_total4;

  $credit_total1 = Payment::whereUserId($user_id)->whereStatus('1')->wherePaymentSource('TopUp Wallet')->sum('amount');
  $credit_total2 = Payment::whereUserId($user_id)->whereStatus('1')->wherePaymentSource('Wallet TopUp')->sum('amount');
  $credit_total3 = Payment::whereUserId($user_id)->whereStatus('1')->wherePaymentSource('Admin Wallet TopUp')->sum('amount');

  $credit_total = $credit_total1 + $credit_total2 + $credit_total3;



  $x =0;

  $diff = $credit_total - $debit_total;


  $x    =  $wallet_bal -  $diff;

  $amount = $x;


  $data = [

    'callback_url'         => url('/'),
    'amount'               => $amount,
    'user_id'              => $user_id,
    'status'               => '1',
    'balance'              => $wallet_bal,
    'payment_source'       => 'account balancing',
    'pay_reason'           => 'account balancing',
    'currency'             => 2,

  ];

  $pay_created = Payment::create($data);

}

return back()->withInput()->with('success', trans('Account balanced successfully'));


}



}
