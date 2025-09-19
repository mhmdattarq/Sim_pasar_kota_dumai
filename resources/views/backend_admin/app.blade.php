<!DOCTYPE html>
<html lang="en">

<head>
    @include('backend_admin.components.style')
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--start header wrapper-->
        <div class="header-wrapper">
            @include('backend_admin.components.header')
        </div>
        <!--end header wrapper-->

        <!--navigation-->
        @include('backend_admin.components.navbar')
        <!--end navigation-->

        <!--start page wrapper -->
        @yield('content')
        <!--end page wrapper -->

        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->

        <!--Back To Top-->
        <a href="javaScript:;" class="back-to-top"><i class="bx bxs-up-arrow-alt"></i></a>

        @include('backend_admin.components.footer')
    </div>

    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    @include('backend_admin.components.script')

</body>

</html>
