<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Lamaran;
use Illuminate\Http\Request;

class LamaranController extends Controller
{
    public function index()
    {
        $lamarans = Lamaran::with('lowongan')
                    ->where('alumni_id', auth()->user()->alumni->id)
                    ->latest()
                    ->get();

        return view('alumni.lamaran.index', compact('lamarans'));
    }
}