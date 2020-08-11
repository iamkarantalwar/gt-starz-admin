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
                   User Messages
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
                <th scope="col" class="sort" data-sort="budget">User Name</th>
                <th scope="col" class="sort" data-sort="status">Email</th>
                <th scope="col" class="sort" data-sort="status">Message</th>
                <th scope="col" class="sort" data-sort="status">Sent Time</th>
                <th scope="col" class="sort" data-sort="status">Action</th>
              </tr>
            </thead>
            <tbody class="list">
             @include('usermessage.partials.list')
            </tbody>
          </table>
        </div>
        <!-- Card footer -->
        <div class="card-footer py-4">
            <nav aria-label="...">
              <ul class="pagination justify-content-end mb-0">
               @if ($messages->currentPage() != 1)
                  <li class="page-item">
                      <a class="page-link" href="{{route('users.index')}}?page={{$messages->currentPage()-1 }}" tabindex="-1">
                      <i class="fas fa-angle-left"></i>
                      <span class="sr-only">Previous</span>
                      </a>
                  </li>
               @endif
                @if($messages->firstItem() == $messages->lastPage())
                <li class="page-item active ">
                  <a class="page-link" href="{{ route('users.index') }}?page={{$messages->firstItem()}}">{{$messages->firstItem()}}</a>
               </li>
                @else
                  @for($i=2; $i<=$messages->lastPage(); $i++)
                      <li class="page-item @if($i ==  $messages->currentPage()) active @endif">
                          <a class="page-link" href="{{ route('users.index') }}?page={{ $i }}">{{ $i }}</a>
                      </li>
                  @endfor
                @endif
                @if($messages->lastPage() != $messages->currentPage())
                <li class="page-item">
                  <a class="page-link" href="{{route('users.index')}}?page={{ $messages->currentPage()+1 }}">
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
