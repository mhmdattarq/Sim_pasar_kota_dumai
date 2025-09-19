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
                                                <span class="badge bg-danger">Draft</span>
                                            @elseif ($p->status == 'lengkap')
                                                <span class="badge bg-warning text-dark">Lengkap</span>
                                            @elseif ($p->status == 'disetujui')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif ($p->status == 'ditolak')
                                                <span class="badge bg-primary">Ditolak</span>
                                            @else
                                                <span class="badge bg-secondary">Unknown</span>
                                            @endif
                                        </td>
                                        <td>{{ $p->keterangan ?? '-' }}</td>
                                        <td>
                                            <!-- Tombol Review -->
                                            <button type="button" class="btn btn-gradient-warning btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#reviewModal{{ $p->id }}">
                                                Review
                                            </button>
                                            <!-- Modal Preview Surat -->
                                            <div class="modal fade" id="reviewModal{{ $p->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Preview Surat Permohonan dari
                                                                {{ $p->nama }} </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{-- Surat preview disini --}}
                                                            <div id="suratPreview{{ $p->id }}">
                                                                <!DOCTYPE html>
                                                                <html lang="id">

                                                                <head>
                                                                    <meta charset="UTF-8">
                                                                    <title>Surat Permohonan Menjadi Pedagang</title>
                                                                    <style>
                                                                        body {
                                                                            font-family: "Times New Roman", serif;
                                                                            font-size: 12pt;
                                                                            line-height: 1.5;
                                                                        }

                                                                        .judul {
                                                                            text-align: center;
                                                                            font-weight: bold;
                                                                            margin-top: 20px;
                                                                        }

                                                                        .lampiran {
                                                                            text-align: right;
                                                                            font-size: 11pt;
                                                                        }

                                                                        .isi {
                                                                            margin: 20px 50px;
                                                                        }

                                                                        .garis {
                                                                            border-bottom: 1px solid black;
                                                                            margin: 10px 0;
                                                                        }

                                                                        .syarat {
                                                                            margin-left: 30px;
                                                                        }

                                                                        .ttd {
                                                                            width: 100%;
                                                                            margin-top: 50px;
                                                                        }

                                                                        .ttd .kanan {
                                                                            text-align: right;
                                                                            float: right;
                                                                            margin-right: 60px;
                                                                        }

                                                                        table {
                                                                            border-collapse: collapse;
                                                                            margin-left: 20px;
                                                                        }

                                                                        table td {
                                                                            padding: 2px 5px;
                                                                            vertical-align: top;
                                                                        }

                                                                        table td:first-child {
                                                                            width: 220px;
                                                                        }
                                                                    </style>
                                                                </head>

                                                                <body>
                                                                    {{-- Bagian Lampiran --}}
                                                                    <div class="lampiran">
                                                                        <p>
                                                                            LAMPIRAN I <br>
                                                                            PERATURAN WALI KOTA DUMAI <br>
                                                                            NOMOR .... TAHUN 2025 <br>
                                                                            TENTANG PASAR RAKYAT
                                                                        </p>
                                                                    </div>

                                                                    {{-- Judul --}}
                                                                    <div class="judul">
                                                                        <p>SURAT PERMOHONAN MENJADI PEDAGANG</p>
                                                                    </div>
                                                                    <div class="garis"></div>

                                                                    {{-- Kepada --}}
                                                                    <div class="isi">
                                                                        <p>
                                                                            Kepada <br>
                                                                            Yth.
                                                                            ..............................................
                                                                            <br>
                                                                            Di- <br>
                                                                            ................................................
                                                                        </p>

                                                                        {{-- Hal --}}
                                                                        <p><strong>Hal</strong> : Permohonan menjadi
                                                                            Pedagang</p>

                                                                        {{-- Identitas Pemohon --}}
                                                                        <p>Yang bertanda tangan di bawah ini :</p>
                                                                        <table>
                                                                            <tr>
                                                                                <td>Nama</td>
                                                                                <td>:
                                                                                    {{ $p->nama ?? '...................................................' }}
                                                                                    ({{ $p->jenis_kelamin ?? '...................................................' }})
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Tempat, tanggal lahir</td>
                                                                                <td>:
                                                                                    {{ $p->tempat_lahir ?? '..................' }},
                                                                                    {{ $p->tanggal_lahir ?? '..................' }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>No. NIK / KTP</td>
                                                                                <td>:
                                                                                    {{ $p->nik ?? '...................................................' }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>No. Telpon yang bisa dihubungi</td>
                                                                                <td>:
                                                                                    {{ $p->no_telp ?? '..................' }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Alamat</td>
                                                                                <td>:
                                                                                    {{ $p->alamat ?? '...................................................' }}
                                                                                </td>
                                                                            </tr>
                                                                        </table>

                                                                        {{-- Permohonan --}}
                                                                        <p style="margin-top:15px;">Mengajukan permohonan
                                                                            menjadi Pedagang:</p>
                                                                        <table>
                                                                            <tr>
                                                                                <td>a. Nama pasar</td>
                                                                                <td>:
                                                                                    {{ $p->nama_pasar ?? '...................................................' }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>b. Lahan/tempat dasaran</td>
                                                                                <td>:
                                                                                    {{ $p->tipe_tempat ?? '...................................................' }},
                                                                                    di lokasi
                                                                                    {{ $p->lokasi ?? '...................................................' }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>c. Luas</td>
                                                                                <td>: {{ $p->luas ?? '................' }}
                                                                                    m<sup>2</sup></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>d. Jenis dagangan/golongan</td>
                                                                                <td>:
                                                                                    {{ $p->jenis_dagangan ?? '...................................................' }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>e. Jam Buka</td>
                                                                                <td>:
                                                                                    {{ $p->jam_buka ?? '................' }}
                                                                                    s.d
                                                                                    {{ $p->jam_tutup ?? '................' }}
                                                                                    WIB
                                                                                </td>
                                                                            </tr>
                                                                        </table>

                                                                        {{-- Syarat --}}
                                                                        <p style="margin-top:15px;">Sebagai kelengkapan
                                                                            persyaratan kami lampirkan :</p>
                                                                        <ol class="syarat">
                                                                            <li>Berusaha (NIB);</li>
                                                                            <li style="color: red;">Fotokopi Nomor Pokok
                                                                                Wajib Pajak (NPWP);</li>
                                                                            <li>Fotokopi Kartu Tanda Penduduk (KTP);</li>
                                                                            <li>Fotokopi Kartu Keluarga (KK);</li>
                                                                            <li>Pas Photo terbaru ukuran 3x4 berwarna
                                                                                sebanyak 4 lembar;</li>
                                                                        </ol>

                                                                        <p>Demikian atas permohonan ini kami ucapkan terima
                                                                            kasih.</p>

                                                                        {{-- TTD --}}
                                                                        <div class="ttd">
                                                                            <div class="kanan">
                                                                                Dumai,
                                                                                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                                                                                <br><br><br><br>
                                                                                Pemohon, <br><br><br><br>
                                                                                (
                                                                                {{ $pedagang->nama ?? '...................................' }}
                                                                                )
                                                                            </div>
                                                                        </div>

                                                                        <br><br>
                                                                        <p><i>*) Coret yang tidak perlu</i></p>
                                                                    </div>
                                                                </body>

                                                                </html>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <!-- Tombol lanjut ke form persetujuan -->
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-dismiss="modal" data-bs-toggle="modal"
                                                                data-bs-target="#accModal{{ $p->id }}">
                                                                Lanjutkan
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- End Modal -->
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
@endsection
