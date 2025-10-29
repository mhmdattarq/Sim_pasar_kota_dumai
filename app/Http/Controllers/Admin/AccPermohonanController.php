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

    public function reviewPdf($nik, $id)
    {
        try {
            $nik = str_replace('.', '', $nik);
            $permohonan = DB::table('permohonan')->where('nik', $nik)->where('id', $id)->first();
            if (!$permohonan) {
                return response()->json([
                    'error' => 'Permohonan tidak ditemukan',
                    'debug' => ['nik' => $nik, 'id' => $id]
                ], 404);
            }

            $filePath = $permohonan->dokumen_path;
            if (!$filePath) {
                return response()->json([
                    'error' => 'Dokumen path tidak tersedia',
                    'debug' => ['nik' => $nik, 'id' => $id]
                ], 404);
            }

            $fullPath = storage_path('app/public/' . $filePath);
            if (!file_exists($fullPath)) {
                return response()->json([
                    'error' => 'File PDF tidak ditemukan di storage',
                    'debug' => [
                        'nik' => $nik,
                        'id' => $id,
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
                    'id' => $id,
                    'filePath' => $filePath,
                    'fullPath' => $fullPath
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi error server: ' . $e->getMessage(),
                'debug' => [
                    'nik' => $nik,
                    'id' => $id,
                    'trace' => $e->getTraceAsString()
                ]
            ], 500);
        }
    }

    public function getDocument($nik, $id, $docType)
    {
        try {
            $nik = str_replace('.', '', $nik);
            $validDocTypes = ['nib', 'npwp', 'ktp', 'kk', 'foto', 'pernyataan'];
            if (!in_array($docType, $validDocTypes)) {
                return response()->json(['error' => 'Tipe dokumen tidak valid'], 400);
            }

            $permohonan = DB::table('permohonan')->where('nik', $nik)->where('id', $id)->first();
            if (!$permohonan) {
                return response()->json(['error' => 'Permohonan tidak ditemukan'], 404);
            }

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

            $fileUrl = url('/proxy-storage/' . $filePath . '?v=' . time());
            return response()->json([
                'success' => true,
                'fileUrl' => $fileUrl,
                'fileName' => basename($filePath)
            ]);
        } catch (\Exception $e) {
            \Log::error('Get document error for NIK: ' . $nik . ', ID: ' . $id . ', DocType: ' . $docType . ': ' . $e->getMessage());
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

            DB::beginTransaction();

            try {
                $permohonan = DB::table('permohonan')->where('id', $id)->first();

                // Update status permohonan
                DB::table('permohonan')
                    ->where('id', $id)
                    ->update([
                        'status' => $newStatus,
                        'keterangan' => $keterangan
                    ]);

                // Handle penolakan: kembalikan status kios/los ke "tersedia" dan tambah total di pasar
                if ($status === 'rejected') {
                    if ($permohonan->tipe_tempat == 'kios') {
                        $kios = DB::table('kios')
                            ->where('pasar_id', $permohonan->pasar_id)
                            ->where('nomor_kios', $permohonan->nomor_tempat)
                            ->where('status_kios', 'pengajuan')
                            ->first();
                        if ($kios) {
                            DB::table('kios')
                                ->where('id', $kios->id)
                                ->update(['status_kios' => 'tersedia', 'updated_at' => now()]);
                            // Tambah kembali total_kios di pasar
                            DB::table('pasar')
                                ->where('id', $permohonan->pasar_id)
                                ->increment('total_kios');
                        } else {
                            Log::warning('Kios not found or not in pengajuan state for pasar_id: ' . $permohonan->pasar_id . ', nomor_tempat: ' . $permohonan->nomor_tempat);
                        }
                    } elseif ($permohonan->tipe_tempat == 'los') {
                        $los = DB::table('loss')
                            ->where('pasar_id', $permohonan->pasar_id)
                            ->where('nomor_los', $permohonan->nomor_tempat)
                            ->where('status_los', 'pengajuan')
                            ->first();
                        if ($los) {
                            DB::table('loss')
                                ->where('id', $los->id)
                                ->update(['status_los' => 'tersedia', 'updated_at' => now()]);
                            // Tambah kembali total_los di pasar
                            DB::table('pasar')
                                ->where('id', $permohonan->pasar_id)
                                ->increment('total_los');
                        } else {
                            Log::warning('Los not found or not in pengajuan state for pasar_id: ' . $permohonan->pasar_id . ', nomor_tempat: ' . $permohonan->nomor_tempat);
                        }
                    }
                }

                // Trigger generasi dokumen berdasarkan status
                if ($status === 'approved') {
                    $this->generatePemberitahuan($id); // Generate surat pemberitahuan
                    $this->generatePernyataan($id);   // Generate surat pernyataan
                } elseif ($status === 'rejected') {
                    $this->generatePemberitahuan($id); // Generate hanya surat pemberitahuan
                }

                DB::commit();

                if ($status === 'approved') {
                    session()->flash('success', "Surat permohonan dari {$nama} telah disetujui");
                } else {
                    session()->flash('error', "Surat permohonan dari {$nama} telah ditolak");
                }

                Log::info('Approve successful for ID: ' . $id, ['status' => $newStatus, 'keterangan' => $keterangan]);
                return response()->json(['success' => true]);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error in transaction for approve ID: ' . $id . ', Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
                DB::table('permohonan')->where('id', $id)->update(['status' => 'lengkap', 'keterangan' => 'Gagal proses pemberitahuan']);
                return response()->json(['error' => 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage()], 500);
            }
        } catch (\Exception $e) {
            Log::error('Error in approve for ID: ' . $id . ', Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
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
                'tanggal_permohonan' => \Carbon\Carbon::parse($permohonan->updated_at)->locale('id')->translatedFormat('d F Y'),
                'tanggal' => now()->locale('id')->translatedFormat('d F Y'),
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

    // Fungsi baru untuk menghitung kios, los, dan pelataran berdasarkan NIK
    private function getTempatData($nik)
    {
        // Ambil semua permohonan berdasarkan NIK dengan status disetujui
        $permohonanList = DB::table('permohonan')
            ->join('pasar', 'permohonan.pasar_id', '=', 'pasar.id')
            ->select('permohonan.tipe_tempat', 'permohonan.nomor_tempat', 'permohonan.lokasi', 'permohonan.luas', 'pasar.nama_pasar')
            ->where('permohonan.nik', $nik)
            ->where('permohonan.status', 'disetujui')
            ->get();

        // Inisialisasi counter dan lokasi
        $kiosCount = 0;
        $losTotal = 0;
        $pelataranTotal = 0;
        $kiosLocations = [];
        $losLocations = [];
        $pelataranLocations = [];

        // Proses setiap permohonan
        foreach ($permohonanList as $item) {
            if ($item->tipe_tempat === 'kios') {
                $kiosCount++;
                $kiosLocations[] = "{$item->nomor_tempat}, {$item->lokasi}, {$item->nama_pasar}";
            } elseif ($item->tipe_tempat === 'los') {
                $losTotal += floatval($item->luas);
                $losLocations[] = "{$item->nomor_tempat}, {$item->lokasi}, {$item->nama_pasar}";
            } elseif ($item->tipe_tempat === 'pelataran') {
                $pelataranTotal += floatval($item->luas);
                $pelataranLocations[] = "{$item->nomor_tempat}, {$item->lokasi}, {$item->nama_pasar}";
            }
        }

        // Format string lokasi
        $kiosLocationString = $kiosCount > 0 ? implode('; ', $kiosLocations) : '-';
        $losLocationString = $losTotal > 0 ? implode('; ', $losLocations) : '-';
        $pelataranLocationString = $pelataranTotal > 0 ? implode('; ', $pelataranLocations) : '-';

        return [
            'kios' => [
                'count' => $kiosCount,
                'locations' => $kiosLocationString,
            ],
            'los' => [
                'total' => $losTotal,
                'locations' => $losLocationString,
            ],
            'pelataran' => [
                'total' => $pelataranTotal,
                'locations' => $pelataranLocationString,
            ],
        ];
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

            // Ambil data kios, los, pelataran
            $tempatData = $this->getTempatData($permohonan->nik);

            $data = [
                'permohonan' => $permohonan,
                'tanggal' => now()->locale('id')->translatedFormat('d F Y'),
                'kios' => $tempatData['kios'],
                'los' => $tempatData['los'],
                'pelataran' => $tempatData['pelataran'],
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

            DB::beginTransaction();

            try {
                // Update status permohonan
                DB::table('permohonan')
                    ->where('id', $id)
                    ->update([
                        'status' => 'selesai',
                        'keterangan' => 'Permohonan telah diverifikasi dan selesai'
                    ]);

                // Update status di tabel kios atau loss berdasarkan tipe_tempat dan nomor_tempat
                if ($permohonan->tipe_tempat == 'kios') {
                    $kios = DB::table('kios')
                        ->where('pasar_id', $permohonan->pasar_id)
                        ->where('nomor_kios', $permohonan->nomor_tempat)
                        ->where('status_kios', 'pengajuan')
                        ->first();
                    if ($kios) {
                        DB::table('kios')
                            ->where('id', $kios->id)
                            ->update(['status_kios' => 'terisi', 'updated_at' => now()]);
                    } else {
                        Log::warning('Kios not found or not in pengajuan state for pasar_id: ' . $permohonan->pasar_id . ', nomor_tempat: ' . $permohonan->nomor_tempat);
                    }
                } elseif ($permohonan->tipe_tempat == 'los') {
                    $los = DB::table('loss')
                        ->where('pasar_id', $permohonan->pasar_id)
                        ->where('nomor_los', $permohonan->nomor_tempat)
                        ->where('status_los', 'pengajuan')
                        ->first();
                    if ($los) {
                        DB::table('loss')
                            ->where('id', $los->id)
                            ->update(['status_los' => 'terisi', 'updated_at' => now()]);
                    } else {
                        Log::warning('Los not found or not in pengajuan state for pasar_id: ' . $permohonan->pasar_id . ', nomor_tempat: ' . $permohonan->nomor_tempat);
                    }
                }

                DB::commit();

                session()->flash('success', "Permohonan dari {$nama} telah diverifikasi dan selesai");

                Log::info('Verify successful for ID: ' . $id, ['status' => 'selesai']);
                return response()->json(['success' => true]);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error in transaction for verify ID: ' . $id . ', Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
                return response()->json(['error' => 'Terjadi kesalahan saat memverifikasi: ' . $e->getMessage()], 500);
            }
        } catch (\Exception $e) {
            Log::error('Error in verify for ID: ' . $id . ', Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Terjadi kesalahan saat memverifikasi: ' . $e->getMessage()], 500);
        }
    }
}
