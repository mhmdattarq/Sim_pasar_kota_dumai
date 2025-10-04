<?php

namespace App\Http\Controllers\Pedagang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PernyataanController extends Controller
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
            return redirect()->back()->with('error', 'Surat pernyataan hanya tersedia untuk status disetujui.');
        }

        // Tentukan file pernyataan berdasarkan NIK
        $fileName = 'surat_pernyataan_' . $nik . '.pdf';
        $filePath = 'uploads/dokumen/' . $fileName;

        if (!Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->with('error', 'File surat pernyataan tidak ditemukan.');
        }

        return Storage::disk('public')->download($filePath, 'Surat_Pernyataan_' . $nik . '.pdf');
    }
    
    public function uploadSigned(Request $request)
    {
        // Ambil NIK dari user yang login
        $user = auth()->user();
        if (!$user || !$user->nik) {
            return redirect()->back()->with('error', 'NIK tidak ditemukan. Silakan hubungi admin.');
        }

        $nik = $user->nik;

        // Validasi file upload
        $request->validate([
            'signed_document' => 'required|file|mimes:pdf|max:2048', // Maks 2MB, cuma PDF
        ]);

        // Ambil permohonan terbaru berdasarkan NIK
        $permohonan = DB::table('permohonan')
            ->where('nik', $nik)
            ->orderBy('updated_at', 'desc')
            ->first();

        if (!$permohonan) {
            return redirect()->back()->with('error', 'Permohonan tidak ditemukan.');
        }

        if ($permohonan->status !== 'disetujui') {
            return redirect()->back()->with('error', 'Upload surat pernyataan hanya tersedia untuk status disetujui.');
        }

        // Tentukan file path
        $fileName = 'surat_pernyataan_' . $nik . '.pdf';
        $filePath = 'uploads/dokumen/' . $fileName;

        // Upload file baru, replace yang lama
        if ($request->hasFile('signed_document')) {
            $file = $request->file('signed_document');
            $fileContent = file_get_contents($file->getRealPath());
            Storage::disk('public')->put($filePath, $fileContent);

            // Update database dengan path baru dan status serta keterangan
            DB::table('permohonan')
                ->where('nik', $nik)
                ->update([
                    'dokumen_path_pernyataan' => $filePath,
                    'status' => 'selesai',
                    'keterangan' => 'Anda sudah berhasil terverifikasi menjadi pedagang!'
                ]);
        }

        return redirect()->back()->with('success', 'Surat pernyataan yang ditandatangani berhasil diupload dan berhasil terverifikasi.');
    }
}