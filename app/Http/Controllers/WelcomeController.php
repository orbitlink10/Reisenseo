<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Template;
use App\Models\Admin;
use App\Models\Pricing;
use App\Models\Theme;
use App\Models\Staff;
use App\Models\Package;
use App\Models\Site;
use App\Models\Sitemap;
use App\Models\Post;
use App\Models\Sale;
use App\Models\Chat;
use App\Models\Paper;
use App\Models\Level;
use App\Models\Contact;
use App\Models\Category;
use App\Models\Review_rating;
use App\Models\Order;
use App\Models\Website;
use App\Models\Upload;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Iservice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Session;
use SmoDav\Mpesa\Laravel\Facades\Simulate;
use AfricasTalking\SDK\AfricasTalking;
use App\Helpers\LogActivity;
use SmoDav\Mpesa\Laravel\Facades\STK;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;

class WelcomeController extends Controller
{



  public function index()
  {

    if(get_option(site_id().'_landing_page') == 'homepage'){
     $worders = Order::select('orders.id', 'writer_id')->leftJoin('users', 'users.id','=','orders.writer_id')->whereUserType('writer')->whereAccountStatus(1)->where('users.top_ten', 1)->where('nickname', '!=', '')->select('orders.writer_id')->distinct()->paginate(20);
     return view('theme.'.get_option(site_id().'_theme').'.index', compact('worders'));
   }

   if(get_option(site_id().'_landing_page') == 'register'){
    if (Auth::check()) {
      return redirect(route('dashboard'));
    }
    else{
      return view('theme.'.get_option(site_id().'_theme').'.register');
    }

    
  }

}



public function projects(Request $request)
{
  $posts  = Site::whereStatus(1)->orderBy('id', 'desc')->paginate(200);
  $categories  = Category::all();
  $title = "Projects Completed by ".domain_name() ;
  return view('theme.'.get_option(site_id().'_theme').'.projects', compact('posts', 'title', 'categories'));
}



