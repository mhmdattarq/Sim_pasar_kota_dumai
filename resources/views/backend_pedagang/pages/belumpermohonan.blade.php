@extends('backend_pedagang.app')

@section('content')
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card py-5 px-4 shadow rounded-4 w-100" style="max-width: 800px;">
            <div class="row g-4 align-items-center text-center text-xl-start">

                {{-- Bagian teks --}}
                <div class="col-12 col-xl-6">
                    <h2 class="fw-bold mb-3">Belum Ada Permohonan!</h2>
                    <p>
                        Sepertinya Anda belum membuat permohonan.
                        Buat permohonan terlebih dahulu agar bisa melanjutkan unggah permohonan!
                    </p>

                    <div class="mt-4 d-flex flex-column flex-md-row justify-content-center justify-content-xl-start gap-3">
                        <a href="{{ route('backend_pedagang.pages.permohonan') }}"
                            class="btn btn-primary px-4 py-2 rounded-pill">
                            Buat Permohonan
                        </a>
                        <a href="{{ route('backend_pedagang.pages.dashboard') }}"
                            class="btn btn-outline-dark px-4 py-2 rounded-pill">
                            Kembali
                        </a>
                    </div>
                </div>

                {{-- Bagian gambar --}}
                <div class="col-12 col-xl-6 text-center">
                    <img src="{{ asset('backend/assets/images/errorpermohonan.png') }}"
                        class="img-fluid w-50 mx-auto d-block" alt="Error">
                </div>

            </div>
        </div>
    </div>
@endsection
