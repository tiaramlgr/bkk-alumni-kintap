<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use App\Models\Lamaran;
use Illuminate\Http\Request;

class LamaranController extends Controller
{
    public function index()
    {
        $lamarans = Lamaran::with(['alumni.user', 'lowongan'])
                    ->whereHas('lowongan', function ($query) {
                        $query->where('admin_id', auth()->id());
                    })
                    ->latest()
                    ->get();

        return view('perusahaan.lamaran.index', compact('lamarans'));
    }

    public function show($id)
    {
        $lamaran = Lamaran::with(['alumni.user', 'alumni.dokumens', 'lowongan'])
                    ->findOrFail($id);

        return view('perusahaan.lamaran.show', compact('lamaran'));
    }

    public function updateStatus(Request $request, $id)
    {
        $lamaran = Lamaran::findOrFail($id);
        $lamaran->update([
            'status_lamaran' => $request->status,
            'catatan_admin' => $request->catatan ?? null,
        ]);

        return redirect()->route('perusahaan.lamaran.index')
            ->with('success', 'Status lamaran berhasil diperbarui.');
    }
}