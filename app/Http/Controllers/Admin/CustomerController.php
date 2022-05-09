<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = Customer::all();
        return view('admin.customer.index',['customer'=>$customer]);
    }

    public function show(Request $request,$id){
        $customer = Customer::find($id);
        return view('admin.customer.display',['customer'=>$customer]);
    }


    public function status(Request $request,$status,$id){
        $customer = Customer::findorfail($id);
        $customer->status=$status;
        $customer->save();
        $request->session()->flash('message','Customer status updated');
        return redirect('admin/customer');
    }

    public function SelectProductSize(Request $request){
        $size = Size::select('sizes.id','sizes.size');
        return response()->json($size->paginate(5, ['*'], 'page', $request->page));
    }
}
