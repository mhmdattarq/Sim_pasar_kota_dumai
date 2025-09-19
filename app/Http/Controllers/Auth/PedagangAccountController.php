<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class PedagangAccountController extends Controller
{
    /**
     * Tampilkan form pembuatan akun pedagang
     */
    public function showCreateAccountForm($nik)
    {
        // Cari user berdasarkan NIK
        $user = User::where('nik', $nik)->firstOrFail();

        // Lempar ke view dengan data user
        return view('backend_pedagang.auth.akun', compact('user'));
    }

    /**
     * Proses simpan akun pedagang
     */
    public function createAccount(Request $request, $nik)
    {
        // Validasi password
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Cari user berdasarkan NIK
        $user = User::where('nik', $nik)->firstOrFail();

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // check sesi download untuk surat permohonanan
        session()->flash('download_surat', $request->nik);

        // Redirect ke halaman depan / dashboard
        return redirect()->route('frontend.pages.home')
            ->with('success', 'Akun berhasil dibuat!');
    }
}