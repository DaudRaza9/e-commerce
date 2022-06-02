@extends('admin.layout')
@section('page_title','Order')
@section('order_select','active')
@section('container')

    <h3>Order</h3>

    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                    <tr>
                        <th>Order Id</th>
                        <th>Customer details</th>
                        <th>Total Amount</th>
                        <th>Order Status</th>
                        <th>Payment Status</th>
                        <th>Payment Type</th>
                        <th>Order Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $list)
                        <tr>
                            <td><a href="{{route('admin.order.order_detail',$list->id)}}">{{$list->id}}</td></a>
                            <td>
                                {{$list->name}} <br>
                                {{$list->email}} <br>
                                {{$list->mobile}} <br>
                                {{$list->address}} ,{{$list->city}} , {{$list->state}} ,{{$list->pincode}}<br>

                            </td>
                            <td>{{$list->total_amount}}</td>
                            <td>{{$list->order_status}}</td>
                            <td>{{$list->payment_status}}</td>
                            <td>{{$list->payment_type}}</td>
                            <td>{{$list->added_on}}</td>
                            <td>


                                <a href="">
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
