<div class="nav-container primary-menu">
    <div class="mobile-topbar-header">
        <div>
            <img src="{{ asset('backend/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon" />
        </div>
        <div>
            <h4 class="logo-text">Simpasar</h4>
        </div>
        <div class="toggle-icon ms-auto">
            <i class="bx bx-arrow-to-left"></i>
        </div>
    </div>
    <nav class="navbar navbar-expand-xl w-100">
        <ul class="navbar-nav justify-content-start flex-grow-1 gap-1">

            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ route('backend_admin.pages.dashboard') }}"
                   class="nav-link {{ request()->routeIs('backend_admin.pages.dashboard') ? 'active text-white' : '' }}" aria-current="page">
                    <div class="parent-icon"><i class="bx bx-home-circle"></i></div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>

            <!-- Pedagang -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret {{ request()->routeIs('backend_admin.pages.pedagang.*') ? 'active text-white' : '' }}"
                   href="javascript:;" data-bs-toggle="dropdown">
                    <div class="parent-icon"><i class="bx bx-user"></i></div>
                    <div class="menu-title">Pedagang</div>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('backend_admin.pages.pedagang.tabelpermohonan') ? 'active text-white' : '' }}"
                           href="{{ route('backend_admin.pages.pedagang.tabelpermohonan') }}">
                            <i class="bx bx-right-arrow-alt"></i> Permohonan
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Pasar -->
            <li class="nav-item dropdown">
                <a href="javascript:;" class="nav-link dropdown-toggle dropdown-toggle-nocaret {{ request()->routeIs('backend_admin.pages.pasar.*') ? 'active text-white' : '' }}"
                   data-bs-toggle="dropdown">
                    <div class="parent-icon"><i class="bx bx-cart"></i></div>
                    <div class="menu-title">Pasar</div>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('backend_admin.pages.pasar.tambah') ? 'active text-white' : '' }}"
                           href="{{ route('backend_admin.pages.pasar.tambah') }}">
                           <i class="bx bx-right-arrow-alt"></i>Tambah Data Pasar
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('backend_admin.pages.pasar.table') ? 'active text-white' : '' }}"
                           href="{{ route('backend_admin.pages.pasar.table') }}">
                           <i class="bx bx-right-arrow-alt"></i>Data Pasar
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Kios -->
            <li class="nav-item dropdown">
                <a href="javascript:;" class="nav-link dropdown-toggle dropdown-toggle-nocaret {{ request()->routeIs('backend_admin.pages.kios.*') ? 'active text-white' : '' }}"
                   data-bs-toggle="dropdown">
                    <div class="parent-icon"><i class="bx bx-building-house"></i></div>
                    <div class="menu-title">Kios</div>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('backend_admin.pages.kios.tambah') ? 'active text-white' : '' }}"
                           href="{{ route('backend_admin.pages.kios.tambah') }}">
                           <i class="bx bx-right-arrow-alt"></i>Tambah Data Kios
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('backend_admin.pages.kios.table') ? 'active text-white' : '' }}"
                           href="{{ route('backend_admin.pages.kios.table') }}">
                           <i class="bx bx-right-arrow-alt"></i>Data Kios
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Los -->
            <li class="nav-item dropdown">
                <a href="javascript:;" class="nav-link dropdown-toggle dropdown-toggle-nocaret {{ request()->routeIs('backend_admin.pages.los.*') ? 'active text-white' : '' }}"
                   data-bs-toggle="dropdown">
                    <div class="parent-icon"><i class="bx bx-store-alt"></i></div>
                    <div class="menu-title">Los</div>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('backend_admin.pages.los.tambah') ? 'active text-white' : '' }}"
                           href="{{ route('backend_admin.pages.los.tambah') }}">
                           <i class="bx bx-right-arrow-alt"></i>Tambah Data Loss
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('backend_admin.pages.los.table') ? 'active text-white' : '' }}"
                           href="{{ route('backend_admin.pages.los.table') }}">
                           <i class="bx bx-right-arrow-alt"></i>Data Loss
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Pelataran -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret {{ request()->routeIs('backend_admin.pages.pelataran.*') ? 'active text-white' : '' }}"
                   href="javascript:;" data-bs-toggle="dropdown">
                    <div class="parent-icon"><i class="bx bx-arch"></i></div>
                    <div class="menu-title">Pelataran</div>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('backend_admin.pages.pelataran.tambah') ? 'active text-white' : '' }}"
                           href="{{ route('backend_admin.pages.pelataran.tambah') }}">
                           <i class="bx bx-right-arrow-alt"></i>Tambah Data Pelataran
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('backend_admin.pages.pelataran.table') ? 'active text-white' : '' }}"
                           href="{{ route('backend_admin.pages.pelataran.table') }}">
                           <i class="bx bx-right-arrow-alt"></i>Data Pelataran
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Informasi -->
            <li class="nav-item">
                <a href="{{ route('backend_admin.pages.pengumuman.informasi') }}"
                   class="nav-link {{ request()->routeIs('backend_admin.pages.pengumuman.informasi') ? 'active text-white' : '' }}" aria-current="page">
                    <div class="parent-icon"><i class="bx bx-envelope-open"></i></div>
                    <div class="menu-title">Pengumuman</div>
                </a>
            </li>
        </ul>
    </nav>
</div>
