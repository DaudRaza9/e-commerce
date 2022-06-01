@extends('front.layouts.master')
@section('page_title','Stripe Page')
@section('content')


    <div class="container">
        <div class="row">
            <h3 style="text-align: center;margin-top: 40px;margin-bottom: 40px;">How To Integrate Stripe Payment Gateway In Laravel 8 - Techsolutionstuff</h3>
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default credit-card-box">
                    <div class="panel-heading" >
                        <div class="row">
                            <h3>Payment Details</h3>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if (Session::has('success'))
                            <div class="alert alert-success text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <p>{{ Session::get('success') }}</p><br>
                            </div>
                        @endif
                        <br>
                        <form role="form" action="{{route('stripe-post')}}" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                            @csrf
                            <div class='form-row row'>
                                <div class='col-xs-12 col-md-6 form-group required'>
                                    <label class='control-label'>Name on Card</label>
                                    <input class='form-control' size='4' type='text' name="name">
                                </div>
                                <div class='col-xs-12 col-md-6 form-group required'>
                                    <label class='control-label'>Card Number</label>
                                    <input autocomplete='off' name="card_number" class='form-control card-number' size='20' type='text'>
                                </div>
                            </div>
                            <div class='form-row row'>
                                <div class='col-xs-12 col-md-4 form-group cvc required'>
                                    <label class='control-label'>CVC</label>
                                    <input autocomplete='off' name="cvc" class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
                                </div>
                                <div class='col-xs-12 col-md-4 form-group cvc required'>
                                    <label class='control-label'>Amount</label>
                                    <input autocomplete='off' name="amount" class='form-control card-cvc' placeholder='in rupees' size='100' type='text'>
                                </div>
                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                    <label class='control-label'>Expiration Month</label>
                                    <input class='form-control  card-expiry-month' name="exp_month" placeholder='MM' size='2' type='text'>
                                </div>
                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                    <label class='control-label'>Expiration Year</label>
                                    <input class='form-control card-expiry-year' name="exp_year" placeholder='YYYY' size='4' type='text'>
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="col-xs-12">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

