@extends('front.layouts.layout')
@section('page_title','Search')
@section('container')



    <!-- catg header banner section -->
    <section id="aa-catg-head-banner">
        <img src="{{asset('front_assets/img/fashion/fashion-header-bg-8.jpg')}}" alt="fashion img">
        <div class="aa-catg-head-banner-area">
            <div class="container">
                <div class="aa-catg-head-banner-content">
                    <h2>Fashion</h2>
                    <ol class="breadcrumb">
                        <li><a href="">Home</a></li>
                        <li class="active">Women</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- / catg header banner section -->

    <!-- product category -->
    <section id="aa-product-category">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-8">
                    <div class="aa-product-catg-content">

                        <div class="aa-product-catg-body">
                            <ul class="aa-product-catg">
                                        <!-- start single product item -->

                                        @if(isset($product[0]))
                                            @foreach($product as $productArray)
                                                <li>
                                                    <figure>
                                                        <a class="aa-product-img h-100" href="{{url('product/'.$productArray->slug)}}"><img
                                                                src="{{asset('storage/products/'.$productArray->image)}}"
                                                                alt="{{$productArray->name}}"></a>
                                                        <a class="aa-add-card-btn" href="javascript:void(0)" onclick="homeAddToCart('{{$productArray->id}}',
                                                            '{{$product_attributes[$productArray->id][0]->size}}',
                                                            '{{$product_attributes[$productArray->id][0]->color}}',
                                                            )"><span
                                                                class="fa fa-shopping-cart"></span>Add To Cart</a>
                                                        <figcaption>
                                                            <h4 class="aa-product-title"><a href="{{url('product/'.$productArray->slug)}}">{{$productArray->name}}</a></h4>
                                                            <span class="aa-product-price">Rs {{$product_attributes[$productArray->id][0]->price}}</span>
                                                            <span class="aa-product-price"><del>Rs {{$product_attributes[$productArray->id][0]->mrp}}</del></span>
                                                        </figcaption>
                                                    </figure>
                                                    <!-- product badge -->
                                                </li>@endforeach
                                        @else
                                            <li>
                                                <figure>
                                                    No Data Found
                                                </figure>
                                            </li>
                                        @endif
                                    </ul>

                                <!-- / featured product category -->
                            </ul>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- / product category -->

    <input type="hidden" id="quantity" value="1">
    <form action="" id="fromAddToCart">
        @csrf
        <input type="hidden" id="size_id" name="size_id">
        <input type="hidden" id="color_id" name="color_id">
        <input type="hidden" id="product_quantity" name="product_quantity">
        <input type="hidden" id="product_id" name="product_id">

    </form>
@endsection
