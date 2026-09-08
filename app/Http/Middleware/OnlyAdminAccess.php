<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OnlyAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( ! Auth::check()){
            return redirect()->guest(route('login'))->with('error', trans('app.unauthorized_access'));
        }

         if (domain_name() != admin_domain_name()){
       return redirect(route('dashboard'))->with('error', trans('app.access_restricted'));
      
        }

        $user = Auth::user();

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

if($user->is_writer() or $user->is_client()){
     return redirect(route('dashboard'))->with('error', trans('app.access_restricted'));
} else{
  return redirect(route('activate_code'))->with('error', trans('app.access_restricted'));
}

            
        }

        if ( ! $user->is_admin())
            return redirect(route('dashboard'))->with('error', trans('app.access_restricted'));

        return $next($request);
    }
}
