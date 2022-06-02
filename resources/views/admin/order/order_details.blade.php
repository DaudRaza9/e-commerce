@extends('admin.layout')
@section('page_title','Order details')
@section('order_select','active')
@section('container')

    <h3>Order details - {{$order_details[0]->id}}</h3>
    <div class="order_operation">
        <b>Update Order status</b>
{{--        {{prx($order_details[0])}}--}}
        <select name="order_status" id="order_status" class="form-control m-b-10" onchange="update_order_status('{{$order_details[0]->id}}')">

            @foreach($order_status_data as $list)

                @if($order_details[0]->order_status == $list->order_status)
                    <option value="{{$list->id}}" selected>{{$list->order_status}}</option>
                @else
                    <option value="{{$list->id}}">{{$list->order_status}}</option>
                @endif
            @endforeach

        </select>

        <b>Update Payment Status</b>
        <select name="payment_status" id="payment_status" class="form-control m-b-10" onchange="update_payment_status('{{$order_details[0]->id}}')">

                @foreach($payment_status as $list)
                    @if($order_details[0]->payment_status == $list)
                        <option value="{{$list}}" selected>{{$list }}</option>
                    @else
                        <option value="{{$list}}">{{$list}}</option>
                    @endif
                @endforeach
        </select>
        <b>Track Details</b>
        <form method="post">
            <textarea name="track_details" id="" required class="form-control m-b-10" cols="30" rows="10">{{$order_details[0]->track_details}}</textarea>
            <button type="submit" class="btn btn-success">
               Update
            </button>
            @csrf
        </form>
    </div>
    <div class="row m-t-30 order-details-background">
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
                if ($order_details[0]->payment_id != '') {
                    echo ' Payment Id : ' . $order_details[0]->payment_id;
                }
                ?>
                <br>
            </div>
        </div>

        <div class="col-md-12">
            <div class="cart-view-area">

                <div class="cart-view-table">


                        <div class="table-responsive">
                            <table class="table order_detail">
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
                                        <td><img src="{{asset('storage/products-attr/'.$list->attr_image)}}" alt="">
                                        </td>
                                        <td>{{$list->color}}</td>
                                        <td>{{$list->size}}</td>
                                        <td>{{$list->price}}</td>
                                        <td>{{$list->quantity}}</td>
                                        <td>{{$list->price*$list->quantity}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                    <td><b>Total</b></td>
                                    <td><b>{{$totalAmount}}</b></td>
                                </tr>
                                <?php
                                if ($order_details[0]->coupon_value > 0)
                                    echo '<td colspan="5">&nbsp; </td>
                                            <td><b>Coupon <span class="coupon_apply_txt">(' . $order_details[0]->coupon_code . ')<span></b></td>
                                            <td><b> ' . $order_details[0]->coupon_value . '</b></td>';
                                $totalAmount = $totalAmount - $order_details[0]->coupon_value;
                                echo '<tr><td colspan="5">&nbsp; </td>
                                            <td><b>Final Total</b></td>
                                            <td><b> ' . $totalAmount . '</b></td></tr>';
                                ?>
                                </tbody>
                            </table>
                        </div>

                    <!-- Cart Total view -->

                </div>
            </div>
        </div>
    </div>

@endsection
