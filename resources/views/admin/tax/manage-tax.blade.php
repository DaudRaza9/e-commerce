@extends('admin.layout')
@section('page_title','Manage Tax')
@section('tax_select','active')
@section('container')


    <h3>Manage Tax</h3>
    <a href="{{route('admin.tax.index')}}">
        <button type="button" class="btn btn-success mt-3">Back</button>
    </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            {{session('message')}}
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">

                            <form action="{{route('admin.tax.insert')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="tax_value" class="control-label mb-1">Tax Value</label>
                                    <input id="tax_value" name="tax_value" type="text" class="form-control"
                                           aria-required="true" aria-invalid="false" required value="{{$tax_value}}" >
                                    @error('tax_value')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tax_desc" class="control-label mb-1">Tax Description</label>
                                    <input id="tax_desc" name="tax_desc" type="text" class="form-control"
                                           aria-required="true" aria-invalid="false" required value="{{$tax_desc}}" >
                                    @error('tax_desc')
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
