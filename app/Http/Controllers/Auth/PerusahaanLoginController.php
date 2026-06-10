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

    public function logout(Request $request) // Tambahkan Request jika ingin menghapus session lebih bersih
    {
        Auth::logout();
        
        // Opsional tetapi disarankan untuk keamanan session Laravel
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Mengarahkan kembali ke Landing Page (route dengan nama 'home')
        return redirect()->route('home'); 
    }
}