@extends('layouts.master')
@section('main')
<style>
    .col-md-6 {
        font-size: 11px;
    }
    select{
        height: 38px;
        margin-bottom: 1rem;
    }
</style>

<div class="col-12">
    <div class="col-12">
      <div class="card">
        <!-- Card header -->
        <div class="card-header">
            <h3>Order Details</h3>
        </div>
        <div class="card-body">
            <div class="row mb-5">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <b>Customer Name :</b>
                        </div>
                        <div class="col-md-6">
                            {{$order->name}}
                        </div>
                        <div class="col-md-6">
                            <b>Customer Email</b>
                        </div>
                        <div class="col-md-6">
                            {{$order->user()->first()->email}}
                        </div>
                        <div class="col-md-6">
                            <b>Customer Phone Number</b>
                        </div>
                        <div class="col-md-6">
                            {{$order->phone_number}}
                        </div>
                        <div class="col-md-6">
                            <b>Customer Address</b>
                        </div>
                        <div class="col-md-6">
                            {{$order->address}}<br/>
                            {{$order->city}}, {{$order->state}}, {{$order->zip_code}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('orders.update', ['order' => $order]) }}" method="POST" id='form'>
                        @method("PUT")
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <b>Assign Driver</b>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control" name="driver_id">
                                    <option value="">Chose Driver</option>
                                    @foreach($drivers as $driver)
                                        <option value="{{$driver->id}}">{{$driver->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <b>Change Status</b>
                            </div>
                            <div class="col-md-6">
                                <select name="order_status" class="form-control">
                                    <option @if($order->order_status == "PENDING") selected @endif value="PENDING">PENDING</option>
                                    <option @if($order->order_status == "PAYMENT_APPROVED") selected @endif value="PAYMENT_APPROVED" disabled>PAYMENT_APPROVED</option>
                                    <option @if($order->order_status == "DISPATCHED") selected @endif value="DISPATCHED">DISPATCHED</option>
                                    <option @if($order->order_status == "DELIVERED") selected @endif value="DELIVERED">DELIVERED</option>
                                    <option @if($order->order_status == "CANCELLED") selected @endif value="CANCELLED">CANCELLED</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <b>Payment Status</b>
                            </div>
                            <div class="col-md-6">
                                @if ($order->order_status == "PENDING")
                                    Pending
                                @else
                                Done
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Product Name</th>
                            <th>Cost</th>
                            <th>Discount</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderProducts as $product)
                        <tr>
                            <td> {{ $loop->iteration }} </td>
                            <td>
                                @if($product->product()->first() != null)
                                    {{$product->product()->first()->category()->name}}
                                @else
                                    N.A.
                                @endif
                            </td>
                            <td>{{$product->product_name}}</td>
                            <td> {{$product->cost }} </td>
                            <td> {{$product->discount }} </td>
                            <td> {{$product->total }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <b>Total</b>
                            </td>
                            <td>
                                <b>$ {{$order->orderProducts->sum('total')}}</b>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" onclick="document.getElementById('form').submit();">Submit</button>
        </div>
      </div>
    </div>
</div>
@endsection
