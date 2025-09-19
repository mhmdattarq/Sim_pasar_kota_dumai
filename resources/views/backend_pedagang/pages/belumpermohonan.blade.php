@extends('backend_pedagang.app')

@section('content')
    <div class="error-404 d-flex align-items-center justify-content-center" style="margin-top: 80px;">
        <div class="container">
            <div class="card py-5">
                <div class="row g-0">
                    <div class="col col-xl-5">
                        <div class="card-body p-4">
                            <h2 class="font-weight-bold display-4">Belum Ada Permohonan!</h2>
                            <p>Sepertinya Anda belum membuat permohonan.
                                <br>Buat permohonan terlebih dahulu agar bisa melanjutkan unggah permohonan!
                            </p>
                            <div class="mt-4 d-flex justify-content-center gap-3">
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
                    </div>
                    <div class="col-xl-7 text-center">
                        <img src="{{ asset('backend/assets/images/errorpermohonan.jpg') }}" class="img-fluid w-50"
                            alt="">
                    </div>

                </div>
                <!--end row-->
            </div>
        </div>
    </div>
@endsection
