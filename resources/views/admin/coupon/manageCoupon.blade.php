@extends('admin.layout')
@section('page_title','Manage Coupon')
@section('container')


    <h3>Manage Coupon</h3>
    <a href="{{route('admin.coupon.index')}}">
        <button type="button" class="btn btn-success mt-3">Back</button>
    </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            {{session('message')}}
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">

                            <form action="{{route('admin.coupon.insert')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="title" class="control-label mb-1">Title</label>
                                    <input id="title" name="title" type="text" class="form-control"
                                           aria-required="true" aria-invalid="false" required value="{{$title}}">
                                    @error('title')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="code" class="control-label mb-1">Code</label>
                                    <input id="code" name="code" type="text" class="form-control"
                                           aria-required="true" aria-invalid="false" required value="{{$code}}">
                                    @error('code')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="value" class="control-label mb-1">Value</label>
                                    <input id="value" name="value" type="text" class="form-control"
                                           aria-required="true" aria-invalid="false" required value="{{$value}}">
                                    @error('value')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
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
