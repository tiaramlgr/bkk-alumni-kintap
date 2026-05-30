<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Alumni;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index()
    {
        $pending = Alumni::with('user', 'jurusan')
                    ->where('status_akun', 'pending')
                    ->get();

        $approved = Alumni::with('user', 'jurusan')
                    ->where('status_akun', 'approved')
                    ->get();

        return view('admin.alumni.index', compact('pending', 'approved'));
    }

    public function approve($id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->status_akun = 'approved';
        $alumni->save();

        $alumni->user->is_active = true;
        $alumni->user->save();

        return back()->with('success', 'Alumni berhasil di-approve.');
    }

    public function reject($id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->status_akun = 'rejected';
        $alumni->save();

        return back()->with('success', 'Registrasi ditolak.');
    }
}