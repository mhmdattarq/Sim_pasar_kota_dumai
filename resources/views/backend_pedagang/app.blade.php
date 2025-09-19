<!DOCTYPE html>
<html lang="en">

<head>
    @include('backend_pedagang.components.style')
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--start header wrapper-->
        <div class="header-wrapper">
            <!--start header -->
            @include('backend_pedagang.components.header')
            <!--end header -->
        </div>
        <!--end header wrapper-->

        <!--navigation-->
        @include('backend_pedagang.components.navbar')
        <!--end navigation-->

        <!--start page wrapper -->
        @yield('content')
        <!--end page wrapper -->

        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->

        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class="bx bxs-up-arrow-alt"></i></a>

        <!--End Back To Top Button-->
        @include('backend_pedagang.components.footer')
    </div>
    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    @include('backend_pedagang.components.script')

</body>

</html>
