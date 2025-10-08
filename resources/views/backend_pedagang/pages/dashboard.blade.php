@extends('backend_pedagang.app')

@section('content')
    <div class="col">
        <!-- Modal -->
        <div class="modal fade" id="welcomeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Selamat Datang!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p>Halo, <strong>{{ $displayName ?? Auth::user()->nik }}</strong></p>
                        <p>Selamat Anda berhasil login ke aplikasi <b>Sim-Pasar</b>!</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Lanjutkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row row-cols-1 row-cols-lg-4">
                <div class="col">
                    <div class="card rounded-4 bg-gradient-rainbow bubble position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-0">
                                <div class="">
                                    <h4 class="mb-0 text-white">{{ $totalPermohonan ?? 0 }}</h4>
                                    <p class="mb-0 text-white">Total Permohonan</p>
                                </div>
                                <div class="fs-1 text-white">
                                    <i class="bx bx-cart"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-4 bg-gradient-burning bubble position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-0">
                                <div class="">
                                    <h4 class="mb-0 text-white">{{ $permohonanDitolak ?? 0 }}</h4>
                                    <p class="mb-0 text-white">Permohonan Ditolak</p>
                                </div>
                                <div class="fs-1 text-white">
                                    <i class="bx bx-group"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-4 bg-gradient-moonlit bubble position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-0">
                                <div class="">
                                    <h4 class="mb-0 text-white">{{ $permohonanSelesai ?? 0 }}</h4>
                                    <p class="mb-0 text-white">Permohonan Disetujui dan Selesai</p>
                                </div>
                                <div class="fs-1 text-white">
                                    <i class="bx bx-wallet"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-4 bg-gradient-cosmic bubble position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-0">
                                <div class="">
                                    <h4 class="mb-0 text-white">{{ $permohonanPending ?? 0 }}</h4>
                                    <p class="mb-0 text-white">Permohonan Pending</p>
                                </div>
                                <div class="fs-1 text-white">
                                    <i class="bx bx-line-chart-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->

            @if (!$permohonan)
                <!-- instrtuksi dashboard -->
                <div class="col">
                    <div class="card rounded-4 bg-gradient-danger">
                        <div class="card-body text-center">
                            <h3 class="text-white">Belum Ada Permohonan Menjadi Pedagang!</h3>
                            <div class="widgets-icons-2 mx-auto my-4 bg-white rounded-circle text-dark">
                                <i class='bx bx-window-close'></i>
                            </div>
                            <p class="mb-0 text-white">Anda belum memiliki surat permohonan, Klik tombol di bawah ini untuk
                                membuat surat permohonan menjadi pedagang baru.</p>
                            <a href="{{ route('backend_pedagang.pages.permohonan') }}"
                                class="btn btn-white px-4 rounded-5 mt-4"><i class='bx bx-highlight'></i>Buat
                                Permohonan</a>
                        </div>
                    </div>
                </div>
            @else
                {{-- Kalau status draft --}}
                @if ($permohonan->status == 'draft')
                    <div class="col">
                        <div class="card rounded-4 bg-gradient-warning">
                            <div class="card-body text-center">
                                <h3 class="text-white">Permohonan Sudah Berhasil Dibuat!</h3>
                                <div class="widgets-icons-2 mx-auto my-4 bg-white rounded-circle text-dark">
                                    <i class='bx bx-upload'></i>
                                </div>
                                <p class="mb-0 text-white">Surat permohonan telah berhasil dibuat. Mohon untuk
                                    menandatangani
                                    dokumen tersebut dan mengunggah ulang agar dapat diverifikasi.</p>
                                <a href="{{ route('backend_pedagang.pages.uploadpermohonan') }}"
                                    class="btn btn-white px-4 rounded-5 mt-4"><i class='bx bx-cloud-upload'></i>Unggah
                                    Permohonan</a>
                            </div>
                        </div>
                    </div>
                    {{-- Kalau status lengkap --}}
                @elseif($permohonan->status == 'lengkap')
                    <div class="col">
                        <div class="card rounded-4 bg-gradient-success">
                            <div class="card-body text-center">
                                <h3 class="text-white">Permohonan Sudah Berhasil Diunggah/Dikirim!</h3>
                                <div class="widgets-icons-2 mx-auto my-4 bg-white rounded-circle text-dark">
                                    <i class='bx bx-check-circle'></i>
                                </div>
                                <p class="mb-0 text-white">Surat permohonan Anda telah berhasil diunggah. Mohon menunggu
                                    hingga
                                    proses verifikasi dilakukan oleh admin.</p>
                                <a href="{{ route('backend_pedagang.pages.uploadpermohonan') }}"
                                    class="btn btn-white px-4 rounded-5 mt-4"><i class='bx bx-list-check'></i>Lihat
                                    Permohonan</a>
                            </div>
                        </div>
                    </div>
                @elseif($permohonan->status == 'disetujui')
                    <div class="col">
                        <div class="card rounded-4 bg-gradient-warning">
                            <div class="card-body text-center">
                                <h3 class="text-white">Permohonan Sudah Berhasil Disetujui, Belum Terverifikasi!</h3>
                                <div class="widgets-icons-2 mx-auto my-4 bg-white rounded-circle text-dark">
                                    <i class='bx bx-check-circle'></i>
                                </div>
                                <p class="mb-0 text-white">Surat permohonan Anda telah berhasil disetujui. <br>Silahkan
                                    unduh surat pemberitahuan dan surat pernyataan menjadi pedagang,
                                    lalu tanda tangani Surat pernyataan untuk menyelesaikan verifikasi.</p>
                                <a href="{{ route('backend_pedagang.pages.uploadpermohonan') }}"
                                    class="btn btn-white px-4 rounded-5 mt-4"><i class='bx bx-check'></i>Verifikasi</a>
                            </div>
                        </div>
                    </div>
                @elseif($permohonan->status == 'ditolak')
                    <div class="col">
                        <div class="card rounded-4 bg-gradient-danger">
                            <div class="card-body text-center">
                                <h3 class="text-white">Permohonan Anda Ditolak !</h3>
                                <div class="widgets-icons-2 mx-auto my-4 bg-white rounded-circle text-dark">
                                    <i class='bx bx-x'></i>
                                </div>
                                <p class="mb-0 text-white">Permohonan yang Anda ajukan belum memenuhi kriteria yang diperlukan.
