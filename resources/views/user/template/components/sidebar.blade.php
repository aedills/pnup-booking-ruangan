<ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('user.index') ? '' : 'collapsed' }}" href="{{route('user.index')}}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="">
            <i class="fa-solid fa-building"></i>
            <span>Data Gedung</span>
        </a>
    </li>

</ul>