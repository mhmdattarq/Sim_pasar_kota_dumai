@extends('backend_pedagang.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Permohonan</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="{{ route('backend_pedagang.pages.permohonan') }}"><i
                                            class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Buat Permohonan</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!--end breadcrumb-->
                <div class="col-xl-9 mx-auto">
                    <div class="card border-top  border-4 border-info">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger mt-4">
                                    <strong>Terjadi kesalahan!</strong>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <div class="border p-4 rounded">
                                <div class="card-title d-flex align-items-center">
                                    <div><i class="bx bxs-home me-1 font-22 text-info"></i>
                                    </div>
                                    <h5 class="mb-0 text-info">Form Pembuatan Surat Permohonan</h5>
                                </div>
                                <hr />
                                <div class="alert alert-info mb-3" style="font-size: 14px;">
                                    @if ($sudahAda)
                                        Anda sudah mengajukan surat permohonan, Silakan cek status <b><a
                                                href="{{ route('backend_pedagang.pages.uploadpermohonan') }}">unggahan surat
                                                permohonan</a></b>
                                        Anda.
                                    @else
                                        Sebelum Mengisi Form Surat Permohonan.
                                        Pastikan data sudah benar dan sudah menyiapkan berkas:
                                        <b>NIB, Fotokopi KTP, Fotokopi KK, Fotokopi NPWP, dan Pas Foto terbaru.</b>
                                    @endif
                                </div>
                                <form action="{{ route('permohonan.store') }}" method="POST" class="user"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="nik" class="col-sm-3 col-form-label"><span
                                                style="color: red">*</span>Nik</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                                id="nik" name="nik" value="{{ $userData->nik ?? '' }}"
                                                placeholder="Masukkan Nik.." readonly>
                                            @error('nik')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="nama" class="col-sm-3 col-form-label"><span
                                                style="color: red">*</span>Nama</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                                id="nama" name="nama" value="{{ $userData->nama ?? '' }}"
                                                placeholder="Masukkan Nama.." readonly>
                                            @error('nama')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="tempat_lahir" class="col-sm-3 col-form-label"><span
                                                style="color: red">*</span>Tempat Lahir</label>
                                        <div class="col-sm-9">
                                            <input type="text"
                                                class="form-control @error('tempat_lahir') is-invalid @enderror"
                                                id="tempat_lahir" name="tempat_lahir"
                                                value="{{ $userData->tempat_lahir ?? '' }}"
                                                placeholder="Masukkan Tempat Lahir.." readonly>
                                            @error('tempat_lahir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="tanggal_lahir" class="col-sm-3 col-form-label"><span
                                                style="color: red">*</span>Tanggal Lahir</label>
                                        <div class="col-sm-9">
                                            <input type="date"
                                                class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                                id="tanggal_lahir" name="tanggal_lahir"
                                                value="{{ $userData->tanggal_lahir ?? '' }}" readonly>
                                            @error('tanggal_lahir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="jenis_kelamin" class="col-sm-3 col-form-label">
                                            <span style="color: red">*</span>Jenis Kelamin
                                        </label>
                                        <div class="col-sm-9">
                                            <!-- Input yang ditampilkan ke user -->
                                            <input type="text" class="form-control" id="jenis_kelamin"
                                                value="{{ $userData->jenis_kelamin === 'L' ? 'Laki-laki' : ($userData->jenis_kelamin === 'P' ? 'Perempuan' : '') }}"
                                                readonly>

                                            <!-- Input hidden untuk disubmit -->
                                            <input type="hidden" name="jenis_kelamin"
                                                value="{{ $userData->jenis_kelamin }}">

                                            @error('jenis_kelamin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="no_telp" class="col-sm-3 col-form-label"><span
                                                style="color: red">*</span>Nomor Handphone</label>
                                        <div class="col-sm-9">
                                            <input type="text"
                                                class="form-control @error('no_telp') is-invalid @enderror" id="no_telp"
                                                name="no_telp" placeholder="Masukkan Nomor Handphone.."
                                                value="{{ $userData->no_telp ?? '' }}" readonly>
                                            @error('no_telp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="alamat" class="col-sm-3 col-form-label"><span
                                                style="color: red">*</span>Alamat</label>
                                        <div class="col-sm-9">
                                            <input type="text"
                                                class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                                                name="alamat" placeholder="Masukkan Alamat.."
                                                value="{{ $userData->alamat ?? '' }}" readonly>
                                            @error('alamat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="pasar_id" class="col-sm-3 col-form-label"><span
                                                style="color: red">*</span>Pasar</label>
                                        <div class="col-sm-9">
                                            <select class="form-select" id="pasar_id" name="pasar_id">
                                                <option>Pilih Pasar</option>
                                                @foreach ($pasar as $pasar)
                                                    <option value="{{ $pasar->id }}">
                                                        {{ $pasar->nama_pasar }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('pasar_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="tipe_tempat" class="col-sm-3 col-form-label"><span
                                                style="color: red">*</span>Tipe Tempat</label>
                                        <div class="col-sm-9">
                                            <select class="form-select mb-3" id="tipe_tempat" name="tipe_tempat">
                                                <option value="" selected hidden>-- Masukkan Tipe Tempat --</option>
                                                <option value="kios">Kios</option>
                                                <option value="los">Los</option>
                                                <option value="pelataran">Pelataran</option>
                                            </select>
                                            @error('tipe_tempat')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div id="form-kios" class="row mb-3">
                                        <label for="kios_id" class="col-sm-3 col-form-label">Lokasi
                                            Kios</label>
                                        <div class="col-sm-9">
                                            <select class="form-select" id="kios_id" name="kios_id">
                                                <option selected>-- Pilih Lokasi --</option>
                                                @foreach ($kios as $k)
                                                    <option value="{{ $k->id }}">Nomor:
                                                        {{ $k->nomor_kios }} | Lokasi:
                                                        {{ $k->lokasi_kios }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('kios_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div id="form-los" class="row mb-3">
                                        <label for="los_id" class="col-sm-3 col-form-label">Lokasi Los</label>
                                        <div class="col-sm-9">
                                            <select class="form-select" id="los_id" name="los_id">
                                                <option value="" selected>-- Lokasi Los --</option>
                                                @foreach ($los as $l)
                                                    <option value="{{ $l->id }}">Nama:
                                                        {{ $l->nomor_los }} | Lokasi: {{ $l->lokasi_los }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('los_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div id="form-pelataran" class="row mb-3">
                                        <label for="pelataran_id" class="col-sm-3 col-form-label">Lokasi Pelataran</label>
                                        <div class="col-sm-9">
                                            <select class="form-select" id="pelataran_id" name="pelataran_id">
                                                <option value="" selected>-- Lokasi Pelataran --</option>
                                                @foreach ($pelataran as $p)
                                                    <option value="{{ $p->id }}">Nama:
                                                        {{ $p->nomor_pelataran }} | Lokasi:
                                                        {{ $p->lokasi_pelataran }}</option>
                                                @endforeach
                                            </select>
                                            @error('pelataran_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="luas" class="col-sm-3 col-form-label">Luas</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="luas" name="luas"
                                                readonly>
                                            @error('luas')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Hidden nomor_tempat -->
                                    <input type="hidden" id="nomor_tempat" name="nomor_tempat">

                                    <div class="row mb-3">
                                        <label for="jenis_dagangan" class="col-sm-3 col-form-label"><span
                                                style="color: red">*</span>Jenis Dagangan</label>
                                        <div class="col-sm-9">
                                            <input type="text"
                                                class="form-control @error('jenis_dagangan') is-invalid @enderror"
                                                id="jenis_dagangan" name="jenis_dagangan"
                                                placeholder="Masukkan Jenis Dagangan..">
                                            @error('jenis_dagangan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="jam_buka" class="col-sm-3 col-form-label"><span
                                                style="color: red">*</span>Jam Buka</label>
                                        <div class="col-sm-9">
                                            <input type="time"
                                                class="form-control @error('jam_buka') is-invalid @enderror"
                                                id="jam_buka" name="jam_buka" placeholder="Masukkan Jam Buka..">
                                            @error('jam_buka')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="jam_tutup" class="col-sm-3 col-form-label"><span
                                                style="color: red">*</span>Jam Tutup</label>
                                        <div class="col-sm-9">
                                            <input type="time"
                                                class="form-control @error('jam_tutup') is-invalid @enderror"
                                                id="jam_tutup" name="jam_tutup" placeholder="Masukkan Jam Tutup..">
                                            @error('jam_tutup')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <br>
                                    <p>Sebagai kelengkapan persyaratan kami lampirkan :</p>
                                    <div class="row mb-3">
                                        <label for="nib" class="col-sm-3 col-form-label"><span
                                                style="color: red">*</span>NIB</label>
                                        <div class="col-sm-9">
                                            <input type="file" name="nib" class="form-control" id="nib"
                                                accept="application/pdf">
                                            @error('nib')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="npwp" class="col-sm-3 col-form-label"><span
                                                style="color: red">*</span>FotoKopi
                                            NPWP</label>
                                        <div class="col-sm-9">
                                            <input type="file" name="npwp" class="form-control" id="npwp"
                                                accept="application/pdf">
                                            @error('npwp')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="ktp" class="col-sm-3 col-form-label"><span
                                                style="color: red">*</span>FotoKopi
                                            KTP</label>
                                        <div class="col-sm-9">
                                            <input type="file" name="ktp" class="form-control" id="ktp"
                                                accept="application/pdf">
                                            @error('ktp')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="kk" class="col-sm-3 col-form-label"><span
                                                style="color: red">*</span>FotoKopi
                                            KK</label>
                                        <div class="col-sm-9">
                                            <input type="file" name="kk" class="form-control" id="kk"
                                                accept="application/pdf">
                                            @error('kk')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="foto" class="col-sm-3 col-form-label">
                                            <span style="color: red">*</span>Pas Foto</label>
                                        <div class="col-sm-9">
                                            <input type="file" name="foto" class="form-control" id="foto"
                                                accept="application/pdf">
                                            @error('foto')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <button type="button" class="btn btn-info px-5" data-bs-toggle="modal"
                                                data-bs-target="#previewModal"><i class='bx bx-highlight'></i>
                                                Ajukan Surat
                                            </button>

                                        </div>
                                    </div>
                                    <!-- Modal Preview -->
                                    <div class="modal fade" id="previewModal" tabindex="-1"
                                        aria-labelledby="previewModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Preview Surat Permohonan</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Isi surat permohonan akan ditampilkan disini -->
                                                    <div id="adobe-dc-view" style="height:600px;"></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Kembali</button>
                                                    <!-- ini tombol submit beneran -->
                                                    <button type="submit" class="btn btn-success "><i
                                                            class='bx bx-highlight'></i>Ajukan Surat</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
            const tipeWrap = $('#tipe_tempat').closest('.row'); // wrapper tipe tempat
            const luasWrap = $('#luas').closest('.row'); // wrapper luas

            // hide semua dulu
            function hideAll() {
                kiosWrap.addClass('d-none');
                losWrap.addClass('d-none');
                pelWrap.addClass('d-none');
            }

            hideAll(); // langsung hide di awal
            tipeWrap.addClass('d-none'); // sembunyiin tipe tempat di awal
            luasWrap.addClass('d-none'); // sembunyiin luas di awal

            // kalau ganti pasar
            pasarSelect.on('change', function() {
                let pasarId = $(this).val();

                // reset isi option
                kiosSelect.html('<option value="">-- Pilih Lokasi --</option>');
                losSelect.html('<option value="">-- Pilih Los --</option>');
                pelSelect.html('<option value="">-- Pilih Pelataran --</option>');

                hideAll(); // sembunyiin kios/los/pelataran
                luasWrap.addClass('d-none'); // luas sembunyi lagi

                if (!pasarId) {
                    tipeWrap.addClass('d-none'); // kalau pasar kosong, tipe tempat disembunyikan
                    return;
                }

                tipeWrap.removeClass('d-none'); // munculin tipe tempat

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
                luasWrap.addClass('d-none'); // tiap ganti tipe, sembunyiin luas dulu
                let tipe = $(this).val();
                if (tipe === 'kios') kiosWrap.removeClass('d-none');
                if (tipe === 'los') losWrap.removeClass('d-none');
                if (tipe === 'pelataran') pelWrap.removeClass('d-none');
            });

            // kalau ganti pilihan kios/los/pelataran → ambil luas
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
                                luasWrap.removeClass('d-none'); // munculin luas kalau udah ada data
                            });
                    } else {
                        document.getElementById("luas").value = '';
                        luasWrap.addClass('d-none'); // kalau kosong, hide luas lagi
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener("change", function(e) {
            if (e.target.matches("#kios_id, #los_id, #pelataran_id")) {
                let text = e.target.options[e.target.selectedIndex].text;
                // ambil hanya "Nomor: xxx"
                let nomor = text.split('|')[0].replace('Nomor:', '').trim();
                document.getElementById("nomor_tempat").value = nomor || '';
            }
        });
    </script>

    <script src="https://documentcloud.adobe.com/view-sdk/main.js"></script>
    <script>
        document.addEventListener("adobe_dc_view_sdk.ready", function() {
            var adobeDCView;

            // event ketika modal dibuka
            $('#previewModal').on('shown.bs.modal', function() {
                $.ajax({
                    url: "{{ route('pedagang.permohonan.preview') }}",
                    method: "POST",
                    data: $('#formPermohonan').serialize(),
                    success: function(res) {
                        if (!adobeDCView) {
                            adobeDCView = new AdobeDC.View({
                                clientId: "d74201ec391f4e5dbe13f29b3674ce19",
                                divId: "adobe-dc-view"
                            });
                        }

                        adobeDCView.previewFile({
                            content: {
                                location: {
                                    url: res.fileUrl
                                }
                            },
                            metaData: {
                                fileName: res.fileName
                            }
                        }, {
                            embedMode: "SIZED_CONTAINER"
                        });
                    }
                });
            });
        });
    </script>
@endsection
