@extends('layouts.alumni')

@section('title', 'Dashboard Alumni')

@section('content')
<div class="space-y-8">
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
    </div>
    
    <div>
        <h1 class="text-4xl font-bold">Selamat Datang, {{ auth()->user()->name }}</h1>
        <p class="text-gray-600 mt-2">SMK Negeri Kintap - Bursa Kerja Khusus & Jejaring Alumni</p>
    </div>

    @php
        // Mengambil data alumni yang sedang login
        $alumni = auth()->user()->alumni;
        $alumniId = $alumni ? $alumni->id : null;

        // Kalkulasi data secara dinamis
        $lowonganAktif = \App\Models\LowonganKerja::where('status', 'aktif')->count();
        $lamaranSaya = $alumniId ? \App\Models\Lamaran::where('alumni_id', $alumniId)->count() : 0;
        
        // Pengecekan cerdas untuk jumlah dokumen (mencegah error jika nama model berbeda)
        $dokumenSaya = 0;
        if ($alumniId) {
            if (class_exists('\App\Models\DokumenAlumni')) {
                $dokumenSaya = \App\Models\DokumenAlumni::where('alumni_id', $alumniId)->count();
            } elseif (class_exists('\App\Models\Dokumen')) {
                $dokumenSaya = \App\Models\Dokumen::where('alumni_id', $alumniId)->count();
            }
        }

        // Pengecekan status verifikasi akun
        $statusAkun = $alumni ? $alumni->status_akun : 'pending';
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-3xl shadow">
            <p class="text-sm text-gray-500">Lowongan Aktif</p>
            <p class="text-5xl font-bold text-green-600 mt-3">{{ $lowonganAktif }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-3xl shadow">
            <p class="text-sm text-gray-500">Lamaran Saya</p>
            <p class="text-5xl font-bold text-blue-600 mt-3">{{ $lamaranSaya }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-3xl shadow">
            <p class="text-sm text-gray-500">Dokumen</p>
            <p class="text-5xl font-bold text-purple-600 mt-3">{{ $dokumenSaya }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-3xl shadow">
            <p class="text-sm text-gray-500">Status Akun</p>
            @if($statusAkun === 'approved')
                <p class="text-2xl font-semibold mt-3 text-green-600">✅ Terverifikasi</p>
            @elseif($statusAkun === 'rejected')
                <p class="text-2xl font-semibold mt-3 text-red-600">❌ Ditolak</p>
            @else
                <p class="text-2xl font-semibold mt-3 text-orange-500">⏳ Pending</p>
            @endif
        </div>
    </div>

    <div class="bg-white p-8 rounded-3xl shadow">
        <h2 class="text-xl font-semibold mb-6">Lowongan Terbaru</h2>
        <a href="{{ route('alumni.lowongan.index') }}" 
           class="inline-flex items-center gap-3 bg-blue-600 text-white px-8 py-4 rounded-3xl hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
            <i class="fas fa-search"></i> Lihat Semua Lowongan Kerja
        </a>
    </div>
</div>
@endsection