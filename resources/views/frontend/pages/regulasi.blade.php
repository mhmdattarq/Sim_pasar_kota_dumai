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
            <h3 class="display-3 mb-4 text-white">REGULASI</h3>
        </div>
    </div>


    <!-- Header End -->
    <!-- Destination Start -->
    <div class="container-fluid destination py-5">
        <div class="container py-5">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Nama Regulasi</th>
                        <th>Tentang Regulasi</th>
                        <th>No</th>
                        <th>Tahun Regulasi</th>
                        <th>Dokumen Regulasi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Peraturan Bupati</td>
                        <td>PERDA NO 17 TAHUN 2020 TENTANG PERUBAHAN KEDUA ATAS PERATURAN DAERAH KABUPATEN TEMANGGUNG NOMOR
                            1 TH 2013 TENTANG RETRIBUSI PEMAKAIAN KEKAYAAN DAERAH</td>
                        <td>12</td>
                        <td>2020</td>
                        <td>Tombol aksi</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Destination End -->
@endsection
