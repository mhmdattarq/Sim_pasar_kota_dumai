<div class="nav-container primary-menu">
    <div class="mobile-topbar-header">
        <div>
            <img src="{{ asset('backend/assets/images/logo_kota_dumai.png') }}" class="logo-icon" alt="logo icon" />
        </div>
        <div>
            <h4 class="logo-text">PORTAL PEDAGANG</h4>
        </div>
    </div>
    <nav class="navbar navbar-expand-xl w-100">
        <ul class="navbar-nav justify-content-start flex-grow-1 gap-1">
            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ route('backend_pedagang.pages.dashboard') }}" 
                   class="nav-link {{ request()->routeIs('backend_pedagang.pages.dashboard') ? 'active text-white' : '' }}">
                    <div class="parent-icon">
                        <i class="bx bx-home-circle"></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>

            <!-- Permohonan -->
            <li class="nav-item dropdown">
                <a href="javascript:;" 
                   class="nav-link dropdown-toggle dropdown-toggle-nocaret {{ request()->routeIs('backend_pedagang.pages.permohonan','backend_pedagang.pages.uploadpermohonan') ? 'active text-white' : '' }}"
                   data-bs-toggle="dropdown">
                    <div class="parent-icon"><i class="bx bx-building-house"></i></div>
                    <div class="menu-title">Permohonan</div>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('backend_pedagang.pages.permohonan') ? 'active text-white' : '' }}" 
                           href="{{ route('backend_pedagang.pages.permohonan') }}">
                            <i class="bx bx-right-arrow-alt"></i>Buat Permohonan
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('backend_pedagang.pages.uploadpermohonan') ? 'active text-white' : '' }}" 
                           href="{{ route('backend_pedagang.pages.uploadpermohonan') }}">
                            <i class="bx bx-right-arrow-alt"></i>Unggah Surat Permohonan
                        </a>
                    </li>
                </ul>
            </li>

            <!-- pengumuman -->
            <li class="nav-item">
                <a href="{{ route('backend_pedagang.pages.pengumuman') }}" 
                   class="nav-link {{ request()->routeIs('backend_pedagang.pages.pengumuman') ? 'active text-white' : '' }}">
                    <div class="parent-icon">
                        <i class="bx bx-envelope-open"></i>
                    </div>
                    <div class="menu-title">Pengumuman</div>
                </a>
            </li>
            <!-- dokumen -->
            <li class="nav-item">
                <a href="{{ route('backend_pedagang.pages.dokumen') }}" 
                   class="nav-link {{ request()->routeIs('backend_pedagang.pages.dokumen') ? 'active text-white' : '' }}">
                    <div class="parent-icon">
                        <i class="bx bx-briefcase"></i>
                    </div>
                    <div class="menu-title">Dokumen</div>
                </a>
            </li>
            <!-- tarif -->
            <li class="nav-item">
                <a href="{{ route('backend_pedagang.pages.comingsoon') }}" 
                   class="nav-link {{ request()->routeIs('backend_pedagang.pages.comingsoon') ? 'active text-white' : '' }}">
                    <div class="parent-icon">
                        <i class="bx bx-money"></i>
                    </div>
                    <div class="menu-title">Tarif Restribusi</div>
                </a>
            </li>
        </ul>
    </nav>
</div>
