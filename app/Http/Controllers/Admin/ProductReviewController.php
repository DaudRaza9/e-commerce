<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductReviewController extends Controller
{
    public function index()
    {
        $result['product_review'] =
            DB::table('product_review')
                ->leftJoin('customers', 'customers.id', '=', 'product_review.customer_id')
                ->leftJoin('products', 'products.id', '=', 'product_review.product_id')
                ->orderBy('product_review.id','desc')
                ->select('product_review.rating','product_review.review','product_review.added_on','product_review.id',
                    'customers.name','products.name as pname','product_review.status')
                ->get();
//prx($result['product_review']);
        return view('admin.product-review.index',$result);

    }


    public  function update_product_review_status(Request $request,$status,$id)
    {
        DB::table('product_review')
            ->where(['id'=>$id])
            ->update(['status'=>$status]);

        return redirect('/admin/product/review');
    }


}
