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
        <!-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->

        @role('Super-Admin')
            <span class="brand-text font-weight-light">SP Admin Dashboard</span>
        @endrole

        @role('admin')
            <span class="brand-text font-weight-light">Admin Dashboard - {{ auth()->user()->name }}</span>
        @endrole

        @role('writer')
            <span class="brand-text font-weight-light">Writer Dashboard - {{ auth()->user()->name }}</span>
        @endrole

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

                        @can('User access')
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

                {{-- <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon far fa-image"></i>
                        <p>
                            Post
                        </p>
                    </a>
                </li> --}}

                @can(['Category access', 'Category create', 'SubCategory access', 'SubCategory create'])
                    <li class="nav-item menu-open d-none">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cubes"></i>
                            <p>
                                Product Management
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('Category access')
                                <li class="nav-item">
                                    <a href="{{ route('admin.categories.index') }}"
                                        class="nav-link @if (Request::is('admin/categories')) active @endif">
                                        <i class="nav-icon fas fa-sitemap"></i>
                                        <p>
                                            Category
                                        </p>
                                    </a>
                                </li>
                            @endcan

                            @can('Category create')
                                <li class="nav-item">
                                    <a href="{{ route('admin.categories.create') }}"
                                        class="nav-link @if (Request::is('admin/categories/create')) active @endif">
                                        <i class="nav-icon fas fa-sitemap"></i>
                                        <p>
                                            Add Category
                                        </p>
                                    </a>
                                </li>
                            @endcan

                            @can('SubCategory access')
                                <li class="nav-item">
                                    <a href="{{ route('admin.subcategories.index') }}"
                                        class="nav-link @if (Request::is('admin/subcategories')) active @endif">
                                        <i class="nav-icon fas fa-sitemap"></i>
                                        <p>
                                            SubCategory
                                        </p>
                                    </a>
                                </li>
                            @endcan

                            @can('SubCategory create')
                                <li class="nav-item">
                                    <a href="{{ route('admin.subcategories.create') }}"
                                        class="nav-link @if (Request::is('admin/subcategories/create')) active @endif">
                                        <i class="nav-icon fas fa-sitemap"></i>
                                        <p>
                                            Add SubCategory
                                        </p>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endcan


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
                                        Lead Category
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
                                        Lead Stage
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
                                        Lead Source
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
                                        Measuring Unit
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
                                        Brand
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
                                        SMS Format
                                    </p>
                                </a>
                            </li>
                        @endcan

                    </ul>
                </li>

                @can(['Company access', 'Customer access', 'Customer create'])
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
                @endcan                


                @can(['Company access', 'SubCategory access', 'Customer create'])
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
                            @can('Product access')
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
                @endcan


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

                
                <li class="nav-item">
                    <a href="{{route('admin.reports')}}" class="nav-link">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>Reports</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
