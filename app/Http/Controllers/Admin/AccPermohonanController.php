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
            $validDocTypes = ['nib', 'npwp', 'ktp', 'kk', 'foto', 'pernyataan'];
            if (!in_array($docType, $validDocTypes)) {
                return response()->json(['error' => 'Tipe dokumen tidak valid'], 400);
            }

            $permohonan = DB::table('permohonan')->where('nik', $nik)->first();
            if (!$permohonan) {
                return response()->json(['error' => 'Permohonan tidak ditemukan'], 404);
            }

            // Map docType to database column
            $columnMap = [
                'nib' => 'nib',
                'npwp' => 'npwp',
                'ktp' => 'ktp',
                'kk' => 'kk',
                'foto' => 'foto',
                'pernyataan' => 'dokumen_path_pernyataan'
            ];

            $column = $columnMap[$docType];
            $filePath = $permohonan->$column;
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

    public function approve(Request $request, $id)
    {
        try {
            $status = $request->input('status');
            $reason = $request->input('reason');
            $nama = DB::table('permohonan')->where('id', $id)->value('nama');

            Log::info('Approve request for ID: ' . $id, ['status' => $status, 'reason' => $reason]);

            if (!in_array($status, ['approved', 'rejected'])) {
                return response()->json(['error' => 'Status tidak valid'], 400);
            }

            $newStatus = ($status === 'approved') ? 'disetujui' : 'ditolak';
            $keterangan = ($status === 'approved') ? 'Surat permohonan telah disetujui, Belum Terverifikasi!' : $reason;

            DB::table('permohonan')
                ->where('id', $id)
                ->update([
                    'status' => $newStatus,
                    'keterangan' => $keterangan
                ]);

            $permohonan = DB::table('permohonan')->where('id', $id)->first();
            Log::info('Status setelah pembaruan untuk ID ' . $id . ': ' . ($permohonan->status ?? 'null'));

            // Trigger generasi dokumen berdasarkan status
            if ($status === 'approved') {
                $this->generatePemberitahuan($id); // Generate surat pemberitahuan
                $this->generatePernyataan($id);   // Generate surat pernyataan
            } elseif ($status === 'rejected') {
                $this->generatePemberitahuan($id); // Generate hanya surat pemberitahuan
            }

            if ($status === 'approved') {
                session()->flash('success', "Surat permohonan dari {$nama} telah disetujui");
            } else {
                session()->flash('error', "Surat permohonan dari {$nama} telah ditolak");
            }

            Log::info('Approve successful for ID: ' . $id, ['status' => $newStatus, 'keterangan' => $keterangan]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error in approve for ID: ' . $id . ', Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            DB::table('permohonan')->where('id', $id)->update(['status' => 'lengkap', 'keterangan' => 'Gagal proses pemberitahuan']);
            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage()], 500);
        }
    }

    public function generatePemberitahuan($id)
    {
        try {
            Log::info('Starting generatePemberitahuan for ID: ' . $id);

            $permohonan = DB::table('permohonan')->where('id', $id)->first();
            if (!$permohonan) {
                throw new \Exception('Permohonan tidak ditemukan untuk ID: ' . $id);
            }

            Log::info('Status permohonan untuk ID ' . $id . ': ' . ($permohonan->status ?? 'null'));
            Log::info('Data permohonan: ' . json_encode($permohonan));

            $data = [
                'permohonan' => $permohonan,
                'tanggal' => now()->format('d F Y'),
            ];

            if (!view()->exists('backend_pedagang.surat.pemberitahuan')) {
                throw new \Exception('View backend_pedagang.surat.pemberitahuan tidak ditemukan');
            }
            Log::info('View backend_pedagang.surat.pemberitahuan ditemukan');

            if (!class_exists('Barryvdh\DomPDF\Facade\Pdf')) {
                throw new \Exception('Library PDF (barryvdh/laravel-dompdf) belum diinstall');
            }

            $directory = 'uploads/dokumen';
            $timestamp = now()->format('Ymd_His'); // Tambahkan timestamp, contoh: 20251008_092300
            $fileName = "surat_pemberitahuan_{$permohonan->nik}_{$timestamp}.pdf"; // Tambah timestamp
            $filePath = $directory . '/' . $fileName;
            $fullPath = storage_path('app/public/' . $filePath);
            Log::info('Generated file path: ' . $filePath);
            Log::info('Full file path: ' . $fullPath);

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('backend_pedagang.surat.pemberitahuan', $data)->setPaper('A4', 'portrait');

            Log::info('PDF generated successfully');

            $pdfOutput = $pdf->output();
            if (empty($pdfOutput)) {
                throw new \Exception('Output PDF kosong, gagal generate PDF');
            }
            Storage::disk('public')->put($filePath, $pdfOutput);
            Log::info('PDF saved to storage: ' . $fullPath);

            if (!Storage::disk('public')->exists($filePath)) {
                throw new \Exception('File tidak ditemukan di storage setelah disimpan');
            }
            Log::info('File verified in storage');

            DB::table('permohonan')
                ->where('id', $id)
                ->update(['dokumen_path_pemberitahuan' => $filePath]);
            Log::info('Database updated with file path: ' . $filePath);

            Log::info('generatePemberitahuan completed successfully for ID: ' . $id);
        } catch (\Exception $e) {
            Log::error('Error in generatePemberitahuan for ID: ' . $id . ', Error: ' . $e->getMessage() . ', Trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }

    public function generatePernyataan($id)
    {
        try {
            Log::info('Starting generatePernyataan for ID: ' . $id);

            $permohonan = DB::table('permohonan')
                ->join('pasar', 'permohonan.pasar_id', '=', 'pasar.id')
                ->select('permohonan.*', 'pasar.nama_pasar')
                ->where('permohonan.id', $id)
                ->first();
            if (!$permohonan) {
                throw new \Exception('Permohonan tidak ditemukan untuk ID: ' . $id);
            }

            $data = [
                'permohonan' => $permohonan,
                'tanggal' => now()->format('d F Y'),
            ];

            if (!view()->exists('backend_pedagang.surat.pernyataan')) {
                throw new \Exception('View backend_pedagang.surat.pernyataan tidak ditemukan');
            }
            Log::info('View backend_pedagang.surat.pernyataan ditemukan');

            if (!class_exists('Barryvdh\DomPDF\Facade\Pdf')) {
                throw new \Exception('Library PDF (barryvdh/laravel-dompdf) belum diinstall');
            }

            $directory = 'uploads/dokumen';
            $timestamp = now()->format('Ymd_His'); // Tambahkan timestamp, contoh: 20251008_092300
            $fileName = "surat_pernyataan_{$permohonan->nik}_{$timestamp}.pdf"; // Tambah timestamp
            $filePath = $directory . '/' . $fileName;
            $fullPath = storage_path('app/public/' . $filePath);
            Log::info('Generated file path: ' . $filePath);
            Log::info('Full file path: ' . $fullPath);

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('backend_pedagang.surat.pernyataan', $data)->setPaper('A4', 'portrait');

            Log::info('PDF generated successfully');

            $pdfOutput = $pdf->output();
            if (empty($pdfOutput)) {
                throw new \Exception('Output PDF kosong, gagal generate PDF');
            }
            Storage::disk('public')->put($filePath, $pdfOutput);
            Log::info('PDF saved to storage: ' . $fullPath);

            if (!Storage::disk('public')->exists($filePath)) {
                throw new \Exception('File tidak ditemukan di storage setelah disimpan');
            }
            Log::info('File verified in storage');

            DB::table('permohonan')
                ->where('id', $id)
                ->update(['dokumen_path_pernyataan' => $filePath]);
            Log::info('Database updated with file path: ' . $filePath);

            Log::info('generatePernyataan completed successfully for ID: ' . $id);
        } catch (\Exception $e) {
            Log::error('Error in generatePernyataan for ID: ' . $id . ', Error: ' . $e->getMessage() . ', Trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }

    public function verify(Request $request, $id)
    {
        try {
            $status = $request->input('status');
            $nama = DB::table('permohonan')->where('id', $id)->value('nama');

            Log::info('Verify request for ID: ' . $id, ['status' => $status]);

            if ($status !== 'selesai') {
                return response()->json(['error' => 'Status tidak valid'], 400);
            }

            $permohonan = DB::table('permohonan')->where('id', $id)->first();
            if (!$permohonan) {
                Log::error('Permohonan tidak ditemukan untuk ID: ' . $id);
                return response()->json(['error' => 'Permohonan tidak ditemukan'], 404);
            }

            Log::info('Status permohonan untuk ID: ' . $id, ['status' => $permohonan->status]);

            if ($permohonan->status !== 'verifikasi') {
                Log::error('Status tidak valid untuk verifikasi', [
                    'id' => $id,
                    'current_status' => $permohonan->status
                ]);
                return response()->json(['error' => 'Permohonan tidak dapat diverifikasi, status tidak valid: ' . $permohonan->status], 400);
            }

            DB::table('permohonan')
                ->where('id', $id)
                ->update([
                    'status' => 'selesai',
                    'keterangan' => 'Permohonan telah diverifikasi dan selesai'
                ]);

            session()->flash('success', "Permohonan dari {$nama} telah diverifikasi dan selesai");

            Log::info('Verify successful for ID: ' . $id, ['status' => 'selesai']);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error in verify for ID: ' . $id . ', Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Terjadi kesalahan saat memverifikasi: ' . $e->getMessage()], 500);
        }
    }
}