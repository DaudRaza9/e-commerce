<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Admin\ProductAttribute;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    //
    public function delete(Request $request,$pId,$pAId){

           $productAttr = ProductAttribute::findorfail($pAId);
            $productAttr->delete();

            return redirect('admin/product/edit/'.$pId);
    }

}
