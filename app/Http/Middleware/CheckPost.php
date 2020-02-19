<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\AdminModel\Admin;



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
                $str=$request->path();
                $url=explode('_', $str);
                $crud= array('C','R','U','D');

                if (in_array($url[0], $crud))
                {
                // echo "Unexpected problem ssssssssssssssssssssssssssssss!!!";  
                 // die;
                    $access=session()->get('access');
                    for($i=0; $i<sizeof($access); $i++)
                    {
                        if(in_array($url[1], $access[$i]))
                        {
                             // echo $access[$i]['access_name'];
                            $previllages=session()->get('previllages');
                            $previllage=$previllages[$i];

                            if($url[0]=='C')
                                $allow_Access=$previllage['create'];
                            elseif($url[0]=='R')
                                $allow_Access=$previllage['read'];
                            elseif($url[0]=='U')
                                $allow_Access=$previllage['update'];
                            elseif($url[0]=='D')
                                $allow_Access=$previllage['delete'];

                            if ($allow_Access==1) 
                            {
                                return $next($request);   
                            }
                            else
                            {
                                echo "you have no Access of this Page Sorry go back to previous page.";
                                die;
                            }

                           // echo $i+1;
                        }
                    }
                }
                else
                {
                    echo "Check crud is not working";  
                    die;
                }
                //echo $str;
                echo "Unexpected problem !!!";  
                die;
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
