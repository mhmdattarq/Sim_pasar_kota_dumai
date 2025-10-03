<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ asset('backend/assets/images/logo_kota_dumai.png') }}" type="image/png" />
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
                                        <h5 class="mt-3 mb-0">Selamat Datang!</h5>
                                        <p class="mb-4">Pendaftaran Akun Pedagang</p>
                                    </div>
                                    <div class="alert alert-info mb-3" style="font-size: 14px;">
                                        <span style="animation: blink 1.5s infinite;">Silahkan lengkapi data diri Anda
                                            sesuai dengan identitas resmi.
                                            Pastikan informasi yang dimasukkan benar dan dapat
                                            dipertanggungjawabkan.</span>
                                        <ul class="mt-2 mb-0">
                                            <li><span style="animation: blink 1.5s infinite;">NIK digunakan sebagai
                                                    identitas utama.</span></li>
                                            <li><span style="animation: blink 1.5s infinite;">Nomor handphone
                                                    aktif.</span></li>
                                            <li><span style="animation: blink 1.5s infinite;">Simpan password Anda
                                                    dengan baik untuk login ke aplikasi.</span></li>
                                        </ul>
                                    </div>
                                    <style>
                                        @keyframes blink {
                                            0% {
                                                opacity: 1;
                                            }

                                            50% {
                                                opacity: 0.3;
                                            }

                                            100% {
                                                opacity: 1;
                                            }
                                        }
                                    </style>
                                    @if ($errors->any())
                                        <div class="alert alert-danger" role="alert">
                                            {{ $errors->first() }}
                                        </div>
                                    @endif

                                    <form class="user" action="{{ route('register.post') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-body">
                                            <div class="col-12">
                                                <label for="nik" class="form-label"> <span
                                                        style="color: red">*</span>NIK (Nomor KTP)</label>
                                                <input type="text"
                                                    class="form-control rounded-5 @error('nik') is-invalid @enderror"
                                                    id="nik" value="{{ old('nik') }}" name="nik"
                                                    placeholder="Masukkan NIK..">
                                                @error('nik')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <br>
                                            <div class="col-12">
                                                <label for="nama" class="form-label"> <span
                                                        style="color: red">*</span>Nama</label>
                                                <input type="text"
                                                    class="form-control rounded-5 @error('nama') is-invalid @enderror"
                                                    id="nama" value="{{ old('nama') }}" name="nama"
                                                    placeholder="Masukkan Nama Lengkap..">
                                                @error('nama')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <br>
                                            <div class="col-12">
                                                <label for="tempat_lahir" class="form-label"> <span
                                                        style="color: red">*</span>Tempat Lahir</label>
                                                <input type="text"
                                                    class="form-control rounded-5 @error('tempat_lahir') is-invalid @enderror"
                                                    id="tempat_lahir" name="tempat_lahir"
                                                    value="{{ old('tempat_lahir') }}"
                                                    placeholder="Masukkan Tempat Lahir..">
                                                @error('tempat_lahir')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <br>
                                            <div class="col-12">
                                                <label for="tanggal_lahir" class="form-label"> <span
                                                        style="color: red">*</span>Tanggal Lahir</label>
                                                <input type="date"
                                                    class="form-control rounded-5 @error('tanggal_lahir') is-invalid @enderror"
                                                    id="tanggal_lahir" name="tanggal_lahir"
                                                    value="{{ old('tanggal_lahir') }}">
                                                @error('tanggal_lahir')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <br>
                                            <div class="col-12">
                                                <label for="jenis_kelamin" class="col-sm-3 col-form-label"> <span
                                                        style="color: red">*</span>Jenis
                                                    kelamin</label>
                                                <div class="col-12">
                                                    <select class="form-select mb-3 rounded-5" id="jenis_kelamin"
                                                        name="jenis_kelamin">
                                                        <option>Tentukan Jenis Kelamin</option>
                                                        <option value="{{ old('jenis_kelamin', 'L') }}"
                                                            {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                                                            Laki-Laki
                                                        </option>
                                                        <option value="{{ old('jenis_kelamin', 'P') }}"
                                                            {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                                                            Perempuan
                                                        </option>
                                                    </select>
                                                    @error('jenis_kelamin')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <br>
                                            <div class="col-12">
                                                <label for="no_telp" class="form-label"> <span
                                                        style="color: red">*</span>Nomor Handphone</label>
                                                <input type="text"
                                                    class="form-control rounded-5 @error('no_telp') is-invalid @enderror"
                                                    id="no_telp" name="no_telp" value="{{ old('no_telp') }}"
                                                    placeholder="Masukkan Nomor Handphone..">
                                                @error('no_telp')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <br>
                                            <div class="col-12">
                                                <label for="alamat" class="form-label"> <span
                                                        style="color: red">*</span>Alamat</label>
                                                <input type="text"
                                                    class="form-control rounded-5 @error('alamat') is-invalid @enderror"
                                                    id="alamat" name="alamat" value="{{ old('alamat') }}"
                                                    placeholder="Masukkan Alamat..">
                                                @error('alamat')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <br>
                                            <div class="col-12">
                                                <label for="password" class="form-label"> <span
                                                        style="color: red">*</span> Password</label>
                                                <input type="password"
                                                    class="form-control rounded-5 @error('password') is-invalid @enderror"
                                                    id="password" name="password" placeholder="Masukkan Password..">
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <br>
                                            <div class="col-12">
                                                <label for="password_confirmation" class="form-label"> <span
                                                        style="color: red">*</span> Konfirmasi
                                                    Password</label>
                                                <input type="password" class="form-control rounded-5"
                                                    id="password_confirmation" name="password_confirmation"
                                                    placeholder="Masukkan Kofirmasi Password..">
                                            </div>
                                            <br>
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-gradient-info rounded-5"><i
                                                            class='bx bx-user'></i>Daftar!</button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <br>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <a href="{{ route('frontend.pages.home') }}"
                                            class="btn btn-gradient-danger rounded-5"><i
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

    <script>
        $(document).ready(function() {
            const pasarSelect = $('#pasar_id');
            const tipeSelect = $('#tipe_tempat');
            const kiosWrap = $('#form-kios');
            const losWrap = $('#form-los');
            const pelWrap = $('#form-pelataran');
            const kiosSelect = $('#kios_id');
            const losSelect = $('#los_id');
            const pelSelect = $('#pelataran_id');

            // hide semua dulu
            function hideAll() {
                kiosWrap.addClass('d-none');
                losWrap.addClass('d-none');
                pelWrap.addClass('d-none');
            }

            hideAll(); // langsung hide di awal

            // kalau ganti pasar
            pasarSelect.on('change', function() {
                let pasarId = $(this).val();

                // reset isi option
                kiosSelect.html('<option value="">-- Pilih Lokasi --</option>');
                losSelect.html('<option value="">-- Pilih Los --</option>');
                pelSelect.html('<option value="">-- Pilih Pelataran --</option>');

                hideAll(); // sembunyiin semua dulu

                if (!pasarId) {
                    return; // kalau pasar belum dipilih stop
                }

                // ambil data sesuai pasar
                $.ajax({
                    url: `/get-tempat/${pasarId}`,
                    type: 'GET',
                    success: function(data) {
                        // isi kios
                        data.kios.forEach(function(k) {
                            kiosSelect.append(
                                `<option value="${k.id}">Nomor: ${k.nomor_kios} | Lokasi: ${k.lokasi_kios}</option>`
                            );
                        });

                        // isi los
                        data.loss.forEach(function(l) {
                            losSelect.append(
                                `<option value="${l.id}">Nomor: ${l.nomor_los} | Lokasi: ${l.lokasi_los}</option>`
                            );
                        });

                        // isi pelataran
                        data.pelatarans.forEach(function(p) {
                            pelSelect.append(
                                `<option value="${p.id}">Nomor: ${p.nomor_pelataran} | Lokasi: ${p.lokasi_pelataran}</option>`
                            );
                        });
                    }
                });
            });

            // kalau ganti tipe tempat
            tipeSelect.on('change', function() {
                hideAll();
                let tipe = $(this).val();
                if (tipe === 'kios') kiosWrap.removeClass('d-none');
                if (tipe === 'los') losWrap.removeClass('d-none');
                if (tipe === 'pelataran') pelWrap.removeClass('d-none');
            });

            document.addEventListener("change", function(e) {
                if (e.target.matches("#kios_id, #los_id, #pelataran_id")) {
                    let tipeMap = {
                        kios_id: "kios",
                        los_id: "los",
                        pelataran_id: "pelataran"
                    };

                    let tipe = tipeMap[e.target.id];
                    let id = e.target.value;

                    if (id) {
                        fetch(`/get-luas/${tipe}/${id}`)
                            .then(res => res.json())
                            .then(data => {
                                document.getElementById("luas").value = data?.luas ?? '';
                            });
                    } else {
                        document.getElementById("luas").value = '';
                    }
                }
            });


        });
    </script>




</body>

</html>
