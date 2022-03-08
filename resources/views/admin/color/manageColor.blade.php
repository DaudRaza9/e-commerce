@extends('admin.layout')
@section('page_title','Manage Color')
@section('color_select','active')
@section('container')


    <h3>Manage Size</h3>
    <a href="{{route('admin.color.index')}}">
        <button type="button" class="btn btn-success mt-3">Back</button>
    </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            {{session('message')}}
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">

                            <form action="{{route('admin.color.insert')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="color" class="control-label mb-1">Size</label>
                                    <input id="color" name="color" type="text" class="form-control"
                                           aria-required="true" aria-invalid="false" required value="{{$color}}">
                                    @error('color')
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
