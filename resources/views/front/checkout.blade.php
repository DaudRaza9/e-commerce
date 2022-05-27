@extends('front.layouts.layout')
@section('page_title','Checkout')
@section('container')

    <!-- catg header banner section -->
    <section id="aa-catg-head-banner">
        <div class="aa-catg-head-banner-area">
            <div class="container">

            </div>
        </div>
    </section>
    <!-- / catg header banner section -->


    <!-- Cart view section -->
    <section id="checkout">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="checkout-area">
                        <form action="">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="checkout-left">
                                        <div class="panel-group" id="accordion">

                                            <!-- Login section -->


                                        @if(session()->has('FRONT_USER_LOGIN')==null)

                                                <div class="panel panel-default aa-checkout-login">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a href="" data-toggle="modal" data-target="#login-modal">Login</a>
                                                        </h4>
                                                    </div>
                                            </div>
                                        @endif
                                               <!-- Shipping Address -->
                                            <div class="panel panel-default aa-checkout-billaddress">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                                                            User Details address
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseFour" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="aa-checkout-single-bill">
                                                                    <input type="text" name="name" required placeholder="Name*" value="{{$customer['name']}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="aa-checkout-single-bill">
                                                                    <input type="email" placeholder="Email Address*" name="email" required value="{{$customer['email']}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="aa-checkout-single-bill">
                                                                    <input type="tel" placeholder="Phone*" name="phone" required  value="{{$customer['mobile']}}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="aa-checkout-single-bill">
                                                                    <textarea cols="8" rows="3" name="address" required>{{$customer['address']}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="aa-checkout-single-bill">
                                                                    <input type="text" placeholder="Appartment, Suite etc.">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="aa-checkout-single-bill">
                                                                    <input type="text" placeholder="City / Town*" value="{{$customer['city']}}" name="city" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="aa-checkout-single-bill">
                                                                    <input type="text" placeholder="state*" value="{{$customer['state']}}" required name="state">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="aa-checkout-single-bill">
                                                                    <input type="text" placeholder="Postcode / ZIP*" value="{{$customer['zip']}}" required name="zip">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="checkout-right">
                                        <h4>Order Summary</h4>
                                        <div class="aa-order-summary-area">
                                            <table class="table table-responsive">
                                                <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Total</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php
                                                $totalPrice=0;

                                                @endphp
                                                @foreach($cart_data as $list)
                                                    @php
                                                    $totalPrice=$totalPrice+($list->price*$list->quantity)
                                                    @endphp
                                                <tr>
                                                    <td>{{$list->name}} <strong> x  {{$list->quantity}}
                                                        </strong>
                                                        <br>
                                                       <span class="cart_color"> {{$list->color}}</span>
                                                    </td>
                                                    <td>Rs {{$list->price*$list->quantity}}</td>
                                                </tr>
                                                @endforeach

                                                </tbody>
                                                <tfoot>


                                                <tr>
                                                    <th>Total</th>
                                                    <td>Rs {{$totalPrice}}</td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <!-- Coupon section -->
                                        <div class="panel panel-default aa-checkout-coupon">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                                        Have a Coupon?
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseOne" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <input type="text" placeholder="Coupon Code" class="aa-coupon-code">
                                                    <input type="submit" value="Apply Coupon" class="aa-browse-btn">
                                                </div>
                                            </div>
                                        </div>
                                        <h4>Payment Method</h4>
                                        <div class="aa-payment-method">
                                            <label for="cashdelivery"><input type="radio" id="cashdelivery" name="optionsRadios"> Cash on Delivery </label>
                                            <label for="paypal"><input type="radio" id="paypal" name="optionsRadios" checked> Via Paypal </label>
                                            <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" border="0" alt="PayPal Acceptance Mark">
                                            <input type="submit" value="Place Order" class="aa-browse-btn">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- / Cart view section -->
@endsection

