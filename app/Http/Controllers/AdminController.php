<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Model\AdminModel\Admin;
use App\Model\AdminModel\Access;
use App\Model\AdminModel\AdminRoles;
use App\Model\AdminModel\Previllages;
use App\Model\AdminModel\SystemRole;

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
		return view('loginSignup.login',compact('Password'));
	}

    public function adminDetails()
    {
        $Admins=DB::table('admin')
                            ->join('admin_role', 'admin_role.admin_id', '=', 'admin.admin_id')
                            ->join('role', 'role.role_id', '=', 'admin_role.role_id')
                            ->get();
        return view('Pages.Admins.AdminDetails',compact('Admins'));
    }

    public function registerAdmin_view()
    {
        $adminRoles=SystemRole::all();
        return view('Pages.Admins.createAdmin',compact('adminRoles'));
    }




    public function editAdmin_view($id)
    {
        $admin=Admin::where('admin_id',$id)->first();
        $SystemRoles=SystemRole::all();
        $adminRole=AdminRoles::where('admin_id',$admin->admin_id)
                    ->leftJoin('role', 'admin_role.role_id', '=', 'role.role_id')->first();


        return view('Pages.Admins.editAdmin',compact('admin','adminRole','SystemRoles'));
    }
    public function registerAdmin(Request $request)
    {
        $this->validate($request,
                                [ 
                                    'admin_name' => 'required|min:3|max:50',
                                    'email' => 'required|email',
                                    'password' => 'required|min:6',
                                    'confirmpassword' => 'required|same:password|min:6',
                                    'role_id'=>'required'
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
            AdminRoles::create(['admin_id'=>$admin->id,'role_id'=>$request->role_id]);

            
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
                                    'confirmpassword' => 'same:password',
                                    'role_id'=>'required'
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
            AdminRoles::where(['admin_id'=>$request->admin_id])->update(['role_id'=>$request->role_id]);
            
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
                    $adminRole=AdminRoles::where('admin_id',$admin->admin_id)->first();
                    $systemRole=SystemRole::where('role_id',$adminRole->role_id)->first();
                    $access=Access::all();
                    $previllages=Previllages::where('role_id',$adminRole->role_id)->get();

                    //var_dump($previllages->toArray());
                    session()->put('access',$access->toArray());
                    session()->put('previllages',$previllages->toArray());
                    session()->put('systemrole',$systemRole->toArray());
                    //  $previllages=session()->get('previllages');
                    //  print_r($previllages[0]);
                    // die;
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
                    session()->flash('Password','Your Password is not macting');
                    $Password=session()->get('Password');
                    if (!empty($Password)) 
                    {
                        echo $Password;
                        die;
                    }
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




    public function getSystemRoles()
    {
        $roles=SystemRole::all();
        $role=session()->get('role');
        return view('Pages.Admins.systemRoles',compact('roles','role'));

    }


    public function newRole()
    {
        $accesses=Access::all();
        return view('Pages.Admins.newRole',compact('accesses'));
    }

    public function registeredNewRole(Request $request)
    {
        $this->validate($request,[ 
                                    'role_name' => 'required|min:3|max:50',
                                 ]);
        $role=SystemRole::create(['role_name'=>$request->role_name,'status'=>'1']);
        $accesses=Access::all();
        foreach ($accesses as $access) 
        {
            $str="access_id".$access->access_id;
            
            if ($request->$str == $access->access_id) 
            {
                $create="create".$request->$str;
                $read= "read".$request->$str;
                $update="update".$request->$str;
                $delete="delete".$request->$str;

                $input=['role_id'=>$role->id, 'access_id'=>$request->$str, 'create'=>0, 'read'=>0, 'update'=>0, 'delete'=>0];
                if (!empty($request->$create)) 
                {
                  $input['create']=1;
                }
                if (!empty($request->$read)) 
                {
                  $input['read']=1;
                }
                if (!empty($request->$update)) 
                {
                  $input['update']=1;
                }
                if (!empty($request->$delete)) 
                {
                  $input['delete']=1;
                }
               Previllages::create($input);
            }
        }
        
        session()->flash('role','A new Role has been created With Previllages');
        return redirect()->route('Admin.roles');

    }



    public function logout()
    {
         session()->forget('Auth_token');
         session()->flush();
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
