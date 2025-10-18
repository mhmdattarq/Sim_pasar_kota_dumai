@extends('backend_admin.app')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Pengumuman</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Informasi</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="position-relative">
                        <h5 class="card-title">Kelola Informasi</h5>
                    </div>
                    <div class="ms-auto">
                        <button type="button" class="btn btn-success radius-30 mt-2 mt-lg-0" data-bs-toggle="modal" data-bs-target="#addPengumumanModal">
                            <i class="bx bxs-plus-square"></i>Tambah Pengumuman
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Lihat Isi Pengumuman</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengumumans as $pengumuman)
                                <tr>
                                    <td>{{ $pengumuman->judul }}</td>
                                    <td>
                                        <div class="badge rounded-pill {{ $pengumuman->status == 'Terpublish' ? 'text-success bg-light-success' : 'text-warning bg-light-warning' }} p-2 text-uppercase px-3">
                                            <i class='bx bxs-circle me-1'></i>{{ $pengumuman->status }}
                                        </div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($pengumuman->tanggal)->format('d M Y') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm radius-30 px-4" data-bs-toggle="modal" data-bs-target="#viewPengumumanModal_{{ $pengumuman->id }}" data-id="{{ $pengumuman->id }}">
                                            View Details
                                        </button>
                                    </td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <a href="#" class="edit-btn" data-bs-toggle="modal" data-bs-target="#editPengumumanModal_{{ $pengumuman->id }}" data-id="{{ $pengumuman->id }}"><i class='bx bxs-edit'></i></a>
                                            <button type="button" class="ms-3 btn btn-link text-danger" data-id="{{ $pengumuman->id }}" id="deletePengumuman_{{ $pengumuman->id }}"><i class='bx bxs-trash'></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Pengumuman (Tetap Apa Adanya) -->
        <div class="modal fade" id="addPengumumanModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pengumuman Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-9 mx-auto">
                                <h6 class="mb-0 text-uppercase">Form Pengumuman</h6>
                                <hr/>
                                <div class="card border-top border-0 border-4 border-info">
                                    <div class="card-body">
                                        <div class="border p-4 rounded">
                                            <div class="card-title d-flex align-items-center">
                                                <div><i class="bx bxs-news me-1 font-22 text-info"></i></div>
                                                <h5 class="mb-0 text-info">Tambah Pengumuman</h5>
                                            </div>
                                            <hr/>
                                            <form id="addPengumumanForm" method="POST" action="{{ route('pengumuman.store') }}">
                                            @csrf
                                            <div class="row mb-3">
                                                <label for="judul" class="col-sm-3 col-form-label">Judul</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="judul" class="form-control" id="judul" placeholder="Masukkan Judul" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="isi" class="col-sm-3 col-form-label">Isi</label>
                                                <div class="col-sm-9">
                                                    <textarea name="isi" class="form-control" id="isi" rows="3" placeholder="Masukkan Isi Pengumuman" required></textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
                                                <div class="col-sm-9">
                                                    <input type="date" name="tanggal" class="form-control" id="tanggal" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="status" class="col-sm-3 col-form-label">Status</label>
                                                <div class="col-sm-9">
                                                    <select name="status" class="form-select mb-3" id="status" aria-label="Pilih Status" required>
                                                        <option value="" selected>Pilih Status</option>
                                                        <option value="Draft">Draft</option>
                                                        <option value="Terpublish">Terpublish</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="formError" class="text-danger"></div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success px-5" id="savePengumuman">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit Pengumuman (Struktur Sama dengan Tambah) -->
        @foreach ($pengumumans as $pengumuman)
            <div class="modal fade" id="editPengumumanModal_{{ $pengumuman->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Pengumuman</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xl-9 mx-auto">
                                    <h6 class="mb-0 text-uppercase">Form Pengumuman</h6>
                                    <hr/>
                                    <div class="card border-top border-0 border-4 border-info">
                                        <div class="card-body">
                                            <div class="border p-4 rounded">
                                                <div class="card-title d-flex align-items-center">
                                                    <div><i class="bx bxs-news me-1 font-22 text-info"></i></div>
                                                    <h5 class="mb-0 text-info">Edit Pengumuman</h5>
                                                </div>
                                                <hr/>
                                                <form id="editPengumumanForm_{{ $pengumuman->id }}" data-id="{{ $pengumuman->id }}"> <!-- Hapus action dan method, biar cuma AJAX -->
                                                    @csrf
                                                    <input type="hidden" name="_method" value="PUT"> <!-- Tambah hidden input untuk PUT -->
                                                    <div class="row mb-3">
                                                        <label for="judul_{{ $pengumuman->id }}" class="col-sm-3 col-form-label">Judul</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="judul" class="form-control" id="judul_{{ $pengumuman->id }}" value="{{ $pengumuman->judul }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="isi_{{ $pengumuman->id }}" class="col-sm-3 col-form-label">Isi</label>
                                                        <div class="col-sm-9">
                                                            <textarea name="isi" class="form-control" id="isi_{{ $pengumuman->id }}" rows="3" required>{{ $pengumuman->isi }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="tanggal_{{ $pengumuman->id }}" class="col-sm-3 col-form-label">Tanggal</label>
                                                        <div class="col-sm-9">
                                                            <input type="date" name="tanggal" class="form-control" id="tanggal_{{ $pengumuman->id }}" value="{{ \Carbon\Carbon::parse($pengumuman->tanggal)->format('Y-m-d') }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="status_{{ $pengumuman->id }}" class="col-sm-3 col-form-label">Status</label>
                                                        <div class="col-sm-9">
                                                            <select name="status" class="form-select mb-3" id="status_{{ $pengumuman->id }}" required>
                                                                <option value="Draft" {{ $pengumuman->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                                                                <option value="Terpublish" {{ $pengumuman->status == 'Terpublish' ? 'selected' : '' }}>Terpublish</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div id="editFormError_{{ $pengumuman->id }}" class="text-danger"></div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-warning px-5" id="updatePengumuman_{{ $pengumuman->id }}">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Modal View Detail Pengumuman -->
        @foreach ($pengumumans as $pengumuman)
            <div class="modal fade" id="viewPengumumanModal_{{ $pengumuman->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content" style="border: none; box-shadow: none;">
                        <div class="modal-header" style="border-bottom: none;">
                            <h5 class="modal-title">Detail Pengumuman: {{ $pengumuman->judul }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="padding: 20px;">
                            <table class="table" style="border: none; width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td style="width: 20%; padding: 8px; border: none;"><strong>Judul:</strong></td>
                                    <td style="padding: 8px; border: none;">{{ $pengumuman->judul }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 20%; padding: 8px; border: none;"><strong>Isi:</strong></td>
                                    <td style="padding: 8px; border: none;">{{ $pengumuman->isi }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 20%; padding: 8px; border: none;"><strong>Status:</strong></td>
                                    <td style="padding: 8px; border: none;">{{ $pengumuman->status }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 20%; padding: 8px; border: none;"><strong>Tanggal:</strong></td>
                                    <td style="padding: 8px; border: none;">{{ \Carbon\Carbon::parse($pengumuman->tanggal)->format('d M Y') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer" style="border-top: none;">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Include SweetAlert2 untuk notifikasi -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- JavaScript untuk submit form via AJAX -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Submit untuk tambah pengumuman (tetap sama)
        const addForm = document.getElementById('addPengumumanForm');
        const saveButton = document.getElementById('savePengumuman');
        const addErrorDiv = document.getElementById('formError');

        if (addForm && saveButton && addErrorDiv) {
            saveButton.addEventListener('click', function (event) {
                event.preventDefault();
                addErrorDiv.textContent = '';

                const formData = new FormData(addForm);

                fetch('{{ route('pengumuman.store') }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) throw new Error('Respon server bermasalah');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Pengumuman berhasil ditambahkan!',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            addForm.reset();
                            try {
                                $('#addPengumumanModal').modal('hide');
                                location.reload();
                            } catch (e) {
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message || 'Terjadi kesalahan saat menyimpan.'
                        });
                        if (data.errors) {
                            addErrorDiv.textContent = Object.values(data.errors).flat().join(', ');
                        }
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan pada server: ' + error.message
                    });
                });
            });
        }

        // Submit untuk edit pengumuman (tetap sama)
        @foreach ($pengumumans as $pengumuman)
            try {
                const editForm = document.getElementById('editPengumumanForm_{{ $pengumuman->id }}');
                const updateButton = document.getElementById('updatePengumuman_{{ $pengumuman->id }}');
                const editErrorDiv = document.getElementById('editFormError_{{ $pengumuman->id }}');

                if (editForm && updateButton && editErrorDiv) {
                    updateButton.addEventListener('click', function (event) {
                        event.preventDefault();
                        editErrorDiv.textContent = '';

                        const formData = new FormData(editForm);
                        formData.append('_method', 'PUT');
                        const id = editForm.getAttribute('data-id');
                        const url = '{{ route('pengumuman.update', ':id') }}'.replace(':id', id);

                        fetch(url, {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Respon server bermasalah');
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: 'Pengumuman berhasil diperbarui!',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    try {
                                        $('#editPengumumanModal_{{ $pengumuman->id }}').modal('hide');
                                        location.reload();
                                    } catch (e) {
                                        location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: data.message || 'Terjadi kesalahan saat memperbarui.'
                                });
                                if (data.errors) {
                                    editErrorDiv.textContent = Object.values(data.errors).flat().join(', ');
                                }
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan pada server: ' + error.message
                            });
                        });
                    });
                } else {
                    console.warn('Elemen update untuk ID {{ $pengumuman->id }} tidak lengkap');
                }
            } catch (e) {
                console.warn('Error inisialisasi update untuk ID {{ $pengumuman->id }}: ' + e.message);
            }
        @endforeach

        // Submit untuk hapus pengumuman (diperbaiki dengan try-catch)
        @foreach ($pengumumans as $pengumuman)
            try {
                const deleteButton = document.getElementById('deletePengumuman_{{ $pengumuman->id }}');
                if (deleteButton) {
                    deleteButton.addEventListener('click', function () {
                        Swal.fire({
                            title: 'Apakah Anda Yakin?',
                            text: 'Data akan dihapus permanen!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const id = this.getAttribute('data-id');
                                const url = '{{ route('pengumuman.destroy', ':id') }}'.replace(':id', id);

                                fetch(url, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({ id: id })
                                })
                                .then(response => {
                                    if (!response.ok) throw new Error('Respon server bermasalah');
                                    return response.json();
                                })
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Sukses',
                                            text: 'Pengumuman berhasil dihapus!',
                                            timer: 2000,
                                            showConfirmButton: false
                                        }).then(() => {
                                            const row = document.querySelector(`tr:has(#deletePengumuman_${id})`);
                                            if (row) row.remove(); // Hapus baris dari DOM
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal',
                                            text: data.message || 'Terjadi kesalahan saat menghapus.'
                                        });
                                    }
                                })
                                .catch(error => {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Terjadi kesalahan pada server: ' + error.message
                                    });
                                });
                            }
                        });
                    });
                } else {
                    console.warn('Tombol hapus untuk ID {{ $pengumuman->id }} tidak ditemukan');
                }
            } catch (e) {
                console.warn('Error inisialisasi hapus untuk ID {{ $pengumuman->id }}: ' + e.message);
            }
        @endforeach
    });
</script>
@endsection