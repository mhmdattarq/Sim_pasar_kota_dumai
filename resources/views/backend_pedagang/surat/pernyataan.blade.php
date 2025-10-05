<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Menjadi Pedagang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            font-size: 14px;
            text-align: justify;
        }
        @page {
            size: A4;
            margin: 40mm 25mm 40mm 25mm; /* Atur margin A4 standar */
        }
        .header { text-align: center; margin-bottom: 20px; }
        .header hr { border: 0; border-top: 2px solid black; margin: 0 auto 20px; width: 100%; }
        .header h2 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .content { line-height: 1.6; }
        .content table { margin-left: 20px; width: 50%; }
        .content td { padding: 5px 0; }
        .signature { margin-top: 50px; text-align: right; }
        .signature p { margin: 0; }
    </style>
</head>
<body>
    <div class="header">
        <hr>
        <h2>SURAT PERNYATAAN MENJADI PEDAGANG</h2>
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini :</p>
        <table>
            <tr><td>Nama</td><td>: {{ $permohonan->nama ?? '...................................................' }} ({{ $permohonan->jenis_kelamin ?? '...................................................' }})</td></tr>
            <tr><td>Tempat, tanggal lahir</td><td>: {{ $permohonan->tempat_lahir ?? '...................................................' }}, {{ $permohonan->tanggal_lahir ?? '...................................................' }} </td></tr>
            <tr><td>Alamat</td><td>: {{ $permohonan->alamat ?? '...................................................' }} </td></tr>
            <tr><td></td><td>: ….…………………………………………………. </td></tr>
            <tr><td>No NIK/KTP</td><td>: {{ $permohonan->nik ?? '...................................................' }} </td></tr>
            <tr><td>No Telpon yang dapat dihubungi</td><td>: {{ $permohonan->no_telp ?? '...................................................' }} </td></tr>
        </table>
        <p>Menyatakan dengan sesungguhnya bahwa:</p>
        <ol style="margin-left: 20px;">
            <li>Saya belum memiliki hak penggunakan Kios atau Los atau Pelataran Pasar Kota Dumai<br>
                Saya telah memiliki hak penggunaan:<br>
                @if($permohonan->tipe_tempat == 'kios')
                    a. Kios :…………unit , di<br>
                    Pasar : {{ $permohonan->nama_pasar ?? 'N/A' }}<br>
                @else
                    a. Kios :…………unit , di<br>
                    Pasar : ……………………………………………………………<br>
                @endif
                @if($permohonan->tipe_tempat == 'los')
                    b. Los :…………m, di<br>
                    Pasar : {{ $permohonan->nama_pasar ?? 'N/A' }}<br>
                @else
                    b. Los :…………m, di<br>
                    Pasar : ……………………………………………………………<br>
                @endif
                @if($permohonan->tipe_tempat == 'pelataran')
                    c. Pelataran :…………m, di<br>
                    Pasar : {{ $permohonan->nama_pasar ?? 'N/A' }}<br>
                @else
                    c. Pelataran :…………m, di<br>
                    Pasar : ……………………………………………………………<br>
                @endif
            <li>Apabila saya ditetapkan sebagai Pedagang, saya akan mematuhi semua ketentuan yang diatur dalam Perwa Kota Dumai Nomor …….. Tahun 2025 tentang Pasar Rakyat.</li>
            <li>Apabila saya ditetapkan sebagai Pedagang, maka saya:<br>
                a. Akan mengajukan permohonan perpanjangan KBP/KIP selambat-lambatnya 15 (lima belas) hari sebelum masa berlakunya berakhir;<br>
                b. Tidak akan menghentikan beraktifitas jual beli pada Kios atau Los atau Pelataran yang menjadi hak saya selama 3 (tiga) bulan berturut-turut atau 90 (Sembilan puluh) hari dalam satu Tahun secara kumulatif;<br>
                c. Tidak akan memperjualbelikan Barang dan atau jasa yang tidak sesuai dengan jenis Barang yang tercantum dalam KBP atau KIP;<br>
                d. Tidak akan memperjual belikan Barang atau jasa yang bertentangan dengan ketentuan perundang-undangan yang berlaku;<br>
                e. Tidak akan menyewakan Kios atau Los atau Pelataran kepada pihak lain dan tidak akan mengalihfungsikan Kios, Los atau Pelataran;<br>
                f. Tidak akan melakukan pengalihan hak penggunakan Kios atau Los atau Pelataran yang tidak sesuai dengan ketentuan tata cara dan syarat-syarat administrasi pengalihan hak;<br>
                g. Akan selalu membayar retribusi tepat waktu;<br>
                h. Tidak akan menginap dan atau bertempat tinggal di Pasar, melakukan praktik percaloan, mengasong, meletakan dan atau menimbun Barang yang menyebabkan terganggunya aktifitas pasar, melakukan kegiatan bongkar muat tidak pada tempatnya dan kegiatan lainnya yang dapat menggangu keamanan dan ketertiban umum di dalam Pasar dan kawasan Pasar;<br>
                i. Akan menyediakan tempat sampah di Kios atau Los atau Pelataran yang saya gunakan dan akan ikut menjaga kebersihan lingkungan Pasar;<br>
                j. Akan ikut mengamankan Barang dagangan dan perlengkapan yang ditinggal di Kios atau Los atau Pelataran yang saya gunakan;<br>
                k. Tidak akan menggunakan sarana bahan bakar sebelum mendapat persetujuan tertulis dari Dinas Perdagangan Kota Dumai;<br>
                l. Tidak akan memasang papan nama usaha tanpa persetujuan tertulis dari Dinas Perdagangan Kota Dumai;<br>
                m. Tidak akan melakukan aktifitas jual beli di luar jam buka yang telah ditentukan;<br>
                n. Tidak akan menjual belikan, bahan gas, mercon, kembang api dan sejenisnya yang mudah terbakar atau meledak;<br>
                o. Tidak akan mengendarai dan memarkirkan kendaraan dan alat pengangkut Barang tidak pada tempat yang ditentukan;<br>
                p. Tidak akan menjemur barang apapun di Pasar dan kawasan pasar;<br>
                q. Tidak akan membakar sampah, menyalakan lilin, menyalahkan lampu berbahan bakar minyak dan sejenisnya yang mudah menimbulkan kebakaran pasar;<br>
                r. Bersedia untuk ditempatkan pada zonasi, lokasi dan luasan yang telah ditetapkan Pemerintah Daerah;<br>
                s. Tidak akan melakukan aktifitas jual beli pada Kios, Los, Pelataran dan lahan pasar yang bukan hak saya;<br>
                t. Tidak akan melaksanakan pembangunan fasilitas apapun tanpa persetujuan tertulis dari Dinas Perdagangan Kota Dumai; dan<br>
                u. Sanggup mengembalikan lahan apabila Pemerintah Daerah akan mempergunakan untuk kepentingan umum yang lebih luas, tanpa syarat apapun.</li>
        </ol>
        <p>Demikian Pernyataan ini saya tandatangani dalam keadaan sadar serta tanpa paksaan dari pihak manapun. Apabila saya memberikan pernyataan tidak benar dan melanggar pernyataan di atas maka saya sanggup menerima sanksi sesuai ketentuan peraturan perundang-undangan yang berlaku.</p>
    </div>

    <div class="signature">
        <p>Dumai, {{ $tanggal }}</p>
        <p style="margin-top: 50px;">Yang menyatakan</p>
        <p>Meterai 10.000</p>
    </div>
    <p style="text-align: center; margin-top: 20px;">*) Coret yang tidak perlu</p>
    <p style="text-align: center;">Beri tanda √ sesuai pilihan</p>
</body>
</html>