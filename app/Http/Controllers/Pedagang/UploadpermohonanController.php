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
            ->select('id', 'nama', 'status', 'keterangan', 'dokumen_path', 'created_at')
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
    
        $permohonan = DB::table('permohonan')->where('id', $request->permohonan_id)->first();
        if ($permohonan && $permohonan->dokumen_path) {
            if (Storage::disk('public')->exists($permohonan->dokumen_path)) {
                Storage::disk('public')->delete($permohonan->dokumen_path);
            }
        }
    
        // Simpen file
        $path = $request->file('file')->store('uploads/dokumen', 'public');
        
        // Set permission file
        $fullPath = storage_path('app/public/' . $path);
        chmod($fullPath, 0644); // File readable oleh semua
    
        // Update DB
        DB::table('permohonan')
            ->where('id', $request->permohonan_id)
            ->update([
                'dokumen_path' => $path,
                'status' => 'lengkap',
                'keterangan' => 'Dokumen Berhasil Terkirim, Silahkan tunggu persetujuan dari Admin!',
                'updated_at' => now(),
            ]);
    
        return redirect()->back()->with('success', 'Dokumen Berhasil Terkirim, Silahkan tunggu persetujuan dari Admin!');
    }
    
    public function getDocumentUrl($id)
{
    try {
        $permohonan = DB::table('permohonan')->where('id', $id)->first();
        if (!$permohonan) {
            return response()->json(['error' => 'Permohonan tidak ditemukan'], 404);
        }

        $filePath = $permohonan->dokumen_path;
        if (!$filePath) {
            return response()->json(['error' => 'Dokumen path tidak tersedia'], 404);
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

        $fileUrl = url('/user-proxy-storage/' . $filePath);  // Ganti ke route baru
        $fileName = basename($filePath);

        return response()->json([
            'fileUrl' => $fileUrl,
            'fileName' => $fileName
        ]);
    } catch (\Exception $e) {
        \Log::error('Get document URL error for ID ' . $id . ': ' . $e->getMessage());
        return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
    }
}
}