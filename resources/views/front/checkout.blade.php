@extends('front.layouts.master')
@section('page_title','Checkout')
@section('content')

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
                        <form id="frmPlaceOrder">
                            @csrf
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
                                                                    <textarea cols="8" rows="3" name="address">{{$customer['address']}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="aa-checkout-single-bill">
                                                                    <input type="text" placeholder="City / Town*"  name="city"  value="{{$customer['city']}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="aa-checkout-single-bill">
                                                                    <input type="text"  name="state" placeholder="state*"  value="{{$customer['state']}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="aa-checkout-single-bill">
                                                                    <input type="text" placeholder="Postcode / ZIP*" name="zip" value="{{$customer['zip']}}"  >
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


                                                <tr class="hide show_coupon_box">
                                                    <th>Coupon Code <a href="javascript:void(0)" onclick="remove_coupon_code()" class="remove_coupon_code">Remove coupon code</a> </th>
                                                    <td id="coupon_code_str"></td>
                                                </tr>
                                                <tr>
                                                    <th>Total</th>
                                                    <td id="total_price">Rs {{$totalPrice}}</td>
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
                                                    <input type="text" name="coupon_code" id="coupon_code" placeholder="Coupon Code" class="aa-coupon-code apply_coupon_code w-100">
                                                    <br><input type="button" name="coupon_code" onclick="applyCouponCode()" value="Apply Coupon" class="aa-browse-btn apply_coupon_code w-100">
                                                    <div id="coupon_code_msg" style="color: red;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <h4>Payment Method</h4>
                                        <div class="aa-payment-method">
                                            <label for="cod"><input type="radio" value="COD" id="cod" name="payment_type" checked> Cash on Delivery </label>

                                            <label for="stripe"><input type="radio"  value="Gateway" id="stripe" name="payment_type"> Via Stripe </label>

                                            <input type="submit" value="Place Order" class="aa-browse-btn">
                                        </div>
                                        <div id="order_place_msg"></div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>


@endsection

<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');

    const elements = stripe.elements();
    const cardElement = elements.create('card');

    cardElement.mount('#card-element');

    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;

    cardButton.addEventListener('click', async (e) => {
        const { setupIntent, error } = await stripe.confirmCardSetup(
            clientSecret, {
                payment_method: {
                    card: cardElement,
                    billing_details: { name: cardHolderName.value }
                }
            }
        );

        if (error) {
             jQuery('#order_place_msg').html("Card is not verified");
        } else {
            jQuery('#order_place_msg').html("Card is verified");
        }
    });
</script>
