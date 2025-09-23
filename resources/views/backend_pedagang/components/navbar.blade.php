<div class="nav-container primary-menu">
    <div class="mobile-topbar-header">
        <div>
            <img src="{{ asset('backend/assets/images/logo_kota_dumai.png') }}" class="logo-icon" alt="logo icon" />
        </div>
        <div>
            <h4 class="logo-text">Sim-pasar</h4>
        </div>
        <div class="toggle-icon ms-auto">
            <i class="bx bx-arrow-to-left"></i>
        </div>
    </div>
    <nav class="navbar navbar-expand-xl w-100">
        <ul class="navbar-nav justify-content-start flex-grow-1 gap-1">
            <li class="nav-item">
                <a href="{{ route('backend_pedagang.pages.dashboard') }}" class="nav-link" aria-current="page">
                    <div class="parent-icon">
                        <i class="bx bx-home-circle"></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="javascript:;" class="nav-link dropdown-toggle dropdown-toggle-nocaret"
                    data-bs-toggle="dropdown">
                    <div class="parent-icon"><i class="bx bx-building-house"></i></div>
                    <div class="menu-title">Permohonan</div>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ route('backend_pedagang.pages.permohonan') }}"><i
                                class="bx bx-right-arrow-alt"></i>Buat Permohonan</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('backend_pedagang.pages.uploadpermohonan') }}"><i
                                class="bx bx-right-arrow-alt"></i>Unggah Surat Permohonan</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;"
                    data-bs-toggle="dropdown">
                    <div class="parent-icon"><i class="bx bx-envelope-open"></i></div>
                    <div class="menu-title">Inbox</div>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="authentication-signin.html" target="_blank"><i
                                class="bx bx-right-arrow-alt"></i>Pengumuman</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="authentication-signup.html" target="_blank"><i
                                class="bx bx-right-arrow-alt"></i>Dokumen</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="authentication-signup.html" target="_blank"><i
                                class="bx bx-right-arrow-alt"></i>Tarif Testribusi</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>
