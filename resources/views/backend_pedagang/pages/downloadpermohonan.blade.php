@extends('backend_pedagang.app')

@section('content')
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card py-5 px-4 shadow rounded-4 w-100" style="max-width: 800px;">
            <div class="row g-4 align-items-center text-center text-xl-start">

                {{-- Bagian teks --}}
                <div class="col-12 col-xl-6">
                    <h2 class="fw-bold mb-3">Permohonan Berhasil Dibuat!</h2>
                    <p>
                        Selamat! <strong>{{ $permohonan->nama }}</strong>, permohonan Anda sudah berhasil dibuat.
                        Silahkan download Surat permohonan dan tanda tangan lalu unggah kembali untuk melanjutkan.
                    </p>

                    <div class="mt-4 d-flex flex-column flex-md-row justify-content-center justify-content-xl-start gap-3">
                        <a href="{{ $downloadUrl }}" class="btn btn-success px-4 py-2 rounded-pill">
                            Download Surat Permohonan
                        </a>
                        <a href="{{ route('backend_pedagang.pages.dashboard') }}"
                            class="btn btn-outline-dark px-4 py-2 rounded-pill">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>

                {{-- Bagian gambar --}}
                <div class="col-12 col-xl-6 text-center">
                    <img src="{{ asset('backend/assets/images/success.png') }}" class="img-fluid w-50 mx-auto d-block"
                        alt="Success">
                </div>

            </div>
        </div>
    </div>
@endsection
