@extends('backend_pedagang.app')

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
                        <li class="breadcrumb-item active" aria-current="page">Kelola Pengumuman</li>
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
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Judul</th>
                                <th>Lihat Isi Pengumuman</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengumumans as $pengumuman)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pengumuman->tanggal)->format('d M Y') }}</td>
                                    <td>{{ $pengumuman->judul }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm radius-30 px-4" data-bs-toggle="modal" data-bs-target="#viewPengumumanModal_{{ $pengumuman->id }}" data-id="{{ $pengumuman->id }}">
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
@endsection