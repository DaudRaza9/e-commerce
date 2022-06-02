@extends('front.layouts.master')
@section('page_title','Order Details')
@section('content')


    <!-- catg header banner section -->
    <section id="aa-catg-head-banner">
        <div class="aa-catg-head-banner-area">
            <div class="container">

            </div>
        </div>
    </section>
    <!-- / catg header banner section -->

    <section id="cart-view">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="address_detail">
                        <h3>Details Address</h3>
                        {{$order_details[0]->name}}( {{$order_details[0]->mobile}}) <br>
                        {{$order_details[0]->address}} <br>
                        {{$order_details[0]->city}} <br>
                        {{$order_details[0]->state}} <br>
                        {{$order_details[0]->pincode}} <br>
                    </div>

                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="address_detail">
                        <h3>Order Details</h3>
                        Order status : {{$order_details[0]->order_status}}<br>
                        Payment status : {{$order_details[0]->payment_status}}<br>
                        Payment type : {{$order_details[0]->payment_type}}<br>
                        <?php
                        if($order_details[0]->payment_id!='')
                        {
                        echo ' Payment Id : '.$order_details[0]->payment_id;
                        }
                        ?>
                       <br>
                    </div>
                   <b> Track Details </b><br>
                    {{$order_details[0]->track_details}}
                </div>

                <div class="col-md-12">
                    <div class="cart-view-area">

                        <div class="cart-view-table">
                            <form action="">

                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>

                                            <th>Product</th>
                                            <th>Image</th>
                                            <th>Size</th>
                                            <th>Color</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                        $totalAmount = 0;
                                        @endphp
                                        @foreach($order_details as $list)
                                            @php
                                                $totalAmount = $totalAmount+($list->price*$list->quantity);
                                            @endphp
                                            <tr>
                                                <td><br>{{$list->pname}}</td>
                                                <td><img src="{{asset('storage/products-attr/'.$list->attr_image)}}" alt=""> </td>
                                                <td>{{$list->color}}</td>
                                                <td>{{$list->size}}</td>
                                                <td>{{$list->price}}</td>
                                                <td>{{$list->quantity}}</td>
                                                <td>{{$list->price*$list->quantity}}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="5">&nbsp; </td>
                                            <td><b>Total</b></td>
                                            <td><b>{{$totalAmount}}</b></td>
                                        </tr>
                                        <?php
                                        if($order_details[0]->coupon_value>0)
                                            echo '<td colspan="5">&nbsp; </td>
                                            <td><b>Coupon <span class="coupon_apply_txt">('.$order_details[0]->coupon_code.')<span></b></td>
                                            <td><b> '.$order_details[0]->coupon_value.'</b></td>';
                                        $totalAmount = $totalAmount-$order_details[0]->coupon_value;
                                        echo '<tr><td colspan="5">&nbsp; </td>
                                            <td><b>Final Total</b></td>
                                            <td><b> '.$totalAmount.'</b></td></tr>';
                                        ?>
                                        </tbody>
                                    </table>
                                </div>


                            </form>
                            <!-- Cart Total view -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" id="quantity" value="1"/>
    <form id="fromAddToCart">
        @csrf
        <input type="hidden" id="size_id" name="size_id"/>
        <input type="hidden" id="color_id" name="color_id"/>
        <input type="hidden" id="product_quantity" name="product_quantity"/>
        <input type="hidden" id="product_id" name="product_id"/>

    </form>
@endsection

