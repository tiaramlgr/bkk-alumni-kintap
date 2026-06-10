<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function edit()
    {
        $alumni = auth()->user()->alumni;
        return view('alumni.profil.edit', compact('alumni'));
    }

    public function update(Request $request)
    {
        $alumni = auth()->user()->alumni;

        $request->validate([
            'no_hp_wa' => 'required|string',
            'alamat' => 'required|string',
            'tahun_lulus' => 'required|integer',
        ]);

        $alumni->update($request->only(['no_hp_wa', 'alamat', 'tahun_lulus', 'is_subscribe_wa']));

        return redirect()->route('alumni.profil.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}