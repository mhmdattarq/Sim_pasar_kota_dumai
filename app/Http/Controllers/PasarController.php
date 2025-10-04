<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function table()
    {
        $pasar = DB::table('pasar')->get();
        return view('backend_admin.pages.pasar.table', compact('pasar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend_admin.pages.pasar.tambah');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pasar'   => 'required|string|max:255',
            'alamat'       => 'required|string',
            'total_kios'     => 'required|integer|min:0',
            'total_los'     => 'required|integer|min:0',
            'total_pelataran'     => 'required|integer|min:0',
            'foto_depan'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_belakang' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_dalam'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'lokasi_peta'  => 'nullable|string',
        ]);

        // handle file upload
        $fotoDepan     = $request->file('foto_depan') ? $request->file('foto_depan')->store('pasar', 'public') : null;
        $fotoBelakang  = $request->file('foto_belakang') ? $request->file('foto_belakang')->store('pasar', 'public') : null;
        $fotoDalam     = $request->file('foto_dalam') ? $request->file('foto_dalam')->store('pasar', 'public') : null;

        // insert ke database dengan query builder
        DB::table('pasar')->insert([
            'nama_pasar'    => $request->nama_pasar,
            'alamat'        => $request->alamat,
            'total_kios'        => $request->total_kios,
            'total_los'        => $request->total_los,
            'total_pelataran'        => $request->total_pelataran,
            'foto_depan'    => $fotoDepan,
            'foto_belakang' => $fotoBelakang,
            'foto_dalam'    => $fotoDalam,
            'lokasi_peta'   => $request->lokasi_peta,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return redirect()->route('backend_admin.pages.pasar.table')->with('success', 'Pasar berhasil ditambahkan!');
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
