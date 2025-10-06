<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // ---------------- LOGIN ----------------
    public function showLoginForm()
    {
        return view('frontend.pages.home'); // form login
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required', // bisa username atau nik
            'password' => 'required',
        ]);

        // cek apakah input angka (NIK) atau huruf (username)
        if (is_numeric($request->login)) {
            $user = DB::table('users')->where('nik', $request->login)->first();
        } else {
            $user = DB::table('users')->where('username', $request->login)->first();
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('login_error', 'Username atau password salah.');
        }

        // login pakai Auth
        Auth::loginUsingId($user->id);
        
        // Set flash session untuk menampilkan modal welcome setelah login
        $request->session()->put('show_welcome_modal', true);

        // redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->route('backend_admin.pages.dashboard');
        } elseif ($user->role === 'pedagang') {
            return redirect()->route('backend_pedagang.pages.dashboard');
        } else {
            return redirect()->route('home'); // fallback
        }
    }

    // ---------------- LOGOUT ----------------
    public function logout(Request $request)
    {
        $request->session()->forget('user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // ---------------- REGISTER ADMIN ----------------
    public function showRegisterFormAdmin()
    {
        return view('backend_admin.auth.register');
    }

    public function registerAdmin(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
        ]);

        DB::table('users')->insert([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/login')->with('success', 'Registrasi admin berhasil, silakan login.');
    }
}