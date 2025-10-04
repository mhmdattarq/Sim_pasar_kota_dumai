<?php

namespace App\Http\Controllers\Pedagang;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PermohonanController extends Controller
{

    public function showForm()
    {
        // Ambil semua pasar
        $pasar = DB::table('pasar')->get();

        // Kosongkan dulu, nanti diisi setelah pilih pasar
        $kios = [];
        $los = [];
        $pelataran = [];

        // Inisialisasi $userData sebagai default
        $userData = (object) [
            'nik' => '',
            'nama' => '',
            'tempat_lahir' => '',
            'tanggal_lahir' => '',
            'jenis_kelamin' => '',
            'no_telp' => '',
            'alamat' => ''
        ];

        $sudahAda = false;

        // Ambil data pengguna yang sedang login jika ada
        if (Auth::check()) {
            $user = Auth::user();
            $nik = $user->nik;
            $userData = DB::table('users')
                ->leftJoin('pedagangregister', 'users.id', '=', 'pedagangregister.user_id') // Perbaiki join berdasarkan id
                ->where('users.nik', $nik)
                ->select(
                    'users.nik',
                    'pedagangregister.nama',
                    'pedagangregister.tempat_lahir',
                    'pedagangregister.tanggal_lahir',
                    'pedagangregister.jenis_kelamin',
                    'pedagangregister.no_telp',
                    'pedagangregister.alamat'
                )
                ->first();

            // Jika data tidak ditemukan, gunakan default dengan nik dari user
            if (!$userData) {
                $userData = (object) [
                    'nik' => $nik,
                    'nama' => '',
                    'tempat_lahir' => '',
                    'tanggal_lahir' => '',
                    'jenis_kelamin' => '', // Simpan sebagai teks
                    'no_telp' => '',
                    'alamat' => ''
                ];
            }

            // cek apakah user sudah pernah buat permohonan
            $sudahAda = DB::table('permohonan')
                ->where('user_id', $user->id)
                ->exists();
        }

        return view('backend_pedagang.pages.permohonan', compact('pasar', 'kios', 'los', 'pelataran', 'userData', 'sudahAda'));
    }



    // untuk mengambil data lokasi lokasi dan nama dari database
    public function getTempatByPasar($pasarId)
    {
        $kios = DB::table('kios')->where('pasar_id', $pasarId)->get();
        $loss = DB::table('loss')->where('pasar_id', $pasarId)->get();
        $pelatarans = DB::table('pelatarans')->where('pasar_id', $pasarId)->get();

        return response()->json([
            'kios' => $kios,
            'loss' => $loss,
            'pelatarans' => $pelatarans,
        ]);
    }

