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

        .indent {
            text-indent: 40px;
        }

        .list {
            margin-left: 20px;
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

        .garis {
            border-bottom: 1px solid black;
            margin: 10px 0;
        }

        .syarat {
            margin-left: 30px;
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
        <p>Kepada<br>
            Yth. ..............................................<br>
            Di-<br>
            ................................................</p>

        {{-- Hal --}}
        <p><strong>Hal:</strong> Permohonan menjadi Pedagang</p>

        {{-- Identitas Pemohon --}}
        <p>Yang bertanda tangan di bawah ini :</p>
        <p>
            -
            Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
            {{ $pedagang->nama ?? '...................................................' }}
            ({{ $pedagang->jenis_kelamin ?? '...................................................' }}) <br>
            - Tempat, tanggal lahir : {{ $pedagang->tempat_lahir ?? '..................' }},
            {{ $pedagang->tanggal_lahir ?? '..................' }} <br>
            - No. NIK / KTP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
            {{ $pedagang->nik ?? '...................................................' }} <br>
            - No. Telpon yang bisa dihubungi : {{ $pedagang->no_telp ?? '..................' }} <br>
            - Alamat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
            {{ $pedagang->alamat ?? '...................................................' }}
        </p>

        {{-- Permohonan --}}
        <p>Mengajukan permohonan menjadi Pedagang:</p>
        <ol class="list" type="a">
            <li>Nama pasar : {{ $pedagang->nama_pasar ?? '...................................................' }}</li>
            <li>
                Lahan/tempat
                dasaran:{{ $pedagang->tipe_tempat ?? '...................................................' }}<br>
                di lokasi {{ ($pedagang->nomor_tempat ?? '........') . ' | ' . ($pedagang->lokasi ?? '........') }}
            </li>
            <li>Luas : {{ $pedagang->luas ?? '................' }} m<sup>2</sup></li>
            <li>Jenis dagangan/golongan :
                {{ $pedagang->jenis_dagangan ?? '...................................................' }}</li>
            <li>Jam Buka : {{ $pedagang->jam_buka ?? '................' }} s.d
                {{ $pedagang->jam_tutup ?? '................' }} WIB</li>
        </ol>

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
                Pemohon, <br><br><br><br>
                ( {{ $pedagang->nama ?? '...................................' }} )
            </div>
        </div>

        <br><br>
        <p><i>*) Coret yang tidak perlu</i></p>
    </div>

</body>

</html>
