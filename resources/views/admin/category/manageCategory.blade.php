@extends('admin.layout')
@section('page_title','Manage Category')
@section('container')


    <h3>Manage Category</h3>
    <a href="category">
        <button type="button" class="btn btn-success mt-3">Back</button>
    </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            {{session('message')}}
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">

                            <form action="{{route('admin.category.insert')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="category_name" class="control-label mb-1">Category</label>
                                    <input id="category_name" name="category_name" type="text" class="form-control"
                                           aria-required="true" aria-invalid="false" required value="{{$category_name}}">
                                    @error('category_name')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="category_slug" class="control-label mb-1">Category Slug</label>
                                    <input id="category_slug" name="category_slug" type="text" class="form-control"
                                           aria-required="true" aria-invalid="false" required value="{{$category_slug}}">
                                    @error('category_slug')
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
