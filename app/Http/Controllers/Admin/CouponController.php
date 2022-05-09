<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupon['data'] = Coupon::all();
        return view('admin.coupon.coupon',$coupon);
    }

    public function manageCoupon(){
        $result['title']='';
        $result['code']='';
        $result['value']='';
        $result['id']=0;
        $result['type']=0;
        $result['minimum_order_amount']=0;
        $result['is_one_time']=0;
        return view('admin.coupon.manageCoupon',$result);
    }
    public function insert(Request $request){

        $request->validate([
            'title'=>'required',
            'code'=>'required|unique:coupons,code,'.$request->post('id'),
            'value'=>'required',
        ]);

        if($request->post('id')>0){
            $coupon = Coupon::find($request->post('id'));
            $msg = "Coupon updated";
        }else{
            $coupon = new Coupon();
            $msg = "Coupon inserted";
            $coupon->status=1;

        }
        $coupon->title=$request->post('title');
        $coupon->code=$request->post('code');
        $coupon->value=$request->post('value');
        $coupon->type=$request->post('type');
        $coupon->minimum_order_amount=$request->post('minimum_order_amount');
        $coupon->is_one_time=$request->post('is_one_time');
        $coupon->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/coupon');
    }

    public function delete(Request $request,$id){
        $category = Coupon::findorfail($id);
        $category->delete();
        $request->session()->flash('message','Coupon Deleted');
        return redirect('admin/coupon');
    }

    public function edit(Request $request,$id){
        if($id>0){
            $arr = Coupon::where(['id'=>$id])->get();
            $result['title']=$arr['0']->title;
            $result['code']=$arr['0']->code;
            $result['value']=$arr['0']->value;
            $result['type']=$arr['0']->type;
            $result['minimum_order_amount']=$arr['0']->minimum_order_amount;
            $result['is_one_time']=$arr['0']->is_one_time;
            $result['id']=$arr['0']->id;
        }else{
            $result['title']='';
            $result['code']='';
            $result['value']='';
            $result['id']='';
            $result['type']='';
            $result['minimum_order_amount']='';
            $result['is_one_time']='';
        }
        return view('admin.coupon.manageCoupon',$result);
    }
    public function status(Request $request,$status,$id){
        $category = Coupon::findorfail($id);
        $category->status=$status;
        $category->save();
        $request->session()->flash('message','Coupon Status updated');
        return redirect('admin/coupon');
    }
}
