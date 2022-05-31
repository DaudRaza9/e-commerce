<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

    public function index()
    {
        $category['data'] = Category::all();
        return view('admin.category.category',$category);
    }

    public function manageCategory(){
        return view('admin.category.manage-category');
    }
    public function insert(Request $request){

        $request->validate([
            'category_name'=>'required',
            'category_slug'=>'required|unique:categories,category_slug,'.$request->post('id'),
            'category_image'=>'mimes:jpeg,jpg,png'
        ]);
            $category = new Category();

        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $extension = $image->extension();
            $imageName = 'CATEGORY-' . time() . '.' . $extension;
            $image->storeAs('public/category', $imageName);
            $category->category_image = $imageName;


        }
        $category->is_home=0;
        if($request->post('is_home')!==null){
            $category->is_home=1;
        }
        $category->category_name=$request->post('category_name');
        $category->category_slug=$request->post('category_slug');
        $category->parent_category_id=$request->post('parent_category_id');

        $category->status=1;
        $category->save();
        $msg = "Category inserted successfully";
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
         $category = Category::find($id);
         $parentCategory = Category::where('status',1)->where('id','!=',$id)->get();

        return view('admin.category.manage-category',['category'=>$category,'parentCategory'=>$parentCategory]);
    }
    public function update(Request $request)
    {

        $request->validate([
            'category_name'=>'required',
            'category_slug'=>'required',
            'category_image'=>'mimes:jpeg,jpg,png'
        ]);

        $category = Category::find($request->id);
        if ($request->hasFile('category_image')) {
            $categoryImages = DB::table('categories')->where([
               'id'=>$request->id
            ])->get();
            if(Storage::exists('public/category/'.$categoryImages[0]->category_image))
            {
                Storage::delete('public/category/'.$categoryImages[0]->category_image);
            }

            $image = $request->file('category_image');
            $extension = $image->extension();
            $imageName = 'CATEGORY-' . time() . '.' . $extension;
            $image->storeAs('public/category', $imageName);
            $category->category_image = $imageName;
        }
        if($request->post('is_home')!==null){
            $category->is_home=1;
        }else{
            $category->is_home=0;
        }
        $category->category_name  = $request->category_name;
        $category->category_slug  = $request->category_slug;
        $category->parent_category_id=$request->post('parent_category_id');
//        $category->status = $category->status;
        $category->update();
        $msg = "Category updated successfully";
        $request->session()->flash('message',$msg);

        return redirect('admin/category');
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
