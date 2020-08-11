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
            </nav>
          </div>
       </div>
      </div>
    </div>
</div>
@endsection
