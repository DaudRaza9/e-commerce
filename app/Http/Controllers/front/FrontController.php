<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Crypt;

class FrontController extends Controller
{
    public function index(Request $request)
    {

        $result['home_categories'] = DB::table('categories')
            ->where(['status' => 1])
            ->where(['is_home' => 1])
            ->get();

        foreach ($result['home_categories'] as $list) {
            $result['home_categories_product'][$list->id] = DB::table('products')
                ->where(['status' => 1])
                ->where(['category_id' => $list->id])
                ->get();

            foreach ($result['home_categories_product'][$list->id] as $list1) {
                $result['home_product_attribute'][$list1->id] =
                    DB::table('product_attributes')
                        ->leftJoin('sizes', 'sizes.id', '=', 'product_attributes.size_id')
                        ->leftJoin('colors', 'colors.id', '=', 'product_attributes.color_id')
                        ->where(['product_attributes.products_id' => $list1->id])
                        ->get();
            }
        }

        $result['home_brand'] = DB::table('brands')
            ->where(['status' => 1])
            ->where(['is_home' => 1])
            ->get();

        $result['home_featured_product'][$list->id] = DB::table('products')
            ->where(['status' => 1])
            ->where(['is_featured' => 1])
            ->get();

        foreach ($result['home_featured_product'][$list->id] as $list1) {
            $result['home_featured_product_attribute'][$list1->id] =
                DB::table('product_attributes')
                    ->leftJoin('sizes', 'sizes.id', '=', 'product_attributes.size_id')
                    ->leftJoin('colors', 'colors.id', '=', 'product_attributes.color_id')
                    ->where(['product_attributes.products_id' => $list1->id])
                    ->get();
        }

        $result['home_discounted_product'][$list->id] = DB::table('products')
            ->where(['status' => 1])
            ->where(['is_discounted' => 1])
            ->get();

        foreach ($result['home_discounted_product'][$list->id] as $list1) {
            $result['home_discounted_product_attribute'][$list1->id] =
                DB::table('product_attributes')
                    ->leftJoin('sizes', 'sizes.id', '=', 'product_attributes.size_id')
                    ->leftJoin('colors', 'colors.id', '=', 'product_attributes.color_id')
                    ->where(['product_attributes.products_id' => $list1->id])
                    ->get();
        }

        $result['home_tranding_product'][$list->id] = DB::table('products')
            ->where(['status' => 1])
            ->where(['is_tranding' => 1])
            ->get();

        foreach ($result['home_tranding_product'][$list->id] as $list1) {
            $result['home_tranding_product_attribute'][$list1->id] =
                DB::table('product_attributes')
                    ->leftJoin('sizes', 'sizes.id', '=', 'product_attributes.size_id')
                    ->leftJoin('colors', 'colors.id', '=', 'product_attributes.color_id')
                    ->where(['product_attributes.products_id' => $list1->id])
                    ->get();
        }

        $result['home_banner'] = DB::table('home_banners')
            ->where(['status' => 1])
            ->get();
        return view('front.index', $result);
    }

    public function product(Request $request, $slug)
    {

        $result['product'] = DB::table('products')
            ->where(['status' => 1])
            ->where(['slug' => $slug])
            ->get();

        foreach ($result['product'] as $list1) {
            $result['product_attributes'][$list1->id] =
                DB::table('product_attributes')
                    ->leftJoin('sizes', 'sizes.id', '=', 'product_attributes.size_id')
                    ->leftJoin('colors', 'colors.id', '=', 'product_attributes.color_id')
                    ->where(['product_attributes.products_id' => $list1->id])
                    ->get();
        }

        $result['related_product'] = DB::table('products')
            ->where(['status' => 1])
            ->where('slug', '!=', $slug)
            ->where(['category_id' => $result['product'][0]->category_id])
            ->get();

        foreach ($result['related_product'] as $list1) {
            $result['related_product_attributes'][$list1->id] =
                DB::table('product_attributes')
                    ->leftJoin('sizes', 'sizes.id', '=', 'product_attributes.size_id')
                    ->leftJoin('colors', 'colors.id', '=', 'product_attributes.color_id')
                    ->where(['product_attributes.products_id' => $list1->id])
                    ->get();
        }
//       echo '<pre>';
//       prx($result);
//       die();
        foreach ($result['product'] as $list1) {
            $result['product_images'][$list1->id] =
                DB::table('product_images')
                    ->where(['product_images.products_id' => $list1->id])
                    ->get();
        }

        return view('front.product', $result);
    }

