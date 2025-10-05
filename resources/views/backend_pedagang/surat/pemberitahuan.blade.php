<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Pemberitahuan Permohonan Pedagang</title>
    <style>
        @page {
            size: A4;
            margin: 5mm;
            /* perkecil margin halaman */
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 11pt;
            line-height: 1.3;
            margin: 0;
            padding: 0;
            position: relative; /* Untuk watermark */
        }

        table {
            margin: 2px 0;
            /* rapetin tabel */
            page-break-inside: avoid;
            /* cegah tabel kepotong */
        }

        p {
            margin: 2px 0;
            /* rapetin spasi antar paragraf */
        }

        .judul {
            text-align: center;
            font-weight: bold;
            margin-top: 20px;
        }

        .kop-surat {
            margin-bottom: 10px;
        }

        .kop-surat img {
            display: block;
            margin: auto;
        }

        .garis-kop {
            border-bottom: 2px solid black;
            border-top: 1px solid black;
            margin-top: 4px;
            margin-bottom: 10px;
        }

        .isi {
            margin: 20px 50px;
        }

        .indent {
            text-indent: 40px;
        }

        .list {
            margin-left: 20px;
        }

        .ttd {
            width: 100%;
            margin-top: 20px;
        }

        .ttd .kanan {
            text-align: right;
            float: right;
            margin-right: 60px;
        }

        .syarat {
            margin-left: 30px;
        }

        .kepada-container {
            text-align: right;
            /* dorong isi ke kanan */
            margin-right: 5px;
            /* sejajarkan dengan lampiran */
        }

        .kepada {
            display: inline-block;
            /* biar ukurannya sesuai konten */
            text-align: left;
            /* isi tetap rata kiri */
        }

        i {
            font-size: 10pt;
            /* supaya footer lebih kecil */
        }

        /* Tambahan CSS untuk Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px; /* Ukuran besar untuk watermark */
            font-weight: bold;
            color: rgba(255, 0, 0, 0.2); /* Merah transparan */
            z-index: -1; /* Di belakang konten */
            pointer-events: none; /* Tidak bisa diklik */
            text-align: center;
            width: 100%;
            opacity: 0.5; /* Efek transparan */
        }
        
        input[type="checkbox"] {
            margin-right: 5px; /* Jarak antara kotak dan teks */
            vertical-align: middle; /* Align dengan teks */
        }
    </style>
</head>

<body>
    {{-- Bagian Lampiran --}}
    <div class="kop-surat">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <!-- Kolom kiri (logo) -->
                <td style="width: 90px; text-align: center; vertical-align: middle;">
                    <img src="{{ public_path('backend/assets/images/logo_kota_dumai.png') }}" alt="Logo"
                        style="width:70px; height:auto;">
                </td>

                <!-- Kolom tengah (teks) -->
                <td style="text-align: center; line-height: 1.2; padding-left: 20px;">
                    <span style="font-size: 12pt;">PEMERINTAH KOTA DUMAI</span><br>
                    <span style="font-size: 14pt; font-weight: bold;">DINAS PERDAGANGAN</span><br>
                    <span style="font-size: 10pt;">
                        Jl. Sultan Syarif Kasim No. 16 Telp (0765) 35760 Fax. (0765) 439750 Kode Pos 28815
                    </span><br>
                    <span style="font-size: 11pt; font-weight: bold;">D U M A I</span>
                </td>

                <!-- Kolom kanan (kosong untuk keseimbangan) -->
                <td style="width: 70px;"></td>
            </tr>
        </table>
        <div class="garis-kop"></div>
    </div>

    {{-- Judul --}}
    <div class="judul">
        <p>PEMBERITAHUAN PERSETUJUAN ATAU PENOLAKAN MENJADI PEDAGANG</p>
    </div>

    {{-- Kepada --}}
    <div class="isi">
        <div class="kepada-container">
            <div class="kepada">
                <p>
                    Kepada<br>
                    Yth. {{ $permohonan->nama ?? '...................................................' }}<br>
                    Hal      :	Pemberitahuan	Di -<br>
                                Dumai
                </p>
            </div>
        </div>

        <p>Memperhatikan surat permohonan Saudara tanggal {{ \Carbon\Carbon::parse($permohonan->updated_at)->format('d F Y') ?? '...................................' }}, perihal permohonan menjadi pedagang, maka permohonan Saudara :</p>
        <p><input type="checkbox" {{ $permohonan->status === 'disetujui' ? 'checked' : '' }} disabled>DIKABULKAN, untuk selanjutnya kepada saudara diminta untuk hadir di Kantor UPT. Pelayanan Pasar / koordinator Pasar untuk segera mengikuti arahan langkah selanjutnya</p>
        <p><input type="checkbox" {{ $permohonan->status === 'ditolak' ? 'checked' : '' }} disabled>TIDAK DIKABULKAN, karena {{ $permohonan->keterangan ?? '...................................' }}</p>

        <p>Demikian, atas perhatiannya diucapkan terima kasih</p>

        {{-- TTD --}}
        <div class="ttd">
            <div class="kanan">
                Dumai, {{ now()->format('d F Y') }}<br><br><br><br>
                KEPALA <br><br><br><br>
                ( ................................... )
            </div>
        </div>

        <br><br>
        <p><i>*) Coret yang tidak perlu</i></p>
    </div>
</body>

</html>