<style>
    .nav-link {
        display: block;
        padding: .25rem 0.5rem;
        font-size: 14px;
    }

    [class*=sidebar-dark-] .nav-sidebar>.nav-item>.nav-treeview {
        background-color: #101010;
    }
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset(asset_path('assets/admin/img/elequip-logo.jpg')) }}" alt="Elequip Logo" class="brand-image elevation-3" style="float:none;max-height: 55px;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div> -->

        <!-- SidebarSearch Form -->
        <div class="form-inline mt-2">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column custom_admin_sidebar" data-widget="treeview" role="menu"
                data-accordion="false">
                
                <li class="nav-item">
                    <a href=" {{ route('admin.dashboard') }}"
                        class="nav-link  @if (Request::is('admin/dashboard')) active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                @can(['Admin access'])
                <li class="nav-item @if (Request::is('admin/roles*') || Request::is('admin/permissions*') || Request::is('admin/users*')) menu-open @endif ">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            User Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('Role access', 'admin')
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}"
                                    class="nav-link  @if (Request::is('admin/roles*')) active @endif">
                                    <i class="nav-icon fas fa-user-tag"></i>
                                    <!-- <i class=" far fa-image"></i> -->
                                    <p>
                                        Role
                                    </p>
                                </a>
                            </li>
                        @endcan

                        @can('Permission access')
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions.index') }}"
                                    class="nav-link @if (Request::is('admin/permissions*')) active @endif">
                                    <i class="nav-icon fas fa-user-shield"></i>
                                    <p>
                                        Permission
                                    </p>
                                </a>
                            </li>
                        @endcan

                        @can('Admin access')
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}"
                                    class="nav-link @if (Request::is('admin/users*')) active @endif">
                                    <i class="nav-icon fas fa-users-cog"></i>
                                    <p>
                                        User
                                    </p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                {{-- <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon far fa-image"></i>
                        <p>
                            Post
                        </p>
                    </a>
                </li> --}}


                @if (Auth::user()->can('Lead Category access') || Auth::user()->can('Lead Stage access') || Auth::user()->can('LeadSource create') || Auth::user()->can('MeasuringUnit create') || Auth::user()->can('Brand create') || Auth::user()->can('SmsFormat create'))
                <li class="nav-item @if (Request::is('admin/lead-category*') ||
                        Request::is('admin/lead-stage*') ||
                        Request::is('admin/lead-sources*') ||
                        Request::is('admin/measuring-unit*') ||
                        Request::is('admin/brand*') ||
                        Request::is('admin/sms-format*')) menu-open @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>
                            Master Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('Lead Category access')
                            <li class="nav-item">
                                <a href="{{ route('admin.lead-category.index') }}"
                                    class="nav-link @if (Request::is('admin/lead-category')) active @endif">
                                    <i class="nav-icon fas fa-sitemap"></i>
                                    <p>
                                        Lead Categories
                                    </p>
                                </a>
                            </li>
                        @endcan

                        @can('Lead Stage access')
                            <li class="nav-item">
                                <a href="{{ route('admin.lead-stage.index') }}"
                                    class="nav-link @if (Request::is('admin/lead-stage')) active @endif">
                                    <i class="nav-icon fas fa-sitemap"></i>
                                    <p>
                                        Lead Stages
                                    </p>
                                </a>
                            </li>
                        @endcan

                        @can('LeadSource create')
                            <li class="nav-item">
                                <a href="{{ route('admin.lead-sources.index') }}"
                                    class="nav-link @if (Request::is('admin/lead-sources')) active @endif">
                                    <i class="nav-icon fas fa-sitemap"></i>
                                    <p>
                                        Lead Sources
                                    </p>
                                </a>
                            </li>
                        @endcan

                        @can('MeasuringUnit create')
                            <li class="nav-item">
                                <a href="{{ route('admin.measuring-unit.index') }}"
                                    class="nav-link @if (Request::is('admin/measuring-unit')) active @endif">
                                    <i class="nav-icon fas fa-sitemap"></i>
                                    <p>
                                        Measuring Units
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('Brand create')
                            <li class="nav-item">
                                <a href="{{ route('admin.brand.index') }}"
                                    class="nav-link @if (Request::is('admin/brand')) active @endif">
                                    <i class="nav-icon fas fa-sitemap"></i>
                                    <p>
                                        Brands
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('SmsFormat create')
                            <li class="nav-item">
                                <a href="{{ route('admin.sms-format.index') }}"
                                    class="nav-link @if (Request::is('admin/sms-format')) active @endif">
                                    <i class="nav-icon fas fa-sitemap"></i>
                                    <p>
                                        SMS Formats
                                    </p>
                                </a>
                            </li>
                        @endcan

                    </ul>
                </li>                
                @endif


                @if (Auth::user()->can('Company access') || Auth::user()->can('Customer access') || Auth::user()->can('Customer create'))
                    <li class="nav-item @if (Request::is('admin/companies*') || Request::is('admin/customers*') || Request::is('admin/upload/contact*')) menu-open @endif">
                        <a href="#" class="nav-link">
                            <i class="nav-icon far fa-address-card"></i>
                            {{-- <i class="fas fa-cubes"></i> --}}
                            <p>
                                Contact Management
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('Company access')
                                <li class="nav-item">
                                    <a href="{{ route('admin.companies.index') }}"
                                        class="nav-link @if (Request::is('admin/companies')) active @endif">
                                        <i class="nav-icon fas fa-sitemap"></i>
                                        <p>
                                            Company
                                        </p>
                                    </a>
                                </li>
                            @endcan

                            @can('Customer access')
                                <li class="nav-item">
                                    <a href="{{ route('admin.customers.index') }}"
                                        class="nav-link @if (Request::is('admin/customers/index')) active @endif">
                                        <i class="nav-icon fas fa-sitemap"></i>
                                        <p>
                                            Customer
                                        </p>
                                    </a>
                                </li>
                            @endcan

                            @can('Customer create')
                                <li class="nav-item">
                                    <a href="{{ route('admin.upload.contact') }}"
                                        class="nav-link @if (Request::is('admin/upload/contact')) active @endif">
                                        <i class="nav-icon fas fa-sitemap"></i>
                                        <p>
                                            Upload Contact
                                        </p>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endif



                @if (Auth::user()->can('ProductCategory access') || Auth::user()->can('ProductSubCategory access') || Auth::user()->can('Product access'))
                    <li class="nav-item @if (Request::is('admin/product-categories*') ||
                            Request::is('admin/products*') ||
                            Request::is('admin/product/subcategories*')) menu-open @endif">
                        <a href="#" class="nav-link">
                            <i class="nav-icon far fa-address-card"></i>
                            {{-- <i class="fas fa-cubes"></i> --}}
                            <p>
                                Product Management
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('ProductCategory access')
                                <li class="nav-item">
                                    <a href="{{ route('admin.product-categories.index') }}"
                                        class="nav-link @if (Request::is('admin/product-categories')) active @endif">
                                        <i class="nav-icon fas fa-sitemap"></i>
                                        <p>
                                            Category
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('Product access')
                                <li class="nav-item">
                                    <a href="{{ route('admin.products.index') }}"
                                        class="nav-link @if (Request::is('admin/products')) active @endif">
                                        <i class="nav-icon fas fa-sitemap"></i>
                                        <p>
                                            Products
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                


                @can(['Lead access'])
                    <li class="nav-item @if (Request::is('admin/leads*')) menu-open @endif">
                        <a href="#" class="nav-link">
                            <i class="nav-icon far fa-address-card"></i>
                            {{-- <i class="fas fa-cubes"></i> --}}
                            <p>
                                Lead Management
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('Lead access')
                                <li class="nav-item">
                                    <a href="{{ route('admin.leads.index') }}"
                                        class="nav-link @if (Request::is('admin/leads')) active @endif">
                                        <i class="nav-icon fas fa-sitemap"></i>
                                        <p>
                                            Lead
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            
                        </ul>
                    </li>
                @endcan

                @can(['Order access'])
                    <li class="nav-item @if (Request::is('admin/orders*')) menu-open @endif">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>
                                Order Management
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('Order access')
                                <li class="nav-item">
                                    <a href="{{ route('admin.orders.index') }}"
                                        class="nav-link @if (Request::is('admin/orders')) active @endif">
                                        <i class="nav-icon fas fa-sitemap"></i>
                                        <p>
                                            Order
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            
                        </ul>
                    </li>
                @endcan

                @can(['Report access'])
                <li class="nav-item">
                    <a href="{{route('admin.reports')}}" class="nav-link @if (Request::is('admin/reports')) active @endif">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>Reports</p>
                    </a>
                </li>
                @endcan
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
