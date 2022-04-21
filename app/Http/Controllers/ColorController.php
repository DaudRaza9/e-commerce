<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $category['data'] = Color::all();
        return view('admin.color.color',$category);
    }

    public function manageColor(){
        $result['color']='';
        $result['status']='';
        $result['id']=0;
        return view('admin.color.manageColor',$result);
    }
    public function insert(Request $request){

        $request->validate([
            'color'=>'required|unique:colors,color,'.$request->post('id'),
        ]);


        if($request->post('id')>0){
            $category = Color::find($request->post('id'));
            $msg = "Color updated";
        }else{
            $category = new Color();
            $msg = "Color inserted";

        }
        $category->color=$request->post('color');
        $category->status=1;
        $category->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/color');
    }

    public function delete(Request $request,$id){
        $category = Color::findorfail($id);
        $category->delete();
        $request->session()->flash('message','Color Deleted');
        return redirect('admin/color');
    }

    public function edit(Request $request,$id){
        if($id>0){
            $arr = Color::where(['id'=>$id])->get();
            $result['color']=$arr['0']->color;
            $result['id']=$arr['0']->id;
        }else{
            $result['color']='';
            $result['id']=0;
        }
        return view('admin.color.manageColor',$result);
    }
    public function status(Request $request,$status,$id){
        $category = Color::findorfail($id);
        $category->status=$status;
        $category->save();
        $request->session()->flash('message','Color status updated');
        return redirect('admin/color');
    }

    public function selectColor(Request $request){
        $size = Color::select('colors.id','colors.color');
        return response()->json($size->paginate(5, ['*'], 'page', $request->page));

    }
}
