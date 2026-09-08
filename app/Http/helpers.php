<?php
use App\Models\User;
use App\Models\Post;
use App\Models\Sms;
use App\Models\Paper;
use App\Models\Package;
use App\Models\Category;
use App\Models\Charge;
use App\Models\Order;
use App\Models\Page;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Option;
use App\Models\Website;
use Stevebauman\Location\Facades\Location;
use AfricasTalking\SDK\AfricasTalking;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function send_email($data, $site){

  //Create an instance; passing `true` enables exceptions
  $mail = new PHPMailer();

  try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $site->mail_host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $site->mail_username;                     //SMTP username
    $mail->Password   = $site->mail_password;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $site->mail_port;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($site->email, $site->domain_name);
    $mail->addAddress($data['email']);     //Add a recipient
    // $mail->addAddress('awasamexperts@gmail.com');               //Name is optional
    $mail->addReplyTo($site->reply_to, $site->domain_name);
    // $mail->addCC('ezekielmuthee42@gmail.com');
    // $mail->addBCC('emuktech@gmail.com');

    //Attachments
   // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
  //  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $data['sname'];
    $mail->Body    = '<h1 style="text-align: center; padding: 20px 10px; background-color: #23527c; color: #FFF;">'.$data['sname'].'
    </h1><div style="text-align: center; padding: 20px; font-size: 16px; background-color: #e9e9e9; color: #000000;">'.$data['description'].'<br>
    <p>You can request help via:</p>
    <a  href="https://api.whatsapp.com/send/?phone='.$site->phone.'&text=Hi&app_absent=0"  style="  background-color: #41D07D;
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 10px;">
    <img src="https://powerpointpresentationhelp.com/wp-content/uploads/2022/03/WhatsApp_icon.png" width="20">
    WhatsApp </a>
    <a href="https://'.$site->domain_name.'" style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 10px;"><img src="https://powerpointpresentationhelp.com/wp-content/uploads/2022/03/205-2057855_essay-icon.png" width="20">
    Visit Website </a>
    <p>Send us an email or call us '.$site->phone.'</p>
    <p>Kind regards</p>
    <p>'.$site->domain_name.' support</p>

    </div>';
    $mail->AltBody = $data['description'];

    $result = $mail->send();
    //echo 'Message has been sent';
  } catch (Exception $e) {
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }

  return $result;


}

if (!function_exists('isPhoto')) 
{
  function isPhoto($path) 
  {
        // Get the file extension from the path
    $exploded = explode('.', $path);
    $ext = strtolower(end($exploded));
        // Define the photos extensions
    $photoExtensions = ['png', 'jpg', 'jpeg', 'gif', 'jfif', 'tif', 'webp'];
        // Check if this extension belongs to the extensions we defined
    if (in_array($ext, $photoExtensions)) {
      return true;
    }
    return false;
  }
}

if (!function_exists('isVideo')) 
{
  function isVideo($path) 
  {
        // Get the file extension from the path
    $exploded = explode('.', $path);
    $ext = end($exploded);
        // Define the videos extensions
    $videoExtensions = ['mov', 'mp4', 'avi', 'wmf', 'flv', 'webm'];
        // Check if this extension belongs to the extensions we defined
    if (in_array($ext, $videoExtensions)) {
      return true;
    }
    return false;
  }
}

function activate_status($user){




 
}


function category_photo($id){

  $product_count = Category::whereId($id)->count();
  if($product_count>0){

    $product = Category::find($id);

if($product->photo_url) {
  $url_path = $product->photo_url;
}
else{
$url_path = asset('assets/images/landing/market4.png');
}

  } else{
   $url_path = asset('assets/images/landing/market4.png'); 
  }



 
  return $url_path;



}




function get_submenus($id){

  $menu = Page::whereParentId($id)->get();
  return $menu;

}


function tag($id){
  $page = Page::find($id);
  return $page;
}
function category($id){
  $cat = Category::find($id);
  return $cat;
}



function post_path($id='')
{

 $post = Post::find($id);
 $path = "https://".client_site($post->site_id)->domain_name."".tag($post->parent_page)->path."/".$post->slug;



 return $path;
}




function has_submenus($id){

  $menu = Page::whereParentId($id)->count();
  
  return $menu;

}

function referer(){

  $referer = request()->headers->get('referer');
  $referer = url()->previous();

  return $referer;
}


