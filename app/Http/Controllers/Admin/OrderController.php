<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use http\Exception\RuntimeException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $result['orders'] = DB::table('orders')
            ->select('orders.*','order_status.order_status')
            ->leftJoin('order_status','order_status.id','=','orders.order_status')
            ->get();
        return view('admin.order.index',$result);

    }

    public function order_details(Request $request,$id)
    {

        $result['order_details'] =
            DB::table('order_details')
                ->select('orders.*', 'order_details.price', 'order_details.quantity', 'order_status.order_status',
                    'products.name as pname', 'product_attributes.attr_image', 'sizes.size', 'colors.color')
                ->leftJoin('orders', 'orders.id', '=', 'order_details.order_id')
                ->leftJoin('product_attributes', 'product_attributes.id', '=', 'order_details.product_attributes_id')
                ->leftJoin('products', 'products.id', '=', 'product_attributes.products_id')
                ->leftJoin('sizes', 'sizes.id', '=', 'product_attributes.size_id')
                ->leftJoin('colors', 'colors.id', '=', 'product_attributes.color_id')
                ->leftJoin('order_status', 'order_status.id', '=', 'orders.order_status')
                ->where(['orders.id' => $id])
                ->get();

        $result['order_status_data'] =
            DB::table('order_status')
                ->get();
//        prx($result['order_details'][0]);
//       foreach ($result['order_status_data'] as $list)
//       {
//           if ($result['order_details'][0]->order_status == $list->id)
//           {
//               prx('it true man');
//           }
//           else
//           {
//               prx('false man');
//           }
//       }
        $result['payment_status'] = ['Pending','Success','Fail'];
        return view('admin.order.order_details',$result);

    }

    public  function update_payment_status(Request $request,$status,$id)
    {
        DB::table('orders')
            ->where(['id'=>$id])
            ->update(['payment_status'=>$status]);

        return redirect('/admin/order/order_detail/'.$id);
    }

    public  function update_order_status(Request $request,$status,$id)
    {
        DB::table('orders')
            ->where(['id'=>$id])
            ->update(['order_status'=>$status]);

        return redirect('/admin/order/order_detail/'.$id);
    }

    public function update_track_details(Request $request,$id)
    {
        $track_details = $request->track_details;
        DB::table('orders')
            ->where(['id'=>$id])
            ->update(['track_details'=>$track_details]);
        return redirect('/admin/order/order_detail/'.$id);
    }

}
