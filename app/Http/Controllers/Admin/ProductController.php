<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Brand;
use App\Http\Controllers\Controller;
use App\Models\Admin\Color;
use App\Models\Admin\Product;
use App\Models\Admin\Size;
use App\Models\Admin\Tax;
use App\Models\Admin\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $category['data'] = Product::all();
        return view('admin.product.product', $category);
    }

    public function manageProduct(Request $request, $id = '')
    {
        if ($id > 0) {
            $arr = Product::where(['id' => $id])->get();

            $result['category_id'] = $arr['0']->category_id;
            $result['name'] = $arr['0']->name;
            $result['image'] = $arr['0']->image;
            $result['slug'] = $arr['0']->slug;
            $result['brand'] = $arr['0']->brand;
            $result['model'] = $arr['0']->model;
            $result['short_desc'] = $arr['0']->short_desc;
            $result['desc'] = $arr['0']->desc;
            $result['keywords'] = $arr['0']->keywords;
            $result['technical_specification'] = $arr['0']->technical_specification;
            $result['uses'] = $arr['0']->uses;
            $result['warranty'] = $arr['0']->warranty;
            $result['lead_time'] = $arr['0']->lead_time;
            $result['tax_id'] = $arr['0']->tax_id;
            $result['is_promo'] = $arr['0']->is_promo;
            $result['is_featured'] = $arr['0']->is_featured;
            $result['is_discounted'] = $arr['0']->is_discounted;
            $result['is_tranding'] = $arr['0']->is_tranding;
            $result['status'] = $arr['0']->status;
            $result['id'] = $arr['0']->id;

            $result['productAttrArr'] = DB::table('product_attributes')->where(['products_id' => $id])->get();

            $productImagesArr = DB::table('product_images')->where(['products_id' => $id])->get();

            if (!isset($productImagesArr[0])) {
                $result['productImagesArr']['0']['id'] = '';
                $result['productImagesArr']['0']['images'] = '';
            } else {
                $result['productImagesArr'] = $productImagesArr;
            }
            //$result['productImagesArr']
        } else {
            $result['category_id'] = '';
            $result['name'] = '';
            $result['slug'] = '';
            $result['image'] = '';
            $result['brand'] = '';
            $result['model'] = '';
            $result['short_desc'] = '';
            $result['desc'] = '';
            $result['keywords'] = '';
            $result['technical_specification'] = '';
            $result['uses'] = '';
            $result['warranty'] = '';
            $result['lead_time'] = '';
            $result['tax_id'] = '';
            $result['is_promo'] = '';
            $result['is_featured'] = '';
            $result['is_discounted'] = '';
            $result['is_tranding'] = '';
            $result['status'] = '';
            $result['id'] = 0;

            $result['productAttrArr'][0]['id'] = '';
            $result['productAttrArr'][0]['products_id'] = '';
            $result['productAttrArr'][0]['sku'] = '';
            $result['productAttrArr'][0]['attr_image'] = '';
            $result['productAttrArr'][0]['mrp'] = '';
            $result['productAttrArr'][0]['price'] = '';
            $result['productAttrArr'][0]['quantity'] = '';
            $result['productAttrArr'][0]['size_id'] = '';
            $result['productAttrArr'][0]['color_id'] = '';

            $result['productImagesArr']['0']['id'] = '';
            $result['productImagesArr']['0']['images'] = '';
            /*echo '<pre>';
            print_r( $result['productAttrArr']);
            die();*/
        }
        /*echo '<pre>';
        print_r( $result);
        die();*/
        $result['category'] = DB::table('categories')->where(['status' => 1])->get();

        $result['sizes'] = DB::table('sizes')->where(['status' => 1])->get();

        $result['colors'] = DB::table('colors')->where(['status' => 1])->get();

        $result['brands'] = DB::table('brands')->where(['status' => 1])->get();

        $result['taxes'] = DB::table('taxes')->where(['status' => 1])->get();
        return view('admin/product/manage-product', $result);
    }

    public function ManageProductProcess(Request $request)
    {
//        echo '<pre>';
//        print_r($request->all());
//        die();
        if ($request->post('id') > 0) {
            $image_validation = "mimes:jpeg,jpg,png";
        } else {
            $image_validation = "required|mimes:jpeg,jpg,png";
        }
        $request->validate([
            'name' => 'required',
            'image' => $image_validation,
            'slug' => 'required|unique:products,slug,' . $request->post('id'),
            'attr_image.*' => 'mimes:jpg,jpeg,png',
            'images.*' => 'mimes:jpg,jpeg,png'
        ]);

        $paidArr = $request->post('paid');
        $skuArr = $request->post('sku');
        $mrpArr = $request->post('mrp');
        $priceArr = $request->post('price');
        $quatityArr = $request->post('quantity');
        $size_idArr = $request->post('size_id');
        $color_idArr = $request->post('color_id');
        foreach ($skuArr as $key => $val) {
            $check = DB::table('product_attributes')->
            where('sku', '=', $skuArr[$key])->
            where('id', '!=', $paidArr[$key])->
            get();

            if (isset($check[0])) {
                $request->session()->flash('sku_error', $skuArr[$key] . ' SKU already used');
                return redirect(request()->headers->get('referer'));
            }
        }

        if ($request->post('id') > 0) {
            $model = Product::find($request->post('id'));
            $msg = "Product updated";
        } else {
            $model = new Product();
            $msg = "Product inserted";
        }

        if ($request->hasfile('image')) {
            if ($request->post('id') > 0) {
                $arrImage = DB::table('products')->where(['id' => $request->post('id')])->get();
                if (Storage::exists('/public/products/' . $arrImage[0]->image)) {
                    Storage::delete('/public/products/' . $arrImage[0]->image);
                }
            }
            $image = $request->file('image');
            $ext = $image->extension();
            $image_name = 'PRODUCT-' . time() . '.' . $ext;
            $image->storeAs('/public/products', $image_name);
            $model->image = $image_name;
        }

        $model->category_id = $request->post('category_id');;
        $model->name = $request->post('name');
        $model->slug = $request->post('slug');
        $model->brand = $request->post('brand');
        $model->model = $request->post('model');
        $model->short_desc = $request->post('short_desc');
        $model->desc = $request->post('desc');
        $model->keywords = $request->post('keywords');
        $model->technical_specification = $request->post('technical_specification');
        $model->uses = $request->post('uses');
        $model->warranty = $request->post('warranty');
        $model->lead_time = $request->post('lead_time');
        $model->tax_id = $request->post('tax_id');
        $model->is_promo = $request->post('is_promo');
        $model->is_featured = $request->post('is_featured');
        $model->is_discounted = $request->post('is_discounted');
        $model->is_tranding = $request->post('is_tranding');
        $model->status = 1;
        $model->save();
        $pid = $model->id;

//        /*--Product Attr Start--*/

        foreach ($skuArr as $key => $val) {
            $productAttrArr = [];
            $productAttrArr['products_id'] = $pid;
            $productAttrArr['sku'] = $skuArr[$key];
            $productAttrArr['mrp'] = (int)$mrpArr[$key];
            $productAttrArr['price'] = (int)$priceArr[$key];
            $productAttrArr['quantity'] = (int)$quatityArr[$key];
            if ($size_idArr[$key] == '') {
                $productAttrArr['size_id'] = 0;
            } else {
                $productAttrArr['size_id'] = $size_idArr[$key];
            }

            if ($color_idArr[$key] == '') {
                $productAttrArr['color_id'] = 0;
            } else {
                $productAttrArr['color_id'] = $color_idArr[$key];
            }
            if ($request->hasFile("attr_image.$key")) {
                if ($paidArr[$key] != '') {
                    $arrImage = DB::table('product_attributes')->where(['id' => $paidArr[$key]])->get();
                    if (Storage::exists('/public/products-attr/' . $arrImage[0]->attr_image)) {
                        Storage::delete('/public/products-attr/' . $arrImage[0]->attr_image);
                    }
                }

                $attr_image = $request->file("attr_image.$key");
                $ext = $attr_image->extension();
                $image_name = 'PRODUCT-ATTRIBUTE-' . time() . '.' . $ext;
                $request->file("attr_image.$key")->storeAs('/public/products-attr', $image_name);
                $productAttrArr['attr_image'] = $image_name;
            }

            if ($paidArr[$key] != '') {
                DB::table('product_attributes')->where(['id' => $paidArr[$key]])->update($productAttrArr);
            } else {
                DB::table('product_attributes')->insert($productAttrArr);
            }

        }

        /*--Product Attr End--*/

        /*--Product Images Start--*/
        $piidArr = $request->post('piid');
        foreach ($piidArr as $key => $val) {
            $productImageArr['products_id'] = $pid;
            if ($request->hasFile("images.$key")) {

                if ($piidArr[$key] != '') {
                    $arrImage = DB::table('product_images')->where(['id' => $piidArr[$key]])->get();
                    if (Storage::exists('/public/products/' . $arrImage[0]->images)) {
                        Storage::delete('/public/products/' . $arrImage[0]->images);
                    }
                }

                $images = $request->file("images.$key");
                $ext = $images->extension();
                $image_name = 'PRODUCTS-' . time() . '.' . $ext;
                $request->file("images.$key")->storeAs('/public/products', $image_name);
                $productImageArr['images'] = $image_name;

                if ($piidArr[$key] != '') {
                    DB::table('product_images')->where(['id' => $piidArr[$key]])->update($productImageArr);
                } else {
                    DB::table('product_images')->insert($productImageArr);
                }

            }
        }

        /*--Product Images End--*/

        $request->session()->flash('message', $msg);
        return redirect('admin/product');

    }


    public function delete(Request $request, $id)
    {
        $category = Product::findorfail($id);
        $category->delete();

        $request->session()->flash('message', 'Product Deleted');
        return redirect('admin/product');
    }

    public function status(Request $request, $status, $id)
    {
        $product = Product::findorfail($id);
        $product->status = $status;
        $product->save();
        $request->session()->flash('message', 'Product status updated');
        return redirect('admin/product');
    }

    public function productAttributeDelete(Request $request, $paid, $pid)
    {
        $arrImage = DB::table('products_attr')->where(['id' => $paid])->get();
        if (Storage::exists('/public/media/' . $arrImage[0]->attr_image)) {
            Storage::delete('/public/media/' . $arrImage[0]->attr_image);
        }
        DB::table('products_attr')->where(['id' => $paid])->delete();
        return redirect('admin/product/manage_product/' . $pid);
    }

    public function imageDelete(Request $request, $paid, $pid)
    {
        $arrImage = DB::table('product_images')->where(['id' => $paid])->get();
        if (Storage::exists('/public/media/' . $arrImage[0]->images)) {
            Storage::delete('/public/media/' . $arrImage[0]->images);
        }
        DB::table('product_images')->where(['id' => $paid])->delete();
        return redirect('admin/product/manage_product/' . $pid);
    }

}
