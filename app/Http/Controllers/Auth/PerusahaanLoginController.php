<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerusahaanLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('perusahaan.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            if ($user->role === 'perusahaan') {
                return redirect()->route('perusahaan.dashboard');
            }

            Auth::logout();
            return redirect()->back()->with('error', 'Akun ini bukan akun Perusahaan.');
        }

        return redirect()->back()->with('error', 'Email atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout(); // Atau sesuai guard yang Anda gunakan

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // UBAH BARIS INI: Arahkan ke rute landing.index
        return redirect()->route('landing.index')->with('success', 'Sesi perusahaan telah diakhiri.');
    }
}