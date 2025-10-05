<a href="" class="navbar-brand p-0">
    <h1 class="m-0"><img src="{{ asset('frontend/assets/img/logodumai.png') }}" alt="Logo"> SIM-PASAR
    </h1>
    <!-- <img src="img/logo.png" alt="Logo"> -->
</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
        aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarCollapse">
    <div class="navbar-nav ms-auto py-0">
        <a href="{{ route('frontend.pages.home') }}" class="nav-item nav-link active">Home</a>
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pasar Daerah</a>
            <div class="dropdown-menu m-0">
                <a href="{{ route('frontend.pages.pulaupayung') }}" class="dropdown-item">Pasar Pulau Payung</a>
                <a href="{{ route('frontend.pages.tamanlepin') }}" class="dropdown-item">Pasar Taman Lepin</a>
                <a href="{{ route('frontend.pages.kelakap') }}" class="dropdown-item">Pasar Kelakap Tujuh</a>
                <a href="{{ route('frontend.pages.senggol') }}" class="dropdown-item">Pasar Senggol</a>
                <a href="#" class="dropdown-item">Pasar JayaMukti</a>
                <a href="#" class="dropdown-item">Pasar Bundaran</a>
            </div>
        </div>
        <a href="{{ route('frontend.pages.tarif') }}" class="nav-item nav-link">Tarif Restribusi</a>
        <a href="{{ route('frontend.pages.regulasi') }}" class="nav-item nav-link">Regulasi</a>
    </div>
    <a href="{{ route('backend_pedagang.auth.register') }}"
        class="btn btn-primary rounded-pill py-2 px-4 ms-lg-4">Registrasi</a>

    @auth
        {{-- Sudah login → tombol dashboard sesuai role --}}
        @if (Auth::user()->role === 'admin')
            <a href="{{ route('backend_admin.pages.dashboard') }}" class="btn btn-success rounded-pill py-2 px-4 ms-lg-4">
                Dashboard Admin
            </a>
        @elseif(Auth::user()->role === 'pedagang')
            <a href="{{ route('backend_pedagang.pages.dashboard') }}"
                class="btn btn-success rounded-pill py-2 px-4 ms-lg-4">
                Dashboard Pedagang
            </a>
        @endif
    @endauth
</div>
