@extends('front.layouts.master')
    @section('page_title','Change password')
@section('content')


    <!-- catg header banner section -->
    <section id="aa-catg-head-banner">
        <img src="{{asset('front_assets/img/fashion/fashion-header-bg-8.jpg')}}" alt="fashion img">
        <div class="aa-catg-head-banner-area">
            <div class="container">
                <div class="aa-catg-head-banner-content">
                    <h2>Account Page</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{route('index')}}">Home</a></li>
                        <li class="active">Account</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- / catg header banner section -->

    <!-- Cart view section -->
    <section id="aa-myaccount">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="aa-myaccount-area">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="aa-myaccount-register">
                                    <h4>Change Password</h4>
                                    <form action="" class="aa-login-form" id="formUpdatePassword">
                                        @csrf
                                        <label for="">Password<span>*</span></label>
                                        <input required type="password" placeholder="Password" name="password">
                                        <div id="password_error" class="field_error"></div>
                                        <button id="btnUpdatePassword" type="submit" class="aa-browse-btn">Update </button>
                                    </form>
                                </div>
                                <div id="forget_pass_msg" class="field_error"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- / Cart view section -->
@endsection
