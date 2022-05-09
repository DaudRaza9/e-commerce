@extends('admin.layout')
@section('page_title','Home Banner')
@section('home_banner_select','active')
@section('container')

    @if(session()->has('message'))
    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
        {{session('message')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    @endif
    <h3>Home Banner</h3>
    <a href="{{route('admin.home-banner.manage_home_banner')}}">
        <button type="button" class="btn btn-success mt-3">Add Home Banner</button>
    </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Button Text</th>
                        <th>Button Link</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($homeBanner as $list)
                        <tr>
                            <td>{{$list->id}}</td>
                            <td>{{$list->button_text}}</td>
                            <td>{{$list->button_link}}</td>
                            <td>
                                <img src="{{asset('storage/home-banner/'.$list->image)}}" alt="">
                            </td>
                            <td>
                                <a href="{{route('admin.home-banner.edit',$list->id)}}">
                                    <button type="button" class="btn btn-success">Edit</button>
                                </a>
                                @if($list->status==1)
                                    <a href="{{route('admin.home-banner.status',['status' => 0,'id'=>$list->id])}}">
                                        <button type="button" class="btn btn-info">Active</button>
                                    </a>
                                @elseif($list->status==0)
                                    <a href="{{route('admin.home-banner.status',['status' => 1,'id'=>$list->id])}}">
                                        <button type="button" class="btn btn-warning">DeActive</button>
                                    </a>
                                @endif
                                <a href="{{route('admin.home-banner.delete',$list->id)}}">
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
