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
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center" id="regulasiTable">
                    <thead class="table-primary">
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
                            <td>
                                PERDA NO 17 TAHUN 2020 <br>
                                Tentang Perubahan Kedua Atas Peraturan Daerah Kabupaten Temanggung Nomor 1 Tahun 2013
                                Tentang Retribusi Pemakaian Kekayaan Daerah
                            </td>
                            <td>12</td>
                            <td>2020</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">
                                    <i class="fa fa-file-pdf"></i> Lihat
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Destination End -->
    <script>
    $(document).ready(function() {
        $('#regulasiTable').DataTable({
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
