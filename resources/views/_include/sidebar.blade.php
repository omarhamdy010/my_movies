<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('dashboard.index')}}" class="brand-link">
        <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">  {{__('site.dashboard')}} </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{auth()->user()->image_path}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{auth()->user()->name}}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item menu-open">
                    <a href="{{route('dashboard.index')}}" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            {{__('site.dashboard')}}
                        </p>
                    </a>
                </li>
                @if(auth()->user()->hasPermission('users_read'))
                    <li class="nav-item menu-open">
                        <a href="{{route('users.index')}}" class="nav-link active">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                {{__('site.users')}}
                            </p>
                        </a>
                    </li>
                @endif
                @if(auth()->user()->hasPermission('category_read'))
                    <li class="nav-item menu-open">
                        <a href="{{route('categories.index')}}" class="nav-link active">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                {{__('site.categories')}}
                            </p>
                        </a>
                    </li>
                @endif
                @if(auth()->user()->hasPermission('product_read'))
                    <li class="nav-item menu-open">
                        <a href="{{route('products.index')}}" class="nav-link active">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                {{__('site.products')}}
                            </p>
                        </a>
                    </li>
                @endif
                <li class="nav-item menu-open">
                    <a href="{{route('fronts.index')}}" class="nav-link active">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            {{__('site.site')}}
                        </p>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