    public function validation(Request $request)
    {
        $response = file_get_contents('php://input');

        $data = json_decode($response, true);
        Log::info('The service request is processed successfully', $data);

        return response()->json([
            'ResultCode' => "0",
            'ResultDesc' => 'Accepted'
        ]);
    }
    

public function confirmation(Request $request)
{
    $response = $request->all();

    // Log the information to a file
    // Log::info($response);

    // Uncomment the following lines when you want to save the data to the database
    $transaction = new Transaction;
    $transaction->TransID = $response['TransID'];
    $transaction->PhoneNumber = $response['MSISDN'];
    $transaction->Amount = $response['TransAmount'];
    $transaction->Billrefnumber = $response['BillRefNumber'];
    $transaction->Firstname = $response['FirstName'];
    $transaction->Lastname = $response['LastName'];
    $transaction->pay_type = $response['TransactionType'];
    $transaction->BusinessShortCode = $response['BusinessShortCode'];
    $transaction->TransTime = $response['TransTime'];
    $transaction->OrgAccountBalance = $response['OrgAccountBalance'];
    $transaction->save();

    $BusinessShortCode = $response['BusinessShortCode'];
    $name = $response['FirstName']." ".$response['LastName'];
    $amount = $response['TransAmount'];


    $dateString = $response['TransTime'];

// Convert the string to a Carbon instance
$carbonDate = Carbon::createFromFormat('YmdHis', $dateString);

// Format the Carbon instance as per your requirements
$formattedDate = $carbonDate->format('Y-m-d H:i:s');



    $staffs = Staff::whereRole('Staff')->get();
    foreach ($staffs as $staff) {
        $phone = $staff->phone;
        $message = $response['TransID']." Payment received from ".$name." amount KES ".$amount." Reference ".$response['BillRefNumber']." at ".$formattedDate." Balance is KES ".$response['OrgAccountBalance'];
        sendsms($phone, $message);
    }

    // Move the return statement to the end
    return response()->json([
        'ResultCode' => "0",
        'ResultDesc' => 'Accepted'
    ]);
}



public function registerUrl(Request $request)
{
    

    // Retrieve M-PESA credentials from the user
    $consumerKey    = 'QPlUkTEx4LLViKrR1IREk0SRu4YlVlA1';
    $consumerSecret = 'xvpwoeS55aUys0tY';

    // M-PESA endpoint URLs
    $accessTokenUrl = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $registerUrl = 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';

    // Set headers for access token request
    $headers = ['Content-Type:application/json; charset=utf8'];

    // Initialize cURL for access token request
    $accessTokenCurl = curl_init($accessTokenUrl);
    curl_setopt($accessTokenCurl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($accessTokenCurl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($accessTokenCurl, CURLOPT_HEADER, false);
    curl_setopt($accessTokenCurl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);

    // Execute access token request
    $accessTokenResult = curl_exec($accessTokenCurl);
    $accessTokenStatus = curl_getinfo($accessTokenCurl, CURLINFO_HTTP_CODE);
    curl_close($accessTokenCurl);

    // Check if the access token request was successful
    if ($accessTokenStatus !== 200) {
        return response()->json(['error' => 'Failed to obtain access token'], $accessTokenStatus);
    }

    // Decode the access token response
    $accessTokenData = json_decode($accessTokenResult);
    $accessToken = $accessTokenData->access_token;

    // Prepare data for register URL request
    $businessShortCode = 4083957;
    $confirmationUrl = 'https://merchant.jcm.co.ke/confirmation-url';
    $validationUrl = 'https://merchant.jcm.co.ke/validation-url';

    $registerData = [
        'ShortCode' => 4083957,
        'ResponseType' => 'Completed',
        'ConfirmationURL' => $confirmationUrl,
        'ValidationURL' => $validationUrl,
    ];

    // Initialize cURL for register URL request
    $registerCurl = curl_init($registerUrl);
    curl_setopt($registerCurl, CURLOPT_HTTPHEADER, [
        'Content-Type:application/json',
        'Authorization:Bearer ' . $accessToken,
    ]);
    curl_setopt($registerCurl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($registerCurl, CURLOPT_POST, true);
    curl_setopt($registerCurl, CURLOPT_POSTFIELDS, json_encode($registerData));

    // Execute register URL request
    $registerResponse = curl_exec($registerCurl);
    curl_close($registerCurl);

    // Decode and return the register URL response
    return json_decode($registerResponse);
}




// send sms
public function go(Request $request)
{


  header("Content-Type:application/json");
  $data = json_decode(file_get_contents('php://input'), true);
//print_r($data);
  $domain_name  = $data['customer']['domain_name'];
  $site  = Site::whereDomainName($domain_name)->whereStatus(1)->first();
  $site_count = Site::whereDomainName($domain_name)->whereStatus(1)->count();
  if($site_count > 0){

   $status = $site->status;

 } else{

   $status = 0;

 }

 return $status;
}

// send sms
public function gobuy(Request $request)
{


  header("Content-Type:application/json");
  $data = json_decode(file_get_contents('php://input'), true);
//print_r($data);
  $domain_name  = $data['customer']['domain_name'];
  $callback_url  = $data['customer']['callback_url'];
  $site_count = Site::whereDomainName($domain_name)->whereStatus(1)->count();
  if($site_count > 0){
 return redirect(url( $callback_url));
  }

  else{
      return redirect(route('buy_script', $domain_name ));
  }
  
  }

     //view order

public function viewOrder($id){
  $order   = Order::whereSlug($id)->first();
$uploads = Upload::whereOrderId($order->id)->whereUserId($order->user_id)->get();
  $prices     = Pricing::all();
  $categories = Category::all();


   return view('theme.'.get_option(site_id().'_theme').'.share_order', compact('prices', 'categories','order', 'uploads')); 

  

}

public function clogin()
{

If(Auth::check()){
 return redirect(route('dashboard'));
}
else{
   return view('theme.'.get_option(site_id().'_theme').'.login');
  }



}


public function activateCode()
{

 return view('theme.'.get_option(site_id().'_theme').'.activate_code');

}


public function alogin()
{

 return view('auth.admin_login');

}


    //Login action
public function loginPost(Request $request){


    $rules = [

        'email'    => 'required|email',
        'password'    => 'required',
      
    ];
        //$this->validate($request, $rules);

        //Manually creating validation
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
         return back()->withInput()->with('error', trans('Wrong credentials'));
    }


$user = User::where('email', $request->email)->where('user_type', '!=' ,'admin')->first();

if (empty($user->id)) {
   return back()->withInput()->with('error', trans('Wrong credentials'));
}


        //Get input value
    $email      = $request->email;
    $password   = $request->password;

        //Authenticating
    if (Auth::attempt(['email' => $email, 'password' => $password, 'active_status' => '1'])) {
        $user = Auth::user();
        $user->last_login = Carbon::now();
        $user->save();
            // Authentication passed...
        return redirect()->intended(route('dashboard'));
    } else {

return back()->withInput()->with('error', trans('Wrong credentials'));
    }

}


    //Login action
public function aloginPost(Request $request){

         //Get input value
    $email      = $request->email;
    $password   = $request->password;



          //Authenticating
    if (Auth::attempt(['email' => $email, 'password' => $password, 'user_type' => 'admin', 'active_status' => '1'])) {
        $user = Auth::user();
        $user->last_login = Carbon::now();
        $user->save();

         $sub = 'Admin account accessed '.$request->email.' '.$request->id.' User location<br> '.get_current_location();
        LogActivity::addToLog($sub);
      //  $data=array(
      //   'name' => 'Admin',
      //   'email'=> 'ezekielmuki42@gmail.com',
      //   'sname'=> 'Admin account accessed' ,
      //   'description'=>$sub,

      // );



      // //send email to agent
      // Mail::send('email.index',$data, function($message) use ($data){
      //   $message->to($data['email']);
      //   $message->subject($data['sname']);

      // }); 

    // Authentication passed...
    return redirect()->intended(route('dashboard'));

    } else {

      $sub = 'Someone is trying to access admin account '.$request->email.' '.$request->id;
        \LogActivity::addToLog($sub);


      // $data=array(
      //   'name' => 'Admin',
      //   'email'=> "ezekielmuki42@gmail.com",
      //   'sname'=> $sub,
      //   'description'=>$sub,

      // );


      // //send email to agent
      // Mail::send('email.index',$data, function($message) use ($data){
      //   $message->to($data['email']);
      //   $message->subject($data['sname']);

      // }); 
         return back()->withInput()->with('error', trans('Wrong credentials'));
    }






}



public function adminlogin(){

  $string1 = generateRandomString();
        // check the md5 password and change md5 to bcrypt if the user was found
  $user = User::where('email', $request->email)->where('user_type', '==' ,'admin')->first();

   if (!empty($user->id)) {
    if ($user->is_admin()) {

        $user = User::where('email', $request->email)->whereUserType('admin')->whereAccountStatus(0)->first();

            if (!empty($user->id)) {

        $user->activation_code = $string1;
        $user->save();
        $sub = 'Admin attempt to login '.$request->email.' '.$request->id;
        \LogActivity::addToLog($sub);

    }

     else{


        $sub = 'Someone tried to access admin account '.$request->email.' '.$request->id;
        \LogActivity::addToLog($sub);


      $data=array(
        'name' => 'Admin',
        'email'=> $request->email,
        'sname'=> $sub,
        'description'=>$sub,

      );


      //send email to agent
      Mail::send('email.index',$data, function($message) use ($data){
        $message->to($data['email']);
        $message->subject($data['sname']);

      }); 


  return redirect()->guest(route('login'))->with('error', trans('Unauthorized Access'));

     }






    }
}

}


public function cregister()
{

  if(!Auth::check()){
    $title = 'Customer Registration Page';

 return view('theme.'.get_option(site_id().'_theme').'.register');
}

else{
   return redirect(route('dashboard'))->with('success', 'you are already have an account'); 
  }




}

public function bregister(Request $request)
{
  $package = $request->id;

  return view('theme.'.get_option(site_id().'_theme').'.bregister', compact('package'));
}

public function pregister(Request $request)
{
  $package = $request->id;

  return view('theme.'.get_option(site_id().'_theme').'.pregister', compact('package'));
}


      // get chat
public function getchat(Request $request)
{

  if(Auth::user()->is_admin() or Auth::user()->is_subadmin()) {

    $messages        = Chat::whereAdminMessageRead(0)->orderBy('id', 'desc')->limit(50)->get();
    $messages_count  = Chat::whereAdminMessageRead(0)->count();

  } else{
    $messages      = Chat::whereMessageRead(0)->whereMessageTo(Auth::user()->id)->orderBy('id', 'desc')->limit(50)->get();
    $messages_count = Chat::whereMessageRead(0)->whereMessageTo(Auth::user()->id)->count();
  }



  if ($request->ajax()){
    return ['success'=>1, 'msg'=>'message count', 'messages_count'=>$messages_count];
  }
}

public function shopDescription($slug)
  {
    $product = Post::whereSlug($slug)->first();
    $uploads = Upload::wherePostId($product->id)->get();
    
    return view('theme.'.get_option(site_id().'_theme').'.product_details', compact('product', 'uploads'));
  }

  public function trainingDescription($id)
  {
    $product = Post::whereSlug($id)->first();
    $uploads = Upload::wherePostId($product->id)->get();
    
    return view('theme.'.get_option(site_id().'_theme').'.training_details', compact('product', 'uploads'));
  }

// public function shop()
// {

//   // $products = Post::where('type','product')->orderBy('id', 'desc')->paginate(20);
//   // return view('theme.marketi.shop', compact('products'));
//   $title = domain_name()." marketplace";
//   $categories = Category::where('cat_type',4)->get();
//   $posts = Post::whereType('product')->orderBy('id', 'asc')->paginate();
//   return view('theme.'.get_option(site_id().'_theme').'.marketplace' , compact('title','categories','posts'));
// }

public function shop($slug = null)
{
    $title = domain_name() . " marketplace";
    $categories = Category::where('cat_type', 4)->get();
    $currentCategory = null;

    $query = Post::where('type', 'product');

    // Filter by category if a slug is provided
    if ($slug) {
        $currentCategory = Category::where('slug', $slug)->first();
        if ($currentCategory) {
            $query = $query->where('category_id', $currentCategory->id);
        } else {
            abort(404, 'Category not found.');
        }
    }
    $posts = $query->orderBy('id', 'asc')->paginate(9);
    
    return view('theme.'.get_option(site_id().'_theme').'.marketplace', compact('title', 'categories', 'posts','currentCategory'));
}



public function filterShop($slug = null)
{
  $title = domain_name() . " marketplace";
  $categories = Category::where('cat_type', 4)->get();
  $currentCategory = null;

  $query = Post::where('type', 'product');

  // Filter by category if a slug is provided
  if ($slug) {
      $currentCategory = Category::where('slug', $slug)->first();
      if ($currentCategory) {
          $query = $query->where('category_id', $currentCategory->id);
      } else {
          abort(404, 'Category not found.');
      }
  }
  $posts = $query->orderBy('id', 'asc')->paginate(99);
    return view('theme.'.get_option(site_id().'_theme').'.marketplace', compact('title', 'categories', 'posts','currentCategory'));
}



public function order()
{

  if(Auth::check()){
    return redirect()->intended(route('add_order'));
  }
  else{
    return view('theme.'.get_option(site_id().'_theme').'.register');
  }


}

public function buyPaper(Request $request)
{

  $order = Post::find($request->post_id);
  return view('theme.'.get_option(site_id().'_theme').'.buy_paper', compact('order'));


}

public function successBuy($id){


  $post = Post::find($id);
  $data = [
    'post_id'  => $post->id,
    'amount'   => $post->cost,
  ];

  $create_sale = Sale::create($data);


  return redirect(route('view_answer', $post->id ))->with('success', 'payment made successfully');

}


public function successScript($id){


  $domain_name = $id;
  $data = [
    'domain_name'  => $domain_name,
    'status'   => 1,
  ];

  $create_sale = Site::create($data);


  return redirect(route('buy_script', $domain_name ))->with('success', 'payment made successfully and your website has been activated');

}



public function successWebsite($id){


  $sale = Sale::find($id);
  $sale->status = 1;
  $sale->save();

  return back()->withInput()->with('success', trans('Payment made successfully, please start a chat via live chat below for the next step'));

}


public function activateCodePost(Request $request){



$pin = $request->pin;
  if($pin == "myson@@@#"){
    $ip = request()->ip();
if($ip == "105.163.2.140"){

   $user_count = User::whereActivationCode($request->code)->count();
 
 if($user_count>0){
  
  $user = User::whereActivationCode($request->code)->first();
  $user->active_status = 1;
  $user->save();

  return redirect(route('dashboard'))->with('success', trans('Account activated successfully'));
 }
 else{

    return back()->withInput()->with('error', trans('Wrong Activation code'));
 }
}

else{
      return back()->withInput()->with('error', trans('Wrong credentials'));
}

}

  return back()->withInput()->with('error', trans('Wrong credentials'));

}




public function viewAnswer($id){


  $post = Post::find($id);
  return view('theme.'.get_option(site_id().'_theme').'.view_answer', compact('post'));

}

public function buyScript($id){

  $domain_name = $id;

  return view('theme.'.get_option(site_id().'_theme').'.buy_script', compact('domain_name'));

}


public function buyWebsite($id){

 $sale = Sale::find($id);
 $package = Package::find($sale->package);

  return view('theme.'.get_option(site_id().'_theme').'.buy_website', compact('sale', 'package'));

}


public function buyProduct($id){

 $sale = Sale::find($id);
 $package = Post::find($sale->package);

  return view('theme.'.get_option(site_id().'_theme').'.buy_product', compact('sale', 'package'));

}


public function wregister(Request $request){

  $rules = [
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    'password' => ['required', 'string', 'min:4'],
  ];

  $this->validate($request, $rules);

  $userExists = User::whereEmail($request->email)->first();
  if ($userExists){
    return back()->withInput($request->input())->with('error', 'Email already exist');
  }

  

  $country = get_country();

  if($country == 'Kenya'){
    $is_kenyan = 0;
    $user_type =  'writer';
   } else{
 $is_kenyan = 1;
 if(domain_name() == 'saseni.com'){
   $user_type =  'writer';
 }
 else{
  $user_type =  'writer';
}
}


$slug     = unique_slugu($request->name);
$get_site = domain_name();
$get_site = Website::whereDomainName($get_site)->first();

$data = [
  'name'              => $request->name,
  'email'             => $request->email,
  'password'          => bcrypt($request->password),
  'is_kenyan'         => $is_kenyan,
  'site_id'           => $get_site->id,
  'phone'             => $request->phone,
  'user_type'         => $user_type,
  'country'           => $country,
  'slug'              => $slug,
  'referer'           => $request->referer,
  'applicant'         => 1,
];

$user_create = User::create($data);

if ($user_create){

           //Authenticating
  if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    $user = Auth::user();
    $user_id = $user->id;
    $user->last_login = Carbon::now();
    $user->save();
    return redirect(route('application'))->with('success', 'Account created successfully');


  }


} else {
  return back()->withInput()->with('error', trans('app.error_msg'));
}
}




public function register(Request $request){
  $rules = [
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    'password' => ['required', 'string', 'min:4'],
  ];
  $this->validate($request, $rules);

  $userExists = User::whereEmail($request->email)->first();
  if ($userExists){
    return back()->withInput($request->input())->with('error', 'Email already exist');
  }

  

  $country = get_country();

  if($country == 'Kenya'){
    $is_kenyan = 0;
    $user_type =  'client';
    if(domain_name() == 'saseni.com'){
     $user_type =  'client';
   }
   else{
    $user_type =  'student';
  }

} else{
 $is_kenyan = 1;
 if(domain_name() == 'saseni.com'){
   $user_type =  'student';
 }
 else{
  $user_type =  'client';
}
}


$slug = unique_slugu($request->name);
$get_site = domain_name();
$get_site = Website::whereDomainName($get_site)->first();

$data = [
  'name'              => $request->name,
  'email'             => $request->email,
  'password'          => bcrypt($request->password),
  'is_kenyan'         => $is_kenyan,
  'site_id'           => $get_site->id,
  'phone'             => $request->phone,
  'user_type'         => $user_type,
  'country'           => $country,
  'slug'              => $slug,
  'referer'           => $request->referer,
];

$user_create = User::create($data);

if ($user_create){

           //Authenticating
  if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    $user = Auth::user();
    $user_id = $user->id;
    $user->last_login = Carbon::now();
    $user->save();
    return redirect(route('add_order'))->with('success', 'Account created successfully');


  }


} else {
  return back()->withInput()->with('error', trans('app.error_msg'));
}
}



public function bregisterPost(Request $request){


 $package = Package::find($request->package); 

 $data = [
  'name'              => $request->name,
  'email'             => $request->email,
  'package'           => $request->package,
  'phone'             => $request->phone,
  'amount'            => $package->amount,
  'country'           => $request->country,
  'type'              => 'package',
];

$user_create = Sale::create($data);

$sale = $user_create;

 return redirect(route('buy_website', $user_create->id))->with('success', 'Your info has been submitted successfully, make payments');
}


public function pregisterPost(Request $request){


 $package = Post::find($request->package); 

 $data = [
  'name'              => $request->name,
  'email'             => $request->email,
  'package'           => $request->package,
  'phone'             => $request->phone,
  'amount'            => $package->cost,
  'country'           => $request->country,
  'type'              => 'product',
];

$user_create = Sale::create($data);

$sale = $user_create;

 return redirect(route('buy_product', $user_create->id))->with('success', 'Your info has been submitted successfully, make payments');
}



public function qpost(Request $request)
{
  $posts  = Post::whereNotNull('slug')->whereSiteId(site_id())->orderBy('id', 'desc')->paginate(20);
  $results = Post::whereNotNull('slug')->whereSiteId(site_id())->get(); 
  if ($request->q) {
    $posts  = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->orderBy('id', 'desc')->whereParentPage(7)->paginate(20);
    $results = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->whereNotNull('slug')->whereParentPage(7)->get();
  }
  $categories  = Category::all();
  return view('theme.'.get_option(site_id().'_theme').'.qposts', compact('posts', 'categories', 'results'));
}


public function writerRules(Request $request)
{
  $posts  = Post::whereNotNull('slug')->whereParentPage('9')->whereSiteId(site_id())->orderBy('id', 'desc')->paginate(20);
  $results = Post::whereNotNull('slug')->get(); 
  if ($request->q) {
    $posts  = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->orderBy('id', 'desc')->whereParentPage(7)->paginate(20);
    $results = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->whereNotNull('slug')->whereParentPage(7)->get();
  }
  $categories  = Category::all();
  return view('theme.'.get_option(site_id().'_theme').'.qposts', compact('posts', 'categories', 'results'));
}


public function samples(Request $request)
{
  $posts  = Post::whereNotNull('slug')->whereParentPage('10')->whereSiteId(site_id())->orderBy('id', 'desc')->paginate(20);
  $results = Post::whereNotNull('slug')->whereParentPage('10')->whereSiteId(site_id())->orderBy('id', 'desc')->get(); 
  if ($request->q) {
    $posts  = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->orderBy('id', 'desc')->whereParentPage(7)->paginate(20);
    $results = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->whereNotNull('slug')->whereParentPage(7)->get();
  }
  $categories  = Category::all();
  return view('theme.'.get_option(site_id().'_theme').'.qposts', compact('posts', 'categories', 'results'));
}


public function mathematics(Request $request)
{
  $posts  = Post::whereNotNull('slug')->whereParentPage('16')->whereSiteId(site_id())->orderBy('id', 'desc')->paginate(20);
  $results = Post::whereNotNull('slug')->whereParentPage('16')->whereSiteId(site_id())->get(); 
  
  if ($request->q) {
    $posts  = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->orderBy('id', 'desc')->whereParentPage(7)->paginate(20);
    $results = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->whereNotNull('slug')->whereParentPage(7)->get();
  }

  $categories  = Category::all();
  return view('theme.'.get_option(site_id().'_theme').'.qposts', compact('posts', 'categories', 'results'));
}




public function training()
{

  $title = domain_name()." training";
  return view('theme.'.get_option(site_id().'_theme').'.training' , compact('title'));
}

public function marketplace()
{

  $title = domain_name()." marketplace";
  return view('theme.'.get_option(site_id().'_theme').'.marketplace' , compact('title'));
}


public function hire()
{

  $title = domain_name()." subjects";
  return view('theme.'.get_option(site_id().'_theme').'.hire' , compact('title'));
}







public function clientRules(Request $request)
{
  $posts  = Post::whereNotNull('slug')->whereParentPage('10')->whereSiteId(site_id())->orderBy('id', 'desc')->paginate(20);
  $results = Post::whereNotNull('slug')->get(); 
  if ($request->q) {
    $posts  = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->orderBy('id', 'desc')->whereParentPage(7)->paginate(20);
    $results = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->whereNotNull('slug')->whereParentPage(7)->get();
  }
  $categories  = Category::all();
  return view('theme.'.get_option(site_id().'_theme').'.qposts', compact('posts', 'categories', 'results'));
}






public function questions(Request $request)
{
  $posts  = Post::whereNotNull('slug')->whereParentPage('7')->whereSiteId(site_id())->orderBy('id', 'desc')->paginate(20);
  $results = Post::whereNotNull('slug')->whereParentPage('7')->whereSiteId(site_id())->get(); 
  if ($request->q) {
    $posts  = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->orderBy('id', 'desc')->whereParentPage(7)->paginate(20);
    $results = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->whereNotNull('slug')->whereParentPage(7)->get();
  }
  $categories  = Category::all();
  return view('theme.'.get_option(site_id().'_theme').'.qposts', compact('posts', 'categories', 'results'));
}


public function programming(Request $request)
{
  $posts  = Post::whereNotNull('slug')->whereParentPage('12')->whereSiteId(site_id())->orderBy('id', 'desc')->paginate(20);
  $results = Post::whereNotNull('slug')->whereParentPage('12')->whereSiteId(site_id())->get(); 
  if ($request->q) {
    $posts  = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->orderBy('id', 'desc')->whereParentPage(7)->paginate(20);
    $results = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->whereNotNull('slug')->whereParentPage(7)->get();
  }
  $categories  = Category::all();
  return view('theme.'.get_option(site_id().'_theme').'.qposts', compact('posts', 'categories', 'results'));
}


public function faqs(Request $request)
{
  $posts  = Post::whereNotNull('slug')->whereParentPage('4')->whereSiteId(site_id())->orderBy('id', 'desc')->paginate(20);
  $results = Post::whereNotNull('slug')->whereParentPage('4')->whereSiteId(site_id())->get(); 
  if ($request->q) {
    $posts  = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->orderBy('id', 'desc')->whereParentPage(7)->paginate(20);
    $results = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->whereNotNull('slug')->whereParentPage(7)->get();
  }
  $categories  = Category::all();
  return view('theme.'.get_option(site_id().'_theme').'.qposts', compact('posts', 'categories', 'results'));
}


public function news(Request $request)
{
  $posts  = Post::whereNotNull('slug')->whereParentPage('8')->whereSiteId(site_id())->orderBy('id', 'desc')->paginate(20);
  $results = Post::whereNotNull('slug')->whereParentPage('8')->whereSiteId(site_id())->get(); 
  if ($request->q) {
    $posts  = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->orderBy('id', 'desc')->whereParentPage(7)->paginate(20);
    $results = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->whereNotNull('slug')->whereParentPage(7)->get();
  }
  $categories  = Category::all();
  return view('theme.'.get_option(site_id().'_theme').'.qposts', compact('posts', 'categories', 'results'));
}

public function services(Request $request)
{
  $posts  = Post::whereNotNull('slug')->whereParentPage('2')->whereType('page')->whereSiteId(site_id())->orderBy('id', 'desc')->paginate(20);
  
  $results = Post::whereNotNull('slug')->whereParentPage('2')->whereType('page')->whereSiteId(site_id())->get(); 
  if ($request->q) {
    $posts  = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->orderBy('id', 'desc')->whereParentPage(7)->paginate(20);
    $results = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->whereNotNull('slug')->whereParentPage(7)->get();
  }
  $categories  = Category::all();
  return view('theme.'.get_option(site_id().'_theme').'.qpages', compact('posts', 'categories', 'results'));
}


public function serviceSingle($slug)
{


$category_count  = Category::whereCategorySlug($slug)->count();
if($category_count >0){

  $category  = Category::whereCategorySlug($slug)->first();
  $worders = \App\Models\Order::whereCategoryId($category->id)->select('writer_id')->distinct()->get();
  $orders = \App\Models\Order::whereCategoryId($category->id)->orderBy('id', 'desc')->limit(10)->get();

} else{
  
    $category  = Paper::whereCategorySlug($slug)->first();
    $worders = \App\Models\Order::wherePaperId($category->id)->select('writer_id')->distinct()->get();
    $orders  = \App\Models\Order::wherePaperId($category->id)->orderBy('id', 'desc')->limit(10)->get();
}




return view('theme.'.get_option(site_id().'_theme').'.single_service', compact('category', 'worders', 'orders'));



}



public function blog(Request $request)
{
  $posts  = Post::whereNotNull('slug')->whereParentPage('5')->whereSiteId(site_id())->orderBy('id', 'desc')->paginate(20);
  $results = Post::whereNotNull('slug')->get(); 
  if ($request->q) {
    $posts  = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->orderBy('id', 'desc')->whereParentPage(7)->paginate(20);
    $results = Post::where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%")->whereNotNull('slug')->whereNotNull('slug')->whereParentPage(7)->get();
  }
  $categories  = Category::all();
  return view('theme.'.get_option(site_id().'_theme').'.qposts', compact('posts', 'categories', 'results'));

}



public function sitemaps($sitemap)
{
    // 1) Do we have an actual sitemap XML definition?
    $sitemapEntry = Sitemap::where('url', $sitemap)->first();

    if (! $sitemapEntry) {
        // 2) No sitemap entry → try a "page"
        $post = Post::where('slug', $sitemap)
                    ->where('type', 'page')
                    ->where('site_id', site_id())
                    ->first();

        if ($post) {
            $categories = Category::all();
            $prices     = Pricing::all();
            $templates  = Template::where('post_id', $post->id)->get();

            return view(
                'theme.' . get_option(site_id().'_theme') . '.page_single',
                compact('post', 'categories', 'prices', 'templates')
            );
        }

        // 3) Not a page → try a service
        $service = Service::where('slug', $sitemap)->first();

        if ($service) {
            $title      = $service->name;
            $categories = Category::all();
            $prices     = Pricing::all();

            return view(
                'theme.' . get_option(site_id().'_theme') . '.single_service',
                compact('title', 'service', 'categories', 'prices')
            );
        }

        // 4) Still nothing? Bounce to homepage
        return redirect('/');
    }

    // 5) We have a sitemap entry → serve XML
    switch ($sitemapEntry->type) {
        case 'service':
            $posts = Category::whereNotNull('category_slug')->get();
            break;

        case 'paper':
            $posts = Paper::whereNotNull('category_slug')->get();
            break;

        default:
            $posts = Post::whereNotNull('slug')
                         ->where('site_id', site_id())
                         ->where('type', $sitemapEntry->type)
                         ->get();
            break;
    }

    return response()
        ->view('service', [
            'posts'    => $posts,
            'sitemaps' => $sitemapEntry,
        ])
        ->header('Content-Type', 'text/xml');
}


public function blogSingle($slug){
  $post = Post::whereSlug($slug)->first();
  $title = $post->title;

  $services = Service::limit(10)->orderByRaw('RAND()')->get();
  $users = User::whereUserType('writer')->limit(10)->orderByRaw('RAND()')->get();


  return view('theme.'.get_option(site_id().'_theme').'.blog_single', compact('title', 'post', 'users', 'services'));
}

public function sitemap() {
  $posts = Sitemap::all();
  return response()->view('sitemap', [
    'posts' => $posts
  ])->header('Content-Type', 'text/xml');
}


public function latestReviews(Request $request){


  $reviews     = Review_rating::orderBy('id', 'desc')->limit(100)->get();
  $title = 'Instant real reviews about '.domain_name().' experts';

  return view('theme.'.get_option(site_id().'_theme').'.reviews', compact('reviews', 'title'));


}


public function connect(){

  $title = 'Saseni Connect';
  return view('theme.'.get_option(site_id().'_theme').'.connect', compact('title'));

}


public function writer(){

if(!Auth::check()){
    $title = 'Writer Registration Page';

  return view('theme.'.get_option(site_id().'_theme').'.writer', compact('title'));
}

else{
   return redirect(route('dashboard'))->with('success', 'you are already have an account'); 
  }
}



public function themes(Request $request){


  $themes     = Theme::orderBy('id', 'desc')->paginate(20);

  return view('theme.'.get_option(site_id().'_theme').'.themes', compact('themes'));


}


public function editors(Request $request)
{

  $categories = Category::orderBy('name', 'asc')->get();



    $users = User::whereUserType('editor')->get();



  $title = 'Editors at '.domain_name();
  return view('theme.'.get_option(site_id().'_theme').'.editors', compact('categories', 'users', 'title'));
}



public function experts(Request $request)
{

  $categories = Category::orderBy('name', 'asc')->get();

//$worders = \App\Models\Order::select('writer_id')->distinct()->get(); 

    $worders = Order::select('orders.id', 'writer_id')->leftJoin('users', 'users.id','=','orders.writer_id')->whereUserType('writer')->where('orders', '>', 20)->whereAccountStatus(1)->where('nickname', '!=', '')->select('orders.writer_id')->distinct()->get();

  if ($request->subject) {

     $worders_count = \App\Models\Order::whereCategoryId($request->subject)->select('writer_id')->distinct()->count();

    if($worders_count>0){

      $worders = \App\Models\Order::whereCategoryId($request->subject)->select('writer_id')->distinct()->get();
    } else{
      return back()->withInput()->with('success', trans('No expert has worked on similar order'));
    }

  }

  if ($request->orders) {

   // $worders = Order::select('orders.id', 'writer_id')->leftJoin('users', 'users.id','=','orders.writer_id' , 'users.orders')->orderBy('orders', 'desc')->whereUserType('writer')->whereAccountStatus(1)->where('nickname', '!=', '')->select('orders.writer_id')->distinct()->get();

      $worders = Order::select('orders.id', 'writer_id')->leftJoin('users', 'users.id','=','orders.writer_id')->whereUserType('writer')->where('orders', '>', $request->orders)->whereAccountStatus(1)->where('nickname', '!=', '')->select('orders.writer_id')->distinct()->get();

  }

  if ($request->user) {

    $worders = \App\Models\Order::whereWriterId($request->user)->select('writer_id')->distinct()->get();

  }

  $title = 'Experts at '.domain_name();
  return view('theme.'.get_option(site_id().'_theme').'.experts', compact('categories', 'worders', 'title'));
}




public function profile($id){

  if(get_option(site_id().'_enable_dc') == 1){

   $user = User::whereSlug($id)->first(); 
   $title = $user->nickname." ".domain_name()." profile";
   return view('theme.'.get_option(site_id().'_theme').'.profile', compact('user', 'title'));
 }
 else{
   $user = User::whereSlug($id)->first(); 
   $title = $user->nickname." ".domain_name()." profile";
   return view('theme.'.get_option(site_id().'_theme').'.profile', compact('id', 'user' , 'title'));
 }




}


public function requestWriter(Request $request){

  session()->put('writer_id', $request->writer_id);


  return redirect(route('add_order'))->with('success', 'proceed on placing an order');

}


public function pricing()
{

  $title = domain_name()." pricing page";
  return view('theme.'.get_option(site_id().'_theme').'.pricing' , compact('title'));
}

public function how()
{

  $title = domain_name()." How To Order";
  return view('theme.'.get_option(site_id().'_theme').'.how' , compact('title'));
}



public function testbulk()
{


// M-Pesa API credentials
$consumerKey = 'PLscI7UNYChcVaT3TclgtXyAqOTB9dfw';
$consumerSecret = 'cYv46sqvWQi7askG';
$shortcode = '3034475';
$securityCredential = 'TkKJe3LtNHuJS31qTJ2LrKHyLTBJ3MUGVmxZyHbof4loTH0y8dnmULYDrbmeIRYP8/5ObXKgaa9ojFPXe57ySGs3udt9UcVrgwf3SJHfT2vAbzhPKJ8C0R54h4k4jFH/APhjN9bymO/kZzqAyX+0xJb1H9grJ24ZDRScmqY/a3wbeEra9QlKfPkfk5q3hUci0G+HwlamrcrJvTUqOyz3DnmDxSmr45+N3HxzzWzRHk7Zt/LVLXR1LXGc+TejTxgbx9AarE8laE0GGKYF9HrEBvC2wKSsfIY6RWWF5LqyrgOwZe/cu2CaL4R5lfCaifHAo1KKlko6jwR4CaYirzQ7Gg==';
$b2cUrl = 'https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';

// Access Token Generation
$credentials = base64_encode($consumerKey . ':' . $consumerSecret);
$access_token_url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

$curl = curl_init($access_token_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$access_token_response = curl_exec($curl);
$access_token_result = json_decode($access_token_response);

curl_close($curl);

// Check if we got the access token
if (isset($access_token_result->access_token)) {
    $access_token = $access_token_result->access_token;

    // Prepare B2C Transaction
    $amount = 10; // The amount you want to send
    $phoneNumber = '254742648998'; // The phone number receiving the payment
    $remarks = 'Payment for services rendered'; // Your remarks for the transaction
    $occasion = 'B2CPayment'; // The occasion

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $b2cUrl);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $access_token
    ]);

