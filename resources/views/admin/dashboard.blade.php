@extends('layouts.app')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold">Admin BKK Dashboard</h1>
            <p class="text-gray-600 mt-1">Selamat datang, <strong>{{ auth()->user()->name }}</strong></p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Alumni -->
        <div class="bg-white p-6 rounded-3xl shadow">
            <div class="text-sm text-gray-500">Total Alumni</div>
            <div class="text-5xl font-bold text-blue-600 mt-2">
                {{ \App\Models\Alumni::count() }}
            </div>
        </div>

        <!-- Lowongan Aktif -->
        <div class="bg-white p-6 rounded-3xl shadow">
            <div class="text-sm text-gray-500">Lowongan Aktif</div>
            <div class="text-5xl font-bold text-green-600 mt-2">
                {{ \App\Models\LowonganKerja::where('status', 'aktif')->count() }}
            </div>
        </div>

        <!-- Pending Approval -->
        <div class="bg-white p-6 rounded-3xl shadow">
            <div class="text-sm text-gray-500">Pending Approval</div>
            <div class="text-5xl font-bold text-orange-600 mt-2">
                {{ \App\Models\Alumni::where('status_akun', 'pending')->count() }}
            </div>
        </div>
    </div>

    <div class="mt-10 flex gap-4">
        <a href="{{ route('admin.alumni.index') }}" 
           class="flex-1 bg-white border border-gray-300 hover:bg-gray-50 px-6 py-6 rounded-3xl text-center font-medium">
            👥 Kelola Registrasi Alumni
        </a>
        <a href="{{ route('admin.lowongan.index') }}" 
           class="flex-1 bg-white border border-gray-300 hover:bg-gray-50 px-6 py-6 rounded-3xl text-center font-medium">
            📋 Lihat Semua Lowongan
        </a>
    </div>
</div>
@endsection