<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    public function index()
    {
        $tax = Tax::all();
        return view('admin.tax.tax',['tax'=>$tax]);
    }

    public function manageTax(){
        $result['tax_desc']='';
        $result['tax_value']='';
        $result['id']=0;
        return view('admin.tax.manage-tax',$result);
    }
    public function insert(Request $request){

        $request->validate([
            'tax_value'=>'required|unique:taxes,tax_value,'.$request->post('id'),
            'tax_desc'=>'required'
        ]);


        if($request->post('id')>0){
            $category = Tax::find($request->post('id'));
            $msg = "Tax updated";
        }else{
            $category = new Tax();
            $msg = "Tax inserted";

        }
        $category->tax_desc=$request->post('tax_desc');
        $category->tax_value=$request->post('tax_value');
        $category->status=1;
        $category->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/tax');
    }

    public function delete(Request $request,$id){
        $category = Tax::findorfail($id);
        $category->delete();
        $request->session()->flash('message','Tax Deleted');
        return redirect('admin/tax');
    }

    public function edit(Request $request,$id){
        if($id>0){
            $arr = Tax::where(['id'=>$id])->get();
            $result['tax_desc']=$arr['0']->tax_desc;
            $result['tax_value']=$arr['0']->tax_value;
            $result['id']=$arr['0']->id;
        }else{
            $result['tax_desc']='';
            $result['tax_value']='';
            $result['id']=0;
        }
        return view('admin.tax.manage-tax',$result);
    }
    public function status(Request $request,$status,$id){
        $category = Tax::findorfail($id);
        $category->status=$status;
        $category->save();
        $request->session()->flash('message','Tax status updated');
        return redirect('admin/tax');
    }

    public function selectTax(Request $request){
        $size = Tax::select('taxes.id','taxes.tax_desc','taxes.tax_value');
        return response()->json($size->paginate(5, ['*'], 'page', $request->page));

    }
}
