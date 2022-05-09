@extends('admin.layout')
@section('page_title','Manage Coupon')
@section('coupon_select','active')
@section('container')

    <h3>Manage Coupon</h3>
    <a href="{{route('admin.coupon.index')}}">
        <button type="button" class="btn btn-success mt-3">Back</button>
    </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            {{session('message')}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <form action="{{route('admin.coupon.insert')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="title" class="control-label mb-1">Title</label>
                                            <input id="title" name="title" type="text" class="form-control"
                                                   aria-required="true" aria-invalid="false" required
                                                   value="{{$title}}">
                                            @error('title')
                                            <div class="alert alert-danger" role="alert">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="code" class="control-label mb-1">Code</label>
                                            <input id="code" name="code" type="text" class="form-control"
                                                   aria-required="true" aria-invalid="false" required value="{{$code}}">
                                            @error('code')
                                            <div class="alert alert-danger" role="alert">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="value" class="control-label mb-1">Value</label>
                                            <input id="value" name="value" type="text" class="form-control"
                                                   aria-required="true" aria-invalid="false" required
                                                   value="{{$value}}">
                                            @error('value')
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
                                            <select name="type" id="type" class="form-control">
                                                @if(isset($product))
                                                    @if($product->type == 'Value')
                                                        <option value="Value" selected>Value</option>
                                                        <option value="Per">Per</option>
                                                    @elseif($product->type == 'Per')
                                                        <option value="Value">Value</option>
                                                        <option value="Per" selected>Per</option>
                                                    @else
                                                        <option value="Value">Value</option>
                                                        <option value="Per">Per</option>
                                                    @endif
                                                @else
                                                    <option value="Value">Value</option>
                                                    <option value="Per">Per</option>
                                                @endif

                                            </select>
                                        </div>
                                            <div class="col-md-4">
                                                <label for="title" class="control-label mb-1">Minimum Order Amt</label>
                                                <input id="minimum_order_amount" name="minimum_order_amount" type="text" class="form-control"
                                                       aria-required="true" aria-invalid="false" required
                                                       value="{{$minimum_order_amount}}">
                                                @error('minimum_order_amount')
                                                <div class="alert alert-danger" role="alert">
                                                    {{$message}}
                                                </div>
                                                @enderror
                                            </div>


                                            <div class="col-md-4">
                                                <label for="is_one_time" class="control-label mb-1">Is One Time</label>
                                                <select name="is_one_time" id="is_one_time" class="form-control">
                                                    @if(isset($product))
                                                        @if($product->is_one_time == '1')
                                                            <option value="1" selected>Yes</option>
                                                            <option value="0">No</option>
                                                        @elseif($product->is_one_time == '0')
                                                            <option value="1">Yes</option>
                                                            <option value="0" selected>No</option>
                                                        @else
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                        @endif
                                                    @else
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    @endif

                                                </select>
                                                @error('is_one_time')
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
                                <input type="hidden" name="id" value="{{$id}}">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
