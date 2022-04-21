@extends('admin.layout')
@if(isset($product))
    @section('page_title','Manage Product')
@else
    @section('page_title','Create Product')
@endif

@section('product_select','active')
@section('container')

    @if(isset($product))
        @if($product->id > 0)
            {{$image_required=""}}
        @endif
    @else
        {{$image_required="required"}}
    @endif

    <h3>@if(isset($product)) Update @else Add @endif Product</h3>

    @if(session()->has('sku-error'))
        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
            {{session('sku-error')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif

    @error('attr_image.*')
    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
        {{$message}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    @enderror

    @error('images.*')
    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
        {{$message}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    @enderror

    <a href="{{route('admin.product.index')}}">
        <button type="button" class="btn btn-success mt-3">Back</button>
    </a>
    @php
        if(isset($product))
        {
            $productId = $product->id;
        }
    @endphp
    {{session('message')}}
    <div class="row m-t-30">
        <div class="col-md-12">
            <form @if(isset($product)) action="{{route('admin.product.update',['id'=>$product->id])}}"
                  @else action="{{route('admin.product.insert')}}" @endif
                  method="post" enctype="multipart/form-data">

                <div class="row">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-body">

                                @csrf
                                <div class="form-group">
                                    <label for="name" class="control-label mb-1">Product</label>
                                    <input id="name" name="name" type="text" class="form-control"
                                           aria-required="true" aria-invalid="false" required
                                           @if(isset($product))
                                           value="{{$product->name}}"
                                        @endif
                                    >
                                    @error('name')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="slug" class="control-label mb-1">Slug</label>
                                    <input id="slug" name="slug" type="text" class="form-control"
                                           aria-required="true" aria-invalid="false" required
                                           @if(isset($product))
                                           value="{{$product->slug}}"
                                        @endif
                                    >
                                    @error('slug')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="image" class="control-label mb-1">Image</label>
                                    <input id="image" name="image" type="file" class="form-control"
                                           aria-required="true" aria-invalid="false">
                                    @error('image')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <select id="category" data-field-name="category" class="form-control select2-reset"
                                            name="category" multiple="multiple" required>
                                        <option value=""></option>
                                        @if(isset($product))
                                            @if(!empty($product->category))
                                                <option value="{{$product->category->id}}"
                                                        selected>{{$product->category->category_name}}</option>
                                            @endif
                                        @endif
                                    </select>
                                    @error('category_id')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="brand" class="control-label mb-1">Brand </label>
                                    <input id="brand" name="brand" type="text" class="form-control"
                                           aria-required="true" aria-invalid="false" required
                                           @if(isset($product))
                                           value="{{$product->brand}}"
                                        @endif
                                    >
                                    @error('brand')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="model" class="control-label mb-1">Model </label>
                                    <input id="model" name="model" type="text" class="form-control"
                                           aria-required="true" aria-invalid="false" required
                                           @if(isset($product))
                                           value="{{$product->model}}"
                                        @endif
                                    >
                                    @error('model')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="short_desc" class="control-label mb-1">Short Desc </label>
                                    <textarea id="short_desc" name="short_desc" type="text" class="form-control"
                                              aria-required="true" aria-invalid="false" required

                                    >@if(isset($product))
                                            {{$product->name}}
                                        @endif</textarea>
                                    @error('short_desc')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="desc" class="control-label mb-1">Description </label>
                                    <textarea id="desc" name="desc" type="text" class="form-control"
                                              aria-required="true" aria-invalid="false" required>
                                        @if(isset($product))
                                            {{$product->desc}}
                                        @endif
                                    </textarea>
                                    @error('desc')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="keywords" class="control-label mb-1">Keywords </label>
                                    <textarea id="keywords" name="keywords" type="text" class="form-control"
                                              aria-required="true" aria-invalid="false" required>
                                        @if(isset($product))
                                            {{$product->keywords}}
                                        @endif
                                    </textarea>
                                    @error('keywords')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="technical_specification" class="control-label mb-1">Technical_specification </label>
                                    <textarea id="technical_specification" name="technical_specification" type="text"
                                              class="form-control"
                                              aria-required="true" aria-invalid="false" required>@if(isset($product))
                                            {{$product->technical_specification}}
                                        @endif</textarea>
                                    @error('technical_specification')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="uses" class="control-label mb-1">Uses </label>
                                    <textarea id="uses" name="uses" type="text" class="form-control"
                                              aria-required="true" aria-invalid="false" required>@if(isset($product))
                                            {{$product->uses}}
                                        @endif</textarea>
                                    @error('uses')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="1" class="control-label mb-1">Warranty </label>
                                    <textarea id="warranty" name="warranty" type="text" class="form-control"
                                              aria-required="true" aria-invalid="false" required>
                                        @if(isset($product))
                                            {{$product->warranty}}
                                        @endif
                                    </textarea>
                                    @error('warranty')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>


                                {{--                            </form>--}}
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="ml-3 mb-2">Products Images</h3>

                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row mt-3" id="product_images_box">
                                    @php
                                        $loop_image_count=1;
                                    @endphp

                                    @if(isset($product))
                                        @foreach($productAttributesImages as $key)
                                            <input id="pIId" name="pIId[]" type="hidden"
                                                   @if(isset($product)) value="{{$key->id}}" @endif >

                                            <div class="col-md-4 product_images_{{$loop_image_count}}">
                                                <label for="images" class="control-label mb-1">Product Image</label>
                                                <input id="images" name="images" type="file" class="form-control"
                                                       aria-required="true" aria-invalid="false">


                                                    <img width="100px" class="mt-3 ml-1"
                                                         src="{{asset('storage/products/'.$key->images)}}" alt="">
                                            </div>
                                            <div class="col-md-2 mt-4" id="product_images_{{$loop_image_count++}}">
                                                @if($loop_image_count==2)
                                                    <button type="button" class="btn btn-success btn-lg"
                                                            onclick="add_more_images()">
                                                        <i class="fa fa-plus">&nbsp; Add</i>
                                                    </button>
                                                @else
                                                    <a href="{{route('admin.product.imageDelete',['pId'=>$productId,'pIId'=>$key->id])}}">
                                                        <button type="button" class="btn btn-danger btn-lg">
                                                            <i class="fa fa-minus">&nbsp; Remove</i>
                                                        </button>
                                                    </a>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach($productAttributesData as $key)
                                            @php
                                                $loop_image_count_prev=$loop_image_count;
                                            @endphp
                                            <input id="pIId" name="pIId[]" type="hidden"
                                                    value="">

                                            <div class="col-md-4 product_images_{{$loop_image_count}}">
                                                <label for="images" class="control-label mb-1">Product Image</label>
                                                <input id="images" name="images" type="file" class="form-control"
                                                       aria-required="true" aria-invalid="false">
                                            </div>
                                            <div class="col-md-2 mt-4" id="product_images_{{$loop_image_count++}}">
                                                @if($loop_image_count==2)
                                                    <button type="button" class="btn btn-success btn-lg"
                                                            onclick="add_more_images()">
                                                        <i class="fa fa-plus">&nbsp; Add</i>
                                                    </button>
                                                @else
                                                    <a href="{{route('admin.product.imageDelete',['pId'=>$productId,'pIId'=>$key->id])}}">
                                                        <button type="button" class="btn btn-danger btn-lg">
                                                            <i class="fa fa-minus">&nbsp; Remove</i>
                                                        </button>
                                                    </a>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <h3 class="ml-3 mb-2">Products Attributes</h3>

                <div class="col-lg-10" id="product_attr_box">
                    @php
                        $loop_count_num=1;
                    @endphp
                    @foreach($productAttributesData as $key)
                        @php
                            $loop_count_num_prev=$loop_count_num;
                        @endphp
                        <input id="paId" name="paId[]" type="hidden" @if(isset($product)) value="{{$key->id}}" @endif >

                        <div class="card" id="product_attr_{{$loop_count_num++}}">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="sku" class="control-label mb-1">SKU </label>
                                            <input id="sku" name="sku[]" type="text" class="form-control"
                                                   aria-required="true" aria-invalid="false"
                                                   @if(isset($product)) value="{{$key->sku}}" @endif required
                                            >
                                            @error('sku')
                                            <div class="alert alert-danger" role="alert">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <label for="mrp" class="control-label mb-1">MRP </label>
                                            <input id="mrp" name="mrp[]" type="text" class="form-control"
                                                   aria-required="true" aria-invalid="false"
                                                   @if(isset($product)) value="{{$key->mrp}}" @endif  required
                                            >
                                            @error('brand')
                                            <div class="alert alert-danger" role="alert">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <label for="price" class="control-label mb-1">Price </label>
                                            <input id="price" name="price[]" type="text" class="form-control"
                                                   aria-required="true" aria-invalid="false"
                                                   @if(isset($product)) value="{{$key->price}}" @endif required
                                            >
                                            @error('price')
                                            <div class="alert alert-danger" role="alert">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <label for="quantity" class="control-label mb-1">Quantity </label>
                                            <input id="quantity" name="quantity[]" type="text" class="form-control"
                                                   aria-required="true" aria-invalid="false"
                                                   @if(isset($product)) value="{{$key->quantity}}" @endif required
                                            >
                                            @error('quantity')
                                            <div class="alert alert-danger" role="alert">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>


                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-2">
                                            <label for="size" class="control-label mb-1">Size </label>
                                            <br>
                                            <select name="size[]" class="form-select size">
                                                @if(isset($product))
                                                    @if(!empty($key->size))
                                                        <option value="{{$key->size->id}}"
                                                                selected>{{$key->size->size}}</option>
                                                    @endif
                                                    {{--@else--}}
                                                    {{--@foreach($size as $list)--}}
                                                    {{--<option value="{{$list->id}}">{{$list->size}}</option>--}}
                                                    {{--@endforeach--}}
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="color" class="control-label">Color </label>
                                            <select name="color[]" id="color" class="form-control color">
                                                <option value=""></option>
                                                @if(isset($product))
                                                    @if(!empty($key->color))
                                                        <option value="{{$key->color->id}}"
                                                                selected>{{$key->color->color}}</option>
                                                    @endif
                                                    {{--@else--}}
                                                    {{--@foreach($color as $list)--}}
                                                    {{--<option value="{{$list->id}}">{{$list->color}}</option>--}}
                                                    {{--@endforeach--}}
                                                @endif

                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="attr_image" class="control-label mb-1">Attr_image</label>
                                            <input id="attr_image" name="attr_image[]" type="file" class="form-control"
                                                   aria-required="true" aria-invalid="false" {{$image_required}}>
                                        </div>
                                        <div class="col-md-2 mt-4">
                                            @if($loop_count_num==2)
                                                <button type="button" class="btn btn-success btn-lg"
                                                        onclick="add_more()">
                                                    <i class="fa fa-plus">&nbsp; Add</i>
                                                </button>
                                            @else
                                                <a href="{{route('admin.productAttribute.delete',['pId'=>$productAttributesData->products_id,'pAId'=>$key->id])}}">
                                                    <button type="button" class="btn btn-danger btn-lg">
                                                        <i class="fa fa-minus">&nbsp; Remove</i>
                                                    </button>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    @endforeach
                </div>

                <div class="w-25 ml-3">
                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('admin.scripts')

    <script>

        var loopCount = 1;

        function add_more() {

            loopCount++;

            var html = '<input id="paId" type="hidden" name="paId[]"><div class="card" id="product_attr_' + loopCount + '"> <div class="card-body"> <div class="form-group">' +
                '<div class="row">';

            html += '<div class="col-md-3"><label for="sku" class="control-label mb-1">SKU</label>' +
                '<input id="sku" name="sku[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required>' +
                '</div>';

            html += '<div class="col-md-2"><label for="mrp" class="control-label mb-1">MRP</label>' +
                '<input id="mrp" name="mrp[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required>' +
                '</div>';

            html += '<div class="col-md-2"><label for="price" class="control-label mb-1">Price</label>' +
                '<input id="price" name="price[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required>' +
                '</div>';

            let size_id_html = jQuery('.size').html();
            size_id_html = size_id_html.replace('selected=""', '');

            let color_id_html = jQuery('.color').html();

            html += '<div class="col-md-2"><label for="size" class="control-label mb-1">Size</label>' +
                '<select data-field-name="size" ' +
                'class="form-control select2-reset size" class="size" name="size[]">' + size_id_html + '</select></div>';

            html += '<div class="col-md-3"><label for="color" class="control-label mb-1">Color</label>' +
                '<select data-field-name="color" ' +
                'class="form-control select2-reset color" name="color[]">' + color_id_html + '</select></div>';

            html += '<div class="col-md-3"><label for="sku" class="control-label mb-1">Quantity</label>' +
                '<input id="quantity" name="quantity[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required></div>';

            html += '<div class="col-md-3"><label for="attr_image" class="control-label mb-1">Attr Image</label>' +
                '<input id="attr_image" name="attr_image[]" type="file" class="form-control" aria-required="true" aria-invalid="false" required></div>';

            html += '<div class="col-md-2 mt-4"><button type="button" class="btn btn-danger btn-lg" onclick="remove(' + loopCount + ')">' +
                '<i class="fa fa-minus">&nbsp; Remove</i></button></div>';

            html += '</div></div></div></div>';

            jQuery('#product_attr_box').append(html);
        }

        function remove(loopCount) {
            jQuery('#product_attr_' + loopCount).remove();
        }

        var loop_image_count = 1;

        function add_more_images() {
            loop_image_count++;
            var html = '<input id="pIId" type="hidden" name="pIId[]"><div class="col-md-4 product_images_' + loop_image_count + '"><label for="images" class="control-label mb-1">Product Image</label>' +
                '<input id="images" name="images[]" type="file" class="form-control" aria-required="true" aria-invalid="false" required></div>';

            html += '<div class="col-md-2 mt-4 product_images_' + loop_image_count + '"><button type="button" class="btn btn-danger btn-lg" onclick="remove_image(' + loop_image_count + ')">' +
                '<i class="fa fa-minus">&nbsp; Remove</i></button></div>';

            jQuery('#product_images_box').append(html);

        }

        function remove_image(loop_image_count) {
            jQuery('.product_images_' + loop_image_count).remove();
        }

        $(document).ready(function () {
            $('#category').select2({
                placeholder: 'Select Category',
                ajax: {
                    url: '{{route('admin.category.select_categories')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.category_name
                                }
                            }),
                            pagination: {
                                more: (data.current_page < data.last_page)
                            }
                        };
                    },
                    cache: true
                }

            });
        });

        $(document).ready(function () {
            $('.size').select2({
                placeholder: 'Size',
                ajax: {
                    url: '{{route('admin.size.select_size')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.size
                                }
                            }),
                            pagination: {
                                more: (data.current_page < data.last_page)
                            }
                        };
                    },
                    cache: true
                }

            });
        });

        $(document).ready(function () {
            $('#color').select2({
                placeholder: 'Size',
                ajax: {
                    url: '{{route('admin.color.select_color')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.color
                                }
                            }),
                            pagination: {
                                more: (data.current_page < data.last_page)
                            }
                        };
                    },
                    cache: true
                }

            });
        });

    </script>

@endsection

