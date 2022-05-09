@extends('admin.layout')
@section('page_title','Manage Home Banner')
@section('home_banner_select','active')
@section('container')


    <h3>Manage Home Banner</h3>
    <a href="category">
        <button type="button" class="btn btn-success mt-3">Back</button>
    </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            {{session('message')}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <form
                                @if(isset($homeBanner)) action="{{route('admin.home-banner.update',['id'=>$homeBanner->id])}}"
                                @else action="{{route('admin.home-banner.insert')}}" @endif method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="button_text" class="control-label mb-1">Button Text</label>
                                            <input id="button_text" name="button_text" type="text"
                                                   class="form-control"
                                                   aria-required="true" aria-invalid="false"
                                                   @if(isset($homeBanner)) value="{{$homeBanner->button_text}}" @endif>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="button_link" class="control-label mb-1">Button Link</label>
                                            <input id="button_link" name="button_link" type="text"
                                                   class="form-control"
                                                   aria-required="true" aria-invalid="false"
                                                   @if(isset($homeBanner))  value="{{$homeBanner->button_link}}" @endif>
                                            @error('button_link')
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
                                                <label for="image" class="control-label mb-1">Home Banner
                                                    Image</label>
                                                <input id="image" name="image" type="file"
                                                       class="form-control"
                                                       aria-required="true" aria-invalid="false" required>

                                                @error('image')
                                                <div class="alert alert-danger" role="alert">
                                                    {{$message}}
                                                </div>
                                                @enderror
                                                @if(isset($homeBanner))
                                                    <img src="{{asset('storage/home-banner/'.$homeBanner->image)}}"
                                                         alt="" width="100px">
                                                @endif

                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        Submit
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.scripts')
    <script>

    </script>
@endsection
