<ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? '' : 'collapsed' }}" href="{{route('admin.dashboard')}}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-heading">Master Data</li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('admin.gedung.index')}}">
            <i class="fa-solid fa-building"></i>
            <span>Data Gedung</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#nav-ruangan" data-bs-toggle="collapse" href="#">
            <i class="fa-solid fa-person-booth"></i><span>Data Ruangan</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="nav-ruangan" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
                <a href="{{route('admin.data-ruangan.rapat.index')}}">
                    <i class="bi bi-circle"></i><span>R. Rapat</span>
                </a>
            </li>
            <li>
                <a href="">
                    <i class="bi bi-circle"></i><span>R. Aula</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-heading">Booking</li>
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('admin.gedung.index')}}">
            <i class="fa-solid fa-list-check"></i>
            <span>Daftar Booking</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('admin.gedung.index')}}">
            <i class="fa-solid fa-clock-rotate-left"></i>
            <span>Riwayat Booking</span>
        </a>
    </li>

    <li class="nav-heading">Data</li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="">
            <i class="bi bi-person"></i>
            <span>Profile</span>
        </a>
    </li>

</ul>