Silakan ajukan kembali permohonan baru dengan memastikan seluruh informasi dan dokumen telah sesuai.</p>
                                <a href="{{ route('backend_pedagang.pages.permohonan') }}"
                                    class="btn btn-white px-4 rounded-5 mt-4"><i class='bx bx-cloud-upload'></i>Buat Ulang Surat Permohonan</a>
                            </div>
                        </div>
                    </div>
                @elseif($permohonan->status == 'selesai')
                    <div class="col">
                        <div class="card rounded-4 bg-gradient-success">
                            <div class="card-body text-center">
                                <h3 class="text-white">Permohonan Sudah Berhasil Disetujui, Terverifikasi!</h3>
                                <div class="widgets-icons-2 mx-auto my-4 bg-white rounded-circle text-dark">
                                    <i class='bx bx-check-circle'></i>
                                </div>
                                <p class="mb-0 text-white">Surat permohonan Anda telah berhasil disetujui. Selamat Anda
                                    sudah berhasil terverifikasi menjadi pedagang!</p>
                                <!--<a href="{{ route('backend_pedagang.pages.uploadpermohonan') }}"
                                        class="btn btn-white px-4 rounded-5 mt-4"><i class='bx bx-check'></i>Verifikasi</a>-->
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
            @if ($showModal)
                console.log('Modal triggered');
                welcomeModal.show();
            @else
                console.log('No trigger for modal');
            @endif
        });
    </script>
@endsection
