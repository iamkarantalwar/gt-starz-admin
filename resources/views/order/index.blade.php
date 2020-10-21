@extends('layouts.master')
@section('main')
    <div class="col-12">
        <div class="col-12">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
                <div class="row align-items-center">
                   <div class="col-8">
                      <h3 class="mb-0">
                       Orders Table
                   </h3>
                   </div>
                </div>
             </div>

            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">#</th>
                    <th scope="col" class="sort" data-sort="budget">Order Number</th>
                    <th scope="col" class="sort" data-sort="status">Customer Name</th>
                    <th scope="col" class="sort" data-sort="date">Order Date</th>
                    <th scope="col" class="sort" data-sort="status">Status</th>
                    <th scope="col">View</th>
                  </tr>
                </thead>
                <tbody class="list">
                 @include('order.partials.list')
                </tbody>
              </table>
            </div>
            <!-- Card footer -->
            <div class="card-footer py-4">
                <nav aria-label="...">
                  <ul class="pagination justify-content-end mb-0">
                   @if ($orders->currentPage() != 1)
                      <li class="page-item">
                          <a class="page-link" href="{{route('orders.index')}}?page={{$orders->currentPage()-1 }}" tabindex="-1">
                          <i class="fas fa-angle-left"></i>
                          <span class="sr-only">Previous</span>
                          </a>
                      </li>
                   @endif
                    @if($orders->firstItem() == $orders->lastPage())
                    <li class="page-item active ">
                      <a class="page-link" href="{{ route('orders.index') }}?page={{$orders->firstItem()}}">{{$orders->firstItem()}}</a>
                   </li>
                    @else
                      @for($i=2; $i<=$orders->lastPage(); $i++)
                          <li class="page-item @if($i ==  $orders->currentPage()) active @endif">
                              <a class="page-link" href="{{ route('orders.index') }}?page={{ $i }}">{{ $i }}</a>
                          </li>
                      @endfor
                    @endif
                    @if($orders->lastPage() != $orders->currentPage())
                    <li class="page-item">
                      <a class="page-link" href="{{route('orders.index')}}?page={{ $orders->currentPage()+1 }}">
                        <i class="fas fa-angle-right"></i>
                        <span class="sr-only">Next</span>
                      </a>
                    </li>
                    @endif
                  </ul>
                </nav>
              </div>
           </div>
          </div>
        </div>
    </div>
@endsection
