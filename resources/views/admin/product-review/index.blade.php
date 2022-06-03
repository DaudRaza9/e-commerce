@extends('admin.layout')
@section('page_title','Product Review')
@section('product_review_select','active')
@section('container')


    <h3>Product Review</h3>

    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Customer Name</th>
                        <th>Product</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Added On</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($product_review as $list)
                        <tr>
                            <td>{{$list->id}}</td>
                            <td>{{$list->name}}</td>
                            <td>{{$list->pname}}</td>
                            <td>{{$list->rating}}</td>
                            <td>{{$list->review}}</td>
                            <td>{{$list->added_on}}</td>

                            <td>

                                @if($list->status==1)
                                    <a href="{{route('admin.product.review.update_product_review_status',['status'=>0,'id'=>$list->id])}}">
                                        <button type="button" class="btn btn-info">Active</button>
                                    </a>
                                @elseif($list->status==0)
                                    <a href="{{route('admin.product.review.update_product_review_status',['status'=>1,'id'=>$list->id])}}">
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
