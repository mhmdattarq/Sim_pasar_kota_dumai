<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = DB::table('pengumuman')->get();
        return view('backend_admin.pages.pengumuman.informasi', compact('pengumumans'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'isi' => 'required',
                'tanggal' => 'required|date', // Ganti dari 'berlaku' ke 'tanggal' biar sinkron
                'status' => 'required|in:Terpublish,Draft,Arsip',
            ]);

            DB::table('pengumuman')->insert([
                'judul' => $request->judul,
                'isi' => $request->isi,
                'tanggal' => $request->tanggal,
                'status' => $request->status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['success' => true, 'message' => 'Pengumuman berhasil ditambahkan!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $pengumuman = DB::table('pengumuman')->where('id', $id)->first();
        if (!$pengumuman) {
            return response()->json(['error' => 'Pengumuman tidak ditemukan!'], 404);
        }
        return view('backend_admin.pages.pengumuman.show', compact('pengumuman'));
    }

    public function edit($id)
    {
        $pengumuman = DB::table('pengumuman')->where('id', $id)->first();
        if (!$pengumuman) {
            return response()->json(['error' => 'Pengumuman tidak ditemukan!'], 404);
        }
        return response()->json(['pengumuman' => $pengumuman]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'isi' => 'required',
                'tanggal' => 'required|date', // Konsisten dengan blade
                'status' => 'required|in:Draft,Terpublish,Arsip', // Tambahin Arsip biar sinkron
            ]);

            DB::table('pengumuman')
                ->where('id', $id)
                ->update([
                    'judul' => $request->judul,
                    'isi' => $request->isi,
                    'tanggal' => $request->tanggal,
                    'status' => $request->status,
                    'updated_at' => now(),
                ]);

            return response()->json(['success' => true, 'message' => 'Pengumuman berhasil diperbarui!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        //
    }
}
