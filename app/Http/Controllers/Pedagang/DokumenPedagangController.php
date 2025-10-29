<?php

namespace App\Http\Controllers\Pedagang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DokumenPedagangController extends Controller
{
    public function showTable()
    {
        // Ambil semua permohonan untuk user yang login
        $permohonans = DB::table('permohonan')
            ->where('user_id', Auth::id())
            ->select('id', 'nik', 'nama', 'created_at', 'status', 'dokumen_path', 'dokumen_path_pernyataan', 'dokumen_path_pemberitahuan')
            ->get();

        // Kalau belum ada permohonan, redirect ke halaman belum permohonan
        if ($permohonans->isEmpty()) {
            return view('backend_pedagang.pages.belumpermohonan');
        }

        // Log untuk debugging
        \Log::info('DokumenPedagangController: Fetched permohonans', [
            'user_id' => Auth::id(),
            'permohonans' => $permohonans->toArray()
        ]);

        return view('backend_pedagang.pages.dokumen', compact('permohonans'));
    }

    public function download($id, $type)
    {
        try {
            // Validasi tipe dokumen
            if (!in_array($type, ['permohonan', 'pernyataan', 'pemberitahuan'])) {
                \Log::error('Invalid document type', ['id' => $id, 'type' => $type, 'user_id' => Auth::id()]);
                return redirect()->back()->with('error', 'Tipe dokumen tidak valid.');
            }

            // Ambil permohonan berdasarkan ID dan user_id
            $permohonan = DB::table('permohonan')
                ->where('id', $id)
                ->where('user_id', Auth::id())
                ->select('nik', 'status', 'dokumen_path', 'dokumen_path_pernyataan', 'dokumen_path_pemberitahuan')
                ->first();

            if (!$permohonan) {
                \Log::error('Permohonan not found', ['id' => $id, 'type' => $type, 'user_id' => Auth::id()]);
                return redirect()->back()->with('error', 'Permohonan tidak ditemukan.');
            }

            // Tentukan kolom path berdasarkan tipe dokumen
            $pathColumn = match ($type) {
                'pernyataan' => 'dokumen_path_pernyataan',
                'pemberitahuan' => 'dokumen_path_pemberitahuan',
                default => 'dokumen_path',
            };

            // Validasi status untuk pernyataan dan pemberitahuan
            if ($type === 'pernyataan' && !in_array($permohonan->status, ['disetujui', 'verifikasi', 'selesai'])) {
                \Log::error('Invalid status for pernyataan download', [
                    'id' => $id,
                    'status' => $permohonan->status,
                    'user_id' => Auth::id()
                ]);
                return redirect()->back()->with('error', 'Surat pernyataan hanya tersedia untuk status disetujui, verifikasi, atau selesai.');
            }

            if ($type === 'pemberitahuan' && !in_array($permohonan->status, ['disetujui', 'verifikasi', 'selesai', 'ditolak'])) {
                \Log::error('Invalid status for pemberitahuan download', [
                    'id' => $id,
                    'status' => $permohonan->status,
                    'user_id' => Auth::id()
                ]);
                return redirect()->back()->with('error', 'Surat pemberitahuan hanya tersedia untuk status disetujui, verifikasi, selesai, atau ditolak.');
            }

            // Ambil path file
            $filePath = $permohonan->$pathColumn;
            if (!$filePath || !Storage::disk('public')->exists($filePath)) {
                \Log::error('File not found', [
                    'id' => $id,
                    'type' => $type,
                    'file_path' => $filePath,
                    'user_id' => Auth::id()
                ]);
                return redirect()->back()->with('error', 'File ' . $type . ' tidak ditemukan.');
            }

            // Generate nama file untuk download
            $fileName = ucfirst($type) . '_' . $permohonan->nik . '_' . now()->format('Ymd_His') . '.pdf';
            \Log::info('Downloading document', [
                'id' => $id,
                'type' => $type,
                'file_path' => $filePath,
                'file_name' => $fileName,
                'user_id' => Auth::id()
            ]);

            return Storage::disk('public')->download($filePath, $fileName);
        } catch (\Exception $e) {
            \Log::error('Download error for ID ' . $id . ': ' . $e->getMessage(), [
                'type' => $type,
                'user_id' => Auth::id()
            ]);
            return redirect()->back()->with('error', 'Gagal mendownload dokumen: ' . $e->getMessage());
        }
    }
}
