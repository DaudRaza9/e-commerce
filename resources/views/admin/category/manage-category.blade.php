@extends('admin.layout')
@section('page_title','Manage Category')
@section('coupon_select','active')
@section('container')


    <h3>Manage Category</h3>
    <a href="category">
        <button type="button" class="btn btn-success mt-3">Back</button>
    </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            {{session('message')}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <form
                                @if(isset($category)) action="{{route('admin.category.update',['id'=>$category->id])}}"
                                @else action="{{route('admin.category.insert')}}" @endif method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="category_name" class="control-label mb-1">Category Name</label>
                                            <input id="category_name" name="category_name" type="text"
                                                   class="form-control"
                                                   aria-required="true" aria-invalid="false" required
                                                   @if(isset($category)) value="{{$category->category_name}}" @endif>
                                        </div>

                                        <div class="col-md-4 m-t-5">
                                            <label for="parent_category_id" class="control-label mb-1">Parent
                                                category</label>
                                            <select id="parent_category_id" data-field-name="parent_category_id"
                                                    class="form-control select2-reset"
                                                    name="parent_category_id" multiple="multiple">
                                                <option value="0"></option>
                                                @if(isset($category))
                                                    @foreach($parentCategory as $item)
                                                        @if($category->id == $item->id)
                                                            <option value="">Hello daud</option>
                                                        @else
                                                            <option value="">bored as F</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="category_slug" class="control-label mb-1">Category Slug</label>
                                            <input id="category_slug" name="category_slug" type="text"
                                                   class="form-control"
                                                   aria-required="true" aria-invalid="false" required
                                                   @if(isset($category))  value="{{$category->category_slug}}" @endif>
                                            @error('category_slug')
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
                                                <label for="category_image" class="control-label mb-1">Category
                                                    Image</label>
                                                <input id="category_image" name="category_image" type="file"
                                                       class="form-control"
                                                       aria-required="true" aria-invalid="false">

                                                @error('category_image')
                                                <div class="alert alert-danger" role="alert">
                                                    {{$message}}
                                                </div>
                                                @enderror
                                                @if(isset($category))
                                                    <img src="{{asset('storage/category/'.$category->category_image)}}"
                                                         alt="" width="100px">
                                                @endif

                                        </div>
                                        <div class="col-md-4">
                                                <label for="is_home" class="control-label mb-1">
                                                    Show in home page</label>
                                                <input id="is_home" name="is_home" type="checkbox"
                                                       aria-required="true" aria-invalid="false" @if(isset($category)) @if($category->is_home == 1) checked @endif @endif >

                                                @error('is_home')
                                                <div class="alert alert-danger" role="alert">
                                                    {{$message}}
                                                </div>
                                                @enderror


                                        </div>
                                    </div>
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
    @include('admin.scripts')
    <script>
        $(document).ready(function () {
            $('#parent_category_id').select2({
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
