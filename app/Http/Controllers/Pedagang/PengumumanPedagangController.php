<?php

namespace App\Http\Controllers\Pedagang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengumumanPedagangController extends Controller
{
    public function index()
    {
        $pengumumans = DB::table('pengumuman')
            ->where('status', 'Terpublish')
            ->orderBy('tanggal', 'desc') // Urutkan dari terbaru
            ->get();
        return view('backend_pedagang.pages.pengumuman', compact('pengumumans'));
    }
}
