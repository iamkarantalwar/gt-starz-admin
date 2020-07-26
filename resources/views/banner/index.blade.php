@extends('layouts.master')
@section('main')
    <div class="col-12">
        @include('banner.add-edit')
    <div class="col-12">
        <div class="col-12">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
                <div class="row align-items-center">
                   <div class="col-8">
                      <h3 class="mb-0">
                       Banners Table
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
                    <th scope="col" class="sort" data-sort="budget">Banner Description</th>
                    <th scope="col" class="sort" data-sort="status">Priority</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody class="list">
                 @include('banner.partials.list')
                </tbody>
              </table>
            </div>
            <!-- Card footer -->
            <div class="card-footer py-4">
                <nav aria-label="...">
                  <ul class="pagination justify-content-end mb-0">
                   @if ($banners->currentPage() != 1)
                      <li class="page-item">
                          <a class="page-link" href="{{route('banners.index')}}?page={{$banners->currentPage()-1 }}" tabindex="-1">
                          <i class="fas fa-angle-left"></i>
                          <span class="sr-only">Previous</span>
                          </a>
                      </li>
                   @endif
                    @if($banners->firstItem() == $banners->lastPage())
                    <li class="page-item active ">
                      <a class="page-link" href="{{ route('banners.index') }}?page={{$banners->firstItem()}}">{{$banners->firstItem()}}</a>
                   </li>
                    @else
                      @for($i=2; $i<=$banners->lastPage(); $i++)
                          <li class="page-item @if($i ==  $banners->currentPage()) active @endif">
                              <a class="page-link" href="{{ route('banners.index') }}?page={{ $i }}">{{ $i }}</a>
                          </li>
                      @endfor
                    @endif
                    @if($banners->lastPage() != $banners->currentPage())
                    <li class="page-item">
                      <a class="page-link" href="{{route('banners.index')}}?page={{ $banners->currentPage()+1 }}">
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
