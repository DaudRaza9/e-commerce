@extends('admin.layout')
@section('page_title','Display Customer')
@section('customer_select','active')
@section('container')

    <h3>Customer Details</h3>

    <div class="row m-t-30">
        <div class="col-md-8">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                    <tr>
                        <th>Field</th>
                        <th>Value</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><strong>Id</strong> </td>
                        <td>{{$customer->id}}</td>
                    </tr>
                    <tr>
                        <td><strong> Name</strong></td>
                        <td>{{$customer->name}}</td>
                    </tr>
                    <tr>
                        <td><strong>Mobile</strong> </td>
                        <td>{{$customer->mobile}}</td>
                    </tr>
                    <tr>
                        <td><strong>Address</strong> </td>
                        <td>{{$customer->address}}</td>
                    </tr>
                    <tr>
                        <td><strong>City</strong></td>
                        <td>{{$customer->city}}</td>
                    </tr>
                    <tr>
                        <td><strong>State</strong> </td>
                        <td>{{$customer->state}}</td>
                    </tr>
                    <tr>
                        <td><strong>Zip</strong> </td>
                        <td>{{$customer->zip}}</td>
                    </tr>
                    <tr>
                        <td><strong>Company</strong> </td>
                        <td>{{$customer->company}}</td>
                    </tr>
                    <tr>
                        <td><strong>Gst Number</strong> </td>
                        <td>{{$customer->gstin}}</td>
                    </tr>
                    <tr>
                        <td><strong>Added On</strong> </td>
                        <td>{{\Carbon\Carbon::parse($customer->created_at)->format('d-m-Y h:i')}}</td>
                    </tr>
                    <tr>
                        <td><strong> Updated on</strong></td>
                        <td>{{\Carbon\Carbon::parse($customer->updated_at)->format('d-m-Y h:i')}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- END DATA TABLE-->
        </div>
    </div>

@endsection
