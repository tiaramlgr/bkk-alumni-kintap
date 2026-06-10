<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PerusahaanRegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('perusahaan.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'nama_perusahaan' => 'required|string',
            'no_hp_wa' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'perusahaan',
        ]);

        Company::create([
            'user_id' => $user->id,
            'nama_perusahaan' => $request->nama_perusahaan,
            'no_hp_wa' => $request->no_hp_wa,
            'alamat' => $request->alamat ?? null,
        ]);

        auth()->login($user);

        return redirect()->route('perusahaan.dashboard');
    }
}