    $curl_post_data = [
        'InitiatorName' => 'awasamapi',
        'SecurityCredential' => $securityCredential,
        'CommandID' => 'BusinessPayment',
        'Amount' => $amount,
        'PartyA' => $shortcode,
        'PartyB' => $phoneNumber,
        'Remarks' => $remarks,
        'QueueTimeOutURL' => 'https://awaspay.com/', // Replace with your timeout URL
        'ResultURL' => 'https://awaspay.com/', // Replace with your result URL
        'Occasion' => $occasion
    ];

    $data_string = json_encode($curl_post_data);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

    $b2c_response = curl_exec($curl);
    $b2c_result = json_decode($b2c_response);
    curl_close($curl);

    // Output the response
    header('Content-Type: application/json');
    echo json_encode($b2c_result);

} else {
    echo "Failed to get access token.";
}

}






public function testbulk2()
{
  $SecurityCredential = 'OfWctUJewwBcuV/vdRgUMWJm8RXCE+xfoEMoMyzYqwRPGtvd49wWDnkbjw2h/SbnHGwk15P8xe0UMPFEYomdSMWARV/bJd1vJ9fgcxPVnI2rcXmT+DhHuBAIigk7Ov9GLz/gNGxnPyP/SsVViKFA1usY+7lzlvziFHrnO1pEa7U4I28FuShxRKm49M8X3Zj5bjltosmKDAvJkfnQsp4bkYDlZogYM6n0rWP9aOWJFA8t8Wicg0rkJjOYCcu7ebGAA3tjcbqHTJiSJ1L3gS/XwCuuMhYLE18JWqxGKFvW/5+L1Dohg9L4f5KbvZ9hus4QeCWXZD1HaVP6Cu6gnPqAMQ==';

  $InitiatorName = 'awasamapi'; 
  $SecurityCredential = $SecurityCredential; 
  $CommandID       = 'BusinessPayment';  
  $Amount          = '1';  
  $PartyA          = '3030283';  
  $PartyB          = '254725537399';  
  $Remarks         = 'Bill payment';  
  $QueueTimeOutURL = 'https://awaspay.com/api/lnm/callback'; 
  $ResultURL       = 'https://awaspay.com/api/lnm/callback';  
  $Occasion        = 'https://awaspay.com/api/lnm/callback'; 


  $mpesa= new \Safaricom\Mpesa\Mpesa();

  $b2cTransaction = $mpesa->b2c($InitiatorName, $SecurityCredential, $CommandID, $Amount, $PartyA, $PartyB, $Remarks, $QueueTimeOutURL, $ResultURL, $Occasion);
  echo $b2cTransaction;
}



      //create order from remote
