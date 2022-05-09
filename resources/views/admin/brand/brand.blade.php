@extends('admin.layout')
@section('page_title','Brand')
@section('brand_select','active')
@section('container')

    @if(session()->has('message'))
        <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
            {{session('message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    <h3>Brand</h3>
     <a href="{{route('admin.brand.manage_brand')}}">
         <button type="button" class="btn btn-success mt-3">Add Brand</button>
     </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Brand</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($brand as $list)
                    <tr>
                        <td>{{$list->id}}</td>
                        <td>{{$list->brand}}</td>
                        <td>{{$list->status}}</td>
                        <td>
                            <img width="100px" class="mt-3 ml-1"
                                 src="{{asset('storage/brand/'.$list->image)}}" alt="">
                        </td>
                        <td>
                            <a href="{{route('admin.brand.edit',$list->id)}}"><button type="button" class="btn btn-success">Edit</button></a>
                            @if($list->status==1)
                            <a href="{{route('admin.brand.status',['status' => 0,'id'=>$list->id])}}"><button type="button" class="btn btn-info">Active</button></a>
                            @elseif($list->status==0)
                            <a href="{{route('admin.brand.status',['status' => 1,'id'=>$list->id])}}"><button type="button" class="btn btn-warning">DeActive</button></a>
                            @endif
                            <a href="{{route('admin.brand.delete',$list->id)}}"><button type="button" class="btn btn-danger">Delete</button></a>
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
