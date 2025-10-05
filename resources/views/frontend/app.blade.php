<!DOCTYPE html>
<html lang="en">

<head>
    @include('frontend.components.style')
</head>

<body>
    <!-- Spinner -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 
         d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- Navbar -->
    <div class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
            @include('frontend.components.navbar')
        </nav>
    </div>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="container-fluid footer py-5">
        @include('frontend.components.footer')
    </footer>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-md-square back-to-top">
        <i class="fa fa-arrow-up"></i>
    </a>

    <!-- Scripts -->
    @include('frontend.components.script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>

<script>
    console.log("Bootstrap ada?", typeof bootstrap !== "undefined" ? "✅ ada" : "❌ tidak ada");
</script>

</html>
