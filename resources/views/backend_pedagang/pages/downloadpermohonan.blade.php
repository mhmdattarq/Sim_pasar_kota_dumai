@extends('backend_pedagang.app')

@section('content')
    <div class="container" style="margin-top: 160px; margin-bottom: 60px;">
        <div class="card py-5 px-3 text-center shadow rounded-4 mx-auto" style="max-width: 600px;">
            <h2 class="fw-bold mb-3">Permohonan Berhasil Dibuat!</h2>
            <p>Selamat! <strong>{{ $permohonan->nama }}</strong>, permohonan Anda sudah berhasil dibuat. Silahkan
                download Surat permohonan dan tanda tangan lalu unggah kembali untuk melanjutkan.</p>

            <div class="mt-4 d-flex flex-column flex-md-row justify-content-center gap-3">
                <a href="{{ $downloadUrl }}" class="btn btn-success px-4 py-2 rounded-pill d-block d-md-inline-block">
                    Download Surat Permohonan
                </a>
                <a href="{{ route('backend_pedagang.pages.dashboard') }}"
                    class="btn btn-outline-dark px-4 py-2 rounded-pill d-block d-md-inline-block">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection
