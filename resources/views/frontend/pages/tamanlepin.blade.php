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
            <h3 class="display-3 mb-4 text-white">PASAR LEPIN</h3>
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
                    <h5 class="section-about-title pe-3">Profil Pasar Lepin</h5>
                    <h1 class="mb-4">Pasar<span class="text-primary"> Lepin</span></h1>
                    <p class="mb-4">Pasar Lepin terletak di Jalan Lepin, Kelurahan Rimba Sekampung, Kecamatan
                        Dumai Kota, Kota Dumai, Provinsi Riau. Pasar ini dikenal sebagai salah satu pasar tradisional yang
                        melayani kebutuhan masyarakat sekitar Dumai.</p>
                    <p class="mb-4">Pedagang di Pasar Lepin menjual beragam kebutuhan harian, antara lain:</p>
                    <div class="row gy-2 gx-4 mb-4">
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Pakaian pria, wanita, dan
                                anak-anak
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Sandal dan sepatu
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Aksesoris & perlengkapan
                                sandang</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Produk rumah tangga ringan
                            </p>
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
                    <td>Pasar Lepin</td>
                </tr>
                <tr>
                    <td>Alamat Pasar</td>
                    <td>Kelurahan Ratu Sima, Kecamatan Dumai Selatan, Kota Dumai</td>
                </tr>
                <tr>
                    <td>Titik koordinat Pasar</td>
                    <td>1.6865° N, 101.4472° E</td>
                </tr>
                <tr>
                    <td>Tahun Berdiri</td>
                    <td>2000-an</td>
                </tr>
                <tr>
                    <td>Luas Lahan Pasar</td>
                    <td>± 2.500 m²</td>
                </tr>
                <tr>
                    <td>Fasilitas Pasar</td>
                    <td>Kios pakaian, los dagang, area parkir</td>
                </tr>
                <tr>
                    <td>Jam Operasional Pasar</td>
                    <td>Setiap hari, pukul 08.00 sd 21.00 WIB</td>
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
                <h5 class="section-title px-3">Foto Pasar Lepin</h5>
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
