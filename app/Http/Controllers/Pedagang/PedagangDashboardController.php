<?php

namespace App\Http\Controllers\Pedagang;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PedagangDashboardController extends Controller
{
    // Dashboard untuk pedagang
    public function PedagangDashboard()
    {
        $user = Auth::user();

        // Ambil data pedagang dari tabel pedagangregister
        $pedagang = DB::table('pedagangregister')
            ->where('user_id', $user->id)
            ->first();

        // Kalau ada, pakai nama. Kalau nggak ada fallback ke NIK
        $displayName = $pedagang->nama ?? $user->nik;

        // Cek permohonan terakhir dari user login
        $permohonan = DB::table('permohonan')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('backend_pedagang.pages.dashboard', compact('user', 'permohonan', 'displayName'));
    }
}