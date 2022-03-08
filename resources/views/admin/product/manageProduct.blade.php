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

                            <form action="{{route('admin.product.insert')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="name" class="control-label mb-1">Product</label>
                                    <input id="name" name="name" type="text" class="form-control"
                                           aria-required="true" aria-invalid="false" required value="{{$name}}">
                                    @error('name')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="slug" class="control-label mb-1">Slug</label>
                                    <input id="slug" name="slug" type="text" class="form-control"
                                           aria-required="true" aria-invalid="false" required value="{{$slug}}">
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
                                    <label for="category_id" class="control-label mb-1">Category </label>
                                    <input id="image" type="text" class="form-control"
                                           aria-required="true" aria-invalid="false" required>
                                    @error('category_id')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="brand" class="control-label mb-1">Brand </label>
                                    <input id="brand" name="brand" type="text" class="form-control"
                                           aria-required="true" aria-invalid="false" required value="{{$brand}}">
                                    @error('brand')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="model" class="control-label mb-1">Model </label>
                                    <input id="model" name="model" type="text" class="form-control"
                                           aria-required="true" aria-invalid="false" required value="{{$model}}">
                                    @error('model')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="short_desc" class="control-label mb-1">Short Desc </label>
                                    <textarea id="short_desc" name="short_desc" type="text" class="form-control"
                                              aria-required="true" aria-invalid="false" required >{{$short_desc}}</textarea>
                                    @error('short_desc')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="desc" class="control-label mb-1">Description </label>
                                    <textarea id="desc" name="desc" type="text" class="form-control"
                                              aria-required="true" aria-invalid="false" required>{{$desc}}</textarea>
                                    @error('desc')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="keywords" class="control-label mb-1">Keywords </label>
                                    <textarea id="keywords" name="keywords" type="text" class="form-control"
                                              aria-required="true" aria-invalid="false" required >{{$keywords}}</textarea>
                                    @error('keywords')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="technical_specification" class="control-label mb-1">Technical_specification </label>
                                    <textarea id="technical_specification" name="technical_specification" type="text" class="form-control"
                                              aria-required="true" aria-invalid="false" required >{{$technical_specification}}</textarea>
                                    @error('technical_specification')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="uses" class="control-label mb-1">Uses </label>
                                    <textarea id="uses" name="uses" type="text" class="form-control"
                                              aria-required="true" aria-invalid="false" required >{{$uses}}</textarea>
                                    @error('uses')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="warranty" class="control-label mb-1">Warranty </label>
                                    <textarea id="warranty" name="warranty" type="text" class="form-control"
                                              aria-required="true" aria-invalid="false" required >{{$warranty}}</textarea>
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
                                <input type="hidden" name="id" value="{{$id}}">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
