@extends('layouts.master')
@section('main')
<div class="col-md-6">
    <div class="card">
        <!-- Card header -->
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-8">
                <h3 class="mb-0">
                    Users Table
                </h3>
                </div>
                {{-- <div class="col-4 text-right">
                    <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">Add Category</a>
                </div> --}}
            </div>
        </div>

        <!-- Light table -->
        <div class="table-responsive">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="sort" data-sort="name">#</th>
                        <th scope="col" class="sort" data-sort="budget">Name</th>
                        <th scope="col" class="sort" data-sort="status">Username</th>
                        <th scope="col" class="sort" data-sort="status">Email</th>
                        <th scope="col" class="sort" data-sort="status">Phone Number</th>
                        <th scope="col" class="sort" data-sort="status">Address</th>
                        <th scope="col" class="sort" data-sort="status">Status</th>
                        <th scope="col" class="sort" data-sort="status">Action</th>
                    </tr>
                </thead>
                <tbody class="list">
                    @include('user.partials.list')
                </tbody>
            </table>
        </div>

    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <!-- Card header -->
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-8">
                    <h3 class="mb-0">
                        Drivers Table
                    </h3>
                </div>
                <div class="col-4 text-right">
                    <a href="{{ route('drivers.create') }}" class="btn btn-sm btn-default">Add Driver</a>
                </div>
            </div>
        </div>

        <!-- Light table -->
        <div class="table-responsive">
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
            <tr>
                <th scope="col" class="sort" data-sort="name">#</th>
                <th scope="col" class="sort" data-sort="budget">Name</th>
                <th scope="col" class="sort" data-sort="status">Username</th>
                <th scope="col" class="sort" data-sort="status">Email</th>
                <th scope="col" class="sort" data-sort="status">Phone Number</th>
                <th scope="col" class="sort" data-sort="status">Address</th>
                <th scope="col" class="sort" data-sort="status">Rating</th>
                <th scope="col" class="sort" data-sort="status">Status</th>
                <th scope="col" class="sort" data-sort="status">Action</th>
            </tr>
            </thead>
            <tbody class="list">
            @include('driver.partials.list')
            </tbody>
        </table>
        </div>
        <!-- Card footer -->
        <div class="card-footer py-4">
            <nav aria-label="...">
            <ul class="pagination justify-content-end mb-0">
                @if ($drivers->currentPage() != 1)
                <li class="page-item">
                    <a class="page-link" href="{{route('drivers.index')}}?page={{$drivers->currentPage()-1 }}" tabindex="-1">
                    <i class="fas fa-angle-left"></i>
                    <span class="sr-only">Previous</span>
                    </a>
                </li>
                @endif
                @if($drivers->firstItem() == $drivers->lastPage())
                <li class="page-item active ">
                <a class="page-link" href="{{ route('drivers.index') }}?page={{$drivers->firstItem()}}">{{$drivers->firstItem()}}</a>
                </li>
                @else
                @for($i=2; $i<=$drivers->lastPage(); $i++)
                    <li class="page-item @if($i ==  $drivers->currentPage()) active @endif">
                        <a class="page-link" href="{{ route('drivers.index') }}?page={{ $i }}">{{ $i }}</a>
                    </li>
                @endfor
                @endif
                @if($drivers->lastPage() != $drivers->currentPage())
                <li class="page-item">
                <a class="page-link" href="{{route('drivers.index')}}?page={{ $drivers->currentPage()+1 }}">
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
<div class="col-md-6">
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
                <div class="col-4 text-right">
                    <a href="{{ route('banners.create') }}" class="btn btn-sm btn-default">Add Banner</a>
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
                <th scope="col" class="sort" data-sort="status">Image</th>
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

<div class="col-md-6">
    <div class="card">
      <!-- Card header -->
      <div class="card-header">
          <div class="row align-items-center">
             <div class="col-8">
                <h3 class="mb-0">
                 Categories Table
             </h3>
             </div>
             <div class="col-4 text-right">
                 <a href="{{ route('categories.create') }}" class="btn btn-sm btn-default">Add Category</a>
             </div>
          </div>
       </div>

      <!-- Light table -->
      <div class="table-responsive">
        <table class="table align-items-center table-flush">
          <thead class="thead-light">
            <tr>
              <th scope="col" class="sort" data-sort="name">#</th>
              <th scope="col" class="sort" data-sort="budget">Category Name</th>
              <th scope="col" class="sort" data-sort="status">Image</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody class="list">
           @include('category.partials.list')
          </tbody>
        </table>
      </div>
      <!-- Card footer -->
      <div class="card-footer py-4">
        <nav aria-label="...">
          <ul class="pagination justify-content-end mb-0">
           @if ($categories->currentPage() != 1)
              <li class="page-item">
                  <a class="page-link" href="{{route('categories.index')}}?page={{$categories->currentPage()-1 }}" tabindex="-1">
                  <i class="fas fa-angle-left"></i>
                  <span class="sr-only">Previous</span>
                  </a>
              </li>
           @endif
            @if($categories->firstItem() == $categories->lastPage())
            <li class="page-item active ">
              <a class="page-link" href="{{ route('categories.index') }}?page={{$categories->firstItem()}}">{{$categories->firstItem()}}</a>
           </li>
            @else
              @for($i=2; $i<=$categories->lastPage(); $i++)
                  <li class="page-item @if($i ==  $categories->currentPage()) active @endif">
                      <a class="page-link" href="{{ route('categories.index') }}?page={{ $i }}">{{ $i }}</a>
                  </li>
              @endfor
            @endif
            @if($categories->lastPage() != $categories->currentPage())
            <li class="page-item">
              <a class="page-link" href="{{route('categories.index')}}?page={{ $categories->currentPage()+1 }}">
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

@endsection
