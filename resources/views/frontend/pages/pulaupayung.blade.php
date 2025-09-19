@extends('frontend.app')

@section('content')
    <!-- Header Start -->
    <div class="container-fluid d-flex align-items-center justify-content-center"
        style="background-image: url('{{ asset('frontend/assets/img/tarifbanner.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 300px;">
        <div class="container text-center">
            <h3 class="display-3 mb-4 text-white">PASAR PULAU PAYUNG</h3>
        </div>
    </div>


    <!-- Header End -->
    <!-- profil Start -->
    <div class="container-fluid about py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5">
                    <div class="h-100" style="border: 50px solid; border-color: transparent #13357B transparent #13357B;">
                        <img src="{{ asset('frontend/assets/img/PPprofil.jpg') }}" class="img-fluid w-100 h-100"
                            alt="">
                    </div>
                </div>
                <div class="col-lg-7"
                    style="background: linear-gradient(rgba(255, 255, 255, .8), rgba(255, 255, 255, .8)), url(img/about-img-1.png);">
                    <h5 class="section-about-title pe-3">Profil Pasar Pulau Payung</h5>
                    <h1 class="mb-4">Pasar<span class="text-primary">Pulau Payung</span></h1>
                    <p class="mb-4">Pasar Pulau Payung terletak di Jalan Pangeran Diponegoro, Kelurahan Rimba Sekampung,
                        Kecamatan Dumai Kota, Kota Dumai, Provinsi Riau. Pasar ini menjadi salah satu pusat aktivitas
                        ekonomi masyarakat Dumai.</p>
                    <p class="mb-4">Pasar Pulau Payung dikenal sebagai pasar tradisional yang menjual beragam kebutuhan
                        pokok masyarakat, di antaranya:</p>
                    <div class="row gy-2 gx-4 mb-4">
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Sayur Mayur Segar
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Buah-Buahan lokal maupun
                                impor
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>ikan dan hasil laut</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Daging ayam dan sapi</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Bahan pokok seperti beras,
                                gula, minyak, dll.</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Pakaian serta kebutuhan
                                rumah tangga</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- profil End -->

    <!-- informasi umum -->
    <div class="mx-auto text-center mb-5" style="max-width: 900px;">
        <h1 class="mb-4">Informasi Umum</h1>
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Aspek</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nama Pasar</td>
                    <td>Pasar Pulau Payung</td>
                </tr>
                <tr>
                    <td>Alamat Pasar</td>
                    <td>Jl. Pangeran Diponegoro, Rimba Sekampung, Dumai Kota</td>
                </tr>
                <tr>
                    <td>Titik koordinat Pasar</td>
                    <td>3.9073° S, 101.4524° E</td>
                </tr>
                <tr>
                    <td>Tahun Berdiri</td>
                    <td>1980-an</td>
                </tr>
                <tr>
                    <td>Luas Lahan Pasar</td>
                    <td>± 3.577 m²</td>
                </tr>
                <tr>
                    <td>Fasilitas Pasar</td>
                    <td>Kios, los dagang, area parkir</td>
                </tr>
                <tr>
                    <td>Jam Operasional Pasar</td>
                    <td>Setiap hari, pukul 07.00 sd 22.00 WIB</td>
                </tr>
                <tr>
                    <td>Pengelola Pasar</td>
                    <td>Pemerintah Kota Dumai</td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- informasi umum end -->

    <!-- Travel Guide Start -->
    <div class="container-fluid guide py-5">
        <div class="container py-5">
            <div class="mx-auto text-center mb-5" style="max-width: 900px;">
                <h5 class="section-title px-3">Foto Pasar Pulau Payung</h5>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-3">
                    <div class="guide-item">
                        <div class="guide-img">
                            <div class="guide-img-efects">
                                <img src="{{ asset('frontend/assets/img/PPdalam.jpg') }}"
                                    class="img-fluid w-100 rounded-top" alt="Image">
                            </div>
                        </div>
                        <div class="guide-title text-center rounded-bottom p-4">
                            <div class="guide-title-inner">
                                <h4 class="mt-3">Tampak Dalam</h4>
                                <p class="mb-0">Pasar Pulau Payung</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="guide-item">
                        <div class="guide-img">
                            <div class="guide-img-efects">
                                <img src="{{ asset('frontend/assets/img/PPsamping.jpg') }}"
                                    class="img-fluid w-100 rounded-top" alt="Image">
                            </div>
                        </div>
                        <div class="guide-title text-center rounded-bottom p-4">
                            <div class="guide-title-inner">
                                <h4 class="mt-3">Tampak Samping</h4>
                                <p class="mb-0">Pasar Pulau Payung</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="guide-item">
                        <div class="guide-img">
                            <div class="guide-img-efects">
                                <img src="{{ asset('frontend/assets/img/PPdalam.jpg') }}"
                                    class="img-fluid w-100 rounded-top" alt="Image">
                            </div>
                        </div>
                        <div class="guide-title text-center rounded-bottom p-4">
                            <div class="guide-title-inner">
                                <h4 class="mt-3">Tampak Depan</h4>
                                <p class="mb-0">Pasar Pulau Payung</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Travel Guide End -->
@endsection
