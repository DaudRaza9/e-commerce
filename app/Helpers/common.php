<?php

use Illuminate\Support\Facades\DB;

function prx($arr)
{
    echo "<pre>";
    print_r($arr);
    die();
}

function getTopNavCategory(){
    $result = DB::table('categories')
        ->where(['status'=>1])
        ->get();
    $arr=[];
    foreach ($result as $row){
        $arr[$row->id]['category_name']=$row->category_name;
        $arr[$row->id]['parent_id']=$row->parent_category_id;
        $arr[$row->id]['category_slug']=$row->category_slug;
    }
    $str = buildTreeView($arr,0);
    return $str;
}

$html='';
function buildTreeView($arr,$parent,$level=0,$prelevel= -1){
    global $html;
    foreach($arr as $id=>$data){
        if($parent==$data['parent_id']){
            if($level>$prelevel){
                if($html==''){
                    $html.='<ul class="nav navbar-nav">';
                }else{
                    $html.='<ul class="dropdown-menu">';
                }
            }
            if($level==$prelevel){
                $html.='</li>';
            }
            $html.='<li><a href="category/'.$data['category_slug'].'">'.$data['category_name'].'<span class="caret"></span></a>';
            if($level>$prelevel){
                $prelevel=$level;
            }
            $level++;
            buildTreeView($arr,$id,$level,$prelevel);
            $level--;
        }
    }
    if($level==$prelevel){
        $html.='</li></ul>';
    }
    return $html;
}

function getUserTempId(){
    if(!session()->has('USER_TEMP_ID')){
        $rand=rand(111111111,999999999);
        session()->put('USER_TEMP_ID',$rand);
        return $rand;
    }
    else{
        return session()->get('USER_TEMP_ID');
    }
}

function getAddToCartTotalItem(){
    if (session()->has('FRONT_USER_LOGIN')) {
        $uid = session()->get('FRONT_USER_ID');
        $user_type = "Reg";
    } else {
        $uid = getUserTempId();
        $user_type = "Not-Reg";
    }

    $result  = DB::table('cart')
        ->leftJoin('products', 'products.id', '=', 'cart.product_id')
        ->leftJoin('product_attributes', 'product_attributes.id', '=', 'cart.product_attr_id')
        ->leftJoin('sizes', 'sizes.id', '=', 'product_attributes.size_id')
        ->leftJoin('colors', 'colors.id', '=', 'product_attributes.color_id')
        ->where(['user_id' => $uid])
        ->where(['user_type' => $user_type])
        ->select('products.id as product_id', 'product_attributes.id as attribute_id', 'products.name', 'products.slug', 'cart.quantity', 'products.image', 'sizes.size', 'colors.color', 'product_attributes.price')
        ->get();

    return $result;
}
