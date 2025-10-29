@extends('frontend.app')

@section('content')
    <!-- Header Start -->
    <div class="container-fluid d-flex align-items-center justify-content-center"
        style="background-image: url('{{ asset('frontend/assets/img/tarif.jpeg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 300px;">
        <div class="container text-center">
            <h3 class="display-3 mb-4 text-white">Tarif Restribusi</h3>
        </div>
    </div>
    <!-- Header End -->
    <!-- tarif Start -->
    <div class="container-fluid destination py-5">
        <div class="container py-5">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center" id="tarifTable">
                    <thead class="table-primary">
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
                            <td>
                                Pasar Rakyat Tipe A <br>
                                1. Pasar Kliwon Rejo Amertani Temanggung <br>
                                2. Pasar Legi Parakan <br>
                                3. Pasar Temanggung Permai <br>
                                4. Pertokoan Temanggung Indah
                            </td>
                            <td>Kelas Utama</td>
                            <td>Ruko</td>
                            <td>Rp. 5.500,00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- tarif End -->
    <script>
    $(document).ready(function() {
        $('#tarifTable').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            lengthMenu: [5, 10, 25, 50],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            }
        });
    });
</script>

@endsection
