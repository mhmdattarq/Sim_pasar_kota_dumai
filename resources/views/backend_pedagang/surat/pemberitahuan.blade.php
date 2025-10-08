<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Pemberitahuan Permohonan Pedagang</title>
    <style>
        @page {
            size: A4;
            margin: 5mm;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 11pt;
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }

        table {
            margin: 2px 0;
            page-break-inside: avoid;
        }

        p {
            margin: 2px 0;
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
            margin-right: 5px;
        }

        .kepada {
            display: inline-block;
            text-align: left;
        }

        i {
            font-size: 10pt;
        }

        .checkbox-img {
            width: 13px;
            height: 13px;
            vertical-align: middle;
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div class="kop-surat">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 90px; text-align: center; vertical-align: middle;">
                    <img src="{{ public_path('backend/assets/images/logo_kota_dumai.png') }}" alt="Logo"
                        style="width:70px; height:auto;">
                </td>
                <td style="text-align: center; line-height: 1.2; padding-left: 20px;">
                    <span style="font-size: 12pt;">PEMERINTAH KOTA DUMAI</span><br>
                    <span style="font-size: 14pt; font-weight: bold;">DINAS PERDAGANGAN</span><br>
                    <span style="font-size: 10pt;">
                        Jl. Sultan Syarif Kasim No. 16 Telp (0765) 35760 Fax. (0765) 439750 Kode Pos 28815
                    </span><br>
                    <span style="font-size: 11pt; font-weight: bold;">D U M A I</span>
                </td>
                <td style="width: 70px;"></td>
            </tr>
        </table>
        <div class="garis-kop"></div>
    </div>

    <div class="judul">
        <p>PEMBERITAHUAN PERSETUJUAN ATAU PENOLAKAN MENJADI PEDAGANG</p>
    </div>

    <div class="isi">
        <div class="kepada-container">
            <div class="kepada">
                <p>
                    Kepada :<br>
                    Yth. {{ $permohonan->nama ?? 'Pembertahuan' }}<br>
                    Di -<br>
                    Dumai
                </p>
            </div>
        </div>

        <p>Memperhatikan surat permohonan saudara tanggal perihal permohonan menjadi pedagang, maka permohonan saudara :</p>
        <p><img src="{{ strtolower($permohonan->status) === 'disetujui' ? public_path('backend/assets/images/ceklist.png') : public_path('backend/assets/images/ceklist_kosong.png') }}" alt="Check - DIKABULKAN" class="checkbox-img">DIKABULKAN, untuk selanjutnya kepada saudara diminta untuk hadir di Kantor UPT. Pelayanan Pasar / koordinator Pasar untuk segera mengikuti arahan langkah selanjutnya</p>
        <p><img src="{{ strtolower($permohonan->status) === 'ditolak' ? public_path('backend/assets/images/ceklist.png') : public_path('backend/assets/images/ceklist_kosong.png') }}" alt="Check - TIDAK DIKABULKAN" class="checkbox-img">TIDAK DIKABULKAN, karena {{ strtolower($permohonan->status) === 'ditolak' ? $permohonan->keterangan : '...................................' }}</p>

        <p>Demikian, atas perhatiannya diucapkan terima kasih</p>

        <div class="ttd">
            <div class="kanan">
                Dumai, {{ $tanggal }}<br><br><br><br>
                KEPALA <br><br><br><br>
                ( ................................... )
            </div>
        </div>

        <br><br>
        <p><i>*) Coret yang tidak perlu</i></p>
    </div>
</body>

</html>