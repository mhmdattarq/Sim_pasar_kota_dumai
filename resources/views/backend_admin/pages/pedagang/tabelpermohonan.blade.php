@extends('backend_admin.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Pedagang</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Permohonan</li>
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
            <br>
            <h6 class="mb-0 text-uppercase">Table Permohonan Pedagang</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_permohonan" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permohonans as $p)
    @if ($p->status === 'lengkap' || $p->status == 'disetujui' || $p->status === 'ditolak' || $p->status === 'verifikasi' || $p->status === 'selesai')
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $p->nama }}</td>
            <td>{{ \Carbon\Carbon::parse($p->updated_at)->format('d-m-Y') }}</td>
            <th>
                @if ($p->status == 'draft')
                    <span class="badge bg-danger">Draft</span>
                @elseif ($p->status == 'lengkap')
                    <span class="badge bg-warning text-dark">Lengkap</span>
                @elseif ($p->status == 'disetujui')
                    <span class="badge bg-success">Disetujui, Belum Terverifikasi</span>
                @elseif ($p->status == 'ditolak')
                    <span class="badge bg-danger">Ditolak</span>
                @elseif ($p->status == 'selesai')
                    <span class="badge bg-success">Selesai</span>
                @elseif ($p->status == 'verifikasi')
                    <span class="badge bg-info">Menunggu Verifikasi</span>
                @else
                    <span class="badge bg-secondary">Unknown</span>
                @endif
            </th>
            <td>{{ $p->keterangan ?? '-' }}</td>
            <td>
                <!-- Tombol Review -->
                <button type="button" class="btn btn-gradient-warning btn-sm view-pdf"
                    data-bs-toggle="modal" data-bs-target="#reviewModal{{ $p->id }}"
                    data-nik="{{ $p->nik }}" data-nama="{{ $p->nama }}">
                    Review
                </button>
                <button type="button" class="btn btn-sm approve-pdf @if ($p->status == 'draft' || $p->status == 'disetujui' || $p->status == 'ditolak' || $p->status == 'selesai' || $p->status == 'verifikasi') btn-secondary @else btn-success @endif"
                        data-bs-toggle="modal" data-bs-target="#approveModal{{ $p->id }}"
                        data-nik="{{ $p->nik }}" data-nama="{{ $p->nama }}"
                        @if ($p->status == 'draft' || $p->status == 'disetujui' || $p->status == 'ditolak' || $p->status == 'selesai' || $p->status == 'verifikasi') disabled @endif>
                    Persetujuan
                </button>
                <button type="button" class="btn btn-sm verify-pdf @if ($p->status != 'verifikasi') btn-secondary @else btn-primary @endif"
                        data-id="{{ $p->id }}" data-nama="{{ $p->nama }}"
                        @if ($p->status != 'verifikasi') disabled @endif>
                    Verifikasi
                </button>
                <!-- Modal Preview Surat -->
                <div class="modal fade" id="reviewModal{{ $p->id }}" tabindex="-1"
                    aria-hidden="true" data-nik="{{ $p->nik }}" data-nama="{{ $p->nama }}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Preview Surat Permohonan dari
                                    {{ $p->nama }}</h5>
                                <button type="button" class="btn-close"
                                    data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div id="loading-{{ $p->id }}"
                                    style="text-align:center; padding:20px; display:block;">
                                    Memuat PDF...</div>
                                <div id="adobe-dc-view-{{ $p->id }}"
                                    style="height:600px; display:none;"
                                    class="adobe-view-container"></div>
                                <iframe id="fallback-pdf-{{ $p->id }}" src=""
                                    width="100%" height="600px"
                                    style="border:none; display:none;"></iframe>
                                <!-- Dokumen Tambahan -->
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h6 class="mb-3">Dokumen Kelengkapan Pemohon:</h6>
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 100px;">NIB</td>
                                                    <td style="width: 500px; text-align: left;">:</td>
                                                    <td class="text-right" style="width: 150px;">
                                                        <button type="button" class="btn btn-sm btn-warning view-document"
                                                            data-nik="{{ $p->nik }}" data-doc-type="nib"
                                                            data-bs-toggle="modal" data-bs-target="#documentModal{{ $p->id }}">
                                                            Lihat Dokumen
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">Fotokopi NPWP</td>
                                                    <td>:</td>
                                                    <td class="text-right">
                                                        <button type="button" class="btn btn-sm btn-warning view-document"
                                                            data-nik="{{ $p->nik }}" data-doc-type="npwp"
                                                            data-bs-toggle="modal" data-bs-target="#documentModal{{ $p->id }}">
                                                            Lihat Dokumen
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">Fotokopi KTP</td>
                                                    <td>:</td>
                                                    <td class="text-right">
                                                        <button type="button" class="btn btn-sm btn-warning view-document"
                                                            data-nik="{{ $p->nik }}" data-doc-type="ktp"
                                                            data-bs-toggle="modal" data-bs-target="#documentModal{{ $p->id }}">
                                                            Lihat Dokumen
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">Fotokopi KK</td>
                                                    <td>:</td>
                                                    <td class="text-right">
                                                        <button type="button" class="btn btn-sm btn-warning view-document"
                                                            data-nik="{{ $p->nik }}" data-doc-type="kk"
                                                            data-bs-toggle="modal" data-bs-target="#documentModal{{ $p->id }}">
                                                            Lihat Dokumen
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">Pas Foto</td>
                                                    <td>:</td>
                                                    <td class="text-right">
                                                        <button type="button" class="btn btn-sm btn-warning view-document"
                                                            data-nik="{{ $p->nik }}" data-doc-type="foto"
                                                            data-bs-toggle="modal" data-bs-target="#documentModal{{ $p->id }}">
                                                            Lihat Dokumen
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @if($p->status === 'verifikasi' || $p->status === 'selesai')
                                            <hr>
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 100px;">Surat Pernyataan</td>
                                                        <td style="width: 500px; text-align: left;">:</td>
                                                        <td class="text-right" style="width: 150px;">
                                                            <button type="button" class="btn btn-sm btn-warning view-document"
                                                                data-nik="{{ $p->nik }}" data-doc-type="pernyataan"
                                                                data-bs-toggle="modal" data-bs-target="#documentModal{{ $p->id }}">
                                                                Lihat Dokumen
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                                <!-- End Dokumen Tambahan -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger"
                                    data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal Preview Surat -->
                <!-- Modal Dokumen -->
                <div class="modal fade" id="documentModal{{ $p->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="documentModalTitle{{ $p->id }}">Preview Dokumen</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="loading-document-{{ $p->id }}" style="text-align:center; padding:20px; display:none;">
                                    Memuat Dokumen...</div>
                                <div id="adobe-dc-view-document-{{ $p->id }}" style="height:90vh; display:none;" class="adobe-view-container"></div>
                                <iframe id="fallback-pdf-document-{{ $p->id }}" src="" width="100%" height="90vh" style="border:none; display:none;"></iframe>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <a href="#" id="open-in-new-tab-{{ $p->id }}" class="btn btn-primary" target="_blank">Buka di Tab Baru</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal Dokumen -->
                <!-- Modal Setujui -->
                <div class="modal fade" id="approveModal{{ $p->id }}" tabindex="-1"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Persetujuan Pedagang untuk
                                    {{ $p->nama }}</h5>
                                <button type="button" class="btn-close"
                                    data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="approval-form-{{ $p->id }}" class="mt-4"
                                    data-id="{{ $p->id }}"
                                    data-nik="{{ $p->nik }}"
                                    data-nama="{{ $p->nama }}">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Status
                                            Persetujuan :</label>
                                        <div class="col-sm-9">
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input"
                                                    name="approval-status-{{ $p->id }}"
                                                    value="approved"
                                                    id="approved-{{ $p->id }}" checked>
                                                <label class="form-check-label"
                                                    for="approved-{{ $p->id }}">DIKABULKAN</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input"
                                                    name="approval-status-{{ $p->id }}"
                                                    value="rejected"
                                                    id="rejected-{{ $p->id }}">
                                                <label class="form-check-label"
                                                    for="rejected-{{ $p->id }}">TIDAK
                                                    DIKABULKAN</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3"
                                        id="reason-container-{{ $p->id }}"
                                        style="display:none;">
                                        <label class="col-sm-3 col-form-label">Alasan Tidak
                                            Dikabulkan :</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control mb-3" placeholder="Masukkan Alasan.." aria-label="default textarea example"
                                                id="reason-text-{{ $p->id }}" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button type="submit"
                                                class="btn btn-success px-5">Simpan
                                                Persetujuan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Adobe Embed API & SweetAlert2 -->
    <script src="https://documentcloud.adobe.com/view-sdk/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("adobe_dc_view_sdk.ready", function() {
            // Function to load review PDF
            function loadReviewPDF(modal, nik, nama, modalId) {
                const loadingEl = document.getElementById('loading-' + modalId.replace('reviewModal', ''));
                const adobeEl = document.getElementById('adobe-dc-view-' + modalId.replace('reviewModal', ''));
                const fallbackEl = document.getElementById('fallback-pdf-' + modalId.replace('reviewModal', ''));
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                loadingEl.style.display = 'block';
                adobeEl.style.display = 'none';
                adobeEl.innerHTML = ''; // Clear previous
                fallbackEl.style.display = 'none';
                fallbackEl.src = '';
                document.querySelector(`#${modalId} .modal-title`).textContent = `Preview Surat Permohonan dari ${nama}`;
                fetch(`/admin/permohonan/${nik}/review`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    credentials: 'same-origin'
                })
                .then(res => res.ok ? res.json() : res.json().then(err => Promise.reject(err)))
                .then(data => {
                    if (data.error) throw new Error(data.error);
                    const adobeDCView = new AdobeDC.View({
                        clientId: "229eaea6e8ad4be58fbf5d31f21d5155",
                        divId: 'adobe-dc-view-' + modalId.replace('reviewModal', '')
                    });
                    adobeDCView.previewFile({
                        content: {
                            location: {
                                url: data.fileUrl
                            }
                        },
                        metaData: {
                            fileName: data.fileName
                        }
                    }, {
                        embedMode: "SIZED_CONTAINER",
                        showDownloadPDF: false,
                        showPrintPDF: false,
                        enableLinearization: true
                    }).then(() => {
                        loadingEl.style.display = 'none';
                        adobeEl.style.display = 'block';
                    }).catch(err => {
                        console.error('Adobe error for NIK ' + nik + ':', err);
                        loadingEl.style.display = 'none';
                        fallbackEl.src = data?.fileUrl || '';
                        fallbackEl.style.display = 'block';
                        alert('Gagal memuat PDF: ' + err.message);
                    });
                })
                .catch(err => {
                    console.error('Fetch error for NIK ' + nik + ':', err);
                    loadingEl.style.display = 'none';
                    alert('Gagal memuat data: ' + err.message);
                });
            }

            // Attach load to shown event for review modals
            document.querySelectorAll('.modal[id^="reviewModal"]').forEach(modal => {
                modal.addEventListener('shown.bs.modal', function() {
                    const nik = this.dataset.nik;
                    const nama = this.dataset.nama;
                    const modalId = this.id;
                    loadReviewPDF(this, nik, nama, modalId);
                });
            });

            // The view-pdf button just toggles modal, load happens on shown

            // Handle Approve button
            document.querySelectorAll('.approve-pdf').forEach(button => {
                button.addEventListener('click', function() {
                    const nama = this.getAttribute('data-nama');
                    const modalId = this.getAttribute('data-bs-target').substring(1);
                    const formEl = document.getElementById('approval-form-' + modalId.replace(
                        'approveModal', ''));
                    const reasonContainer = document.getElementById('reason-container-' + modalId
                        .replace('approveModal', ''));
                    const reasonText = document.getElementById('reason-text-' + modalId.replace(
                        'approveModal', ''));
                    if (!document.getElementById(modalId)) {
                        console.error('Modal not found for ID:', modalId);
                        return;
                    }
                    const adobeEl = document.querySelector(`#${modalId} .adobe-view-container`);
                    if (adobeEl) adobeEl.style.display = 'none';
                    formEl.style.display = 'block';
                    reasonContainer.style.display = 'none';
                    reasonText.value = '';
                    document.querySelector(`#${modalId} .modal-title`).textContent =
                        `Persetujuan Pedagang untuk ${nama}`;
                    // Handle radio button change
                    document.querySelectorAll(
                            `input[name="approval-status-${modalId.replace('approveModal', '')}"]`)
                        .forEach(radio => {
                            radio.addEventListener('change', function() {
                                if (this.value === 'rejected') {
                                    reasonContainer.style.display = 'block';
                                } else {
                                    reasonContainer.style.display = 'none';
                                    reasonText.value = '';
                                }
                            });
                        });
                });
            });
            // Handle form submission
            document.querySelectorAll('[id^="approval-form-"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const modalId = this.id.replace('approval-form-', '');
                    const id = this.getAttribute('data-id'); // Ambil id dari atribut data-id
                    const nik = this.getAttribute('data-nik'); // Tetap simpan nik jika diperlukan
                    const nama = this.getAttribute('data-nama');
                    const status = document.querySelector(`input[name="approval-status-${modalId}"]:checked`).value;
                    const reason = status === 'rejected' ? document.getElementById(`reason-text-${modalId}`).value : 'surat permohonan telah disetujui';
                    console.log('Submitting approval for ID:', id, 'NIK:', nik, 'Status:', status, 'Reason:', reason);
                    fetch(`/admin/permohonan/${id}/approve`, { // Gunakan id di URL
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            status: status,
                            reason: reason
                        })
                    })
                    .then(res => {
                        console.log('Fetch response status:', res.status);
                        return res.json();
                    })
                    .then(data => {
                        console.log('Fetch response data:', data);
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: status === 'approved' ? 'Sukses' : 'Ditolak',
                                text: status === 'approved' ? 'Surat permohonan telah disetujui' : 'Surat permohonan telah ditolak'
                            });
                            const alertContainer = document.querySelector('.page-content > .page-breadcrumb');
                            if (alertContainer && alertContainer.nextElementSibling) {
                                const alertType = status === 'approved' ? 'success' : 'danger';
                                const alertMessage = `Surat permohonan dari ${nama} telah ${status === 'approved' ? 'disetujui' : 'ditolak'}`;
                                const alertHtml = `<div class="alert alert-${alertType} alert-dismissible fade show" role="alert">${alertMessage}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
                                alertContainer.nextElementSibling.insertAdjacentHTML('afterbegin', alertHtml);
                                setTimeout(() => {
                                    const alert = alertContainer.nextElementSibling.querySelector('.alert');
                                    if (alert) alert.remove();
                                }, 5000);
                            }
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal memperbarui status: ' + (data.error || 'Unknown error')
                            });
                        }
                    })
                    .catch(err => {
                        console.error('Fetch error:', err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat menyimpan'
                        });
                    });
                });
            });
            // Clean up on modal close
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('hidden.bs.modal', function() {
                    const modalId = this.id;
                    const isApproveModal = modalId.startsWith('approveModal');
                    const formEl = isApproveModal ? document.getElementById('approval-form-' +
                        modalId.replace('approveModal', '')) : null;
                    const reasonContainer = isApproveModal ? document.getElementById(
                        'reason-container-' + modalId.replace('approveModal', '')) : null;
                    const reasonText = isApproveModal ? document.getElementById('reason-text-' +
                        modalId.replace('approveModal', '')) : null;
                    const adobeEl = document.querySelector(`#${modalId} .adobe-view-container`);
                    if (formEl) formEl.style.display = 'none';
                    if (reasonContainer) reasonContainer.style.display = 'none';
                    if (reasonText) reasonText.value = '';
                    if (adobeEl) {
                        adobeEl.style.display = 'none';
                        adobeEl.innerHTML = ''; // Clear Adobe content on close to reset state
                    }
                    // Force remove any lingering backdrops
                    document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
                });
            });
        });
    </script>
    <script>
       // Handle Verify button
            document.querySelectorAll('.verify-pdf').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const nama = this.getAttribute('data-nama');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    console.log('Verify button clicked for ID:', id, 'Nama:', nama, 'Button disabled:', this.disabled);
                    Swal.fire({
                        title: 'Konfirmasi Verifikasi',
                        text: `Apakah Anda yakin ingin memverifikasi permohonan dari ${nama}?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Verifikasi',
                        cancelButtonText: 'Batal',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log('Sending fetch to /admin/permohonan/id/' + id + '/verify');
                            fetch(`/admin/permohonan/id/${id}/verify`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    status: 'selesai'
                                })
                            })
                            .then(res => {
                                console.log('Fetch response status:', res.status);
                                return res.json();
                            })
                            .then(data => {
                                console.log('Fetch response data:', data);
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sukses',
                                        text: `Permohonan dari ${nama} telah berhasil diverifikasi`
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: 'Gagal memverifikasi: ' + (data.error || 'Unknown error')
                                    });
                                }
                            })
                            .catch(err => {
                                console.error('Fetch error:', err);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Terjadi kesalahan saat memverifikasi'
                                });
                            });
                        }
                    });
                });
            });
    </script>
    <script>
    document.addEventListener("adobe_dc_view_sdk.ready", function() {
        // Handle View Document button
        document.querySelectorAll('.view-document').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const nik = this.getAttribute('data-nik');
                const docType = this.getAttribute('data-doc-type');
                const modalId = this.getAttribute('data-bs-target').substring(1);
                const loadingEl = document.getElementById('loading-document-' + modalId.replace('documentModal', ''));
                const adobeEl = document.getElementById('adobe-dc-view-document-' + modalId.replace('documentModal', ''));
                const fallbackEl = document.getElementById('fallback-pdf-document-' + modalId.replace('documentModal', ''));
                const openInNewTabEl = document.getElementById('open-in-new-tab-' + modalId.replace('documentModal', ''));
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const reviewModalId = 'reviewModal' + modalId.replace('documentModal', '');
                const reviewModal = bootstrap.Modal.getInstance(document.getElementById(reviewModalId));
                if (reviewModal) reviewModal.hide();
                loadingEl.style.display = 'block';
                adobeEl.style.display = 'none';
                adobeEl.innerHTML = ''; // Clear previous Adobe content to prevent state issues
                fallbackEl.style.display = 'none';
                fallbackEl.src = '';
                openInNewTabEl.href = '#';
                document.getElementById('documentModalTitle' + modalId.replace('documentModal', '')).textContent = `Preview Dokumen ${docType.toUpperCase()} dari ${nik}`;
                fetch(`/admin/permohonan/${nik}/documents/${docType}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    credentials: 'same-origin'
                })
                .then(res => res.ok ? res.json() : res.json().then(err => Promise.reject(err)))
                .then(data => {
                    if (data.error) throw new Error(data.error);
                    const adobeDCView = new AdobeDC.View({
                        clientId: "229eaea6e8ad4be58fbf5d31f21d5155",
                        divId: 'adobe-dc-view-document-' + modalId.replace('documentModal', '')
                    });
                    adobeDCView.previewFile({
                        content: {
                            location: {
                                url: data.fileUrl
                            }
                        },
                        metaData: {
                            fileName: data.fileName
                        }
                    }, {
                        embedMode: "SIZED_CONTAINER",
                        showDownloadPDF: false,
                        showPrintPDF: false,
                        enableLinearization: true
                    }).then(() => {
                        loadingEl.style.display = 'none';
                        adobeEl.style.display = 'block';
                        openInNewTabEl.href = data.fileUrl;
                    }).catch(err => {
                        console.error('Adobe error for NIK ' + nik + ', DocType ' + docType + ':', err);
                        loadingEl.style.display = 'none';
                        fallbackEl.src = data?.fileUrl || '';
                        fallbackEl.style.display = 'block';
                        openInNewTabEl.href = data?.fileUrl || '#';
                        alert('Gagal memuat dokumen: ' + err.message);
                    });
                })
                .catch(err => {
                    console.error('Fetch error for NIK ' + nik + ', DocType ' + docType + ':', err);
                    loadingEl.style.display = 'none';
                    alert('Gagal memuat data: ' + err.message);
                });
                const documentModal = new bootstrap.Modal(document.getElementById(modalId));
                documentModal.show();
            });
        });
        // Handle modal close to reopen review
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('hidden.bs.modal', function() {
                const modalId = this.id;
                if (modalId.startsWith('documentModal')) {
                    const reviewModalId = 'reviewModal' + modalId.replace('documentModal', '');
                    const reviewModal = new bootstrap.Modal(document.getElementById(reviewModalId));
                    if (reviewModal) reviewModal.show();
                }
                // Force remove any lingering backdrops
                document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
            });
        });
    });
</script>
@endsection