function can_bid($id){

if(writer_counter($id, 2) and writer_counter($id, 6) and writer_counter($id, 8)){
 $canbid = 1;
}
else{
  $canbid = 1;
}

return $canbid;
}





function generateRandomString($length = 5) {
  return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}


function getTOC1(string $html) {
  $myHtmlContent = $html;

  $markupFixer  = new TOC\MarkupFixer();
  $tocGenerator = new TOC\TocGenerator();

// This ensures that all header tags have `id` attributes so they can be used as anchor links
  $htmlOut  = "<div style='display:none;' class='content'>" . $markupFixer->fix($myHtmlContent) . "</div>";

// This generates the Table of Contents in HTML
  $htmlOut .= "
  <style>
  .toc-list, .toc-list ol {
    list-style-type: none;
  }

  .toc-list {
    padding: 0;
  }

  .toc-list ol {
    padding-inline-start: 2ch;
  }
  </style>
  <div class='toc a'>" . $tocGenerator->getHtmlMenu($htmlOut) . "</div>";


  $someHtmlContent = $htmlOut;


  $options = [
    'currentAsLink' => false,
    'currentClass'  => 'curr_page',
    'ancestorClass' => 'curr_ancestor',
    'branch_class'  => 'branch'
  ];

  $renderer = new Knp\Menu\Renderer\ListRenderer(new Knp\Menu\Matcher\Matcher(), $options);

// Render the list
  $tocGenerator = new TOC\TocGenerator();
  $listHtml = $tocGenerator->getHtmlMenu($someHtmlContent, 1, 6, $renderer);

  return $listHtml;
}




function userslug($id){

 $user = User::find($id);
 return $user->slug;

}

function parentpage($id='')
{
  $parentpage = Page::find($id);

  return $parentpage->name;
}

function charges($amount){

  $amount = $amount;

  $amount = (int) $amount;

  $charge = Charge::where('max', '>', $amount)->first();

  return $charge->charges;

}


function writertotals($id='')
{
  $total = writer_counter($id, 2) + writer_counter($id, 4) + writer_counter($id, 5);

  return $total;
}


function unique_slug($title = '', $model = 'Order'){
  $slug = Str::slug($title);
  if ($slug === ''){
    $string = mb_strtolower($title, "UTF-8");;
    $string = preg_replace("/[\/\.]/", " ", $string);
    $string = preg_replace("/[\s-]+/", " ", $string);
    $slug = preg_replace("/[\s_]/", '-', $string);
  }

    //get unique slug...
  $nSlug = $slug;
  $i = 0;

  $model = str_replace(' ','',"\App\Models\ ".$model);
  while( ($model::whereSlug($nSlug)->count()) > 0){
    $i++;
    $nSlug = $slug.'-'.$i;
  }
  if($i > 0) {
    $newSlug = substr($nSlug, 0, strlen($slug)) . '-' . $i;
  } else
  {
    $newSlug = $slug;
  }
  return $newSlug;
}


function unique_slugu($title = '', $model = 'User'){
  $slug = Str::slug($title);
  if ($slug === ''){
    $string = mb_strtolower($title, "UTF-8");;
    $string = preg_replace("/[\/\.]/", " ", $string);
    $string = preg_replace("/[\s-]+/", " ", $string);
    $slug = preg_replace("/[\s_]/", '-', $string);
  }

    //get unique slug...
  $nSlug = $slug;
  $i = 0;

  $model = str_replace(' ','',"\App\Models\ ".$model);
  while( ($model::whereSlug($nSlug)->count()) > 0){
    $i++;
    $nSlug = $slug.'-'.$i;
  }
  if($i > 0) {
    $newSlug = substr($nSlug, 0, strlen($slug)) . '-' . $i;
  } else
  {
    $newSlug = $slug;
  }
  return $newSlug;
}

     /**
     * Write code on Method
     *
     * @return response()
     */




     function sendsms($phone, $message){


       $option              = Option::find(1);
       $sms_balance         = $option->sms_balance;

       if($sms_balance > 0){

        $phone = $phone;
      $phone = ltrim($phone,'0');///phone remove 0 
      $phone = ltrim($phone,'+');//phone remove +
      if(substr($phone,0,3)!='254'){
       $phone = "254".$phone; ///add 254 in the beginning 
     }else{
       $phone=$phone;
     }


     $recipients = $phone;
     $message    = $message;
     $user_id    = get_option(site_id().'_awaspay_id');

     $url="https://awaspay.com/sendsms";
     $data = array(
      "phone"       => $recipients,
      "message"  => $message,
      "merchant_id" => $user_id,   
    );

     $ch = curl_init( $url );
# Setup request to send json via POST.
     $payload = json_encode( array( "customer"=> $data ) );
     curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
     curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
# Return response instead of printing.
     curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
# Send request.
     $result = curl_exec($ch);
     curl_close($ch);
# Print response.
     echo "<pre>" . $result. "</pre>";

     $option              = Option::find(1);
     $sms_balance         = $option->sms_balance;
     $option->sms_balance = $sms_balance-1;
     $option->save();

     $data2 = array(
      "phone"       => $recipients,
      "message"  => $message,
      "user_id" => Auth::user()->id,   
    );

     $sms_created = Sms::create($data2);

     return  $result;

   }
   else{
    return 'no sms';
  }



}

