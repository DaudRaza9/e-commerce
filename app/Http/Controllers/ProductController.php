<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $category['data'] = Product::all();
        return view('admin.product.product', $category);
    }

    public function createProduct()
    {
        $size = Size::all();
        $color = Color::all();
        $productAttributesData['productAttributes'][0]['products_id'] = '';
        $productAttributesData['productAttributes'][0]['sku'] = '';
        $productAttributesData['productAttributes'][0]['attr_image'] = '';
        $productAttributesData['productAttributes'][0]['mrp'] = '';
        $productAttributesData['productAttributes'][0]['price'] = '';
        $productAttributesData['productAttributes'][0]['qty'] = '';
        $productAttributesData['productAttributes'][0]['size_id'] = '';
        $productAttributesData['productAttributes'][0]['color_id'] = '';
        $productAttributesData['productAttributes'][0]['images'] = '';
        $productAttributesData['productAttributes'][0]['id'] = '';

//        $productAttributesImages['productAttributes'][0]['id'] = '';
//        $productAttributesImages['productAttributes'][0]['products_id'] = '';
//        $productAttributesImages['productAttributes'][0]['images'] = '';
        $productAttributesImages['productAttributes'][0]['']='';
        return view('admin.product.manageProduct', ['size' => $size, 'color' => $color, 'productAttributesData' => $productAttributesData, 'productAttributesImages ' => $productAttributesImages]);
    }

    public function insert(Request $request)
    {

//        echo '<pre>';
//        print_r($request->post());
//        die();
        $request->validate([
            'name' => 'required',
//            'image'=>'required|mimes:jpeg,jpg,png',
            'slug' => 'required|unique:products,slug',
            'attr_images.*' => 'mimes:jpg,jpeg,png',
            'images.*' => 'mimes:jpg,jpeg,png',
        ]);

        $product = new Product();
        $product->category_id = $request->post('category');
        $product->name = $request->post('name');
        $product->slug = $request->post('slug');
        $product->brand = $request->post('brand');
        $product->model = $request->post('model');
        $product->short_desc = $request->post('short_desc');
        $product->desc = $request->post('desc');
        $product->keywords = $request->post('keywords');
        $product->technical_specification = $request->post('technical_specification');
        $product->uses = $request->post('uses');
        $product->warranty = $request->post('warranty');
        $product->status = 1;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->extension();
            $imageName = 'PRODUCT-' . time() . '.' . $extension;
            $image->storeAs('public/media', $imageName);
            $product->image = $imageName;
        }

        $product->save();

        //---Product attributes---//
        $productId = $product->id;
        $skuArray = $request->post('sku');
        $mrpArray = $request->post('mrp');
        $attrImageArray = $request->post('attr_image');
        $priceArray = $request->post('price');
        $quantityArray = $request->post('quantity');
        $sizeArray = $request->post('size');
        $colorArray = $request->post('color');

        foreach ($skuArray as $key => $val) {
            $productAttributes['products_id'] = $productId;
            $productAttributes['sku'] = $skuArray[$key];
            $productAttributes['attr_image'] = 'test';
            $productAttributes['mrp'] = $mrpArray[$key];
            $productAttributes['price'] = $priceArray[$key];
            $productAttributes['quantity'] = $quantityArray[$key];
            if ($request->hasFile('attr_image')) {
                $attrImage = $request->file('attr_image');
                $attrExtension = $attrImage[$key]->extension();
                $attrImageName[$key] = 'PRODUCT-Attr-' . time() . '.' . $attrExtension;
                $attrImage[$key]->storeAs('public/products-attr', $attrImageName[$key]);
                $productAttributes['attr_image'] = $attrImageName[$key];
            }
            if ($sizeArray[$key] == '') {
                $productAttributes['size_id'] = 0;

            } else {
                $productAttributes['size_id'] = $sizeArray[$key];
            }
            if ($colorArray[$key] == '') {
                $productAttributes['color_id'] = 0;

            } else {
                $productAttributes['color_id'] = $colorArray[$key];
            }
            DB::table('product_attributes')->insert($productAttributes);
        }

        //---Product Images---//
        $pIId = $request->post('pIId');

        foreach ($pIId as $key => $val) {
            $productImageArray['products_id'] = $productId;
            if ($request->hasFile('images' . $key)) {
                $productImages = $request->file('images');
                $imageExtension = $productImages[$key]->extension();
                $imageName[$key] = 'PRODUCT-' . time() . '.' . $imageExtension;
                $productImages[$key]->storeAs('public/products', $imageName[$key]);
                $productImageArray['images'] = $imageName[$key];
            } else {
                $productImageArray['images'] = '';
            }
            DB::table('product_images')->insert($productImageArray);
        }
        $msg = "Product inserted";
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

    public function edit(Request $request, $id)
    {
        $product = Product::findorfail($id);
        $productAttributesData = ProductAttribute::select('*')
            ->where('products_id', $id)->get();
        $productAttributesImages = DB::table('product_images')
            ->where('products_id', '=', $id)->get();

        return view('admin.product.manageProduct', ['product' => $product, 'productAttributesData' => $productAttributesData, 'productAttributesImages' => $productAttributesImages]);
    }

    public function update(Request $request)
    {
//        echo '<pre>';
//        print_r($request->post());
//        die();
        Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png',
            'slug' => 'required|unique:products,slug,' . $request->post('id'),
            'attr_image.*' => 'required|mimes:jpg,jpeg,png',
            'images.*' => 'required|mimes:jpg,jpeg,png',
        ]);

        $product = Product::findorfail($request->id);
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->image = $request->image;
        $product->category_id = $request->category;
        $product->brand = $request->brand;
        $product->model = $request->model;
        $product->short_desc = $request->short_desc;
        $product->desc = $request->desc;
        $product->keywords = $request->keywords;
        $product->technical_specification = $request->technical_specification;
        $product->uses = $request->uses;
        $product->warranty = $request->warranty;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->extension();
            $imageName = 'PRODUCT-' . time() . '.' . $extension;
            $image->storeAs('public/products', $imageName);
            $product->image = $imageName;
        }
        $product->save();

        //---Product attributes---//
        $productId = $product->id;
        $skuArray = $request->post('sku');
        $PAA = $request->post('paId');
        $mrpArray = $request->post('mrp');
        $priceArray = $request->post('price');
        $quantityArray = $request->post('quantity');
        $sizeArray = $request->post('size');
        $colorArray = $request->post('color');

        foreach ($skuArray as $key => $val) {
            $check = DB::table('product_attributes')->where('sku', '=', $skuArray[$key])
                ->where('id', '!=', $PAA[$key])->get();
            if (isset($check[0])) {
                $request->session()->flash('sku-error', $skuArray[$key] . ' Sku already used');
                return redirect(request()->headers->get('referer'));
            }

            $productAttributes['products_id'] = $productId;
            $productAttributes['sku'] = $skuArray[$key];
            if ($request->hasFile('attr_image')) {
                $attrImage = $request->file('attr_image');
                $attrExtension = $attrImage[$key]->extension();
                $attrImageName[$key] = 'PRODUCT-ATTR-' . time() . '.' . $attrExtension;
                $attrImage[$key]->storeAs('public/products-attr', $attrImageName[$key]);
                $productAttributes['attr_image'] = $attrImageName[$key];
            }
            $productAttributes['mrp'] = $mrpArray[$key];
            $productAttributes['price'] = $priceArray[$key];
            $productAttributes['quantity'] = $quantityArray[$key];
            if ($sizeArray[$key] == '') {
                $productAttributes['size_id'] = 0;
            } else {
                $productAttributes['size_id'] = $sizeArray[$key];
            }
            if ($colorArray[$key] == '') {
                $productAttributes['color_id'] = 0;
            } else {
                $productAttributes['color_id'] = $colorArray[$key];
            }

            if ($PAA[$key] != '') {
                DB::table('product_attributes')->where('id', $PAA[$key])->update($productAttributes);
            } else {
                DB::table('product_attributes')->insert($productAttributes);
            }
        }

        //---Product Images---//
        $pIId = $request->post('pIId');
        foreach ($pIId as $key => $val) {
            $productImageArray['products_id'] = $productId;
            if ($request->hasFile('images')) {
                $productImages = $request->file('images');
                $imageExtension = $productImages->extension();
                $ImageName = 'PRODUCT-' . time() . '.' . $imageExtension;
                $productImages->storeAs('public/products', $ImageName);
                $productImageArray['images'] = $ImageName;
            }
            if ($pIId[$key] != '') {
                DB::table('product_images')->where('id', $pIId[$key])->update($productImageArray);
            } else {
                DB::table('product_images')->insert($productImageArray);
            }
        }

        $msg = "Product updated";
        $request->session()->flash('message', $msg);
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

    public function imageDelete(Request $request, $pId, $pIId)
    {
        DB::table('product_images')->where(['id' => $pIId])->delete();

        return redirect('admin/product/edit/' . $pId);
    }

}
