<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Model\Admin;

//*****Created By Usman Abbas*******//
class AdminController extends Controller
{
    public function loginView()
	{
        $email=session()->get('email');
        if (!empty($email))
        {
            $admin = Admin::where('email', $email)->first();   
            $Auth_token=session()->get('Auth_token');
            if ($Auth_token==$admin->Auth_token) 
            {
                 return redirect()->route('Home');
            }
        }
        
        session()->forget('Auth_token');
        // dd(session());
		return view('loginSignup.login');
	}

    public function adminDetails()
    {
        $Admins=Admin::all();
        return view('Pages.Admins.AdminDetails',compact('Admins'));
    }

    public function registerAdmin_view()
    {
        return view('Pages.Admins.createAdmin');
    }

    public function editAdmin_view($id)
    {
        $admin=Admin::where('admin_id',$id)->first();
        return view('Pages.Admins.editAdmin',compact('admin'));
    }
    public function registerAdmin(Request $request)
    {
        $this->validate($request,
                                [ 
                                    'admin_name' => 'required|min:3|max:50',
                                    'email' => 'required|email',
                                    'password' => 'required|min:6',
                                    'confirmpassword' => 'required|same:password|min:6'
                                     ]);

        $admin=Admin::where('email',$request->email)->first();
        if (empty($admin)) 
        {
            $auth_token=$this->random();
            $input['admin_name']=$request->admin_name;
            $input['email']=$request->email;
            $input['password']=Hash::make($request->password);
            $input['status']=1;
            $input['updatedMaxAmt']=0;
            $input['updatedPercentage']=0;
            $input['Auth_token']=session()->get('Auth_token');
            
            $admin=Admin::create($input);
            
            return redirect()->route('Admin.details');
        }
        else
        {   
            session()->flash('emailStatus', 'Email is Already Avaliable Select another');
            return redirect()->route('Admin.register');
        }
    }

    public function deleteAdmin($admin_id)
    {
        $status=Admin::where('admin_id',$admin_id)->delete();
        return redirect()->route('Admin.details');
    }

    public function editAdmin(Request $request)
    {
         $this->validate($request,
                                [ 
                                    'admin_name' => 'required|min:3|max:50',
                                    'email' => 'required|email',
                                    'confirmpassword' => 'same:password|min:6'
                                     ]);
          $auth_token=$this->random();
            $input['admin_name']=$request->admin_name;
            $input['email']=$request->email;
            if (!empty($request->password))
            {
                $input['password']=Hash::make($request->password);                
            }
            $input['status']=1;
            $input['updatedMaxAmt']=0;
            $input['updatedPercentage']=0;
            $input['Auth_token']=session()->get('Auth_token');
            
            $admin=Admin::where('admin_id',$request->admin_id)->update($input);
            
            return redirect()->route('Admin.details');
    }

    public function login(Request $request)
    {

        $this->validate($request,Admin::$login_validation_rules);
    	if (!empty($request->email))
        {
            $admin = Admin::where('email', $request->email)->first();
        }

        if (!empty($admin)) 
        {
                if (Hash::check($request->password, $admin->password)) 
                {
                    $auth_token=$this->random();
                    session()->put([
                                     'admin_id'=>$admin->admin_id,
                                     'admin_name'=>$admin->admin_name,
                                     'email'=>$admin->email,
                                     'allow_access'=> '1',
                                     'Auth_token'=>$auth_token
                                   ]);
                    Admin::where('admin_id', $admin->admin_id)->update(['Auth_token' => $auth_token]);
                    return redirect()->route('Home');
                }
                else
                {
                      return view('loginSignup.login');
                }
        
        }
        else
        {
            
        }
    }

    
    public function Register(Request $request)
    {
    	$Admin=new Admin();
        $input=$request->all();
        $auth_token=$this->random();
        $input['Password']=Hash::make($request->Password);
        $input['Auth_token']=$auth_token;
        $Admin->fill($input)->save();
    }

    public function logout()
    {
         session()->forget('Auth_token');
         return redirect()->route('Home');
    }

    public static function random($length = 16)
    {
        if ( ! function_exists('openssl_random_pseudo_bytes'))
        {
            throw new RuntimeException('OpenSSL extension is required.');
        }

        $bytes = openssl_random_pseudo_bytes($length * 2);

        if ($bytes === false)
        {
            throw new RuntimeException('Unable to generate random string.');
        }

        return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $length);
    }
}
