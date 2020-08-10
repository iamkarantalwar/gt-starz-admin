@extends('layouts.master')
@section('main')
<div class="col-xl-12 order-xl-1">
   <div class="card">
      <div class="card-header">
         <div class="row align-items-center">
            <div class="col-8">
               <h3 class="mb-0">
                @if($product) Edit @else Add @endif Product
            </h3>
            </div>
            <div class="col-4 text-right actions">
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-default"> View Products</a>
            </div>
         </div>
      </div>
      <div class="card-body">
         @include('product.partials.form')
      </div>
   </div>
</div>
@endsection
