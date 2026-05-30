@extends('layouts.app')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold mb-4">Alumni Dashboard</h1>
    <p class="text-gray-600">Selamat datang, {{ auth()->user()->name }}</p>
    
    <div class="mt-8 bg-white rounded-3xl p-8 shadow">
        <h2 class="text-xl font-semibold mb-4">Menu Utama</h2>
        <div class="grid grid-cols-2 gap-4">
            <a href="#" class="p-6 border rounded-2xl hover:bg-gray-50">📋 Update Tracer Study</a>
            <a href="#" class="p-6 border rounded-2xl hover:bg-gray-50">💼 Lihat Lowongan Kerja</a>
            <a href="#" class="p-6 border rounded-2xl hover:bg-gray-50">📄 Download Ijazah/SKHU</a>
            <a href="#" class="p-6 border rounded-2xl hover:bg-gray-50">📬 Riwayat Lamaran</a>
        </div>
    </div>
</div>
@endsection