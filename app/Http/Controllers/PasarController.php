<?php

namespace App\Http\Controllers;

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
                'foto_depan' => $pasar->foto_depan ? asset('https://simpasar.zoema.web.id/storage/app/public/' . $pasar->foto_depan) : '',
                'foto_belakang' => $pasar->foto_belakang ? asset('https://simpasar.zoema.web.id/storage/app/public/' . $pasar->foto_belakang) : '',
                'foto_dalam' => $pasar->foto_dalam ? asset('https://simpasar.zoema.web.id/storage/app/public/' . $pasar->foto_dalam) : '',
                'lokasi_peta' => $pasar->lokasi_peta ?? '',
            ];
            Log::debug('Pasar data sent:', $response);
            return response()->json($response, 200);
        } catch (\Exception $e) {
            Log::error('Error fetching pasar:', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['error' => 'Terjadi kesalahan server: ' . $e->getMessage()], 500);
        }
    }
    public function apiIndex(Request $request)
    {
        try {
            Log::debug('API accessed - fetching pasar data for external web');

            // Parameter dari query string
            $limit = $request->get('limit', 50);
            $page = $request->get('page', 1);
            $search = $request->get('search', '');

            // Query builder - HANYA ambil field yang diperlukan
            $query = DB::table('pasar')
                ->select([
                    'id',
                    'nama_pasar',
                    'alamat',
                    'total_kios',
                    'total_los',
                    'total_pelataran'
                ]);

            // Filter search jika ada
            if (!empty($search)) {
                $query->where('nama_pasar', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%');
            }

            // Pagination
            $pasar = $query->paginate($limit, ['*'], 'page', $page);

            // Format response seperti API staff (lebih structured)
            $response = [
                "status" => "success",
                "timestamp" => now()->toISOString(),
                "data" => [
                    "pasar" => $pasar->items(),
                    "metadata" => [
                        "current_page" => $pasar->currentPage(),
                        "total_pages" => $pasar->lastPage(),
                        "total_records" => $pasar->total(),
                        "per_page" => $pasar->perPage(),
                        "has_more" => $pasar->hasMorePages()
                    ]
                ]
            ];

            Log::debug('API response prepared', ['total_data' => count($response['data']['pasar'])]);
            return response()->json($response)->header('Access-Control-Allow-Origin', '*');
        } catch (\Exception $e) {
            Log::error('API Error:', ['error' => $e->getMessage()]);

            return response()->json([
                "status" => "error",
                "timestamp" => now()->toISOString(),
                "message" => "Terjadi kesalahan server",
                "error" => env('APP_DEBUG') ? $e->getMessage() : 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * API untuk get detail pasar by ID (untuk web lain)
     * URL: /home/api/{id} atau /api/v1/pasar/{id}
     */
    public function apiShow($id)
    {
        try {
            Log::debug('API Detail accessed - ID:', ['id' => $id]);

            if (!is_numeric($id) || $id <= 0) {
                return response()->json([
                    "status" => "error",
                    "timestamp" => now()->toISOString(),
                    "message" => "ID tidak valid"
                ], 400);
            }

            $pasar = DB::table('pasar')
                ->select([
                    'id',
                    'nama_pasar',
                    'alamat',
                    'total_kios',
                    'total_los',
                    'total_pelataran'
                ])
                ->where('id', $id)
                ->first();

            if (!$pasar) {
                return response()->json([
                    "status" => "error",
                    "timestamp" => now()->toISOString(),
                    "message" => "Data pasar tidak ditemukan"
                ], 404);
            }

            $response = [
                "status" => "success",
                "timestamp" => now()->toISOString(),
                "data" => [
                    "pasar" => $pasar
                ]
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('API Detail Error:', ['id' => $id, 'error' => $e->getMessage()]);

            return response()->json([
                "status" => "error",
                "timestamp" => now()->toISOString(),
                "message" => "Terjadi kesalahan server",
                "error" => env('APP_DEBUG') ? $e->getMessage() : 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * API untuk search data pasar (untuk web lain)
     * URL: /home/api/search/{keyword} atau /api/v1/pasar/search/{keyword}
     */
    public function apiSearch($keyword)
    {
        try {
            Log::debug('API Search accessed - keyword:', ['keyword' => $keyword]);

            $pasar = DB::table('pasar')
                ->select([
                    'id',
                    'nama_pasar',
                    'alamat',
                    'total_kios',
                    'total_los',
                    'total_pelataran'
                ])
                ->where('nama_pasar', 'like', '%' . $keyword . '%')
                ->orWhere('alamat', 'like', '%' . $keyword . '%')
                ->get();

            $response = [
                "status" => "success",
                "timestamp" => now()->toISOString(),
                "data" => [
                    "pasar" => $pasar,
                    "metadata" => [
                        "total_results" => $pasar->count(),
                        "search_keyword" => $keyword
                    ]
                ]
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('API Search Error:', ['keyword' => $keyword, 'error' => $e->getMessage()]);

            return response()->json([
                "status" => "error",
                "timestamp" => now()->toISOString(),
                "message" => "Terjadi kesalahan server",
                "error" => env('APP_DEBUG') ? $e->getMessage() : 'Internal Server Error'
            ], 500);
        }
    }
}
