<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Admin\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Crypt;
use Stripe;
use Symfony\Component\HttpFoundation\RequestStack;

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

        foreach ($result['product'] as $list1) {
            $result['product_images'][$list1->id] =
                DB::table('product_images')
                    ->where(['product_images.products_id' => $list1->id])
                    ->get();
        }

        $result['product_review'] =
            DB::table('product_review')
                ->leftJoin('customers', 'customers.id', '=', 'product_review.customer_id')
                ->where(['product_review.product_id' => $result['product'][0]->id])
                ->where(['product_review.status' => 1])
               ->orderBy('product_review.id','desc')
                ->select('product_review.rating','product_review.review','product_review.added_on',
               'customers.name')
                ->get();


        return view('front.product', $result);
    }

    public function addToCart(Request $request)
    {
        if ($request->session()->has('FRONT_USER_LOGIN')) {
            $uid = $request->session()->get('FRONT_USER_ID');
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
//        $getAvailableQuantity = getAvailableQuantity($product_id,$product_attr_id);
//        prx($getAvailableQuantity);
//
//        $finalAvaliable = $getAvailableQuantity[0]->pquantity-$getAvailableQuantity[0]->quantity;
//        prx($finalAvaliable);
//        if($productQuantity>$finalAvaliable )
//        {
//            return response()->json(['msg' => 'not_available', 'data' => 'only'. $finalAvaliable .'left.']);
//        }
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
            $uid = $request->session()->get('FRONT_USER_ID');
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
        $query = $query->where('name', 'like', "%$str%");
        $query = $query->orwhere('model', 'like', "%$str%");
        $query = $query->orwhere('short_desc', 'like', "%$str%");
        $query = $query->orwhere('desc', 'like', "%$str%");
        $query = $query->orwhere('keywords', 'like', "%$str%");
        $query = $query->orwhere('technical_specification', 'like', "%$str%");
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
        if ($request->session()->has('FRONT_USER_LOGIN') != null) {
            return redirect('/');
        }
//
        return view('front.registration');


    }

    public function registration_process(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required',
            'mobile' => 'required|numeric|digits:10',
        ]);

        if (!$validate->passes()) {
            return response()->json(['status' => 'error', 'error' => $validate->errors()->toArray()]);
        } else {
            $rand_id = rand(1111111111, 9999999999);
            $array = [
                "name" => $request->name,
                "email" => $request->email,
                "password" => Crypt::encrypt($request->password),
                "mobile" => $request->mobile,
                "status" => 1,
                "is_verify" => 0,
                "rand_id" => $rand_id,
                "created_at" => date('Y-m-d h:i:s'),
                "updated_at" => date('Y-m-d h:i:s'),
            ];
            $query = DB::table('customers')->insert($array);
            if ($query) {
                $data = ['name' => $request->name, 'rand_id' => $rand_id];
                $user['to'] = $request->email;
                Mail::send('front.email_verification', $data, function ($messages) use ($user) {
                    $messages->to($user['to']);
                    $messages->subject('Email Verification');
                });
                return response()->json(['status' => 'success', 'msg' => "user has been registered successfully & please check your inbox for verification email."]);
            }
        }
    }

    public function login_process(Request $request)
    {

        $result = DB::table('customers')
            ->where(['email' => $request->str_login_email])
            ->get();

        if (isset($result[0])) {
            $db_pwd = Crypt::decrypt($result[0]->password);
            $status = $result[0]->status;
            $is_verify = $result[0]->is_verify;
            if ($is_verify == 0) {
                return response()->json(['status' => "error", 'msg' => "please verify your email"]);
            }
            if ($status == 0) {
                return response()->json(['status' => "error", 'msg' => "Your account has been deactivated.."]);
            }
            if ($db_pwd == $request->str_login_password) {
                if ($request->rememberme === null) {
                    setcookie('login_email', $request->str_login_email,
                        100);
                    setcookie('login_pwd', $request->str_login_password,
                        100);

                } else {
                    setcookie('login_email', $request->str_login_email,
                        time() + 60 * 60 * 24 * 100);
                    setcookie('login_pwd', $request->str_login_password,
                        time() + 60 * 60 * 24 * 100);
                }
                $request->session()->put('FRONT_USER_LOGIN', true);
                $request->session()->put('FRONT_USER_ID', $result[0]->id);
                $request->session()->put('FRONT_USER_NAME', $result[0]->name);
                $status = "success";
                $msg = "";
                $getUserTempId = getUserTempId();
                DB::table('cart')
                    ->where(['user_id' => $getUserTempId, 'user_type' => 'Not-Reg'])
                    ->update(['user_id' => $result[0]->id, 'user_type' => 'Reg']);
            } else {
                $status = "error";
                $msg = "Please enter valid password";
            }
        } else {
            $status = "error";
            $msg = "Please enter valid email id";
        }
        return response()->json(['status' => $status, 'msg' => $msg]);

    }

    public function logout(Request $request)
    {
        $request->session()->forget('FRONT_USER_LOGIN');
        $request->session()->forget('FRONT_USER_ID');
        $request->session()->forget('FRONT_USER_NAME');
        return redirect('/');
    }

    public function email_verification(Request $request, $id)
    {
        $result = DB::table('customers')
            ->where(['rand_id' => $id])
            ->where(['is_verify' => 0])
            ->get();
        if (isset($result[0])) {
            $result = DB::table('customers')
                ->where(['id' => $result[0]->id])
                ->update(['is_verify' => 1, 'rand_id' => '']);
            return view('front.verification');
        } else {
            return redirect('/');
        }
    }

    public function forget_password(Request $request)
    {

        $result = DB::table('customers')
            ->where(['email' => $request->str_forget_email])
            ->get();
        $rand_id = rand(1111111111, 999999999);
        if (isset($result[0])) {
            DB::table('customers')
                ->where(['email' => $request->str_forget_email])
                ->update(['is_forget_password' => 1, 'rand_id' => $rand_id]);

            $data = ['name' => $result[0]->name, 'rand_id' => $rand_id];
            $user['to'] = $request->str_forget_email;
            Mail::send('front.forget-email', $data, function ($messages) use ($user) {
                $messages->to($user['to']);
                $messages->subject('Forget Password');
            });
            return response()->json(['status' => 'success', 'msg' => "please check your inbox"]);

        } else {
            return response()->json(['status' => 'error', 'msg' => "Email id not registered!!!--"]);
        }
    }

    public function forget_password_change(Request $request, $id)
    {
        $result = DB::table('customers')
            ->where(['rand_id' => $id])
            ->where(['is_forget_password' => 1])
            ->get();
        if (isset($result[0])) {
            $request->session()->put('FORGET_PASSWORD_USER_ID', $result[0]->id);
            return view('front.forget-password');
        } else {
            return redirect('/');
        }
    }

    public function forget_password_change_process(Request $request)
    {
//        dd($request->all());
        $result = DB::table('customers')
            ->where(['id' => $request->session()->get('FORGET_PASSWORD_USER_ID')])
            ->update([
                'is_forget_password' => 0,
                'rand_id' => '',
                'password' => Crypt::encrypt($request->password),
            ]);

        return response()->json(['status' => 'success', 'msg' => "Password change"]);

    }

    public function checkout(Request $request)
    {
        $result['cart_data'] = getAddToCartTotalItem();

        if (isset($result['cart_data'][0])) {
            if ($request->session()->has('FRONT_USER_LOGIN')) {
                $uid = $request->session()->get('FRONT_USER_ID');
                $customer_info = DB::table('customers')
                    ->where(['id' => $uid])
                    ->get();
                $result['customer']['name'] = $customer_info[0]->name;
                $result['customer']['email'] = $customer_info[0]->email;
                $result['customer']['mobile'] = $customer_info[0]->mobile;
                $result['customer']['address'] = $customer_info[0]->address;
                $result['customer']['city'] = $customer_info[0]->city;
                $result['customer']['state'] = $customer_info[0]->state;
                $result['customer']['zip'] = $customer_info[0]->zip;
            } else {
                $result['customer']['name'] = '';
                $result['customer']['email'] = '';
                $result['customer']['mobile'] = '';
                $result['customer']['address'] = '';
                $result['customer']['city'] = '';
                $result['customer']['state'] = '';
                $result['customer']['zip'] = '';

            }
            $uid = $request->session()->get('FRONT_USER_ID');
            $user = DB::table('customers')
                ->where(['id' => $uid])
                ->get();

            return view('front.checkout',
                $result);
        } else {
            return redirect('/');
        }
    }

    public function applyCouponCode(Request $request)
    {
        $array = apply_coupon_code($request->coupon_code);
        $array = json_decode($array, true);
        return response()->json(['status' => $array['status'], 'msg' => $array['msg'], 'totalPrice' => $array['totalPrice']]);
//
    }

    public function remove_coupon_code(Request $request)
    {
        $result = DB::table('coupons')
            ->where(['code' => $request->coupon_code])
            ->get();
        $getAddToCartTotalItem = getAddToCartTotalItem();
        $totalPrice = 0;
        foreach ($getAddToCartTotalItem as $list) {
            $totalPrice = $totalPrice + ($list->quantity * $list->price);
        }

        return response()->json(['status' => 'success', 'msg' => 'coupon code removed', 'totalPrice' => $totalPrice]);
    }

    public function placeOrder(Request $request)
    {

        if ($request->session()->has('FRONT_USER_LOGIN')) {
            $coupon_value = 0;
            if ($request->coupon_code != '') {
                $array = apply_coupon_code($request->coupon_code);
                $array = json_decode($array, true);
                if ($array['status'] === 'success') {
                    $coupon_value = $array['coupon_code_value'];
                } else {
                    return response()->json(['status' => 'error', 'msg' => $array['msg']]);
                }
            }

            $uid = $request->session()->get('FRONT_USER_ID');
            $totalPrice = 0;
            $getAddToCartTotalItem = getAddToCartTotalItem();
            foreach ($getAddToCartTotalItem as $list) {
                $totalPrice = $totalPrice + ($list->quantity * $list->price);
            }
            $array = [
                "customer_id" => $uid,
                "name" => $request->name,
                "email" => $request->email,
                "mobile" => $request->phone,
                "address" => $request->address,
                "city" => $request->city,
                "state" => $request->state,
                "pincode" => $request->zip,
                "coupon_code" => $request->coupon_code,
                "coupon_value" => $coupon_value,
                "order_status" => 1,
                "payment_type" => $request->payment_type,
                "payment_status" => "Pending",
                "added_on" => date('Y-m-d h:i:s'),
                "total_amount" => $totalPrice,
            ];
            $order_id = DB::table('orders')->insertGetId($array);
            if ($order_id > 0) {
                foreach ($getAddToCartTotalItem as $list) {
                    $productDetailArray['product_id'] = $list->product_id;
                    $productDetailArray['product_attributes_id'] = $list->attribute_id;
                    $productDetailArray['price'] = $list->price;
                    $productDetailArray['quantity'] = $list->quantity;
                    $productDetailArray['order_id'] = $order_id;
                    DB::table('order_details')->insert($productDetailArray);
                }
                if ($request->payment_type === 'Gateway') {

                } else {

                }
//            DB::table('cart')
//                ->where(['user_id'=>$uid,'user_type'=>'Reg'])
//                ->delete();

                $request->session()->put('ORDER_ID', $order_id);
                $status = "success";
                $msg = "Order placed";
            } else {
                $status = "error";
                $msg = "Please try after sometime-";
            }
        } else {
            $status = "error";
            $msg = "Please login to place order";
        }

        return response()->json(['status' => $status, 'msg' => $msg]);

    }

    public function orderPlaced(Request $request)
    {
        if ($request->session()->has('ORDER_ID')) {
            return view('front.order_placed');
        } else {
            return redirect('/');
        }
    }

    public function stripe()
    {

        return view('front.stripe');
    }

    public function stripePost(Request $request)
    {

        $stripe = \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $uid = $request->session()->get('FRONT_USER_ID');
        $user = Customer::findorfail($uid);
        $chekout = \Stripe\Checkout\Session::create([
            'payment_method_types' => [
                'card'
            ],
            'line_items' => [[
                'name' => $user->name,
                'amount' => $request->amount,
                'currency' => 'INR',
                'quantity' => 1,
                'description' => 'Product Payment',
            ]],
            'payment_intent_data' => [
                'setup_future_usage' => 'off_session',
            ],
            'mode' => 'payment',
            'success_url' => 'http://local.laravel-ecommerce/success',
            'cancel_url' => 'http://local.laravel-ecommerce/stripe',
        ]);

        $user->addPaymentMethod($request->stripeToken);

        return response()->json(['success' => true, 'message', 'Payment added']);
    }

    public function success(Request $request)
    {
        return view('front.success');
    }

    public function order(Request $request)
    {

        $result['orders'] = DB::table('orders')
            ->select('orders.*', 'order_status.order_status')
            ->leftJoin('order_status', 'order_status.id', '=', 'orders.order_status')
            ->where(['orders.customer_id' => $request->session()->get('FRONT_USER_ID')])
            ->get();

        return view('front.order', $result);
    }

    public function orderDetails(Request $request, $id)
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
                ->where(['customer_id' => $request->session()->get('FRONT_USER_ID')])
                ->get();
        if (!isset($result['order_details'][0])) {
            return redirect('/');
        }
        return view('front.order_detail', $result);
    }

    public function product_review_process(Request $request)
    {
        if ($request->session()->has('FRONT_USER_LOGIN')) {
            $uid = $request->session()->get('FRONT_USER_ID');
            $array=[
                'rating'=>$request->rating,
                'review'=>$request->review,
                'status'=> 1,
                'product_id'=>$request->product_id,
                'customer_id'=>$uid,
                'added_on'=>date('Y-m-d h:i:s')
            ];
            $query = DB::table('product_review')->insert($array);
            $status = "success";
            $msg = "Thank you for providing your feedback.";
        }
        else {
            $status = "error";
            $msg = "Please login to submit your review:-";
        }

        return response()->json(['status' => $status, 'msg' => $msg]);

    }
}
