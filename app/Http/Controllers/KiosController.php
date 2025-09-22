<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KiosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function table()
    {
        $kios = DB::table('kios')
            ->join('pasar', 'kios.pasar_id', '=', 'pasar.id')
            ->select('kios.*', 'pasar.nama_pasar')
            ->get();

        return view('backend_admin.pages.kios.table', compact('kios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pasars = DB::table('pasar')->get();
        return view('backend_admin.pages.kios.tambah', compact('pasars'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_kios' => 'required|string|max:255',
            'ukuran_kios' => 'required|string|max:255',
            'harga_sewa' => 'required|numeric',
            'satuan_retribusi' => 'required|in:hari,bulan,tahun',
            'status_kios' => 'required|in:tersedia,disewa,kosong',
            'lokasi_kios' => 'required|string|max:255',
            'pasar_id' => 'required|exists:pasar,id'
        ]);

        DB::table('kios')->insert([
            'nomor_kios'   => $request->nomor_kios,
            'ukuran_kios' => $request->ukuran_kios,
            'harga_sewa'  => $request->harga_sewa,
            'satuan_retribusi'  => $request->satuan_retribusi,
            'status_kios' => $request->status_kios,
            'lokasi_kios' => $request->lokasi_kios,
            'pasar_id'    => $request->pasar_id,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->route('backend_admin.pages.kios.table')->with('success', 'Data kios berhasil ditambahkan.');
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
