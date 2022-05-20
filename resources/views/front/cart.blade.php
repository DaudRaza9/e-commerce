@extends('front.layouts.layout')
@section('page_title','Cart Page')
@section('container')


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
                <div class="col-md-12">
                    <div class="cart-view-area">
                        <div class="cart-view-table">
                            <form action="">
                                    @if(isset($list[0]))
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($list as $data)
                                                <tr id="cart_box{{$data->attribute_id  }}">
                                                    <td><a class="remove" href="javascript:void(0)" onclick="deleteCartProduct('{{$data->product_id}}','{{$data->size}}','{{$data->color}}','{{$data->attribute_id}}')"><fa class="fa fa-close"></fa></a></td>
                                                    <td><a href="{{url('product/'.$data->slug)}}"><img src="{{asset('storage/products/'.$data->image)}}" alt="img"></a></td>
                                                    <td><a class="aa-cart-title" href="{{url('product/'.$data->slug)}}">{{$data->name}}</a>
                                                        @if($data->size!='')
                                                            <br/>SIZE: {{$data->size}}
                                                        @endif
                                                        @if($data->color!='')
                                                            <br/>COLOR: {{$data->color}}
                                                        @endif
                                                    </td>
                                                    <td>Rs {{$data->price}}</td>
                                                    <td><input id="quantity{{$data->attribute_id}}" class="aa-cart-quantity" type="number" value="{{$data->quantity}}"
                                                               onchange="updateQuantity(
                                                                   '{{$data->product_id}}',
                                                                   '{{$data->size}}',
                                                                   '{{$data->color}}',
                                                                   '{{$data->attribute_id}}',
                                                                   '{{$data->price}}',
                                                               )"></td>
                                                    <td id="total_price_{{$data->attribute_id}}">Rs {{$data->price*$data->quantity}}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="6" class="aa-cart-view-bottom">
                                                    <input class="aa-cart-view-btn" type="button" value="Checkout">
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <h3>Cart empty</h3>
                                @endif
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

