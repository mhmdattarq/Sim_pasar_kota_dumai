<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import DB facade untuk Query Builder

class HomeController extends Controller
{
    public function index()
    {
        try {
            $pasars = DB::table('pasar')
                ->select([
                    'nama_pasar',
                    'total_kios',
                    'total_los',
                    'total_pelataran',
                    DB::raw('(total_kios + total_los + total_pelataran) AS total_unit')
                ])
                ->orderBy('nama_pasar', 'asc')
                ->get();

            // Debug: Log data yang diambil
            \Log::info('Pasar data fetched: ', $pasars->toArray());

            // Pastikan view sesuai dengan file Blade
            return view('frontend.pages.home', compact('pasars')); // Sesuaikan dengan lokasi file
        } catch (\Exception $e) {
            \Log::error('Error fetch pasar: ' . $e->getMessage());
            $pasars = collect();
            \Log::info('Fallback pasar data: ', $pasars->toArray());
            return view('frontend.pages.home', compact('pasars')); // Sesuaikan dengan lokasi file
        }
    }
}
