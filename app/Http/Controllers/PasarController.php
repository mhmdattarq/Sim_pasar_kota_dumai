<?php

namespace App\Http\Controllers; // Tetap di root namespace, bukan Admin
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PasarController extends Controller
{
    public function table()
    {
        $pasar = DB::table('pasar')->get();
        Log::debug('Pasar data fetched for table:', ['count' => $pasar->count(), 'data' => $pasar->toArray()]);
        return view('backend_admin.pages.pasar.table', compact('pasar'));
    }

    public function create()
    {
        return view('backend_admin.pages.pasar.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pasar' => 'required|string|max:255',
            'alamat' => 'required|string',
            'total_kios' => 'nullable|integer|min:0',
            'total_los' => 'nullable|integer|min:0',
            'total_pelataran' => 'nullable|integer|min:0',
            'foto_depan' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_belakang' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_dalam' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'lokasi_peta' => 'nullable|string',
        ]);

        $fotoDepan = $request->file('foto_depan') ? $request->file('foto_depan')->store('pasar', 'public') : null;
        $fotoBelakang = $request->file('foto_belakang') ? $request->file('foto_belakang')->store('pasar', 'public') : null;
        $fotoDalam = $request->file('foto_dalam') ? $request->file('foto_dalam')->store('pasar', 'public') : null;

        DB::table('pasar')->insert([
            'nama_pasar' => $request->nama_pasar,
            'alamat' => $request->alamat,
            'total_kios' => $request->input('total_kios') ?? 0,
            'total_los' => $request->input('total_los') ?? 0,
            'total_pelataran' => $request->input('total_pelataran') ?? 0,
            'foto_depan' => $fotoDepan,
            'foto_belakang' => $fotoBelakang,
            'foto_dalam' => $fotoDalam,
            'lokasi_peta' => $request->lokasi_peta,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('backend_admin.pages.pasar.table')->with('success', 'Pasar berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        try {
            Log::debug('Fetching pasar with ID:', ['id' => $id]);
            if (!is_numeric($id) || $id <= 0) {
                Log::warning('Invalid ID provided:', ['id' => $id]);
                return response()->json(['error' => 'ID tidak valid'], 400);
            }
            $pasar = DB::table('pasar')->find($id);
            if (!$pasar) {
                Log::warning('Pasar not found for ID:', ['id' => $id]);
                return response()->json(['error' => 'Data pasar tidak ditemukan'], 404);
            }
            $response = [
                'nama_pasar' => $pasar->nama_pasar ?? 'N/A',
                'alamat' => $pasar->alamat ?? 'N/A',
                'total_kios' => $pasar->total_kios ?? 0,
                'total_los' => $pasar->total_los ?? 0,
                'total_pelataran' => $pasar->total_pelataran ?? 0,
                'foto_depan' => $pasar->foto_depan ? asset('storage/' . $pasar->foto_depan) : '',
                'foto_belakang' => $pasar->foto_belakang ? asset('storage/' . $pasar->foto_belakang) : '',
                'foto_dalam' => $pasar->foto_dalam ? asset('storage/' . $pasar->foto_dalam) : '',
                'lokasi_peta' => $pasar->lokasi_peta ?? '',
            ];
            Log::debug('Pasar data sent:', $response);
            return response()->json($response, 200);
        } catch (\Exception $e) {
            Log::error('Error fetching pasar:', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['error' => 'Terjadi kesalahan server: ' . $e->getMessage()], 500);
        }
    }
}
