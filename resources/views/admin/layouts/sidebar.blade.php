<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">    
        <div class="sidebar-brand-text mx-3">
            <img class="" width="140px" src="{{asset('images/EML_Logo_Clear.png')}}">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    @can('admin.users.index')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span>
        </a>
    </li>
    @endcan
    @canany(['admin.countries.index','admin.cities.index'])
    <li class="nav-item">
        <a class="nav-link collapsed" href="javascript:;" data-toggle="collapse" data-target="#masterCollapse" aria-expanded="true" aria-controls="masterCollapse">
            <i class="fab fa-maxcdn"></i>
            <span>Master</span>
        </a>
        <div id="masterCollapse" class="collapse" aria-labelledby="masterHeading" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('admin.product_categories.index')
                 <a class="collapse-item" href="{{ route('admin.product_categories.index') }}">
                   <i class="fa fa-cubes"></i>
                    <span>Product Categories</span>
                </a>
                @endcan
                @can('admin.countries.index')
                <a class="collapse-item" href="{{ route('admin.countries.index') }}">
                   <i class="fas fa-globe-asia"></i>
                    <span>Countries</span>
                </a>
                @endcan
                @can('admin.cities.index')
                <a class="collapse-item" href="{{ route('admin.cities.index') }}">
                   <i class="fas fa-city"></i>
                    <span>Cities</span>
                </a>
                @endcan
                @can('admin.roles.index')
                <a class="collapse-item" href="{{ route('admin.roles.index') }}">
                   <i class="fas fa-fw fa-users"></i>
                    <span>Roles</span>
                </a>
                @endcan
            </div>
        </div>
    </li>
    @endcanany

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->