function sms_balance(){

  $option = Option::find(1);
  $sms_balance = $option->sms_balance;
  return $sms_balance;
}


/**
 * @return string
 * 
 * @return logo url
 */
function logo_url(){


  $website = Website::whereDomainName(domain_name())->first();
  $url_path = $website->logo_url;
  return $url_path;

}

function favicon_url(){


  $website = Website::whereDomainName(domain_name())->first();
  $url_path = $website->favicon_url;

  return $url_path;
}


function file_get_contents_curl($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
curl_setopt($ch, CURLOPT_URL, $url);
$data = curl_exec($ch);
curl_close($ch);
return $data;
}

function get_user_data($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
curl_setopt($ch, CURLOPT_URL, $url);
$data = curl_exec($ch);
curl_close($ch);
return $data;
}

    /**
 * @param string $option_key
 * @return string
 */
    function get_option($option_key = ''){
      $get = \App\Models\Option::where('option_key', $option_key)->first();
      if($get) {
        return $get->option_value;
      }
      return $option_key;
    }




    //get current location

    function get_country(){

if(domain_name() == "localhost"){
      $ip = '49.35.41.195'; //For static IP address get
} else{

      //$ip = request()->ip(); //Dynamic IP address get

      $ip = '49.35.41.195';
     
}
     
     $data = \Location::get($ip); 
     $country = $data->countryName;
     return $country;

   }


       //get current location

    function get_current_location(){

if(domain_name() == "localhost"){
      $ip = '49.35.41.195'; //For static IP address get
} else{

    //  $ip = request()->ip(); //Dynamic IP address get

    $ip = '49.35.41.195';
     
}
     
  $data = \Location::get($ip);
  $data = "<br>
 <span style='font-size: 11px;'>IP: {{ $data->ip }}</span><br>
  <span style='font-size: 11px;'>Country Name: {{ $data->countryName }}</span><br>
 <span style='font-size: 11px;'>Country Code: {{ $data->countryCode }}</span><br>
  <span style='font-size: 11px;'>Region Code: {{ $data->regionCode }}</span><br>
 <span style='font-size: 11px;'>Region Name: {{ $data->regionName }}</span><br>
 <span style='font-size: 11px;'>City Name: {{ $data->cityName }}</span><br>
 <span style='font-size: 11px;'>Zipcode: {{ $data->zipCode }}</span><br>
<span style='font-size: 11px;'>Latitude: {{ $data->latitude }}</span><br>
<span style='font-size: 11px;'>Longitude: {{ $data->longitude }}</span><br>




  <a target='_blank' href='http://maps.google.com/?q=".$data->latitude.",".$data->longitude."'>View the location</a> <br> PC Name ".getenv('COMPUTERNAME');
     return $data;

   }







   function get_wtotal($id){ 

    $order = Order::whereWriterId($id)->whereStatus(5)->sum('wcost');
    $order  = (int)  $order;
    return $order;

  }


  function get_intotal($id){ 

    $order = Invoice::whereUserId($id)->sum('total');
    $order  = (int)  $order ;
    return $order;

  }


  function get_ewtotal($id){ 

    $order = Order::whereEditorId($id)->whereStatus(5)->sum('ecost');
    $order  = (int)  $order;
    return $order;

  }


  function get_eintotal($id){ 

    $order = Invoice::whereUserId($id)->sum('total');
    $order  = (int)  $order ;
    return $order;

  }




   function get_city(){

      // $user_ip = request()->ip();
      // $geo     = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
      // $city    = $geo["geoplugin_city"];

    $city = get_current_location()->cityName;
    return $city;

  }

  function uploadType($id){
    switch ($id) {
      case "0":
      echo "Final document to editor";
      break;
      case "1":
      echo "Plagiarism Report to editor";
      break;
      case "2":
      echo "File with comments to writer";
      break;
      case "3":
      echo "Plagiarism Report to client";
      break;
      case "4":
      echo "Final document to client";
      break;
      default:
      echo "client upload";
    }

  }

    //accout status
  function invoice_status($id){
    switch ($id) {
      case "0":
      echo "unpaid";
      break;
      case "1":
      echo "paid";
      break;
      default:
      echo "cancelled";
    }

  }

       //accout status
  function plagiarism_report($id){
    switch ($id) {
      case "0":
      echo "Plagiarism report not required";
      break;
      case "1":
      echo "Include plagiarism report";
      break;
      default:
      echo "Not specified";
    }

  }

         //order status
  function order_status($id){
    switch ($id) {
      case "0":
      echo "Pending";
      break;
      case "1":
      echo "Available";
      break;
      case "2":
      echo "In Progress";
      break;
      case "3":
      echo "Editing";
      break;
      case "4":
      echo "Completed";
      break;
      case "5":
      echo "Approved";
      break;
      case "6":
      echo "Revision";
      break;
      case "7":
      echo "Cancelled";
      break;
      case "9":
      echo "Dispute Raised";
      break;
      case "8":
      echo "Editor revision";
      break;
      default:
      echo "Not specified";
    }

  }


    //academic level

  function aclevel($id){


   if (is_numeric($id)){
    switch ($id) {
      case "19":
      echo "College";
      break;
      case "20":
      echo "Undergraduate";
      break;
      case "21":
      echo "Masters";
      break;
      case "22":
      echo "PhD";
      break;
      default:
      echo "Not defined";
    }

  }else{
    return $id;
  }

}

