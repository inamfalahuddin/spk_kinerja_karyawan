<ul class="navbar-nav bg-white sidebar sidebar-light accordion border" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('dashboard')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">KinerjaKu<sup>SPK</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data
    </div>

    <!-- Nav Item - Tables -->
    @if (Auth::user()->role == 'admin')
    <li class="nav-item">
        <a class="nav-link" href="{{route('users')}}">
            <i class="fas fa-fw fa-folder"></i>
            <span>Data User</span>
        </a>
    </li>
    @endif

    <!-- Nav Item - Tables -->
    @if (Auth::user()->role == 'admin')
    <li class="nav-item">
        <a class="nav-link" href="{{route('karyawan.index')}}">
            <i class="fas fa-fw fa-folder"></i>
            <span>Data Karyawan</span></a>
    </li>
    @endif

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('nilai.index')}}">
            <i class="fas fa-fw fa-table"></i>
            <span>Nilai Karyawan</span></a>
    </li>

    <!-- Nav Item - Tables -->
    @if (Auth::user()->role == 'admin')
    <li class="nav-item">
        <a class="nav-link" href="{{route('kriteria.index')}}">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Data Kriteria</span></a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('bobot.index')}}">
            <i class="fas fa-fw fa-cog"></i>
            <span>Data Pembobotan</span></a>
    </li>
    @endif

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('penilaian.index')}}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Hasil Penilaian</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>