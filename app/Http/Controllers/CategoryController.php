<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $result['data']=Category::all();
        return view('admin.category', $result);
    }

    public function manage_category(Request $request, $id = '')
    {
        $result['id'] = $id;

        if ($id > 0) {
            $arr['data'] = Category::where(['id' => $id])->get();

            if (!$arr['data']->isEmpty()) {
                $result['category_name'] = $arr['data'][0]->category_name;
                $result['category_slug'] = $arr['data'][0]->category_slug;
            } else {
                $result['category_name'] = '';
                $result['category_slug'] = '';
            }
        } else {
            $result['category_name'] = '';
            $result['category_slug'] = '';
            $result['id'] = 0;
        }

        return view('admin/manage_category', $result);
    }

    public function manage_category_process(Request $request)
    {

        $request->validate([
            'category_name'=>'required',
            'category_slug'=>'required|unique:categories,category_slug,'.$request->post('id'),
        ]);

        if($request->post('id')>0)
        {
            $model=Category::find($request->post('id'));
            $message="Category Updated";
        }else{
            $model=new Category();
            $message="Category Inserted";
        }
        $model->category_name=$request->post('category_name');
        $model->category_slug=$request->post('category_slug');
        $model->save();
        $request->session()->flash('message', $message);
        return redirect('admin/category');
    }

    public function delete(Request $request,$id)
    {
        $model=Category::find($id);
        $model->delete();
        $request->session()->flash('message', 'Category Deleted');
        return redirect('admin/category');
    }

}
