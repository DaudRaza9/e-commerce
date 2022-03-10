<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $category['data'] = Product::all();
        return view('admin.product.product',$category);
    }

    public function manageProduct(){

        return view('admin.product.manageProduct');
    }
    public function insert(Request $request){
        $request->validate([
            'name'=>'required',
            'slug'=>'required|unique:products,slug,'.$request->post('id'),
        ]);

        $category = new Product();
        $category->category_id=$request->post('category');
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
        $msg = "Product inserted";
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

            $product = Product::findorfail($id);
        return view('admin.product.manageProduct',['product'=>$product]);
    }

    public function update(Request $request){
        Validator::make($request->all(),[
        'name'=>'required',
        'slug'=>'required|unique:products,slug,'.$request->post('id')
        ]);

        $product = Product::findorfail($request->id);
        $product->name =$request->name;
        $product->slug =$request->slug;
        $product->image =$request->image;
        $product->category_id =$request->category;
        $product->brand =$request->brand;
        $product->model =$request->model;
        $product->short_desc =$request->short_desc;
        $product->desc =$request->desc;
        $product->keywords =$request->keywords;
        $product->technical_specification =$request->technical_specification;
        $product->uses =$request->uses;
        $product->warranty =$request->warranty;
        $product->save();

        $msg = "Product updated";
        $request->session()->flash('message',$msg);
        return redirect('admin/product');

    }
    public function status(Request $request,$status,$id){
        $product = Product::findorfail($id);
        $product->status=$status;
        $product->save();
        $request->session()->flash('message','Product status updated');
        return redirect('admin/product');
    }

}
