@extends('layouts.master')
@section('main')
<div class="col-12">
    <div class="col-12">
      <div class="card">
        <!-- Card header -->
        <div class="card-header">
            <h3>Order Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">

                </div>
                <div class="col-md-6">

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
                            <td> {{$product->category_name }} </td>
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
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
      </div>
    </div>
</div>
@endsection
