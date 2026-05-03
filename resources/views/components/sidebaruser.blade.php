<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('user.dashboard') }}" class="brand-link">
        <img src="{{ asset('assets') }}/AdminLTE/dist/img/AdminLTELogo.png"
             alt="Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Absensi Sholat</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- User Panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets') }}/AdminLTE/dist/img/user2-160x160.jpg"
                     class="img-circle elevation-2"
                     alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    {{ auth()->user()->name ?? 'User' }}
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
    <a href="{{ route('user.dashboard') }}"
       class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Dashboard</p>
    </a>
</li>



                <!-- Riwayat Absensi -->
                <li class="nav-item">
    <a href="{{ route('user.riwayat') }}"
       class="nav-link {{ request()->routeIs('user.riwayat') ? 'active' : '' }}">
        <i class="nav-icon fas fa-history"></i>
        <p>Riwayat Absensi</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('user.qr.absen') }}" class="nav-link">
        <i class="nav-icon fas fa-qrcode"></i>
        <p>QR Absensi</p>
    </a>
</li>

                 <!-- Profil -->
                <li class="nav-item">
    <a href="{{ route('user.profil') }}" class="nav-link {{ request()->routeIs('user.profil') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user"></i>
        <p>Profil</p>
    </a>
</li>


                <!-- Logout -->
                <li class="nav-item">
    <a href="#"
       class="nav-link text-danger"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
