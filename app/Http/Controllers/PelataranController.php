<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelataran;
use App\Models\Pasar;
use Illuminate\Support\Facades\DB;

class PelataranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function table()
    {
        $pelatarans = DB::table('pelatarans')
            ->join('pasar', 'pelatarans.pasar_id', '=', 'pasar.id')
            ->select('pelatarans.*', 'pasar.nama_pasar')
            ->get();

        return view('backend_admin.pages.pelataran.table', compact('pelatarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pasars = DB::table('pasar')->get();
        return view('backend_admin.pages.pelataran.tambah', compact('pasars'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_pelataran' => 'required|string|max:255',
            'ukuran_pelataran' => 'required|string|max:255',
            'harga_sewa' => 'required|numeric',
            'satuan_retribusi' => 'required|in:hari,bulan,tahun',
            'kategori_pelataran' => 'required|in:tetap,tidaktetap,insidentil',
            'lokasi_pelataran' => 'required|string|max:255',
            'pasar_id' => 'required|exists:pasar,id'
        ]);

        DB::table('pelatarans')->insert([
            'nomor_pelataran'   => $request->nomor_pelataran,
            'ukuran_pelataran' => $request->ukuran_pelataran,
            'harga_sewa'  => $request->harga_sewa,
            'satuan_retribusi'  => $request->satuan_retribusi,
            'kategori_pelataran' => $request->kategori_pelataran,
            'lokasi_pelataran' => $request->lokasi_pelataran,
            'pasar_id'    => $request->pasar_id,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->route('backend_admin.pages.pelataran.table')->with('success', 'Data pelataran berhasil ditambahkan.');
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
