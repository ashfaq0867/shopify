<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Nav links -->
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
            <li class="nav-item">
                <a href="/price-update" class="nav-link">
                    <i class="nav-icon fas fa-tag"></i>
                    <p>Price Update</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('products') }}" class="nav-link">
                    <i class="nav-icon fas fa-plus"></i>
                    <p>New Products</p>
                </a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar -->
</aside>
