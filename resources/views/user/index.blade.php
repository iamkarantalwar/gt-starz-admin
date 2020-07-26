@extends('layouts.master')
@section('main')
<div class="row col-12">
    <div class="col-12">
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
        <!-- Card footer -->
        <div class="card-footer py-4">
            <nav aria-label="...">
              <ul class="pagination justify-content-end mb-0">
               @if ($users->currentPage() != 1)
                  <li class="page-item">
                      <a class="page-link" href="{{route('users.index')}}?page={{$users->currentPage()-1 }}" tabindex="-1">
                      <i class="fas fa-angle-left"></i>
                      <span class="sr-only">Previous</span>
                      </a>
                  </li>
               @endif
                @if($users->firstItem() == $users->lastPage())
                <li class="page-item active ">
                  <a class="page-link" href="{{ route('users.index') }}?page={{$users->firstItem()}}">{{$users->firstItem()}}</a>
               </li>
                @else
                  @for($i=2; $i<=$users->lastPage(); $i++)
                      <li class="page-item @if($i ==  $users->currentPage()) active @endif">
                          <a class="page-link" href="{{ route('users.index') }}?page={{ $i }}">{{ $i }}</a>
                      </li>
                  @endfor
                @endif
                @if($users->lastPage() != $users->currentPage())
                <li class="page-item">
                  <a class="page-link" href="{{route('users.index')}}?page={{ $users->currentPage()+1 }}">
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
