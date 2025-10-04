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

        if ($permohonan->status !== 'disetujui') {
            return redirect()->back()->with('error', 'Surat pemberitahuan hanya tersedia untuk status disetujui.');
        }

        // Tentukan file pemberitahuan berdasarkan NIK
        $fileName = 'surat_pemberitahuan_' . $nik . '.pdf';
        $filePath = 'uploads/dokumen/' . $fileName;

        if (!Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->with('error', 'File surat pemberitahuan tidak ditemukan.');
        }

        return Storage::disk('public')->download($filePath, 'Surat_Pemberitahuan_' . $nik . '.pdf');
    }
}