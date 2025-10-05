<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Menjadi Pedagang</title>
    <style>
        @page {
            size: A4;
            margin: 30mm 20mm 30mm 20mm;
        }
        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            line-height: 1.5;
            text-align: justify;
            margin: 0;
            padding: 0;
        }
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }
        .kop-surat hr {
            border: 0;
            border-top: 2px solid black;
            margin: 10px 0;
        }
        .kop-surat h2 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .content {
            margin-top: 20px;
        }
        .content p {
            margin: 5px 0;
        }
        .content table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .content table td {
            padding: 5px 0;
            vertical-align: top;
        }
        .content table td.label {
            width: 30%;
        }
        .content table td.value {
            width: 70%;
        }
        .content ol {
            margin-left: 20px;
            padding-left: 20px;
        }
        .content ol li {
            margin-bottom: 10px;
        }
        .content ol li ol {
            list-style-type: lower-alpha;
            margin-left: 20px;
            margin-top: 5px;
        }
        .signature {
            margin-top: 40px;
            text-align: right;
            width: 100%;
        }
        .signature p {
            margin: 5px 0;
        }
        .footer-note {
            margin-top: 30px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="kop-surat">
        <h2>SURAT PERNYATAAN MENJADI PEDAGANG</h2>
        <hr>
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini:</p>
        <table>
            <tr>
                <td class="label">-Nama</td>
                <td class="value">: {{ $permohonan->nama ?? '…………………………………………………………'}} ({{ $permohonan->jenis_kelamin ?? '…………………………………………………………'}})</td>
            </tr>
            <tr>
                <td class="label">-Tempat, tanggal lahir</td>
                <td class="value">: {{ $permohonan->tempat_lahir ?? '…………………………………………………………'}}, {{ $permohonan->tanggal_lahir ?? '…………………………………………………………'}}</td>
            </tr>
            <tr>
                <td class="label">-Alamat</td>
                <td class="value">: {{ $permohonan->alamat ?? '…………………………………………………………'}}</td>
            </tr>
            <tr>
                <td class="label">-No NIK/KTP</td>
                <td class="value">: {{ $permohonan->nik ?? '…………………………………………………………'}}</td>
            </tr>
            <tr>
                <td class="label">-No Telpon yang dapat dihubungi</td>
                <td class="value">: {{ $permohonan->no_telp ?? '…………………………………………………………'}}</td>
            </tr>
        </table>

        <p>Menyatakan dengan sesungguhnya bahwa:</p>
        <p>1.&nbsp;&nbsp;<span style="color: red;">Saya belum memiliki hak penggunakan Kios atau Los atau Pelataran Pasar Kota</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dumai.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saya telah memiliki hak penggunaan:</p>
        <ol>
            <table>
                    <tr>
                        <td class="label">a. Kios</td>
                        <td class="value">: ………… unit, di</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;&nbsp;&nbsp;&nbsp;Pasar</td>
                        <td class="value">: …………………………………………………………</td>
                    </tr>
                    <tr>
                        <td class="label">b. Los</td>
                        <td class="value">: ………… m, di</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;&nbsp;&nbsp;&nbsp;Pasar</td>
                        <td class="value">: …………………………………………………………</td>
                    </tr>
                    <tr>
                        <td class="label">c. Pelataran</td>
                        <td class="value">: ………… m, di</td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;&nbsp;&nbsp;&nbsp;Pasar</td>
                        <td class="value">: …………………………………………………………</td>
                    </tr>
                </table>
        </ol>
        <p>2.&nbsp;&nbsp;Apabila saya ditetapkan sebagai Pedagang, saya akan mematuhi semua ketentuan yang diatur<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;dalam Perwa Kota Dumai Nomor&nbsp;&nbsp;Tahun 2025 tentang Pasar Rakyat.</p>
        <p>3.&nbsp;&nbsp;Apabila saya ditetapkan sebagai Pedagang, maka saya:</p>
        <ol>
                    <li>Akan mengajukan permohonan perpanjangan KBP/KIP selambat-lambatnya 15 (lima belas) hari sebelum masa berlakunya berakhir;</li>
                    <li>Tidak akan menghentikan beraktifitas jual beli pada Kios atau Los atau Pelataran yang menjadi hak saya selama 3 (tiga) bulan berturut-turut atau 90 (Sembilan puluh) hari dalam satu Tahun secara kumulatif;</li>
                    <li>Tidak akan memperjualbelikan Barang dan atau jasa yang tidak sesuai dengan jenis Barang yang tercantum dalam KBP atau KIP;</li>
                    <li>Tidak akan memperjual belikan Barang atau jasa yang bertentangan dengan ketentuan perundang-undangan yang berlaku;</li>
                    <li>Tidak akan menyewakan Kios atau Los atau <span style="color: red;">Pelataran</span> kepada pihak lain dan tidak akan mengalihfungsikan Kios, Los atau <span style="color: red;">Pelataran</span>;</li>
                    <li>Tidak akan melakukan pengalihan hak penggunakan Kios atau Los atau <span style="color: red;">Pelataran</span> yang tidak sesuai dengan ketentuan tata cara dan syarat-syarat administrasi pengalihan hak;</li>
                    <li>Akan selalu membayar retribusi tepat waktu;</li>
                    <li>Tidak akan menginap dan atau bertempat tinggal di Pasar, melakukan praktik percaloan, mengasong, meletakan dan atau menimbun Barang yang menyebabkan terganggunya aktifitas pasar, melakukan kegiatan bongkar muat tidak pada tempatnya dan kegiatan lainnya yang dapat menggangu keamanan dan ketertiban umum di dalam Pasar dan kawasan Pasar;</li>
                    <li>Akan menyediakan tempat sampah di Kios atau Los atau Pelataran yang saya gunakan dan akan ikut menjaga kebersihan lingkungan Pasar;</li>
                    <li>Akan ikut mengamankan Barang dagangan dan perlengkapan yang ditinggal di Kios atau Los atau Pelataran yang saya gunakan;</li>
                    <li>Tidak akan menggunakan sarana bahan bakar sebelum mendapat persetujuan tertulis dari Dinas Perdagangan Kota Dumai;</li>
                    <li>Tidak akan memasang papan nama usaha tanpa persetujuan tertulis dari Dinas Perdagangan Kota Dumai;</li>
                    <li>Tidak akan melakukan aktifitas jual beli di luar jam buka yang telah ditentukan;</li>
                    <li>Tidak akan menjual belikan, bahan gas, mercon, kembang api dan sejenisnya yang mudah terbakar atau meledak;</li>
                    <li>Tidak akan mengendarai dan memarkirkan kendaraan dan alat pengangkut Barang tidak pada tempat yang ditentukan;</li>
                    <li>Tidak akan menjemur barang apapun di Pasar dan kawasan pasar;</li>
                    <li>Tidak akan membakar sampah, menyalakan lilin, menyalakan lampu berbahan bakar minyak dan sejenisnya yang mudah menimbulkan kebakaran pasar;</li>
                    <li>Bersedia untuk ditempatkan pada zonasi, lokasi dan luasan yang telah ditetapkan Pemerintah Daerah;</li>
                    <li>Tidak akan melakukan aktifitas jual beli pada Kios, Los, Pelataran dan lahan pasar yang bukan hak saya;</li>
                    <li>Tidak akan melaksanakan pembangunan fasilitas apapun tanpa persetujuan tertulis dari Dinas Perdagangan Kota Dumai;</li>
                    <li>Sanggup mengembalikan lahan apabila Pemerintah Daerah akan mempergunakan untuk kepentingan umum yang lebih luas, tanpa syarat apapun.</li>
                </ol>
        <p>Demikian Pernyataan ini saya tandatangani dalam keadaan sadar serta tanpa paksaan dari pihak manapun. Apabila saya memberikan pernyataan tidak benar dan melanggar pernyataan di atas maka saya sanggup menerima sanksi sesuai ketentuan peraturan perundang-undangan yang berlaku.</p>
    </div>

    <div class="signature">
        <p>Dumai, ……………………</p>
        <p style="margin-top: 80px;">Yang menyatakan</p>
        <p>Meterai 10.000</p>
        <p>(……………………………………)</p>
    </div>
    <div class="footer-note">
        <p>*) Coret yang tidak perlu</p>
        <p>Beri tanda √ sesuai pilihan</p>
    </div>
</body>
</html>