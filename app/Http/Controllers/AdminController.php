<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if($request->session()->has('ADMIN.LOGIN')){
            return redirect('admin/dashboard');
        }else{
            return view('admin.login');
        }
        return view('admin.login');
    }

    public function auth(Request $request)
    {
        $email=$request->post('email');
        $password=$request->post('password');

        $result=Admin::where(['email'=>$email])->first();
        if($result){
            if(Hash::check($request->post('password'),$result->password)){
            $request->session()->put('ADMIN.LOGIN',true);
            $request->session()->put('ADMIN.LOGIN',$result->id);
            return redirect('admin/dashboard');
            }else{
                $request->session()->flash('error', 'please enter correct password');
                return redirect('admin');
            }

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
