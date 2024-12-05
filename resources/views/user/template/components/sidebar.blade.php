<ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('user.index') ? '' : 'collapsed' }}" href="{{route('user.index')}}">
            <i class="bi bi-grid"></i>
            <span>Daftar Ruangan</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('user.search')}}">
            <i class="fa-solid fa-magnifying-glass"></i>
            <span>Cari Booking</span>
        </a>
    </li>

</ul>