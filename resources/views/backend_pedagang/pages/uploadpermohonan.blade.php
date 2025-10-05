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

            @foreach ($permohonans as $permohonan)
                @if ($permohonan->status == 'draft')
                    <div class="alert alert-info mb-3" style="font-size: 14px;">
                        Silakan unggah kembali Surat permohonan yang sudah ditandatangani. Setelah itu, mohon tunggu proses
                        verifikasi dari <b>admin.</b>
                    </div>
                @elseif ($permohonan->status == 'disetujui')
                    <div class="alert alert-warning mb-3" style="font-size: 14px;">
                        Surat permohonan Anda telah berhasil disetujui. Silahkan unduh Surat pemberitahuan dan Surat
                        pernyataan menjadi pedagang,
                        <b>lalu tanda tangani Surat pernyataan</b> untuk menyelesaikan verifikasi.
                    </div>
                @endif
            @endforeach

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Tombol upload -->
            @foreach ($permohonans as $permohonan)
                @if ($permohonan->status == 'lengkap')
                    <button type="button" class="btn btn-secondary mb-3" disabled>
                        Dokumen sudah diunggah
                    </button>
                @elseif($permohonan->status == 'draft')
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                        data-bs-target="#uploadModal">
                        Unggah Dokumen
                    </button>
                @elseif ($permohonan->status == 'disetujui')
                    <button type="button" class="btn btn-warning mb-3" data-bs-toggle="modal"
                        data-bs-target="#VerifikasiModal">
                        Verifikasi!
                    </button>
                @endif
            @endforeach

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
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permohonans as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $p->nama }}</td>
                                        <td>
                                            @if ($p->status == 'draft')
                                                <span class="badge bg-warning">Draft</span>
                                            @elseif ($p->status == 'lengkap')
                                                <span class="badge bg-success">Uploaded, Terkirim</span>
                                            @elseif ($p->status == 'disetujui')
                                                <span class="badge bg-success">Disetujui, Belum Terverifikasi</span>
                                            @elseif ($p->status == 'ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @elseif ($p->status == 'selesai')
                                                <span class="badge bg-success">selesai</span>
                                            @else
                                                <span class="badge bg-secondary">Unknown</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($p->status === 'draft')
                                                {{ $p->keterangan ?? '' }}
                                            @elseif ($p->status === 'lengkap')
                                                {{ $p->keterangan ?? '' }}
                                            @elseif($p->status === 'disetujui')
                                                {{ $p->keterangan ?? '' }}
                                            @elseif($p->status === 'ditolak')
                                                {{ $p->keterangan ?? '' }}
                                            @elseif($p->status === 'selesai')
                                                {{ $p->keterangan ?? '' }}
                                            @else
                                                {{ $p->keterangan ?? '-' }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($p->status == 'disetujui')
                                                <a href="{{ route('pedagang.pemberitahuan.download') }}"
                                                    class="btn btn-sm btn-success">
                                                    Download Surat <b>Pemberitahuan</b>
                                                </a>
                                                |
                                                <a href="{{ route('pedagang.pernyataan.download') }}"
                                                    class="btn btn-sm btn-success">
                                                    Download Surat <b>Pernyataan</b>
                                                </a>
                                            @elseif ($p->status == 'draft')
                                                <a href="{{ route('pedagang.permohonan.download', $p->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    Download Dokumen Permohonan Anda
                                                </a>
                                            @elseif ($p->status == 'lengkap')
                                                <a href="#" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#viewDocumentModal" data-id="{{ $p->id }}">
                                                    Lihat Permohonan Anda
                                                </a>
                                            @elseif ($p->status == 'lengkap')
                                            @else
                                                -
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
                        <h5 class="modal-title">Unggah Dokumen</h5>
                    </div>
                    <div class="alert alert-info mb-3" style="font-size: 14px;">
                        <span style="animation: blink 1.5s infinite;">
                            Silahkan <b> tanda tangani Surat Permohonan menjadi pedagang</b> untuk Melengkapi Dokumen Anda.
                        </span>
                    </div>
                    <style>
                        @keyframes blink {
                            0% {
                                opacity: 1;
                            }

                            50% {
                                opacity: 0.3;
                            }

                            100% {
                                opacity: 1;
                            }
                        }
                    </style>
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
    <!-- End Modal Upload -->

    <!-- Modal Verifikasi -->
    <div class="modal fade" id="VerifikasiModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('pedagang.uploadSigned') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Verifikasi Dokumen</h5>
                    </div>
                    <div class="alert alert-warning mb-3" style="font-size: 14px;">
                        <span style="animation: blink 1.5s infinite;">
                            Silahkan <b> tanda tangani Surat pernyataan menjadi pedagang</b> untuk menyelesaikan verifikasi.
                        </span>
                    </div>
                    <style>
                        @keyframes blink {
                            0% {
                                opacity: 1;
                            }

                            50% {
                                opacity: 0.3;
                            }

                            100% {
                                opacity: 1;
                            }
                        }
                    </style>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="permohonan_id" class="form-label">Pemohon</label>
                            <input type="text" class="form-control" value="{{ $p->nama }}" readonly>

                            {{-- hidden input supaya id tetap ikut ke controller --}}
                            <input type="hidden" name="permohonan_id" value="{{ $p->id }}">
                        </div>
                        <div class="mb-3">
                            <label for="signed_document" class="form-label">Upload Surat Pernyataan Menjadi Pedagang
                                (PDF)</label>
                            <input type="file" name="signed_document" id="signed_document" class="form-control"
                                accept="application/pdf" required>
                            @error('signed_document')
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
    <!-- End Modal Verifikasi -->

    <!-- Modal Lihat Dokumen -->
    <div class="modal fade" id="viewDocumentModal" tabindex="-1" aria-labelledby="viewDocumentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDocumentModalLabel">Lihat Permohonan Anda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Adobe viewer -->
                    <div id="adobe-dc-view-document" style="height:600px;"></div>
                    <!-- Fallback iframe -->
                    <iframe id="fallback-pdf-document" src="" width="100%" height="600px"
                        style="border:none; display:none;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Lihat Dokumen -->

    <!-- Adobe SDK -->
    <script src="https://documentcloud.adobe.com/view-sdk/main.js"></script>

    <!-- Script untuk Modal -->
    <script>
        document.addEventListener("adobe_dc_view_sdk.ready", function() {
            let adobeDCView = null;

            $('#viewDocumentModal').on('shown.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                let permohonanId = button.data('id');
                const fallbackIframe = document.getElementById('fallback-pdf-document');
                const adobeEl = document.getElementById('adobe-dc-view-document');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fallbackIframe.style.display = 'none';
                fallbackIframe.src = '';
                adobeEl.style.display = 'none';
                adobeEl.innerHTML = '';

                // Fetch URL dari controller
                fetch(`/get-document-url/${permohonanId}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(res => {
                        if (!res.ok) throw new Error(`Fetch URL failed: ${res.status}`);
                        return res.json();
                    })
                    .then(data => {
                        if (data.error) throw new Error(data.error);
                        let fileUrl = data.fileUrl + '?v=' + new Date().getTime();
                        console.log('File URL:', fileUrl);

                        // Fetch PDF sebagai ArrayBuffer
                        return fetch(fileUrl, {
                                method: 'GET',
                                credentials: 'same-origin',
                                cache: 'no-store'
                            })
                            .then(pdfRes => {
                                if (!pdfRes.ok) {
                                    throw new Error(
                                        `PDF fetch failed: ${pdfRes.status} - ${pdfRes.statusText}`
                                    );
                                }
                                return pdfRes.arrayBuffer();
                            })
                            .then(arrayBuffer => {
                                adobeDCView = new AdobeDC.View({
                                    clientId: "d74201ec391f4e5dbe13f29b3674ce19",
                                    divId: "adobe-dc-view-document"
                                });
                                return adobeDCView.previewFile({
                                    content: {
                                        promise: Promise.resolve(new Uint8Array(
                                            arrayBuffer))
                                    },
                                    metaData: {
                                        fileName: data.fileName || 'permohonan_lengkap.pdf'
                                    }
                                }, {
                                    embedMode: "SIZED_CONTAINER",
                                    enableDownload: false,
                                    enablePrint: false
                                });
                            })
                            .then(() => {
                                adobeEl.style.display = 'block';
                                console.log('Adobe preview success');
                            });
                    })
                    .catch(err => {
                        console.error('Full error:', err);
                        alert('Gagal memuat dokumen: ' + err.message + '. Cek console.');
                        if (fallbackIframe && fileUrl) {
                            fallbackIframe.src = fileUrl;
                            fallbackIframe.style.display = 'block';
                            adobeEl.style.display = 'none';
                        }
                    });
            });

            // Reset saat modal tutup
            $('#viewDocumentModal').on('hidden.bs.modal', function() {
                document.getElementById('adobe-dc-view-document').innerHTML = '';
                adobeDCView = null;
                const fallbackIframe = document.getElementById('fallback-pdf-document');
                if (fallbackIframe) {
                    fallbackIframe.src = '';
                    fallbackIframe.style.display = 'none';
                }
            });
        });
    </script>
@endsection
