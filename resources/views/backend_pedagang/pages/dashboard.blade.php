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
                                    <h4 class="mb-0 text-white">986</h4>
                                    <p class="mb-0 text-white">Total Orders</p>
                                </div>
                                <div class="fs-1 text-white">
                                    <i class="bx bx-cart"></i>
                                </div>
                            </div>
                            <small class="mb-0 text-white">+2.6% Since Last Week</small>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-4 bg-gradient-burning bubble position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-0">
                                <div class="">
                                    <h4 class="mb-0 text-white">485</h4>
                                    <p class="mb-0 text-white">Customers</p>
                                </div>
                                <div class="fs-1 text-white">
                                    <i class="bx bx-group"></i>
                                </div>
                            </div>
                            <small class="mb-0 text-white">+2.6% Since Last Week</small>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-4 bg-gradient-moonlit bubble position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-0">
                                <div class="">
                                    <h4 class="mb-0 text-white">$24K</h4>
                                    <p class="mb-0 text-white">Total Revenue</p>
                                </div>
                                <div class="fs-1 text-white">
                                    <i class="bx bx-wallet"></i>
                                </div>
                            </div>
                            <small class="mb-0 text-white">+2.6% Since Last Week</small>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-4 bg-gradient-cosmic bubble position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-0">
                                <div class="">
                                    <h4 class="mb-0 text-white">22%</h4>
                                    <p class="mb-0 text-white">Total Growth</p>
                                </div>
                                <div class="fs-1 text-white">
                                    <i class="bx bx-line-chart-down"></i>
                                </div>
                            </div>
                            <small class="mb-0 text-white">+2.6% Since Last Week</small>
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
                            <h3 class="text-white">Belum Ada Permohonan</h3>
                            <div class="widgets-icons-2 mx-auto my-4 bg-white rounded-circle text-dark">
                                <i class='bx bx-window-close'></i>
                            </div>
                            <p class="mb-0 text-white">Anda belum memiliki surat permohonan, Klik tombol di bawah ini untuk
                                membuat surat permohonan baru.</p>
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
                                <h3 class="text-white">Permohonan Sudah Berhasil Dibuat</h3>
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
                                <h3 class="text-white">Permohonan Sudah Berhasil Diunggah/Dikirim</h3>
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
                @endif
            @endif
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
            welcomeModal.show();
        });
    </script>
@endsection