    public function addToCart(Request $request)
    {
        if ($request->session()->has('FRONT_USER_LOGIN')) {
            $uid = $request->session()->get('FRONT_USER_LOGIN');
            $user_type = "Reg";
        } else {
            $uid = getUserTempId();
            $user_type = "Not-Reg";
        }
        $size_id = $request->post('size_id');
        $color_id = $request->post('color_id');
        $productQuantity = $request->post('product_quantity');
        $product_id = $request->post('product_id');

        $result = DB::table('product_attributes')
            ->select('product_attributes.id')
            ->leftJoin('sizes', 'sizes.id', '=', 'product_attributes.size_id')
            ->leftJoin('colors', 'colors.id', '=', 'product_attributes.color_id')
            ->where(['sizes.size' => $size_id])
            ->where(['products_id' => $product_id])
            ->where(['colors.color' => $color_id])
            ->get();

        $product_attr_id = $result[0]->id;
        $check = DB::table('cart')
            ->where(['user_id' => $uid])
            ->where(['user_type' => $user_type])
            ->where(['product_id' => $product_id])
            ->where(['product_attr_id' => $product_attr_id])
            ->get();

        if (isset($check[0])) {
            $update_id = $check[0]->id;
            if ($productQuantity == 0) {
                DB::table('cart')
                    ->where(['id' => $update_id])
                    ->delete();
                $msg = "removed";
            } else {
                DB::table('cart')
                    ->where(['id' => $update_id])
                    ->update(['quantity' => $productQuantity]);

                $msg = "updated";
            }
        } else {
            $id = DB::table('cart')->insertGetId([
                'user_id' => $uid,
                'user_type' => $user_type,
                'product_id' => $product_id,
                'product_attr_id' => $product_attr_id,
                'quantity' => $productQuantity,
                'added_on' => date('Y-m-d h:i:s')
            ]);
            $msg = 'added';
        }

        $result = DB::table('cart')
            ->leftJoin('products', 'products.id', '=', 'cart.product_id')
            ->leftJoin('product_attributes', 'product_attributes.id', '=', 'cart.product_attr_id')
            ->leftJoin('sizes', 'sizes.id', '=', 'product_attributes.size_id')
            ->leftJoin('colors', 'colors.id', '=', 'product_attributes.color_id')
            ->where(['user_id' => $uid])
            ->where(['user_type' => $user_type])
            ->select('products.id as product_id', 'product_attributes.id as attribute_id', 'products.name', 'products.slug', 'cart.quantity', 'products.image', 'sizes.size', 'colors.color', 'product_attributes.price')
            ->get();

        return response()->json(['msg' => $msg, 'data' => $result, 'totalItem' => count($result)]);
    }

    public function cart(Request $request)
    {
        if ($request->session()->has('FRONT_USER_LOGIN')) {
            $uid = $request->session()->get('FRONT_USER_LOGIN');
            $user_type = "Reg";
        } else {
            $uid = getUserTempId();
            $user_type = "Not-Reg";
        }
        $result['list'] = DB::table('cart')
            ->leftJoin('products', 'products.id', '=', 'cart.product_id')
            ->leftJoin('product_attributes', 'product_attributes.id', '=', 'cart.product_attr_id')
            ->leftJoin('sizes', 'sizes.id', '=', 'product_attributes.size_id')
            ->leftJoin('colors', 'colors.id', '=', 'product_attributes.color_id')
            ->where(['user_id' => $uid])
            ->where(['user_type' => $user_type])
            ->select('products.id as product_id', 'product_attributes.id as attribute_id', 'products.name', 'products.slug', 'cart.quantity', 'products.image', 'sizes.size', 'colors.color', 'product_attributes.price')
            ->get();


        return view('front.cart', $result);
    }

