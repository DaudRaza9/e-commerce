@extends('admin.layout')
@section('page_title','Manage Brand')
@section('brand_select','active')
@section('container')


    <h3>Manage Brand</h3>
    <a href="{{route('admin.brand.index')}}">
        <button type="button" class="btn btn-success mt-3">Back</button>
    </a>

    <div class="row m-t-30">
        <div class="col-md-12">
            {{session('message')}}
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">

                            <form @if(isset($brand)) action="{{route('admin.brand.update',['id'=>$brand->id])}}"
                                  @else action="{{route('admin.brand.insert')}}" @endif method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="brand" class="control-label mb-1">Brand</label>
                                            <input id="brand" name="brand" type="text" class="form-control"
                                                   aria-required="true" aria-invalid="false" required
                                                   @if(isset($brand)) value="{{$brand->brand}}" @endif
                                            >
                                            @error('brand')
                                            <div class="alert alert-danger" role="alert">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="is_home" class="control-label mb-1">
                                                Show in home page</label>
                                            <input id="is_home" name="is_home" type="checkbox"
                                                   aria-required="true" aria-invalid="false" @if(isset($brand)) @if($brand->is_home == 1) checked @endif @endif >

                                            @error('is_home')
                                            <div class="alert alert-danger" role="alert">
                                                {{$message}}
                                            </div>
                                            @enderror

                                        </div>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="image" class="control-label mb-1">Image</label>
                                            <input id="image" name="image" type="file" class="form-control"
                                                   aria-required="true" aria-invalid="false">
                                            @error('image')
                                            <div class="alert alert-danger" role="alert">
                                                {{$message}}
                                            </div>
                                            @enderror

                                            @if(isset($brand))
                                                <img width="100px" class="mt-3 ml-1"
                                                     src="{{asset('storage/brand/'.$brand->image)}}" alt="">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        Submit
                                    </button>
                                </div>
                                <input type="hidden" name="id" @if(isset($brand)) value="{{$brand->id}}" @endif>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
