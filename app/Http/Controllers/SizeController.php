<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $category['data'] = Size::all();
        return view('admin.size.size',$category);
    }

    public function manageSize(){
        $result['size']='';
        $result['status']='';
        $result['id']=0;
        return view('admin.size.manageSize',$result);
    }
    public function insert(Request $request){

        $request->validate([
            'size'=>'required|unique:sizes,size,'.$request->post('id'),
        ]);

        if($request->post('id')>0){
            $category = Size::find($request->post('id'));
            $msg = "Size updated";
        }else{
            $category = new Size();
            $msg = "Size inserted";

        }
        $category->size=$request->post('size');
        $category->status=1;
        $category->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/size');
    }

    public function delete(Request $request,$id){
        $category = Size::findorfail($id);
        $category->delete();
        $request->session()->flash('message','Size Deleted');
        return redirect('admin/size');
    }

    public function edit(Request $request,$id){
        if($id>0){
            $arr = Size::where(['id'=>$id])->get();
            $result['size']=$arr['0']->size;
            $result['id']=$arr['0']->id;
        }else{
            $result['size']='';
            $result['id']=0;
        }
        return view('admin.size.manageSize',$result);
    }
    public function status(Request $request,$status,$id){
        $category = Size::findorfail($id);
        $category->status=$status;
        $category->save();
        $request->session()->flash('message','Size status updated');
        return redirect('admin/size');
    }
}
