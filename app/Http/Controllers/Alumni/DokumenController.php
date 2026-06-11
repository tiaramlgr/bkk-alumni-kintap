<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\DokumenAlumni;
use Illuminate\Http\Request;

class DokumenController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user->alumni) {
            return redirect()->route('alumni.dashboard')
                ->with('error', 'Profil alumni tidak valid.');
        }

        // Ambil dokumen yang diunggah Admin untuk alumni ini, dan berstatus aktif
        $dokumens = DokumenAlumni::where('alumni_id', $user->alumni->id)
                    ->where('is_active', true)
                    ->latest()
                    ->get();

        return view('alumni.dokumen.index', compact('dokumens'));
    }
}