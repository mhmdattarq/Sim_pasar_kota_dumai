<?php

namespace App\Http\Controllers\Pedagang;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

        // Cek permohonan terakhir dari user login (terbaru berdasarkan created_at)
        $permohonan = DB::table('permohonan')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')  // Atau orderBy('id', 'desc') jika id lebih akurat untuk "terbaru"
            ->first();

        // Hitung statistik semua permohonan
        $totalPermohonan = DB::table('permohonan')->where('user_id', $user->id)->count();
        $permohonanDitolak = DB::table('permohonan')->where('user_id', $user->id)->where('status', 'ditolak')->count();
        $permohonanDisetujui = DB::table('permohonan')->where('user_id', $user->id)->where('status', 'disetujui')->count();
        $permohonanSelesai = DB::table('permohonan')->where('user_id', $user->id)->where('status', 'selesai')->count();
        $permohonanPending = DB::table('permohonan')
            ->where('user_id', $user->id)
            ->whereIn('status', ['draft', 'lengkap', 'verifikasi'])
            ->count();

        // Ambil dan hapus flag modal dari session
        $showModal = session()->pull('show_welcome_modal', false);

        return view('backend_pedagang.pages.dashboard', compact('user', 'permohonan', 'displayName', 'showModal', 'totalPermohonan', 'permohonanDitolak', 'permohonanDisetujui', 'permohonanPending', 'permohonanSelesai'));
    }
}