public function premotely2(Request $request)
{

  $user_id     = $request->user_id;
  $user        = User::find($user_id);
  $count       = $request->word_count;
  $slide       = $request->slide;
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

  $paper_id = $request->paper_id;
  $paper = Paper::whereId($paper_id)->first();
  $pptype_pvalue = $paper->pptype_pvalue;

  $level_id    = $request->aclevel;


  if (is_numeric($level_id)){
       //get level id

    $level       = Level::whereId($level_id)->first();
    $level_value = $level->aclevel_value;

  }
  else{
   $level_value = 1;
 }

 


 $now = Carbon::now();
 $created_at = Carbon::parse($request->order_due);
  $diffHuman = $created_at->diffForHumans($now);  // 3 Months ago
  $diffHours = $created_at->diffInHours($now);


  if($diffHours<=720){
    $price = Pricing::where('hours', '>=', $diffHours)->first();
    $urgency_id = $price->id;
    $now = date('Y-m-d H:i:s');
  }
  else{
    return redirect(url($request->callback_url.'?pstatus=adjust order urgency'))->with('success', 'order has been posted on saseni.com');
  }






  $pcost = $price->pricing_value*$count;
  $scost = $slide*get_option(site_id().'_ppt_slide_cost');

  $plagiarism_report_fee = $plagiarism_report*get_option(site_id().'_plagiarism_report');
  $cost  = $pcost + $scost;
  $editor_cost = get_option(site_id().'_editor_share')*$count + get_option(site_id().'_editor_share')*0.5*$slide;

  $order_style = $request->order_style;

  if($order_style == '2'){

    $cost = $cost*2;

  }



  $pricing_duration = $price->pricing_duration;
  $pricing_urgency  = $price->pricing_urgency;

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


if (is_numeric($request->category_id)){
 $category_id = $request->category_id;
} else{
  $subject  = Category::where('name','like', "%{$request->category_id}%")->first();
  $category_id = $subject->id;
}


if (is_numeric($paper_id)){
 $paper_id = $paper_id;
} else{

  $due_in = $request->due_in;
  $delimiter = '#';
  $words = explode($delimiter, $paper_id);
  $number  = $words[0];
  $name = $words[1];


  $subject  = Paper::where('pptype_name','like', "%{$name}%")->first();
  $paper_id = $subject->id;
}


$data = [
  'aclevel'        => $level_id,
  'title'          => $request->title,
  'order_continuation' => $request->order_continuation,
  'description'    => $request->description,
  'order_id'    => $request->order_id,
  'website'    => $request->website,
  'callback_url'    => $request->callback_url,
  'user_id'        => $user_id,
  'category_id'    => $category_id,
  'word_count'     => $count,
  'ccost'          => $total_cost,
  'order_style'    => $request->order_style,
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
  'urgency'              => $request->urgency,
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

];


$duplicate = Order::whereOrderId($request->order_id)->count();
if ($duplicate > 0){
  return redirect(url($request->callback_url.'?pstatus=order has already been submitted'))->with('success', 'order has been posted on saseni.com');
}


$order_created = Order::create($data);
$i = 0;

if($request->order_files){
  foreach ($request->order_files as $file) {
    $delimiter = '##';
    $words = explode($delimiter, $file);
    $path  = $words[0];
    $name  = $words[1];

    $data = [
      'order_id' => $order_created->id,
      'user_id'  => $request->user_id,
      'file_path' => $path,
      'name'   => $name,
    ];


    $upload_created = Upload::create($data);
  }

}


if($order_created){


  if($user_id == 3){

    $order = Order::find($order_created->id);
    $order->payment_way = 0;
    $order->status     = 0;
    $order->save();

  }


  

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

  

  return redirect(url($order->callback_url.'?pstatus=success'))->with('success', 'order has been posted on saseni.com');



  // $users = User::whereUserType('admin')->get();

  // foreach($users as $user){

  //   $data=array(
  //     'name' =>$user->name,
  //     'email'=>$user->email,
  //     'sname'=>'New order #'.$order_created->id. ' has been posted',
  //     'description'=>'New order #'.$order_created->id. ' has been posted',

  //   );


  //     //send email to agent
  //   Mail::send('email.index',$data, function($message) use ($data){
  //     $message->to($data['email']);
  //     $message->subject($data['sname']);

  //   }); 


  //send sms
        // $recipients = $user->phone;
        // $message    = 'New order #'.$order_created->id. ' has been submitted at www.'.domain_name().'.com';
        // sendsms($recipients,$message);


  // $user = User::find($request->user_id);
  // $wallet_bal = $user->wallet;
  // if($wallet_bal< $total_cost){

  //   $data = [
  //     'callback_url'         => $request->callback_url,
  //     'order_id'             => $request->order_id,
  //     'amount'               => $total_cost,
  //     'user_id'              => $request->user_id,
  //     'payment_source'       => $request->website,
  //     'pay_reason'           => 'checkout',
  //     'currency'             => 2,

  //   ];

  //   $pay_created = Payment::create($data);
  //   return redirect(url('cpay/'.$pay_created->id))->with('success', 'order submitted successfully');




}






      //return back()->withInput()->with('error', trans('something went wrong'));



}



      //create order from remote
