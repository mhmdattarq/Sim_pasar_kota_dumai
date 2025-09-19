<?php

namespace App\Http\Controllers\pedagang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UploadpermohonanController extends Controller
{
    public function showTable()
    {
        // cek apakah user sudah punya permohonan
        $permohonans = DB::table('permohonan')
            ->where('user_id', Auth::id())
            ->select('id', 'nama', 'status', 'keterangan')
            ->get();

        // kalau belum ada permohonan
        if ($permohonans->isEmpty()) {
            return view('backend_pedagang.pages.belumpermohonan');
        }

        // kalau sudah ada → tampilkan halaman upload
        return view('backend_pedagang.pages.uploadpermohonan', compact('permohonans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'permohonan_id' => 'required|exists:permohonan,id',
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        // Cek dulu data lama
        $permohonan = DB::table('permohonan')->where('id', $request->permohonan_id)->first();

        if ($permohonan && $permohonan->dokumen_path) {
            // Hapus file lama dari storage/public
            Storage::disk('public')->delete($permohonan->dokumen_path);
        }


        // Simpan file ke storage
        $path = $request->file('file')->store('uploads/dokumen', 'public');

        // Update database
        DB::table('permohonan')
            ->where('id', $request->permohonan_id)
            ->update([
                'dokumen_path' => $path,
                'status' => 'lengkap',
                'keterangan' => 'Dokumen Berhasil Terkirim, Silahkan tunggu verifikasi dari Admin!',
                'updated_at' => now(),
            ]);

        return redirect()->back()->with('success', 'Dokumen Berhasil Terkirim, Silahkan tunggu verifikasi dari Admin!');
    }
}