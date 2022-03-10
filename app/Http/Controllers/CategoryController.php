<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $category['data'] = Category::all();
        return view('admin.category.category',$category);
    }

    public function manageCategory(){
        $result['category_name']='';
        $result['category_slug']='';
        $result['id']=0;
        return view('admin.category.manageCategory',$result);
    }
    public function insert(Request $request){

        $request->validate([
            'category_name'=>'required',
            'category_slug'=>'required|unique:categories,category_slug,'.$request->post('id'),
        ]);

        if($request->post('id')>0){
            $category = Category::find($request->post('id'));
            $msg = "Category updated";
        }else{
            $category = new Category();
            $msg = "Category inserted";

        }
        $category->category_name=$request->post('category_name');
        $category->category_slug=$request->post('category_slug');
        $category->status=1;
        $category->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/category');
    }

    public function delete(Request $request,$id){
        $category = Category::findorfail($id);
        $category->delete();
        $request->session()->flash('message','Category Deleted');
        return redirect('admin/category');
    }

    public function edit(Request $request,$id){
        if($id>0){
            $arr = Category::where(['id'=>$id])->get();
            $result['category_name']=$arr['0']->category_name;
            $result['category_slug']=$arr['0']->category_slug;
            $result['id']=$arr['0']->id;
        }else{
            $result['category_name']='';
            $result['category_slug']='';
            $result['id']=0;
        }
        return view('admin.category.manageCategory',$result);
    }
    public function status(Request $request,$status,$id){
        $category = Category::findorfail($id);
        $category->status=$status;
        $category->save();
        $request->session()->flash('message','Category status updated');
        return redirect('admin/category');
    }

    public function selectCategories(Request $request){
        $category = Category::select('categories.id','categories.category_name');
        return response()->json($category->paginate(5, ['*'], 'page', $request->page));
    }
}
