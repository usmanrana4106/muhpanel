<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Admin;



class CheckPost
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
        $Auth_token=session()->get('Auth_token');
        $email=session()->get('email');
        if (!empty($email)) 
        {
          $admin = Admin::where('email', $email)->first();   
            if($admin->Auth_token == $Auth_token)
            {
                return $next($request);
                // return redirect()->to('home');
            }
            else
            {
                return redirect()->to('/');
            }
        }
        else
        {
            return redirect()->to('/');
        }
      
    }
}
