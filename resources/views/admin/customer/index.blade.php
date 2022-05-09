@extends('admin.layout')
@section('page_title','Customer')
@section('customer_select','active')
@section('container')

    @if(session()->has('message'))
        <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
            {{session('message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    <h3>Customer</h3>

    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>City</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($customer as $list)
                        <tr>
                            <td>{{$list->id}}</td>
                            <td>{{$list->name}}</td>
                            <td>{{$list->email}}</td>
                            <td>{{$list->mobile}}</td>
                            <td>{{$list->city}}</td>
                            <td>
                                <a href="{{route('admin.customer.show',$list->id)}}">
                                    <button type="button" class="btn btn-success">View</button>
                                </a>
                                @if($list->status==1)
                                    <a href="{{route('admin.customer.status',['status' => 0,'id'=>$list->id])}}">
                                        <button type="button" class="btn btn-info">Active</button>
                                    </a>
                                @elseif($list->status==0)
                                    <a href="{{route('admin.customer.status',['status' => 1,'id'=>$list->id])}}">
                                        <button type="button" class="btn btn-warning">DeActive</button>
                                    </a>
                                @endif

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
