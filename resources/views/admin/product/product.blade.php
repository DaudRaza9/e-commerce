@extends('admin.layout')
@section('page_title','Product')
@section('product_select','active')
@section('container')

    @if(session()->has('message'))
    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
        {{session('message')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    @endif
    <h3>Products</h3>
    <a href="{{route('admin.product.manage_product')}}">
        <button type="button" class="btn btn-success mt-3">Add Product</button>
    </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $list)
                        <tr>
                            <td>{{$list->id}}</td>
                            <td>{{$list->name}}</td>
                            <td>{{$list->slug}}</td>
                            <td>
                                <a href="{{route('admin.product.edit',$list->id)}}">
                                    <button type="button" class="btn btn-success">Edit</button>
                                </a>
                                @if($list->status==1)
                                    <a href="{{route('admin.product.status',['status' => 0,'id'=>$list->id])}}">
                                        <button type="button" class="btn btn-info">Active</button>
                                    </a>
                                @elseif($list->status==0)
                                    <a href="{{route('admin.product.status',['status' => 1,'id'=>$list->id])}}">
                                        <button type="button" class="btn btn-warning">DeActive</button>
                                    </a>
                                @endif
                                <a href="{{route('admin.product.delete',$list->id)}}">
                                    <button type="button" class="btn btn-danger">Delete</button>
                                </a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- END DATA TABLE-->
        </div>
    </div>

@endsection
