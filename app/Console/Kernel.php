<?php

namespace App\Console;

use App\Models\Order;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Review_rating;
use Carbon\Carbon;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

      $schedule->call(function () {

//approve order
        $current_time = Carbon::now();
        $orders       = Order::whereStatus(4)->get();
        foreach ($orders as $key => $value) {
          $order = Order::find($value->id);
          $day_count = days($current_time, $order->completed_at);
          $pay_after = get_option('pay_after');
          if ($day_count > $pay_after) {

            $order->status        = 5;
            $order->payments      = 1; 
            $order->epayments     = 1;
            $order->save();

            $user         = User::find($order->writer_id);
            $order_count  = $user->orders;
            $user->orders = $order_count+1;
            $user->save();

          }
        }


        $orders       = Order::whereStatus("pending")->get();
        foreach ($orders as $key => $value) {
          $order = Order::find($value->id);
          $created_at  = Carbon::parse($order->order_due);
          $day_count   = Carbon::parse($current_time)->diffInHours($created_at,false);
          if ($day_count < 0) {

            $order->status        = 7;
            $order->order_cancelreason = "Time Expired";
            $order->save();

          }
        }

        $writers = User::whereUserType('writer')->get();
        foreach ($writers as $key => $user) {
         $count_star_rating = Review_rating::whereWriterId($user->id)->count();
         $sum_star_rating = Review_rating::whereWriterId($user->id)->sum('star_rating');
         if ($count_star_rating > 0) {
           $star_rating = $sum_star_rating/$count_star_rating;
         } else{
          $star_rating = 0;
        }

        $writer = User::find($user->id);
        $writer->ratings = $star_rating;
        $writer->save();
      }

//update orders count

      $writers = User::whereUserType('writer')->get();
      foreach ($writers as $key => $user) {
        
        $orders_count = Order::whereWriterId($user->id)->count();
        $user->orders = $orders_count;
        $user->save();

      }


    $users  = User::whereUserType('client')->get();
      foreach ($users as $key => $user) {
          $wallet_balance = wallet($user->id);
          $user->wallet   = $wallet_balance;
          $user->save();

      }
      

        //update expired accounts
      $users       = User::whereAccountStatus(1)->get();
      foreach ($users as $key => $value) {

        $user = User::find($value->id);
        $created_at = Carbon::parse($user->subscribe_end);
        $day_count = Carbon::parse($current_time)->diffInHours($created_at,false);
        if ($day_count < 0) {

          $user->account_status = 0;
          $user->save();

          $data = [
           'subscribe_start'     => $user->subscribe_start,
           'subscribe_end'       => $user->subscribe_end,
           'user_id'             => $user->id,
           'package_id'          => $user->package,
           'status'              => 0,
         ];

         $subscription_created = Subscription::create($data); 

         if($subscription_created){


//send sms
          $data=array(
            'name' =>$user->name,
            'email'=>$user->email,
            'sname'=>'Hi '.$user->name.', your Saseni subscription has expired',
            'description'=>'Hi '.$user->name.', your Saseni subscription has just expired. you can login to your account and renew it',

          );


  //     //send email to editor
  //         Mail::send('email.index',$data, function($message) use ($data){
  //           $message->to($data['email']);
  //           $message->subject($data['sname']);

  //         }); 


  // //send sms
  //         $recipients = $user->phone;
  //         $message    = 'Hi '.$user->name.', your Saseni subscription has just expired. you can login to your account and renew it';
  //         sendsms($recipients,$message);
        }


      }
    }


  })->everyFifteenMinutes();
//everyFifteenMinutes();
//everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
      $this->load(__DIR__.'/Commands');

      require base_path('routes/console.php');
    }
  }
