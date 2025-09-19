<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ asset('backend/assets/images/favicon-32x32.png') }}" type="image/png" />
    <!--plugins-->
    <link href="{{ asset('backend/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <!-- loader-->
    <link href="{{ asset('backend/assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('backend/assets/js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/icons.css') }}" rel="stylesheet">
    <title>REGISTRASi</title>
</head>

<body class="bg-register">
    <!--wrapper-->
    <div class="wrapper">
        <div class="d-flex align-items-center justify-content-center my-lg-0 py-5">
            <div class="container">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2">
                    <div class="col mx-auto">
                        <div class="card rounded-4">
                            <div class="card-body">

                                <div class="border p-4  rounded-4">
                                    <div class="text-center">
                                        <img src="assets/images/logo-icon.png" width="70" alt="" />
                                        <h5 class="mt-3 mb-0">Buat Akun!</h5>
                                    </div>
                                    @if ($errors->any())
                                        <div class="alert alert-danger" role="alert">
                                            {{ $errors->first() }}
                                        </div>
                                    @endif

                                    <form class="user"
                                        action="{{ route('createAccount.post', ['nik' => $user->nik]) }}"
                                        method="POST">
                                        @csrf
                                        <div class="form-body">
                                            <form class="row g-3">
                                                <div class="col-12">
                                                    <label for="nik" class="form-label">nik</label>
                                                    <input type="text"
                                                        class="form-control rounded-5 @error('nik') is-invalid @enderror"
                                                        id="nik" value="{{ $user->nik }}" name="nik"
                                                        placeholder="Enter nik..">
                                                    @error('nik')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <br>
                                                <div class="col-12">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input type="password"
                                                        class="form-control rounded-5 @error('password') is-invalid @enderror"
                                                        id="password" name="password" placeholder="Enter Password..">
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <br>
                                                <div class="col-12">
                                                    <label for="password_confirmation" class="form-label">Konfirmasi
                                                        Password</label>
                                                    <input type="password"
                                                        class="form-control rounded-5 @error('password_confirmation') is-invalid @enderror"
                                                        id="password_confirmation" name="password_confirmation"
                                                        placeholder="Enter Kofirmasi Password..">
                                                    @error('password_confirmation')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <br>
                                                <div class="col-12">
                                                    <div class="d-grid">
                                                        <button type="submit"
                                                            class="btn btn-gradient-info rounded-5"><i
                                                                class='bx bx-user'></i>Sign up</button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </form>
                                    <br>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <a href="{{ route('frontend.pages.home') }}"
                                                class="btn btn-gradient-info rounded-5"><i
                                                    class='bx bx-exit'></i>Home</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('backend/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <!--Password show & hide js -->
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
    </script>
    <!--app JS-->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
</body>

</html>
