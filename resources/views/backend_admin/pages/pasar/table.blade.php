@extends('backend_admin.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Pasar</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Pasar</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <br>
            <h6 class="mb-0 text-uppercase">Table Pasar</h6>
            <hr />
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_pasar" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pasar</th>
                                    <th>Alamat</th>
                                    <th>Total Kios</th>
                                    <th>Total Los</th>
                                    <th>Total Pelataran</th>
                                    <th>Detail Pasar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pasar as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->nama_pasar }}</td>
                                        <td>{{ $data->alamat }}</td>
                                        <td>{{ $data->total_kios }}</td>
                                        <td>{{ $data->total_los }}</td>
                                        <td>{{ $data->total_pelataran }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm radius-30 px-4 view-detail"
                                                    data-id="{{ $data->id }}">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Fullscreen -->
    <div class="modal fade" id="detailPasarModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Detail Pasar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBody">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    console.log('Table script loaded'); // DEBUG

    var buttons = $('.view-detail');
    console.log('Found view-detail buttons:', buttons.length); // DEBUG

    if (buttons.length === 0) {
        console.error('No view-detail buttons found! Check table HTML.');
        alert('Error: Tombol detail tidak ditemukan.');
        return;
    }

    buttons.each(function() {
        $(this).on('click', function() {
            var id = $(this).data('id');
            console.log('Button clicked, ID:', id); // DEBUG

            if (!id) {
                console.error('No ID found on button!');
                alert('Error: ID tidak ditemukan.');
                return;
            }

            // Show modal
            try {
                var modal = new bootstrap.Modal(document.getElementById('detailPasarModal'));
                modal.show();
                console.log('Modal opened'); // DEBUG
            } catch (e) {
                console.error('Error opening modal:', e);
                alert('Error: Gagal membuka modal.');
                return;
            }

            // Reset modal
            var modalBody = $('#modalBody');
            modalBody.html(`
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `);
            $('#modalTitle').text('Detail Pasar');

            // Fetch data
            console.log('Fetching data for ID:', id); // DEBUG
            $.ajax({
                url: '{{ route("pasar.show", ":id") }}'.replace(':id', id),
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || ''
                },
                success: function(data) {
                    console.log('Data received:', data); // DEBUG
                    if (data.error) {
                        modalBody.html(`<div class="alert alert-danger">Error: ${data.error}</div>`);
                        return;
                    }

                    var lokasiPeta = data.lokasi_peta && data.lokasi_peta.includes('<iframe') 
                        ? data.lokasi_peta 
                        : '<p class="text-muted">Tidak ada peta tersedia</p>';

                    $('#modalTitle').text(`Detail Pasar: ${data.nama_pasar || 'N/A'}`);
                    modalBody.html(`
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-xl-8 col-lg-10">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td style="width: 25%; vertical-align: top;"><strong>Nama Pasar</strong></td>
                                            <td style="width: 5%; vertical-align: top;">:</td>
                                            <td>${data.nama_pasar || 'N/A'}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 25%; vertical-align: top;"><strong>Alamat</strong></td>
                                            <td style="width: 5%; vertical-align: top;">:</td>
                                            <td>${data.alamat || 'N/A'}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 25%; vertical-align: top;"><strong>Total Kios</strong></td>
                                            <td style="width: 5%; vertical-align: top;">:</td>
                                            <td>${data.total_kios || 0}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 25%; vertical-align: top;"><strong>Total Los</strong></td>
                                            <td style="width: 5%; vertical-align: top;">:</td>
                                            <td>${data.total_los || 0}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 25%; vertical-align: top;"><strong>Total Pelataran</strong></td>
                                            <td style="width: 5%; vertical-align: top;">:</td>
                                            <td>${data.total_pelataran || 0}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 25%; vertical-align: top;"><strong>Foto Tampak Depan</strong></td>
                                            <td style="width: 5%; vertical-align: top;">:</td>
                                            <td>
                                                ${data.foto_depan ? `
                                                    <img src="${data.foto_depan}" alt="Foto Depan" class="img-fluid mb-3" style="max-height: 200px;" onerror="this.src='https://via.placeholder.com/300x200?text=Tidak+Ada+Foto';">
                                                ` : '<p class="text-muted">Tidak ada foto</p>'}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 25%; vertical-align: top;"><strong>Foto Tampak Belakang</strong></td>
                                            <td style="width: 5%; vertical-align: top;">:</td>
                                            <td>
                                                ${data.foto_belakang ? `
                                                    <img src="${data.foto_belakang}" alt="Foto Belakang" class="img-fluid mb-3" style="max-height: 200px;" onerror="this.src='https://via.placeholder.com/300x200?text=Tidak+Ada+Foto';">
                                                ` : '<p class="text-muted">Tidak ada foto</p>'}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 25%; vertical-align: top;"><strong>Foto Tampak Dalam</strong></td>
                                            <td style="width: 5%; vertical-align: top;">:</td>
                                            <td>
                                                ${data.foto_dalam ? `
                                                    <img src="${data.foto_dalam}" alt="Foto Dalam" class="img-fluid mb-3" style="max-height: 200px;" onerror="this.src='https://via.placeholder.com/300x200?text=Tidak+Ada+Foto';">
                                                ` : '<p class="text-muted">Tidak ada foto</p>'}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 25%; vertical-align: top;"><strong>Lokasi Peta</strong></td>
                                            <td style="width: 5%; vertical-align: top;">:</td>
                                            <td>
                                                <div style="max-height: 400px; overflow: auto;">
                                                    ${lokasiPeta}
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    `);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error, xhr.responseText); // DEBUG
                    modalBody.html(`<div class="alert alert-danger">Error loading data: ${xhr.status} ${xhr.statusText}</div>`);
                }
            });
        });
    });
});
</script>
@endpush