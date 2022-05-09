<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brand = Brand::all();
        return view('admin.brand.brand',['brand'=>$brand]);
    }

    public function createBrand(){

        return view('admin.brand.manage-brand');
    }
    public function insert(Request $request){
       $request->validate([
           'brand'=>'required|unique:brands,brand',
           'image'=>'mimes:jpeg,jpg,png',
        ]);

       $brand = new Brand();
       $brand->brand = $request->post('brand');
       if($request->hasFile('image'))
       {
           $image = $request->file('image');
           $extension = $image->extension();
           $imageName = 'BRAND-' . time() . '.' . $extension;
           $image->storeAs('public/brand', $imageName);
           $brand->image = $imageName;
       }
        $brand->is_home=0;
        if($request->post('is_home')!==null){
            $brand->is_home=1;
        }
       $brand->status = 1;
       $msg = "Brand added successfully";
        $brand->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/brand');
    }

    public function delete(Request $request,$id){
        $category = Brand::findorfail($id);
        $category->delete();
        $request->session()->flash('message','Brand Deleted');
        return redirect('admin/brand');
    }

    public function edit(Request $request,$id){
            $brand = Brand::findorfail($id);
        return view('admin.brand.manage-brand',['brand'=>$brand]);
    }

    public function update(Request $request){
        $request->validate([
            'brand'=>'required',
        ]);

        $brand = Brand::findorfail($request->id);
        if($request->hasFile('image'))
        {
            $brandImages = DB::table('brands')->where([
                'id'=>$request->id
            ])->get();
            if(Storage::exists('public/brand/'.$brandImages[0]->image))
            {
                Storage::delete('public/brand/'.$brandImages[0]->image);
            }

            $image = $request->file('image');
            $extension = $image->extension();
            $imageName = 'BRAND-' . time() . '.' . $extension;
            $image->storeAs('public/brand', $imageName);
            $brand->image = $imageName;
        }
        if($request->post('is_home')!==null){
            $brand->is_home=1;
        }else{
            $brand->is_home=0;
        }
        $brand->brand = $request->brand;
        $brand->update();

        $msg = "Brand updated successfully";
        $request->session()->flash('message',$msg);

        return redirect('admin/brand');

    }

    public function status(Request $request,$status,$id){
        $category = Brand::findorfail($id);
        $category->status=$status;
        $category->save();
        $request->session()->flash('message','Brand status updated');
        return redirect('admin/brand');
    }

    public function selectBrand(Request $request){

        $brand = Brand::select('brands.id','brands.brand');
        return response()->json($brand->paginate(5, ['*'], 'page', $request->page));

    }
}
