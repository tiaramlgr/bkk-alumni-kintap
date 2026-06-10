@extends('layouts.alumni')

@section('title', 'Dashboard Alumni')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-4xl font-bold">Selamat Datang, {{ auth()->user()->name }}</h1>
        <p class="text-gray-600 mt-2">SMK Negeri Kintap - Bursa Kerja Khusus & Jejaring Alumni</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-3xl shadow">
            <p class="text-sm text-gray-500">Lowongan Aktif</p>
            <p class="text-5xl font-bold text-green-600 mt-3">{{ \App\Models\LowonganKerja::where('status', 'aktif')->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-3xl shadow">
            <p class="text-sm text-gray-500">Lamaran Saya</p>
            <p class="text-5xl font-bold text-blue-600 mt-3">0</p>
        </div>
        <div class="bg-white p-6 rounded-3xl shadow">
            <p class="text-sm text-gray-500">Dokumen</p>
            <p class="text-5xl font-bold text-purple-600 mt-3">0</p>
        </div>
        <div class="bg-white p-6 rounded-3xl shadow">
            <p class="text-sm text-gray-500">Status Akun</p>
            <p class="text-2xl font-semibold mt-3 text-green-600">✅ Terverifikasi</p>
        </div>
    </div>

    <div class="bg-white p-8 rounded-3xl shadow">
        <h2 class="text-xl font-semibold mb-6">Lowongan Terbaru</h2>
        <a href="{{ route('alumni.lowongan.index') }}" 
           class="inline-flex items-center gap-3 bg-blue-600 text-white px-8 py-4 rounded-3xl hover:bg-blue-700 transition">
            <i class="fas fa-search"></i> Lihat Semua Lowongan Kerja
        </a>
    </div>
</div>
@endsection 