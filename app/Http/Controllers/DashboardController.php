<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Dashboard untuk admin
    public function adminDashboard()
    {
        $user = Auth::user();

        try {
            // Total Pasar (jumlah baris di tabel pasar)
            $totalPasar = DB::table('pasar')->count();

            // Ambil data agregat untuk masing-masing pasar
            $pasarKelakap = DB::table('pasar')
                ->where('nama_pasar', 'PASAR KELAKAP TUJUH') // Sesuaikan nama tepat di database
                ->first();

            $pasarBundaran = DB::table('pasar')
                ->where('nama_pasar', 'PASAR BUNDARAN SRI MERSING') // Sesuaikan nama tepat di database
                ->first();

            $pasarTamanLepin = DB::table('pasar')
                ->where('nama_pasar', 'PASAR LEPIN') // Sesuaikan nama tepat di database
                ->first();

            // Hitung total unit (kios + los + pelataran) untuk masing-masing pasar
            $totalUnitKelakap = $pasarKelakap ? ($pasarKelakap->total_kios + $pasarKelakap->total_los + $pasarKelakap->total_pelataran) : 0;
            $totalUnitBundaran = $pasarBundaran ? ($pasarBundaran->total_kios + $pasarBundaran->total_los + $pasarBundaran->total_pelataran) : 0;
            $totalUnitTamanLepin = $pasarTamanLepin ? ($pasarTamanLepin->total_kios + $pasarTamanLepin->total_los + $pasarTamanLepin->total_pelataran) : 0;

            // Debug: Log data yang diambil
            \Log::info('Dashboard Admin Data - Total Pasar: ' . $totalPasar);
            \Log::info('Dashboard Admin Data - Total Unit Kelakap: ' . $totalUnitKelakap);
            \Log::info('Dashboard Admin Data - Total Unit Bundaran: ' . $totalUnitBundaran);
            \Log::info('Dashboard Admin Data - Total Unit Taman Lepin: ' . $totalUnitTamanLepin);

            return view('backend_admin.pages.dashboard', compact('user', 'totalPasar', 'totalUnitKelakap', 'totalUnitBundaran', 'totalUnitTamanLepin'));
        } catch (\Exception $e) {
            \Log::error('Error fetch pasar admin dashboard: ' . $e->getMessage());
            $totalPasar = 0;
            $totalUnitKelakap = 0;
            $totalUnitBundaran = 0;
            $totalUnitTamanLepin = 0;
            return view('backend_admin.pages.dashboard', compact('user', 'totalPasar', 'totalUnitKelakap', 'totalUnitBundaran', 'totalUnitTamanLepin'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}