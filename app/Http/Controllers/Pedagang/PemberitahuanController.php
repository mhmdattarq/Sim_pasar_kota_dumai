<?php

namespace App\Http\Controllers\Pedagang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PemberitahuanController extends Controller
{
    public function download()
    {
        // Ambil NIK dari user yang login
        $user = auth()->user();
        if (!$user || !$user->nik) {
            return redirect()->back()->with('error', 'NIK tidak ditemukan. Silakan hubungi admin.');
        }

        $nik = $user->nik;

        // Ambil permohonan terbaru berdasarkan NIK
        $permohonan = DB::table('permohonan')
            ->where('nik', $nik)
            ->orderBy('updated_at', 'desc')
            ->first();

        if (!$permohonan) {
            return redirect()->back()->with('error', 'Permohonan tidak ditemukan.');
        }

        // Izinkan download untuk status 'disetujui' atau 'ditolak'
        if (!in_array($permohonan->status, ['disetujui', 'ditolak'])) {
            return redirect()->back()->with('error', 'Surat pemberitahuan hanya tersedia untuk status disetujui atau ditolak.');
        }

        // Ambil path file dari kolom dokumen_path_pemberitahuan
        $filePath = $permohonan->dokumen_path_pemberitahuan;

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->with('error', 'File surat pemberitahuan tidak ditemukan.');
        }

        // Ambil nama file asli dari path untuk download
        $fileName = basename($filePath);

        return Storage::disk('public')->download($filePath, 'Surat_Pemberitahuan_' . $nik . '_' . now()->format('Ymd_His') . '.pdf');
    }
}