<div class="scrollbar-inner">
    <!-- Brand -->
    <div class="sidenav-header  align-items-center">
    <a class="navbar-brand" href="javascript:void(0)">
        <img src="{{ asset('assets/img/brand/white1.png') }}" class="navbar-brand-img" alt="..." style="max-height: 4rem;">
    </a>
    </div>
    <div class="navbar-inner">
    <!-- Collapse -->
    <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Nav items -->
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link active" href="/">
            <i class="ni ni-tv-2 text-primary"></i>
            <span class="nav-link-text">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('categories.create') }}">
                <i class="ni ni-planet text-orange"></i>
                <span class="nav-link-text">Category</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('banners.index') }}">
                <i class="ni ni-pin-3 text-primary"></i>
                <span class="nav-link-text">Banners</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('products.create') }}">
                <i class="ni ni-bag-17"></i>
                <span class="nav-link-text">Product Management</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('users.index')}}">
                <i class="ni ni-single-02 text-yellow"></i>
                <span class="nav-link-text">User Management</span>
            </a>
        </li>
         <li class="nav-item">
            <a class="nav-link" href="{{ route('drivers.index') }}">
                <i class="ni ni-bullet-list-67 text-default"></i>
                <span class="nav-link-text">Driver Management</span>
            </a>
        </li>
    {{--    <li class="nav-item">
            <a class="nav-link" href="login.html">
            <i class="ni ni-key-25 text-info"></i>
            <span class="nav-link-text">Login</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="register.html">
            <i class="ni ni-circle-08 text-pink"></i>
            <span class="nav-link-text">Register</span>
            </a>
        </li> --}}

        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <!-- Heading -->
        <h6 class="navbar-heading p-0 text-muted">
        <span class="docs-normal">Order</span>
        </h6>
        <!-- Navigation -->
        {{-- <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
                <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/getting-started/overview.html" target="_blank">
                <i class="ni ni-spaceship"></i>
                <span class="nav-link-text">Order Details</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/foundation/colors.html" target="_blank">
                <i class="ni ni-palette"></i>
                <span class="nav-link-text">Transactions</span>
                </a>
            </li>
        </ul> --}}
    </div>
    </div>
</div>
