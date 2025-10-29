@extends('backend_pedagang.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Dokumen</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend_pedagang.pages.uploadpermohonan') }}"><i
                                        class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Dokumen Anda</li>
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

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_permohonan" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permohonans as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d-m-Y') }}</td>
                                        <td>{{ $p->nama }}</td>
                                        <td>
                                            @if ($p->status == 'disetujui' || $p->status == 'verifikasi')
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
                                                    class="btn btn-sm btn-success">
                                                    Download Dokumen <b>Permohonan</b> Anda
                                                </a>
                                            @elseif ($p->status == 'lengkap')
                                                <a href="#" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#viewDocumentModal" data-id="{{ $p->id }}">
                                                    Lihat Permohonan Anda
                                                </a>
                                            @elseif ($p->status == 'selesai')
                                                <a href="{{ route('pedagang.permohonan.download', $p->id) }}"
                                                    class="btn btn-sm btn-success">
                                                    Download Dokumen <b>Permohonan</b>
                                                </a>
                                                |
                                                <a href="{{ route('pedagang.pernyataan.download') }}"
                                                    class="btn btn-sm btn-success">
                                                    Download Surat <b>Pernyataan</b>
                                                </a>
                                                |
                                                <a href="{{ route('pedagang.pemberitahuan.download') }}"
                                                    class="btn btn-sm btn-success">
                                                    Download Surat <b>Pemberitahuan</b>
                                                </a>
                                            @elseif ($p->status == 'ditolak')
                                                <a href="{{ route('pedagang.pemberitahuan.download') }}"
                                                    class="btn btn-sm btn-danger">
                                                    Download Surat <b>Pemberitahuan</b>
                                                </a>
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
