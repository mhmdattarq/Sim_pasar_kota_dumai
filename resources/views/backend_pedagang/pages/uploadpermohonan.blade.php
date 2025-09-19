@extends('backend_pedagang.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Permohonan</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend_pedagang.pages.uploadpermohonan') }}"><i
                                        class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Unggah Surat Permohonan</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="alert alert-info mb-3" style="font-size: 14px;">
                Silakan unggah kembali surat permohonan yang sudah ditandatangani. Setelah itu, mohon tunggu proses
                verifikasi dari <b>admin.</b>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Tombol upload -->
            @if ($permohonans->where('status', 'lengkap')->count() > 0)
                <button type="button" class="btn btn-secondary mb-3" disabled>
                    Dokumen sudah diunggah
                </button>
            @else
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    Unggah Dokumen
                </button>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_permohonan" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permohonans as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $p->nama }}</td>
                                        <td>
                                            @if ($p->status == 'draft')
                                                <span class="badge bg-danger">Draft</span>
                                            @elseif ($p->status == 'lengkap')
                                                <span class="badge bg-success">Uploaded, Terkirim</span>
                                            @elseif ($p->status == 'disetujui')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif ($p->status == 'ditolak')
                                                <span class="badge bg-primary">Ditolak</span>
                                            @else
                                                <span class="badge bg-secondary">Unknown</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($p->status === 'draft')
                                                <a href="{{ route('pedagang.permohonan.download', $p->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    Download Dokumen Permohonan Anda
                                                </a>
                                            @else
                                                {{ $p->keterangan ?? '-' }}
                                            @endif
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

    <!-- Modal Upload -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('uploadpermohonan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Dokumen</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="permohonan_id" class="form-label">Pemohon</label>
                            <input type="text" class="form-control" value="{{ $p->nama }}" readonly>

                            {{-- hidden input supaya id tetap ikut ke controller --}}
                            <input type="hidden" name="permohonan_id" value="{{ $p->id }}">
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload Surat Permohonan (PDF)</label>
                            <input type="file" name="file" id="file" class="form-control"
                                accept="application/pdf" required>
                            @error('file')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Upload</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
