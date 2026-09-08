<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
 // $orders  = User::all();
 // foreach ($orders as $key => $order) {

 //       $slug = Str::slug($order->name);


 //       $order->slug = $slug.'-'.$order->id;

 //             $order->save();
 //     # code...
 // }



    }

      function createSlug($title){

     

    }
}