function dispute($id){
  switch ($id) {
    case "1":
    echo "Declined";
    break;
    case "2":
    echo "Full Refund";
    break;

    case "3":
    echo "50% Refund";
    break;

    default:
    echo "Not defined";
  }

}

//accout status
function accountStatus($id){
  switch ($id) {
    case "0":
    echo "No subscription";
    break;
    case "1":
    echo "active";
    break;
    default:
    echo "blocked";
  }

}

    //accout status
function writerStatus($id){
  switch ($id) {
    case "0":
    echo "pending";
    break;
    case "1":
    echo "active";
    break;
    case "2":
    echo "suspended";
    break;
    default:
    echo "blocked";
  }

}


    //accout status
function paymentStatus($id){
  switch ($id) {
    case "0":
    echo "unpaid";
    break;
    case "2":
    echo "paid";
    break;
    default:
    echo "not yet";
  }

}

function current_disk(){
  $current_disk = \Illuminate\Support\Facades\Storage::disk(get_option(site_id().'_default_storage'));
  return $current_disk;
}

function domain_name(){

  $site = $_SERVER['HTTP_HOST'];


  $pattern = '/www./i';
  $site = preg_replace($pattern, '', $site);
  return $site;

}

function site_id(){
 $site = Website::whereDomainName(domain_name())->first();
 return $site->id;
}


function service($id){
  $service =Service::find($id);
  return $service;
}

function admin_domain_name(){
 $site = Website::whereDomainName(domain_name())->first();
 return $site->admin_domain_name;
}

function client_site($id){
  $client_site = Website::find($id);
  return $client_site;
}

function avatar_img_url($img = '', $source){
  $url_path = '';
  if ($img){
    if ($source == 'public'){
      $url_path = asset('storage/uploads/avatar/'.$img);
    }elseif ($source == 's3'){
      $url_path = \Illuminate\Support\Facades\Storage::disk('s3')->url('uploads/avatar/'.$img);
    }
  }
  return $url_path;
}
//days difference

function days($fdate, $tdate){
  $datetime1 = new DateTime($fdate);
  $datetime2 = new DateTime($tdate);
  $interval = $datetime1->diff($datetime2);
      $days = $interval->format('%a');//now do whatever you like with $days

      return $days;

    }

