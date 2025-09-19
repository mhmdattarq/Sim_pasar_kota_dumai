<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccPermohonanController extends Controller
{
    public function showTable()
    {
        $permohonans = DB::table('permohonan')
            ->join('pasar', 'permohonan.pasar_id', '=', 'pasar.id')
            ->select(
                'permohonan.*',
                'pasar.nama_pasar' // ambil nama pasar dari tabel pasar
            )
            ->get();

        return view('backend_admin.pages.pedagang.tabelpermohonan', compact('permohonans'));
    }
}