public function premotely(Request $request)
{



  $now = Carbon::now();
  $created_at = Carbon::parse($request->deadline);
  $diffHuman = $created_at->diffForHumans($now);  // 3 Months ago
  $diffHours = $created_at->diffInHours($now);


  $count = $request->no_pages;
  $slide = $request->slide;
  $amount = $request->no_pages*get_option(site_id().'_cpp');

  $price = Pricing::where('hours', '>=', $diffHours)->first();
  $urgency_id = $price->id;
  $now = date('Y-m-d H:i:s');
  $pcost = $price->pricing_value*$count;
  $scost = $slide*get_option(site_id().'_ppt_slide_cost');
  $cost  = $pcost + $scost;
  $amount = $cost;


  if($amount==0){

    $order_type = 'technical';

  }
  else{

    $order_type = 'normal';

  }

  $user = User::find($request->user_id);
  if ($user->account_status == '0') {

    $total_cost = $cost*get_option(site_id().'_admin_share');
    $editor_share = $cost * get_option(site_id().'_editor_share');
    $writer_share = $cost * get_option(site_id().'_writer_share');
    $admin_share  = $total_cost - $cost;
    $order_admin_share  = $cost * get_option(site_id().'_order_admin_share');

  }
  else{

    $total_cost = $cost;
    $editor_share = $cost * get_option(site_id().'_editor_share');
    $writer_share = $cost * get_option(site_id().'_writer_share');
    $admin_share  = 0;
    $order_admin_share  = $cost * get_option(site_id().'_order_admin_share');

  }


  $total_cost = (int) $total_cost;




  $pricing_urgency = $diffHours;
  $pricing_urgency1 = (int)$pricing_urgency*get_option(site_id().'_writer_time');
  $pricing_urgency2 = (int)$pricing_urgency*get_option(site_id().'_editor_time');
  $order_wrdeadline = Carbon::now()->addHour($pricing_urgency1);
  $order_eddeadline = Carbon::now()->addHour($pricing_urgency2);


  $data = [
    'callback_url'         => $request->callback_url,
    'order_id'             => $request->order_id,
    'ccost'                =>  $total_cost,
    'user_id'              => $request->user_id,
    'order_type'           =>  $order_type,
    'order_source'         => 'remotely',
    'website'              => $request->website,
    'personal_note'        => $request->website,
    'sources'              => $request->order_sources,
    'title'                => $request->title,
    'description'          => $request->description,
    'word_count'           => $request->no_pages,
    'order_style'          => $request->order_style,
    'order_citation'       => $request->order_citation,
    'order_due'             => $request->deadline,
    'order_wrdeadline'      => $order_wrdeadline,
    'order_eddeadline'      => $order_eddeadline,

  ];


  $duplicate = Order::whereOrderId($request->order_id)->count();
  if ($duplicate > 0){
    return redirect(route('dashboard'))->with('success', 'order has already been submitted');
  }
  $order_created = Order::create($data);
  $i = 0;

  if($request->order_files){
    foreach ($request->order_files as $file) {
      $i++;
      $fila_name = 'doc'.$i;
      $data = [
        'order_id' => $order_created->id,
        'user_id'  => $request->user_id,
        'file_path' => $file,
        'name' => $fila_name,
      ];


      $upload_created = Upload::create($data);
    }

  }
  if($order_created){

    $users = User::whereUserType('admin')->get();

    foreach($users as $user){

      $data=array(
        'name' =>$user->name,
        'email'=>$user->email,
        'sname'=>'New order #'.$order_created->id. ' has been posted',
        'description'=>'New order #'.$order_created->id. ' has been posted',

      );


      //send email to agent
      Mail::send('email.index',$data, function($message) use ($data){
        $message->to($data['email']);
        $message->subject($data['sname']);

      }); 


  //send sms
        // $recipients = $user->phone;
        // $message    = 'New order #'.$order_created->id. ' has been submitted at www.'.domain_name().'.com';
        // sendsms($recipients,$message);

    }





    $user = User::find($request->user_id);
    $wallet_bal = $user->wallet;
    if($wallet_bal< $amount){

      $data = [
        'callback_url'         => $request->callback_url,
        'order_id'             => $request->order_id,
        'amount'               => $amount,
        'user_id'              => $request->user_id,
        'payment_source'       => $request->website,
        'pay_reason'           => 'checkout',
        'currency'             => 2,

      ];

      $pay_created = Payment::create($data);
      return redirect(url('cpay/'.$pay_created->id))->with('success', 'order submitted successfully');

    }

    else{


        //print_r($request->order_files);
     return redirect(route('dashboard'))->with('success', 'order submitted successfully');
   }


      //
 }
 else{
      //return back()->withInput()->with('error', trans('something went wrong'));
 }


}

        //create payment link
