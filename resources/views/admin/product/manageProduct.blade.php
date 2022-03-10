@extends('admin.layout')
@section('page_title','Manage Product')
@section('product_select','active')
@section('container')


    <h3>Manage Category</h3>
    <a href="{{route('admin.product.index')}}">
        <button type="button" class="btn btn-success mt-3">Back</button>
    </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            {{session('message')}}
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">

                            <form @if(isset($product)) action="{{route('admin.product.update',['id'=>$product->id])}}" @else action="{{route('admin.product.insert')}}" @endif  method="post">
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
                                    <input id="image" name="file" type="file" class="form-control"
                                           aria-required="true" aria-invalid="false" required>
                                    @error('image')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <select id="category" data-field-name="category" class="form-control select2-reset" name="category" multiple="multiple" required>
                                        <option value=""></option>
                                        @if(isset($product))
                                            @if(!empty($product->category))
                                                <option value="{{$product->category->id}}" selected>{{$product->category->category_name}}</option>
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
                                              aria-required="true" aria-invalid="false" required >
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
                                    <textarea id="technical_specification" name="technical_specification" type="text" class="form-control"
                                              aria-required="true" aria-invalid="false" required >@if(isset($product))
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
                                              aria-required="true" aria-invalid="false" required >@if(isset($product))
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
                                              aria-required="true" aria-invalid="false" required >
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

                                <div>
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        Submit
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Jquery JS-->
    <script src="{{asset('admin_assets/vendor/jquery-3.2.1.min.js')}}"></script>
    <!-- Bootstrap JS-->
    <script src="{{asset('admin_assets/vendor/bootstrap-4.1/popper.min.js')}}"></script>
    <script src="{{asset('admin_assets/vendor/bootstrap-4.1/bootstrap.min.js')}}"></script>
    <!-- Vendor JS       -->
    <script src="{{asset('admin_assets/vendor/wow/wow.min.js')}}"></script>
    <!-- Main JS-->
    <script src="{{asset('admin_assets/js/main.js')}}"></script>
    <script src="{{asset('admin_assets/js/select2.min.js')}}"></script>

    <script>
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
    </script>

@endsection

