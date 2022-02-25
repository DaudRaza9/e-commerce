@extends('admin.layout')
@section('page_title','Coupon')
@section('container')

    {{session('message')}}
    <h3>Coupon</h3>
     <a href="{{route('admin.coupon.manage_coupon')}}">
         <button type="button" class="btn btn-success mt-3">Add Coupon</button>
     </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Code</th>
                        <th>Value</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $list)
                    <tr>
                        <td>{{$list->id}}</td>
                        <td>{{$list->title}}</td>
                        <td>{{$list->code}}</td>
                        <td>{{$list->value}}</td>
                        <td>
                            <a href="{{route('admin.coupon.delete',$list->id)}}"><button type="button" class="btn btn-danger">Delete</button></a>
                            <a href="{{route('admin.coupon.edit',$list->id)}}"><button type="button" class="btn btn-success">Edit</button></a>
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
