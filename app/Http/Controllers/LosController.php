<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function table()
    {
        $los = DB::table('loss')
            ->join('pasar', 'loss.pasar_id', '=', 'pasar.id')
            ->select('loss.*', 'pasar.nama_pasar')
            ->get();

        return view('backend_admin.pages.los.table', compact('los'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pasars = DB::table('pasar')->get();
        return view('backend_admin.pages.los.tambah', compact('pasars'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_los' => 'required|string|max:255',
            'ukuran_los' => 'required|string|max:255',
            'harga_sewa' => 'required|numeric',
            'satuan_retribusi' => 'required|in:hari,bulan,tahun',
            'status_los' => 'required|in:tersedia,terisi',
            'lokasi_los' => 'required|string|max:255',
            'pasar_id' => 'required|exists:pasar,id'
        ]);

        DB::table('loss')->insert([
            'nomor_los'   => $request->nomor_los,
            'ukuran_los' => $request->ukuran_los,
            'harga_sewa'  => $request->harga_sewa,
            'satuan_retribusi'  => $request->satuan_retribusi,
            'status_los' => $request->status_los,
            'lokasi_los' => $request->lokasi_los,
            'pasar_id'    => $request->pasar_id,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->route('backend_admin.pages.los.table')->with('success', 'Data los berhasil ditambahkan.');
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