    public function category(Request $request, $slug)
    {
        $sort = "";
        $sort_txt = "";
        $filter_price_start = "";
        $filter_price_end = "";
        $color_filter = "";
        $colorFilterArray = [];
        if ($request->get('sort') !== null) {
            $sort = $request->get('sort');
        }

        $query = DB::table('products');
        $query = $query->leftJoin('categories', 'categories.id', '=', 'products.category_id');
        $query = $query->leftJoin('product_attributes', 'products.id', '=', 'product_attributes.products_id');
        $query = $query->where(['products.status' => 1]);
        $query = $query->where(['categories.category_slug' => $slug]);
        if ($sort == 'name') {
            $query = $query->orderBy('products.name', 'asc');
            $sort_txt = "Product Name";
        }
        if ($sort == 'date') {
            $query = $query->orderBy('products.id', 'desc');
            $sort_txt = "Date";
        }
        if ($sort == 'price_desc') {
            $query = $query->orderBy('product_attributes.price', 'desc');
            $sort_txt = "Price - DESC";
        }
        if ($sort == 'price_asc') {
            $query = $query->orderBy('product_attributes.price', 'asc');
            $sort_txt = "Price - ASC";
        }
        if ($request->get('filter_price_start') !== null && $request->get('filter_price_end') !== null) {
            $filter_price_start = $request->get('filter_price_start');
            $filter_price_end = $request->get('filter_price_end');
            if ($filter_price_start > 0 && $filter_price_end) {
                $query = $query->whereBetween('product_attributes.price', [$filter_price_start, $filter_price_end]);
            }
        }
        if ($request->get('color_filter') !== null) {
            $color_filter = $request->get('color_filter');
            $colorFilterArray = explode(":", $color_filter);
            $colorFilterArray = array_filter($colorFilterArray);
            $query = $query->where(['product_attributes.color_id' => $request->get('color_filter')]);
        }
        $query = $query->select('products.*');
        $query = $query->get();
        $result['product'] = $query;
        foreach ($result['product'] as $list) {
            $query1 = DB::table('product_attributes');
            $query1 = $query1->leftJoin('sizes', 'sizes.id', '=', 'product_attributes.size_id');
            $query1 = $query1->leftJoin('colors', 'colors.id', '=', 'product_attributes.color_id');
            $query1 = $query1->where(['product_attributes.products_id' => $list->id]);

            $query1 = $query1->get();
            $result['product_attributes'][$list->id] = $query1;
        }
        $result['colors'] = DB::table('colors')
            ->where(['status' => 1])
            ->get();
        $result['categories'] = DB::table('categories')
            ->where(['status' => 1])
            ->get();

        $result['sort'] = $sort;
        $result['slug'] = $slug;
        $result['sort_txt'] = $sort_txt;
        $result['filter_price_start'] = $filter_price_start;
        $result['filter_price_end'] = $filter_price_end;
        $result['color_filter'] = $color_filter;
        $result['colorFilterArray'] = $colorFilterArray;

        return view('front.category',
            $result
        );
    }

    public function search(Request $request, $str)
    {
        $result['product'] =
        $query = DB::table('products');
        $query = $query->leftJoin('categories', 'categories.id', '=', 'products.category_id');
        $query = $query->leftJoin('product_attributes', 'products.id', '=', 'product_attributes.products_id');
        $query = $query->where(['products.status' => 1]);
        $query = $query->where('name' ,'like',"%$str%");
        $query = $query->orwhere('model' ,'like',"%$str%");
        $query = $query->orwhere('short_desc' ,'like',"%$str%");
        $query = $query->orwhere('desc' ,'like',"%$str%");
        $query = $query->orwhere('keywords' ,'like',"%$str%");
        $query = $query->orwhere('technical_specification' ,'like',"%$str%");
        $query = $query->select('products.*');
        $query = $query->get();
        $result['product'] = $query;
        foreach ($result['product'] as $list) {
            $query1 = DB::table('product_attributes');
            $query1 = $query1->leftJoin('sizes', 'sizes.id', '=', 'product_attributes.size_id');
            $query1 = $query1->leftJoin('colors', 'colors.id', '=', 'product_attributes.color_id');
            $query1 = $query1->where(['product_attributes.products_id' => $list->id]);
            $query1 = $query1->get();
            $result['product_attributes'][$list->id] = $query1;
        }

        return view('front.search', $result);
    }

    public function registration(Request $request)
    {
        if($request->session()->has('FRONT_USER_LOGIN')!=null)
        {
            return redirect('/');
        }
//
            return view('front.registration');


    }

