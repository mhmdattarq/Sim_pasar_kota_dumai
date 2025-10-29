<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $user = Auth::user();
        try {
            // Ambil semua pasar dari tabel pasar
            $pasars = DB::table('pasar')
                ->select('id', 'nama_pasar', 'total_kios', 'total_los', 'total_pelataran')
                ->get();

            // Hitung total pasar
            $totalPasar = $pasars->count();

            // Siapkan array untuk total unit per pasar
            $totalUnits = [];
            foreach ($pasars as $pasar) {
                $totalUnits[$pasar->nama_pasar] = [
                    'total' => ($pasar->total_kios + $pasar->total_los + $pasar->total_pelataran),
                    'nama_pasar' => $pasar->nama_pasar
                ];
            }

            // Debug: Log data yang diambil
            \Log::info('Dashboard Admin Data', [
                'total_pasar' => $totalPasar,
                'total_units' => $totalUnits
            ]);

            return view('backend_admin.pages.dashboard', compact('user', 'totalPasar', 'totalUnits'));
        } catch (\Exception $e) {
            \Log::error('Error fetching dashboard data: ' . $e->getMessage());
            $totalPasar = 0;
            $totalUnits = [];
            return view('backend_admin.pages.dashboard', compact('user', 'totalPasar', 'totalUnits'));
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
