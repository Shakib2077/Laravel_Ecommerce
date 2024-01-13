<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function index()
    {
        $result['data']=Coupon::all();
        return view('admin.coupon', $result);
    }

    public function manage_coupon(Request $request, $id = '')
    {
        $result['id'] = $id;

        if ($id > 0) {
            $arr['data'] = Coupon::where(['id' => $id])->get();

            if (!$arr['data']->isEmpty()) {
                $result['title'] = $arr['data'][0]->title;
                $result['code'] = $arr['data'][0]->code;
                $result['value'] = $arr['data'][0]->value;
            } else {
                $result['title'] = '';
                $result['code'] = '';
                $result['value'] = '';
            }
        } else {
            $result['title'] = '';
            $result['code'] = '';
            $result['value'] = '';
            $result['id'] = 0;
        }

        return view('admin/manage_coupon', $result);
    }

    public function manage_coupon_process(Request $request)
    {

        $request->validate([
            'title'=>'required',
            'code'=>'required|unique:coupons,code,'.$request->post('id'),
            'value'=>'required',
        ]);

        if($request->post('id')>0)
        {
            $model=Coupon::find($request->post('id'));
            $message="Coupon Updated";
        }else{
            $model=new Coupon();
            $message="Coupon Inserted";
        }
        $model->title=$request->post('title');
        $model->code=$request->post('code');
        $model->value=$request->post('value');
        $model->save();
        $request->session()->flash('message', $message);
        return redirect('admin/coupon');
    }

    public function delete(Request $request,$id)
    {
        $model=Coupon::find($id);
        $model->delete();
        $request->session()->flash('message', 'Coupon Deleted');
        return redirect('admin/coupon');
    }

    public function status(Request $request,$status,$id)
    {
        $model=Coupon::find($id);
        $model->status=$status;
        $model->save();
        $request->session()->flash('message', 'Coupon status updated');
        return redirect('admin/coupon');
    }

}