<div class="col-xl-12 order-xl-1">
    <div class="card">
       <div class="card-header">
          <div class="row align-items-center">
             <div class="col-8">
                <h3 class="mb-0">
                 @if($banner) Edit @else Add @endif Banner
             </h3>
             </div>
          </div>
       </div>
       <div class="card-body">
          @include('banner.partials.form')
       </div>
    </div>
 </div>
