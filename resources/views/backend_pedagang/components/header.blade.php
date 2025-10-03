<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand">
            <div class="mobile-toggle-menu">
                <i class="bx bx-menu"></i>
            </div>
            <div class="topbar-logo-header">
                <div class="">
                    <img src="{{ asset('backend/assets/images/logo_kota_dumai.png') }}" class="logo-icon"
                        alt="logo icon" />
                </div>
                <div class="">
                    <h4 class="logo-text">PORTAL PEDAGANG</h4>
                </div>
            </div>
            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item mobile-search-icon">
                        <a class="nav-link" href="#">
                            <i class="bx bx-search"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="user-box dropdown">
                <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('backend/assets/images/user.jpg') }}" class="user-img" alt="user avatar" />
                    <div class="user-info ps-3">
                        <p class="user-name mb-0">{{ $displayName ?? Auth::user()->nik }}</p>

                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item" href="javascript:;"><i
                                    class="bx bx-log-out-circle"></i><span>Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
