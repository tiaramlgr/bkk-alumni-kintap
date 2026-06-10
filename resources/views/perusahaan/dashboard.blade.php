@extends('layouts.perusahaan')

@section('title', 'Dashboard Perusahaan')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold">Selamat Datang, {{ auth()->user()->name }}</h1>
            <p class="text-gray-600">Portal Rekrutmen BKK SMK Negeri Kintap</p>
        </div>
        <a href="#" class="bg-emerald-600 text-white px-6 py-3 rounded-2xl hover:bg-emerald-700">
            + Buat Lowongan Baru
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-8 rounded-3xl shadow text-center">
            <p class="text-sm text-gray-500">Lowongan Aktif</p>
            <p class="text-6xl font-bold text-emerald-600 mt-3">0</p>
        </div>
        <div class="bg-white p-8 rounded-3xl shadow text-center">
            <p class="text-sm text-gray-500">Total Pelamar</p>
            <p class="text-6xl font-bold text-blue-600 mt-3">0</p>
        </div>
        <div class="bg-white p-8 rounded-3xl shadow text-center">
            <p class="text-sm text-gray-500">Lamaran Baru</p>
            <p class="text-6xl font-bold text-orange-600 mt-3">0</p>
        </div>
    </div>
</div>
@endsection