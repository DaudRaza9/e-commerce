@extends('admin.layout')
@section('page_title','Category')
@section('container')

    {{session('message')}}
    <h3>Category</h3>
     <a href="{{route('admin.category.manage_category')}}">
         <button type="button" class="btn btn-success mt-3">Add Category</button>
     </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Category Name</th>
                        <th>Category Slug</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $list)
                    <tr>
                        <td>{{$list->id}}</td>
                        <td>{{$list->category_name}}</td>
                        <td>{{$list->category_slug}}</td>
                        <td>
                            <a href="{{route('admin.category.delete',$list->id)}}"><button type="button" class="btn btn-danger">Delete</button></a>
                            <a href="{{route('admin.category.edit',$list->id)}}"><button type="button" class="btn btn-success">Edit</button></a>
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
