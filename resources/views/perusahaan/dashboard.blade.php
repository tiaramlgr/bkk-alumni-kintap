@extends('layouts.perusahaan')

@section('title', 'Dashboard Perusahaan')

@section('content')
{{--<div class="space-y-8">
    <div class="bg-gradient-to-br from-green-500 to-emerald-700 rounded-3xl p-8 text-white shadow-xl shadow-green-500/20 relative overflow-hidden mb-8">
        
        <div class="absolute -right-6 -bottom-6 opacity-10">
            <i class="fab fa-whatsapp" style="font-size: 14rem;"></i>
        </div>

        <div class="relative z-10 md:w-2/3">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-4 border border-white/30">
                <span class="w-2 h-2 rounded-full bg-green-300 animate-pulse"></span> Saluran Resmi BKK
            </div>
            
            <h2 class="text-3xl font-bold mb-3">Pusat Informasi & Lowongan Kerja Terkini</h2>
            
            <p class="text-green-50 text-base leading-relaxed mb-6">
                Jangan sampai terlewat info penting! Bergabunglah sekarang ke Saluran WhatsApp BKK SMKN Kintap untuk mendapatkan  notifikasi lowongan pekerjaan terbaru, info rekrutmen, dan pemanggilan interview langsung di HP Anda.
            </p>
            
            <div class="flex flex-wrap items-center gap-4">
                <a href="https://chat.whatsapp.com/GbwBrGkgmxTLGtjyLqzwfr"
                target="_blank" 
                class="bg-white text-emerald-800 hover:bg-green-50 px-8 py-3.5 rounded-2xl font-bold transition-all shadow-lg flex items-center gap-3 transform hover:-translate-y-1">
                    <i class="fab fa-whatsapp text-xl"></i> Gabung ke Grup WhatsApp
                </a>
                
                <span class="text-sm text-green-100/80 flex items-center gap-2">
                    <i class="fas fa-shield-alt"></i> Aman & Privasi Terjaga
                </span>
            </div>
        </div>
    </div> --}}

    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold">Selamat Datang, {{ auth()->user()->name }}</h1>
            <p class="text-gray-600">Portal Rekrutmen BKK SMK Negeri Kintap</p>
        </div>
        <!-- Link tombol sudah diperbaiki agar berfungsi -->
        <a href="{{ route('perusahaan.lowongan.create') }}" class="bg-emerald-600 text-white px-6 py-3 rounded-2xl hover:bg-emerald-700 transition shadow-sm">
            + Buat Lowongan Baru
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-8 rounded-3xl shadow text-center">
            <p class="text-sm text-gray-500 font-medium">Lowongan Aktif</p>
            <!-- Variabel Dinamis Lowongan -->
            <p class="text-6xl font-bold text-emerald-600 mt-3">{{ $lowonganAktif }}</p>
        </div>
        <div class="bg-white p-8 rounded-3xl shadow text-center">
            <p class="text-sm text-gray-500 font-medium">Total Pelamar</p>
            <!-- Variabel Dinamis Total Pelamar -->
            <p class="text-6xl font-bold text-blue-600 mt-3">{{ $totalPelamar }}</p>
        </div>
        <div class="bg-white p-8 rounded-3xl shadow text-center">
            <p class="text-sm text-gray-500 font-medium">Lamaran Baru (Menunggu)</p>
            <!-- Variabel Dinamis Lamaran Pending -->
            <p class="text-6xl font-bold text-orange-600 mt-3">{{ $lamaranBaru }}</p>
        </div>
    </div>
</div>
@endsection