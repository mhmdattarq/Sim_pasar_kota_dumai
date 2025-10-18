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
        \Log::info('Store pengumuman dipanggil', $request->all());
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'isi' => 'required',
                'tanggal' => 'required|date',
                'status' => 'required|in:Draft,Terpublish',
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
            \Log::error('Validasi gagal di store pengumuman', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error di store pengumuman', ['message' => $e->getMessage()]);
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
            \Log::info('Update pengumuman dipanggil untuk ID: ' . $id, $request->all());

            $request->validate([
                'judul' => 'required|string|max:255',
                'isi' => 'required',
                'tanggal' => 'required|date',
                'status' => 'required|in:Draft,Terpublish',
            ]);

            $affectedRows = DB::table('pengumuman')
                ->where('id', $id)
                ->update([
                    'judul' => $request->judul,
                    'isi' => $request->isi,
                    'tanggal' => $request->tanggal,
                    'status' => $request->status,
                    'updated_at' => now(),
                ]);

            \Log::info('Update selesai untuk ID: ' . $id, ['affected_rows' => $affectedRows]);

            if ($affectedRows > 0) {
                return response()->json(['success' => true, 'message' => 'Pengumuman berhasil diperbarui!']);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada perubahan atau data tidak ditemukan.'
                ], 404);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validasi gagal di update untuk ID: ' . $id, ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error di update untuk ID: ' . $id, ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            \Log::info('Hapus pengumuman dipanggil untuk ID: ' . $id);

            $deleted = DB::table('pengumuman')->where('id', $id)->delete();

            if ($deleted) {
                \Log::info('Hapus selesai untuk ID: ' . $id);
                return response()->json(['success' => true, 'message' => 'Pengumuman berhasil dihapus!']);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan atau gagal dihapus.'
                ], 404);
            }
        } catch (\Exception $e) {
            \Log::error('Error di hapus untuk ID: ' . $id, ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus: ' . $e->getMessage()
            ], 500);
        }
    }
}
