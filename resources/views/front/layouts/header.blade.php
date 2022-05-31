<!-- Start header section -->
<header id="aa-header">
    <!-- start header top  -->
    <div class="aa-header-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="aa-header-top-area">
                        <!-- start header top left -->
                        <div class="aa-header-top-left">
                            <!-- start currency -->
                            <div class="aa-currency">
                                <div class="dropdown">
                                    <a class="btn dropdown-toggle" href="#" type="button" id="dropdownMenu1"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <i class="fa fa-usd"></i>USD
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        <li><a href="#"><i class="fa fa-euro"></i>EURO</a></li>
                                        <li><a href="#"><i class="fa fa-jpy"></i>YEN</a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- / currency -->
                            <!-- start cellphone -->
                            <div class="cellphone hidden-xs">
                                <p><span class="fa fa-phone"></span>00-62-658-658</p>
                            </div>
                            <!-- / cellphone -->
                        </div>
                        <!-- / header top left -->
                        <div class="aa-header-top-right">
                            <ul class="aa-head-top-nav-right">
                                <li><a href="javascript:void(0)">My Account</a></li>
                                <li class="hidden-xs"><a href="javascript:void(0)">Wishlist</a></li>
                                <li class="hidden-xs"><a href="{{url('/cart')}}">My Cart</a></li>
                                <li class="hidden-xs"><a href="{{url('/checkout')}}">Checkout</a></li>
                                @if(session()->has('FRONT_USER_LOGIN')!=null)
                                    <li><a href="{{url('/logout')}}">Logout</a></li>
                                @else
                                    <li><a href="" data-toggle="modal" data-target="#login-modal">Login</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / header top  -->

    <!-- start header bottom  -->
    <div class="aa-header-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="aa-header-bottom-area">
                        <!-- logo  -->
                        <div class="aa-logo">
                            <!-- Text based logo -->
                            <a href="{{route('index')}}">
                                <span class="fa fa-shopping-cart"></span>
                                <p>daily<strong>Shop</strong> <span>Your Shopping Partner</span></p>
                            </a>
                            <!-- img based logo -->
                            <!-- <a href="javascript:void(0)"><img src="img/logo.jpg" alt="logo img"></a> -->
                        </div>
                        <!-- / logo  -->
                        <!-- cart box -->
                        @php
                            $getAddToCartTotalItem = getAddToCartTotalItem();

                            $totalCartItem=count($getAddToCartTotalItem);

                            $total_price=0;
                        @endphp
                        <div class="aa-cartbox">
                            <a class="aa-cart-link" href="#" id="cartBox">
                                <span class="fa fa-shopping-basket"></span>
                                <span class="aa-cart-title">SHOPPING CART</span>
                                <span class="aa-cart-notify">{{$totalCartItem}}</span>
                            </a>
                            <div class="aa-cartbox-summary">
                                @if($totalCartItem)


                                    <ul>
                                        @foreach($getAddToCartTotalItem as $cartItem)
                                            {{ $total_price = $total_price+($cartItem->quantity*$cartItem->price)}}
                                            <li>
                                                <a class="aa-cartbox-img" href="#"><img
                                                        src="{{asset('storage/products/'.$cartItem->image)}}" alt="img"></a>
                                                <div class="aa-cartbox-info">
                                                    <h4><a href="#">{{$cartItem->name}}</a></h4>
                                                    <p>{{$cartItem->quantity}} * Rs {{$cartItem->price}}</p>
                                                </div>
                                                <a class="aa-remove-product" href="#"><span class="fa fa-times"></span></a>
                                            </li>
                                        @endforeach
                                        <li>
                      <span class="aa-cartbox-total-title">
                        Total
                      </span>
                                            <span class="aa-cartbox-total-price">
                        Rs {{$total_price}}
                      </span>
                                        </li>
                                    </ul>
                                    <a class="aa-cartbox-checkout aa-primary-btn"
                                       href="{{url('/cart')}}">Cart</a>

                                @endif
                            </div>
                        </div>
                        <!-- / cart box -->
                        <!-- search box -->
                        <div class="aa-search-box">
                            <form action="">
                                <input type="text" id="search_str" placeholder="Search here ex. 'man' ">
                                <button type="button" onclick="funSearch()"><span class="fa fa-search"></span></button>
                            </form>
                        </div>
                        <!-- / search box -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / header bottom  -->
</header>
<!-- / header section -->
