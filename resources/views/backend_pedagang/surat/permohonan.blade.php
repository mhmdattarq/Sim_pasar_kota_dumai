<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Permohonan Menjadi Pedagang</title>
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
        
        .judul::after {
            content: '';
            display: block;
            border-bottom: 2px solid black;
            width: calc(100% - 100px); /* Sesuai margin kiri-kanan isi (50px per sisi) */
            margin-left: auto;
            margin-right: auto;
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
            margin-right: 20px;
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
            color: rgba(255, 0, 0, 0.7); /* Merah transparan */
            z-index: -1; /* Di belakang konten */
            pointer-events: none; /* Tidak bisa diklik */
            text-align: center;
            width: 100%;
            opacity: 0.5; /* Efek transparan */
        }
    </style>
</head>

<body>
    @if (isset($isDraft) && $isDraft)
        <div class="watermark">[DRAFT]</div>
    @endif

    {{-- Judul --}}
    <div class="judul">
        <p>SURAT PERMOHONAN MENJADI PEDAGANG</p>
    </div>

    {{-- Kepada --}}
    <div class="isi">
        <div class="kepada-container">
            <div class="kepada">
                <p>
                    Kepada<br>
                    Yth. Kepala Dinas Perdagangan<br>
                    Di-<br>
                    Dumai
                </p>
            </div>
        </div>

        {{-- Hal --}}
        <p><strong>Hal:</strong> Permohonan menjadi Pedagang</p>

        {{-- Identitas Pemohon --}}
        <p>Yang bertanda tangan di bawah ini :</p>
        <table style="border-collapse: collapse; width: 100%; font-family: 'Times New Roman', serif; font-size: 12pt;">
            <tr>
                <td style="width: 180px;">- Nama</td>
                <td style="width: 10px;">:</td>
                <td>
                    {{ $pedagang->nama ?? '...................................................' }}
                    ({{ $pedagang->jenis_kelamin ?? '...................................................' }})
                </td>
            </tr>
            <tr>
                <td>- Tempat, tanggal lahir</td>
                <td>:</td>
                <td>
                    {{ $pedagang->tempat_lahir ?? '..................' }},
                    {{ $pedagang->tanggal_lahir ?? '..................' }}
                </td>
            </tr>
            <tr>
                <td>- No. NIK / KTP</td>
                <td>:</td>
                <td>{{ $pedagang->nik ?? '...................................................' }}</td>
            </tr>
            <tr>
                <td style="width: 250px;">- No. Telpon yang bisa dihubungi</td>
                <td style="width: 10px;">:</td>
                <td>{{ $pedagang->no_telp ?? '..................' }}</td>
            </tr>
            <tr>
                <td>- Alamat</td>
                <td>:</td>
                <td>{{ $pedagang->alamat ?? '...................................................' }}</td>
            </tr>
        </table>

        {{-- Permohonan --}}
        <p>Mengajukan permohonan menjadi Pedagang:</p>
        <table style="border-collapse: collapse; width: 100%; font-family: 'Times New Roman', serif; font-size: 12pt;">
            <tr>
                <td style="width: 20px; vertical-align: top;">a.</td>
                <td style="width: 180px; white-space: nowrap;">Nama pasar</td>
                <td style="width: 10px;">:</td>
                <td>{{ $pedagang->nama_pasar ?? '...................................................' }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">b.</td>
                <td>Lahan/tempat dasaran</td>
                <td>:</td>
                <td>
                    {{ $pedagang->tipe_tempat ?? '................' }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    di lokasi {{ ($pedagang->nomor_tempat ?? '........') . ' , ' . ($pedagang->lokasi ?? '........') }}
                </td>
            </tr>

            <tr>
                <td>c.</td>
                <td>Luas</td>
                <td>:</td>
                <td>{{ $pedagang->luas ?? '................' }} m<sup>2</sup></td>
            </tr>
            <tr>
                <td>d.</td>
                <td>Jenis dagangan/golongan</td>
                <td>:</td>
                <td>{{ $pedagang->jenis_dagangan ?? '...................................................' }}</td>
            </tr>
            <tr>
                <td>e.</td>
                <td>Jam Buka</td>
                <td>:</td>
                <td>{{ $pedagang->jam_buka ?? '................' }} s.d
                    {{ $pedagang->jam_tutup ?? '................' }} WIB</td>
            </tr>
        </table>

        {{-- Syarat --}}
        <p>Sebagai kelengkapan persyaratan kami lampirkan :</p>
        <ol class="syarat">
            <li>Berasusaha (NIB);</li>
            <li style="color: red;">Fotokopi Nomor Pokok Wajib Pajak (NPWP);</li>
            <li>Fotokopi Kartu Tanda Penduduk (KTP);</li>
            <li>Fotokopi Kartu Keluarga (KK);</li>
            <li>Pas Photo terbaru ukuran 3x4 berwarna sebanyak 4 lembar;</li>
        </ol>

        <p>Demikian atas permohonan ini kami ucapkan terima kasih.</p>

        {{-- TTD --}}
        <div class="ttd">
            <div class="kanan">
                Dumai, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }} <br><br><br><br>
                Pemohon, <br><br><br><br><br>
                ( {{ $pedagang->nama ?? '...................................' }} )
            </div>
        </div>

        <br><br>
        <p><i>*) Coret yang tidak perlu</i></p>
    </div>
</body>

</html>