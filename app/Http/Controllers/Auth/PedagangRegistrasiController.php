<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PedagangRegistrasiController extends Controller
{
    public function showForm()
    {
        return view('backend_pedagang.auth.register');
    }


    public function register(Request $request)
    {
        $request->validate([
            'nik'            => 'required|unique:users,nik',
            'nama'           => 'required|string|max:100',
            'tempat_lahir'   => 'required|string|max:50',
            'tanggal_lahir'  => 'required|date',
            'jenis_kelamin'  => 'required|in:L,P',
            'no_telp'        => 'required|string|max:15',
            'alamat'         => 'required|string|max:255',
            'password'       => 'required|min:6|confirmed',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'nama.required' => 'Nama wajib diisi.',
            'tempat_lahir.required' => 'Tempat Lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal Lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal Lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin hanya boleh Laki-Laki atau Perempuan.',
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'no_telp.max' => 'Nomor telepon maksimal 15 digit.',
            'alamat.required' => 'Alamat wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // simpan user ke table users
        $userId = DB::table('users')->insertGetId([
            'nik' => $request->nik,
            'password' => Hash::make($request->password),
            'role' => 'pedagang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // simpan ke table pedagang
        DB::table('pedagangregister')->insert([
            'user_id'       => $userId,
            'nama'          => $request->nama,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telp'       => $request->no_telp,
            'alamat'        => $request->alamat,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
        // === AUTO GENERATE FOLDER BERDASARKAN NIK ===
        $nikFolder = "uploads/{$request->nik}";
        $subFolders = ['ktp', 'kk', 'nib', 'npwp', 'foto'];

        // bikin folder utama
        Storage::disk('public')->makeDirectory($nikFolder);

        // bikin sub folder
        foreach ($subFolders as $sub) {
            Storage::disk('public')->makeDirectory("{$nikFolder}/{$sub}");
        }
        return redirect()->route('login')->with('registered', true);
    }
}