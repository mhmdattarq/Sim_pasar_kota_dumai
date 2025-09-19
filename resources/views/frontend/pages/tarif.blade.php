@extends('frontend.app')

@section('content')
    <!-- Header Start -->
    <div class="container-fluid d-flex align-items-center justify-content-center"
        style="background-image: url('{{ asset('frontend/assets/img/bannertarif.jpeg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 300px;">
        <div class="container text-center">
            <h3 class="display-3 mb-4 text-white">Tarif Restribusi</h3>
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
                        <th>Jenis Pelayanan</th>
                        <th>Tipe Pasar</th>
                        <th>Tipe Sub</th>
                        <th>Objek Restribusi</th>
                        <th>Tarif Restribusi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Ruko, Toko, Kios dan Los/Pelataran</td>
                        <td>Pasar Rakyat Tipe A
                            1. Pasar Kliwon Rejo Amertani Temanggung 2. Pasar Legi Parakan 3. Pasar Temanggung Permai 4.
                            Pertokoan Temanggung Indah</td>
                        <td>Kelas Utama</td>
                        <td>Ruko</td>
                        <td>Rp. 5.500,00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Destination End -->
@endsection