    // untuk mengambil data luas dari database
    public function getLuas($tipe, $id)
    {
        if ($tipe === 'kios') {
            $data = DB::table('kios')->where('id', $id)->select('ukuran_kios as luas')->first();
        } elseif ($tipe === 'los') {
            $data = DB::table('loss')->where('id', $id)->select('ukuran_los as luas')->first();
        } elseif ($tipe === 'pelataran') {
            $data = DB::table('pelatarans')->where('id', $id)->select('ukuran_pelataran as luas')->first();
        } else {
            $data = null;
        }

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik'           => 'required',
            'nama'          => 'required|string|max:255',
            'tempat_lahir'  => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'no_telp'       => 'required|string|max:15',
            'alamat'        => 'required|string',
            'pasar_id'      => 'required|integer|exists:pasar,id',
            'tipe_tempat'   => 'required|string|in:kios,los,pelataran',
            'nomor_tempat' => 'required|string|max:50',
            'kios_id'       => 'required_if:tipe_tempat,kios',
            'los_id'        => 'required_if:tipe_tempat,los',
            'pelataran_id'  => 'required_if:tipe_tempat,pelataran',
            'jenis_dagangan' => 'required|string|max:255',
            'jam_buka'      => 'required|date_format:H:i',
            'jam_tutup'     => 'required|date_format:H:i|after:jam_buka',

            'nib'           => 'required|mimes:pdf|max:2048',
            'npwp'          => 'required|mimes:pdf|max:2048',
            'ktp'           => 'required|mimes:pdf|max:2048',
            'kk'            => 'required|mimes:pdf|max:2048',
            'foto'          => 'required|mimes:pdf|max:2048',
        ], [
            'pasar_id.required' => 'Pasar wajib dipilih.',
            'pasar_id.integer' => 'Pasar wajib dipilih.',
            'pasar_id.exists'   => 'Pasar tidak valid.',
            'tipe_tempat.required' => 'Tipe tempat wajib diisi.',
            'tipe_tempat.in' => 'Tipe tempat hanya bisa kios, los, atau pelataran.',
            'kios_id.required_if' => 'Kios wajib diisi jika tipe tempat adalah kios.',
            'los_id.required_if' => 'Los wajib diisi jika tipe tempat adalah los.',
            'pelataran_id.required_if' => 'Pelataran wajib diisi jika tipe tempat adalah pelataran.',
            'jam_buka.required' => 'Jam buka wajib diisi.',
            'jam_tutup.required' => 'Jam tutup wajib diisi.',
            'jam_tutup.after' => 'Jam tutup harus lebih besar dari jam buka.',
            'jenis_dagangan.required' => 'Jenis Dagangan wajib diisi',
            'nib.required' => 'NIB wajib di unggah.',
            'nib.mimes' => 'NIB harus dalam format PDF.',
            'nib.max' => 'Ukuran NIB maksimal 2MB.',
            'npwp.required' => 'Fotokopi NPWP wajib di unggah.',
            'npwp.mimes' => 'NPWP harus dalam format PDF.',
            'ktp.required' => 'Fotokopi KTP wajib di unggah.',
            'ktp.mimes' => 'KTP harus dalam format PDF.',
            'kk.required' => 'Fotokopi KK wajib di unggah.',
            'kk.mimes' => 'KK harus dalam format PDF.',
            'foto.required' => 'Pas Foto wajib di unggah.',
            'foto.mimes' => 'Foto harus dalam format PDF.',
        ]);

        // Ambil nik user
        $nik = $request->nik;

        // Buat folder path utama
        $nikFolder = "uploads/{$nik}";

        // Simpan file ke folder sesuai nik
        $nibPath  = $request->file('nib')->store("{$nikFolder}/nib", 'public');
        $npwpPath = $request->file('npwp')->store("{$nikFolder}/npwp", 'public');
        $ktpPath  = $request->file('ktp')->store("{$nikFolder}/ktp", 'public');
        $kkPath   = $request->file('kk')->store("{$nikFolder}/kk", 'public');
        $fotoPath = $request->file('foto')->store("{$nikFolder}/foto", 'public');


        // cek tipe tempat
        $lokasi = null;
        $luas = null;

        if ($request->tipe_tempat == 'kios') {
            $data = DB::table('kios')->where('id', $request->kios_id)->first();
            $lokasi = $data->lokasi_kios ?? null;
            $luas = $data->ukuran_kios ?? null;
        } elseif ($request->tipe_tempat == 'los') {
            $data = DB::table('loss')->where('id', $request->los_id)->first();
            $lokasi = $data->lokasi_los ?? null;
            $luas = $data->ukuran_los ?? null;
        } elseif ($request->tipe_tempat == 'pelataran') {
            $data = DB::table('pelatarans')->where('id', $request->pelataran_id)->first();
            $lokasi = $data->lokasi_pelataran ?? null;
            $luas = $data->ukuran_pelataran ?? null;
        }

        // simpan ke tabel permohonan (bukan users lagi)
        $permohonanId = DB::table('permohonan')->insertGetId([
            'user_id'       => Auth::id(),
            'nik'           => $request->nik,
            'nama'          => $request->nama,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telp'       => $request->no_telp,
            'alamat'        => $request->alamat,
            'pasar_id'      => $request->pasar_id,
            'tipe_tempat'   => $request->tipe_tempat,
            'nomor_tempat'  => $request->nomor_tempat,
            'lokasi'        => $lokasi,
            'luas'          => $luas,
            'jenis_dagangan' => $request->jenis_dagangan,
            'jam_buka'      => $request->jam_buka,
            'jam_tutup'     => $request->jam_tutup,

            // file upload
            'nib'           => $nibPath,
            'npwp'          => $npwpPath,
            'ktp'           => $ktpPath,
            'kk'            => $kkPath,
            'foto'          => $fotoPath,

            'status'      => 'draft',
            'keterangan'  => 'Menunggu kelengkapan dokumen',

            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return redirect()->route('pedagang.permohonan.success', $permohonanId)
            ->with('success', 'Permohonan berhasil diajukan.');
    }

    // halaman sukses setelah submit permohonan
    public function success($id)
    {
        $permohonan = DB::table('permohonan')->where('id', $id)->first();

        if (!$permohonan) {
            abort(404, 'Permohonan tidak ditemukan');
        }

        // generate link download di sini (bukan di store)
        $downloadUrl = route('pedagang.permohonan.download', $permohonan->id);

        return view('backend_pedagang.pages.downloadpermohonan', compact('permohonan', 'downloadUrl'));
    }

    public function preview(Request $request)
        {
            try {
                $data = $request->all();
        
                // Validasi minimal, tambah tipe_tempat dan ID-nya
                $request->validate([
                    'nik' => 'required',
                    'nama' => 'required|string',
                    'pasar_id' => 'required|integer',
                    'tipe_tempat' => 'required|string|in:kios,los,pelataran', // Tambah validasi
                    'kios_id' => 'required_if:tipe_tempat,kios', // Opsional berdasarkan tipe
                    'los_id' => 'required_if:tipe_tempat,los',
                    'pelataran_id' => 'required_if:tipe_tempat,pelataran',
                    'jenis_dagangan' => 'required|string|max:255',
                ]);
        
                // Ambil nama pasar
                $pasar = DB::table('pasar')->where('id', $data['pasar_id'])->first();
                $data['nama_pasar'] = $pasar ? $pasar->nama_pasar : '';
        
                // Ambil lokasi berdasarkan tipe tempat (seperti di store)
                $lokasi = null;
                if ($data['tipe_tempat'] == 'kios' && isset($data['kios_id'])) {
                    $dataKios = DB::table('kios')->where('id', $data['kios_id'])->first();
                    $lokasi = $dataKios->lokasi_kios ?? null;
                } elseif ($data['tipe_tempat'] == 'los' && isset($data['los_id'])) {
                    $dataLos = DB::table('loss')->where('id', $data['los_id'])->first();
                    $lokasi = $dataLos->lokasi_los ?? null;
                } elseif ($data['tipe_tempat'] == 'pelataran' && isset($data['pelataran_id'])) {
                    $dataPelataran = DB::table('pelatarans')->where('id', $data['pelataran_id'])->first();
                    $lokasi = $dataPelataran->lokasi_pelataran ?? null;
                }
                $data['lokasi'] = $lokasi; // Tambah lokasi ke data
        
                // Generate PDF dengan watermark draft
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
                    'backend_pedagang.surat.permohonan',
                    ['pedagang' => (object) $data, 'isDraft' => true] // Tambah isDraft true untuk watermark
                )->setPaper('A4', 'portrait');
        
                // Nama file statis berdasarkan userId
                $userId = Auth::id();
                $fileName = "preview_user{$userId}.pdf";
                $filePath = "uploads/dokumen/{$fileName}";
        
                // Hapus file lama jika ada
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
        
                // Simpan file baru (overwrite)
                Storage::disk('public')->put($filePath, $pdf->output());
        
                if (!Storage::disk('public')->exists($filePath)) {
                    throw new \Exception('Gagal menyimpan file PDF.');
                }
        
                // Pakai path absolut langsung
                $fileUrl = 'https://dev-simpasar.dumaikota.go.id/storage/app/public/uploads/dokumen/' . $fileName;
                \Log::info('Generated PDF URL: ' . $fileUrl . ' | Lokasi: ' . ($lokasi ?? 'null')); // Debug lokasi
        
                return response()->json([
                    'fileUrl' => $fileUrl,
                    'fileName' => $fileName,
                ]);
            } catch (\Exception $e) {
                \Log::error('Error generating PDF: ' . $e->getMessage());
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        // download surat permohonan resmi (setelah data masuk DB)
        public function download($id)
        {
                $permohonan = DB::table('permohonan')
                    ->join('pasar', 'pasar.id', '=', 'permohonan.pasar_id')
                    ->where('permohonan.id', $id)
                    ->select('permohonan.*', 'pasar.nama_pasar')
                    ->first();
            
                if (!$permohonan) {
                    abort(404, 'Data permohonan tidak ditemukan');
                }
            
                // nama file final berdasarkan NIK
                $fileName = "surat_permohonan_{$permohonan->nik}.pdf";
                $path = "uploads/dokumen/{$fileName}";
            
                // Generate PDF setiap kali dengan data terbaru
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
                    'backend_pedagang.surat.permohonan',
                    ['pedagang' => $permohonan, 'isDraft' => false]
                )->setPaper('A4', 'portrait');
            
                // Simpan file baru (overwrite)
                Storage::disk('public')->put($path, $pdf->output());
            
                if (!Storage::disk('public')->exists($path)) {
                    throw new \Exception('Gagal menyimpan file PDF.');
                }
            
                // Ambil file dari storage untuk di-download
                return response()->download(storage_path("app/public/{$path}"), $fileName);
        }
}