//get writer balance
    function remainingtime($id){
      $datetime1 = new DateTime(date('Y-m-d H:i:s'));
      $datetime2 = new DateTime($id);

      if($datetime1 <= $datetime2){
        $interval = $datetime1->diff($datetime2);
        $elapsed = $interval->format('%a days %h hours %i minutes');
      }

      if($datetime1 >= $datetime2){
        $winterval = $datetime1->diff($datetime2);
        $welapsed = $winterval->format('%a days %h hours %i minutes');
        $elapsed =  "<font color='red'>-".$welapsed .' passed </font> <br/>';
      }
      return $elapsed;
    }

//get writer balance
    function writer_balance($id){
      $writer_balance = Order::whereWriterId($id)->whereStatus('5')->whereWriterPaid('unpaid')->wherePayments('1')->sum('wcost');
      return $writer_balance;
    }

//get editor balance
    function editor_balance($id){
      $writer_balance = Order::whereEditorId($id)->whereStatus('5')->whereEditorPaid('unpaid')->whereEpayments('1')->sum('ecost');
      return $writer_balance;
    }

    function username($id){

$user_count = User::whereId($id)->count();
if($user_count>0){

  if (is_numeric($id)){
    $user = User::find($id);
    return $user;

  }else{
    return $id;
  }

} else{
  return $id;
}
    
  }

//get package
  function writer_counter($writer_id, $status){
    $order = Order::whereStatus($status)->whereWriterId($writer_id)->count();
    return $order;
  }




  function wallet($user_id)
  {
    $debit_total1 = Payment::whereUserId($user_id)->whereStatus('1')->wherePaymentSource('Order paid')->sum('amount');
    $debit_total2 = Payment::whereUserId($user_id)->whereStatus('1')->wherePaymentSource('Pay Later')->sum('amount');
    $debit_total3 = Payment::whereUserId($user_id)->whereStatus('1')->wherePaymentSource('invoice paid')->sum('amount');
    $debit_total4 = Payment::whereUserId($user_id)->whereStatus('1')->wherePaymentSource('Wallet Deduction')->sum('amount');
    $debit_total5 = Payment::whereUserId($user_id)->whereStatus('1')->wherePaymentSource('custom invoice wallet deduction')->sum('amount');


    $debit_total =  $debit_total1 +  $debit_total2 +  $debit_total3 +  $debit_total4 + $debit_total5;
    $credit_total1 = Payment::whereUserId($user_id)->whereStatus('1')->wherePaymentSource('TopUp Wallet')->sum('amount');
    $credit_total2 = Payment::whereUserId($user_id)->whereStatus('1')->wherePaymentSource('Wallet TopUp')->sum('amount');
    $credit_total3 = Payment::whereUserId($user_id)->whereStatus('1')->wherePaymentSource('Admin Wallet TopUp')->sum('amount');
    $credit_total4 = Payment::whereUserId($user_id)->whereStatus('1')->wherePaymentSource('account balancing')->sum('amount');
    $credit_total5 = Payment::whereUserId($user_id)->whereStatus('1')->wherePaymentSource('custom invoice')->sum('amount');
    $credit_total6 = Payment::whereUserId($user_id)->whereStatus('1')->wherePaymentSource('Order Refund')->sum('amount');

    $credit_total = $credit_total1 + $credit_total2 + $credit_total3 + $credit_total4 + $credit_total5 + $credit_total6 ;

    $wallet = User::find($user_id)->wallet;

    $diff = $credit_total - $debit_total;

    $total  = $credit_total - $debit_total;

    return $total;
  }

  function client_counter($user_id, $status){
    $order = Order::whereStatus($status)->whereUserId($user_id)->count();
   // $order1 = Order::whereOrderSite('www.writers24x7.com')->whereUserId($user_id)->count();
   // $order2 = Order::whereOrderSite('writers24x7.com')->whereUserId($user_id)->count();
    return  $order;
  }



  function editor_counter($editor_id, $status){
    $order = Order::whereStatus($status)->whereEditorId($editor_id)->count();
    return $order;
  }

//get package
  function package($id){
   $package = Package::find($id);
   return $package;
 }

 function user_status($id){
   $user = User::find($id);
   return $user->user_type;
 }

//display paper type
 function paper($id){

   $user = Paper::find($id);
   $pptype_count = Paper::whereId($id)->count();
   if ($pptype_count>0) {
    return $user->pptype_name;
  }
  else{
    return $user = 'No type of paper selected';
  }


}

