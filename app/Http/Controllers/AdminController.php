<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function auth(Request $request)
    {
        $email=$request->post('email');
        $password=$request->post('password');

        $result=Admin::where(['email'=>$email,'password'=>$password])->get();
        if(isset($result['0']->id)){
            $request->session()->put('ADMIN.LOGIN',true);
            $request->session()->put('ADMIN.LOGIN',$result['0']->id);
            return redirect('admin/dashboard');

        }else{
            $request->session()->flash('error', 'please enter valid login details');
            return redirect('admin');
        }
    }
    public function dashboard()
    {
        return view('admin.dashboard');
    }

}
