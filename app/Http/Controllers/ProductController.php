<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $category['data'] = Product::all();
        return view('admin.product.product',$category);
    }

    public function manageProduct(){
        $result['category_id']='';
        $result['name']='';
        $result['image']='';
        $result['slug']='';
        $result['brand']='';
        $result['model']='';
        $result['short_desc']='';
        $result['desc']='';
        $result['keywords']='';
        $result['technical_specification']='';
        $result['uses']='';
        $result['warranty']='';
        $result['status']='';
        $result['id']=0;
        return view('admin.product.manageProduct',$result);
    }
    public function insert(Request $request){

        $request->validate([
            'name'=>'required',
            'slug'=>'required|unique:products,slug,'.$request->post('id'),
        ]);

        if($request->post('id')>0){
            $category = Product::find($request->post('id'));
            $msg = "Product updated";
        }else{
            $category = new Product();
            $msg = "Product inserted";

        }
        $category->category_id=1;
        $category->name=$request->post('name');
        $category->slug=$request->post('slug');
        $category->brand=$request->post('brand');
        $category->model=$request->post('model');
        $category->short_desc=$request->post('short_desc');
        $category->desc=$request->post('desc');
        $category->keywords=$request->post('keywords');
        $category->technical_specification=$request->post('technical_specification');
        $category->uses=$request->post('uses');
        $category->warranty=$request->post('warranty');
        $category->status=1;
        $category->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/product');
    }

    public function delete(Request $request,$id){
        $category = Product::findorfail($id);
        $category->delete();
        $request->session()->flash('message','Product Deleted');
        return redirect('admin/product');
    }

    public function edit(Request $request,$id){
        if($id>0){
            $arr = Product::where(['id'=>$id])->get();
            $result['name']=$arr['0']->name;
            $result['image']=$arr['0']->image;
            $result['slug']=$arr['0']->slug;
            $result['brand']=$arr['0']->brand;
            $result['model']=$arr['0']->model;
            $result['short_desc']=$arr['0']->short_desc;
            $result['desc']=$arr['0']->desc;
            $result['keywords']=$arr['0']->keywords;
            $result['technical_specification']=$arr['0']->technical_specification;
            $result['uses']=$arr['0']->uses;
            $result['warranty']=$arr['0']->warranty;
            $result['status']=$arr['0']->status;
            $result['id']=$arr['0']->id;
        }else{
            $result['name']='';
            $result['image']='';
            $result['slug']='';
            $result['brand']='';
            $result['model']='';
            $result['short_desc']='';
            $result['desc']='';
            $result['keywords']='';
            $result['technical_specification']='';
            $result['uses']='';
            $result['warranty']='';
            $result['status']='';
            $result['id']=0;
        }
        return view('admin.product.manageProduct',$result);
    }
    public function status(Request $request,$status,$id){
        $product = Product::findorfail($id);
        $product->status=$status;
        $product->save();
        $request->session()->flash('message','Product status updated');
        return redirect('admin/product');
    }
}
