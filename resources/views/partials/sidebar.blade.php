<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/" class="brand-link">
    <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">SIPeramalan SES</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="/" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>     
        <li class="nav-header">Master</li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-archive"></i>
            <p>
              Barang
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/barang" class="nav-link">
                <i class="fas fa-table nav-icon"></i>
                <p>Data Barang</p>
              </a>
            </li>
            {{-- <li class="nav-item">
              <a href="/barang/create" class="nav-link">
                <i class="fas fa-plus nav-icon"></i>
                <p>Tambah Barang</p>
              </a>
            </li> --}}
          </ul>
        </li>
        <li class="nav-header">Transaksi</li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-shopping-cart"></i>
            <p>
              Penjualan
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/penjualan" class="nav-link">
                <i class="fas fa-table nav-icon"></i>
                <p>Data Penjualan</p>
              </a>
            </li>
            {{-- <li class="nav-item">
              <a href="/penjualan/create" class="nav-link">
                <i class="fas fa-plus nav-icon"></i>
                <p>Tambah Penjualan</p>
              </a>
            </li> --}}
          </ul>
        </li>
        <li class="nav-header">Laporan</li>
        <li class="nav-item">
          <a href="/peramalan" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>Peramalan</p>
          </a>
        </li>
        <li class="nav-header">Pengaturan</li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Pengguna
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/users" class="nav-link">
                <i class="fas fa-table nav-icon"></i>
                <p>Data Pengguna</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/users/create" class="nav-link">
                <i class="fas fa-plus nav-icon"></i>
                <p>Tambah Pengguna</p>
              </a>
            </li>
          </ul>
        </li>
        {{-- <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user-tag"></i>
            <p>
              Role
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/role" class="nav-link">
                <i class="fas fa-table nav-icon"></i>
                <p>Data Role</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/role/create" class="nav-link">
                <i class="fas fa-plus nav-icon"></i>
                <p>Tambah Role</p>
              </a>
            </li>
          </ul>
        </li> --}}
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>