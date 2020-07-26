@extends('layouts.master')
@section('main')
<div class="col-xl-12 order-xl-1">
   <div class="card">
      <div class="card-header">
         <div class="row align-items-center">
            <div class="col-8">
               <h3 class="mb-0">
                @if($driver) Edit @else Add @endif Driver
            </h3>
            </div>
            <div class="col-4 text-right actions">
                <a href="{{ route('drivers.index') }}" class="btn btn-sm btn-primary"><i class="ni ni-bullet-list-67"></i> View Drivers</a>
            </div>
         </div>
      </div>
      <div class="card-body">
         @include('driver.partials.form')
      </div>
   </div>
</div>
@endsection