function subject($id){
  if (is_numeric($id)){

   $user_count = Category::whereId($id)->count();
   if($user_count>0){
    $user = Category::find($id);
    return $user->name;
  }

  else{
    $name = 'Not defined';
    return $name;
  }

  




}else{
  return $id;
}

}

function month($id){
 switch ($id) {
  case "1":
  echo "January";
  break;
  case "2":
  echo "February";
  break;
  case "3":
  echo "March";
  break;
  case "4":
  echo "April";
  break;
  case "5":
  echo "May";
  break;
  case "6":
  echo "June";
  break;
  case "7":
  echo "July";
  break;
  case "8":
  echo "August";
  break;
  case "9":
  echo "Semptember";
  break;
  case "10":
  echo "Octumber";
  break;
  case "11":
  echo "November";
  break;
  case "12":
  echo "December";
  break;
  default:
  echo "wrong month";
}
}

function price($price = 0){
 return get_currency().' '.$price;
}

function get_currency(){
  $currency = get_option(site_id().'_currency_sign');
  if(Auth::check()){
    if(Auth::user()->is_student()){
      $currency = 'USD';
    }
  }





  return $currency;

}

function currencies(){
  return array(
    'AED' => 'United Arab Emirates dirham',
    'AFN' => 'Afghan afghani',
    'ALL' => 'Albanian lek',
    'AMD' => 'Armenian dram',
    'ANG' => 'Netherlands Antillean guilder',
    'AOA' => 'Angolan kwanza',
    'ARS' => 'Argentine peso',
    'AUD' => 'Australian dollar',
    'AWG' => 'Aruban florin',
    'AZN' => 'Azerbaijani manat',
    'BAM' => 'Bosnia and Herzegovina convertible mark',
    'BBD' => 'Barbadian dollar',
    'BDT' => 'Bangladeshi taka',
    'BGN' => 'Bulgarian lev',
    'BHD' => 'Bahraini dinar',
    'BIF' => 'Burundian franc',
    'BMD' => 'Bermudian dollar',
    'BND' => 'Brunei dollar',
    'BOB' => 'Bolivian boliviano',
    'BRL' => 'Brazilian real',
    'BSD' => 'Bahamian dollar',
    'BTC' => 'Bitcoin',
    'BTN' => 'Bhutanese ngultrum',
    'BWP' => 'Botswana pula',
    'BYR' => 'Belarusian ruble',
    'BZD' => 'Belize dollar',
    'CAD' => 'Canadian dollar',
    'CDF' => 'Congolese franc',
    'CHF' => 'Swiss franc',
    'CLP' => 'Chilean peso',
    'CNY' => 'Chinese yuan',
    'COP' => 'Colombian peso',
    'CRC' => 'Costa Rican col&oacute;n',
    'CUC' => 'Cuban convertible peso',
    'CUP' => 'Cuban peso',
    'CVE' => 'Cape Verdean escudo',
    'CZK' => 'Czech koruna',
    'DJF' => 'Djiboutian franc',
    'DKK' => 'Danish krone',
    'DOP' => 'Dominican peso',
    'DZD' => 'Algerian dinar',
    'EGP' => 'Egyptian pound',
    'ERN' => 'Eritrean nakfa',
    'ETB' => 'Ethiopian birr',
    'EUR' => 'Euro',
    'FJD' => 'Fijian dollar',
    'FKP' => 'Falkland Islands pound',
    'GBP' => 'Pound sterling',
    'GEL' => 'Georgian lari',
    'GGP' => 'Guernsey pound',
    'GHS' => 'Ghana cedi',
    'GIP' => 'Gibraltar pound',
    'GMD' => 'Gambian dalasi',
    'GNF' => 'Guinean franc',
    'GTQ' => 'Guatemalan quetzal',
    'GYD' => 'Guyanese dollar',
    'HKD' => 'Hong Kong dollar',
    'HNL' => 'Honduran lempira',
    'HRK' => 'Croatian kuna',
    'HTG' => 'Haitian gourde',
    'HUF' => 'Hungarian forint',
    'IDR' => 'Indonesian rupiah',
    'ILS' => 'Israeli new shekel',
    'IMP' => 'Manx pound',
    'INR' => 'Indian rupee',
    'IQD' => 'Iraqi dinar',
    'IRR' => 'Iranian rial',
    'ISK' => 'Icelandic kr&oacute;na',
    'JEP' => 'Jersey pound',
    'JMD' => 'Jamaican dollar',
    'JOD' => 'Jordanian dinar',
    'JPY' => 'Japanese yen',
    'KES' => 'Kenyan shilling',
    'KGS' => 'Kyrgyzstani som',
    'KHR' => 'Cambodian riel',
    'KMF' => 'Comorian franc',
    'KPW' => 'North Korean won',
    'KRW' => 'South Korean won',
    'KWD' => 'Kuwaiti dinar',
    'KYD' => 'Cayman Islands dollar',
    'KZT' => 'Kazakhstani tenge',
    'LAK' => 'Lao kip',
    'LBP' => 'Lebanese pound',
    'LKR' => 'Sri Lankan rupee',
    'LRD' => 'Liberian dollar',
    'LSL' => 'Lesotho loti',
    'LYD' => 'Libyan dinar',
    'MAD' => 'Moroccan dirham',
    'MDL' => 'Moldovan leu',
    'MGA' => 'Malagasy ariary',
    'MKD' => 'Macedonian denar',
    'MMK' => 'Burmese kyat',
    'MNT' => 'Mongolian t&ouml;gr&ouml;g',
    'MOP' => 'Macanese pataca',
    'MRO' => 'Mauritanian ouguiya',
    'MUR' => 'Mauritian rupee',
    'MVR' => 'Maldivian rufiyaa',
    'MWK' => 'Malawian kwacha',
    'MXN' => 'Mexican peso',
    'MYR' => 'Malaysian ringgit',
    'MZN' => 'Mozambican metical',
    'NAD' => 'Namibian dollar',
    'NGN' => 'Nigerian naira',
    'NIO' => 'Nicaraguan c&oacute;rdoba',
    'NOK' => 'Norwegian krone',
    'NPR' => 'Nepalese rupee',
    'NZD' => 'New Zealand dollar',
    'OMR' => 'Omani rial',
    'PAB' => 'Panamanian balboa',
    'PEN' => 'Peruvian nuevo sol',
    'PGK' => 'Papua New Guinean kina',
    'PHP' => 'Philippine peso',
    'PKR' => 'Pakistani rupee',
    'PLN' => 'Polish z&#x142;oty',
    'PRB' => 'Transnistrian ruble',
    'PYG' => 'Paraguayan guaran&iacute;',
    'QAR' => 'Qatari riyal',
    'RON' => 'Romanian leu',
    'RSD' => 'Serbian dinar',
    'RUB' => 'Russian ruble',
    'RWF' => 'Rwandan franc',
    'SAR' => 'Saudi riyal',
    'SBD' => 'Solomon Islands dollar',
    'SCR' => 'Seychellois rupee',
    'SDG' => 'Sudanese pound',
    'SEK' => 'Swedish krona',
    'SGD' => 'Singapore dollar',
    'SHP' => 'Saint Helena pound',
    'SLL' => 'Sierra Leonean leone',
    'SOS' => 'Somali shilling',
    'SRD' => 'Surinamese dollar',
    'SSP' => 'South Sudanese pound',
    'STD' => 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe dobra',
    'SYP' => 'Syrian pound',
    'SZL' => 'Swazi lilangeni',
    'THB' => 'Thai baht',
    'TJS' => 'Tajikistani somoni',
    'TMT' => 'Turkmenistan manat',
    'TND' => 'Tunisian dinar',
    'TOP' => 'Tongan pa&#x2bb;anga',
    'TRY' => 'Turkish lira',
    'TTD' => 'Trinidad and Tobago dollar',
    'TWD' => 'New Taiwan dollar',
    'TZS' => 'Tanzanian shilling',
    'UAH' => 'Ukrainian hryvnia',
    'UGX' => 'Ugandan shilling',
    'USD' => 'United States dollar',
    'UYU' => 'Uruguayan peso',
    'UZS' => 'Uzbekistani som',
    'VEF' => 'Venezuelan bol&iacute;var',
    'VND' => 'Vietnamese &#x111;&#x1ed3;ng',
    'VUV' => 'Vanuatu vatu',
    'WST' => 'Samoan t&#x101;l&#x101;',
    'XAF' => 'Central African CFA franc',
    'XCD' => 'East Caribbean dollar',
    'XOF' => 'West African CFA franc',
    'XPF' => 'CFP franc',
    'YER' => 'Yemeni rial',
    'ZAR' => 'South African rand',
    'ZMW' => 'Zambian kwacha',
  );

}


?>