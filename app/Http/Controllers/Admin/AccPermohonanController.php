<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AccPermohonanController extends Controller
{
    public function showTable()
    {
        $permohonans = DB::table('permohonan')
            ->join('pasar', 'permohonan.pasar_id', '=', 'pasar.id')
            ->select('permohonan.*', 'pasar.nama_pasar')
            ->get();

        return view('backend_admin.pages.pedagang.tabelpermohonan', compact('permohonans'));
    }

    public function reviewPdf($nik)
    {
        try {
            $nik = str_replace('.', '', $nik);

            // Ambil data permohonan berdasarkan nik
            $permohonan = DB::table('permohonan')->where('nik', $nik)->first();
            if (!$permohonan) {
                return response()->json([
                    'error' => 'Permohonan tidak ditemukan',
                    'debug' => ['nik' => $nik]
                ], 404);
            }

            // Cek dokumen_path
            $filePath = $permohonan->dokumen_path;
            if (!$filePath) {
                return response()->json([
                    'error' => 'Dokumen path tidak tersedia',
                    'debug' => ['nik' => $nik, 'id' => $permohonan->id]
                ], 404);
            }

            // Cek apakah file ada di storage
            $fullPath = storage_path('app/public/' . $filePath);
            if (!file_exists($fullPath)) {
                return response()->json([
                    'error' => 'File PDF tidak ditemukan di storage',
                    'debug' => [
                        'nik' => $nik,
                        'id' => $permohonan->id,
                        'filePath' => $filePath,
                        'fullPath' => $fullPath,
                        'url' => asset('storage/' . $filePath)
                    ]
                ], 404);
            }

            $fileUrl = url('/proxy-storage/' . $filePath);
            $fileName = basename($filePath);

            return response()->json([
                'fileUrl' => $fileUrl,
                'fileName' => $fileName,
                'debug' => [
                    'nik' => $nik,
                    'id' => $permohonan->id,
                    'filePath' => $filePath,
                    'fullPath' => $fullPath
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi error server: ' . $e->getMessage(),
                'debug' => [
                    'nik' => $nik,
                    'trace' => $e->getTraceAsString()
                ]
            ], 500);
        }
    }

    public function getDocument($nik, $docType)
    {
        try {
            $nik = str_replace('.', '', $nik);
            $validDocTypes = ['nib', 'npwp', 'ktp', 'kk', 'foto'];
            if (!in_array($docType, $validDocTypes)) {
                return response()->json(['error' => 'Tipe dokumen tidak valid'], 400);
            }

            $permohonan = DB::table('permohonan')->where('nik', $nik)->first();
            if (!$permohonan) {
                return response()->json(['error' => 'Permohonan tidak ditemukan'], 404);
            }

            $filePath = $permohonan->$docType; // Kolom: nib, npwp, ktp, kk, foto
            if (!$filePath) {
                return response()->json(['error' => 'Dokumen ' . strtoupper($docType) . ' tidak tersedia'], 404);
            }

            $fullPath = storage_path('app/public/' . $filePath);
            if (!file_exists($fullPath)) {
                \Log::error('File not found: ' . $fullPath);
                return response()->json(['error' => 'File PDF tidak ditemukan'], 404);
            }
            if (!is_readable($fullPath)) {
                \Log::error('File not readable: ' . $fullPath);
                return response()->json(['error' => 'File tidak bisa dibaca'], 403);
            }

            $fileUrl = url('/proxy-storage/' . $filePath);
            return redirect($fileUrl); // Buka PDF di tab baru
        } catch (\Exception $e) {
            \Log::error('Get document error for NIK: ' . $nik . ', DocType: ' . $docType . ': ' . $e->getMessage());
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function approve(Request $request, $nik)
    {
        try {
            $status = $request->input('status');
            $reason = $request->input('reason');
            $nama = DB::table('permohonan')->where('nik', $nik)->value('nama');

            Log::info('Approve request for NIK: ' . $nik, ['status' => $status, 'reason' => $reason]);

            if (!in_array($status, ['approved', 'rejected'])) {
                return response()->json(['error' => 'Status tidak valid'], 400);
            }

            $newStatus = ($status === 'approved') ? 'disetujui' : 'ditolak';
            $keterangan = ($status === 'approved') ? 'Surat permohonan telah disetujui, Belum Terverifikasi!' : $reason;

            // Generate surat pemberitahuan dan pernyataan jika disetujui
            if ($status === 'approved') {
                $this->generatePemberitahuan($nik);
                $this->generatePernyataan($nik);
            }

            // Update status dan keterangan
            DB::table('permohonan')
                ->where('nik', $nik)
                ->update([
                    'status' => $newStatus,
                    'keterangan' => $keterangan
                ]);

            // Set session untuk alert
            if ($status === 'approved') {
                session()->flash('success', "Surat permohonan dari {$nama} telah disetujui");
            } else {
                session()->flash('error', "Surat permohonan dari {$nama} telah ditolak");
            }

            Log::info('Approve successful for NIK: ' . $nik, ['status' => $newStatus, 'keterangan' => $keterangan]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error in approve for NIK: ' . $nik . ', Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            DB::table('permohonan')->where('nik', $nik)->update(['status' => 'lengkap', 'keterangan' => 'Gagal proses pemberitahuan']); // Rollback
            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage()], 500);
        }
    }

    public function generatePemberitahuan($nik)
    {
        try {
            Log::info('Starting generatePemberitahuan for NIK: ' . $nik);

            $permohonan = DB::table('permohonan')->where('nik', $nik)->first();
            if (!$permohonan) {
                throw new \Exception('Permohonan tidak ditemukan untuk NIK: ' . $nik);
            }

            $data = [
                'permohonan' => $permohonan, // Mengirim objek permohonan utuh
                'tanggal' => now()->format('d F Y'), // Tanggal TTD
            ];

            // Cek apakah view ada sebelum generate
            if (!view()->exists('backend_pedagang.surat.pemberitahuan')) {
                throw new \Exception('View backend_pedagang.surat.pemberitahuan tidak ditemukan');
            }
            Log::info('View backend_pedagang.surat.pemberitahuan ditemukan');

            // Cek apakah library PDF tersedia
            if (!class_exists('Barryvdh\DomPDF\Facade\Pdf')) {
                throw new \Exception('Library PDF (barryvdh/laravel-dompdf) belum diinstall');
            }

            // Gunakan direktori utama
            $directory = 'uploads/dokumen';
            $fileName = "surat_pemberitahuan_{$permohonan->nik}.pdf";
            $filePath = $directory . '/' . $fileName;
            $fullPath = storage_path('app/public/' . $filePath);
            Log::info('Generated file path: ' . $filePath);
            Log::info('Full file path: ' . $fullPath);

            // Generate PDF
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('backend_pedagang.surat.pemberitahuan', $data)->setPaper('A4', 'portrait');

            Log::info('PDF generated successfully');

            // Simpan PDF
            $pdfOutput = $pdf->output();
            if (empty($pdfOutput)) {
                throw new \Exception('Output PDF kosong, gagal generate PDF');
            }
            Storage::disk('public')->put($filePath, $pdfOutput);
            Log::info('PDF saved to storage: ' . $fullPath);

            // Verifikasi file ada
            if (!Storage::disk('public')->exists($filePath)) {
                throw new \Exception('File tidak ditemukan di storage setelah disimpan');
            }
            Log::info('File verified in storage');

            // Update database dengan path PDF
            DB::table('permohonan')
                ->where('nik', $nik)
                ->update(['dokumen_path_pemberitahuan' => $filePath]);
            Log::info('Database updated with file path: ' . $filePath);

            Log::info('generatePemberitahuan completed successfully for NIK: ' . $nik);
        } catch (\Exception $e) {
            Log::error('Error in generatePemberitahuan for NIK: ' . $nik . ', Error: ' . $e->getMessage() . ', Trace: ' . $e->getTraceAsString());
            throw $e; // Re-throw agar ditangkap di approve
        }
    }

    public function generatePernyataan($nik)
    {
        try {
            Log::info('Starting generatePernyataan for NIK: ' . $nik);

            $permohonan = DB::table('permohonan')
                ->join('pasar', 'permohonan.pasar_id', '=', 'pasar.id')
                ->select('permohonan.*', 'pasar.nama_pasar')
                ->where('permohonan.nik', $nik)
                ->first();
            if (!$permohonan) {
                throw new \Exception('Permohonan tidak ditemukan untuk NIK: ' . $nik);
            }

            $data = [
                'permohonan' => $permohonan, // Mengirim objek permohonan utuh
                'tanggal' => now()->format('d F Y'), // Tanggal TTD
            ];

            // Cek apakah view ada sebelum generate
            if (!view()->exists('backend_pedagang.surat.pernyataan')) {
                throw new \Exception('View backend_pedagang.surat.pernyataan tidak ditemukan');
            }
            Log::info('View backend_pedagang.surat.pernyataan ditemukan');

            // Cek apakah library PDF tersedia
            if (!class_exists('Barryvdh\DomPDF\Facade\Pdf')) {
                throw new \Exception('Library PDF (barryvdh/laravel-dompdf) belum diinstall');
            }

            // Gunakan direktori utama
            $directory = 'uploads/dokumen';
            $fileName = "surat_pernyataan_{$permohonan->nik}.pdf";
            $filePath = $directory . '/' . $fileName;
            $fullPath = storage_path('app/public/' . $filePath);
            Log::info('Generated file path: ' . $filePath);
            Log::info('Full file path: ' . $fullPath);

            // Generate PDF
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('backend_pedagang.surat.pernyataan', $data)->setPaper('A4', 'portrait');

            Log::info('PDF generated successfully');

            // Simpan PDF
            $pdfOutput = $pdf->output();
            if (empty($pdfOutput)) {
                throw new \Exception('Output PDF kosong, gagal generate PDF');
            }
            Storage::disk('public')->put($filePath, $pdfOutput);
            Log::info('PDF saved to storage: ' . $fullPath);

            // Verifikasi file ada
            if (!Storage::disk('public')->exists($filePath)) {
                throw new \Exception('File tidak ditemukan di storage setelah disimpan');
            }
            Log::info('File verified in storage');

            // Update database dengan path PDF
            DB::table('permohonan')
                ->where('nik', $nik)
                ->update(['dokumen_path_pernyataan' => $filePath]);
            Log::info('Database updated with file path: ' . $filePath);

            Log::info('generatePernyataan completed successfully for NIK: ' . $nik);
        } catch (\Exception $e) {
            Log::error('Error in generatePernyataan for NIK: ' . $nik . ', Error: ' . $e->getMessage() . ', Trace: ' . $e->getTraceAsString());
            throw $e; // Re-throw agar ditangkap di approve
        }
    }
    public function verify($nik)
    {
        try {
            $nik = str_replace('.', '', $nik);
            $nama = DB::table('permohonan')->where('nik', $nik)->value('nama');

            // Cek apakah permohonan ada
            $permohonan = DB::table('permohonan')->where('nik', $nik)->first();
            if (!$permohonan) {
                return response()->json(['error' => 'Permohonan tidak ditemukan'], 404);
            }

            // Update status jadi 'selesai'
            DB::table('permohonan')
                ->where('nik', $nik)
                ->update([
                    'status' => 'selesai',
                    'keterangan' => 'Permohonan telah diverifikasi'
                ]);

            // Set session untuk alert
            session()->flash('success', "Permohonan dari {$nama} telah diverifikasi");

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error verifikasi untuk NIK: ' . $nik . ', Error: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal verifikasi: ' . $e->getMessage()], 500);
        }
    }
}
