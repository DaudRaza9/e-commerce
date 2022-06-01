@extends('front.layouts.master')
@section('page_title','Order')
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
                <div class="col-md-12">
                    <div class="cart-view-area">
                        <div class="cart-view-table">
                            <form action="">

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>

                                                <th>Order Id</th>
                                                <th>Payment Status</th>
                                                <th>Order Status</th>
                                                <th>Total amount</th>
                                                <th>Placed at</th>
                                                <th>Payment Id</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($orders as $list )
                                                <tr>

                                                    <td class="order_id_btn"><a href="{{url('order_details/'.$list->id)}}">{{$list->id}}</a></td>
                                                    <td>{{$list->payment_status}}</td>
                                                    <td>{{$list->order_status}}</td>
                                                    <td>{{$list->total_amount}}</td>
                                                    <td>{{$list->payment_id}}</td>
                                                    <td>{{$list->added_on}}</td>
                                                </tr>
                                            @endforeach

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