    public function registration_process(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:customers,email',
            'password'=>'required',
            'mobile'=>'required|numeric|digits:10',
        ]);

        if(!$validate->passes()){
            return response()->json(['status'=>'error','error'=>$validate->errors()->toArray()]);
        }else{
            $rand_id=rand(1111111111,9999999999);
            $array=[
                "name"=>$request->name,
                "email"=>$request->email,
                "password"=>Crypt::encrypt($request->password),
                "mobile"=>$request->mobile,
                "status"=>1,
                "is_verify"=>0,
                "rand_id"=>$rand_id,
                "created_at"=>date('Y-m-d h:i:s'),
                "updated_at"=>date('Y-m-d h:i:s'),
            ];
            $query = DB::table('customers')->insert($array);
            if($query)
            {
                $data=['name'=>$request->name,'rand_id'=>$rand_id];
                $user['to']=$request->email;
                Mail::send('front.email_verification',$data,function($messages)use
                ($user){
                    $messages->to($user['to']);
                    $messages->subject('Email Verification');
                });
                return response()->json(['status'=>'success','msg'=>"user has been registered successfully & please check your inbox for verification email."]);
            }
        }
    }

    public function login_process(Request $request)
    {

        $result=DB::table('customers')
            ->where(['email'=>$request->str_login_email])
            ->get();

        if(isset($result[0])){
            $db_pwd=Crypt::decrypt($result[0]->password);
            $status=$result[0]->status;
            $is_verify=$result[0]->is_verify;
            if($is_verify==0)
            {
                return response()->json(['status'=>"error",'msg'=>"please verify your email"]);
            }
            if($status==0)
            {
                return response()->json(['status'=>"error",'msg'=>"Your account has been deactivated.."]);
            }
            if($db_pwd==$request->str_login_password){
                if($request->rememberme === null)
                {
                    setcookie('login_email',$request->str_login_email,
                        100);
                    setcookie('login_pwd',$request->str_login_password,
                        100);

                }
                else{
                    setcookie('login_email',$request->str_login_email,
                    time()+60*60*24*100);
                    setcookie('login_pwd',$request->str_login_password,
                    time()+60*60*24*100);
                }
                $request->session()->put('FRONT_USER_LOGIN',true);
                $request->session()->put('FRONT_USER_ID',$result[0]->id);
                $request->session()->put('FRONT_USER_NAME',$result[0]->name);
                $status="success";
                $msg="";
            }else{
                $status="error";
                $msg="Please enter valid password";
            }
        }
        else{
            $status="error";
            $msg="Please enter valid email id";
        }
        return response()->json(['status'=>$status,'msg'=>$msg]);

    }

    public function logout(Request $request)
    {
        $request->session()->forget('FRONT_USER_LOGIN');
        $request->session()->forget('FRONT_USER_ID');
        $request->session()->forget('FRONT_USER_NAME');
        return redirect('/');
    }

    public function email_verification(Request $request,$id)
    {
        $result=DB::table('customers')
            ->where(['rand_id'=>$id])
            ->where(['is_verify'=>0])
            ->get();
         if(isset($result[0]))
         {
             $result=DB::table('customers')
                 ->where(['id'=>$result[0]->id])
                 ->update(['is_verify'=>1,'rand_id'=>'']);
             return view('front.verification');
         }
         else{
             return redirect('/');
         }
    }

    public function forget_password(Request $request)
    {

        $result=DB::table('customers')
            ->where(['email'=>$request->str_forget_email])
            ->get();
        $rand_id = rand(1111111111,999999999);
        if(isset($result[0])){
            DB::table('customers')
                ->where(['email'=>$request->str_forget_email])
                ->update(['is_forget_password'=>1,'rand_id'=>$rand_id]);

            $data=['name'=>$result[0]->name,'rand_id'=>$rand_id];
            $user['to']=$request->str_forget_email;
            Mail::send('front.forget-email',$data,function($messages)use
            ($user){
                $messages->to($user['to']);
                $messages->subject('Forget Password');
            });
            return response()->json(['status'=>'success','msg'=>"please check your inbox"]);

        }
        else
        {
            return response()->json(['status'=>'error','msg'=>"Email id not registered!!!--"]);
        }
    }

    public function forget_password_change(Request $request,$id)
    {
        $result=DB::table('customers')
            ->where(['rand_id'=>$id])
            ->where(['is_forget_password'=>1])
            ->get();
        if(isset($result[0]))
        {
            $request->session()->put('FORGET_PASSWORD_USER_ID',$result[0]->id);
            return view('front.forget-password');
        }
        else{
            return redirect('/');
        }
    }

    public function forget_password_change_process(Request $request)
    {
//        dd($request->all());
        $result=DB::table('customers')
            ->where(['id'=>$request->session()->get('FORGET_PASSWORD_USER_ID')])
            ->update([
                'is_forget_password'=>0,
                'rand_id'=>'',
                'password'=> Crypt::encrypt($request->password),
            ]);

        return response()->json(['status'=>'success','msg'=>"Password change"]);

    }
}