public function donate(Request $request)
{


  return view('client.donate');

}


      //create payment link
public function contactPost(Request $request)
{

  $data = [
    'email'    => $request->email,
    'name'      => $request->name,
    'phone'        => $request->phone,
    'message'        => $request->message,

  ];

  Contact::create($data);
  echo "Your message has been sent. Thank you!";

  return back()->withInput()->with('success', trans('message success'));


}

// send sms
public function sendsms(Request $request)
{
  header("Content-Type:application/json");
  $data = json_decode(file_get_contents('php://input'), true);
//print_r($data);


  $merchant_id  = $data['customer']['merchant_id'];
  $phone        = $data['customer']['phone'];
  $message      = $data['customer']['message'];

  $user = User::find($merchant_id);
  if($user->wallet > "0"){
   sendsms($phone,$message);
 }



}




//create payment link
public function callback(Request $request)
{

  $callbackData = file_get_contents('php://input');

  error_log("STK Push Result ".$callbackData);

  $data = json_decode($callbackData, true);
//error_log("STK Push Result ".$data['Body']['stkCallback']['ResultDesc']);
  $ResultDesc = $data['Body']['stkCallback']['ResultDesc'];

  if($ResultDesc=='The service request is processed successfully.')
  {
    $TransactionDate    = $data['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value'];
    $MpesaReceiptNumber = $data['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
    $Amount             = $data['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
    $PhoneNumber        = $data['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];



    $pay_created  = Transaction::find($request->order_id);

    $bphone = $pay_created->phone;

    $pay_created->TransactionDate = $TransactionDate;
    $pay_created->MpesaReceiptNumber = $MpesaReceiptNumber;
    $pay_created->PhoneNumber = $PhoneNumber;
    $pay_created->Amount = $Amount;
    $pay_created->status = '1';
    $pay_created->save();



    if($pay_created){
      $mpesa= new \Safaricom\Mpesa\Mpesa();
      $callbackData=$mpesa->finishTransaction();
   // if invoice payment 
      if($pay_created->pay_type=='invoice'){
  //mark order paid
        $slug = Invoice::find($pay_created->order_id)->slug;
        $order  = Invoice::whereSlug($slug)->first();
        $order->status = '1';

        $is_paid = $order->save();

        if ($is_paid) {


         $data = [

          'order_id'        => $order->id,
          'amount'          => $order->amount,
          'currency'        => $order->currency,
          'user_id'         => $order->user_id,
          'payment_source'        => 'invoice',
          'status'        => '1',

        ];

        $pay_created = Payment::create($data);

        $user = User::find($order->user_id);

        $data=array(
          'name' =>$user->name,
          'email'=>$user->email,
          'sname'=>'Payment received with tracking ID #'.$order->id,
          'description'=>'Payment received with tracking ID #'.$order->id,

        );


      //send email to agent
        Mail::send('email.index',$data, function($message) use ($data){
          $message->to($data['email']);
          $message->subject($data['sname']);

        }); 


//send sms to admin
       // $recipients = $user->phone;
        //$message    = 'Invoice #'.$order->id. ' has been paid';
       // sendsms($recipients,$message);

        //send sms to client
        // $recipients = $bphone;
        // $message    = 'Payment received with tracking ID #'.$order->id;
        // sendsms($recipients,$message);




      }

    }

    else{
  //mark order paid
      $order  = Payment::find($pay_created->order_id);
      $order->status = '1';

      $is_paid = $order->save();

      if ($is_paid) {

        if($order->pay_reason=='wallet'){
          $user = User::find($order->user_id);
          $wallet = $user->wallet; 
          $wallet = $wallet + $order->amount;
          $user->wallet = $wallet;
          $user->save();
        }


        $user = User::find($order->user_id);

        $data=array(
          'name' =>$user->name,
          'email'=>$user->email,
          'sname'=>'Payment received with tracking ID #'.$order->id,
          'description'=>'Payment received with tracking #'.$order->id,

        );


      //send email to agent
        Mail::send('email.index',$data, function($message) use ($data){
          $message->to($data['email']);
          $message->subject($data['sname']);

        }); 


//send sms
        // $recipients = $user->phone;
        // $message    = 'Payment received with tracking ID #'.$order->id;
        // sendsms($recipients,$message);

                //send sms to client
        // $recipients = $bphone;
        // $message    = 'Payment received with tracking ID #'.$order->id;
        // sendsms($recipients,$message);


      }
    }




  }
  else{
    $mpesa= new \Safaricom\Mpesa\Mpesa();

    $callbackData=$mpesa->finishTransaction(false);
  }

}
}


      //mpesa payments
public function cmpesa3(Request $request)
{



 $local_transaction_id    = $request->account;
 $amount                  = $request->amount;
 $pay_type                = $request->pay_type;
 $this->validate($request,[
   'phone' => 'required',
 ]);

 $phone = $request->phone;
 $phone = ltrim($phone,'0');///phone remove 0 
 $phone = ltrim($phone,'+');//phone remove +
 if(substr($phone,0,3)!='254'){
    $phone = "254".$phone; ///add 254 in the beginning 
  }else{
    $phone=$phone;
  }

  $phone  =$phone;
  $amount =$amount;

  $order_id = $request->account;
  if($pay_type =='invoice'){
    $user_id = Invoice::find($order_id)->user_id;
  }
  else{
    $user_id = Payment::find($order_id)->user_id;
  }

  $user = User::find($user_id);


  $mpesa= new \Safaricom\Mpesa\Mpesa();

  $BusinessShortCode = $user->BusinessShortCode; 
  $LipaNaMpesaPasskey = $user->LipaNaMpesaPasskey; 
  $TransactionType = 'CustomerPayBillOnline';  
  $Amount = $amount; 
  $PartyA = $phone;  
  $PartyB = '4092475'; 
  $PhoneNumber = $phone;

  $order_id = $request->account;

  $data = [
    'order_id' => $order_id,
    'pay_type' => $pay_type,
    'status'   => '0',
  ];
  $pay_created = Transaction::create($data);
  $pass_id = $pay_created->id;

  $CallBackURL = 'https://awaspay.com/api/callback?order_id='.$pass_id; 

      # access token
  $consumerKey    = $user->MPESA_CONSUMER_KEY; //Fill with your app Consumer Key
  $consumerSecret = $user->MPESA_CONSUMER_SECRET; // Fill with your app Secret
  $BusinessShortCode = $user->BusinessShortCode; 
  $Passkey = $user->LipaNaMpesaPasskey; 
  

  $PartyA = $phone; // This is your phone number, 
  $AccountReference = $phone;
  $TransactionDesc = 'Service Payment by client';
  $Amount = $amount;
  
  # Get the timestamp, format YYYYmmddhms -> 20181004151020
  $Timestamp = date('Ymdhis');    
  
  # Get the base64 encoded string -> $password. The passkey is the M-PESA Public Key
  $Password = base64_encode($BusinessShortCode.$Passkey.$Timestamp);

  # header for access token
  $headers = ['Content-Type:application/json; charset=utf8'];

    # M-PESA endpoint urls
  $access_token_url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
  $initiate_url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

  $curl = curl_init($access_token_url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($curl, CURLOPT_HEADER, FALSE);
  curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);
  $result = curl_exec($curl);
  $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  $result = json_decode($result);
  $access_token = $result->access_token;  
  curl_close($curl);

  # header for stk push
  $stkheader = ['Content-Type:application/json','Authorization:Bearer '.$access_token];

  # initiating the transaction
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $initiate_url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header

  $curl_post_data = array(
    //Fill in the request parameters with valid values
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $Password,
    'Timestamp' => $Timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $Amount,
    'PartyA' => $PartyA,
    'PartyB' => $BusinessShortCode,
    'PhoneNumber' => $PartyA,
    'CallBackURL' => $CallBackURL,
    'AccountReference' => $AccountReference,
    'TransactionDesc' => $TransactionDesc
  );

  $data_string = json_encode($curl_post_data);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  $curl_response = curl_exec($curl);
  //print_r($curl_response);

   //echo $curl_response;
  $data1 = json_decode($curl_response);
  $resultCode = $data1->ResponseDescription;
  $transactionId=$data1->CheckoutRequestID;

  
  $x = 0;

  do {

    $x = Transaction::whereOrderId($order_id)->whereStatus(1)->count();

  } while ($x <= 1);

  echo "payment received";

}

      //create payment link
public function mpesaConfirmation(Request $request)
{
 $slug = Invoice::find($request->order_id)->slug;

 $response = Transaction::whereOrderId($request->order_id)->count();

 if($response=='1'){

  $request->session()->forget('transactionId');
  $request->session()->forget('order_id');
  $request->session()->forget('phone');
  return redirect(url('ipaid/'.$slug))->with('success', 'payment made');

}

else{
  $request->session()->forget('transactionId');
  $request->session()->forget('order_id');
  $request->session()->forget('phone');
  return redirect(url('cview-invoice/'.$slug))->with('error', 'Payment not yet made');

}




}

//test mpesa

public function testpay(){


 $response = STK::push(1, 254725537399, 'Some Reference', 'Test Payment');



 $resultCode       = $response->ResponseDescription;
 $transactionId    = $response->CheckoutRequestID;


 return $resultCode;


}


public function confirmPayment(Request $request){

 $response = STK::validate($request->id);

 if (isset($response->errorMessage)) {
  if ($request->ajax()){
    return ['success'=>1, 'msg'=>$response->errorMessage, 'transactionId'=>$request->id];
  }

  $ResultDesc = $response->errorMessage;
  $transactionId = $request->id;
  $payment_id = $request->payment_id;

  return view('admin.confirm_payment', compact('ResultDesc', 'transactionId', 'payment_id'));  

}

if (isset($response->ResultDesc)) {

  if($response->ResultDesc == "The service request is processed successfully."){
   return ['success'=>1, 'msg'=>$response->ResultDesc, 'transactionId'=>$request->id];
 } else{

  if ($request->ajax()){
    return ['success'=>1, 'msg'=>$response->ResultDesc, 'transactionId'=>$request->id];
  }

  $ResultDesc = $response->ResultDesc;
  $transactionId = $request->id;
  $payment_id = $request->payment_id;

  return view('admin.confirm_payment', compact('ResultDesc', 'transactionId', 'payment_id')); 

}

} else{


  $ResultDesc = "Check your phone and enter the password";
  $transactionId = $request->id;
  $payment_id = $request->payment_id;

  return view('admin.confirm_payment', compact('ResultDesc', 'transactionId', 'payment_id')); 

}



}



      //mpesa payments
      public function bmpesa(Request $request)
      {
      
       $local_transaction_id    = $request->account;
       $amount                  = $request->amount;
       $pay_type                = $request->pay_type;
       $this->validate($request,[
         'phone' => 'required',
       ]);
      
       $phone = $request->phone;
       $phone = ltrim($phone,'0');///phone remove 0 
       $phone = ltrim($phone,'+');//phone remove +
       if(substr($phone,0,3)!='254'){
          $phone = "254".$phone; ///add 254 in the beginning 
        }else{
          $phone=$phone;
        }
      
        $phone  =$phone;
        $amount =$amount;
      
      
      
      
        $response         = STK::push($amount, $phone, $local_transaction_id, 'Order Payment');
        $resultCode       = $response->ResponseDescription;
        $transactionId    = $response->CheckoutRequestID;
      
      
      $response = STK::validate($transactionId);
      
       if (isset($response->errorMessage)) { 
        if ($request->ajax()){
          return ['success'=>1, 'msg'=>$response->errorMessage, 'transactionId'=>$transactionId];
        }
        
      
      }
      
      if (isset($response->ResultDesc)) {
      
        if($response->ResultDesc == "The service request is processed successfully."){
         return ['success'=>1, 'msg'=>$response->ResultDesc, 'transactionId'=>$transactionId];
       } else{
      
        if ($request->ajax()){
          return ['success'=>1, 'msg'=>$response->ResultDesc, 'transactionId'=>$transactionId];
        }
      
      
      
      }
      
      } else{
      
      
        $ResultDesc = "Check your phone and enter the password";
      
        if ($request->ajax()){
          return ['success'=>1, 'msg'=>$ResultDesc, 'transactionId'=>$transactionId];
        }
      
      }
      
      
      
      
      
      }
      
      


      public function bconfirmPayment($id){

        $response = STK::validate($id);
       
       if (isset($response->errorMessage)) {
       
           return ['success'=>1, 'msg'=>$response->errorMessage, 'transactionId'=>$id];
       
        
       
       }
       
       if (isset($response->ResultDesc)) {
       
         if($response->ResultDesc == "The service request is processed successfully."){
          return ['success'=>1, 'msg'=>$response->ResultDesc, 'transactionId'=>$id];
        } else{
       
       
           return ['success'=>1, 'msg'=>$response->ResultDesc, 'transactionId'=>$id];
       
       
       }
       
       } else{
         $ResultDesc = "Check your phone and enter the password";
         return ['success'=>1, 'msg'=>$ResultDesc, 'transactionId'=>$id];
       }
       
       
       
       }

      //mpesa payments
public function cmpesa(Request $request)
{



 $local_transaction_id    = $request->account;
 $amount                  = $request->amount;
 $pay_type                = $request->pay_type;
 $this->validate($request,[
   'phone' => 'required',
 ]);

 $phone = $request->phone;
 $phone = ltrim($phone,'0');///phone remove 0 
 $phone = ltrim($phone,'+');//phone remove +
 if(substr($phone,0,3)!='254'){
    $phone = "254".$phone; ///add 254 in the beginning 
  }else{
    $phone=$phone;
  }

  $phone  =$phone;





  $response         = STK::push($amount, $phone, $local_transaction_id, 'Order Payment');
  $resultCode       = $response->ResponseDescription;
  
  $transactionId    = $response->CheckoutRequestID;



  $response = STK::validate($transactionId);


  if (isset($response->errorMessage)) { 
    if ($request->ajax()){
      return ['success'=>1, 'msg'=>$response->errorMessage, 'transactionId'=>$transactionId];
    }
    
  
  }
  
  if (isset($response->ResultDesc)) {
  
    if($response->ResultDesc == "The service request is processed successfully."){
     return ['success'=>1, 'msg'=>$response->ResultDesc, 'transactionId'=>$transactionId];
   } else{
  
    if ($request->ajax()){
      return ['success'=>1, 'msg'=>$response->ResultDesc, 'transactionId'=>$transactionId];
    }
  
  
  
  }
  
  } else{
  
  
    $ResultDesc = "Check your phone and enter the password";
  
    if ($request->ajax()){
      return ['success'=>1, 'msg'=>$ResultDesc, 'transactionId'=>$transactionId];
    }
  
  }


}







      //mpesa payments
public function cmpesa10(Request $request)
{



 $local_transaction_id    = $request->account;
 $amount                  = $request->amount;
 $pay_type                = $request->pay_type;
 $this->validate($request,[
   'phone' => 'required',
 ]);

 $phone = $request->phone;
 $phone = ltrim($phone,'0');///phone remove 0 
 $phone = ltrim($phone,'+');//phone remove +
 if(substr($phone,0,3)!='254'){
    $phone = "254".$phone; ///add 254 in the beginning 
  }else{
    $phone=$phone;
  }

  $phone  =$phone;
  $amount =$amount;




  $mpesa= new \Safaricom\Mpesa\Mpesa();

  $BusinessShortCode = '4092475'; 
  $LipaNaMpesaPasskey = '8f62a516b3e1e68a7120bb499b078e20d88520af53401d3589e4e7a7e288ed83'; 
  $TransactionType = 'CustomerPayBillOnline';  
  $Amount = $amount; 
  $PartyA = $phone;  
  $PartyB = '4092475'; 
  $PhoneNumber = $phone;

  $order_id = $request->account;

  $data = [
    'order_id' => $order_id,
    'pay_type' => $pay_type,
    'phone'    => $phone,
    'status'   => '0',
  ];
  $pay_created = Transaction::create($data);
  $pass_id = $pay_created->id;

  $CallBackURL = 'https://'.domain_name().'/api/callback?order_id='.$pass_id; 


  if($pay_type =='invoice'){
    $user_id = Invoice::find($order_id)->user_id;
  }
  else{
    $user_id = Payment::find($order_id)->user_id;
  }

  $user = User::find(1);

  # access token
  $consumerKey = 'dxgZK09pFBtJynxlgf51Fii5WRLBNoJt'; //Fill with your app Consumer Key
  $consumerSecret = 'vT8ZvfofPGJFZOG0'; // Fill with your app Secret
  $BusinessShortCode = '4092475';
  $Passkey = '8f62a516b3e1e68a7120bb499b078e20d88520af53401d3589e4e7a7e288ed83';

  $consumerKey         = $user->MPESA_CONSUMER_KEY; //Fill with your app Consumer Key
  $consumerSecret      = $user->MPESA_CONSUMER_SECRET; // Fill with your app Secret
  $BusinessShortCode   = $user->BusinessShortCode; 
  $Passkey             = $user->LipaNaMpesaPasskey; 
  
  

  $PartyA = $phone; // This is your phone number, 
  $AccountReference = $phone;
  $TransactionDesc = 'Service Payment by client';
  $Amount = $amount;
  
  # Get the timestamp, format YYYYmmddhms -> 20181004151020
  $Timestamp = date('Ymdhis');    
  
  # Get the base64 encoded string -> $password. The passkey is the M-PESA Public Key
  $Password = base64_encode($BusinessShortCode.$Passkey.$Timestamp);

  # header for access token
  $headers = ['Content-Type:application/json; charset=utf8'];

    # M-PESA endpoint urls
  $access_token_url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
  $initiate_url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

  $curl = curl_init($access_token_url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($curl, CURLOPT_HEADER, FALSE);
  curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);
  $result = curl_exec($curl);
  $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  $result = json_decode($result);
  $access_token = $result->access_token;  
  curl_close($curl);

  # header for stk push
  $stkheader = ['Content-Type:application/json','Authorization:Bearer '.$access_token];

  # initiating the transaction
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $initiate_url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header

  $curl_post_data = array(
    //Fill in the request parameters with valid values
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $Password,
    'Timestamp' => $Timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $Amount,
    'PartyA' => $PartyA,
    'PartyB' => $BusinessShortCode,
    'PhoneNumber' => $PartyA,
    'CallBackURL' => $CallBackURL,
    'AccountReference' => $AccountReference,
    'TransactionDesc' => $TransactionDesc
  );

  $data_string = json_encode($curl_post_data);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  $curl_response = curl_exec($curl);
  //print_r($curl_response);

   //echo $curl_response;
  $data1 = json_decode($curl_response);
  $resultCode = $data1->ResponseDescription;
  $transactionId=$data1->CheckoutRequestID;

  for ($x = 0; $x <= 1; $x++) {
   $x = Transaction::whereOrderId($order_id)->whereStatus(1)->count();

 } 
 echo "payment received";




}


public function cpay($id)
{

  $order  = Payment::find($id);

  return view('admin.cpay', compact('order', 'id'));

}


public function spay(Request $request)
{

  $payment_id      = $request->payment_id;
  $amount          = $request->amount;
  $domain_name     = $request->domain_name;
  $scallback_url   = $request->scallback_url;
  $ccallback_url   = $request->ccallback_url;

  return view('admin.stripe', compact('payment_id' , 'amount', 'domain_name', 'scallback_url', 'ccallback_url'));

}


public function cviewInvoice($id)
{

  $order  = Invoice::whereSlug($id)->first();
  $user = User::find($order->user_id);

  if ($user->is_writer()){
    $services = Order::whereInvoiceId($order->id)->get();
  }

  if ($user->is_editor()){
    $services = Order::whereEinvoiceId($order->id)->get();
  }


  return view('admin.cinvoice', compact('order' , 'id', 'services'));

}


public function viewInvoice($id)
{

  $order  = Invoice::whereSlug($id)->first();
  $services = Iservice::whereInvoiceId($order->id)->get();

  return view('admin.invoice', compact('order' , 'id', 'services'));

}


// pay for package call back
public function payPackage($id)
{

  $now = date('Y-m-d H:i:s');



  $days = 31;
  $order_due = date("Y-m-d H:i:s", strtotime('+'.$days.' days'));


  $user = Auth::user();
  $user_id = $user->id;
  $user->subscribe_start = $now; 
  $user->subscribe_end = $order_due;
  $user->account_status = '1';
  $user->package = $id;

  $user->save();

  Session::pull('package');


  $data=array(
    'name' =>$user->name,
    'email'=>$user->email,
    'sname'=>'Hi '.$user->name. ' client has subcribed in '.domain_name().'',
    'description'=>'Hi '.$user->name. ' client has subcribed in '.domain_name().'',

  );


        //send email to agent
  Mail::send('email.index',$data, function($message) use ($data){
    $message->to($data['email']);
    $message->subject($data['sname']);

  }); 

   //send sms
   // $recipients = $user->phone;
   // $message    = 'Hi '.$user->name. ' client has subcribed in '.domain_name().'';
   // sendsms($recipients,$message);


  

  return redirect(url('dashboard'))->with('success', 'account activated successfully');

}


public function cpaid($id)
{

  $order  = Payment::find($id);
  $order->status = '1';

  $is_paid = $order->save();

  if ($is_paid) {

   $user = User::find($order->user_id);
   $wallet = $user->wallet; 
   $wallet = $wallet + $order->amount;
   $user->wallet = $wallet;
   $user->save();




   $data=array(
    'name' =>$user->name,
    'email'=>$user->email,
    'sname'=>'Order #'.$order->order_id. ' has been paid',
    'description'=>'Order #'.$order->order_id. ' has been paid',

  );


        //send email to agent
   Mail::send('email.index',$data, function($message) use ($data){
    $message->to($data['email']);
    $message->subject($data['sname']);

  }); 

   //send sms
   // $recipients = $user->phone;
   // $message    = 'Order #'.$order->order_id. ' has been paid';
   // sendsms($recipients,$message);
 }



 return redirect(url($order->callback_url.''.$order->order_id))->with('success', 'order paid successfully');

}


public function ipaid($id)
{

  $order  = Invoice::whereSlug($id)->first();
  $order->status = '1';

  $is_paid = $order->save();

  if ($is_paid) {

   $data = [
    'order_id'        => $order->id,
    'amount'          => $order->amount,
    'currency'        => $order->currency,
    'user_id'         => $order->user_id,
    'payment_source'        => 'invoice',
    'status'        => '1',

  ];

  $pay_created = Payment::create($data);

  $user = User::find($order->user_id);

  $data=array(
    'name' =>$user->name,
    'email'=>$user->email,
    'sname'=>'Invoice #'.$order->id. ' has been paid',
    'description'=>'Order #'.$order->id. ' has been paid',

  );


        //send email to agent
  Mail::send('email.index',$data, function($message) use ($data){
    $message->to($data['email']);
    $message->subject($data['sname']);

  }); 

//send sms
  // $recipients = $user->phone;
  // $message    = 'Invoice #'.$order->id. ' has been paid';
  // sendsms($recipients,$message);

}

return redirect(url('view-invoice/'.$id))->with('success', trans('invoice paid successfully'));

}





    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * Clear all cache
     */
    public function clearCache(){
      Artisan::call('debugbar:clear');
      Artisan::call('view:clear');
      Artisan::call('route:clear');
      Artisan::call('config:clear');
      Artisan::call('cache:clear');
      if (function_exists('exec')){
        exec('rm ' . storage_path('logs/*'));
      }
      $this->rrmdir(storage_path('logs/'));

      return redirect(route('home'));
    }
    public function rrmdir($dir) {

      if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
          if ($object != "." && $object != "..") {
            if (is_dir($dir."/".$object))
              $this->rrmdir($dir."/".$object);
            else
              unlink($dir."/".$object);
          }
        }
            //rmdir($dir);
      }
    }


  }
